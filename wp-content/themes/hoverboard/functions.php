<?php
/**
 * Hoverboard Studios functions and definitions
 *
 * @package Hoverboard Studios
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'hb_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hb_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Hoverboard Studios, use a find and replace
	 * to change 'hb' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'hb', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'hb' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'hb_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // hb_setup
add_action( 'after_setup_theme', 'hb_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function hb_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'hb' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'hb_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hb_scripts() {

	//plugin for some reason is enqueuing style on front-end.
	wp_dequeue_style('wpt-twitter-feed');

	if ( is_single() || is_page() ) {
		wp_enqueue_script( 'hb-lightbox', get_template_directory_uri() . '/js/photolightbox.js', array(), '20120206', true );
	}

	wp_dequeue_style('prism-detached');

	wp_enqueue_script( 'hb-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'hb_scripts' );

function hb_wp_footer() {

	if ( is_single() || is_page() ) {
		echo '<link rel="stylesheet" href="' . get_template_directory_uri() .'/single.css" type="text/css" media="all" property="stylesheet">';
		echo '<!-- Include this on pages you want the gallery to appear -->
		<div id="PhotoViewer" class="photo-viewer">
		  <header class="photo-viewer--title">
		    <h1 id="PhotoViewerTitle">Image Title</h1>
		    <div id="PhotoViewerClose" class="photo-viewer--close"><a href="#">X</a></div>
		  </header>
		  <div class="photo-viewer--container">
		    <figure class="photo-viewer--current-image" id="PhotoViewerCurrentImageContainer">
		      <img id="PhotoViewerCurrentImage" src="">
		    </figure>
		  </div>
		  <div class="photo-viewer--controls">
		      <div id="PhotoViewerPreviousImage" class="photo-viewer--previous-image"><a href="#">&laquo; Previous</a></div>
		      <div id="PhotoViewerCount" class="photo-viewer--count">1/10</div>
		      <div id="PhotoViewerNextImage" class="photo-viewer--next-image"><a href="#">Next &raquo;</a></div>
		    </div>
		</div>';
	}

	echo '<link rel="stylesheet" href="' . get_stylesheet_uri() .'" type="text/css" media="all" property="stylesheet">';

	if (!current_user_can('edit_published_posts') && esc_url(home_url()) == 'http://hoverboardstudios.com' ) {
		echo "<script>
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-53685504-1', 'auto']);
	_gaq.push(['_trackPageview']);

	setTimeout(function() {
    window.onscroll = function() {
      window.onscroll = null; // Only track the event once
      _gaq.push(['_trackEvent', 'scroll', 'read']);
    }
	}, 30000);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

	</script>";
	} else {
		echo "<!--- Analytics Unbounce Plugin is working but not tracking you as you are admin-->";
	}
}
add_action( 'wp_footer', 'hb_wp_footer' );

function new_excerpt_more( $more ) {
	return '…';
}
add_filter('excerpt_more', 'new_excerpt_more');

function hb_wp_head() { ?>

	<style><?php include 'inc/critical.css.php'; ?></style>

	<!-- START Favicons -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/dist/img/favicons/Hoverboard.ico">
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/dist/img/favicons/Hoverboard-76.png">
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/dist/img/favicons/Hoverboard-76@2x.png">
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/dist/img/favicons/Hoverboard-60@.png">
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/dist/img/favicons/Hoverboard-60@2x.png">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/dist/img/favicons/Hoverboard.ico">
	<link rel="icon" type="image/png" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/dist/img/favicons/Hoverboard-60.png">
	<!-- END Favicons -->
	<!--[if lt IE 9]><script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script><![endif]-->
<?php }
add_action( 'wp_head', 'hb_wp_head' );

function hb_the_archive_title($before, $after) {
	$title = get_the_archive_title();
	$title = str_replace('Category: ', '', $title);

	echo $before . $title . $after;
}

function hb_comment_theme ($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	$tag = 'li';
	$add_below = 'div-comment'; ?>

	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">

	<div class="comment-meta-wrap">
		<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		<div class="comment-meta commentmetadata">
			<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php echo get_comment_date(); ?><br>
				<?php echo get_comment_time(); ?>
			</a>
		</div>
	</div><!-- .comment-meta-wrap -->

	<div class="comment-wrap">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
			<div class="comment-author vcard">
				<h3>
					<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
				</h3>
			</div>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
				<br />
			<?php endif; ?>

			<?php comment_text(); ?>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
			<?php if ( 'div' != $args['style'] ) : ?>
			</div>
			<?php endif; ?>
	</div>

<?php
}

function hb_filter_the_author ($username) {

	// first check for a first name (last name not necessarily required, right?)
	if ( get_the_author_meta('first_name', $post->post_author) ) {
		// use author's full name rather than user name
		return get_the_author_meta('first_name', $post->post_author) . ' ' . get_the_author_meta('last_name', $post->post_author);
	} else {
		return $username;
	}

}

add_filter('the_author', 'hb_filter_the_author');

add_filter( 'image_send_to_editor', 'fancy_capable', 10, 7);
// to get wrapping div for lightbox. Only do if the $url is an image
function fancy_capable($html, $id, $alt, $title, $align, $url, $size ) {
	if ( strstr($url, '.jpg') || strstr($url, '.jpeg') || strstr($url, '.png') || strstr($url, '.gif') ) {
		return '<div class="lightbox-image">' . $html . '</div>';
	} else {
		return $html;
	}
}
/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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
 * Load Shortcodes
 */
require get_template_directory() . '/inc/shortcodes.php';

function custom_upload_mimes ( $existing_mimes=array() ) {

	// add your ext => mime to the array
	$existing_mimes['svg'] = 'mime/type';

	// add as many as you like

	// and return the new full result
	return $existing_mimes;

}

add_filter('upload_mimes', 'custom_upload_mimes');
