<!doctype html>
<html lang="en" class="no-js">
<head>
  <?php $template_name = basename(__FILE__, '.php'); ?>
  <?php include('inc/head.php'); ?>
</head>
<body class="page-template-page-case-study-php">

  <?php include('inc/search.php'); ?>

  <header class="wrap wrap--green wrap--small-gradient">
    <div class="container container--top-bottom-padding">
      <?php include('inc/header.php'); ?>
    </div>
  </header>

  <!-- TODO: possibily switch this out with the <main> tag -->
  <div role="main" class="main main--content">
    <div class="wrap">
      <div class="container container--case-study-title">
        <div class="container-page-title">
          <?php include('inc/icon-circles.php'); ?>
          <h1 class="page-title">Standard Distributing</h1>
          <a href="http://standarddistributing.com" class="link--icon">
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
              <path fill="#000000" d="M10.59,13.41C11,13.8 11,14.44 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C7.22,12.88 7.22,9.71 9.17,7.76V7.76L12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.59,9.17C9.41,10.34 9.41,12.24 10.59,13.41M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.78,11.12 16.78,14.29 14.83,16.24V16.24L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L13.41,14.83C14.59,13.66 14.59,11.76 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z" />
            </svg>
            standarddistributing.com
          </a>
        </div>
      </div>
    </div>

    <div class="wrap">

      <div class="container static">

        <div class="portfolio__example">
          <img src="../dist/img/portfolio_standarddist_desk.png" alt="">
        </div>

        <div class="content content--case-study">

          <p>Previously, they were using a Front Page-like process, so they had full control of the design. It had served them very well over the years, but they had realized the business outgrew the site’s functionality.</p>

          <h2>Goals</h2>
          <!-- Will use shortcode columns to make "side by side" -->
          <h3 class="heading--underlined">Standard Distributing’s Goals</h3>

          <ol>
            <li>Create a seamless user experience for current customers to log into the ordering system.</li>
            <li>Ability to add promotions to website.</li>
            <li>Update site design to reflect new branding.</li>
          </ol>

          <h3 class="heading--underlined">Hoverboard’s Goals</h3>

          <ol>
            <li>Give Standard a CMS to update the website while keeping in place the overall design aesthetic.</li>
            <li>New design to be responsive to prolong the investment of the new site.</li>
            <li>Keep front-end code as lightweight as possible.</li>
            <li>Streamline current email campaign process</li>
          </ol>

          <h2>Design</h2>

          <p>The overall look and feel was based off the supplied branding, using the same color palette and ribbon treatment for headings on the site.</p>

          <p>There wasn’t an equivalent typeface to the branding type so we used “Oswald”, a similar web font in the Google Fonts Library.</p>

          <div class="case-study-sidebar">
            <figure id="attachment_134" style="width: 600px" class="wp-caption alignright">
              <img src="http://placehold.it/600x200/" alt="">
              <figcaption class="wp-caption-text">This is the caption</figcaption>
            </figure>
          </div>

          <p><strong>After the discovery process, we concluded there were two different user stories:</strong></p>

          <ul class="list--emphasis">
            <li>As a potential customer, I am gathering information about Standard Distributing. I would either fill out the contact form or call the phone number to get in touch.</li>
            <li>As a current customer, I am looking at current promotions or logging into the backend system to place an order.</li>
          </ul>

          <p>Because of these user stories, we made the “Customer Login”, “Contact” buttons and the (clickable) phone numbe	r prominent in the header.</p>

          <h2>Front-End Code</h2>

          <div class="case-study-sidebar">
            <figure id="attachment_134" style="width: 300px" class="wp-caption alignright">
              <img class="size-medium wp-image-134" src="../dist/img/SDBanner.png" alt="Banner of website" width="300" height="123">
              <figcaption class="wp-caption-text">This is the caption</figcaption>
            </figure>
          </div>

          <p>The website is built responsively with a mobile-first approach. Per our goals from above, we kept the front-end as lightweight as possible, using SVG’s and CSS whenever possible.</p>

          <p>Inuit.css was used as a lightweight css framework using BEM naming conventions to keep everything as modular as possible.</p>

          <p>The underline animation on the header navigation ended up being very successful in the community.</p>

          <blockquote>
            <p>Everyone wants to be heard—your audience included.</p>

            <p>The trouble is how to go about it.</p>
          </blockquote>

        </div>
      </div>
    </div>
    <div class="wrap">
      <div class="container container--medium container--padded">
        <div class="well">
          <h3>Conclusion</h3>
          <p>With this redesign, the new site reflects their updated branding and gave them a responsive website that works on virtually any device. We were able to give them the ability to easily add new content and streamline their newsletter process. With Standard being happy with the results, the project was a success.</p>
        </div>
      </div>
    </div>
  </div><!-- .main -->
  <?php include('inc/footer.php'); ?>
  <script src="../dist/js/main.min.js"></script>
</body>
</html>
