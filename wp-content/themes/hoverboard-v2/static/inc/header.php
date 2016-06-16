<div class="header-wrap">
  <a href="#" class="logo">
    <?php echo file_get_contents('../dist/img/logo.svg'); ?>
  </a>
  <nav class="menu--primary primary--spaced">
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
      <li class="menu-item--contact"><a id="contact-popup-btn" href="#contact" class="btn btn--shadow">Contact</a></li>
    </ul>
  </nav>
</div>
