<?php

/**
 * Used on public display of the Givin Circle(s)
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    Purecharity_Wp_Givingcircles
 * @subpackage Purecharity_Wp_Givingcircles/includes
 */

/**
 * Used on public display of the Givin Circle(s).
 *
 * This class defines all the shortcodes necessary.
 *
 * @since      1.0.0
 * @package    Purecharity_Wp_Givingcircles
 * @subpackage Purecharity_Wp_Givingcircles/includes
 * @author     Pure Charity <dev@purecharity.com>
 */
class Purecharity_Wp_Givingcircles_Shortcode {


    /**
   * Initialize the shortcodes to make them available on page runtime.
   *
   * @since    1.0.0
   */
  public static function init()
  {

      add_shortcode('giving_circles', array('Purecharity_Wp_Givingcircles_Shortcode', 'giving_circles_shortcode'));
      add_shortcode('giving_circle', array('Purecharity_Wp_Givingcircles_Shortcode', 'giving_circle_shortcode'));
      add_shortcode('giving_circle_info', array('Purecharity_Wp_Givingcircles_Shortcode', 'giving_circle_info_shortcode'));

  }

  /**
   * Initialize the Giving Circles Listing shortcode.
   *
   * @since    1.0.0
   */
  public static function giving_circles_shortcode($atts)
  {
    $options = shortcode_atts( array(
      'members_limit' => get_query_var('members_limit'),
      'backed_limit' => get_query_var('backed_limit')
    ), $atts );
    Purecharity_Wp_Base_Public::$options = $options;

    if(isset($_GET['giving_circle'])){
      $options = array();
      $options["giving_circle"] = $_GET['giving_circle'];
      return self::giving_circle_shortcode($options);
    }else{
      $givingcircles = Purecharity_Wp_Base::api_call('giving_circles');

      if ($givingcircles && count($givingcircles->giving_circles) > 0) {
        $givingcircles = $givingcircles->giving_circles;
        Purecharity_Wp_Base_Public::$givingcircles = $givingcircles;
        return Purecharity_Wp_Base_Public::circle_listing();
      }else{
        return Purecharity_Wp_Base_Public::circle_list_not_found();        
      };
    }
  }

  /**
   * Initialize the Single Giving Circle shortcode.
   *
   * @since    1.0.0
   */
  public static function giving_circle_shortcode($atts)
  {
    $options = shortcode_atts( array(
      'giving_circle' => false,
      'members_limit' => get_query_var('members_limit'),
      'backed_limit' => get_query_var('backed_limit')
    ), $atts );

    if ($options['giving_circle']) {
      $givingcircle = Purecharity_Wp_Base::api_call('giving_circles/'. $options['giving_circle']);
      
      if ($givingcircle) {
        $givingcircle = $givingcircle->giving_circle;
        Purecharity_Wp_Base_Public::$givingcircle = $givingcircle;
        return Purecharity_Wp_Base_Public::circle_show();
      }else{
        return Purecharity_Wp_Base_Public::circle_not_found();       
      }

    }
  }

  /**
   * Initialize the Giving Circles Information shortcode.
   *
   * @since    1.1.0
   */
  public static function giving_circle_info_shortcode($atts)
  {
    $options = shortcode_atts( array(
      'giving_circle' => false,
      'type' => false
    ), $atts );
    if(isset($options['giving_circle'])){
      $givingcircle = Purecharity_Wp_Base::api_call('giving_circles/'. $options['giving_circle'])->giving_circle;
      switch($options['type']){
        case 'members_count':
          return count($givingcircle->members);
        case 'amount_donated':
          $amount_donated = 0;
          foreach($givingcircle->backed_causes as $backed_cause){
            $amount_donated += (int)$backed_cause->amount_donated;
          }
          return money_format('$ %i', $amount_donated); 
        case 'member_avatars':
          $options = get_option( 'purecharity_giving_circles_settings' );
          $class = '';
          if(isset($options["round_avatars"])){ $class = 'circular'; };

          $html = '<ul class="pc-avatars-list '.$class.'">';
          foreach($givingcircle->members as $member){
            $html .= '
              <li style="background: url('.$member->avatar.') no-repeat;">
                <img width="76" height="76" src="'.$member->avatar.'"/>
              </li>
            ';
          }
          $html .= '</ul>';
          return $html;
      }
      
    }
  }
}