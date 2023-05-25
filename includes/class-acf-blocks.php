<?php

namespace Blokki;

/**
 * This class will create meta boxes for Shortcodes
 *
 * @package    Blokki
 * @subpackage Blokki/includes
 */
class AcfBlocks {

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
	 * @var array a list of removed blocks
	 */
	private $removed_blocks = [];

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

		$this->register_acf_options();
		$this->register_hooks();

	}

	/**
	 * Register ACF Options
	 */
	public function register_acf_options() {


		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return null;
		}

		acf_add_options_page(
			[
				'page_title' => esc_html__( 'Blokki Settings', 'blokki' ),
				'menu_title' => esc_html__( 'Blokki', 'blokki' ),
				'menu_slug'  => 'blokki-settings',
				'capability' => 'manage_options',
				'icon_url'   => 'dashicons-image-filter'
			]
		);

	}

	/**
	 * Register required hooks
	 */
	public function register_hooks() {


		/**
		 * Set location to load acf data from
		 */
		add_filter( 'acf/settings/load_json', [ $this, 'acf_add_json_path' ] );

		/**
		 * Update location for
		 */
		add_action( 'acf/update_field_group', [ $this, 'acf_group_save_path_correction' ], 1, 1 );


		/**
		 * Register ACF Blocks
		 */
		add_action( 'acf/init', [ $this, 'register_blocks_with_acf' ] );


		/**
		 * Add wp_block to the ACF post types
		 */
		add_filter( 'acf/get_post_types', [ $this, 'acf_add_blocks_to_post_types' ] );

		// include new field types
		add_action( 'acf/include_field_types', [ $this, 'include_field' ] ); // v5
		add_action( 'acf/register_fields', [ $this, 'include_field' ] ); // v4


		/**
		 * Dynamically update field choices
		 */
		add_filter( 'acf/load_field/name=post_type', [ $this, 'acf_field_choices_post_type' ] );
		add_filter( 'acf/load_field/name=related_taxonomies', [ $this, 'acf_field_choices_taxonomies' ] );

//		add_action( 'rest_api_init', [ $this, 'custom_rest_route' ] );
	}

	public function custom_rest_route() {
		register_rest_route( 'custom/v1', '/acf-options', array(
			'methods'             => 'GET',
			'callback'            => [ $this, 'get_acf_options' ],
			'permission_callback' => '__return_true'
		) );
	}

	public function get_acf_options() {
		$acf_options = get_fields( 'options' );

		return $acf_options;
	}

	/*
	*  include_field
	*
	*  This function will include the field type class
	*
	*  @param	$version (int) major ACF version. Defaults to false
	*  @return	void
	*/

	function include_field( $version = false ) {

		$include_field_settings = array(
			'version' => BLOKKI_VERSION,
			'url'     => plugin_dir_url( BLOKKI_PLUGIN_FILE ),
			'path'    => plugin_dir_path( BLOKKI_PLUGIN_FILE )
		);

		/**
		 * Multiple Taxonomy Terms
		 */
		new ACF_Field_Multiple_Taxonomy_Terms( $include_field_settings );
	}

	/**
	 * Add JSO Path for ACF Fields
	 * @hooked acf/settings/load_json
	 */
	public function acf_add_json_path( $paths ) {

		$paths[] = blokki_acf_json_path();

		return $paths;

	}

	/**
	 * When field group is updated check for group type i.e. theme vs plugin, then save in the appropriate location
	 */
	public function acf_group_save_path_correction( $group ) {

		if ( strpos( $group['title'], 'Blokki' ) ) {
			add_action( 'acf/settings/save_json', 'blokki_acf_json_path', 9999 );

			return $group;
		} else {
			return $group;
		}

	}

	/**
	 * Register ACF Blocks
	 *
	 * @hooked acf/init
	 */
	public function register_blocks_with_acf() {

		/**
		 * If we do not have ACF activated, bail out early
		 */
		if ( ! function_exists( 'acf_register_block' ) ) {
			return null;
		}

		$remove_blocks = $this->get_removed_blocks();

		$blocks_to_register = $this->get_acf_blocks_config();

		if ( ! is_array( $blocks_to_register ) || empty( $blocks_to_register ) ) {
			return null;
		}

		foreach ( $blocks_to_register as $block ):

			$block_name = $block['name'] ?? null;

			/**
			 * If this block name is in $remove_blocks, continue
			 */
			if ( ! $block_name || in_array( "acf/$block_name", $remove_blocks, true ) ) {
				continue;
			}

			/**
			 * Set a render template if not defined
			 */
			if ( ! isset( $block['render_template'] ) ) {
				$block['render_template'] = blokki_locate_template( "blocks/{$block_name}.php" );
			}

			acf_register_block_type( $block );


		endforeach;


	}

	/**
	 * Get removed blocks
	 */
	public function get_removed_blocks() {

		return apply_filters( 'blokki_remove_block_types', $this->removed_blocks );

	}

	/**
	 * Get ACF blocks config array
	 */
	public function get_acf_blocks_config() {

		$blocks = [];

		if ( ! get_field( 'blokki_disable_registered_block_cards', 'options' ) ) {
			$blocks[] = [
				'name'        => 'cards',
				'title'       => __( 'Blokki Cards' ),
				'description' => __( 'Add block of cards for a post type.' ),
				'category'    => 'theme',
				'icon'        => 'forms',
				'keywords'    => [ 'blokki', 'cards', 'cpt', 'grid' ],
			];
		}

		if ( ! get_field( 'blokki_disable_registered_block_accordions', 'options' ) ) {
			$blocks[] = [
				'name'        => 'accordions',
				'title'       => __( 'Blokki Accordions' ),
				'description' => __( 'Add block of accordions for a post type.' ),
				'category'    => 'theme',
				'icon'        => 'excerpt-view',
				'keywords'    => [ 'blokki', 'accordions', 'cpt', 'grid', 'cards', 'post type' ],
			];
		}
		if ( ! get_field( 'blokki_disable_registered_block_social_share', 'options' ) ) {
			$blocks['social-share'] = [
				'name'        => 'social-share',
				'title'       => __( 'Blokki Social Share', 'blokki' ),
				'description' => __( 'Add social sharing buttons.', 'blokki' ),
				'category'    => 'theme',
				'icon'        => 'share',
				'keywords'    => [ 'blokki', 'social-share' ],
			];
		}

		return apply_filters( 'blokki_acf_blocks_config', $blocks );


	}

	/**
	 * Populate ACF Field with choices
	 * @hooked 'acf/load_field/name=post_type'
	 */
	public function acf_field_choices_post_type( $field ) {

		$field['choices'] = [];
		$choices          = get_post_types( [ 'public' => true ], 'labels' );

		if ( is_array( $choices ) ) {
			foreach ( $choices as $slug => $choice ) {
				$field['choices'][ $slug ] = $choice->label;
			}
		}

		return $field;

	}

	/**
	 * Populate ACF Field with choices
	 * @hooked 'acf/load_field/name=additional_taxonomy_filtering_1'
	 * @hooked 'acf/load_field/name=additional_taxonomy_filtering_2'
	 */
	public function acf_field_choices_taxonomies( $field ) {

		$field['choices'] = [];

		$taxonomies = get_taxonomies( [ 'show_ui' => true ], 'labels' );

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
			$field['choices'][ $taxonomy_slug ] = $taxonomy->label;

		}

		return $field;

	}

	/**
	 * Update field with Taxonomy List
	 * @hooked 'acf/load_field/name=taxonomy_list'
	 */
	public function acf_field_choices_taxonomy_list( $field ) {

		$field['choices']     = [];
		$field['choices'][''] = __( 'Show All', 'blokki' );
		$taxonomies           = get_taxonomies( [ 'public' => true ], 'labels' );

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
			$taxonomy_entries = get_terms( [ 'taxonomy' => $taxonomy_slug, 'hide_empty' => false ] );

			if ( is_array( $taxonomy_entries ) ) {
				foreach ( $taxonomy_entries as $taxonomy_entry ) {
					$field['choices'][ json_encode( [
						'taxonomy' => $taxonomy_slug,
						'field'    => 'slug',
						'terms'    => $taxonomy_entry->slug
					] ) ] = $taxonomy->label . ' -> ' . $taxonomy_entry->name;
				}
			}
		}

		return $field;

	}

	/**
	 * Add wp_block to the ACF post types
	 */
	public function acf_add_blocks_to_post_types( $post_types ) {

		if ( ! in_array( 'wp_block', $post_types ) ) {
			$post_types[] = 'wp_block';
		}


		return $post_types;

	}

}
