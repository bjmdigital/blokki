<?php
printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_excerpt', [ 'card-excerpt' ] ) )
);
do_action( 'blokki_block_cards_partial_before_excerpt' );
if ( apply_filters( 'blokki_block_cards_partial_render_excerpt', true ) ) {
	the_excerpt();
}
do_action( 'blokki_block_cards_partial_after_excerpt' );
printf( '</div>' );