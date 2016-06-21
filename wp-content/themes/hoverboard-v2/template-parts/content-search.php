<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hoverboard-v2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="container container--small">
		<header class="entry-header">
			<?php
        if ( get_post_type() == 'studies' ) {
          $categoryTaxonomy = 'tech_category';
        } else {
          $categoryTaxonomy = 'category';
        }
        hb_v2_category_icons(get_the_ID(), $categoryTaxonomy);
      ?>
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'post' === get_post_type() || 'podcast' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php hb_v2_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php
				the_excerpt();
			?>
		</div><!-- .entry-summary -->
	</div><!-- .container NEW -->

</article><!-- #post-## -->
