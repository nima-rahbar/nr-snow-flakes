<?php
class SnowFlakes
{
    private $snow_flakes_options;

    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'my_admin_enqueue'));
        add_action('admin_menu', array($this, 'snow_flakes_add_plugin_page'));
        add_action('admin_init', array($this, 'snow_flakes_page_init'));
    }
    function my_admin_enqueue($hook_suffix)
    {
        if ($hook_suffix == 'settings_page_snow-flakes') {
            wp_enqueue_style('bs-core-styles', plugin_dir_url(dirname(__FILE__)) . 'assets/css/bootstrap.min.css', array(), '5.1.3');
            wp_enqueue_style('snow-flakes-admin', plugin_dir_url(dirname(__FILE__)) . 'assets/css/nr_snowflakes_admin.css', array(), '5.1.3');
            wp_enqueue_script('bs-core-scripts', plugin_dir_url(dirname(__FILE__)) . 'assets/js/bootstrap.min.js', array('jquery'), '5.1.3', true);
            wp_enqueue_script('nr_snow_flakes_core', plugin_dir_url(dirname(__FILE__)) . 'assets/js/snowfall.jquery.min.js', array('jquery'), '1.7', true);
            wp_enqueue_media();
            $options = get_option('snow_flakes_option_name'); // Array of All Options
            wp_register_script('snow-flakes-admin', plugin_dir_url(dirname(__FILE__)) . 'assets/js/nr_snowflakes_admin.js', array('jquery', 'bs-core-scripts', 'nr_snow_flakes_core'), '1.0.0', true);
            wp_localize_script('snow-flakes-admin', 'db_options', $options);
            wp_enqueue_script('snow-flakes-admin');
        }
    }

    public function snow_flakes_add_plugin_page()
    {
        add_options_page(
            __('Snow Flakes', 'nr-snow-flakes'), // page_title
            __('Snow Flakes', 'nr-snow-flakes'), // menu_title
            'manage_options', // capability
            'snow-flakes', // menu_slug
            array($this, 'snow_flakes_create_admin_page') // function
        );
    }

    public function snow_flakes_create_admin_page()
    {
        $this->snow_flakes_options = get_option('snow_flakes_option_name'); ?>

        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-12">
                    <h2><?php echo __('Snow Flakes', 'nr-snow-flakes'); ?></h2>
                    <h3 class="fs-4 text-muted"><?php echo __('By <b>Nima Rahbar</b>', 'nr-snow-flakes'); ?></h3>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6 order-sm-2">
                    <div id="snowflakes-preview" class="card text-center bg-dark text-light w-100" style="max-width: none;">
                        <h5 class="card-header"><?php echo __('Snow Flakes <span class="text-muted">Preview</span>', 'nr-snow-flakes'); ?></h5>
                        <div class="card-body">
                            <table class="table table-borderless text-light">
                                <tr>
                                    <th class="text-start"><?php echo __('Snow Flakes', 'nr-snow-flakes'); ?></th>
                                    <td id="status" class="text-end"><span class="bi bi-x text-danger fs-4"></span></td>
                                </tr>
                                <tr>
                                    <th class="text-start"><?php echo __('Count', 'nr-snow-flakes'); ?></th>
                                    <td id="count" class=" text-end fs-4">-</td>
                                </tr>
                                <tr>
                                    <th class="text-start"><?php echo __('Minimum Size', 'nr-snow-flakes'); ?></th>
                                    <td id="minSize" class="text-end fs-4">-</td>
                                </tr>
                                <tr>
                                    <th class="text-start"><?php echo __('Maximum Size', 'nr-snow-flakes'); ?></th>
                                    <td id="maxSize" class="text-end fs-4">-</td>
                                </tr>
                                <tr>
                                    <th class="text-start"><?php echo __('Round', 'nr-snow-flakes'); ?></th>
                                    <td id="round" class="text-end"><span class="bi bi-x text-danger fs-4"></td>
                                </tr>
                                <tr>
                                    <th class="text-start"><?php echo __('Shadow', 'nr-snow-flakes'); ?></th>
                                    <td id="shadow" class="text-end"><span class="bi bi-x text-danger fs-4"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <p><?php echo __('In admin area "Collection" will be here!', 'nr-snow-flakes'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 order-sm-1">
                    <form method="post" action="options.php">
                        <?php
                        settings_fields('snow_flakes_option_group');
                        do_settings_sections('snow-flakes-admin');
                        submit_button(__('Save Settings', 'nr_snow_flakes'), 'btn btn-primary');
                        ?>
                    </form>
                </div>
            </div>
        </div>
    <?php }

    public function snow_flakes_page_init()
    {
        register_setting(
            'snow_flakes_option_group', // option_group
            'snow_flakes_option_name', // option_name
            array($this, 'snow_flakes_sanitize') // sanitize_callback
        );

        add_settings_section(
            'snow_flakes_setting_section', // id
            __('Settings', 'nr-snow-flakes'), // title
            array($this, 'snow_flakes_section_info'), // callback
            'snow-flakes-admin' // page
        );

        add_settings_field(
            'enable_snow_flakes_0', // id
            __('Enable Snow Flakes', 'nr-snow-flakes'), // title
            array($this, 'enable_snow_flakes_0_callback'), // callback
            'snow-flakes-admin', // page
            'snow_flakes_setting_section' // section
        );

        add_settings_field(
            'flakes_count_1', // id
            __('Flakes Count', 'nr-snow-flakes'), // title
            array($this, 'flakes_count_1_callback'), // callback
            'snow-flakes-admin', // page
            'snow_flakes_setting_section' // section
        );

        add_settings_field(
            'minimum_size_2', // id
            __('Minimum Size', 'nr-snow-flakes'), // title
            array($this, 'minimum_size_2_callback'), // callback
            'snow-flakes-admin', // page
            'snow_flakes_setting_section' // section
        );

        add_settings_field(
            'maximum_size_2', // id
            __('Maximum Size', 'nr-snow-flakes'), // title
            array($this, 'maximum_size_2_callback'), // callback
            'snow-flakes-admin', // page
            'snow_flakes_setting_section' // section
        );

        add_settings_field(
            'round_3', // id
            __('Round', 'nr-snow-flakes'), // title
            array($this, 'round_3_callback'), // callback
            'snow-flakes-admin', // page
            'snow_flakes_setting_section' // section
        );

        add_settings_field(
            'shadow_4', // id
            __('Shadow', 'nr-snow-flakes'), // title
            array($this, 'shadow_4_callback'), // callback
            'snow-flakes-admin', // page
            'snow_flakes_setting_section' // section
        );

        add_settings_field(
            'image_8', // id
            __('Flakes Image', 'nr-snow-flakes'), // title
            array($this, 'image_8_callback'), // callback
            'snow-flakes-admin', // page
            'snow_flakes_setting_section' // section
        );
        add_settings_field(
            'collection_name_5', // id
            __('Collection Name', 'nr-snow-flakes'), // title
            array($this, 'collection_name_5_callback'), // callback
            'snow-flakes-admin', // page
            'snow_flakes_setting_section' // section
        );

        add_settings_field(
            'start_date_6', // id
            __('Start Date', 'nr-snow-flakes'), // title
            array($this, 'start_date_6_callback'), // callback
            'snow-flakes-admin', // page
            'snow_flakes_setting_section' // section
        );

        add_settings_field(
            'end_date_7', // id
            __('End Date', 'nr-snow-flakes'), // title
            array($this, 'end_date_7_callback'), // callback
            'snow-flakes-admin', // page
            'snow_flakes_setting_section' // section
        );
    }

    public function snow_flakes_sanitize($input)
    {
        $sanitary_values = array();
        if (isset($input['enable_snow_flakes_0'])) {
            $sanitary_values['enable_snow_flakes_0'] = $input['enable_snow_flakes_0'];
        }

        if (isset($input['flakes_count_1'])) {
            $sanitary_values['flakes_count_1'] = sanitize_text_field($input['flakes_count_1']);
        }

        if (isset($input['minimum_size_2'])) {
            $sanitary_values['minimum_size_2'] = sanitize_text_field($input['minimum_size_2']);
        }
        if (isset($input['maximum_size_2'])) {
            $sanitary_values['maximum_size_2'] = sanitize_text_field($input['maximum_size_2']);
        }

        if (isset($input['round_3'])) {
            $sanitary_values['round_3'] = $input['round_3'];
        }

        if (isset($input['shadow_4'])) {
            $sanitary_values['shadow_4'] = $input['shadow_4'];
        }

        if (isset($input['image_8'])) {
            $sanitary_values['image_8'] = sanitize_text_field($input['image_8']);
        }

        if (isset($input['collection_name_5'])) {
            $sanitary_values['collection_name_5'] = sanitize_text_field($input['collection_name_5']);
        }

        if (isset($input['start_date_6'])) {
            $sanitary_values['start_date_6'] = sanitize_text_field($input['start_date_6']);
        }

        if (isset($input['end_date_7'])) {
            $sanitary_values['end_date_7'] = sanitize_text_field($input['end_date_7']);
        }

        return $sanitary_values;
    }

    public function snow_flakes_section_info()
    {
        echo __("You can set all the settings here and see them in preview box on the right side of the page.", 'nr-snow-flakes');
    }

    public function enable_snow_flakes_0_callback()
    {
    ?> <fieldset>
            <div class="form-check">
                <?php $checked = (isset($this->snow_flakes_options['enable_snow_flakes_0']) && $this->snow_flakes_options['enable_snow_flakes_0'] === 'enable') ? 'checked' : ''; ?>
                <input type="radio" class="form-check-input" name="snow_flakes_option_name[enable_snow_flakes_0]" id="enable_snow_flakes_0-0" value="enable" <?php echo $checked; ?>>
                <label class="form-check-label" for="enable_snow_flakes_0-0"><?php echo __('Enable', 'nr-snow-flakes'); ?></label>
            </div>
            <div class="form-check">
                <?php $checked = (isset($this->snow_flakes_options['enable_snow_flakes_0']) && $this->snow_flakes_options['enable_snow_flakes_0'] === 'schedule') ? 'checked' : ''; ?>
                <input type="radio" class="form-check-input" name="snow_flakes_option_name[enable_snow_flakes_0]" id="enable_snow_flakes_0-1" value="schedule" <?php echo $checked; ?>>
                <label class="form-check-label" for="enable_snow_flakes_0-1"><?php echo __('Schedule', 'nr-snow-flakes'); ?></label>
            </div>
            <div class="form-check">
                <?php $checked = (isset($this->snow_flakes_options['enable_snow_flakes_0']) && $this->snow_flakes_options['enable_snow_flakes_0'] === 'disable') ? 'checked' : ''; ?>
                <input type="radio" class="form-check-input" name="snow_flakes_option_name[enable_snow_flakes_0]" id="enable_snow_flakes_0-2" value="disable" <?php echo ($checked) ? $checked : ''; ?>>
                <label class="form-check-label" for="enable_snow_flakes_0-2"><?php echo __('Disable', 'nr-snow-flakes'); ?></label>
            </div>
        </fieldset>
    <?php
    }

    public function flakes_count_1_callback()
    {
        printf(
            '<input class="form-control" type="number" min="0" max="500" name="snow_flakes_option_name[flakes_count_1]" id="flakes_count_1" value="%s">',
            isset($this->snow_flakes_options['flakes_count_1']) ? esc_attr($this->snow_flakes_options['flakes_count_1']) : ''
        );
    }

    public function minimum_size_2_callback()
    {
        printf(
            '<input class="form-control" type="number" min="0" max="10" name="snow_flakes_option_name[minimum_size_2]" id="minimum_size_2" value="%s">',
            isset($this->snow_flakes_options['minimum_size_2']) ? esc_attr($this->snow_flakes_options['minimum_size_2']) : ''
        );
    }
    public function maximum_size_2_callback()
    {
        printf(
            '<input class="form-control" type="number" min="0" max="100" name="snow_flakes_option_name[maximum_size_2]" id="maximum_size_2" value="%s">',
            isset($this->snow_flakes_options['maximum_size_2']) ? esc_attr($this->snow_flakes_options['maximum_size_2']) : ''
        );
    }

    public function round_3_callback()
    {
    ?> <fieldset>
            <div class="form-check">
                <?php $checked = (isset($this->snow_flakes_options['round_3']) && $this->snow_flakes_options['round_3'] === 'no') ? 'checked' : ''; ?>
                <input type="radio" class="form-check-input" name="snow_flakes_option_name[round_3]" id="round_3-0" value="no" <?php echo ($checked) ? $checked : 'checked'; ?>>
                <label class="form-check-label" for="round_3-0"><?php echo __('No', 'nr-snow-flakes'); ?></label>
            </div>
            <div class="form-check">
                <?php $checked = (isset($this->snow_flakes_options['round_3']) && $this->snow_flakes_options['round_3'] === 'yes') ? 'checked' : ''; ?>
                <input type="radio" class="form-check-input" name="snow_flakes_option_name[round_3]" id="round_3-1" value="yes" <?php echo $checked; ?>>
                <label class="form-check-label" for="round_3-1"><?php echo __('Yes', 'nr-snow-flakes'); ?></label>
            </div>
        </fieldset>
    <?php
    }

    public function shadow_4_callback()
    {
    ?> <fieldset>
            <div class="form-check">
                <?php $checked = (isset($this->snow_flakes_options['shadow_4']) && $this->snow_flakes_options['shadow_4'] === 'no') ? 'checked' : ''; ?>
                <input type="radio" class="form-check-input" name="snow_flakes_option_name[shadow_4]" id="shadow_4-0" value="no" <?php echo ($checked) ? $checked : 'checked'; ?>>
                <label class="form-check-label" for="shadow_4-0"><?php echo __('No', 'nr-snow-flakes'); ?></label>
            </div>
            <div class="form-check">
                <?php $checked = (isset($this->snow_flakes_options['shadow_4']) && $this->snow_flakes_options['shadow_4'] === 'yes') ? 'checked' : ''; ?>
                <input type="radio" class="form-check-input" name="snow_flakes_option_name[shadow_4]" id="shadow_4-1" value="yes" <?php echo $checked; ?>>
                <label class="form-check-label" for="shadow_4-1"><?php echo __('Yes', 'nr-snow-flakes'); ?></label>
            </div>
        </fieldset>
<?php
    }

    public function image_8_callback()
    {
        printf(
            '<div class="input-group input-group-sm"><input class="form-control" type="text" name="snow_flakes_option_name[image_8]" id="image_8" value="%s"><input id="upload_image_button" class="button" type="button" value="'. __( 'Upload Image', 'nr-snow-flakes').'" />',
            isset($this->snow_flakes_options['image_8']) ? esc_attr($this->snow_flakes_options['image_8']) : ''
        );
    }

    public function collection_name_5_callback()
    {
        printf(
            '<input class="form-control" type="text" name="snow_flakes_option_name[collection_name_5]" id="collection_name_5" value="%s">',
            isset($this->snow_flakes_options['collection_name_5']) ? esc_attr($this->snow_flakes_options['collection_name_5']) : ''
        );
    }

    public function start_date_6_callback()
    {
        printf(
            '<input class="form-control" type="date" name="snow_flakes_option_name[start_date_6]" id="start_date_6" value="%s" placeholder="yyyy-mm-dd" min="2021-12-01">',
            isset($this->snow_flakes_options['start_date_6']) ? esc_attr($this->snow_flakes_options['start_date_6']) : ''
        );
    }

    public function end_date_7_callback()
    {
        printf(
            '<input class="form-control" type="date" name="snow_flakes_option_name[end_date_7]" id="end_date_7" value="%s" placeholder="yyyy-mm-dd" min="2022-01-01">',
            isset($this->snow_flakes_options['end_date_7']) ? esc_attr($this->snow_flakes_options['end_date_7']) : ''
        );
    }
}
if (is_admin())
    $snow_flakes = new SnowFlakes();
