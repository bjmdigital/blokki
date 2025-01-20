<?php

namespace Blokki\Schema;

// if class already defined, bail out
if ( class_exists( 'Blokki\Schema\QAPage' ) ) {
	return;
}

class QAPage extends BaseSchemaType {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		parent::__construct();
		$this->setup_schema_properties();
	}

	/**
	 * abstract function on parent class
	 * to set required properties
	 * @return array
	 */
	protected function set_required_properties() {
		return [ 'mainEntity' ];
	}

	/**
	 * Setup Base Schema
	 */
	public function setup_schema_properties() {
		$this->schema->mainEntity = [];
	}

	/**
	 *
	 */
	public function add_post_schema( $post = 0 ) {

		$question_schema = new Question();
		$question_schema->add_post_schema( $post );

		$schema = $question_schema->get_schema();
		if ( $schema ) {
			$this->schema->mainEntity[] = $schema;
		}
		// unset the variable as it's not needed now
		unset( $schema, $question_schema );

	}


}
