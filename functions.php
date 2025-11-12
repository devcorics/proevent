<?php
// Enqueue styles and scripts
function proevent_enqueue_assets() {
    wp_enqueue_style('proevent-style', get_stylesheet_uri());
    wp_enqueue_script('proevent-js', get_template_directory_uri() . '/assets/js/main.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'proevent_enqueue_assets');

// Theme support
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('align-wide');

// Include files
require get_template_directory() . '/inc/cpt.php';
require get_template_directory() . '/inc/settings.php';
require get_template_directory() . '/inc/blocks.php';
