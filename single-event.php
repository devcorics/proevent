<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
  $date = get_post_meta( get_the_ID(), '_pe_date', true );
  $time = get_post_meta( get_the_ID(), '_pe_time', true );
  $location = get_post_meta( get_the_ID(), '_pe_location', true );
  $reg = get_post_meta( get_the_ID(), '_pe_registration', true );
?>
<div class="container mx-auto px-4 py-8">
  <article class="proevent-article max-w-4xl mx-auto">
    <header class="mb-6">
      <h1 class="text-3xl font-bold"><?php the_title(); ?></h1>
      <div class="text-sm text-gray-600 mt-2">
        <?php if ( $date ): ?><time datetime="<?php echo esc_attr( $date ); ?>"><?php echo date_i18n( get_option('date_format'), strtotime($date) ); ?></time><?php endif; ?>
        <?php if ( $time ): ?> • <?php echo esc_html( $time ); ?><?php endif; ?>
        <?php if ( $location ): ?> • <?php echo esc_html( $location ); ?><?php endif; ?>
      </div>
    </header>

    <?php if ( has_post_thumbnail() ): ?>
      <div class="mb-6">
        <?php the_post_thumbnail( 'pe-thumb-large', array( 'class' => 'w-full h-auto rounded', 'loading' => 'lazy' ) ); ?>
      </div>
    <?php endif; ?>

    <div class="proevent-content prose max-w-none">
      <?php the_content(); ?>
    </div>

    <?php if ( $reg ): ?>
      <p class="mt-6">
        <a href="<?php echo esc_url( $reg ); ?>" target="_blank" rel="noopener" class="inline-block px-4 py-2 rounded bg-indigo-600 text-white">Register</a>
      </p>
    <?php endif; ?>

    <!-- Related events by category -->
    <?php
    $terms = wp_get_post_terms( get_the_ID(), 'event-category', array( 'fields' => 'ids' ) );
    if ( ! empty( $terms ) ) :
      $rel = new WP_Query( array(
        'post_type' => 'event',
        'posts_per_page' => 3,
        'post__not_in' => array( get_the_ID() ),
        'tax_query' => array( array( 'taxonomy' => 'event-category', 'field' => 'term_id', 'terms' => $terms ) )
      ) );
      if ( $rel->have_posts() ) : ?>
        <section class="mt-10">
          <h3 class="text-xl font-semibold mb-4">Related events</h3>
          <div class="grid md:grid-cols-3 gap-4">
            <?php while ( $rel->have_posts() ) : $rel->the_post(); get_template_part( 'template-parts/event', 'card' ); endwhile; wp_reset_postdata(); ?>
          </div>
        </section>
      <?php endif; ?>
    <?php endif; ?>

  </article>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
