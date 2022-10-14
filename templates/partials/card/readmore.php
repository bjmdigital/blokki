<?php

$readmore_label = apply_filters( 'blokki_block_cards_partial_readmore_label', __( 'Read more', 'blokki' ) );

$custom_readmore_label = apply_filters( 'blokki_block_cards_partial_readmore_label_custom', '' );

$post_type_config = blokki_get_template_post_type_config( $post_type_config ?? [] );
$link_target      = $post_type_config['link_target'] ?? '_self';
$link_target      = apply_filters( 'blokki_block_cards_partial_readmore_target', $link_target );

printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_readmore', [ 'card-readmore' ] ) )
);
do_action( 'blokki_block_cards_partial_before_readmore' );
if ( apply_filters( 'blokki_block_cards_partial_render_readmore', true ) ) {
	printf( '<a href="%s" class="%s" title="%s" target="%s" %s>%s</a>',
		get_the_permalink(),
		implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_readmore_link', [ 'card-readmore-link' ] ) ),
		$custom_readmore_label ?: blokki_get_post_link_title(),
		$link_target,
		blokki_get_skip_tab_index( $post_type_config['link_card'] || $post_type_config['readmore_skip_tab'] ),
		$custom_readmore_label ?: $readmore_label
	);
}
do_action( 'blokki_block_cards_partial_after_readmore' );
printf( '</div>' );
