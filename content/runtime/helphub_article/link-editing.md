---
type: document
title: Link control
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/link-editing/"
tags:
timestamp: "2026-06-16T19:28:18+00:00"
wordpress:
  id: 2148
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:18"
  date_gmt: "2026-06-16 19:28:18"
  modified: "2026-06-16 19:28:18"
  modified_gmt: "2026-06-16 19:28:18"
  slug: link-editing
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/link-editing/"
  comment_count: 0
  terms:
    category:
      - block-editor
      - customization
---

[Go to the list of blocks](https://wordpress.org/documentation/article/blocks/)

Use the Link control to add, edit, search for, and configure links in supported blocks, like the [Paragraph block](https://wordpress.org/documentation/article/paragraph-block/) and [Heading block](https://wordpress.org/documentation/article/heading-block/). You can use it to link selected text, images, buttons, and other block content to another page, post, file, email address, phone number, or external website.

Link options may appear slightly differently depending on the block you are using.

Refer to this article for [detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/).

## Adding links

There are a few different ways to add links in WordPress.

### Link button

To create a text link, highlight and select the text first. This opens a dialog box where you can search for pages, posts, attachments, or images on your own website or type a URL.

![Selected linked text in the WordPress editor with the Link button highlighted and the link search field open.](https://wordpress.org/documentation/files/2023/08/link-control-add-link.png)Start typing a keyword, page title, or post title to search for content on your site. For links to another website, paste the full URL, including `https://`.

### Keyboard shortcut

Highlight and select the text you want to link and use the **Ctrl+K** (or **⌘+K**) keyboard shortcut to quickly add a link.

### Copied URL

To turn selected text into a link, copy the URL you want to use. Then select the text and paste the URL using **Ctrl+V** on Windows or **⌘+V** on Mac.

**Note**: Pasting a URL by itself on a new line may create an Embed block or preview instead, depending on the URL.

## Edit an existing link

To edit an existing link, select the linked text. WordPress displays a link preview with options to open, edit, remove, or copy the link.

![Linked text selected in the WordPress editor with the link preview open below it.](https://wordpress.org/documentation/files/2023/08/link-control-edit-options.png)## Supported URLs

When adding a link, WordPress may ask you to “Please enter a valid URL” if the link looks incomplete or is not in a format WordPress recognizes.

![The link text 'Hello, world!' is shown as the link URL with an error message to please add a valid URL](https://wordpress.org/documentation/files/2023/08/link-control-url-validation.png)Valid URL error messageBelow is a list of supported URL formats:

- **Full URL** – `https://wordpress.org`
- **Page or file path on the same site** – `/about`
- **Same-page anchor link** – `#contact`
- **Email link** – `mailto:name@example.com`
- **Phone link** – `tel:+123456789`

For links to another website, include the full address with `https://`.

**Note**: WordPress checks whether the link is formatted like a valid URL. It does not confirm that the destination page exists or loads successfully.

## Advanced options

When editing a link, expand the Advanced section to enable or disable the following settings:

- **Open in new tab**
    - Turn on **Open in new tab** to open the link in a separate browser tab. Leave it off to open the link in the same tab.
- **Mark as nofollow**
    - Turn on **nofollow** if you do not want search engines to associate your site with the linked page or crawl the linked page from your site.

![Link editing panel with the advanced options displayed](https://wordpress.org/documentation/files/2024/01/image-8.png)## Changelog

- Updated 2026-06-13 (props to @blessingoye @kjoyner)
    - Added more clarity to Link control intro and nofollow definition
    - Added “Edit an existing link” section
    - Placed different options for adding links into their own sections
    - Combined changelogs
    - Updated “Invalid URLs” heading to “Supported URLs” for clarity
- Updated 2025-05-19
    - Props to @get\_dave, @0mirka00, @sirlouen, @jeryj, @paaljoachim, @wildworks, @scruffian
    - Muted embedded video
    - Updated screenshots with WordPress 7.0
    - Minor updates to content on the Adding links section.
- Updated 2025-06-05
    - Updated screenshots with WordPress 6.8
- Updated 2023-07-05
    - Removed developer jargon and old links to Codex
