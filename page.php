<?php
/**
 * The template for displaying all static pages
 *
 * @package ProEvent
 */

get_header(); ?>

<main class="container mx-auto px-4 py-12">
    <?php

    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>
        
            <article id="post-<?php the_ID(); ?>" <?php post_class('mb-12'); ?>>
                <!-- Page Title -->
                <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center"><?php the_title(); ?></h1>

                <!-- Page Content -->
                <div class="prose max-w-full">
                    <?php the_content(); ?>
                </div>
            </article>

        <?php endwhile;
    else : ?>
        <p class="text-center text-gray-500">Sorry, no content found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
