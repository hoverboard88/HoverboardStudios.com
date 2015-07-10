<?php
/*
Plugin Name: Analytics Reduce Bounce Rate
Plugin URI: http://wpblogexperts.com/plugins
Description: Adds Google Analytics tracking code to WordPress and fixes bounce rate measurement
Version: 2.3
Author: Ishan Sharma
Author URI: http://ishan.co
License: GPL2
*/

if (!get_option('unbounce_analytics_id')) // Check for Analytics ID in DB
{
	add_option('unbounce_analytics_id'); // If key is not there, a blank value is created.
}
$unbounce_analytics_id = get_option('unbounce_analytics_id'); // Retrieve the value from database
$unbounce_analytics_input_id = ''; // No input for now, so keeping it blank. 


/* *** Add Code to Website *** */
add_action('wp_footer', 'unbounce_tracking_code'); 

function unbounce_tracking_code()
{
	global $unbounce_analytics_id;
	$tracking_script = <<<_TRACKING_CODE_
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '$unbounce_analytics_id']);
	_gaq.push(['_trackPageview']);

	setTimeout(function() {
    window.onscroll = function() {
      window.onscroll = null; // Only track the event once
      _gaq.push(['_trackEvent', 'scroll', 'read']);
    }
	}, 30000);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

	</script>
_TRACKING_CODE_;

	// Check if current user is logged in and is author or higher. Echo code only if condition is false. 
	if (!current_user_can('edit_published_posts'))
	{
		echo $tracking_script;
	}
	else
	{
		echo "<!--- Analytics Unbounce Plugin is working but not tracking you as you are admin-->";
	}
}
/* Plugin front end work ends here, next is about options and database handling */

/* *** Add Plugins Optinos Under Settings *** */
add_action ('admin_menu', 'unbounce_admin_menu');

function unbounce_admin_menu()
{
	add_options_page( 'Analytics Code', 'Analytics Code', 'manage_options', 'analytics-unbounce', 'unbounce_options');
}

function unbounce_options()
{
	global $unbounce_analytics_id;
	if ( !current_user_can( 'manage_options' ) )
	{
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	$unbounce_message = '';
	if (array_key_exists('unbounce_submit', $_POST))
	{
		$unbounce_message = unbounce_check_analytics_key();
	}
	echo <<<_UNBOUNCE_OPTIONS_
	<div id="wrap">
		<h2>Analytics Code Settings</h2> 
		$unbounce_message
		<hr />
		<form action="options-general.php?page=analytics-unbounce" method="post">
			<label for="analytics_id">Enter Your Google Analytics ID:</label> <br />
			<input type="text" maxlength="14" name="analytics_id" value="$unbounce_analytics_id" class="regular-text" /> <br />
			<input type="submit" value="Save" class="button button-primary" /> <hr />
			<input type="hidden" name="unbounce_submit"/>
		</form>
	</div>
_UNBOUNCE_OPTIONS_;
}

function unbounce_check_analytics_key()
{
	if (array_key_exists('analytics_id', $_POST))
	{
		global $unbounce_analytics_input_id;
		$unbounce_analytics_local_id = sanitize_text_field($_POST['analytics_id']);
		$unbounce_input_length = strlen($unbounce_analytics_local_id);
		if ($unbounce_input_length < 9 || $unbounce_input_length > 15) 
		{
			return '<div class="updated settings-error">This seems like wrong Analytics ID. Please enter a valid one.</div>';
		}
		else
		{
			$unbounce_analytics_input_id = $unbounce_analytics_local_id;
			store_unbounce_analytics_key();
			return '<div class="updated settings-error">Analytics ID saved</div>';
		}
	}
}


/* This section has some scary databse stuff!*/

function store_unbounce_analytics_key()
	{
		global $unbounce_analytics_input_id;
		global $unbounce_analytics_id;
		if ($unbounce_analytics_input_id != $unbounce_analytics_id)
		{
			$unbounce_analytics_id = $unbounce_analytics_input_id;
			update_option('unbounce_analytics_id', $unbounce_analytics_input_id);
		}
	}
?>