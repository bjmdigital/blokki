<?php

namespace Blokki\Schema;

// if class already defined, bail out
if ( class_exists( 'Blokki\Schema\ListItem' ) ) {
	return;
}

class ListItem extends BaseSchemaType {


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

		$post = get_post( $post );

		$this->schema->url = get_permalink($post);

	}

	/**
	 * abstract function on parent class
	 * to set required properties
	 */
	protected function set_required_properties() {
		return [ 'url' ];
	}

}