---
type: document
title: "Import &amp; export"
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/import-export/"
tags:
timestamp: "2026-06-16T19:29:23+00:00"
wordpress:
  id: 2464
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:23"
  date_gmt: "2026-06-16 19:29:23"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: import-export
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/import-export/"
  comment_count: 0
---

A WordPress Studio site can be added from a backup file that contains a site’s full content.

An existing WordPress Studio site can be updated from the backup file in a similar fashion, or from the single `.sql` file, in the **Import / Export** tab.

Your backup files can be downloaded from your WordPress.com site or from Jetpack’s Activity Log page. It will have the following files and directories inside:

- `wp-config.php`: The WordPress configuration file.
- `wp-content/plugins`: The folder containing your site’s plugins.
- `wp-content/themes`**:** The folder containing your site’s themes.
- `wp-content/uploads`**:** The folder containing your site’s uploads.
- `sql/`**:** A directory with `.sql` files that contain your site’s database data.

Exports from Studio will also have a `meta.json` file, which contains information about the desired PHP version for the site.

Other supported formats are:

- The `.wpress` file from the [All-in-One WP Migration and Backup plugin](https://wordpress.com/plugins/all-in-one-wp-migration)
- The `.zip` file from the [Local app](https://localwp.com/help-docs/getting-started/how-to-import-a-wordpress-site-into-local/#export-a-site)
- The `.zip` file from [WordPress Playground](https://wordpress.github.io/wordpress-playground/quick-start-guide/#save-your-site)

If your site is hosted on WordPress.com (Business or Commerce plan) or [Pressable](https://pressable.com/), you can use [Studio Sync](https://developer.wordpress.com/docs/developer-tools/studio/sync/) as an alternative. It lets you pull down your production or staging site into Studio, and push local changes back up to the live site when you’re ready.

## How to add a new site to WordPress Studio from a backup

To add a new site to WordPress Studio from backup, you’ll need a `.tar.gz`, or`.zip` file:

1. Click the “**Add site**” button in Studio. You will be presented with three options: “**Create a site**,” “**Start from a Blueprint**,” or “**Import from a backup**.”
2. Select “**Import from a backup.”**
3. On the following screen, select your backup file and click **Continue**.
4. Name your site.
5. (Optional) Toggle “**Advanced settings**” to configure additional settings.
6. Click “**Add site**.”

Any imported site is started by default and visible in the sidebar.

## How to update an existing WordPress Studio site from a backup

To update an existing Studio site from a backup, you’ll need a `.tar.gz`, `.zip`, or `.sql` file:

1. Select the site you wish to update from the Studio sidebar.
2. Open the *Import / Export* tab.
3. Click the *Import* box to select your backup file. Alternatively, you can drag and drop your backup file into the *Import* box.
4. When prompted, click **Import** to overwrite your Studio site with your backup file.

The Studio site will be replaced from the provided `.tar.gz` or `.zip` backup. However, when you import `.sql` file to an existing site, the database dump will be imported on top of the existing site.

## How to export a site from WordPress Studio

WordPress Studio allows you to export your entire local site into a `.zip` format, which is compatible with Jetpack Backup. You may also export only the database into a `.sql` file, which is compatible with MySQL.

To export a site from Studio:

1. Select the site you wish to export from the Studio sidebar.
2. Open the *Import / Export* tab.
3. Click the “**Export entire site**” button to generate a full-site `.zip` file or the “**Export database**” file to generate a `.sql` file.
4. Choose the destination and click **Save.**

When the export is finished, Studio will open the directory containing the backup file automatically.

Note that `node_modules` and `.git` paths are excluded from the exported file.

## How to upload a WordPress Studio export to a hosted WordPress site

Once you have the backup file, you can deploy it to **any** WordPress site. For example, if your site is on WordPress.com (Business or Commerce plan), you can follow the [Manually Restore Your Site from a Jetpack Backup File on WordPress.com](https://developer.wordpress.com/docs/guides/manually-restore-backup/) guide.

Alternatively, if your site is hosted on WordPress.com (Business or Commerce plan) or Pressable, you also have the option to use [Studio Sync](https://developer.wordpress.com/docs/developer-tools/studio/sync/). This feature lets you connect Studio to your live production or staging sites and push local changes with a single click—no manual file upload required.

## How to import a site without a Jetpack backup

If you are not using Jetpack Backup, you can still import the site to WordPress Studio from a backup file created manually:

1. Create a temporary import directory e.g., `import-to-studio/`.
2. Create `sql/` and `wp-content/` directories inside the created directory.
3. Open `wp-content/` directory of your site and copy `plugins/`, `themes/`, and `uploads/` to the `wp-content/` in the temporary import directory.
4. Copy your site’s `wp-config.php` to the temporary import directory.
5. Export your site’s database using your favorite MySQL tool and place the dump file in `sql/` directory.
6. Select all files in temporary import directory and compress them as `.zip` file.
7. Follow the steps shown above to add a new site from the backup file.
