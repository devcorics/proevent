<?php
// Register CPT "Event"
function proevent_register_cpt() {
    $labels = [
        'name' => 'Events',
        'singular_name' => 'Event',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => ['title','editor','thumbnail'],
    ];

    register_post_type('event', $args);

    // Taxonomy
    register_taxonomy('event-category', 'event', [
        'label' => 'Event Categories',
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'proevent_register_cpt');

// Add ACF-style meta boxes (date, time, location, registration link)
function proevent_event_meta_boxes() {
    add_meta_box('event_details', 'Event Details', 'proevent_event_meta_callback', 'event', 'normal', 'high');
}
add_action('add_meta_boxes', 'proevent_event_meta_boxes');

function proevent_event_meta_callback($post) {
    $date = get_post_meta($post->ID, '_event_date', true);
    $time = get_post_meta($post->ID, '_event_time', true);
    $location = get_post_meta($post->ID, '_event_location', true);
    $link = get_post_meta($post->ID, '_event_link', true);
    wp_nonce_field('proevent_event_nonce', 'proevent_event_nonce');
    ?>
    <p><label>Date: <input type="date" name="event_date" value="<?php echo esc_attr($date); ?>"></label></p>
    <p><label>Time: <input type="time" name="event_time" value="<?php echo esc_attr($time); ?>"></label></p>
    <p><label>Location: <input type="text" name="event_location" value="<?php echo esc_attr($location); ?>"></label></p>
    <p><label>Registration Link: <input type="url" name="event_link" value="<?php echo esc_attr($link); ?>"></label></p>
    <?php
}

function proevent_save_event_meta($post_id) {
    if (!isset($_POST['proevent_event_nonce']) || !wp_verify_nonce($_POST['proevent_event_nonce'], 'proevent_event_nonce')) return;
    update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
    update_post_meta($post_id, '_event_time', sanitize_text_field($_POST['event_time']));
    update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location']));
    update_post_meta($post_id, '_event_link', esc_url_raw($_POST['event_link']));
}
add_action('save_post', 'proevent_save_event_meta');
