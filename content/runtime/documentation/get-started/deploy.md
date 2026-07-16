---
type: document
title: "Step 5: Deploy to your production or staging site"
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/deploy/"
tags:
timestamp: "2026-06-16T19:29:24+00:00"
wordpress:
  id: 2468
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:24"
  date_gmt: "2026-06-16 19:29:24"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: deploy
  parent: 2510
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/deploy/"
  comment_count: 0
---

WordPress.com’s [GitHub Deployments](https://wordpress.com/support/github-deployments/) feature makes it easy to deploy changes from GitHub to your production or staging site.

You can set up GitHub Deployments on your production or staging site by:

1. [Connecting the plugin, theme, or site repository](https://wordpress.com/support/github-deployments/#authorize-install).
2. [Setting up the deployment](https://wordpress.com/support/github-deployments/#manage-deployment-settings).
3. [Optionally setting up workflows under Advanced Deployment](https://wordpress.com/support/github-deployments/#advanced-deployment).

You must trigger the first deployment, [either automatically or manually](https://wordpress.com/support/github-deployments/#deploy). If you’re syncing a theme or plugin, you may need to activate it on the Plugins or Themes page in wp-admin.

If you set up automatic deployments through GitHub Deployments, any additional changes to the main branch in your GitHub repository will be automatically synced with your production or staging site.

If you set up manual deployments, syncs will need to be [manually triggered](https://wordpress.com/support/github-deployments/#deploy) through your GitHub Deployments dashboard.

For convenience and maximum control over your production site, we recommend setting up:

- Manual deployments for production sites.
- Automatic deployments for staging sites.

If you decide to use a staging site, you can [synchronize your staging site to your production site](https://wordpress.com/support/how-to-create-a-staging-site/#staging-to-production).

## Next steps

Setting up a local-to-production development flow is only the start of what you can do on WordPress.com. Be sure to check out our documentation for:

- [Documentation Tools](https://developer.wordpress.com/docs/developer-tools/)
- [Site Performance](https://developer.wordpress.com/docs/site-performance/)
- [Platform Features](https://developer.wordpress.com/docs/platform-features/)
- [Troubleshooting](https://developer.wordpress.com/docs/troubleshooting/)
