<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ccb_Api
 * @subpackage Ccb_Api/includes
 * @author     Laura Haverkamp <laura@haverkamp.us>
 */
class Ccb_Api {
    /**
     * A constant that is used on both the admin and the public side to store
     * and retrieve the options via get_option and set_option
     *
     * @since 1.0.0
     * @const OPTIONS
     */
    const OPTIONS = 'ccb_plugin_options';
    
    /**
     * A constant used to pull a specific option out of the option array.
     *
     * @since 1.0.0
     * @const URL
     */
    const URL = 'ccb_url';
    
    /**
     * A constant used to pull a specific option out of the option array.
     *
     * @since 1.0.0
     * @const USERNAME
     */
    const USERNAME = 'ccb_username';
    
    /**
     * A constant used to pull a specific option out of the option array.
     *
     * @since 1.0.0
     * @const PASSWORD
     */
    const PASSWORD = 'ccb_password';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ccb_Api_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugin_name = 'ccb-api';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ccb_Api_Loader. Orchestrates the hooks of the plugin.
	 * - Ccb_Api_Admin. Defines all hooks for the dashboard.
	 * - Ccb_Api_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ccb-api-loader.php';

        // TODO i18n
        
		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ccb-api-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ccb-api-public.php';

		$this->loader = new Ccb_Api_Loader();
	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Ccb_Api_Admin( $this->get_plugin_name(), $this->get_version() );
        
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugins_page');
        $this->loader->add_action( 'admin_init', $plugin_admin, 'ccb_initialize_plugin_options');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Ccb_Api_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_shortcode( 'ccb_current_events', $plugin_public, 'current_events' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ccb_Api_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
