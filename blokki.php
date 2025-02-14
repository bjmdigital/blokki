<?php
/** @noinspection PhpUnused */

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bjmdigital.com.au/
 * @since             1.0.0
 * @package           Blokki
 *
 * @wordpress-plugin
 * Plugin Name:       Blokki
 * Plugin URI:        https://github.com/bjmdigital/blokki
 * Description:       Blocks functionality from BJM Team
 * Requires PHP:      7.0
 * Requires at least: 6.0
 * Tested up to:      6.6.2
 * Version:           1.10.0
 * Author:            BJM Team
 * Author URI:        https://bjmdigital.com.au/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       blokki
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'BLOKKI_VERSION', '1.10.0' );

if ( ! defined( 'BLOKKI_PLUGIN_FILE' ) ) {
	define( 'BLOKKI_PLUGIN_FILE', __FILE__ );
}


/**
 * Composer Auto Loader
 */
if ( ! file_exists( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	deactivate_plugins( basename( __FILE__ ) );
	wp_die( esc_html__( 'Please run composer install before activating plugin.' ) );
}
require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-blokki-activator.php
 */
function blokki_activate() {
	Blokki\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-blokki-deactivator.php
 */
function blokki_deactivate() {
	Blokki\Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'blokki_activate' );
register_deactivation_hook( __FILE__, 'blokki_deactivate' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function Blokki() {

	return Blokki\Init::get_instance();

}

Blokki();
