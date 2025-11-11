<?php
$logo = get_option('proevent_logo');
$brand_color = get_option('proevent_brand_color');
$facebook = get_option('proevent_facebook');
$twitter = get_option('proevent_twitter');
$instagram = get_option('proevent_instagram');
?>

<header class="site-header" style="background-color: <?php echo esc_attr($brand_color); ?>;">
    <div class="container mx-auto flex justify-between items-center py-4">
        <?php if ($logo): ?>
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo esc_url($logo); ?>" alt="Company Logo" class="h-12">
            </a>
        <?php else: ?>
            <h1 class="text-white">ProEvent</h1>
        <?php endif; ?>

        <nav class="flex space-x-4">
            <?php if ($facebook): ?><a href="<?php echo esc_url($facebook); ?>">Facebook</a><?php endif; ?>
            <?php if ($twitter): ?><a href="<?php echo esc_url($twitter); ?>">Twitter</a><?php endif; ?>
            <?php if ($instagram): ?><a href="<?php echo esc_url($instagram); ?>">Instagram</a><?php endif; ?>
        </nav>
    </div>
</header>