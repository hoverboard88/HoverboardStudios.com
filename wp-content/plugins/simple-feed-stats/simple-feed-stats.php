<?php
/*
	Plugin Name: Simple Feed Stats
	Plugin URI: https://perishablepress.com/simple-feed-stats/
	Description: Tracks your feeds, adds custom content, and displays your feed statistics on your site.
	Tags: atom, comments, count, feed, feedburner, feeds, posts, rdf, rss, stats, statistics, subscribers, tracking
	Author: Jeff Starr
	Author URI: https://plugin-planet.com/
	Donate link: http://m0n.co/donate
	Contributors: specialk
	Requires at least: 4.1
	Tested up to: 4.7
	Stable tag: 20161118
	Version: 20161118
	Text Domain: simple-feed-stats
	Domain Path: /languages
	License: GPL v2 or later
*/

if (!defined('ABSPATH')) die();

$sfs_wp_vers = '4.1';
$sfs_version = '20161118';
$sfs_options = get_option('sfs_options');

// i18n
function sfs_i18n_init() {
	load_plugin_textdomain('simple-feed-stats', false, dirname(plugin_basename(__FILE__)) .'/languages/');
}
add_action('plugins_loaded', 'sfs_i18n_init');

// cache-busting
function sfs_randomizer() {
	$sfs_randomizer = rand(1000000, 9999999);
	return $sfs_randomizer;
}
$sfs_rand = sfs_randomizer();
global $sfs_rand;

// require minimum version
function sfs_require_wp_version() {
	global $wp_version, $sfs_wp_vers;
	$plugin = plugin_basename(__FILE__);
	$plugin_data = get_plugin_data(__FILE__, false);
	
	if (version_compare($wp_version, $sfs_wp_vers, '<')) {
		if (is_plugin_active($plugin)) {
			deactivate_plugins($plugin);
			$msg  = '<p><strong>'. $plugin_data['Name'] .'</strong> '. esc_html__('requires WordPress ', 'simple-feed-stats') . $sfs_wp_vers . esc_html__(' or higher, and has been deactivated! ', 'simple-feed-stats');
			$msg .= esc_html__('Please upgrade WordPress and try again. Return to the', 'simple-feed-stats') .' <a href="'. get_admin_url() .'update-core.php">'. esc_html__('WordPress Admin area', 'simple-feed-stats') .'</a>.</p>';
			wp_die($msg);
		}
	}
}
if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
	add_action('admin_init', 'sfs_require_wp_version');
}

