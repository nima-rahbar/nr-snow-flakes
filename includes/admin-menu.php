<?php
function nr_snow_flakes_customize_register($wp_customize)
{

    // No panels added!

    // Create our sections

    $wp_customize->add_section('snow_flakes_section', array(
        'title'             => __('Snow Flakes', 'nr_snow_flakes'),
    ));

    // Create our settings

    $wp_customize->add_setting('snow_enable', array(
        'type'          => 'theme_mod',
        'transport'     => 'refresh',
    ));
    $wp_customize->add_control('snow_enable_control', array(
        'label'      => __('Enable Snow Flakes', 'nr_snow_flakes'),
        'section'    => 'snow_flakes_section',
        'settings'   => 'snow_enable',
        'type'       => 'radio',
        'choices'    => array(
            'enable' => __('Enable', 'nr_snow_flakes'),
            'schedule' => __('Schedule', 'nr_snow_flakes'),
            'disable' => __('Disable', 'nr_snow_flakes'),
        ),
    ));

    $wp_customize->add_setting('snow_count', array(
        'type'          => 'theme_mod',
        'transport'     => 'refresh',
    ));
    $wp_customize->add_control('snow_count_control', array(
        'label'      => __('Flakes Count', 'nr_snow_flakes'),
        'section'    => 'snow_flakes_section',
        'settings'   => 'snow_count',
        'type'       => 'number',
        'input_attrs' => array(
            'step' => 10,
            'min' => 100,
            'max' => 500,
        ),
    ));

    $wp_customize->add_setting('snow_minsize', array(
        'type'          => 'theme_mod',
        'transport'     => 'refresh',
    ));
    $wp_customize->add_control('snow_minsize_control', array(
        'label'      => __('Minimum Size', 'nr_snow_flakes'),
        'section'    => 'snow_flakes_section',
        'settings'   => 'snow_minsize',
        'type'       => 'number',
        'input_attrs' => array(
            'step' => 1,
            'min' => 5,
            'max' => 20,
        ),
    ));

    $wp_customize->add_setting('snow_maxsize', array(
        'type'          => 'theme_mod',
        'transport'     => 'refresh',
    ));
    $wp_customize->add_control('snow_maxsize_control', array(
        'label'      => __('Maximum Size', 'nr_snow_flakes'),
        'section'    => 'snow_flakes_section',
        'settings'   => 'snow_maxsize',
        'type'       => 'number',
        'input_attrs' => array(
            'step' => 1,
            'min' => 5,
            'max' => 50,
        ),
    ));

    $wp_customize->add_setting('snow_round', array(
        'type'          => 'theme_mod',
        'transport'     => 'refresh',
    ));
    $wp_customize->add_control('snow_round_control', array(
        'label'      => __('Round', 'nr_snow_flakes'),
        'section'    => 'snow_flakes_section',
        'settings'   => 'snow_round',
        'type'       => 'radio',
        'choices'    => array(
            'no' => __('No', 'nr_snow_flakes'),
            'yes' => __('Yes', 'nr_snow_flakes'),
        ),
    ));

    $wp_customize->add_setting('snow_shadow', array(
        'type'          => 'theme_mod',
        'transport'     => 'refresh',
    ));
    $wp_customize->add_control('snow_shadow_control', array(
        'label'      => __('Shadow', 'nr_snow_flakes'),
        'section'    => 'snow_flakes_section',
        'settings'   => 'snow_shadow',
        'type'       => 'radio',
        'choices'    => array(
            'no' => __('No', 'nr_snow_flakes'),
            'yes' => __('Yes', 'nr_snow_flakes'),
        ),
    ));

    $wp_customize->add_setting('snow_image', array(
        'type'          => 'theme_mod',
        'transport'     => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'snow_image_control', array(
        'label'      => __('Flakes Image', 'nr_snow_flakes'),
        'section'    => 'snow_flakes_section',
        'settings'   => 'snow_image',
        'type'       => 'image',
    )));

    $wp_customize->add_setting('snow_collection', array(
        'type'          => 'theme_mod',
        'transport'     => 'refresh',
    ));
    $wp_customize->add_control('snow_collection_control', array(
        'label'      => __('Collection Name', 'nr_snow_flakes'),
        'description' => __('Add jQuery Selector please', 'nr_snow_flakes'),
        'section'    => 'snow_flakes_section',
        'settings'   => 'snow_collection',
        'type'       => 'text',
    ));

    // Date fields
    $wp_customize->add_setting('snow_start_date', array(
        'capability' => 'theme_mod',
        'sanitize_callback' => 'themeslug_sanitize_date',
    ));

    $wp_customize->add_control('snow_start_date_control', array(
        'type' => 'date',
        'section' => 'snow_flakes_section',
        'settings'   => 'snow_start_date',
        'label' => __('Start Date'),
        'input_attrs' => array(
            'placeholder' => __('yyyy/mm/dd'),
        ),
    ));
    $wp_customize->add_setting('snow_end_date', array(
        'capability' => 'theme_mod',
        'sanitize_callback' => 'themeslug_sanitize_date',
    ));

    $wp_customize->add_control('snow_end_date_control', array(
        'type' => 'date',
        'section' => 'snow_flakes_section',
        'settings'   => 'snow_end_date',
        'label' => __('End Date'),
        'input_attrs' => array(
            'placeholder' => __('yyyy/mm/dd'),
        ),
    ));

    function themeslug_sanitize_date($input)
    {
        $date = new DateTime($input);
        return $date->format('Y-m-d');
    }
}
add_action('customize_register', 'nr_snow_flakes_customize_register');