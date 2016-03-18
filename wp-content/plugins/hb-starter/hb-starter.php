<?php
/**
 * Plugin Name: Hoverboard Starter Plugin
 * Plugin URI: https://github.com/hoverboard88/
 * Description: Strips out unneeded stuff in Wordpress
 * Version: 1.0
 * Author: Ryan Tvenge <ryan@hoverboardstudios.com>
 * Author URI: http://hoverboardstudios.com
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Turn off things that can screw things up.
 */

if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}
if ( ! defined( 'DISALLOW_FILE_MODS' ) ) {
	define( 'DISALLOW_FILE_MODS', true );
}

function hb_starter_setup () {
  remove_action('wp_head', 'wp_generator');                // #1
  remove_action('wp_head', 'wlwmanifest_link');            // #2
  remove_action('wp_head', 'rsd_link');                    // #3
  remove_action('wp_head', 'wp_shortlink_wp_head');        // #4

  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);    // #5

  add_filter('the_generator', '__return_false');            // #6
  add_filter('show_admin_bar','__return_false');            // #7

  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );  // #8
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action('after_setup_theme', 'hb_starter_setup');

function hb_starter_init () {

  // Remove Cookies
  remove_action('set_comment_cookies', 'wp_set_comment_cookies');

  // remove outdated tags
  global $allowedtags;

  unset($allowedtags['cite']);
  unset($allowedtags['q']);
  unset($allowedtags['del']);
  unset($allowedtags['abbr']);
  unset($allowedtags['acronym']);

  // html5 elements
  add_theme_support('html5',
    array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'widgets')
  );

}
add_action( 'init', 'hb_starter_init' );

function hb_starter_template_redirect () {
  global $wp_query, $post;

  if ( is_attachment() ) {
    $post_parent = $post->post_parent;

    if ( $post_parent ) {
      wp_redirect( get_permalink($post->post_parent), 301 );
      exit;
    }

    $wp_query->set_404();

    return;
  }

  if ( is_author() || is_date() ) {
    $wp_query->set_404();
  }
}

// remove attachment pages (pretty useless)
add_action( 'template_redirect', 'hb_starter_template_redirect' );

function hb_starter_add_lightbox_class( $html, $id ) {
  $url = wp_get_attachment_image_src($id, 'large');

  $html = preg_replace('/<a href="[^"]+\.(jpe?g|gif|png)">/i', '<a href="' . $url[0] . '">', $html);

  return $html;
}
add_filter( 'image_send_to_editor', 'hb_starter_add_lightbox_class', 10, 3 );

function hb_starter_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="video-wrapper">' . $html . '</div>';
}
// so you can use fitvids.js
add_filter('embed_oembed_html', 'hb_starter_embed_oembed_html', 9999, 4);

function hb_starter_enqueue() {
  wp_deregister_script('jquery');
  wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", array(), '1.10.2', true);
  wp_enqueue_script('jquery');
}
add_action("wp_enqueue_scripts", "hb_starter_enqueue", 11);
