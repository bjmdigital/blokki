<?php

if ( ! isset( $loop ) ) {
	echo esc_html__( 'Please provide `loop` variable for loop template', 'blokki' );

	return;
}

if ( ! isset( $block ) ) {
	echo esc_html__( 'Please provide `block` variable for loop template', 'blokki' );

	return;
}

if ( ! isset( $template ) ) {
	echo esc_html__( 'Please provide `template` variable for loop template', 'blokki' );

	return;
}
$template = blokki_to_string( $template );

if ( $loop->have_posts() ) :
	do_action( 'blokki_template_posts_loop_before', $loop, $block );
	$card_index = 0;
	while ( $loop->have_posts() ) : $loop->the_post();
		blokki_loader()->set_template_data( $block, 'block' )
		               ->set_template_data( $card_index, 'card_index' )
		               ->get_template_part( $template, get_post_type( get_the_ID() ) );
		$card_index ++;

	endwhile;
	do_action( 'blokki_template_posts_loop_after', $loop, $block );
else:

	blokki_loader()->set_template_data( $loop, 'loop' )
	               ->get_template_part( 'loop', 'no-content' );

endif;