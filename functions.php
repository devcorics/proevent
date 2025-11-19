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





// Custom Blocks: Event Grid
add_action('init', function() {
    require get_template_directory() . '/inc/blocks.php';
});

// Auto-load block.json for custom blocks Hero CTA and Event Grid:
add_action( 'init', function() {
    // Auto-load block.json if you prefer, but here we register programmatically:
    register_block_type( 'proevent/event-grid', array(
        'api_version'      => 3,
        'editor_script'    => 'proevent-event-grid-block',
        'render_callback'  => 'proevent_render_event_grid_block',
        'description'  => 'Displays a grid of events with customizable parameters.',
        'attributes'       => array(
            'limit' => array(
                'type'    => 'number',
                'default' => 3,
            ),
            'category' => array(
                'type'    => 'string',
                'default' => '',
            ),
            'order' => array(
                'type'    => 'string',
                'default' => 'DESC',
            ),
        ),
    ));

});

// Custom Blocks: Event Grid -Enqueue block
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_script(
        'proevent-event-grid-block',
        get_template_directory_uri() . '/inc/blocks/event-grid/index.js',
        array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
        filemtime( get_template_directory() . '/inc/blocks/event-grid/index.js' )
    );

});


// Custom Blocks: Hero CTA
function proevent_register_hero_cta_block() {
    wp_register_script(
        'proevent-hero-cta-block',
        get_template_directory_uri() . '/inc/blocks/hero-cta/index.js', // your JS
        array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ), // basic WP dependencies
        filemtime( get_template_directory() . '/inc/blocks/hero-cta/index.js' ),
        true
    );

    wp_register_style(
        'proevent-hero-cta-style',
        get_template_directory_uri() . '/inc/blocks/hero-cta/style.css', // URL for browser
        array(),
        filemtime( get_template_directory() . '/inc/blocks/hero-cta/style.css' ) // server path for version
    );

    register_block_type( 'proevent/hero-cta', array(
        'editor_script' => 'proevent-hero-cta-block',
        'editor_style'  => 'proevent-hero-cta-style',
        'style'         => 'proevent-hero-cta-style',
        'render_callback' => 'proevent_render_hero_cta_block',
        'attributes'      => array(
            'heroImage' => array(
                'type' => 'string',
                'default' => ''
            ),
            'heroHeading' => array(
                'type' => 'string',
                'default' => 'Your Heading Here'
            ),
            'heroButtonText' => array(
                'type' => 'string',
                'default' => 'Click Here'
            ),
            'heroButtonUrl' => array(
                'type' => 'string',
                'default' => '#'
            ),
        ),
    ) );
}
add_action( 'init', 'proevent_register_hero_cta_block' );









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


// Register custom REST API endpoint
add_action('rest_api_init', function() {
    register_rest_route('proevent/v1', '/next', [
        'methods' => 'GET',
        'callback' => 'proevent_get_next_events',
        'permission_callback' => '__return_true', // public endpoint
    ]);
});
function proevent_get_next_events() {
    $today = date('Y-m-d');

    $args = [
        'post_type'      => 'event',
        'posts_per_page' => 5,
        'meta_key'       => '_event_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'meta_query'     => [
            [
                'key'     => '_event_date',
                'value'   => $today,
                'compare' => '>=',
                'type'    => 'DATE',
            ]
        ]
    ];

    $events = get_posts($args);

    $data = [];

    foreach ($events as $event) {
        $data[] = [
            'id'       => $event->ID,
            'title'    => get_the_title($event->ID),
            'link'     => get_permalink($event->ID),
            'date'     => get_post_meta($event->ID, '_event_date', true),
            'time'     => get_post_meta($event->ID, '_event_time', true),
            'location' => get_post_meta($event->ID, '_event_location', true),
            'thumbnail'=> get_the_post_thumbnail_url($event->ID, 'medium'),
        ];
    }

    return $data;
}