<?php
/**
 * hoverboard-v2 functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hoverboard-v2
 */

if ( ! function_exists( 'hb_v2_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hb_v2_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on hoverboard-v2, use a find and replace
	 * to change 'hb_v2' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'hb_v2', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'hb_v2' ),
		'footer' => esc_html__( 'Footer', 'hb_v2' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

}
endif;
add_action( 'after_setup_theme', 'hb_v2_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hb_v2_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hb_v2_content_width', 640 );
}
add_action( 'after_setup_theme', 'hb_v2_content_width', 0 );

/**
 * Add classes to post-list for css purposes
 */
function hb_v2_odd_even_classes( $classes ) {
	global $wp_query;

	// if it's archive
	if ( is_category() || is_home() ) {
		if ($wp_query->current_post == 0) {
			$classes[] = 'post-list__first';
			return $classes; // exit
		}

		if ($wp_query->current_post == 1) {
			$classes[] = 'post-list__second';
			return $classes; // exit
		}

		if($wp_query->current_post % 2 == 0) {
			$classes[] = 'post-list__odd';
		}
		else {
			$classes[] = 'post-list__even';
		}
	}

	return $classes;
}
add_filter( 'post_class', 'hb_v2_odd_even_classes' );

function hb_v2_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'hb_v2_excerpt_length', 999 );

function hb_v2_replace_ellipsis($content) {
	return str_replace('[...]',
		'…', $content);
}
add_filter('the_excerpt', 'hb_v2_replace_ellipsis');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Shortcodes.
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Load RSS Feed Customizations
 */
require get_template_directory() . '/inc/rss-feeds.php';

/**
 * Helper Functions
 */
require get_template_directory() . '/inc/helper-functions.php';

/**
 * Styles and Scripts
 */
require get_template_directory() . '/inc/styles-scripts.php';

/**
 * Custom Post Types and such
 */
require get_template_directory() . '/inc/post-types.php';
