<?php

namespace Blokki;

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
use YahnisElsts\PluginUpdateChecker\v5p0\Vcs\GitHubApi;

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Blokki\Updater' ) ) {
	return;
}


/**
 * This class deals with Plugin Auto Update functionality
 *
 * @since 1.0.4
 * @package    Blokki
 * @subpackage Blokki/includes
 */
class Updater {

	/**
	 * Initialize the class and set its properties.
	 * @since    1.0.4
	 */
	public function __construct() {

		$this->init_updater();

	}

	/**
	 * Register required hooks
	 */
	public function init_updater() {


		$update_checker = PucFactory::buildUpdateChecker(
			BLOKKI_GITHUB_REPO_URL,
			BLOKKI_PLUGIN_FILE,
			BLOKKI_PLUGIN_NAME
		);

		//Don't look for a "Stable tag" header in readme.txt.
		$update_checker->addFilter( 'vcs_update_detection_strategies', function ( $strategies ) {
			unset( $strategies[ GitHubApi::STRATEGY_STABLE_TAG ] );

			return $strategies;
		} );

		//Optional: If you're using a private repository, specify the access token like this:
//		$update_checker->setAuthentication( '' );

		$update_checker->getVcsApi()->enableReleaseAssets();

	}

}