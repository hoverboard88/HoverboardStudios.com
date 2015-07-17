<?php
/*
Plugin Name: WP Tweets PRO
Plugin URI: https://www.joedolson.com/wp-tweets-pro/
Description: Adds great new features to extend WP to Twitter. 
Version: 1.8.3
Author: Joseph Dolson
Author URI: https://www.joedolson.com/
*/
/*  Copyright 2012-2015  Joseph C Dolson  (email : plugins@joedolson.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
	
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wptp_version;
$wptp_version = '1.8.3';
load_plugin_textdomain( 'wp-tweets-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' ); 
// response to settings updates

include( plugin_dir_path( __FILE__ ) . 'wpt-auto-repost.php' );

function wpt_update_pro_settings() {
	$message = '';
	if ( !empty($_POST['wp_pro_settings']) ) {
		switch ( $_POST['wp_pro_settings'] ) {
			case 'set':
				$wpt_delay_tweets = $_POST['wpt_delay_tweets'];
				$wpt_retweet_after = $_POST['wpt_retweet_after'];
				if ( trim($wpt_delay_tweets) === '' ) { $wpt_delay_tweets = 0; }
				if ( trim($wpt_retweet_after) === '' ) { $wpt_retweet_after = 0; }
				
				update_option('wpt_delay_tweets', $wpt_delay_tweets );
				update_option('wpt_retweet_after', $wpt_retweet_after );

				if ( $wpt_delay_tweets > 0 ) { update_option( 'jd_twit_remote', 0 ); } // remote posting is unnecessary with PRO activated.
				
				$wpt_retweet_repeat = $_POST['wpt_retweet_repeat'];
				update_option('wpt_retweet_repeat', $wpt_retweet_repeat );
			
				$wpt_license_key = $_POST['wpt_license_key'];
				update_option('wpt_license_key', $wpt_license_key );
				
				if ( $wpt_license_key != '' ) {
					$confirmation = wpt_check_license( $wpt_license_key );
				} else {
					$confirmation = 'deleted';
				}
				$previously = get_option('wpt_license_valid');
				update_option('wpt_license_valid', $confirmation );
				
				$wpt_custom_type = ( isset( $_POST['wpt_custom_type'] ) )?$_POST['wpt_custom_type']:'prefix';
				$wpt_prepend_rt3 = ( isset( $_POST['wpt_prepend_rt3'] ) )?$_POST['wpt_prepend_rt3']:'';				
				$wpt_prepend_rt2 = ( isset( $_POST['wpt_prepend_rt2'] ) )?$_POST['wpt_prepend_rt2']:'';
				$wpt_prepend_rt = ( isset( $_POST['wpt_prepend_rt'] ) )?$_POST['wpt_prepend_rt']:'';
				update_option('wpt_custom_type',$wpt_custom_type );
				update_option('wpt_prepend_rt', $wpt_prepend_rt );
				update_option('wpt_prepend_rt2', $wpt_prepend_rt2 );
				update_option('wpt_prepend_rt3', $wpt_prepend_rt3 );
				
				$wpt_rt_media = ( isset( $_POST['wpt_rt_media'] ) ) ? 'true' : '';
				$wpt_rt_media2 = ( isset( $_POST['wpt_rt_media2'] ) ) ? 'true' : '';
				$wpt_rt_media3 = ( isset( $_POST['wpt_rt_media3'] ) ) ? 'true' : '';
				update_option('wpt_rt_media', $wpt_rt_media );
				update_option('wpt_rt_media2', $wpt_rt_media2 );
				update_option('wpt_rt_media3', $wpt_rt_media3 );
				
				$wpt_twitter_card = ( isset( $_POST['wpt_twitter_card'] ) )?1:0;
				update_option('wpt_twitter_card', $wpt_twitter_card );

				$wpt_toggle_card = ( isset( $_POST['wpt_toggle_card'] ) )?(int) $_POST['wpt_toggle_card']:0;
				update_option('wpt_toggle_card', $wpt_toggle_card );	
	
				$prepend = __('Warning: your Tweet re-posts are not differentiated. This may cause Twitter to block your re-posted Tweets.','wp-tweets-pro');
				$prepend_warning = '';
				if ( $wpt_retweet_repeat == 1 && $wpt_prepend_rt == '' ) {
					$prepend_warning = "$prepend";
				}
				if ( $wpt_retweet_repeat == 2 && $wpt_prepend_rt2 == '' ) {
					$prepend_warning = "$prepend";
				}
				if ( $wpt_retweet_repeat == 3 && $wpt_prepend_rt3 == '' ) {
					$prepend_warning = "$prepend";				
				}
				
				$wpt_prepend = ( isset($_POST['wpt_prepend']) && $_POST['wpt_prepend'] == 'on' )?1:0;
				update_option('wpt_prepend', $wpt_prepend );
				
				$wpt_filter_title = ( isset($_POST['wpt_filter_title']) && $_POST['wpt_filter_title'] == 'on' )?1:0;
				$wpt_filter_post = ( isset($_POST['wpt_filter_post']) && $_POST['wpt_filter_post'] == 'on' )?1:0;
				update_option('wpt_filter_title', $wpt_filter_title );
				update_option('wpt_filter_post', $wpt_filter_post );
				
				$wpt_blackout_from = ( isset($_POST['wpt_blackout_from']) ) ? (int) $_POST['wpt_blackout_from'] : 0 ;
				$wpt_blackout_to = ( isset($_POST['wpt_blackout_to']) ) ? (int) $_POST['wpt_blackout_to'] : 0 ;
				update_option( 'wpt_blackout', array( 'from'=>$wpt_blackout_from, 'to'=>$wpt_blackout_to ) );
				
				$wpt_media = ( isset($_POST['wpt_media']) && $_POST['wpt_media'] == 'on' )?1:0;
				update_option( 'wpt_media', $wpt_media );
				
				$wpt_cotweet = ( isset($_POST['wpt_cotweet']) && $_POST['wpt_cotweet'] == 'on' )?1:0;
				update_option('wpt_cotweet', $wpt_cotweet );

				$wpt_cotweet_lock = ( isset($_POST['wpt_cotweet_lock']) && $_POST['wpt_cotweet_lock'] != 'false' )?(int) $_POST['wpt_cotweet_lock']:'false';
				update_option('wpt_cotweet_lock', $wpt_cotweet_lock );
				
				if ( isset( $_POST['wpt_unschedule'] ) ) {
					wp_clear_scheduled_hook( 'wptcron' );
					delete_option( 'wpt_schedule' );
					echo "<div class='updated'><p>" . __( 'Automated Schedule Cleared', 'wp-tweets-pro' ) . "</p></div>";
				}
				
				$schedule = ( isset( $_POST['wpt_schedule'] ) && $_POST['wpt_schedule'] != '' ) ? sanitize_text_field( $_POST['wpt_schedule'] ) : false;
				$is_scheduled = ( isset( $_POST['wpt_is_scheduled'] ) ) ? true : false;
				if ( $schedule && !$is_scheduled ) {
					wpt_setup_schedules( $schedule );
				}
				
				$schedule_template = ( isset( $_POST['wpt_schedule_template'] ) ) ? $_POST['wpt_schedule_template'] : false;
				if ( $schedule_template ) {
					update_option( 'wpt_schedule_template', $schedule_template );
				}
				
				$wpt_autopost_notification = ( isset( $_POST['wpt_autopost_notification'] ) ) ? $_POST['wpt_autopost_notification'] : false;
				if ( $wpt_autopost_notification && is_email( $wpt_autopost_notification ) ) {
					update_option( 'wpt_autopost_notification', $wpt_autopost_notification );
				}
				
				$minimum_age = ( isset( $_POST['wpt_minimum_age'] ) ) ? (int) $_POST['wpt_minimum_age'] : 15552000; // 180 days (~6 months)
				$maximum_age = ( isset( $_POST['wpt_maximum_age'] ) ) ? (int) $_POST['wpt_maximum_age'] : 155520000; // 1800 days (~5 years)
				update_option( 'wpt_minimum_age', $minimum_age );
				update_option( 'wpt_maximum_age', $maximum_age );
				
				$wpt_autoretweet_post_types = ( isset( $_POST['wpt_autoretweet_post_types'] ) ) ? $_POST['wpt_autoretweet_post_types'] : array();
				update_option( 'wpt_autoretweet_post_types', $wpt_autoretweet_post_types );
				
				// comment settings
				update_option( 'comment-published-text', ( isset( $_POST['comment-published-text'] ) ) ? $_POST['comment-published-text'] : '' );
				update_option( 'comment-published-update',( isset( $_POST['comment-published-update']) ) ? $_POST['comment-published-update'] : '' );
				update_option( 'wpt_comment_delay', ( isset( $_POST['wpt_comment_delay'] ) ) ? $_POST['wpt_comment_delay'] : '' );

				if ( $confirmation == 'false' ) {
					$message = __('WP Tweets PRO key not valid.','wp-tweets-pro');
				} else if ( $confirmation == 'inuse' ) {
					$message = sprintf( __('WP Tweets PRO license key already registered. <a href="%s">Upgrade to a Developer\'s license!</a>','wp-tweets-pro'), 'https://www.joedolson.com/account/' );				
				} else if ( $confirmation == 'unconfirmed' ) {
					$message = __('Your payment for WP Tweets PRO has not been confirmed.','wp-tweets-pro');				
				} else if ( $confirmation == 'true' ) {
					if ( $previously == 'true' ) { 
					} else {
						$message = __('WP Tweets PRO key validated. Enjoy!','wp-tweets-pro');
					}
				} else if ( $confirmation == 'deleted' ) {
					$message = __('You have deleted your WP Tweets PRO license key.','wp-tweets-pro');
				} else {
					$message = __('WP Tweets PRO received an unexpected message from the license server. Try again in a bit.','wp-tweets-pro');
				}
				$message = ( $message != '' )?"$message ":$message; // just add a space
				$message .= "<strong>".__('WP Tweets PRO Settings Updated','wp-tweets-pro')."</strong>";
				$notice = "<div id='message' class='updated notice'><p>$message</p></div>";
				if ( $prepend_warning != '' ) { $notice .= "<div id='message' class='error notice'><p>".$prepend_warning . "</p></div>"; }
				echo $notice;
			break;
		}
	}
}
add_filter( 'wpt_status','wpt_filter_tweet', 10, 3 );
function wpt_filter_tweet( $string, $id, $context ) {
	if ( ( get_option( 'wpt_filter_title' ) == 1 && $context == 'title' ) || ( get_option( 'wpt_filter_post' ) == 1 && $context = 'post' ) ) {
		$term_meta = false;
		$tags = get_the_tags( $id );
		if ( $tags > 0 ) {
			foreach ( $tags as $value ) {
				if ( get_option('wpt_tag_source') == 'slug' ) {
					$tag = $value->slug;
				} else {
					$tag = $value->name;
				}
				$replace = get_option( 'jd_replace_character' );
				$strip = get_option( 'jd_strip_nonan' );
				$search = "/[^a-zA-Z0-9]/";
				if ($replace == "[ ]" || $replace == "" ) { $replace = ""; }
				$newtag = str_ireplace( " ",$replace,trim( $tag ) );
				$t_id = $value->term_id; 
				$term_meta = get_option( "wpt_taxonomy_$t_id" );
				switch ( $term_meta ) {
					case 1 : $newtag = "#$tag"; break;
					case 2 : $newtag = "$$tag"; break;
					case 3 : $newtag = ''; break;
					default: $newtag = apply_filters( 'wpt_tag_default', "#", $t_id ).$tag;
				}
				if ( $strip == '1' ) { $newtag = preg_replace( $search, $replace, $newtag ); }
				if ( mb_strlen( $newtag ) > 2 ) {
					// replaces whole words only
					$tag = preg_replace( '/[\/]/','', $tag ); // need to remove slashes
					$string = preg_replace( '/\b'.$tag.'\b/i',$newtag,$string);
				}
			}
		}
	}
	return $string;
}

add_filter( 'wpt_schedule_retweet', 'wpt_blackout_period', 10, 4 );
function wpt_blackout_period( $time, $acct, $i, $post_info ) {
	$orig_time = $time;
	$blackout = get_option( 'wpt_blackout' );
	$from = $blackout['from'];
	$to = $blackout['to'];
	if ( $from == $to ) { return $time; }
	$hour = date( 'G', current_time( 'timestamp' )+$time );
	if ( $from < $to ) {
		$jump = ( ( 24 - $from ) + $to ) - 24;
		$blackout = ( $hour > $from && $hour < $to ) ? true : false ;				
	} else {
		$jump = ( ( 24 - $from ) + $to );
		$blackout = ( $hour > $from || $hour < $to ) ? true : false ;		
	}
	if ( $blackout ) {
		$time = $time + ( $jump*60*60 );
	}
	return $time;
}

add_filter( 'wpt_insert_post','wpt_insert_post_values', 10, 2 );
function wpt_insert_post_values( $post, $id ) {
	$update = false;
	if ( isset( $post[ '_wpt_delay_tweet' ] ) && $post['_wpt_delay_tweet'] != '' ) {
		$wpt_delay_tweet = (int) $post[ '_wpt_delay_tweet' ];
		$update = update_post_meta( $id, '_wpt_delay_tweet', $wpt_delay_tweet );
	}
	if ( isset( $post[ '_wpt_noautopost' ] ) && $post['_wpt_noautopost'] == 1 ) {
		$update = update_post_meta( $id, '_wpt_noautopost', 1 );
	} else if ( isset( $post['_wpt_noautopost'] ) && $post['_wpt_noautopost'] != 1  || !isset( $post['_wpt_noautopost'] ) ) {
		delete_post_meta( $id, '_wpt_noautopost' );
	}
	if ( isset( $post[ '_wpt_retweet_repeat' ] ) && $post['_wpt_retweet_repeat'] != '' ) {
		$wpt_retweet_repeat = (int) $post[ '_wpt_retweet_repeat' ];
		$update = update_post_meta( $id, '_wpt_retweet_repeat', $wpt_retweet_repeat );
	}
	if ( isset( $post[ '_wpt_retweet_after' ] ) && $post['_wpt_retweet_after'] != '' ) {
		$wpt_retweet_after = (float) $post[ '_wpt_retweet_after' ];
		$update = update_post_meta( $id, '_wpt_retweet_after', $wpt_retweet_after );
	}
	if ( isset( $post[ '_wpt_twitter_card' ] ) && $post['_wpt_twitter_card'] != '' ) {
		$wpt_twitter_card = 'photo';
		$update = update_post_meta( $id, '_wpt_twitter_card', $wpt_twitter_card );
	}
	if ( isset( $post[ '_wpt_cotweet' ] ) && $post['_wpt_cotweet'] == 'on' ) {
		$update = update_post_meta( $id, '_wpt_cotweet', 1 );
	} else {
		delete_post_meta( $id, '_wpt_cotweet' );
	}
	if ( isset( $post[ '_wpt_image' ] ) && $post['_wpt_image'] == 1 ) {
		$update = update_post_meta( $id, '_wpt_image', 1 );
	} else {
		delete_post_meta( $id, '_wpt_image' );
	}	
	if ( isset( $post[ '_wpt_authorized_users' ] ) ) {
		$update = update_post_meta( $id, '_wpt_authorized_users', $post['_wpt_authorized_users'] );
	} else {
		delete_post_meta( $id, '_wpt_authorized_users' );
	}
	if ( isset( $post[ '_wpt_retweet_text' ] ) ) {
		$update = update_post_meta( $id, '_wpt_retweet_text', $post['_wpt_retweet_text'] );
	} else {
		delete_post_meta( $id, '_wpt_retweet_text' );
	}
	return $update;
}

function wpt_setup_filters() {
	$filters = get_option('wpt_filters');
	$available = array( 'postTitle'=>'Post Title', 'postContent'=>'Post Content', 'postLink'=>'Permalink','shortUrl'=>'Shortened URL','postStatus'=>'Post Status','postType'=>'Post Type','id'=>'Post ID','authId'=>'Author ID','postExcerpt'=>'Post Excerpt');
	$return = "<table class='widefat fixed'><thead><tr><th scope='col'>Filter field</th><th scope='col'>Filter type</th><th scope='col'>Filtered value</th><th scope='col'>Delete Filter</th></tr></thead><tbody>";
	if ( is_array( $filters ) ) {
		foreach ( $filters as $key=>$value ) {
			$return .= "
			<tr><td><label for='wpt_filter_field_$key'>Filtered field</label> 
			<select name='wpt_filters[$key][field]' id='wpt_filter_field_$key'>";
			foreach ( $available as $k=>$v ) {
				if ( $k == $value['field'] ) { $selected = ' selected="selected"'; } else { $selected = ''; }
				$return .= "<option value='$k'$selected>$v</option>";
			}
			$return .= "</select></td>
			<td><label for='wpt_filter_type_$key'>Filter type</label> 
			<select name='wpt_filters[$key][type]' id='wpt_filter_type_$key'>
				<option value='equals'".(($value['type'] == 'equals')?' selected="selected"':'').">is equal to</option>
				<option value='notin'".(($value['type'] == 'notin')?' selected="selected"':'').">does not contain</option>
				<option value='in'".(($value['type'] == 'in')?' selected="selected"':'').">contains</option>
				<option value='notequals'".(($value['type'] == 'notequals')?' selected="selected"':'').">is not equal to</option>
			</select></td>
			<td><label for='wpt_filter_value_$key'>Filter value</label> <input type='text' id='wpt_filter_value_$key' name='wpt_filters[$key][value]' value='$value[value]' /></td>			
			<td><label for='wpt_filter_delete_$key'>Delete filter</label> <input type='checkbox' id='wpt_filter_delete_$key' name='wpt_filters[$key][delete]' value='on' /></td>
			</tr>";
		}
	} else {
		$key = 0;
	}
	$key = $key+1;
	$return .= "
	<tr>
	<td><label for='wpt_filter_field_$key'>Filtered field</label>
	<select name='wpt_filters[$key][field]' id='wpt_filter_field_$key'>
		<option value='0'> -- </option>";
	foreach ( $available as $k=>$v ) {
		$return .= "<option value='$k'>$v</option>";
	}
	$return .= "</select></td>
	<td><label for='wpt_filter_type_$key'>Filter type</label> 
	<select name='wpt_filters[$key][type]' id='wpt_filter_type_$key'>
		<option value='0'> -- </option>
		<option value='equals'>is equal to</option>
		<option value='notin'>does not contain</option>
		<option value='in'>contains</option>
		<option value='notequals'>is not equal to</option>
	</select></td>
	<td><label for='wpt_filter_value_$key'>Filter value</label> <input type='text' id='wpt_filter_value_$key' name='wpt_filters[$key][value]' value='' /></td>
	</tr></tbody></table>";
	return $return;
}

function wpt_build_filters() {
	$filters = get_option('wpt_filters');
	if ( isset($_POST['wpt_filters']) ) {
		foreach ( $_POST['wpt_filters'] as $key=>$value ) {
			if ( isset($value['delete']) && $value['delete'] == 'on' ) {
				unset($filters[$key]);
				continue;
			} 
			if ( !in_array( $value['type'], array( 'in','notin','equals','notequals' ) ) )  {
				continue;
			} 
			$filters[$key] = $value;
		}
	}
	update_option( 'wpt_filters', $filters );
}

function wpt_filter_post_info( $post_info ) {
	$filters = get_option( 'wpt_filters' );
	if ( is_array( $filters ) ) {
		foreach ( $filters as $filter=>$rule ) {
			$comparison = $rule['type'];
			switch ( $comparison ) {
				case 'equals':
					if ( $post_info[$rule['field']] == $rule['value'] ) return true;
				break;
				case 'notin':
					if ( strpos( $post_info[$rule['field']], $rule['value'] ) === false ) return true;
				break;
				case 'in':
					if ( strpos( $post_info[$rule['field']], $rule['value'] ) !== false ) return true;				
				break;
				case 'notequals':
					if ( $post_info[$rule['field']] != $rule['value'] ) return true;				
				break;
				default: return true;
			}
		}
		return false;
	}
	return false;
}

function wpt_get_scheduled_tweets() {
	$schedule = wpt_schedule_custom_tweet( $_POST );
	$deletions = ( isset( $_POST['delete-tweets'] ) && isset( $_POST['delete-list'] ) ) ? $_POST['delete-list'] : array();
	$cron = _get_cron_array();
	$schedules = wp_get_schedules();
	$date_format = _x( 'M j, Y @ G:i', 'Publish box date format', 'wp-tweets-pro' );
	$clear_queue = wp_nonce_url( admin_url("admin.php?page=wp-to-twitter-schedule&amp;wpt=clear") );
	if ( isset( $schedule['message'] ) ) { echo $schedule['message']; }

?>
<div class="wrap" id="wp-to-twitter" >
	<h2><?php _e('Scheduled Tweets from WP Tweets PRO', 'wp-tweets-pro'); ?></h2>
	<div id="wp-to-twitter" class="postbox-container jcd-wide">
	<div class="metabox-holder">
	<div class="ui-sortable meta-box-sortables">
	<div class="postbox">
		
		<h3><?php _e('Your Scheduled Tweets','wp-tweets-pro'); ?></h3>
		<div class="inside">
	<p><?php _e('This is a list of tweets which are scheduled to be sent to Twitter for posts which have already been published.','wp-tweets-pro'); ?>
	<form method="post" action="<?php echo admin_url( 'admin.php?page=wp-to-twitter-schedule&action=delete' ); ?>">
	<table class="widefat fixed">
		<thead>
			<tr>
				<th scope="col"><?php _e('Tweet on <em>date</em> at <em>time</em>', 'wp-tweets-pro'); ?></th>
				<th scope="col" style="width:50%;"><?php _e('Tweet', 'wp-tweets-pro'); ?></th>
				<th scope="col"><?php _e('Author','wp-tweets-pro'); ?></th>
				<th scope="col"><?php _e('Options', 'wp-tweets-pro'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php $offset = (60*60*get_option('gmt_offset'));
			foreach ( $cron as $timestamp => $cronhooks ) { 
				foreach ( (array) $cronhooks as $hook => $events ) { 
					$i = 0; foreach ( (array) $events as $event ) { 
						if ( $hook == 'wpt_schedule_tweet_action' ) {
							$i++; 
							if ( count( $event[ 'args' ] ) ) { 
								$auth = $event['args']['id'];
								$sentence = $event['args']['sentence'];	
								$rt = $event['args']['rt'];
								$post_ID = $event['args']['post_id'];
							}
							$id = md5( $timestamp . $auth . $rt . $post_ID . $sentence );
							
							if ( ( isset( $_GET['wpt'] ) && $_GET['wpt'] == 'clear' ) && ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'] ) ) ) {
								wp_unschedule_event( $timestamp, 'wpt_schedule_tweet_action', array( 'id'=>$auth,'sentence'=>$sentence, 'rt'=>$rt,'post_id'=>$post_ID ) );
								echo "<div id='message' class='updated'><p>".sprintf(__('Tweet for %1$s has been deleted.','wp-tweets-pro'),date( $date_format, ($timestamp+$offset) ))."</p></div>";
							} else if ( in_array( $id, $deletions ) ) {
								wp_unschedule_event( $timestamp, 'wpt_schedule_tweet_action', array( 'id'=>$auth,'sentence'=>$sentence,'rt'=>$rt,'post_id'=>$post_ID ) );
								echo "<div id='message' class='updated'><p>".__('Scheduled Tweet has been deleted.','wp-tweets-pro')."</p></div>";							
							} else {
								$time_diff = human_time_diff( $timestamp+$offset, time()+$offset );							
								$image = '';
								if ( get_option( 'wpt_media' ) == 1 ) {
									if ( get_post_meta( $post_ID, '_wpt_image', true ) != 1 ) {
										$tweet_this_image = wpt_filter_scheduled_media( true, $post_ID, $rt );
										if ( $tweet_this_image ) {
											$img = wpt_post_attachment( $post_ID );
											if ( $img ) {
												$img_url = wp_get_attachment_image_src( $img, apply_filters( 'wpt_upload_image_size', 'medium' ) );
												$image = "<a href='$img_url[0]' class='wpt_image'>".__('Includes Image','wp-tweets-pro')."</a>";
											}
										}
									}
								} 
							?>
							<tr>
								<th scope="row"><?php echo date_i18n( $date_format, ($timestamp+$offset) ); ?><br /><small>(~<?php echo $time_diff; ?>)</small></th>
								<td id='sentence-<?php echo $id; ?>'><?php echo "$sentence $image"; ?></td>
								<td><?php if ( !$auth ) { echo '@'.get_option( 'wtt_twitter_username' ); } else { echo '@'.get_user_meta( $auth, 'wtt_twitter_username',true ); } ?></td>
								<td><input type='checkbox' id='checkbox-<?php echo $id; ?>' value='<?php echo $id; ?>' name='delete-list[]' aria-describedby='sentence-<?php echo $id; ?>' /> <label for='checkbox-<?php echo $id; ?>'><?php _e( 'Delete', 'wp-tweets-pro' ); ?></label></td>
							</tr><?php 
							} 
						}
					}
				}
			} ?>
		</tbody>
	</table>
	<p><input type='submit' class='button-primary' name='delete-tweets' value='<?php _e( 'Delete checked Tweets', 'wp-tweets-pro' ); ?>' /></p>
	</form>
	<p><a href="<?php echo $clear_queue; ?>"><?php _e('Clear Tweets Queue','wp-tweets-pro'); ?></a></p>
	</div>
	</div>
	</div>
	<div class="ui-sortable meta-box-sortables">
	<div class="postbox">
		
		<h3><?php _e('Schedule a Tweet','wp-tweets-pro'); ?></h3>
		<div class="inside schedule" id="wp2t">	
		<?php $admin_url = admin_url('admin.php?page=wp-to-twitter-schedule'); ?>
		<p>
		<?php _e('Tweets must be associated with a post ID; running the WP to Twitter filters for template tags and other custom fields is optional.','wp-tweets-pro'); ?>
		</p>
		<form method="post" action="<?php echo $admin_url; ?>">
		<div><input type="hidden" name="submit-type" value="schedule-tweet" /><input type="hidden" name='author' id='author' value='<?php echo get_current_user_id(); ?>' /></div>
		<?php $nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);  echo "<div>$nonce</div>"; ?>	
			<p class='jtw'>
				<label for='jtw'><?php _e('Tweet Text','wp-tweets-pro'); ?></label> <input type="checkbox" value='on' id='filter' name='filter' checked='checked' /> <label for='filter'><?php _e('Run WP to Twitter filters on this Tweet','wp-tweets-pro'); ?></label><br />
				<textarea id='jtw' name='tweet' rows='3' cols='70'><?php echo ( isset($schedule['tweet']) )?stripslashes($schedule['tweet'] ) : ''; ?></textarea>
			</p>
			<div class="datetime">
			<div class='date'>
				<label for='date'><?php _e('Date','wp-tweets-pro'); ?></label><br />
				<input type='text' name='date' id='date' size="20" value='<?php echo date_i18n('Y-m-d',(current_time( 'timestamp' )+300) ); ?>' />
			</div>			
			<div class='time'>
				<label for='time'><?php _e('Time','wp-tweets-pro'); ?></label><br />
				<input type='text' name='time' id='time' size="20" value='<?php echo date_i18n('h:i a',(current_time( 'timestamp' )+300) ); ?>' />
			</div>
			</div>
			<?php $last = wp_get_recent_posts( array( 'numberposts'=>1, 'post_type'=>'post', 'post_status'=>'publish' ) ); $last_id = $last['0']['ID']; ?>
			<p>
				<label for='post'><?php _e('Associate with post ID: (required,default is most recently published)','wp-tweets-pro'); ?></label> <input type="text" name="post" id="post" value="<?php echo ( isset($schedule['post'] ) )?$schedule['post']:$last_id; ?>" />
			</p>
			<p>
			<?php print('
						<label for="alt_author">'.__('Post to this author', 'wp-tweets-pro').'</label>
						<select name="alt_author" id="alt_author">
							<option value="main">'.__('Main site account','wp-tweets-pro').'</option>
							<option value="false">'.__('Current User\'s account','wp-tweets-pro').'</option>');
						$user_query = get_users( array( 'role' => 'subscriber' ) );
						// This gets the array of ids of the subscribers
						$subscribers = wp_list_pluck( $user_query, 'ID' );
						// Now use the exclude parameter to exclude the subscribers
						$users = get_users( array( 'exclude' => $subscribers ) );						
						foreach ( $users as $this_user ) {
							if ( get_user_meta( $this_user->ID, 'wtt_twitter_username',true ) != '' ) {
								print('<option value="'.$this_user->ID.'">'.$this_user->display_name.'</option>');
							}
						}
					print('
						</select>');
			?>
		</p>
		<p><input type="submit" name="submit" value="<?php _e("Schedule a Tweet", 'wp-tweets-pro'); ?>" class="button-primary" /></p>
		</form>	
		<h3><?php _e('Recently published posts/IDs:','wp-tweets-pro'); ?></h3>
		<ul class='columns' id="recent">
		<?php 
			$recent = wp_get_recent_posts( array( 'numberposts'=>15,'post_status'=>'publish' ) ); 
			foreach( $recent as $post ) {
				echo "<li><code>$post[ID]</code> - <strong>$post[post_title]</strong></li>";
			} 
		?>
		</ul>
	</div>
	</div>
	</div>
</div>
</div>
<?php if ( function_exists( 'wpt_sidebar' ) ) { wpt_sidebar(); } else { _e('Please Activate WP to Twitter!','wp-tweets-pro'); } ?>	
</div>
<?php
}

function wpt_schedule_custom_tweet( $post ) {
	$offset = (60*60*get_option('gmt_offset'));
	if ( isset($post['submit-type']) && $post['submit-type'] == 'schedule-tweet' ) { 
		$auth = ( isset($post['author']) && $post['author'] != '' )?(int) $post['author']:false;
		$auth = ( isset($post['alt_author']) && $post['alt_author'] == 'false' )?$auth:(int) $post['alt_author'];
		$auth = ( isset($post['alt_author']) && $post['alt_author'] == 'main' )?false:$auth;
		if ( $auth && get_user_meta( $auth, 'wtt_twitter_username',true ) == '' ) {
			$auth = false;
		}
		$encoding = get_option('blog_charset');
		if ( $encoding == '' ) { $encoding = 'UTF-8'; }
		$sentence = ( isset($post['tweet'] ) ) ? html_entity_decode( stripcslashes($post['tweet']), ENT_COMPAT, $encoding  ) : '';
		$post_id = ( isset($post['post'] ) )?(int) $post['post']:'';
		if ( isset( $post['filter'] ) && $post['filter'] == 'on' ) {
			$post_info = jd_post_info( $post_id );
			$sentence = jd_truncate_tweet( $sentence, $post_info, $post_id, false, false );
		}
		$time = ( isset( $post['time'] ) && isset( $post['date'] ) ) ? ( strtotime( $post['date'] . ' ' . $post['time'] ) ):'' ;
		$time = ( $time > current_time( 'timestamp' ) ) ? $time : false;
		$time = ( $time ) ? $time - $offset : $time; 
		if ( !$sentence || !$post ) {
			return array( 'message'=>"<div class='error'><p>".__('You must include a custom tweet text and a post ID to associate the tweet with.','wp-tweets-pro')."</p></div>", 'tweet'=>$sentence, 'post'=>$post_id ); 
		} else if ( !$time ) {
			return array( 'message'=>"<div class='error'><p>".__('The time provided was either invalid or in the past.','wp-tweets-pro')."</p></div>", 'tweet'=>$sentence, 'post'=>$post_id ); ; 
		} else {
			wp_schedule_single_event(
				$time, 
				'wpt_schedule_tweet_action', 
				array( 'id'=>$auth, 'sentence'=>$sentence, 'rt'=>0, 'post_id'=>$post_id ) 
			);
			return array( 'message'=>"<div class='updated'><p>".__('Your custom Tweet has been scheduled.','wp-tweets-pro')."</p></div>", 'tweet'=>$sentence, 'post'=>$post_id ); ; 					
		}
	}
}

/* Out of use as of 1.7.2
function wpt_tweet_links( $ts, $auth, $rt, $post_ID, $hash ) {
	$auth = ( !$auth )?0:$auth;
	$unschedule = wp_nonce_url( admin_url( "admin.php?page=wp-to-twitter-schedule&amp;wpt=delete&amp;ts=$ts&amp;auth=$auth&amp;rt=$rt&amp;rp=$post_ID&amp;hash=$hash" ), 'wpt_unschedule_tweet' );
	echo "<a href='$unschedule'>Delete</a>";
}
*/

