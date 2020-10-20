<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tahir.codes/
 * @since             1.0.0
 * @package           Idlkeys_management
 *
 * @wordpress-plugin
 * Plugin Name:       IDL Keys Management
 * Plugin URI:        https://tahir.codes/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            tahir iqbal
 * Author URI:        https://tahir.codes/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       idlkeys_management
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'IDLKEYS_MANAGEMENT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-idlkeys_management-activator.php
 */
function activate_idlkeys_management() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-idlkeys_management-activator.php';
	Idlkeys_management_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-idlkeys_management-deactivator.php
 */
function deactivate_idlkeys_management() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-idlkeys_management-deactivator.php';
	Idlkeys_management_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_idlkeys_management' );
register_deactivation_hook( __FILE__, 'deactivate_idlkeys_management' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-idlkeys_management.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_idlkeys_management() {

	$plugin = new Idlkeys_management();
	$plugin->run();

}
run_idlkeys_management();
