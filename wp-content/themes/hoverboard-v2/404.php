<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hoverboard-v2
 */

get_header(); ?>

	<div id="primary" class="content-area wrap wrap--404">
		<main id="main" class="site-main content container container--medium" role="main">

      <div class="well well--shadowed">
        <h1 class="black h2 single-spaced">Great scott!</h1>
        <p>We can’t find what you’re looking for. Try <button class="toggle-search">searching</button> or perusing our <a href="/blog/">blog</a>. Otherwise, <a href="#contact">get in touch</a> or start with one of these case studies.</p>
      </div>

      <div class="wells--404">

        <?php foreach (hb_v2_get_home_featured_studies() as $key => $featured_study) { ?>
          <div class="well well--purple centered">
            <h3 class="h4 one-half-spaced"><?php echo $featured_study->post_title; ?></h3>
            <p>
              <a target="_blank" target="_blank" href="<?php the_field('study_url', $featured_study->ID) ?>" class="link--icon">
                <?php hb_v2_svg('mdi-links.svg'); ?>
                <?php echo hb_v2_prettify_url(get_field('study_url', $featured_study->ID)); ?>
              </a>
            </p>
            <a href="<?php echo get_permalink($featured_study->ID); ?>" class="btn btn-tertiary">Case Study</a>
          </div>
        <?php } ?>

      </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
