<?php
/**
 * The template for displaying all single posts.
 *
 * @package Hoverboard
 */

get_header(); ?>

	<div class="wrap--content wrap--category wrap--category--<?php echo get_the_category()[0]->slug; ?>">
		<header class="container container--page-title">
			<div class="title-wrap">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="single__meta">
					<?php hb_posted_on(); ?>
					<?php hb_byline(); ?>
				</div>
			</div>
			<span class="author-gravatar">
				<?php echo get_avatar(get_the_author_meta('ID'), 96); ?>
			</span>
		</header>
	</div>

	<div id="primary" class="content-area wrap">
		<main id="main" class="site-main container" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<div class="wrap--blue wrap--content">
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
