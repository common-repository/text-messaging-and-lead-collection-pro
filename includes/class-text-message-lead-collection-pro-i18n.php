<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.livecomm.com
 * @since      1.0
 *
 * @package    Text_Message_Lead_Collection_Pro
 * @subpackage Text_Message_Lead_Collection_Pro/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0
 * @package    Text_Message_Lead_Collection_Pro
 * @subpackage Text_Message_Lead_Collection_Pro/includes
 * @author     Text Comm, LLC <info@vndx.com>
 */
class Text_Message_Lead_Collection_Pro_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'text-message-lead-collection-pro',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
