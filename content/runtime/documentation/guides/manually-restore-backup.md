---
type: document
title: Manually restore your site from a Jetpack Backup file on WordPress.com
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/manually-restore-backup/"
tags:
timestamp: "2026-06-16T19:29:26+00:00"
wordpress:
  id: 2486
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:26"
  date_gmt: "2026-06-16 19:29:26"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: manually-restore-backup
  parent: 2479
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/manually-restore-backup/"
  comment_count: 0
---

In most cases, you can restore your site with a single click using [Jetpack VaultPress Backup](https://developer.wordpress.com/docs/platform-features/real-time-backup-restore/). But if needed, you can also restore your site manually using a backup file you’ve previously downloaded.

If you manage a WordPress.com site whose Business or Commerce plan recently expired, [first try following these steps](https://wordpress.com/support/restore-your-site-after-the-plan-expires), as your site’s backups may still be available for one-click restoration.

If you’re moving your site to a new domain (for example, if the backup files were originally used on a different domain), make sure to [follow the instructions below](#update-domain-in-database) for updating the domain in your database. If you’re restoring to the same domain, you can skip that step.

## Transfer plugins, themes, uploads, and database files

If you are using [WordPress Studio](https://developer.wordpress.com/studio/), we recommend taking a look at the [Studio Sync](https://developer.wordpress.com/docs/developer-tools/studio/sync/#push) feature before proceeding with the manual steps.

You can manually restore your WordPress.com site using either a Jetpack `.tar.gz` backup file or a Studio `.zip` backup. Just follow the steps below, or watch the video for a detailed walkthrough.

 

1. To proceed, you must have an active [WordPress.com Business or Commerce plan](https://wordpress.com/hosting/?ref=developer-docs#pricing-grid).
2. Start by retrieving your [Jetpack backup](https://developer.wordpress.com/docs/platform-features/real-time-backup-restore/) or [Studio export](https://developer.wordpress.com/docs/developer-tools/studio/import-export/#2-how-to-export-a-site-from-studio) file.
3. [Enable SFTP credentials](https://wordpress.com/support/sftp/#sftp-credentials) on your site. You will need to connect to SFTP using an [SFTP client](https://wordpress.com/support/sftp/#set-up-a-client), such as [FileZilla](https://filezilla-project.org/).
4. Unzip your Jetpack backup `.tar.gz` or Studio `.zip` file. The unzipped folder, regardless of Jetpack or Studio, will contain your site data in the `sql` and `wp-content` subfolders.

 Remove user dataIn the next few steps, we will be removing `wp_users` and `wp_usermeta` tables from the SQL export file. This will ensure that the Jetpack connection on your WordPress.com site does not break when you run the database import. The steps are slightly different for Jetpack and Studio backups.

1. Navigate to `sql` folder.
2. **Jetpack**: You’ll see several `.sql` files. Delete the `wp_users.sql` and `wp_usermeta.sql` files.
3. **Studio**: You’ll see a single `.sql` file. Open it in your code editor, then search for the `wp_users` table and delete that entire section. The screenshot below highlights exactly what needs to be removed.

[![The wp_users section of the SQL export file.](https://developer.wordpress.com/wp-content/uploads/2024/04/screenshot-2025-05-28-at-11.04.13e280afam.png)](https://developer.wordpress.com/wp-content/uploads/2024/04/screenshot-2025-05-28-at-11.04.13e280afam.png)1. **Studio**: Search for the `wp_usermeta` table and also and delete that entire section. The screenshot below highlights exactly what needs to be removed.

[![The wp_usermeta section of the SQL export file.](https://developer.wordpress.com/wp-content/uploads/2024/04/image.png)](https://developer.wordpress.com/wp-content/uploads/2024/04/image.png)1. **Studio**: Save the `.sql` file after editing it.
2. Once FileZilla is connected to your site, go to the `/srv/htdocs` folder. Within that folder, open `wp-content`.
3. Open the `plugins` folder, and you’ll see a list of plugins currently installed on your site.

 Symlinked files and foldersOn a WordPress.com website, we symbolically link (symlink) WordPress Core files as well as WordPress.com’s own themes and plugins. By using symlinks, we can ensure that the files on your website are always up-to-date and secure.

To identify a symlinked folder or file, some FTP clients may show a tiny arrow on the bottom-left part of the folder icon. On others, it might have a question mark over it.

You won’t be able to access or edit the symlinked files, as they are managed on the platform level. [Learn more about symlinked folders and files here](https://wordpress.com/support/symlinked-files-and-folders/).

1. Check the `plugins` folder from your backup and compare it to the `plugins` folder you have in FileZilla. Any plugin can be restored by dragging the entire plugin folder from your backup to FileZilla, **provided the plugin is not symlinked**. Skip any symlinked plugins, and transfer any others you wish to restore on your site.
2. Repeat this process with your `themes` and `uploads` folders.
3. Next, you’ll need to restore your database files. Drag the `sql` folder from your backup into the `htdocs` folder on FileZilla.
4. Open our preferred terminal application and [connect to your site using SSH](https://wordpress.com/support/ssh/#connect-to-ssh).
5. Once connected, run the command `cd htdocs/sql`.
6. Run `ls | xargs -I % wp db import %`. This lists every file in the folder, wraps the files, and then runs `wp db import` all with one command.
7. Run `wp cache flush`. You must flush the cache every time you make changes to your database.
8. Run `wp plugin activate jetpack`. This is necessary to make sure that the connection to Jetpack on your [WordPress.com](http://wordpress.com) site works as expected after you do the database import.
9. Run `wp plugin install one-time-login --activate && wp user one-time-login <user>`. Replace `<user>` with the email address associated with your [WordPress.com](http://wordpress.com) account.
10. Open the link that appears in the terminal. Once logged into your site, navigate to **Jetpack** in the right sidebar. If Jetpack is not already set up, click “**Set up Jetpack**” and follow the prompts.
11. Run `wp plugin delete one-time-login`.
12. If you run into any further issues on your site after import, [contact support](https://wordpress.com/support/contact/) from your [WordPress.com](http://wordpress.com) site for further help.

Any plugin or theme settings you had enabled at the time of your backup should now be enabled on your site, but double check on the live site to confirm. If not, activate as you would normally.

## Update your domain in the database

When restoring your site to a different domain, you’ll need to update all mentions of your old domain in the database. If you’re restoring your site files to a site with the same domain, you should skip this section.

You can edit your newly-imported database using phpMyAdmin or WP-CLI.

### Update `siteurl` and `home` values with phpMyAdmin

To update your `siteurl` and `home` database values in the `wp_options` table using phpMyAdmin:

1. Visit your site’s wp-admin dashboard and navigate to *Hosting → Overview* (or *Settings → Hosting Configuration* if using the default interface style) if you haven’t already done so.
2. Click the **Settings** tab.
3. Click on the **Database** tab in the sidebar.
4. Click the “**Open phpMyAdmin**” button.
5. To view your `siteurl` and `home` values, click the **SQL** button in the top toolbar, and run the following queries:

```
/* Run these queries to get your current site URL */
SELECT * FROM `wp_options` WHERE `option_name` = 'siteurl';
SELECT * FROM `wp_options` WHERE `option_name` = 'home';
```

/\* Run these queries to get your current site URL \*/ SELECT \* FROM `wp\_options` WHERE `option\_name` = 'siteurl'; SELECT \* FROM `wp\_options` WHERE `option\_name` = 'home';CopyCopied

1. To update your `siteurl` and `home` values, click the **SQL** button in the top toolbar and run the following queries, replacing NEW-DOMAIN with your new domain:

```
/* Run these queries to update your site URL to your new domain */
UPDATE wp_options SET option_value = 'NEW-DOMAIN' WHERE wp_options.option_name = 'siteurl';
UPDATE wp_options SET option_value = 'NEW-DOMAIN' WHERE wp_options.option_name = 'home';
```

/\* Run these queries to update your site URL to your new domain \*/ UPDATE wp\_options SET option\_value = 'NEW-DOMAIN' WHERE wp\_options.option\_name = 'siteurl'; UPDATE wp\_options SET option\_value = 'NEW-DOMAIN' WHERE wp\_options.option\_name = 'home';CopyCopied

#### Search and replace with phpMyAdmin

To ensure that images load as expected, you should also run search-replace queries to update any references to your old URL:

1. Visit your site’s wp-admin dashboard and navigate to *Hosting → Overview* (or *Settings → Hosting Configuration* if using the default interface style) if you haven’t already done so.
2. Click the **Settings** tab.
3. Click on the **Database** tab in the sidebar.
4. Click the **Open phpMyAdmin** button.
5. Click the **SQL** button in the top toolbar, and run the following queries, replacing OLD-DOMAIN with your old domain name and NEW-DOMAIN with your new domain name:

```
/* Run these queries to update the old domain to your new domain */
UPDATE wp_posts SET post_content = replace(post_content, 'OLD-DOMAIN', 'NEW-DOMAIN');
UPDATE wp_posts SET guid = replace(guid, 'OLD-DOMAIN','NEW-DOMAIN');
UPDATE wp_postmeta SET meta_value = replace(meta_value,'OLD-DOMAIN','NEW-DOMAIN');
UPDATE wp_links SET link_image = replace(link_image, 'OLD-DOMAIN','NEW-DOMAIN');
```

/\* Run these queries to update the old domain to your new domain \*/ UPDATE wp\_posts SET post\_content = replace(post\_content, 'OLD-DOMAIN', 'NEW-DOMAIN'); UPDATE wp\_posts SET guid = replace(guid, 'OLD-DOMAIN','NEW-DOMAIN'); UPDATE wp\_postmeta SET meta\_value = replace(meta\_value,'OLD-DOMAIN','NEW-DOMAIN'); UPDATE wp\_links SET link\_image = replace(link\_image, 'OLD-DOMAIN','NEW-DOMAIN');CopyCopied

### Update `siteurl` and `home` values with WP-CLI

To update your `siteurl` and `home` database values in the `wp_options` table using WP-CLI:

1. Open the Terminal on your computer and [connect to your site via SSH](https://wordpress.com/support/ssh/#connect-to-ssh).
2. Once connected, type `cd htdocs/sql`, then press return/enter on your keyboard.
3. To *view* your `siteurl` and `home` values, run the following commands one at a time:
    - `wp option get siteurl`
    - `wp option get home`
4. To *update* your `siteurl` and `home` values, run the following commands one at a time, replacing NEW-DOMAIN with your new domain:
    - `wp option update siteurl NEW-DOMAIN`
    - `wp option update home NEW-DOMAIN`
5. Run `wp cache flush`, then press return/enter on your keyboard.

#### Search and replace with WP-CLI

To ensure that images load as expected, you should also run a search-replace command to update any references to your old URL:

1. Open the Terminal on your computer and [connect to your site via SSH](https://wordpress.com/support/ssh/#connect-to-ssh).
2. Run the following command, replacing OLD-DOMAIN with your old domain name and NEW-DOMAIN with your new domain name:
    - `wp search-replace OLD-DOMAIN NEW-DOMAIN --skip-columns=guid`
3. Run `wp cache flush`, then press return/enter on your keyboard.

## What if something goes wrong?

If something unwanted happens to your site as a result of actions in SFTP, in phpMyAdmin, or with WP-CLI, you can [restore a recent backup of your site](https://href.li/?https://developer.wordpress.com/docs/platform-features/real-time-backup-restore/). If you’re still having trouble, [connect with our Happiness Engineers here](mailto:developers@wordpress.com).
