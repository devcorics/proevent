<?php 

// Add Company Settings page in WP Admin
function proevent_register_settings_page() {
    add_menu_page(
        'Company Settings',
        'Company Settings',
        'manage_options',
        'proevent-company-settings', // Menu slug
        'proevent_render_settings_page', // Callback function
        'dashicons-admin-generic',
        20
    );
}
add_action('admin_menu', 'proevent_register_settings_page');

// Register settings
function proevent_register_theme_settings() {
    register_setting('proevent_settings_group', 'proevent_logo');
    register_setting('proevent_settings_group', 'proevent_brand_color');
    register_setting('proevent_settings_group', 'proevent_facebook');
    register_setting('proevent_settings_group', 'proevent_twitter');
    register_setting('proevent_settings_group', 'proevent_linkedin');
    register_setting('proevent_settings_group', 'proevent_instagram');
}
add_action('admin_init', 'proevent_register_theme_settings');

// Render settings page
function proevent_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Company Settings</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php settings_fields('proevent_settings_group'); ?>
            <?php do_settings_sections('proevent_settings_group'); ?>

            <table class="form-table">

                <!-- Logo -->
                <tr valign="top">
                    <th scope="row">Company Logo</th>
                    <td>
                        <?php $logo = esc_url(get_option('proevent_logo')); ?>
                        <input type="text" name="proevent_logo" id="proevent_logo" value="<?php echo $logo; ?>" style="width:50%;" />
                        <input type="button" class="button" id="upload_logo_button" value="Upload Logo" />
                        <input type="button" class="button" id="clear_logo_button" value="Clear Logo" />
                        <div id="logo_preview" style="margin-top:10px;">
                            <?php if ($logo): ?>
                                <img src="<?php echo $logo; ?>" style="max-width:200px; height:auto;" />
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>

                <!-- Brand Color -->
                <tr valign="top">
                    <th scope="row">Brand Color</th>
                    <td>
                        <input type="color" name="proevent_brand_color" value="<?php echo esc_attr(get_option('proevent_brand_color', '#000000')); ?>" />
                    </td>
                </tr>

                <!-- Social Links -->
                <tr valign="top">
                    <th scope="row">Facebook URL</th>
                    <td><input type="url" name="proevent_facebook" value="<?php echo esc_attr(get_option('proevent_facebook')); ?>" style="width:60%;" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Twitter URL</th>
                    <td><input type="url" name="proevent_twitter" value="<?php echo esc_attr(get_option('proevent_twitter')); ?>" style="width:60%;" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">LinkedIn URL</th>
                    <td><input type="url" name="proevent_linkedin" value="<?php echo esc_attr(get_option('proevent_linkedin')); ?>" style="width:60%;" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Instagram URL</th>
                    <td><input type="url" name="proevent_instagram" value="<?php echo esc_attr(get_option('proevent_instagram')); ?>" style="width:60%;" /></td>
                </tr>

            </table>

            <?php submit_button(); ?>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($){
        // Logo uploader
        $('#upload_logo_button').click(function(e){
            e.preventDefault();
            var custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Select Logo',
                button: { text: 'Select Logo' },
                multiple: false
            });
            custom_uploader.on('select', function(){
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#proevent_logo').val(attachment.url);
                $('#logo_preview').html('<img src="'+attachment.url+'" style="max-width:200px;height:auto;" />');
            });
            custom_uploader.open();
        });

        // Clear logo
        $('#clear_logo_button').click(function(){
            $('#proevent_logo').val('');
            $('#logo_preview').html('');
        });
    });
    </script>
    <?php
}

// Enqueue media uploader script for this page
function proevent_enqueue_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_proevent-company-settings') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'proevent_enqueue_admin_scripts');