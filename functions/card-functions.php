<?php

if ( ! function_exists( 'blokki_render_card' ) ) :

	function blokki_render_card() {

		blokki_get_template( 'card.php' );
	}

endif;

function blokki_get_current_post_id() {

	$post_id = apply_filters( 'blokki_block_cards_current_post', null );

	return $post_id;

}

function blokki_get_posts_query_from_block( $block ) {


	$default_args = blokki_get_default_posts_query_args();
	if ( is_null( $block ) || ! isset( $block['data'] ) ) {
		return $default_args;
	}

	$block_data = $block['data'];

	$query_args = array_intersect_key( $block_data, array_flip( blokki_get_available_query_args() ) );

	/**
	 * Exclude Current Post
	 */
	if ( get_the_ID() && ( $block_data['exclude_current_post'] ?? 0 ) ) {
		$query_args['post__not_in'] = [ get_the_ID() ];
	}

	/**
	 * Show only top level
	 */
	if ( $block_data['show_only_top_level'] ?? 0 ) {
		$query_args['post_parent'] = 0;
	}

	/**
	 * Taxonomy Query
	 */
	if (
		( $block_data['tax_query'] ?? '' )
		&&
		( $query_args['tax_query'] ?? '' )
	) {

		/**
		 * Try to decode JSON
		 */
		$tax_query = blokki_json_decode( $query_args['tax_query'] );

		/**
		 * If we found valid array, then set the tax_query, else unset it
		 */
		if ( ! empty( $tax_query ) ) {
			$query_args['tax_query'] = $tax_query;
		} else {
			unset( $query_args['tax_query'] );
		}

	} else {
		unset( $query_args['tax_query'] );
	}


	$query_args = wp_parse_args( $query_args, $default_args );

	return $query_args;


}

function blokki_get_posts_query_for_block() {


	$default_args = blokki_get_default_posts_query_args();


	$block_data = get_fields();
	if ( ! $block_data ) {
		$block_data = [];
	}
	$query_args = array_intersect_key( $block_data, array_flip( blokki_get_available_query_args() ) );

	/**
	 * Exclude Current Post
	 */
	if ( get_the_ID() && ( $block_data['exclude_current_post'] ?? 0 ) ) {
		$query_args['post__not_in'] = [ get_the_ID() ];
	}

	/**
	 * Show only top level
	 */
	if ( $block_data['show_only_top_level'] ?? 0 ) {
		$query_args['post_parent'] = 0;
	}

	/**
	 * Taxonomy Query
	 */
	if (
		( $block_data['tax_query'] ?? '' )
		&&
		( $query_args['tax_query'] ?? '' )
	) {

		/**
		 * Try to decode JSON
		 */
		$tax_query = blokki_json_decode( $query_args['tax_query'] );

		/**
		 * If we found valid array, then set the tax_query, else unset it
		 */
		if ( ! empty( $tax_query ) ) {
			$query_args['tax_query'] = [ $tax_query ];
		} else {
			unset( $query_args['tax_query'] );
		}

	} else {
		unset( $query_args['tax_query'] );
	}


	$query_args = wp_parse_args( $query_args, $default_args );

	return $query_args;


}

function blokki_get_default_posts_query_args() {

	$default_query_args = [
		'post_type'           => 'any',
		'posts_per_page'      => get_option( 'posts_per_page' ),
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true
	];


	return $default_query_args;

}

function blokki_get_available_query_args() {

	$args = array(
		'author',
		'author_name',
		'author__in',
		'author__not_in',
		'cat',
		'category_name',
		'category__and',
		'category__in',
		'category__not_in',
		'tag',
		'tag_id',
		'tag__and',
		'tag__in',
		'tag__not_in',
		'tag_slug__and',
		'tag_slug__in',
		'tax_query',
		'p',
		'name',
		'title',
		'page_id',
		'pagename',
		'post_name__in',
		'post_parent',
		'post_parent__in',
		'post_parent__not_in',
		'post__in',
		'post__not_in',
		'has_password',
		'post_password',
		'post_type',
		'post_status',
		'comment_count',
		'posts_per_page',
		'nopaging',
		'paged',
		'posts_per_archive_page',
		'offset',
		'page',
		'ignore_sticky_posts',
		'order',
		'orderby',
		'year',
		'monthnum',
		'w',
		'day',
		'hour',
		'minute',
		'second',
		'm',
		'date_query',
		'meta_key',
		'meta_value',
		'meta_value_num',
		'meta_compare',
		'meta_query',
		'perm',
		'post_mime_type',
		'cache_results',
		'update_post_term_cache',
		'update_post_meta_cache',
		'no_found_rows',
		's',
		'exact',
		'sentence',
		'fields',
	);

	return apply_filters( 'blokki_get_available_query_args', $args );
}


