<?php

printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_meta_author', [ 'card-author' ] ) )
);
do_action( 'blokki_block_cards_partial_before_meta_author' );

if ( apply_filters( 'blokki_block_cards_partial_render_meta_author', true ) ) {
	the_author();
}
do_action( 'blokki_block_cards_partial_after_meta_author' );
printf( '</div>' );

