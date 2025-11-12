<?php
function proevent_register_settings_page() {
    add_menu_page(
        'Company Settings',
        'Company Settings',
        'manage_options',
        'proevent-settings',
        'proevent_settings_page_html',
        'dashicons-admin-generic',
        20
    );
}
add_action('admin_menu', 'proevent_register_settings_page');

function proevent_settings_page_html() {
    if (!current_user_can('manage_options')) return;
    if (isset($_POST['proevent_save_settings'])) {
        update_option('proevent_logo', esc_url($_POST['proevent_logo']));
        update_option('proevent_color', sanitize_hex_color($_POST['proevent_color']));
        update_option('proevent_facebook', esc_url($_POST['proevent_facebook']));
        update_option('proevent_twitter', esc_url($_POST['proevent_twitter']));
        echo '<div class="updated">Settings saved!</div>';
    }

    $logo = get_option('proevent_logo');
    $color = get_option('proevent_color');
    $facebook = get_option('proevent_facebook');
    $twitter = get_option('proevent_twitter');
    ?>
    <form method="POST">
        <p>Logo URL: <input type="text" name="proevent_logo" value="<?php echo esc_attr($logo); ?>"></p>
        <p>Brand Color: <input type="color" name="proevent_color" value="<?php echo esc_attr($color); ?>"></p>
        <p>Facebook URL: <input type="url" name="proevent_facebook" value="<?php echo esc_attr($facebook); ?>"></p>
        <p>Twitter URL: <input type="url" name="proevent_twitter" value="<?php echo esc_attr($twitter); ?>"></p>
        <p><input type="submit" name="proevent_save_settings" value="Save Settings"></p>
    </form>
    <?php
}
