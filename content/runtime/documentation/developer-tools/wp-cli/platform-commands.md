---
type: document
title: Platform-specific commands
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/platform-commands/"
tags:
timestamp: "2026-06-16T19:29:23+00:00"
wordpress:
  id: 2461
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:23"
  date_gmt: "2026-06-16 19:29:23"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: platform-commands
  parent: 2513
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/platform-commands/"
  comment_count: 0
---

While the majority of the core WP-CLI commands are available to you, there are also some additional commands that are exclusive to WordPress.com hosting. These allow you to interact with and control specific elements of your [WordPress.com Business or Commerce plan](https://wordpress.com/hosting/?ref=developer-docs#pricing-grid).

To see which commands are available on your plan, you can use the WP-CLI `--help` flag in the terminal:

```
wp --help
```

wp --help

## Business plan

### atomic

Control aspects of your WordPress.com hosting plan.

### custom-fonts

Manage the Custom Fonts plugin.

### dereferenced 

Helper utilities for working with dereferenced (development mode) sites.

### disk-usage 

Output disk usage information for the document root and tmp directories.

### edge-cache 

Edge Cache control – query and control the Edge Cache.

### jetpack 

Control your local [Jetpack installation through WP-CLI](https://jetpack.com/support/jetpack-cli/).

### jetpack-heartbeat 

Interact with the Jetpack Heartbeat.

### jetpack-waf 

Control the [Jetpack Web Application Firewall](https://jetpack.com/support/jetpack-waf/).

### launch-site 

Makes the site live to the public.

### php-errors

Output contents of php-errors.

### wpcomsh

WordPress.com specific commands.

## Commerce plan

If you use the Commerce plan, there are also specific commands related to the Commerce tools installed on your site.

### action-scheduler 

Commands for Action Scheduler.

### akismet

Filter and monitor spam comments.

### mailpoet

WP-CLI commands to manage aspects of MailPoet.

### videopress 

VideoPress command line utilities.

### wc 

WP-CLI commands to manage [your WooCommerce store](https://developer.woocommerce.com/docs/woocommerce-cli-commands/).

## Allowed Commands

Certain core WP-CLI commands are unavailable on WordPress.com Business or Commerce plans to provide a secure and performant hosting environment. If a command is disabled, it will return forbidden when you try to run it.

Typically, you can do anything on CLI that you could do with the GUI (Graphical User Interface) in your site’s dashboard, but without any of the warnings or checks provided in the GUI. Disabling certain commands makes it harder to damage a site irreparably or destroy it accidentally.

To see which commands are available on your plan, use the WP-CLI `--help` flag in the terminal.
