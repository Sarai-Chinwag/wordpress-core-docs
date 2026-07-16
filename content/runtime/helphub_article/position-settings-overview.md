---
type: document
title: Position Settings overview
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/position-settings-overview/"
tags:
timestamp: "2026-06-16T19:28:21+00:00"
wordpress:
  id: 2167
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:21"
  date_gmt: "2026-06-16 19:28:21"
  modified: "2026-06-16 19:28:21"
  modified_gmt: "2026-06-16 19:28:21"
  slug: position-settings-overview
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/position-settings-overview/"
  comment_count: 0
  terms:
    category:
      - appearance
      - customization
---

The position settings in [blocks](https://wordpress.org/documentation/article/blocks/) allow you to set how an element is positioned in your site. These settings can only be found in a few blocks when they are placed at the root of site.

The position settings are available when you use the [block editor](https://wordpress.org/documentation/article/wordpress-editor/). If you are new to the block editor, [this guide](https://wordpress.org/documentation/article/working-with-blocks/) will show you how to work with blocks.

## How to access position settings

To access the position settings, either add a Group, Row, or Stack block to the root of your content, meaning not placed within another block. In the block settings sidebar of the block you added, you will find the **Position** section as shown below.

## Type of settings

![](https://wordpress.org/documentation/files/2023/03/Sticky-positioning-horizontal-view-1-361x1024.png)Each supported block comes with two different position settings. Automatically, blocks will use the “Default” option. You can switch between these two options as you’d like. If you do not see these settings, it’s because the block either doesn’t support the positioning option or, if it’s one of the blocks listed under blocks that include these settings, the block is not placed in the root of your site, meaning not placed within another block.

### Default

This is the option chosen automatically. It allows a block to be positioned as it usually is in relation to other blocks.

### Sticky

This option allows you to keep top-level blocks fixed to the top of a page as visitors scroll. This matches the CSS property of the same name.

## Blocks that include position settings

As a reminder, this setting will only show for the following blocks when that block is placed at the root of your site, meaning not placed within another block.

- Group
- Row
- Stack

## Demonstration

**Making a Header Template Part sticky**

A common use case for the sticky positioning option is having a header that sticks to the top of the page as a visitor scrolls. To accomplish this, follow these steps:

1. **Open [List View](https://wordpress.org/documentation/article/list-view/)** and select the Header Template Part block. Ensure this Header Template Part block is not placed within another block.
2. Select the three dot menu either in List View or the block toolbar and choose the option to **Group**. This will wrap the Header Template Part block in a Group block.
3. Select the Group block that was just created and **open the Block Settings sidebar**.
4. Add a background color to the Group block under the Styles tab in the Block Settings. This ensures that when a visitor is scrolling, the items in the Header Template part aren’t interfering with the rest of the blocks on the page.
5. Scroll down to the Position settings and choose **Sticky**.

## Changelog

- Created 2023-03-27
