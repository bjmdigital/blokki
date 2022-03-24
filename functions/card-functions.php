<?php

if ( ! function_exists( 'blokki_render_card' ) ) :

	function blokki_render_card() {

		blokki_get_template( 'card.php' );
	}

endif;


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

	blokki_var_export( $query_args );

	return $query_args;


}

function blokki_get_default_posts_query_args() {

	$default_query_args = [
		'post_type'           => 'post',
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
