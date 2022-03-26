<?php
printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_accordions_partial_classes_content', [ 'card-content' ] ) )
);
do_action( 'blokki_block_accordions_partial_before_content' );
if ( apply_filters( 'blokki_block_accordions_partial_render_content', true ) ) {
	the_content();
}
do_action( 'blokki_block_accordions_partial_after_content' );
printf( '</div>' );