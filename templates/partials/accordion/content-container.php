<?php

$post_type_config = blokki_get_template_post_type_config( $post_type_config ?? [] );

$partials = $post_type_config['partials']['content-container']
            ?? blokki_get_block_partials_default( 'accordions' )['content-container'];

$template_path = 'partials/accordion';

printf( '<div id="accordion-content-%s" class="%s" aria-hidden="true">',
	get_the_ID(),
	implode( ' ', apply_filters( 'blokki_block_accordions_partial_classes_content_container', [
		'content-container',
		'accordion-content'
	] ) )
);

do_action( 'blokki_block_accordions_partial_before_content_container' );

if ( apply_filters( 'blokki_block_accordions_partial_render_content_container', true ) ) {
	blokki_render_partials( $template_path, $partials, $post_type_config );
}


do_action( 'blokki_block_accordions_partial_after_content_container' );

printf( '</div>' );

