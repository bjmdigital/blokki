<?php

$post_type_config = blokki_get_template_post_type_config( $post_type_config ?? [] );

//if we have not received the card_html_tag yet, make sure we have one
$post_type_config = blokki_override_post_type_config_with_block( $post_type_config, 'title_html_tag' );

$title_html_tag = apply_filters(
	'blokki_block_cards_partial_title_html_tag',
	$post_type_config['title_html_tag'] ?? 'h3',
);

printf( '<%s class="%s">',
	$title_html_tag,
	implode( ' ', apply_filters( 'blokki_block_cards_partial_classes_title', [ 'card-title', 'title' ] ) )
);
do_action( 'blokki_block_cards_partial_before_title' );
if ( apply_filters( 'blokki_block_cards_partial_render_title', true ) ) {
	blokki_render_post_title(get_the_ID(), $post_type_config['link_title'], $post_type_config['link_target']);
}

do_action( 'blokki_block_cards_partial_after_title' );
printf( '</%s>', $title_html_tag );