<?php
/**
 * Template Name: Home Page
 *
 * This is the Home Page Template. It can be used on any page if you want, but only recommended for home and landing pages.
 *
 * @package Hoverboard Studios
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="wrap--hero">
	      <div class="container container--hero">

	        <div class="content-block">
	          <h2>Ready to engage with your website?</h2>
						<p>Get involved in the building of your own website or app as the creative visionary leader, and help us to create a custom-branded website or application specific for your business.</p>
	        </div>

	      </div><!-- .container -->
	    </div><!-- .wrap -->

	    <div class="wrap--content wrap--ltgreen">
	      <div id="about" class="container container--who-we-are">

	        <img class="img--desktop" src="<?php echo get_template_directory_uri(); ?>/dist/img/desktop.svg" alt="Desktop">

	        <div class="content-block content-block--who-we-are">
	          <h2>About Us</h2>

						<p>Matt and Ryan are the co-owners and two-person team behind Hoverboard Studios. Having engrossed themselves with all things tech for over 10 years, they each bring an incredible understanding of websites and web applications to your project—the do’s, don’ts, and ingrained know-how.</p>

						<a class="btn--red" href="/about/">Learn More About Us</a>
	        </div>

	      </div><!-- .container -->
	    </div><!-- .wrap -->

	    <div class="wrap--ltblue wrap--content">
	      <div class="container container--columns">
	        <section id="why" class="column--half container container--ltblue container--devices">

	          <h2>Why Us?</h2>

						<p>We believe in your collaboration throughout every part of your project. From design ideas and inspiration to branding and implementation, Hoverboard is determined to bring your audience the very best experience to the web.</p>

						<p>Our attention to detail allows us to better understand your clients, customers, and prospects through your eyes. Get that creative edge through knowing your audience and together building something specifically for them.</p>

	          <a class="btn--purple single-spaced" href="/why-us/">More On Our Awesomeness</a>

	          <div class="devices">
	            <img class="img--tablet" src="<?php echo get_template_directory_uri(); ?>/dist/img/tablet.svg" alt="Tablet">
	            <img class="img--laptop" src="<?php echo get_template_directory_uri(); ?>/dist/img/laptop.svg" alt="Laptop">
	            <img class="img--mobile" src="<?php echo get_template_directory_uri(); ?>/dist/img/mobile.svg" alt="Mobile">
	          </div>

	        </section><!-- .column––half -->

	        <section id="contact" class="column--half container container--blue">

						<h2>Get in Touch Today</h2>

						<p>Have a project already in mind but don’t know where to start? Looking for some advice or a quote on a branding revamp? Have an idea for an app but feel lost?</p>

						<p>Send us a quick note about your upcoming project and we will be happy to help!</p>

						<?php include 'inc/contact-form.php'; ?>

	        </section><!-- .container -->
	      </div><!-- .container––columns -->
	    </div>

	    <div class="wrap--dkgreen wrap--content">
	      <div class="container container--work">
	        <div id="work">

	          <h2>Our Work</h2>

	          <div class="column--half column--half--spaced first">

							<h3><a href="http://superiorcampers.com">Superior Campers</a></h3>

							<p><a href="http://superiorcampers.com"><img src="<?php echo get_template_directory_uri(); ?>/dist/img/work-supcamp.jpg" alt="screenshot of Superior Campers Web Site"></a></p>

							<p>This Superior, Wisconsin based camper and trailer dealership came to us originally in 2008 looking for a fresh, new website.</p>

							<p>Six years later, Superior Camper had outgrown their website and was looking for an updated design that was easy for their customers to navigate.</p>

							<p>Using an active-inventory addition and updating their current design, nature-lovers can easily find the exact home away from home they’re looking for online before ever setting foot on the lot.</p>

							<a class="btn--green" href="^_^">Full Case Study</a>

	          </div>
	          <div class="column--half column--half--spaced last">

							<h3><a href="http://standarddistributing.com">Standard Distributing</a></h3>

							<p><a href="http://standarddistributing.com"><img src="<?php echo get_template_directory_uri(); ?>/dist/img/work-standard.jpg" alt="screenshot of Standard Distributing Web Site"></a></p>

							<p>Hailing from Sapulpa, Oklahoma, Standard Distributing works to bring the sweet and salty snacks to local convenience stores. They came to us looking for something professional that could be edited anytime they wanted.</p>

							<p>Using custom menus, widgets, and customizers, Standard Distributing is now able to pick and choose exactly what they want from day to day without compromising the look and feel of their branding or their website.</p>

							<p>Less hassle and website-frustrations. More work and profit.</p>

							<a class="btn--green" href="^_^">Full Case Study</a>

	          </div>

	        </div>
	      </div>
	    </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
