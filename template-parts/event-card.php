<?php
// expects inside loop
$post_id = get_the_ID();
$date = get_post_meta( $post_id, '_pe_date', true );
$time = get_post_meta( $post_id, '_pe_time', true );
?>
<article id="post-<?php the_ID(); ?>" class="bg-white border rounded overflow-hidden">
  <a href="<?php the_permalink(); ?>" class="block">
    <?php if ( has_post_thumbnail() ): ?>
      <div class="h-44 md:h-32 overflow-hidden">
        <?php the_post_thumbnail( 'pe-thumb-medium', array( 'class' => 'w-full h-full object-cover', 'loading' => 'lazy' ) ); ?>
      </div>
    <?php endif; ?>
    <div class="p-4">
      <h3 class="text-lg font-semibold mb-1"><?php the_title(); ?></h3>
      <p class="text-sm text-gray-600 mb-2">
        <?php if ( $date ) echo date_i18n( get_option('date_format'), strtotime($date) ); ?>
        <?php if ( $time ) echo ' • ' . esc_html( $time ); ?>
      </p>
      <p class="text-sm text-gray-700"><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>
    </div>
  </a>
</article>
