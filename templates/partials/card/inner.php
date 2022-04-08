<?php

$post_type_config = blokki_get_template_post_type_config( $post_type_config ?? [] );

$partials  = $post_type_config['partials'] ?? blokki_get_card_partials_inner();
$partials  = isset( $partials['inner'] ) ? $partials['inner'] : $partials;
$post_type = get_post_type( get_the_ID() );

$template_path = 'partials/card';

printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_inner', [ 'card-inner-content' ] ) )
);

do_action( 'blokki_block_cards_partial_before_inner' );

if ( apply_filters( 'blokki_block_cards_partial_render_inner', true ) ) {
	blokki_render_partials( $template_path, $partials, $post_type_config, $post_type );
}


do_action( 'blokki_block_cards_partial_after_inner' );

printf( '</div>' );

