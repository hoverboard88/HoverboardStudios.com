<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package hoverboard-v2
 */

get_header(); ?>

	<section id="primary" class="main main--content site-content content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<div class="container">
				<h1 class="search-title">
					<div class="search-title__chevron">
						<div class="search-title__icon">
							<?php hb_v2_svg('mdi-search.svg'); ?>
						</div>
						<div class="search-title__title">
							Search Results
						</div>
					</div>
					<div class="search-title__query">
						<?php echo get_search_query(); ?>
					</div>
				</h1>
			</div>

			<!-- TODO: make dynamic. Pull in first 2 case studies. Or maybe 2 featured case studies? -->
			<div class="container">
				<div class="well well--full-border well--no-padding centered portfolio-promo single-spaced">
					<div class="portfolio-promo__item">
						<ul class="list--unstyled list--horizontal list--icons">
							<li class="icon icon--circle icon--tooltip icon--blue">
								<a href="#">
									<svg viewBox="0 0 24 24">
										<path d="M12.2,15.5L9.65,21.72C10.4,21.9 11.19,22 12,22C12.84,22 13.66,21.9 14.44,21.7M20.61,7.06C20.8,7.96 20.76,9.05 20.39,10.25C19.42,13.37 17,19 16.1,21.13C19.58,19.58 22,16.12 22,12.1C22,10.26 21.5,8.53 20.61,7.06M4.31,8.64C4.31,8.64 3.82,8 3.31,8H2.78C2.28,9.13 2,10.62 2,12C2,16.09 4.5,19.61 8.12,21.11M3.13,7.14C4.8,4.03 8.14,2 12,2C14.5,2 16.78,3.06 18.53,4.56C18.03,4.46 17.5,4.57 16.93,4.89C15.64,5.63 15.22,7.71 16.89,8.76C17.94,9.41 18.31,11.04 18.27,12.04C18.24,13.03 15.85,17.61 15.85,17.61L13.5,9.63C13.5,9.63 13.44,9.07 13.44,8.91C13.44,8.71 13.5,8.46 13.63,8.31C13.72,8.22 13.85,8 14,8H15.11V7.14H9.11V8H9.3C9.5,8 9.69,8.29 9.87,8.47C10.09,8.7 10.37,9.55 10.7,10.43L11.57,13.3L9.69,17.63L7.63,8.97C7.63,8.97 7.69,8.37 7.82,8.27C7.9,8.2 8,8 8.17,8H8.22V7.14H3.13Z" />
									</svg>
									<span class="icon-circle__text">Wordpress</span>
								</a>
							</li>
							<li class="icon icon--circle icon--tooltip icon--purple">
								<a href="#">
									<svg viewBox="0 0 24 24">
										<path d="M14.6,16.6L19.2,12L14.6,7.4L16,6L22,12L16,18L14.6,16.6M9.4,16.6L4.8,12L9.4,7.4L8,6L2,12L8,18L9.4,16.6Z" />
									</svg>
									<span class="icon-circle__text">Code</span>
								</a>
							</li>
						</ul>

						<h3 class="black single-spaced">Superior Campers</h3>
						<a href="#" class="portfolio__website">
							<svg viewBox="0 0 24 24">
								<path d="M10.59,13.41C11,13.8 11,14.44 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C7.22,12.88 7.22,9.71 9.17,7.76V7.76L12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.59,9.17C9.41,10.34 9.41,12.24 10.59,13.41M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.78,11.12 16.78,14.29 14.83,16.24V16.24L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L13.41,14.83C14.59,13.66 14.59,11.76 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z" />
							</svg>
							superiorcampers.com
						</a>
						<a href="#" class="btn">Case Study</a>

	        </div>
					<div class="portfolio-promo__item">
						<ul class="list--unstyled list--horizontal list--icons">
							<li class="icon icon--circle icon--tooltip icon--blue">
								<a href="#">
									<svg viewBox="0 0 24 24">
										<path d="M12.2,15.5L9.65,21.72C10.4,21.9 11.19,22 12,22C12.84,22 13.66,21.9 14.44,21.7M20.61,7.06C20.8,7.96 20.76,9.05 20.39,10.25C19.42,13.37 17,19 16.1,21.13C19.58,19.58 22,16.12 22,12.1C22,10.26 21.5,8.53 20.61,7.06M4.31,8.64C4.31,8.64 3.82,8 3.31,8H2.78C2.28,9.13 2,10.62 2,12C2,16.09 4.5,19.61 8.12,21.11M3.13,7.14C4.8,4.03 8.14,2 12,2C14.5,2 16.78,3.06 18.53,4.56C18.03,4.46 17.5,4.57 16.93,4.89C15.64,5.63 15.22,7.71 16.89,8.76C17.94,9.41 18.31,11.04 18.27,12.04C18.24,13.03 15.85,17.61 15.85,17.61L13.5,9.63C13.5,9.63 13.44,9.07 13.44,8.91C13.44,8.71 13.5,8.46 13.63,8.31C13.72,8.22 13.85,8 14,8H15.11V7.14H9.11V8H9.3C9.5,8 9.69,8.29 9.87,8.47C10.09,8.7 10.37,9.55 10.7,10.43L11.57,13.3L9.69,17.63L7.63,8.97C7.63,8.97 7.69,8.37 7.82,8.27C7.9,8.2 8,8 8.17,8H8.22V7.14H3.13Z" />
									</svg>
									<span class="icon-circle__text">Wordpress</span>
								</a>
							</li>
							<li class="icon icon--circle icon--tooltip icon--purple">
								<a href="#">
									<svg viewBox="0 0 24 24">
										<path d="M14.6,16.6L19.2,12L14.6,7.4L16,6L22,12L16,18L14.6,16.6M9.4,16.6L4.8,12L9.4,7.4L8,6L2,12L8,18L9.4,16.6Z" />
									</svg>
									<span class="icon-circle__text">Code</span>
								</a>
							</li>
						</ul>

						<h3 class="black single-spaced">Superior Campers</h3>
						<a href="#" class="portfolio__website">
							<svg viewBox="0 0 24 24">
								<path d="M10.59,13.41C11,13.8 11,14.44 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C7.22,12.88 7.22,9.71 9.17,7.76V7.76L12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.59,9.17C9.41,10.34 9.41,12.24 10.59,13.41M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.78,11.12 16.78,14.29 14.83,16.24V16.24L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L13.41,14.83C14.59,13.66 14.59,11.76 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z" />
							</svg>
							superiorcampers.com
						</a>
						<a href="#" class="btn">Case Study</a>

	        </div>
				</div>
			</div>

			<?php

			echo '<div class="container post-list">';

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			echo '</div>';

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
