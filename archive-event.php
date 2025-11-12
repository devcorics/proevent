<?php get_header(); ?>

<div class="container mx-auto px-4 py-8">
  <header class="mb-6">
    <h1 class="text-2xl font-bold">Events</h1>
    <?php if ( is_tax() ) : the_archive_description( '<div class="text-gray-600 mt-2">', '</div>' ); endif; ?>
  </header>

  <div class="grid md:grid-cols-3 gap-6">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); get_template_part( 'template-parts/event', 'card' ); endwhile; else: ?>
      <p class="text-gray-600">No events found.</p>
    <?php endif; ?>
  </div>

  <div class="mt-8">
    <?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
  </div>
</div>

<?php get_footer(); ?>
