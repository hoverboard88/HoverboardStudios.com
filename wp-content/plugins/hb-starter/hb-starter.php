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

/**
 * Plugin class.
 */

class hb_wp_starter {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @const   string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'hb-wp-starter';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		add_action('after_setup_theme', array( $this, 'hbstarter_setup' ) );
		$this->hbstarter_remove_tags();

	}
	public function hbstarter_remove_tags() {
		global $allowedtags;

		unset($allowedtags['cite']);
		unset($allowedtags['q']);
		unset($allowedtags['del']);
		unset($allowedtags['abbr']);
		unset($allowedtags['acronym']);

	}
	/**
	 * NOTE: Sample
	 *
	 * @since    1.0.0
	 */
	public function hbstarter_setup( $plugins ) {

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

}

hb_wp_starter::get_instance();
