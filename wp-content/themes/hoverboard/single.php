<?php
/**
 * The template for displaying all single posts.
 *
 * @package Hoverboard Studios
 */

get_header(); ?>

	<div class="wrap wrap--ltgreen wrap--content">
		<header class="container container--page-title">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-meta">
				<?php hb_posted_on(); ?>
			</div><!-- .entry-meta -->
		</header>
	</div>

	<div id="primary" class="content-area wrap">
		<main id="main" class="site-main container" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<div class="wrap wrap--red wrap--content">
		<div class="container">
			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>
		</div>
	</div>

<?php get_footer(); ?>
