<?php


$title_html_tag = get_field( 'title_html_tag' ) ?? 'h3';
$title_html_tag = apply_filters( 'blokki_block_cards_partial_title_html_tag', $title_html_tag );
if ( is_array( $title_html_tag ) ) {
	$title_html_tag = array_pop( $title_html_tag );
}

printf( '<%s class="%s">',
	$title_html_tag,
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_title', [ 'card-title', 'title' ] ) )
);
do_action( 'blokki_block_cards_partial_before_title' );
if ( apply_filters( 'blokki_block_cards_partial_render_title', true ) ) {
	the_title();
}

do_action( 'blokki_block_cards_partial_after_title' );
printf( '</%s>', $title_html_tag );