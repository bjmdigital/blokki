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

if ( ! function_exists( 'blokki_get_term_ids_from_tax_query' ) ) :

	function blokki_get_term_ids_from_tax_query( array $tax_query ) {

		if ( isset( $tax_query['relation'] ) ) {
			unset( $tax_query['relation'] );
		}

		return wp_list_pluck( $tax_query, 'terms' );
	}

endif;

function blokki_get_posts_query_for_block( $block_data = [] ) {

	$default_args = blokki_get_default_posts_query_args();

	if ( empty( $block_data ) ) {
		$block_data = get_fields();
	}
	if ( ! $block_data ) {
		$block_data = [];
	}
	/**
	 * Include Current Post
	 */
	if ( ( $block_data['include_current_post'] ?? 0 ) ) {
		unset( $default_args['post__not_in'] );
	}


	$query_args = array_intersect_key( $block_data, array_flip( blokki_get_available_query_args() ) );

	/**
	 * Block Query Type
	 * possible values = 'custom' || 'specific' || 'related'
	 */
	$block_query_type = get_field( 'query_type' );
	/**
	 * Backward Compatibility for Specific Posts
	 */
	if ( is_null( $block_query_type ) && get_field( 'show_specific_cards' ) ) {
		$block_query_type = 'specific';
	}
	/**
	 * If nothing found, which is unlikely set it to 'custom'
	 */
	$block_query_type = ! is_null( $block_query_type ) ? $block_query_type : 'custom';

	/**
	 * Show Children of Specific Post
	 */
	$post_parent = intval( $block_data['post_parent'] ?? 0 );

	if ( $post_parent ) {
		$query_args['post_type'] = get_post_type( $post_parent );
	}

	/**
	 * Query Type
	 */
	switch ( $block_query_type ):
		case( 'related' ):
			$query_args = blokki_update_query_args_with_related_tax_query( $query_args, $block_data );
			break;
		case( 'specific' ):

			// Only do this if we have the specific posts set
			if ( $post__in = get_field( 'post__in' ) ) {
				/**
				 * Fix for CPTs with `exclude_from_search` => true
				 */
				$post_ids = wp_list_pluck( $post__in, 'ID' );

				/** $post_ids will only be available if post object is returned by ACF */
				if ( $post_ids ) {
					$query_args['post__in']  = $post_ids;
					$query_args['post_type'] = wp_list_pluck( $post__in, 'post_type' );
				}
			}

			break;
		case( 'custom' ):
		default:
			$query_args = blokki_update_query_args_with_custom_tax_query( $query_args, $block_data );
			break;
	endswitch;

	$query_args = wp_parse_args( $query_args, $default_args );

	return $query_args;

}

function blokki_update_query_args_with_related_tax_query( $query_args, $block_data ) {

	if ( ! isset( $query_args['tax_query'] ) ) {

		/**
		 * New ACF Field for Multi Taxonomy Terms Select
		 */
		$tax_query = blokki_get_related_tax_query_args(
			get_the_ID(),
			null,
			$block_data['related_taxonomies'] ?? []
		);
		/**
		 * If we found valid array, then set the tax_query, else unset it
		 */
		if ( ! empty( $tax_query ) ) {
			$query_args['tax_query'] = $tax_query;
			// We need to make sure we have something for these query args, so, let query with these args
			$temp_query = new WP_Query( $query_args );
			// Since it will include the current post,
			// so,  found_posts should be greater than 1
			if ( ! $temp_query->found_posts > 1 ) {
				unset( $query_args['tax_query'] );
			}

		}

	}

	return $query_args;

}

