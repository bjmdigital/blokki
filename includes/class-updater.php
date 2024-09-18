<?php

namespace Blokki;

use YahnisElsts\PluginUpdateChecker\v5p4\Vcs\PluginUpdateChecker;
use YahnisElsts\PluginUpdateChecker\v5p4\Vcs\GitHubApi;

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


		$githubApiInstance = new GitHubApi(
			BLOKKI_GITHUB_REPO_URL
		);

		//Enable update via release assets.;
		$githubApiInstance->enableReleaseAssets();

		$updateChecker = new PluginUpdateChecker(
			$githubApiInstance,
			BLOKKI_PLUGIN_FILE,
			BLOKKI_PLUGIN_NAME
		);


		//Don't look for a "Stable tag" header in readme.txt.
		$updateChecker->addFilter( 'vcs_update_detection_strategies', function ( $strategies ) {
			unset( $strategies[ GitHubApi::STRATEGY_STABLE_TAG ] );

			return $strategies;
		} );


	}

}
