<?php

/**
 * Fired during plugin deactivation
 *
 * @link       bedomarci.hu
 * @since      1.0.0
 *
 * @package    Sell_Ajanlo
 * @subpackage Sell_Ajanlo/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Sell_Ajanlo
 * @subpackage Sell_Ajanlo/includes
 * @author     Bedő Marci <bedomarci@gmail.com>
 */
class Sell_Ajanlo_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        wp_clear_scheduled_hook( 'sell_magazin_daily_schedule' );
        wp_clear_scheduled_hook( 'sell_magazin_validity_update_schedule' );
        wp_clear_scheduled_hook( 'sell_magazin_suggestion_update_schedule' );
	}

}
