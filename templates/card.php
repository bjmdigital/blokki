<?php

global $post;
$block = $block ?? [];

$css_classes   = [];
$css_classes[] = 'cell';
$css_classes   = apply_filters( 'blokki_template_card_css_classes', $css_classes );

/**
 * HTML Output
 */
printf( '<div class="%s">',
	implode( ' ', get_post_class( implode( ' ', $css_classes ), get_the_ID() ) )
);


echo 'This is Card Template in Plugin';

printf( '</div><!-- post_class -->' );