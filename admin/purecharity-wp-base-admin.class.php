<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    Purecharity
 * @subpackage Purecharity/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Purecharity
 * @subpackage Purecharity/admin
 * @author     Pure Charity <dev@purecharity.com>
 */
class Purecharity_Wp_Base_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @var      string $plugin_name The name of this plugin.
     * @var      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }


    /**
     * Add the Plugin Settings Menu.
     *
     * @since    1.0.0
     */
    function add_admin_menu()
    {
        add_options_page('PureBase&#8482; Settings', 'PureBase&#8482;', 'manage_options', 'pure_base', array('Purecharity_Wp_Base_Admin', 'options_page'));
    }

    /**
     * Checks for the existence of the pure base settings.
     *
     * @since    1.0.0
     */
    public static function settings_exist()
    {
        if (false == get_option('pure_base_settings')) {
            add_option('pure_base_settings');
        }
    }

    /**
     * Initializes the settings page options.
     *
     * @since    1.0.0
     */
    public static function settings_init()
    {
        register_setting('pbPluginPage', 'pure_base_settings');

        add_settings_section(
            'pure_base_pbPluginPage_section',
            __('General settings', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'settings_section_callback'),
            'pbPluginPage'
        );

        add_settings_field(
            'pure_base_mode',
            __('API Mode', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'api_mode_render'),
            'pbPluginPage',
            'pure_base_pbPluginPage_section'
        );

        add_settings_field(
            'pure_base_api_key',
            __('API Key', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'api_key_render'),
            'pbPluginPage',
            'pure_base_pbPluginPage_section'
        );

        add_settings_field(
            'pure_base_main_color',
            __('Main Color', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'main_color_render'),
            'pbPluginPage',
            'pure_base_pbPluginPage_section'
        );

        add_settings_section(
            'purecharity_donations_pdPluginPage_section',
            __('Donation settings', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'donation_settings_section_callback'),
            'pbPluginPage'
        );

        add_settings_field(
            'one_time',
            __('One Time Link', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'one_time_render'),
            'pbPluginPage',
            'purecharity_donations_pdPluginPage_section'
        );

        add_settings_field(
            'recurring',
            __('Recurring Link', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'recurring_render'),
            'pbPluginPage',
            'purecharity_donations_pdPluginPage_section'
        );

        add_settings_section(
            'purecharity_fundraisers_pfPluginPage_section',
            __('Fundraiser settings', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'fundraiser_settings_section_callback'),
            'pbPluginPage'
        );

        add_settings_field(
            'single_view_template',
            __('Single view template', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'single_view_template_render'),
            'pbPluginPage',
            'purecharity_fundraisers_pfPluginPage_section'
        );

        add_settings_section(
            'purecharity_fundraisers_display_pfPluginPage_section',
            __('Fundraiser display settings', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'fundraiser_display_settings_section_callback'),
            'pbPluginPage'
        );

        add_settings_field(
            'live_filter', __('Display Filter', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'live_filter_render'),
            'pbPluginPage',
            'purecharity_fundraisers_display_pfPluginPage_section'
        );

        add_settings_field(
            'fundraise_cause', __('Hide "Fundraise for this cause" link', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'fundraise_cause_render'),
            'pbPluginPage',
            'purecharity_fundraisers_display_pfPluginPage_section'
        );

        add_settings_field(
            'backers_tab', __('Hide the Backers Tab', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'backers_tab_render'),
            'pbPluginPage',
            'purecharity_fundraisers_display_pfPluginPage_section'
        );

        add_settings_field(
            'updates_tab', __('Hide the Updates Tab', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'updates_tab_render'),
            'pbPluginPage',
            'purecharity_fundraisers_display_pfPluginPage_section'
        );

        add_settings_section(
            'purecharity_giving_circles_pgPluginPage_section',
            __('Giving Circles general settings', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'settings_section_callback'),
            'pbPluginPage'
        );

        add_settings_field(
            'round_avatars', __('Round Avatar Images', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'round_avatars_render'),
            'pbPluginPage',
            'purecharity_giving_circles_pgPluginPage_section'
        );

        add_settings_section(
            'purecharity_sponsorships_pbPluginPage_section',
            __('Sponsopship General settings', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'settings_section_callback'),
            'pbPluginPage'
        );

        add_settings_field(
            'plugin_style',
            __('Style to Use', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'plugin_style_render'),
            'pbPluginPage',
            'purecharity_sponsorships_pbPluginPage_section'
        );

        add_settings_section(
            'purecharity_sponsorships_display_pbPluginPage_section',
            __('Display settings', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'display_settings_section_callback'),
            'pbPluginPage'
        );

        add_settings_field(
            'hide_powered_by', __('Hide Powered By Image', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'hide_powered_by_render'),
            'pbPluginPage', 'purecharity_sponsorships_display_pbPluginPage_section'
        );

        add_settings_field(
            'search_input', __('Display Global Search', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'search_input_render'),
            'pbPluginPage', 'purecharity_sponsorships_display_pbPluginPage_section'
        );

        add_settings_field(
            'age_filter', __('Display Age Filter', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'age_filter_render'),
            'pbPluginPage', 'purecharity_sponsorships_display_pbPluginPage_section'
        );

        add_settings_field(
            'gender_filter', __('Display Gender Filter', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'gender_filter_render'),
            'pbPluginPage', 'purecharity_sponsorships_display_pbPluginPage_section'
        );

        add_settings_field(
            'location_filter', __('Display Location Filter', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'location_filter_render'),
            'pbPluginPage', 'purecharity_sponsorships_display_pbPluginPage_section'
        );

        add_settings_field(
            'allowed_custom_fields', __('Allowed Custom Fields', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'allowed_custom_fields_render'),
            'pbPluginPage', 'purecharity_sponsorships_display_pbPluginPage_section'
        );

        add_settings_section(
            'purecharity_sponsorships_3_pbPluginPage_section',
            __('Display settings', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'third_option_settings_section_callback'),
            'pbPluginPage'
        );

        add_settings_field(
            'show_back_link', __('Display Back Link', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'show_back_link_render'),
            'pbPluginPage', 'purecharity_sponsorships_3_pbPluginPage_section'
        );

        add_settings_field(
            'back_link', __('Back Link to (default: back)', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'back_link_render'),
            'pbPluginPage', 'purecharity_sponsorships_3_pbPluginPage_section'
        );

        add_settings_field(
            'show_more_link', __('Display More Info Link', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'show_more_link_render'),
            'pbPluginPage', 'purecharity_sponsorships_3_pbPluginPage_section'
        );

        add_settings_field(
            'more_link', __('More Info Link to', 'wordpress'),
            array('Purecharity_Wp_Base_Admin', 'more_link_render'),
            'pbPluginPage', 'purecharity_sponsorships_3_pbPluginPage_section'
        );

        add_settings_section(
            'purecharity_trips_ptPluginPage_section',
            __('Trips General settings', 'wordpress'),
            array('Purecharity_Wp_Trips_Admin', 'settings_section_callback'),
            'pbPluginPage'
        );

    }

    /**
     * Renders the select for API Mode [ staging, production ].
     *
     * @since    1.0.0
     */
    public static function api_mode_render()
    {

        $options = get_option('pure_base_settings');
        ?>
        <select name="pure_base_settings[mode]">
            <option value="sandbox" <?php @selected($options['mode'], 'sandbox'); ?> >Sandbox</option>
            <option value="production" <?php @selected($options['mode'], 'production'); ?> >Production</option>
            <option value="demo" <?php @selected($options['mode'], 'demo'); ?> >Demo</option>
            <option value="development" <?php @selected($options['mode'], 'development'); ?> >Development</option>
        </select>
        <?php

    }

    /**
     * Renders the text field for API Key.
     *
     * @since    1.0.0
     */
    public static function api_key_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input type="text" name="pure_base_settings[api_key]" value="<?php echo @$options['api_key']; ?>">
        <?php
    }

    /**
     * Renders the color picker for main color.
     *
     * @since    1.0.0
     */
    public static function main_color_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input type="text" id="main_color" name="pure_base_settings[main_color]"
               value="<?php echo @$options['main_color']; ?>">
        <?php
    }

    /**
     * Callback for use with Settings API.
     *
     * @since    1.0.0
     */
    public static function settings_section_callback()
    {
        echo __('General settings for the base plugin. Used across the dependent plugins.', 'wordpress');
    }

    /**
     * Renders the one-time link option.
     *
     * @since    1.0.0
     */
    public static function one_time_render()
    {

        $options = get_option('pure_base_settings');
        ?>
        <input type="text" name="pure_base_settings[one_time]" id="one_time"
               value="<?php echo @$options['one_time']; ?>">

        <?php

    }

    /**
     * Renders the one-time link option.
     *
     * @since    1.0.0
     */
    public static function recurring_render()
    {

        $options = get_option('pure_base_settings');
        ?>
        <input type="text" name="pure_base_settings[recurring]" id="recurring"
               value="<?php echo @$options['recurring']; ?>">
        <?php

    }

    /**
     * Callback for use with Settings API.
     *
     * @since    1.0.0
     */
    public static function Donation_settings_section_callback()
    {
        echo __('Settings for the Pure Charity Donations plugin.', 'wordpress');
    }

    /**
     * Renders the fundraise for this cause.
     *
     * @since    1.0.0
     */
    public static function fundraise_cause_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[fundraise_cause]"
            <?php echo (isset($options['fundraise_cause'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Renders the backers tab.
     *
     * @since    1.0.0
     */
    public static function backers_tab_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[backers_tab]"
            <?php echo (isset($options['backers_tab'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Renders the updates tab.
     *
     * @since    1.0.0
     */
    public static function updates_tab_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[updates_tab]"
            <?php echo (isset($options['updates_tab'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Renders the updates.
     *
     * @since    1.0.0
     */
    public static function single_view_template_render()
    {
        $options = get_option('pure_base_settings');
        $templates = purecharity_get_templates();
        ?>
        <select name="pure_base_settings[single_view_template]">
            <option value="">Inherit from the listing page</option>
            <?php foreach ($templates as $key => $template) { ?>
                <option <?php echo $template == @$options['single_view_template'] ? 'selected' : '' ?>
                        value="<?php echo $template; ?>"><?php echo "$key ($template)" ?></option>
            <?php } ?>
        </select>
        <?php
    }

    /**
     * Renders the live filter.
     *
     * @since    1.0.0
     */
    public static function live_filter_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[live_filter]"
            <?php echo (isset($options['live_filter'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }


    /**
     * Renders the round avatar image switch.
     *
     * @since    1.0.0
     */
    public static function round_avatars_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[round_avatars]"
            <?php echo (isset($options['round_avatars'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Callback for use with Settings API.
     *
     * @since    1.0.0
     */
    public static function fundraiser_settings_section_callback()
    {
        echo __('General settings for Fundraisers.', 'wordpress');
    }

    /**
     * Callback for use with Settings API.
     *
     * @since    1.0.0
     */
    public static function fundraiser_display_settings_section_callback()
    {
        echo __('Display settings for the Fundraisers.', 'wordpress');
    }

    /**
     * Renders the template selector for the single view.
     *
     * @since    1.0.0
     */
    public static function allowed_custom_fields_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input type="hidden" name="pure_base_settings[allowed_custom_fields]" id="custom_fields_value"
               value="<?php echo @$options['allowed_custom_fields']; ?>">

        <a href="javascript:new_custom_field();" class="button button-primary">Add Custom Field</a>

        <ul class="pcs_custom_field header">
            <li>
                <div class="left">
                    <b>Display Name</b>
                </div>
                <div class="right">
                    <b>Original Custom Field Name</b>
                </div>
                <br style="clear: both"/>
            </li>
        </ul>

        <ul class="pcs_custom_field sortable">
            <?php foreach (explode(';', $options['allowed_custom_fields']) as $field) { ?>
                <?php $parsed_field = explode('|', $field); ?>
                <li class="custom_field">

                    <div class="left">
                        <b><?php echo @$parsed_field[1]; ?></b>
                        <input type="text" value="<?php echo @$parsed_field[1]; ?>">
                        <a href="#" class="edit">edit</a>
                        <a href="#" class="save">save</a>
                    </div>

                    <div class="right">
                        <b><?php echo @$parsed_field[0]; ?></b>
                        <input type="text" value="<?php echo @$parsed_field[0]; ?>">
                        <a href="#" class="edit">edit</a>
                        <a href="#" class="save">save</a>
                    </div>

                    <div class="options">
                        <a href="#" class="remove">remove</a>
                    </div>

                    <br style="clear:both"/>
                </li>
            <?php } ?>
        </ul>

        <p>
            Add the allowed custom fields for your sponsorship program, using the format they are inputted into the Pure
            Charity app.<br/>
            <a href="#" id="custom-fields-example">Load Example</a>
            <a href="#" id="custom-fields-example-cancel" style="display:none">Cancel</a>
            <br/>
        <div id="custom-fields-loader"
             data-api-url="<?php echo site_url(); ?>/index.php?__api=1&sponsorship_slug="
             style="display:none">
            <span>Sponsorship Program Slug:</span><br/>
            <input type="text" id="example-program-slug"/><br/>
            <button type="button" id="generate-example" name="button">Load Example</button>
        </div>
        </p>
        <?php
    }

    /**
     * Renders the global search.
     *
     * @since    1.0.0
     */
    public static function search_input_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[search_input]"
            <?php echo (isset($options['search_input'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Renders the powered by display.
     *
     * @since    1.0.0
     */
    public static function hide_powered_by_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[hide_powered_by]"
            <?php echo (isset($options['hide_powered_by'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Renders the age filter.
     *
     * @since    1.0.0
     */
    public static function age_filter_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[age_filter]"
            <?php echo (isset($options['age_filter'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Renders the gender filter.
     *
     * @since    1.0.0
     */
    public static function gender_filter_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[gender_filter]"
            <?php echo (isset($options['gender_filter'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Renders the back link.
     *
     * @since    1.0.0
     */
    public static function show_back_link_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[show_back_link]"
            <?php echo $options['plugin_style'] == 'pure-sponsorships-option3' ? '' : 'disabled' ?>
            <?php echo (isset($options['back_link'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Renders the back link option.
     *
     * @since    1.0.0
     */
    public static function back_link_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="text"
                name="pure_base_settings[back_link]"
                placeholder="javascript:history.go(-1)"
                value="<?php echo @$options['back_link']; ?>"/>
        <?php
    }


    /**
     * Renders the more info link.
     *
     * @since    1.0.0
     */
    public static function show_more_link_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[show_more_link]"
            <?php echo $options['plugin_style'] == 'pure-sponsorships-option3' ? '' : 'disabled' ?>
            <?php echo (isset($options['more_link'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Renders the more link option.
     *
     * @since    1.0.0
     */
    public static function more_link_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="text"
                name="pure_base_settings[more_link]"
                value="<?php echo @$options['more_link']; ?>"/>
        <?php
    }

    /**
     * Renders the location filter.
     *
     * @since    1.0.0
     */
    public static function location_filter_render()
    {
        $options = get_option('pure_base_settings');
        ?>
        <input
                type="checkbox"
                name="pure_base_settings[location_filter]"
            <?php echo (isset($options['location_filter'])) ? 'checked' : '' ?>
                value="true">
        <?php
    }

    /**
     * Renders the plugin style selector.
     *
     * @since    1.0.0
     */
    public static function plugin_style_render()
    {
        $options = get_option('pure_base_settings');
        if (!isset($options['plugin_style'])) {
            $options['plugin_style'] = 'pure-sponsorships-option1';
        }
        ?>
        <input type="radio"
               style="float:left; margin: 57px 10px 0 0"
               name="pure_base_settings[plugin_style]"
               value="pure-sponsorships-option1"
            <?php echo $options['plugin_style'] == 'pure-sponsorships-option1' ? 'checked' : '' ?>
        />
        <label><img src="<?php echo plugins_url('pure-charity-plugin/admin/img/opt1.png'); ?>" width="320"></label>
        <br/>
        <input type="radio"
               style="float:left; margin: 57px 10px 0 0"
               name="pure_base_settings[plugin_style]"
               value="pure-sponsorships-option2"
            <?php echo $options['plugin_style'] == 'pure-sponsorships-option2' ? 'checked' : '' ?>
        />
        <label><img src="<?php echo plugins_url('pure-charity-plugin/admin/img/opt2.png'); ?>" width="320"></label>
        <br/>
        <input type="radio"
               style="float:left; margin: 57px 10px 0 0"
               name="pure_base_settings[plugin_style]"
               value="pure-sponsorships-option3"
            <?php echo $options['plugin_style'] == 'pure-sponsorships-option3' ? 'checked' : '' ?>
        />
        <label><img src="<?php echo plugins_url('pure-charity-plugin/admin/img/opt3.png'); ?>" width="320"></label>
        <?php
    }

    /**
     * Callback for use with Settings API.
     *
     * @since    1.0.0
     */
    public static function third_option_settings_section_callback()
    {
        echo __('Display settings for the sponsorships plugin. * Only available when using the third layout option.', 'wordpress');
    }

    /**
     * Callback for use with Settings API.
     *
     * @since    1.0.0
     */
    public static function display_settings_section_callback()
    {
        echo __('Display settings for the sponsorships plugin.', 'wordpress');
    }


    /**
     * Creates the options page.
     *
     * @since    1.0.0
     */
    public static function options_page()
    {
        ?>
        <div class="wrap">
            <form action="options.php" method="post" class="pure-settings-form">
                <?php
                echo '<img align="left" src="' . PURECHARITY_BASE_URL . 'public/img/purecharity.png" > ';
                ?>
                <h2 style="padding-left:100px;padding-top: 20px;padding-bottom: 50px;border-bottom: 1px solid #ccc;">
                    PureBase&#8482; Settings</h2>

                <?php
                settings_fields('pbPluginPage');
                do_settings_sections('pbPluginPage');
                submit_button();
                ?>

            </form>
        </div>
        <?php
    }

    /**
     * Register the stylesheets for the Dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style('spectrum', plugin_dir_url(__FILE__) . 'css/spectrum.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/purecharity-wp-base-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook)
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/purecharity-wp-base-admin.js', array('jquery'), $this->version, false);
        wp_enqueue_script('admin-color-picker', plugins_url('admin/js/spectrum.js', dirname(__FILE__)));
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
    }

}
