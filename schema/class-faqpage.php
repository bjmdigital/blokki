<?php

namespace Blokki\Schema;

// if class already defined, bail out
if ( class_exists( 'Blokki\Schema\FAQPage' ) ) {
	return;
}

class FAQPage extends BaseSchema {


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		parent::__construct();
	}

	/**
	 * Setup Base Schema
	 */
	public function setup_base_schema() {

		$this->schema = $this->get_base_schema_type( 'FAQPage' );

		$this->schema->mainEntity = [];

	}

	/**
	 *
	 */
	public function has_schema() {
		if ( $this->schema
		     && property_exists( $this->schema, 'mainEntity' )
		     && ! empty( $this->schema->mainEntity )
		) {
			return true;
		}

		return false;

	}

	/**
	 *
	 */
	public function add_post_schema( $post = 0 ) {

		$post = get_post( $post );

		$question_schema = $this->get_base_schema_type( 'Question' );

		$question_schema->name = wp_strip_all_tags( $post->post_title );

		$answer_schema       = $this->get_base_schema_type( 'Answer' );
		$answer_schema->text = wp_strip_all_tags( $post->post_content );

		$question_schema->acceptedAnswer = $answer_schema;

		$this->schema->mainEntity[] = $question_schema;

	}

}