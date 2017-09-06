=== CSS & JavaScript Toolbox ===
Contributors: wipeoutmedia
Author URL: https://easy-code-manager.com
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EWDWF75JHT9Q6
Tags: post, posts, admin, sidebar, page, pages, widget, image, shortcode, plugin, google, customise, style, scripts, hack, Wordpress, HTML, CSS, JavaScript, HTML5, jQuery, PHP, code, script, scripts, manage, management, display, output, header, footer, apply, requests, match, hook, execute, run
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 3.9
Tested up to: 4.8.1
Stable tag: 8.3.2

Easily add custom CSS, JavaScript, HTML and PHP code to unique CJT code blocks and assign them wherever you want.

== Description ==

= IMPORTANT NOTE: =
The CSS & JavaScript Toolbox plugin on WordPress.org is no longer supported. This has been replaced by our new code management plugin called Easy Code Manager, which you can download for free here: [Easy Code Manager on WordPress.org](https://wordpress.org/plugins/easy-code-manager)

This free version has been fully redesigned and does not have a number of features you would expect in CSS & JavaScript Toolbox. That said, you may wish to stay on CSS & JavaScript Toolbox unless you intend to update to our premium Easy Code Manager PLUS plugin.

= Easy Code Manager PLUS =
This is our premium plugin that extends the free version of Easy Code Manager - adding an amazing amount of features. Why not take a look to see if it suits your needs.  Click here: [Easy Code Manager PLUS](https://easy-code-manager.com)

= Compatibility =
At this stage CSS & JavaScript Toolbox and Easy Code Manager cannot be installed and activated at the same time. It is advised to BACKUP all your CSS & JavaScript Toolbox code blocks, code files and template data, and take note of all your assignments and shortcode placements. This is a precautionary recommendation so you don’t lose your work.

Once CSS & JavaScript Toolbox is deactivated, then you should be able to install and activate Easy Code Manager. Currently, both plugins share the same database structure and depending on your current version of CSS & JavaScript Toolbox, you may just see all your original CJT code blocks intact in the Easy Code Manager main dashboard. However, please do not rely on this and BACKUP all of your work before trying to install the Easy Code Manager plugins on your site.

= CSS & JavaScript Toolbox premium license holders =
If you are a premium CSS & JavaScript Toolbox (CJT) license holder with a valid license key that has NOT expired, you will be eligible to receive Easy Code Manager for free with one year of premium updates. Please send us a message along with your valid license key via our Contact page OR via: info (at) easy-code-manager.com

Thanks for your support.

== Installation ==
1. If you're upgrading from older versions its highly recommended to backup your database before upgrading.
2. Upload the 'css-javascript-toolbox' folder to the '/wp-content/plugins/' directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Click 'CSS & JavaScript Toolbox' link in the main navigation (left side of your Dashboard).

== Changelog ==

= 8.3.2 =
* Warning: Add CJT Plugin "not longer supported" notice

= 8.3.1 =
* Fix: Development log files created at production

= 8.3 =
* Enahnce: CJT Won't work and admin notice displayed when PHP version < 5.3
* Enahnce: Dashboard Statictics Metabox display more fields
* Enahnce: Update ACE Editor
* Fix: some commonly detected Plugins conflict compatibility
* Fix: SQL errors commonly appears in Error log file 
* Fix: Dashboard Statictics Metabox exception when CJT server is not reachable
* Fix: Dashboard Statictics Metabox blocks count includs backups block
* Enahnce: Update ACE Editor to the last version

= 8.2 =
* PHP version check on activation
* Fixed fatal error: 'break' not in the 'loop' or 'switch' context in /path/to/wp-content/plugins/css-javascript-toolbox/controllers/block.php on line 145
* Will display message during installation steps on network-level errors (before only endless animation was shown)
* Now CJT is compatible with BulletProof Security WP plugin, so CJT can be installed / used without extra changes in this security plugin

= 8.1 =
* Compatibility with Wordpress 4.3.1
* Core Upgrades/Enhancements

= 8.0.4 =
* Check Wordpress 4.3 compatibility
* List future deprecated features

= 8.0.3 =
* Add support us link to Dashboard metabpx
* Add support us link to CJT header

= 8.0.2 =
* Remove: CJT License Setup form as CJT is now 100% FREE.
* Fix: Multi site CJT Network Extensions is not loaded.

= 8.0.1 =
* Fix: Fresh installer stopped when 'Adding Wordpress built-in scripts and styles as CJT Templates'
* Fix: Dashboard metabox notices when CJT is not yet installed

= 8.0 =
* Show premium extensions list in Dashboard Widget instead of Scripts Packages
* Framework update that makes CJT functionality more extendable
* Remove: Editor Toolbox Buttons and Block File, Edit and View menu as it now presented in separated extension
* Remove: Editor Themes Switcher list as it now presented in separated extension
* Remove: Import and Export Tools as it not presented in separated extension
* Fix: Conflict with other themes like X Theme

= 7.2 =
* Fix: Block Code file name moving away when open/close Block metabox
* Fix: Shortcode list is too small for Shortcode names
* Enhance: CJT Framework for packages and extensions updates

= 7.1.2 =
* Enhance: Show Latest News on Dashboard Widget

= 7.1.1 =
* Enhance: Add Statistics Dashboard Widget that shows few useful fields.

= 7.1 =
* Enhance: Processing and Memory optimization for better performance.
* Enhance: Block Box Themes Support.
* Enhance: 32 Themes is now supported to be applied for the whole block box.
* Enhance: Applying theme per browser. Allow for assigning appropriate theme for different devices.
* Enhance: Assigned/All mode switchers for assignment panel list. You can show all items even not selected ones or show only assigned to the block.
* Enhance: Bullet-Proof Assignment Panel layout so it would always reserved even if another Plugin wrongly load jQuery TABS/ACCORDION Styles.
* Enahnce: General UI enhancements.
* Enahnce: Code editor updates.
* Enhance: Turns CJT Block into a tiny Project that host Multiple "Managed" Code-Files instead of just one.
* Enhance: No need to create a Block for each Language Type and assign them to the same Wordpress Page. One Block with Multiple Code Files solved that by creating only one Block for each assgined request.
* Enhance: Code Files Support Language Type, Code, Description and TAG fields.
* Enhance: Write Design-Time Organized Code by separating them into code-files (JS, CSS, PHP, HTML) and CJT will merge them all at run-time.
* Enhance: There is no need to write <script>, <style> or <?php ?> tags when writing Javascript, CSS or PHP Codes. Code File assigned language would take care of that.
* Enhance: Control/Modify auto-added <script>, <style> or <?php ?> TAGS by modifying Code File TAG field.
* Enhance: Automatically Change Code Editor language to currently active Code File language.
* Enhance: Manage Code Files without leaving the Block Page.
* Enhance: Block revision is now created based on the Current Active Code File. Therefore each Code File has its owen revisions.
* Enhance: Its now possible for multiple Authors to work on the same Block by creating Multiple Code-Files.
* Enhance: Add Multiple Code Files to CJT Packages.
* Enhance: Block File, Edit and View Menus.
* Enhance: 'Load Local', 'Load Url' and 'Reload' to load Block Code from Local File, Url and Reload From Server respectively.
* Enhance: Save/Download Block Current Active Code File.
* Enhance: Undo, Redo, Find, Find Next, Find Previous, Replace, Goto Line, Goto Line Up, GoTo Line Down, GoTo Next Error, GoTo Previous Error, Fold, Fold All, UnFold, UnFold All, To Lower Case and To Upper Case Edit Menu functions added.
* Enhance: 'Settings' Edit Menu item for Fully Customize Code Editor Fonts, Show/Hide Print Margine, Keybinding Methods, Show/Hide Scroll, Scroll Speed, Readonly, Show/Hide Gutter, TAB Size, New Line Mode and much more!
* Enhance: Show/Hide StatusBar via View StatusBar Menu.
* Enhance: CJT Website is now support Full documentation Tutorials that expose many internal features/possibilities that can be achived by CJT.
* Enhance: Code Blocks disappeared after upgrading to Wordpress 3.9 and sever running PHP >= 5.5.
* Enhance: Packages Management System (BETA)
* Enhance: Define Shortcode Parameters by creating package and input their values from the CJT Shortcode Parameters form.

= 6.1.5 =
* Enhance: Editor enhancements and updates.
* Enhance: Framework updates (Allow installing New CAC extension).
* Fix: Safari Browser pagination icon position.

= 6.1.4 =
* Fix: Assignment Panel Pagination Icon position fixed for Safari browsers.
* Remove: New Block Form Activate, Location Hook and Initial position fields.
* Remove: Block Revisions.
* Remove: Blocks Backup and Restore.
* Remove: Assignment Panel Select-Childs Checkboxes.
* Remove: Minimize and Mazimize All.
* Remove: Batch Process (Delete All and Delete Empty).
* Remove: Output Location Switch (Header and Footer).
* Remove: State Switch (Activate, Deactivate and Invert).
* Remove: Shortcode TinyMCE button (Community users has to write Shortcode manually).
* Remove: Don't load more assignment objects by scroll (Community users has to use the pagination list).

= 6.1.3 =
* Enhance: UI Compatibility with Wordpress >= 3.8.
* Deprecated: New Block Form Activate, Location Hook and Initial position fields.
* Deprecated: Block Revisions.
* Deprecated: Blocks Backup and Restore.
* Deprecated: Assignment Panel Select-Childs Checkboxes.
* Deprecated: Minimize and Mazimize All.
* Deprecated: Batch Process (Delete All and Delete Empty).
* Deprecated: Output Location Switch (Header and Footer).
* Deprecated: State Switch (Activate, Deactivate and Invert).
* Deprecated: Shortcode TinyMCE button (Community users has to write Shortcode manually).
* Deprecated: Don't load more assignment objects by scroll (Community users has to use the pagination list).

= 6.1.2 =
* Fix: Break Wordpress frontend page pagination by issuing 301 redirect.

= 6.1.1 =
* Fix: Validate block name when editing and adding blocks.
* Fix: Code Blocks is not being applied on WPEngine servers and other servers related to the MYSQL query error.
* Fix: Load block code one time after its first time opened as it was loaded every time the block is opened.
* Enhance: Show User-PHP code errors only when WP_DEBUG is set to TRUE.
* Enhance: Auto-Size edit-block-name text field to fit the current block-name, therefor display the name without the need of moving the cursor to the end.
* Enhance: Disable new-block form fields while saving prevent user from duplicating block when traffic is slow.

= 6.1 =
* Enhance: Initially don't load Block assignment panel items: Speed up Blocks page loading time when its initially opened, also affect the browser performance as the items is not loaded or rendered before its required.
* Enhance: Initially don't load Block code for the closed/minimised Blocks: Loading those Blocks will be done through AJAX once the Block is opened by user.
* Enhance: The ability to 'Cancel' revision mode and get back to the normal mode without refreshing the whole page.
* Update: Animate Block 'Save' button for not-saved Blocks.
* Update: The Assignment-Panel is now Loads the assigned items only when enter the revision and backup modes.
* Update: Set assignment-Panel Advanced-TAB as the default active TAB.
* Add: Few helper links to the CJT official website at the top of the Blocks page.
* Fix: Block 'Save' and 'Save All Changes' buttons are stay enabled after updating Block Assignment-Panel items and revert them back again. The buttons is enabled even if the Block content has not been changed.

= 6.0.15 =
* Enhance: Uninstaller is now configurable so that admin can specify is to wipeout the data or not! This is really great for manual upgrade to the PE versions!

= 6.0.14 =
* Add: Accept Shortcode parameters and segments. Provide PHP framework for code blocks to define, validate and reading Shortcode parameters.
* Add: Allow using block 'name' in additional to 'id' when using Shortcodes.
* Fix: Failed to work with non-ascii (e.g Arabic) characters.
* Enhance: Viewing block info is now showing Shortcode using block 'name' instead of 'id'.
* Enhance: Embedded Shortcode with its closing tag as the Shortcode content is now being used by the handler blocks.
* Enhance: Revert block Shortcode 'force' parameter default value to 'true' therefore allow using multiple Shortcode for the same block without setting 'force' attribute.

= 6.0.13 =
* Fix: CJT hijacks Plugins page after activate or deactivate a Plugin.

= 6.0.12 =
* Fix: PHP code is not getting evaluated when CJT code Block delegated using Shortcode.

= 6.0.11 =
* Fix:  Add ACE Editor PHP Worker as it was missing.
* Enhancement: List only Public Custom Posts that can be accessed through Wordpress URL under Assignment Panel Custom Posts Tab. Therefor enhance performance for sites that has 'Log' custom post that might has hundreds or records read for every code block.

= 6.0.9 =
* Enhancement: Suppress PHP errors displayed under STRICT PHP configuration like PHP >= 5.4.x and therefor boost performance, increase result and security reliability!
* Fix: Installer operations state is cleared after the install/upgrade is interrupted, cause the repeats/re-executes of the install/upgrade operations.

= 6.0.7 =
* Fix: textarea HTML tag break down CJT Block code.

= 6.0.6 =
* Fix: Conflict with other Plugins!
* Fix: Javascript exception thrown when dismissing the install/upgrade notice.
* Enhancement: Disallow (with user notice) upgrade/downgrade if the target version is not being supported, therefor saving user data!
* Enhancement: Don't break down the site if manual upgrade/downgrade process is uncompleted! Allow user to revert back manually or disable the Plugin.
* Enhancement: E_ALL complain! Suppress all notices when WP_DEBUG set to true, allow better development, fast performance and error handling.

= 6.0 =
* Core code is 100% re-written for optimum performance and future enhancements, and is 100% based on MVC (Model–view–controller) design.
* 100% Using Web 2.0
* Applying code blocks to the requests are now enhanced to boost performance.
* The ability of interacting with admin pages too - not only the website side as in the previous versions.
* Light-weight and smart user-interface.
* Multiple operations can be executed at a time! For example, you can work on a code block while another block(s) is saving.
* Code block data is automatically revisioned after saving.
* Hot Key added for saving code block.
* Empty blocks can now exist.
* Interaction with each code block from a simple smart graphical Toolbox using Web 2.0
* Delegate code block using Shortcodes. You can do that manually or through CJT smart TinyMCE dropdown list button.
* Integrate ACE Editor to provide syntax highlighting and correction while writing codes!
* Syntax highlighting for 4 languages: CSS, HTML, JavaScript and PHP.
* Entire plugin is now extensible! CJT supports installed extensions to extend or enhance its features.
* Batch operations (Toggling On and Off, Activate, Deactivate and Revert states, Delete empty and Delete all) toolbox allow for batch update of all code blocks.
* Rename and save code block name.
* You can now save multiple backups.
* Activate and Deactivate code blocks feature.
* Fix: blocks order was correctly displayed from the admin side, but had no effect while applying blocks to the website side.
* Templates system is totally removed and will be presented with many enhancements via a separate extension.
* Allow assigning code blocks to Posts and Custom Posts.
* Apply 'Category' block to all the child posts (or sub-posts) within that category.
* Assignment Panel smart feature to assist while working with hierarchical items (sub-pages, sub-categories, etc).
* Auxiliary tab has been added to the Assignment Panel in order to organise all the predefined items (or requests) under a single tab.
* Moved and added: 'Front Page', 'All Pages' and 'All Posts' predefined items to appear under the Auxiliary tab.
* Newly defined: Blog Index, All Categories, Recent Posts, Entire Website, Website Backend, Search Pages, All Archives, Tag Archives, Author Archives, Attachment Pages and 404 Error, which are listed under the Auxiliary tab.
* Support of regular expressions for defining code block Point-To-Hook
* Security enhancements, only administrators can execute CJT backend operations.
* Each block has an Information metabox (Author, created date, modification date, and Shortcode).
* Create new block with initial properties (state, name and position).
* Internal error detection routine for detecting Ajax errors that may have happened away from users view.
* There is an extensive CJT User Manual PDF file attached in the /docs folder.  You can also download this file through the website - click for [CJT Free User Manual](http://css-javascript-toolbox.com/css-javascript-toolbox-free)
* Use of a separated Dashboard item to embrace all CJT plugin pages.
* Added separate installer and upgrade pages for both CJT v0.3 and v0.8 to allow watching of the installation processes.
* Added an uninstaller to completely erase all CJT data from the system.
* 100% tested and working with BPS (BulletProof Security) plugin, after applying [simple Ajax bypass rule](http://css-javascript-toolbox.com/support/topic/bulletproof-security-ajax-issue-and-resolution-2)

= 0.8 =
* Modifying template code.
* Header and footer hooks support so you can select which hook to output CSS/JS code.
* Code blocks can be reordered.
* Code blocks can now be given names that can be edited and saved.
* New icons and improved UI.
* Multilingual support: Only English translation is shipped with this version.
* Style overriding: code blocks order will allow any higher-positioned blocks style syntax to override lower-positioned blocks style syntax.
* Embedded Scripts: Embedded WordPress or Scripts that are shipped out with CJToolbox plugin by just checking them.
* Backup and Restore blocks data.
* Bug Fix: New code blocks are not toggling unless the page is refreshed.
* Bug Fix: CSS/JS template extra slash character problem.
* Bug Fix: Code block deletion issues.
* Bug Fix: Code is not applied to the URL list except the last URL.
* Bug Fix: Cannot use string offset as array error.
* Bug Fix: Invalid argument supplied foreach() error.

= 0.3 =
* This is the very first release.

== Credits ==
    
Copyright © 2017, Wipeout Media.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.