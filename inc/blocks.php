<?php

/**
 * Render callback for Hero with CTA block
 */
function proevent_render_hero_cta_block( $attributes ) {
    $image = ! empty( $attributes['heroImage'] ) ? esc_url( $attributes['heroImage'] ) : '';
    $heading = ! empty( $attributes['heroHeading'] ) ? esc_html( $attributes['heroHeading'] ) : '';
    $button_text = ! empty( $attributes['heroButtonText'] ) ? esc_html( $attributes['heroButtonText'] ) : '';
    $button_url = ! empty( $attributes['heroButtonUrl'] ) ? esc_url( $attributes['heroButtonUrl'] ) : '#';

    ob_start(); ?>
    <section class="hero-cta bg-gray-100 py-16 text-center">
        <?php if ( $image ) : ?>
            <div class="hero-image mb-6">
                <img src="<?php echo $image; ?>" alt="<?php echo $heading; ?>" class="mx-auto" />
            </div>
        <?php endif; ?>
        <?php if ( $heading ) : ?>
            <h1 class="text-4xl font-bold mb-4 text-black"><?php echo $heading; ?></h1>
        <?php endif; ?>
        <?php if ( $button_text ) : ?>
            <a href="<?php echo $button_url; ?>">
                <button class="inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                    <?php echo $button_text; ?>
                </button>
            </a>
        <?php endif; ?>
    </section>
    <?php
    return ob_get_clean();
}




/**
 * Render Callback for Event Grid
 */
function proevent_render_event_grid_block( $attributes ) {
    $limit    = isset( $attributes['limit'] ) ? intval( $attributes['limit'] ) : 6;
    $category = isset( $attributes['category'] ) ? sanitize_text_field( $attributes['category'] ) : '';
    $order    = isset( $attributes['order'] ) ? sanitize_text_field( $attributes['order'] ) : 'DESC';

    $args = array(
        'post_type'      => 'event',
        'posts_per_page' => $limit,
        'order'          => $order,
    );

    // Filter by event-category taxonomy
    if ( $category ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'event-category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }

    $events = new WP_Query( $args );

    ob_start();

    if ( $events->have_posts() ) :

        $grid_classes = "grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3";

        echo '<div class="event-grid-block py-8">';
        echo '<div class="' . esc_attr($grid_classes) . '">';

        while ( $events->have_posts() ) :
            $events->the_post();
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            $event_time = get_post_meta(get_the_ID(), '_event_time', true);

            echo '<div class="event-item event-card bg-white shadow-md rounded-lg p-4 hover:shadow-xl transition-shadow duration-300">';
            
            if ( has_post_thumbnail() ) {
                echo '<div class="event-thumb overflow-hidden mb-2">';
                echo '<a href="' . get_permalink(get_the_ID()) . '">';
                echo get_the_post_thumbnail( get_the_ID(), 'medium', array( 'class' => 'w-full h-48 object-cover transition-transform duration-300 hover:scale-105' ) );
                echo '</a>';
                echo '</div>';
            }
            ?>
                <h2 class="text-xl font-semibold mb-2">
                    <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="text-blue-600 hover:underline"><?php echo get_the_title( get_the_ID() ); ?></a>
                </h2>
                <p class="text-gray-500 mb-3">
                    <?php 
                        echo date_i18n('F j, Y', strtotime($event_date)); 
                        if ($event_time) {
                            echo ' @ ' . date_i18n('g:i A', strtotime($event_time));
                        }
                    ?>
                </p>
                <div class="text-gray-700">
                    <?php echo get_the_excerpt( get_the_ID() ); ?>
                </div>

            <?php

            echo '</div>'; // end event-item

        endwhile;

        echo '</div>'; // end event-grid
        echo '</div>'; // end event-grid-block

    else :
        echo '<p>No events found.</p>';
    endif;

    wp_reset_postdata(); // reset query

    return ob_get_clean();
}

