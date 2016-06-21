<?php
/* Template Name: About */
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hoverboard-v2
 */

get_header(); ?>

	<div id="primary" class="main main--content site-content content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' );

			endwhile; // End of the loop.
			?>

			<div class="wrap">
	      <div class="container container--medium container--padded">
	        <div class="well well--no-padding centered">
	          <div class="flex-row">
	            <div class="flex-column flex-column-half">
	              <h3 class="h6">Services</h3>
	              <p>Full Stack Design and Development CMS Integration and Support Continued Support &amp; Maintenance Comprehensive Pagespeed Reports</p>
	            </div>
	            <div class="flex-column flex-column-half">
	              <h3 class="h6">Languages</h3>
	              <p>HTML, CSS, SASS, Javascript, Ruby, PHP, Python</p>
	              <p><strong>and more… Just ask!</strong></p>
	            </div>
	          </div>
	          <div class="flex-row">
	            <div class="flex-column">
	              <h3 class="black h2 base-font single-spaced">Thinking of a website revamp?</h3>
	              <p class="italicized-callout">
	                Looking for feedback on your latest project?<br>
	                Not sure exactly how we could help?
	              </p>
	              <p><a href="#contact" class="btn single-spaced">Get in Touch</a></p>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
