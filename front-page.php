<?php
/**
 * Front Page Template
 *
 * @package YourTheme
 */

get_header(); ?>

<main class="bg-gray-50 min-h-screen p-6">
    
    <section id="content" class="py-12">
        <div class="max-w-4xl mx-auto">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="mb-8 p-6 bg-white rounded shadow">
                        <h2 class="text-2xl font-semibold mb-2"><?php the_title(); ?></h2>
                        <div class="text-gray-700">
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="text-center text-gray-500">No posts found.</p>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
