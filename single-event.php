<?php get_header(); ?>
<main class="container mx-auto px-4 py-12">
    <?php
    if (have_posts()):
        while (have_posts()): the_post(); 

            $event_link = get_post_meta(get_the_ID(), '_event_link', true);

            $event_date = get_post_meta(get_the_ID(), '_event_date', true);

            $event_time = get_post_meta(get_the_ID(), '_event_time', true);

            $event_location = get_post_meta(get_the_ID(), '_event_location', true);

            ?>

            <article class="event-single">
                <h1><?php the_title(); ?></h1>

                <p><strong>Date:</strong> <?php echo $event_date; ?></p>

                <p><strong>Time:</strong> <?php echo $event_time; ?></p>

                <p><strong>Location:</strong> <?php echo $event_location; ?></p>

                <?php if( !empty($event_link) ){ ?>
                <p><strong>Register Link:</strong> <a href="<?php $event_link; ?>" target="_blank" rel="noopener"><?php echo $event_link; ?></a></p>
                <?php } ?>

                <br>
                
                <div class="event-content"><?php the_content(); ?></div>

            </article>

            <?php
            // Get related events by the same category
            $terms = wp_get_post_terms(get_the_ID(), 'event-category', array('fields' => 'ids'));
            if ($terms):
                $related_args = array(
                    'post_type' => 'event',
                    'posts_per_page' => 3,
                    'post__not_in' => array(get_the_ID()),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'event-category',
                            'field'    => 'term_id',
                            'terms'    => $terms,
                        ),
                    ),
                );
                $related_events = new WP_Query($related_args);

                if ($related_events->have_posts()): ?>
                    <br>
                    <br>
                    <section class="related-events">
                        <h2>Related Events</h2>
                        <ul>
                            <?php while ($related_events->have_posts()): $related_events->the_post(); ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    <span><?php echo get_post_meta(get_the_ID(), '_event_date', true); ?></span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </section>
                <?php endif;
                wp_reset_postdata();
            endif;
        endwhile;
    endif;
    ?>
</main>
<?php get_footer(); ?>
