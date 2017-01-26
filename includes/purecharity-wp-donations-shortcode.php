<?php

/**
 * Used on public display of the Donation form
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    Purecharity
 * @subpackage Purecharity/includes
 */

/**
 * Used on public display of the Donation form.
 *
 * This class defines all the shortcodes necessary.
 *
 * @since      1.0.0
 * @package    Purecharity
 * @subpackage Purecharity/includes
 * @author     Pure Charity <dev@purecharity.com>
 */
class Purecharity_Wp_Donations_Shortcode {

  /**
   * Initialize the shortcodes to make them available on page runtime.
   *
   * @since    1.0.0
   */
  public static function init()
  {

      add_shortcode('donation', array('Purecharity_Wp_Donations_Shortcode', 'donation_shortcode'));

  }

  /**
   * Initialize the Donation Form Shortcode
   *
   * @since    1.0.1
   */
  public static function donation_shortcode($atts)
  { 
    $options = get_option( 'purecharity_donations_settings' );

    return Purecharity_Wp_Base_Public::donation_form($options);
  }

}