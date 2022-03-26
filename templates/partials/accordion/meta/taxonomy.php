<?php

$post_type_config = blokki_get_template_post_type_config( $post_type_config ?? [] );

$taxonomy       = $post_type_config['taxonomy'] ?? '';
$terms_has_link = (bool) $post_type_config['taxonomy_link'] ?? false;

if ( ! $taxonomy ) {
	return;
}

$partial_wrapper_classes = apply_filters( 'blokki_block_cards_partial_classes_meta_taxonomy',
	[
		'card-meta-taxonomy',
	]
);


printf( '<div class="%s">',
	implode( ' ', $partial_wrapper_classes )
);
do_action( 'blokki_block_cards_partial_before_meta_taxonomy' );

if ( apply_filters( 'blokki_block_cards_partial_render_meta_taxonomy', true ) ) {

	echo blokki_get_taxonomy_terms_markup( $taxonomy, $terms_has_link );

}
do_action( 'blokki_block_cards_partial_after_meta_taxonomy' );
printf( '</div>' );