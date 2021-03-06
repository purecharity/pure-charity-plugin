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
 * Author URI:        http://purecharity.com
 * Author2:           <a href="http://zemlianoi.com">Aleskandr Zemlianoi</a>
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pure-charity
 * Domain Path:       /lang
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('PURECHARITY_BASE_URL', plugin_dir_url(__FILE__));
define('PURECHARITY_BASE_PATH', plugin_dir_path(__FILE__));
define('PURECHARITY_PLUGIN_NAME', 'purecharity');

/**
 * The code that runs during plugin activation.
 */
require_once PURECHARITY_BASE_PATH . 'includes/purecharity-wp-base-template-tags-helper.php';

/**
 * The GitHub updater.
 */
require_once PURECHARITY_BASE_PATH . 'includes/purecharity-wp-base-updater.class.php';

/**
 * The code that runs during plugin activation.
 */
require_once PURECHARITY_BASE_PATH . 'includes/purecharity-wp-base-activator.class.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once PURECHARITY_BASE_PATH . 'includes/purecharity-wp-base-deactivator.class.php';

/**
 * The Donation shortcode.
 */
require_once plugin_dir_path(__FILE__) . 'includes/purecharity-wp-donations-shortcode.php';

/**
 * The Fundraisers shortcode.
 */
require_once plugin_dir_path(__FILE__) . 'includes/purecharity-wp-fundraisers-shortcode.php';

/**
 * The Fundraisers paginator.
 */
require_once plugin_dir_path(__FILE__) . 'includes/purecharity-wp-fundraisers-paginator.php';

/**
 * The Givingcircles shortcode.
 */
require_once plugin_dir_path(__FILE__) . 'includes/purecharity-wp-givingcircles-shortcode.php';

/**
 * The Sponsorship shortcode.
 */
require_once plugin_dir_path(__FILE__) . 'includes/purecharity-wp-sponsorships-shortcode.php';

/**
 * The Sponsorship paginator.
 */
require_once plugin_dir_path(__FILE__) . 'includes/purecharity-wp-sponsorships-paginator.php';

/**
 * The Trips shortcode.
 */
require_once plugin_dir_path(__FILE__) . 'includes/purecharity-wp-trips-shortcode.php';

/**
 * The Trips paginator.
 */
require_once plugin_dir_path(__FILE__) . 'includes/purecharity-wp-trips-paginator.php';

/**
 * The template tags for trips.
 */
require_once plugin_dir_path(__FILE__) . 'includes/template_tags.php';

/**
 * The Widgets.
 */
require_once plugin_dir_path(__FILE__) . 'includes/widget_region.class.php';
require_once plugin_dir_path(__FILE__) . 'includes/widget_country.class.php';
require_once plugin_dir_path(__FILE__) . 'includes/widget_months.class.php';
require_once plugin_dir_path(__FILE__) . 'includes/widget_tags.class.php';

/**
 * This action is documented in includes/purecharity-wp-base-activator.class.php
 */
register_activation_hook(__FILE__, array('Purecharity_Wp_Base_Activator', 'activate'));

/**
 * This action is documented in includes/purecharity-wp-base-deactivator.class.php
 */
register_deactivation_hook(__FILE__, array('Purecharity_Wp_Base_Deactivator', 'deactivate'));

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once PURECHARITY_BASE_PATH . 'includes/purecharity-wp-base.class.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pure_base()
{
    $plugin = new Purecharity_Wp_Base();
    $plugin->run();
}

run_pure_base();

/**
 * Word pluralizer helper for all the plugins.
 *
 * @since    1.0.0
 */
function pluralize($count, $singular, $plural = false)
{
    if (!$plural) $plural = $singular . 's';
    return $count == 1 ? $singular : $plural;
}


/**
 * Text truncating alias
 *
 * @since    1.0.0
 */
function ps_truncate($text, $chars = 25)
{
    $text = $text . " ";
    $text = substr($text, 0, $chars);
    $text = substr($text, 0, strrpos($text, ' '));
    $text = $text . "...";
    return $text;
}

/* ALIAS ps_truncate() */
if (!function_exists('truncate')) {
    function truncate($text, $chars = 25)
    {
        ps_truncate($text, $chars);
    }
}


/*
 * Plugin updater using GitHub
 *
 * Auto Updates through GitHub
 *
 * @since   1.0.0
 */
add_action('init', 'purecharity_wp_base_updater');
function purecharity_wp_base_updater()
{
    if (!get_option('pure_base_name')) {
        add_option('pure_base_name', PURECHARITY_PLUGIN_NAME, '', 'no');
    }
    define('WP_GITHUB_FORCE_UPDATE', true);
    if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
        $config = array(
            'slug' => plugin_basename(__FILE__),
            'proper_folder_name' => PURECHARITY_PLUGIN_NAME,
            'api_url' => 'https://api.github.com/repos/purecharity/pure-base',
            'raw_url' => 'https://raw.githubusercontent.com/purecharity/pure-base/master/purecharity-wp-base/',
            'github_url' => 'https://github.com/purecharity/pure-base',
            'zip_url' => 'https://github.com/purecharity/pure-base/archive/master.zip',
            'sslverify' => true,
            'requires' => '3.0',
            'tested' => '3.3',
            'readme' => 'README.md',
            'access_token' => '',
        );
        new WP_GitHub_Updater($config);
    }
}

/**
 * Returns the Base plugin file path
 *
 * @since    1.0.0
 */
function purecharity_plugin_template()
{
    return PURECHARITY_BASE_PATH . 'public/partials/purecharity-plugin-template.php';
}

/**
 * Returns the usable page templates and injects the custom template
 *
 * @since    1.0.0
 */
function purecharity_get_templates()
{
    $templates = get_page_templates();
    $templates['[Plugin Template] Default single view'] = 'purecharity-plugin-template.php';
    return $templates;
}

add_filter('extra_plugin_headers', 'add_extra_headers');

function add_extra_headers()
{
    return array('Author2');
}

add_filter('plugin_row_meta', 'filter_authors_row_meta', 1, 4);

function filter_authors_row_meta($plugin_meta, $plugin_file, $plugin_data, $status)
{
    if (empty($plugin_data['Author'])) {
        return $plugin_meta;
    }

    if (!empty($plugin_data['Author2'])) {
        $plugin_meta[1] = $plugin_meta[1] . ', ' . $plugin_data['Author2'];
    }

    return $plugin_meta;
}