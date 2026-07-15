---
type: document
title: Jetpack Activity Log
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/jetpack-activity-log/"
tags:
timestamp: "2026-06-16T19:29:26+00:00"
wordpress:
  id: 2491
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:26"
  date_gmt: "2026-06-16 19:29:26"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: jetpack-activity-log
  parent: 2493
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/jetpack-activity-log/"
  comment_count: 0
---

Activity Log by Jetpack shows a record of all activities and events on your website so you can keep track of your site’s changes. This guide explains how it works and how to view your site’s activities.

## Access the Activity Log

To visit your site’s activity:

1. Visit your site’s dashboard.
2. On the left side, go to *Jetpack* → *Activity Log*.

You may need to log into Jetpack using your WordPress.com account. Click **Accept**.

Once connected, you can view the recent events recorded for your site in reverse chronological order.

![A list of recent activities in the activity log](https://developer.wordpress.com/wp-content/uploads/2024/02/5e148-example-activity-log-jetpack.png?w=1024)[WordPress.com paid plans](https://wordpress.com/hosting/?ref=developer-docs#pricing-grid) have access to their complete site activity for their plan’s [data retention period](#data-retention).

The most recent 1,000 events are displayed in Activity. The timestamp displayed in Activity matches the timezone set in your [site’s timezone settings](https://wordpress.com/support/general-settings/#timezone) configured from *Settings → General*.

At the top of the screen, you can filter activities by:

- **Date Range**: view activities that occurred between two dates of your choice.
- **Activity Type:** show only activities related to:
    - [Backups and restores](https://developer.wordpress.com/docs/platform-features/real-time-backup-restore/)
    - [Plugins](https://wordpress.com/support/plugins/)
    - [Posts](https://wordpress.com/support/posts/) and [pages](https://wordpress.com/support/pages/)
    - [Media](https://wordpress.com/support/media/)
    - [Themes](https://wordpress.com/support/themes/)
    - [Comments](https://wordpress.com/support/comments/)
    - [People](https://wordpress.com/support/invite-people/)
    - [Widgets](https://wordpress.com/support/widgets/)
    - [Pingbacks](https://wordpress.com/support/comments/pingbacks/)
    - [Site Settings](https://wordpress.com/support/category/account/settings/)

If a particular activity type is not listed, it means there are no recorded activities of that type on your site.

## How to use the Activity Log

The activity log is versatile and easy to use, allowing you to keep track of all actions taken on your site. It can help you in the following ways:

- If [several contractors or team members](https://developer.wordpress.com/docs/platform-features/user-management/) work on your site, the activity log helps you ensure all critical tasks are completed by the right person.
- Catch unauthorized changes caused by other team members, such as plugin and theme deletions, unapproved page changes, [database access](https://developer.wordpress.comhttps://wordpress.com/support/database/), and more.
- Identify an issue when something goes wrong. For example, if you know that your site went down around 2:30 PM, you might see that a plugin was updated at 2:29 PM.
- Make use of [real-time backups](https://developer.wordpress.com/docs/platform-features/real-time-backup-restore/) to restore your website to the point right before an error occurred.

## Data retention

The retention periods for Activity data depend on both the activity itself and the site’s plan.

| Activity | Premium | Business  &amp; Commerce | Pro (Legacy) |
|---|---|---|---|
| **Users:** additions, deletions, network deletions, registrations, invite acceptance, removals, updates | 30 days | Forever | Forever |
| **Attachments:** uploads, updates, deletions | 30 days | Forever | Forever |
| **Comments:** submissions, approvals, un-approvals, content edits, deletions, trash actions, spam/un-spam actions, restorations from trash | 30 days | Forever | Forever |
| **Feedback:** [Contact Form](https://wordpress.com/support/wordpress-editor/blocks/form-block/) submissions | 30 days | Forever | Forever |
| **Settings:** settings updates | 30 days | Forever | Forever |
| **Menus:** additions, updates, deletions | 30 days | Forever | Forever |
| **Themes:** theme activations | 30 days | Forever | Forever |
| **Posts &amp; Pages:** publish actions, updates, deletions, trash actions, imports, exports | 30 days | Forever | Forever |
| **Widgets:** additions, updates, removals, reorders, set-to-inactive actions | 30 days | Forever | Forever |
| **WordPress:** [plan](https://wordpress.com/hosting/?ref=developer-docs#pricing-grid) activations and deactivations, new blog subscribers | Forever | Forever | Forever |

At the end of any retention periods outlined above, activity data is moved to long-term storage and is retained indefinitely. Once in long-term storage, activity data will no longer be visible in a site’s Activity.

If there is no activity on your site for longer than the retention period, you’ll see a screen with no activity shown:

![The Activity Log screen with no activity to display](https://developer.wordpress.com/wp-content/uploads/2024/02/92809-activity-jetpack.png)Once you make any changes to your site that are recorded in your Activity, this screen will update to show the latest events.
