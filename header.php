<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="bg-white border-b">
  <div class="container mx-auto px-4 py-4 flex items-center justify-between">
    <div class="flex items-center space-x-4">
      <?php $logo = pe_get_company('logo'); ?>
      <a href="<?php echo esc_url( home_url('/') ); ?>" class="flex items-center">
        <?php if ( $logo ): ?>
          <img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo('name'); ?> logo" class="h-10 w-auto" loading="eager" />
        <?php else: ?>
          <span class="text-lg font-semibold"><?php bloginfo('name'); ?></span>
        <?php endif; ?>
      </a>
    </div>

    <nav class="hidden md:block">
      <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'flex gap-4',
            'fallback_cb' => false
        ) );
      ?>
    </nav>

    <button id="pe-toggle-mobile" class="md:hidden p-2">
      <span class="sr-only">Open menu</span>
      <!-- simple hamburger -->
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
  </div>

  <!-- Mobile nav -->
  <div id="pe-mobile-nav" class="md:hidden hidden border-t">
    <div class="px-4 pb-4">
      <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'flex flex-col gap-2',
            'fallback_cb' => false
        ) );
      ?>
    </div>
  </div>
</header>
<main id="site-content" class="min-h-screen">