function blokki_update_query_args_with_custom_tax_query( $query_args, $block_data ) {
	if (
		( $block_data['tax_query'] ?? '' )
		&&
		( $query_args['tax_query'] ?? '' )
	) {

		/**
		 * New ACF Field for Multi Taxonomy Terms Select
		 */
		$tax_query = blokki_parse_multiple_taxonomy_terms_field( $query_args['tax_query'] );

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

	return $query_args;

}

function blokki_parse_multiple_taxonomy_terms_field( array $multiple_taxonomy_terms ) {

	$tax_query = [
		'relation' => 'OR'
	];
	foreach ( $multiple_taxonomy_terms as $term ):
		if ( ! is_array( $term ) ) {
			$term = get_term( $term );
			if ( is_wp_error( $term ) ) {
				continue;
			}
		}
//		add term to $tax_query
		$tax_query[] = [
			'taxonomy' => $term->taxonomy,
			'field'    => 'id',
			'terms'    => $term->term_id
		];

	endforeach;

	return $tax_query;

}


function blokki_get_default_posts_query_args() {

	$default_query_args = [
		'post_type'           => 'any',
		'posts_per_page'      => get_option( 'posts_per_page' ),
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true
	];


	if ( get_the_ID() ) {
		$default_query_args['post__not_in'] = [ get_the_ID() ];
	}


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

	function blokki_get_post_type_config( string $post_type, string $block_name = 'cards' ) {

		$post_type_config = apply_filters( 'blokki_get_post_type_config_' . $post_type, [], $block_name );

		return wp_parse_args( $post_type_config, blokki_get_post_type_config_default( $block_name ) );

	}

endif;

if ( ! function_exists( 'blokki_get_post_type_config_default' ) ) :

	function blokki_get_post_type_config_default( string $block_name = 'cards' ) {

		$config = [
			'link_card'          => false,
			'link_title'         => true,
			'link_target'        => '_self',
			'link_taxonomy'      => false,
			'card_html_tag'      => 'div',
			'taxonomy'           => '',
			'schema'             => '',
			'loop_schema'        => '',
			'related_taxonomies' => []
		];
		switch ( $block_name ):
			case( 'accordions' ):
				$config['link_title']     = false;
				$config['template']       = 'accordion';
				$config['title_html_tag'] = 'span';
				break;
			case( 'cards' ):
			default:
				$config['template']       = 'card';
				$config['image_size']     = 'medium_large';
				$config['link_image']     = true;
				$config['title_html_tag'] = 'h3';
		endswitch;
		$config['partials'] = blokki_get_block_partials_default( $block_name );

		$display_config = blokki_get_block_display_config_default( $block_name );
		$config         = array_merge( $display_config, $config );

		return apply_filters( 'blokki_get_post_type_config_default', $config );

	}

endif;

if ( ! function_exists( 'blokki_get_block_display_config_default' ) ) :

	function blokki_get_block_display_config_default( $block_name = 'cards' ) {

		$blocks_display_config = [
			'cards'      => [
				'show_title'    => true,
				'show_image'    => true,
				'show_excerpt'  => true,
				'show_readmore' => true,
				'show_meta'     => true,
				'show_date'     => true,
				'show_author'   => true,
				'show_taxonomy' => true,
				'show_inner'    => true,
				'show_content'  => false,
			],
			'accordions' => [
				'show_title'   => true,
				'show_content' => true,
			]
		];
		$blocks_display_config = apply_filters(
			'blokki_get_blocks_display_config_default',
			$blocks_display_config
		);

		if ( isset( $blocks_display_config[ $block_name ] ) ) {
			return apply_filters( "blokki_get_blocks_display_config_default_{$block_name}",
				$blocks_display_config[ $block_name ]
			);
		} else {
			return apply_filters( "blokki_get_blocks_display_config_default_cards",
				$blocks_display_config['cards']
			);
		}


	}

endif;


if ( ! function_exists( 'blokki_get_block_partials_default' ) ) :

	function blokki_get_block_partials_default( string $block_name = 'cards' ) {

		$partials = [
			'cards'      => [
				'image',
				'inner' => blokki_get_card_partials_inner()
			],
			'accordions' => [
				'accordion-button'  => [
					'title'
				],
				'accordion-content' => [
					'content'
				],
			]
		];

		$partials = apply_filters( 'blokki_get_block_partials_default', $partials );

		if ( isset( $partials[ $block_name ] ) ) {
			return apply_filters( "blokki_get_block_partials_default_{$block_name}",
				$partials[ $block_name ]
			);
		} else {
			return apply_filters( "blokki_get_block_partials_default_cards",
				$partials['cards']
			);
		}

	}

endif;


if ( ! function_exists( 'blokki_get_accordion_partials_default' ) ) :

	function blokki_get_accordion_partials_default() {
		return apply_filters( 'blokki_get_accordion_partials_default', [
			'accordion-button'  => [
				'title'
			],
			'accordion-content' => [
				'content'
			],
		] );
	}

endif;

if ( ! function_exists( 'blokki_get_card_partials_meta' ) ) :

	function blokki_get_card_partials_meta() {
		return apply_filters( 'blokki_get_card_partials_meta', [
			'date',
			'taxonomy',
			'author'
		] );
	}

endif;

if ( ! function_exists( 'blokki_get_card_partials_inner' ) ) :

	function blokki_get_card_partials_inner() {
		return apply_filters( 'blokki_get_card_partials_inner', [
			'title',
			'meta' => blokki_get_card_partials_meta(),
			'excerpt',
			'readmore'
		] );
	}

endif;

if ( ! function_exists( 'blokki_get_block_display_options' ) ) :

	function blokki_get_block_display_options( $block_name = 'cards' ) {
		$card_config = [];

		$block_display_config = blokki_get_block_display_config_default();


		foreach ( $block_display_config as $field_id => $value ) :

			// Try to fetch the value for the block
			$field_value = get_field( $field_id );

			if ( is_null( $field_value ) ) {
				// this can be the case when the option is not defined for the block
				continue;
			} elseif ( 'default' !== ( $field_value ) ) {
				// in case of not 'default', we get the block options
				$card_config[ $field_id ] = $field_value;
			}

			// there should be no 'else' as this config is intended to override the post_type config

		endforeach;

		return apply_filters( 'blokki_get_cards_display_config', $card_config );
	}

endif;

if ( ! function_exists( 'blokki_render_partials' ) ) :

	function blokki_render_partials( string $template_path, array $partials, array $post_type_config, string $post_type = '' ) {

		$post_type = ! empty( $post_type ) ? $post_type : get_post_type( get_the_ID() );

		foreach ( $partials as $key => $partial ):

			$partial_slug = '';

			if ( is_string( $partial ) ) {
				$partial_slug = $partial;
			} elseif ( is_array( $partial ) ) {
				$partial_slug = $key;
			}

			if ( ! $partial_slug ) {
				continue;
			}

			if ( isset( $post_type_config["show_{$partial_slug}"] ) ) {
				if ( ! (bool) $post_type_config["show_{$partial_slug}"] ) {
					continue;
				}
			}


			blokki_loader()->set_template_data( $post_type_config, 'post_type_config' )
			               ->get_template_part( "{$template_path}/{$partial_slug}", $post_type );


		endforeach;

	}

endif;

if ( ! function_exists( 'blokki_get_grid_layout_classes' ) ) :

	function blokki_get_grid_layout_classes() {

		$layout_classes = [];
		/**
		 * Parse Block Options
		 */
		$cards_small_up  = get_field( 'small_up' ) ?? 1;
		$cards_medium_up = get_field( 'medium_up' ) ?? 2;
		$cards_large_up  = get_field( 'large_up' ) ?? 3;
		$feature_first   = get_field( 'feature_first' ) ?? false;

		/**
		 * Update Grid Classes with Card options
		 */
		$layout_classes['small_up']      = 'small-up-' . $cards_small_up;
		$layout_classes['medium_up']     = 'medium-up-' . $cards_medium_up;
		$layout_classes['large_up']      = 'large-up-' . $cards_large_up;
		$layout_classes['feature_first'] = $feature_first ? 'feature-first' : '';
		if ( blokki_is_foundation_support() ) {
			$layout_classes['grid_margin_x'] = 'grid-margin-x';
			$layout_classes['grid_margin_y'] = 'grid-margin-y';
		}

		// Remove empty values
		$layout_classes = array_filter( $layout_classes );

		return apply_filters( 'blokki_get_grid_layout_classes', $layout_classes );

	}

endif;

if ( ! function_exists( 'blokki_get_taxonomy_terms_markup' ) ) :

	function blokki_get_taxonomy_terms_markup( string $taxonomy, bool $terms_has_link = false, int $post_id = 0 ) {
		$post_id = $post_id !== 0 ? $post_id : get_the_ID();
		$html    = '';

		$terms = wp_get_post_terms( $post_id, array( $taxonomy ) );

		/**
		 * If no terms found, bail out
		 */
		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return $html;
		}

		$wrapper_classes = apply_filters( 'blokki_taxonomy_terms_markup_wrapper_classes',
			[
				'taxonomy-terms-list',
				'taxonomy-' . $taxonomy
			]
		);


		$html .= sprintf( '<div class="%s">',
			implode( ' ', $wrapper_classes )
		);


		foreach ( $terms as $term ):

			$term_classes   = [ 'taxonomy-term' ];
			$term_classes[] = $term->slug;
			$term_classes[] = 'term-id-' . $term->term_id;
			$term_classes[] = 'taxonomy-' . $taxonomy;


			$term_before = sprintf( '<span class="%s">',
				apply_filters( 'blokki_taxonomy_terms_markup_term_classes',
					implode( ' ', $term_classes ), $term, $post_id
				)
			);
			$term_after  = sprintf( '</span>' );


			if ( $terms_has_link ) {
				$term_html = sprintf( '<a href="%s" rel="tag" title="%s" tabindex="-1">%s</a>',
					get_term_link( $term->term_id ),
					esc_html__( 'View', 'blokki' ) . ' ' . $term->name,
					$term->name
				);
			} else {
				$term_html = $term->name;
			}


			$html .= $term_before . $term_html . $term_after;

		endforeach;


		$html .= sprintf( '</div>' );

		return $html;

	}

endif;

if ( ! function_exists( 'blokki_get_template_post_type_config' ) ) :

	function blokki_get_template_post_type_config( $post_type_config = [] ) {

		if ( ! empty( $post_type_config ) ) {
			return blokki_get_template_data( $post_type_config );
		} else {
			return blokki_get_post_type_config( get_post_type() );
		}
	}

endif;

if ( ! function_exists( 'blokki_get_post_link_title' ) ) :

	function blokki_get_post_link_title( int $post_id = 0 ) {
		$post_id         = $post_id !== 0 ? $post_id : get_the_ID();
		$read_more_label = apply_filters( 'blokki_post_link_title_readmore_label',
			esc_html__( 'Read more about ', 'blokki' ),
			get_post_type( $post_id )
		);

		return $read_more_label . get_the_title( $post_id );
	}

endif;

if ( ! function_exists( 'blokki_override_post_type_config_with_block' ) ) :

	function blokki_override_post_type_config_with_block( $post_type_config, $field_id ) {

		// override field with Block Options
		if ( $field_value = get_field( $field_id ) ) {
			if ( ! is_null( $field_value ) && 'default' !== $field_value ) {
				// fo admin, the returned value might be an array instead of string
				$post_type_config[ $field_id ] = is_array( $field_value )
					? array_pop( $field_value )
					: $field_value;
			}
		}

		return $post_type_config;
	}

endif;

if ( ! function_exists( 'blokki_get_post_title' ) ) :

	function blokki_render_post_title( int $post_id, bool $has_link = true, string $link_target = '_self' ) {
		if ( $has_link && is_post_publicly_viewable( $post_id ) && ! is_admin() ) {
			printf( '<a href="%s" target="%s" title="%s">%s</a>',
				get_the_permalink( $post_id ),
				$link_target,
				blokki_get_post_link_title( $post_id ),
				get_the_title( $post_id )
			);
		} else {
			echo get_the_title( $post_id );
		}
	}

endif;

if ( ! function_exists( 'blokki_render_post' ) ) :

	function blokki_render_post() {
		$post_type_config = blokki_get_post_type_config( get_post_type( get_the_ID() ) );
		$template         = $post_type_config['template'] ?? 'card';

		switch ( $template ):
			case( 'accordion' ):
				blokki_render_accordion();
				break;
			case( 'card' ):
			default:
				blokki_render_card();
		endswitch;
	}

endif;

if ( ! function_exists( 'blokki_render_card' ) ) :

	function blokki_render_card() {
		blokki_loader()->get_template_part( 'card', get_post_type( get_the_ID() ) );
	}

endif;
if ( ! function_exists( 'blokki_render_accordion' ) ) :

	function blokki_render_accordion() {
		blokki_loader()->get_template_part( 'accordion', get_post_type( get_the_ID() ) );
	}

endif;