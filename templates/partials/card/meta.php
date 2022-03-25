<?php

$post_type_config = blokki_get_template_data( $post_type_config ?? [] );

$template_order = $post_type_config['order']['meta'] ?? blokki_get_card_template_order_meta();

$post_type = get_post_type( get_the_ID() );

$template_path = 'partials/card/meta';

echo '<div style="background-color: #7ad03a">';

blokki_render_templates( $template_path, $template_order, $post_type_config, $post_type );

echo '</div>';