// get list of active post types, generate control to select which post type to view tweets for.
function wpt_get_past_tweets() {
	$settings = get_option('wpt_post_types');
	$per_page = apply_filters( 'wpt_past_tweets_per_page', 50 );
	$post_types = array_keys($settings);
	$root = admin_url( "admin.php?page=wp-to-twitter-tweets" );
	if ( isset( $_GET['wpt_clear_saved'] ) && $_GET['wpt_clear_saved'] == $post_type ) {
		if (!wp_verify_nonce( $_GET['_wpnonce'], 'clear_saved_tweets' ) ) wp_die();
		$clear = get_posts( array( 'post_type'=>$post_type ) );
		foreach ( $clear as $p ) {	
			$id = $p->ID;
			//delete_post_meta( $id, '_wpt_failed' );
			delete_post_meta( $id, '_jd_wp_twitter' );
		}
		echo "<div class='notice'><p>".__('Saved Tweets Deleted','wp-tweets-pro')."</p></div>";
	}	
	$types = "<ul class='post-types'>";
	foreach ( $post_types as $pt ) {
		if ( $settings[$pt]['post-published-update'] == 1 || $settings[$pt]['post-edited-update'] == 1 ) {
			$types .= "<li><a href='$root&ptype=$pt'>$pt</a></li>";
		}
	}
	$types .= "</ul>";
	$post_type = ( isset( $_GET['ptype'] ) ) ? $_GET['ptype'] : 'post';
	$paged = ( isset( $_GET['paged'] ) ) ? (int) $_GET['paged'] - 1 : false;
	$offset = ( $paged ) ? $per_page*$paged : 0;
	$posts = new WP_Query( array( 'posts_per_page'=>$per_page, 'offset'=>$offset, 'post_type'=>$post_type, 'meta_key'=>'_jd_wp_twitter', 'meta_query'=>array( array( 'key'=>'_jd_wp_twitter', 'compare'=>'EXISTS' ) ) ) );
	$output = '';
	while( $posts->have_posts() ) {
		$posts->the_post();
		$post = get_post( get_the_ID() );
		$user = get_userdata( $post->post_author );	
		$key = $post->post_title.'|'.$user->display_name.'|'.date('d M, Y; g:ia',strtotime( $post->post_date ) );
		$value = get_post_meta( get_the_ID(), '_jd_wp_twitter', true );
		$row = explode('|',$key);
		$list = '<ul>';
		if ( is_array( $value ) ) {
			foreach ( $value as $v ) {
				if ( is_array( $v ) ) {
					foreach ( $v as $t ) {
						$t2 = urlencode($t);
						$list .= "<li><a href='http://twitter.com/intent/tweet?text=$t2'>$t</a></li>";
					}
				} else {
					$v2 = urlencode($v);				
					$list .= "<li><a href='http://twitter.com/intent/tweet?text=$v2'>$v</a></li>";
				}
			}
		} else {
			$v2 = urlencode($value);		
			$list .= "<li><a href='http://twitter.com/intent/tweet?text=$v2'>$value</a></li>";
		}
		$list .= "</ul>";
		$output .= "<tr><th scope='row'><a href='#'>$row[0]</a>$list</th><td>$row[1]</td><td>$row[2]</td></tr>";		
	}
	?>
	<div class="wrap" id="wp-to-twitter" >
	<h2><?php _e('Past Tweets saved by WP Tweets PRO', 'wp-tweets-pro'); ?></h2>
	<div class="postbox-container jcd-wide">
	<div class="metabox-holder">
	<div class="ui-sortable meta-box-sortables">
	<div class="postbox">
		
		<h3><?php _e('Posts with Sent Tweets','wp-tweets-pro'); ?></h3>
		<div class="inside">
		<?php
			if ( isset( $_GET['ptype'] ) ) { 
				$url = wp_nonce_url( admin_url( "admin.php?page=wp-to-twitter-tweets&ptype=$post_type&wpt_clear_saved=$post_type" ), 'clear_saved_tweets' ); ?>
				<p>
					<a href="<?php echo $url; ?>">
					<?php _e('Clear saved Tweets for this post type','wp-tweets-pro'); ?>
					</a>
				</p>
			<?php } ?>
	<p><?php _e('This is a list of tweets WP Tweets PRO has sent or attempted to send to Twitter. WP Tweets PRO started tracking this with version 2.2.9; earlier tweets will not be shown.','wp-tweets-pro'); ?>
	<?php echo $types; ?>
	<?php
		$items = $posts->found_posts;		
		$num_pages = ceil($items / $per_page);
		$current = ( isset($_GET['paged']) )? $_GET['paged'] : 1;
		if ( $num_pages > 1 ) {
			$page_links = paginate_links( array(
				'base' => add_query_arg( 'paged', '%#%' ),
				'format' => '',
				'prev_text' => __('&laquo; Previous Page','wp-tweets-pro'),
				'next_text' => __('Next Page &raquo;','wp-tweets-pro'),
				'total' => $num_pages,
				'current' => $current
			));
			printf( "<div class='tablenav'><div class='tablenav-pages'>%s</div></div>", $page_links );
		}
	?>
		<table class="widefat fixed" id="wpt">
		<thead>
			<tr>
				<th scope="col" style="width:60%"><?php _e('Post Title', 'wp-tweets-pro'); ?></th>
				<th scope="col"><?php _e('Author','wp-tweets-pro'); ?></th>
				<th scope="col"><?php _e('Date Posted', 'wp-tweets-pro'); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php
	if ( $output ) { echo $output; }
	?>
	</tbody>
	</table>
	</div>
	</div>
	</div>
	</div>
	</div>
	<?php if ( function_exists( 'wpt_sidebar' ) ) { wpt_sidebar(); } else { _e('Please Activate WP to Twitter!','wp-tweets-pro'); } ?>	

	</div><?php
}

