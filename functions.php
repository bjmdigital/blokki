<?php

require_once 'functions/core-functions.php';
require_once 'functions/card-functions.php';
require_once 'functions/helper-functions.php';

/**
 * For Testing Things
 */
require_once 'functions/action-hooks.php';

/**
 * Integrations
 */
require_once 'integrations/wp-grid-builder.php';
require_once 'integrations/micro-modal.php';


function blokki_enqueue_video_player_apis() {
    wp_enqueue_script( 'vimeo-player-api', 'https://player.vimeo.com/api/player.js', array(), null, true );
    wp_enqueue_script( 'youtube-iframe-api', 'https://www.youtube.com/iframe_api', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'blokki_enqueue_video_player_apis' );