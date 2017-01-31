<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    Purecharity_Wp_Base
 * @subpackage Purecharity_Wp_Base/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Purecharity_Wp_Base
 * @subpackage Purecharity_Wp_Base/public
 * @author     Pure Charity <dev@purecharity.com>
 */
class Purecharity_Wp_Base_Public
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
     * The Shortcode options.
     *
     * @since    1.0.0
     * @access   public
     * @var      string $options The Shortcode options.
     */
    public static $options;

    /**
     * The Fundraise.
     *
     * @since    1.0.0
     * @access   public
     * @var      string $fundraiser The Fundraiser.
     */
    public static $fundraiser;

    /**
     * The Fundraisers collection.
     *
     * @since    1.0.0
     * @access   public
     * @var      string $fundraisers The Fundraisers collection.
     */
    public static $fundraisers;

    /**
     * The Giving Circle.
     *
     * @since    1.0.0
     * @access   public
     * @var      string $givingcircle The Giving Circle.
     */
    public static $givingcircle;

    /**
     * The Giving Circles collection.
     *
     * @since    1.0.0
     * @access   public
     * @var      string $givingcircles The Giving Circles collection.
     */
    public static $givingcircles;

    /**
     * The sponsorship.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $sponsorship The sponsorship.
     */

    public static $sponsorship;

    /**
     * The sponsorships.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $sponsorships The sponsorships.
     */
    public static $sponsorships;

    /**
     * The full list of sponsorships.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $sponsorships The full list of sponsorships.
     */

    public static $sponsorships_full;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @var      string $plugin_name The name of the plugin.
     * @var      string $version The version of this plugin.
     */

    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/purecharity-wp-base-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/purecharity-wp-base-public.js', array('jquery'), $this->version, false);
        wp_enqueue_script('pure-sponsorships-selects-js', plugin_dir_url(__FILE__) . 'js/jquery.simpleselect.js', $this->version, false);
    }

    /**
     * Powered by at the bottom of the page.
     *
     * @since    1.0.0
     */
    public static function powered_by()
    {
        return '
			<div class="poweredby">
          		<a href="https://purecharity.com/nonprofits/">Powered by Pure Charity</a>
      		</div>
		';
    }

    /**
     * Includes the sharing links.
     *
     * @since    1.0.0
     */
    public static function sharing_links($which = array(), $text = '', $title = '', $image = '')
    {
        $current_url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

        $facebook_url = 'https://www.facebook.com/sharer.php?p[url]=' . self::current_page_url();

        $widgets = array();
        $widgets['facebook'] = '
			<a style="float:left;" href="' . $facebook_url . '">
				<img src="' . plugins_url('/img/facebook.png', __FILE__) . '" />
			</a>
		';

        $widgets['twitter'] = '
			<a href="https://twitter.com/home?status=' . $title . ' ' . self::current_page_url() . '">
				<img src="' . plugins_url('/img/twitter.png', __FILE__) . '" />
			</a>
		';

        if (count($which) == 0) {
            return join('', $widgets);
        } else {
            $html = '';
            foreach ($which as $w) {
                if (isset($widgets[$w])) {
                    $html .= $widgets[$w];
                };
            }
            return $html;
        }
    }

    /**
     * Returns the current page url.
     *
     * @since    1.0.0
     */
    public static function current_page_url($cut_params = false)
    {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"])) {
            if ($_SERVER["HTTPS"] == "on") {
                $pageURL .= "s";
            }
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        if ($cut_params) {
            return split('?', $pageURL);
        } else {
            return $pageURL;
        }
    }

    /**
     * Not found layout for single display.
     *
     * @since    1.0.0
     */
    public static function pc_url()
    {
        $pure_base_options = get_option('pure_base_settings');
        $mode = $pure_base_options['mode'];
        if ($mode == 'production') {
            return 'https://purecharity.com';
        } elseif ('sandbox' == $mode) {
            return 'https://staging.purecharity.com';
        } elseif ('demo' == $mode) {
            return 'https://demo.purecharity.com';
        } else {
            return $_ENV["API_URL"];
        }
    }

    public static function donation_form($options)
    {

        $html = self::print_custom_styles();
        $html .= '
			<div class="container">
				<form class="pure-donations clearfix">
	        <input class="donatefield" name="give" type="number" placeholder="$ USD" /><br/>
	        <input class="button donatesubmit" data-url="' . $options['recurring'] . '" name="donaterecurring" type="submit" value="Give Recurring" />
	        <input class="button donatesubmit" data-url="' . $options['one_time'] . '" name="donateonetime" type="submit" value="Give One-Time" />
	      </form>
			</div> 
		';
        return $html;
    }

    /**
     * Prints the custom styles
     *
     * @since    1.0.0
     */
    public static function print_custom_styles()
    {
        $base_settings = get_option('pure_base_settings');
        //$pd_settings = get_option( 'purecharity_donations_settings' );

        // Default theme color
        if (@$base_settings['plugin_color'] == NULL || @$base_settings['plugin_color'] == '') {
            if (@$base_settings['main_color'] == NULL || @$base_settings['main_color'] == '') {
                $color = '#CA663A';
            } else {
                $color = @$base_settings['main_color'];
            }
        } else {
            $color = @$base_settings['plugin_color'];
        }

        $html = '<style>';
        $html .= '
				.container form.pure-donations input.button { background: ' . $color . ' !important; }
		';
        $html .= '</style>';

        return $html;
    }

    public static function list_not_found($default = true)
    {
        $html = '<p class="fr-not-found" style="' . ($default ? '' : 'display:none') . '">No Fundraisers Found.</p>' . ($default ? Purecharity_Wp_Base_Public::powered_by() : '');
        return $html;
    }

    /**
     * Not found layout for single display.
     *
     * @since    1.0.0
     */
    public static function not_found()
    {
        return "<p>Fundraiser Not Found.</p>" . Purecharity_Wp_Base_Public::powered_by();;
    }

    /**
     * Live filter for table.
     *
     * @since    1.0.0
     */
    public static function live_search()
    {

        $options = get_option('pure_base_settings');

        if (isset($options["live_filter"]) && (empty(self::$options['hide_search']) || self::$options['hide_search'] != 'true')) {
            $html = '
        <div class="fr-filtering">
          <form method="get">
            <fieldset class="livefilter fr-livefilter">
              <legend>
                <label for="livefilter-input">
                  <strong>Search Fundraisers:</strong>
                </label>
              </legend>
              <input id="livefilter-input" class="fr-livefilter-input" value="' . @$_GET['query'] . '" name="query" type="text">
              <button class="fr-filtering-button" type="submit">Filter</button>
              ' . (@$_GET['query'] != '' ? '<a href="#" onclick="jQuery(this).prev().prev().val(\'\'); jQuery(this).parents(\'form\').submit(); return false;">Clear filter</a>' : '') . '
            </fieldset>
          </form>
        </div>
      ';
        } else {
            $html = '';
        }
        return $html;
    }

    /**
     * List of Fundraisers, grid option.
     *
     * @since    1.0.0
     */
    public static function listing()
    {

        $options = get_option('pure_base_settings');

        $html = self::fr_print_custom_styles();
        $html .= '
      <div class="fr-list-container">
        ' . self::live_search() . '
        <table class="fundraiser-table option1">
          <tr>
              <th colspan="2">Fundraiser Name</th>
            </tr>
    ';
        $i = 0;

        $used = array();
        foreach (self::$fundraisers->external_fundraisers as $fundraiser) {
            if (!in_array($fundraiser->id, $used)) {
                array_push($used, $fundraiser->id);
                $title = $fundraiser->name;
                if (isset(self::$options['title']) && self::$options['title'] == 'owner_name') {
                    $title = $fundraiser->owner->name;
                }
                if (isset(self::$options['title']) && self::$options['title'] == 'title_and_owner_name') {
                    $title = $fundraiser->name . ' by ' . $fundraiser->owner->name;
                }

                $class = $i & 1 ? 'odd' : 'even';
                $i += 1;
                $html .= '
          <tr class="row ' . $class . ' fundraiser_' . $fundraiser->id . '">
              <td>' . $title . '</td>
              <td>
                <a class="fr-themed-link" href="?fundraiser=' . $fundraiser->slug . '">More Info</a>
                <a class="donate
                " href="' . Purecharity_Wp_Base_Public::pc_url() . '/fundraisers/' . $fundraiser->id . '/fund">Donate Now</a>
            </td>
           </tr>
        ';
            }
        }

        $html .= '
      </table>
        ' . self::list_not_found(false) . '
      </div>
    ';
        $html .= Purecharity_Wp_Base_Public::powered_by();

        return $html;
    }

    /**
     * List of Fundraisers.
     *
     * @since    1.0.0
     */
    public static function listing_grid($opts)
    {

        $layout = empty($opts['layout']) ? 1 : $opts['layout'];

        self::$options = get_option('purecharity_fundraisers_settings');

        switch ((int)$layout) {
            case 1:
                return self::grid_option_1();
                break;
            case 2:
                return self::grid_option_2();
                break;
            case 3:
                return self::grid_option_3();
                break;
            default:
                return self::grid_option_1();
                break;
        }
    }

    /**
     * Grid listing layout option 1.
     *
     * @since    1.0.0
     */
    public static function grid_option_1()
    {
        $html = self::fr_print_custom_styles();
        $html .= '<div class="fr-list-container pure_centered pure_row is-grid">' . self::live_search();
        $html .= '<div>';

        $used = array();
        $counter = 1;
        foreach (self::$fundraisers->external_fundraisers as $fundraiser) {
            if (!in_array($fundraiser->id, $used)) {
                array_push($used, $fundraiser->id);

                $title = $fundraiser->name;
                if (isset(self::$options['title']) && self::$options['title'] == 'owner_name') {
                    $title = $fundraiser->owner->name;
                }
                if (isset(self::$options['title']) && self::$options['title'] == 'title_and_owner_name') {
                    $title = $fundraiser->name . '<br /> by ' . $fundraiser->owner->name;
                }

                if ($fundraiser->images->medium == NULL) {
                    $image = $fundraiser->images->large;
                } else {
                    $image = $fundraiser->images->medium;
                }

                $funded = self::percent(($fundraiser->funding_goal - $fundraiser->funding_needed), $fundraiser->funding_goal);
                $html .= '
          <div class="fr-grid-list-item pure_span_6 pure_col fundraiser_' . $fundraiser->id . '">
            <div class="fr-grid-list-content">
        ';

                $html .= '
          <div class="fr-listing-avatar-container pure_span24">
            <div class="fr-listing-avatar" href="#" style="background-image: url(' . $image . ')">
              <a href="?fundraiser=' . $fundraiser->slug . '" class="overlay-link"></a>
            </div>
          </div>
        ';

                $html .= '
          <div class="fr-grid-item-content pure_col pure_span_24">
            <div class="fr-grid-title-container">
              <p class="fr-grid-title">' . $title . '</p>
              <p class="fr-grid-desc">' . strip_tags(truncate($fundraiser->about, 100)) . '</p>
            </div>
            ' . self::grid_funding_stats($fundraiser) . '
          </div>
          <div class="fr-actions pure_col pure_span_24">
            <a class="fr-themed-link" href="?fundraiser=' . $fundraiser->slug . '">More</a>
            <a class="fr-themed-link" target="_blank" href="' . Purecharity_Wp_Base_Public::pc_url() . '/fundraisers/' . $fundraiser->id . '/fund">Donate</a>
          </div>
        ';

                $html .= '
            </div>
          </div>
        ';
                if ($counter % 4 == 0) {
                    $html .= '<hr class="hidden"></hr>';
                }
                $counter++;
            }
        }

        $html .= self::list_not_found(false);
        $html .= '</div>';
        $html .= '</div>';
        $html .= Purecharity_Wp_Fundraisers_Paginator::page_links(self::$fundraisers->meta);
        $html .= Purecharity_Wp_Base_Public::powered_by();

        return $html;
    }

    /**
     * Grid listing layout option 2.
     *
     * @since    1.0.0
     */
    public static function grid_option_2()
    {
        $html = self::fr_print_custom_styles();
        $html .= '<div class="fr-list-container pure_centered pure_row is-grid">' . self::live_search();
        $html .= '<div>';

        $used = array();
        $counter = 1;
        foreach (self::$fundraisers->external_fundraisers as $fundraiser) {
            if (!in_array($fundraiser->id, $used)) {
                array_push($used, $fundraiser->id);

                $title = $fundraiser->name;
                if (isset(self::$options['title']) && self::$options['title'] == 'owner_name') {
                    $title = $fundraiser->owner->name;
                }
                if (isset(self::$options['title']) && self::$options['title'] == 'title_and_owner_name') {
                    $title = $fundraiser->name . '<br /> by ' . $fundraiser->owner->name;
                }

                if ($fundraiser->images->medium == NULL) {
                    $image = $fundraiser->images->large;
                } else {
                    $image = $fundraiser->images->medium;
                }

                $funded = self::percent(($fundraiser->funding_goal - $fundraiser->funding_needed), $fundraiser->funding_goal);
                $html .= '
          <div class="fr-grid-list-item pure_span_8 pure_col fundraiser_' . $fundraiser->id . '">
            <div class="fr-grid-list-content">
              <div class="fr-listing-avatar-container extended pure_span24">
                <div class="fr-listing-avatar" href="#" style="background-image: url(' . $image . ')">
                  <a href="?fundraiser=' . $fundraiser->slug . '" class="overlay-link"></a>
                </div>
              </div>
              <div class="fr-grid-item-content pure_col pure_span_24">
                <div class="fr-grid-title-container">
                  <p class="fr-grid-title extended">' . $title . '</p>
                  <p class="fr-grid-desc extended">' . strip_tags(truncate($fundraiser->about, 150)) . '</p>
                </div>
                ' . self::grid_funding_stats($fundraiser, 2) . '
              </div>
              <div class="fr-actions extended pure_col pure_span_24">
                <a class="fr-themed-link" href="?fundraiser=' . $fundraiser->slug . '">More</a>
                <a class="fr-themed-link" target="_blank" href="' . Purecharity_Wp_Base_Public::pc_url() . '/fundraisers/' . $fundraiser->id . '/fund">Donate</a>
              </div>
            </div>
          </div>
        ';
                if ($counter % 3 == 0) {
                    $html .= '<div class="clearfix"></div>';
                }
                $counter++;
            }
        }

        $html .= self::list_not_found(false);
        $html .= '</div>';
        $html .= '</div>';
        $html .= Purecharity_Wp_Fundraisers_Paginator::page_links(self::$fundraisers->meta);
        $html .= Purecharity_Wp_Base_Public::powered_by();

        return $html;
    }

    /**
     * Grid listing layout option 3.
     *
     * @since    1.0.0
     */
    public static function grid_option_3()
    {
        $html = self::fr_print_custom_styles();
        $html .= '<div class="fr-list-container pure_centered pure_row is-grid">' . self::live_search();
        $html .= '<div>';

        $used = array();
        $counter = 1;
        foreach (self::$fundraisers->external_fundraisers as $fundraiser) {
            if (!in_array($fundraiser->id, $used)) {
                array_push($used, $fundraiser->id);

                $title = $fundraiser->name;
                if (isset(self::$options['title']) && self::$options['title'] == 'owner_name') {
                    $title = $fundraiser->owner->name;
                }
                if (isset(self::$options['title']) && self::$options['title'] == 'title_and_owner_name') {
                    $title = $fundraiser->name . '<br /> by ' . $fundraiser->owner->name;
                }

                if ($fundraiser->images->medium == NULL) {
                    $image = $fundraiser->images->large;
                } else {
                    $image = $fundraiser->images->medium;
                }

                $funded = self::percent(($fundraiser->funding_goal - $fundraiser->funding_needed), $fundraiser->funding_goal);
                $html .= '
          <div class="fr-grid-list-item pure_span_8 pure_col no-border fundraiser_' . $fundraiser->id . '">
            <div class="fr-grid-list-content">
              <div class="fr-listing-avatar-container extended pure_span24">
                <div class="fr-listing-avatar" href="#" style="background-image: url(' . $image . ')">
                  <a href="?fundraiser=' . $fundraiser->slug . '" class="overlay-link"></a>
                </div>
              </div>
              <div class="fr-grid-item-content simplified pure_col pure_span_24">
                <div class="fr-grid-title-container">
                  <p class="fr-grid-title extended simplified">' . $title . '</p>
                  <p class="fr-grid-desc extended simplified">' . strip_tags(truncate($fundraiser->about, 150)) . '</p>
                </div>
              </div>
              <div class="fr-actions extended simplified no-border pure_col pure_span_24">
                <a class="fr-themed-link" href="?fundraiser=' . $fundraiser->slug . '">More</a>
                <a class="fr-themed-link" target="_blank" href="' . Purecharity_Wp_Base_Public::pc_url() . '/fundraisers/' . $fundraiser->id . '/fund">Donate</a>
              </div>
            </div>
          </div>
        ';
                if ($counter % 3 == 0) {
                    $html .= '<div class="clearfix"></div>';
                }
                $counter++;
            }
        }

        $html .= self::list_not_found(false);
        $html .= '</div>';
        $html .= '</div>';
        $html .= Purecharity_Wp_Fundraisers_Paginator::page_links(self::$fundraisers->meta);
        $html .= Purecharity_Wp_Base_Public::powered_by();

        return $html;
    }

    /**
     * List of Last Fundraisers.
     *
     * @since    1.0.0
     */
    public static function listing_last_grid()
    {

        $options = get_option('purecharity_fundraisers_settings');

        $html = self::fr_print_custom_styles();
        $html .= '<div class="fr-list-container is-grid">';

        $used = array();
        foreach (self::$fundraisers->external_fundraisers as $fundraiser) {
            if (!in_array($fundraiser->id, $used)) {
                array_push($used, $fundraiser->id);

                $title = $fundraiser->name;
                if (isset(self::$options['title']) && self::$options['title'] == 'owner_name') {
                    $title = $fundraiser->owner->name;
                }
                if (isset(self::$options['title']) && self::$options['title'] == 'title_and_owner_name') {
                    $title = $fundraiser->name . '<br /> by ' . $fundraiser->owner->name;
                }

                $html .= '
          <div class="fr-grid-list-item fundraiser_' . $fundraiser->id . '">
            <div class="fr-grid-list-content">
              <div class="fr-listing-avatar-container">
                  <div class="fr-listing-avatar" href="#" style="background-image: url(' . $fundraiser->images->large . ')"></div>
                </div>
              <div class="fr-grid-item-content">
              <p class="fr-grid-title">' . $title . '</p>
              <p class="fr-grid-desc">' . $fundraiser->about . '</p>
              ' . self::grid_funding_stats($fundraiser) . '
            </div>
            <div class="fr-actions pure_col pure_span_24">
              <a class="fr-themed-link" href="?fundraiser=' . $fundraiser->slug . '">More</a>
              <a class="fr-themed-link" target="_blank" href="' . Purecharity_Wp_Base_Public::pc_url() . '/fundraisers/' . $fundraiser->id . '/fund">Donate</a>
            </div>
          </div>
          </div>
        ';
            }
        }

        $html .= self::list_not_found(false);
        $html .= '</div>';

        return $html;
    }

    /**
     * Single Fundraisers.
     *
     * @since    1.0.0
     */
    public static function show()
    {

        $title = self::$fundraiser->name;
        if (isset(self::$options['title']) && self::$options['title'] == 'owner_name') {
            $title = self::$fundraiser->owner->name;
        }
        if (isset(self::$options['title']) && self::$options['title'] == 'title_and_owner_name') {
            $title = self::$fundraiser->name . ' by ' . self::$fundraiser->owner->name;
        }

        $options = get_option('pure_base_settings');

        $html = self::fr_print_custom_styles();
        $html .= '
      <div class="pure_row">
        <div class="fr-top-row pure_col pure_span_24">
          <div class="fr-name pure_col pure_span_18">
            <h3>' . $title . '</h3>
          </div>
          <div class="fr-donate mobile-hidden fr-donate-top pure_col pure_span_6">
            <a class="fr-pure-button" href="' . Purecharity_Wp_Base_Public::pc_url() . '/fundraisers/' . self::$fundraiser->id . '/fund">Donate</a>
          </div>
        </div>
        <div class="fr-container pure_col pure_span_24 fundraiser_' . self::$fundraiser->id . '">
          <div class="fr-header pure_col pure_span_24">
            <img src="' . self::$fundraiser->images->large . '">
          </div>
          <div class="fr-middle-row pure_col pure_span_24">
            <div class="fr-avatar-container pure_col pure_span_5">
              <div class="fr-avatar" href="#" style="background-image: url(' . self::$fundraiser->images->small . ')"></div>
            </div>
            <div class="fr-info pure_col pure_span_13">
              <p class="fr-location">' . self::$fundraiser->country . '</p>
                <p class="fr-organizer">
                  Organized by <a class="fr-themed-link" href="' . Purecharity_Wp_Base_Public::pc_url() . '/' . self::$fundraiser->field_partner->slug . '">' . self::$fundraiser->field_partner->name . '</a>
                </p>
            </div>
            <div class="fr-donate pure_col pure_span_6">
              <a class="fr-pure-button" href="' . Purecharity_Wp_Base_Public::pc_url() . '/fundraisers/' . self::$fundraiser->id . '/fund">Donate</a>
              ' . (isset($options['fundraise_cause']) ? '' : '<a class="fr-p2p" href="' . Purecharity_Wp_Base_Public::pc_url() . '/' . self::$fundraiser->slug . '/copies/new">Start a Fundraiser for this Cause</a>') . '
            </div>
          </div>
          ' . self::single_view_funding_bar() . '
          ' . self::single_view_funding_div() . '
          ' . self::single_view_tabs() . '
        </div>
      </div>
    ';
        $html .= Purecharity_Wp_Base_Public::powered_by();
        return $html;
    }

    /**
     * Funding stats for grid listing.
     *
     * @since    1.0.0
     */
    public static function grid_funding_stats($fundraiser, $layout = 1)
    {
        $klass = ($fundraiser->funding_goal != 'anonymous' && ($fundraiser->recurring_funding_goal != NULL && $fundraiser->recurring_funding_goal != 'anonymous')) ? 'pure_span_12' : 'pure_span_24';
        $html = '';
        if ($fundraiser->funding_goal != 'anonymous') {
            $funded = self::percent(($fundraiser->funding_goal - $fundraiser->funding_needed), $fundraiser->funding_goal);
            $html .= '
        <div class="pure_col ' . $klass . '">
          <div class="fr-grid-status-title pure_col pure_span_24" title="' . $funded . '">
            <span>One-time donations:</span>
          </div>
          <div class="fr-grid-status pure_col pure_span_24" title="' . $funded . '">
            <div class="fr-grid-progress" style="width:' . $funded . '%"></div>
          </div>
          <div class="fr-grid-stats ' . ($layout == 2 ? 'extended' : '') . ' pure_col pure_span_24">
            <p>
              $' . number_format(($fundraiser->funding_goal - $fundraiser->funding_needed), 0, '.', ',') . '
              of
              $' . number_format($fundraiser->funding_goal, 0, '.', ',') . '
              raised
            </p>
          </div>
        </div>
      ';
        }

        if ($fundraiser->recurring_funding_goal != NULL && $fundraiser->recurring_funding_goal != 'anonymous') {
            $funded = self::percent(($fundraiser->recurring_funding_goal - $fundraiser->recurring_funding_needed), $fundraiser->recurring_funding_goal);
            $html .= '
        <div class="pure_col ' . $klass . '">
          <div class="fr-grid-status-title pure_col pure_span_24" title="' . $funded . '">
            <span>Recurring donations:</span>
          </div>
          <div class="fr-grid-status pure_col pure_span_24" title="' . $funded . '">
            <div class="fr-grid-progress" style="width:' . $funded . '%"></div>
          </div>
          <div class="fr-grid-stats ' . ($layout == 2 ? 'extended' : '') . ' pure_col pure_span_24">
            <p>
              $' . number_format(($fundraiser->funding_goal - $fundraiser->funding_needed), 0, '.', ',') . '
              of
              $' . number_format($fundraiser->funding_goal, 0, '.', ',') . '
              raised
            </p>
          </div>
        </div>
      ';
        }
        return $html;
    }

    /**
     * Funding bar for single view.
     *
     * @since    1.0.0
     */
    public static function single_view_funding_bar()
    {
        include('includes/single-view-funding-bar.php');
        return $html;
    }

    /**
     * Funding stats for single view.
     *
     * @since    1.0.0
     */
    public static function single_view_funding_div()
    {
        include('includes/single-view-funding-div.php');
        return $html;
    }

    /**
     * Sharing links for single view.
     *
     * @since    1.0.0
     */
    public static function single_view_tabs()
    {
        include('includes/single-view-tabs.php');
        return $html;
    }


    /**
     * Backers list.
     *
     * @since    1.0.0
     */
    public static function print_backers()
    {
        if (sizeof(self::$fundraiser->backers) == 0) {
            $html = '<p>There are no backers at this time.</p>';
        } else {
            $html = '<ul class="fr-backers pure_col pure_span_24">';
            foreach (self::$fundraiser->backers as $backer) {
                $html .= '
          <li class="pure_col pure_span_6">
            <span class="fr-avatar fr-backer-avatar" href="#" style="background-image: url(' . $backer->avatar . ')"></span>
            <span class="fr-backer-name"><a class="fr-themed-link" href="' . Purecharity_Wp_Base_Public::pc_url() . '/' . $backer->slug . '">' . $backer->name . '</a></span>
          </li>
        ';
            }
            $html .= '</ul>';
        }
        return $html;
    }

    /**
     * Updates list.
     *
     * @since    1.0.0
     */
    public static function print_updates()
    {
        if (sizeof(self::$fundraiser->updates) == 0) {
            $html = '<p>There are no updates at this time.</p>';
        } else {
            $html = '<ul class="fr-updates">';
            foreach (self::$fundraiser->updates as $update) {
                $html .= '
          <li>
              <h4><a class="fr-themed-link" href="' . $update->url . '">' . $update->title . '</a></h4>
              <p class="date">Posted a week ago</p>
              <p>' . $update->body . '</p>
              <span class="fr-author">
                <p>Posted by:<br/><a class="fr-themed-link" href="' . Purecharity_Wp_Base_Public::pc_url() . '/' . $update->author->slug . '">' . $update->author->name . '</a></p>
              </span>
              <span class="fr-read-more">
                <a class="fr-read-more" href="' . $update->url . '">Read More</a><!-- links to update on pure charity -->
              </span>
            </li>
        ';
            }
            $html .= '</ul>';
        }
        return $html;
    }


    public static function fr_print_custom_styles()
    {
        $base_settings = get_option('pure_base_settings');

        // Default theme color

        if ($base_settings['main_color'] == NULL || $base_settings['main_color'] == '') {
            $color = '#CA663A';
        } else {
            $color = $base_settings['main_color'];
        }

        $html = '<style>';
        $html .= '
      .fundraiser-table a.donate { background: ' . $color . ' !important; }
      .fr-grid-progress { background: ' . $color . ' !important; }
      .fr-grid-list-item ul.fr-list-actions li a:hover { background: ' . $color . ' !important; }
      a.fr-pure-button { background: ' . $color . ' !important; }
      .fr-single-progress { background: ' . $color . ' !important; }
      #fr-tabs ul.fr-tabs-list li.active a, #fr-tabs ul.fr-tabs-list li a:hover {border-color: ' . $color . ' !important;}
      .fr-themed-link { color: ' . $color . ' !important; }
      .fr-filtering button { background: ' . $color . ' }
    ';
        $html .= '</style>';

        return $html;
    }


    /**
     * Percentage calculator.
     *
     * @since    1.0.0
     */
    public static function percent($num_amount, $num_total)
    {
        if ($num_total == 0) {
            return 100;
        }
        return number_format((($num_amount / $num_total) * 100), 0);
    }

    /**
     * Not found layout for listing display.
     *
     * @since    1.0.0
     */
    public static function circle_list_not_found()
    {
        return "<p>No Giving Circles Found.</p>" . Purecharity_Wp_Base_Public::powered_by();;
    }

    /**
     * Not found layout for single display.
     *
     * @since    1.0.0
     */
    public static function circle_not_found()
    {
        return "<p>Giving Circle Not Found.</p>" . Purecharity_Wp_Base_Public::powered_by();;
    }

    /**
     * List of Giving Circles.
     *
     * @since    1.0.0
     */
    public static function circle_listing()
    {

        $html = "";
        $html .= self::custom_style();
        $html .= '<div class="gc-listing">';

        foreach (self::$givingcircles as &$giving_circle) {
            $html .= '
        <div class="gc-listing-single">
          <a href="?slug=' . $giving_circle->slug . '" title="View ' . $giving_circle->name . '">
            <div class="gc-listing-avatar-container">
              <div class="gc-listing-avatar" href="#" style="background-image: url(' . $giving_circle->profile->avatar . ')"></div>
            </div>
            <div class="gc-listing-info">
              <h3>' . $giving_circle->name . '</h3>
              <p>' . $giving_circle->members_count . ' ' . pluralize($giving_circle->members_count, 'Member', 'Members') . '</p>
            </div>
          </a>
        </div>
      ';
        }

        $html .= '</div>';
        $html .= Purecharity_Wp_Base_Public::powered_by();

        return $html;
    }

    /**
     * Custom layout from the plugin settings.
     *
     * @since    1.0.0
     */
    public static function custom_style()
    {
        $main_color = get_option('puregivingcircles_main_color', false);
        $text_color = get_option('puregivingcircles_text_color', false);
        $html = "";
        $html .= ' <style>';

        if ($main_color != '') {
            $html .= '   
        .gc-go-back,
        .gc-go-back:hover { 
          background: #' . str_replace('#', '', $main_color) . ' !important; 
        } 
        a.gc-pure-button,
        a.gc-pure-button:hover { 
          background: #' . str_replace('#', '', $main_color) . ' !important; 
        } 
      ';
        }

        if ($text_color != '') {
            $html .= '   
        .gc-go-back,
        .gc-go-back:hover { 
          color: #' . str_replace('#', '', $text_color) . ' !important; 
        } 
        a.gc-pure-button,
        a.gc-pure-button:hover { 
          color: #' . str_replace('#', '', $text_color) . ' !important; 
        } 
      ';
        }

        $html .= ' </style>';

        return $html;
    }

    /**
     * Members link on the display header.
     *
     * @since    1.0.0
     */
    public static function members_link()
    {
        if (count(self::$givingcircle->organizers) > 0) {
            return '  and 
                <a href="#trigger-tab-3" onclick="$(\'#trigger-tab-3\').click()">
                  ' . count(self::$givingcircle->organizers) . ' ' . pluralize(count(self::$givingcircle->organizers), 'member', 'members') . '
                </a>';
        } else {
            return '';
        }
    }

    /**
     * Backed Causes listing for a single Giving Circle display.
     *
     * @since    1.0.0
     */
    public static function backed_causes_listing()
    {
        $html = '<ul class="gc-causes">';
        $i = 0;
        foreach (self::$givingcircle->backed_causes as &$backed_cause) {
            if (isset(self::$options['backed_limit']) && (int)self::$options['backed_limit'] == $i) {
                $more_backed = (count(self::$givingcircle->backed_causes) - (int)self::$options['backed_limit']);
                if ($more_backed > 0) {
                    $html .= '
            <li>
              <h4><a href="' . Purecharity_Wp_Base_Public::pc_url() . '/' . self::$givingcircle->slug . '" target="_blank">see ' . $more_backed . ' more backed causes</a></h4>
            </li>
          ';
                }
                break;
            }
            $html .= '
        <li>
          <span class="gc-cause-avatar"><img src="' . $backed_cause->avatar . '" /></span>
          <h4><a href="' . $backed_cause->url . '" target="_blank">' . $backed_cause->name . '</a></h4>
          <p class="gc-location">
            ' . $backed_cause->location . '<br />
            Amount donated to this cause: $' . $backed_cause->amount_donated . '
          </p>
        </li>
      ';
            $i++;
        }
        $html .= '</ul>';
        return $html;
    }


    /**
     * Members listing for a single Giving Circle display.
     *
     * @since    1.0.0
     */
    public static function members_listing()
    {
        $html = '<ul class="gc-members">';
        $i = 0;
        foreach (self::$givingcircle->members as &$member) {
            $html .= '
        <li>
          <span class="gc-cause-avatar" style="background: url(' . $member->avatar . ') center; background-size: 100%;"></span>
          <h4><a href="' . $member->profile_url . '" target="_blank">' . $member->name . '</a></h4>
          <p class="gc-location"></p>
        </li>
      ';
            if (isset(self::$options['members_limit']) && self::$options['members_limit'] != "" && (int)self::$options['members_limit'] == $i) {
                $more_members = (count(self::$givingcircle->members) - (int)self::$options['members_limit']);
                if ($more_members > 0) {
                    $html .= '
            <li>
              <h4><a href="' . Purecharity_Wp_Base_Public::pc_url() . '/' . self::$givingcircle->slug . '" target="_blank">see ' . $more_members . ' more members</a></h4>
            </li>
          ';
                }
                break;
            }
            $i++;
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     * Virtual page for a single Giving Circle
     *
     * @since    1.0.0
     */
    public static function circle_show()
    {
        $html = "";
        if (isset($_GET['slug'])) {
            $html .= '<a class="gc-go-back" href="#" onclick="window.history.go(-1); return false;">&lt; Back</a>';
        }

        $html .= self::custom_style();
        $html .= '
      <div class="gc-container">        
        <div class="gc-header">
          <img src="' . self::$givingcircle->profile->cover . '">
        </div>

        <div class="gc-intro">
          <div class="gc-avatar" style="background: url(' . self::$givingcircle->profile->avatar . ') center; background-size: 100%;">
          </div>

          <div class="gc-info">
            <h2>' . self::$givingcircle->name . '</h2>
            <p class="gc-organizer">
              Organized by 
              <a href="' . self::$givingcircle->founder->profile_url . '" target="_blank">
                ' . self::$givingcircle->founder->name . '
              </a> 
              ' . self::members_link() . '
            </p>
            <ul class="gc-stats">
              <li><span class="gc-stat">' . self::$givingcircle->profile->lives_impacted . '</span><br/> 
              ' . pluralize(intval(self::$givingcircle->profile->lives_impacted), 'Live Impacted', 'Lives Impacted') . '</li>
              <li><span class="gc-stat">' . count(self::$givingcircle->members) . '</span><br/> 
              ' . pluralize(count(self::$givingcircle->members), 'Member', 'Members') . '</li>
            </ul>
          </div>

          <div class="gc-join">
            <a class="gc-pure-button" href="' . self::$givingcircle->join_url . '">Join</a>
            <p>A minimum monthly donation of ' . money_format('$%i', self::$givingcircle->minimum_monthly_donation) . ' is required.</p>
            <p>Funds Donated: ' . money_format('$%i', self::$givingcircle->minimum_monthly_donation) . '</p>
          </div>
        </div>

        <div class="gc-body">
          <div id="gc-tabs">
            <ul class="gc-tabs-list">
              <li><a id="trigger-tab-1" href="#tab-1">About</a></li>
              <li><a id="trigger-tab-2" href="#tab-2">Causes</a></li>
              <li><a id="trigger-tab-3" href="#tab-3">Members</a></li>
            </ul>
            <div id="tab-1">
              <p>' . self::$givingcircle->profile->about . '</p>
            </div>
            <div id="tab-2">
              ' . self::backed_causes_listing() . '
            </div>
            <div id="tab-3">
              ' . self::members_listing() . '
            </div>
          </div>

        </div>

      </div>
    ';
        $html .= Purecharity_Wp_Base_Public::powered_by();
        return $html;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function sponsorship_enqueue_styles()
    {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/public.css', array(), $this->version, 'all');


        wp_enqueue_style('pure-sponsorships-selects', plugin_dir_url(__FILE__) . 'css/jquery.simpleselect.css');

        $options = get_option('purecharity_sponsorships_settings');
        // Allow the user to select a stylesheet theme
        if (isset($options['plugin_style'])) {
            switch ($options['plugin_style']) {
                case 'pure-sponsorships-option2':
                    $pure_style = 'pure-sponsorships-option2';
                    break;
                case 'pure-sponsorships-option3':
                    $pure_style = 'pure-sponsorships-option3';
                    break;
                default:
                    $pure_style = 'pure-sponsorships-option1';
            }
        } else {
            $pure_style = 'pure-sponsorships-option1';
        }

        wp_enqueue_style('pure-sponsorships-style', plugin_dir_url(__FILE__) . 'css/' . $pure_style . '.css');
    }

    /**
     * Listing entry for a single sponsorship.
     *
     * @since    1.0.0
     */
    public static function sponsor_listing()
    {
        $options = get_option('purecharity_sponsorships_settings');
        $html = self::custom_css();
        $html .= '<div class="pcsponsor-container">';
        $html .= self::search_input();

        $html .= '<div class="pcsponsor-filters">';
        $html .= self::age_filter();
        $html .= self::gender_filter();
        $html .= self::location_filter();
        $html .= '</div>';

        foreach (self::$sponsorships->sponsorships as $sponsorship) {
            $html .= '
                <div class="pcsponsor-item sponsorship_' . $sponsorship->id . '">
                    <a href="?sponsorship=' . $sponsorship->id . '">
                        <div class="pcsponsor-image" style="background-image: url(' . $sponsorship->images->small . ');">
                            ' . ($sponsorship->is_sponsored ? '<p class="pcsponsor-full">Fully Sponsored</p>' : '') . '
                        </div>
                        <div class="pcsponsor-content">
                            ' . self::lower_listing_content($sponsorship, $options) . '
                        </div>
                    </a>
                </div>
            ';
        }

        $html .= '</div>';
        $html .= Purecharity_Wp_Sponsorships_Paginator::page_links(self::$sponsorships->meta);
        if (!isset($options['hide_powered_by'])) {
            $html .= Purecharity_Wp_Base_Public::powered_by();
        }

        return $html;
    }

    /**
     * Single child view.
     *
     * @since    1.0.0
     */
    public static function single()
    {

        $options = get_option('purecharity_sponsorships_settings');
        $html = self::custom_css();

        if (isset($options['plugin_style']) && $options['plugin_style'] == 'pure-sponsorships-option3') {
            $html .= '
                <div class="pcs-rounded">

                    <div class="info">
                        ' . self::render_slots(0) . '
                        <h1>' . self::$sponsorship->name . '</h1>
                        ' . self::render_age() . '
                        ' . self::render_description() . '
                        ' . self::render_about_section('pure-about') . '
                        ' . self::render_custom_fields() . '
                    </div>

                    <div class="pictures">

                        <div class="control left">
                            <a href="#"> < </a>
                        </div>

                        <div class="album">
                            <div class="rail">
                                <div class="picture" style="background-image: url(' . self::$sponsorship->images->small . ');">
                                </div>
                            </div>
                            <ul class="controls">
                                <li class="active"><a href="#picture-1"></a></li>
                                <li><a href="#picture-2"></a></li>
                            </ul>
                            <div class="pcsponsor-single-select pc-third-view">
                                ' . self::render_sponsor_options() . '
                            </div>
                        </div>

                        <div class="control right">
                            <a href="#"> > </a>
                        </div>
                    </div>
                </div>

                <div class="pcs-navigation">
                    ' . self::lower_links() . '
                </div>
            ';

        } else {
            $html .= '
                <div class="pcsponsor-single-container">
                    <p class="pcsponsorships-return"><a href="#" onclick="javascript:history.go(-1); return false;">&#10094; Return to Sponsorship List</a></p>

                    <div class="pcsponsor-single-image">
                        <img src="' . self::$sponsorship->images->small . '" alt="' . self::$sponsorship->name . '"/>
                    </div>
                    <div class="pcsponsor-single-content">
                        <div class="pcsponsor-single-info">
                            <h4>' . self::$sponsorship->name . '</h4>
                            ' . self::render_slots(1) . '
                        </div>
                        <div class="pcsponsor-single-desc">
                            ' . self::render_age() . '
                            ' . self::render_description() . '
                            ' . self::render_about_section('pure-about') . '
                            <p>' . self::render_custom_fields() . '</p>
                        </div>
                        <div class="pcsponsor-single-select">
                            ' . self::render_sponsor_options() . '
                        </div>
                    </div>
            ';
        }

        $html .= Purecharity_Wp_Base_Public::powered_by();

        return $html;
    }

    /**
     * Renders slots.
     *
     * @since    1.0.0
     */
    public static function render_slots($template = 0)
    {
        $total_available = self::$sponsorship->sponsors_goal;
        $taken = self::$sponsorship->quantity_taken;
        if ((int)$taken > (int)$total_available) {
            $taken = $total_available;
        }

        $html = '';
        if ((int)$total_available > 1) {
            if ($template == 0) {
                $html .= '<div class="slots">
                            <ul class="no-padding">' . self::the_bullets(self::$sponsorship) . '</ul>
                            ' . self::sponsorship_slots_text() . '
                          </div>';
            } else {
                $html .= '<ul class="pcsponsor-status-buttons pcsponsor-single-status-buttons">
                           ' . self::the_bullets(self::$sponsorship) . '
                          </ul>
                           ' . self::sponsorship_slots_text();
            }
        }
        return $html;
    }

    /**
     * Renders the description.
     *
     * @since    1.0.0
     */
    public static function render_description()
    {
        $html = '';
        if (!empty(self::$sponsorship->description)) {
            $html = '<p class="pure-desc">
                    ' . self::$sponsorship->description . '
                     </p>';
        }
        return $html;
    }

    /**
     * Renders the age display.
     *
     * @since    1.0.0
     */

    public static function render_age()
    {
        $html = '';
        if (!empty(self::$sponsorship->age)) {
            $html = '<p class="pure-desc"><small>
                 <strong>Age:</strong> ' . self::$sponsorship->age . '
              </small></p>';
        }
        return $html;
    }

    /**
     * Renders the about optional section.
     *
     * @since    1.0.0
     */
    public static function render_about_section($class = '')
    {
        $html = '';
        if (!empty(self::$sponsorship->about)) {
            $html = '<p class="' . $class . '">' . self::$sponsorship->about . '</p>';
        }
        return $html;
    }

    /**
     * Renders the lower content of the listing options.
     *
     * @since    1.0.0
     */
    public static function lower_listing_content($sponsorship, $options)
    {
        $total_available = $sponsorship->sponsors_goal;

        $available = $sponsorship->sponsors_goal - $sponsorship->quantity_taken;
        if ($available < 0) {
            $available = 0;
        }

        $components = array();
        $components['title'] = '<h4>' . $sponsorship->name . '</h4>';
        if ((int)$total_available > 1) {
            $components['bullets'] = '<ul class="pcsponsor-status-buttons">' . self::the_bullets($sponsorship) . '</ul>';
            $components['info'] = '<p class="pcsponsor-status">
                                    ' . $available . ' of ' . $total_available . '
                                    ' . pluralize($total_available, 'Sponsorship') . '
                                    Available
                                   </p>';
        } else {
            $components['bullets'] = '';
            $components['info'] = (($sponsorship->is_sponsored && (isset($options['plugin_style']) && $options['plugin_style'] == 'pure-sponsorships-option3')) ? '<p>Sponsored</p>' : '');
        }
        if (isset($options['plugin_style']) && $options['plugin_style'] == 'pure-sponsorships-option3') {
            return $components['title'] . $components['info'] . $components['bullets'];
        } else {
            return $components['title'] . $components['bullets'] . $components['info'];
        }
    }

    /**
     * Generates the age filter.
     *
     * @since    1.0.0
     */
    public static function age_filter()
    {
        $options = get_option('purecharity_sponsorships_settings');
        if (isset($options["age_filter"])) {
            return '<select data-type="age" name="age">
                <option value="0">Select Age</option>
                <option ' . ((isset($_GET['age']) && $_GET['age'] == '0-4') ? 'selected' : '') . ' value="0-4">0-4</option>
                <option ' . ((isset($_GET['age']) && $_GET['age'] == '5-8') ? 'selected' : '') . ' value="5-8">5-8</option>
                <option ' . ((isset($_GET['age']) && $_GET['age'] == '9-12') ? 'selected' : '') . ' value="9-12">9-12</option>
                <option ' . ((isset($_GET['age']) && $_GET['age'] == '13') ? 'selected' : '') . ' value="13">13+</option>
            </select>';
        }
    }

    /**
     * Generates the age filter.
     *
     * @since    1.0.0
     */
    public static function gender_filter()
    {
        $options = get_option('purecharity_sponsorships_settings');
        if (isset($options["gender_filter"])) {
            return '<select data-type="gender" name="gender">
                <option value="0">Select Gender</option>
                <option ' . ((isset($_GET['gender']) && $_GET['gender'] == 'Male') ? 'selected' : '') . ' >Male</option>
                <option ' . ((isset($_GET['gender']) && $_GET['gender'] == 'Female') ? 'selected' : '') . ' >Female</option>
            </select>';
        }
    }

    /**
     * Generates the age filter.
     *
     * @since    1.0.0
     */
    public static function location_filter()
    {
        $options = get_option('purecharity_sponsorships_settings');
        if (isset($options["gender_filter"])) {
            $html = "";
            // Grab the locations for the filter
            $locations = array();
            foreach (self::$sponsorships_full->sponsorships as $sponsorship) {
                $locations[$sponsorship->location] = true;
            }
            asort($locations);
            $html .= '<select data-type="location" name="location">';
            $html .= '<option value="0">Select Country</option>';
            foreach ($locations as $location => $val) {
                $html .= '<option ' . ((isset($_GET['location']) && $_GET['location'] == $location) ? 'selected' : '') . '>' . $location . '</option>';
            }
            $html .= '</select>';
            return $html;
        }
    }

    /**
     * Generates the bullets for the sponsorship.
     *
     * @since    1.0.0
     */
    public static function the_bullets($sponsorship)
    {
        $total_available = $sponsorship->sponsors_goal;
        $taken = $sponsorship->quantity_taken;
        if ((int)$taken > (int)$total_available) {
            $taken = $total_available;
        }

        $html = '';
        if ((int)$total_available > 1) {
            for ($i = 1; $i <= $total_available; $i++) {
                $klass = ($i <= $taken) ? 'pcsponsor-taken' : '';
                $html .= '<li class="' . $klass . '"></li>';
            }
        }
        return $html;

    }


    /**
     * Custom CSS in case the user has chosen to use another color.
     *
     * @since    1.0.0
     */
    public static function custom_css()
    {
        $base_settings = get_option('pure_base_settings');
        $pf_settings = get_option('purecharity_sponsorships_settings');

        // Default theme color
        if (empty($pf_settings['plugin_color'])) {
            if ($base_settings['main_color'] == NULL || $base_settings['main_color'] == '') {
                $color = '#CA663A';
            } else {
                $color = $base_settings['main_color'];
            }
        } else {
            $color = $pf_settings['plugin_color'];
        }

        $scripts = '
            <style>
                .single-sponsorship .ps-taken,
                .single-sponsorship .simpleselect .placeholder,
                .single-sponsorship .styledButton ,
                .pcs-rounded .info .slots ul li.taken,
                .pure-button { background: ' . $color . ' !important; color: #FFF !important; }
                .pcsponsorships-return a,
                .pcs-rounded .info .slots ul li.pcsponsor-taken,
                .pcs-navigation a span
                .single-sponsorship a { color: ' . $color . ' !important; }
                a.pctrip-pure-button { background: ' . $color . '; }
                .fr-filtering button { background: ' . $color . ' }
                .pctrip-list-actions li a:hover { background: ' . $color . ' !important }
            </style>
        ';

        return $scripts;
    }


    /**
     * Renders the available sponsorships slot for the single view. Returns blank if there is only one.
     *
     * @since    1.0.0
     */
    public static function sponsorship_slots_text()
    {

        $total_available = (int)self::$sponsorship->sponsors_goal;

        $available = self::$sponsorship->sponsors_goal - self::$sponsorship->quantity_taken;
        if ($available < 0) {
            $available = 0;
        }

        $html = '';

        if ($total_available > 1 && $available > 0) {
            $html = '
            <span>
                ' . $available . ' of ' . $total_available . '
                ' . pluralize($total_available, 'Sponsorship') . '
                Available
            </span>
            ';
        } elseif ($total_available > 1 && $available == 0) {
            $html = '<span>Fully Sponsored</span>';
        } elseif ($available == 0) {
            $html = '<span>Sponsored</span>';
        }

        return $html;
    }


    /**
     * Renders the lower links for the single kid view when using layout option 3.
     *
     * @since    1.0.0
     */
    public static function lower_links()
    {
        $options = get_option('purecharity_sponsorships_settings');
        $back_link = isset($options['back_link']) ? $options['back_link'] : 'javascript:history.go(-1);';
        $html = '';
        if (isset($options['show_back_link'])) {
            $html .= '<a href="' . $back_link . '" class="back"><span> < </span> Back to all kids</a>';
        }
        if (isset($options['show_more_link']) && !empty($options['more_link'])) {
            $html .= '<a href="' . $options['more_link'] . '" class="learn-more">Learn more about sponsorships <span> > </span></a>';
        }

        return $html;
    }

    /**
     * Renders the custom fields for the single kid view.
     *
     * @since    1.0.0
     */
    public static function render_custom_fields()
    {
        $options = get_option('purecharity_sponsorships_settings');
        $fields_config = explode(";", $options['allowed_custom_fields']);

        $custom_fields = Array();
        foreach ($fields_config as $key => $value) {
            $parts = explode('|', $value);
            $custom_fields[$parts[0]] = @$parts[1];
        }


        $html = '';
        foreach ($custom_fields as $key => $value) {
            if (isset(self::$sponsorship->custom_fields->$key)) {
                $html .= "<b>" . $value . "</b>: " . self::$sponsorship->custom_fields->$key . "<br />";
            }
        }

        if ($html != '') {
            $exp = explode(' ', self::$sponsorship->name);
            $return = "<h4>about " . $exp[0] . "</h4><p>$html</p>";
        } else {
            $return = '';
        }

        return $return;
    }

    /**
     * Renders the sponsor options for the single kid view.
     *
     * @since    1.0.0
     */
    public static function render_sponsor_options()
    {

        $options = get_option('purecharity_sponsorships_settings');

        $available = self::$sponsorship->sponsors_goal - self::$sponsorship->quantity_taken;
        if ($available < 0) {
            $available = 0;
        }

        $html = '<form method="get" action="' . Purecharity_Wp_Base_Public::pc_url() . '/sponsorships/' . self::$sponsorship->id . '/fund" class="pcsponsor-fund-form">';

        if ((int)self::$sponsorship->sponsors_goal > 1 && $available > 0) {
            $html .= '<select id="sponsorship_supporter_shares" name="amount">';
            $html .= '<option>Choose Sponsorship Level</option>';
            for ($i = 1; $i <= $available; $i++) {
                $termName = 'Sponsorship';
                if ($i > 1) {
                    $termName = 'Sponsorships';
                }
                $html .= '<option value="' . (self::$sponsorship->funding_per * $i) . '.0">' . $i . ' ' . $termName . ' - $' . (self::$sponsorship->funding_per * $i) . '.00 Monthly</option>';
            }
            $html .= '</select>';
        } else {
            $html .= '<input type="hidden" name="amount" value="' . self::$sponsorship->funding_per . '" />';
        }
        if ($available > 0) {
            $html .= '<a class="pure-button submit" href="#">Sponsor</a>';
        }
        $html .= '</form>';
        return $html;
    }

    /**
     * Global search input.
     *
     * @since    1.0.0
     */
    public static function search_input()
    {

        $options = get_option('purecharity_sponsorships_settings');

        if (isset($options["search_input"])) {

            $html = '
                <div class="sp-filtering">
                    <form method="get">
                        <fieldset class="livefilter sp-livefilter">
                            <legend>
                                <label for="livefilter-input">
                                    <strong>Search Sponsorships:</strong>
                                </label>
                            </legend>
                            <input id="livefilter-input" class="sp-livefilter-input" value="' . @$_GET['query'] . '" name="query" type="text">
                            <button class="sp-filtering-button" type="submit">Filter</button>
                            ' . (@$_GET['query'] != '' ? '<a href="#" onclick="$(this).prev().prev().val(\'\'); $(this).parents(\'form\').submit(); return false;">Clear filter</a>' : '') . '
                        </fieldset>
                    </form>
                </div>
            ';
        } else {
            $html = '';
        }
        return $html;
    }

    /**
     * Not found layout for listing display.
     *
     * @since    1.0.0
     */
    public static function trips_list_not_found()
    {
        $html = self::live_search();
        $html .= "<p>No Trips Found.</p>" . Purecharity_Wp_Base_Public::powered_by();;
        return $html;
    }

    /**
     * Not found layout for single display.
     *
     * @since    1.0.0
     */
    public static function trips_not_found()
    {
        return "<p>Trip Not Found.</p>" . Purecharity_Wp_Base_Public::powered_by();;
    }


    /**
     * Live filter template.
     *
     * @since    1.0.0
     */
    public static function trips_live_search()
    {

        $options = get_option('purecharity_trips_settings');
        if (isset($options["live_filter"])) {

            $html = '
            <div class="fr-filtering">
              <form method="get">
                <fieldset class="livefilter fr-livefilter">
                  <legend>
                    <label for="livefilter-input">
                      <strong>Search Trips:</strong>
                    </label>
                  </legend>
                  <input id="livefilter-input" class="fr-livefilter-input" value="' . @$_GET['query'] . '" name="query" type="text">
                  <button class="fr-filtering-button" type="submit">Filter</button>
                  ' . (@$_GET['query'] != '' ? '<a href="#" onclick="$(this).prev().prev().val(\'\'); $(this).parents(\'form\').submit(); return false;">Clear filter</a>' : '') . '
                </fieldset>
              </form>
            </div>
          ';
        } else {
            $html = '';
        }
        return $html;
    }

    /**
     * Listing HTML for Trips
     *
     * @since    1.0.0
     */
    public static function trips_listing()
    {

        $html = self::custom_css();
        $html .= '<div class="pctrip-list-container">';
        $html .= self::live_search();

        foreach (self::$events->events as $event) {
            $truncated = (strlen($event->about) > 100) ? substr($event->about, 0, 100) . '...' : $event->about;
            $html .= '
            <div class="pctrip-list-item pure_col pure_span_24">
              <div class="pctrip-list-content pure_col pure_span_24">
                <div class="pctrip-listing-avatar-container pure_col pure_span_4">
                  <a href="?trip=' . $event->id . '">
                    <div class="pctrip-listing-avatar" style="background-image: url(' . $event->images->small . ')"></div>
                  </a>
                </div>
                <div class="pctrip-list-body-container pure_col pure_span_20">
                  <h3 class="pctrip-title"><a href="?trip=' . $event->id . '">' . $event->name . '</a></h3>
                  <p class="pctrip-date">' . self::get_date_range($event->starts_at, $event->ends_at) . '</p>
                  <p class="pctrip-grid-intro">' . strip_tags($truncated) . '</h4>
                </div>
              </div>
            </div>
          ';

        }

        // Paginator
        if (self::$events->meta->num_pages > 1) {
            $html .= Purecharity_Wp_Trips_Paginator::page_links(self::$events->meta);
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * Listing HTML for Trips
     *
     * @since    1.0.0
     */
    public static function trips_listing_grid()
    {
        $html = self::custom_css();
        $html .= '<div class="pctrip-list-container is-grid pure_row">';
        $html .= self::live_search();

        $counter = 0;
        foreach (self::$events->events as $event) {
            $truncated = (strlen($event->description) > 100) ? substr($event->description, 0, 100) . '...' : $event->description;
            $html .= '
            <div class="pctrip-grid-list-item pure_col pure_span_6">
              <div class="pctrip-grid-list-content pure_col pure_span_24">
                <div class="pctrip-listing-avatar-container pure_col pure_span_24">
                    <a href="?trip=' . $event->id . '">
                      <div class="pctrip-grid-listing-avatar pure_col pure_span_24" style="background-image: url(' . $event->images->medium . ')"></div>
                    </a>
                  </div>
                <div class="pctrip-grid-lower-content pure_col pure_span_24">
                  <h4 class="pctrip-grid-title">' . $event->name . '</h4>
                  <p class="pctrip-date">' . self::get_date_range($event->starts_at, $event->ends_at) . '</p>
                  <p class="pctrip-grid-location">
                    <img class="pctrips-location-pin" src="' . plugins_url('img/location-pin.png', __FILE__) . '" />
                    ' . $event->country . '
                  </p>

                  <p class="pctrip-grid-intro">' . strip_tags($truncated) . '</p>
              </div>
              <ul class="pctrip-list-actions pure_col pure_span_24">
                <li><a href="?trip=' . $event->id . '">More Info</a></li>
              </ul>
              </div>    
            </div>';
            if ($counter == 3) {
                $html .= '<div class="clearfix"></div>';
                $counter = 0;
            } else {
                $counter++;
            }
        }

        // Paginator
        if (self::$events->meta->num_pages > 1) {
            $html .= Purecharity_Wp_Trips_Paginator::page_links(self::$events->meta);
        }

        $html .= '</div>';
        return $html;
    }


    /**
     * Single HTML for a Trip
     *
     * @since    1.0.0
     */
    public static function trips_show()
    {
        return self::custom_css() . '
          <div class="pctrip-container">

            <div class="pctrip-header pure_col pure_span_24">
              <img src="' . self::$event->images->large . '">
            </div>
            <div class="pctrip-avatar-container pure_col pure_span_4">
              <div class="pctrip-avatar" href="#" style="background-image: url(' . self::$event->images->small . ')"></div>
            </div>

            <div class="pctrip-name pure_col pure_span_14">
              <h3>' . self::$event->name . '</h3>
              <p class="pctrip-date">' . self::get_date_range(self::$event->starts_at, self::$event->ends_at) . '</p>
            </div>
            <div class="pure_col pure_span_6 pctrip-register">
            ' . self::print_register_button() . '
            </div>


            <div class="pctrip-content pure_col pure_span_24">


              <div class="pctrip-body pure_col pure_span_18">
                <p>' . self::$event->about . '</p>
              </div>

              <div class="pctrip-sidebar pure_col pure_span_6">

                <div class="pctrip-sidebarsection">
                  <h4>Share</h4>
                  ' . Purecharity_Wp_Base_Public::sharing_links(array(), self::$event->name) . '
                  <a target="_blank" href="' . Purecharity_Wp_Base_Public::pc_url() . '/' . self::$event->slug . '">
                    <img src="' . plugins_url('img/share-purecharity.png', __FILE__) . '" >
                  </a>
                </div>

                ' . self::print_tickets_area() . '

                <div class="pctrip-sidebarsection">
                  <h4>Trip Information</h4>
                  <p><strong>Trip Type:</strong> ' . self::print_trip_types() . '</p>
                  ' . self::print_trip_location() . '
                  ' . self::print_trip_tags() . '
                </div>

              </div>

            </div>

          </div>

        ';
    }

    /**
     * Print the tickets area
     *
     * @since    1.0.0
     */
    public static function print_tickets_area()
    {
        $html = '';
        if (self::$event->registrations_state == 'open' && count(self::$event->tickets) > 0) {
            $html .= '
            <div class="pctrip-sidebarsection">
              <h4>Trip Costs</h4>
              ' . self::print_trip_tickets() . '
            </div>
          ';
        }
        return $html;
    }

    /**
     * Print the country/location
     *
     * @since    1.0.0
     */
    public static function print_trip_location()
    {
        $html = '';
        if (self::$event->region != "") {
            $html .= "<p><strong>Region:</strong> " . self::$event->region . "</p>";
        }

        if (self::$event->location == "") {
            $html .= "<p><strong>Country:</strong> " . self::$event->country . "</p>";
        } else {
            $html .= "<p><strong>Location:</strong> " . self::$event->location . "</p>";
        }

        return $html;
    }

    /**
     * Print the register button
     *
     * @since    1.0.0
     */
    public static function print_register_button()
    {
        if (self::$event->registrations_state == 'open' && count(self::$event->tickets) == 1) {
            return '
            <a class="pctrip-pure-button" href="' . self::$event->public_url . '">Register</a>
          ';
        } else {
            return '';
        }
    }

    /**
     * Print the trip leaders
     *
     * @since    1.0.0
     */
    public static function print_trip_leaders()
    {
        $html = '';
        foreach (self::$event->leaders as $leader) {
            $html .= '<p><a href="' . $leader->public_url . '">' . $leader->name . '</a></p>';
        }
        return $html;
    }

    /**
     * Print the trip tags
     *
     * @since    1.0.0
     */
    public static function print_trip_tags()
    {
        $tags = array();
        foreach (self::$event->trip_tags as $tag) {
            $tags[] = '<a href="?trip_tag=' . $tag . '">' . $tag . '</a>';
        }
        if (count($tags) > 0) {
            return '<p><strong>Tags:</strong> ' . join(', ', $tags);
        } else {
            return '';
        }
    }

    /**
     * Print the trip types
     *
     * @since    1.0.0
     */
    public static function print_trip_types()
    {
        $types = array();
        foreach (self::$event->types as $type) {
            $types[] = $type;
        }
        return join(', ', array_unique($types));
    }

    /**
     * Print the trip tickets
     *
     * @since    1.0.0
     */
    public static function print_trip_tickets()
    {

        $tickets = '';
        foreach (self::$event->tickets as $ticket) {

            $tickets .= '
            <p class="pctrip-ticket">
              <strong>' . $ticket->name . '</strong><br /><br />
              <span class="pctrip-ticket-price">' . money_format('$%i', $ticket->price) . '</span><br /><br />
              ' . $ticket->description . '</br>
              ' . (count(self::$event->tickets) > 1 ? '<a class="pctrip-pure-button" href="' . $ticket->public_url . '">Register</a>' : '') . '
            </p>
          ';
        }
        return $tickets;
    }


    /**
     * Calculate date range for a trip
     *
     * @since    1.0.0
     */
    public static function get_date_range($start, $end)
    {
        $start = strtotime($start);
        $end = strtotime($end);
        $days = ($end - $start) / 3600 / 24;
        if (($days > 31) || date('M', $start) != date('M', $end)) {
            return date(self::DATE_FORMAT, $start) . ' - ' . date(self::DATE_FORMAT, $end);
        } else {
            $parts = preg_split('/([dj])/', self::DATE_FORMAT, -1, PREG_SPLIT_DELIM_CAPTURE);
            $date = '';
            foreach ($parts as $part) {
                if ($part == 'd' || $part == 'j') {
                    $date .= date($part, $start) . '-' . date($part, $end);
                } else {
                    $date .= date($part, $start);
                }
            }
            return $date;
        }
    }

}
