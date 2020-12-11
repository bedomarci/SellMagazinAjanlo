<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       bedomarci.hu
 * @since      1.0.0
 *
 * @package    Sell_Ajanlo
 * @subpackage Sell_Ajanlo/includes
 */

use SellMagazin\Divi\Divi_Component_Register;
use SellMagazin\Interfaces\Action_Register;
use SellMagazin\Interfaces\Filter_Register;
use SellMagazin\PostMeta\Archive_Custom_Fields_Register;
use SellMagazin\PostMeta\Handle_Manage_Posts_Columns;
use SellMagazin\PostMeta\Post_Edit_Recalculate_Suggestion_Button;
use SellMagazin\PostMeta\Post_Row_Edit_Recalculate_Suggestion_Button;
use SellMagazin\PostMeta\Post_Suggestion_Custom_Fields_Register;
use SellMagazin\PostMeta\Post_Suggestion_Meta_Register;
use SellMagazin\PostMeta\Register_Manage_Posts_Columns;
use SellMagazin\PostUpdater\Batch_Calculation_Updater;
use SellMagazin\PostUpdater\Batch_Validity_Updater;
use SellMagazin\PostUpdater\Calculation_Ajax_Updater;
use SellMagazin\PostUpdater\Calculation_Updater;
use SellMagazin\PostUpdater\Highlight_Updater;
use SellMagazin\PostUpdater\Single_Validity_Updater;
use SellMagazin\Queue\Async_Job_Register;
use SellMagazin\Settings\Plugin_Settings_Init;
use SellMagazin\Settings\Plugin_Settings_Page;


/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.1
 * @package    Sell_Ajanlo
 * @subpackage Sell_Ajanlo/includes
 * @author     Bedő Marci <bedomarci@gmail.com>
 */
class Sell_Ajanlo {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sell_Ajanlo_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SELL_AJANLO_VERSION' ) ) {
			$this->version = SELL_AJANLO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'sell-ajanlo';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->auto_define();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sell_Ajanlo_Loader. Orchestrates the hooks of the plugin.
	 * - Sell_Ajanlo_i18n. Defines internationalization functionality.
	 * - Sell_Ajanlo_Admin. Defines all hooks for the admin area.
	 * - Sell_Ajanlo_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$autoload_path = plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';
		if ( file_exists( $autoload_path ) ) {
			require_once $autoload_path;
		} else {
			$command = 'composer install -d ' . plugin_dir_path( dirname( __FILE__ ) );
			wp_die( "Dependencies are missing. Please run the following command on the host:<br/><pre>$command</pre>" );
		}

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sell-ajanlo-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sell-ajanlo-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sell-ajanlo-admin.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sell-ajanlo-public.php';


		$this->loader = new Sell_Ajanlo_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sell_Ajanlo_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sell_Ajanlo_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

//		$plugin_admin_page = new Suggestion_Calculator_Settings_Page();

		$plugin_admin = new Sell_Ajanlo_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

//		$this->loader->add_action( 'wp_ajax_recalculate_suggestion', $plugin_admin, 'handle_recalculate_suggestion_ajax_request' );

//		$this->loader->add_action( 'sell_magazin_daily_schedule', $plugin_admin, 'schedule_daily_recalculation' );
//		$this->loader->add_action( 'sell_magazin_validity_update_schedule', $plugin_admin, 'sell_magazin_validity_update' );


		$this->loader->add_filter( 'cron_schedules', $plugin_admin, 'register_cron_scheduler' );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Sell_Ajanlo_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
//		$this->loader->add_action( 'et_builder_modules_loaded', $plugin_public, 'initialize_divi_module' );


	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Sell_Ajanlo_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	public function auto_define() {

		$registers = [
			new Post_Edit_Recalculate_Suggestion_Button(),
			new Post_Row_Edit_Recalculate_Suggestion_Button(),
			new Post_Suggestion_Custom_Fields_Register(),
			new Archive_Custom_Fields_Register(),
			new Post_Suggestion_Meta_Register(),
			new Async_Job_Register(),
			new Single_Validity_Updater(),
			new Highlight_Updater(),
			new Plugin_Settings_Init(),
			new Plugin_Settings_Page(),
			new Divi_Component_Register(),
			new Calculation_Updater(),
			new Calculation_Ajax_Updater(),
			new Batch_Validity_Updater(),
			new Batch_Calculation_Updater(),
			new Register_Manage_Posts_Columns(),
			new Handle_Manage_Posts_Columns(),
		];
		foreach ( $registers as $register ) {
			if ( is_subclass_of( $register, Action_Register::class ) ) {
				$this->loader->add_action( $register->get_hook(), $register, 'run', $register->get_prioroty(), $register->get_accepted_args() );
			}
			if ( is_subclass_of( $register, Filter_Register::class ) ) {
				$this->loader->add_filter( $register->get_hook(), $register, 'filter', $register->get_prioroty(), $register->get_accepted_args() );
			}
		}
	}

}
