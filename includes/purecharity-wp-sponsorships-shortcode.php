<?php

/**
 * Used on public display of the sponsorship(s)
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    Purecharity_Wp_Sponsorships
 * @subpackage Purecharity_Wp_Sponsorships/includes
 */

/**
 * Used on public display of the sponsorship(s).
 *
 * This class defines all the shortcodes necessary.
 *
 * @since      1.0.0
 * @package    Purecharity_Wp_Sponsorships
 * @subpackage Purecharity_Wp_Sponsorships/includes
 * @author     Rafael Dalprá <rafael.dalpra@toptal.com>
 */
class Purecharity_Wp_Sponsorships_Shortcode {

  /**
   * Initialize the shortcodes to make them available on page runtime.
   *
   * @since    1.0.0
   */
  public static function init()
  {
      add_shortcode('sponsorships', array('Purecharity_Wp_Sponsorships_Shortcode', 'sponsorships_shortcode'));
      add_shortcode('sponsorship', array('Purecharity_Wp_Sponsorships_Shortcode', 'sponsorship_shortcode'));
      add_shortcode('sponsorship_child', array('Purecharity_Wp_Sponsorships_Shortcode', 'sponsorship_child_shortcode'));
  }


  /**
   * Sponsorships list shortcode.
   *
   * @since    1.0.0
   */
  public static function sponsorships_shortcode($atts)
  {

    // Set up and retrieve attributes
    $options = shortcode_atts( array(
      'status' => false,
      'per_page' => false,
      'reject' => false
    ), $atts );


    $sponsorship_id = $atts["program_id"];

    if (isset($_GET['sponsorship'])) {
      // In case it's a single child view
      return self::sponsorship_child_shortcode(array('sponsorship' => $_GET['sponsorship']));
    } else if($sponsorship_id){
      $filters = '';
      $age = '';
      $gender = '';
      $location = '';

      // Check for any filters, validating and sanitizing along the way
      // Append valid filters to $filters
      if (isset($_GET['gender'])) {
        $gender = ucfirst(strtolower($_GET['gender']));

        if ($gender == 'Male' || $gender == 'Female') {
          $filters = '&gender='. $gender;
        }
      }

      $range1 = $range2 = $range3 = $range4 = '';

      if (isset($_GET['age'])) {
        $age = $_GET['age'];
        if (preg_match('/[0-9-]*/', $_GET['age'])) {
          // Split the age
          $ages = explode('-', $_GET['age']);

          if (isset($ages[0]) && isset($ages[1])) {
            $filters .= '&min_age='. $ages[0];
          }

          if (isset($ages[0]) && !isset($ages[1])) {
            $filters .= '&max_age='. $ages[0];
          }

          if (isset($ages[1])) {
            $filters .= '&max_age='. $ages[1];
          }
        }
      }

      if (isset($_GET['country'])) {
        $filters .= '&country='. urlencode(sanitize_text_field($_GET['country']));;
      }

      if (isset($_GET['query'])) {
        $filters .= '&search_filter='. urlencode(sanitize_text_field($_GET['query']));;
      }

      if($options['reject']){
        $filters .= '&reject='.$options['reject'];
      }

      if ($status = $options['status']) {
        $filters .= '&status='. $status;
      }

      if (isset($_GET['_page'])) {
        $filters .= '&page='. (int) $_GET['_page'];
      }

      if ($limit = $options['per_page']) {
        $filters .= '&limit='. (int) $limit;
      }

      $full_filters = $filters;
      $full_filters .= '&limit='. 9999;

      // Grab the sponsorships
      $sponsorships = Purecharity_Wp_Base::api_call('sponsorships?sponsorship_program_id='. $sponsorship_id . $filters);
      $sponsorships_full = Purecharity_Wp_Base::api_call('sponsorships?sponsorship_program_id='. $sponsorship_id . $full_filters);

      // Set up the page url for filtering
      $pageUrl = explode('?', $_SERVER['REQUEST_URI'], 2);
      $pageUrl = $pageUrl[0];

      Purecharity_Wp_Base_Public::$sponsorships = $sponsorships;
      Purecharity_Wp_Base_Public::$sponsorships_full = $sponsorships_full;
      return Purecharity_Wp_Base_Public::sponsor_listing();
    }
  }

  /**
   * Sponsorships child view shortcode.
   *
   * @since    1.0.0
   */
  public static function sponsorship_child_shortcode($atts)
  {
    $options = shortcode_atts( array(
      'sponsorship' => false
    ), $atts );

    if ($options['sponsorship']) {
      $sponsorship = self::$base_plugin->api_call('sponsorships/'. $options['sponsorship']);

      Purecharity_Wp_Base_Public::$sponsorship = $sponsorship->sponsorship;

      return Purecharity_Wp_Base_Public::single();
    }
  }
}
