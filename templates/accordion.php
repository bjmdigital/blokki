<?php
/**
 * Get Template Vars
 */
$block         = blokki_get_template_data( $block ?? [] );
$card_index    = blokki_get_template_data( $card_index ?? null, true );
$template_path = 'partials/accordion';

$post_type = get_post_type( get_the_ID() );

$post_type_config = blokki_get_post_type_config( $post_type, 'accordions' );

/**
 * Override post_type config with block level display options
 */
$post_type_config = blokki_override_post_type_config_with_block( $post_type_config, 'card_html_tag' );


/**
 * CSS Classes
 */
$css_classes   = [];
$css_classes[] = 'accordion-cell';
$css_classes[] = blokki_is_foundation_support() ? 'cell' : '';

if ( ! is_null( $card_index ) ) {
	$css_classes[] = 'card-index-' . intval( $card_index );
}


$css_classes = array_filter( $css_classes );
$css_classes = apply_filters( 'blokki_template_accordions_css_classes', $css_classes, $block, $card_index );

$card_inner_css_classes = [ 'card-inner' ];
$card_inner_css_classes = apply_filters( 'blokki_template_accordions_inner_css_classes', $card_inner_css_classes, $block );

//if we have not received the card_html_tag yet, make sure we have one
$card_html_tag = $post_type_config['card_html_tag'] ?? 'div';

/**
 * HTML Output
 */
printf( '<%s class="%s">',
	$card_html_tag,
	implode( ' ', get_post_class( implode( ' ', $css_classes ), get_the_ID() ) )

);

do_action( 'blokki_block_accordions_inner_content_before' );
// card-inner
printf( '<div class="%s">',
	implode( ' ', $card_inner_css_classes )
);
do_action( 'blokki_block_accordions_inner_content_start' );

blokki_render_partials( $template_path, $post_type_config['partials'], $post_type_config, $post_type );

do_action( 'blokki_block_accordions_inner_content_end' );

// end inner card
printf( '</div>' );
do_action( 'blokki_block_accordions_inner_content_after' );
// end block
printf( '</%s>', $card_html_tag );