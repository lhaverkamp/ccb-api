<?php

/**
 * Plugin Name: CCB API
 * Plugin URI: https://github.com/lhaverkamp/ccb-api
 * Description: A WordPress plugin that consumes various CCB API calls.
 * Version: 1.0.0
 * Author: Laura Haverkamp
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ccb-api-activator.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ccb-api-deactivator.php';

/** This action is documented in includes/class-ccb-api-activator.php */
register_activation_hook( __FILE__, array( 'Ccb_Api_Plugin_Activator', 'activate' ) );

/** This action is documented in includes/class-ccb-api-deactivator.php */
register_deactivation_hook( __FILE__, array( 'Ccb_Api_Plugin_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ccb-api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ccb_api() {

	$plugin = new Ccb_Api();
	$plugin->run();

}
run_ccb_api();
