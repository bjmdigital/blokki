<?php
/**
 * Get Template Vars
 */
$block         = blokki_get_template_data( $block ?? [] );
$card_index    = blokki_get_template_data( $card_index ?? null, true );
$template_path = 'partials/accordion';

$post_type = get_post_type( get_the_ID() );

$post_type_config = blokki_get_post_type_config( $post_type, 'accordions' );

/**
 * Override post_type config with block level display options
 */
$post_type_config = blokki_override_post_type_config_with_block( $post_type_config, 'card_html_tag' );


/*
 * Get template order and fallback to default, in case of mess-up by any filter
 */
$partials = $post_type_config['partials'];


/**
 * CSS Classes
 */
$css_classes   = [];
$css_classes[] = 'cell accordion-item';

if ( ! is_null( $card_index ) ) {
	$css_classes[] = 'card-index-' . intval( $card_index );
}


$css_classes = array_filter( $css_classes );
$css_classes = apply_filters( 'blokki_template_accordions_css_classes', $css_classes, $block, $card_index );

$card_inner_css_classes = [ 'card-inner' ];
$card_inner_css_classes = apply_filters( 'blokki_template_accordions_inner_css_classes', $card_inner_css_classes, $block );

//if we have not received the card_html_tag yet, make sure we have one
$card_html_tag = $post_type_config['card_html_tag'] ?? 'div';

/**
 * HTML Output
 */
printf( '<%s class="%s">',
	$card_html_tag,
	implode( ' ', get_post_class( implode( ' ', $css_classes ), get_the_ID() ) )

);

do_action( 'blokki_block_accordions_inner_content_before' );
// card-inner
printf( '<div class="%s">',
	implode( ' ', $card_inner_css_classes )

);
do_action( 'blokki_block_accordions_inner_content_start' );
?>
<!--
	<ul aria-label="Accordion group - Dad Jokes" class="accordion-group">
		<li class="accordion-item">
			<button id="accordion-button-1" aria-controls="accordion-content-1" class="accordion-button" aria-expanded="false"><span class="indicator"></span>What did the pirate say when he turned 80?</button>
			<div id="accordion-content-1" class="accordion-content" aria-hidden="true">"Aye matey."</div>
		</li>
		<li class="accordion-item">
			<button id="accordion-button-2" aria-controls="accordion-content-2" class="accordion-button" aria-expanded="false">Have you heard of the band 1023MB?</button>
			<div id="accordion-content-2" class="accordion-content" aria-hidden="true">They haven't got a gig yet.</div>
		</li>
		<li class="accordion-item">
			<button id="accordion-button-3" aria-controls="accordion-content-3" class="accordion-button" aria-expanded="false">How do you throw a space party?</button>
			<div id="accordion-content-3" class="accordion-content" aria-hidden="true">You planet!</div>
		</li>
		<li class="accordion-item">
			<button id="accordion-button-4" aria-controls="accordion-content-4" class="accordion-button" aria-expanded="false">Want to hear a joke about construction?</button>
			<div id="accordion-content-4" class="accordion-content" aria-hidden="true">I'm still working on it...</div>
		</li>
		<li class="accordion-item">
			<button id="accordion-button-5" aria-controls="accordion-content-5" class="accordion-button" aria-expanded="false">Why did the chicken go to the séance?</button>
			<div id="accordion-content-5" class="accordion-content" aria-hidden="true">To get to the other side.</div>
		</li>
	</ul>
-->
<?php

blokki_render_partials( $template_path, $partials, $post_type_config, $post_type );

do_action( 'blokki_block_accordions_inner_content_end' );

// end inner card
printf( '</div>' );
do_action( 'blokki_block_accordions_inner_content_after' );
// end block
printf( '</%s>', $card_html_tag );