function wpt_get_failed_tweets() {
	$settings = get_option('wpt_post_types');
	$per_page = apply_filters( 'wpt_failed_tweets_per_page', 50 );
	$post_types = array_keys($settings);
	$root = admin_url( "admin.php?page=wp-to-twitter-errors" );
	$types = "<ul class='post-types'>";
	if ( isset( $_GET['wpt_clear_failed'] ) && $_GET['wpt_clear_failed'] == $post_type ) {
		if (!wp_verify_nonce( $_GET['_wpnonce'], 'wpt_clear_failed' ) ) wp_die();
		$clear = get_posts( array( 'post_type'=>$post_type ) );
		foreach ( $clear as $p ) {	
			$id = $p->ID;
			delete_post_meta( $id, '_wpt_failed' );
			//delete_post_meta( $id, '_jd_wp_twitter' );
		}
		echo "<div class='notice'><p>".__('Failed Tweets Deleted','wp-tweets-pro')."</p></div>";
	}	
	foreach ( $post_types as $pt ) {
		if ( $settings[$pt]['post-published-update'] == 1 || $settings[$pt]['post-edited-update'] == 1 ) {
			$types .= "<li><a href='$root&ptype=$pt'>$pt</a></li>";
		}
	}
	$types .= "</ul>";
	$post_type = ( isset( $_GET['ptype'] ) ) ? $_GET['ptype'] : 'post';
	$paged = ( isset( $_GET['paged'] ) ) ? (int) $_GET['paged'] - 1 : false;
	$offset = ( $paged ) ? $per_page*$paged : 0;
	$posts = new WP_Query( array( 'posts_per_page'=>$per_page, 'offset'=>$offset, 'post_type'=>$post_type, 'meta_key'=>'_wpt_failed', 'meta_query'=>array( array( 'key'=>'_wpt_failed', 'compare'=>'EXISTS' ) ) ) );
	$output = '';
	while( $posts->have_posts() ) {
		$posts->the_post();
		$post = get_post( get_the_ID() );
		$user = get_userdata( $post->post_author );	
		$key = $post->post_title.'|'.$user->display_name.'|'.date('d M, Y; g:ia',strtotime($post->post_date) );
		$value = get_post_meta( get_the_ID(), '_wpt_failed', false );
		$row = explode('|',$key);
		$list = '<ul>';
		if ( is_array( $value ) ) {
			foreach ( $value as $v ) {
				if ( is_array( $v ) ) {
						$ts = ( isset( $v['timestamp'] ) )?date('d M, Y; g:ia',$v['timestamp'] ):'not available';
						$t2 = urlencode($v['sentence']);						
						$list .= "
							<li><em>Tweet</em>: <a href='http://twitter.com/intent/tweet?text=$t2'>$v[sentence]</a><br />
							<em>Error reason</em>: $v[error] (<code>http code: $v[code]</code>)<br />
							<em>Sent on</em>: $ts
							</li>";
				} 
			}
		} else {
			$list .= ___('No errors found.','wp-tweets-pro');
		}
		$list .= "</ul>";
		$output .= "<tr><th scope='row'><a href='#'>$post->post_title</a>$list</th><td>$user->display_name</td></tr>";		
	}
	?>
	<div class="wrap" id="wp-to-twitter" >
	<h2><?php _e('Failed Tweets from WP Tweets PRO', 'wp-tweets-pro'); ?></h2>
	<div class="metabox-holder">
	<div class="postbox-container jcd-wide">
	<div class="ui-sortable meta-box-sortables">
	<div class="postbox">
	
	<h3><?php _e('Posts with Failed Tweets','wp-tweets-pro'); ?></h3>
	<div class="inside">
		<?php
			if ( isset( $_GET['ptype'] ) ) { 
				$url = wp_nonce_url( admin_url( "admin.php?page=wp-to-twitter-tweets&ptype=$post_type&wpt_clear_failed=$post_type" ), 'wpt_clear_failed' ); ?>
				<p>
					<a href="<?php echo $url; ?>"><?php _e('Clear failed Tweets for this post type','wp-tweets-pro'); ?></a>
				</p>
			<?php } ?>	
	<p><?php printf( __('This is a list of tweets WP Tweets PRO failed to send to Twitter with the reported reason for the failure. Data gathered starting with WP to Twitter version 2.4.7. Each page shows the failed tweets in that set of %d posts.','wp-tweets-pro'), $per_page ); ?>
	<?php echo $types; ?>
	<?php
		//$items = wp_count_posts( $post_type )->publish;
		$items = $posts->found_posts;
		$num_pages = ceil($items / $per_page);
		$current = ( isset($_GET['paged']) ) ? $_GET['paged'] : 1;
		if ( $num_pages > 1 ) {
			$page_links = paginate_links( array(
				'base' => add_query_arg( 'paged', '%#%' ),
				'format' => '',
				'prev_text' => __('&laquo; Previous Page','wp-tweets-pro'),
				'next_text' => __('Next Page &raquo;','wp-tweets-pro'),
				'total' => $num_pages,
				'current' => $current
			));
			printf( "<div class='tablenav'><div class='tablenav-pages'>%s</div></div>", $page_links );
		}
	?>
		<table class="widefat fixed" id="wpt">
		<thead>
			<tr>
				<th scope="col" style="width:60%"><?php _e('Post Title', 'wp-tweets-pro'); ?></th>
				<th scope="col"><?php _e('Author','wp-tweets-pro'); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php
	if ( $output ) { echo $output; }
	?>
	</tbody>
	</table>
	</div>
	</div>
	</div>
	</div>
	</div>
	<?php if ( function_exists( 'wpt_sidebar' ) ) { wpt_sidebar(); } else { _e( 'Please Activate WP to Twitter!','wp-tweets-pro' ); } ?>	
	</div><?php
}

