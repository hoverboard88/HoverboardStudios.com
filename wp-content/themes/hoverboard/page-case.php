<?php
/* Template Name: Case Study */

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Hoverboard Studios
 */

get_header(); ?>

	<div class="wrap--content wrap--blue">
		<div class="container study-devices">
			<header class="container--page-title">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
			<p><?php echo get_post_meta( get_the_ID(), 'case-study-summary', true ); ?></p>
			<a href="<?php echo get_post_meta( get_the_ID(), 'case-study-url', true ); ?>" class="btn--purple">Website</a>
			<?php echo wp_get_attachment_image( get_post_meta( get_the_ID(), 'case-study-device-image-id', true ), 'full' ); ?>
		</div>
	</div>

	<div id="primary" class="content-area wrap">
		<main id="main" class="site-main container" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
