<?php

$readmore_label = apply_filters( 'blokki_block_cards_partial_readmore_label', __( 'Read more', 'blokki' ) );

printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_readmore', [ 'card-readmore' ] ) )
);
do_action( 'blokki_block_cards_partial_before_readmore' );
if ( apply_filters( 'blokki_block_cards_partial_render_readmore', true ) ) {
	printf( '<a href="%s" class="%s" title="%s" target="%s">%s</a>',
		get_the_permalink(),
		implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_readmore_link', [ 'card-readmore-link' ] ) ),
		$readmore_label . ' ' . esc_html__( 'about', 'blokki' ) . ' ' . get_the_title(),
		'_self',
		$readmore_label
	);
}
do_action( 'blokki_block_cards_partial_after_readmore' );
printf( '</div>' );
