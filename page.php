<?php
get_header();
if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  <div class="container mx-auto px-4 py-12 max-w-3xl">
    <h1 class="text-3xl font-bold mb-4"><?php the_title(); ?></h1>
    <div class="prose prosee">
      <?php the_content(); ?>
    </div>
  </div>
<?php endwhile; get_footer(); ?>
