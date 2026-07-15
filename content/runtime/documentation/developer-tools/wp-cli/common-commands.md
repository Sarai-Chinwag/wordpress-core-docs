---
type: document
title: Common commands
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/common-commands/"
tags:
timestamp: "2026-06-16T19:29:23+00:00"
wordpress:
  id: 2460
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:23"
  date_gmt: "2026-06-16 19:29:23"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: common-commands
  parent: 2513
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/common-commands/"
  comment_count: 0
---

There are a number of commands that you may find helpful when working with your site. These commands and their common parameters are included below. There are also many other useful commands available, and these sections do not include them all. Please refer to the [WordPress.org Developer CLI Commands Guide](https://developer.wordpress.org/cli/commands) for more information.

In the CLI itself you can also make use of the help command to find more information about what parameters and flags are available.

For example: `wp help plugin`

## Manage Users

Use the following commands to manage your site’s local users. Please keep in mind that changing user aspects in CLI will not change the settings for WordPress.com user accounts that may be associated with local accounts.

The user serving as your primary Jetpack connection must have an email that matches the email of the site owner’s WordPress.com account. If the email does not match, the site’s Jetpack Connection will not work correctly. The username does not need to match.

### wp user list

List all users on the site. If you have many users you may wish to restrict the list to specific roles by using the `--role` flag:

```
wp user list –role=adminstrator
```

wp user list –role=adminstratorCopyCopied

### wp user get {USER ID/NAME/EMAIL}

Return a specific user, either by user id, username, or email address.

### wp user create {NAME} {USER EMAIL} –role={ROLE}

Create a new user with the name, user email, and role defined.

This command does not create a matching WordPress.com user. If you are using [WordPress.com Secure Sign-On (SSO)](https://wordpress.com/en/support/wordpress-com-secure-sign-on-sso/) you should instead create the local user by inviting a user via *Users &gt; Add New*. This will ensure a WordPress.com account and local user are both created.

### wp user update {USER ID/NAME/EMAIL} –{KEY}={VALUE}

Update a user based on the user ID, name, or email. Updates the set of key/value pairs specified.

Keys include `display_name`, `user_email`, `role`, and `user_pass`

Note: You will not be able to update a user’s `user_login` with the `wp user update` command. Instead, updating the `user_login` requires using `wp search-replace`. This change, however, is not recommended as it performs partial replacements. For example: If there are two users with the usernames “techie” and “nontechie”, replacing “techie” with “sense” will result in “sense” and “nonsense”.

If you would still like to replace a `user_login` the command to use is:

```
wp --skip-plugins --skip-themes search-replace "old username" "new username" *users --include-columns=user_login,user_nicename --dry-run
```

wp --skip-plugins --skip-themes search-replace "old username" "new username" \*users --include-columns=user\_login,user\_nicename --dry-runCopyCopied

## Manage Plugins and Themes

Use the following commands to manage your plugins and themes. When working with plugins and themes, please note that the related slug will not always match the plugin/theme name.

If you are having issues with a plugin or theme you can start your command with `wp --skip-themes --skip-plugins` to run the commands despite conflicts.

You can find [more information about skip commands below](#skipping).

### wp plugin/theme list

List all the plugins/themes installed on the site and their status. From these lists you will find the slugs of your installed plugins and themes, which you can use for the purpose of running the commands below.

### wp plugin/theme activate {SLUG}

Activate the specified plugin/theme.

To deactivate a theme, you need to activate another in its place.

### wp plugin deactivate {SLUG}

Deactivate the specified plugin.

### wp plugin/theme delete {SLUG}

Delete the specified plugin/theme.

You cannot delete an active theme or managed themes with this command. To remove an active theme, switch to a different theme first, then delete the theme that you want. To remove managed themes, [you may do so via SFTP](https://wordpress.com/support/sftp/).

### wp plugin/theme install {SLUG or URL TO INSTALLATION\_FILE}

Install a plugin/theme from the WordPress.org repo based on the slug or via a URL path to an installation .zip file.

You can not overwrite an existing plugin/theme unless you run the command with the `--force` flag. You can use this to update plugins and fix corrupt plugin folders.

To automatically activate a plugin after installation, include the `--activate` flag.

### wp plugin/theme update {SLUG}

Update the specified plugin/theme if available. You cannot use this command to update managed plugins/themes.

You can also use the `--all` flag if you want to update all plugins/themes.

### wp plugin auto-updates {COMMAND} {PLUGIN SLUG}

Display the status of plugin updates or enable/disable updates for a specific plugin.

Available COMMANDS are `status`, `enable`, `disable`.

You cannot disable updates for managed plugins or themes.

## Manage Jetpack

Use the following commands to adjust Jetpack modules, check your Jetpack connection, or troubleshoot Jetpack issues.

Disconnecting Jetpack will disable many important WordPress.com features including general site and billing management.

Using `--skip-plugins` will prevent these commands from working.

You can find [more information about skip commands below](#skipping).

### wp jetpack module list

List the Jetpack modules and their statuses.

### wp jetpack module activate {MODULE NAME}

Activate the specified Jetpack module.

You can also use `all` in place of {MODULE NAME}

### wp jetpack module deactivate {MODULE NAME}

Deactivate the specified Jetpack module.

You can also use `all` in place of {MODULE NAME}

### wp jetpack status

Report the status of Jetpack, including which user account is the primary connection (this should always be the site owner).

An additional parameter, `full`, can be added to report full details, including Jetpack version, WordPress version, and module status.

While your [site’s visibility is set to Private](https://wordpress.com/support/privacy-settings/#privacy-options), some Jetpack modules are disabled and cannot be managed in CLI. These modules are: Ads, Asset CDN, Enhanced Distribution, Google Analytics, Image CDN, JSON API, Publicize, Sharing, Site Verification, and Sitemaps.

## Manage Site Settings

Use the following commands to manage various aspects of your site and users.

### wp site empty –yes

Empty a site of content (posts and pages).

### wp site empty –uploads –yes

Empty the site, including media files.

`wp site empty` commands are irreversible. If you use them, your content will be removed permanently. To recover them, [you will need to restore from a previous backup](https://developer.wordpress.com/docs/platform-features/real-time-backup-restore/). Please ensure you have a backup available before using the function.

`wp site` commands will not delete themes or plugins, nor will they reset a theme or erase plugin settings. If you need to reset your site completely, [please reach out to WordPress.com support](https://developer.wordpress.com/docs/glance/support/).

### wp option get {OPTION}

Return the value of an option.

### wp option update {OPTION} {VALUE}

Update the value of an option.

### wp option add {OPTION} {VALUE}

Add a new option.

### wp option delete {OPTION}

Delete an option.

The options table is the “control center” of a website. If an option is improperly edited or deleted, you may stop your entire site from working.

When working with `wp option` commands, if you get the following error in the terminal it may mean the options table has been corrupted:

```
One or more database tables are unavailable. The database may need to be repaired
```

One or more database tables are unavailable. The database may need to be repaired

You can restore the table by rewinding the site’s SQL table to a last good copy. Please note, this will reverse all mutable changes to the database that occur after the restore point and can result in lost data.

To restore an SQL table:

1. In the site’s dashboard, navigate to **Jetpack &gt; Activity Log**.
2. Select a [backup point](https://developer.wordpress.com/docs/platform-features/real-time-backup-restore/) to rewind to.
3. Uncheck all boxes except for **Site Database (SQL)**.
4. Click **Confirm Rewind**.

### wp role list

Return a list of roles

### wp role reset {ROLE}

Reset the specified role. You can list multiple roles (without commas)

```
wp reset role administrator editor
```

wp reset role administrator editorCopyCopied

You can also replace {ROLE} with `--all` to reset all at once

## Manage Content

You can use the following commands to manage your site content, including posts/pages, menus, and media.

### wp post list

Return a list of blog posts.

You can use a variety of flags with this command, including:

`--format={FORMAT}`

`--posts_per_page={#}`

`--post_type={TYPE}`

Possible post types include `posts`, `pages`, `attachments`, and `products`.

Multiple flags can be used at once.

```
wp post list --post_type=posts,pages --format=count
```

wp post list --post\_type=posts,pages --format=countCopyCopied

### wp post update {POST\_ID} –{KEY}={VALUE}

Update post information.

```
wp post update123 --post_status=draft
```

wp post update123 --post\_status=draftCopyCopied

### wp post delete {POST\_ID}

Delete a post.

### wp post exists {POST\_ID}

Check if a post exists.

### wp menu list

List menus on the site.

### wp menu item list {TERM\_ID}

List menu items of a specific menu.

### wp menu item update {MENU\_ITEM\_PARENT\_ID}

Update a specific menu item.

The `wp menu` commands can be useful if you see the primary menu freezing in the Customizer or /wp-admin screen.

### wp media regenerate

Regenerate media thumbnails when the Jetpack Photon module is deactivated.

You can use the `--only-missing` flag to skip existing image sizes.

## Troubleshooting Site Issues

You can use the following commands when troubleshooting issues on your site. Checking for PHP errors can help you identify sources of errors on your site or use `wp wpcomsh` commands to quickly perform plugin conflict checks or to adjust whether or not you are using managed versions of plugins.

Both Jetpack and Akismet are managed plugins that are required for your site to work correctly here at WordPress.com. These plugins should remain activated and cannot be switched to unmanaged versions.

### wp php-errors

Output error logs in WP-CLI.

This command only outputs PHP errors, not of any other language such as HTML, Javascript, or CSS. To see these other errors, use the Browser Inspector.

You can add the `--limit` flag to reduce the number of errors shown to improve readability.

```
wp php-errors –limit10
```

wp php-errors –limit10CopyCopied

### wp wpcomsh deactivate-user-plugins

Deactivate user plugins.

You can use the `--interactive` flag to force confirmation for each plugin.

This command will not deactivate Akismet, Jetpack, or managed ecommerce plugins.

### wp wpcomsh reactivate-user-plugins

Reactivate user plugins.

You can use the `--interactive` flag to to force confirmation for each plugin.

### wp wpcomsh persistent-data {DATA}

Return persistent data (which Jetpack uses to verify site capabilities).

Available DATA options include:

`WPCOM_PLAN_EXPIRATION`

`JETPACK_BLOG_TOKEN`

`WPCOM_PURCHASES`

`WPCOM_PUBLIC_COMING_SOON`

### wp wpcomsh plugin use-managed {SLUG}

Use a managed ([symlinked](https://developer.wordpress.com/docs/guides/symlinked-files-folders/)) version of a plugin.

This command will remove existing, unmanaged versions and replace them with managed versions. It is available for `amp`, `classic-editor`, `coblocks`, `crowdsignal-forms`, `full-site-editing`, `gutenberg`, `layout-grid`, `page-optimize`, `wp-seo`, `woocommerce`, WooCommerce Extensions from the WordPress.com Marketplace, and [plugins included in the Commerce plan](https://wordpress.com/support/plan-features/entrepreneur-plan/#included-in-the-entrepreneur-plan).

You can use the `--remove-existing` flag to skip the confirmation step.

### wp wpcomsh theme use-managed {SLUG}

Use a managed ([symlinked](https://developer.wordpress.com/docs/guides/symlinked-files-folders/)) version of a theme.

This command will remove existing, unmanaged versions and replace them with managed versions. It is available for all WordPress.com themes, Storefront, and any Twenty \* themes (ex: Twenty Twenty Two).

You can use the `--remove-existing` flag to skip the confirmation step.

### wp wpcomsh plugin use-unmanaged {SLUG}

Use an unmanaged (not [symlinked](https://developer.wordpress.com/docs/guides/symlinked-files-folders/)) version of a plugin

This command will remove existing, managed versions and replace them with unmanaged versions from the WordPress.org plugin repository. It will not work for WooCommerce Extensions from the WordPress.com Marketplace and [plugins included in the Commerce plan](https://wordpress.com/support/plan-features/entrepreneur-plan/#included-in-the-entrepreneur-plan). You will need to install these plugins manually to get the unmanaged version.

You can use the `--remove-existing` flag to skip the confirmation step and the `--version={X.Y.Z}` flag to define the version to install.

### wp wpcomsh theme use-unmanaged {SLUG}

Use an unmanaged (not [symlinked](https://developer.wordpress.com/docs/guides/symlinked-files-folders/)) version of a theme.

This command will remove existing, managed versions and replace them with unmanaged versions from the WordPress.org theme repository if available.

You can use the `--remove-existing` flag to skip the confirmation step and the `--version={X.Y.Z}` flag to define the version to install.

The WordPress.com Site Helper or `wpcomsh` must-use plugin runs on sites with activated hosting features to make them work seamlessly in the WordPress.com ecosystem.

### wp cache flush

Flush the cache.

This command is not meant to be a fix for issues and can obscure root causes. Please use with care. Clearing the cache may also make your site run slower while the cache is rebuilt on page load.

## Skipping Plugins and Themes

You may want to skip plugins, and sometimes themes, when running CLI commands. This can be useful for troubleshooting conflicts or for overriding restrictions placed by plugins, such as control over roles.

- `--skip-plugins` can be added before any command and skips plugins
- `--skip-themes` can be added before any command and skips themes

You can use these commands together. You can also use these commands with slugs to skip specific plugins or themes. This can be useful for ruling out the effects of certain plugins or themes when deactivation is not possible.

For example:

```
wp --skip-plugins=woocommerce, code-snippets, elementor-pro plugin list
```

wp --skip-plugins=woocommerce, code-snippets, elementor-pro plugin listCopyCopied