add_filter( 'wpt_post_info', 'wpt_insert_post_info',10,2 );
function wpt_insert_post_info( $values, $post_ID ) {
	if ( is_array( $values ) ) {
		$delay = ( isset( $_POST['_wpt_delay_tweet'] ) && is_numeric( $_POST['_wpt_delay_tweet'] )  )?$_POST['_wpt_delay_tweet']:get_post_meta( $post_ID, '_wpt_delay_tweet',true );
		$after = ( isset( $_POST['_wpt_retweet_after'] ) && is_numeric( $_POST['_wpt_retweet_after'] ) )?$_POST['_wpt_retweet_after']:get_post_meta( $post_ID, '_wpt_retweet_after',true );
		$auth_repeat = ( get_user_meta( $values['authId'], 'wpt_retweet_repeat', true ) != '' ) ? get_user_meta( $values['authId'], 'wpt_retweet_repeat', true ) : false;
		$repeat = ( isset( $_POST['_wpt_retweet_repeat'] ) && is_numeric( $_POST['_wpt_retweet_repeat'] ) )?$_POST['_wpt_retweet_repeat']:get_post_meta( $post_ID, '_wpt_retweet_repeat',true );
		
		$no_delay = ( isset( $_POST['wpt-no-delay'] ) )?'on':false;
		$no_repost = ( isset( $_POST['wpt-no-repost'] ) )?'on':false;
		$image = ( isset( $_POST['_wpt_image'] ) && $_POST[ '_wpt_image'] == 1 ) ? 1 : false;
		$cotweet = ( isset( $_POST['wpt_cotweet'] ) )?1:get_post_meta( $post_ID, '_wpt_cotweet',true );
		$wpt_authorized_users = ( isset( $_POST['_wpt_authorized_users'] ) )?$_POST['_wpt_authorized_users']:array();
		
		$values['wpt_cotweet'] = $cotweet;
		$values['wpt_authorized_users'] = $wpt_authorized_users;
		$values['wpt_no_delay'] = $no_delay;
		$values['wpt_image'] = $image;
		$values['wpt_no_repost'] = $no_repost;
		$values['wpt_delay_tweet'] = ( $delay !== '')?(int) $delay:get_option('wpt_delay_tweets');		
		$values['wpt_retweet_after'] = ( $after !== '')?(float) $after:get_option('wpt_retweet_after');
		$values['wpt_retweet_repeat'] =  ($repeat !== '') ? (int) $repeat : get_option( 'wpt_retweet_repeat' );
	}
	return $values;
}

// 		$auth_repeat = ( get_user_meta( $values['authId'], 'wpt_retweet_repeat', true ) != '' ) ? get_user_meta( $values['authId'], 'wpt_retweet_repeat', true ) : false;

add_filter( 'wpt_allow_reposts', 'wpt_test_user_reposts', 10, 4 );
function wpt_test_user_reposts( $continue, $rt, $post_ID, $auth_ID ) {
	if ( $auth_ID ) {
		$auth_value = get_user_meta( $auth_ID, 'wpt_retweet_repeat', true );
		$auth_repeat = ( $auth_value != '' ) ? $auth_value : false;
		// if author has a defined repost value & this retweet # is higher than their value, cancel it.
		if ( $auth_value && ( $auth_value > $rt ) ) {
			return false;
		}
	}
	return $continue;
}

function wpt_check_license( $key=false ) {
	global $wptp_version;
	if ( !$key ) {
		return false;
	} else {
		define('WPT_PRO_PLUGIN_LICENSE_URL', "https://www.joedolson.com/wp-content/plugins/files/license.php" );
		$response = wp_remote_post( WPT_PRO_PLUGIN_LICENSE_URL, 
			array (
				'user-agent' => 'WordPress/WP Tweets PRO' . $wptp_version . '; ' . get_bloginfo( 'url' ), 
				'body'=>array ('key'=>$key, 'site'=>urlencode(home_url()) ),
				'timeout' 	=> 30
			) );

		if ( ! is_wp_error( $response ) || is_array( $response ) ) {
			$data = $response['body'];
			if ( !in_array( $data, array( 'false', 'inuse', 'true', 'unconfirmed' ) ) ) {
				$data = @gzinflate(substr($response['body'],2));
			}
			return $data;
		}
	}
	return false;
}

if ( get_option( 'jd_individual_twitter_users' ) == '1' ) {
	add_filter('manage_users_columns', 'wpt_add_column');
	function wpt_add_column($columns) {
		$columns['wpt_twitter'] = 'Twitter';
		return $columns;
	}
	add_action('manage_users_custom_column',  'wpt_column_content', 10, 3);
	function wpt_column_content($value, $column_name, $user_id) {
		$user = get_userdata( $user_id );
		if ( 'wpt_twitter' == $column_name ) {
			$twitter = get_user_meta( $user_id, 'wtt_twitter_username', true );
			if ( $twitter && wtt_oauth_test( $user_id,'verify' ) ) { $twitter = '<span class="authorized">@'.$twitter.'</span>'; return $twitter; } 
			if ( $twitter ) { return "@".$twitter; }
			if ( get_user_meta( $user_id, 'wp-to-twitter-user-username', true ) != '' ) { $account = "@".get_user_meta( $user_id, 'wp-to-twitter-user-username', true ); return $account; }
			return __( 'None', 'wp-tweets-pro' );
		}
		return $value;
	}
}

function wpt_write_css() {
}

add_action( 'admin_menu', 'wpt_pro_menu' );
// Function to deal with adding the WP Tweets PRO menus
function wpt_pro_menu() {
  global $wpdb, $wp_plugin_url, $user_ID, $current_user;
  get_currentuserinfo();
  $allowed_group = apply_filters( 'wpt_main_settings', 'manage_options', $user_ID );
  $icon_path = $wp_plugin_url.'/'.basename(dirname(__FILE__)).'/images';

	if ( function_exists('add_menu_page') ) {
		$function = ( function_exists('jd_twit') )?'wpt_update_settings':'wpt_warning';
		$page = add_menu_page(__('WP Tweets PRO','wp-tweets-pro'), __('WP Tweets PRO','wp-tweets-pro'), $allowed_group, 'wp-tweets-pro', $function,$icon_path.'/icon.png' );
		if ( function_exists( 'jd_twit' ) ) { add_action( 'admin_head-'. $page, 'jd_addTwitterAdminStyles' ); }
	}
	if ( function_exists('add_submenu_page') ) {
		$scheduled_permissions = apply_filters( 'wpt_scheduled_tweets_capability', 'manage_options', $user_ID );
		$past_permissions = apply_filters( 'wpt_past_tweets_capability', 'manage_options', $user_ID );
		$error_permissions = apply_filters( 'wpt_error_tweets_capability', 'manage_options', $user_ID );
		
		$schedule = add_submenu_page('wp-tweets-pro', __('Scheduled Tweets','wp-tweets-pro'), __('Scheduled Tweets','wp-tweets-pro'), $scheduled_permissions, 'wp-to-twitter-schedule', 'wpt_get_scheduled_tweets');
		add_submenu_page('wp-tweets-pro', __('Past Tweets','wp-tweets-pro'), __('Past Tweets','wp-tweets-pro'), $past_permissions, 'wp-to-twitter-tweets', 'wpt_get_past_tweets');		
		add_submenu_page('wp-tweets-pro', __('Failed Tweets','wp-tweets-pro'), __('Failed Tweets','wp-tweets-pro'), $error_permissions, 'wp-to-twitter-errors', 'wpt_get_failed_tweets');	
	}
}

function wpt_warning() {
	echo "<div class='notice error'><p>".__('<strong>WP Tweets PRO</strong> requires that WP to Twitter is also activated. Please re-activate WP to Twitter! Thanks for purchasing!','wp-tweets-pro')."</p></div>";
}

add_filter( 'wpt_save_user','wpt_update_user_oauth',10,2 );
function wpt_update_user_oauth( $edit_id, $post ) {
	if ( function_exists( 'wpt_pro_exists' ) ) {
		$message = jd_update_oauth_settings( $edit_id, $post );
		switch( $message ) {
			case 'success':
				$message = __('You have successfully connected your profile to Twitter','wp-tweets-pro');
			break;
			case 'failed':
				$message = __('We could not connect your profile to Twitter. Please check your application keys and settings and try again.','wp-tweets-pro');			
			break;
			case 'nodata':
				$message = __('Your Twitter keys were not received - did you leave the fields blank?','wp-tweets-pro');			
			break;
			case 'nosync':
				$message = __('We could not connect your profile to Twitter due to a time discrepancy between this server and Twitter.','wp-tweets-pro');			
			break;
			case 'cleared':
				$message = __('You have successfully disconnected your profile from Twitter','wp-tweets-pro');			
			break;
			default:
			break;
		}
		update_user_meta( $edit_id, 'wpt-connection-message', $message );
	}
	return $edit_id; 
}

add_filter( 'wpt_save_user', 'wpt_update_twitter_user_fields', 10, 2 );
function wpt_update_twitter_user_fields( $edit_id, $post ) {
	if ( function_exists( 'wpt_pro_exists' ) ) {
		$templates = $post['wpt_templates'];
		update_user_meta( $edit_id, 'wpt_templates', $templates );
		$reposts = $post['wpt_retweet_repeat'];
		update_user_meta( $edit_id, 'wpt_retweet_repeat', $reposts );
	}
	return $edit_id; 
}

