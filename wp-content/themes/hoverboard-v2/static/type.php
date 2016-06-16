<!doctype html>
<html lang="en" class="no-js">
<head>
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
      <div class="container container--medium container--page-title">
        <h1 class="page-title">About Us</h1>
      </div>
    </div>
    <div class="wrap">
      <div class="content container container--small">

        <h1>Heading 1</h1>

        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse imperdiet, dolor sed commodo finibus, libero ante malesuada ligula, sit amet imperdiet ex nulla ac ex. Suspendisse potenti. Fusce a risus sit amet lacus dictum maximus ultrices eu augue. Donec volutpat convallis nulla, non pellentesque metus euismod et. Aenean faucibus dui sit amet est imperdiet, vitae pulvinar velit pretium.</p>

        <h2>Heading 2</h1>

        <p>Cras ut nulla malesuada, convallis urna in, facilisis ante. Cras nec venenatis ligula. Quisque mollis ac felis in cursus. Nunc ac convallis est. Donec interdum vehicula velit, cursus pellentesque mauris posuere et. Curabitur pulvinar dui et eleifend viverra. Aliquam viverra accumsan nibh, vel mollis magna suscipit ac. Mauris et elit vestibulum, rhoncus augue et, ultricies enim.</p>

        <h3>Heading 3</h1>

        <p>Curabitur pulvinar dui et eleifend viverra. Aliquam viverra accumsan nibh, vel mollis magna suscipit ac. Mauris et elit vestibulum, rhoncus augue et, ultricies enim.</p>

        <ul>
          <li>list Item 1</li>
          <li>list Item 2</li>
          <li>list Item 3</li>
          <li>list Item 4</li>
          <li>list Item 5</li>
          <li>list Item 6</li>
        </ul>

        <h4>Heading 4</h1>

        <p>Curabitur pulvinar dui et eleifend viverra. Aliquam viverra accumsan nibh, vel mollis magna suscipit ac. Mauris et elit vestibulum, rhoncus augue et, ultricies enim.</p>

        <ol>
          <li>list Item 1</li>
          <li>list Item 2</li>
          <li>list Item 3</li>
          <li>list Item 4</li>
          <li>list Item 5</li>
          <li>list Item 6</li>
        </ol>

        <h5>Heading 5</h1>

        <blockquote>
          <p>Cras ut nulla malesuada, convallis urna in, facilisis ante. Cras nec venenatis ligula. Quisque mollis ac felis in cursus. Nunc ac convallis est. Donec interdum vehicula velit, cursus pellentesque mauris posuere et.</p>
          <p>Curabitur pulvinar dui et eleifend viverra. Aliquam viverra accumsan nibh, vel mollis magna suscipit ac. Mauris et elit vestibulum, rhoncus augue et, ultricies enim.</p>
        </blockquote>

        <h6>Heading 6</h1>

        <p><img src="http://placehold.it/800x400/" alt=""></p>

        <div class="well">
          <p>Cras ut nulla malesuada, convallis urna in, facilisis ante. Cras nec venenatis ligula. Quisque mollis ac felis in cursus. Nunc ac convallis est. Donec interdum vehicula velit, cursus pellentesque mauris posuere et.</p>
          <p>Curabitur pulvinar dui et eleifend viverra. Aliquam viverra accumsan nibh, vel mollis magna suscipit ac. Mauris et elit vestibulum, rhoncus augue et, ultricies enim.</p>
        </div>

        <?php include('inc/contact-form.php'); ?>

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
