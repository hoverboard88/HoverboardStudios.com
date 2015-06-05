<?php
/**
 * Hoverboard Studios Shortcodes
 *
 * @package Hoverboard Studios
 */

 remove_filter( 'the_content', 'wpautop' );
 add_filter( 'the_content', 'wpautop' , 12);

function hb_shortcode_profile_pictures( $atts ){
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
add_shortcode( 'hb_profiles', 'hb_shortcode_profile_pictures' );

// Halves

function hb_shortcode_columns_1( $atts, $content = NULL ){
  //this is a shortterm fix. If you have actual p tags in this shortcode, I think they'll be stripped.
  $content = wpautop(trim($content));
  return '<div class="column--half column--half--spaced first">' .  do_shortcode($content) . '</div>';
}
add_shortcode( 'hb_column_half_1', 'hb_shortcode_columns_1' );

function hb_shortcode_columns_2( $atts, $content = NULL ){
  $content = wpautop(trim($content));
  return '<div class="column--half column--half--spaced last">' .  do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'hb_column_half_2', 'hb_shortcode_columns_2' );

// Thirds

function hb_shortcode_columns_3_1( $atts, $content = NULL ){
  //this is a shortterm fix. If you have actual p tags in this shortcode, I think they'll be stripped.
  $content = wpautop(trim($content));
  return '<div class="column--third column--third--spaced first">' .  do_shortcode($content) . '</div>';
}
add_shortcode( 'hb_column_third_1', 'hb_shortcode_columns_3_1' );

function hb_shortcode_columns_3_2( $atts, $content = NULL ){
  $content = wpautop(trim($content));
  return '<div class="column--third column--third--spaced">' .  do_shortcode($content) . '</div>';
}
add_shortcode( 'hb_column_third_2', 'hb_shortcode_columns_3_2' );

function hb_shortcode_columns_3_3( $atts, $content = NULL ){
  $content = wpautop(trim($content));
  return '<div class="column--third column--third--spaced last">' .  do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'hb_column_third_3', 'hb_shortcode_columns_3_3' );
