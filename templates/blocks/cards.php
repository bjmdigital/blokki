<?php
// to fix IDE crying for unset variable
$block           = $block ?? [];
$block_classname = blokki_acf_get_block_classname( $block, 'wp-block-acf-blokki-cards' );

/**
 * Build Grid CSS Classes
 */
$grid_classes = [ 'blokki-grid', 'cards-grid' ];

$grid_classes[] = blokki_is_foundation_support() ? "grid-x" : "";

/**
 * Update $grid_classes with layout classes
 */
$grid_classes = array_merge( $grid_classes, blokki_get_grid_layout_classes() );

/**
 * Create Loop
 */
$post_query_args = blokki_get_posts_query_for_block();


$loop = new WP_Query( $post_query_args );
$loop = apply_filters( 'blokki_block_cards_loop', $loop );

/**
 * Setup template to use for loop
 */
$template      = 'card';
$grid_classes  = apply_filters( 'blokki_block_cards_grid_classes', $grid_classes, $block );
$grid_classes  = array_filter( $grid_classes );
/**
 * HTML Output
 */
printf( '<div class="%s">', $block_classname );

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

printf( '</div><!-- .cards-grid -->' );
printf( '</div><!-- .wp-block-acf-blokki-cards -->' );