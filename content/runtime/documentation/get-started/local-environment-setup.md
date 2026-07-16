---
type: document
title: "Step 2: Set up your local environment"
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/local-environment-setup/"
tags:
timestamp: "2026-06-16T19:29:24+00:00"
wordpress:
  id: 2471
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:24"
  date_gmt: "2026-06-16 19:29:24"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: local-environment-setup
  parent: 2510
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/local-environment-setup/"
  comment_count: 0
---

For local development, we recommend using [WordPress Studio](https://developer.wordpress.com/studio/?ref=developer-docs), a free, open source development environment for WordPress sites created by the WordPress.com team. It’s currently available for Mac and Windows.

[Download Studio](https://developer.wordpress.com/studio/?ref=developer-docs)

## Create a blank WordPress Studio site

You may choose to start from scratch. If that’s the case, you can create a blank WordPress site through WordPress Studio by [following these instructions](https://developer.wordpress.com/docs/developer-tools/studio/sites/#0-add-a-new-site).

## Import content into WordPress Studio

If you have existing content to import into WordPress Studio, you have two options. To import an entire site, you can:

- Use [Studio Sync](https://developer.wordpress.com/docs/developer-tools/studio/sync/) to pull content from an existing WordPress.com site into Studio automatically. [Follow these instructions](https://developer.wordpress.com/docs/developer-tools/studio/sync/#pull) to get started.
- Use the [importing feature](https://developer.wordpress.com/docs/developer-tools/studio/import-export/) within Studio if your site is hosted elsewhere.
- Use a preconfigured site [Blueprint](https://developer.wordpress.com/docs/developer-tools/studio/blueprints).

To import custom plugin or theme code, you can upload ZIP files through wp-admin or add files directly into the correct folder through Finder or File Explorer:

- If importing a plugin, add files to the `wp-content/plugins` folder.
- If importing a theme, add files to the `wp-content/themes` folder.

By default, all Studio sites are located in the `Studio` folder in the root directory of your computer.
