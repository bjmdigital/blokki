<?php
// to fix IDE crying for unset variable
$block = $block ?? [];

/**
 * Build CSS Classes
 */
$css_classes   = [];
$css_classes[] = 'blokki-cards-grid';
$css_classes[] = 'grid-x';

/**
 * Parse Block Options
 */
$heading = get_field( 'heading') ?? '';
$add_view_all_link = get_field( 'add_view_all_link') ?? false;
$view_all_link_url = get_field( 'view_all_link_url ') ?? '';



$css_classes = apply_filters( 'blokki_block_cards_css_classes', $css_classes );

$post_query_args = blokki_get_posts_query_from_block( $block );

$loop = new WP_Query( $post_query_args );
$loop = apply_filters( 'blokki_block_cards_loop', $loop );

$template = 'card';

/**
 * HTML Output
 */
printf( '<div class="%s">', $block['className'] ?? 'wp-block-acf-blokki-cards' );

printf( '<div class="%s">', implode( ' ', $css_classes ) );

blokki_loader()->set_template_data( $loop, 'loop' )
               ->set_template_data( $template, 'template' )
               ->set_template_data( $block, 'block' )
               ->get_template_part( 'loop' );

printf( '</div><!-- .blokki-cards-grid -->' );
printf( '</div><!-- .wp-block-acf-blokki-cards -->' );