(function ($) {
    function snowing(options) {
        if (options) {
            $("#snowflakes-preview").snowfall("clear").snowfall(options);
        } else {
            $("#snowflakes-preview").snowfall("clear");
        }
    }
    $(function () {
        if ($("body").hasClass("wp-admin")) {
            var custom_uploader;
            $('#upload_image_button').click(function (e) {
                e.preventDefault();
                //If the uploader object has already been created, reopen the dialog
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
                //Extend the wp.media object
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });
                //When a file is selected, grab the URL and set it as the text field's value
                custom_uploader.on('select', function () {
                    attachment = custom_uploader.state().get('selection').first().toJSON();
                    $('#image_8').val(attachment.url);
                });
                //Open the uploader dialog
                custom_uploader.open();
            });



            var options = {
                deviceorientation: true,
                flakeCount: (db_options.flakes_count_1) ? parseInt(db_options.flakes_count_1) : 0,
                round: (db_options.round_3 == 'yes') ? true : false,
                shadow: (db_options.shadow_4 == 'yes') ? true : false,
                minSize: (db_options.minimum_size_2) ? parseInt(db_options.minimum_size_2) : 0,
                maxSize: (db_options.maximum_size_2) ? parseInt(db_options.maximum_size_2) : 0,
                image: (db_options.image_8) ? db_options.image_8 : '',
                collection: $('.card-footer'),
            };
            console.log(db_options);

            // Startup Show on loading
            if ($('input[name="snow_flakes_option_name[enable_snow_flakes_0]"]:checked').val() == 'disable' || db_options.enable_snow_flakes_0 == 'disable') {
                snowing(false);
            } else {
                snowing(options);

                // Loading icons
                switch (db_options.enable_snow_flakes_0) {
                    case 'enable':
                        $("#status").html('<span class="dashicons dashicons-yes text-success fs-4"></span>');
                        snowing(options);
                        break;
                    case 'schedule':
                        $("#status").html('<span class="dashicons dashicons-calendar-alt text-warning fs-4"></span>');
                        snowing(options);
                        break;
                    case 'disable':
                        $("#status").html('<span class="dashicons dashicons-no text-danger fs-4"></span>');
                        snowing(false);
                        break;
                }
                    if(options.round) {
                            $("#round").html('<span class="dashicons dashicons-yes text-success fs-4"></span>');
                    }else{
                            $("#round").html('<span class="dashicons dashicons-no text-danger fs-4"></span>');
                    }

                    if(options.shadow) {
                            $("#shadow").html(
								'<span class="dashicons dashicons-yes text-success fs-4"></span>'
							);
                    }else{
                            $("#shadow").html(
								'<span class="dashicons dashicons-no text-danger fs-4"></span>'
							);
                    }
            }


            /**
             * Form Events
             */
            $('input[name="snow_flakes_option_name[enable_snow_flakes_0]"]').on('change', function () {
                switch ($(this).val()) {
                    case 'enable':
                        $("#status").html('<span class="dashicons dashicons-yes text-success fs-4"></span>');
                        snowing(options);
                        break;
                    case 'schedule':
                        $("#status").html('<span class="dashicons dashicons-calendar-alt text-warning fs-4"></span>');
                        snowing(options);
                        break;
                    case 'disable':
                        $("#status").html('<span class="dashicons dashicons-no text-danger fs-4"></span>');
                        snowing(false);
                        break;
                }
            });
            $('input[name="snow_flakes_option_name[flakes_count_1]"]').on('keyup', function () {
                $("#count").text($(this).val());
                options.flakeCount = $(this).val();
                snowing(options);
            });
            $('input[name="snow_flakes_option_name[minimum_size_2]"]').on('keyup', function () {
                $("#minSize").text($(this).val());
                options.minSize = $(this).val();
                snowing(options);
            });
            $('input[name="snow_flakes_option_name[maximum_size_2]"]').on('keyup', function () {
                $("#maxSize").text($(this).val());
                options.maxSize = $(this).val();
                snowing(options);
            });
            $('input[name="snow_flakes_option_name[round_3]"]').on('change', function () {
                switch ($(this).val()) {
                    case 'yes':
                        $("#round").html('<span class="dashicons dashicons-yes text-success fs-4"></span>');
                        options.round = true;
                        break;
                    case 'no':
                        $("#round").html('<span class="dashicons dashicons-no text-danger fs-4"></span>');
                        options.round = false;
                        break;
                }
                snowing(options);
            });
            $('input[name="snow_flakes_option_name[shadow_4]"]').on('change', function () {
                switch ($(this).val()) {
                    case 'yes':
                        $("#shadow").html('<span class="dashicons dashicons-yes text-success fs-4"></span>');
                        options.shadow = true;
                        break;
                    case 'no':
                        $("#shadow").html('<span class="dashicons dashicons-no text-danger fs-4"></span>');
                        options.shadow = false;
                        break;
                }
                snowing(options);
            });
            $('input[name="snow_flakes_option_name[image_8]"]').on('change, blur', function () {
                options.image = $(this).val();
                snowing(options);
            });
        }
    });
})(jQuery);