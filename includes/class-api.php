<?php

namespace Blokki;
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Blokki\Api' ) ) {
	return;
}


/**
 * This class deals with API offered by the plugin
 *
 * @package    Blokki
 * @subpackage Blokki/includes
 */
class Api {

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

		$this->register_hooks();

	}

	/**
	 * Register required hooks
	 */
	public function register_hooks() {

		add_action( 'rest_api_init', [ $this, 'endpoint_global_blocks' ] );

	}

	/**
	 *
	 */
	public function endpoint_global_blocks() {

		register_rest_route( 'blokki/v1', '/wp-blocks/', [
			'methods'             => 'GET',
			'callback'            => [ $this, 'get_global_blocks' ],
			'permission_callback' => function () {
				return current_user_can( 'edit_posts' );
			}
		] );

	}

	/**
	 *
	 */
	public function get_global_blocks( $data ) {

		$args = [
			'posts_per_page' => 100,
			'post_type'      => 'wp_block'
		];

		$ar_response = [
			'success' => true,
			'posts'   => get_posts( $args )
		];

		$response = new \WP_REST_Response( $ar_response );
		$response->set_status( 200 );

		return $response;
	}

}