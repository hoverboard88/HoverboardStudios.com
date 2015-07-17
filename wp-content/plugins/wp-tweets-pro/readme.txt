=== WP Tweets PRO ===
Contributors: joedolson
Donate link: http://www.joedolson.com/donate.php
Tags: twitter, microblogging, su.pr, bitly, yourls, redirect, shortener, post, links
Requires at least: 3.8.5
Tested up to: 4.1
Stable tag: trunk
License: GPLv2 or later

Posts a Twitter update when you update your WordPress blog or post to your blogroll. Requires WP to Twitter.

== Description ==

WP Tweets PRO adds new features to WP to Twitter, including:

* support for multi-user authentication with Twitter, 
* scheduled delay of Tweets, 
* scheduled re-posting of Tweets, and more!
* review of any failed tweets for retweeting manually or debugging
* Tweet comments
* Upload media to Twitter

== Changelog ==

= Future =

* Make aware of custom plug-ins such as randomizer/custom Tweet scheduler - allow post meta settings to override, disable fields, etc. [todo]
* Option to customize Tweet schedule for each re-post (with customize text) [todo]
* Add support to WPts PRO for compatibility with CoAuthors Plus [todo]
* Add custom Tweet options for taxonomy terms (custom template, custom URL, etc.) - Pending WordPress support for taxonomy meta. [todo]
* Make all Tweet options fields persistent [todo]
* Allow AJAX handler for Tweet Now button to pick up values in Tweet to box [todo]

= 1.8.3 =

* Updated link to Twitter Card validator.
* Fix pagination in Past Tweets/Failed Tweets
* Make number of Tweets per page on past/failed Tweets filterable.
* Add option to choose whether a given re-post should upload media
* Place main Twitter account into multiselect 'Tweet to' box, so it's available as one of the selectable Tweets. 
* Bug fix: Automatic reposts would not pick up media to upload.

= 1.8.2 =

* Bug fix: Autotweeting could be accidentally scheduled when saving settings.

= 1.8.1 =

* Bug fix: 'Co-Tweet' option in meta box was not checked when option enabled.

= 1.8.0 =

* Bug fix: Strip slashes on custom repost texts in settings.
* Bug fix: Strip slashes on custom retweet texts in post meta box.
* Bug fix: Tweet scheduler did not show that images would be attached when using Always Upload Images plug-in
* Bug fix: If an editor published a post written by a different author, it could Tweet to the editor's account.
* Update: Fix media uploading to use Uploads endpoint, replacing deprecated update_with_media endpoint.
* Media uploads now attached to all reposts.
* Media uploads no longer dependent on file path.
* Obsolete: "Always Upload Images" add-on.
* Obsolete: "Custom Image Path" add-on.
* Obsolete: "CVN REmote images" setting.
* New feature: Schedule automated re-posting of old posts.
* New feature: specify different numbers of reposts for individual user accounts

= 1.7.4 =

* Bug fix: 'Array' appearing as Tweet text for reposts.

= 1.7.3 =

* Bug fix: Incorrect default value for image uploading
* Feature: set a delay for Tweeting comments

= 1.7.2 =

* Bug fix: Save custom retweets
* Bug fix: Call tmh_oauth by absolute path (fixes extremely obscure plug-in conflict)
* Add Post Content to custom tweet filters
* Option: Upload images when stored remotely, such as through Amazon S3 or a CDN.
* Feature: Select scheduled Tweets to delete to bulk delete some of queued Tweets.

= 1.7.1 =

* Bug fix: scheduled retweet custom Tweets empty data
* Bug fix: admin did not have update_core capability, could not see settings page.
* Bug fix: Logic error disabled image upload in inappropriate circumstances due to UI change.

= 1.7.0 =

* Feature: Create custom Tweets for each scheduled retweet in the post meta panel.
* Feature: Add comment URL template tag: #comment_url# to pass shortened comment-specific URL.
* Improvement: Pass comment Tweets through custom Tweet filters.
* Deprecated support for WordPress versions 3.5.x
* New filter: wpt_default_upload_image to set image upload option default to 'no'.

= 1.6.3 =

* Change: Default to 'large' image for uploads.
* New: per-post toggle to disable image uploads on a post-specific basis.
* Bug fix: If 'large' image size has been removed, automatically switch to an alternate image size.

= 1.6.2 =

* Perform count of terms before fetching terms to avoid excess memory consumption on large taxonomies.
* Bug fix: could not delete category filter if it was the only category selected.

= 1.6.1 =

* Missing array type verification in term filtering.

= 1.6.0 =

* New Feature: Implemented taxonomy filtering for all taxonomies. 
* Added post arguments to image path filter to enable custom image swapping on upload.
* Added option to not upload images for a specific post.
* Bug fix: misnamed variable.
* Updated manual.

= 1.5.8 =

* Bug fix: if forward slash in tag & filtering of titles/content enabled, title was removed.

= 1.5.8 =

* Remove extraneous spaces from Twitter Card description
* New feature: custom templates for each Tweet re-post.

= 1.5.7 =

* Security release.

= 1.5.6 =

* Bug fix: Tweeting comments did not provide shortened URL if post had not previously been Tweeted.
* Bug fix: undeclared array key.
* Bug fix: Only return published posts in recent posts list (scheduled Tweets page)
* Bug fix: Send correct mime type to Twitter for uploaded images
* Bug fix: If attachment cannot be used for uploading, fallback to normal status update instead of exiting.
* Bug fix: obtain correct attachment file path if WordPress installed in different directory.
* New Feature: "Blackout" period -- if Tweet scheduler falls between defined times, reschedule.
* New Filter: 'wpt_upload_image_size' - alter image size uploaded to Twitter. Default: 'medium' (only if WordPress not in separate directory)
* New Filter: 'wpt_image_path' - image path used to upload to Twitter. (only if WordPress not in separate directory)