add_filter( 'wpt_twitter_user_fields','wpt_twitter_user_fields' );
function wpt_twitter_user_fields( $edit_id ) {
	// show form fields on user profile
	$templates = get_user_meta( $edit_id, 'wpt_templates', true );
	$reposts = get_user_meta( $edit_id, 'wpt_retweet_repeat', true );
	$edit = ( isset( $templates['edit'] ) ) ? $templates['edit'] : '';
	$new = ( isset( $templates['new'] ) ) ? $templates['new'] : '';
	$num_reposts = ( $reposts == '' ) ? get_option( 'wpt_retweet_repeat' ) : $reposts;
	
	return sprintf( "
		<tr><th scope='row'><label for='wpt_new'>".__('Tweet Template for new posts:','wp-tweets-pro').'</label></th><td><input type="text" class="regular-text" name="wpt_templates[new]" id="wpt_new" value="%1$s" /></td></tr>'."
		<tr><th scope='row'><label for='wpt_edit'>".__('Tweet Template for edited posts:','wp-tweets-pro').'</label></th><td><input type="text" class="regular-text" name="wpt_templates[edit]" id="wpt_edit" value="%2$s" /></td></tr>
		<tr><th scope="row"><label for="wpt_retweet_repeat">'.__('Number of reposts','wp-tweets-pro').'</label></th><td><select id="wpt_retweet_repeat" name="wpt_retweet_repeat">
			<option value="">'. _e( 'Default', 'wp-tweets-pro' ) . '</option>
			<option value="0"' . selected( $reposts, 0, false ) . '>0</option>
			<option value="1"' . selected( $reposts, 1, false ) . '>1</option>
			<option value="2"' . selected( $reposts, 2, false ) . '>2</option>
			<option value="3"' . selected( $reposts, 3, false ) . '>3</option>
		</select></td></tr>', $new, $edit, $num_reposts );
}

add_filter('wpt_user_text','wpt_filter_user_text',10,3 );
function wpt_filter_user_text( $text, $status, $alt=false ) {
	global $current_user;
	$auth = $current_user->ID;
	$user_text = get_user_meta( $auth, 'wpt_templates', true );	
	if ( $text != '' && !$alt ) return $text;
	if ( $status != 'publish' ) {
		if ( isset($user_text['new']) && trim($user_text['new']) != '' ) {
			$text = stripcslashes($user_text['new']);
		}
	} else {
		if ( isset($user_text['edit']) && trim($user_text['edit']) != '' ) {
			$text = stripcslashes($user_text['edit']);
		}
	}
	return $text;
}

add_action('wpt_schedule_tweet_action', 'wpt_schedule_tweet', 10, 4);
function wpt_schedule_tweet( $id, $sentence, $rt, $post_ID ) {
	wpt_mail( "Scheduled Action Happening: #$id","$sentence, $rt, $post_ID" ); // DEBUG
	// only upload media the first time...
	$media = ( ( get_option( 'wpt_media' ) == '1' ) && ( has_post_thumbnail( $post_ID ) || wpt_post_attachment( $post_ID ) ) ) ? true : false;
	$media = apply_filters( 'wpt_scheduled_media', $media, $post_ID, $rt ); // filter based on post ID
	$post = jd_doTwitterAPIPost( $sentence, $id, $post_ID, $media );
}

add_filter( 'wpt_scheduled_media', 'wpt_filter_scheduled_media', 10, 3 );
function wpt_filter_scheduled_media( $media, $post_ID, $rt ) {
	switch ( $rt ) {
		case 1:
			$rt1 = get_option( 'wpt_rt_media' );
			$return = ( $rt1 == 'true' ) ? false : $media;
			break;
		case 2:
			$rt2 = get_option( 'wpt_rt_media2' );
			$return = ( $rt2 == 'true' ) ? false : $media;
			break;
		case 3:
			$rt3 = get_option( 'wpt_rt_media3' );
			$return = ( $rt3 == 'true' ) ? false : $media;	
			break;
		default: $return = $media;
	}
	return $return;
}

add_filter( 'wpt_upload_media', 'wpt_filter_upload_media', 10, 2 );
function wpt_filter_upload_media( $media, $post_ID ) {
	$skip = get_post_meta( $post_ID, '_wpt_image', true );
	if ( $skip == 1 ) {
		return false;
	}
	return $media;
}

add_filter( 'wpt_custom_retweet_fields', 'wpt_retweet_custom_tweets', 10, 2 );
function wpt_retweet_custom_tweets( $return, $post_ID=false ) {
	$repeat = ( get_post_meta( $post_ID, '_wpt_retweet_repeat', true ) ) ? get_post_meta( $post_ID, '_wpt_retweet_repeat', true ) : get_option( 'wpt_retweet_repeat' );
	$custom_tweets = ( $post_ID ) ? get_post_meta( $post_ID, '_wpt_retweet_text', true ) : false;	
	if ( $repeat > 0 ) {
		$return = "<p><span class='dashicons dashicons-plus'></span><a href='#wpt_custom_retweets' class='tweet-toggle'>".__('Add custom retweets','wp-tweets-pro' )."</a></p><div class='expandable' id='wpt_custom_retweets'>";
		for ( $i=0; $i<$repeat; $i++ ) {
			$n = $i + 1;
			if ( !empty( $custom_tweets ) ) {
				$tweet = ( isset( $custom_tweets[$i] ) ) ? $custom_tweets[$i] : '';
			} else {
				if ( get_option( 'wpt_custom_type' ) == 'prefix' ) {
					$tweet = ''; 
				} else {
					$x = ( $n == 1 ) ? '' : $n ;
					$tweet = get_option( "wpt_prepend_rt$x" );
				}
			}
			$return .= "<p class='jtw'><label for='wpt_retweet_$i'>".sprintf( __( 'Retweet %d', 'wp-tweets-pro' ), $n )."</label> <textarea class='attachmentlinks' name='_wpt_retweet_text[]' id='wpt_retweet_$i'>".esc_attr( $tweet )."</textarea></p>";
		}
		$return .= "</div>";
	}
	return $return;
}

function wpt_schedule_values( $post_id, $display='normal' ) {
	$delay = get_post_meta( $post_id, '_wpt_delay_tweet', true ); 
	$retweet = get_post_meta( $post_id, '_wpt_retweet_after', true );
	// this looks awkward, but it makes sense, really.
	$cotweet = get_post_meta( $post_id, '_wpt_cotweet', true );
	$cotweet = ( $cotweet ) ? true : get_option( 'wpt_cotweet' );
	$cotweet = ( $cotweet ) ? true : false;
	$repeat = ( get_post_meta( $post_id, '_wpt_retweet_repeat', true ) == false )?get_option('wpt_retweet_repeat'):get_post_meta( $post_id, '_wpt_retweet_repeat', true );
	$upload = ( get_post_meta( $post_id, '_wpt_image', true ) == 1 ) ? true : false;
	$wpt_images = ( get_option( 'wpt_media' ) == 1 ) ? 'yes' : 'no';
	$wpt_authorized_users = get_post_meta( $post_id, '_wpt_authorized_users', true );
	$noautopost = get_post_meta( $post_id, '_wpt_noautopost', true );

	if ( $display == 'hidden' ) {
	?>
	<input type='hidden' name='_wpt_cotweet' value='<?php if ( $cotweet ) { echo 'on'; } ?>' />
	<input type='hidden' name='_wpt_delay_tweet' value='<?php if ( $delay != false ) { echo $delay; } else { echo get_option('wpt_delay_tweets'); } ?>' />
	<input type='hidden' name='_wpt_retweet_after' value='<?php if ( $retweet != false ) { echo $retweet; } else { echo get_option('wpt_retweet_after'); } ?>' />
	<input type='hidden' name='_wpt_retweet_repeat' value='<?php if ( $repeat != false ) { echo $repeat; } else { echo get_option('wpt_retweet_repeat'); } ?>' />
	<input type='hidden' name='_wpt_noautopost' value='<?php echo $noautopost; ?>' />
	<?php } else { ?>
<p>
<label for="wtd"><?php _e("Delay for <em>x</em> minutes:", 'wp-tweets-pro'); ?></label> <input type="text" name="_wpt_delay_tweet" size="3" value="<?php if ( $delay != false ) { echo $delay; } else { echo get_option('wpt_delay_tweets'); } ?>" id="wtd" /> 
<input type='checkbox' value='on' name='wpt-no-delay' id='wpt-no-delay' /> <label for='wpt-no-delay'><?php _e('No delay','wp-tweets-pro'); ?></label>
</p>
<p>
<label for="wtr"><?php _e("Re-post after <em>x</em> hours:", 'wp-tweets-pro'); ?></label> <input type="text" name="_wpt_retweet_after" size="3" value="<?php if ( $retweet != false ) { echo $retweet; } else { echo get_option('wpt_retweet_after'); } ?>" id="wtr" /> 
<input type='checkbox' value='on' name='wpt-no-repost' id='wpt-no-repost' /> <label for='wpt-no-repost'><?php _e('No re-post','wp-tweets-pro'); ?></label>
</p>
<?php if ( get_option( 'jd_individual_twitter_users' ) == 1 ) { ?>
<p>
<?php $checked = ( $cotweet ) ? ' checked="checked"' : ''; ?>
<input type='checkbox' value='on' name='_wpt_cotweet' id='wpt_cotweet'<?php echo $checked; ?> /> <label for='wpt_cotweet'><?php _e('Co-tweet to site Twitter account','wp-tweets-pro'); ?></label>
</p>
<?php } ?>
<p>
<input type='checkbox' value='photo' name='_wpt_twitter_card' id='wpt_twitter_card'<?php if ( get_post_meta( $post_id, '_wpt_twitter_card', true ) == 'photo' || isset($_GET['format']) && $_GET['format'] == 'image' ) { echo ' checked="checked"'; } ?> /> <label for='wpt_twitter_card'><?php _e('Twitter Card: Photo','wp-tweets-pro'); ?></label>
</p>
<?php
	$checked = ( !$upload && $wpt_images == 'no' ) ? 'no' : $wpt_images; 
	$checked = ( $checked != 'yes' && $checked != 'no' ) ? 'no' : $checked;
	if ( get_option( 'wpt_media' ) == 1 ) { 
		$checked = apply_filters( 'wpt_default_upload_image', $checked, $upload ); ?>
		<p class='toggle-btn-group'>
			<input type='radio' name='_wpt_image' id='wpt_image_no' value='1'<?php checked( $checked, 'no' ); ?> /> <label for='wpt_image_no'><?php _e('No image upload','wp-tweets-pro'); ?></label>
			<input type='radio' name='_wpt_image' id='wpt_image_yes' value='0'<?php checked( $checked, 'yes' ); ?> /> <label for='wpt_image_yes'><?php _e('Upload image','wp-tweets-pro'); ?></label>
		</p><?php 
	} ?>
<p>
<label for="wrr"><?php _e("Re-post how many times:", 'wp-tweets-pro'); ?></label> 
	<select name="_wpt_retweet_repeat" id="wrr">
		<option value="0"<?php selected( $repeat, '0' ); ?>>0 </option>	
		<option value="1"<?php selected( $repeat, '1' ); ?>>1 </option>
		<option value="2"<?php selected( $repeat, '2' ); ?>>2 </option>
		<option value="3"<?php selected( $repeat, '3' ); ?>>3 </option>
	</select>
</p>
<?php if ( get_option( 'wpt_schedule' ) != '' ) { ?>
<p>
<input type='checkbox' value='1' id='wpt_noautopost' name='_wpt_noautopost'<?php checked( $noautopost, 1 ); ?> /> <label for='wpt_noautopost'><?php _e( "Don't automatically repost this post", 'wp-tweets-pro' ); ?></label>
</p>
<?php } ?>
<?php
	}
}

if ( !function_exists( 'wpt_pro_exists' ) ) {
	function wpt_pro_exists() {
		return true;
	}
}
	
if ( get_option( 'wpt_license_valid' ) != 'true' ) {
	$message = sprintf(__("You must <a href='%s'>enter your WP Tweets Pro license key</a> for support & updates to WP Tweets PRO features.", 'wp-tweets-pro'), admin_url('admin.php?page=wp-tweets-pro'));
	add_action( 'admin_notices', create_function( '', "if ( ! current_user_can( 'manage_options' ) ) { return; } else { echo \"<div class='error'><p>$message</p></div>\";}" ) );
}

// connect or disconnect form
function wpt_pro_functions() {
	wpt_update_pro_settings();
	wpt_build_filters();
	global $wpdb;
	echo '<div class="ui-sortable meta-box-sortables wp-tweets-pro">';
	echo '<div class="postbox">';

	$class = ( get_option( 'wpt_license_valid' ) == 'true' )?"":" style='padding: 3px; background: #ffc; border: 2px solid #c22; border-radius: 3px;'";
	$retweet = ( get_option('wpt_retweet_after') != '' )?esc_attr( get_option('wpt_retweet_after') ):'39.5';
	print('	
		<div class="handlediv"><span class="screen-reader-text">Click to toggle</span></div>
		<h3 class="hndle"><span>'.__('WP Tweets PRO Settings','wp-tweets-pro').'</span></h3>
		<div class="inside">
			<form action="" method="post">
					<p'.$class.'>
						<label for="wpt_license_key">'.__('License Key', 'wp-tweets-pro').'</label>
						<input type="text" size="38" name="wpt_license_key" id="wpt_license_key" value="'.esc_attr( get_option('wpt_license_key') ).'" />
					</p>
				<fieldset>
				<legend>'.__('Scheduling','wp-tweets-pro').'</legend>
					<p>
						<label for="wpt_delay_tweets">'.__('Number of minutes to delay tweets', 'wp-tweets-pro').'</label>
						<input type="text" size="4" name="wpt_delay_tweets" id="wpt_delay_tweets" value="'.esc_attr( get_option('wpt_delay_tweets') ).'" />
					</p>
					<p>
						<label for="wpt_retweet_after">'.__('Re-post Tweet after how many hours', 'wp-tweets-pro').'</label>
						<input type="text" size="4" name="wpt_retweet_after" id="wpt_retweet_after" value="'.$retweet.'" />
					</p>
					<p>
						<label for="wpt_retweet_repeat">'.__('Re-post Tweet how many times at this interval?', 'wp-tweets-pro').'</label>
						<select name="wpt_retweet_repeat" id="wpt_retweet_repeat">
							<option value="0"'.selected( get_option('wpt_retweet_repeat'), '0', false ).'>0 </option>						
							<option value="1"'.selected( get_option('wpt_retweet_repeat'), '1', false ).'>1 </option>
							<option value="2"'.selected( get_option('wpt_retweet_repeat'), '2', false ).'>2 </option>
							<option value="3"'.selected( get_option('wpt_retweet_repeat'), '3', false ).'>3 </option>
						</select>
					</p>
					<p>'.__('Blackout Period: Reschedule Tweets if', 'wp-tweets-pro').'
						<label for="wpt_blackout_from">'.__('between','wp-tweets-pro').'</label>
						<select name="wpt_blackout_from" id="wpt_blackout_from">
							<option value="0"> -- </option>					
							<optgroup label="'.__('AM', 'wp-tweets-pro' ).'">');
						$wpt_blackout = ( is_array( get_option( 'wpt_blackout' ) ) ) ? get_option( 'wpt_blackout' ) : array( 'from'=>0,'to'=>0 );
						for( $i=1;$i<=24;$i++ ) {
							print( '<option value="'.$i.'"'.selected( $wpt_blackout['from'], $i, false).'>'.$i.':00 </option>');
							if ( $i == 12 ) {
								print( '</optgroup>
								<optgroup label="'.__( 'PM','wp-tweets-pro' ).'">');
							}
						}
						print('</optgroup></select>
						<label for="wpt_blackout_to">'.__('and','wp-tweets-pro').'</label>
						<select name="wpt_blackout_to" id="wpt_blackout_to">
							<option value="0"> -- </option>					
							<optgroup label="'.__('AM', 'wp-tweets-pro' ).'">');
						for( $i=1;$i<=24;$i++ ) {
							print( '<option value="'.$i.'"'.selected( $wpt_blackout['to'], $i, false ).'>'.$i.':00 </option>');
							if ( $i == 12 ) {
								print( '</optgroup>
								<optgroup label="'.__( 'PM','wp-tweets-pro' ).'">');
							}
						}
						print('</optgroup></select>');
					if ( is_array( get_option( 'wpt_blackout' ) ) && !( $wpt_blackout['to'] == $wpt_blackout['from'] ) ) {
						print( "<br /><em>".sprintf( __('Tweets rescheduled for times between %1$s:00 and %2$s:00.', 'wp-tweets-pro' ), $wpt_blackout['from'], $wpt_blackout['to'] )."</em>" );
					}
					$custom_type = get_option( 'wpt_custom_type' );
					$prefix = ( $custom_type == 'prefix' || !$custom_type ) ? " checked='checked'" : '';
					$template = ( $custom_type == 'template' ) ? " checked='checked'" : '';
					print('</p>					
					<fieldset>
					<legend>'.__('Differentiate Re-posted Tweets','wp-tweets-pro').'</legend>
					<p><input type="radio" name="wpt_custom_type" id="wpt_custom_prefix" value="prefix"'.$prefix.' /> <label for="wpt_custom_prefix">Custom Prefixes</label><br />
					   <input type="radio" name="wpt_custom_type" id="wpt_custom_template" value="template"'.$template.' /> <label for="wpt_custom_template">Custom Templates</label>
					<p>
						<label for="wpt_prepend_rt">'.__('First Repost', 'wp-tweets-pro').'</label>
						<input type="text" size="32" name="wpt_prepend_rt" id="wpt_prepend_rt" value="'.esc_attr( stripslashes( get_option('wpt_prepend_rt' ) ) ).'" /> <input type="checkbox" name="wpt_rt_media" id="wpt_rt_media" value="true" ' . checked( 'true', get_option( 'wpt_rt_media' ), false ) . ' /> <label for="wpt_rt_media">' . __( 'Exclude Media on First Repost', 'wp-tweets-pro' ) . '</label>
					</p>
					<p>
						<label for="wpt_prepend_rt2">'.__('Second Repost', 'wp-tweets-pro').'</label>
						<input type="text" size="32" name="wpt_prepend_rt2" id="wpt_prepend_rt2" value="'.esc_attr( stripslashes( get_option('wpt_prepend_rt2' ) ) ).'" /> <input type="checkbox" name="wpt_rt_media2" id="wpt_rt_media2" value="true" ' . checked( 'true', get_option( 'wpt_rt_media2' ), false ) . ' /> ' . __( 'Exclude Media on Second Repost', 'wp-tweets-pro' ) . '</label>
					</p>
					<p>
						<label for="wpt_prepend_rt3">'.__('Third Repost', 'wp-tweets-pro').'</label>
						<input type="text" size="32" name="wpt_prepend_rt3" id="wpt_prepend_rt3" value="'.esc_attr( stripslashes( get_option('wpt_prepend_rt3' ) ) ).'" /> <input type="checkbox" name="wpt_rt_media3" id="wpt_rt_media3" value="true" ' . checked( 'true', get_option( 'wpt_rt_media3' ), false ) . ' /> <label for="wpt_rt_media3">' . __( 'Exclude Media on Third Repost', 'wp-tweets-pro' ) . '</label>
					</p>');
					if ( $custom_type == 'prefix' || !$custom_type ) {
						print( '
					<p><input type="checkbox" name="wpt_prepend" id="wpt_prepend" value="on"'.jd_checkCheckbox( 'wpt_prepend' ).' />
						<label for="wpt_prepend">'.__('Move repost prefixes to end of repost', 'wp-tweets-pro').'</label>
					</p>');
					}
					print( '
					</fieldset>
					<fieldset>
					<legend>'.__('Co-tweeting and <a href="https://dev.twitter.com/cards">Twitter Cards</a>','wp-tweets-pro').'</legend>
					<p>
						<input type="checkbox" name="wpt_twitter_card" id="wpt_twitter_card" value="on" '.jd_checkCheckbox( 'wpt_twitter_card' ).' aria-describedby="tc_validation" />
						<label for="wpt_twitter_card">'.__('Enable Twitter Cards.', 'wp-tweets-pro').'</label> <span id="tc_validation"><a href="https://cards-dev.twitter.com/validator">' . __( 'Validate your Twitter Cards', 'wp-tweets-pro' ) . '</a></span>
					</p>
					<p>
						<label for="wpt_toggle_card">'.__('Auto-enable photo card if post length less than', 'wp-tweets-pro').'</label>
<input type="text" name="wpt_toggle_card" id="wpt_toggle_card" aria-labelledby="wpt_toggle_card wpt_tc_label" size="4" value="'.(int) get_option( 'wpt_toggle_card' ).'" /> <span id="wpt_tc_label">'.__('characters','wp-tweets-pro').'</span>
					</p>					
					<p>
						<input type="checkbox" name="wpt_cotweet" id="wpt_cotweet" value="on" '.jd_checkCheckbox( 'wpt_cotweet' ).' />
						<label for="wpt_cotweet">'.__('Co-Tweet to Main Site account and author\'s account.', 'wp-tweets-pro').'</label>
					</p>');
						$disabled = ( get_option( 'jd_individual_twitter_users' ) != 1 )?" disabled='disabled'":'';
					print('
					<p class="indent">
						<label for="wpt_cotweet_lock">'.__('All co-tweets sent to this author', 'wp-tweets-pro').'</label>
						<select name="wpt_cotweet_lock" id="wpt_cotweet_lock"'.$disabled.'>
							<option value="false">'.__('Post author','wp-tweets-pro').'</option>');
						$count = count_users('time');
						$users = ( $count['total_users'] > 100 )?get_users( array( 'role'=>'administrator' ) ):$users = get_users();
						$authorized_users = array();
						foreach ( $users as $this_user ) {
							if ( wtt_oauth_test( $this_user->ID,'verify' ) ) {
								$twitter = get_user_meta( $this_user->ID, 'wtt_twitter_username', true );
								$authorized_users[] = array( 'ID'=>$this_user->ID, 'name'=>$this_user->display_name, 'twitter'=>$twitter );
								print('<option value="'.$this_user->ID.'" '.jd_checkSelect( 'wpt_cotweet_lock',$this_user->ID ).'>'.$this_user->display_name." (@$twitter)</option>");
							}
						}
						update_option( 'wpt_authorized_users', $authorized_users );
					print('
						</select>
					</p>
					</fieldset>
					<fieldset>
					<legend>'.__('Add hashtag filters','wp-tweets-pro').'</legend>
					<p>
						<input type="checkbox" name="wpt_filter_title" id="wpt_filter_title" value="on" '.jd_checkCheckbox( 'wpt_filter_title' ).' />
						<label for="wpt_filter_title">'.__('Filter Post Titles and insert hashtags', 'wp-tweets-pro').'</label>
					</p>
					<p>
						<input type="checkbox" name="wpt_filter_post" id="wpt_filter_post" value="on"'.jd_checkCheckbox( 'wpt_filter_post' ).' />
						<label for="wpt_filter_post">'.__('Filter Post excerpts and insert hashtags', 'wp-tweets-pro').'</label>
					</p>
					</fieldset>'); 
					?>
					<fieldset class="comments">
					<legend><?php _e('Tweet Comments','wp-tweets-pro'); ?></legend>
					<?php					
					if ( get_option( 'comment_moderation' ) == 1 || get_option( 'comment_whitelist' ) == 1 ) {
					?>
					<p>
						<input type="checkbox" name="comment-published-update" id="comment-published-update" value="1" <?php echo jd_checkCheckbox('comment-published-update')?> />
						<label for="comment-published-update"><strong><?php _e("Update Twitter when new comments are posted", 'wp-tweets-pro'); ?></strong></label><br />				
						<label for="comment-published-text"><?php _e("Template for new comments:", 'wp-tweets-pro'); ?></label> <input aria-labelledby="comment-published-text-label" type="text" class="wpt-template" name="comment-published-text" id="comment-published-text" size="60" maxlength="120" value="<?php echo ( esc_attr( stripslashes( get_option( 'comment-published-text' ) ) ) ); ?>" /><br />
						<label for="wpt_comment_delay"><?php _e( 'Delay comments (minutes)', 'wp-tweets-pro' ); ?></label> <input type="number" name="wpt_comment_delay" id="wpt_comment_delay" value="<?php esc_attr_e( get_option( 'wpt_comment_delay' ) ); ?>" />
					</p>
					<p id='comment-published-text-label'><?php _e('Comments can use <code>#commenter#</code> to post the commenter\'s name in the Tweet, <code>#comment#</code> to post an excerpt of the comment, and <code>#comment_date#</code>. Comments will be Tweeted immediately when approved, or automatically if commenter has the "moderate comments" capability.','wp-tweets-pro'); ?>
					<?php 
					} else {
						$url = admin_url( 'options-discussion.php#moderation_notify' );
						printf( __( "<em>Disabled</em>: Require <a href='%s'>administrator moderation of comments</a> or a previously approved comment to enable Tweeting comments.", 'wp-tweets-pro' ), $url );
					}
					?>
					</fieldset>
					<fieldset class="uploads">
					<legend><?php _e('Upload Images to Twitter','wp-tweets-pro'); ?></legend>
					<?php					
						if ( function_exists('curl_version') ) {
					?>
					<p>
						<input type="checkbox" name="wpt_media" id="wpt_media" value="on" <?php echo jd_checkCheckbox('wpt_media')?> /> <label for="wpt_media"><?php _e("Upload images to Twitter (Featured Image first, first other attached image otherwise.)", 'wp-tweets-pro'); ?></label>			
					</p>
					<?php 
					} else {
						_e( "<em>Disabled</em>: cURL support not available.", 'wp-tweets-pro' );
					}
					?>
					</fieldset>					
					<?php
					print('
					<fieldset>
					<legend>'.__('Custom Tweet Filters','wp-tweets-pro').'</legend>
					<p>'.__('Use these filters to set custom rules to block tweeting.','wp-tweets-pro').'</p>
					'.wpt_setup_filters().'
					</fieldset>
				');
				?>
					<fieldset class="autopost">
					<legend><?php _e( 'Automatically Tweet Old Posts', 'wp-tweets-pro' ); ?></legend>
					<?php 
						if ( get_option( 'wpt_schedule' ) != '' ) {
					?>
					<p>
						<input type='hidden' name='wpt_is_scheduled' value='on' />
						<input type='checkbox' id='wpt_unschedule' name='wpt_unschedule' /> <label for='wpt_unschedule'><?php _e( 'Delete currently scheduled posting cycle', 'wp-tweets-pro' ); ?>
					</p>
					<?php							
						}
					?>
					<p>
						<label for='wpt_schedule'><?php _e( 'Autopost interval', 'wp-tweets-pro' ); ?></label> 
						<select name='wpt_schedule' id='wpt_schedule'>
							<option value=''><?php _e( 'None selected', 'wp-tweets-pro' ); ?></option>
							<?php 
								// note: if a schedule is set, show checkbox to delete existing schedule and create new.
								$schedules = wp_get_schedules(); 
								foreach ( $schedules as $key => $schedule ) {
									echo "<option value='$key'" . selected( get_option( 'wpt_schedule' ), $key ) . ">$schedule[display]</option>";
								}
							?>
						</select>
					</p>
					<p>
						<label for='wpt_schedule_template'><?php _e( 'Template for autoscheduled posts', 'wp-tweets-pro' ); ?></label>
						<textarea name='wpt_schedule_template' id='wpt_schedule_template' cols='60' rows='3' class='wpt-template'><?php esc_attr_e( stripslashes( get_option( 'wpt_schedule_template' ) ) ); ?></textarea>
					</p>
					<p>
						<label for="wpt_minimum_age"><?php _e( 'Minimum age of posts eligible for automatic Tweeting', 'wp-tweets-pro' ); ?></label>
						<select name='wpt_minimum_age' id='wpt_minimum_age'>
							<option value='none'<?php selected( get_option( 'wpt_minimum_age' ), 1 ); ?>><?php _e( 'No limit', 'wp-tweets-pro' ); ?></option>						
							<option value='2592000'<?php selected( get_option( 'wpt_minimum_age' ), 2592000 ); ?>><?php _e( '1 month', 'wp-tweets-pro' ); ?></option>
							<option value='7776000'<?php selected( get_option( 'wpt_minimum_age' ), 7776000 ); ?>><?php _e( '3 months', 'wp-tweets-pro' ); ?></option>
							<option value='15552000'<?php selected( get_option( 'wpt_minimum_age' ), 15552000 ); ?>><?php _e( '6 months', 'wp-tweets-pro' ); ?></option>
							<option value='31536000'<?php selected( get_option( 'wpt_minimum_age' ), 31536000 ); ?>><?php _e( '12 months', 'wp-tweets-pro' ); ?></option>
						</select>
					</p>
					<p>
						<label for="wpt_maximum_age"><?php _e( 'Maximum age of posts eligible for automatic Tweeting', 'wp-tweets-pro' ); ?></label>
						<select name='wpt_maximum_age' id='wpt_maximum_age'>
							<option value='none'<?php selected( get_option( 'wpt_maximum_age' ), 1 ); ?>><?php _e( 'No limit', 'wp-tweets-pro' ); ?></option>						
							<option value='31536000'<?php selected( get_option( 'wpt_maximum_age' ), 31536000 ); ?>><?php _e( '12 months', 'wp-tweets-pro' ); ?></option>
							<option value='63072000'<?php selected( get_option( 'wpt_maximum_age' ), 63072000 ); ?>><?php _e( '2 years', 'wp-tweets-pro' ); ?></option>	
							<option value='157680000'<?php selected( get_option( 'wpt_maximum_age' ), 157680000 ); ?>><?php _e( '5 years', 'wp-tweets-pro' ); ?></option>
							<option value='315360000'<?php selected( get_option( 'wpt_maximum_age' ), 315360000 ); ?>><?php _e( '10 years', 'wp-tweets-pro' ); ?></option>
						</select>
					</p>
					<p>
						<label for="wpt_autoretweet_post_types"><?php _e( 'Automatically Tweet these post types', 'wp-tweets-pro' ); ?></label><br />
						<select name='wpt_autoretweet_post_types[]' id='wpt_autoretweet_post_types' multiple='multiple'>
							<?php
								$post_types    = get_post_types( array( 'public' => true ), 'objects' );
								$wpt_post_types = get_option( 'wpt_autoretweet_post_types' );
								if ( ! is_array( $wpt_post_types ) ) {
									$wpt_post_types = array();
								}
								$wpt_post_type_options = '';

								foreach ( $post_types as $type ) {
									if ( $type->name == 'mc-events' ) {
										continue;
									}
									if ( in_array( $type->name, $wpt_post_types ) ) {
										$selected = ' selected="selected"';
									} else {
										$selected = '';
									}
									$wpt_post_type_options .= "<option value='$type->name'$selected>" . $type->labels->name . "</option>";
								}
								echo $wpt_post_type_options;
							?>
						</select>
					</p>
					<p>
						<label for='wpt_autopost_notification'><?php _e( 'Notify me about autoposted Tweets', 'wp-tweets-pro' ); ?></label>
						<input type='email' name='wpt_autopost_notification' id='wpt_autopost_notification' value='<?php esc_attr_e( get_option( 'wpt_autopost_notification' ) ); ?>' />
					</p>
					</fieldset>	
	<?php
		echo '		<p class="submit">
					<input type="submit" name="submit" class="button-primary" value="'.__('Update WP Tweets PRO Settings', 'wp-tweets-pro').'" />
				</p>
				<input type="hidden" name="wp_pro_settings" value="set" class="hidden" style="display: none;" />
				'.wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false).'
			</form>
			</div>';	
	echo "</div>";
	echo "</div>";
}

function wpt_notes() {
	$is_enabled = get_option( 'jd_individual_twitter_users' );
	if ( $is_enabled ) { 
		$message = __("<em>Individual Author accounts are already enabled.</em>",'wp-tweets-pro'); 
	} else {
		$message = __("<em>Enable individual Author accounts in <a href='#indauthors'>Advanced Settings</a>, below.</em>",'wp-tweets-pro');
	}
	print( '
	<div class="ui-sortable meta-box-sortables wp-tweets-notes">
		<div class="postbox">
		<div class="handlediv"><span class="screen-reader-text">Click to toggle</span></div>
			<h3 class="hndle"><span>'.__('WP Tweets PRO Notes','wp-to-twitter').'</span></h3>
			<div class="inside">	
			<p>'.__('Most WP Tweets PRO settings can also be set on a per-post basis. Leave empty for instant posting and no re-post.','wp-tweets-pro').'</p>
			<p>'.__('Twitter blocks identical Tweets. Prepend text to differentiate reposts.','wp-tweets-pro' ).'</p>
			<p>'.__('Additional Twitter accounts are added in user profiles.','wp-tweets-pro').' '.$message.'</p>
			</div>
		</div>
	</div>' );
}

function wpt_authorized_users( $selected=array() ) {
	global $user_ID;
	$users = get_option( 'wpt_authorized_users' );
	if ( !$users ) {
		$count = count_users('time');
		$users = ( $count['total_users'] > 100 )?get_users( array( 'role'=>'administrator' ) ):$users = get_users();
		$authorized_users = array();
		if ( is_array( $users ) ) {
			foreach ( $users as $this_user ) {
				if ( wtt_oauth_test( $this_user->ID,'verify' ) ) {
					$twitter = get_user_meta( $this_user->ID, 'wtt_twitter_username', true );
					$authorized_users[] = array( 'ID'=>$this_user->ID, 'name'=>$this_user->display_name, 'twitter'=>$twitter ); 
				}
			}
		}
		update_option( 'wpt_authorized_users', $authorized_users );
		$users = $authorized_users; 		
	}
	$main_account = get_option( 'wtt_twitter_username' );
	$select = "<p class='wpt_auth_users'><label for='wpt_authorized_users'>".__( 'Tweet to:', 'wp-tweets-pro' )."</label><br /><select multiple='multiple' name='_wpt_authorized_users[]' id='wpt_authorized_users'>
		<option value='main'>(" . __( 'Site account', 'wp-tweets-pro' ) . ") $main_account</option>";

	if ( !empty( $users ) ) {
		foreach ( $users as $user ) {
			$current = $user_ID;
			$active = '';
			// if this has been directly pulled, these are objects. Otherwise, arrays.
			if ( is_object( $user ) ) {
				$id = $user->ID;
				$name = $user->display_name;
				$twitter = get_user_meta( $id, 'wtt_twitter_username', true );
			} else {
				$id = $user['ID'];
				$name = $user['name'];
				$twitter = $user['twitter'];
			}
			global $post;
			if ( ( $id == $current && $current == $post->post_author ) || in_array( $id, $selected ) ) { 
				$active = " selected='selected'"; 
			}
			$select .= " <option value='$id'$active>$name (@$twitter)</option>\n";
		}
	}
	$select .= "</select></p>";
	return $select;
}

function wpt_add_js() {
global $current_screen;
	if ( $current_screen->id == 'wp-tweets-pro_page_wp-to-twitter-tweets' || $current_screen->id == 'wp-tweets-pro_page_wp-to-twitter-errors' ) {
		echo '
<script type="text/javascript">
jQuery(document).ready( function($) {
	$("#wpt ul").hide();
	$("#wpt th > a").live("click", function(e){
		e.preventDefault();
		$(this).next("ul").toggle();
	});	
});
</script>
';
	}
	if ( $current_screen->id == 'wp-tweets-pro_page_wp-to-twitter-schedule' ) {
		echo '
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#date").calendricalDate();
	$("#time").calendricalTime();
});
</script>';	
	}
}

add_filter( 'wpt_set_retweet_text', 'wpt_set_retweet_text', 10, 2 );
function wpt_set_retweet_text( $template, $rt ) {
	switch( $rt ) {
		case 1:
		$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt');
		$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt');
		break;
		case 2:
		$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt2');
		$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt2');
		break;
		case 3:
		$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt3');
		$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt3');
		break;
	}
	if ( get_option( 'wpt_custom_type' ) == 'template' ) {
		$retweet = trim( $prepend.$append );
	} else {
		$retweet = trim( $prepend.$template.$append );
	}
	// get custom value
	if ( isset( $_POST['_wpt_retweet_text'] ) && !empty( $_POST['_wpt_retweet_text'] ) ) {
		$prev_retweet = $retweet; 
		$templates = $_POST['_wpt_retweet_text'];
		if ( isset( $templates[($rt-1)] ) ) {
			$retweet = trim( stripslashes( $templates[($rt-1)] ) );
		}
		if ( $retweet == '' || !$retweet || is_array( $retweet ) ) { $retweet = $prev_retweet; }
	}
	return $retweet;
}

// based on original comment Tweet function from Luis Nobrega
/* Assume is approved, unless otherwise informed by comment validator */
function wpt_set_comment_tweet( $comment_id, $approved ) {	
	$_t = get_comment( $comment_id );
	$post_ID = $_t->comment_post_ID;
	$commenter = $_t->comment_author;
	$comment = $_t->comment_content;
	$user_id = $_t->user_id;
		$excerpt_length = get_option( 'jd_post_excerpt' );
		$comment_excerpt = @mb_substr( strip_tags( strip_shortcodes( $comment ) ), 0, $excerpt_length );
	$comment_date = $_t->comment_date;
		$dateformat = (get_option('jd_date_format')=='')?get_option('date_format'):get_option('jd_date_format');
		$comment_date = mysql2date( $dateformat,$comment_date );
	$jd_tweet_this = get_post_meta( $post_ID, '_jd_tweet_this', TRUE );
	$post_info = jd_post_info( $post_ID );
	$sentence = '';
	$comment_url = apply_filters( 'wptt_shorten_link', get_comment_link( $comment_id ), $post_info['postTitle'], $post_ID, false );
	$sentence = stripcslashes( get_option( 'comment-published-text' ) );
	$sentence = jd_truncate_tweet( $sentence, $post_info, $post_ID );
	$sentence = str_replace("#commenter#",$commenter, $sentence);
	$sentence = str_replace("#comment#", $comment_excerpt,$sentence);
	$sentence = str_replace("#comment_date#", $comment_date, $sentence );
	$sentence = str_replace("#comment_url#", $comment_url, $sentence );
	if ( $sentence != '' ) {
		$comment_tweet = apply_filters( 'wpt_filter_comment_tweet', $sentence, $_t );
		add_comment_meta( $comment_id, 'wpt_comment_tweet', $comment_tweet, true );
	}
	if ( user_can( $user_id, 'moderate_comments' ) || $approved == 1 ) {
		wpt_twit_comment( $_t );
	}
	return $post_ID;
}

function wpt_filter_comment_info( $comment ) {
	$filters = get_option( 'wpt_filters' );
	if ( is_array( $filters ) ) {
		foreach ( $filters as $filter=>$rule ) {
			$comparison = $rule['type'];
			$field = $rule['field'];
			switch( $field ) {
				case 'postTitle' : $value = get_the_title( $comment->comment_post_ID ); break;
				case 'postLink' : $value = get_the_permalink( $comment->comment_post_ID ); break;
				case 'shortUrl' : $short = wpt_short_url( $comment->comment_post_ID ); break;
				case 'postStatus' : $value = 'publish'; break; // comments are only on published posts.
				case 'postType' : $value = get_post_type( $comment->comment_post_ID ); break;
				case 'id' : $value = $comment->comment_post_ID; break;
				case 'authId' : $value = $comment->user_id; break;
				case 'postExcerpt' : wpt_get_excerpt_by_id( $comment->comment_post_ID ); break;
			}
			switch ( $comparison ) {
				case 'equals':
					if ( $value == $rule['value'] ) return true;
				break;
				case 'notin':
					if ( strpos( $value, $rule['value'] ) === false ) return true;
				break;
				case 'in':
					if ( strpos( $value, $rule['value'] ) !== false ) return true;				
				break;
				case 'notequals':
					if ( $value != $rule['value'] ) return true;				
				break;
				default: return true;
			}
		}
		return false;
	}
	return false;
}

function wpt_twit_comment( $comment ) {
	if ( isset( $_REQUEST['tweet'] ) && $_REQUEST['tweet'] == 'false' ) { return; }
	$block = wpt_filter_comment_info( $comment ); 
	$delay = ( get_option( 'wpt_comment_delay' ) == '' ) ? false : get_option( 'wpt_comment_delay' );
	// $block == true means block this comment.
	if ( !$block ) {
		$comment_id = $comment->comment_ID;
		$post_ID = $comment->comment_post_ID;
		$sentence = get_comment_meta( $comment_id, 'wpt_comment_tweet', true );
		if ( $sentence && !$delay ) {
			$tweet = jd_doTwitterAPIPost( $sentence, false, $post_ID );
		} else {
			$delay = apply_filters( 'wpt_schedule_comment_delay', ( (int) $delay ) * 60, $post_ID );
			wp_schedule_single_event( time() + $delay, 'wpt_schedule_tweet_action', array(
					'id'       => false,
					'sentence' => $sentence,
					'rt'       => 0,
					'post_id'  => $post_ID
			) );		
		}
	}
}

if ( get_option('comment-published-update') == 1 && 
	( get_option( 'comment_moderation' ) == 1 || get_option( 'comment_whitelist' ) == 1 ) ) {
	add_action( 'comment_post', 'wpt_set_comment_tweet', 10, 2 );
	add_action( 'comment_unapproved_to_approved', 'wpt_twit_comment', 10, 2 );
	add_filter( 'manage_edit-comments_columns', 'wpt_comment_columns' );
	add_filter( 'manage_comments_custom_column', 'wpt_comment_column', 10, 2 );	
}

function wpt_comment_columns( $columns ) {
	$columns['wpt_comment_tweet'] = __( 'Comment Tweet' );
	return $columns;
}

function wpt_comment_column( $column, $comment_ID ) {
	if ( 'wpt_comment_tweet' == $column ) {
		$comment = get_comment( $comment_ID );
		if ( $meta = get_comment_meta( $comment_ID, $column , true ) ) {
			echo $meta;
			if ( $comment->comment_approved != 1 ) {
				$approve_nonce = esc_html( '_wpnonce=' . wp_create_nonce( "approve-comment_$comment->comment_ID" ) );
				$url = "comment.php?c=$comment_ID&#038;action=approvecomment&#038;tweet=false&#038;$approve_nonce";
				echo "<p><span class='approve'>";
				printf( __('<a href="%s" data-wp-lists="dim:the-comment-list:comment-%d:unapproved:e7e7d3:tweet=false:new=approved" class="vim-a">Approve without Tweeting</a>','wp-tweets-pro'), $url, $comment_ID );
				echo "</span></p>";
			}
		} else {
			_e( 'No Tweet saved for this comment.','wp-tweets-pro' );
		}
	}
}

function wpt_add_styles() {
global $current_screen;
	if ( $current_screen->id == 'profile' ) {
		echo '
<style type="text/css">
.wpt-profile ul { margin-left: 3em}
.wpt-profile li { list-style-type: disc}
.wpt-profile .tokens label { display: block}
.notes { width: 240px; float: right; margin-left: 30px; border-left: 1px solid #ddd; padding-left: 10px}
</style>
';
	}
	if ( $current_screen->id == 'wp-tweets-pro_page_wp-to-twitter-tweets' || $current_screen->id == 'wp-tweets-pro_page_wp-to-twitter-errors' ) {
		echo '
<style type="text/css">
.wrap #wpt th > a { text-decoration: none}
.wrap #wpt th > a:hover, .wrap #wpt .post_title > a:focus { text-decoration: underline}
.wrap #wpt li { list-style-type: disc; margin-left: 2em; font-size: .85em}
#wp-to-twitter table label { position: absolute; left: -999em; }
.post-types { margin: 0!important; padding: 0; }
.post-types li { display: inline; list-style-type: none; }
.post-types li a { padding: 5px; background: #fff; margin: 0 1px 0 0; border: 1px solid #ccc; border-radius: 3px;}
.post-types li a:hover, .post-types li a:focus { border: 1px solid; }
</style>
';
	}
	if ( $current_screen->id == 'toplevel_page_wp-tweets-pro' ) {
		echo '
<style type="text/css">
#wp-to-twitter table label { position: absolute; left: -999em; }
</style>
';
	}
	if ( $current_screen->id == 'wp-tweets-pro_page_wp-to-twitter-schedule' ) {
		echo '
<link type="text/css" rel="stylesheet" href="'.plugins_url( 'js/calendrical.css', __FILE__ ).'" />
<style type="text/css">
#jtw { width: 98%; font-size: 1.5em; margin-top: 2px; }
.columns {-moz-column-count: 3;-moz-column-gap: 20px;-webkit-column-count: 3;-webkit-column-gap: 20px;column-count: 3;column-gap: 20px;}
#wp2t .datetime { position: relative; }
#wp2t .date { width: 160px; }
#wp2t .time { position: absolute; left: 180px; top: 0; }
</style>
';
	}		
}
add_action( 'admin_head', 'wpt_add_styles' );
add_action( 'admin_head', 'wpt_add_js' );
add_action( 'admin_menu', 'wpt_enqueue_js' );
if ( get_option('wpt_twitter_card') == 1 ) {
	add_action( 'wp_head', 'wpt_twitter_card' );
}
// autorender photocard & toggle post meta if image & minimal text.
function wpt_render_photocard( $id ) {
	if ( get_post_meta( $id, '_wpt_twitter_card', true ) == 'photo' &&  wp_get_attachment_url( get_post_thumbnail_id( $id ) ) ) {
		return true; 
	} else {
		$post = get_post( $id );
		$content = $post->post_content;
		$length_limit = ( get_option( 'wpt_toggle_card' ) )?get_option( 'wpt_toggle_card' ):0;
		if ( strlen($content) <= $length_limit && wp_get_attachment_url( get_post_thumbnail_id($id) ) ) {
			update_post_meta( $id, '_wpt_twitter_card', 'photo' );
			return true; 
		}
	}
	return false;
}

function wpt_twitter_card() {
	if ( is_singular() ) {
	$post_ID = get_the_ID();
	$photocard = ( wpt_render_photocard( $post_ID ) )?true:false;
	$excerpt = wpt_get_excerpt_by_id( $post_ID );
	$excerpt_length = apply_filters( 'wpt_summary_large_image_excerpt', 80 );
	if ( $photocard ) {
		if ( $excerpt && mb_strlen( $excerpt ) > $excerpt_length ) {
			$meta = '<meta name="twitter:card" content="summary_large_image" />';		
		} else {
			$meta = '<meta name="twitter:card" content="photo" />';
		}
	} else {
		$meta = '<meta name="twitter:card" content="summary" />';
	}
	$meta .= '
<meta name="twitter:site" content="@'.get_option('wtt_twitter_username').'" />
<meta name="twitter:url" content="'.get_permalink($post_ID).'" />
<meta name="twitter:title" content="'.get_the_title($post_ID).'" />
<meta name="twitter:description" content="'.$excerpt.'" />
';
if ( wp_get_attachment_url( get_post_thumbnail_id( $post_ID ) ) ) { 
	$meta .= '<meta name="twitter:image:src" content="'. wp_get_attachment_url( get_post_thumbnail_id( $post_ID ) ).'">';
}
	echo $meta;
	} 
}

function wpt_get_excerpt_by_id( $post, $length = 15, $tags = '<a><em><strong>', $extra = ' &hellip;' ) {
	if ( is_int($post) ) {
		// get the post object of the passed ID
		$post = get_post($post);
	} else if ( !is_object($post) ) {
		return false;
	}

	if (has_excerpt($post->ID)) {
		$the_excerpt = $post->post_excerpt;
	} else {
		$the_excerpt = $post->post_content;
	}
	$the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags);
	$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
	$excerpt_waste = array_pop($the_excerpt);
	$the_excerpt = implode($the_excerpt);
	$the_excerpt .= $extra;
	return preg_replace( '/\s+/', ' ', trim( $the_excerpt ) );
}

function wpt_enqueue_js() {
	if ( isset($_GET['page']) && $_GET['page'] == 'wp-to-twitter-schedule' ) {
		wp_enqueue_script('jquery.calendrical',plugins_url( 'js/jquery.calendrical.js', __FILE__ ), array('jquery') );	
	}
}

function wpt_connect_oauth_message( $id ) {
		$message = get_user_meta( $id,'wpt-connection-message',true );
		echo ( $message == '' )?'':"<div id='message' class='updated'><p>$message</p></div>";
}

add_action( 'init', 'wpt_edit_terms_fields' );
function wpt_edit_terms_fields() {
	$args = apply_filters( 'wpt_revive_taxonomies', array() );
	$taxonomies = get_taxonomies( $args );
	if ( ! is_array( $taxonomies ) ) {
		$taxonomies = array();
	}
	foreach ( $taxonomies as $value ) {
			add_action( $value . '_add_form_fields', 'wpt_add_term', 10, 1 );
			add_action( $value . '_edit_form_fields', 'wpt_edit_term', 10, 2 );
			add_action( 'edit_'.$value, 'wpt_save_term', 10, 2 );
			add_action( 'created_'.$value, 'wpt_save_term', 10, 2 );
	}
}

function wpt_save_term( $term_id, $tax_id ) {
	$option_set = get_option( "wpt_taxonomy_revive_$term_id" );
	if ( isset( $_POST['taxonomy'] ) ) {
		$taxonomy = $_POST['taxonomy'];
		if ( isset( $_POST['wpt_term_revive'] ) && $option_set != 1 ) {
			update_option( "wpt_taxonomy_revive_$term_id", 1 );
			$args = array(
					'tax_query' => 
						array( 
							array( 'taxonomy'=>$taxonomy, 'field' => 'id', 'terms' => $term_id ) 
						), 
					'fields'=>'ids',
					'posts_per_page'=> -1
				);
			$posts = new WP_Query( $args );
			foreach ( $posts->posts as $post ) {
				update_post_meta( $post, '_wpt_noautopost', 1 );
			}
		} else if ( !isset( $_POST['wpt_term_revive'] ) && $option_set == 1 ) {
			delete_option( "wpt_taxonomy_revive_$term_id" );
			$args = array( 
					'tax_query' => 
						array( 
							array( 'taxonomy'=>$taxonomy, 'field' => 'id', 'terms' => $term_id ) 
						), 
					'fields'=>'ids',
					'posts_per_page'=> -1
				);
			$posts = new WP_Query( $args );
			foreach ( $posts->posts as $post ) {
				delete_post_meta( $post, '_wpt_noautopost' );
			}		
		}
	}
}

function wpt_edit_term( $term, $taxonomy ) {
	$t_id = $term->term_id;
	$term_meta = get_option( "wpt_taxonomy_revive_$t_id" );
?>
    <tr class="form-field">
            <th valign="top" scope="row">
                <label for="wpt_term_revive"><?php _e( 'Don\'t autotweet this term','wp-tweets-pro' ); ?></label>
            </th>
            <td>
				<input type='checkbox' value='1' name='wpt_term_revive' id='wpt_term_revive'<?php checked( $term_meta, 1 ); ?> />
            </td>
        </tr>
        <?php 	
}

function wpt_add_term( $tag ) {
?>
    <div class="form-field">
		<input type='checkbox' value='1' id='wpt_term_revive' name='wpt_term_revive' /> <label for="wpt_term_revive" style='display: inline;'><?php _e( 'Don\'t autotweet this term','wp-tweets-pro' ); ?></label>
	</div>
	<?php 
}


add_action( 'post_tag_add_form_fields','wpt_add_tag' );
add_action( 'post_tag_edit_form_fields','wpt_edit_tag' );
add_action( 'edited_post_tag', 'wpt_save_tag', 10, 2 );
add_action( 'created_post_tag', 'wpt_save_tag', 10, 2 );

function wpt_save_tag( $term_id ) {
	if ( isset( $_POST['wpt_tag'] ) ) {
		$wpt_tag = $_POST['wpt_tag'];
		update_option( "wpt_taxonomy_$term_id", $wpt_tag );
	}
}

function wpt_edit_tag( $term ) {
	$t_id = $term->term_id;
	$term_meta = get_option( "wpt_taxonomy_$t_id" );
?>
    <tr class="form-field">
            <th valign="top" scope="row">
                <label for="wpt_tag"><?php _e('Tweet tag as','wp-tweets-pro'); ?></label>
            </th>
            <td>
                <select name="wpt_tag" id="wpt_tag">
					<option value='1'<?php echo ( $term_meta == 1 )?"selected='selected'":''; ?>>#tag</option>
					<option value='2'<?php echo ( $term_meta == 2 )?"selected='selected'":''; ?>>$tag</option>
					<option value='3'<?php echo ( $term_meta == 3 )?"selected='selected'":''; ?>><?php _e('ignore','wp-tweets-pro'); ?></option>
				</select>
            </td>
        </tr>
        <?php 
}

function wpt_add_tag() {
?>
    <tr class="form-field">
            <th valign="top" scope="row">
                <label for="wpt_tag"><?php _e('Tweet tag as','wp-tweets-pro'); ?></label>
            </th>
            <td>
                <select name="wpt_tag" id="wpt_tag">
					<option value='1'>#tag</option>
					<option value='2'>$tag</option>
					<option value='3'><?php _e('ignore','wp-tweets-pro'); ?></option>
				</select>
            </td>
        </tr>
        <?php 
}

add_filter( 'wpt_settings', 'wpt_set_filter_terms', 10, 2 );
function wpt_set_filter_terms( $message, $post ) {
	if ( isset( $post['wpt_terms'] ) ) {
		// if setting term filters, delete old filters.
		delete_option( 'jd_twit_cats' ); 
		delete_option( 'limit_categories' );
		delete_option( 'tweet_categories' );
		foreach ( $post['wpt_terms'] as $tax => $terms ) {
			$terms = array_unique( $terms );
			$wpt_terms[$tax] = $terms;
		}
		update_option( 'wpt_terms', $wpt_terms );
		$message .= ' '.__( 'Term filters updated.','wp-tweets-pro' );
	} else {
		delete_option( 'wpt_terms' );
	}
	if ( isset( $post['wpt_term_filters'] ) ) {
		update_option( 'wpt_term_filters', $post['wpt_term_filters'] );
		$message .= ' '.__( 'Term filtering method reversed.','wp-tweets-pro' );
	} else {
		delete_option( 'wpt_term_filters' );
	}
	return $message;
}

add_filter( 'wpt_filter_terms', 'wpt_apply_term_filters', 10, 2 );
function wpt_apply_term_filters( $filter, $args ) {
	$post_type = ( isset( $args['type'] ) ) ? $args['type'] : false;
	$post_ID = ( isset( $args['id'] ) ) ? $args['id'] : false;
	// $filter == true == allowed
	$term_ids = array();
	$filters = get_option( 'wpt_terms' );
	if ( is_array( $filters ) ) {
		$filtered_taxonomies = array_keys( $filters );
		$taxonomies = get_object_taxonomies( $post_type, 'names' );
		$terms = wp_get_object_terms( $post_ID, $taxonomies );
		foreach ( $terms as $term ) {
			$term_ids[$term->taxonomy][] = $term->term_id; // term IDs are unique, so I don't care which taxonomy this is.
		}
		$positive = get_option( 'wpt_term_filters' ); // items in array are checked positively
		foreach( $filters as $key => $value ) {
			// if there are terms in both sets
			// this keeps going unless any test comes up as false.
			if ( !empty( $filters[$key] ) ) {
				if ( isset($term_ids[$key]) ) {
					$result = array_intersect( $term_ids[$key], $filters[$key] );
					if ( isset( $positive[$key] ) && count($result) >= 1 ) {
						$filter = true;
					} else if ( isset( $positive[$key] ) && count($result) == 0 ) {
						$filter = false;
					} else if ( count( $result ) >= 1 && !isset( $positive[$key] ) ) {
						return false;
					}
				}
			}
		}
	}
	wpt_mail(  "3d: Taxonomy limits completed - $filter - #$post_ID", print_r( $args , 1 ) );
	return apply_filters( 'wpt_modify_term_filters', $filter, $args );
}

function wpt_list_terms( $post_type, $post_name ) {
	$selected = "";
	$taxonomies = get_object_taxonomies( $post_type, 'object' );
	$term_filters = get_option( 'wpt_terms' );
	$filter_type = get_option( 'wpt_term_filters' );
	$nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);
	$input = '';
	if ( !empty( $taxonomies ) ) {
		foreach( $taxonomies as $taxonomy ) {
			$name = $taxonomy->labels->name;
			$slug = $taxonomy->name;			
			$count = wp_count_terms( $slug );
			echo "<input type='hidden' name='wpt_term_taxonomies[]' value='$slug' />";
			if ( $count > 500 ) {
				_e( 'There are more than 500 terms in this taxonomy. Use the <code>wpt_filter_terms</code> filter to apply custom limits on this taxonomy.', 'wp-tweets-pro' );
			} else {
				$terms = get_terms( $slug, array( 'hide_empty'=>false ) );
				$checked = ( isset( $filter_type[$slug] ) ) ? ' checked="checked"' : '';
				if ( !$checked ) { $exclude = __('Exclude','wp-tweets-pro'); } else { $exclude = __('Include','wp-tweets-pro'); }
				$input = "
				<fieldset class='wpt-terms'>
					<legend>".sprintf( __('%3$s %1$s by %2$s','wp-to-twitter'), $post_name, $name, $exclude )."</legend>";
				$input .= '
					<p>
					<input type="checkbox" name="wpt_term_filters['.$slug.'][]" id="wpt_term_filters_'.$slug.'" value="1"'.$checked.' />
					<label for="wpt_term_filters_'.$slug.'">'.sprintf( __("Tweet posts in checked %s", 'wp-tweets-pro'), strtolower( $name ) ).'</label>
					</p>';
				$input .= "
				<ul class='wpt-terms'>\n";
					$class = '';
					if ( !empty( $terms ) ) {
						foreach ( $terms as $term ) {
							if ( is_array( $term_filters ) ) {
								$filter = ( isset( $term_filters[$slug] ) ) ? $term_filters[$slug] : array();
								if ( in_array( $term->term_id, $filter ) ) {
									$selected = " checked=\"checked\"";
									$class = ( $checked ) ? 'tweet' : 'notweet';
								} else {
									$selected = "";
									$class = 'unchecked';
								}
							}
							$input .= '		<li class="'.$class.'"><input'.$selected.' type="checkbox" name="wpt_terms['.$slug.'][]" value="'.$term->term_id.'" id="'.$term->slug.'" /> <label for="'.$term->slug.'">'.$term->name."</label></li>\n";
						}
					} else {
						$input .= __( 'No terms in this taxonomy.', 'wp-tweets-pro' );
					}
				$input .= "	</ul>
				</fieldset>";
				echo $input;
			}
		}
	} else {
		_e( 'No taxonomies found.','wp-tweets-pro' );
	}
}

add_action('init', 'wpt_check_for_upgrades');
function wpt_check_for_upgrades() {
	global $wptp_version;
	$hash = get_option( 'wpt_license_key' );
	if ( !$hash ) { return; }
	if ( !class_exists('jd_auto_update') ) {
		require_once ('updates/plugin-update-checker.php');
	}
    $wpt_plugin_current_version = $wptp_version;
    $wpt_plugin_remote_path = "https://www.joedolson.com/wp-content/plugins/files/updates-v2.php?key=$hash";
    $wpt_plugin_slug = plugin_basename( __FILE__ );
    new jd_auto_update ($wpt_plugin_current_version, $wpt_plugin_remote_path, $wpt_plugin_slug);
}