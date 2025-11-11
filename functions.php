<?php
defined('ABSPATH') || exit;

function proevent_setup() {
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');
}
add_action('after_setup_theme', 'proevent_setup');

function proevent_enqueue_assets() {
  wp_enqueue_style('proevent-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'proevent_enqueue_assets');

function proevent_register_cpt() {
  register_post_type('event', [
    'label' => 'Events',
    'public' => true,
    'menu_icon' => 'dashicons-calendar-alt',
    'supports' => ['title','editor','thumbnail'],
    'has_archive' => true,
  ]);

  register_taxonomy('event-category', 'event', [
    'label' => 'Event Categories',
    'hierarchical' => true,
  ]);
}
add_action('init', 'proevent_register_cpt');


add_action('rest_api_init', function() {
  register_rest_route('proevent/v1', '/next', [
    'methods' => 'GET',
    'callback' => 'proevent_get_next_events',
  ]);
});

function proevent_get_next_events() {
  $today = date('Y-m-d');
  $query = new WP_Query([
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'meta_value' => $today,
    'meta_compare' => '>=',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'posts_per_page' => 5,
  ]);

  $events = [];
  foreach($query->posts as $post) {
    $events[] = [
      'title' => get_the_title($post),
      'link' => get_permalink($post),
      'date' => get_post_meta($post->ID, 'event_date', true),
    ];
  }
  return $events;
}

// Add Company Settings page in WP Admin
function proevent_add_company_settings_page() {
    add_theme_page(
        'Company Settings',      // Page title
        'Company Settings',      // Menu title
        'manage_options',        // Capability
        'proevent-company-settings', // Menu slug
        'proevent_render_settings_page' // Callback function
    );
}
add_action('admin_menu', 'proevent_add_company_settings_page');

// Register settings
function proevent_register_theme_settings() {
    register_setting('proevent_settings_group', 'proevent_logo');
    register_setting('proevent_settings_group', 'proevent_brand_color');
    register_setting('proevent_settings_group', 'proevent_facebook');
    register_setting('proevent_settings_group', 'proevent_twitter');
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
    if ($hook !== 'appearance_page_proevent-company-settings') return;
    wp_enqueue_media();
    wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'proevent_enqueue_admin_scripts');


// Register custom meta fields for Event CPT
function proevent_register_event_meta() {

    $fields = [
        'event_date',
        'event_time',
        'event_location',
        'event_registration_link'
    ];

    foreach ($fields as $field) {
        register_post_meta('event', $field, [
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
    }
}
add_action('init', 'proevent_register_event_meta');


// Add admin metabox
function proevent_add_event_metabox() {
    add_meta_box(
        'proevent_event_fields',
        'Event Details',
        'proevent_event_metabox_html',
        'event',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'proevent_add_event_metabox');


function proevent_event_metabox_html($post) {

    $event_date  = get_post_meta($post->ID, 'event_date', true);
    $event_time  = get_post_meta($post->ID, 'event_time', true);
    $location    = get_post_meta($post->ID, 'event_location', true);
    $reg_link    = get_post_meta($post->ID, 'event_registration_link', true);

    wp_nonce_field('proevent_event_fields_nonce', 'proevent_event_fields_nonce');
    ?>

    <style>
        .proevent-field { margin-bottom: 15px; }
        .proevent-field label { font-weight: 600; display:block; margin-bottom: 5px; }
        .proevent-field input { width: 100%; }
    </style>

    <div class="proevent-field">
        <label>Event Date</label>
        <input type="date" name="event_date" value="<?php echo esc_attr($event_date); ?>">
    </div>

    <div class="proevent-field">
        <label>Event Time</label>
        <input type="time" name="event_time" value="<?php echo esc_attr($event_time); ?>">
    </div>

    <div class="proevent-field">
        <label>Location</label>
        <input type="text" name="event_location" value="<?php echo esc_attr($location); ?>">
    </div>

    <div class="proevent-field">
        <label>Registration Link</label>
        <input type="url" name="event_registration_link" value="<?php echo esc_attr($reg_link); ?>">
    </div>

    <?php
}


function proevent_save_event_fields($post_id) {

    if (!isset($_POST['proevent_event_fields_nonce'])) return;
    if (!wp_verify_nonce($_POST['proevent_event_fields_nonce'], 'proevent_event_fields_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = [
        'event_date',
        'event_time',
        'event_location',
        'event_registration_link'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_event', 'proevent_save_event_fields');


