<?php


if ( ! has_post_thumbnail() ) {
	return;
}
$post_type_config = blokki_get_template_post_type_config( $post_type_config ?? [] );

$image_size = $post_type_config['image_size'] ?? '';

printf( '<div class="%s">',
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_image', [ 'card-image' ] ) )
);
do_action( 'blokki_block_cards_partial_before_image' );
if ( apply_filters( 'blokki_block_cards_partial_render_image', true ) ) {
	if ( $post_type_config['link_image'] && is_post_publicly_viewable() && ! is_admin() ) {
		printf( '<a href="%s" target="%s" title="%s">%s</a>',
			get_the_permalink(),
			$post_type_config['link_target'],
			blokki_get_post_link_title( get_the_ID() ),
			get_the_post_thumbnail( get_the_ID(), $image_size )
		);
	} else {
		the_post_thumbnail();
	}

}

do_action( 'blokki_block_cards_partial_after_image' );
printf( '</div>' );


