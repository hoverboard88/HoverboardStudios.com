<?php

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */

function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_hbf_';

	$svg_path = plugin_dir_path( __FILE__ ) . 'open-iconic/svg';
	$icon_array = Array();

	//Create icon array
	foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($svg_path)) as $filename) {
    preg_match('/.*\/svg\/(.*)\.svg/', $filename, $filename_match, PREG_OFFSET_CAPTURE);

		$icon_name_value = $filename_match[1][0];

		if ($icon_name_value) {
			$icon_array[$icon_name_value] = $icon_name_value;
		}

	}

	//see example-init.php for full list of possible "type"

	$meta_boxes['test_metabox'] = array(
		'id'         => 'icon_metabox',
		'title'      => __( 'Icon Settings', 'cmb' ),
		'pages'      => array( 'post', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
		    'name'    => 'Icon Color',
		    'id'      => $prefix . 'icon_color',
		    'type'    => 'radio',
		    'options' => Array(
					'#222' => 'black',
					'#67c8ca' => 'greens--light',
					'#329a9a' => 'greens--medium',
					'#093334' => 'greens--dark',
					'#ad1414' => 'secondary--red',
					'#580d0a' => 'secondary--red-dark',
					'#8757b5' => 'secondary--purple-light',
					'#483360' => 'secondary--purple-dark',
					'#24408f' => 'secondary--blue',
					'#27365b' => 'secondary--blue-dark',
					'#668c62' => 'secondary--green',
					'#6fc067' => 'secondary--green-lt',
				),
			),
			array(
		    'name'    => 'Icon',
		    'id'      => $prefix . 'icon',
		    'type'    => 'radio',
		    'options' => $icon_array
			),
		),
	);

	$meta_boxes['link_post_metabox'] = array(
		'id'         => 'link_post_metabox',
		'title'      => __( 'Link Post', 'cmb' ),
		'desc' => __( 'Tumblr-like Link Posts', 'cmb' ),
		'pages'      => array( 'post', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
		    'name'    => 'URL',
				'desc' => __( 'link url', 'cmb' ),
		    'id'      => $prefix . 'link_post_url',
		    'type'    => 'text_url'
			),
			array(
		    'name'    => 'Site Name',
				'desc' => __( 'Used in "Read full post on…"', 'cmb' ),
		    'id'      => $prefix . 'link_post_site',
		    'type'    => 'text'
			),
		),
	);

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'metaboxes/init.php';

}

function hb_func_post_meta ($id, $post_id = 0, $echo = false) {

	if ($post_id == 0) {
		$post_id = get_the_id();
	}

	$meta = get_post_meta( $post_id, '_hbf_' . $id, true );

	if ($echo) {
		echo $meta;
	} else {
		return $meta;
	}
}
//
// function hbi_taxonomy($id, $post_id = 0, $echo = true) {
//
// 	if ($post_id == 0) {
// 		$post_id = get_the_id();
// 	}
//
// 	$array = wp_get_post_terms($post_id, $id);
//
// 	if ( gettype($array) == 'array' ) {
// 		$term = $array[0]->name;
// 	}
//
// 	if ($echo) {
// 		echo $term;
// 	} else {
// 		return $term;
// 	}
// }
// function hbi_window_sticker ($id, $echo=true) {
//
// 	$array = hbi_post_meta('sticker_sheet', $id, false);
//
// 	reset($array);
// 	$first_key = key($array);
//
// 	if ($echo) {
// 		echo $array[$first_key];
// 	} else {
// 		return $array[$first_key];
// 	}
//
// }
