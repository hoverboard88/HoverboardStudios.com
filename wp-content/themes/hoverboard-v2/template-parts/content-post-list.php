<?php
/**
 * Template part for displaying posts list.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hoverboard-v2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php hb_v2_category_icons(get_the_ID()); ?>
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

</article><!-- #post-## -->
