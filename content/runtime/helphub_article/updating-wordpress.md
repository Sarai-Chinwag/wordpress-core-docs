---
type: document
title: Updating WordPress
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/updating-wordpress/"
tags:
timestamp: "2026-06-16T19:29:11+00:00"
wordpress:
  id: 2409
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:11"
  date_gmt: "2026-06-16 19:29:11"
  modified: "2026-06-16 19:29:11"
  modified_gmt: "2026-06-16 19:29:11"
  slug: updating-wordpress
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/updating-wordpress/"
  comment_count: 0
  terms:
    category:
      - maintenance
      - technical-guides
---

**WARNING:** The upgrade process will affect all files and folders included in the main WordPress installation. This includes all the core files used to run WordPress. If you have made any modifications to those files, your changes will be lost.

You should always update WordPress to the [latest version](https://wordpress.org/download/). When a new version of WordPress is available you will receive an update message in your WordPress Admin Screens. To update WordPress, click the link in this message.

There are two methods for updating – the easiest is the one-click update, which will work for most people. If it doesn’t work, or you just prefer to be more hands-on, you can follow the manual update process.

If you are updating across multiple versions, follow the procedure at [Upgrading WordPress – Extended Instructions](https://developer.wordpress.org/advanced-administration/upgrade/upgrading/)

## Back up WordPress

Before you get started, it’s a good idea to back up your website. This means if there are any issues you can restore your website. Complete instructions to make a backup can be found in the [WordPress Backup](https://developer.wordpress.org/advanced-administration/security/backup/).

## Automatic Background Updates

For [WordPress 3.7](https://wordpress.org/documentation/wordpress-version/version-3-7/)+, you don’t have to lift a finger to apply minor and security updates. Most sites are now able to automatically apply these updates in the background. If your site is capable of one-click updates without entering FTP credentials, then your site should be able to update from 3.7 to 3.7.1, 3.7.2, etc. (You’ll still need to click “Update Now” for major feature releases.)

## One-click Update

WordPress lets you update with the click of a button. You can launch the update by clicking the link in the new version banner (if it’s there) or by going to the Dashboard &gt; Updates screen. Once you are on the “Update WordPress” page, click the button “Update Now” to start the process off. You shouldn’t need to do anything else and, once it’s finished, you will be up-to-date.

One-click updates work on most servers. If you have any problems, it is probably related to permissions issues on the filesystem.

### File Ownership

WordPress determines what method it will use to connect to the filesystem of your server based on the file ownership of your WordPress files. If the files are owned by the owner of the current process (i.e., the user under which the web server is running), *and* new files created by WordPress will also be owned by that user, WordPress will directly modify the files all by itself, without asking you for credentials.

WordPress won’t attempt to create the new files directly if they won’t have the correct ownership. Instead, you will be shown a dialog box asking for connection credentials. It is typical for the files to be owned by the FTP account that originally uploaded them. To perform the update, you just need to fill in the connection credentials for that FTP account.

Whether your files are owned by the web server user, or not, will depend on how you installed WordPress and how your server is configured. On some shared hosting platforms, it is a security risk for the files to be owned by the web server user and not a FTP user. See the tutorial on [Changing File Permissions](https://developer.wordpress.org/advanced-administration/server/file-permissions/)<a> </a>for more information, including how to configure file permissions so that multiple FTP users are able to edit the files.

### Failed Updates

If you see a “failed update” nag message, delete the file **.maintenance** from your WordPress directory using FTP. This will remove the “failed update” nag message.

If the one-click upgrade doesn’t work for you, don’t panic! Just try a manual update.

## Manual Update

These are the short instructions, if you want more check out the [extended upgrade](https://developer.wordpress.org/advanced-administration/upgrade/upgrading/) instructions. If you experience problems with the Three Step Update, you may want to review the [more detailed upgrade instructions](https://developer.wordpress.org/advanced-administration/upgrade/upgrading/).

For these instructions, it is assumed that your blog’s URL is `http://example.com/wordpress/`.

### Step 1: Replace WordPress files

1. Get the [latest WordPress](https://wordpress.org/download/) zip (or tar.gz) file.
2. Unpack the zip file that you downloaded.
3. Deactivate plugins.
4. Delete the old `wp-includes` and `wp-admin` directories on your web host (through your [FTP](https://wordpress.org/documentation/article/ftp-clients/)<a> </a>or shell access).
5. Using [FTP ](https://wordpress.org/documentation/article/ftp-clients/)or your shell access, upload the new `wp-includes` and `wp-admin` directories to your web host, in place of the previously deleted directories.
6. Upload the individual files from the new `wp-content` folder to your existing `wp-content` folder, overwriting existing files. Do NOT delete your existing `wp-content` folder. Do NOT delete any files or folders in your existing `wp-content` directory (except for the one being overwritten by new files).
7. Upload all new loose files from the root directory of the new version to your existing WordPress root directory.

NOTE – you should replace all the old WordPress files with the new ones in the `wp-includes` and `wp-admin` directories and sub-directories, and in the root directory (such as `index.php`, `wp-login.php` and so on). Don’t worry – your `wp-config.php` will be safe.

Be careful when you come to copying the `wp-content` directory. You should make sure that you only copy the files from inside this directory, rather than replacing your entire `wp-content` directory. This is where your themes and plugins live, so you will want to keep them. If you have customized the default or classic themes without renaming them, make sure not to overwrite those files, otherwise you will lose your changes. (Though you might want to compare them for new features or fixes..)

Lastly you should take a look at the `wp-config-sample.php` file, to see if any new settings have been introduced that you might want to add to your own `wp-config.php`.

### Step 1.5: Remove .maintenance file

If you’re upgrading manually after a failed auto-upgrade, delete the file .maintenance from your WordPress directory using FTP. This will remove the “failed update” nag message.

### Step 2: Update your installation

Visit your main WordPress admin page at /wp-admin. You may be asked to login again. If a database upgrade is necessary at this point, WordPress will detect it and give you a link to a URL like `http://example.com/wordpress/wp-admin/upgrade.php`. Follow that link and follow the instructions. This will update your database to be compatible with the latest code. You should do this as soon as possible after step 1.

Don’t forget to reactivate plugins!

### Step 3: Do something nice for yourself

If you have caching enabled, clear the cache at this point so the changes will go live immediately. Otherwise, visitors to your site (including you) will continue to see the old version (until the cache updates).

Your WordPress installation is successfully updated. That’s as simple as we can make it without [Updating WordPress Using Subversion](https://codex.wordpress.org/Installing/Updating_WordPress_with_Subversion).

Consider rewarding yourself with a blog post about the update, reading that book or article you’ve been putting off, or simply sitting back for a few moments and letting the world pass you by.

## Final Steps

Your update is now complete, so you can go in and enable your Plugins again.
If you have issues with logging in, try clearing cookies in your browser.

## Troubleshooting

If anything has gone wrong, then the first thing to do is go through all the steps in our [extended upgrade instructions](https://developer.wordpress.org/advanced-administration/upgrade/upgrading/). That page also has information about some of the most common problems we see.

If you run into a request for FTP credentials with trying to update WP on a IIS server automatically, it may well be a matter of rights. Go into the IIS Management Console, and there to the application pool of your blog. In its advanced settings, change the Process Model Id into LocalSystem. Then on Sites, choose your blog, right click, click on Edit permissions and on security tab add authenticated users. That should do it.

If you experience problems after the upgrade, you can always [restore your backup](https://developer.wordpress.org/advanced-administration/security/backup/)<a> </a>and replace the files with ones from your previous version from the [release archive](https://wordpress.org/download/release-archive/).

### Other options

If you have some knowledge of unix shells you should check out [wp-cli](https://developer.wordpress.org/cli/commands/).
