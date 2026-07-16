---
type: document
title: WP-CLI overview
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/overview/"
tags:
timestamp: "2026-06-16T19:29:23+00:00"
wordpress:
  id: 2462
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:23"
  date_gmt: "2026-06-16 19:29:23"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: overview
  parent: 2513
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/overview/"
  comment_count: 0
---

WP-CLI is a command-line interface for WordPress. It provides developers comfortable with the terminal tools to manage a WordPress site from the command line. WP-CLI is useful for everything from site administration to debugging site issues.

## Access WP-CLI

WP-CLI comes preinstalled on WordPress.com and extends the shell to provide WordPress-specific command line tools. You can start running WP-CLI commands once you have connected to your site via SSH.

Visit the [SSH guide to learn how to activate and use SSH](https://wordpress.com/support/ssh/).

## Using WP-CLI

Once you have SSH access to your WordPress.com account, you run WP-CLI commands as you would normally.

```
wp post list

+----+--------------+-------------+---------------------+-------------+
| ID | post_title   | post_name   | post_date           | post_status |
+----+--------------+-------------+---------------------+-------------+
| 1  | Hello world! | hello-world | 2025-01-04 14:07:11 | publish    |
+----+--------------+-------------+---------------------+-------------+
```

wp post list +----+--------------+-------------+---------------------+-------------+ | ID | post\_title | post\_name | post\_date | post\_status | +----+--------------+-------------+---------------------+-------------+ | 1 | Hello world! | hello-world | 2025-01-04 14:07:11 | publish | +----+--------------+-------------+---------------------+-------------+

## Additional WP-CLI Resources

WP-CLI is available as a stand-alone install for local development environments. Many popular plugins for WordPress also extend WP-CLI to provide command-line tools for their features. Below is a list of additional WP-CLI resources that are handy to bookmark.

- [WP-CLI home page on WordPress.org](http://wordpress.org)[WordPress.org WP-CLI documentation](https://developer.wordpress.org/cli/commands/)
- [WooCommerce WP-CLI documentation](https://github.com/woocommerce/woocommerce/wiki/WC-CLI-Overview)
