<?php

namespace Blokki;

// if class already defined, bail out
if ( class_exists( 'Blokki\Schema' ) ) {
	return;
}

class Schema {

	protected $schema_array;
	protected $schema;

	/**
	 * Initialize the class and set its properties.
	 *
	 *
	 * @since    1.0.0
	 */
	public function __construct() {


		/**
		 * Blokki Loop action
		 */
		add_action( 'blokki_template_posts_loop_post', [ $this, 'setup_schema_for_post_in_loop' ], 10, 3 );

		/**
		 * WP Grid Builder Action for Card
		 */
		add_action( 'wp_grid_builder/grid/the_object', [ $this, 'setup_schema_for_post_in_wp_grid_card' ], 10, 1 );

		add_action( 'wp_footer', [ $this, 'output_schema' ] );
	}

	/**
	 * Setup Schema for Post inside loop in a block
	 * @hooked wp_grid_builder/card/wrapper_start
	 */
	public function setup_schema_for_post_in_wp_grid_card( $object ) {

		// we are only interested in WP_Post Object
		if ( 'WP_Post' === get_class( $object ) ) {
			$this->enqueue_post_schema( $object );
		}

		return $object;
	}

	/**
	 * Enqueue Schema using the $post object
	 */
	public function enqueue_post_schema( $post ) {

		$schema_type = $this->get_post_schema_type( $post );

		if ( ! $schema_type ) {
			return null;
		}

		/**
		 * Lets setup Schema Type class for the specified schema_type
		 * This will set up schema class
		 */
		$schema_type_class = $this->setup_schema_type( $schema_type );

		if ( ! $schema_type_class ) {
			return null;
		}
		/**
		 * Add Post Schema to the class
		 */
		$schema_type_class->add_post_schema( $post );
	}

	/**
	 * Get Schema Type from Post Object
	 */
	public function get_post_schema_type( $post ) {

		$post_type_config = blokki_get_post_type_config( get_post_type( $post ) );

		if (
			is_array( $post_type_config )
			&& isset( $post_type_config['schema'] )
			&& is_string( $post_type_config['schema'] )
		) {
			$class = $this->get_namespace_class_name( $post_type_config['schema'] );
			if ( class_exists( $class ) ) {
				return $post_type_config['schema'];
			} else {
				return false;
			}
		}

		return false;

	}

	/**
	 *
	 */
	public function get_namespace_class_name( $schema_type ) {
		return "Blokki\\Schema\\{$schema_type}";
	}


	/**
	 * @param $schema_type
	 *
	 * @return mixed|null
	 */
	public function setup_schema_type( $schema_type ) {

		$class = $this->get_namespace_class_name( $schema_type );

		// if the required class not found, we should return
		if ( ! class_exists( $class ) ) {
			return null;
		}

		/**
		 * If not Already initiated, then initiate a new one
		 */
		if ( ! isset( $this->schema_array[ $schema_type ] ) ) {
			$this->schema_array[ $schema_type ] = new $class;
		}

		return $this->schema_array[ $schema_type ];

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
	 */
	public function setup_schema_for_post_in_loop( $post, $block, $loop ) {


		if ( $this->is_disable_schema_block( $block ) ) {
			return null;
		}

		$this->enqueue_post_schema( $post );

	}

	/**
	 *
	 */
	public function is_disable_schema_block( $block ) {

		if ( isset( $block->data['disable_schema'] ) && $block->data['disable_schema'] ) {
			return true;
		}

		return false;

	}

	/**
	 * @hooked wp_footer
	 */
	public function output_schema() {

		$this->build_schema();

		if ( empty( $this->schema ) ) {
			return;
		}

		printf( '<!-- BJM-SEO Schema added by BJM --><script type="application/ld+json">%s</script>',
			$this->schema
		);
	}

	/**
	 *
	 */
	public function build_schema() {

		if ( ! is_array( $this->schema_array ) || empty( $this->schema_array ) ) {
			return;
		}

		$combined_schema = [];

		foreach ( $this->schema_array as $schema_class ):
			$schema = $schema_class->get_schema();
			if ( $schema ) {
				$combined_schema[] = $schema_class->get_schema();
			}
		endforeach;

		$schema_json = wp_json_encode( $combined_schema );
		if ( ! json_last_error() ) {
			$this->schema = $schema_json;
		}

	}

}