=== WP to Twitter ===
Contributors: joedolson
Donate link: http://www.joedolson.com/donate/
Tags: twitter, microblogging, su.pr, bitly, yourls, redirect, shortener, post, links, social, sharing, media, tweet
Requires at least: 3.9.2
Tested up to: 4.2.2
License: GPLv2 or later
Text Domain: wp-to-twitter
Stable tag: 3.1.0

Posts a Twitter update when you update your WordPress blog or add a link, with your chosen URL shortening service.

== Description ==

= Post Tweets from WordPress to Twitter. =

Yep. That's the basic functionality. But it's not the only thing you can do:

* Display your Recent Tweets: Widget for your recent Tweets. Fetch Tweets from your own or any other account.
* Display Tweets based on a search: Display the Tweets resulting from a search and limit by Geolocation.
* Shorten URLs in your Tweets with popular URL shorteners, or let Twitter to do it with [t.co](http://t.co). 

[Upgrade to WP Tweets Pro](http://www.joedolson.com/wp-tweets-pro/) and schedule Tweets, set up automatic reposts, upload images and more!

[youtube https://www.youtube.com/watch?v=3YIia5dQBSk]

WP to Twitter uses a customizable Tweet template for Tweets sent when updating or editing posts and pages or custom post types. You can customize your Tweet for each post, using custom template tags to generate the Tweet. 

= Free Features =

* Use post tags as Twitter hashtags
* Use alternate URLs in place of post permalinks
* Support for Google Analytics
* Support for XMLRPC remote clients
* Select from YOURLS, Goo.gl, Bit.ly, jotURL, or Su.pr as external URL shorteners.
* Rate limiting: make sure you don't exceed Twitter's API rate limits. 

= Premium Features =

Upgrade to [WP Tweets Pro](http://www.joedolson.com/wp-tweets-pro/) for extra features, including:

* Authors can set up their own Twitter accounts in their profiles
* Time delayed Tweeting
* Scheduled Tweet management
* Simultaneously Tweet to site and author Twitter accounts
* Preview and Tweet comments
* Filter Tweets by taxonomy (categories, tags, or custom taxonomies)
* Upload images to Twitter
* Integrated Twitter Card support
* Automatically schedule Tweets of old posts
* [Check out WP Tweets PRO!](http://www.joedolson.com/wp-tweets-pro/)

Want to stay up to date on WP to Twitter? [Follow me on Twitter!](https://twitter.com/joedolson)

= Translations =

Visit the [WP to Twitter translations page](http://translate.joedolson.com/projects/wp-to-twitter) to see how complete these are.

Translations available (in order of completeness):
Japanese, Dutch, French, Italian, Russian, Danish, Catalan, Portuguese (Brazil), Spanish (Spain), Chinese (Taiwan), German, Romanian, Estonian, Polish, Lithuanian, Ukrainian, Irish, Swedish, Turkish

Translating my plug-ins is always appreciated. Visit <a href="http://translate.joedolson.com">my translations site</a> to start getting your language into shape!

== Changelog ==

= Future =

* Use apply_filters( 'wpt_tweet_sentence', $tweet, $post_ID ) to pass custom taxonomy Tweet formats - Pending WordPress support for taxonomy meta.
* Add regex filter to detect URLs typed into Tweet fields for counting/shortening purposes. [todo]
* 4.2 added compat function for mb_substr; drop mine when I drop support for 4.1

= 3.1.1 =

* Add post title to Yourls shortener query. Thanks to <a href="https://wordpress.org/support/topic/missing-post-title-on-remote-yourls-call-fix-included?replies=1">the.mnbvcx</a>.
* Bug fix: Overlooked warning if categories not defined.
* Updated wp-to-twitter.pot

= 3.1.0 = 

* Moved changelog entries older than 3.0.0 into changelog.txt
* Update PHP 4 class constructors to PHP 5.
* Added template tags for all categories and all category descriptions.
* Better loading of text domain.
* Improve preview character counting when featured images are being uploaded. (WP Tweets PRO)
* Require users to add an email to send a support request.
* Added check for constant WPT_STAGING_MODE; disables posting to Twitter on staging servers.
* New feature: Rate limiting. Enable rate limiting to restrict the number of posts per category per hour can be sent to your Twitter account.

= 3.0.7 =

* Bug fix: Twitter Feed search broken.
* Bug fix: Display issue with support form textarea.
* Address issue with input sources that have double encoded entities.
* Improved: Error messages with Twitter Feed issues.
* Add option to hide header on Twitter feed widget.
* Language Update: Portuguese (Brazil)

= 3.0.6 =

* Bug fix: missing styles from Twitter feed
* Bug fix: test whether Tweet is possibly sensitive always returned true
* New feature: display uploaded images in Twitter feed instead of link to image.
* New template tag: #longurl# - use to Tweet the unshortened URL for a post.

= 3.0.5 =

* Bug fix: Typo in fix for settings update screwed things up.

= 3.0.4 =

* Bug fix: Error with YOURLS url handler. Two reversed variable definitions.
* Bug fix: Bad URL for testing time check when WP Tweets PRO active.
* Bug fix: Update could reset some settings to defaults.
* Grammar fix to one text string. 
* Minor updates to Spanish & Portuguese translations

= 3.0.3 =

* Update Japanese translation
* Bug fix: accidentally left one debug message in override.

= 3.0.2 =

* Bug fix: obscure duplicating Tweets issue related to co-Tweeting and media uploads
* Bug fix: notice thrown if using Yourls and access to Yourls directory blocked at server.
* Revamped settings page. 
* Updated user's guide.

= 3.0.1 =

* Changed priority of wpt_twit function on save_post action so that The Events Calendar can send Tweets.
* Bug fix: ensure that arguments passed to URL shorteners for analytics are URL encoded.
* Bug fix: Clear widget cache when widget is updated.
* Bug fix: invalid argument with obsolete category filters.
* Bug fix: inconsistent labeling of API key/consumer key. 
* Bug fix: Errors in data migration for 3.0.0 fixed.
* Only show 'Tweet to' tab if individual authors options are enabled.
* Minor updates to application setup instructions.

= 3.0.0 =

* Handles case where post type identification could throw PHP warning if no post types were chosen to be Tweeted.
* Eliminated outdated compatibility function. 
* Eliminated old update notices.
* General code cleanup.
* Code documentation.
* Updated media uploading to use Uploads endpoint, replacing deprecated update_with_media endpoint. [WP Tweets PRO]
* Simplifed short URL storage
* Decreased widget cache life from 1 hour to 30 minutes.
* Added fallback Normalizer class for cases when extension is not installed.
* Added notes for the 100 HTTP code return error.
* Moved Twitter server time check out of basic set-up & set up to only run on demand.
* Minor design changes.

== Installation ==

1. Upload the `wp-to-twitter` folder to your `/wp-content/plugins/` directory
2. Activate the plugin using the `Plugins` menu in WordPress
3. Go to Settings > WP to Twitter
4. Adjust the WP to Twitter Options as you prefer them. 
5. Create a Twitter application at Twitter and Configure your OAuth keys

== Frequently Asked Questions ==

= Where are your Frequently Asked Questions? Why aren't they here? =

Right here: [WP to Twitter FAQ](http://www.joedolson.com/wp-to-twitter/support-2/). I don't maintain them here because I would prefer to only maintain one copy. This is better for everybody, since the responses are much more likely to be up to date!

= How can I help you make WP to Twitter a better plug-in? =

Writing and maintaining a plug-in is a lot of work. You can help me by providing detailed support requests (which saves me time), or by providing financial support, either via my [plug-in donations page](https://www.joedolson.com/donate/) or by [upgrading to WP Tweets Pro](https://www.joedolson.com/wp-tweets-pro/). Believe me, your donation really makes a difference!

== Screenshots ==

1. WP to Twitter OAuth settings.
2. WP to Twitter post meta box settings.
3. WP to Twitter post meta box with WP Tweets PRO.
4. WP Tweets PRO settings.
5. Twitter Feed 
6. Settings

== Upgrade Notice ==

* 3.1.0 - New feature: Rate limiting by category; Staging mode; misc. bug fixes