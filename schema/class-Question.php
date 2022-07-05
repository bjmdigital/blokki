<?php

namespace Blokki\Schema;

// if class already defined, bail out
if ( class_exists( 'Blokki\Schema\Question' ) ) {
	return;
}

class Question extends BaseSchemaType {


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Add post schema
	 */
	public function add_post_schema( $post = 0 ) {

		$cached_schema = $this->get_cache_schema_for_post( $post );
		if ( $cached_schema ) {
			$this->schema = $cached_schema;

			return;
		}

		$this->schema->name = wp_strip_all_tags( $post->post_title );

		$answer_schema       = $this->get_base_schema_type( 'Answer' );
		$answer_schema->text = wp_strip_all_tags( $post->post_content );

		$this->schema->acceptedAnswer = $answer_schema;
		$this->set_cache_schema_for_post( $this->schema, $post );

	}

	/**
	 * abstract function on parent class
	 * to set required properties
	 * @return array
	 */
	protected function set_required_properties() {
		return [ 'name', 'acceptedAnswer' ];
	}

}