<?php
namespace Blokki;
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://bjmdigital.com.au/
 * @since      1.0.0
 *
 * @package    Blokki
 * @subpackage Blokki/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Blokki
 * @subpackage Blokki/includes
 * @author     BJM Team <developers@bjmdigital.com.au>
 */
class i18N {
	/** @noinspection SpellCheckingInspection */


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'blokki',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}


}
