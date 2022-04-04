<?php
// to fix IDE crying for unset variable
$block           = $block ?? [];
$block_css_class = $block['className'] ?? 'wp-block-acf-blokki-grid-with-filters';
$block_classes   = [ $block_css_class ];

$block_classes   = apply_filters( 'blokki_block_grid_with_filters_block_classes', $block_classes, $block );


$grid_id = get_field( 'grid_id' ) ?? 3;

/**
 * HTML Output
 */
printf( '<div class="%s">', implode( ' ', $block_classes ) );


add_filter( 'wp_grid_builder/grid/settings', 'blokki_wpgb_override_posts_query_with_block' );

wpgb_render_grid( [
	'id' => $grid_id
] );

remove_filter( 'wp_grid_builder/grid/settings', 'blokki_wpgb_override_posts_query_with_block' );
//blokki_wpgb_reset_grid_data($grid_id);


//Grid Loop template
//blokki_loader()->set_template_data( $loop, 'loop' )
//               ->set_template_data( $template, 'template' )
//               ->set_template_data( $block, 'block' )
//               ->get_template_part( 'loop' );

printf( '</div><!-- .wp-block-acf-blokki-grid-with-filters -->' );