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

//add_action( 'wp_footer', function (){
//
//} );


//add_action( 'pre_get_posts', 'remove_archive_pagination' );

if ( ! function_exists( 'bjm_wpgb_archive_grid_settings' ) ) :

	function bjm_wpgb_archive_grid_settings( $settings ) {

		// If it matches grid id , we change the grid settings.
		$archive_grid_id = (int) get_field( 'wpgb_grid_archive', 'options' );

		if ( ! $archive_grid_id || $archive_grid_id !== $settings['id'] ) {
			return $settings;
		}

		return $settings;


		$settings = array(
			'id'            => $archive_grid_id,
			'name'          => 'Archive Grid',
			'date'          => '2022-03-02 05:15:22',
			'modified_date' => '2022-03-02 08:12:46',
			'favorite'      => '0',
			'type'          => 'masonry',
			'source'        => 'post_type',
			'settings'      =>
				array(
					'name'                    => 'Archive Grid',
					'class'                   => '',
					'no_posts_msg'            => 'Sorry, No Articles Found',
					'no_results_msg'          => '',
					'source'                  => 'post_type',
					'posts_per_page'          => 0,
					'offset'                  => 0,
					'orderby'                 =>
						array(
							0 => 'menu_order',
						),
					'order'                   => 'ASC',
					'post_type'               =>
						array(),
					'post_status'             =>
						array(
							0 => 'publish',
						),
					'author__in'              =>
						array(),
					'post__in'                =>
						array(),
					'post__not_in'            =>
						array(),
					'tax_query'               =>
						array(),
					'tax_query_operator'      => 'IN',
					'tax_query_relation'      => 'OR',
					'tax_query_children'      => 0,
					'meta_query'              =>
						array(),
					'post_formats'            =>
						array(),
					'first_media'             => 0,
					'default_thumbnail'       => '',
					'thumbnail_aspect'        => 0,
					'thumbnail_size'          => 'medium_large',
					'thumbnail_size_mobile'   => 'medium_large',
					'type'                    => 'masonry',
					'full_width'              => 0,
					'horizontal_order'        => 0,
					'fit_rows'                => 0,
					'equal_columns'           => 1,
					'override_card_sizes'     => 0,
					'card_sizes'              =>
						array(
							0 =>
								array(
									'columns' => 3,
									'height'  => 240,
									'gutter'  => 30,
									'ratio'   =>
										array(
											'x' => 4,
											'y' => 3,
										),
								),
							1 =>
								array(
									'browser' => 1200,
									'columns' => 3,
									'height'  => 240,
									'gutter'  => 30,
									'ratio'   =>
										array(
											'x' => 4,
											'y' => 3,
										),
								),
							2 =>
								array(
									'browser' => 992,
									'columns' => 3,
									'height'  => 220,
									'gutter'  => 30,
									'ratio'   =>
										array(
											'x' => 4,
											'y' => 3,
										),
								),
							3 =>
								array(
									'browser' => 768,
									'columns' => 2,
									'height'  => 220,
									'gutter'  => 20,
									'ratio'   =>
										array(
											'x' => 4,
											'y' => 3,
										),
								),
							4 =>
								array(
									'browser' => 576,
									'columns' => 2,
									'height'  => 200,
									'gutter'  => 20,
									'ratio'   =>
										array(
											'x' => 4,
											'y' => 3,
										),
								),
							5 =>
								array(
									'browser' => 320,
									'columns' => 1,
									'height'  => 200,
									'gutter'  => - 1,
									'ratio'   =>
										array(
											'x' => 4,
											'y' => 3,
										),
								),
						),
					'layout'                  => 'vertical',
					'grid_layout'             =>
						array(
							'area-top-1'    =>
								array(
									'style'  =>
										array(
											'justify-content' => 'flex-start',
										),
									'facets' => '',
								),
							'area-bottom-1' =>
								array(
									'style'  =>
										array(
											'justify-content' => 'center',
										),
									'facets' => '',
								),
							'area-bottom-2' =>
								array(
									'style'  =>
										array(
											'justify-content' => 'center',
										),
									'facets' => '',
								),
						),
					'cards'                   =>
						array(
							'default' => '',
							'aside'   => '',
							'chat'    => '',
							'gallery' => '',
							'link'    => '',
							'image'   => '',
							'quote'   => '',
							'status'  => '',
							'video'   => '',
							'audio'   => '',
						),
					'content_background'      => '',
					'overlay_background'      => '',
					'content_color_scheme'    => 'dark',
					'overlay_color_scheme'    => 'light',
					'animation'               => '',
					'timing_function'         => 'ease',
					'transition'              => 700,
					'transition_delay'        => 100,
					'lazy_load'               => 0,
					'lazy_load_spinner'       => 0,
					'lazy_load_blurred_image' => 0,
					'lazy_load_background'    => '#e0e4e9',
					'lazy_load_spinner_color' => '#0069ff',
					'loader'                  => 0,
					'loader_color'            => '#0069ff',
					'loader_size'             => 1,
					'loader_type'             => 'wpgb-loader-1',
					'custom_css'              => '',
					'custom_js'               => '',
				),
		);


		return $settings;
	}

endif;

//add_filter( 'wp_grid_builder/grid/settings', 'bjm_wpgb_archive_grid_settings', 10, 1 );

