<?php
// Enqueue styles and scripts
function proevent_enqueue_assets() {
    wp_enqueue_style('proevent-style', get_stylesheet_uri());
    wp_enqueue_script('proevent-js', get_template_directory_uri() . '/assets/js/main.js', [], false, true);
    wp_enqueue_style('proevent-tailwind',get_stylesheet_directory_uri() . '/src/output.css', array(),filemtime(get_stylesheet_directory() . '/src/output.css') );
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


// WebP image format
add_filter('wp_get_attachment_image_src', function($image) {
    $webp = str_replace(['.jpg', '.png'], '.webp', $image[0]);
    if (file_exists(get_attached_file($image[1]))) {
        $image[0] = $webp;
    }
    return $image;
});


