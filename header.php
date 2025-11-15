<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-white'); ?>>

<header class="w-full border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-4 flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center">
            <?php 
            $logo = get_option('proevent_logo'); 
            if ($logo) : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url($logo); ?>" 
                         alt="<?php bloginfo('name'); ?>" 
                         class="h-10 w-auto object-contain" loading="lazy"/>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" 
                   class="text-2xl font-bold text-gray-900">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuBtn" 
                class="block md:hidden text-gray-600 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Desktop Menu -->
        <nav id="desktopMenu" class="hidden md:flex space-x-6 text-base font-medium text-gray-700">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s', // remove <ul>
                'fallback_cb'    => false
            ]);
            ?>
        </nav>

    </div>

    <!-- Mobile Menu Dropdown -->
    <nav id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-200">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'flex flex-col p-4 space-y-3 text-gray-700 text-lg',
            'fallback_cb'    => false
        ]);
        ?>
    </nav>

</header>

<script>
document.getElementById('mobileMenuBtn')?.addEventListener('click', () => {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
});
</script>
