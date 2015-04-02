=== Plugin Name ===
Contributors: hipchat
Donate link: https://www.hipchat.com
Tags: chat, hipchat, notification, alert
Requires at least: 2.9.0
Tested up to: 3.8
Stable tag: 1.3

This plugin allows you to send notifications about new published posts to a HipChat room.

== Description ==

This plugin uses the [HipChat v1 HTTP API][api] to send a message to a room whenever a post is published. You will need to provide your HipChat API token before notifications are sent.

  [api]: http://www.hipchat.com/docs/api

== Installation ==

Use the "Install Plugins" page in your wp-admin, or:

1. Upload the `hipchat` directory to your `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Configure the plugin by selecting 'HipChat' in the settings menu.

== Screenshots ==

1. This is what the message looks like.

== Changelog ==

= 1.3 =
* Mark as working with WP 3.8

= 1.2 =
* Properly tag new release. This system and svn are weird. :p

= 1.1 =
* Use HTTPS when hitting API.
* Only hit rooms/message method so this works with Notification tokens.

= 1.0 =
* Initial release.

== Contributors ==

* Artem Russakovskii (admin@beerpla.net)
* Garret Heaton (garret@hipchat.com)

