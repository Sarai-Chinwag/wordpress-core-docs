---
type: document
title: Enabling WP_DEBUG
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/wp-debug/"
tags:
timestamp: "2026-06-16T19:29:27+00:00"
wordpress:
  id: 2492
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:27"
  date_gmt: "2026-06-16 19:29:27"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: wp-debug
  parent: 2493
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/wp-debug/"
  comment_count: 0
---

When debugging issues on your WordPress.com site, it’s often useful to enable the built in [debugging mode](https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/) available to WordPress.

This feature is available on sites with the [WordPress.com Business or Commerce plan](https://wordpress.com/hosting/?ref=developer-docs#pricing-grid).

## Before you enable WP\_DEBUG

By default, any web server or PHP errors or warnings for your site are automatically logged and available from your site’s *Settings* page. You can learn how to access and download these logs in the Site Monitoring documentation under [Access logs](https://wordpress.com/support/site-monitoring/#2-access-logs).

You can still enable `WP_DEBUG`, but please note that doing so may cause excessive warnings and break the default logging WordPress.com provides. It may also cause excessive disk usage if it’s not disabled and the debug.log file deleted after using it.

## Enable WP\_DEBUG

To activate debugging mode, take the following steps:

1. Connect to your WordPress site using [your preferred SFTP](https://wordpress.com/support/sftp/) client.
2. Once connected, locate the `wp-config.php` file in the root directory of your WordPress installation.
3. Open the `wp-config.php` file in your text editor.
4. Find the section titled *For developers: WordPress debugging mode.*
5. Update the code to look like this:

```
if ( ! defined( 'WP_DEBUG') ) {
	define( 'WP_DEBUG', true );
	if ( WP_DEBUG ) {
		define( 'WP_DEBUG_DISPLAY', false );
		define( 'WP_DEBUG_LOG', true );
	}
}
```

if ( ! defined( 'WP\_DEBUG') ) { define( 'WP\_DEBUG', true ); if ( WP\_DEBUG ) { define( 'WP\_DEBUG\_DISPLAY', false ); define( 'WP\_DEBUG\_LOG', true ); } }CopyCopied

6\. Save the changes you made to the `wp-config.php` file.

This will enable debug mode, prevent any logging from being displayed on the front end, and log any errors or calls to `error_log` to a `debug.log` file.

You can read more about these settings, as well as additional debugging settings you can enable the [WordPress Advanced Administration Handbook](https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/)

## Retrieve logs

Now you’ve enabled debug mode, you can retrieve the logs to help diagnose issues:

1. Reconnect to your WordPress site [using SFTP](https://wordpress.com/support/sftp/).
2. Navigate to the `wp-content` directory and locate the `debug.log` file.
3. Download or view the `debug.log` file. You can download the `debug.log` file to your computer or view it directly using a text editor.

## Disable WP\_DEBUG

To prevent performance issues and keep sensitive information secure, it’s important to disable debugging mode in your production environment after you’ve finished debugging.

Once you’ve finished debugging, disable `WP_DEBUG` with the following steps:

1. Reconnect to your WordPress site again [with SFTP](https://wordpress.com/support/sftp/).
2. Locate the `wp-config.php` file in the root directory of your WordPress installation.
3. Open the `wp-config.php` file in your text editor.
4. Find the section titled *For developers: WordPress debugging mode.*
5. Update the code to look like this:

```
if ( ! defined( 'WP_DEBUG') ) {
	define( 'WP_DEBUG', false );
}
```

if ( ! defined( 'WP\_DEBUG') ) { define( 'WP\_DEBUG', false ); }CopyCopied

6\. Save the changes you made to the `wp-config.php` file.
