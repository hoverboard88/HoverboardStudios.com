<?php
/**
 * Hoverboard Shortcodes
 *
 * @package Hoverboard
 */

 remove_filter( 'the_content', 'wpautop' );
 add_filter( 'the_content', 'wpautop' , 12);

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
