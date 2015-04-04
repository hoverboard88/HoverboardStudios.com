<?php
/**
 * @package Hoverboard Studios
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php hb_posted_on(); ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'hb' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