// create stats table
function sfs_create_table() {
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'simple_feed_stats';
	$check_table = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
	
	if ($check_table != $table_name) {
		$sql =  "CREATE TABLE " . $table_name . " (
			`id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
			`logtime`  varchar(200) NOT NULL default '',
			`request`  varchar(200) NOT NULL default '',
			`referer`  varchar(200) NOT NULL default '',
			`type`     varchar(200) NOT NULL default '',
			`qstring`  varchar(200) NOT NULL default '',
			`address`  varchar(200) NOT NULL default '',
			`tracking` varchar(200) NOT NULL default '',
			`agent`    varchar(200) NOT NULL default '',
			PRIMARY KEY (`id`),
			cur_timestamp TIMESTAMP
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		if (isset($sql)) dbDelta($sql);
		
		if (!isset($wpdb->feed_stats)) {
			$wpdb->feed_stats = $table_name; 
			$wpdb->tables[] = str_replace($wpdb->prefix, '', $table_name); 
		}
	}
}
if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
	add_action('init', 'sfs_create_table');
}

// enable shortcodes in widgets and post content
if (isset($sfs_options['sfs_enable_shortcodes']) && $sfs_options['sfs_enable_shortcodes']) {
	add_filter('the_content', 'do_shortcode', 10);
	add_filter('widget_text', 'do_shortcode', 10); 
}

// string cleaner
function sfs_clean($string) {
	$string = trim($string); 
	$string = strip_tags($string);
	$string = htmlspecialchars($string, ENT_QUOTES, get_option('blog_charset', 'UTF-8'));
	$string = str_replace("\n", "", $string);
	$string = trim($string); 
	return $string;
}



/*
	Default Tracking
	tracks all feed requests
*/
function simple_feed_stats() {
	global $wpdb, $sfs_options;
	if (($sfs_options['sfs_tracking_method'] == 'sfs_default_tracking') && (is_feed())) {
		
		$protocol = 'http://';
		if (is_ssl()) $protocol = 'https://';
		
		$host = 'n/a'; $request = 'n/a'; $referer = 'n/a'; $qstring = 'n/a'; $address = 'n/a'; $agent = 'n/a';

		if (isset($_SERVER['HTTP_HOST']))       $host    = sfs_clean($_SERVER['HTTP_HOST']);
		if (isset($_SERVER['REQUEST_URI']))     $request = sfs_clean($protocol.$host.$_SERVER['REQUEST_URI']);
		if (isset($_SERVER['HTTP_REFERER']))    $referer = sfs_clean($_SERVER['HTTP_REFERER']);
		if (isset($_SERVER['QUERY_STRING']))    $qstring = sfs_clean($_SERVER['QUERY_STRING']);
		if (isset($_SERVER['REMOTE_ADDR']))     $address = sfs_clean($_SERVER['REMOTE_ADDR']);
		if (isset($_SERVER['HTTP_USER_AGENT'])) $agent   = sfs_clean($_SERVER['HTTP_USER_AGENT']);

		$date_format = get_option('date_format');
		$time_format = get_option('time_format');
		$logtime = date("{$date_format} {$time_format}", current_time('timestamp'));
		
		$feed_rdf       = get_bloginfo('rdf_url');           // RDF feed
		$feed_rss2      = get_bloginfo('rss2_url');          // RSS feed
		$feed_atom      = get_bloginfo('atom_url');          // Atom feed
		$feed_coms      = get_bloginfo('comments_rss2_url'); // RSS2 comments
		$feed_coms_atom = get_bloginfo('comments_atom_url'); // Atom comments

		$wp_feeds = array($feed_rdf, $feed_rss2, $feed_atom, $feed_coms, $feed_coms_atom);

		if     ($request == $feed_rdf)       $type = 'RDF';
		elseif ($request == $feed_rss2)      $type = 'RSS2';
		elseif ($request == $feed_atom)      $type = 'Atom';
		elseif ($request == $feed_coms)      $type = 'Comments';
		elseif ($request == $feed_coms_atom) $type = 'Comments';
		else                                 $type = 'Other';

		$tracking = 'default';
		
		if (in_array($request, $wp_feeds)) {
			$table = $wpdb->prefix . 'simple_feed_stats';
			$wpdb->insert($table, array(
				'logtime'  => $logtime, 
				'request'  => $request, 
				'referer'  => $referer, 
				'type'     => $type, 
				'qstring'  => $qstring, 
				'address'  => $address, 
				'tracking' => $tracking, 
				'agent'    => $agent, 
			));
		}
	}
}
add_action('wp', 'simple_feed_stats');



/*
	Custom Tracking
	Tracks via embedded post image (excludes Atom comments feed)
	Recommended if redirecting your feed to FeedBurner using full-text feeds (use "Open Tracking" for FeedBurner summary feeds)
*/
function sfs_feed_tracking($content) {
	
	global $wp_query, $sfs_options, $sfs_rand;
	
	if (is_feed()) {
		
		$feed_type = get_query_var('feed');
		$custom    = sfs_custom_parameter();
		$string    = array('sfs_tracking' => 'true', 'feed_type' => $feed_type, 'v' => $sfs_rand, $custom[0] => $custom[1]);
		$url       = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($string));
		
		if (is_comment_feed() && $feed_type == 'rss2') $feed_type = 'comments';
		
		if (($wp_query->current_post == 0) || ($wp_query->current_comment == 0)) {
			
			return '<img src="'. $url .'" width="1" height="1" alt=""> '. $content;
			
		}
		
	}
	
	return $content;
	
}
function sfs_custom_parameter() {
	global $sfs_options;
	$custom_key = '';
	$custom_value = '';
	if (!empty($sfs_options['sfs_custom_key']) && !empty($sfs_options['sfs_custom_value'])) {
		$custom_key = $sfs_options['sfs_custom_key'];
		$custom_value = $sfs_options['sfs_custom_value'];
	}
	return array($custom_key, $custom_value);
}
if ($sfs_options['sfs_tracking_method'] == 'sfs_custom_tracking') {
	add_filter('the_content', 'sfs_feed_tracking');
	add_filter('the_excerpt', 'sfs_feed_tracking');
	add_filter('comment_text_rss', 'sfs_feed_tracking'); 
	// ^ no equivalent for atom comment feeds (e.g., comment_text_atom)
}



/*
	Alt Tracking
	Tracks via embedded feed image
	Experimental tracking method
*/
function sfs_alt_tracking_rdf() {
	global $sfs_options, $sfs_rand; 
	$custom = sfs_custom_parameter(); 
	$string = array('sfs_tracking' => 'true', 'feed_type' => 'rdf', 'v' => $sfs_rand, $custom[0] => $custom[1]); 
	$url = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($string, '', '&amp;')); ?>

	<image rdf:resource="<?php echo $url; ?>">
		<title><?php bloginfo_rss('name'); ?></title>
		<url><?php echo $url; ?></url>
		<link><?php bloginfo_rss('url'); ?></link>
		<description><?php bloginfo('description'); ?></description>
	</image>
<?php }

function sfs_alt_tracking_rss() {
	global $sfs_options, $sfs_rand; 
	$custom = sfs_custom_parameter(); 
	$string = array('sfs_tracking' => 'true', 'feed_type' => 'rss2', 'v' => $sfs_rand, $custom[0] => $custom[1]); 
	$url = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($string, '', '&amp;')); ?>

	<image>
		<title><?php bloginfo_rss('name'); ?></title>
		<url><?php echo $url; ?></url>
		<link><?php bloginfo_rss('url'); ?></link>
		<width>1</width><height>1</height>
		<description><?php bloginfo('description'); ?></description>
	</image>
<?php }

function sfs_alt_tracking_atom() {
	global $sfs_options, $sfs_rand; 
	$custom = sfs_custom_parameter(); 
	$string = array('sfs_tracking' => 'true', 'feed_type' => 'atom', 'v' => $sfs_rand, $custom[0] => $custom[1]); 
	$url = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($string, '', '&amp;')); ?>

	<icon><?php echo $url; ?></icon>
<?php }

function sfs_alt_tracking_comments_rss() {
	global $sfs_options, $sfs_rand; 
	$custom = sfs_custom_parameter(); 
	$string = array('sfs_tracking' => 'true', 'feed_type' => 'comments', 'v' => $sfs_rand, $custom[0] => $custom[1]); 
	$url = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($string, '', '&amp;')); ?>

	<image>
		<title><?php esc_html_e('Comments for ', 'simple-feed-stats') . bloginfo_rss('name'); ?></title>
		<url><?php echo $url; ?></url>
		<link><?php bloginfo_rss('url'); ?></link>
		<width>1</width><height>1</height>
		<description><?php bloginfo('description'); ?></description>
	</image>
<?php }

function sfs_alt_tracking_comments_atom() {
	global $sfs_options, $sfs_rand; 
	$custom = sfs_custom_parameter(); 
	$string = array('sfs_tracking' => 'true', 'feed_type' => 'comments', 'v' => $sfs_rand, $custom[0] => $custom[1]); 
	$url = plugins_url('/simple-feed-stats/tracker.php?'. http_build_query($string, '', '&amp;')); ?>

	<icon><?php echo $url; ?></icon>
<?php }

if ($sfs_options['sfs_tracking_method'] == 'sfs_alt_tracking') {
	add_action('rdf_header', 'sfs_alt_tracking_rdf');
	add_action('rss2_head', 'sfs_alt_tracking_rss');
	add_action('atom_head', 'sfs_alt_tracking_atom');
	add_action('commentsrss2_head', 'sfs_alt_tracking_comments_rss');
	add_action('comments_atom_head', 'sfs_alt_tracking_comments_atom'); 
	// ^ comments_atom_head doesn't seem to work = bug?
}



// display settings link on plugin page
function sfs_plugin_action_links($links, $file) {
	if ($file == plugin_basename(__FILE__)) {
		$sfs_links = '<a href="'. get_admin_url() .'options-general.php?page=sfs-options">'. esc_html__('Settings', 'simple-feed-stats') .'</a>';
		array_unshift($links, $sfs_links);
	}
	return $links;
}
add_filter ('plugin_action_links', 'sfs_plugin_action_links', 10, 2);

// rate plugin link
function add_sfs_links($links, $file) {
	if ($file == plugin_basename(__FILE__)) {
		
		$href  = 'https://wordpress.org/support/plugin/simple-feed-stats/reviews/?rate=5#new-post';
		$title = esc_html__('Give us a 5-star rating at WordPress.org', 'simple-feed-stats');
		$text  = esc_html__('Rate this plugin', 'simple-feed-stats') .'&nbsp;&raquo;';
		
		$links[] = '<a target="_blank" href="'. $href .'" title="'. $title .'">'. $text .'</a>';
		
	}
	return $links;
}
add_filter('plugin_row_meta', 'add_sfs_links', 10, 2);

// delete plugin settings
function sfs_delete_options_on_deactivation() {
	delete_option('sfs_options');
}
if ($sfs_options['default_options'] == 1) {
	register_uninstall_hook (__FILE__, 'sfs_delete_options_on_deactivation');
}

// delete stats table
function sfs_delete_table_on_deactivation() {
	global $wpdb;
	$result = $wpdb->query("DROP TABLE " . $wpdb->prefix . "simple_feed_stats");
	sfs_delete_transients();
}
if ($sfs_options['sfs_delete_table'] == 1) {
	register_deactivation_hook(__FILE__, 'sfs_delete_table_on_deactivation');
}

// define default settings
function sfs_add_defaults() {
	$tmp = get_option('sfs_options');
	if (($tmp['default_options'] == '1') || (!is_array($tmp))) {
		$arr = array(
			'sfs_custom'              => '0', // string
			'sfs_custom_enable'       => 0,
			'sfs_number_results'      => '3',
			'sfs_tracking_method'     => 'sfs_default_tracking',
			'sfs_open_image_url'      => plugins_url('/simple-feed-stats/testing.gif'),
			'sfs_delete_table'        => 0,
			'default_options'         => 0,
			'sfs_feed_content_before' => '',
			'sfs_feed_content_after'  => '',
			'sfs_strict_stats'        => 0,
			'sfs_custom_key'          => 'custom_key',
			'sfs_custom_value'        => 'custom_value',
			'sfs_ignore_bots'         => 0,
			'sfs_enable_shortcodes'   => 0,
			'sfs_custom_styles'       => sfs_default_badge_styles(),
		);
		update_option('sfs_options', $arr);
		update_option('sfs_alert', 0);
	}
}
register_activation_hook (__FILE__, 'sfs_add_defaults');

// default badge styles
function sfs_default_badge_styles() {
	
	return '.sfs-subscriber-count, .sfs-count, .sfs-count span, .sfs-stats { -webkit-box-sizing: initial; -moz-box-sizing: initial; box-sizing: initial; }
.sfs-subscriber-count { width: 88px; overflow: hidden; height: 26px; color: #424242; font: 9px Verdana, Geneva, sans-serif; letter-spacing: 1px; }
.sfs-count { width: 86px; height: 17px; line-height: 17px; margin: 0 auto; background: #ccc; border: 1px solid #909090; border-top-color: #fff; border-left-color: #fff; }
.sfs-count span { display: inline-block; height: 11px; line-height: 12px; margin: 2px 1px 2px 2px; padding: 0 2px 0 3px; background: #e4e4e4; border: 1px solid #a2a2a2; border-bottom-color: #fff; border-right-color: #fff; }
.sfs-stats { font-size: 6px; line-height: 6px; margin: 1px 0 0 1px; word-spacing: 2px; text-align: center; text-transform: uppercase; }';
	
}

// define style options
$sfs_tracking_method = array(
	'sfs_disable_tracking' => array(
		'value' => 'sfs_disable_tracking',
		'label' => '<strong>'. esc_html__('Disable tracking', 'simple-feed-stats') .'</strong> &ndash; <em>'. esc_html__('disables all tracking', 'simple-feed-stats') .'</em> <span class="tooltip" title="'. esc_attr__('Note: no stats or data will be deleted.', 'simple-feed-stats') .'">?</span>',
	),
	'sfs_default_tracking' => array(
		'value' => 'sfs_default_tracking',
		'label' => '<strong>'. esc_html__('Default tracking', 'simple-feed-stats') .'</strong> &ndash; <em>'. esc_html__('tracks via feed requests', 'simple-feed-stats') .'</em> <span class="tooltip" title="'. esc_attr__('Recommended if serving your own feeds.', 'simple-feed-stats') .'">?</span>',
	),
	'sfs_custom_tracking' => array(
		'value' => 'sfs_custom_tracking',
		'label' => '<strong>'. esc_html__('Custom tracking', 'simple-feed-stats') . '</strong> &ndash; <em>'. esc_html__('tracks via embedded post image', 'simple-feed-stats') .'</em> <span class="tooltip" title="'. esc_attr__('Recommended if redirecting your feed to FeedBurner (using Full-text feeds only; use &ldquo;Open Tracking&rdquo; for FeedBurner Summary feeds).', 'simple-feed-stats') .'">?</span>'
	),
	'sfs_alt_tracking' => array(
		'value' => 'sfs_alt_tracking',
		'label' => '<strong>'. esc_html__('Alternate tracking', 'simple-feed-stats') .'</strong> &ndash; <em>'. esc_html__('tracks via embedded feed image', 'simple-feed-stats') .'</em> <span class="tooltip" title="'. esc_attr__('Experimental tracking method.', 'simple-feed-stats') .'">?</span>'
	),
	'sfs_open_tracking' => array(
		'value' => 'sfs_open_tracking',
		'label' => '<strong>'. esc_html__('Open tracking', 'simple-feed-stats') .'</strong> &ndash; <em>'. esc_html__('open tracking via image', 'simple-feed-stats') .'</em> <span class="tooltip" title="'. esc_attr__('Track any feed or web page by using the open-tracking URL as the', 'simple-feed-stats') .' <code>src</code> '. esc_attr__('for any', 'simple-feed-stats') .' <code>img</code> '. esc_attr__('tag. Tip: this is a good alternate method of tracking your FeedBurner feeds. Visit', 'simple-feed-stats') .' <code>m0n.co/a</code> '. esc_attr__('for details.', 'simple-feed-stats') .'">?</span>'
	),
);

// sanitize and validate input
function sfs_validate_options($input) {
	global $sfs_tracking_method;
	
	if (!isset($input['sfs_custom_enable'])) $input['sfs_custom_enable'] = null;
	$input['sfs_custom_enable'] = ($input['sfs_custom_enable'] == 1 ? 1 : 0);

	if (!isset($input['sfs_delete_table'])) $input['sfs_delete_table'] = null;
	$input['sfs_delete_table'] = ($input['sfs_delete_table'] == 1 ? 1 : 0);

	if (!isset($input['sfs_strict_stats'])) $input['sfs_strict_stats'] = null;
	$input['sfs_strict_stats'] = ($input['sfs_strict_stats'] == 1 ? 1 : 0);

	if (!isset($input['default_options'])) $input['default_options'] = null;
	$input['default_options'] = ($input['default_options'] == 1 ? 1 : 0);
	
	if (!isset($input['sfs_ignore_bots'])) $input['sfs_ignore_bots'] = null;
	$input['sfs_ignore_bots'] = ($input['sfs_ignore_bots'] == 1 ? 1 : 0);
	
	if (!isset($input['sfs_enable_shortcodes'])) $input['sfs_enable_shortcodes'] = null;
	$input['sfs_enable_shortcodes'] = ($input['sfs_enable_shortcodes'] == 1 ? 1 : 0);
	
	if (!isset($input['sfs_tracking_method'])) $input['sfs_tracking_method'] = null;
	if (!array_key_exists($input['sfs_tracking_method'], $sfs_tracking_method)) $input['sfs_tracking_method'] = null;

	$input['sfs_custom']         = wp_filter_nohtml_kses($input['sfs_custom']);
	$input['sfs_number_results'] = wp_filter_nohtml_kses($input['sfs_number_results']);
	$input['sfs_open_image_url'] = wp_filter_nohtml_kses($input['sfs_open_image_url']);
	$input['sfs_custom_key']     = wp_filter_nohtml_kses($input['sfs_custom_key']);
	$input['sfs_custom_value']   = wp_filter_nohtml_kses($input['sfs_custom_value']);
	
	$input['sfs_custom_styles']       = wp_kses_post($input['sfs_custom_styles']);
	$input['sfs_feed_content_before'] = wp_kses_post($input['sfs_feed_content_before']);
	$input['sfs_feed_content_after']  = wp_kses_post($input['sfs_feed_content_after']);

	return $input;
}

// whitelist settings
function sfs_init() {
	register_setting('sfs_plugin_options', 'sfs_options', 'sfs_validate_options');
}
add_action('admin_init', 'sfs_init');

// add the options page
function sfs_add_options_page() {
	add_options_page('Simple Feed Stats', 'Simple Feed Stats', 'manage_options', 'sfs-options', 'sfs_render_form');
}
add_action('admin_menu', 'sfs_add_options_page');

// add query-string variable @ http://www.addedbytes.com/code/querystring-functions/
function add_querystring_var($url, $key, $value) { 
	$url = preg_replace('/(.*)(\?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&'); 
	$url = substr($url, 0, -1);
	if (strpos($url, '?') === false) { 
		return ($url . '?' . $key . '=' . $value); 
	} else { 
		return ($url . '&' . $key . '=' . $value); 
	}
}

// shorten string & add ellipsis (by David Duong)
function sfs_truncate($string, $max = 50, $rep = '') {
    $leave = $max - strlen($rep);
    return substr_replace($string, $rep, $leave);
}

// display total stats template tag
function sfs_display_total_count() {
	global $sfs_options; 
	$all_count = get_transient('all_count');
	if ($all_count) echo $all_count;
	else echo '0';
}

// display daily stats template tag
function sfs_display_subscriber_count() {
	global $sfs_options;
	if ($sfs_options['sfs_custom_enable'] == 1) {
		echo $sfs_options['sfs_custom'];
	} else {
		$feed_count = get_transient('feed_count');	
		if ($feed_count) echo $feed_count;
		else echo '0';
	}
}

// display stats shortcode
function sfs_subscriber_count() { 
	global $sfs_options;
	if ($sfs_options['sfs_custom_enable'] == 1) {
		return $sfs_options['sfs_custom'];
	} else {
		$feed_count = get_transient('feed_count');	
		if ($feed_count) return $feed_count;
		else return '0';
	}
}
add_shortcode('sfs_subscriber_count','sfs_subscriber_count');

// display daily RSS2 stats shortcode
function sfs_rss2_count() { 
	global $sfs_options;
	$feed_count = get_transient('rss2_count');	
	if ($feed_count) return $feed_count;
	else return '0';
}
add_shortcode('sfs_rss2_count','sfs_rss2_count');

// display daily comment stats shortcode
function sfs_comments_count() {
	global $sfs_options;
	$feed_count = get_transient('comment_count');	
	if ($feed_count) return $feed_count;
	else return '0';
}
add_shortcode('sfs_comments_count','sfs_comments_count');

// feed count badge template tag
function sfs_display_count_badge() {
	
	echo sfs_count_badge();
	
}

// feed count badge shortcode
function sfs_count_badge() {
	global $sfs_options;
	
	if ($sfs_options['sfs_custom_enable']) {
		
		$count = isset($sfs_options['sfs_custom']) ? intval($sfs_options['sfs_custom']) : 0;
		
	} else {
		
		$count = (get_transient('feed_count')) ? intval(get_transient('feed_count')) : 0;
		
	}
	
	$text_1 = sprintf(_n('reader', 'readers', $count, 'simple-feed-stats'), $count);
	$text_2 = esc_html__('Simple Feed Stats', 'simple-feed-stats');
	
	$badge_prepend = '<div class="sfs-subscriber-count"><div class="sfs-count"><span>';
	$badge_append  = '</span> '. $text_1 .'</div><div class="sfs-stats">'. $text_2 .'</div></div>';
	
	$badge = $badge_prepend . sanitize_text_field($count) . $badge_append;
	
	return $badge;
	
}
add_shortcode('sfs_count_badge','sfs_count_badge');

// conditional css inclusion
function sfs_include_badge_styles() {
	global $sfs_options;
	$sfs_badge_styles = esc_textarea($sfs_options['sfs_custom_styles']);
	echo '<style type="text/css">' . "\n";
	echo $sfs_badge_styles . "\n";
	echo '</style>' . "\n";
}
if (!empty($sfs_options['sfs_custom_styles'])) {
	add_action('wp_head', 'sfs_include_badge_styles');
}

// custom footer content
function sfs_feed_content($content) {
	global $wp_query, $sfs_options;
	$custom_before = $sfs_options['sfs_feed_content_before'];
	$custom_after  = $sfs_options['sfs_feed_content_after'];
	if (is_feed()) return $custom_before . $content . $custom_after;
	else return $content;
}
if ((!empty($sfs_options['sfs_feed_content_before'])) || (!empty($sfs_options['sfs_feed_content_after']))) {
	add_filter('the_content', 'sfs_feed_content');
	add_filter('the_excerpt', 'sfs_feed_content');
}



// cron three minute interval
function sfs_cron_three_minutes($schedules) {
	$schedules['three_minutes'] = array('interval' => 180, 'display' => esc_html__('Three minutes'));
	return $schedules;
}
add_filter('cron_schedules', 'sfs_cron_three_minutes');

// cron for caching counts
function sfs_cron_activation() {
	if (!wp_next_scheduled('sfs_cron_cache')) {
		wp_schedule_event(time(), 'twicedaily', 'sfs_cron_cache'); // eg: hourly, daily, twicedaily (SFS default), three_minutes
	}
}
register_activation_hook(__FILE__, 'sfs_cron_activation');

// cleanup cron on deactivate
function sfs_cron_cleanup() {
	$timestamp = wp_next_scheduled('sfs_cron_cache');
	wp_unschedule_event($timestamp,'sfs_cron_cache');
}
register_deactivation_hook(__FILE__, 'sfs_cron_cleanup');

// cache feed counts
function sfs_cache_data() {
	global $wpdb, $sfs_options;
	
	$all_stats     = '0';
	$current_stats = '0';
	$rss2_stats    = '0';
	$comment_stats = '0';
	
	$count = ($sfs_options['sfs_strict_stats']) ? 'COUNT(DISTINCT address)' : 'COUNT(*)';
	
	$table_name  = $wpdb->prefix . 'simple_feed_stats';
	$check_table = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
	
	if ($check_table == $table_name) {
		
		// all-time stats
		$all_stats = $wpdb->get_row("SELECT " . $count . " FROM " . $table_name, ARRAY_A);
		if (is_array($all_stats)) $all_stats = $all_stats[$count];
		
		// daily stats
		$current_stats = $wpdb->get_row("SELECT " . $count . " FROM " . $table_name . " WHERE cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()", ARRAY_A); // AND TYPE != 'Comments'
		if (is_array($current_stats)) $current_stats = $current_stats[$count];
		
		// daily RSS2 stats
		$rss2_stats = $wpdb->get_row("SELECT " . $count . " FROM " . $table_name . " WHERE type='RSS2' AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()", ARRAY_A);
		if (is_array($rss2_stats)) $rss2_stats = $rss2_stats[$count];
		
		// daily comment stats
		$comment_stats = $wpdb->get_row("SELECT " . $count . " FROM " . $table_name . " WHERE type='Comments' AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()", ARRAY_A);
		if (is_array($comment_stats)) $comment_stats = $comment_stats[$count];
		
		set_transient('feed_count', $current_stats, 60*60*24); // 12 hour cache 60*60*12 , 24 hour cache = 60*60*24
		$feed_count = get_transient('feed_count');
		
		set_transient('all_count', $all_stats, 60*60*24); // 12 hour cache 60*60*12 , 24 hour cache = 60*60*24
		$all_count = get_transient('all_count');
		
		set_transient('rss2_count', $rss2_stats, 60*60*24); // 12 hour cache 60*60*12 , 24 hour cache = 60*60*24
		$rss2_count = get_transient('rss2_count');
		
		set_transient('comment_count', $comment_stats, 60*60*24); // 12 hour cache 60*60*12 , 24 hour cache = 60*60*24
		$comment_count = get_transient('comment_count');
		
	}
	
}
add_action('sfs_cron_cache', 'sfs_cache_data');



// delete transients
function sfs_delete_transients() {
	
	if (is_multisite()) {
		delete_site_transient('feed_count');
		delete_site_transient('all_count');
		delete_site_transient('rss2_count');
		delete_site_transient('comments_count');
		
		delete_site_transient('_transient_timeout_all_count');
		delete_site_transient('_transient_timeout_feed_count');
		delete_site_transient('_transient_timeout_rss2_count');
		delete_site_transient('_transient_timeout_comment_count');
	} else {
		delete_transient('feed_count');
		delete_transient('all_count');
		delete_transient('rss2_count');
		delete_transient('comments_count');
		
		delete_transient('_transient_timeout_all_count');
		delete_transient('_transient_timeout_feed_count');
		delete_transient('_transient_timeout_rss2_count');
		delete_transient('_transient_timeout_comment_count');
	}
}

// clear cache
function sfs_clear_cache() {
	if (isset($_GET['cache']) && $_GET['cache'] === 'clear') {
		if (current_user_can('administrator')) {
			
			sfs_delete_transients();
			sfs_cache_data();
			
			update_option('sfs_alert', 0, 0);
		}
	}
}
add_action('init', 'sfs_clear_cache');

// reset stats
function sfs_reset_stats() {
	global $wpdb;
	if ((isset($_GET['reset'])) && ($_GET['reset'] === 'true')) {
		if (current_user_can('administrator')) {
			
			$truncate = $wpdb->query("TRUNCATE " . $wpdb->prefix . "simple_feed_stats");
			sfs_delete_transients();
			sfs_cache_data();
			
			update_option('sfs_alert', 0, 0);
		}
	}
}
add_action('init', 'sfs_reset_stats');



// sfs dashboard widget 
function sfs_dashboard_widget() { 
	$sfs_query_current = sfs_query_database('current_stats'); ?>

	<style type="text/css">
		.sfs-table table { border-collapse: collapse; }
		.sfs-table th { font-size: 12px; }
		.sfs-table td { 
			display: table-cell; vertical-align: middle; padding: 10px; color: #555; border: 1px solid #dfdfdf;
			text-align: left; text-shadow: 1px 1px 1px #fff; font: bold 18px/18px Georgia, serif; 
			}
			.sfs-table .rdf      { background-color: #d9e8f9; }
			.sfs-table .rss2     { background-color: #d5f2d5; }
			.sfs-table .atom     { background-color: #fafac0; }
			.sfs-table .comments { background-color: #fee6cc; }
	</style>
	<p><?php esc_html_e('Current Subscriber Count', 'simple-feed-stats'); ?>: <strong><?php sfs_display_subscriber_count(); ?></strong></p>
	<div class="sfs-table">
		<table class="widefat">
			<thead>
				<tr>
					<th><?php esc_html_e('RDF',      'simple-feed-stats'); ?></th>
					<th><?php esc_html_e('RSS2',     'simple-feed-stats'); ?></th>
					<th><?php esc_html_e('Atom',     'simple-feed-stats'); ?></th>
					<th><?php esc_html_e('Comments', 'simple-feed-stats'); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="rdf"><?php      echo $sfs_query_current[0]; ?></td>
					<td class="rss2"><?php     echo $sfs_query_current[1]; ?></td>
					<td class="atom"><?php     echo $sfs_query_current[2]; ?></td>
					<td class="comments"><?php echo $sfs_query_current[3]; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<p><a href="<?php get_admin_url(); ?>options-general.php?page=sfs-options"><?php esc_html_e('More stats, tools, and options &raquo;', 'simple-feed-stats'); ?></a></p>

<?php }
function add_custom_dashboard_widget() {
	wp_add_dashboard_widget('sfs_dashboard_widget', 'Simple Feed Stats', 'sfs_dashboard_widget');
}
add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');

// query database for stats
function sfs_query_database($sfs_query_type) {
	global $wpdb, $sfs_options;

	if ($sfs_options['sfs_strict_stats']) $count = 'COUNT(DISTINCT address)';
	else $count = 'COUNT(*)';

	if ($sfs_query_type == 'current_stats') {
		
		$count_recent_rdf = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE type='RDF' AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()", ARRAY_A);
		if (is_array($count_recent_rdf)) $count_recent_rdf = $count_recent_rdf[$count];
		else $count_recent_rdf = '0';
		
		$count_recent_rss2 = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE type='RSS2' AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()", ARRAY_A);
		if (is_array($count_recent_rss2)) $count_recent_rss2 = $count_recent_rss2[$count];
		else $count_recent_rss2 = '0';
		
		$count_recent_atom = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE type='Atom' AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()", ARRAY_A);
		if (is_array($count_recent_atom)) $count_recent_atom = $count_recent_atom[$count];
		else $count_recent_atom = '0';
		
		$count_recent_comments = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE type='Comments' AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()", ARRAY_A);
		if (is_array($count_recent_comments)) $count_recent_comments = $count_recent_comments[$count];
		else $count_recent_comments = '0';
		
		$count_recent_open = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE tracking='open' AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()", ARRAY_A);
		if (is_array($count_recent_open)) $count_recent_open = $count_recent_open[$count];
		else $count_recent_open = '0';
		
		$count_recent_other = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE type='other' AND cur_timestamp BETWEEN TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND NOW()", ARRAY_A);
		if (is_array($count_recent_other)) $count_recent_other = $count_recent_other[$count];
		else $count_recent_other = '0';
		
		$sfs_query_current = array($count_recent_rdf, $count_recent_rss2, $count_recent_atom, $count_recent_comments, $count_recent_open, $count_recent_other);
		return $sfs_query_current;
		
	} elseif ($sfs_query_type == 'alltime_stats') {
		
		$count_rdf = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE type='RDF'", ARRAY_A);
		if (is_array($count_rdf)) $count_rdf = $count_rdf[$count];
		else $count_rdf = '0';
		
		$count_rss2 = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE type='RSS2'", ARRAY_A);
		if (is_array($count_rss2)) $count_rss2 = $count_rss2[$count];
		else $count_rss2 = '0';
		
		$count_atom = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE type='Atom'", ARRAY_A);
		if (is_array($count_atom)) $count_atom = $count_atom[$count];
		else $count_atom = '0';
		
		$count_comments = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE type='Comments'", ARRAY_A);
		if (is_array($count_comments)) $count_comments = $count_comments[$count];
		else $count_comments = '0';
		
		$count_open = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE tracking='open'", ARRAY_A);
		if (is_array($count_open)) $count_open = $count_open[$count];
		else $count_open = '0';
		
		$count_other = $wpdb->get_row("SELECT " . $count . " FROM " . $wpdb->prefix . "simple_feed_stats WHERE type='other'", ARRAY_A);
		if (is_array($count_other)) $count_other = $count_other[$count];
		else $count_other = '0';
		
		$sfs_query_alltime = array($count_rdf, $count_rss2, $count_atom, $count_comments, $count_open, $count_other);
		return $sfs_query_alltime;
	}
}

// dismiss plugin notice
function sfs_dismiss_notice() {
	if (isset($_GET['sfs-alert']) && wp_verify_nonce($_GET['sfs-alert'], 'sfs-alert')) {
		if (isset($_GET['sfs_alert']) && $_GET['sfs_alert'] == '1') update_option('sfs_alert', 1);
	}
}
add_action('admin_init', 'sfs_dismiss_notice');

// create the options page
function sfs_render_form() {
	global $wpdb, $sfs_options, $sfs_tracking_method, $sfs_version;
	
	$sfs_query_current = sfs_query_database('current_stats'); 
	$sfs_query_alltime = sfs_query_database('alltime_stats'); 
	$numresults = $sfs_options['sfs_number_results'];
	
	if (isset($_GET["p"])) $pagevar = (is_numeric($_GET["p"]) ? $_GET["p"] : 1);
	else $pagevar = '1';	

	$offset = ($pagevar-1) * $numresults;
	
	$numrows = $wpdb->get_row("SELECT COUNT(*) FROM " . $wpdb->prefix . "simple_feed_stats", ARRAY_A);
	if (is_array($numrows)) $numrows = $numrows['COUNT(*)'];
	else $numrows = 'undefined';
	$maxpage = ceil($numrows/$numresults);
	
	if ((isset($_GET['filter'])) && (!empty($_GET['filter']))) {
		$sql = '';
		$filter = sfs_clean($_GET['filter']);
		if ($filter === 'logtime' || $filter === 'type' || $filter === 'address' || $filter === 'agent' || $filter === 'tracking' || $filter === 'referer') {    
			$sql = $wpdb->get_results($wpdb->prepare("SELECT * FROM ". $wpdb->prefix ."simple_feed_stats ORDER BY $filter ASC LIMIT %d, %d", $offset, $numresults)); // bug? can't use %s for $filter
		}
	} else {
		$sql = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."simple_feed_stats ORDER BY id DESC LIMIT %d, %d", $offset, $numresults));
	} ?>

	<style type="text/css">
		.sfs-admin h1 small { font-size: 60%; color: #777; }
		.js .sfs-admin .postbox h2 { margin: 0; padding: 12px 0 12px 15px; font-size: 16px; cursor: pointer; }
		
		.dismiss-alert { margin: 15px 0 0 0; }
		.dismiss-alert-wrap { display: inline-block; padding: 7px 0 10px 0; }
		.dismiss-alert .description { display: inline-block; margin: -2px 15px 0 0; }
		
		.toggle { padding: 0 15px 15px 15px; }
		.toggle.sfs-overview {
			padding: 0 15px 20px 130px;
			background-image: url(<?php echo plugins_url('/simple-feed-stats/sfs-logo.jpg'); ?>); 
			background-repeat: no-repeat; background-position: 0 0; background-size: 120px 131px;
			}
		.toggle.sfs-overview p { margin: 0; }
		
		.sfs-menu-item { float: left; margin: 12px 12px 12px 0; }
		.sfs-sub-item { display: inline-block; }
		.sfs-menu-row { margin: 12px 0 0 0; }
		
		.sfs-admin h3 { margin: 20px 0; font-size: 14px; }
		.sfs-admin ul { margin: 15px 15px 15px 40px; clear: both; }
		.sfs-admin li { margin: 8px 0; list-style-type: disc; }
		
		.sfs-table table { border-collapse: collapse; }
		.sfs-table th { font-size: 13px; }
		.sfs-table td { padding: 5px 10px; color: #555; border: 1px solid #dfdfdf; font: 12px/18px 'Proxima Nova Regular', 'Helvetica Neue', Helvetica, Arial, sans-serif; }
		.sfs-table .form-table td { padding: 10px; border: none; }
		.sfs-table .form-table th { padding: 10px 10px 10px 0; }
		.sfs-open-tracking-url, .sfs-open-tracking-image { background-color: #efefef; }
		
		.rdf      { background-color: #d9e8f9; }
		.rss2     { background-color: #d5f2d5; }
		.atom     { background-color: #fafac0; }
		.comments { background-color: #fee6cc; }
		.open     { background-color: #ffe3e3; }
		.other    { background-color: #efefef; }
		
		.sfs-statistics div { margin: 5px; }
		.sfs-statistics .sfs-type { padding: 0 12px; text-align: center; }
		.sfs-table .sfs-type { display: table-cell; vertical-align: middle; padding: 12px; text-align: left; text-shadow: 1px 1px 1px #fff; font: bold 20px/20px Georgia, serif; }
		.sfs-meta, .sfs-details { font-size: 12px; }
		.sfs-meta div { margin: 3px 5px; }
		.sfs-stats-type { font-size: 12px; font-weight: bold; }
		.sfs-stats-type span { color: #777; font-size: 11px; font-weight: normal; }
		
		.sfs-radio { margin: 5px 0; }
		.sfs-table-item { margin: 0 0 10px 0; }
		.sfs-admin textarea.code, .sfs-table input[type="text"] { padding: 6px; color: #777; font-size: 12px; }
		.sfs-last-item { margin: 24px 0 0 0; }
		
		.tooltip { 
			cursor: help; display: inline-block; width: 18px; height: 18px; margin: 0 0 0 4px; text-align: center; font: bold 12px/18px Georgia, serif;
			border: 2px solid #fff; color: #fff; background-color: #b0c6d0; -webkit-border-radius: 18px; -moz-border-radius: 18px; border-radius: 18px;
			-webkit-box-shadow: 0 0 1px rgba(0,0,0,0.3); -moz-box-shadow: 0 0 1px rgba(0,0,0,0.3); box-shadow: 0 0 1px rgba(0,0,0,0.3); 
			}
			.tooltip:hover { background-color: #0073aa; }
			
		#easyTooltip { 
			max-width: 310px; padding: 15px; font-size: 13px; line-height: 18px; border: 1px solid #96c2d5; background-color: #fdfdfd; 
			-webkit-box-shadow: 7px 7px 7px -1px rgba(0,0,0,0.3); -moz-box-shadow: 7px 7px 7px -1px rgba(0,0,0,0.3); box-shadow: 7px 7px 7px -1px rgba(0,0,0,0.3);
			}
			#easyTooltip code { padding: 2px 3px; line-height: 0; font-size: 90%; }
		
		.sfs-current { width: 100%; height: 250px; overflow: hidden; }
		.sfs-current iframe { width: 100%; height: 100%; overflow: hidden; margin: 0; padding: 0; }
		.sfs-credits { margin-top: -10px; font-size: 12px; line-height: 18px; color: #777; }
		
		<?php // $sfs_badge_styles = esc_textarea($sfs_options['sfs_custom_styles']); echo $sfs_badge_styles; ?>
		.sfs-subscriber-count { width: 88px; overflow: hidden; height: 26px; color: #424242; font: 9px Verdana, Geneva, sans-serif; letter-spacing: 1px; }
		.sfs-count { width: 86px; height: 17px; line-height: 17px; margin: 0 auto; background: #ccc; border: 1px solid #909090; border-top-color: #fff; border-left-color: #fff; }
		.sfs-count span { display: inline-block; height: 11px; line-height: 12px; margin: 2px 1px 2px 2px; padding: 0 2px 0 3px; background: #e4e4e4; border: 1px solid #a2a2a2; border-bottom-color: #fff; border-right-color: #fff; }
		.sfs-stats { font-size: 6px; line-height: 6px; margin: 1px 0 0 1px; word-spacing: 2px; text-align: center; text-transform: uppercase; }
	</style>

	<div class="wrap sfs-admin">
		<h1><?php esc_html_e('Simple Feed Stats', 'simple-feed-stats'); ?> <small><?php echo 'v'. $sfs_version; ?></small></h1>
		
		
		<?php if (isset($_GET['cache'])) : ?>
		<div class="notice notice-success is-dismissible"><p><strong><?php esc_html_e('Cache cleared', 'simple-feed-stats'); ?>.</strong></p></div>
		<?php endif; ?>
		
		<?php if (isset($_GET['reset'])) : ?>
		<div class="notice notice-success is-dismissible"><p><strong><?php esc_html_e('All feed stats deleted', 'simple-feed-stats'); ?>.</strong></p></div>
		<?php endif; ?>
		
		
		<div class="sfs-toggle-panels"><a href="<?php get_admin_url() . 'options-general.php?page=sfs-options'; ?>"><?php esc_html_e('Toggle all panels', 'simple-feed-stats'); ?></a></div>
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				
				<div class="postbox" style="display:<?php if (get_option('sfs_alert')) echo 'none'; else echo 'block'; ?>;">
					<h2><?php esc_html_e('Simple Feed Stats needs your support!', 'simple-feed-stats'); ?></h2>
					<div class="toggle">
						<div class="mm-panel-alert">
							<p>
								<?php esc_html_e('Please', 'simple-feed-stats'); ?> 
								<a target="_blank" href="http://m0n.co/donate" title="<?php esc_attr_e('Make a donation via PayPal', 'simple-feed-stats'); ?>"><?php esc_html_e('make a donation', 'simple-feed-stats'); ?></a> 
								<?php esc_html_e('and/or', 'simple-feed-stats'); ?> 
								<a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/<?php echo basename(dirname(__FILE__)); ?>?rate=5#postform" title="<?php esc_attr_e('THANK YOU for your support!', 'simple-feed-stats'); ?>"><?php esc_html_e('give it a 5-star rating', 'simple-feed-stats'); ?>&nbsp;&raquo;</a>
							</p>
							<p>
								<?php esc_html_e('Your generous support enables continued development of this free plugin. Thank you!', 'simple-feed-stats'); ?>
							</p>
							<div class="dismiss-alert">
								<form action="">
									<div class="dismiss-alert-wrap">
										<input class="input-alert" name="sfs_alert" type="checkbox" value="1" /> 
										<label class="description" for="sfs_alert"><?php esc_html_e('Check this box if you have shown support', 'simple-feed-stats') ?></label>
										<?php wp_nonce_field('sfs-alert', 'sfs-alert', false); ?>
										<input type="hidden" name="page" value="sfs-options" />
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				<div class="postbox">
					<h2><?php esc_html_e('Overview', 'simple-feed-stats'); ?></h2>
					<div class="toggle sfs-overview">
						<p>
							<?php esc_html_e('Simple Feed Stats tracks your feeds, adds custom content, and displays your feed statistics on your site.', 'simple-feed-stats'); ?> 
							<?php esc_html_e('SFS tracks your feeds automatically and displays the statistics on this page and via the Dashboard widget.', 'simple-feed-stats'); ?> 
						</p>
						<ul>
							<li><a class="sfs-options-link" href="#sfs_custom-options"><?php esc_html_e('Plugin Settings', 'simple-feed-stats'); ?></a></li>
							<li><a class="sfs-shortcodes-link" href="#sfs-shortcodes"><?php esc_html_e('Shortcodes &amp; Template Tags', 'simple-feed-stats'); ?></a></li>
							<li><a target="_blank" href="https://wordpress.org/plugins/simple-feed-stats/"><?php esc_html_e('Plugin Homepage', 'simple-feed-stats'); ?>&nbsp;&raquo;</a>
							</li>
						</ul>
						<p>
							<?php esc_html_e('If you like this plugin, please', 'simple-feed-stats'); ?> 
							<a target="_blank" href="https://wordpress.org/support/plugin/simple-feed-stats/reviews/?rate=5#new-post" title="<?php esc_attr_e('THANK YOU for your support!', 'simple-feed-stats'); ?>"><?php esc_html_e('give it a 5-star rating', 'simple-feed-stats'); ?>&nbsp;&raquo;</a>
						</p>
					</div>
				</div>
				
				
				
				<?php if ($maxpage != 0) : ?>

				<div class="postbox">
					<h2><?php esc_html_e('Daily Stats', 'simple-feed-stats'); ?>: <?php sfs_display_subscriber_count(); ?></h2>
					<div class="toggle default-hidden">
						<p>
							<strong><?php esc_html_e('Daily feed statistics', 'simple-feed-stats'); ?></strong> 
							<span class="tooltip" title="<?php 
								esc_attr_e('Count totals are cached and updated every 12 hours for better performance. ', 'simple-feed-stats');
								esc_attr_e('So the count total may not always equal the sum of the individual counts, which are reported in real-time. ', 'simple-feed-stats');
								esc_attr_e('Tip: to get the numbers to match up, you can manually clear the cache via the &ldquo;Plugin Settings&rdquo; panel.', 'simple-feed-stats');
								?>">?</span>
						</p>
						<div class="sfs-table">
							<table class="widefat">
								<thead>
									<tr>
										<th><?php esc_html_e('RDF',      'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('RSS2',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Atom',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Comments', 'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Open',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Other',    'simple-feed-stats'); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="sfs-type rdf"><?php      echo esc_attr($sfs_query_current[0]); ?></td>
										<td class="sfs-type rss2"><?php     echo esc_attr($sfs_query_current[1]); ?></td>
										<td class="sfs-type atom"><?php     echo esc_attr($sfs_query_current[2]); ?></td>
										<td class="sfs-type comments"><?php echo esc_attr($sfs_query_current[3]); ?></td>
										<td class="sfs-type open"><?php     echo esc_attr($sfs_query_current[4]); ?></td>
										<td class="sfs-type other"><?php    echo esc_attr($sfs_query_current[5]); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<?php endif; ?>
				
				
				
				<div class="postbox">
					<h2><?php esc_html_e('Total Stats', 'simple-feed-stats'); ?>: <?php sfs_display_total_count(); ?></h2>
					<div class="toggle default-hidden">
						<p>
							<strong><?php esc_html_e('Total feed statistics', 'simple-feed-stats'); ?></strong> 
							<span class="tooltip" title="<?php 
								esc_attr_e('Count totals are cached and updated every 12 hours for better performance. ', 'simple-feed-stats');
								esc_attr_e('So the count total may not always equal the sum of the individual counts, which are reported in real-time. ', 'simple-feed-stats');
								esc_attr_e('Tip: to get the numbers to match up, you can manually clear the cache via the &ldquo;Plugin Settings&rdquo; panel. ', 'simple-feed-stats');
								?>">?</span>
						</p>
						<div class="sfs-table">
							<table class="widefat">
								<thead>
									<tr>
										<th><?php esc_html_e('RDF',      'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('RSS2',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Atom',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Comments', 'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Open',     'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Other',    'simple-feed-stats'); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="sfs-type rdf"><?php      echo esc_attr($sfs_query_alltime[0]); ?></td>
										<td class="sfs-type rss2"><?php     echo esc_attr($sfs_query_alltime[1]); ?></td>
										<td class="sfs-type atom"><?php     echo esc_attr($sfs_query_alltime[2]); ?></td>
										<td class="sfs-type comments"><?php echo esc_attr($sfs_query_alltime[3]); ?></td>
										<td class="sfs-type open"><?php     echo esc_attr($sfs_query_alltime[4]); ?></td>
										<td class="sfs-type other"><?php    echo esc_attr($sfs_query_alltime[5]); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				
				
				<?php if ($maxpage != 0) : ?>
				
				<div class="postbox">
					<h2><?php esc_html_e('Subscriber Info', 'simple-feed-stats'); ?></h2>
					<div class="toggle<?php if (!isset($_GET['filter']) && !isset($_GET['p'])) echo ' default-hidden'; ?>">
	
						<?php if (isset($_GET['filter']) && !empty($_GET['filter'])) : ?>
						<div class="sfs-menu-row">
							<?php esc_html_e('Subscriber info filtered by', 'simple-feed-stats'); ?> <strong><?php echo sanitize_text_field($filter); ?></strong> 
							[ <a href="<?php echo get_admin_url(); ?>options-general.php?page=sfs-options"><?php esc_html_e('reset', 'simple-feed-stats'); ?></a> ]
						</div>
						<?php endif; ?>
						
						<div class="sfs-menu-item">
							<form class="sfs-sub-item" action="">
								<select name="filter">
									<option value="" selected="selected"><?php esc_html_e('Filter data by..', 'simple-feed-stats'); ?></option>
									<option value="logtime"><?php  esc_html_e('Log Time',   'simple-feed-stats'); ?></option>
									<option value="type"><?php     esc_html_e('Feed Type',  'simple-feed-stats'); ?></option>
									<option value="address"><?php  esc_html_e('IP Address', 'simple-feed-stats'); ?></option>
									<option value="agent"><?php    esc_html_e('User Agent', 'simple-feed-stats'); ?></option>
									<option value="tracking"><?php esc_html_e('Tracking',   'simple-feed-stats'); ?></option>
									<option value="referer"><?php  esc_html_e('Referrer',   'simple-feed-stats'); ?></option>
								</select>
								<input type="hidden" name="page" value="sfs-options" />
								<input class="button" type="submit" />
							</form>
						</div>
						<div class="sfs-menu-item">
							<form class="sfs-sub-item" action="">
								<select name="sfs-paging-menu" onchange="myF('parent', this, 0)">
									<?php $i = 1; while ($i <= $maxpage) {
											$url = get_admin_url() .'options-general.php'. add_querystring_var('?'. $_SERVER['QUERY_STRING'], 'p', $i);
											if ($pagevar == $i) echo '<option selected class="current" value="selected">'. esc_html__('Page ', 'simple-feed-stats') . $i .'</option>';
											else echo '<option value="'. esc_url($url) .'">'. esc_html__('Page ', 'simple-feed-stats') . $i .'</option>';
											$i++;
										} ?>
								</select>
							</form>
						</div>
						<div class="sfs-menu-item">
							<?php if($pagevar != 1) {
								$url = get_admin_url() .'options-general.php'. add_querystring_var('?'. $_SERVER['QUERY_STRING'], 'p', $pagevar - 1);
								echo '<a class="sfs-sub-item button" href="'. esc_url($url) .'">&laquo; '. esc_html__('Previous page', 'simple-feed-stats') .'</a> ';
							}
							if($pagevar != $maxpage) {
								$url = get_admin_url() .'options-general.php'. add_querystring_var('?'. $_SERVER['QUERY_STRING'], 'p', $pagevar + 1);
								echo '<a class="sfs-sub-item button" href="'. esc_url($url) .'">'. esc_html__('Next page', 'simple-feed-stats') .' &raquo;</a> ';
							} ?>
						</div>
						<div class="sfs-table sfs-statistics">
							<table class="widefat">
								<thead>
									<tr>
										<th><?php esc_html_e('ID',      'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Meta',    'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Details', 'simple-feed-stats'); ?></th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th><?php esc_html_e('ID',      'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Meta',    'simple-feed-stats'); ?></th>
										<th><?php esc_html_e('Details', 'simple-feed-stats'); ?></th>
									</tr>
								</tfoot>
								<tbody>
									<?php foreach($sql as $s) { ?>
									<tr>
										<td class="sfs-type <?php echo esc_attr(strtolower($s->type)); ?>"><?php echo sanitize_text_field($s->id); ?></td>
										<td class="sfs-meta">
											<div class="sfs-stats-type"><?php echo sanitize_text_field($s->type); ?></div>
											<div class="sfs-stats-tracking"><?php echo sanitize_text_field(ucfirst($s->tracking)) .'&nbsp;'. esc_html__('tracking', 'simple-feed-stats'); ?></div>
											<div class="sfs-stats-ip"><?php echo sanitize_text_field($s->address); ?></div>
											<div class="sfs-stats-time"><?php $logtime = preg_replace('/\s+/', '&nbsp;', $s->logtime); echo sanitize_text_field($logtime); ?></div>
										</td>
										<td class="sfs-details">
											<div class="sfs-stats-referrer"><strong><?php esc_html_e('Referrer',   'simple-feed-stats'); ?>:</strong> <?php echo sanitize_text_field($s->referer); ?></div>
											<div class="sfs-stats-request"><strong><?php  esc_html_e('Request',    'simple-feed-stats'); ?>:</strong> <?php echo sanitize_text_field($s->request); ?></div>
											<div class="sfs-stats-agent"><strong><?php    esc_html_e('User Agent', 'simple-feed-stats'); ?>:</strong> <?php echo sanitize_text_field($s->agent);   ?></div>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<?php endif; ?>
				
				
				
				<div id="sfs_custom-options" class="postbox">
					<h2><?php esc_html_e('Plugin Settings', 'simple-feed-stats'); ?></h2>
					<div class="toggle<?php if (!isset($_GET['cache']) && !isset($_GET['reset']) && !isset($_GET['settings-updated'])) echo ' default-hidden'; ?>">
						<form method="post" action="options.php">
							<?php settings_fields('sfs_plugin_options'); ?>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_tracking_method]"><?php esc_html_e('Tracking method', 'simple-feed-stats'); ?></label></th>
										<td>
											<?php if (!isset($checked)) $checked = '';
												foreach ($sfs_tracking_method as $option) {
													$radio_setting = $sfs_options['sfs_tracking_method'];
													if ('' != $radio_setting) {
														if ($sfs_options['sfs_tracking_method'] == $option['value']) {
															$checked = "checked=\"checked\"";
														} else {
															$checked = '';
														}
													} ?>
													<div class="sfs-radio">
														<input type="radio" name="sfs_options[sfs_tracking_method]" class="sfs-<?php if ($option['value'] == 'sfs_open_tracking') echo 'open-'; ?>tracking" value="<?php echo esc_attr($option['value']); ?>" <?php echo $checked; ?> /> 
														<?php echo $option['label']; ?>
													</div>
											<?php } ?>
										</td>
									</tr>
									<tr class="sfs-open-tracking-url<?php if ($sfs_options['sfs_tracking_method'] !== 'sfs_open_tracking') echo ' default-hidden'; ?>">
										<th scope="row"><label class="description"><?php esc_html_e('Open Tracking URL', 'simple-feed-stats'); ?></label></th>
										<td>
											<div class="sfs-table-item">
												<?php esc_html_e('For use with the &ldquo;Open Tracking&rdquo; method. Use this tracking URL as the', 'simple-feed-stats'); ?> 
												<code>src</code> <?php esc_html_e('for any', 'simple-feed-stats'); ?> <code>img</code>: 
											</div>
											<div class="sfs-table-item">
												<input class="sfs-code-input regular-text" type="text" value="<?php echo plugins_url('/simple-feed-stats/tracker.php?sfs_tracking=true&sfs_type=open'); ?>" />
											</div>
											<div class="sfs-table-item">
												<?php esc_html_e('Example code:', 'simple-feed-stats'); ?> 
											</div>
											<div class="sfs-table-item">
												<input class="sfs-code-input regular-text" type="text" value='&lt;img src="<?php echo plugins_url('/simple-feed-stats/tracker.php?sfs_tracking=true&sfs_type=open'); ?>" alt="" /&gt;' />
											</div>
										</td>
									</tr>
									<tr class="sfs-open-tracking-image<?php if ($sfs_options['sfs_tracking_method'] !== 'sfs_open_tracking') echo ' default-hidden'; ?>">
										<th scope="row"><label class="description" for="sfs_options[sfs_open_image_url]"><?php esc_html_e('Open Tracking Image', 'simple-feed-stats'); ?></label></th>
										<td>
											<div class="sfs-table-item">
												<?php esc_html_e('For use with the &ldquo;Open Tracking&rdquo; method. Here you may specify the URL for the tracking image:', 'simple-feed-stats'); ?> 
												<span class="tooltip" title="<?php esc_attr_e('Tip: this is the URL of the image that will be returned as the', 'simple-feed-stats'); ?> 
												<code>src</code> <?php esc_attr_e('for the open-tracking image.', 'simple-feed-stats'); ?>">?</span>
											</div>
											<div class="sfs-table-item">
												<input class="sfs-code-input regular-text" type="text" maxlength="200" name="sfs_options[sfs_open_image_url]" value="<?php echo esc_attr($sfs_options['sfs_open_image_url']); ?>" />
											</div>
											<div class="sfs-table-item">
												<?php esc_html_e('Current image being used for Open Tracking:', 'simple-feed-stats'); ?> 
												<img src="<?php echo esc_attr($sfs_options['sfs_open_image_url']); ?>" alt="" />
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_strict_stats]"><?php esc_html_e('Strict reporting', 'simple-feed-stats'); ?></label></th>
										<td><input name="sfs_options[sfs_strict_stats]" type="checkbox" value="1" <?php if (isset($sfs_options['sfs_strict_stats'])) checked($sfs_options['sfs_strict_stats']); ?> /> 
											<?php esc_html_e('Enable strict reporting of feed statistics', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('This will result in a more accurate reporting of feed stats;', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('however, if you have been using SFS for awhile, you may notice that the feed count is lower with this option enabled.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Tip: after changing this option, click the &ldquo;Clear the cache&rdquo; link below to reset the cache.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_ignore_bots]"><?php esc_html_e('Ignore bots', 'simple-feed-stats'); ?></label></th>
										<td><input name="sfs_options[sfs_ignore_bots]" type="checkbox" value="1" <?php if (isset($sfs_options['sfs_ignore_bots'])) checked($sfs_options['sfs_ignore_bots']); ?> /> 
											<?php esc_html_e('Ignore feed requests from the most common bots', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('This will result in a more accurate reporting of feed stats;', 'simple-feed-stats'); ?>  
											<?php esc_attr_e('however, if you have been using SFS for awhile, you may notice that the feed count is lower with this option enabled.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Tip: the bot list for this feature is located in', 'simple-feed-stats'); ?> <code>tracker.php</code> 
											<?php esc_attr_e('and may be filtered via the hook,', 'simple-feed-stats'); ?> <code>sfs_filter_bots</code>.">?</span>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_custom]"><?php esc_html_e('Custom count', 'simple-feed-stats'); ?></label></th>
										<td>
											<input type="text" size="20" maxlength="100" name="sfs_options[sfs_custom]" value="<?php echo esc_attr($sfs_options['sfs_custom']); ?>" /> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: use this feature for a day or so after resetting the feed stats (check the next box to enable).', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_custom_enable]"><?php esc_html_e('Enable custom count', 'simple-feed-stats'); ?></label></th>
										<td>
											<input name="sfs_options[sfs_custom_enable]" type="checkbox" value="1" <?php if (isset($sfs_options['sfs_custom_enable'])) checked($sfs_options['sfs_custom_enable']); ?> /> 
											<?php esc_html_e('Display your custom feed count instead of the recorded value', 'simple-feed-stats'); ?>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_custom_key]"><?php esc_html_e('Custom key/value', 'simple-feed-stats'); ?></label></th>
										<td>
											<div class="sfs-table-item">
												<input type="text" size="20" maxlength="100" name="sfs_options[sfs_custom_key]" value="<?php echo esc_attr($sfs_options['sfs_custom_key']); ?>" /> 
												<label class="description" for="sfs_options[sfs_custom_key]"><?php esc_html_e('Custom key', 'simple-feed-stats'); ?></label> 
												<span class="tooltip" title="<?php esc_attr_e('Add custom key/value parameter for either &ldquo;custom&rdquo; or &ldquo;alt&rdquo; tracking methods.', 'simple-feed-stats'); ?> 
												<?php esc_html_e('Important: include only alphanumeric characters, underscores, and hyphens. Leave blank to disable.', 'simple-feed-stats'); ?>">?</span>
												<br />
												<input type="text" size="20" maxlength="100" name="sfs_options[sfs_custom_value]" value="<?php echo esc_attr($sfs_options['sfs_custom_value']); ?>" /> 
												<label class="description" for="sfs_options[sfs_custom_value]"><?php esc_html_e('Custom value', 'simple-feed-stats'); ?></label> 
												<span class="tooltip" title="<?php esc_attr_e('Including a custom key/value in the tracking URL can be used with 3rd-party services such as Google Analytics.', 'simple-feed-stats'); ?> 
												<?php esc_html_e('This feature will be extended in future versions, send feedback with any requests.', 'simple-feed-stats'); ?>">?</span>
											</div>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_enable_shortcodes]"><?php esc_html_e('Enable Widget Shortcodes', 'simple-feed-stats'); ?></label></th>
										<td>
											<input name="sfs_options[sfs_enable_shortcodes]" type="checkbox" value="1" <?php if (isset($sfs_options['sfs_enable_shortcodes'])) checked($sfs_options['sfs_enable_shortcodes']); ?> /> 
											<?php esc_html_e('Enable shortcodes in widget areas and post content', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('By default, WordPress does not enable shortcodes in widgets.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('This setting enables shortcodes to work when they are added to widgets, and also ensures that shortcodes will work when they are added to post/page content.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Note: this setting applies to any/all shortcodes, even those of other plugins.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_number_results]"><?php esc_html_e('Number of results per page', 'simple-feed-stats'); ?></label></th>
										<td>
											<input type="number" min="1" max="999" name="sfs_options[sfs_number_results]" value="<?php echo esc_attr($sfs_options['sfs_number_results']); ?>" /> 
											<?php esc_html_e('Applies to &ldquo;Subscriber Info&rdquo; panel on this page', 'simple-feed-stats'); ?>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_custom_styles]"><?php esc_html_e('Custom CSS for count badge', 'simple-feed-stats'); ?></label></th>
										<td>
											<textarea class="large-text code" cols="50" rows="3" name="sfs_options[sfs_custom_styles]"><?php echo esc_textarea($sfs_options['sfs_custom_styles']); ?></textarea><br />
											<?php esc_html_e('CSS/text only, no markup', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: see the &ldquo;Shortcodes &amp; Template Tags&rdquo; panel for count-badge shortcode and template tag.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Default styles replicate the FeedBurner chicklet. Leave blank to disable.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_feed_content_before]"><?php esc_html_e('Display before each feed item', 'simple-feed-stats'); ?></label></th>
										<td>
											<textarea class="large-text code" cols="50" rows="3" name="sfs_options[sfs_feed_content_before]"><?php echo esc_textarea($sfs_options['sfs_feed_content_before']); ?></textarea><br />
											<?php esc_html_e('Text and basic markup allowed', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: you can has shortcodes. Leave blank to disable.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="sfs_options[sfs_feed_content_after]"><?php esc_html_e('Display after each feed item', 'simple-feed-stats'); ?></label></th>
										<td>
											<textarea class="large-text code" cols="50" rows="3" name="sfs_options[sfs_feed_content_after]"><?php echo esc_textarea($sfs_options['sfs_feed_content_after']); ?></textarea><br />
											<?php esc_html_e('Text and basic markup allowed', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: you can has shortcodes. Leave blank to disable.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-table">
								<table class="form-table">
									<tr>
										<th scope="row"><label class="description"><?php esc_html_e('Clear the cache', 'simple-feed-stats'); ?></label></th>
										<td>
											<strong><a href="<?php get_admin_url(); ?>options-general.php?page=sfs-options&amp;cache=clear"><?php esc_html_e('Clear cache', 'simple-feed-stats'); ?></a></strong> 
											<span class="tooltip" title="<?php esc_attr_e('Note: it&rsquo;s safe to clear the cache at any time. WordPress automatically will cache fresh data.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Tip: refresh this page to renew the cache after clearing.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description"><?php esc_html_e('Reset feed stats', 'simple-feed-stats'); ?></label></th>
										<td>
											<strong><a class="reset" href="<?php get_admin_url(); ?>options-general.php?page=sfs-options&amp;reset=true"><?php esc_html_e('Reset stats', 'simple-feed-stats'); ?></a></strong> 
											<span class="tooltip" title="<?php esc_attr_e('Warning: this will delete all feed stats! Note: deletes data only.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('To delete the SFS table, see the &ldquo;Delete Database Table&rdquo; option (below).', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><label class="description" for="sfs_options[default_options]"><?php esc_html_e('Restore default settings', 'simple-feed-stats'); ?></label></th>
										<td>
											<input name="sfs_options[default_options]" type="checkbox" value="1" id="sfs_restore_defaults" <?php if (isset($sfs_options['default_options'])) { checked('1', $sfs_options['default_options']); } ?> /> 
											<?php esc_html_e('Restore default options upon plugin deactivation/reactivation', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: leave this option unchecked to remember your settings.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Note that this setting applies only to plugin settings. Checking this box will not affect any of your statistical data.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><label class="description" for="sfs_options[sfs_delete_table]"><?php esc_html_e('Delete database table', 'simple-feed-stats'); ?></label></th>
										<td>
											<input name="sfs_options[sfs_delete_table]" type="checkbox" value="1" id="sfs_delete_table" <?php if (isset($sfs_options['sfs_delete_table'])) { checked('1', $sfs_options['sfs_delete_table']); } ?> /> 
											<?php esc_html_e('Delete the stats table the next time plugin is deactivated', 'simple-feed-stats'); ?> 
											<span class="tooltip" title="<?php esc_attr_e('Tip: leave this setting unchecked to keep your feed stats if the plugin is deactivated.', 'simple-feed-stats'); ?> 
											<?php esc_attr_e('Note that this setting applies only to plugin *deactivation*. If you *uninstall* (i.e., delete) the plugin, all data including feed stats will be removed.', 'simple-feed-stats'); ?>">?</span>
										</td>
									</tr>
								</table>
							</div>
							
							<div class="sfs-last-item">
								<input type="submit" class="button button-primary" value="<?php esc_attr_e('Save Settings', 'simple-feed-stats'); ?>" />
							</div>
							
						</form>
					</div>
				</div>
				
				<div class="postbox">
					<h2><?php esc_html_e('Your Feed Info', 'simple-feed-stats'); ?></h2>
					<div class="toggle default-hidden">
						<p>
							<?php esc_html_e('Here are some helpful things to know when working with feeds.', 'simple-feed-stats'); ?> 
							<span class="tooltip" title="<?php esc_attr_e('Tip: to generate some feed data to look at, click on a few of these links and then refresh the SFS settings page.', 'simple-feed-stats'); ?> :)">?</span>
						</p>
						<?php 
							$feed_rdf       = get_bloginfo('rdf_url');           // RDF feed
							$feed_rss2      = get_bloginfo('rss2_url');          // RSS feed
							$feed_atom      = get_bloginfo('atom_url');          // Atom feed
							$feed_coms      = get_bloginfo('comments_rss2_url'); // RSS2 comments
							$feed_coms_atom = get_bloginfo('comments_atom_url'); // Atom comments
							
							$date_format = get_option('date_format');
							$time_format = get_option('time_format');
							$curtime = date("{$date_format} {$time_format}", current_time('timestamp'));
							
							$address = isset($_SERVER['REMOTE_ADDR'])     ? sfs_clean($_SERVER['REMOTE_ADDR'])     : 'n/a';
							$agent   = isset($_SERVER['HTTP_USER_AGENT']) ? sfs_clean($_SERVER['HTTP_USER_AGENT']) : 'n/a'; 
						?>
	
						<p><strong><?php esc_html_e('Your feed URLs', 'simple-feed-stats'); ?></strong></p>
						<div class="sfs-table">
							<ul>
								<li><?php esc_html_e('Content RDF',   'simple-feed-stats'); ?> &ndash; <a target="_blank" href="<?php echo esc_attr($feed_rdf);       ?>"><code><?php echo sfs_clean($feed_rdf);       ?></code></a></li>
								<li><?php esc_html_e('Content RSS2',  'simple-feed-stats'); ?> &ndash; <a target="_blank" href="<?php echo esc_attr($feed_rss2);      ?>"><code><?php echo sfs_clean($feed_rss2);      ?></code></a></li>
								<li><?php esc_html_e('Content Atom',  'simple-feed-stats'); ?> &ndash; <a target="_blank" href="<?php echo esc_attr($feed_atom);      ?>"><code><?php echo sfs_clean($feed_atom);      ?></code></a></li>
								<li><?php esc_html_e('Comments RSS2', 'simple-feed-stats'); ?> &ndash; <a target="_blank" href="<?php echo esc_attr($feed_coms);      ?>"><code><?php echo sfs_clean($feed_coms);      ?></code></a></li>
								<li><?php esc_html_e('Comments Atom', 'simple-feed-stats'); ?> &ndash; <a target="_blank" href="<?php echo esc_attr($feed_coms_atom); ?>"><code><?php echo sfs_clean($feed_coms_atom); ?></code></a></li>
							</ul>
						</div>
						<p><strong><?php esc_html_e('More about WordPress feeds', 'simple-feed-stats'); ?></strong></p>
						<ul>
							<li><a target="_blank" href="https://wordpress.org/plugins/simple-feed-stats/"><?php esc_html_e('Simple Feed Stats Homepage', 'simple-feed-stats'); ?></a></li>
							<li><a target="_blank" href="http://codex.wordpress.org/WordPress_Feeds"><?php esc_html_e('WP Codex: WordPress Feeds', 'simple-feed-stats'); ?></a></li>
							<li><a target="_blank" href="https://perishablepress.com/what-is-my-wordpress-feed-url/"><?php esc_html_e('What is my WordPress Feed URL?', 'simple-feed-stats'); ?></a></li>
							<li><a target="_blank" href="http://feedburner.google.com/"><?php esc_html_e('Google/Feedburner', 'simple-feed-stats'); ?></a></li>
						</ul>
						<p><strong><?php esc_html_e('Your browser/IP info', 'simple-feed-stats'); ?></strong></p>
						<ul>
							<li><?php esc_html_e('IP Address:', 'simple-feed-stats'); ?> <code><?php echo sfs_clean($address); ?></code></li>
							<li>
								<?php esc_html_e('Approx. Time:', 'simple-feed-stats'); ?> <code><?php echo sfs_clean($curtime); ?></code>
								<span class="tooltip" title="<?php esc_attr_e('Denotes date/time of most recent page-load (useful when monitoring feed stats).', 'simple-feed-stats'); ?>">?</span>
							</li>
							<li><?php esc_html_e('User Agent:', 'simple-feed-stats'); ?> <code><?php echo sfs_clean($agent); ?></code></li>
						</ul>
					</div>
				</div>
				<div id="sfs-shortcodes" class="postbox">
					<h2><?php esc_html_e('Shortcodes &amp; Template Tags', 'simple-feed-stats'); ?></h2>
					<div class="toggle default-hidden">
						
						<h3><?php esc_html_e('Shortcodes', 'simple-feed-stats'); ?></h3>
						
						<p><?php esc_html_e('Display daily count for all feeds in plain-text:', 'simple-feed-stats'); ?></p>
						<p><code>[sfs_subscriber_count]</code></p>
						
						<p><?php esc_html_e('Display daily count for all feeds with a FeedBurner-style badge:', 'simple-feed-stats'); ?></p>
						<p><code>[sfs_count_badge]</code></p>

						<p><?php esc_html_e('Display daily count for RSS2 feeds in plain-text:', 'simple-feed-stats'); ?></p>
						<p><code>[sfs_rss2_count]</code></p>
						
						<p><?php esc_html_e('Display daily count for comment feeds in plain-text:', 'simple-feed-stats'); ?></p>
						<p><code>[sfs_comments_count]</code></p>
						
						
						<h3><?php esc_html_e('Template Tags', 'simple-feed-stats'); ?></h3>
						
						<p><?php esc_html_e('Display daily count for all feeds in plain-text:', 'simple-feed-stats'); ?></p>
						<p><code>&lt;?php if (function_exists('sfs_display_subscriber_count')) sfs_display_subscriber_count(); ?&gt;</code></p>
						
						<p><?php esc_html_e('Display daily count for all feeds with a FeedBurner-style badge:', 'simple-feed-stats'); ?></p>
						<p><code>&lt;?php if (function_exists('sfs_display_count_badge')) sfs_display_count_badge(); ?&gt;</code></p>
						
						<p><?php esc_html_e('Display total count for all feeds as plain-text:', 'simple-feed-stats'); ?></p>
						<p><code>&lt;?php if (function_exists('sfs_display_total_count')) sfs_display_total_count(); ?&gt;</code></p>
						
						<p>
							<?php esc_html_e('Example of FeedBurner-style badge:', 'simple-feed-stats'); ?>
							<span class="tooltip" title="<?php esc_attr_e('Tip: visit the &ldquo;Plugin Settings&rdquo; panel to style your badge with some custom CSS.', 'simple-feed-stats'); ?>">?</span>
						</p>
						<p><?php sfs_display_count_badge(); ?></p>
					</div>
				</div>
				<div class="postbox">
					<h2><?php esc_html_e('Show Support', 'simple-feed-stats'); ?></h2>
					<div class="toggle">
						<div class="sfs-current">
							<iframe src="https://perishablepress.com/current/index-sfs.html"></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="sfs-credits">
			<a target="_blank" href="https://perishablepress.com/simple-feed-stats/" title="<?php esc_attr_e('Plugin Homepage', 'simple-feed-stats'); ?>">Simple Feed Stats</a> <?php esc_html_e('by', 'simple-feed-stats'); ?> 
			<a target="_blank" href="https://twitter.com/perishable" title="<?php esc_attr_e('Jeff Starr on Twitter', 'simple-feed-stats'); ?>">Jeff Starr</a> @ 
			<a target="_blank" href="http://monzillamedia.com/" title="<?php esc_attr_e('Obsessive Web Design &amp; Development', 'simple-feed-stats'); ?>">Monzilla Media</a>
		</div>
	</div>

	<script type="text/javascript">
		// auto-submit
		function myF(targ, selObj, restore){
			eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");
			if (restore) selObj.selectedIndex = 0;
		}
		// prevent accidents (delete stats)
		jQuery('.reset').click(function(event){
			event.preventDefault();
			var r = confirm("<?php esc_html_e('Are you sure you want to delete all the feed stats? (this action cannot be undone)', 'simple-feed-stats'); ?>");
			if (r == true){  
				window.location = jQuery(this).attr('href');
			}
		});
		// prevent accidents (restore options)
		if(!jQuery("#sfs_restore_defaults").is(":checked")){
			jQuery('#sfs_restore_defaults').click(function(event){
				var r = confirm("<?php esc_html_e('Are you sure you want to restore all default options? (this action cannot be undone)', 'simple-feed-stats'); ?>");
				if (r == true){  
					jQuery("#sfs_restore_defaults").attr('checked', true);
				} else {
					jQuery("#sfs_restore_defaults").attr('checked', false);
				}
			});
		}
		// prevent accidents (delete table)
		if(!jQuery("#sfs_delete_table").is(":checked")){
			jQuery('#sfs_delete_table').click(function(event){
				var r = confirm("<?php esc_html_e('Are you sure you want to delete the stats table and all of its data? (this action cannot be undone)', 'simple-feed-stats'); ?>");
				if (r == true){  
					jQuery("#sfs_delete_table").attr('checked', true);
				} else {
					jQuery("#sfs_delete_table").attr('checked', false);
				}
			});
		}
		// Easy Tooltip 1.0 - Alen Grakalic
		(function($) {
			$.fn.easyTooltip = function(options){
				var defaults = {	
					xOffset: 10,		
					yOffset: 25,
					tooltipId: "easyTooltip",
					clickRemove: false,
					content: "",
					useElement: ""
				}; 
				var options = $.extend(defaults, options);  
				var content;	
				this.each(function() {  				
					var title = $(this).attr("title");				
					$(this).hover(function(e){											 							   
						content = (options.content != "") ? options.content : title;
						content = (options.useElement != "") ? $("#" + options.useElement).html() : content;
						$(this).attr("title","");								  				
						if (content != "" && content != undefined){			
							$("body").append("<div id='"+ options.tooltipId +"'>"+ content +"</div>");		
							$("#" + options.tooltipId).css("position","absolute").css("top",(e.pageY - options.yOffset) + "px")
								.css("left",(e.pageX + options.xOffset) + "px").css("display","none").fadeIn("fast")
						}
					},
					function(){	
						$("#" + options.tooltipId).remove();
						$(this).attr("title",title);
					});	
					$(this).mousemove(function(e){
						$("#" + options.tooltipId)
						.css("top",(e.pageY - options.yOffset) + "px")
						.css("left",(e.pageX + options.xOffset) + "px")					
					});	
					if(options.clickRemove){
						$(this).mousedown(function(e){
							$("#" + options.tooltipId).remove();
							$(this).attr("title",title);
						});				
					}
				});
			};
		})(jQuery);
		jQuery(".tooltip").easyTooltip();
		// toggle stuff
		jQuery(document).ready(function(){
			jQuery('.sfs-toggle-panels a').click(function(){
				jQuery('.toggle').slideToggle(300);
				return false;
			});
			jQuery('.default-hidden').hide();
			jQuery('h2').click(function(){
				jQuery(this).next().slideToggle(300);
			});
			jQuery('.sfs-options-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#sfs_custom-options .toggle').slideToggle(300);
				return true;
			});
			jQuery('.sfs-shortcodes-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#sfs-shortcodes .toggle').slideToggle(300);
				return true;
			});
			jQuery('.sfs-open-tracking').click(function(){
				jQuery('.sfs-open-tracking-image, .sfs-open-tracking-url').slideDown('fast');
			});
			jQuery('.sfs-tracking').click(function(){
				jQuery('.sfs-open-tracking-image, .sfs-open-tracking-url').slideUp('fast');
			});
			//dismiss_alert
			if (!jQuery('.dismiss-alert-wrap input').is(':checked')){
				jQuery('.dismiss-alert-wrap input').one('click',function(){
					jQuery('.dismiss-alert-wrap').after('<input type="submit" class="button" value="<?php esc_attr_e('Save Preference', 'gap'); ?>" />');
				});
			}
		});
	</script>

<?php }
