<?php

/**
 * Instance of the base plugin for use on the child template tags.
 *
 * @since    1.0.0
 */
function pc_base(){
    return new Purecharity_Wp_Base();
}

/**
 * Template tags for donations
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 */

function pc_donation($options = array()){
	return Purecharity_Wp_Base::donation_form($options);
}