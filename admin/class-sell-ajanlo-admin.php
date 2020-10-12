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

    private $suggester;

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
        $this->suggester = new Post_Suggester();

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

    public function initialize_suggester()
    {
//	    $this->suggester->registerPostMeta();
//	    $this->suggester->registerPostEditRecalculateSuggestionsButton();
    }

    function register_post_meta()
    {
        register_post_meta('post', 'sellmagazin__meta_block_field', array(
            'show_in_rest' => true,
            'type' => 'array',
        ));
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
        <div style="padding: 10px; text-align: left" id="recalculate-suggestion">
            <span class="spinner"></span>
            <button class=" button" data-id="<?php echo $post->ID ?>">Ajánlatok újraszámolása</button>
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

    function register_rcalculate_suggestion_REST_endpoint()
    {
        register_rest_route('suggester/v1', '/recalculate', array(
            'methods' => 'POST',
            'callback' => array($this, 'handleRecalculateSuggestionRequest'),
        ));
    }

    function handle_recalculate_suggestion_request(WP_REST_Request $request)
    {
        $data = $request->get_params('id');
        $response = new WP_REST_Response($data);
        $response->set_status(201);
        return $response;
    }

    function schedule_daily_recalculation()
    {
        //        RUN BITCH
        write_log("scheduled: " . time());
    }

}
