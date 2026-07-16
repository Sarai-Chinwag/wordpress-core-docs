---
type: document
title: Comments Link block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/comment-link-block/"
tags:
timestamp: "2026-06-16T19:28:12+00:00"
wordpress:
  id: 2118
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:12"
  date_gmt: "2026-06-16 19:28:12"
  modified: "2026-06-16 19:28:12"
  modified_gmt: "2026-06-16 19:28:12"
  slug: comment-link-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/comment-link-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - theme-blocks
---

The Comments Link block displays a link to the comments section for the current post or page. You can customize the link text and optionally include the total number of comments. This block is most useful in single post/page templates or inside a Post Template within a Query Loop.

## Where you can use this block

- Single posts and pages.
- Post Template inside a Query Loop (for example, on an index or archive template).
- The block requires post context. It does not display on non-singular pages without a current post.

## Add the Comments Link block

1. Open a post, page, or template in the editor.
2. Place your cursor where you want the link to appear (for example, under the post title or byline).
3. Click the + Block Inserter and search for “Comments Link,” then select it.
    - Tip: You can also type /comments-link on a new line to insert it quickly.

## Behavior notes

- If comments are disabled for the current post or the post is password-protected, the link may be hidden or disabled depending on your discussion settings.
- When used in a Query Loop, each Comments Link points to the corresponding post’s comments section.

## Block toolbar

The block toolbar displays several tools used to customize each block. When you select the **Comments Link** block, it will show the block toolbar that contains the following tools:

### Transform to

Click on the “Transform” button to convert the *Comments Link* block into a “Group”, “Columns”, “Details”, or “Comments Count” block.

![The Transform button in the Comment Link Block is selected and shows options to transform to Group, Columns, Details, or Comments count](https://wordpress.org/documentation/files/2025/11/comment-link-transform-1.png)### Drag icon

To drag and drop the block to a new location, click and hold the rectangle of dots, then drag it to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block.

![The Drag and Drop icon is clicked and highlighted.](https://wordpress.org/documentation/files/2025/11/comment-link-drag-1-1024x239.png)### Move arrows

The up and down arrow icons can be used to move the block up and down on the page.

![The Up and Down arrows of the Comments Link block is selected.](https://wordpress.org/documentation/files/2025/11/comment-link-move-arrows-1024x232.png)Detailed instructions on moving a block within the editor can be found [here](https://wordpress.org/support/article/moving-blocks/)

### Align

Use the change alignment tool to align the *Comments link* block. Choose one of the following options:

- **Align text left**
- **Align text right**
- **Align text center**

![The Alignment Tool of the Comment Link block is selected and highlighted.](https://wordpress.org/documentation/files/2025/11/comment-link-align-1024x343.png)## Block Settings

WordPress blocks have specific configuration options in the block settings panel. To access the **Comments Link** block settings panel, click the **Settings** button at the top-right corner of the WordPress editor. Alternatively, click the **More options** or three dots icon in the **Comments Link** block toolbar and select **Show more settings**.

**Color**

The **Comments Link** block provides Color settings options to change the text and background colors.

For details refer to this support article: [Color settings overview](https://wordpress.org/documentation/article/colors-settings-overview/)

**Typography**

The **Comments Link** block provides typography settings to change the font family, appearance, line height, letter spacing, decoration, letter case, and font size.

For details refer to this support article: [Typography settings overview](https://wordpress.org/documentation/article/typography-settings-overview/)

**Dimensions**

The **Comments Link** block provides dimension settings options to add padding and margin.

For details refer to this support article: [Dimension settings overview](https://wordpress.org/documentation/article/dimension-controls-overview/)

**Border**

The **Comments Link** block provides border settings options to add border color, width, and radius.

For details refer to this support article: [Border settings overview](https://wordpress.org/documentation/article/border-settings-overview/)

**Advanced**

The **Advanced** section allows you to add CSS class(es) to the **Comments Link** block. Therefore, you can insert custom CSS styles into the block.

## Changelog

- Created 2025-12-02
