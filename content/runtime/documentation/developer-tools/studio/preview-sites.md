---
type: document
title: Preview sites in WordPress Studio
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/preview-sites/"
tags:
timestamp: "2026-06-16T19:29:23+00:00"
wordpress:
  id: 2465
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:23"
  date_gmt: "2026-06-16 19:29:23"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: preview-sites
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/preview-sites/"
  comment_count: 0
---

With WordPress Studio, you can share your work with preview sites. These preview sites are powered by [WordPress.com](https://wordpress.com/?ref=dev-doc) on a temporary domain (wp.build), and they allow you to share snapshots of your local sites with clients or team members.

You can create up to ten preview sites at a time per WordPress.com account, and you can view the total number of preview sites you have associated with your account by clicking on your avatar within the WordPress Studio app.

While preview sites are intended for sharing with clients and gathering early feedback for up to seven days, a hosting plan is required to make your site permanently accessible. Use the [Studio Sync](https://developer.wordpress.com/docs/developer-tools/studio/sync/) or [Import/Export](https://developer.wordpress.com/docs/developer-tools/studio/import-export/) features to connect your Studio site to a hosting plan.

## Create a preview site

To create a preview site:

1. Select the local site within the Studio.
2. Click on the **Previews** tab.
3. [Log in to WordPress.com](https://developer.wordpress.com/docs/developer-tools/studio#connect-wordpress-com) if you haven’t already.
4. Click on the **Create preview site** button.

[![A screenshot depicting the Previews tab in the Studio app.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-site-preview-site.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-site-preview-site.jpg)Your preview site should be ready to view in a few seconds, and it will be available to access publicly for seven days.

## Rename a preview site

You can create multiple preview sites per Studio site. To differentiate between them you can rename them inside Studio. To do so follow these steps:

1. Select the local site within the Studio.
2. Click on the **Previews** tab.
3. Click the vertical ellipsis (⋮) in the row of your preview site.
4. Click on the **Rename** button.
5. Enter a new name.
6. Click on the **Save** button.

[![A screenshot depicting the list of preview sites and the popover that allows you to rename each site.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-site-preview-site-rename.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-site-preview-site-rename.jpg)Your preview site will display that name in the list of preview sites, while your remote preview site name will remain unchanged.

## Delete a preview site

To delete a preview site:

1. Select the local site within the Studio.
2. Click on the **Previews** tab.
3. Click the vertical ellipsis (⋮) in the row of your preview site.
4. Click on the **Delete** button.

Your preview site will be deleted and removed from the list.

## Update your preview site

By design, preview sites are generated as one-time “snapshots” of your work. That said, you may synchronize local site changes with your preview site:

1. Select the local site within Studio.
2. Click on the **Previews** tab.
3. Click the vertical ellipsis (⋮) in the row of your preview site.
4. Click **Update** and confirm.

Your preview site will be updated with the local changes in a few seconds. This will also reset the preview site expiration date back to seven days.

## Exclude files with `.deployignore`

When creating or updating a preview site, Studio uploads the contents of your site’s `wp-content` directory. If your site contains files you don’t want included — such as build artifacts, vendor dependencies, or large media folders — you can create a `.deployignore` file at the root of your site directory to exclude them.

The `.deployignore` file uses the same pattern syntax as `.gitignore`. For example:

```
# Exclude vendor dependencies
wp-content/plugins/my-plugin/vendor
Exclude all log files
*.log
Exclude old uploads
wp-content/uploads/2024
Exclude a specific plugin
wp-content/plugins/wordpress-seo
```

You can also use negation patterns to re-include specific items:

Note: Patterns are relative to the site root directory, not to `wp-content`. The following directories are excluded by default, even without a `.deployignore` file: `.git`, `node_modules`, `.DS_Store`, and `Thumbs.db`.

```
# Exclude vendor, but keep important-lib
wp-content/plugins/my-plugin/vendor/*
!wp-content/plugins/my-plugin/vendor/important-lib
```

Preview sites are temporary, and each preview site will be **automatically deleted after seven days from the last update**. This feature ensures that preview environments are used for short-term feedback and review purposes.

## Preview site expiration

To quickly delete all of your preview sites within Studio:

## Delete all preview sites

1. Click on your avatar within Studio.
2. Click the vertical ellipsis (⋮) next to your preview site count.
3. Click the **Delete all preview sites** button.

[![A screenshot depicting the modal that allows you to delete all preview sites in Studio.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-site-preview-site-delete-all.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-site-preview-site-delete-all.jpg)
