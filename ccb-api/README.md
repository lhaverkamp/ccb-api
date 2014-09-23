=== Plugin Name ===
Contributors: lhaverkamp
Tags: wordpress, ccb, community church builder
Requires at least: 4.0
Testing up to: 4.0
Stable tag: TODO
License:  GPLv3

//TODO short description <= 150 characters

== Description ==

//TODO

== Installation ==

1.  Copy the `ccb-api` directory into your `wp-content/plugins` directory.
2.  In the WordPress dashboard, navigate to the *Plugins* page.  Locate the menu item that reads "CCB API."
3.  Click on *Activate.*
4.  In the WordPress dashboard, navigate to the *Plugins* -> *CCB Plugin* page.  Configure the plugin
1.  Upload `ccb-api` folder to the `/wp-content/plugins/` directory.
2.  Active the plugin through the *Plugins* menu in WordPress
3.  Configure the plugin through the *Plugins* -> *CCB Plugin* menu in WordPress.  The CCB API users are configured in the CCB application unders *Settings* -> *API*.
4.  Click on *Save Changes*

== Usage ==

The API is exposed via a series of WordPress shortcodes.

=== [ccb_current_events] shortcode ===

This displays an upcoming calendar of events.  `[ccb_current_events days="10"]` will display a list of calendar events for the next 10 days.  `days` is optional and defaults to 7 if not specified.

This displays an upcoming calendar of events.  '[ccb_current_events days="10"]' will display a list of calendar events for the next 10 days.  'days' is optional and defaults to 7 if not specified.

== Changelog ==

= 1.0.0
* Exposes the public_calendar_listing API call via the [ccb_current_events] shortcode.
