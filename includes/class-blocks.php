<?php

namespace Blokki;
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Blokki\Blocks' ) ) {
	return;
}


/**
 * This class will create meta boxes for Shortcodes
 *
 * @package    Blokki
 * @subpackage Blokki/includes
 */
class Blocks {

	private $block;

	private $current_block_id = null;

	private $current_block_fields;

	private $block_fields = [];

	private $grid_settings = [];

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * @var string $editor_script_handle the editor script handle id
	 */
	private $editor_script_handle;

	/**
	 * @var string $editor_style_handle the editor style handle id
	 */
	private $editor_style_handle;

	/**
	 * @var string $public_style_handle the public style handle id
	 */
	private $public_style_handle;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->editor_script_handle = 'blokki-block-editor-script';
		$this->editor_style_handle  = 'blokki-block-editor-style';
		$this->public_style_handle  = 'blokki-block-style';

		$this->register_hooks();


	}

	/**
	 * Register required hooks
	 */
	public function register_hooks() {

		/**
		 * Register Blocks
		 */
		add_action( 'init', [ $this, 'register_blocks' ] );

		/**
		 * Only for Editor (admin)
		 */
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ] );

		/**
		 * For Editor (admin) and Public (frontend)
		 */
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_assets' ] );


	}

	/**
	 * Enqueue assets for Editor (admin) and Public (frontend) side
	 * @hooked  enqueue_block_assets
	 */
	public function enqueue_block_assets() {

		$style_css = 'style-index.css';
		wp_enqueue_style(
			$this->public_style_handle,
			$this->get_build_url( $style_css ),
			array(),
			filemtime( $this->get_build_dir( $style_css ) )
		);

	}

	/**
	 * Get Build URL path
	 */
	public function get_build_url( $file_name_with_sub_dir ) {

		return BLOKKI_URL_PATH . trailingslashit( 'build' ) . $file_name_with_sub_dir;

	}

	/**
	 * Get Build Dir path
	 */
	public function get_build_dir( $file_name_with_sub_dir ) {

		return BLOKKI_DIR_PATH . 'build' . DIRECTORY_SEPARATOR . $file_name_with_sub_dir;

	}

	/**
	 * Enqueue CSS and JS assets for Editor
	 * @hooked  enqueue_block_editor_assets
	 */
	public function enqueue_block_editor_assets() {

		$script_asset_path = $this->get_build_dir( 'index.asset.php' );

		if ( ! file_exists( $script_asset_path ) ) {
			throw new \Error(
				'You need to first run `npm start` or `npm run build` for the blocks offered by this plugin. Could Not find the index.asset.php file'
			);
		}

		/**
		 * Register Scripts
		 */
		$script_asset = require( $script_asset_path );
		wp_enqueue_script(
			$this->editor_script_handle,
			$this->get_build_url( 'index.js' ),
			$script_asset['dependencies'],
			$script_asset['version']
		);

		/**
		 * Localize Scripts
		 * Passes translations to JavaScript.
		 */
		if ( function_exists( 'wp_set_script_translations' ) ) {
			/**
			 * May be extended to wp_set_script_translations( 'my-handle', 'my-domain',
			 * plugin_dir_path( MY_PLUGIN ) . 'languages' ) ). For details see
			 * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
			 */
			wp_set_script_translations( $this->editor_script_handle, 'blokki' );
		}

		/**
		 * Register CSS Style
		 */

		$editor_css = 'index.css';
		wp_enqueue_style(
			$this->editor_style_handle,
			$this->get_build_url( $editor_css ),
			array(),
			filemtime( $this->get_build_dir( $editor_css ) )
		);

	}

	/**
	 * Registers all block assets so that they can be enqueued through Gutenberg in
	 * the corresponding context.
	 *
	 *
	 */
	public function register_blocks() {


		// Array of block created in this plugin.
		$blocks = [
			'blokki/grid',
		];

		// Loop through $blocks and register each block with the same script and styles.
		foreach ( $blocks as $block ) {
			register_block_type( $block, array(
				'editor_script' => $this->editor_script_handle,
				// Calls registered script above
				'editor_style'  => $this->editor_style_handle,
				// Calls registered stylesheet above
				'style'         => $this->public_style_handle,
				// Calls registered stylesheet above
			) );
		}


	}


	public function get_current_block_fields() {
		return $this->current_block_fields;
	}

	public function set_current_block_fields( $block_fields ) {
		return $this->current_block_fields = $block_fields;
	}

	public function reset_current_block_fields() {
		return $this->current_block_fields = [];
	}

	public function get_block_fields( string $block_id ) {
		return isset( $this->block_fields[ $block_id ] ) ? $this->block_fields[ $block_id ] : [];
	}

	public function set_block_fields( string $block_id, array $block_fields ) {
		$this->set_current_block_id( $block_id );

		return $this->block_fields[ $block_id ] = $block_fields;
	}

	public function reset_block_fields( string $block_id ) {
		if ( $block_id === $this->get_current_block_id() ) {
			$this->reset_current_block_id();
		}
		unset( $this->block_fields[ $block_id ] );
	}

	public function get_current_block_id() {
		return $this->current_block_id;
	}

	public function set_current_block_id( $block_id ) {
		$this->current_block_id = $block_id;
	}

	public function reset_current_block_id() {
		$this->current_block_id = null;
	}

	public function get_grid_settings( string $grid_id ) {
		return isset( $this->grid_settings[ $grid_id ] ) ? $this->grid_settings[ $grid_id ] : [];
	}

	public function set_grid_settings( string $grid_id, array $settings ) {

		return $this->grid_settings[ $grid_id ] = $settings;
	}


}