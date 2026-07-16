---
type: document
title: Block-based Widgets Editor
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/block-based-widgets-editor/"
tags:
timestamp: "2026-06-16T19:28:36+00:00"
wordpress:
  id: 2231
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:36"
  date_gmt: "2026-06-16 19:28:36"
  modified: "2026-06-16 19:28:36"
  modified_gmt: "2026-06-16 19:28:36"
  slug: block-based-widgets-editor
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/block-based-widgets-editor/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

The Block-based Widgets Editor brings the power of blocks to the **Theme Customizer** and **Appearance** &gt; **Widgets** sections in the WordPress Administration Screens allowing you to add blocks right next to any current widgets. You can now customize your Widget Areas using blocks, just like how you use the [block editor](https://wordpress.org/documentation/article/wordpress-editor/) to create content.

The Block-based Widgets Editor was introduced in 5.8 for those who use classic themes with [widgets](https://wordpress.org/documentation/article/wordpress-widgets/). With WordPress 5.8 or higher and a classic theme like [Twenty Twenty](https://wordpress.org/documentation/article/twenty-twenty/), you can see the Block-based Widgets Editor.

![Block-based Widgets Editor](https://wordpress.org/documentation/files/2021/07/test-widgets_v2-1-1024x643.jpeg)Appearance &gt; Widgets View![Widget area in the Customizer](https://wordpress.org/documentation/files/2021/07/test-widgets-customizer-1-1024x643.jpeg)Customizer View## How to use blocks in the Widget editor

The interface replicates the [Post Editor](https://wordpress.org/documentation/article/wordpress-editor/) experience, allowing you to use similar workflows like drag and drop. The biggest difference is that you will see distinct editing areas that represent the various Widget Areas as part of your theme, like Footer and Sidebar.

Within each of these areas, you can add blocks like you would in the Post Editor. You can edit any previous Widgets you’ve added using the **Legacy Widgets** block. Of note, [Theme blocks](https://wordpress.org/documentation/article/blocks/#theme-blocks) (Site Logo, Site Title, etc) and [Synced patterns](https://wordpress.org/documentation/article/reusable-blocks/) have been disabled in this editor.

**How to add a block**

1. Navigate to **Appearance** &gt; **Widgets**.
2. Click on a specific Widget Area you’d like to edit.
3. Select the **+** prompt to add a block. You can use the search functionality to find the block you want or select **Browse All** to see the various options.

**How to move items between areas**

There are two ways to move items between areas:

1. You can use drag and drop by hovering over the block toolbar, selecting and holding it, and dragging it to a new section.
2. You can use the option shown below in the block toolbar to move to the desired Widget Area:

![Block widget mover](https://wordpress.org/documentation/files/2021/07/Screen-Shot-2021-07-06-at-8.36.47-PM-1-edited.png)## How to use blocks in the Customizer

If you’re more comfortable managing your Widget Areas in the Customizer, you can now add widgets and blocks with the same ability to live preview, schedule changes, and publish that you’re used to. The main thing to keep in mind is that, due to the small size of the Customizer, some settings require a few more steps to find. To find all block settings, follow the steps below:

1. Use the **+** to add a new block.
2. After adding the block, select the three-dot ellipsis menu and choose the top option of **Show more settings**.
3. From there, you’ll see more options to customize your block to your liking.

## How to manage Legacy Widgets

For any widget that doesn’t come with WordPress and that hasn’t been converted to a block, you can use the Legacy Widget block to manage any existing widgets or third-party widgets.

## How to opt-out

A user may install and activate [the Classic Widgets plugin](https://wordpress.org/plugins/classic-widgets/) to opt-out of this feature. This will return you to the [original view](https://wordpress.org/documentation/article/appearance-widgets-screen/) of the **Appearance** &gt; **Widgets** and the **Customizer**.

## Demonstration of the Block-based Widgets Editor

Demonstration of the block-based Widgets Editor and blocks in Customizer experience## Resources

- [Block-based Widgets Editor in WordPress 5.8](https://make.wordpress.org/core/2021/06/29/block-based-widgets-editor-in-wordpress-5-8/)

## Changelog

- Updated 2022-12-06
    - Added ALT tags for the images
    - Added internal links to other support articles.
    - Updated videos.
- Created 2021-07-08
