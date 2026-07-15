---
type: document
title: Comments Count block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/comments-count-block/"
tags:
timestamp: "2026-06-16T19:28:12+00:00"
wordpress:
  id: 2119
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:12"
  date_gmt: "2026-06-16 19:28:12"
  modified: "2026-06-16 19:28:12"
  modified_gmt: "2026-06-16 19:28:12"
  slug: comments-count-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/comments-count-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - theme-blocks
---

The Comments Count block displays the total number of comments for the current post or page. It’s most useful in single post/page templates or inside a Post Template within a Query Loop.

## Where you can use this block

- Single posts and pages (when comments are enabled).
- Post Template inside a Query Loop (for example, on index or archive templates).
- Note: The block requires post context. It won’t display on non‑singular pages unless it’s inside a Post Template (such as within a Query Loop).

## Add the Comments Count block

1. Open a post, page, or template in the editor.
2. Place your cursor where you want the count to appear (for example, near the byline or meta).
3. Click the + Block Inserter, search for “Comments Count,” and select it. Tip: You can also type /comments count on a new line to insert it quickly.

## Behavior notes

- The block respects your Discussion settings. If comments are disabled, the count may show 0 or be hidden depending on your theme and settings.
- If a post is password‑protected, the count may be hidden until the password is entered (behavior can vary by theme).
- When used in a Query Loop, each Comments Count displays the correct total for its corresponding post.

## Block toolbar

The block toolbar displays several tools used to customize each block. When you select the **Comments Count** block, it will show the block toolbar that contains the following tools:

### Transform to

Click on the “Transform” button to convert the *Comments Count* block into a “Group”, “Columns”, “Details”, or “Comments Count” block.

![](https://wordpress.org/documentation/files/2025/11/comments-count-transform.png)### Drag icon

To drag and drop the block to a new location, click and hold the rectangle of dots, then drag it to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block.

![](https://wordpress.org/documentation/files/2025/11/comments-count-drag-1.png)Detailed instructions on moving a block within the editor can be found [here](https://wordpress.org/support/article/moving-blocks/)

### Move arrows

The up and down arrow icons can be used to move the block up and down on the page.

![](https://wordpress.org/documentation/files/2025/11/comments-count-move-arrow-1-1024x234.png)### Align

Use the change alignment tool to align the *Comments Count* block. Choose one of the following options:

- **Align text left**
- **Align text right**
- **Align text center**

![](https://wordpress.org/documentation/files/2025/11/comments-count-align.png)## Block Settings

WordPress blocks have specific configuration options in the block settings panel. To access the ****Comments Count**** block settings panel, click the **Settings** button at the top-right corner of the WordPress editor. Alternatively, click the **More options** or three dots icon in the ****Comments Count**** block toolbar and select **Show more settings**.

**Color**

The ****Comments Count**** block provides Color settings options to change the text and background colors.

For details refer to this support article: [Color settings overview](https://wordpress.org/documentation/article/colors-settings-overview/)

**Typography**

The **Comments Count** block provides typography settings to change the font family, appearance, line height, letter spacing, decoration, letter case, and font size.

For details refer to this support article: [Typography settings overview](https://wordpress.org/documentation/article/typography-settings-overview/)

**Dimensions**

The **Comments Count** block provides dimension settings options to add padding and margin.

For details refer to this support article: [Dimension settings overview](https://wordpress.org/documentation/article/dimension-controls-overview/)

**Border**

The **Comments Count** block provides border settings options to add border color, width, and radius.

For details refer to this support article: [Border settings overview](https://wordpress.org/documentation/article/border-settings-overview/)

**Advanced**

The **Advanced** section allows you to add CSS class(es) to the **Comment Count** block. Therefore, you can insert custom CSS styles into the block.

## Changelog

- Created 2025-12-02
