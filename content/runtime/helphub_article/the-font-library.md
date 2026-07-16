---
type: document
title: The Font Library
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/the-font-library/"
tags:
timestamp: "2026-06-16T19:28:13+00:00"
wordpress:
  id: 2131
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:13"
  date_gmt: "2026-06-16 19:28:13"
  modified: "2026-06-16 19:28:13"
  modified_gmt: "2026-06-16 19:28:13"
  slug: the-font-library
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/the-font-library/"
  comment_count: 0
  terms:
    category:
      - appearance
      - customization
---

The Font Library allows you to manually upload your own collection or connect directly to Google Fonts and manage fonts in WordPress. Starting in 7.0, it is available globally for [block themes](https://wordpress.org/documentation/article/block-themes/) and classic themes.

## Navigate the Font Library

The Font Library lives in the Admin menu under **Appearance &gt; Fonts**.

![Fonts location in admin](https://wordpress.org/documentation/files/2024/10/Screenshot-2026-05-23-at-7.23.52-AM-1024x308.jpg)### Library

The Library tab contains any fonts installed on the site as well as the theme fonts. Any newly added fonts will appear in this tab.

![Screenshot of the  Library tab in the Manage Fonts panel in the WordPress editor, showing the available fonts. Fonts listed include Cardo (3 variants active), Inter (1 variant active), System Sans-serif (1 variant active), and System Serif (1 variant active).](https://wordpress.org/documentation/files/2024/10/2-library.png)### Upload

A new collection or a single font file can be uploaded on this tab. The supported formats are .ttf, .otf, .woff, and .woff2

### Install Fonts

The Install Fonts tab allows you to install **Google Fonts** for use on your site.

First, you need to give access to Google Fonts.

![Screenshot of the Install Fonts tab in the WordPress 'Manage Fonts' panel. The tab displays a prompt to Connect to Google Fonts, explaining that permission is required to connect directly to Google servers. Installed fonts will be stored locally on the site. It also explains how to   upload fonts manually on the 'Upload' tab. A blue button labeled 'Allow access to Google Fonts' is at the bottom of the panel.
](https://wordpress.org/documentation/files/2024/10/Google-Fonts.png)Access can be revoked by clicking on the 3 dots on the right side.

![Screenshot of the Install Fonts tab in the WordPress Manage Fonts panel, showing a dropdown menu with the option to Revoke access to Google Fonts. The menu is accessed through the three-dot button in the upper right.](https://wordpress.org/documentation/files/2024/10/Revoke-access.png)Find the font you wish to use using the search box. You can filter search results using the category dropdown menu in the upper right side.

![Screenshot of the Google Fonts installation interface in WordPress, highlighting the search functionality. The search term 'Bodoni' is entered in the search bar on the left. Two results are displayed: 'Bodoni Moda' with 12 variants and 'Libre Bodoni' with 8 variants. A category dropdown is on the right, currently set to All.](https://wordpress.org/documentation/files/2024/10/6-font-search.png)#### Install a Google Font

To install a font with Google Fonts, choose the desired font &gt; Select the font variants in the next panel &gt; click Install. You’ll see a notice indicating whether the font installed successfully. Newly installed fonts will appear in the Library tab.

The available variations will also appear in the Styles section.

## Removing fonts

![Fonts library with Delete and Update options ](https://wordpress.org/documentation/files/2024/10/Screenshot-2026-05-23-at-7.18.14-AM-1024x518.jpg)To temporarily remove access to some variants of a font, you can check/uncheck them in the Font Library, then click Update.

To completely remove the font family or single font, click on it, check the box for the font then click **Delete**. You’ll be prompted to confirm the deletion before the Font family is uninstalled.

After a font is deleted, a “Font family uninstalled successfully” notice appears on the main Library tab.

## Change a default font

To update a block’s font across your site, navigate to Appearance &gt; Editor &gt; Styles

From here you can change the default font used across the entire site. You can also update the default font used for specific block types such as Heading or Paragraph.

## Changelog

- Updated 2026-05-23 (props to @awetz583)
    - Updated font menu location for 7.0
    - Updated videos and screenshots
- Created 2024-10-17
