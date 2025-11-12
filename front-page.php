<?php get_header(); ?>

<main>
    <h1>Upcoming Events</h1>
    <?php
    $today = date('Ymd'); // today's date in Ymd format

    $events = new WP_Query([
        'post_type'      => 'event',
        'posts_per_page' => -1,
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
        while ($events->have_posts()): $events->the_post(); 
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            $event_time = get_post_meta(get_the_ID(), '_event_time', true);
            ?>
            <article class="event-card">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p class="event-datetime">
                    <?php 
                        echo date_i18n('F j, Y', strtotime($event_date)); 
                        if ($event_time) {
                            echo ' @ ' . date_i18n('g:i A', strtotime($event_time));
                        }
                    ?>
                </p>
                <?php the_excerpt(); ?>
            </article>
            <?php
        endwhile;
        wp_reset_postdata();
    else:
        echo '<p>No upcoming events.</p>';
    endif;
    ?>
</main>


<?php get_footer(); ?>
