<?php

/**
 * Fired during plugin activation
 *
 * @link       bedomarci.hu
 * @since      1.0.0
 *
 * @package    Sell_Ajanlo
 * @subpackage Sell_Ajanlo/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Sell_Ajanlo
 * @subpackage Sell_Ajanlo/includes
 * @author     Bedő Marci <bedomarci@gmail.com>
 */
class Sell_Ajanlo_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        if (!wp_next_scheduled('sell_magazin_daily_schedule')) {
//            wp_schedule_event( time(), 'daily', 'sell_magazin_daily_schedule' );
            wp_schedule_event(time(), 'everyminute', 'sell_magazin_daily_schedule');
        }

        if (!wp_next_scheduled('sell_magazin_validity_calculation_schedule')) {
            wp_schedule_event(strtotime('05:00:00'), 'daily', 'sell_magazin_validity_calculation_schedule');
        }

    }

}
