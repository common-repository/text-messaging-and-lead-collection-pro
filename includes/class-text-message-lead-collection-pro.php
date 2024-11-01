<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.livecomm.com
 * @since      1.0
 *
 * @package    Text_Message_Lead_Collection_Pro
 * @subpackage Text_Message_Lead_Collection_Pro/includes
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
 * @since      1.0
 * @package    Text_Message_Lead_Collection_Pro
 * @subpackage Text_Message_Lead_Collection_Pro/includes
 * @author     Text Comm, LLC <info@vndx.com>
 */
class Text_Message_Lead_Collection_Pro {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0
	 * @access   protected
	 * @var      Text_Message_Lead_Collection_Pro_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0
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
	 * @since    1.0
	 */
	public function __construct() {
		if ( defined( 'TEXT_MESSAGE_LEAD_COLLECTION_PRO_VERSION' ) ) {
			$this->version = TEXT_MESSAGE_LEAD_COLLECTION_PRO_VERSION;
		} else {
			$this->version = '1.0';
		}
		$this->plugin_name = 'text-message-lead-collection-pro';

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
	 * - Text_Message_Lead_Collection_Pro_Loader. Orchestrates the hooks of the plugin.
	 * - Text_Message_Lead_Collection_Pro_i18n. Defines internationalization functionality.
	 * - Text_Message_Lead_Collection_Pro_Admin. Defines all hooks for the admin area.
	 * - Text_Message_Lead_Collection_Pro_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-text-message-lead-collection-pro-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-text-message-lead-collection-pro-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-text-message-lead-collection-pro-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-text-message-lead-collection-pro-public.php';

		$this->loader = new Text_Message_Lead_Collection_Pro_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Text_Message_Lead_Collection_Pro_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Text_Message_Lead_Collection_Pro_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Text_Message_Lead_Collection_Pro_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'tmlcp_admin_menu' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'tmlcp_logout_user' );

		$this->loader->add_action( 'wp_ajax_tmlcp_livecomm_login', $plugin_admin, 'tmlcp_livecomm_login_callback' );

		$this->loader->add_action( 'wp_ajax_tmlcp_livecomm_phone_list', $plugin_admin, 'tmlcp_set_default_phonenumber_callback' );

		$this->loader->add_action( 'wp_ajax_tmlcp_livecomm_contact_list', $plugin_admin, 'tmlcp_set_default_contact_list_callback' );

		$this->loader->add_action( 'wp_ajax_tmlcp_livecomm_field_mapping', $plugin_admin, 'tmlcp_livecomm_field_mapping_callback' );

		$this->loader->add_action( 'wp_ajax_tmlcp_unmap_form', $plugin_admin, 'tmlcp_unmap_form_callback' );

		$this->loader->add_action( 'wp_ajax_tmlcp_save_general_setting', $plugin_admin, 'tmlcp_save_general_setting_callback' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Text_Message_Lead_Collection_Pro_Public( $this->get_plugin_name(), $this->get_version() );

		$plugin_admin = new Text_Message_Lead_Collection_Pro_Admin( $this->get_plugin_name(), $this->get_version() );

		// If plugin is enabled from settings page then and only load public hook
		if( $plugin_public->tmlcp_is_plugin_enabled() && $plugin_admin->tmlcp_is_user_logged_in() ) {

			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

			$this->loader->add_action( 'wpcf7_mail_sent', $plugin_public, 'tmlcp_send_contact_data_livecomm' );

			$this->loader->add_action( 'init', $plugin_public, 'tmlcp_register_shortcode' );

			$tmlcp_enable_floating_plugin = get_option('tmlcp_enable_floating_plugin');

			if ( $tmlcp_enable_floating_plugin == 'yes' ) {
				$this->loader->add_action( 'wp_footer', $plugin_public, 'tmlcp_floating_button_form' );
			}

			$this->loader->add_action( 'wp_ajax_tmlcp_livecomm_lead_create_form', $plugin_public, 'tmlcp_livecomm_lead_create_form_callback' );

			$this->loader->add_action( 'wp_ajax_nopriv_tmlcp_livecomm_lead_create_form', $plugin_public, 'tmlcp_livecomm_lead_create_form_callback' );

			$this->loader->add_action( 'wp_footer', $plugin_public, 'tmlcp_call_to_action' );	
		}
		

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0
	 * @return    Text_Message_Lead_Collection_Pro_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
