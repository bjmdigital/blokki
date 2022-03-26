<?php
/**
 * Get Template Vars
 */
$block                 = blokki_get_template_data( $block ?? [] );
$card_index            = blokki_get_template_data( $card_index ?? null, true );
$cards_display_options = blokki_get_card_display_options();

$post_type = get_post_type( get_the_ID() );

$post_type_config = blokki_get_post_type_config( $post_type );
/**
 * Override post_type config with block level display options
 */
$post_type_config = wp_parse_args( $cards_display_options, $post_type_config );

/*
 * Get template order and fallback to default, in case of mess-up by any filter
 */
$template_order = $post_type_config['order'];
if ( ! $template_order || empty( $template_order ) ) {
	$template_order = blokki_get_card_template_order_default();
}

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

$template_path = 'partials/card';
/**
 * HTML Output
 */
printf( '<div class="%s"><div class="card-inner">',
	implode( ' ', get_post_class( implode( ' ', $css_classes ), get_the_ID() ) )
);

/**
 * Magic here
 */

blokki_render_templates( $template_path, $template_order, $post_type_config, $post_type );


//// $template_order
//// $post_type_config
//// $post_type
//
//foreach ( $template_order as $key => $template ):
//
//
//	$template_slug = '';
//
//	if ( is_string( $template ) ) {
//		$template_slug = $template;
//	} elseif ( is_array( $template ) ) {
//		$template_slug = $key;
//	}
//
//	if ( ! $template_slug ) {
//		continue;
//	}
//
//	$show_template = isset( $post_type_config["show_{$template_slug}"] ) && $post_type_config["show_{$template_slug}"];
//
//	if ( ! $show_template ) {
//		continue;
//	}
//
//	blokki_loader()->set_template_data( $post_type_config, 'post_type_config' )
//	               ->get_template_part( "partials/card/{$template_slug}", $post_type );
//
//
//endforeach;


//foreach ( $post_type_config as $config_item => $value ):
//
//
//	if ( 0 !== strpos( $config_item, 'show' ) ) {
//		continue;
//	}
//
//	$template = str_replace( 'show_', '', $config_item );
//
//
//	blokki_loader()->get_template_part( "partials/card/{$template}", $post_type );
//
//endforeach;

printf( '</div></div><!-- post_class -->' );