=== mPress Fix URL References ===
Contributors: woodent
Donate link: https://www.paypal.me/wpscholar
Tags: mpress, database, migrate, migration, URL, link, links
Requires at least: 3.2
Tested up to: 4.5.2
Stable tag: 1.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Easily fix URL references in your WordPress database.

== Description ==

The **mPress Fix URL References** plugin allows you to easily fix URL references in your WordPress database.

= Why? =

When you move your site from one domain to another, there is no built-in process for updating URL references in the database. For example, if you have internal links in your post content that point to the full URL of other pages on your site, these URL references will become invalid when you migrate your site to a new domain. If you aren't a developer who knows how to write MySQL queries, replacing potentially thousands of instances of incorrect URLs is a real pain.  No worries.  I'm a developer and I've done all the work for you.

= How? =

Using this plugin is simple:

1. Ensure that you define the [WP_HOME](http://codex.wordpress.org/Editing_wp-config.php#Blog_address_.28URL.29) and [WP_SITEURL](http://codex.wordpress.org/Editing_wp-config.php#WordPress_address_.28URL.29) constants in your wp-config.php file.  It's not that hard.
2. Install the plugin
3. Activate the plugin
4. In the WordPress admin, click on 'Fix URL References' in the 'Tools' menu
4. Enter the URL that you want to have replaced
5. Click on 'Fix References'

= Features =

* Clean, well written code that won't bog down your site

== Installation ==

= Prerequisites =
If you don't meet the below requirements, I highly recommend you upgrade your WordPress install or move to a web host
that supports a more recent version of PHP.

* Requires WordPress version 3.2 or greater
* Requires PHP version 5 or greater ( PHP version 5.2.4 is required to run WordPress version 3.2 )

= The Easy Way =

1. In your WordPress admin, go to 'Plugins' and then click on 'Add New'.
2. In the search box, type in 'mPress Fix URL References' and hit enter.  This plugin should be the first and likely the only result.
3. Click on the 'Install' link.
4. Once installed, click the 'Activate this plugin' link.

= The Hard Way =

1. Download the .zip file containing the plugin.
2. Upload the file into your `/wp-content/plugins/` directory and unzip
3. Find the plugin in the WordPress admin on the 'Plugins' page and click 'Activate'

= Usage Instructions =

Before you do anything else, this plugin requires that you define the [WP_HOME](http://codex.wordpress.org/Editing_wp-config.php#Blog_address_.28URL.29) and [WP_SITEURL](http://codex.wordpress.org/Editing_wp-config.php#WordPress_address_.28URL.29) constants in your wp-config.php file.  

Once the plugin is installed and activated, just click on 'Fix URL References' in the 'Tools' menu on the left hand side in the WordPress admin area.  Next, simply enter the old URL you want to have replaced and click 'Fix References'.  Yep... it's that easy.

== Frequently Asked Questions ==

By default, this plugin only replaces URLs in specific tables and fields that would typically have URL references.  I understand that this doesn't meet everyone's use cases, so this plugin exposes a simple PHP function for replacing string content from any given table and field.

Please only use this function if you know what you are doing:

`mPress_Fix_URL_References::run_replacement_query( $table, $field, $old, $new );`

This plugin replaces content in the 'post_content' field in the 'posts' table. The line of code below is from this plugin and is given as an example of how to use this function:

    mPress_Fix_URL_References::run_replacement_query( 
        'posts', 
        'post_content', 
        'http://www.old-domain.com', 
        'http://www.new-domain.com' 
    );

Notice how the table name doesn't include the WordPress table prefix.  This gets added automatically.

== Screenshots ==

1. Go to 'Tools' -> 'Fix URL References' to get started.

== Changelog ==

= 1.0 =

* Updated to release version after testing in WordPress 4.5.2

= 0.2 =

* Removed deprecated screen_icon() function (props Shelob9)

= 0.1 =

* Initial commit

== Upgrade Notice ==

= 1.0 =
Plugin is compatible with WordPress 4.5.2