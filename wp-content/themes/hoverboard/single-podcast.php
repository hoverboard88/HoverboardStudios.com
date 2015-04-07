<?php
/**
 * The template for displaying all single posts.
 *
 * @package Hoverboard Studios
 */

get_header(); ?>

	<div class="wrap wrap--content wrap--category wrap--category--podcast">
		<header class="container container--page-title">
			<div class="title-wrap">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</div>
		</header>
	</div>

	<p>media player? http://mediaelementjs.com/</p>

	<div id="primary" class="content-area wrap">
		<main id="main" class="site-main container" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<div class="wrap wrap--blue wrap--content">
		<div class="container">
			<?php var_dump(comments_open()); ?>
			<?php if ( comments_open() || get_comments_number() ) : ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</div>
	</div>

<?php get_footer(); ?>
