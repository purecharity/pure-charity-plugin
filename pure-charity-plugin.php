<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://purecharity.com
 * @since             1.0.0
 * @package           pure-charity-plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Pure Charity
 * Plugin URI:        http://purecharity.com/
 * Description:       The plugin for Pure Charity API integration
 * Version:           1.0.0
 * Author:            <a href="http://purecharity.com">Pure Charity</a>
 * Author2:           <a href="http://zemlianoi.com">Aleskandr Zemlianoi</a>
 * Author URI:        http://purecharity.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pure-charity
 * Domain Path:       /lang
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'PURECHARITY_BASE_URL', plugin_dir_url( __FILE__ ) );
define( 'PURECHARITY_BASE_PATH', plugin_dir_path( __FILE__ ) );

require_once PURECHARITY_BASE_PATH . 'includes/purecharity.class.php';

//add_filter('extra_plugin_headers', 'add_extra_headers');
//
//function add_extra_headers(){
//    return array('Author2');
//}
//
//add_filter('plugin_row_meta', 'filter_authors_row_meta', 1, 4);
//
//function filter_authors_row_meta($plugin_meta, $plugin_file, $plugin_data, $status ){
//
//    if(empty($plugin_data['Author'])){
//        return $plugin_meta;
//    }
//
//
//    if ( !empty( $plugin_data['Author2'] ) ) {
//        $plugin_meta[1] = $plugin_meta[1] . ', ' . $plugin_data['Author2'];
//    }
//
//
//    return $plugin_meta;
//}
?>
