<?php
/**
 * @package Hoverboard Studios
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php hb_func_icon(); ?>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
			<?php hb_posted_on(); ?>
		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			if ( (is_category() || is_archive() || is_home()) && !get_post_meta($post->ID, '_hbf_link_post_url', true) ) {
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

</article><!-- #post-## -->
