<?php

namespace Blokki;
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Blokki\Template' ) ) {
	return;
}


if ( ! class_exists( '\Gamajo_Template_Loader' ) ) {
	return;
}

/**
 * This class will create meta boxes for Shortcodes
 *
 * @package    Blokki
 * @subpackage Blokki/includes
 */
class Template extends \Gamajo_Template_Loader{

	/**
	 * Prefix for filter names.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $filter_prefix = 'blokki';

	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $theme_template_directory = 'blokki';

	/**
	 * Reference to the root directory path of this plugin.
	 * @since 1.0.0
	 * @var string
	 */
	protected $plugin_directory = BLOKKI_DIR_PATH;

	/**
	 * Directory name where templates are found in this plugin.
	 *
	 * Can either be a defined constant, or a relative reference from where the subclass lives.
	 *
	 * e.g. 'templates' or 'includes/templates', etc.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	protected $plugin_template_directory = 'templates';


}