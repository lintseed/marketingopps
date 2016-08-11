=== Dashboard Widgets Suite ===

Plugin Name: Dashboard Widgets Suite
Plugin URI: https://perishablepress.com/dashboard-widgets-suite/
Description: Provides a suite of sweet widgets for your WP Dashboard.
Tags: dashboard, widget, widgets, user notes, notes, todo, memo, rss, social, server, debug, log
Author: Jeff Starr
Contributors: specialk
Author URI: http://monzilla.biz/
Donate link: http://m0n.co/donate
Requires at least: 4.1
Tested up to: 4.5
Stable tag: trunk
Version: 1.1
Text Domain: dws
Domain Path: /lang/
License: GPL v2 or later

Pimp your Dashboard with a sweet collection of custom widgets.



== Description ==

__1 Plugin. 9 Widgets. Awesome Dashboard.__

_Streamline your Admin Area by reducing the number of plugins required for widgets._

Dashboard Widgets Suite provides an entire set of awesome widgets that you can add to your WordPress Dashboard:

* __Control Panel__ - Enable/disable widgets directly from the Dashboard
* __User Notes__    - Add, edit, delete notes for any user role
* __Feed Box__      - Display and customize any RSS Feed
* __Social Box__    - Display social media links from Twitter, Facebook, etc.
* __List Box__      - Display a custom list of links created via the Menu screen
* __Widget Box__    - Display any theme or WP widget (e.g., Meta, Search, Text)
* __System Info__   - Display basic or advanced system info (e.g., WP, PHP, server, client)
* __Debug Log__     - Display, customize, reset your WP debug log
* __PHP Error Log__ - Display, customize, reset your server error log

Each widget includes its own set of options for customizing display. 

The notes widget is super awesome, designed for serious note takers :)

