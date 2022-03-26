<?php

$date_format = apply_filters( 'blokki_block_cards_partial_meta_date_format', '' );

printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_meta_date', [ 'card-meta-date' ] ) )
);
do_action( 'blokki_block_cards_partial_before_meta_date' );

if ( apply_filters( 'blokki_block_cards_partial_render_meta_date', true ) ) {

	echo get_the_date( $date_format );
}
do_action( 'blokki_block_cards_partial_after_meta_date' );
printf( '</div>' );
