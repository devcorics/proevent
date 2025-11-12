</main>
<footer class="bg-gray-50 border-t mt-12">
  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:justify-between">
      <div>
        <p class="font-semibold"><?php bloginfo('name'); ?></p>
        <p class="text-sm text-gray-600">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
      </div>
      <div class="mt-4 md:mt-0">
        <?php if ( is_active_sidebar( 'sidebar-footer' ) ) : dynamic_sidebar( 'sidebar-footer' ); endif; ?>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
