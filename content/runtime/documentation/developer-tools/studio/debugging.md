---
type: document
title: Debugging in Studio
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/debugging/"
tags:
timestamp: "2026-06-16T19:29:17+00:00"
wordpress:
  id: 2429
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:17"
  date_gmt: "2026-06-16 19:29:17"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: debugging
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/debugging/"
  comment_count: 0
---

WordPress Studio includes several built-in tools to help you find and fix issues in your local WordPress sites — without needing to install extra software or leave the app.

## Debug log

Sometimes you just need to see what WordPress is logging. Studio makes that easy with a dedicated debug log toggle that configures `WP_DEBUG` and `WP_DEBUG_LOG` for your site automatically.

### Enabling the debug log

1. Select the site you want to debug.
2. Navigate to the **Settings** tab.
3. Click “**Edit site**.”
4. Open the **Debugging** tab.
5. Toggle **Enable debug log** on.
6. Click **Save**.

When the debug log is enabled, your site will capture PHP errors, notices, and warnings to `wp-content/debug.log`. An **Open log file** link will appear in the **Settings** tab, so you can jump directly to the file without hunting for its path.

You can also write your own messages to the log using PHP’s `error_log()` function:

```
error_log( 'My value: ' . print_r( $my_variable, true ) );
```

### Show errors in browser

The **Debugging** tab also includes a **Show errors in browser** toggle, which sets `WP_DEBUG_DISPLAY`. When enabled, PHP errors and warnings are printed inline in the page output rather than captured silently in the log file — useful when you want immediate feedback during active development.

Keep in mind:

- **Show errors in browser** works best alongside the debug log, not as a replacement for it.
- Turn it off on any site you share with clients — it can expose internal path information or other implementation details in the page output.

### Using AI agents to interpret debug logs

Once your debug log is active, you can point an AI agent directly at it. Tell your agent — whether you’re using Claude Code, Cursor, or another tool — that error logs are available at `wp-content/debug.log`. From there, it can read the output, identify what’s going wrong, and suggest fixes without breaking your flow.

## Database access with phpMyAdmin

Inspecting or editing your local database used to mean a separate tool and a separate setup. Studio includes phpMyAdmin access directly from the **Overview** tab — so you can query tables, check data, and debug schema issues without leaving the app or configuring anything.

To open phpMyAdmin for a site, select the site and click the **phpMyAdmin** button in the **Overview** tab.

## Step-through debugging with Xdebug

For deeper investigation, Studio includes [Xdebug](https://xdebug.org/) support. Instead of scattering debug output through your code, you can set breakpoints, step through execution line by line, and inspect variables in real time — all from your editor.

Xdebug is available for all Studio sites and requires no system-level installation. Studio listens for debug connections on port `9003`.

For full setup instructions, including how to connect VS Code and PhpStorm, see [Xdebug in Studio](https://developer.wordpress.com/docs/developer-tools/studio/xdebug/).
