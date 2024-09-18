<?php
/**
 * Get Template Vars
 */
$block                 = blokki_get_template_data( $block ?? array() );
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


$partials = $post_type_config['partials'];

/**
 * CSS Classes
 */
$css_classes = array( 'blokki-card' );

$css_classes[] = blokki_is_foundation_support() ? 'cell' : '';

if ( ! is_null( $card_index ) ) {
	$css_classes[] = 'card-index-' . intval( $card_index );
}


$css_classes = array_filter( $css_classes );
$css_classes = apply_filters( 'blokki_template_card_css_classes', $css_classes, $block, $card_index );

$card_inner_css_classes = array( 'card-inner' );
$card_inner_css_classes = apply_filters( 'blokki_template_card_inner_css_classes', $card_inner_css_classes, $block );

// if we have not received the card_html_tag yet, make sure we have one
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
printf(
	'<%s class="%s">',
	$card_html_tag,
	implode( ' ', get_post_class( implode( ' ', $css_classes ), get_the_ID() ) )
);

if ( $link_card && ! is_admin() ) {
	printf(
		'<a aria-label="%s" class="link-card-cover" title="%s" href="%s" target="%s"></a>',
		wp_strip_all_tags( get_the_title() ),
        blokki_get_post_link_title(),
		get_the_permalink(),
		$post_type_config['link_target'] ?? '_self'
	);
}

do_action( 'blokki_block_cards_inner_content_before' );
// card-inner
printf(
	'<div class="%s">',
	implode( ' ', $card_inner_css_classes )
);
do_action( 'blokki_block_cards_inner_content_start' );
/**
 * Magic here
 */

$block_id = $block['id'] ?? '';

$show_inner = $post_type_config['show_inner'] ?? false;

if ( ! $show_inner ) {
	// if we do not need to wrap in inner-content, then we can just output everything
	blokki_render_partials( $template_path, $post_type_config['partials'], $post_type_config, $post_type );
} else {
	/**
	 * First, lets try to find, image in partials order
	 */
	$image_position = array_search( 'image', $post_type_config['partials'] );

	// default value for image position
	$image_first    = ( 0 === $image_position );
	$card_has_image = ( false !== $image_position );

	// Unset the `image` from partials
	if ( $card_has_image ) {
		unset( $post_type_config['partials'][ $image_position ] );
	}

	// if image is first, out image partial
	if ( $image_first ) {
		blokki_render_partials( $template_path, array( 'image' ), $post_type_config, $post_type );
	}

	// rest of the partials except image
	blokki_render_partials( $template_path, array( 'inner' ), $post_type_config, $post_type );

}

do_action( 'blokki_block_cards_inner_content_end' );

// end inner card
printf( '</div>' );
do_action( 'blokki_block_cards_inner_content_after' );
// end block
printf( '</%s>', $card_html_tag );
