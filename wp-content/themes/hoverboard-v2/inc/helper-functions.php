<?php
function hb_v2_category_color($queried_object) {
	$term_id = $queried_object->term_id;
	return get_field('category-icon-color', get_category($term_id));
}

function hb_v2_category_icon($queried_object) {
	$term_id = $queried_object->term_id;
	return hb_v2_svg('mdi-' . get_category($term_id)->slug . '.svg', 'mdi-default.svg');
}

function hb_v2_get_featured_study() {

	$args = array(
		'posts_per_page'   => 1,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'meta_key'         => 'study_index_featured',
		'meta_value'       => '1',
		'post_type'        => 'studies',
		'post_status'      => 'publish'
	);

	$posts_array = get_posts( $args );

	return $posts_array[0];

}

function hb_v2_get_home_featured_studies() {

	$args = array(
		'posts_per_page'   => 2,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'meta_key'         => 'study_home_featured',
		'meta_value'       => '1',
		'post_type'        => 'studies',
		'post_status'      => 'publish'
	);

	$posts_array = get_posts( $args );

	return $posts_array;

}

function hb_v2_svg($file, $default = '') {
	if ( file_exists(get_template_directory() . '/dist/img/' . $file) ) {
		echo file_get_contents(get_template_directory() . '/dist/img/' . $file);
	} else {
		echo file_get_contents(get_template_directory() . '/dist/img/' . $default);
	}
}

function hb_v2_prettify_url($url, $post_id = null) {
	// if display_url isn't empty, return that
	if (!empty(get_field('display_url', $post_id))) {
		return get_field('display_url', $post_id);
	} else {
		return preg_replace("/https?:\/\/([^\/]*)\/?/u", "$1", $url);
	}
}

function hb_v2_portfolio_screenshot($imageArray, $size) {
  echo '<img src="' . $imageArray['sizes'][$size] . '" alt="' . $imageArray['alt'] . '">';
}
