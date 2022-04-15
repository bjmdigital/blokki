<?php
printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_content', [ 'post-content' ] ) )
);
do_action( 'blokki_block_cards_partial_before_content' );
if ( apply_filters( 'blokki_block_cards_partial_render_content', true ) ) {
	the_content();
}
do_action( 'blokki_block_cards_partial_after_content' );
printf( '</div>' );