_[Suggest a widget!](https://perishablepress.com/contact/)_



**Features**

Dashboard Widgets Suite provides a slick set of useful Dashboard widgets with some great features:

* Includes 9 awesome Dashboard widgets
* Easy to set up and customize options
* Squeaky clean, error-free code
* Built with the WordPress API
* Well-styled and elegant display
* Born of simplicity, no frills
* Lightweight, fast and flexible
* Focused on performance, loads only enabled widgets
* Enable/disable widgets via Dashboard or plugin settings
* Option to restore 1-column display for the Dashboard
* Shortcodes to display widgets on the frontend
* Many options for customizing widget display

[Check out the Screenshots](https://wordpress.org/plugins/dashboard-widgets-suite/screenshots/) for more details!

_[Suggest a feature!](https://perishablepress.com/contact/)_



== Screenshots ==

1.  DWS Dashboard: All widgets enabled
2.  DWS Settings:  General Settings
3.  DWS Settings:  User Notes
4.  DWS Settings:  Feed Box
5.  DWS Settings:  Social Box
6.  DWS Settings:  List Box
7.  DWS Settings:  Widget Box
8.  DWS Settings:  System Info
9.  DWS Settings:  Debug Log
10. DWS Settings:  Error Log



== Installation ==

**Installing Dashboard Widgets Suite**

1. Upload the plugin to your blog and activate
2. Visit the settings and enable desired widgets
3. Visit the WP Dashboard to use your new widgets

Tip: you can enable/disable widgets via the plugin settings or via the Control Panel widget on the Dashboard.

_[More info on installing WP plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)_



**Uninstalling**

Dashboard Widgets Suite cleans up after itself. All plugin settings will be removed from your database when the plugin is uninstalled via the Plugins screen.



**Restore Default Options**

To restore default plugin options, either uninstall/reinstall the plugin or visit the General Settings &gt; Restore default plugin options.



**Shortcodes**

DWS provides several shortcodes for displaying widgets on the frontend of your site. Here is a summary:

	[dws_feed_box]   => Feed Box
	[dws_social_box] => Social Box
	[dws_user_notes] => User Notes
	
You can add these to any WP Post or Page to display the widget on the frontend. The same widget settings apply to both frontend and backend display.



**Customizing**

Dashboard Widgets Suite provides plenty of settings to customize your widgets. For advanced customization, developers can tap into the power of WordPress Action and Filter Hooks. Here is a complete list of the hooks provided by Dashboard Widgets Suite:

	
	Action Hooks
	
	dashboard_widgets_suite
	dashboard_widgets_suite_control_panel
	
	dashboard_widgets_suite_feed_box
	dashboard_widgets_suite_feed_box_frontend
	
	dashboard_widgets_suite_list_box
	
	dashboard_widgets_suite_log_debug
	dashboard_widgets_suite_log_error
	
	dashboard_widgets_suite_notes_user
	dashboard_widgets_suite_notes_user_submit
	dashboard_widgets_suite_notes_user_frontend
	
	dashboard_widgets_suite_social_box
	dashboard_widgets_suite_social_box_frontend
	
	dashboard_widgets_suite_system_info
	
	dashboard_widgets_suite_widget_box
	
	
	Filter Hooks
	
	dashboard_widgets_suite_options_general
	dashboard_widgets_suite_get_options_general
	
	dashboard_widgets_suite_options_feed_box
	dashboard_widgets_suite_get_options_feed_box
	dashboard_widgets_suite_feed_box_data
	dashboard_widgets_suite_feed_box_output
	dashboard_widgets_suite_feed_box_suffix
	dashboard_widgets_suite_feed_box_frontend_data
	
	dashboard_widgets_suite_options_list_box
	dashboard_widgets_suite_get_options_list_box
	dashboard_widgets_suite_list_box_menu_name
	
	dashboard_widgets_suite_options_log_debug
	dashboard_widgets_suite_get_options_log_debug
	dashboard_widgets_suite_log_debug_clear
	dashboard_widgets_suite_log_debug_errors
	dashboard_widgets_suite_log_debug_level
	dashboard_widgets_suite_log_debug_path
	
	dashboard_widgets_suite_options_log_error
	dashboard_widgets_suite_get_options_log_error
	dashboard_widgets_suite_log_error_clear
	dashboard_widgets_suite_log_error_errors
	dashboard_widgets_suite_log_error_level
	dashboard_widgets_suite_log_error_path
	
	dashboard_widgets_suite_options_notes_user
	dashboard_widgets_suite_get_options_notes_user
	dashboard_widgets_suite_notes_user_data_add
	dashboard_widgets_suite_notes_user_data_delete
	dashboard_widgets_suite_notes_user_data_edit
	dashboard_widgets_suite_notes_user_data_form
	dashboard_widgets_suite_notes_user_data_get
	dashboard_widgets_suite_notes_user_example
	dashboard_widgets_suite_notes_user_message
	dashboard_widgets_suite_notes_user_style
	dashboard_widgets_suite_notes_user_frontend_data
	dashboard_widgets_suite_notes_user_frontend_view
	
	dashboard_widgets_suite_options_social_box
	dashboard_widgets_suite_get_options_social_box
	dashboard_widgets_suite_social_box_output
	dashboard_widgets_suite_social_box_frontend_data
	
	dashboard_widgets_suite_options_system_info
	dashboard_widgets_suite_get_options_system_info
	
	dashboard_widgets_suite_options_widget_box
	dashboard_widgets_suite_get_options_widget_box
	
	dashboard_widgets_suite_allowed_tags
	dashboard_widgets_suite_editable_roles
	dashboard_widgets_suite_get_date
	

_[Suggest a hook!](https://perishablepress.com/contact/)_



== Upgrade Notice ==

To upgrade Dashboard Widgets Suite, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database. 

__Important:__ User Notes are not deleted, so if you want to delete them, do so via the WP Dashboard before uninstalling the plugin.



== Frequently Asked Questions ==

**Can you add this widget or that widget?**

Yeah maybe, feel free to [suggest a widget!](https://perishablepress.com/contact/)


**Got a question?**

Send any questions or feedback via my [contact form](https://perishablepress.com/contact/)



== Support development of this plugin ==

I develop and maintain this free plugin with love for the WordPress community. To show support, you can [make a cash donation](http://m0n.co/donate), [bitcoin donation](http://m0n.co/bitcoin), or purchase one of my books:

* [The Tao of WordPress](https://wp-tao.com/)
* [Digging into WordPress](https://digwp.com/)
* [.htaccess made easy](https://htaccessbook.com/)
* [WordPress Themes In Depth](https://wp-tao.com/wordpress-themes-book/)

And/or purchase one of my premium WordPress plugins:

* [BBQ Pro](https://plugin-planet.com/bbq-pro/) - Pro version of Block Bad Queries
* [SES Pro](https://plugin-planet.com/ses-pro/) - Super-simple &amp; flexible email signup forms
* [USP Pro](https://plugin-planet.com/usp-pro/) - Pro version of User Submitted Posts

Links, tweets and likes also appreciated. Thank you! :)



== Changelog ==

**1.1 (2016/03/30)**

* Adds option to delete/reset all user notes
* Fixes incorrect localization parameter
* Changes default required role to administrator for debug and error logs
* Fixes two "Undefined variable" PHP Notices in debug and error logs
* Fixes PHP Warning with array_sum() function in System Info widget
* Adds setting to display any widget area in the Widget Box ([thanks Joan Boluda](https://boluda.com/))
* Adds setting to display any menu/list in the List Box Widget ([thanks Joan Boluda](https://boluda.com/))
* Improves handling of debug and error logs
* Improves functionality of System Info Widget
* Added more security checks to System Info Widget
* Tests on WordPress version 4.5 beta

**1.0 (2016/03/17)**

* Initial release


