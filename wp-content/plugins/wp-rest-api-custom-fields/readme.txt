=== Plugin Name ===
Contributors: andrex84
Donate link: https://www.oxfam.org/en/donate
Tags: api, json, REST, rest-api, advanced custom fields, ACF, custom fields, meta fields, advanced meta fields
Requires at least: 4.2.1
Tested up to: 4.2.1
Stable tag: 0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shows Advanced Custom Field output to the WP REST API for posts, pages, taxonomies and users.

== Description ==

This plugin combines the two of the best WordPress plugins: [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/ "Advanced Custom Fields") and [WP REST API](https://wordpress.org/plugins/json-rest-api/ "WP REST API"). 

This plugin is based on the work from[Panman on Github](https://github.com/PanManAms/WP-JSON-API-ACF "Panman on Github"). He was right when he said it would be better as plugin, but it would be even better if it would be available through the WordPress Plugin Repository.

An addition made to this plugin is that each ACF Field van be filtered throug the hook: JSON_META_ACFFIELDNAME (where ACFFIELDNAME depends on the fieldname you've added in the Advanced Custom Fields backend.)

== Installation ==

This plugin works straight out of the box.

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 0.1 =
* Initial Release. 

