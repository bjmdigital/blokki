<?php

function blokki_micro_modal_markup(){

	Blokki()->template_loader->get_template_part( 'partials/modal-video');
	
}

add_action('wp_footer', 'blokki_micro_modal_markup');