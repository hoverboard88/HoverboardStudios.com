<?php
/**
 * The template for displaying search results pages.
 *
 * @package Hoverboard
 */

get_header(); ?>

<div class="wrap--content wrap--medgreen">
	<header class="container container--page-title">
		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'hb' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</header>
</div>

	<section id="primary" class="content-area wrap">
		<main id="main" class="site-main container" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'content', 'search' );
				?>

			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
