# mPress Fix URL References

## Description
Easily fix URL references in your WordPress database.

### How?

Using this plugin is simple:

1. Ensure that you define the [WP_HOME](http://codex.wordpress.org/Editing_wp-config.php#Blog_address_.28URL.29) and [WP_SITEURL](http://codex.wordpress.org/Editing_wp-config.php#WordPress_address_.28URL.29) constants in your wp-config.php file.  It's not that hard.
2. Install the plugin
3. Activate the plugin
4. In the WordPress admin, click on 'Fix URL References' in the 'Tools' menu
4. Enter the URL that you want to have replaced
5. Click on 'Fix References'

https://wordpress.org/plugins/mpress-fix-url-references/

## Feature Requests

If there is a feature or integration that you are interested in, please let me know. What I build will be entirely based on what my users need, so let your voice be heard by creating a [new issue on GitHub](https://github.com/wpscholar/mPress-Fix-URL-References/issues/new).

## Contributors

### Pull Requests
All pull requests are welcome.  If you would like to submit a translation, this is the place to do it!

### SVN Access
If you have been granted access to SVN, this section details the processes for reliably checking out the code and committing your changes.

#### Prerequisites
- Install SVN
- Install Node.js
- Run `npm install -g gulp`
- Run `npm install` from the project root

#### Checkout
- Run `gulp svn:checkout` from the project root

#### Check In
- Be sure that all version numbers in the code and readme have been updated.  Add changelog and upgrade notice entries.
- Tag the new version in Git
- Run `gulp project:build` from the project root.
- Run `gulp svn:addremove` from the SVN directory.
- Run `gulp svn:tag --v={version}` from the SVN directory.
- Run `svn ci -m "{commit message}"` from the SVN root to commit changes