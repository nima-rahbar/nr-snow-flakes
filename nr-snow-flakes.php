<?php

/**
 * Plugin Name:     Snow Flakes
 * Plugin URI:      https://hellenictechnologies.com
 * Description:     Create snowflakes falling. For settings go to customizer's menu.
 * Author:          Nima Rahbar
 * Author URI:      https://nimarahbar.com
 * Text Domain:     nr-snow-flakes
 * Domain Path:     /languages
 * Version:         0.1.1
 *
 * @package         Nr_Snow_Flakes
 */
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'includes' . DIRECTORY_SEPARATOR . 'admin-menu.php';
}
//require_once plugin_dir_path(__FILE__).'includes'.DIRECTORY_SEPARATOR.'customizer-menu.php';

add_action('wp_enqueue_scripts', 'nr_snow_flakes_enqueue_scripts');
function nr_snow_flakes_enqueue_scripts()
{
    $params = nr_snow_flakes_get_admin_options();
    wp_enqueue_script('nr_snow_flakes_core', plugin_dir_url(__FILE__) . 'assets/js/snowfall.jquery.min.js', array('jquery'), '1.7', true);
    wp_register_script('nr_snow_flakes_custom', plugin_dir_url(__FILE__) . 'assets/js/nr_snowflakes.js', array('jquery', 'nr_snow_flakes_core'), time() . "0.1.0", true);
    wp_localize_script('nr_snow_flakes_custom', 'params', $params);
    wp_enqueue_script('nr_snow_flakes_custom');
}

add_action('wp_footer', 'nr_snow_flakes_get_admin_options');
function nr_snow_flakes_get_admin_options()
{
    /* 
    * Retrieve this value with:
    * $snow_flakes_options = get_option( 'snow_flakes_option_name' ); // Array of All Options
    * $enable_snow_flakes_0 = $snow_flakes_options['enable_snow_flakes_0']; // Enable Snow Flakes
    * $flakes_count_1 = $snow_flakes_options['flakes_count_1']; // Flakes Count
    * $minimum_size_2 = $snow_flakes_options['minimum_size_2']; // Minimum Size
    * $maximum_size_2 = $snow_flakes_options['maximum_size_2']; // Minimum Size
    * $round_3 = $snow_flakes_options['round_3']; // Round
    * $shadow_4 = $snow_flakes_options['shadow_4']; // Shadow
    * $image_8 = $snow_flakes_options['image_8']; // Image Address
    * $collection_name_5 = $snow_flakes_options['collection_name_5']; // Collection Name
    * $start_date_6 = $snow_flakes_options['start_date_6']; // Start Date
    * $end_date_7 = $snow_flakes_options['end_date_7']; // End Date
    */
    $db_params = get_option('snow_flakes_option_name');
    $schedule = $db_params['enable_snow_flakes_0'];
    $show = false;
    if ($schedule === 'schedule') {
        $start_date = date("Y-m-d", strtotime($db_params['start_date_6']));
        $end_date = date("Y-m-d", strtotime($db_params['end_date_7']));
        $today = date('Y-m-d', time());
        if (($start_date <= $today) && ($today <= $end_date)) {
            $show = true;
        } else {
            $show = false;
        }
    } elseif ($schedule === 'enable') {
        $show = true;
    }
    if ($show) {
        $params = [
            'enabled' => ($db_params['enable_snow_flakes_0'] == 'enable') ? true : false,
            'flakeCount' => $db_params['flakes_count_1'],
            'minSize' => $db_params['minimum_size_2'],
            'maxSize' => $db_params['maximum_size_2'],
            'round' => ($db_params['round_3'] == 'yes') ? true : false,
            'shadow' => ($db_params['shadow_4'] == 'yes') ? true : false,
            'image' => $db_params['image_8'],
            'collection' => $db_params['collection_name_5'],
        ];
    } else {
        $params = null;
    }
    return $params;
}
