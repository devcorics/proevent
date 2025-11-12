<article>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p>Date: <?php echo get_post_meta(get_the_ID(), '_event_date', true); ?></p>
    <p>Location: <?php echo get_post_meta(get_the_ID(), '_event_location', true); ?></p>
</article>
