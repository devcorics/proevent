<?php
/**
 * ProEvent functions and definitions
 * Requires: WP 6.8+, PHP 8.2+
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* -----------------------------
 * Theme constants
 * ----------------------------- */
define( 'PE_THEME_DIR', get_template_directory() );
define( 'PE_THEME_URI', get_template_directory_uri() );

/* -----------------------------
 * Setup theme supports, menus
 * ----------------------------- */
add_action( 'after_setup_theme', function() {
    load_theme_textdomain( 'proevent', PE_THEME_DIR . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'pe-thumb-medium', 640, 420, true );
    add_image_size( 'pe-thumb-large', 1200, 780, true );

    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption' ) );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'proevent' ),
        'footer'  => __( 'Footer Menu', 'proevent' ),
    ) );
});

/* -----------------------------
 * Enqueue assets (Tailwind CSS built file + small JS)
 * ----------------------------- */
add_action( 'wp_enqueue_scripts', function() {
    // Tailwind built CSS (path: assets/dist/tailwind.css)
    $css_file = PE_THEME_DIR . '/assets/dist/tailwind.css';
    if ( file_exists( $css_file ) ) {
        wp_enqueue_style( 'proevent-tailwind', PE_THEME_URI . '/assets/dist/tailwind.css', array(), filemtime( $css_file ) );
    } else {
        // fallback small CSS if build missing
        wp_enqueue_style( 'proevent-fallback', PE_THEME_URI . '/assets/fallback.css', array(), '0.1' );
    }

    // Theme main script (defer)
    wp_register_script( 'proevent-main', PE_THEME_URI . '/assets/dist/main.js', array(), filemtime( PE_THEME_DIR . '/assets/dist/main.js' ), true );
    wp_script_add_data( 'proevent-main', 'defer', true );
    wp_enqueue_script( 'proevent-main' );

    // Localize a tiny config (example: REST endpoint)
    wp_localize_script( 'proevent-main', 'PE_Config', array(
        'restBase' => esc_url_raw( rest_url( '/proevent/v1' ) ),
    ) );
});

/* -----------------------------
 * Short helper: get company settings (from plugin options)
 * ----------------------------- */
if ( ! function_exists( 'pe_get_company' ) ) {
    function pe_get_company( $key = '' ) {
        $map = array(
            'logo' => get_option( 'pe_logo' ),
            'brand_color' => get_option( 'pe_brand_color' ),
            'social' => json_decode( get_option( 'pe_social_links', '{}' ), true ),
        );
        return $key ? ( $map[$key] ?? false ) : $map;
    }
}

/* -----------------------------
 * Excerpt length & read more
 * ----------------------------- */
add_filter( 'excerpt_length', function( $len ) { return 20; }, 999 );
add_filter( 'excerpt_more', function( $more ) { return ' &hellip;'; } );

/* -----------------------------
 * Optimize images: add loading="lazy" by default to post thumbnails
 * ----------------------------- */
add_filter( 'wp_get_attachment_image_attributes', function( $attr, $attachment ) {
    if ( empty( $attr['loading'] ) ) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}, 10, 2 );

/* -----------------------------
 * Register widget areas (optional)
 * ----------------------------- */
add_action( 'widgets_init', function() {
    register_sidebar( array(
        'name' => __( 'Footer', 'proevent' ),
        'id' => 'sidebar-footer',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
    ) );
});

/* -----------------------------
 * Include template helpers (if exists)
 * ----------------------------- */
if ( file_exists( __DIR__ . '/inc/template-helpers.php' ) ) {
    require_once __DIR__ . '/inc/template-helpers.php';
}
