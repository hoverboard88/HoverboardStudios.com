<?php

/**
 * Plugin Name: HoverboardStudios.com Functional Plugin
 * Description: Functionality for Hoverboardstudios.com
 * Version: The plugin's version number. Example: 1.0.0
 * Author: Hoverboard Studios
 * Author URI: http://hoverboardstudios.com
 * Text Domain: hb_func_
 */

/*----------------------------------------------------------------------------*
 * Custom Metaboxes Framework
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'init-metaboxes.php' );
require_once( plugin_dir_path( __FILE__ ) . 'metaboxes/init.php' );

function hb_func_icon_img($icon) {
	$img_url = plugins_url( 'open-iconic/', __FILE__ );
	echo '<img class="hb-icon hb-icon-' . $icon . '" src="' . $img_url . '/svg/' . $icon . '.svg" onerror="this.onerror=null; this.src=\'' . $img_url . '/png/' . $icon . '.png\'">';
}

function hb_func_icon($before='', $after='') {
	$icon = hb_func_post_meta('icon');
	$img_url = plugins_url( 'open-iconic/', __FILE__ );
	if ($icon) {
		echo '<div style="background: ' . hb_func_post_meta('icon_color') . '" class="hb-icon-svg hb-icon-svg-' . $icon . '">';
		echo $before;
		include 'open-iconic/svg/' . $icon . '.svg';
		echo $after;
		echo '</div>';
	}
}

function hb_func_icon_svg($icon) {
	include 'open-iconic/svg/' . $icon . '.svg';
}

function hb_func_icon_name() {
	return get_post_meta( get_the_ID(), '_hb_func_icon')[0];
}

function hb_func_enqueue_styles_admin() {
	wp_enqueue_style( 'iconic-icons', plugins_url( 'open-iconic/font/css/open-iconic.min.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'hb_func_enqueue_styles_admin' );

function hb_func_admin_head() {
	echo '<script charset="utf-8">
		jQuery(document).ready(function($){
			$(".cmb_id__hbf_icon_color input").each(function () {
				$(this).parent().css("background", this.value);
			});
			$(".cmb_id__hbf_icon input").each(function () {
				$("<span class=\"oi\" data-glyph=\"" + this.value + "\" aria-hidden=\"true\"></span>").insertAfter($(this));
			});
		});
	</script>
	<style media="screen">
	.cmb_id__hbf_icon_color li {
		padding: 5px;
		color: #fff;
	}
	@media only screen and (min-width: 400px) {
		.cmb_id__hbf_icon li {
			float: left;
			width: 50%;
		}
	}
	@media only screen and (min-width: 1200px) {
		.cmb_id__hbf_icon li {
			float: left;
			width: 33%;
		}
	}
	</style>';
}
add_action( 'admin_head', 'hb_func_admin_head' );

function hb_func_custom_post_type() {
    $args = array(
      'public' => true,
      'label'  => 'Podcast'
    );
    register_post_type( 'podcast', $args );
}
//add_action( 'init', 'hb_func_custom_post_type' );

function hb_func_post_type_suppports() {
	add_post_type_support( 'podcast', 'comments' );
}
add_action('init', 'hb_func_post_type_suppports');

function custom_upload_mimes ( $existing_mimes=array() ) {

	// add your ext => mime to the array
	$existing_mimes['svg'] = 'mime/type';

	// add as many as you like

	// and return the new full result
	return $existing_mimes;

}

add_filter('upload_mimes', 'custom_upload_mimes');

add_theme_support( 'post-thumbnails' );

// filter post title for tumblr links
function hb_func_link_filter($link, $post) {
	global $post;
	if (get_post_meta($post->ID, '_hbf_link_post_url', true)) {
	  $link = get_post_meta($post->ID, '_hbf_link_post_url', true);
	}
	return $link;
}
add_filter('post_link', 'hb_func_link_filter', 10, 2);

function hb_func_add_icon_to_title( $title, $id = null ) {
	if (get_post_meta($id, '_hbf_link_post_url', true) && get_post_type($id) == 'post') {
	  return $title . ' ∞';
	} else {
		return $title;
	}
}
add_filter( 'the_title', 'hb_func_add_icon_to_title', 10, 2 );

function hb_func_append_link ($content) {
	global $post;

	if (get_post_meta($post->ID, '_hbf_link_post_url', true) && get_post_meta($post->ID, '_hbf_link_post_site', true) && is_single()) {
		return $content . '<p class="hb-func-tumblr-read-more"><a href="' . get_post_meta($post->ID, '_hbf_link_post_url', true) . '">∞ Read the full post on ' . get_post_meta($post->ID, '_hbf_link_post_site', true) . '</a></p>';
	}
  // otherwise returns the database content
  return $content;
}

add_filter( 'the_content', 'hb_func_append_link' );
