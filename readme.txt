=== BuddyPress Group Type Search ===
Contributors: wbcomdesigns, vapvarun
Donate link: https://wbcomdesigns.com/donate/
Tags: buddypress, groups
Requires at least: 3.0.1
Tested up to: 4.8
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin modifies the search template that is on the "/groups" page. It adds a feature of "group types" that are involved while searching groups. Now the users can search groups based on group types.

 It requires BuddyPress to be installed and activated. To create Group types for BuddyPress, you can use [BP Create Group Type](https://wordpress.org/plugins/bp-create-group-type/). 

If you need additional help you can contact us for [Custom Development](https://wbcomdesigns.com/contact/).
Note: For Multisite please activate it where BuddyPress is activated. Like if Buddypress is network activated so also network activate this plugin. and use define('BP_ENABLE_MULTIBLOG', true ); in config.php file for seprate blog. if BuddyPress is activated seprate domain so please activate this plugin to seprate blog.

== Installation ==

1. Upload the entire "buddypress-groups-search" folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= How to configure setting for BP Group Types Search plugin? =

To Configure BP Group Types Search plugin. Follow the steps given below.
Step 1) Login to the WordPress Dashboard.
Step 2) From the Admin Panel, click on Settings >> BuddyPress.
Step 3) BuddyPress Setting page will appear. Here Click on Options Tab and scroll down to the bottom of page for setting.
You can also access/open this page directly from plugin section by clicking on Settings link under BP Group Types Search Plugin

= How can we search the groups by using this plugin? =
 
Simply goto the groups directory from site front, you can see the search bar appearing above the groups listing. There you can see the "select" box that lists all the group types on the site. You can select any group type from search group type filter and click on search button to perform a search. You can also search by search text box by typing any keyword available in the title and description of the groups. The group type search will work according to the settings in the admin section.
You can also see the page numbers before and after searched groups. You can click on any page number to jump related page. The attached screenshot will help you better understand the purpose. The screenshot is within the plugin folder.

= What Is The Basic Difference Between Search Text Box And Group Type Search Filter? =
Search text box accepts a keyword from you and searches for groups in which that particular keyword matches in their title and description.
Group type search filter shows you all group types in a drop down list. You can choose any group type from the list and perform a search. This will search all those groups which are of that particular group type and list on the screen.
Both of these searches work individually as well as together. It means you can use both of them at a time and search result will show accordingly.

== Screenshots ==
1. The screenshot shows the modified search template on buddypress groups page and corresponds to screenshot-1.(png|jpg|jpeg|gif).
2. The screenshot shows the plugin name on plugins listing page on admin panel and corresponds to screenshot-2.(png|jpg|jpeg|gif).
3. The screenshot shows the modified search template on buddypress groups page and corresponds to screenshot-3.(png|jpg|jpeg|gif).
4. The screenshot shows the modified plugin name on plugins listing page on admin panel and corresponds to screenshot-4.(png|jpg|jpeg|gif).
5. The screenshot shows the plugin settings on buddypress setting page and corresponds to screenshot-5.(png|jpg|jpeg|gif).

== Changelog ==
= 1.0.0 =
* Initial release.
= 1.0.1 =
* Updated release.

== Upgrade Notice ==
= 1.0.0 = This version is the initial version of the plugin with basic search functionality.
= 1.0.1 =
Search option fixes
= 1.0.2 =

Plugin multisite support added.
Settings added in wp-admin where user can set which type of search filter (text, select or both) will be shown on front-end for group searching also user can set the number of groups to shown in a single group page after search.
On frontend now it can show the hidden groups also after search only if loggedin user has the privilege to see them.
