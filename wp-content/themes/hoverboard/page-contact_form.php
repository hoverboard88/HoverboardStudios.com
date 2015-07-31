<?php
/* Template Name: Contact */

/**
 *
 * This is the Contact Template. It can be used ony page where you want a contact form below the content area.
 *
 * @package Hoverboard
 */

get_header(); ?>

	<div class="wrap--content wrap--ltgreen">
		<header class="container container--page-title">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="wrap">
				<div class="container container--columns">
					<section class="column--half container">

						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'content', 'page' ); ?>

						<?php endwhile; // end of the loop. ?>

					</section><!-- .column––half -->

					<section class="column--half container container--content container--blue">

						<h2>Get in Touch Today</h2>

						<?php echo do_shortcode('[contact-form-7 id="307" title="Contact Form"]'); ?>

					</section><!-- .container -->
				</div><!-- .container––columns -->
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
