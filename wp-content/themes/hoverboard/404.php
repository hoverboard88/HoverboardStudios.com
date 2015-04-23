<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Hoverboard Studios
 */

get_header(); ?>

	<div class="wrap--content wrap--medgreen">
		<header class="container container--page-title">
			<h1 class="entry-title"><?php _e( 'Great Scott!', 'hb' ); ?></h1>
		</header>
	</div>

	<div id="primary" class="content-area wrap">
		<main id="main" class="site-main container" role="main">

			<section class="error-404 not-found">

				<div class="page-content">

					<figure  class="wp-caption alignright"><a href="http://en.wikipedia.org/wiki/Emmett_Brown"><img class="size-medium" src="http://upload.wikimedia.org/wikipedia/en/9/97/Doc_Brown.JPG" alt="Doc Brown"></a><figcaption class="wp-caption-text">Source: <a href="http://en.wikipedia.org/wiki/Emmett_Brown">Wikipedia</a></figcaption></figure>

					<p><?php _e( 'It looks like you didn\'t reach 88 mph. Maybe try one of the links below or a search?', 'hb' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<?php if ( hb_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
					<div class="widget widget_categories">
						<h2 class="widget-title"><?php _e( 'Most Used Categories', 'hb' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->
					<?php endif; ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
