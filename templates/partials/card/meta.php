<?php

$post_type_config = blokki_get_template_post_type_config( $post_type_config ?? [] );

$partials = $post_type_config['partials']['inner']['meta'] ?? [];
if ( empty( $partials ) ) {
	$partials = $post_type_config['partials']['meta'] ?? blokki_get_card_partials_meta();
}

$post_type = get_post_type( get_the_ID() );

$template_path = 'partials/card/meta';

printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_meta', [ 'card-meta' ] ) )
);

do_action( 'blokki_block_cards_partial_before_meta' );

if ( apply_filters( 'blokki_block_cards_partial_render_meta', true ) ) {
	blokki_render_partials( $template_path, $partials, $post_type_config, $post_type );
}


do_action( 'blokki_block_cards_partial_after_meta' );

printf( '</div>' );

