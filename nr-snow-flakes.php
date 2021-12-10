<?php
/**
 * Plugin Name:     Snow Flakes
 * Plugin URI:      https://hellenictechnologies.com
 * Description:     Create snowflakes falling. For settings go to customizer's menu.
 * Author:          Nima Rahbar
 * Author URI:      https://nimarahbar.com
 * Text Domain:     nr-snow-flakes
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Nr_Snow_Flakes
 */

    require_once plugin_dir_path(__FILE__).'includes'.DIRECTORY_SEPARATOR.'admin-menu.php';

 add_action('wp_enqueue_scripts', 'nr_snow_flakes_enqueue_scripts');
function nr_snow_flakes_enqueue_scripts(){
    $params = nr_snow_flakes_get_customizer_options();
    wp_enqueue_script('nr_snow_flakes_core', plugin_dir_url( __FILE__ ).'assets/snowfall.jquery.min.js', array('jquery'), '1.7', true);
    wp_register_script('nr_snow_flakes_custom', plugin_dir_url( __FILE__ ). 'assets/nr_snowflakes.js', array('jquery', 'nr_snow_flakes_core'), time(), true);
    wp_localize_script('nr_snow_flakes_custom', 'params', $params);
    wp_enqueue_script('nr_snow_flakes_custom');
}

add_action('wp_footer', 'nr_snow_flakes_get_customizer_options');
function nr_snow_flakes_get_customizer_options(){
    $params = [
        'enabled' => (get_theme_mod('snow_enable') == 'enable') ? true : false,
        'flakeCount' => get_theme_mod('snow_count'),
        'minSize' => get_theme_mod('snow_minsize'),
        'maxSize' => get_theme_mod('snow_maxsize'),
        'round' => (get_theme_mod('snow_round') == 'yes') ? true : false,
        'shadow' => (get_theme_mod('snow_shadow') == 'yes') ? true : false,
        'image' => get_theme_mod('snow_image'),
        'collection' => get_theme_mod('snow_collection'),
    ];
    return $params;
}