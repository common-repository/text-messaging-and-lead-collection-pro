<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.livecomm.com
 * @since      1.0
 *
 * @package    Text_Message_Lead_Collection_Pro
 * @subpackage Text_Message_Lead_Collection_Pro/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0
 * @package    Text_Message_Lead_Collection_Pro
 * @subpackage Text_Message_Lead_Collection_Pro/includes
 * @author     Text Comm, LLC <info@vndx.com>
 */
class Text_Message_Lead_Collection_Pro_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0
	 */
	public static function activate() {

        if ( ! get_option( 'tmlcp_enable_plugin' ) ) {
            update_option('tmlcp_enable_plugin', 'yes');
        }

        // Floating button option yes on active
        update_option('tmlcp_enable_floating_plugin', 'yes');
	}

}
