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
