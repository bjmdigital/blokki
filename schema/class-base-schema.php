<?php

namespace Blokki\Schema;

// if class already defined, bail out
if ( class_exists( 'Blokki\Schema\BaseSchema' ) ) {
	return;
}

abstract class BaseSchema {

	protected $self;
	protected $schema;
	protected $properties;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->setup_base_schema();
		$this->properties = $this->set_required_properties();
	}

	/**
	 * Setup base schema
	 */
	public function setup_base_schema() {
		$this->schema = $this->get_base_schema_type( $this->get_class_short_name() );

	}

	/**
	 * Get Base Schema type for schema.org context
	 */
	public function get_base_schema_type( string $schema_type ) {

		return (object) [
			'@context' => 'https://schema.org',
			'@type'    => $schema_type
		];

	}

	/**
	 * Get Short name of the static class
	 * @return string
	 */
	private function get_class_short_name() {
		return ( new \ReflectionClass( static::class ) )->getShortName();
	}

	abstract protected function set_required_properties();

	abstract public function add_post_schema();


	/**
	 * Get Schema Array
	 */
	public function get_schema() {

		if ( $this->has_schema() ) {
			return apply_filters( 'blokki_get_schema_' . $this->get_class_short_name(),
				$this->schema
			);
		}

		return null;

	}

	/**
	 * Check if we have the schema
	 */
	protected function has_schema() {

		if ( ! $this->schema ) {
			return false;
		}
		if ( ! is_array( $this->properties ) ) {
			return false;
		}

		foreach ( $this->properties as $property ) {

			if (
				! property_exists( $this->schema, $property )
				|| empty( $this->schema->$property )
			) {
				return false;
			}
		}

		return true;

	}


}