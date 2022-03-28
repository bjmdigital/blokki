<?php
// to fix IDE crying for unset variable
$block           = $block ?? [];
$block_css_class = $block['className'] ?? 'wp-block-acf-blokki-accordions';
$block_classes   = [ $block_css_class ];
/**
 * Build Grid CSS Classes
 */
$grid_classes = [ 'grid-x', 'accordions-grid', 'accordion-group' ];

/**
 * Update $grid_classes with layout classes
 */
$grid_classes = array_merge( $grid_classes, blokki_get_cards_layout_classes() );

/**
 * Create Loop
 */
$post_query_args = blokki_get_posts_query_for_block();


$loop = new WP_Query( $post_query_args );
$loop = apply_filters( 'blokki_block_accordions_loop', $loop );

/**
 * Setup template to use for loop
 */
$template      = 'accordion';
$block_classes = apply_filters( 'blokki_block_accordions_block_classes', $block_classes, $block );
$grid_classes  = apply_filters( 'blokki_block_accordions_grid_classes', $grid_classes, $block );

/**
 * HTML Output
 */
printf( '<div class="%s">', implode( ' ', $block_classes ) );

// Heading and Link
blokki_loader()->set_template_data( $block, 'block' )
               ->get_template_part( 'partials/header-info', 'cards' );

// Grid Wrapper
printf( '<div class="%s">', implode( ' ', $grid_classes ) );

//Grid Loop template
blokki_loader()->set_template_data( $loop, 'loop' )
               ->set_template_data( $template, 'template' )
               ->set_template_data( $block, 'block' )
               ->get_template_part( 'loop' );

printf( '</div><!-- .accordions-grid -->' );
printf( '</div><!-- .wp-block-acf-blokki-accordions -->' );