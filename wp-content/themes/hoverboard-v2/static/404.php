<!doctype html>
<html lang="en" class="no-js 404">
<head>
  <?php include('inc/head.php'); ?>
</head>
<body class="error404">

  <?php include('inc/search.php'); ?>

  <header class="wrap wrap--green wrap--small-gradient">
    <div class="container container--top-bottom-padding">
      <?php include('inc/header.php'); ?>
    </div>
  </header>

  <!-- TODO: possibily switch this out with the <main> tag -->
  <div role="main" class="main main--content">
    <div class="wrap wrap--404">
      <div class="content container container--small">

        <div class="well well--shadowed">
          <h1 class="black h2 single-spaced">Great scott!</h1>
          <p>We can’t find what you’re looking for. Try <a href="#">searching</a> or <a href="#">perusing</a> our <a href="#">blog</a>. Otherwise, <a href="#">get in touch</a> or start with one of these case studies.</p>

        </div>

      </div>
    </div>
  </div><!-- .main -->
  <?php include('inc/footer.php'); ?>
  <script src="../dist/js/main.min.js"></script>
</body>
</html>
