<?php

/* Custom Block - Hero CTA */
function proevent_register_blocks() {
    register_block_type( get_template_directory() . '/inc/blocks/hero-cta' );
}
add_action('init', 'proevent_register_blocks');


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
        return '<p>No events found.</p>';
    }

    $output = '<div class="event-grid" style="display:grid;gap:20px;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));">';
    while ($events->have_posts()) {
        $events->the_post();
        $date = get_post_meta(get_the_ID(), '_event_date', true);
        $time = get_post_meta(get_the_ID(), '_event_time', true);
        $output .= '<div class="event-item" style="padding:10px;border:1px solid #ddd;border-radius:8px;">';
        $output .= '<h3>' . get_the_title() . '</h3>';
        $output .= '<p>' . esc_html($date) . ' ' . esc_html($time) . '</p>';
        $output .= '</div>';
    }
    $output .= '</div>';
    wp_reset_postdata();

    return $output;
}

