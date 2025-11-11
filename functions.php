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
