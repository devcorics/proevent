<?php


/*
function ts_enqueue_notice_block() {
    wp_enqueue_script(
        'custom-notice-block',
        get_template_directory() . '/inc/blocks/custom-notice-block/index.js',
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element'),
        filemtime(get_template_directory() . '/inc/blocks/custom-notice-block/index.js')
    );
}
add_action('enqueue_block_editor_assets', 'ts_enqueue_notice_block');
*/



/* Custom Block - Hero CTA */
function proevent_register_hero_cta_block() {
    register_block_type( get_template_directory() . '/inc/blocks/hero-cta' );
}
add_action('init', 'proevent_register_hero_cta_block');

function proevent_hero_cta_render($atts = []) {
    $defaults = [
        'imageUrl'   => '', 
        'imageAlt'   => '', 
        'heading'    => 'Your Heading', 
        'buttonText' => 'Click Here', 
        'buttonUrl'  => '#'
    ];
    $atts = wp_parse_args($atts, $defaults);

    ob_start(); // Start output buffering
    ?>
    <div class="hero-cta p-6 text-center bg-gray-100 rounded-lg">
        <?php if ( ! empty($atts['imageUrl']) ) : ?>
            <img src="<?php echo esc_url($atts['imageUrl']); ?>" alt="<?php echo esc_attr($atts['imageAlt']); ?>" class="my-4 mx-auto max-w-full h-auto rounded">
        <?php else: ?>
            <div class="bg-gray-300 w-full h-40 mb-4 rounded flex items-center justify-center text-gray-500">Hero Image</div>
        <?php endif; ?>

        <h1 class="text-3xl font-bold mb-4 text-black"><?php echo esc_html($atts['heading']); ?></h1>
        <a href="<?php echo esc_url($atts['buttonUrl']); ?>" 
           class="hero-cta-button inline-block px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transition-all duration-300">
            <?php echo esc_html($atts['buttonText']); ?>
        </a>
    </div>
    <?php
    return ob_get_clean(); // Return the HTML
}


/* Custom Block - Event Grid */
function eventgrid_register_block() {

    // Register block from block.json
    register_block_type( get_template_directory() . '/inc/blocks/event-grid' );

    // Enqueue block script
    wp_enqueue_script(
        'event-grid-block',
        get_template_directory_uri() . '/inc/blocks/event-grid/block.js',
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element'),
        filemtime( get_template_directory() . '/inc/blocks/event-grid/block.js' ),
        true
    );
}
add_action( 'init', 'eventgrid_register_block' );