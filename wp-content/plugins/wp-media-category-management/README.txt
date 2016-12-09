=== Plugin Name ===
Contributors: DeBAAT
Donate link: https://www.de-baat.nl/WP_MCM
Tags: media library, bulk action, bulk toggle, toggle category, taxonomy, taxonomies, attachment, media category, media categories, media tag, media tags, media taxonomy, media taxonomies, media filter, media organizer, media types, media uploader, custom, media management, attachment management, files management, user experience, wp-admin, admin
Requires at least: 4.0
Tested up to: 4.6.1
Stable tag: 1.9.1
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

A plugin to provide bulk category management functionality for media in WordPress sites.

== Description ==
This WordPress plugin will ease the management of media categories, including bulk actions.
It supports categories for media using either the existing post categories or a dedicated media_category custom taxonomy.
The plugin supports easy category toggling on the media list page view and also bulk toggling for multiple media at once.
It now also supports post tags and media taxonomies defined by other plugins.

= Main Features =

* Use post categories or dedicated media categories.
* Control your media categories via admin the same way as post categories.
* Bulk toggle any media taxonomy assignment from Media Library via admin.
* Filter media files in Media Library by your custom taxonomies, both in list and grid view.
* Use new or existing shortcode to filter the media on galleries in posts.
* Use a default category while uploading (see FAQ section). 

== Installation ==

1. Upload plugin folder to '/wp-content/plugins/' directory
1. Activate the plugin through 'Plugins' menu in WordPress admin
1. Adjust plugin's settings on **WP MCM -> Settings**
1. Enjoy WordPress Media Category Management!
1. Use shortcode `[wp_mcm taxonomy="<slug>" category="<slugs>"]` in your posts or pages, see also **WP MCM -> Shortcodes**

== Frequently Asked Questions ==

= How do I use this plugin? =

On the options page, define which taxonomy to use for media: either use the standard post taxonomy, a dedicated media taxonomy or a custom media taxonomy.
Define the categories to be used for media.
Toggle category assignments to media, either individually or in bulk.
Use category filter when adding media to posts or pages.

= How do I use this plugin to support the media taxonomy of another plugin? =

There are a number of plugins available for managing media categories.
This plugin now supports the settings previously defined to support those media categories.

Check out the **MCM Settings** page which shows an option "Media Taxonomy To Use".
The dropdown list of this option shows a list of all taxonomies currently used by this WordPress installation.
The option "**(P) Categories**" is the taxonomy defined by default for posts.
The option "**MCM Categories**" is the taxonomy previously defined as "**Media Categories**" by version 1.1 and earlier of this plugin.
If there are other taxonomies currently assigned to attachments, the list shows the corresponding taxonomy slug prefixed with **(*)**.
When such a taxonomy is selected to be used, the taxonomy will be registered anew with the indication "**(*) Custom MCM Categories**".
As long as this taxonomy is selected, the functionality available for "**MCM Categories**" is now available for these "**(*) Custom MCM Categories**", i.e. toggling and filtering.
The name shown for the "**(*) Custom MCM Categories**" can be changed using the option "**Name for Custom MCM Taxonomy**" on the **MCM Settings** page.

= How can I use the "Default Media Category"? =

First enable the option "**Use Default Category**" on the **MCM Settings** page.
When enabled and a media attachment has no category defined yet, the value of "**Default Media Category**" will be assigned automatically when a media attachment is added or edited.
The default value is also used in the `[wp_mcm]` shortcode to automatically filter the attachments to be shown.

= Steps to assign a default category while uploading: =

1. Enable "Use default category" in Settings
1. Define the default category to use
1. Upload the media for this category
1. Repeat from step 2 for other categories

= How do I use the shortcode of this plugin? =

Use the `[wp_mcm]` shortcode. Various shortcode uses are explained in the **WP MCM -> Shortcodes** page.

== Screenshots ==

1. The admin page showing the options for this plugin.
2. Managing the new Media Category taxonomy.
3. Setting Media Category options for a media post.
4. Media List page view showing individual toggle options for first media post.
5. Media List page view showing bulk toggle actions for selected media post.
6. Media List page view showing filter options for Media Categories.
7. Media Grid page view showing filter options for Media Categories.
8. The admin page showing the shortcode explanations for this plugin.
9. The post edit page showing an example using the [wp-mcm category="mediafoto,medialogo"] shortcode.
10. The post page showing the results of the example using the [wp-mcm category="mediafoto,medialogo"] shortcode.

== Changelog ==

= 1.9.1 =
* Added support for category base permalink.

= 1.9.0 =
* Tested for WP 4.6.
* Added support for new shortcode attribute 'show_category_link'.
* Fixed support for MCM Categories Widget.
* Fixed rewrite rules when changing taxonomy.

