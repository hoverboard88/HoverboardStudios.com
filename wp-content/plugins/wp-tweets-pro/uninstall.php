<?php
if ( !defined( 'ABSPATH' ) && !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
exit();
} else {
delete_option( 'wpt_delay_tweets' );
delete_option( 'wpt_retweet_after' );
delete_option( 'wpt_retweet_repeat' );
delete_option( 'wpt_prepend_rt' );
delete_option( 'wpt_filter_title' );
delete_option( 'wpt_prepend_rt2' );
delete_option( 'wpt_filter_post' );
delete_option( 'wpt_license_key' );
delete_option( 'wpt_license_valid' );
delete_option( 'wpt_cotweet' );
delete_option( 'wpt_prepend' );
delete_option( 'wpt_authorized_users' );
delete_option( 'wpt_blackout' );
}