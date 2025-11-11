<?php
defined('ABSPATH') || exit;

function proevent_setup() {
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');
}
add_action('after_setup_theme', 'proevent_setup');

function proevent_enqueue_assets() {
  wp_enqueue_style('proevent-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'proevent_enqueue_assets');

function proevent_register_cpt() {
  register_post_type('event', [
    'label' => 'Events',
    'public' => true,
    'menu_icon' => 'dashicons-calendar-alt',
    'supports' => ['title','editor','thumbnail'],
    'has_archive' => true,
  ]);

  register_taxonomy('event-category', 'event', [
    'label' => 'Event Categories',
    'hierarchical' => true,
  ]);
}
add_action('init', 'proevent_register_cpt');


add_action('rest_api_init', function() {
  register_rest_route('proevent/v1', '/next', [
    'methods' => 'GET',
    'callback' => 'proevent_get_next_events',
  ]);
});

function proevent_get_next_events() {
  $today = date('Y-m-d');
  $query = new WP_Query([
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'meta_value' => $today,
    'meta_compare' => '>=',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'posts_per_page' => 5,
  ]);

  $events = [];
  foreach($query->posts as $post) {
    $events[] = [
      'title' => get_the_title($post),
      'link' => get_permalink($post),
      'date' => get_post_meta($post->ID, 'event_date', true),
    ];
  }
  return $events;
}