<?php

/**
 * Pagination generator class
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    Purecharity_Wp_Sponsorships
 * @subpackage Purecharity_Wp_Sponsorships/includes
 */

/**
 * Pagination generator class.
 *
 * @package    Purecharity_Wp_Sponsorships
 * @subpackage Purecharity_Wp_Sponsorships/includes
 * @author     Rafael Dalprá <rafael.dalpra@toptal.com>
 */
class Purecharity_Wp_Sponsorships_Paginator {
  const DEFAULT_PER_PAGE = 10;

  /**
   * Generates pagination html for given collection of objects.
   *
   * TODO: Document possible options.
   *
   * @since    1.0.0
   */
  public static function page_links($meta = array(), $options = array()){
    if((int)$meta->num_pages == 1){
      return '';
    }
    $opts = self::sanitize_options($options);

    $html = '<div class="pc_pagination">';
    $html .= '<ul class="pc_page-numbers">';

    if($meta->current_page > 1){
      $html .= '<li><a class="pc_page-numbers" href="?_page='.($meta->current_page-1).'">Previous</a></li>';
    }

    for($i = 1; $i <= $meta->num_pages; $i++){
      if($meta->current_page == $i){
        $html .= '<li><span class="pc_page-numbers current">'.$i.'</span></li>';
      }else{
        $html .= '<li><a class="pc_page-numbers" href="?_page='.$i.'">'.$i.'</a></li>';
      }
    }
    
    if($meta->current_page < $meta->num_pages){
      $html .= '<li><a class="pc_page-numbers" href="?_page='.($meta->current_page+1).'">Next</a></li>';
    }

    $html .= '</ul>';
    $html .= '</div>';
    
    return $html;
  }

  /**
   * Convert options into usable options.
   *
   * @since    1.0.0
   */
  public static function sanitize_options($options){
    $sanitized = array();
    foreach($options as $key => $value){
      if($key == '' || $value == ''){ continue; }
      $sanitized[$key] = $value;
    }
    if(!isset($sanitized['per_page'])){ $sanitized['per_page'] = self::DEFAULT_PER_PAGE; }
    
    return $sanitized;
  }

}