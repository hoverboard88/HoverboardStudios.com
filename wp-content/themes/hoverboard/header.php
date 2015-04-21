<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Hoverboard Studios
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class('fonts-loaded'); ?>>
<div id="page" class="site">

	<div class="wrap wrap--tiled hfeed">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'hb' ); ?></a>
		<header id="masthead" class="container container--header centered site-header" role="banner">

			<div class="single-spaced logo-h1 site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img class="logo" src="<?php echo get_template_directory_uri(); ?>/dist/img/hoverboard.svg" onerror="this.onerror=null;this.src='<?php echo get_template_directory_uri(); ?>/dist/img/hoverboard.png';" alt="Hoverboard">
				</a>
			</div>

			<nav id="site-navigation" class="main-navigation menu menu--main" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_id' => 'primary-menu' ) ); ?>
				<?php get_search_form(); ?>
				<!-- <button class="search-toggle" type="button">
					<?php hb_func_icon_svg('magnifying-glass'); ?>
				</button> -->
			</nav>

		</header><!-- .container -->
	</div><!-- .wrap -->

	<div id="content" class="site-content">
