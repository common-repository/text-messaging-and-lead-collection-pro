<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.livecomm.com
 * @since             1.0
 * @package           Text_Message_Lead_Collection_Pro
 *
 * @wordpress-plugin
 * Plugin Name:       Text Messaging and Lead Collection Pro
 * Plugin URI:        https://www.livecomm.com/text-messaging-and-lead-collection-pro
 * Description:       The Livecomm plugin enables direct integration between your WordPress website and your livecomm.com account.
 * Version:           1.0
 * Author:            Text Comm, LLC
 * Author URI:        https://www.livecomm.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       text-message-lead-collection-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if (!defined('TEXT_MESSAGE_LEAD_COLLECTION_PRO_VERSION')) define( 'TEXT_MESSAGE_LEAD_COLLECTION_PRO_VERSION', '1.0' );

// Defines the path to the main plugin file.
if (!defined('TMLCP_FILE')) define( 'TMLCP_FILE', __FILE__ );

// Defines the path to be used for includes.
if (!defined('TMLCP_DIR_PATH')) define( 'TMLCP_DIR_PATH', plugin_dir_path( TMLCP_FILE ) );

// Defines the url to be used for images.
if (!defined('TMLCP_DIR_URL')) define( 'TMLCP_DIR_URL', plugin_dir_url( TMLCP_FILE ) );

// Wordpress AJAX URL
if (!defined('TMLCP_AJAX_URL')) define( 'TMLCP_AJAX_URL', admin_url('admin-ajax.php') );

// Livecomm API Base URL
if (!defined('TMLCP_API_BASE_URL')) define( 'TMLCP_API_BASE_URL', 'https://beta.livecomm.com/api2/' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-text-message-lead-collection-pro-activator.php
 */
function activate_text_message_lead_collection_pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-text-message-lead-collection-pro-activator.php';
	Text_Message_Lead_Collection_Pro_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-text-message-lead-collection-pro-deactivator.php
 */
function deactivate_text_message_lead_collection_pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-text-message-lead-collection-pro-deactivator.php';
	Text_Message_Lead_Collection_Pro_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_text_message_lead_collection_pro' );
register_deactivation_hook( __FILE__, 'deactivate_text_message_lead_collection_pro' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-text-message-lead-collection-pro.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0
 */
function run_text_message_lead_collection_pro() {

	$plugin = new Text_Message_Lead_Collection_Pro();
	$plugin->run();

}

add_action( 'plugins_loaded', 'tmlcp_plugin_init' );

/**
 * Check plugin dependency after plugin has been loaded
 *
 * @since 1.0
 */
function tmlcp_plugin_init() {
    
    // If Contact Form 7 plugin is not installed, print error message at very top in WP-ADMIN
    if ( ! class_exists('WPCF7_ContactForm') ) {
        add_action( 'admin_notices', 'tmlcp_print_dependency_error_message' );
    }
    else {
        // Call plugin main function only when Contact Form 7 plugin is installed
        run_text_message_lead_collection_pro();
    }    
}

/**
 * Print notice error message if Contact Form 7 plugin is not active
 *
 * @since 1.0
 */
function tmlcp_print_dependency_error_message() {
    
    echo '<div class="notice notice-error"><p>' . sprintf( esc_html__( 'Text Messaging and Lead Collection Pro depends on Contact Form 7. Please install and activate %1$sContact Form 7%2$s.' , 'text-message-lead-collection-pro' ), '<a href="//wordpress.org/plugins/contact-form-7/" target="_blank">', '</a>' ) . '</p></div>';

}

