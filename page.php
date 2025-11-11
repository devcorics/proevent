<?php get_header(); ?>

<main class="container mx-auto p-4">
  <?php
    if ( have_posts() ) :
      while ( have_posts() ) : the_post();
        ?>
        <h1 class="text-3xl font-bold mb-4"><?php the_title(); ?></h1>
        <div class="content">
          <?php the_content(); ?>
        </div>
        <?php
      endwhile;
    endif;
  ?>
</main>

<?php get_footer(); ?>