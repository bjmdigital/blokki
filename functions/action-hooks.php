<?php


if ( ! function_exists( 'blokki_cards_add_class_featured_first' ) ) :

	function blokki_cards_add_class_featured_first( $card_classes, $block, $card_index ) {


		if ( ! $block || 0 !== $card_index ) {
			return $card_classes;
		}

		if (
			isset( $block['data'] )
			&& isset( $block['data']['feature_first'] )
			&& $block['data']['feature_first']
		) {
			$card_classes[] = 'featured-card';
		}

		return $card_classes;

	}

endif;

add_filter( 'blokki_template_card_css_classes', 'blokki_cards_add_class_featured_first', 10, 3 );

//
//add_filter( 'blokki_get_post_type_config_post', function ( $post_type_config ) {
//
//	return [
//		'show_title' => false,
//		'order' => [
//			'title'
//		]
//	];
//
//
//} );

add_filter( 'blokki_get_card_template_order_meta', function ( $meta_order ) {

	if ( 'page' === get_post_type( get_the_ID() ) ) {
		$meta_order = [
			'author',
			'date',
		];
	}


	return $meta_order;
} );

//add_action( 'blokki_block_cards_partial_title_before', function(){
//
//	if(223 !== get_the_ID()){
//		return;
//	}
//
//	echo 'This is post ID 223';
//
//} );

//add_filter( 'blokki_block_cards_partial_render_meta_author', function ( $render ) {
//	if ( has_post_thumbnail() ) {
//		$render = false;
//	}
//
//	return $render;
//} );

add_filter( 'blokki_block_cards_partial_meta_date_format', function ( $date_format ) {
	if ( has_post_thumbnail() ) {
		$date_format = 'Y-M-j';
	}

	return $date_format;
} );