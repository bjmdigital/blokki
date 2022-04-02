<?php

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 *
 * @param string $template_name Template name.
 * @param string $template_path Template path. (default: '').
 * @param string $default_path Default path. (default: '').
 *
 * @return string
 */
function blokki_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	if ( ! $template_path ) {
		$template_path = Blokki()->template_path();
	}

	if ( ! $default_path ) {
		$default_path = Blokki()->plugin_path() . '/templates/';
	}


	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name,
		)
	);


	// Get default template/.
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	// Return what we found.
	return apply_filters( 'blokki_locate_template', $template, $template_name, $template_path );
}


/**
 * Get other templates passing attributes and including the file.
 *
 * @param string $template_name Template name.
 * @param array $args Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 * @param string $default_path Default path. (default: '').
 */
function blokki_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

	$template = blokki_locate_template( $template_name, $template_path, $default_path );


	// Allow 3rd party plugin filter template file from their plugin.
	$filter_template = apply_filters( 'blokki_get_template', $template, $template_name, $args, $template_path, $default_path );

	if ( $filter_template !== $template ) {
		if ( ! file_exists( $filter_template ) ) {
			/* translators: %s template */
			_doing_it_wrong( __FUNCTION__, sprintf( __( '%s does not exist.', 'blokki' ), '<code>' . $filter_template . '</code>' ), '3.0.0' );

			return;
		}
		$template = $filter_template;
	}

	$action_args = array(
		'template_name' => $template_name,
		'template_path' => $template_path,
		'located'       => $template,
		'args'          => $args,
	);

	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args ); // @codingStandardsIgnoreLine
	}

	do_action( 'blokki_before_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args'] );

	include $action_args['located'];

	do_action( 'blokki_after_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args'] );
}

/**
 * Return the correct path for save acf json in the plugin
 */
function blokki_acf_json_path() {
	return BLOKKI_DIR_PATH . 'acf-json';
}

if ( ! function_exists( 'blokki_dump' ) ) :

	function blokki_dump( $var ) {
		echo '<pre>';
		echo preg_replace( '(\d+\s=>)', "", var_export( $var, true ) );
		echo '</pre>';
	}

endif;

if ( ! function_exists( 'blokki_json_decode' ) ) :

	function blokki_json_decode( $json ) {
		$data = json_decode( (string) $json, true );

		return ( JSON_ERROR_NONE === json_last_error() && ! is_null( $data ) )
			? $data
			: [];

	}

endif;

if ( ! function_exists( 'blokki_get_template_part' ) ) :

	function blokki_get_template_part( $slug, $name = '', $load = true ) {
		/**
		 * Convert back from object to string
		 */
		$slug = is_object( $slug ) ? $slug->scalar : $slug;

		Blokki()->template_loader->get_template_part( $slug, $name, $load );

	}

endif;
if ( ! function_exists( 'blokki_set_template_data' ) ) :

	function blokki_set_template_data( $data, string $variable_name = 'data' ) {
		Blokki()->template_loader->set_template_data( $data, $variable_name );
	}

endif;

if ( ! function_exists( 'blokki_loader' ) ) :

	function blokki_loader() {
		return Blokki()->template_loader;
	}

endif;

if ( ! function_exists( 'blokki_to_string' ) ) :

	function blokki_to_string( $var ) {
		return is_object( $var ) ? $var->scalar : $var;
	}

endif;

if ( ! function_exists( 'blokki_get_template_data' ) ) :

	function blokki_get_template_data( $var, $is_string = false ) {
		$var = $var ?? [];

		return $is_string ? blokki_to_string( $var ) : (array) $var;
	}

endif;

if ( ! function_exists( 'blokki_is_foundation_support' ) ) :

	function blokki_is_foundation_support() {
		return (bool) get_field( 'foundation_support', 'options' );
	}

endif;

if ( ! function_exists( 'blokki_get_related_tax_query_args' ) ) :

	function blokki_get_related_tax_query_args( $post_id ) {
		$tax_query_args = [];

		$taxonomies = get_post_taxonomies( $post_id );

		foreach ( $taxonomies as $taxonomy ) {
			$term_ids = wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );

			if ( ! is_wp_error( $term_ids ) && $term_ids ) {
				$tax_query_args[] = [
					'field'    => 'id',
					'taxonomy' => $taxonomy,
					'terms'    => $term_ids
				];
			}
		}

		if ( $tax_query_args ) {
			$tax_query_args['relation'] = 'OR';
		}

		return $tax_query_args;

	}

endif;