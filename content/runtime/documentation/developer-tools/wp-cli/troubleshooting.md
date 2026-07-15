---
type: document
title: Troubleshooting
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/troubleshooting/"
tags:
timestamp: "2026-06-16T19:29:22+00:00"
wordpress:
  id: 2459
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:22"
  date_gmt: "2026-06-16 19:29:22"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: troubleshooting
  parent: 2513
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/troubleshooting/"
  comment_count: 0
---

## HTML output

Occasionally, you may see HTML returned when you enter a command in the CLI. This can happen when you have a maintenance plugin active or can be a sign that a theme or plugin is coded incorrectly.

If no maintenance plugin is present, you can use the `--skip-*` flag to verify whether the source is a plugin or theme. Once identified, you can deactivate the plugin or theme and may want to reach out to the plugin developer to get it corrected.

## Allowed commands

Specific WP-CLI commands by return forbidden when you try to run them. This is because they are not on the list of Allowed commands on WordPress.com plans.

WP-CLI SupportDue to the complex nature of WP-CLI commands, we are not able to provide extensive support for using these tools. [Happiness Engineers are available to help with issues accessing WP-CLI](https://developer.wordpress.com/docs/glance/support/) but cannot guide you through using commands.
