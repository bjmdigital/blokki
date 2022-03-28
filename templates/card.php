<?php
/**
 * Get Template Vars
 */
$block                 = blokki_get_template_data( $block ?? [] );
$card_index            = blokki_get_template_data( $card_index ?? null, true );
$cards_display_options = blokki_get_block_display_options();
$template_path         = 'partials/card';

$post_type = get_post_type( get_the_ID() );

$post_type_config = blokki_get_post_type_config( $post_type );

/**
 * Override post_type config with block level display options
 */
$post_type_config = wp_parse_args( $cards_display_options, $post_type_config );
$post_type_config = blokki_override_post_type_config_with_block( $post_type_config, 'card_html_tag' );


/*
 * Get template order and fallback to default, in case of mess-up by any filter
 */
$partials = $post_type_config['partials'];

/**
 * CSS Classes
 */
$css_classes   = [];
$css_classes[] = 'cell';

if ( ! is_null( $card_index ) ) {
	$css_classes[] = 'card-index-' . intval( $card_index );
}


$css_classes = array_filter( $css_classes );
$css_classes = apply_filters( 'blokki_template_card_css_classes', $css_classes, $block, $card_index );

$card_inner_css_classes = [ 'card-inner' ];
$card_inner_css_classes = apply_filters( 'blokki_template_card_inner_css_classes', $card_inner_css_classes, $block );

//if we have not received the card_html_tag yet, make sure we have one
$card_html_tag = $post_type_config['card_html_tag'] ?? 'div';

/**
 * Card Link
 */
$link_card = ( ( $post_type_config['link_card'] ?? false ) && ( is_post_publicly_viewable() ) );

if ( $link_card ) {
	$css_classes[] = 'link-card';
}

/**
 * HTML Output
 */
printf( '<%s class="%s">',
	$card_html_tag,
	implode( ' ', get_post_class( implode( ' ', $css_classes ), get_the_ID() ) )

);
if ( $link_card && ! is_admin() ) {
	printf( '<a aria-label="%s" class="link-card-cover" title="%s" href="%s" target="%s"></a>',
		get_the_title(),
		blokki_get_post_link_title(),
		get_the_permalink(),
		$post_type_config['link_target'] ?? '_self'
	);
}

do_action( 'blokki_block_cards_inner_content_before' );
// card-inner
printf( '<div class="%s">',
	implode( ' ', $card_inner_css_classes )

);
do_action( 'blokki_block_cards_inner_content_start' );
/**
 * Magic here
 */

blokki_render_partials( $template_path, $partials, $post_type_config, $post_type );

do_action( 'blokki_block_cards_inner_content_end' );

// end inner card
printf( '</div>' );
do_action( 'blokki_block_cards_inner_content_after' );
// end block
printf( '</%s>', $card_html_tag );