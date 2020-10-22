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

use SellMagazin\Suggestion_Calculation_Process;
use SellMagazin\Suggestion_Calculation_Request;
use SellMagazin\Batch_Validity_Updater_Request;

//use SellMagazin\Suggestion_Calculation_Process;

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

    protected $suggestion_calculation_request;
    protected $suggestion_calculation_process;
    protected $validity_updater_request;


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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/sell-ajanlo-admin.css', array(), time(), 'all');
//        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/sell-ajanlo-admin.css', array(), $this->version, 'all');

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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/sell-ajanlo-admin.js', array('jquery', 'wp-api'), time(), false);
//        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/sell-ajanlo-admin.js', array('jquery'), $this->version, false);

    }


    function register_post_meta()
    {
        register_post_meta('post', 'sellmagazin_suggestions', array(
            'show_in_rest' => true,
            'type' => 'array',
        ));
        register_post_meta('post', 'sellmagazin_suggestion_last_update', array(
            'show_in_rest' => true,
            'type' => 'string',
        ));
        register_post_meta('post', 'sellmagazin_suggestion_valid', array(
            'show_in_rest' => true,
            'type' => 'number',
        ));
    }

    function register_async_jobs()
    {
        $this->suggestion_calculation_request = new Suggestion_Calculation_Request();
        $this->suggestion_calculation_process = new Suggestion_Calculation_Process();
        $this->validity_updater_request = new Batch_Validity_Updater_Request();
    }

    function registerDailyRecalculationCronJob()
    {
        if (!wp_next_scheduled('sell_magazin_recalculation')) {
            wp_schedule_event(time(), 'five_seconds', 'bl_cron_hook');
        }
    }

    function add_post_edit_recalculate_suggestion_button()
    {
        global $post;
        if (get_current_screen()->post_type != 'post') return;
        ?>
        <div class="misc-pub-section curtime misc-pub-curtime">
            Ajánlások ideje: <b><?php echo get_post_meta($post->ID, 'sellmagazin_suggestion_last_update', true) ?></b>
        </div>
        <div style="padding: 10px; text-align: left" id="recalculate-suggestion">
            <span class="spinner"></span>
            <button class=" button" data-id="<?php echo $post->ID ?>">Ajánlat újraszámítás indítása</button>
        </div>
        <?php
    }

    function add_post_row_edit_recalculate_suggestion_button($actions)
    {
        if (get_current_screen()->post_type != 'post') return;
        global $post;
        $actions['recalculate'] = '<a class="quick-recalculate-suggestion" href="#" title="" data-id="' . $post->ID . '" rel="permalink">Ajánlatok újraszámolása<span></span></a>';
        return $actions;
    }

    function handle_recalculate_suggestion_request($post_id)
    {
        $this->suggestion_calculation_request->set_post_id($post_id)->dispatch();
    }

    function handle_recalculate_suggestion_ajax_request()
    {
//        $this->handle_recalculate_suggestion_request($_POST['id']);
//        wp_die();


        //sync
        $post_id = $_POST['id'];
        $calculator = new \SellMagazin\Suggestion_Calculator($post_id);
        echo print_r($calculator->calculate());
//        $calculator = new \SellMagazin\Validity_Updater();
//        echo $calculator->calculate();
//

    }


    function schedule_daily_recalculation()
    {
//        sell_log("Auto dispatch 111, 112 (by " . get_current_user_id() . ") @" . getmypid());
//
//        $post_ids = [111, 112];
//        foreach ($post_ids as $post_id) {
//            $this->calculation_process->push_to_queue($post_id);
//        }
//        $this->calculation_process->save()->dispatch();
    }

    function sell_magazin_validity_update()
    {
        $this->validity_updater_request->dispatch();
    }


    function wpshout_add_cron_interval($schedules)
    {
        $schedules['everyminute'] = array(
            'interval' => 60, // time in seconds
            'display' => 'Every Minute'
        );
        return $schedules;
    }
}
