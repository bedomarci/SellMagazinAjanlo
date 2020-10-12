<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       bedomarci.hu
 * @since      1.0.0
 *
 * @package    Sell_Ajanlo
 * @subpackage Sell_Ajanlo/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sell_Ajanlo
 * @subpackage Sell_Ajanlo/includes
 * @author     Bedő Marci <bedomarci@gmail.com>
 */
class Sell_Ajanlo_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sell-ajanlo',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