= 1.5.5 =

* Show authorized users in users screen.
* Bug fixes: undeclared variables.

= 1.5.4 =

* Bug fix: avoid namespace collision with auto update
* Bug fix: If authorized users list wasn't saved, returned fatal errors.

= 1.5.3 =

* Bug fix: user object incorrectly accessed as array.
* Bug fix: array variable overwritten as string.

= 1.5.2 =

* Changed default for bespoke scheduling to use WP to Twitter filters
* Opened up Tweeting of comments to also apply to commenters with a previously approved comment.
* Auto-toggling to Twitter photo cards if minimal content and a featured image set.
* Support for selection of Twitter accounts to use when posting.
* Updated automatic updater. 

= 1.5.1 =

* Bug fix: could not set meta values to same value as settings if previously saved to another value.
* Bug fix: (in WP to Twitter) - Tweets did not work on scheduled posts when image uploading enabled.
* Feature change: Tweet administrator & editor comments without requiring moderation.
* New feature: configure post tags: use as a hashtag (#a11y), as a stock tag ($GOOG), or to ignore.

= 1.5.0 =

* Added support for Tweeting comments to WP Tweets PRO.
* Added support for uploading images to Twitter.

= 1.4.1 =

* Bug fix: could not set re-post value to 0. 
* Changed auto-update checker cycle to match WordPress.

= 1.4.0 =

* New feature: User-specific Tweet text templates.
* Increased prominence for Tweet differentiation info.
* Support for float values in Tweet re-post schedule.
* Bug fix: if a duplicate Tweet was scheduled, deleting would delete both Tweets.
* Added User's Guide.

= 1.3.7 = 

* Bug fix: limiting failed Tweets by post type lead to wrong URL

= 1.3.6 =

* French language update.
* Improvement: can view other post types than 'post' in past/failed tweets listings.
* Bug fix: only save post-specific meta data (retweet period, delay, etc.) if value is not the default.
* WP Tweets PRO now adds initial delay to the scheduled time for re-Tweets.

= 1.3.5 =

* Ability to disable Twitter Card output
* Bug in Twitter Card output: HTML tags were not stripped from content, only from excerpt.

= 1.3.4 = 

* Fixed a bug in automatic update cycle.

= 1.3.3 =

* Changed the frequency of automatic update checking to reduce burden on joedolson.com server.

= 1.3.2 =

* Bug fix: WP Tweets PRO would attempt to Tweet to an account that had been set up, even if user accounts were deactivated.
* Bug fix: Improper truncation of re-posted Tweets.
* Bug fix: Custom filters didn't remember what field was selected.

= 1.3.1 =

* Bug fix to custom filters settings.
* Bug fix to date display when scheduling a bespoke Tweet.

= 1.3.0 =

* Added 'Schedule a Tweet' feature to add custom tweets to the scheduled Tweet queue for any configured author.
* Added feature to lock co-tweeting to a single secondary account.
* Bug fix in licensing process.
* Bug fix: Tweet to main account was failing if no delay, no repost, and cotweeting all set.
* Added 3rd prepend field so all re-posts will have unique text prepended.
* Improved error message if prepend fields are not authored.
* Added custom filtering to set custom rules for posts that should not be tweeted.
* Added pagination to Past Tweets/Failed Tweets listings.
* Tested up to WP 3.5
* Requires WP to Twitter 2.5.0+

= 1.2.3 =

* Bug fix: Issues with saving post meta when user has restricted permissions.

= 1.2.2 =

* Bug fix: Problem saving cotweet settings on a per-post basis due to misnamed input field.

= 1.2.1 =

* Bug fix: Version 2.4.8 changed behavior when saving tweets in WP to Twitter, breaking saving when scheduling via WP Tweets Pro

= 1.2.0 =

* Bug fixes to Scheduled Tweet Queue Management. 
* Adds view to see failed tweets. 
* Adds #reference# template tag.

= 1.1.3 =

* Bug fix: Could not delete single items from queue if they contained a single quote
* Bug fix: Could not delete single items from queue if not sent to the main account

= 1.1.2 =

* Adds option to move repost text to end of the Tweet; removes space from repost text.

= 1.1.1 =

* Fixes upgrade message so it turns off when you're up to date
* Adds warning if user has WP to Twitter deactivated.

= 1.1.0 =

* Adds ability to co-tweet to both the main and current author's Twitter accounts.

= 1.0.2 =

* Automatically disables option to post to Twitter on XMLRPC if a tweet delay is set. Option not required if Tweet is delayed.

= 1.0.1 =

* Bug fix to XML RPC support for delayed tweets / repost policies. 

= 1.0.0 =

* Initial release.

== Installation ==

1. Upload the `wp-to-twitter-pro` folder to your `/wp-content/plugins/` directory
2. Activate the plugin using the `Plugins` menu in WordPress
3. Go to the WP to Twitter menu
4. Adjust your new WP to Twitter PRO Options as you prefer them. 

== Frequently Asked Questions ==

= I installed this, and nothing's there! What's going on! =

Do you have WP to Twitter installed? You need to have both installed: WP Tweets Pro expands on the functions already available from WP to Twitter.

== Screenshots ==

== Upgrade Notice ==

* 1.5.4 Bug fixes: class collision with updater, fatal error if authorized user array not set.