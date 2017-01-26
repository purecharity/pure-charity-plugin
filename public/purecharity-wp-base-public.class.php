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
class Purecharity_Wp_Base_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/purecharity-wp-base-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/purecharity-wp-base-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Powered by at the bottom of the page.
	 *
	 * @since    1.0.0
	 */
	public static function powered_by(){
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
	public static function sharing_links($which = array(), $text = '', $title = '', $image = ''){
		$current_url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

		$facebook_url = 'https://www.facebook.com/sharer.php?p[url]='.self::current_page_url();

		$widgets = array();
		$widgets['facebook'] = '
			<a style="float:left;" href="'.$facebook_url.'">
				<img src="'.plugins_url( '/img/facebook.png' , __FILE__ ).'" />
			</a>
		';

		$widgets['twitter'] = '
			<a href="https://twitter.com/home?status='.$title.' '.self::current_page_url().'">
				<img src="'.plugins_url( '/img/twitter.png' , __FILE__ ).'" />
			</a>
		';

		if(count($which) == 0){
			return join('', $widgets);
		}else{
			$html = '';
			foreach($which as $w){
				if(isset($widgets[$w])){ $html .= $widgets[$w]; };
			}
			return $html;
		}
	}

	/**
	 * Returns the current page url.
	 *
	 * @since    1.0.0
	 */
	public static function current_page_url($cut_params = false) {
		$pageURL = 'http';
		if( isset($_SERVER["HTTPS"]) ) {
			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		if($cut_params){
			return split('?', $pageURL);
		}else{
			return $pageURL;
		}
	}

	/**
	 * Not found layout for single display.
	 *
	 * @since    1.0.0
	 */
	public static function pc_url(){
		$pure_base_options = get_option( 'pure_base_settings' );
		$mode = $pure_base_options['mode'];
		if($mode == 'production'){
			return 'https://purecharity.com';
		}elseif('sandbox' == $mode){
			return 'https://staging.purecharity.com';
		}elseif('demo' == $mode){
			return 'https://demo.purecharity.com';
		}else{
			return $_ENV["API_URL"];
		}
	}

		public static function donation_form($options) {

		$html = self::print_custom_styles();
		$html .= '
			<div class="container">
				<form class="pure-donations clearfix">
	        <input class="donatefield" name="give" type="number" placeholder="$ USD" /><br/>
	        <input class="button donatesubmit" data-url="'.$options['recurring'].'" name="donaterecurring" type="submit" value="Give Recurring" />
	        <input class="button donatesubmit" data-url="'.$options['one_time'].'" name="donateonetime" type="submit" value="Give One-Time" />
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
	public static function print_custom_styles(){
		$base_settings = get_option( 'pure_base_settings' );
		$pd_settings = get_option( 'purecharity_donations_settings' );

		// Default theme color
		if(@$pd_settings['plugin_color'] == NULL || @$pd_settings['plugin_color'] == ''){
		  if(@$base_settings['main_color'] == NULL || @$base_settings['main_color'] == ''){
		    $color = '#CA663A';
		  }else{
		    $color = @$base_settings['main_color'];
		  }
		}else{
		  $color = @$pd_settings['plugin_color'];
		}

		$html = '<style>';
		$html .= '
				.container form.pure-donations input.button { background: '.$color.' !important; }
		';
		$html .= '</style>';

		return $html;
	}
}
