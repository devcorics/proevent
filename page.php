<?php get_header(); ?>
<main class="container mx-auto p-4">
    <?php
    if (have_posts()):
        while (have_posts()): the_post();
            get_template_part('template-parts/content', 'page');
        endwhile;
    endif;
    ?>
</main>
<?php get_footer(); ?>
