<?php


if ( ! has_post_thumbnail() ) {
	return;
}

printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_image', [ 'card-image' ] ) )
);
do_action( 'blokki_block_cards_partial_before_image' );
if ( apply_filters( 'blokki_block_cards_partial_render_image', true ) ) {
	the_post_thumbnail();
}

do_action( 'blokki_block_cards_partial_after_image' );
printf( '</div>' );


