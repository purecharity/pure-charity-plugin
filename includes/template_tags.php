<?php
/**
 * Template tags for trips
 *
 * @link       http://purecharity.com
 * @since      1.0.0
 *
 * @package    Purecharity_Wp_Trips
 * @subpackage Purecharity_Wp_Trips/includes
 */

/**
 * Trips listing.
 *
 * For more information, please refer to the readme.
 *
 * @since    1.0.0
 */
function pc_trips($options)
{
    return pc_base()->api_call('events/?' . http_build_query(Purecharity_Wp_Trips_Shortcode::filtered_opts($options)));
}

/**
 * Single trip information based on ID.
 *
 * For more information, please refer to the readme.
 *
 * @since    1.0.0
 */
function pc_trip($id = null)
{
    if ($id == null) {
        return pc_trip_not_found();
    }

    return pc_base()->api_call('events/' . $id)->event;
}

/**
 * Trips regions listing.
 *
 * For more information, please refer to the readme.
 *
 * @since    1.0.0
 */
function pc_trips_regions()
{
    return pc_base()->api_call('regions');
}

/**
 * Trips countries listing.
 *
 * For more information, please refer to the readme.
 *
 * @since    1.0.0
 */
function pc_trips_countries()
{
    return pc_base()->api_call('countries');
}

/**
 * Trips dates listing.
 *
 * For more information, please refer to the readme.
 *
 * @since    1.0.0
 */
function pc_trips_dates()
{
    $all_dates = pc_base()->api_call('events?scope=dates');
    $months = array();
    foreach ($all_dates->events as $dates) {
        $start = new DateTime($dates->starts_at);
        $start->modify('first day of this month');
        $end = new DateTime($dates->ends_at);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);
        foreach ($period as $dt) {
            $key = $dt->format('Y-m');
            if (!array_key_exists($key, $months)) {
                $months[$key] = $dt->format(Purecharity_Wp_Trips::MONTH_FORMAT);
            }
        }
    }
    ksort($months);
    return $months;
}

/**
 * Trips tags listing.
 *
 * For more information, please refer to the readme.
 *
 * @since    1.0.0
 */
function pc_trips_tags()
{
    return pc_base()->api_call('events/tags');
}
