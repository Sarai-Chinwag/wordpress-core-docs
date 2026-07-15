---
type: document
title: Layout Settings overview
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/layout-settings-overview/"
tags:
timestamp: "2026-06-16T19:28:23+00:00"
wordpress:
  id: 2184
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:23"
  date_gmt: "2026-06-16 19:28:23"
  modified: "2026-06-16 19:28:23"
  modified_gmt: "2026-06-16 19:28:23"
  slug: layout-settings-overview
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/layout-settings-overview/"
  comment_count: 0
  terms:
    category:
      - appearance
      - customization
---

The layout settings in [blocks](https://wordpress.org/documentation/article/blocks/) allow you to change the justification and orientation of the nested child blocks inside their parent blocks. These settings can be found in the parent blocks within which the child blocks are nested.

The layout settings are available when you use the [block editor](https://wordpress.org/documentation/article/wordpress-editor/). If you are new to the block editor, [this guide](https://wordpress.org/documentation/article/working-with-blocks/) will show you how to work with blocks. You can read more about the new block editor features and improvements [in this article.](https://make.wordpress.org/core/2022/09/26/core-editor-improvement-catalyst-for-creativity/)

## How to access layout settings

To access the layout settings (in the parent block), click on any of the child blocks. The first icon in the block toolbar of the child block will select the parent block. In the block settings sidebar in the parent block, you will find the **Layout** section as shown below.

![Layout Settings for blocks](https://wordpress.org/documentation/files/2022/10/layout-settings-1.gif)## Navigating through nested blocks

The **List View** tool can be used to navigate between layers of content and nested blocks. This will make it easy to access the parent and child block.

![Top toolbar of the editor](https://wordpress.org/documentation/files/2021/07/Screen-Shot-2021-07-08-at-4.43.32-PM-1.png)To open **List View**, select the List View icon from the Top Toolbar of the [block editor](https://wordpress.org/documentation/article/wordpress-editor/) as shown above. It will remain open as you navigate through your content and stay open until you close it by either selecting the “x” or by selecting the List View icon again.

[Learn more about the List View](https://wordpress.org/documentation/article/list-view/).

![The list view of blocks](https://wordpress.org/documentation/files/2021/12/Screen-Shot-2021-12-21-at-3.32.17-PM-1024x926.png)

## Type of settings

Each supported block comes with different layout settings. If you make customizations to these settings and want to revert back to the original settings quickly, you can do so by selecting the three-dot menu icon and clicking **Reset All** as [shown in this article](https://wordpress.org/documentation/article/working-with-blocks/#reset-controls). This resets the settings and removes all of your changes.

### Justification

You can set the justification of the child blocks inside the parent block. You can justify the child blocks to the **Left**, **Center**, or **Right**.

Some blocks like [buttons block](https://wordpress.org/documentation/article/buttons-block/) will have the option to add **Space between items** which lets you add equal space between them. Space between items is applicable only for horizontal orientation. Eg: The *buttons block* is centered with equal spacing between the buttons if you have more than 1 button within the *buttons block*. *If the child blocks are set to be vertically aligned, you will not be able to put space between them.*

The justification settings can be found on the parent block’s toolbar and sidebar settings.

![Layout settings for justifying blocks](https://wordpress.org/documentation/files/2022/10/justification-2.gif)### Orientation

When you first add multiple blocks to a parent block, the child blocks will be displayed horizontally (i.e. next to each other.)

Another option is to display the child blocks vertically (i.e., stacked in the parent block).

![Orientation for layout Parent Block Settings](https://wordpress.org/documentation/files/2022/10/orientation-1.gif)### Allow to wrap to multiple lines

![Allow to wrap blocks to multiple lines. ](https://wordpress.org/documentation/files/2022/10/wrap.png)By turning on the **Allow to wrap to multiple lines** setting, the child blocks will move to the next line when there isn’t enough space on smaller screen sizes *(mobile device)*. With this setting off, all the child blocks will stay on the same line no matter the screen size.

### Customizing layout width

Some blocks such as the [Query Loop](https://wordpress.org/documentation/article/query-loop-block/) block that has nested inner blocks like [Post Template](https://wordpress.org/documentation/article/post-template-block/) block and [Group block](https://wordpress.org/documentation/article/group-block/) will have the following layout option that lets you choose the layout width for the nested blocks.

![Toggle off the option- Inner blocks use content width](https://wordpress.org/documentation/files/2022/11/layout-settings-innverblock-1-6.8-300x137.jpg)Toggle off **Inner blocks use content width** so that the nested inner blocks fill the width of the parent container.

![Toggle on the option- Inner blocks use content width](https://wordpress.org/documentation/files/2022/11/layout-settings-innverblock-2-6.8-201x300.jpg)Toggle on ****Inner blocks use content width**** so that the nested inner blocks use content width with options for full and wide widths. You can set the value for full width by typing in a value in the **Content** textbox. You can also set the value for wide width by typing in a value in the **Wide** textbox. You can also set the unit in PX, %, EM, REM, VW, or VH for the **Content** width and **Wide** width. You can also change the **Justification** for the nested elements to left, center or right aligned within the parent container.

## Blocks that include layout settings

- Buttons
- Column
- Columns
- Comments Pagination
- Gallery
- Group
- Navigation
- Post Content
- Post Template
- Query
- Query Pagination
- Social Links

## Demonstration

To see these specific container-related options in play here’s an example with the navigation block where you can quickly switch between different configurations as you find which best fits with the header of your choosing.

You can read more about the new Block Editor features and improvements [in this article.](https://make.wordpress.org/core/2022/09/26/core-editor-improvement-catalyst-for-creativity/)

## Changelog

- Created 2022-11-01
