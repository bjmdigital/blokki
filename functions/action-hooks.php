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

add_filter( 'blokki_get_card_partials_meta', function ( $meta_order ) {

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

//add_filter( 'blokki_block_cards_partial_meta_date_format', function ( $date_format ) {
//	if ( has_post_thumbnail() ) {
//		$date_format = 'Y-M-j';
//	}
//
//	return $date_format;
//} );


add_filter( 'blokki_get_post_type_config_bjm_glossary', function ( $post_type_config ) {

	$post_type_config = [
		'taxonomy'      => 'bjm_loan_cat',
		'taxonomy_link' => true,
		'show_date'     => false
	];


	return $post_type_config;

} );

add_filter( 'blokki_get_post_type_config_post', function ( $post_type_config ) {

	$post_type_config = [
		'taxonomy'   => 'category',
//		'taxonomy_link' => false,
//		'show_date'     => true,
//		'show_meta'  => false,
		'show_inner' => true,
		'image_size' => '',
////		'link_target'   => '_blank',
//		'link_card'     => true,
//		'link_image'    => true,
//		'link_title'    => true,
//		'show_readmore' => true,
//		'show_taxonomy' => true,
//		'title_html_tag' => 'h4',
		'partials'   => [
			'image',
			'excerpt',
			'meta' => [
				'date'
			],
			'title',
			'readmore',
//			'inner' => [
//				'title',
//				'meta' => [
//					'date'
//				],
//				'excerpt',
//				'readmore'
//			]
		]

	];


	return $post_type_config;

} );

add_filter( 'blokki_get_post_type_config_bjm_faq', function ( $post_type_config ) {

	$post_type_config = [
		'taxonomy' => 'bjm_faq_cat',
		'partials' => [
			'title-container'   => [
				'title'
			],
			'content-container' => [
				'content',
				'ullu-bata'
			]
		]
	];


	return $post_type_config;

} );

//add_action( 'blokki_block_cards_partial_before_image', function () {
//
//	if ( 'post' !== get_post_type() ) {
//		return null;
//	}
//
//	echo 'Hey before image';
//
//
//} );


add_action( 'blokki_block_cards_partial_after_image', function () {

	if ( 'post' !== get_post_type() ) {
		return null;
	}

	echo blokki_get_taxonomy_terms_markup( 'category' );


} );

//
//add_filter( 'blokki_get_post_type_config_default', function ( $default_config ) {
//
//	$default_config['card_html_tag'] = 'article';
//
//	return $default_config;
//
//} );
