<?php
/**
 * Hoverboard Studios Shortcodes
 *
 * @package Hoverboard Studios
 */

function hb_profile_pictures( $atts ){
 	return '<div class="profiles">
     <figure class="profile">
       <a href="http://linkedin.com/in/rtvenge"><img class="img--profile" src="' . get_template_directory_uri() . '/dist/img/ryan.jpg" alt="Photo of Ryan Tvenge" /></a>
       <figcaption>
         <a href="http://linkedin.com/in/rtvenge">Ryan Tvenge</a>
       </figcaption>
     </figure>
     <figure class="profile">
     <a href="http://linkedin.com/in/mattbiersdorf"><img class="img--profile" src="' . get_template_directory_uri() . '/dist/img/matt.jpg" alt="Photo of Matt Biersdorf" /></a>
       <figcaption>
       <a href="http://linkedin.com/in/mattbiersdorf">Matt Biersdorf</a>
       </figcaption>
     </figure>
   </div>';
}
add_shortcode( 'hb_profiles', 'hb_profile_pictures' );
