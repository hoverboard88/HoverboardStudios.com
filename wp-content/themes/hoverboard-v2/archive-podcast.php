<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hoverboard-v2
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header container container--title-box">
				<h1 class="title-box title-box--icon title-box--purple">
					<div class="title-box__icon">
						<div class="title-box__icon-svg">
							<?php hb_v2_svg('mdi-podcast.svg'); ?>
						</div>
						<div class="title-box__chevron">
							<?php hb_v2_svg('chevron-filled.svg'); ?>
						</div>
					</div>
					<div class="title-box__title">
						Podcasts
					</div>
				</h1>
			</header><!-- .page-header -->

      <div class="post-list post-list--side-by-side container">

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'post-list' );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

    </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
