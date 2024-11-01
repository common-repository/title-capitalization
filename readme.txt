=== Title Capitalization ===
Contributors: multippt
Tags: post, titles, automated
Requires at least: 1.5
Tested up to: 2.3.1
Stable tag: 1.01
Donate link: http://www.tevine.com/donate.php

This plugin automates the process of capitalizing titles.

== Description ==

The plugin automates the process of capitalizing titles. This is useful for making posts look more formal.

== Installation ==

By installing the plugin, you agree to [Tevine's policies](http://www.tevine.com/policies.php "Tevine's Policies").

1. Upload the "capital-titles.php" file to the plugins folder (which is located at `wp-content/plugins/`)

2. Login to your Wordpress Administration Panel

3. Go to the plugins tab, and activate the "Title Capitalization" plug-in. 
If there are no error messages, the plugin is properly installed.

4. You can edit options in the Wordpress Administration area (`Options > Title Capitalization`). Some formats supported in this plugin are:

 * None: No changes made to the title
 * All-uppercase letters: Same as applying ALL-CAPS to the title
 * All-lowercase letters: No capitalization at all
 * Capitalize only first word: Only the first word in the title is capitalized
 * Capitalize all words: All words are capitalized
 * Capitalize all words, except for internal articles and preposition: All words are capitalized except for some special words like "the".
 * Capitalize all words, except for internal articles, preposition and forms of to and be: Same as above, except more words are included like "with".
 * Capitalize all words, except for most words in closed-classes: Same as above, except more words are included like "its".

Feel free to poke around the internals of the plug-in.

== Updating ==

The procedure involves the replacement of files. You can check if your current revision is at its latest version via the `Options > Title Capitalization` panel.

1. Deactivate the "Title Capitalization" plug-in
2. Upload the latest version of the "capital-titles.php" file to replace the older one. 
3. Activate the "Title Capitalization" plug-in.

== Requirements ==

1. A working Wordpress install

== Frequently Asked Questions ==

**That's it? No editing of templates?**

Installing this plugin does not require the editing of your template files. Deactivating the plugin will revert titles to their original form.

**What does it affect?**

This plugin affects titles in posts (i.e. they use `the_content()` or `get_the_content()` functions in the Wordpress template)

== Changelog ==

* 1.0.1 - Added update notification
* 1.0.0 - Initial
