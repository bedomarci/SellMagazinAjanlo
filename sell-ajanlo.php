<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              bedomarci.hu
 * @since             1.0.0
 * @package           Sell_Ajanlo
 *
 * @wordpress-plugin
 * Plugin Name:       Sell Magazin Ajánló
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Bedő Marci
 * Author URI:        bedomarci.hu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sell-ajanlo
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
define( 'SELL_AJANLO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sell-ajanlo-activator.php
 */
function activate_sell_ajanlo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sell-ajanlo-activator.php';
	Sell_Ajanlo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sell-ajanlo-deactivator.php
 */
function deactivate_sell_ajanlo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sell-ajanlo-deactivator.php';
	Sell_Ajanlo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sell_ajanlo' );
register_deactivation_hook( __FILE__, 'deactivate_sell_ajanlo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/helpers.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-sell-ajanlo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sell_ajanlo() {

	$plugin = new Sell_Ajanlo();
	$plugin->run();

}
run_sell_ajanlo();
