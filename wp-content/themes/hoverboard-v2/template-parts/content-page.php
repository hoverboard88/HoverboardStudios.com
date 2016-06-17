<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hoverboard-v2
 */

?>

<div class="wrap">
  <div class="container centered container-page-title container--medium container-page-title">
    <h1 class="page-title"><?php the_title(); ?></h1>
  </div>
</div>

<div class="wrap">
  <article id="post-<?php the_ID(); ?>" <?php post_class('content container container--small'); ?>>

  	<div class="entry-content">
  		<?php
  			the_content();

  			wp_link_pages( array(
  				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hb_v2' ),
  				'after'  => '</div>',
  			) );
  		?>
  	</div><!-- .entry-content -->

  </article><!-- #post-## -->
</div>
