<?php

namespace Blokki\Schema;

// if class already defined, bail out
if ( class_exists( 'Blokki\Schema\ItemList' ) ) {
	return;
}

class ItemList extends BaseSchemaType {

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
	 * Setup Base Schema
	 */
	public function setup_schema_properties() {
		$this->schema->itemListElement = [];
	}

	/**
	 *
	 */
	public function add_post_schema( $post = 0 ) {

		$ListItem = new ListItem();
		$ListItem->add_post_schema( $post );

		$schema = $ListItem->get_schema();
		if ( $schema ) {
			// Add Position property required for ListItem
			$position         = count( $this->schema->itemListElement );
			$schema->position = $position + 1;

			$this->schema->itemListElement[] = $schema;
		}
		// unset the variable as it's not needed now
		unset( $ListItem, $schema );

	}

	/**
	 *
	 */
	protected function set_required_properties() {
		return [ 'itemListElement' ];
	}


}