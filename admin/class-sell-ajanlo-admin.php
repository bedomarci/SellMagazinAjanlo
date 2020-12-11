<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       bedomarci.hu
 * @since      1.0.0
 *
 * @package    Sell_Ajanlo
 * @subpackage Sell_Ajanlo/admin
 */


use SellMagazin\Calculator\Suggestion_Calculator;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sell_Ajanlo
 * @subpackage Sell_Ajanlo/admin
 * @author     Bedő Marci <bedomarci@gmail.com>
 */
class Sell_Ajanlo_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

//    protected $suggestion_calculation_request;
//    protected $suggestion_calculation_process;
//    protected $validity_updater_request;


    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;


    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Sell_Ajanlo_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Sell_Ajanlo_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

//        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/sell-ajanlo-admin.css', array(), time(), 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/sell-ajanlo-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Sell_Ajanlo_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Sell_Ajanlo_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

//        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/sell-ajanlo-admin.js', array('jquery', 'wp-api'), time(), false);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/sell-ajanlo-admin.js', array('jquery', 'wp-api'), $this->version, false);

    }

    function registerDailyRecalculationCronJob()
    {
        if (!wp_next_scheduled('sell_magazin_recalculation')) {
            wp_schedule_event(time(), 'five_seconds', 'bl_cron_hook');
        }
    }

    function register_cron_scheduler($schedules)
    {
        $schedules['everyminute'] = array(
            'interval' => 60, // time in seconds
            'display' => 'Every Minute'
        );
        return $schedules;
    }
}
