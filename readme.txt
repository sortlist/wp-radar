=== Sortlist Radar ===
Contributors: sortlist
Tags: analytics, tracking, lead generation, B2B, visitor identification
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Integrate the Sortlist Radar tracking script on your WordPress website to identify B2B visitors and generate leads.

== Description ==

[Sortlist Radar](https://www.sortlist.com/radar) identifies companies visiting your website and turns anonymous B2B traffic into actionable leads. This plugin makes it easy to install the Radar tracking script on your WordPress site without editing any code.

**A Sortlist account with an active Radar subscription is required.** [Get started with Sortlist Radar](https://www.sortlist.com/radar) to create your account and subscribe.

**Features:**

* One-click installation of the Sortlist Radar tracking script
* Configure your Profile ID from the WordPress admin
* Session tracking to understand visitor journeys
* Optional form submission tracking
* Click tracking for engagement insights

**How it works:**

1. [Sign up for Sortlist Radar](https://www.sortlist.com/radar) and subscribe
2. Install and activate this plugin
3. Enter your Sortlist Profile ID (found in your Sortlist dashboard)
4. The Radar script automatically loads on all public pages

**Documentation:**

* [How to add the Radar snippet to your website](https://help.sortlist.com/en/articles/12382011-how-to-add-the-sortlist-radar-snippet-to-your-website)
* [Sortlist Radar: Turn anonymous visitors into qualified leads](https://help.sortlist.com/en/articles/13905002-sortlist-radar-turn-anonymous-visitors-into-qualified-leads)

**External service:**

This plugin loads a JavaScript tracking script from `collector.sortlist.com` and sends collected data to `radar.sortlist.com`. These are services operated by [Sortlist](https://www.sortlist.com). By using this plugin, visitor data (IP address, page views, form submissions, clicks) is transmitted to Sortlist's servers for processing.

* [Sortlist Privacy Policy](https://www.sortlist.com/privacy-policy)
* [Sortlist Terms of Service](https://www.sortlist.com/terms-of-use)

== Installation ==

1. Upload the `sortlist-radar` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to Settings > Sortlist Radar to enter your Profile ID.

== Frequently Asked Questions ==

= Do I need a Sortlist account? =

Yes. Sortlist Radar is a paid product that requires an active subscription. [Sign up at sortlist.com/radar](https://www.sortlist.com/radar) to get started.

= Where do I find my Profile ID? =

Log in to your [Sortlist dashboard](https://www.sortlist.com/radar) and navigate to the Radar section. Your Profile ID will be displayed there.

= Does this plugin affect site performance? =

The tracking script is loaded asynchronously and does not block page rendering.

= Is this plugin GDPR compliant? =

The plugin loads a tracking script that collects visitor data. You are responsible for informing your visitors and obtaining consent as required by applicable privacy regulations. We recommend using a cookie consent plugin alongside Sortlist Radar.

= Can I disable form tracking? =

Yes. Go to Settings > Sortlist Radar and uncheck the "Track form submissions" option.

== Screenshots ==

1. Settings page with Profile ID configuration.
2. Active status indicator when configured.

== Changelog ==

= 1.0.0 =
* Initial release.
* Profile ID configuration.
* Session, form, and click tracking options.

== Upgrade Notice ==

= 1.0.0 =
Initial release.
