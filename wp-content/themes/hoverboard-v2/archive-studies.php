<?php
/**
 * The template for displaying cast study archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hoverboard-v2
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
			$featured_study = hb_v2_get_featured_study();
			$study_id = $featured_study->ID;
		?>

		<div class="wrap wrap--green">
			<div class="container container--padded featured-study">
				<div class="featured-study__info">
					<?php hb_v2_category_icons($study_id, 'tech_category'); ?>
					<h3 class="single-spaced"><?php echo $featured_study->post_title; ?></h3>
					<p>
						<a target="_blank" target="_blank" href="<?php the_field('study_url', $study_id) ?>" class="link--icon">
							<?php hb_v2_svg('mdi-links.svg'); ?>
							<?php echo hb_v2_prettify_url(get_field('study_url', $study_id)); ?>
						</a>
					</p>
					<?php echo wpautop($featured_study->post_excerpt); ?>
					<a href="<?php echo get_permalink($study_id); ?>" class="btn">Case Study</a>
				</div>
				<div class="featured-study__screenshots">

					<div class="portfolio__example featured-study__screenshot-internal">
						<?php echo wp_get_attachment_image(get_field('study_screenshot_internal', $study_id)['id'], 'portfolio_internal'); ?>
	        </div>
					<div class="portfolio__example featured-study__screenshot-desk">
						<?php echo wp_get_attachment_image(get_field('study_screenshot_desk', $study_id)['id'], 'portfolio_home'); ?>
					</div>

				</div>
			</div>
		</div>

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header container container--title-box">
				<h1 class="title-box title-box--teal">
					<div class="title-box__title">
						Our Work
					</div>
				</h1>
			</header><!-- .page-header -->

			<div id="category-tabs" class="container category-tabs">
				<ul>
					<li><a href="/<?php echo get_post_type(); ?>/">All</a></li>
					<?php wp_list_categories( 'taxonomy=tech_category&title_li=' ); ?>
				</ul>
			</div>

			<div class="portfolio container container--xwide">
	      <div class="portfolio__items">

					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'case-study' );

					endwhile;

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>

	    </div>
		</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
