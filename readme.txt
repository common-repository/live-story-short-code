=== Live Story ===
Contributors: livestory
Tags: livestory, experience, embed, no-code
Requires at least: 5.0
Stable tag: 1.0.2
Requires PHP: 7.0
Tested up to: 6.6.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Embed Live Story experiences in pages with a shortcode

== Description ==

Design and publish layouts online and to remote screens in no time. Live Story is a next-gen UX design platform that boosts productivity and creativity on your WordPress site. 
With our freehand editor, you can freely craft layouts on a blank canvas, add rich animations, and optimize for conversions.

Prefer templates? Build your own library and seamlessly blend them with your designs.

This integration brings unmatched creative agility to WordPress, perfect for content that needs frequent updates, ensuring your site stays fresh, engaging, and conversion-focused.

[youtube https://www.youtube.com/watch?v=4am_agsJ0zQ]

## External services
The correct Live Story functionings requires the Live Story javascript main script asset to be loaded.
Live Story plugin automatically loads Live Story main script ```https://assets.livestory.io/dist/livestory-xxxx.min.js``` where xxxx stands for brand
code set up on plugin configuration.

Official documentation can be found here: https://livestory.nyc/documentation/articles/basic-client-side-integration/#main-script

Live Story services are compliant with Art. 13 of Regulation (EU) 2016/679 ("GDPR") regarding the processing of your personal data that we collect when you browse the Site and interact with its services. Detailed infos can be found at https://livestory.nyc/privacy page.

## Setup guide

1. Define this constant inside `wp-config.php`

    `define('LIVESTORY_BRANDCODE', 'code');`

2. Clone this repository in the `wp-content/plugins` directory

3. Activate it from the admin panel

## Syntax

### Add a layout

`[livestory id="xyz" type="layout"]`

### Add a destination

`[livestory id="xyz" type="destination"]`

### Stores and language

Support for store and language codes is available using the parameters `store` and `lang`.

`[livestory id="xyz" type="layout" store="storeid" lang="foo"]`


## Example contents shortcodes

In Live Story plugin settings, set brand code value: `demo`

Use following shortcodes in Wordpress pages:

`[livestory id="66aca2d449fcbc000846e6b7" type="layout"]`

`[livestory id="65ba07376c11e000080a6b7c" type="destination"]`

== Installation ==

The easy way:

1. Go to the Plugins Menu in WordPress
2. Search for "Live Story"
3. Click "Install"

The manual way:

1. Upload the `live-story-short-code` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Manage your configuration using the 'Live Story' menu option to enable plugin and set brand code

== Frequently Asked Questions ==

= How can I embed a layout on a page =

You have to use shortcode like this ```[livestory id="xyz" type="layout"]```

= How can I embed a destination on a page =

You have to use shortcode like this ```[livestory id="xyz" type="destination"]```

== Screenshots ==

1. Live Story plugin settings.
2. Layout content rendering in page.
3. Destination content rendering in page.

== Changelog ==

= 1.0.2 =
* Added support for destination server side rendering content.

= 1.0.1 =
* Added Server Side Rendering support for layouts.

= 1.0.0 =
* Added first set of features.

== Upgrade Notice ==

= 1.0.2 =
* Upgrade is requested if you want to use enable SSR versions of your destinations.

= 1.0.1 =
* Upgrade is requested if you want to enable SSR versions of your contents.
