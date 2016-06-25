<?php
/**
 * Enqueue scripts and styles.
 */
function hb_v2_scripts() {
	// wp_enqueue_style( 'hb_v2-style', get_template_directory_uri() . '/dist/css/style.css' );

	wp_deregister_script('jquery');

  //plugin for some reason is enqueuing style on front-end.
	wp_dequeue_style('wpt-twitter-feed');

	//don't need CF7 styles. Gonna write our own.
	wp_deregister_style('contact-form-7');

	// dont need their styles either
	wp_dequeue_style('prism-detached');

	// footnotes plugin, jquery.tools doesn't work with our version of jquery.
	wp_dequeue_style('mci-footnotes-css-public');
	wp_dequeue_script('mci-footnotes-js-jquery-tools');

  wp_dequeue_style('slb_core');
	wp_deregister_style('slb_core');


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
  echo '<link rel="stylesheet" href="/wp-content/plugins/simple-lightbox/client/css/app.css?ver=2.5.3" type="text/css" media="all">';
	// TypeKit
	echo '<script> (function(d) { var config = { kitId: "bev1prj", scriptTimeout: 3000, async: true }, h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src="https://use.typekit.net/"+config.kitId+".js";tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s) })(document); </script>';
}
add_action( 'wp_footer', 'hb_v2_wp_footer' );

function hb_v2__wp_head() { ?>
	<style><?php include get_stylesheet_directory() . '/dist/css/critical.css'; ?></style>

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
add_action( 'wp_head', 'hb_v2__wp_head' );
