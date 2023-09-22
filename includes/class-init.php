<?php

namespace Blokki;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://bjmdigital.com.au/
 * @since      1.0.0
 *
 * @package    Blokki
 * @subpackage Blokki/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Blokki
 * @subpackage Blokki/includes
 * @author     BJM Team <developers@bjmdigital.com.au>
 */
class Init {

	/**
	 * The instance of this class
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      object $instance The instance of the current class
	 */
	protected static $instance;
	/**
	 * The template loader class of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Template $template_loader
	 */
	public $template_loader;
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version
	 */
	protected $version;
	/**
	 * The admin class of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Admin $admin
	 */
	protected $admin;

    /**
     * The api class of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Api $api
     */
    protected $api;

    /**
     * The blocks class of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Blocks $blocks
     */
    protected $blocks;

    /**
     * The ACF blocks class of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      AcfBlocks $acf_blocks
     */
    protected $acf_blocks;

    /**
     * The schema class of the plugin.
     *
     * @since    1.0.1
     * @access   protected
     * @var      Schema $schema
     */
    protected $schema;


	/**
	 * The front/public class of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Front $front
	 */
	protected $front;

	/**
	 * The updater class of the plugin.
	 *
	 * @since    1.0.4
	 * @access   protected
	 * @var      Updater $upater
	 */
	protected $upater;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->define_constants();

		if ( defined( 'BLOKKI_VERSION' ) ) {
			$this->version = BLOKKI_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		if ( defined( 'BLOKKI_PLUGIN_NAME' ) ) {
			$this->plugin_name = BLOKKI_PLUGIN_NAME;
		} else {
			$this->plugin_name = 'blokki';
		}


		$this->load_dependencies();
		$this->load_updater();
		$this->set_locale();
		$this->template_loader_hooks();
		$this->define_admin_hooks();
		$this->define_api_hooks();
		$this->define_public_hooks();
		$this->define_blocks_hooks();
		$this->define_schema_hooks();
		$this->define_acf_blocks_hooks();

		do_action( 'blokki_init_construct' );

	}

	/**
	 * Define Plugin Constants
	 */
	public function define_constants() {


		define( 'BLOKKI_PLUGIN_NAME', 'blokki' );

		/**
		 * Plugin base name.
		 * used to locate plugin resources primarily code files
		 * Start at version 1.0.0
		 */
		/** @noinspection PhpUnused */
		define( 'BLOKKI_PLUGIN_BASE_NAME', basename( BLOKKI_PLUGIN_FILE ) );


		/**
		 * Plugin base dir path.
		 * used to locate plugin resources primarily code files
		 * Start at version 1.0.0
		 */
		/** @noinspection PhpUnused */
		define( 'BLOKKI_DIR_PATH', plugin_dir_path( BLOKKI_PLUGIN_FILE ) );

		/**
		 * Plugin url to access its resources through browser
		 * used to access assets images/css/js files
		 * Start at version 1.0.0
		 */
		/** @noinspection PhpUnused */
		define( 'BLOKKI_URL_PATH', plugin_dir_url( BLOKKI_PLUGIN_FILE ) );


		/**
		 * Transient Prefix for schema cache
		 * Start at version 1.0.1
		 */
		/** @noinspection PhpUnused */
		define( 'BLOKKI_SCHEMA_CACHE_PREFIX', 'blokki_schema_cache_' );

		/**
		 * Plugin GitHub repo URL
		 * @since version 1.0.4
		 */
		define( 'BLOKKI_GITHUB_REPO_URL', 'https://github.com/bjmdigital/blokki' );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Loader. Orchestrates the hooks of the plugin.
	 * - i18n. Defines internationalization functionality.
	 * - Admin. Defines all hooks for the admin area.
	 * - Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/* No Need to Load anything as autoloader is generated by Composer*/

		$this->loader = new Loader();
		include_once BLOKKI_DIR_PATH . 'functions.php';

	}

	/**
	 * Load the required Auto updater for the plugin
	 *
	 *
	 * @since    1.0.4
	 * @access   private
	 */
	private function load_updater() {

		$this->upater = new Updater();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new i18N();

		/** @noinspection SpellCheckingInspection */
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function template_loader_hooks() {

		if ( ! class_exists( '\Gamajo_Template_Loader' ) ) {
			die( esc_html__( 'Please run `composer install` for template loader class', 'blokki' ) );
		}
		$this->template_loader = new Template();

	}

	/**
	 * Register all the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {


		$this->admin = new Admin( $this->get_plugin_name(), $this->get_version() );


	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$this->front = new Front( $this->get_plugin_name(), $this->get_version() );

	}

	/**
	 * Register hooks related to the API functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_api_hooks() {

		$this->api = new Api( $this->get_plugin_name(), $this->get_version() );

	}


	/**
	 * Register all the hooks related to Gutenberg
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_blocks_hooks() {

		if ( ! function_exists( 'register_block_type' ) ) {
			// Gutenberg is not active.
			return;
		}

		$this->blocks = new Blocks( $this->get_plugin_name(), $this->get_version() );

	}

	/**
	 * Register all the hooks related to SEO Schema
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function define_schema_hooks() {

		$this->schema = new Schema();

	}

	/**
	 * Register all the hooks related to ACF Blocks
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_acf_blocks_hooks() {

		$this->acf_blocks = new AcfBlocks( $this->get_plugin_name(), $this->get_version() );

	}

	/**
	 * get the instance of the main plugin class
	 */
	public static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new self();
			self::$instance->run();
		}

		return self::$instance;

	}

	/**
	 * Run the loader to execute all the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public function template_path() {
		return apply_filters( 'blokki_template_path', 'blokki/' );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( BLOKKI_PLUGIN_FILE ) );
	}


}
