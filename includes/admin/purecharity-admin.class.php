<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    pure-charity-plugin
 * @subpackage pure-charity-plugin/admin
 */
class Purecharity_Admin extends Purecharity {

    /**
     * Used to do not call class twice
     *
     * @since    1.0.0
     * @access   private
     * @var      Purecharity_Admin    $instance    Instance of this class.
     */
    private static $instance = null;

    /**
     * Define admin hooks.
     *
     * @since    1.0.0
     */
    public function __construct() {

    }

    /**
     * Get instance of class
     *
     * @since    1.0.0
     * @return    Purecharity_Admin    Instance of class.
     */
    public static function getInstance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Add the Plugin Settings Menu.
     *
     * @since    1.0.0
     */
    function add_admin_menu() {
        add_options_page( 'PureBase&#8482; Settings', 'PureBase&#8482;', 'manage_options', 'pure_base', ['Purecharity_Admin', 'options_page'] );
    }

    /**
     * Initializes the settings page options.
     *
     * @since    1.0.0
     */
    public static function settings_init() {
        register_setting( 'pc_settings_section', 'purecharity_settings' );

        add_settings_section(
            'pc_plugin_section',
            __( 'General settings', 'wordpress' ),
            [ 'Purecharity_Admin', 'settings_section_callback' ],
            'pc_settings_section'
        );

        add_settings_field(
            'pc_mode',
            __( 'API Mode', 'wordpress' ),
            [ 'Purecharity_Admin', 'api_mode_render' ],
            'pc_settings_section',
            'pc_plugin_section'
        );

        add_settings_field(
            'pc_api_key',
            __( 'API Key', 'wordpress' ),
            [ 'Purecharity_Admin', 'api_key_render' ],
            'pc_settings_section',
            'pc_plugin_section'
        );

        add_settings_field(
            'pc_main_color',
            __( 'Main Color', 'wordpress' ),
            [ 'Purecharity_Admin', 'main_color_render' ],
            'pc_settings_section',
            'pc_plugin_section'
        );
    }

    /**
     * Creates the options page.
     *
     * @since    1.0.0
     */
    public static function options_page() {
        ?>

        <div class="wrap">
            <form action="options.php" method="post" class="pure-settings-form">
                <img align="left" src="<?= PURECHARITY_BASE_URL ?>assets/img/purecharity.png">
                <h2 style="padding-left:100px;padding-top: 20px;padding-bottom: 50px;border-bottom: 1px solid #ccc;">PureBase&#8482; Settings</h2>

                <?php
                settings_fields('pc_settings_section');
                do_settings_sections('pc_settings_section');
                submit_button();
                ?>
            </form>
        </div>

        <?php
    }

    /**
     * Callback for use with Settings API.
     *
     * @since    1.0.0
     */
    public static function settings_section_callback() {
        echo __( 'General settings for the base plugin. Used across the dependent plugins.', 'wordpress' );
    }

    /**
     * Renders the select for API Mode [ staging, production ].
     *
     * @since    1.0.0
     */
    public static function api_mode_render(  ) {
        $options = get_option( 'pure_base_settings' );
        ?>

        <select name="pure_base_settings[mode]">
            <option value="sandbox" <?php @selected( $options['mode'], 'sandbox' ); ?> >Sandbox</option>
            <option value="production" <?php @selected( $options['mode'], 'production' ); ?> >Production</option>
            <option value="demo" <?php @selected( $options['mode'], 'demo' ); ?> >Demo</option>
            <option value="development" <?php @selected( $options['mode'], 'development' ); ?> >Development</option>
        </select>

        <?php
    }

    /**
     * Renders the text field for API Key.
     *
     * @since    1.0.0
     */
    public static function api_key_render() {
        $options = get_option( 'pure_base_settings' );
        echo '<input type="text" name="pure_base_settings[api_key]" value="' . @$options['api_key'] . '">';
    }

    /**
     * Renders the color picker for main color.
     *
     * @since    1.0.0
     */
    public static function main_color_render() {
        $options = get_option( 'pure_base_settings' );
        echo '<input type="text" id="main_color" name="pure_base_settings[main_color]" value="' . @$options['main_color'] . '">';
    }
}