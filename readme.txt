=== Plugin Name ===
Contributors: Cjunghanns
Donate link: http://www.christian-junghanns.de/wpec-goodrelations
Tags: GoodRelations, rdfa, e-commerce, shopping, cart, semantic, web, wpec, ecommerce, seo, richsnippets, google, search engine optimization
Requires at least: 3.0
Tested up to: 3.0.4
Stable tag: 0.1.8

Adds GoodRelations metadata as RDFa to WP e-Commerce plugin

== Description ==

This plugin enriches your WP e-Commerce Store with RDFa Data for the Semantic Web.

Search engines are herewith able to read all details of your products description and is reported to improve your ranking in search engine results.

GoodRelations is already in use by companies like Google, BestBuy, Overstock.com, Yahoo, OpenLink Software, O'Reilly Media, the RDF Book Mashup and many others.

To increase your visibility in the Web, you should install a separate plugin which creates a sitemap.xml, enable the product rating feature of WP e-Commerce and activate the permalink feature of Wordpress! 

wpec-goodrelations requires at least:

* WordPress version 3.0 ( uses home_url() ) 
* WP e-Commerce 3.7.6.7


For a working livedemo of wpec-goodrelations please visit:
http://www.christian-junghanns.de/wpec-livedemo

== Installation ==

1. Unzip the archive.
2. Upload the 'wpec-goodrelations' folder to the '/wp-content/plugins/' directory
3. Activate the Plugin through the 'Plugins' menu in the WordPress Administration
4. Click 'GoodRelations' in the WP e-Commerce 'Store' menu and follow the instructions

== Frequently Asked Questions ==

= Google is not displaying my product in search results with a rich snippet =

Up to today, Dec 02 2010, google displays GoodRelations based rich snippets only in the United States.
Hopefully this will change in the future.

= I don't know how to handle with the global product options =

Global product options are global settings for all products. You may define each of the global settings individually for each product.

= I don't want all my products displayed with GoodRelations RDFa data =

Just edit the product you don't want to show with GoodRelations RDFa data and click in the GoodRelations section on 'Don't add GoodRelations annotation for this product.'

= What is GoodRelations =

GoodRelations is a web vocabulary for describing products and services and may be combined with any other existing web vocabulary.
For further information about GoodRelations visit [http://purl.org/goodrelations](http://purl.org/goodrelations)

= There are errors on my products pages =

Please contact me! I will check these errors and will provide an update asap!

== Changelog ==

= 0.1.8 =

* removed question for feedback in goodrelations admin pages
* added gr:eligibleRegions

= 0.1.7 =

* extended support for gr-notify.appspot.com
* bugfix for gr-notify function

= 0.1.6 =

* added support for gr-notify.appspot.com, to automatically notify the web of data about your sitemap.xml

= 0.1.5 =

* bugfix: now checking before executing foreach if var is an array
* companydata is now displayed on static front pages, too

= 0.1.4 =

* added category support (products which are only shown in category will be annotated with a product permalink in the categories)

= 0.1.3 =

* bugfixed the product template

= 0.1.2 =

* bugfixed 'edit products', was working but not displayed in the 'edit products' section

= 0.1.1 =
* bugfixed several minor bugs
* changed setup
* changed rdfa models for google support
* adding of serialnumber includes product as ActualProductOrServiceInstance
* rdfa-data may be displayed on category pages

= 0.1 =
* Initial version

== Upgrade Notice ==

= 0.1.8 =

Follow the installation instructions and override all existing files!
or just click "Update Plugins"

= 0.1.7 =

This update is important! Update as quick as possible!
Follow the installation instructions and override all existing files!

= 0.1.6 =

Added support for gr-notify for automatically notifying the web of data about your content.
Follow the installation instructions and override all existing files!

= 0.1.5 =

This update is important! Update as quick as possible!
Follow the installation instructions and override all existing files!

= 0.1.4 =

Follow the installation instructions and override all existing files!
or just click "Update Plugins"

= 0.1.3 =

This update is important!
Follow the installation instructions and override all existing files!

= 0.1.2 =

Just follow the installation instruction and override all existing files

== Screenshots ==

1. Global Product Options

2. Add / Edit Products

3. Pagesource with RDFa