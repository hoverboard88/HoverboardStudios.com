<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Hoverboard Studios
 */
?>

	</div><!-- #content -->

	<div class="wrap--dark">

		<footer class="container container--footer site-footer" id="colophon" role="contentinfo">

			<div class="column--half column--half--spaced first">

				<p class="site-info fine-print single-spaced">©<?php echo date('Y'); ?> Hoverboard. All rights reserved.</p>
				<nav class="menu--social">
					<ul>
						<li class="menu__item menu__item--twitter">
							<a href="https://twitter.com/hoverboard88">
								<?php include 'src/img/social-twitter.svg'; ?>
								<span class="visuallyhidden">Twitter</span>
							</a>
						</li>
						<li class="menu__item menu__item--facebook">
							<a href="https://www.facebook.com/hoverboardstudios">
								<?php include 'src/img/social-facebook.svg'; ?>
								<span class="visuallyhidden">Facebook</span>
							</a>
						</li>
						<li class="menu__item menu__item--linkedin">
							<a href="https://www.linkedin.com/company/hoverboard-studios">
								<?php include 'src/img/social-linkedin.svg'; ?>
								<span class="visuallyhidden">LinkedIn</span>
							</a>
						</li>
						<li class="menu__item menu__item--github">
							<a href="https://github.com/hoverboard88">
								<?php include 'src/img/social-github.svg'; ?>
								<span class="visuallyhidden">GitHub</span>
							</a>
						</li>
						<li class="menu__item menu__item--rss">
							<a href="/feed/">
								<?php include 'src/img/social-rss.svg'; ?>
								<span class="visuallyhidden">RSS</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="column--half column--half--spaced last">
				<p class="address" itemscope itemtype="http://schema.org/LocalBusiness">
					<a itemprop="url" href="<?php echo get_site_url(); ?>">
						<strong itemprop="name">Hoverboard Studios</strong>
					</a><br>
					<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
						<span itemprop="streetAddress">3948 Yosemite Ave South</span>, <span itemprop="addressLocality">Saint Louis Park</span>, <span itemprop="addressRegion">MN</span> <span itemprop="postalCode">55416</span>
					</span><br>
					<span itemprop="telephone">612-351-2373</span>
				</p>
			</div>

		</footer>
	</div>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
