<?php
/**
 * Template part for displaying posts list.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hoverboard-v2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('portfolio__item'); ?>>

	<div class="portfolio__summary">
		<header class="entry-header">
			<?php hb_v2_category_icons(get_the_ID(), 'tech_category'); ?>
			<?php the_title( sprintf( '<h2 class="portfolio__title entry-title">', esc_url( get_permalink() ) ), '</h2>' ); ?>
			<?php if (get_field('study_url', get_the_ID())) { ?>
				<a target="_blank" href="<?php the_field('study_url', get_the_ID()) ?>" class="portfolio__website">
					<?php hb_v2_svg('mdi-links.svg'); ?>
					<?php echo hb_v2_prettify_url(get_field('study_url', get_the_ID())); ?>
				</a>
			<?php } ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

		<a href="<?php echo the_permalink(); ?>" class="btn">Case Study</a>
	</div>
	<div class="portfolio__example">
		<?php echo wp_get_attachment_image(get_field('study_screenshot_mobile', get_the_ID())['id'], 'portfolio_mobile'); ?>
	</div>

</article><!-- #post-## -->
