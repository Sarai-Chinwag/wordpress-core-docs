---
type: document
title: Studio sites
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/sites/"
tags:
timestamp: "2026-06-16T19:29:23+00:00"
wordpress:
  id: 2466
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:23"
  date_gmt: "2026-06-16 19:29:23"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: sites
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/sites/"
  comment_count: 0
---

A Studio site is a WordPress instance running locally on your computer, and each of your sites will be listed in the WordPress Studio sidebar.

WordPress Studio allows you to create, maintain, and work on **unlimited local WordPress websites**.

## Add a new site

To add a new site to Studio:

1. Click the “**Add site**” button in the lower-left corner of Studio to display the “**Add a site**” screen.
2. You will be presented with three options: “**Build a new site”**, “**Connect a site”**, or “**Import from a backup”**.

[![The new "Add a site" screen in WordPress Studio.](https://developer.wordpress.com/wp-content/uploads/2025/01/new-studio-site.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/01/new-studio-site.png)1. For now, select the “**Build a new site”** option.
2. On the next screen, select the **“Empty site”** option to start.
3. (Optional) Toggle “**Advanced settings**” to enable the following additional settings:
    - Select a custom local path
    - Select a custom WordPress version
    - Select a custom PHP version
    - [Use a custom domain.](#Using-a-custom-domain-and-SSL)
4. Click the “**Add site**“.

![Set the site name and configure advanced settings.](https://developer.wordpress.com/wp-content/uploads/2025/10/studio-add-site-name-settings-16-1.jpg)Any new site is started by default, which is depicted by a green dot in the sidebar:

![A screenshot depicting the Studio app and sites list in the sidebar. Green dots indicate that the site is running.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-start-dot.jpg)### Using a custom domain and SSL

By default, new Studio sites use `localhost`. If you prefer to use a custom domain, you can enable that option when creating the site. Studio will suggest a domain for you but you can also enter your own. Custom domains must end in `.local`.

After clicking the “**Add site**” button, you will be prompted to enter your system password. Once confirmed, the custom domain will then point to your Studio site.

You can optionally enable HTTPS (SSL) for your custom domain. Refer to the [“SSL in Studio” doc page](https://developer.wordpress.com/docs/developer-tools/studio/ssl-in-studio/) to learn more about this functionality.

### Add a new site using an existing WordPress directory

You can also add a site to Studio using an existing WordPress directory:

1. Remove `wp-config.php` file from the existing WordPress site directory.
2. Click the “**Add site**” button.
3. Name your site, choose a path with an existing WordPress site, and click “**Add site**“.

If you’d prefer to use an existing `wp-config.php` file, [you can follow these instructions](https://developer.wordpress.com/docs/developer-tools/studio/frequently-asked-questions/#use-studio-with-mysql-server).

## Starting and stopping sites

You can view any *running* site in your browser. With a *stopped site*, viewing the site in your browser will be disabled until you start it again.

To start a site:

1. Click on a site name from the left sidebar.
2. Click the **Start** button.

![A screenshot depicting the Studio app and button to start a local site.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-stopped-2.jpg)Once your site is running, the button will display “Running.” You can also start your site by clicking the **“WP Admin”** or **“Open Site”** buttons. Another quick way to start your site is by hovering over the gray dot in the sidebar until it changes to a green triangle, then clicking it to start your site.

![A screenshot depicting the Studio app and button in the site list sidebar that allows you to start or stop a site.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-start-dot-hover.jpg)To stop your site, hover over the **Running** button — it will change to a **Stop** button. Click it to stop your site.

Alternatively, hover over the green dot in the sidebar until it turns into a red square, then click it to stop your site.

To quickly stop *all* of your local sites from running, click the **Stop all** button at the bottom of the sidebar.

![A screenshot depicting the Studio app and button in the site list sidebar that allows stop all sites at once.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-stop-all.jpg)### View sites

Once you start a site, there are two different ways to view it in your browser:

- **WP admin**: Opens your local site’s dashboard.
- **Open site**: Opens your local site’s homepage.

You do not need a username or password to view your site’s dashboard as you will be automatically logged in.

![A screenshot depicting the Studio app and links that allow you to open the frontend of the site or wp-admin.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-open-site.jpg)## Site overview

Each local site has its own quick-access buttons under the **Overview** tab for easy navigation and an efficient workflow.

[![A screenshot depicting the Overview tab in the Studio app.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-site-overview-2.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-site-overview-2.jpg)Select one of your sites and [make sure that it is running](#start-stop). Under **Customize***,* you can quickly open site setting pages with just one click.

If you’re using a block theme on your local site, you’ll see the following options:

- Site Editor
- Styles
- Patterns
- Navigation
- Templates
- Pages

If you’re using a classic theme on your local site, you’ll see the following options, depending on their availability in the theme:

- Customizer
- Menus
- Widgets

### “Open in…” section

Under the “**Open in…**” heading, Studio will show buttons that will open your site in the following apps if detected on your computer:

- Finder (macOS only)
- File Explorer (Windows only)

Additionally, Studio allows opening files in the following code editors:

- Cursor
- PhpStorm
- Sublime Text
- VS Code
- Webstorm
- Windsurf

You can also open your sites with several terminal applications:

- Terminal (macOS)
- Warp (macOS)
- iTerm (macOS)
- Command Prompt (Windows)
- Ghostty

Studio also allows you to open your site’s database with the database editor:

- phpMyAdmin

To select a preferred code editor or terminal application, click on the user icon in the top right corner to open **“User Settings”**.

[![A screenshot depicting how to open the User Settings in the Studio app.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-open-preferences-2.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-open-preferences-2.jpg)Then click the **Preference** tab and make your selections.

[![A screenshot depicting the user Setting modal in Studio.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-editor-preferences-2.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-editor-preferences-2.jpg)## Site settings

You can view each site’s settings by selecting a site and then clicking on the **Settings** tab.

[![A screenshot depicting the Settings tab in the Studio app.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-site-settings-2.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-site-settings-2.jpg)**Site details:**

- **Site name**: Your local site’s name (editable).
- **Local domain**: The domain you can use to view your site in your browser, [provided your site is running](#start-stop).
- **Local path**: Where your site files are located on your computer.
- **WP Version**: The current WordPress version of your local site.
- **PHP Version**: The current PHP version used for your local site.

**WP Admin:**

- **Username**: The username for the admin account on your local site and can be used to log into your preview site.
- **Password**: The password for the admin account on your local site and can be used to log into your preview site.
- **Admin URL**: The login page for your local site.

### Edit a site

Your site’s details can be edited by clicking “**Edit site**” button in the top left corner. You can edit the site’s name and switch to different PHP and WordPress versions.

![A screenshot depicting the "Edit site" modal on the Settings tab in the Studio app.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-edit-site-new.jpg)Please note that when selecting different PHP and WordPress versions, ensure they are compatible with the plugins and themes installed on your site. If you encounter any errors on your Studio site after making these changes, reviewing your active plugins and themes is a good first step in troubleshooting.

### Delete a site

You may also delete your local site by clicking the “**Delete site**” button located in the ellipsis (⋮) menu besides the **“Edit Site”** button. You’ll have the option to delete site files from your computer before confirming the deletion.

[![A screenshot depicting the warning when deleting a local site in the Studio app.](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-delete-site-2.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/01/studio-delete-site-2.jpg)
