---
type: document
title: Symlinked files and folders
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/symlinked-files-folders/"
tags:
timestamp: "2026-06-16T19:29:25+00:00"
wordpress:
  id: 2483
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:25"
  date_gmt: "2026-06-16 19:29:25"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: symlinked-files-folders
  parent: 2479
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/symlinked-files-folders/"
  comment_count: 0
---

[](https://wordpress.com/support/symlinked-files-and-folders/#about-symlinked-files-and-folders)On WordPress.com, WordPress core files, along with WordPress.com’s themes and plugins, are symbolically linked using symlinks. This helps keep your site secure and ensures the files are always up to date.

A symlink acts like a shortcut. It doesn’t contain the actual files in your site’s SFTP system but points to them. Since these files are managed at the platform level, you won’t be able to access or edit them directly.

This guide explains when symlinks might appear on your site and what you can do if you need to modify a symlinked file.

## Recognizing symlinks in SFTP

When accessing your site’s files via [SFTP](https://wordpress.com/support/sftp/), you will encounter symlinked files and folders.

You can recognize a symlinked file or folder by its icon in your FTP client. Some FTP clients may have a tiny arrow on the bottom-left part of the icon. On others, it might have a question mark over it:

![A WordPress file structure with a few symlinked folders](https://developer.wordpress.com/wp-content/uploads/2024/04/symlinked-example-1.png)

![A WordPress file structure with a few symlinked folders](https://developer.wordpress.com/wp-content/uploads/2024/04/symlinked-example-2.png)

If you try to open a symlinked folder, such as the `__wp__` folder shown in the screenshot above, you’ll see an error message like this:

```
Error:	/htdocs/__wp__: open for read: no such file or directory
Error:	File transfer failed
```

Error: /htdocs/\_\_wp\_\_: open for read: no such file or directory Error: File transfer failedCopyCopied

Symlinked files can’t be accessed or edited directly. This might seem like a permissions issue with your SFTP account, but it’s not. It simply means the file or folder is symlinked and managed by the platform.

## Symlinked themes[](https://wordpress.com/support/symlinked-files-and-folders/#symlinked-themes)

WordPress.com uses symlinks to manage all its [themes](https://wordpress.com/support/themes/). This allows us to make sure that themes are up to date with the latest patches and to prevent updates that may introduce conflicts.

It is not possible to edit symlinked theme files directly, which also means you cannot modify the theme from within the WordPress admin using *Tools → Theme File Editor*. Basic theme customizations can be achieved using the [Site Editor](https://wordpress.com/support/site-editor/), [CSS](https://wordpress.com/support/css-basics/), or [Hooks](https://developer.wordpress.org/plugins/hooks/). Larger theme customizations can be achieved by creating a [child theme](https://wordpress.com/support/themes/child-themes/).

You can deactivate or delete any of the symlinked themes through the WordPress dashboard, [SFTP](https://wordpress.com/support/sftp/), or [WP-CLI](https://developer.wordpress.com/docs/developer-tools/wp-cli/). You can then upload the same theme from the [WordPress.com theme repository](https://wordpress.com/themes/) and it will not be symlinked.

## Symlinked plugins

On plugin-enabled plans, certain plugins come pre-installed to give you extra functionality when setting up your site. Just like WordPress.com themes, these plugins are symlinked. This setup helps ensure they stay updated with the latest patches and reduces the risk of updates causing conflicts.

### Plugins pre-installed on the Business plan

The following plugins come pre-installed and are symlinked on the Business plan:

- Akismet\*
- Classic Editor
- Crowdsignal Forms\*
- Crowdsignal Polls &amp; Ratings\*
- Gutenberg\*
- Jetpack\*
- Layout Grid\*
- Page Optimize\*

Plugins marked with an asterisk (\*) are activated by default.

Jetpack and Akismet are the only two plugins that must stay installed and activated, as they optimize WordPress.com sites with important security and storage features.

You can deactivate or delete any of the other plugins through the WordPress dashboard, [SFTP](https://wordpress.com/support/sftp/), or [WP-CLI](https://developer.wordpress.com/docs/developer-tools/wp-cli/). If you reinstall the same plugins from the [WordPress.com plugin repository](https://wordpress.com/plugins/), they will no longer be symlinked.

### Plugins pre-installed on the Commerce plan

The following plugins come pre-installed and are symlinked on the Commerce plan:

- Akismet Anti-spam: Spam Protection\*
- AutomateWoo
- Avalara AvaTax
- Blaze Ads\*
- Classic Editor
- Crowdsignal Forms\*
- Crowdsignal Polls &amp; Ratings\*
- Facebook for WooCommerce
- Google Analytics for WooCommerce\*
- Google for WooCommerce
- Gravatar Enhanced\*
- Gutenberg\*
- Jetpack\*
- Layout Grid\*
- MailPoet\*
- MailPoet Premium\*
- Page Optimize\*
- Pinterest for WooCommerce
- TaxJar
- TikTok\*
- WooCommerce\*
- WooCommerce Australia Post Shipping
- WooCommerce Back in Stock Notifications
- WooCommerce Canada Post Shipping
- WooCommerce EU VAT Number
- WooCommerce FedEx Shipping
- WooCommerce Gift Cards\*
- WooCommerce Min/Max Quantities
- WooCommerce Product Add-Ons\*
- WooCommerce Product Bundles
- WooCommerce Product Recommendations\*
- WooCommerce Royal Mail
- WooCommerce Shipment Tracking\*
- WooCommerce Shipping &amp; Tax\*
- WooCommerce UPS Shipping
- WooCommerce USPS Shipping
- WooPayments\*
- WordPress.com Site Migration File Shim\*

Plugins marked with an asterisk (\*) are activated by default, though this may vary depending on the options you selected during site setup.

Akismet and Jetpack are the only plugins that must stay installed and activated, as they optimize WordPress.com sites with important security and storage features.

You can deactivate or delete any of the other plugins through the WordPress dashboard, [SFTP](https://wordpress.com/support/sftp/), or [WP-CLI](https://developer.wordpress.com/docs/developer-tools/wp-cli/). If you reinstall the same plugins from the [WordPress.com plugin repository](https://wordpress.com/plugins/), they will no longer be symlinked.
