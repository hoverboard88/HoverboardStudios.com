<?php
/**
 * @package Hoverboard Studios
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<p class="entry-meta">
			<?php hb_posted_on(); ?>
		</p><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			if ( is_category() || is_archive() || is_home() ) {
				the_excerpt();
			} else {
				/* translators: %s: Name of current post */
				the_content( sprintf(
					__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'hb' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			}
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'hb' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php hb_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
