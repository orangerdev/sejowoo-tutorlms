<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://sejoli.co.id
 * @since      1.0.0
 *
 * @package    Sejowoo_Tutorlms
 * @subpackage Sejowoo_Tutorlms/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sejowoo_Tutorlms
 * @subpackage Sejowoo_Tutorlms/includes
 * @author     Sejoli Team <admin@sejoli.co.id>
 */
class Sejowoo_Tutorlms {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sejowoo_Tutorlms_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
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
		if ( defined( 'SEJOWOO_TUTORLMS_VERSION' ) ) {
			$this->version = SEJOWOO_TUTORLMS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'sejowoo-tutorlms';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sejowoo_Tutorlms_Loader. Orchestrates the hooks of the plugin.
	 * - Sejowoo_Tutorlms_i18n. Defines internationalization functionality.
	 * - Sejowoo_Tutorlms_Admin. Defines all hooks for the admin area.
	 * - Sejowoo_Tutorlms_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sejowoo-tutorlms-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sejowoo-tutorlms-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sejowoo-tutorlms-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sejowoo-tutorlms-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sejowoo-tutorlms-all-class.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sejowoo-tutorlms-enrolled-class.php';

		/**
		 * Routine functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'functions/course.php';

		$this->loader = new Sejowoo_Tutorlms_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sejowoo_Tutorlms_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sejowoo_Tutorlms_i18n();

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

		$admin = new Sejowoo_Tutorlms\Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'plugins_loaded', $admin, 'check_needed_plugins', 999);
		$this->loader->add_action( 'admin_notices',	$admin, 'display_notice_if_sejoli_not_activated', 10);
		$this->loader->add_action( 'admin_notices',	$admin, 'display_notice_if_tutorlms_not_activated', 10);

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$public = new Sejowoo_Tutorlms\Front( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles', 999);
		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_scripts', 999);
		$this->loader->add_filter( 'tutor_course_price', $public, 'remove_price', 10);

		$allclass = new Sejowoo_Tutorlms\Front\AllClass( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'sejowoo/my-account-endpoint/vars', $allclass, 'register_my_account_endpoint', 16 );
		$this->loader->add_filter( 'sejowoo/myaccount/links', $allclass, 'add_my_account_links', 30 );
		$this->loader->add_filter( 'woocommerce_endpoint_all-class_title', $allclass, 'set_my_account_title', 1);
		$this->loader->add_action( 'woocommerce_account_all-class_endpoint', $allclass, 'set_my_account_content', 1);

		// Actions used to insert a new endpoint in the WordPress.
		$this->loader->add_action( 'init', $allclass, 'add_endpoints' );
		$this->loader->add_filter( 'query_vars', $allclass, 'add_query_vars', 0 );

		$enrolledclass = new Sejowoo_Tutorlms\Front\EnrolledClass( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'sejowoo/my-account-endpoint/vars', $enrolledclass, 'register_my_account_endpoint', 16 );
		$this->loader->add_filter( 'sejowoo/myaccount/links', $enrolledclass, 'add_my_account_links', 30 );
		$this->loader->add_filter( 'woocommerce_endpoint_enrolled-class_title', $enrolledclass, 'set_my_account_title', 1);
		$this->loader->add_action( 'woocommerce_account_enrolled-class_endpoint', $enrolledclass, 'set_my_account_content', 1);

		// Actions used to insert a new endpoint in the WordPress.
		$this->loader->add_action( 'init', $enrolledclass, 'add_endpoints' );
		$this->loader->add_filter( 'query_vars', $enrolledclass, 'add_query_vars', 0 );

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
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
	
		return $this->plugin_name;
	
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sejowoo_Tutorlms_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
	
		return $this->loader;
	
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
	
		return $this->version;
	
	}

}
