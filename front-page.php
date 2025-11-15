<?php get_header(); ?>

<main class="container max-w-7xl mx-auto p-6">

    <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center">Upcoming Events</h1>
    <?php
    $today = date('Ymd'); // today's date in Ymd format

    $events = new WP_Query([
        'post_type'      => 'event',
        'posts_per_page' => 3,
        'meta_key'       => '_event_date', 
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'meta_query'     => [
            [
                'key'     => '_event_date',
                'value'   => $today,
                'compare' => '>=',
                'type'    => 'DATE'
            ]
        ]
    ]);

    if ($events->have_posts()):
    ?>
    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <?php while ($events->have_posts()): $events->the_post(); 
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            $event_time = get_post_meta(get_the_ID(), '_event_time', true);
        ?>
            <article class="event-card bg-white shadow-md rounded-lg p-4 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:underline"><?php the_title(); ?></a>
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
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
    <?php
        wp_reset_postdata();
    else:
        echo '<p class="text-center text-gray-600">No upcoming events.</p>';
    endif;
    ?>
</main>


<?php get_footer(); ?>
