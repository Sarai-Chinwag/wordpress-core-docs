---
type: document
title: Manage user, file, and folder permissions
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/manage-permissions/"
tags:
timestamp: "2026-06-16T19:29:25+00:00"
wordpress:
  id: 2484
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:25"
  date_gmt: "2026-06-16 19:29:25"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: manage-permissions
  parent: 2479
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/manage-permissions/"
  comment_count: 0
---

Permissions issues can block access to certain features or functions on your site. To fix them, it helps to understand the different types of permissions and common errors. This guide covers file permissions, user permissions, and how to troubleshoot the most common problems.

## Types of permissions

There are two main types of permissions: file permissions and user permissions. File permissions control who can access your site’s files and when. User permissions define what each user can do on your site, including which parts of the dashboard they can access and manage.

## File permissions

By default, a WordPress.com site is set to the following file permissions:

- Unmanaged Directories: `775` or `755`
    - This allows owners to read, write, and execute, and group members and other users to read and write.
    - If the permission is `775`, group members can also execute.
- Files: `644`
    - This allows owners to read and write, and other users to read-only.

Sites on WordPress.com also include files and folders managed for performance, security, or other platform reasons. These have `755` or `644` permissions and cannot be changed.

Some files, like managed plugins or themes, are [symlinked](https://developer.wordpress.com/docs/guides/symlinked-files-folders/). This means you can’t edit their files or folders directly. However, with the exception of [Jetpack](https://wordpress.com/support/jetpack/), Akismet, and the must-use plugin `wpcomsh`, you can remove the managed version and replace it with an unmanaged one.

If you choose to convert a symlinked plugin or theme, you’ll be responsible for keeping it up to date. You’ll also no longer receive performance or security updates included with the managed version. Learn more about [symlinked plugins and themes here](https://developer.wordpress.com/docs/guides/symlinked-files-folders/).

### Change file permissions

Changing permissions can break your site functionality and should only be done if you are absolutely certain what you are changing and why.

You can change file or folder permissions through your site’s [SFTP](https://wordpress.com/support/sftp/) or [SSH](https://wordpress.com/support/ssh/) connection.

## User permissions

WordPress.com sites come with default user roles, each with its own set of permissions. You can [learn more about those roles and what they allow here](https://developer.wordpress.com/docs/platform-features/user-management/#roles).

When you invite a user to your site or create a new user through the WP-Admin dashboard, WP-CLI, or by editing the database, you can assign a role. That user will automatically receive the default permissions for that role, unless you customize them.

Some plugins and themes may add their own roles and permissions. These are often required for certain features to work and can be assigned alongside existing roles or as the only role for a user.

### SFTP and SSH access credentials

Users with access to [SFTP](https://wordpress.com/support/sftp/) or [SSH](https://wordpress.com/support/ssh/) credentials will have administrative privileges to add, modify, and remove site files and settings. SSH permissions also grant access to the database directly and all available CLI commands.

SFTP and SSH access cannot be limited to specific actions or permissions. If you don’t want a user to have full access through these tools, do not assign them an administrator role or share SFTP/SSH credentials with them, regardless of their role or permissions on the site.

### Change user roles or permissions

You can change a user’s role or permissions in a few built-in ways:

- From you site’s admin dashboard under the *Users* section. Full instructions are available in the [Changing User Roles guide](https://wordpress.com/support/invite-people/#change-a-user-s-role).
- Using [WP-CLI](https://developer.wordpress.com/docs/developer-tools/wp-cli/), which is accessible via SSH.

You can also use third-party plugins to manage custom file and user permissions. Popular options like [User Role Editor](https://wordpress.org/plugins/user-role-editor/) or [Members](https://wordpress.org/plugins/members/) let you fine-tune permissions and assign multiple roles to users based on your site’s needs.

### Helpful tips

You can see what capabilities a user is currently assigned with `user list-caps {userID}` in [WP-CLI](https://developer.wordpress.com/docs/developer-tools/wp-cli/):

```
wp user list-caps youruser
read
level_0
subscriber
```

wp user list-caps youruser read level\_0 subscriber

If the permissions do not match your expectations, you can reassign the correct role to reset permissions.

If the permissions are still not correct after the role is corrected, the role’s default permissions may have been changed. In this case, you can reset the permissions to default with the CLI command `role reset {role}`. This will then update the permissions for anyone assigned to that role:

```
wp role reset editor
Restored 0 capabilities to and removed 0 capabilities from 'editor' role.
Success: Role reset.
```

wp role reset editor Restored 0 capabilities to and removed 0 capabilities from 'editor' role. Success: Role reset.

Some plugins create new user roles or modify existing ones. In most cases, these roles are removed when the plugin is uninstalled. However, if not, you might end up with unused custom roles.

If any of these roles remain after removing the plugin, you may need to delete them manually and reassign affected users to a default role.

To remove roles, you can use the CLI command `role delete {ROLE}`.

If you accidentally remove a default role or a default role is otherwise missing, you can re-add it using `role reset {ROLE}` :

```
wp role delete editor
Success: Role with key 'editor' deleted.
```

wp role delete editor Success: Role with key 'editor' deleted.

## Correct permission errors

Sometimes, you might experience issues with user roles and permissions on your site. Below are some of the most common problems you may encounter.

### Access errors

You might see a message like “Sorry, you are not allowed to access this page” or “You do not have permission to access this page.”

These errors often appear when trying to access WP-Admin pages, such as the Plugins page or plugin settings. You might also notice that the **Upgrades** section shows the wrong plan or no plan at all.

To troubleshoot:

- Confirm you are signed in with the correct account by visiting your [profile](https://wordpress.com/me).
- Check that the correct plan is showing next to **Upgrades**. If not, please reach out to [WordPress.com support](https://developer.wordpress.com/docs/glance/support/).
- Check what role is assigned to the affected user. You can check the role in *Users → [All Users](https://wordpress.com/people/team/)*. If the role is incorrect, assign the correct role and navigate to the page you were trying to visit again.
- Check the permissions assigned to the user. If the role is correct but the permissions aren’t, [reset the role](https://developer.wordpress.com/docs/guides/manage-permissions#user-permissions) and navigate to the page again.
- If a user has multiple roles, or if you’re using plugins that affect permissions, try temporarily deactivating those plugins. This can help you determine whether role conflicts are causing the issue.

### Unable to install plugins or themes

If you cannot install plugins, it may be related to permissions issues, incompatible plugins, incorrect plan information, or other site errors.

To troubleshoot:

- Confirm you are signed in with the correct account by visiting your [profile](https://wordpress.com/me).
- Verify that this account has the correct role and permissions assigned. You can check the role in *Users → [All Users](https://wordpress.com/people/team/)*. If the role is incorrect, assign the correct role.
- Confirm that you WordPress.com site is on a [plugin-enabled plan](https://wordpress.com/pricing/).
- Make sure the plugin or theme you’re uploading is in the correct format. It should be a single ZIP file that doesn’t contain another ZIP file inside, and it must be compatible with WordPress.com.

We do our best to make WordPress.com compatible with as many plugins and themes as possible. However, some may not work due to conflicts with our platform. If a plugin or theme is incompatible, you’ll often see a message letting you know. If you’re unsure, you can check our list of [incompatible plugins here](https://wordpress.com/support/plugins/incompatible-plugins/).

### Unable to upload media

Media upload issues are not usually associated with user permissions. The cause is often related to file size or format, available storage, or connection issues.

To troubleshoot:

- Verify that you have enough remaining storage space to accommodate the file.
- Make sure the file is one of the [accepted types](https://wordpress.com/support/accepted-filetypes/). Sometimes, the file extension doesn’t match the actual file type. If that happens, try saving the file with the correct extension or use third-party software to convert it to a supported format.
- Verify that your upload does not exceed the max size of 2GB. If your file is larger than 2 GB, you can upload it using [SFTP](https://wordpress.com/support/sftp/) or [SSH](https://wordpress.com/support/ssh/).
- Verify that you have a stable connection that is not timing out while uploading your file.
- Verify that your Uploads [folder and subfolder permissions](https://developer.wordpress.com/docs/guides/manage-permissions/) are correct.

### Other media errors

If you see broken thumbnails in your media gallery or receive a 404 response when visiting the source URL for media items, it’s usually due to one of three reasons:

- Your [site privacy](https://wordpress.com/support/privacy-settings/) is set to Private.
- The media is missing from your site files. This can happen if you migrate a site and not all uploaded content is imported.
- File or folder permissions have been changed.

To troubleshoot:

- Verify that your site is set to Public or Coming Soon by going to *Settings → Reading* and scrolling down to the “**Site Visibility**” section.
- Using [SFTP](https://wordpress.com/support/sftp/) or [SSH](https://wordpress.com/support/ssh/), verify that the media files exist in your site Uploads folders.
    - If the media does not exist, you will need to re-import it.
    - If the media was manually uploaded directly to the file structure via SFTP or SSH, or is in a custom folder structure, you can use a plugin like [Media Sync](https://wordpress.org/plugins/media-sync/) to associate it correctly.
- Verify that your folder and file permissions match the [default values](https://wordpress.com/support/manage-permissions/#file-permissions).
    - If permissions have been changed, you can correct them following the instructions provided in the [Change File Permissions](#change-file-permissions) section above.

### Privacy errors

You might see an error like “403 Forbidden: Permission denied” or “Our sentries tell us that you should not be here.”

These messages usually appear if your site is set to private or if you’re using a maintenance plugin to hide it before launch. In these cases, some features in your site’s dashboard may be limited or inaccessible.

To resolve this issue, we recommend using the [Coming Soon](https://wordpress.com/support/privacy-settings/#coming-soon) mode. Activate this mode by following these steps:

- Visit your site’s [dashboard](https://wordpress.com/home/).
- Navigate to *Settings →* *Reading*.
- Scroll to the “**Site Visibility**” section.
- Choose from the “**Coming soon**” option.
- Click the **“Save Changes”** button at the bottom of the page.
