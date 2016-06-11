<!doctype html>
<html lang="en">
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
    <form action="#" class="form form--search">
      <div class="grid-columns">
        <div class="grid-column-16">
          <input type="text" placeholder="Search Articles, Work, Bios" class="form__input form--search-input">
        </div>
        <div class="grid-column-4">
          <button class="form__submit" type="submit">
            <svg style="width:32px;height:32px" viewBox="0 0 24 24">
              <path fill="#013333" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
            </svg>
          </button>
        </div>
      </div>
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
              <button class="icon--search">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                  <path fill="#ffffff" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                </svg>
              </button>
            </li>
            <li class="menu-item--contact"><a href="/contact" class="btn btn--shadow">Contact</a></li>
          </ul>
        </nav>
      </div>
      <div class="feature-block centered">
        <p class="tagline"><strong>Everyone wants to be heard–your audience included.</strong></p>
        <p class="mission">We believe in your collaboration throughout every part of your project. <br>From design ideas and inspiration to branding and implementation, Hoverboard is determined to bring your audience the very best experience to the web.</p>
        <p class="tagline tagline-small"><strong>We are your right-hand design and development studio.</strong></p>
        <p>
          <a href="/about" class="btn btn--spaced btn-tertiary">About Us</a>
          <a href="/contact" class="btn btn--spaced btn-secondary">Get a Quote</a>
        </p>
      </div>
    </header>
  </div>
  <!-- TODO: possibily switch this out with the <main> tag -->
  <div role="main" class="main">
    <div class="wrap wrap--white wrap--portfolio">
      <section class="portfolio container container--xwide">
        <div class="centered">
          <h2 class="portfolio__header portfolio__header--gray-light">Our Latest Work</h2>
        </div>
        <div class="portfolio__items">
          <div class="portfolio__item">
            <div class="portfolio__summary">
              <ul class="list--unstyled list--horizontal list--icons">
                <li class="icon icon--circle icon--blue"><a href="#"><svg style="width:32px;height:32px" viewBox="0 0 24 24">
                  <path d="M12.2,15.5L9.65,21.72C10.4,21.9 11.19,22 12,22C12.84,22 13.66,21.9 14.44,21.7M20.61,7.06C20.8,7.96 20.76,9.05 20.39,10.25C19.42,13.37 17,19 16.1,21.13C19.58,19.58 22,16.12 22,12.1C22,10.26 21.5,8.53 20.61,7.06M4.31,8.64C4.31,8.64 3.82,8 3.31,8H2.78C2.28,9.13 2,10.62 2,12C2,16.09 4.5,19.61 8.12,21.11M3.13,7.14C4.8,4.03 8.14,2 12,2C14.5,2 16.78,3.06 18.53,4.56C18.03,4.46 17.5,4.57 16.93,4.89C15.64,5.63 15.22,7.71 16.89,8.76C17.94,9.41 18.31,11.04 18.27,12.04C18.24,13.03 15.85,17.61 15.85,17.61L13.5,9.63C13.5,9.63 13.44,9.07 13.44,8.91C13.44,8.71 13.5,8.46 13.63,8.31C13.72,8.22 13.85,8 14,8H15.11V7.14H9.11V8H9.3C9.5,8 9.69,8.29 9.87,8.47C10.09,8.7 10.37,9.55 10.7,10.43L11.57,13.3L9.69,17.63L7.63,8.97C7.63,8.97 7.69,8.37 7.82,8.27C7.9,8.2 8,8 8.17,8H8.22V7.14H3.13Z" />
                </svg></a></li>
                <li class="icon icon--circle icon--purple"><a href="#"><svg style="width:32px;height:32px" viewBox="0 0 24 24">
                  <path d="M14.6,16.6L19.2,12L14.6,7.4L16,6L22,12L16,18L14.6,16.6M9.4,16.6L4.8,12L9.4,7.4L8,6L2,12L8,18L9.4,16.6Z" />
                </svg></a></li>
              </ul>
              <h3 class="portfolio__title">Superior Campers</h3>
              <a href="#" class="portfolio__website">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                  <path d="M10.59,13.41C11,13.8 11,14.44 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C7.22,12.88 7.22,9.71 9.17,7.76V7.76L12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.59,9.17C9.41,10.34 9.41,12.24 10.59,13.41M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.78,11.12 16.78,14.29 14.83,16.24V16.24L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L13.41,14.83C14.59,13.66 14.59,11.76 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z" />
                </svg>
                superiorcampers.com
              </a>
              <p class="portfolio__intro">Superior Campers out of Superior, WI came to us looking for a website revamp. After we had originally created their website in 2008, they had outgrown what they had and was looking to add an active inventory feature on an updated site.</p>
              <a href="#" class="btn">Case Study</a>
            </div>
            <div class="portfolio__example">
              <img src="../dist/img/portfolio_supcamp.png" alt="">
            </div>
          </div>
          <div class="portfolio__item">
            <div class="portfolio__summary">
              <ul class="list--unstyled list--horizontal list--icons">
                <li class="icon icon--circle icon--blue"><a href="#"><svg style="width:32px;height:32px" viewBox="0 0 24 24">
                  <path d="M12.2,15.5L9.65,21.72C10.4,21.9 11.19,22 12,22C12.84,22 13.66,21.9 14.44,21.7M20.61,7.06C20.8,7.96 20.76,9.05 20.39,10.25C19.42,13.37 17,19 16.1,21.13C19.58,19.58 22,16.12 22,12.1C22,10.26 21.5,8.53 20.61,7.06M4.31,8.64C4.31,8.64 3.82,8 3.31,8H2.78C2.28,9.13 2,10.62 2,12C2,16.09 4.5,19.61 8.12,21.11M3.13,7.14C4.8,4.03 8.14,2 12,2C14.5,2 16.78,3.06 18.53,4.56C18.03,4.46 17.5,4.57 16.93,4.89C15.64,5.63 15.22,7.71 16.89,8.76C17.94,9.41 18.31,11.04 18.27,12.04C18.24,13.03 15.85,17.61 15.85,17.61L13.5,9.63C13.5,9.63 13.44,9.07 13.44,8.91C13.44,8.71 13.5,8.46 13.63,8.31C13.72,8.22 13.85,8 14,8H15.11V7.14H9.11V8H9.3C9.5,8 9.69,8.29 9.87,8.47C10.09,8.7 10.37,9.55 10.7,10.43L11.57,13.3L9.69,17.63L7.63,8.97C7.63,8.97 7.69,8.37 7.82,8.27C7.9,8.2 8,8 8.17,8H8.22V7.14H3.13Z" />
                </svg></a></li>
                <li class="icon icon--circle icon--purple"><a href="#"><svg style="width:32px;height:32px" viewBox="0 0 24 24">
                  <path d="M14.6,16.6L19.2,12L14.6,7.4L16,6L22,12L16,18L14.6,16.6M9.4,16.6L4.8,12L9.4,7.4L8,6L2,12L8,18L9.4,16.6Z" />
                </svg></a></li>
              </ul>
              <h3 class="portfolio__title">Standard Distributing</h3>
              <a href="#" class="portfolio__website">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                  <path d="M10.59,13.41C11,13.8 11,14.44 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C7.22,12.88 7.22,9.71 9.17,7.76V7.76L12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.59,9.17C9.41,10.34 9.41,12.24 10.59,13.41M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.78,11.12 16.78,14.29 14.83,16.24V16.24L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L13.41,14.83C14.59,13.66 14.59,11.76 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z" />
                </svg>
                standarddistributing.com
              </a>
              <p class="portfolio__intro">Standard Distributing, a convenience store distributer in Oklahoma, needed an overhaul to their website. Their design was dated but worse yet, they couldn’t update it without potentially compromising the design and development of the site.</p>
              <a href="#" class="btn">Case Study</a>
            </div>
            <div class="portfolio__example">
              <img src="../dist/img/portfolio_standarddist.png" alt="">
            </div>
          </div>
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
          <p><a href="#" class="btn btn--shadow">Get in Touch</a></p>
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
</body>
</html>
