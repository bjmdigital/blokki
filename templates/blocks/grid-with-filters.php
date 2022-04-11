<?php
// to fix IDE crying for unset variable
$block           = $block ?? [];
$block_css_class = $block['className'] ?? 'wp-block-acf-blokki-grid-with-filters';
$block_classes   = [ $block_css_class ];

$block_classes = apply_filters( 'blokki_block_grid_with_filters_block_classes', $block_classes, $block );

$grid_id = (int) get_field( 'wpgb_grid_for_block' );

$facets_top = get_field( 'wpgb_facets_top' );

$block_id = isset( $block['id'] ) ? $block['id'] : '';
/**
 * HTML Output
 */
printf( '<div class="%s">', implode( ' ', $block_classes ) );

//Blokki()->blocks->set_block_fields( $block_id, get_fields() );
Blokki()->blocks->set_current_grid_id( $grid_id );
/**
 * Add the filter to override post query
 */
add_filter( 'wp_grid_builder/grid/query_args', 'blokki_wpgb_override_grid_query_with_block', 10, 2 );

//add_filter( 'wp_grid_builder/grid/settings', 'blokki_wpgb_override_grid_settings_with_block' );
//add_filter( 'wp_grid_builder/facet/settings', 'blokki_wpgb_override_facet_settings_with_block' );
//
if(is_array( $facets_top) && !empty($facets_top)){
	foreach ( $facets_top as $facet_id ) {
		wpgb_render_facet( [ 'id' => (int) $facet_id, 'grid' => $grid_id ] );
	}
}


wpgb_render_grid( [
	'id' => $grid_id
] );
/**
 * Remove the filter added previously to override post query
 */
//add_filter( 'wp_grid_builder/grid/query_args', 'blokki_wpgb_override_grid_query_with_block');
//remove_filter( 'wp_grid_builder/grid/settings', 'blokki_wpgb_override_grid_settings_with_block' );


printf( '</div><!-- .wp-block-acf-blokki-grid-with-filters -->' );