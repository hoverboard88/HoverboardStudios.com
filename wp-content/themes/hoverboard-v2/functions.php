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

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'hb_v2_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
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
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hb_v2_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'hb_v2' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'hb_v2' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'hb_v2_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hb_v2_scripts() {
	// wp_enqueue_style( 'hb_v2-style', get_template_directory_uri() . '/dist/css/style.css' );

	wp_deregister_script('jquery');
  wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js", false, null);
  wp_enqueue_script('jquery');

	wp_enqueue_script( 'hb_v2-mainjs', get_template_directory_uri() . '/dist/js/main.min.js', array('jquery'), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hb_v2_scripts' );

function hb_v2_wp_footer() {
	echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/dist/css/style.css" type="text/css" media="all" />';
}
add_action( 'wp_footer', 'hb_v2_wp_footer' );

function hb_v2__wp_head() {
	echo '<style>';
	include get_stylesheet_directory() . '/dist/css/critical.css';
	echo '</style>';

	// TypeKit
	echo '<script> (function(d) { var config = { kitId: "bev1prj", scriptTimeout: 3000, async: true }, h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src="https://use.typekit.net/"+config.kitId+".js";tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s) })(document); </script>';
}
add_action( 'wp_head', 'hb_v2__wp_head' );

function hb_v2_cpts() {

	register_post_type( 'studies',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Case Studies' ),
				'singular_name' => __( 'Case Study' )
			),
			'supports' => array( 'excerpt', 'editor', 'title' ),
			'taxonomies' => array( 'category' ),

			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'studies'),
		)
	);

}
add_action( 'init', 'hb_v2_cpts' );

function hb_v2_svg($file, $default = '') {
	if ( file_exists(get_template_directory() . '/dist/img/' . $file) ) {
		echo file_get_contents(get_template_directory() . '/dist/img/' . $file);
	} else {
		echo file_get_contents(get_template_directory() . '/dist/img/' . $default);
	}
}

function hb_v2_prettify_url($url) {
	return preg_replace("/https?:\/\/(.*)/u", "$1", $url);
}

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

function hb_v2_category_color($queried_object) {
	$term_id = $queried_object->term_id;
	return get_field('category-icon-color', get_category($term_id));
}

function hb_v2_category_icon($queried_object) {
	$term_id = $queried_object->term_id;
	return hb_v2_svg('mdi-' . get_category($term_id)->slug . '.svg', 'mdi-default.svg');
}

function hb_v2_get_featured_study() {

	$args = array(
		'posts_per_page'   => 1,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'meta_key'         => 'study_index_featured',
		'meta_value'       => '1',
		'post_type'        => 'studies',
		'post_status'      => 'publish'
	);

	$posts_array = get_posts( $args );

	return $posts_array[0];

}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Create Custom Fields via Advanced Custom Fields plugin
 */
// require get_template_directory() . '/inc/advanced-custom-fields.php';

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
