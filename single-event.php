<?php get_header(); ?>
<main>
    <?php
    if (have_posts()):
        while (have_posts()): the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <p>Date: <?php echo get_post_meta(get_the_ID(), '_event_date', true); ?></p>
            <p>Time: <?php echo get_post_meta(get_the_ID(), '_event_time', true); ?></p>
            <p>Location: <?php echo get_post_meta(get_the_ID(), '_event_location', true); ?></p>
            <p><a href="<?php echo get_post_meta(get_the_ID(), '_event_link', true); ?>">Register</a></p>
            <div><?php the_content(); ?></div>
        <?php endwhile;
    endif;
    ?>
</main>
<?php get_footer(); ?>
