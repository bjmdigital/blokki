<div class="blokki-cards-wrapper align<?php echo $block['align']; ?>">
<?php

$post_query_args = blokki_get_posts_query_from_block($block);

$loop = new WP_Query( $post_query_args );

if ( $loop->have_posts() ) :
	while ( $loop->have_posts() ) :
		$loop->the_post();
		// Code Here
		blokki_get_template( 'card.php');
	endwhile;
endif;