= 1.8.3 =
* Tested for WP 4.5.

= 1.8.2 =
* Tested for WP 4.4.2.

= 1.8.1 =
* Fixed Text Domain and Author to support translations on WordPress.org.

= 1.8.0 =
* Using media filter on more relevant pages than only for posts and media.
* When selected also show Post Categories together with MCM Categories in Media List View.
* Improved labels when showing Tags or Post Categories.
* Removed WP-MCM shortcode parameters when using alternative_shortcode, e.g. [dg] for [Document Gallery] (https://wordpress.org/plugins/document-gallery/).

= 1.7.4 =
* Fixed issue with using post categories when selected as MCM Category.

= 1.7.3 =
* Fixed issue with filtering posts, only perform additional media search on non-admin pages.

= 1.7.2 =
* Fixed issue with translating "MCM Shortcodes"
* Change textdomain to 'wp-media-category-management' from MCM_LANG per forthcoming translate.wordpress.org standards.
* Added Portuguese (pt_PT) translation as provided by Pedro Mendonça [www.pedromendonca.pt]

= 1.7.1 =
* Fixed issue with showing bulk actions when filtering.

= 1.7.0 =
* Update to support WordPress 4.3.
* Allow use of admin functions in front-end.
* Added Settings link to action links on Installed Plugins page.
* Added screen-reader-text to filter.
* Fixed handling checkbox options.
* Used check for search to skip searching completely.

= 1.6.1 =
* Fixed issue with filtering media in combination with search function.

= 1.6.0 =
* Added support for media category permalinks.
* Added support for MCM Category widgets using the permalinks.
* Added option to search the media library.
* Removed trailing spaces from translatable key words.

= 1.5.2 =
* Fixed issue with filtering media.

= 1.5.1 =
* Added German translation (thanks Marcel Dischinger).
* Fixed issue filtering media on 'No categories' for post categories.
* Fixed a non-translatable text.

= 1.5.0 =
* Tested up to WP 4.2.1.
* Added support for tags also used by posts.

= 1.4.5 =
* Added Serbo-Croatian translation (thanks Andrijana Nikolic [andrijanan@webhostinggeeks.com].

= 1.4.4 =
* Added French translation (thanks Pierre).

= 1.4.3 =
* Tested up to WP 4.1.1.
* Added filter support for MCM categories when adding media to new post.

= 1.4.2 =
* Fixed issue with display of filter when adding media in posts and pages.
* Changed menu icon into a dashicon to improve visibility.
* Changed urls to https.

= 1.4.1 =
* Tested up to WP 4.1.
* Changed row actions text to only show 'Toggle' for first category to save space.

= 1.4.0 =
* Added filter to view uncategorized media files only.

= 1.3.1 =
* Fixed issue with finding taxonomies to use.

= 1.3.0 =
* Fixed issue with updating options.
* Improved support for MCM categories in modal edit mode.
* Improved support for Custom MCM names.
* Improved support for use of POST categories.
* Added support for new shortcode parameter "alternative_shortcode".

= 1.2.0 =
* Renamed "Media Categories" to "MCM Categories" for easier distinction from other taxonomies.
* Added support for media categories as defined by other plugins.
* Updated MCM Settings page to reflect support for other media categories.
* Added support for new shortcode parameter "taxonomy".

= 1.1.0 =
* Create default options when activating.
* Limit dark table header to WP_MCM shortcode screen only.

= 1.0.0 =
* Added category filter functionality when adding media to posts or pages.
* Added functionality to define default category when adding or editing a media file.
* Added a switch to enable and disable the assignment of default category.
* Added category filter functionality to the media grid view.
* Added a new screenshot showing filter in media grid view.

= 0.2.0 =
* Fixed bug managing post categories in combination with "Use Post Taxonomy" flag.
* Improved asset images for repository.

= 0.1.0 =
* First version starting the plugin.

== Upgrade Notice ==

= 1.4.3 =
* Fixed some issues, see change log.

= 1.4.2 =
* Fixed some issues, see change log.

= 1.4.1 =
* Fixed some issues, see change log.

= 1.4.0 =
* Added new functionality and fixed some issues, see change log.

= 1.3.1 =
* Fixed some issues, see change log.

= 1.3.0 =
* Added new functionality and fixed some issues, see change log.

= 1.2.0 =
* Added new functionality, see change log.

= 1.1.0 =
* Added new functionality, see change log.

= 1.0.0 =
* Added new functionality, see change log.

= 0.2.0 =
* Fixed bug managing post categories in combination with "Use Post Taxonomy" flag.
* Improved asset images for repository.

= 0.1.0 =
As this is the first version, there is no upgrade info yet.
