<?php

/**
 * Fired during plugin activation
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    Purecharity
 * @subpackage Purecharity/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Purecharity
 * @subpackage Purecharity/includes
 * @author     Pure Charity <dev@purecharity.com>
 */
class Purecharity_Wp_Base_Activator {

	/**
	 * Activates the Pure Base Plugin.
	 *
	 * Sets all the necessary settings for the plugin.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
            if( get_option( 'pure_base_name' ) ) {
                update_option( 'pure_base_name', PURECHARITY_PLUGIN_NAME );
            } else { 
                add_option( 'pure_base_name', PURECHARITY_PLUGIN_NAME, '', 'no' );
            }
	}

}
