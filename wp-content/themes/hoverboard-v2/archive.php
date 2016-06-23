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

			<header class="page-header container container--title-box">
				<h1 class="title-box title-box--icon title-box--<?php echo hb_v2_category_color( get_queried_object() ); ?>">
					<div class="title-box__icon">
						<div class="title-box__icon-svg">
							<?php hb_v2_category_icon(get_queried_object()); ?>
						</div>
						<div class="title-box__chevron">
							<?php hb_v2_svg('chevron-filled.svg'); ?>
						</div>
					</div>
					<div class="title-box__title">
						<?php echo str_replace('Category: ', '', get_the_archive_title()); ?>
					</div>
				</h1>
			</header><!-- .page-header -->

			<div id="category-tabs" class="container category-tabs">
				<ul>
					<?php if (get_post_type() == 'post') {
						$base_slug = 'blog';
					} else {
						$base_slug = get_post_type();
					} ?>
					<li><a href="/<?php echo $base_slug; ?>/">All</a></li>
					<?php wp_list_categories( 'taxonomy=category&title_li=' ); ?>
				</ul>
			</div>

      <div class="post-list post-list--side-by-side container">

        <?php if ( have_posts() ) : ?>

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
