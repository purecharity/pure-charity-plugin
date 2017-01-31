<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    Purecharity
 * @subpackage Purecharity/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Purecharity
 * @subpackage Purecharity/includes
 * @author     Pure Charity <dev@purecharity.com>
 */
class Purecharity_Wp_Base_Paginator
{
    const DEFAULT_WRAPPER = '<div class="purecharity-paginator">';
    const DEFAULT_WRAPPER_CLOSE = '</div>';
    const DEFAULT_PER_PAGE = 10;

    /**
     * Generates pagination html for given collection of objects.
     *
     * TODO: Document possible options.
     *
     * @since    1.0.0
     */
    public static function page_links($collection = array(), $options = array())
    {
        $opts = self::sanitize_options($options);
        if (count($collection) < $opts['per_page']) {
            return '';
        } else {
            $html = $opts['wrapper_open'];

            $pages = ceil(count($collection) / $opts['per_page']);

            $html .= count($collection);
            $html .= $opts['wrapper_close'];
        }
        return $html;
    }

    /**
     * Convert options into usable options.
     *
     * @since    1.0.0
     */
    public static function sanitize_options($options)
    {
        $sanitized = array();
        foreach ($options as $key => $value) {
            if ($key == '' || $value == '') {
                continue;
            }
            $sanitized[$key] = $value;
        }
        if (!isset($sanitized['wrapper_open'])) {
            $sanitized['wrapper_open'] = self::DEFAULT_WRAPPER;
        }
        if (!isset($sanitized['wrapper_close'])) {
            $sanitized['wrapper_close'] = self::DEFAULT_WRAPPER_CLOSE;
        }
        if (!isset($sanitized['per_page'])) {
            $sanitized['per_page'] = self::DEFAULT_PER_PAGE;
        }

        return $sanitized;
    }

}