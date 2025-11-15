<?php

/* Custom Block - Hero CTA */
function proevent_register_hero_cta_block() {
    register_block_type( get_template_directory() . '/inc/blocks/hero-cta' );
}
add_action('init', 'proevent_register_hero_cta_block');

function proevent_hero_cta_render($atts = []) {
    $defaults = [
        'imageUrl'   => '', 
        'imageAlt'   => '', 
        'heading'    => 'Your Heading', 
        'buttonText' => 'Click Here', 
        'buttonUrl'  => '#'
    ];
    $atts = wp_parse_args($atts, $defaults);

    ob_start(); // Start output buffering
    ?>
    <div class="hero-cta p-6 text-center bg-gray-100 rounded-lg">
        <?php if ( ! empty($atts['imageUrl']) ) : ?>
            <img src="<?php echo esc_url($atts['imageUrl']); ?>" alt="<?php echo esc_attr($atts['imageAlt']); ?>" class="my-4 mx-auto max-w-full h-auto rounded">
        <?php else: ?>
            <div class="bg-gray-300 w-full h-40 mb-4 rounded flex items-center justify-center text-gray-500">Hero Image</div>
        <?php endif; ?>

        <h1 class="text-3xl font-bold mb-4 text-black"><?php echo esc_html($atts['heading']); ?></h1>

<a href="<?php echo esc_url($atts['buttonUrl']); ?>" 
   class="hero-cta-button inline-block px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transition-all duration-300">
    <?php echo esc_html($atts['buttonText']); ?>
</a>




    </div>
    <?php
    return ob_get_clean(); // Return the HTML
}

/* Custom Block - Event Grid */
function proevent_register_event_grid_block() {
    // Register editor script
    wp_register_script(
        'proevent-event-grid',
        get_template_directory_uri() . '/inc/blocks/event-grid/index.js',
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n', 'wp-block-editor' ],
        filemtime( get_template_directory() . '/inc/blocks/event-grid/index.js' ),
        true
    );

    // Register block type
    register_block_type('proevent/event-grid', [
        'editor_script'   => 'proevent-event-grid',
        'render_callback' => 'proevent_event_grid_render'
    ]);
}
add_action('init', 'proevent_register_event_grid_block');

function proevent_event_grid_render($attributes) {
    $limit = isset($attributes['limit']) ? intval($attributes['limit']) : 6;
    $category = isset($attributes['category']) ? sanitize_text_field($attributes['category']) : '';
    $sort = isset($attributes['sort']) ? sanitize_text_field($attributes['sort']) : 'ASC';

    $args = [
        'post_type'      => 'event',
        'posts_per_page' => $limit,
        'orderby'        => 'meta_value',
        'meta_key'       => '_event_date',
        'order'          => $sort,
    ];

    if ($category) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'event-category',
                'field'    => 'slug',
                'terms'    => $category,
            ]
        ];
    }

    $events = new WP_Query($args);

    if (!$events->have_posts()) {
        return '<p class="text-gray-500 italic">No events found.</p>';
    }

    // Grid container
    $output = '<div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3" style="margin-bottom:20px;">';

    while ($events->have_posts()) {
        $events->the_post();
        $date = get_post_meta(get_the_ID(), '_event_date', true);
        $time = get_post_meta(get_the_ID(), '_event_time', true);
        $permalink = get_permalink();

        // Event card
        $output .= '<div class="event-item bg-white border border-gray-200 rounded-lg p-4 shadow hover:shadow-lg transition-shadow">';
        $output .= '<h3 class="text-lg font-semibold mb-2"><a href="' . esc_url($permalink) . '" class="text-blue-600 hover:underline">' . get_the_title() . '</a></h3>';
        $output .= '<p class="text-gray-600 text-sm">' . esc_html($date) . ' ' . esc_html($time) . '</p>';
        $output .= '</div>';
    }

    $output .= '</div>';

    wp_reset_postdata();
    
    return $output;
}

