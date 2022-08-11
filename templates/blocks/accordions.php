<?php
// to fix IDE crying for unset variable
$block           = $block ?? [];
$block_classname = blokki_acf_get_block_classname( $block, 'wp-block-acf-blokki-accordions' );

/**
 * Build Grid CSS Classes
 */
$grid_classes   = [ 'blokki-grid', 'accordions-grid' ];
$grid_classes[] = blokki_is_foundation_support() ? 'grid-x' : '';

/**
 * Update $grid_classes with layout classes
 */
$grid_classes = array_merge( $grid_classes, blokki_get_grid_layout_classes() );

/**
 * Create Loop
 */
$post_query_args = blokki_get_posts_query_for_block();


$loop = new WP_Query( $post_query_args );
$loop = apply_filters( 'blokki_block_accordions_loop', $loop );

/**
 * Setup template to use for loop
 */
$template     = 'accordion';
$grid_classes = apply_filters( 'blokki_block_accordions_grid_classes', $grid_classes, $block );

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

printf( '</div><!-- .accordions-grid -->' );
printf( '</div><!-- .wp-block-acf-blokki-accordions -->' );