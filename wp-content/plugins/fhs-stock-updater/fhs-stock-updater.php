<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://acalebwilson.com
 * @since             1.0.0
 * @package           Fhs_Stock_Updater
 *
 * @wordpress-plugin
 * Plugin Name:       FHS Stock Updater
 * Plugin URI:        fhs-stock-updater
 * Description:       Stock Updater for the Future Health Store
 * Version:           1.0.0
 * Author:            Caleb Wilson
 * Author URI:        https://acalebwilson.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fhs-stock-updater
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
define( 'FHS_STOCK_UPDATER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fhs-stock-updater-activator.php
 */
function activate_fhs_stock_updater() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fhs-stock-updater-activator.php';
	Fhs_Stock_Updater_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fhs-stock-updater-deactivator.php
 */
function deactivate_fhs_stock_updater() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fhs-stock-updater-deactivator.php';
	Fhs_Stock_Updater_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fhs_stock_updater' );
register_deactivation_hook( __FILE__, 'deactivate_fhs_stock_updater' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fhs-stock-updater.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fhs_stock_updater() {

	$plugin = new Fhs_Stock_Updater();
	$plugin->run();

}
run_fhs_stock_updater();
