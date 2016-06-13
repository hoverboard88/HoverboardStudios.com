<!doctype html>
<html lang="en" class="no-js">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hoverboard</title>
  <script>
  (function(d) {
    var config = {
      kitId: 'bev1prj',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
  </script>
  <meta name="description" content="">
  <link rel="stylesheet" href="../dist/css/style.css">
</head>
<body>
  <div class="wrap wrap--green-dark wrap--gradient-dark">
    <form id="form--search" action="#" class="form form--search">

      <button class="form__submit" type="submit">
        <svg style="width:32px;height:32px" viewBox="0 0 24 24">
          <path fill="#013333" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
        </svg>
      </button>
      <input type="search" placeholder="Search Articles, Work, Bios" class="form__input form--search-input">

    </form>

  </div>
  <div class="wrap wrap--green wrap--gradient">
    <header class="container container--top-bottom-padding">
      <div class="wrap">
        <div class="logo">
          <?php echo file_get_contents('../dist/img/logo.svg'); ?>
        </div>
        <nav class="primary primary--horizontal primary--spaced">
          <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/work">Work</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/blog">Blog</a></li>
            <li class="menu-item--search">
              <button id="toggle-search" class="icon--search">
                <svg style="width:22px;height:22px" viewBox="0 0 24 24">
                  <path fill="#ffffff" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                </svg>
              </button>
            </li>
            <li class="menu-item--contact"><a href="/contact" class="btn btn--shadow">Contact</a></li>
          </ul>
        </nav>
      </div>
    </header>
  </div>
  <!-- TODO: possibily switch this out with the <main> tag -->
  <div role="main" class="main main--content">
    <div class="wrap">
      <div class="container container--page-title">
        <h1 class="page-title">About Us</h1>
      </div>
    </div>
    <div class="wrap">
      <section class="about container">
        <div class="about__partner">
          <img src="../dist/img/ryan.jpg" alt="">
          <div class="about__detail">
            <h4 class="about__title">Ryan Tvenge</h4>
            <div class="about__position">Designer/Developer</div>
            <a class="about__link" href="#">@rtvenge</a>
          </div>
        </div>
        <div class="about__partner">
          <img src="../dist/img/matt.jpg" alt="">
          <div class="about__detail">
            <h4 class="about__title">Matt Biersdorf</h4>
            <div class="about__position">Designer/Developer</div>
            <a class="about__link" href="#">@mbiersdo</a>
          </div>
        </div>
      </section>
    </div>
    <div class="wrap">
      <div class="container content">

        <p>Matt and Ryan are the co-founders behind the team at Hoverboard. Having engrossed themselves with all things tech for over 10 years, they each bring an incredible understanding of websites and web applications to your project—the do’s, don’ts, and ingrained know-how.</p>

        <p>But that’s not all there is to building a great site or app.</p>

        <p>There is still that one remaining factor: you, your vision, and your plan.</p>

        <p>At Hoverboard, we introduce our clients to their website or web application as thought leaders and creative directors. And together we craft exactly what your business wants and needs.</p>

        <blockquote>
          <p>We work to listen to you and your business, asking questions, ultimately giving you fast-loading, custom development.</p>
        </blockquote>

        <p>This way your clients and customers aren’t waiting around for your website to load.</p>

        <p>After all, the average human attention span is 8 seconds (the average goldfish—9). If your website hasn’t loaded something great yet, they may push the back button and be gone forever.</p>

        <p>We don’t want that to happen. That’s why we specialize in websites that are quick on its toes and ready when your customers are.</p>

      </div>
    </div>
    <div class="wrap wrap--green-dark">
      <footer class="information">
        <nav class="menu--footer secondary--horizontal secondary--spaced">
          <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/work">Work</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/blog">Blog</a></li>
            <li><a href="/contact">Contact</a></li>
          </ul>
          <ul class="social">
            <li><a href="#">
              <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="#ffffff" d="M22.46,6C21.69,6.35 20.86,6.58 20,6.69C20.88,6.16 21.56,5.32 21.88,4.31C21.05,4.81 20.13,5.16 19.16,5.36C18.37,4.5 17.26,4 16,4C13.65,4 11.73,5.92 11.73,8.29C11.73,8.63 11.77,8.96 11.84,9.27C8.28,9.09 5.11,7.38 3,4.79C2.63,5.42 2.42,6.16 2.42,6.94C2.42,8.43 3.17,9.75 4.33,10.5C3.62,10.5 2.96,10.3 2.38,10C2.38,10 2.38,10 2.38,10.03C2.38,12.11 3.86,13.85 5.82,14.24C5.46,14.34 5.08,14.39 4.69,14.39C4.42,14.39 4.15,14.36 3.89,14.31C4.43,16 6,17.26 7.89,17.29C6.43,18.45 4.58,19.13 2.56,19.13C2.22,19.13 1.88,19.11 1.54,19.07C3.44,20.29 5.7,21 8.12,21C16,21 20.33,14.46 20.33,8.79C20.33,8.6 20.33,8.42 20.32,8.23C21.16,7.63 21.88,6.87 22.46,6Z" />
              </svg>
            </a></li>
            <li><a href="#">
              <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="#ffffff" d="M17,2V2H17V6H15C14.31,6 14,6.81 14,7.5V10H14L17,10V14H14V22H10V14H7V10H10V6A4,4 0 0,1 14,2H17Z" />
              </svg>
            </a></li>
            <li><a href="#">
              <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="#ffffff" d="M21,21H17V14.25C17,13.19 15.81,12.31 14.75,12.31C13.69,12.31 13,13.19 13,14.25V21H9V9H13V11C13.66,9.93 15.36,9.24 16.5,9.24C19,9.24 21,11.28 21,13.75V21M7,21H3V9H7V21M5,3A2,2 0 0,1 7,5A2,2 0 0,1 5,7A2,2 0 0,1 3,5A2,2 0 0,1 5,3Z" />
              </svg>
            </a></li>
            <li><a href="#">
              <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="#ffffff" d="M6.18,15.64A2.18,2.18 0 0,1 8.36,17.82C8.36,19 7.38,20 6.18,20C5,20 4,19 4,17.82A2.18,2.18 0 0,1 6.18,15.64M4,4.44A15.56,15.56 0 0,1 19.56,20H16.73A12.73,12.73 0 0,0 4,7.27V4.44M4,10.1A9.9,9.9 0 0,1 13.9,20H11.07A7.07,7.07 0 0,0 4,12.93V10.1Z" />
              </svg>
            </a></li>
            <li><a href="#">
              <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="#ffffff" d="M12,2A10,10 0 0,0 2,12C2,16.42 4.87,20.17 8.84,21.5C9.34,21.58 9.5,21.27 9.5,21C9.5,20.77 9.5,20.14 9.5,19.31C6.73,19.91 6.14,17.97 6.14,17.97C5.68,16.81 5.03,16.5 5.03,16.5C4.12,15.88 5.1,15.9 5.1,15.9C6.1,15.97 6.63,16.93 6.63,16.93C7.5,18.45 8.97,18 9.54,17.76C9.63,17.11 9.89,16.67 10.17,16.42C7.95,16.17 5.62,15.31 5.62,11.5C5.62,10.39 6,9.5 6.65,8.79C6.55,8.54 6.2,7.5 6.75,6.15C6.75,6.15 7.59,5.88 9.5,7.17C10.29,6.95 11.15,6.84 12,6.84C12.85,6.84 13.71,6.95 14.5,7.17C16.41,5.88 17.25,6.15 17.25,6.15C17.8,7.5 17.45,8.54 17.35,8.79C18,9.5 18.38,10.39 18.38,11.5C18.38,15.32 16.04,16.16 13.81,16.41C14.17,16.72 14.5,17.33 14.5,18.26C14.5,19.6 14.5,20.68 14.5,21C14.5,21.27 14.66,21.59 15.17,21.5C19.14,20.16 22,16.42 22,12A10,10 0 0,0 12,2Z" />
              </svg>
            </a></li>
          </ul>
        </nav>
        <div class="copyright centered">© 2015 Hoverboard. All rights reserved.</div>
      </footer>
    </div>
  </div><!-- .main -->
  <script src="../dist/js/main.min.js"></script>
</body>
</html>
