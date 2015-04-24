=== Simply Hide Pages ===
Contributors: julienvdg
Donate link: http://silicone.homelinux.org/
Tags: page, pages, hide, wp_list_pages, wp_list_pages_excludes, hide pages, hide menu pages, menu, exclude pages
Requires at least: 2.9
Tested up to: 3.0.1
Stable tag: trunk

Easy way to hide some pages from wp_list_pages output.

== Description ==

Easy way to hide some pages from wp_list_pages output.
Simply add the custom field 'hide' with any value to your page, and this page will no longer appear on the page list.
You could already do this on the 'Pages' widget or by adding the `exclude` parameter to all your `wp_list_pages` template tags. But now you can do it directly form the page editor which is, I believe, the best place to do so.

You might want to hide pages if you need some pages to exist but don't want them to appear on your page list. For instance as [Cool URIs don't change](http://www.w3.org/Provider/Style/URI "Cool URIs don't change"), but some services have been removed from your site, so you write a page explaining where to go to get the equivalent service now. (not a real redirect, but still useful sometimes). Of course you don't want this page on your page list, you prefer to only have the new services listed ;)

Unlike other more complex plugins, it uses custom field to avoid adding tables to your database.

== Installation ==

1. Download plugin archive and expand it
1. Upload `simply-hide-pages.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. To indicate that a page should be hidden when `wp_list_pages()` is used, edit the page that you do not want to see and create a custom field with a key of "hide" and value of "true" (or anything else it does not really matter).

== Frequently Asked Questions ==

Please see plugin homepage.

== Screenshots ==

1. Custom field needed on page to hide

== Changelog ==

= 1.0 =
* initial release
