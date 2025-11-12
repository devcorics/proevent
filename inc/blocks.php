<?php

function proevent_register_blocks() {
    // Hero CTA
    register_block_type_from_metadata(__DIR__ . '/blocks/hero-cta');

    // Event Grid
    register_block_type_from_metadata(__DIR__ . '/blocks/event-grid', [
        'render_callback' => function ($attributes) {
            $args = [
                'post_type' => 'event',
                'posts_per_page' => $attributes['limit'] ?? 6,
                'orderby' => 'meta_value',
                'meta_key' => '_event_date',
                'order' => $attributes['order'] ?? 'ASC'
            ];
            if (!empty($attributes['category'])) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'event-category',
                        'field' => 'slug',
                        'terms' => $attributes['category']
                    ]
                ];
            }
            $events = new WP_Query($args);
            if (!$events->have_posts()) return '<p>No events found.</p>';
            $output = '<div class="event-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;">';
            while ($events->have_posts()): $events->the_post();
                $date = get_post_meta(get_the_ID(), '_event_date', true);
                $location = get_post_meta(get_the_ID(), '_event_location', true);
                $output .= '<div class="event-card" style="border:1px solid #ccc;padding:15px;">';
                $output .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                $output .= '<p>Date: ' . esc_html($date) . '</p>';
                $output .= '<p>Location: ' . esc_html($location) . '</p>';
                $output .= '</div>';
            endwhile;
            wp_reset_postdata();
            $output .= '</div>';
            return $output;
        }
    ]);
}
add_action('init', 'proevent_register_blocks');
