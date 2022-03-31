<?php

$post_type_config = blokki_get_template_post_type_config( $post_type_config ?? [] );

$partials = $post_type_config['partials']['accordion-button']
            ?? blokki_get_block_partials_default( 'accordions' )['accordion-button'];

$template_path = 'partials/accordion';

global $post;
printf( '<button id="%1$s" aria-controls="accordion-content-%2$s" class="accordion-button" aria-expanded="false">',
	$post->post_name,
	get_the_ID()
);


do_action( 'blokki_block_accordions_partial_before_accordion_button' );

if ( apply_filters( 'blokki_block_accordions_partial_render_accordion_button', true ) ) {
	blokki_render_partials( $template_path, $partials, $post_type_config );
}
do_action( 'blokki_block_accordions_partial_after_accordion_button_title' );

blokki_render_partials( $template_path, [ 'accordion-icons' ], $post_type_config );

do_action( 'blokki_block_accordions_partial_after_accordion_button' );


printf( '</button>' );

