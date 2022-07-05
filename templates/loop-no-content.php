<?php
// to fix IDE crying for unset variable
$loop = $loap ?? new stdClass;

do_action( 'blokki_loop_no_content_before', $loop );
if ( apply_filters( 'blokki_loop_no_content_render_default', true ) ) {
	echo esc_html__( 'No Cards found matching your query', 'blokki' );
}
do_action( 'blokki_loop_no_content_after', $loop );