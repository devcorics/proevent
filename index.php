<?php get_header(); ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold mb-8 text-center">Blog Posts</h1>

<?php if (have_posts()): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php while (have_posts()): the_post(); ?>
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <?php if (has_post_thumbnail()): ?>
                    <div class="h-48 w-full overflow-hidden">
                        <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                    </div>
                <?php endif; ?>
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors duration-300"><?php the_title(); ?></a>
                    </h2>
                    <p class="text-gray-500 mb-4 text-sm"><?php the_date(); ?> by <?php the_author(); ?></p>
                    <p class="text-gray-700 mb-4"><?php echo wp_trim_words(get_the_content(), 20, '...'); ?></p>
                    <a href="<?php the_permalink(); ?>" class="inline-block text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded transition-colors duration-300">Read More</a>
                </div>
            </article>
        <?php endwhile; ?>
    </div>

    <div class="mt-12 flex justify-center">
        <?php
        the_posts_pagination([
            'prev_text' => '&larr; Previous',
            'next_text' => 'Next &rarr;',
            'mid_size'  => 2,
            'class'     => 'pagination flex space-x-4',
        ]);
        ?>
    </div>
<?php else: ?>
    <p class="text-center text-gray-500">No posts found.</p>
<?php endif; ?>

</main>

<?php get_footer(); ?>
