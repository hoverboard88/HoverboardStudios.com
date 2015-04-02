<?php
/*
Plugin Name: iframe
Plugin URI: http://wordpress.org/plugins/iframe/
Description: [iframe src="http://www.youtube.com/embed/4qsGTXLnmKs" width="100%" height="500"] shortcode
Version: 3.0
Author: webvitaly
Author URI: http://web-profile.com.ua/wordpress/plugins/
License: GPLv3
*/


function iframe_unqprfx_embed_shortcode( $atts, $content = null ) {
	$defaults = array(
		'src' => 'http://www.youtube.com/embed/4qsGTXLnmKs',
		'width' => '100%',
		'height' => '500',
		'scrolling' => 'yes',
		'class' => 'iframe-class',
		'frameborder' => '0'
	);

	foreach ( $defaults as $default => $value ) { // add defaults
		if ( ! @array_key_exists( $default, $atts ) ) { // mute warning with "@" when no params at all
			$atts[$default] = $value;
		}
	}

	// get_params_from_url
	if ( isset( $atts["get_params_from_url"] ) && ( $atts["get_params_from_url"] == '1' || $atts["get_params_from_url"] == 1 ) ) {
		$encode_string = '';
		if ( $_GET != NULL ) {
			if ( strpos( $atts["src"], '?' ) ) { // if we already have '?' and GET params
				$encode_string = '&';
			} else {
				$encode_string = '?';
			}
			foreach( $_GET as $key => $value ) {
				$encode_string .= $key.'='.$value.'&';
			}
		}
		$encode_string = rtrim($encode_string, '&'); // remove last '&'
		$atts["src"] .= $encode_string;
	}

	$html = "\n".'<!-- iframe plugin v.3.0 wordpress.org/plugins/iframe/ -->'."\n";
	$html .= '<iframe';
	foreach( $atts as $attr => $value ) {
		if ( $attr != 'same_height_as' ) { // remove some attributes
			if ( $value != '' ) { // adding all attributes
				$html .= ' ' . $attr . '="' . $value . '"';
			} else { // adding empty attributes
				$html .= ' ' . $attr;
			}
		}
	}
	$html .= '></iframe>'."\n";

	if ( isset( $atts["same_height_as"] ) ) {
		$html .= '
			<script>
			document.addEventListener("DOMContentLoaded", function(){
				var target_element, iframe_element;
				iframe_element = document.querySelector("iframe.' . $atts["class"] . '");
				target_element = document.querySelector("' . $atts["same_height_as"] . '");
				iframe_element.style.height = target_element.offsetHeight + "px";
			});
			</script>
		';
	}

	return $html;
}
add_shortcode( 'iframe', 'iframe_unqprfx_embed_shortcode' );


function iframe_unqprfx_plugin_meta( $links, $file ) { // add 'Plugin page' and 'Donate' links to plugin meta row
	if ( strpos( $file, 'iframe.php' ) !== false ) {
		$links = array_merge( $links, array( '<a href="http://web-profile.com.ua/wordpress/plugins/iframe/" title="Plugin page">Iframe</a>' ) );
		$links = array_merge( $links, array( '<a href="http://web-profile.com.ua/donate/" title="Support the development">Donate</a>' ) );
		$links = array_merge( $links, array( '<a href="http://codecanyon.net/item/advanced-iframe-pro/5344999?ref=webvitaly">Advanced iFrame Pro</a>' ) );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'iframe_unqprfx_plugin_meta', 10, 2 );
