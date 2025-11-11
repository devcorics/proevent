<?php get_header(); ?>

<?php
// Fetch custom event fields
$event_date  = get_post_meta(get_the_ID(), 'event_date', true);
$event_time  = get_post_meta(get_the_ID(), 'event_time', true);
$location    = get_post_meta(get_the_ID(), 'event_location', true);
$reg_link    = get_post_meta(get_the_ID(), 'event_registration_link', true);

// Format date (optional)
$event_date_formatted = $event_date ? date("F j, Y", strtotime($event_date)) : '';
?>

<main class="container mx-auto py-10">

    <!-- Event Title -->
    <h1 class="text-4xl font-bold mb-6">
        <?php the_title(); ?>
    </h1>

    <!-- Event Meta Section -->
    <div class="bg-gray-100 p-6 rounded-xl mb-8">

        <?php if ($event_date): ?>
            <p class="text-lg"><strong>Date:</strong> <?php echo esc_html($event_date_formatted); ?></p>
        <?php endif; ?>

        <?php if ($event_time): ?>
            <p class="text-lg"><strong>Time:</strong> <?php echo esc_html($event_time); ?></p>
        <?php endif; ?>

        <?php if ($location): ?>
            <p class="text-lg"><strong>Location:</strong> <?php echo esc_html($location); ?></p>
        <?php endif; ?>

        <?php if ($reg_link): ?>
            <p class="mt-4">
                <a href="<?php echo esc_url($reg_link); ?>" target="_blank" class="inline-block bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">
                    Register Now →
                </a>
            </p>
        <?php endif; ?>

    </div>

    <!-- Featured Image -->
    <?php if (has_post_thumbnail()): ?>
        <div class="mb-8">
            <?php the_post_thumbnail('large', ['class' => 'rounded-xl w-full h-auto']); ?>
        </div>
    <?php endif; ?>

    <!-- Event Content -->
    <article class="prose max-w-none">
        <?php the_content(); ?>
    </article>

    <!-- Related Events by Category -->
    <?php
    $terms = wp_get_post_terms(get_the_ID(), 'event-category', ['fields' => 'ids']);

    if ($terms) {
        $related_events = new WP_Query([
            'post_type' => 'event',
            'post__not_in' => [get_the_ID()],
            'posts_per_page' => 3,
            'tax_query' => [
                [
                    'taxonomy' => 'event-category',
                    'field'    => 'term_id',
                    'terms'    => $terms,
                ]
            ]
        ]);
    ?>

    <?php if (!empty($related_events->posts)): ?>
        <h2 class="text-2xl font-bold mt-12 mb-6">Related Events</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($related_events->posts as $event): ?>
                <div class="p-5 border rounded-lg bg-white shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold">
                        <a href="<?php echo get_permalink($event->ID); ?>" class="hover:underline">
                            <?php echo esc_html($event->post_title); ?>
                        </a>
                    </h3>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php wp_reset_postdata(); } ?>

</main>

<?php get_footer(); ?>
