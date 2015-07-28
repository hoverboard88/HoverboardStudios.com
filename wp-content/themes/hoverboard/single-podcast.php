<?php
/**
 * The template for displaying all single posts.
 *
 * @package Hoverboard
 */

get_header(); ?>

	<div class="wrap--content wrap--category wrap--category--podcast">
		<header class="container container--page-title">
			<div class="title-wrap">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php hb_posted_on(); ?>
			</div>
		</header>
	</div>

	<div id="primary" class="content-area wrap">
		<main id="main" class="site-main container" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php /*<div class="podcast_player_wrap wrap--blue">
		<div id="podcast_player_wrap" class="container">

		</div>
	</div>

	<script>
	// (function () {
	// 	document.getElementById('podcast_player_wrap').appendChild(document.querySelector('.podcast_player'));
	// 	document.getElementById('podcast_player_wrap').appendChild(document.querySelector('.podcast_meta'));
	// }());
	</script>*/ ?>

	<?php if ( comments_open() || get_comments_number() ) : ?>
		<div class="wrap--blue wrap--content">
			<div class="container">
				<?php comments_template(); ?>
			</div>
		</div>
	<?php endif; ?>

<?php get_footer(); ?>
