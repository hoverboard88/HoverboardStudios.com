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

<?php if (is_page_template('page-about.php')) { ?>
  <div class="wrap">
    <section class="about container">
      <div class="about__partner">
        <div class="about__img">
          <img src="<?php bloginfo('template_directory'); ?>/dist/img/ryan.jpg" alt="">
        </div>
        <div class="about__detail">
          <h4 class="about__title">Ryan Tvenge</h4>
          <div class="about__position">Designer/Developer</div>
          <a class="about__link" href="https://twitter.com/rtvenge">@rtvenge</a>
        </div>
      </div>
      <div class="about__partner">
        <div class="about__img">
          <img src="<?php bloginfo('template_directory'); ?>/dist/img/matt.jpg" alt="">
        </div>
        <div class="about__detail">
          <h4 class="about__title">Matt Biersdorf</h4>
          <div class="about__position">Designer/Developer</div>
          <a class="about__link" href="https://twitter.com/mbiersdo">@mbiersdo</a>
        </div>
      </div>
    </section>
  </div>
<?php } ?>

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
