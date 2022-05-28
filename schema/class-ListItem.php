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

		$cached_schema = $this->get_cache_schema_for_post( $post );

		if ( $cached_schema ) {
			$this->schema = $cached_schema;

			return;
		}

		$this->schema->url = get_permalink( $post );
		$this->set_cache_schema_for_post( $this->schema, $post );
	}

	/**
	 * abstract function on parent class
	 * to set required properties
	 */
	protected function set_required_properties() {
		return [ 'url' ];
	}

}