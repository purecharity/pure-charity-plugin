<?php

/**
 * The file that defines the core plugin class
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    pure-charity-plugin
 * @subpackage pure-charity-plugin/includes
 */

class Purecharity {

    /**
     * Used to do not call class twice
     *
     * @since    1.0.0
     * @access   private
     * @var      Purecharity    $instance    Instance of this class.
     */
    private static $instance = null;

    /**
     * The API Key used for API requests.
     *
     * @since    1.0.0
     * @access   private
     * @var      Purecharity_Api_Key    $api_key    The API Key retrieved from the settings page.
     */
//    private static $api_key = false;

    /**
     * The API base url used for API requests.
     *
     * @since    1.0.0
     * @access   private
     * @var      Purecharity_Api_Url    $api_url    The API base url that will be used on API requests.
     */
//    private static $api_url = false;

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
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Purecharity_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * Define the core functionality of the plugin.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->version = '1.0.0';
        $this->plugin_name = 'pure-charity';

        $this->set_loader();
    }

    /**
     * Get instance of class
     *
     * @since    1.0.0
     * @return    Purecharity    Instance of class.
     */
    public static function getInstance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
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
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Purecharity_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain( $this->get_plugin_name(), false, PURECHARITY_BASE_PATH . '/lang/' );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->add_action( 'plugins_loaded', self::$instance, 'load_plugin_textdomain' );

        $this->loader->run();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Purecharity_Loader. Orchestrates the hooks of the plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_loader() {
        require_once PURECHARITY_BASE_PATH . 'includes/purecharuty-loader.class.php';

        $this->loader = Purecharity_Loader::getInstance();
    }

}

$Purecharity = Purecharity::getInstance();
$Purecharity->run();