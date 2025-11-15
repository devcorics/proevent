<?php
// Enqueue styles and scripts
function proevent_enqueue_assets() {

    // Main theme stylesheet
    wp_enqueue_style(
        'proevent-style',
        get_stylesheet_uri(),
        array('proevent-tailwind'), // load after Tailwind
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    // Main JS
    wp_enqueue_script(
        'proevent-js',
        get_template_directory_uri() . '/assets/js/main.js',
        array(), // dependencies if any
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true // load in footer
    );

    // Tailwind CSS (compiled via CLI)
    wp_enqueue_style(
        'proevent-tailwind',
        get_stylesheet_directory_uri() . '/src/output.css',
        array(),
        filemtime(get_stylesheet_directory() . '/src/output.css')
    );

}
add_action('wp_enqueue_scripts', 'proevent_enqueue_assets');

// Theme support
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('align-wide');
 
// Include files
require get_template_directory() . '/inc/cpt.php'; // CPT Event, ACF-style custom fields
require get_template_directory() . '/inc/settings.php'; // Company Settings custom settings page
require get_template_directory() . '/inc/blocks.php'; // Custom Blocks: Hero CTA and Event Grid

// Add Menu settings
function proevent_setup() {
    add_theme_support('menus');

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'proevent' ),
        'footer'  => __( 'Footer Menu', 'proevent' )
    ));
}
add_action('after_setup_theme', 'proevent_setup');

// Automatically add lazy-loading to all images in post content
function add_lazy_loading_to_images($content) {
    // Add loading="lazy" to all <img> tags that don't already have it
    $content = preg_replace('/<img(?![^>]*loading=)/i', '<img loading="lazy"', $content);
    return $content;
}
add_filter('the_content', 'add_lazy_loading_to_images');

// WebP image format
add_filter('wp_get_attachment_image_src', function($image, $attachment_id) {
    $webp = str_replace(['.jpg', '.png'], '.webp', $image[0]);
    $file_path = get_attached_file($attachment_id);
    $webp_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $file_path);

    if (file_exists($webp_path)) {
        $image[0] = $webp;
    }
    return $image;
}, 10, 2);