if ( ! function_exists( 'blokki_get_post_type_config' ) ) :

	function blokki_get_post_type_config( string $post_type ) {

		$post_type_config = apply_filters( 'blokki_get_post_type_config_' . $post_type, [] );

		return wp_parse_args( $post_type_config, blokki_get_post_type_config_default() );

	}

endif;

if ( ! function_exists( 'blokki_get_post_type_config_default' ) ) :

	function blokki_get_post_type_config_default() {

		$config         = [
			'image_size'  => 'medium_large',
			'link_card'   => false,
			'link_target' => 'self',
			'taxonomy'    => '',
			'order'       => blokki_get_card_template_order_default()
		];
		$display_config = blokki_get_cards_display_config_default();
		$config         = array_merge( $display_config, $config );

		return apply_filters( 'blokki_get_post_type_config_default', $config );

	}

endif;

if ( ! function_exists( 'blokki_get_cards_display_config_default' ) ) :

	function blokki_get_cards_display_config_default() {
		$display_config = [
			'show_title'    => true,
			'show_image'    => true,
			'show_excerpt'  => true,
			'show_readmore' => true,
			'show_meta'     => true,
			'show_date'     => true,
			'show_author'   => true,
			'show_taxonomy' => true,
		];

		return apply_filters( 'blokki_get_cards_display_config_default', $display_config );
	}

endif;


if ( ! function_exists( 'blokki_get_card_template_order_default' ) ) :

	function blokki_get_card_template_order_default() {
		return apply_filters( 'blokki_get_card_template_order_default', [
			'image',
			'title',
			'meta' => blokki_get_card_template_order_meta(),
			'excerpt',
			'readmore'
		] );
	}

endif;

if ( ! function_exists( 'blokki_get_card_template_order_meta' ) ) :

	function blokki_get_card_template_order_meta() {
		return apply_filters( 'blokki_get_card_template_order_meta', [
			'date',
			'taxonomy',
			'author'
		] );
	}

endif;

if ( ! function_exists( 'blokki_get_card_display_options' ) ) :

	function blokki_get_card_display_options() {
		$card_config = [];

		$cards_display_config = blokki_get_cards_display_config_default();

		foreach ( $cards_display_config as $field_id => $value ) {

			// Try to fetch the value for the block
			$field_value = get_field( $field_id );

			if ( is_null( $field_value ) ) {
				// default to true for unspecified $field_value
				// this can be the case when the option is not defined for the block
				$card_config[ $field_id ] = true;
			} elseif ( 'default' !== ( $field_value ) ) {
				// in case of not 'default', we get the block options
				$card_config[ $field_id ] = $field_value;
			}

			// there should be no 'else' as this config is intended to override the post_type config

		}

		return apply_filters( 'blokki_get_cards_display_config', $card_config );
	}

endif;

if ( ! function_exists( 'blokki_render_templates' ) ) :

	function blokki_render_templates( $template_path, $template_order, $post_type_config, $post_type ) {

		foreach ( $template_order as $key => $template ):

			$template_slug = '';

			if ( is_string( $template ) ) {
				$template_slug = $template;
			} elseif ( is_array( $template ) ) {
				$template_slug = $key;
			}

			if ( ! $template_slug ) {
				continue;
			}

			$show_template = isset( $post_type_config["show_{$template_slug}"] ) && $post_type_config["show_{$template_slug}"];

			if ( ! $show_template ) {
				continue;
			}

			blokki_loader()->set_template_data( $post_type_config, 'post_type_config' )
			               ->get_template_part( "{$template_path}/{$template_slug}", $post_type );


		endforeach;

	}

endif;

if ( ! function_exists( 'blokki_get_cards_layout_classes' ) ) :

	function blokki_get_cards_layout_classes() {

		$layout_classes = [];
		/**
		 * Parse Block Options
		 */
		$cards_small_up  = get_field( 'small_up' ) ?? 1;
		$cards_medium_up = get_field( 'medium_up' ) ?? 2;
		$cards_large_up  = get_field( 'large_up' ) ?? 3;
		$feature_first   = get_field( 'feature_first' ) ?? false;
		$grid_margin_x   = get_field( 'grid_margin_x' ) ?? false;
		$grid_margin_y   = get_field( 'grid_margin_y' ) ?? false;

		/**
		 * Update Grid Classes with Card options
		 */
		$layout_classes[] = 'small-up-' . $cards_small_up;
		$layout_classes[] = 'medium-up-' . $cards_medium_up;
		$layout_classes[] = 'large-up-' . $cards_large_up;
		$layout_classes[] = $feature_first ? 'feature-first' : '';
		$layout_classes[] = $grid_margin_x ? 'grid-margin-x' : '';
		$layout_classes[] = $grid_margin_y ? 'grid-margin-y' : '';

		// Remove empty values
		$layout_classes = array_filter( $layout_classes );

		return apply_filters( 'blokki_get_block_layout_classes', $layout_classes );

	}

endif;