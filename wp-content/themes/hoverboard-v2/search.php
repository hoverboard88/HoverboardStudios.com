<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package hoverboard-v2
 */

get_header(); ?>

	<section id="primary" class="main main--content site-content content-area">
		<main id="main" class="site-main" role="main">

    <div class="container">
      <h1 class="search-title">
        <div class="title-box title-box--chevron title-box--icon title-box--green">
          <div class="title-box__icon">
            <div class="title-box__icon-svg">
              <?php hb_v2_svg('mdi-search.svg'); ?>
            </div>
            <div class="title-box__chevron">
              <?php hb_v2_svg('chevron-filled.svg'); ?>
            </div>
          </div>
          <div class="title-box__title">
            Search Results
            <div class="title-box__title-svg">
              <?php hb_v2_svg('chevron-outline.svg'); ?>
            </div>
          </div>
        </div>
        <div class="search-title__query">
          <?php echo get_search_query(); ?>
        </div>
      </h1>
    </div>

		<?php if ( have_posts() ) : ?>

			<div class="container">
				<div class="well well--full-border well--no-padding centered portfolio-promo">

          <?php foreach (hb_v2_get_home_featured_studies() as $key => $featured_study) { ?>
						<div class="portfolio-promo__item">
							<?php hb_v2_category_icons($featured_study->ID, 'tech_category'); ?>

							<h3 class="black single-spaced"><?php echo $featured_study->post_title; ?></h3>
							<a href="<?php the_field('study_url', $featured_study->ID) ?>" class="portfolio__website">
								<?php hb_v2_svg('mdi-links.svg'); ?>
								<?php echo hb_v2_prettify_url(get_field('study_url', $featured_study->ID)); ?>
							</a>
							<a href="<?php echo get_permalink($featured_study->ID); ?>" class="btn">Case Study</a>
		        </div>
          <?php } ?>

				</div>
			</div>

			<?php

			echo '<div class="container post-list">';

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			echo '</div>';

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
