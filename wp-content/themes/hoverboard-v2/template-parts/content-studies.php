<?php
/**
 * Template part for displaying studies.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hoverboard-v2
 */

?>

<div class="wrap">
	<div class="container container--case-study-title">
		<div class="container-page-title">
			<?php hb_v2_category_icons(get_the_ID(), 'tech_category'); ?>
			<?php the_title( '<h1 class="page-title entry-title">', '</h1>' ); ?>
			<a target="_blank" href="<?php the_field('study_url'); ?>" class="link--icon">
				<?php hb_v2_svg('mdi-links.svg'); ?>
				<?php echo hb_v2_prettify_url(get_field('study_url')); ?>
			</a>
		</div>
	</div>
</div>

<div class="wrap">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="container static entry-content">

			<div class="portfolio__example">
				<?php echo wp_get_attachment_image(get_field('study_screenshot_desk')['id'], 'portfolio_home'); ?>
			</div>

			<div class="content content--case-study">

				<?php
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'hb_v2' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hb_v2' ),
						'after'  => '</div>',
					) );
				?>
			</div>
		</div><!-- .entry-content -->

	</article><!-- #post-## -->
</div>
<div class="wrap">
	<div class="container container--medium container--padded">
		<div class="well">
			<h3>Conclusion</h3>
			<?php the_field('study_conclusion'); ?>
		</div>
	</div>
</div>
