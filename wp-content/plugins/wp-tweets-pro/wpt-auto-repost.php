<?php
/**
 * Set up a schedule and automatically Tweet an old post. 
 */
 
register_deactivation_hook( __FILE__, 'wpt_deactivate_cron' );
function wpt_deactivate_cron() {
	wp_clear_scheduled_hook( 'wptcron' );
}

add_action( 'wptcron', 'wpt_auto_schedule' );
function wpt_auto_schedule() {
	$notify_user = get_option( 'wpt_autopost_notification' );
	// select post from criteria: 
	$template = ( get_option( 'wpt_schedule_template' ) != '' ) ? get_option( 'wpt_schedule_template' ) : '#title# #url#';
	$post = wpt_select_post();
	// $post = $post_ID 
	if ( !$post ) {
		if ( $notify_user && is_email( $notify_user ) ) {
			wp_mail( $notify_user, __( 'Failed to select any post for Tweeting', 'wp-tweets-pro' ), __( 'WP Tweets PRO did not find a valid post to repost. This may mean that there are no posts between the selected minimum and maximum ages.', 'wp-tweets-pro' ) );
		}
		die;
	}
	$post_info = jd_post_info( $post );
	$sentence = jd_truncate_tweet( $template, $post_info, $post );
	
	$media = ( ( get_option( 'wpt_media' ) == 1 ) && ( has_post_thumbnail( $post ) || wpt_post_attachment( $post ) ) ) ? true : false;
	$media = apply_filters( 'wpt_upload_media', $media, $post ); // filter based on post ID
	
	$tweet = jd_doTwitterAPIPost( $sentence, false, $post, $media );
	// if Tweeted successfully, add to post meta so this will not be Tweeted again until all old posts have been Tweeted.
	if ( $tweet ) {
		if ( $notify_user && is_email( $notify_user ) ) {
			wp_mail( $notify_user, __( 'Autoposted Tweet succeeded', 'wp-tweets-pro' ), sprintf( __( "Tweet autoposted: %s", 'wp-tweets-pro' ), $sentence ) );
		}		
		update_post_meta( $post, '_wpt_autoposted', '1' );
	} else {
		if ( $notify_user && is_email( $notify_user ) ) {
			$log   = wpt_log( 'wpt_status_message', $post );
			wp_mail( $notify_user, __( 'Autoposted Tweet failed', 'wp-tweets-pro' ), sprintf( __( "Site failed to automatically post. Tweet attempted: %s", 'wp-tweets-pro' ) . "\n\n" . __( 'Error message from Twitter:', 'wp-tweets-pro' ) .' '. $log, $sentence  ) );
		}
	}
}

function wpt_select_post( $return = 'post' ) {
	global $wpdb;
	$value = false;
	$minimum_age = get_option( 'wpt_minimum_age' );
	$maximum_age = get_option( 'wpt_maximum_age' );
	if ( !$minimum_age ) { $minimum_age = 0; }
	if ( !$maximum_age ) { $maximum_age = 60*60*24*365*5; }
	if ( $maximum_age < $minimum_age ) { $maximum_age = 60*60*24*365*5; }
	$post_types = get_option( 'wpt_autoretweet_post_types' );
	
	$after = apply_filters( 'wpt_custom_cron_maximum', current_time( 'timestamp' ) - $maximum_age );
	$before = apply_filters( 'wpt_custom_cron_minimum', current_time( 'timestamp' ) - $minimum_age );
	
	$after = array( 'year'=>date( 'Y', $after ), 'month'=> date( 'n', $after ), 'day'=> date( 'j', $after ) );
	$before = array( 'year'=>date( 'Y', $before ), 'month'=> date( 'n', $before ), 'day'=> date( 'j', $before ) );
	
	$args = array( 
			'post_type' => $post_types,
			'date_query' => array(
				'after' => $after,
				'before' => $before,
				'inclusive' => true
			),
			'fields' => 'ids',			
			'post_status' => 'publish'
		);			
	
	$posts = new WP_query( $args );
	
	$posted_args = array(
				'post_type' => $post_types,
				'post_status' => 'publish',
				'meta_query' => array(
					array( 
						'key' => '_wpt_autoposted',
						'value' => '1',
						'compare' => '='
					),
					array( 
						'key' => '_wpt_noautopost',
						'value' => '1',
						'compare' => '='
					),
					'relation' => 'OR'
				),
				'fields' => 'ids'
			);

	$posted = new WP_query( $posted_args );	
	
	$posts = $posts->posts;
	$posted = $posted->posts;
	
	// get all posts from result that aren't already posted
	$diff = array_diff( $posts, $posted );
	if ( empty( $diff ) && !empty( $posted ) ) {
		// If the diff leaves no remaining posts, then all eligible posts have already been Tweeted.
		$query = "DELETE from ".$wpdb->prefix."postmeta WHERE meta_key = '_wpt_autoposted'";
		$wpdb->query( $query );
	} else {
		$posts = $diff;
	}
	if ( !empty( $posts ) ) {
		// array_values ensures that the keys are in numeric order after the diff
		$posts = array_values( $posts );
		$max = count( $posts );
		$rand = mt_rand( 0, $max-1 );
		$post = $posts[$rand];
		$value = $post;
	}
	if ( $return == 'post' ) {
		return $value;	
	} else {
		return array( 'post'=>$value, 'posts'=>$posts, 'posted'=>$posted );
	}
}

function wpt_setup_schedules( $schedule ) {
	update_option( 'wpt_schedule', $schedule );
	$timestamp = current_time( 'timestamp' ) + 600; // first auto schedule in 10 minutes
	wp_schedule_event( $timestamp, $schedule, 'wptcron' );
}

add_filter( 'cron_schedules', 'wpt_custom_schedules' );
function wpt_custom_schedules( $schedules ) {
 	$schedules['four-hours'] = array(
 		'interval' => 14400,
 		'display' => __( 'Every 4 hours', 'wp-tweets-pro' )
 	);
 	$schedules['eight-hours'] = array(
 		'interval' => 28800,
 		'display' => __( 'Every 8 hours', 'wp-tweets-pro' )
 	);	
	$schedules['sixteen-hours'] = array(
 		'interval' => 57600,
 		'display' => __( 'Every 16 hours', 'wp-tweets-pro' )
 	);	
 	$schedules['fortyeight-hours'] = array(
 		'interval' => 172800,
 		'display' => __( 'Every other day', 'wp-tweets-pro' )
 	);	
	 $schedules['ninetysix-hours'] = array(
 		'interval' => 345600,
 		'display' => __( 'Every four days', 'wp-tweets-pro' )
 	);	
 	$schedules['weekly'] = array(
 		'interval' => 604800,
 		'display' => __( 'Once Weekly', 'wp-tweets-pro' )
 	);
 	$schedules['monthly'] = array(
 		'interval' => 2635200,
 		'display' => __( 'Once Monthly', 'wp-tweets-pro' )
 	);	
 	return $schedules;	
}

/* This exists for testing. You can use this if you want to examine what is currently in the Tweetable arrays */
add_shortcode( 'wpt_test_autoschedule_arrays', 'wpt_test_shortcode' );
function wpt_test_shortcode() {
	$object = wpt_select_post( 'test' );
	
	$post = $object['post'];
	$posted = $object['posted'];
	$posts = $object['posts'];
	
	return print_r( $post, 1 ) . "<br /><br />" . print_r( $posted, 1 ) . "<br /><br />" . print_r( $posts, 1 );
}