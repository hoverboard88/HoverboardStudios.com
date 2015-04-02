=== Plugin Name ===
Contributors: ishan001
Tags: analytics, google, traffic, bounce rate, google analytics
Requires at least: 3.5
Tested up to: 3.6
Stable tag: 2.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds Fixed Google Analytics Tracking Code to Your Footer. 

== Description ==

Google Analytics has a small problem in tracking: When someone visits a page, it waits for an event. If visitor leaves from that page, no event occurs and they are counted as a bounce. 

This plugin fixes it by generating an event when visitors scrolls **and** stays on page for 30 seconds. 

Apart from fixing the code, it is also the simplest way to add Google Analytics code to your WordPress blog/website. You just have to enter your Google Analytics ID and that's it. No complex options.

Read more at [WordPress Blog Experts](http://wpblogexperts.com/plugins/analytics-unbounce)

You can ask for help or any features by simply [contacting us](http://wpblogexperts.com/contact-us)

Upcoming Features:

* Options to select who is tracked. (Authors, Editors and Administrators aren't tracked right now)
* Option to set the timeout.

If you need any help with WordPress Setup, Theme Customization or Troubleshooting, visit [WordPress Blog Experts](http://wpblogexperts.com/).

== Installation ==

This section describes how to install the plugin and get it working.


1. Upload `analytics-unbounce.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Setting &rarr; Analytics Code to enter your Google Analytics ID. 

== Frequently Asked Questions ==

= Can I select the user type who is tracked? =

Not right now. I am working on implementing it soon. 

= How do I get help? =

Best way is to contact me using [this form](http://wpblogexperts.com/contact-us)

== Screenshots ==

1. Just enter your Analytics ID and you're done. No complex settings. 

== Changelog ==

= 2.3 =
* Change timeout back. Apologies for last one. It shouldn't have been done in first place.

= 2.2 =
* Changed timeout to 5 seconds from 30 seconds.

= 2.0 =
* Added scroll event to make tracking more accurate. 

== Upgrade NOtice ==

= 2.3 =
* Changes timeout to 30 seconds. Custom option coming in next version. 

= 2.2 =
* Previous version worked after 30 seconds. Changed to 5 seconds.

= 2.0 =
* More accurate tracking, added scroll method and increased time to 30 seconds. 