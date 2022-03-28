<?php

$post_type_config = blokki_get_template_post_type_config( $post_type_config ?? [] );

$partials = $post_type_config['partials']['title-container']
            ?? blokki_get_block_partials_default( 'accordions' )['title-container'];

$template_path = 'partials/accordion';

//printf( '<div class="%s">',
//	implode( ' ', apply_filters( 'blokki_block_accordions_partial_classes_title_container', [ 'title-container' ] ) )
//);
global $post;
printf('<button id="accordion-button-%1$s" aria-controls="accordion-content-%1$s" class="accordion-button" aria-expanded="false">',
	get_the_ID()
);


do_action( 'blokki_block_accordions_partial_before_title_container' );

if ( apply_filters( 'blokki_block_accordions_partial_render_title_container', true ) ) {
	blokki_render_partials( $template_path, $partials, $post_type_config );
}


do_action( 'blokki_block_accordions_partial_after_title_container' );

printf( '<span class="indicator"></span></button>');
//printf( '</div>' );

