<?php
/**
 * Customize RSS feed
 * Remember, you can create a custom-feed.php file if this isn't enough control: http://www.wprecipes.com/creating-user-defined-rss-feeds-in-wordpress
 */

 // image size for rss feed
 add_image_size('rss_feed', 1024, 768, false);

function rss_feed_filter($query) {
	if ($query->is_feed) {
		add_filter('the_content', 'rss_feed_content_filter');
		}
	return $query;
}
add_filter('pre_get_posts','rss_feed_filter');

function rss_feed_content_filter($content) {
	$thumbId = get_post_thumbnail_id();

	if($thumbId) {
		$img = wp_get_attachment_image_src($thumbId, 'rss_feed');
		$image = '<img align="center" src="'. $img[0] .'" alt="" />';
		// $content = $image . $content;
	}

  $content = preg_replace('/<img.*src="(.*)\-[0-9]*x[0-9]*(.[a-zA-Z]{3,4})".*alt="(.*)"[ \/]?[^\>]*>/', '<img src="${1}${2}" alt="${3}" \>', $content);

	// This needs rewording before we push it out.
	// $content .= '<p>Have a web project? <a href="'. get_bloginfo('url') .'/contact/">Contact Us</a> to see if we can help!</p>';

	return $content;
}
