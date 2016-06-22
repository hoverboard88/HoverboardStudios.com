<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hoverboard-v2
 */

?>

<div class="wrap wrap--white wrap--portfolio">
  <section class="portfolio container container--xwide">
    <div class="centered">
      <h2 class="portfolio__header portfolio__header--gray-light">Our Latest Work</h2>
    </div>
    <div class="portfolio__items">
      <?php foreach (hb_v2_get_home_featured_studies() as $key => $featured_study) { ?>
        <div class="portfolio__item">
          <div class="portfolio__summary">
            <?php hb_v2_category_icons($featured_study->ID, 'tech_category'); ?>
            <h3 class="portfolio__title"><?php echo $featured_study->post_title; ?></h3>
            <a target="_blank" href="<?php the_field('study_url', $featured_study->ID) ?>" class="portfolio__website">
              <?php hb_v2_svg('mdi-links.svg'); ?>
              <?php echo hb_v2_prettify_url(get_field('study_url', $featured_study->ID)); ?>
            </a>
            <?php echo wpautop($featured_study->post_excerpt); ?>
            <a href="<?php echo get_permalink($featured_study->ID); ?>" class="btn">Case Study</a>
          </div>
          <div class="portfolio__example">
            <?php echo wp_get_attachment_image(get_field('study_screenshot_mobile', $featured_study->ID)['id'], 'portfolio_mobile'); ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>
</div>

<div class="wrap">
  <section class="mantra container container--xwide">
    <div class="mantra__header--border">
      <h2 class="mantra__header">Our Mantra</h2>
    </div>
    <div class="mantra__items">
      <div class="mantra__item">
        <div class="icon icon--square icon--blue double-spaced">
          <svg style="width:32px;height:32px" viewBox="0 0 24 24">
            <path d="M2.81,14.12L5.64,11.29L8.17,10.79C11.39,6.41 17.55,4.22 19.78,4.22C19.78,6.45 17.59,12.61 13.21,15.83L12.71,18.36L9.88,21.19L9.17,17.66C7.76,17.66 7.76,17.66 7.05,16.95C6.34,16.24 6.34,16.24 6.34,14.83L2.81,14.12M5.64,16.95L7.05,18.36L4.39,21.03H2.97V19.61L5.64,16.95M4.22,15.54L5.46,15.71L3,18.16V16.74L4.22,15.54M8.29,18.54L8.46,19.78L7.26,21H5.84L8.29,18.54M13,9.5A1.5,1.5 0 0,0 11.5,11A1.5,1.5 0 0,0 13,12.5A1.5,1.5 0 0,0 14.5,11A1.5,1.5 0 0,0 13,9.5Z" />
          </svg>
        </div>
        <h3 class="mantra__title">Passion for the Industry</h3>
        <p class="mantra__summary">No matter the size, at Hoverboard, we treat all of our clients the same. We’re an extension of your company; your own private design and development firm.</p>
      </div>
      <div class="mantra__item">
        <div class="icon icon--square icon--purple double-spaced">
          <svg style="width:32px;height:32px" viewBox="0 0 24 24">
            <path d="M16,13C15.71,13 15.38,13 15.03,13.05C16.19,13.89 17,15 17,16.5V19H23V16.5C23,14.17 18.33,13 16,13M8,13C5.67,13 1,14.17 1,16.5V19H15V16.5C15,14.17 10.33,13 8,13M8,11A3,3 0 0,0 11,8A3,3 0 0,0 8,5A3,3 0 0,0 5,8A3,3 0 0,0 8,11M16,11A3,3 0 0,0 19,8A3,3 0 0,0 16,5A3,3 0 0,0 13,8A3,3 0 0,0 16,11Z" />
          </svg>
        </div>
        <h3 class="mantra__title">Teamwork Centric</h3>
        <p class="mantra__summary">Rather than taking an idea and running potentially off course, Hoverboard focuses on your ideas, your consistent input, and your branding to give you exactly what you’ve imagined for your business.</p>
      </div>
      <div class="mantra__item">
        <div class="icon icon--square icon--red double-spaced">
          <svg style="width:32px;height:32px" viewBox="0 0 24 24">
            <path d="M11.71,19C9.93,19 8.5,17.59 8.5,15.86C8.5,14.24 9.53,13.1 11.3,12.74C13.07,12.38 14.9,11.53 15.92,10.16C16.31,11.45 16.5,12.81 16.5,14.2C16.5,16.84 14.36,19 11.71,19M13.5,0.67C13.5,0.67 14.24,3.32 14.24,5.47C14.24,7.53 12.89,9.2 10.83,9.2C8.76,9.2 7.2,7.53 7.2,5.47L7.23,5.1C5.21,7.5 4,10.61 4,14A8,8 0 0,0 12,22A8,8 0 0,0 20,14C20,8.6 17.41,3.8 13.5,0.67Z" />
          </svg>
        </div>
        <h3 class="mantra__title">Performance First</h3>
        <p class="mantra__summary"><strong>The average human attention span is 8 seconds</strong>. If your website hasn’t loaded something great yet, they may push the back button and be gone forever.</p>
      </div>
      <div class="mantra__item">
        <div class="icon icon--square icon--teal double-spaced">
          <svg style="width:32px;height:32px" viewBox="0 0 24 24">
            <path d="M20.71,4.63L19.37,3.29C19,2.9 18.35,2.9 17.96,3.29L9,12.25L11.75,15L20.71,6.04C21.1,5.65 21.1,5 20.71,4.63M7,14A3,3 0 0,0 4,17C4,18.31 2.84,19 2,19C2.92,20.22 4.5,21 6,21A4,4 0 0,0 10,17A3,3 0 0,0 7,14Z" />
          </svg>
        </div>
        <h3 class="mantra__title">Creative Culture</h3>
        <p class="mantra__summary">We love bouncing ideas off each other before helping you make decisions on features or functionality. We realize that the first solution isn’t always the best solution.</p>
      </div>
      <div class="mantra__item">
        <div class="icon icon--square icon--green double-spaced">
          <svg style="width:32px;height:32px" viewBox="0 0 24 24">
            <path d="M11,6H13V13H11V6M9,20A1,1 0 0,1 8,21H5A1,1 0 0,1 4,20V15L6,6H10V13A1,1 0 0,1 9,14V20M10,5H7V3H10V5M15,20V14A1,1 0 0,1 14,13V6H18L20,15V20A1,1 0 0,1 19,21H16A1,1 0 0,1 15,20M14,5V3H17V5H14Z" />
          </svg>
        </div>
        <h3 class="mantra__title">Flexible on Scope</h3>
        <p class="mantra__summary">Our clients range from small, engaged shops to large, invested corporations and our work consists of the smallest edits to large scale applications. We work on whatever with whomever.</p>
      </div>
      <div class="mantra__item">
        <div class="icon icon--square icon--red-light double-spaced">
          <svg style="width:32px;height:32px" viewBox="0 0 24 24">
            <path d="M7.5,4A5.5,5.5 0 0,0 2,9.5C2,10 2.09,10.5 2.22,11H6.3L7.57,7.63C7.87,6.83 9.05,6.75 9.43,7.63L11.5,13L12.09,11.58C12.22,11.25 12.57,11 13,11H21.78C21.91,10.5 22,10 22,9.5A5.5,5.5 0 0,0 16.5,4C14.64,4 13,4.93 12,6.34C11,4.93 9.36,4 7.5,4V4M3,12.5A1,1 0 0,0 2,13.5A1,1 0 0,0 3,14.5H5.44L11,20C12,20.9 12,20.9 13,20L18.56,14.5H21A1,1 0 0,0 22,13.5A1,1 0 0,0 21,12.5H13.4L12.47,14.8C12.07,15.81 10.92,15.67 10.55,14.83L8.5,9.5L7.54,11.83C7.39,12.21 7.05,12.5 6.6,12.5H3Z" />
          </svg>
        </div>
        <h3 class="mantra__title">Lifecycle Support</h3>
        <p class="mantra__summary">No one wants to left in the dust to figure out bugs or a backlog of features after a great application release. We love supporting projects through their entire lifecycle, especially after launch.</p>
      </div>
    </div>
  </section>
</div>

<div class="wrap wrap--green-dark">
  <section class="services container">
    <div class="services__main-column">
      <h3 class="services__header one-half-spaced">Thinking of a website revamp?</h3>
      <p class="services__title single spaced">Looking for feedback on your latest project? Not sure exactly how we could help?</p>
      <p class="h4">Let us know what you’re up to and we’ll let you know how we can help you on your next project.</p>
      <p><a href="#contact" class="btn btn--shadow">Get in Touch</a></p>
    </div>
    <div class="services__side-column">
      <h4 class="services__title--h4">Services</h4>
      <p>Full Stack Design and Development CMS Integration and Support Continued Support &amp; Maintenance Comprehensive Pagespeed Reports</p>
      <h4 class="services__title--h4">Languages</h4>
      <p>HTML, CSS, SASS, Javascript, Ruby, PHP, Python<br>
      and more... Just ask!</p>
    </div>
  </section>
</div>
<div class="wrap wrap--green-dark wrap--pattern">
  <section class="about container">
    <div class="about__partner">
      <div class="about__img">
        <img src="<?php bloginfo('template_directory'); ?>/dist/img/ryan.jpg" alt="">
      </div>
      <div class="about__detail">
        <h4 class="about__title">Ryan Tvenge</h4>
        <div class="about__position">Designer/Developer</div>
        <a target="_blank" class="about__link" href="https://twitter.com/rtvenge">@rtvenge</a>
      </div>
    </div>
    <div class="about__partner">
      <div class="about__img">
        <img src="<?php bloginfo('template_directory'); ?>/dist/img/matt.jpg" alt="">
      </div>
      <div class="about__detail">
        <h4 class="about__title">Matt Biersdorf</h4>
        <div class="about__position">Designer/Developer</div>
        <a target="_blank" class="about__link" href="https://twitter.com/mbiersdo">@mbiersdo</a>
      </div>
    </div>
  </section>
</div>
