<?php

if ( ! function_exists( 'blokki_wpgb_query_related_cards' ) ) :

	function blokki_wpgb_query_related_cards( $query_args, $grid_id ) {

		if ( ! is_singular() ) {
			return $query_args;
		}

		$post_type = get_post_type();
		if ( ! $post_type ) {
			return $query_args;
		}
		$post_id = get_the_ID();

		$related_grids = get_field( 'wpgb_grid_related', 'options' );

		if ( ! $related_grids ) {
			return $query_args;
		}
		$related_grids = array_map( 'intval', $related_grids );

		if ( ! in_array( $grid_id, $related_grids, true ) ) {
			return $query_args;
		}

		$query_args['post_type'] = [ $post_type ];
		$tax_query_args          = blokki_get_related_tax_query_args( $post_id );
		if ( ! empty( $tax_query_args ) ) :

			// check if we have some posts with related args
			$grid_query_args = $query_args;
			if (
				isset( $grid_query_args['tax_query'] )
				&& is_array( $grid_query_args['tax_query'] )
				&& ! empty( $grid_query_args['tax_query'] )
			) {
				$grid_query_args['tax_query'] = array_merge( $grid_query_args['tax_query'], $tax_query_args );
			} else {
				$grid_query_args['tax_query'] = $tax_query_args;
			}

			$grid_query_args['post__not_in'] = [ $post_id ];

			$temp_query = new WP_Query( $grid_query_args );

			if ( $temp_query->have_posts() ) {
				return $grid_query_args;
			}

		endif; //  ! empty( $tax_query_args )

		return $query_args;

	}
endif;

add_filter( 'wp_grid_builder/grid/query_args', 'blokki_wpgb_query_related_cards', 10, 2 );

if ( ! function_exists( 'blokki_wpgb_query_exclude_current' ) ) :

	function blokki_wpgb_query_exclude_current( $query_args, $grid_id ) {

		if ( ! is_singular() ) {
			return $query_args;
		}

		$query_args['post__not_in'] = [ get_the_ID() ];

		return $query_args;
	}

endif;

add_filter( 'wp_grid_builder/grid/query_args', 'blokki_wpgb_query_exclude_current', 10, 2 );


function blokki_wpgb_add_post_type_to_card_class( $atts, $card ) {

	// We get post in the custom loop of the plugin.
	if ( function_exists( 'wpgb_get_post_type' ) ) {
		$atts['class'][] = 'type-' . wpgb_get_post_type();
	}

	return $atts;

}

add_filter( 'wp_grid_builder/card/attributes', 'blokki_wpgb_add_post_type_to_card_class', 10, 2 );


if ( ! function_exists( 'blokki_wpgb_get_custom_card_id' ) ) :

	function blokki_wpgb_get_custom_card_id( $card = '' ) {
		if ( ! is_admin() ) {
			return 'blokki';
		}

		return $card;

	}

endif;


if ( ! is_admin() ) {
	/**
	 * TODO: WPGB Support
	 * There is no indication as to which card id we are going to filter,
	 * There is no context to this filter
	 */
	add_filter( 'wp_grid_builder/card/id', 'blokki_wpgb_get_custom_card_id', 10, 1 );
}


if ( ! function_exists( 'blokki_wpgb_card_render_callback' ) ) :

	function blokki_wpgb_card_render_callback() {

		if ( function_exists( 'wpgb_get_post' ) ) {
			$object    = wpgb_get_post();
			$object_id = $object->ID;
		} else {
			$object_id = get_the_ID();
		}
		global $post;
		$post = get_post( $object_id );
		setup_postdata( $post );
		blokki_render_post();
		wp_reset_postdata();

	}

endif;


/**
 * TODO: WPGB Support
 * This option does not work well due to:
 * 1. Un-necessary html structure
 * 2. Its not the actual card but instead a block in the card
 * 3. Replacing the full card option seems more realistic
 */
function blokki_wpgb_register_card_block( $blocks ) {

	$blocks['blokki_full_card'] = [
		'name'            => __( 'Blokki Card', 'blokki' ),
		'render_callback' => 'blokki_wpgb_card_render_callback',
	];

	return $blocks;

}

add_filter( 'wp_grid_builder/blocks', 'blokki_wpgb_register_card_block' );


if ( ! function_exists( 'blokki_wpgb_set_custom_card_id_args' ) ) :

	function blokki_wpgb_set_custom_card_id_args( $cards ) {

		$cards[ blokki_wpgb_get_custom_card_id() ] = array(
			'render_callback' => 'blokki_wpgb_card_render_callback',
		);

		return $cards;
	}

endif;

