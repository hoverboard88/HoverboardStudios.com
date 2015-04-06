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
