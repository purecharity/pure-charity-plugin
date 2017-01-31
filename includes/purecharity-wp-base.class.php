<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    Purecharity
 * @subpackage Purecharity/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Purecharity
 * @subpackage Purecharity/includes
 * @author     Pure Charity <dev@purecharity.com>
 */
class Purecharity_Wp_Base
{


    /**
     * The API Key used for API requests.
     *
     * @since    1.0.0
     * @access   private
     * @var      Purecharity_Wp_Base_Api_Key $api_key The API Key retrieved from the settings page.
     */
    private static $api_key = false;

    /**
     * The API base url used for API requests.
     *
     * @since    1.0.0
     * @access   private
     * @var      Purecharity_Wp_Base_Api_Url $api_url The API base url that will be used on API requests.
     */
    private static $api_url = false;

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Purecharity_Wp_Base_Loader $loader Maintains and registers all hooks for the plugin.
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
     * Formats used on the widgets.
     *
     * @since    1.0.0
     */
    const DATE_FORMAT = "F j, Y";
    const MONTH_FORMAT = "F Y";

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the Dashboard and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {

        $this->plugin_name = PURECHARITY_PLUGIN_NAME;
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

        $this->init_api();

        // Initialize the shortcodes
        Purecharity_Wp_Donations_Shortcode::init();
        Purecharity_Wp_Fundraisers_Shortcode::init();
        Purecharity_Wp_Givingcircles_Shortcode::init();
        Purecharity_Wp_Sponsorships_Shortcode::init();
        Purecharity_Wp_Trips_Shortcode::init();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Purecharity_Wp_Base_Loader. Orchestrates the hooks of the plugin.
     * - Purecharity_Wp_Base_i18n. Defines internationalization functionality.
     * - Purecharity_Wp_Base_Admin. Defines all hooks for the dashboard.
     * - Purecharity_Wp_Base_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once PURECHARITY_BASE_PATH . 'includes/purecharity-wp-base-loader.class.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once PURECHARITY_BASE_PATH . 'includes/purecharity-wp-base-i18n.class.php';

        /**
         * The class responsible for defining all actions that occur in the Dashboard.
         */
        require_once PURECHARITY_BASE_PATH . 'admin/purecharity-wp-base-admin.class.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once PURECHARITY_BASE_PATH . 'public/purecharity-wp-base-public.class.php';

        $this->loader = new Purecharity_Wp_Base_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Purecharity_Wp_Base_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Purecharity_Wp_Base_i18n();
        $plugin_i18n->set_domain($this->get_plugin_name());

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the dashboard functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Purecharity_Wp_Base_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_menu');
        $this->loader->add_action('admin_init', $plugin_admin, 'settings_init');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new Purecharity_Wp_Base_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'sponsorship_enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('wp_head', $this, 'set_fr_meta_tags');

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Purecharity_Wp_Base_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Initializes the API settings.
     *
     * @since    1.0.0sa
     */
    private function init_api()
    {
        $pure_base_options = get_option('pure_base_settings');
        $mode = $pure_base_options['mode'];
        self::$api_key = $pure_base_options['api_key'];

        if ('production' == $mode) {
            self::$api_url = "http://purecharity.com/api/";
        } elseif ('sandbox' == $mode) {
            self::$api_url = "https://staging.purecharity.com/api/";
        } elseif ('demo' == $mode) {
            self::$api_url = "https://demo.purecharity.com/api/";
        } else {
            self::$api_url = $_ENV["API_URL"];
        }

    }

    /**
     * Runs the API requests.
     *
     * @since    1.0.0
     * @return    string    The result of the API request.
     */
    public static function api_call($endpoint)
    {
        $response = false;

        // if(ini_get('allow_url_fopen')){

        //   $headers = array(
        //     'http' => array(
        //       'method' => 'GET',
        //       'header' => "Authorization: Token token=\"". self::$api_key ."\"\r\n"
        //     )
        //   );
        //   $context = stream_context_create($headers);
        //   $response = file_get_contents(self::$api_url . $endpoint, false, $context);

        // }else{

        $headers = array();
        $headers[] = "Authorization: Token token=\"" . self::$api_key . "\"\r\n";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$api_url . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        // }

        if ($response) {
            $response = json_decode($response);
        }

        return $response;
    }

    /**
     * Sets the meta tags for the facebook sharing.
     *
     * @since    1.0.0
     */
    public function set_fr_meta_tags()
    {
        if (isset($_GET['fundraiser']) && false) {
            $fundraiser = $this->api_call('fundraisers/show?fundraiser=' . $_GET['fundraiser'])->fundraiser;
            echo '
        <meta property="og:title" content="' . strip_tags($fundraiser->name) . '">
        <meta property="og:image" content="' . $fundraiser->images->large . '">
        <meta property="og:description" content="' . strip_tags($fundraiser->about) . '">
      ' . "\n";
        }
    }

    /**
     * Country list for use on widget.
     *
     * @since    1.0.0
     */
    public static function widget_country_list()
    {
        $base_plugin = new Purecharity_Wp_Base();
        $countries = $base_plugin->api_call('countries');
        if ($countries != null) {
            sort($countries->countries);
            $current_country = get_query_var('country');
            $content = '<ul class="purecharity-trips-countries-widget">';
            foreach ($countries->countries as $country) {
                if ($country == '') {
                    continue;
                }
                $content .= "<li><a href=\"?country=" . urlencode($country) . "\""
                    . ($country == $current_country ? ' class="selected"' : '')
                    . ">" . $country . "</a></li>";
            }
            $content .= '</ul>';
            return $content;
        }
    }

    /**
     * Region list for use on widget.
     *
     * @since    1.0.0
     */
    public static function widget_region_list()
    {
        $base_plugin = new Purecharity_Wp_Base();
        $regions = $base_plugin->api_call('regions');
        if ($regions != null) {
            sort($regions->regions);
            $current_region = get_query_var('region');
            $content = '<ul class="purecharity-trips-regions-widget">';
            foreach ($regions->regions as $region) {
                if ($region == '') {
                    continue;
                }
                $content .= "<li><a href=\"?region=" . $region->id . "\""
                    . ($region->id == $current_region ? ' class="selected"' : '')
                    . ">" . $region->name . "</a></li>";
            }
            $content .= '</ul>';
            return $content;
        }
    }

    /**
     * Months list for use on widget.
     *
     * @since    1.0.0
     */
    public static function widget_month_list()
    {
        $base_plugin = new Purecharity_Wp_Base();
        $all_dates = $base_plugin->api_call('events?scope=dates');
        $months = array();
        foreach ($all_dates->events as $dates) {
            $start = new DateTime($dates->starts_at);
            $start->modify('first day of this month');
            $end = new DateTime($dates->ends_at);
            $end->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period = new DatePeriod($start, $interval, $end);
            foreach ($period as $dt) {
                $key = $dt->format('Y-m');
                if (!array_key_exists($key, $months)) {
                    $months[$key] = $dt->format(self::MONTH_FORMAT);
                }
            }
        }
        ksort($months);
        $current_month = get_query_var('date');
        $content = '<ul class="purecharity-trips-months-widget">';
        foreach ($months as $date => $label) {
            $content .= "<li><a href=\"?date=" . urlencode($date) . "\""
                . ($date == $current_month ? ' class="selected"' : '')
                . ">" . $label . "</a></li>";
        }
        $content .= '</ul>';
        return $content;
    }

    /**
     * Months list for use on widget.
     *
     * @since    1.0.0
     */
    public static function widget_tag_list()
    {
        $base_plugin = new Purecharity_Wp_Base();
        $all_tags = $base_plugin->api_call('events/tags');

        $base_url = get_site_url();

        $tags = $all_tags->tags;
        asort($tags);
        $content = '<ul class="purecharity-trips-tags-widget">';
        foreach ($tags as $event_tag) {
            $content .= '<li><a href="' . $base_url . '/missions/upcoming-missions?trip_tag=' . $event_tag->name . '"'
                . ((isset($_GET['trip_tag']) && $_GET['trip_tag'] == $event_tag->name) ? ' class="selected"' : '')
                . ">" . $event_tag->name . "</a></li>";
        }
        $content .= '</ul>';
        return $content;
    }

}