add_filter( 'wp_grid_builder/cards', 'blokki_wpgb_set_custom_card_id_args' );


function remove_archive_pagination( $query ) {

	if ( is_archive() ) {
		$query->set( 'no_found_rows', true );
	}
}


if ( ! function_exists( 'blokki_wpgb_get_grids' ) ) :

	function blokki_wpgb_get_grids() {
		$grids = [];

		if ( ! class_exists( 'WP_Grid_Builder\Includes\Database' ) ) {
			return $grids;
		}

		/** @noinspection PhpUndefinedNamespaceInspection */
		$grids_query = WP_Grid_Builder\Includes\Database::query_results( [
			'from' => 'grids'
		] );

		if ( is_array( $grids_query ) ) {
			$grids = $grids_query;
		}

		return $grids;

	}

endif;

if ( ! function_exists( 'blokki_wpgb_get_facets' ) ) :

	function blokki_wpgb_get_facets() {
		$facets = [];

		if ( ! class_exists( 'WP_Grid_Builder\Includes\Database' ) ) {
			return $facets;
		}

		/** @noinspection PhpUndefinedNamespaceInspection */
		$facets_query = WP_Grid_Builder\Includes\Database::query_results( [
			'from' => 'facets'
		] );

		if ( is_array( $facets_query ) ) {
			$facets = $facets_query;
		}

		return $facets;

	}

endif;

if ( ! function_exists( 'blokki_wpgb_get_grids_as_option_choices' ) ) :

	function blokki_wpgb_get_grids_as_option_choices() {
		$options = [];
		$grids   = blokki_wpgb_get_grids();

		if ( ! is_array( $grids ) || empty( $grids ) ) {
			return $options;
		}

		$ids   = wp_list_pluck( $grids, 'id' );
		$names = wp_list_pluck( $grids, 'name' );

		$options = array_combine( $ids, $names );

		return $options;

	}

endif;

if ( ! function_exists( 'blokki_wpgb_get_facets_as_option_choices' ) ) :

	function blokki_wpgb_get_facets_as_option_choices() {
		$options = [];
		$facets  = blokki_wpgb_get_facets();

		if ( ! is_array( $facets ) || empty( $facets ) ) {
			return $options;
		}

		$ids   = wp_list_pluck( $facets, 'id' );
		$names = wp_list_pluck( $facets, 'name' );

		$options = array_combine( $ids, $names );

		return $options;

	}

endif;

if ( ! function_exists( 'blokki_wpgb_acf_grid_field_options' ) ) :

	function blokki_wpgb_acf_grid_field_options( $field ) {

		$choices = blokki_wpgb_get_grids_as_option_choices();
		// loop through array and add to field 'choices'
		if ( is_array( $choices ) && ! empty( $choices ) ) {
			foreach ( $choices as $grid_id => $grid_name ) {
				$field['choices'][ $grid_id ] = $grid_name;
			}
		}

		return $field;
	}

endif;

if ( ! function_exists( 'blokki_wpgb_acf_facet_field_options' ) ) :

	function blokki_wpgb_acf_facet_field_options( $field ) {

		$choices = blokki_wpgb_get_facets_as_option_choices();
		// loop through array and add to field 'choices'
		if ( is_array( $choices ) && ! empty( $choices ) ) {
			foreach ( $choices as $grid_id => $grid_name ) {
				$field['choices'][ $grid_id ] = $grid_name;
			}
		}

		return $field;
	}

endif;

/**
 * Dynamically update ACF field options
 */
add_filter( 'acf/load_field/name=wpgb_grid_related', 'blokki_wpgb_acf_grid_field_options' );
add_filter( 'acf/load_field/name=wpgb_grid_archive', 'blokki_wpgb_acf_grid_field_options' );
add_filter( 'acf/load_field/name=wpgb_grid_for_block', 'blokki_wpgb_acf_grid_field_options' );
add_filter( 'acf/load_field/name=wpgb_facets_top', 'blokki_wpgb_acf_facet_field_options' );
add_filter( 'acf/load_field/name=wpgb_facets_bottom', 'blokki_wpgb_acf_facet_field_options' );


if ( ! function_exists( 'bjm_wpgb_archive_grid_settings' ) ) :

	function bjm_wpgb_archive_grid_settings( $settings ) {

		// If it matches grid id , we change the grid settings.
		$archive_grid_id = (int) get_field( 'wpgb_grid_archive', 'options' );

		if ( ! $archive_grid_id || $archive_grid_id !== $settings['id'] ) {
			return $settings;
		}

		return $settings;

	}

endif;

//add_filter( 'wp_grid_builder/grid/settings', 'bjm_wpgb_archive_grid_settings', 10, 1 );



