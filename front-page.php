<?php get_header(); ?>

<main>
    <h1>Upcoming Events</h1>
    <?php
    $events = new WP_Query(['post_type' => 'event', 'posts_per_page' => -1 ]);
    if ($events->have_posts()):
        while ($events->have_posts()): $events->the_post();
            get_template_part('template-parts/content', 'event');
        endwhile;
        wp_reset_postdata();
    else:
        echo '<p>No upcoming events.</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>
