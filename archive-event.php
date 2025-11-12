<?php get_header(); ?>
<main>
    <h1>All Events</h1>
    <?php
    if (have_posts()):
        while (have_posts()): the_post();
            get_template_part('template-parts/content', 'event');
        endwhile;
        the_posts_navigation();
    else:
        echo '<p>No events found.</p>';
    endif;
    ?>
</main>
<?php get_footer(); ?>
