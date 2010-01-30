=== Plugin Name ===
Contributors: leftcolumn
Donate link: http://labs.leftcolumn.net/stoken-console/
Tags: console, tools
Requires at least: 2.5
Tested up to: 2.9.
Stable tag: trunk

Adds an interactive console to Wordpress and allows you to add text Tokens that reveal corresponding text Secrets.

== Description ==

SToken Overview

This plugin lets you add an interactive console to your Wordpress site, then set up 'Tokens' that 
control access to 'Secrets.' Your users type the Token into the console to reveal the corresponding secret. 
You manage the process via the Wordpress Admin Dashboard.

So why is this useful? Well it means you can <em>selectively share semi-secret information</em>
with anyone who visits your site. Here are some examples:

	* MP3 Download links for bands: say you want your fans to enter a promo code first
	* Text adventures, puzzles, and so on
	* Check out the live demo at http://labs.leftcolumn.net/stoken-console/

More Information

The SToken Console is achieved using a simple HTML form. It is not a true console. It doesn't 
open up SSH access to your Web Site and should not present any security risk, but no claims are 
made as to quality. It is released under the GPL. Support questions should be raised here in the form of comments. 

The Tokens and Secrets are stored in your Wordpress Database and are not encrypted. Because
they are not encrypted I don't recommend storing highly sensitive information. The Tokens
can contain spaces and almost any other characters. Currently Tokens are limited
to 255 characters. Secrets can be big. There is no limit on the number of Token/Secrets.



== Installation ==


1. Unzip 
2. Upload the whole 'stoken' folder to the '/wp-content/plugins' directory. 
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to Tools->SToken Tokens and add whatever tokens you like. 
5. To add the SToken Console to a Post or Page use:
[stoken]


== Frequently Asked Questions ==

= How do I get suppport? =

Check the Website for support and updates: http://labs.leftcolumn.net/stoken-console/

== Screenshots ==

1. The SToken Console, pictured here in frivolous use.
2. The Administration page lets you Add, Edit, and Delete tokens.

== Changelog ==

= 0.7 =
* First released Version.

