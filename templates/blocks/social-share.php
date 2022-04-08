<?php
// to fix IDE crying for unset variable
$block           = $block ?? [];
$block_css_class = $block['className'] ?? 'wp-block-acf-blokki-social-share';
$block_classes   = [ $block_css_class ];

$share_text = get_field( 'share_text' );

if ( $share_text ) {
	$block_classes[] = 'has-share-text';
	/**
	 * Text location class
	 */
	$block_classes[] = get_field( 'is_text_first' ) ? 'text-first' : 'text-last';
}

global $wp;
$url     = urlencode( trailingslashit( home_url( $wp->request ) ) );
$title   = urlencode( get_the_title() );
$excerpt = urlencode( get_the_excerpt() );

$social_sharing = get_field( 'social_sharing', 'option' );

$icon_size            = apply_filters( 'blokki_block_social_share_icon_size_class', '' );
$icon_wrapper_classes = apply_filters( 'blokki_block_social_share_wrapper_classes', [ 'share-icons' ] );
$block_classes        = apply_filters( 'blokki_block_social_share_block_classes', $block_classes, $block );


/**
 * HTML Output
 */
printf( '<div class="%s">', implode( ' ', $block_classes ) );
if ( $share_text ) {
	printf( '<div class="share-text">%s</div>',
		$share_text
	);
}

printf( '<div class="%s">', implode( ' ', $icon_wrapper_classes ) );

if ( $social_sharing['facebook'] ?? false ):
	printf( '<a 	aria-label="%s" href="%s" data-network="facebook" class="facebook share-button" 
					  	rel="noopener" target="_blank"><i class="%s"></i></a>',
		esc_html__( 'Share this page on Facebook', 'blokki' ),
		'https://www.facebook.com/sharer/sharer.php?u=' . $url,
		$icon_size . ' ' . apply_filters( 'blokki_block_social_share_icon_classes_facebook', 'fab fa-facebook' )
	);
endif;

if ( $social_sharing['twitter'] ?? false ):
	printf( '<a 	aria-label="%s" href="%s" data-network="twitter" class="twitter share-button" 
					  	rel="noopener" target="_blank"><i class="%s"></i></a>',
		esc_html__( 'Share this page on Twitter', 'blokki' ),
		'https://twitter.com/intent/tweet?text=' . $title . '&url=' . $url,
		$icon_size . ' ' . apply_filters( 'blokki_block_social_share_icon_classes_twitter', 'fab fa-twitter' )
	);
endif;

if ( $social_sharing['linkedin'] ?? false ):
	printf( '<a 	aria-label="%s" href="%s" data-network="linkedin" class="linkedin share-button" 
					  	rel="noopener" target="_blank"><i class="%s"></i></a>',
		esc_html__( 'Share this page on LinkedIn', 'blokki' ),
		'http://www.linkedin.com/shareArticle?mini=true&title=' . $title . '&url=' . $url . '&summary=' . $excerpt,
		$icon_size . ' ' . apply_filters( 'blokki_block_social_share_icon_classes_linkedin', 'fab fa-linkedin' )
	);
endif;

if ( $social_sharing['email'] ?? false ):
	printf( '<a 	aria-label="%s" href="%s" data-network="email" class="email share-button" 
					  	rel="noopener" target="_blank"><i class="%s"></i></a>',
		esc_html__( 'Share this page via Email', 'blokki' ),
		'mailto:?subject=' . $title . '&body=' . $excerpt . '%0A' . $url,
		$icon_size . ' ' . apply_filters( 'blokki_block_social_share_icon_classes_email', 'fas fa-envelope' )
	);
endif;

printf( '</div><!-- .share-icons -->' );
printf( '</div><!-- .wp-block-acf-blokki-social-share -->' );