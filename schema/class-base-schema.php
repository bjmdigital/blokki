<?php

namespace Blokki\Schema;

// if class already defined, bail out
if ( class_exists( 'Blokki\Schema\BaseSchema' ) ) {
	return;
}

abstract class BaseSchema {

	protected $self;
	protected $schema;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->setup_base_schema();
	}

	abstract public function setup_base_schema();

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

		return false;

	}

	abstract public function has_schema();

	private function get_class_short_name() {
		return ( new \ReflectionClass( static::class ) )->getShortName();
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


}