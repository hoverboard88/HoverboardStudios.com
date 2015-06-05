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
	          <h2>Who We Are</h2>

						<p>We are your next right-hand design and development studio.</p>

						<p>We use your creative ideas for your business, and together we build a digital experience that you and your audience will love.</p>

						<p>Audience Engagement. Application Innovation. Website Speed. </p>

						<p>When it comes to your new website or application, we’re right beside you every step of the way.</p>

						<a class="btn--red" href="<?php echo get_site_url(); ?>/about/">Learn More About Us</a>
	        </div>

	      </div><!-- .container -->
	    </div><!-- .wrap -->

	    <div class="wrap--medblue wrap--content">
	      <div class="container container--columns">
	        <section id="why" class="column--half container container--medblue container--devices">

	          <h2>Why Us?</h2>

						<p>Rather than taking an idea and running potentially off course, Hoverboard focuses on your ideas, your consistent input, and your branding to give you exactly what you’ve imagined for your business.</p>

						<p>We get to know every aspect of what you’re looking for and translate it into your business needs. This way, you’re never paying for anything you don’t need and never sacrificing what you want.</p>

						<h2>Keeping It Small</h2>

						<p>We’re a two-man studio with a passion for design and web development. We want our clients to range from small, engaged shops to large, invested corporations. </p>

						<p>Yet no matter the size, at Hoverboard, we treat all of our clients the same. </p>

						<p>We’re an extension of your company; your own private design and development firm.</p>

						<a class="btn--purple single-spaced" href="<?php echo get_site_url(); ?>/why-us/">More On Our Awesomeness</a>

	          <div class="devices">
	            <img class="img--tablet" src="<?php echo get_template_directory_uri(); ?>/dist/img/tablet.svg" alt="Tablet">
	            <img class="img--laptop" src="<?php echo get_template_directory_uri(); ?>/dist/img/laptop.svg" alt="Laptop">
	            <img class="img--mobile" src="<?php echo get_template_directory_uri(); ?>/dist/img/mobile.svg" alt="Mobile">
	          </div>

	        </section><!-- .column––half -->

	        <section id="contact" class="column--half container container--blue">

						<h2>Get in Touch Today</h2>

						<p>Thinking of a website revamp? Want more information about designing a company app? Looking for feedback on your latest project?</p>

						<p>Let us know what you’re up to and how we can help you on your next project.</p>

						<?php include 'inc/contact-form.php'; ?>

	        </section><!-- .container -->
	      </div><!-- .container––columns -->
	    </div>

	    <div class="wrap--dkgreen wrap--content">
	      <div class="container container--work">
	        <div id="work">

	          <h2>Our Work</h2>

	          <div class="column--half column--half--spaced first">

							<h3><a href="<?php echo get_site_url(); ?>/case-studies/superior-campers/">Superior Campers</a></h3>

							<p><a href="<?php echo get_site_url(); ?>/case-studies/superior-campers/"><img src="<?php echo get_template_directory_uri(); ?>/dist/img/work-supcamp.jpg" alt="screenshot of Superior Campers Web Site"></a></p>

							<p>Superior Campers out of Superior, WI came to us looking for a website revamp. After we had originally created their website in 2008, they had outgrown what they had and was looking to add an active inventory feature on an updated site.</p>

							<a class="btn--green" href="<?php echo get_site_url(); ?>/case-studies/superior-campers/">Full Case Study</a>

	          </div>
	          <div class="column--half column--half--spaced last">

							<h3><a href="<?php echo get_site_url(); ?>/case-studies/standard-distributing/">Standard Distributing</a></h3>

							<p><a href="<?php echo get_site_url(); ?>/case-studies/standard-distributing/"><img src="<?php echo get_template_directory_uri(); ?>/dist/img/work-standard.jpg" alt="screenshot of Standard Distributing Web Site"></a></p>

							<p>Standard Distributing, a convenience store distributer in Oklahoma, needed an overhaul to their website. Their design was dated but worse yet, they couldn’t update it without potentially compromising the design and development of the site.</p>

							<a class="btn--green" href="<?php echo get_site_url(); ?>/case-studies/standard-distributing/">Full Case Study</a>

	          </div>

	        </div>
	      </div>
	    </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
