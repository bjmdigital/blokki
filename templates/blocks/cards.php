<?php
// to fix IDE crying for unset variable
$block           = $block ?? [];
$block_css_class = $block['className'] ?? 'wp-block-acf-blokki-cards';
$block_classes   = [ $block_css_class ];
/**
 * Build Grid CSS Classes
 */
$grid_classes = [ 'grid-x', 'cards-grid' ];

/**
 * Parse Block Options
 */
// TODO move to a separate function
$cards_small_up  = get_field( 'small_up' ) ?? 1;
$cards_medium_up = get_field( 'medium_up' ) ?? 2;
$cards_large_up  = get_field( 'large_up' ) ?? 3;
$feature_first   = get_field( 'feature_first' ) ?? false;
$grid_margin_x   = get_field( 'grid_margin_x' ) ?? false;
$grid_margin_y   = get_field( 'grid_margin_y' ) ?? false;

/**
 * Update Grid Classes with Card options
 */
$grid_classes[] = 'small-up-' . $cards_small_up;
$grid_classes[] = 'medium-up-' . $cards_medium_up;
$grid_classes[] = 'large-up-' . $cards_large_up;
$grid_classes[] = $feature_first ? 'feature-first' : '';
$grid_classes[] = $grid_margin_x ? 'grid-margin-x' : '';
$grid_classes[] = $grid_margin_y ? 'grid-margin-y' : '';

/**
 * Card Display Options
 */
$cards_display_options = blokki_get_card_display_options();


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
$block_classes = apply_filters( 'blokki_block_cards_block_classes', $block_classes, $block );
// Remove empty values
$grid_classes = array_filter( $grid_classes );
$grid_classes = apply_filters( 'blokki_block_cards_grid_classes', $grid_classes, $block );

/**
 * HTML Output
 */
printf( '<div class="%s">', implode( ' ', $block_classes ) );

// Heading and Link
blokki_loader()->set_template_data( $block, 'block' )
               ->get_template_part( 'partials/header-info', 'cards' );

// Grid Wrapper
printf( '<div class="%s">', implode( ' ', $grid_classes ) );

//Grid Loop
blokki_loader()->set_template_data( $loop, 'loop' )
               ->set_template_data( $template, 'template' )
               ->set_template_data( $block, 'block' )
               ->set_template_data( $cards_display_options, 'cards_display_options' )
               ->get_template_part( 'loop' );

printf( '</div><!-- .cards-grid -->' );
printf( '</div><!-- .wp-block-acf-blokki-cards -->' );