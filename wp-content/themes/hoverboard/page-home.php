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

			<div class="wrap wrap--hero">
	      <div class="container container--hero">

	        <div class="content-block">
	          <p>Hoverboard is a design and development studio that creates innovative digital experiences to fit the needs of engaged clients.</p>
	          <!-- <p>We'd want to hear from you!<br>
	          612-351-2373</p> -->
	        </div>

	      </div><!-- .container -->
	    </div><!-- .wrap -->

	    <div class="wrap wrap--content wrap--ltgreen">
	      <div id="about" class="container container--who-we-are">

	        <img class="img--desktop" src="<?php echo get_template_directory_uri(); ?>/dist/img/desktop.svg" alt="Desktop">

	        <div class="content-block content-block--who-we-are">
	          <h2>Who We Are</h2>

	          <p>We create digital experiences for websites with a passion for using the latest web technologies. The user experience is optimized for any device, whether browsing on a phone or a desktop computer.</p>

	          <p>We utilize user-friendly content management systems, such as Wordpress, so that our clients can quickly and easily edit site content.</p>
	        </div>

	      </div><!-- .container -->
	    </div><!-- .wrap -->

	    <div class="wrap wrap--medgreen wrap--content">
	      <div class="container container--columns">
	        <section id="why" class="column--half container container--medgreen container--devices">

	          <h2>Why Us?</h2>

	          <p>We believe it is important to incorporate our clients into the development process from the beginning and continue a high level of collaboration throughout the project.</p>

	          <p>Our goal is to identify the needs and ensure we are creating the appropriate solutions for our clients. We work to create a positive experience for both the client and end user throughout the entire process so that together, we create something great.</p>

	          <h2>Keeping it Small</h2>

	          <p class="single-spaced">We are a small, two-person studio. Our focus is to provide a hands-on experience that is dedicated to our client’s work. This provides our customers the benefit of a close, personal team.</p>

	          <div class="devices">
	            <img class="img--tablet" src="<?php echo get_template_directory_uri(); ?>/dist/img/tablet.svg" alt="Tablet">
	            <img class="img--laptop" src="<?php echo get_template_directory_uri(); ?>/dist/img/laptop.svg" alt="Laptop">
	            <img class="img--mobile" src="<?php echo get_template_directory_uri(); ?>/dist/img/mobile.svg" alt="Mobile">
	          </div>

	        </section><!-- .column––half -->

	        <section id="contact" class="column--half container container--red">

	          <h2>Get In Touch</h2>

	          <p class="work__blurb">Do you have a project/product in mind? Did you just wrap up a project and want a second set of eyes to take a look?</p>

	          <p>We just need a few things from you:</p>

	          <form class="capsule-crm-form" onsubmit="return split_names();" action="https://service.capsulecrm.com/service/newlead" method="post">
	            <p id="alert__thank-you" class="alert__thank-you alert alert-success well">Thank you for contacting us! We'll be in touch.</p>
	            <input type="hidden" name="FORM_ID" value="527b4032-3da6-4716-8ced-67426a4aea61">
	            <input type="hidden" name="COMPLETE_URL" value="http://hoverboardstudios.com/#alert__thank-you">

	            <!-- <input type="hidden" name="DEVELOPER" value="TRUE"/> -->
	            <input type="hidden" id="FIRST_NAME" name="FIRST_NAME">

	            <label for="LAST_NAME">Name <span class="span--required">(required)</span></label>
	            <input type="text" required id="LAST_NAME" name="LAST_NAME">

	            <label for="EMAIL">Email <span class="span--required">(required)</span></label>
	            <input type="text" required id="EMAIL" name="EMAIL">

	            <label for="PHONE">Phone</label>
	            <input type="tel" id="PHONE" name="PHONE">

	            <label for="CF_Budget">Project Budget <span class="span--required">(required)</span></label>
	            <select id="CF_Budget" required name="CUSTOMFIELD[Budget]">
	              <option value="">Budget Amount</option>
	              <option value="4000">0 - $4,000</option>
	              <option value="8000">$4,000 - $8,000</option>
	              <option value="15000">$8,000 - $15,000</option>
	              <option value="30000">$15,000 - $30,000</option>
	              <option value="60000">$30,000 - $60,000</option>
	              <option value="60001">$60,000+</option>
	            </select>

	            <label for="NOTE">Tell us about your project:</label>
	            <textarea id="NOTE" name="NOTE"></textarea>

	            <input class="single-spaced" type="submit" value="Submit"/>

	          </form>

						<script>
						function split_names () {

							var
								wholeName = document.getElementById('LAST_NAME').value,
								nameArray = wholeName.split(' ');

							document.getElementById('FIRST_NAME').value = nameArray[0];

							//remove first name from array
							nameArray.splice(0, 1);
							//join back into string
							nameArray = nameArray.join(' ');

							//dump the rest into LAST_NAME
							document.getElementById('LAST_NAME').value = nameArray;

						}
						</script>

	        </section><!-- .container -->
	      </div><!-- .container––columns -->
	    </div>

	    <div class="wrap wrap--dkgreen wrap--content">
	      <div class="container container--work">
	        <div id="work">

	          <h2>Our Work</h2>

	          <div class="column--half column--half--spaced first">
	            <h3><a href="http://superiorcampers.com">Superior Campers</a></h3>
	            <p><a href="http://superiorcampers.com"><img src="<?php echo get_template_directory_uri(); ?>/dist/img/work-supcamp.jpg" alt="screenshot of Superior Campers Web Site"></a></p>
	            <p>Superior Campers is a camper and trailer dealership in Superior, WI who deal in new and used units. We had originally designed their last site in 2008, but they were starting to outgrow their current site, and wanted more things like active inventory and an updated design. For the feature they were looking for, we thought WordPress would be a great fit because of the plethora of plugins and it would also make subsequent design updates easier down the road.</p>
	          </div>
	          <div class="column--half column--half--spaced last">
	            <h3><a href="http://standarddistributing.com">Standard Distributing</a></h3>
	            <p><a href="http://standarddistributing.com"><img src="<?php echo get_template_directory_uri(); ?>/dist/img/work-standard.jpg" alt="screenshot of Standard Distributing Web Site"></a></p>
	            <p>Standard Distributing is a convenience store distributer in Oklahoma. They had been on their old website for a while, but never had a chance to refresh it.</p>

	            <p>Previously, they were using a Front Page-like process, so they had full control of the design. The challenge was to make the site as editable as possible without giving the ability to compromise the overall design aesthetic. We utilized custom menus, widgets and the Theme Customizer as must as possible when integrating the design into WordPress.</p>
	          </div>

	        </div>
	      </div>
	    </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
