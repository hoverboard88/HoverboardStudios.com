<!doctype html>
<html lang="en" class="no-js">
<head>
  <?php $template_name = basename(__FILE__, '.php'); ?>
  <?php include('inc/head.php'); ?>
</head>
<body>

  <?php include('inc/search.php'); ?>

  <header class="wrap wrap--green wrap--small-gradient">
    <div class="container container--top-bottom-padding">
      <?php include('inc/header.php'); ?>
    </div>
  </header>

  <!-- TODO: possibily switch this out with the <main> tag -->
  <div role="main" class="main main--content">
    <div class="wrap">
      <div class="container centered container-page-title container--medium container-page-title">
        <h1 class="page-title">About Us</h1>
      </div>
    </div>
    <div class="wrap">
      <section class="about container">
        <div class="about__partner">
          <div class="about__img">
            <img src="../dist/img/ryan.jpg" alt="">
          </div>
          <div class="about__detail">
            <h4 class="about__title">Ryan Tvenge</h4>
            <div class="about__position">Designer/Developer</div>
            <a class="about__link" href="#">@rtvenge</a>
          </div>
        </div>
        <div class="about__partner">
          <div class="about__img">
            <img src="../dist/img/matt.jpg" alt="">
          </div>
          <div class="about__detail">
            <h4 class="about__title">Matt Biersdorf</h4>
            <div class="about__position">Designer/Developer</div>
            <a class="about__link" href="#">@mbiersdo</a>
          </div>
        </div>
      </section>
    </div>
    <div class="wrap">
      <div class="content container container--small">

        <p>Matt and Ryan are the co-founders behind the team at Hoverboard. Having engrossed themselves with all things tech for over 10 years, they each bring an incredible understanding of websites and web applications to your project—the do’s, don’ts, and ingrained know-how.</p>

        <p>But that’s not all there is to building a great site or app.</p>

        <p>There is still that one remaining factor: you, your vision, and your plan.</p>

        <p>At Hoverboard, we introduce our clients to their website or web application as thought leaders and creative directors. And together we craft exactly what your business wants and needs.</p>

        <blockquote>
          <p>We work to listen to you and your business, asking questions, ultimately giving you fast-loading, custom development.</p>
          <p>We work to listen to you and your business, asking questions, ultimately giving you fast-loading, custom development.</p>
        </blockquote>

        <p>This way your clients and customers aren’t waiting around for your website to load.</p>

        <p>After all, the average human attention span is 8 seconds (the average goldfish—9). If your website hasn’t loaded something great yet, they may push the back button and be gone forever.</p>

        <p>We don’t want that to happen. That’s why we specialize in websites that are quick on its toes and ready when your customers are.</p>

      </div>
    </div>
    <div class="wrap">
      <div class="container container--medium container--padded">
        <div class="well well--no-padding centered">
          <div class="flex-row">
            <div class="flex-column flex-column-half">
              <h3 class="h6">Services</h3>
              <p>Full Stack Design and Development CMS Integration and Support Continued Support &amp; Maintenance Comprehensive Pagespeed Reports</p>
            </div>
            <div class="flex-column flex-column-half">
              <h3 class="h6">Languages</h3>
              <p>HTML, CSS, SASS, Javascript, Ruby, PHP, Python</p>
              <p><strong>and more… Just ask!</strong></p>
            </div>
          </div>
          <div class="flex-row">
            <div class="flex-column">
              <h3 class="black h2 base-font single-spaced">Thinking of a website revamp?</h3>
              <p class="italicized-callout">
                Looking for feedback on your latest project?<br>
                Not sure exactly how we could help?
              </p>
              <p><a href="#" class="btn single-spaced">Get in Touch</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- .main -->
  <?php include('inc/footer.php'); ?>
  <script src="../dist/js/main.min.js"></script>
</body>
</html>
