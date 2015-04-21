=== Plugin Name ===
Contributors: keyword-strategy
Tags: Google+, Google Authorship, multiple writers, rel=author, author=me, brand pages
Requires at least: 3.0.0
Tested up to: 3.3.1
Stable tag: 1.5.0

This plugin allows Wordpress-driven websites with multiple authors to properly claim authorship, linking each individual writer to their associated Google+ profile page. Once the pages have been indexed, the profile picture of the writer will appear next to the entry in the Google search results.

== Description ==

In order to get the little photograph of the author beside articles in the search results, you need to “claim” yourself as the writer of the article by linking to your Google+ profile.

You can hardcode this for a single author website, but requires more complex hacking for a multiple author website, where each writer should get the credit for the articles they wrote, and lend their personal authority to help boost the pages in the search results.

This plugin adds a new Google+ field to every user profile in the WordPress database. Your authors can copy-paste their profile link into that field.

The plugin then automatically links back to the profile on every article they write, as defined by Google’s instructions.

You have to wait for the new pages to get indexed before the authorship photos appear beside your articles, but you can test your pages beforehand using the Rich Snippets tool.

== Installation ==

<ol>
<li>Extract and upload the `authorship-plugin` directory into `/wp-content/plugins`</li>
<li>Activate the plugin through the ‘Plugins’ menu in WordPress</li>
<li>Create a Google+ profile for each writer who will claim authorship</li>
<li>Each writer should update the “Contributor to” field in their Google+ profile to link to the website</li>
<li>Update each author’s profile to include a link to their Google+ profile.</li>
<li>Confirm that your authorship is working properly by verifying with Google’s <a href="http://www.google.com/webmasters/tools/richsnippets">Rich Snippets tool</a>.
</ol>

== Frequently Asked Questions ==

= I've installed the plugin, but I don't see my picture in the search results. =

The plugin configures your blog so that Google will incorporate your authorship information when it indexes your pages. But that can take days, weeks or even months. If you want to test out to see if your authorship is working properly, test out various pages in Google's Rich Snippet Testing Tool.

http://www.google.com/webmasters/tools/richsnippets

= Do I need a Google+ account to claim authorship? =

Yes, Google runs everything through the Google+ profile pages. You don't have to actively use Google+ but you at least need to create your profile page and link up the domain names of the websites that you write for.

== Upgrade Notice ==

Just replace old plugin files.

== Changelog ==

= 1.5 =
* Integrated the official google profile badge graphic for personal profiles (optional).
= 1.0 =
* First public release

