<?php

namespace Blokki;

// if class already defined, bail out
if ( class_exists( 'Blokki\Schema' ) ) {
	return;
}

/**
 * The class to control the Schema offered by BJM
 */
class Schema {

	protected array $schema_array = [];
	protected string $schema = '';

	/**
	 * Initialize the class and set its properties.
	 *
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( ! function_exists( 'get_field')
			||
			! get_field( 'blokki_schema_support', 'options' ) ) {
			return null;
		}
		/**
		 * Blokki Loop action
		 */
		add_action( 'blokki_template_posts_loop_post', [ $this, 'setup_schema_for_post_in_loop' ], 10, 3 );

		/**
		 * WP Grid Builder Action for Card
		 */
		add_action( 'wp_grid_builder/grid/the_object', [ $this, 'setup_schema_for_post_in_wp_grid_loop' ], 10, 1 );

		/**
		 * Output the schema in footer
		 */
		add_action( 'wp_footer', [ $this, 'output_schema' ] );

		/**
		 * Remove Schema cache transient on post save
		 */
		add_action( 'save_post', [ $this, 'remove_schema_cache_on_post_save' ] );


	}

	/**
	 * Remove schema cached result on post_save
	 */
	public function remove_schema_cache_on_post_save( $post_id ) {

		global $wpdb;
		$wpdb->query(
			$wpdb->prepare( "DELETE FROM $wpdb->options WHERE `option_name` LIKE %s",
				'_transient_' . BLOKKI_SCHEMA_CACHE_PREFIX . $post_id . '%'
			)
		);

	}

	/**
	 * Setup Schema for Post inside loop in a block
	 * @hooked wp_grid_builder/card/wrapper_start
	 */
	public function setup_schema_for_post_in_wp_grid_loop( $object ) {

		// we are only interested in WP_Post Object
		if ( 'WP_Post' === get_class( $object ) ) {
			$this->enqueue_post_loop_schema( $object );
		}

		return $object;
	}

	/**
	 * Enqueue Schema using the $post object
	 */
	public function enqueue_post_loop_schema( $post ) {
		$post = get_post( $post );

		if ( ! $post ) {
			return null;
		}

		$loop_schema_type = $this->get_post_loop_schema_type( $post );

		if ( ! $loop_schema_type ) {
			return null;
		}

		/**
		 * Lets setup Schema Type class for the specified loop_schema
		 */
		$loop_schema_type_class = $this->setup_schema_type( $loop_schema_type, $post->post_type );

		if ( ! $loop_schema_type_class ) {
			return null;
		}
		/**
		 * Add Post Schema to the class
		 */
		$loop_schema_type_class->add_post_schema( $post );
	}

	/**
	 * Get Loop Schema Type from Post Object
	 */
	public function get_post_loop_schema_type( $post ) {

		return $this->get_post_schema_type( $post, true );

	}

	/**
	 * Get Schema Type from Post Object
	 */
	public function get_post_schema_type( $post, $for_post_loop = false ) {

		$schema_use = $for_post_loop ? 'loop_schema' : 'schema';

		$post_type_config = blokki_get_post_type_config( get_post_type( $post ) );

		if (
			is_array( $post_type_config )
			&& isset( $post_type_config[ $schema_use ] )
			&& is_string( $post_type_config[ $schema_use ] )
		) {
			return $post_type_config[ $schema_use ];
		}

		return false;

	}

	/**
	 * @param $loop_schema_type
	 * @param string $post_schema_type
	 *
	 * @return mixed|null
	 */
	public function setup_schema_type( $loop_schema_type, string $post_schema_type = '' ) {

		$class = $this->get_namespace_class_name( $loop_schema_type );

		// if the required class not found, we should return
		if ( ! class_exists( $class ) ) {
			return null;
		}
		/**
		 * We need a key identifying the different types of post schema
		 * so that on list contains only one type of schema,
		 * Reference: https://developers.google.com/search/docs/advanced/structured-data/carousel#guidelines
		 */
		$array_key = $loop_schema_type . '_' . $post_schema_type;

		/**
		 * If not Already initiated, then initiate a new one
		 */
		if ( ! isset( $this->schema_array[ $array_key ] ) ) {
			$this->schema_array[ $array_key ] = new $class;
		}

		return $this->schema_array[ $array_key ];
	}

	/**
	 *
	 */
	public function get_namespace_class_name( $schema_type ) {
		return "Blokki\\Schema\\$schema_type";
	}

	/**
	 * Get the schema_type class from schema array
	 */
	public function get_schema_type_class( $schema_type ) {

		if ( isset( $this->schema_array[ $schema_type ] ) ) {
			return $this->schema_array[ $schema_type ];
		}

		return null;

	}

	/**
	 * Setup Schema for Post inside loop in a block
	 * @hooked blokki_template_posts_loop_post
	 *
	 * @param $post \WP_Post
	 * @param $block
	 * @param $loop \WP_Query
	 *
	 * @return void|null
	 * @noinspection PhpUnusedParameterInspection
	 */
	public function setup_schema_for_post_in_loop( \WP_Post $post, $block, \WP_Query $loop ) {

		if ( $this->is_disable_schema_block( $block ) ) {
			return null;
		}

		$this->enqueue_post_loop_schema( $post );

	}

	/**
	 * Check if the $block properties hav disabled schema
	 */
	public function is_disable_schema_block( $block ) {

		if (
			is_object( $block )
			&& property_exists( $block, 'data' )
			&& isset( $block->data['disable_schema'] )
			&& $block->data['disable_schema']
		) {
			return true;
		}

		return false;

	}

	/**
	 * Output the Schema script
	 * @hooked wp_footer
	 */
	public function output_schema() {

		$this->build_schema();

		if ( empty( $this->schema ) ) {
			return;
		}

		printf( "\n<!-- BJM-SEO Schema added by BJM --><script type=\"application/ld+json\">%s</script>\n",
			$this->schema
		);
	}

	/**
	 * The main function to buildup the schema
	 * It will only build schema if it has found one
	 * and there are no json errors in schema
	 */
	public function build_schema() {

		if ( ! is_array( $this->schema_array ) || empty( $this->schema_array ) ) {
			return null;
		}

		$combined_schema = [];

		foreach ( $this->schema_array as $schema_class ):
			$schema = $schema_class->get_schema();

			if ( $schema ) {
				$combined_schema[] = $schema;
			}
		endforeach;

		$combined_schema = apply_filters( 'blokki_schema_combined_before_json_encode', $combined_schema );

		if ( empty( $combined_schema ) ) {
			return null;
		}
		$schema_json = wp_json_encode( $combined_schema );

		if ( ! json_last_error() ) {
			$this->schema = $schema_json;
		}

	}

}