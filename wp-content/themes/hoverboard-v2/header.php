<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hoverboard-v2
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

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link visuallyhidden" href="#main"><?php esc_html_e( 'Skip to content', 'hb_v2' ); ?></a>

	<!-- START Search -->
	<div id="form--search" class="wrap wrap--green-dark wrap--search wrap--gradient-dark">

		<form role="search" role="search" method="get" class="search-form form form--search" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	    <button class="form__submit" type="submit">
	      <svg style="width:32px;height:32px" viewBox="0 0 24 24">
	        <path fill="#013333" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
	      </svg>
	    </button>
	    <input type="search" name="s" placeholder="Search Articles, Work, Bios" class="form__input form--search-input">
	    <script>
	      (function () {
	        var d = document.getElementById("form--search");
	        d.className += " inactive";
	      }());
	    </script>
	  </form>
	</div>
	<!-- END Search -->

	<!-- START Header -->
  <?php
    if (is_page_template('page-home.php')) {
      $gradient_class = 'wrap--gradient';
    } elseif ( is_archive() && get_post_type() === 'studies' ) {
      $gradient_class = '';
    } else {
			$gradient_class = 'wrap--small-gradient';
		}
  ?>
	<header id="masthead" class="wrap wrap--green <?php echo $gradient_class; ?> site-header" role="banner">
    <div class="container container--top-bottom-padding">

			<div class="header-wrap">
			  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" rel="home">
					<?php hb_v2_svg('logo.svg'); ?>
					<span class="site-title visuallyhidden"><?php bloginfo( 'name' ); ?></span>
			  </a>

			  <nav id="site-navigation" class="menu--primary primary--spaced">
			    <ul>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' , 'container' => false, 'items_wrap' => '%3$s') ); ?>
			      <li class="menu-item--search">
			        <button class="toggle-search icon--search">
			          <svg style="width:22px;height:22px" viewBox="0 0 24 24">
			            <path fill="#ffffff" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
			          </svg>
			        </button>
			      </li>
			      <li class="menu-item--contact"><a href="#contact" class="contact-popup-btn btn btn--shadow">Contact</a></li>
			    </ul>
			  </nav>
			</div>

    </div>
		<?php if ( is_page_template('page-home.php') ) { ?>
			<div class="feature-block centered">
				<p class="tagline"><strong>Everyone wants to be heard–your audience included.</strong></p>
				<p class="mission">We believe in your collaboration throughout every part of your project. <br>From design ideas and inspiration to branding and implementation, Hoverboard is determined to bring your audience the very best experience to the web.</p>
				<p class="tagline tagline-small"><strong>We are your right-hand design and development studio.</strong></p>
				<p>
					<a href="/about" class="btn btn--spaced btn-tertiary">About Us</a>
					<a href="/contact" class="btn btn--spaced btn-secondary">Get a Quote</a>
				</p>
			</div>
		<?php } ?>
  </header>
	<!-- END Header -->

	<div role="main" id="content">