/**
 * TODO: WPGB Support
 * The problem is when the grid re-renders (after applying filters),
 * the block data is not available, nor does the class instances data is available for this filter
 * Probably due to AJAX request.
 * We need to have some way to Re-use a grid on different pages with various Post Type, Taxonomy and Filtering option.
 */
if ( ! function_exists( 'blokki_wpgb_override_grid_settings_with_block' ) ) :

	function blokki_wpgb_override_grid_settings_with_block( $settings ) {

		$block_id = Blokki()->blocks->get_current_block_id();
		if ( ! $block_id ) {
			return $settings;
		}
		$block_fields = Blokki()->blocks->get_block_fields( $block_id );

		if ( ! $block_fields ) {
			return $settings;
		}

		$post_query_args = blokki_get_posts_query_for_block( $block_fields );

		/**
		 * Fix tax_query according to the WPGB requirement for grid settings which requires only term ids
		 */
		if ( isset( $post_query_args['tax_query'] ) ) {
			$term_ids = blokki_get_term_ids_from_tax_query( $post_query_args['tax_query'] );
			if ( ! empty( $term_ids ) ) {
				$post_query_args['tax_query'] = $term_ids;
			} else {
				unset( $post_query_args['tax_query'] );
			}
		}

		$settings = wp_parse_args( $post_query_args, $settings );

		/**
		 * Try to add block_id to settings as well and then target on the basis of block id
		 */

		/**
		 * Check if we have facets for top region
		 */
		$facets_top = $block_fields['wpgb_facets_top'] ?? null;
		if ( $facets_top && isset( $settings['grid_layout']['area-top-1']['facets'] ) ) {
			$settings['grid_layout']['area-top-1']['facets'] = $facets_top;
		}

		/**
		 * Check if we have facets for bottom region
		 */
//		$facets_bottom = $block_fields['wpgb_facets_bottom'] ?? null;
//		if ( $facets_bottom && isset( $settings['grid_layout']['area-bottom-1']['facets'] ) ) {
//			$settings['grid_layout']['area-bottom-1']['facets'] = $facets_bottom;
//		}

		return $settings;

	}

endif;

if ( ! function_exists( 'blokki_wpgb_override_grid_query_with_block' ) ) :

	function blokki_wpgb_override_grid_query_with_block( $query_args, $grid_id ) {

//		blokki_dump( $query_args);

//		return $query_args;

		$block_grid_id = Blokki()->blocks->get_current_grid_id();
		var_dump( $block_grid_id);

		if($grid_id !== $block_grid_id){
			return $query_args;
		}

		$block_fields = get_fields();

		if ( ! $block_fields ) {
			return $query_args;
		}

		$post_query_args = blokki_get_posts_query_for_block( $block_fields );

		/**
		 * Fix tax_query according to the WPGB requirement for grid settings which requires only term ids
		 */
//		if ( isset( $post_query_args['tax_query'] ) ) {
//			$term_ids = blokki_get_term_ids_from_tax_query( $post_query_args['tax_query'] );
//			if ( ! empty( $term_ids ) ) {
//				$post_query_args['tax_query'] = $term_ids;
//			} else {
//				unset( $post_query_args['tax_query'] );
//			}
//		}

		$query_args = wp_parse_args( $post_query_args, $query_args );

		/**
		 * Try to add block_id to settings as well and then target on the basis of block id
		 */

		/**
		 * Check if we have facets for top region
		 */
//		$facets_top = $block_fields['wpgb_facets_top'] ?? null;
//		if ( $facets_top && isset( $settings['grid_layout']['area-top-1']['facets'] ) ) {
//			$settings['grid_layout']['area-top-1']['facets'] = $facets_top;
//		}

		/**
		 * Check if we have facets for bottom region
		 */
//		$facets_bottom = $block_fields['wpgb_facets_bottom'] ?? null;
//		if ( $facets_bottom && isset( $settings['grid_layout']['area-bottom-1']['facets'] ) ) {
//			$settings['grid_layout']['area-bottom-1']['facets'] = $facets_bottom;
//		}
//		blokki_dump( $query_args);

		return $query_args;

	}

endif;

//add_filter( 'wp_grid_builder/grid/settings', 'blokki_wpgb_override_grid_settings_with_block' );


//function blokki_wpgb_card_register_template( $templates ) {
//
//
//	// 'my_template' corresponds to the template ID.
//	$templates['blokki_card_template'] = [
//		'class'              => '',
//		'source_type'        => 'post_type',
//		'is_main_query'      => false,
//		'query_args'         => [
//			'post_type'      => 'post',
//			'posts_per_page' => 10,
//		],
//		'render_callback'    => 'blokki_wpgb_template_render_callback',
//		'noresults_callback' => 'blokki_wpgb_template_noresults_callback',
//	];
//
//	return $templates;
//
//}

//add_filter( 'wp_grid_builder/templates', 'blokki_wpgb_card_register_template', 10, 1 );


//if ( ! function_exists( 'blokki_wpgb_template_render_callback' ) ) :
//
//	function blokki_wpgb_template_render_callback( $post ) {
//		// No Need to setup_postdata as WPGB has already done it.
//		blokki_render_post();
//	}
//
//endif;
//
//if ( ! function_exists( 'blokki_wpgb_template_noresults_callback' ) ) :
//
//	function blokki_wpgb_template_noresults_callback() {
//
//		blokki_loader()->get_template_part( 'loop', 'no-content' );
//
//	}
//
//endif;
