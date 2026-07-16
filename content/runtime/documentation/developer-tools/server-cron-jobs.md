---
type: document
title: Server Cron Jobs on WordPress.com
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/server-cron-jobs/"
tags:
timestamp: "2026-06-16T19:29:18+00:00"
wordpress:
  id: 2432
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:18"
  date_gmt: "2026-06-16 19:29:18"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: server-cron-jobs
  parent: 2514
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/server-cron-jobs/"
  comment_count: 0
---

Server Cron Jobs allow you to run scheduled commands directly on your site’s server. Unlike WP-Cron, server cron jobs do not depend on site traffic and run independently at regular intervals.

This feature is available on sites with the Business plan or higher and is configured from the new Multi-site dashboard under the **Settings** tab:

![The Cron setting in the WordPress.com Hosting Dashboard](https://developer.wordpress.com/wp-content/uploads/2026/02/server-cron-job-settings-wordpress-com.png)Under the **Cron** tab, you can add a command to run and see the list of scheduled jobs:

![The Cron schedule page on WordPress.com](https://developer.wordpress.com/wp-content/uploads/2026/02/server-cron-job-schedule-wordpress-com.png)### What are Server Cron Jobs?

A server cron job is a scheduled task that runs automatically at defined intervals.

You can use server cron jobs for recurring maintenance or automation tasks. For example:

- Clearing cache: `wp cache flush`
- Removing spam comments: `wp comment delete $(wp comment list --status=spam --format=ids)`

These commands run in the server environment and are not affected by how much traffic your site receives.

### Scheduling Server Cron Jobs

You can schedule server cron jobs using one of the predefined options, or choose a custom schedule for more control:

- Hourly
- Daily
- Twice daily
- Weekly
- Custom

![](https://developer.wordpress.com/wp-content/uploads/2026/02/screenshot-2026-03-19-at-12.50.44.png)The Custom option lets you run a job multiple times per hour, per day, or per week. For example, you can schedule a job to run 2 times per hour, 3 times per day, or 2 times per week:

[![](https://developer.wordpress.com/wp-content/uploads/2026/02/screenshot-2026-03-19-at-12.50.59.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2026/02/screenshot-2026-03-19-at-12.50.59.png)To help prevent system overload, the exact execution time is randomized within the selected interval. This applies to both predefined and custom schedules. For example, if you choose once per hour, the job may run at any point during that hour.

### Command format and supported syntax

Server Cron Jobs run the command you enter in a shell environment on your site’s server.

- **WP-CLI commands** are supported (for example, commands starting with `wp`).
- **Shell features** such as output redirection (`>`, `>>`) and combining output/error (`2>&1`) are also supported.
- If you use shell features like pipes (`|`) or command substitution (`$(...)`), confirm the command works when run manually first.

**Examples:**

Run a WP-CLI command:

`wp cache flush`

Run a command that uses shell output redirection:

`echo "Cron ran at $(date)" > /srv/htdocs/wp-content/cron-test.txt`

Write both output and errors to a log file:

`wp cache flush >> /srv/htdocs/wp-content/cron-debug.log 2>&1`

**Note:** Traditional cron schedule expressions (for example, `*/5 * * * *`) are not currently supported in the scheduling UI.

### Viewing command output and debugging

There is currently no built-in execution log available in the dashboard.

If you need to confirm that a command is running or view its output, you can use shell output redirection to write results to a file on your site.

**Basic test**

The following command creates a file in `wp-content` each time the cron job runs:

`echo "Cron ran at $(date)" > /srv/htdocs/wp-content/cron-test.txt`

If successful, `cron-test.tx` will appear in your `wp-content` directory.

![A cron-test.txt file shown in a wp-content folder](https://developer.wordpress.com/wp-content/uploads/2026/02/cron-test-txt.png)You can access this [file using SFTP.](https://wordpress.com/support/sftp/)

**Capturing output and errors**

To record both standard output and errors to a log file, you can use:

`command >> /srv/htdocs/wp-content/cron-debug.log 2>&1`

Replace `command` with your actual command. For example:

`mysqldump database >> /srv/htdocs/wp-content/cron-debug.log 2>&1`

This appends all output to `cron-debug.log`, which you can download via SFTP for troubleshooting.

## Relationship between WP-Cron and Server Cron Jobs

[WP-Cron](https://developer.wordpress.com/docs/guides/wp-cron-on-wordpress-com/) continues to handle WordPress-level scheduled tasks such as publishing posts and running plugin background processes.

Server Cron Jobs operate separately and run directly on the server. They are suitable for tasks that require consistent execution regardless of site traffic.
