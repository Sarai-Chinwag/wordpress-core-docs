---
type: document
title: Query Total block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/query-total-block/"
tags:
timestamp: "2026-06-16T19:28:13+00:00"
wordpress:
  id: 2128
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:13"
  date_gmt: "2026-06-16 19:28:13"
  modified: "2026-06-16 19:28:13"
  modified_gmt: "2026-06-16 19:28:13"
  slug: query-total-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/query-total-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - theme-blocks
---

[Go to the list of Blocks](https://wordpress.org/documentation/article/blocks/)

WordPress 6.8 is set to introduce a new block called Query Total, enhancing the flexibility of the Query Loop block.

This new block displays the total number of results within a query, making it easier for users to showcase the number of posts retrieved by a query loop.

The Query Total block is designed to be used inside a Query Loop block. It automatically counts the total number of posts retrieved by the query and displays the result in a user-friendly manner. For example, if a Query Loop retrieves 12 posts, the Query Total block will display:

![The Query total block on the site editor](https://wordpress.org/documentation/files/2025/04/query-total-intro-1024x681.png)The Query total block on the site editor***Note:*** You can only insert the Query Total Block inside a Query Loop block.

To add a *Query Total block*, click the **Block Inserter** icon when editing in the Query Loop.

Click on it to add the block to your page template.You can also use the keyboard shortcut `/query-total` to quickly insert the *Query Total block*:

[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

## Block toolbar

To view the block toolbar, click on the block, and the toolbar will be displayed.

![Query total block toolbar](https://wordpress.org/documentation/files/2025/04/query-total-toolbar.png)Query total block toolbarEvery block comes with unique toolbar icons and blocks specific user controls that allow you to manipulate the block right in the editor.

The *Query Total block* shows seven buttons in the block toolbar:

- Select parent block
- Transform to
- Drag icon
- Move arrows
- Change display type
- More options

### Select parent

Click on the **Select parent** button to move to the *Query Loop block*.

![Select parent for Query Total block](https://wordpress.org/documentation/files/2025/04/query-total-select-parent.png)Select parent for Query Total block### Transform to

![Transform button for the Query Total block](https://wordpress.org/documentation/files/2025/04/query-total-transform.png)Transform button for the Query Total blockClick on the **Transform** button to convert the *Query Total block* into a *Columns, Details, or Group* block:

![Transform options for Query Total block](https://wordpress.org/documentation/files/2025/04/query-total-transform-to.png)Transform options for Query Total block### Drag icon

![Drag and drop tool on the toolbar](https://wordpress.org/documentation/files/2025/04/query-total-drag.png)Drag and drop tool on the toolbarTo drag and drop the block to a new location on the page template, click and hold the rectangle of dots, then drag it to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block.

### Move arrows

![](https://wordpress.org/documentation/files/2025/04/query-total-move.png)Block moving tools on the block toolbarThe up and down arrow icons can be used to move the block up and down on the page.

[Get more information about moving a block within the editor.](https://wordpress.org/documentation/article/moving-blocks/)

### Change display type

The next button over will allow you to choose two types of displays:

The “Total results” option displays the number of results found, for example: “12 results found”:

![Display type toolbar tool](https://wordpress.org/documentation/files/2025/04/query-total-display-type.jpg)Display type toolbar toolThe “Range display” option displays the range total, for example, “Displaying 1 – 10 of 12”.

![Range display type for Query Total block](https://wordpress.org/documentation/files/2025/04/query-total-display-type-range.png)Range display type for Query Total block### More options

The [More Options menu](https://wordpress.org/documentation/article/more-options) represented by **three vertical dots on the far right of the toolbar** gives you more features such as the ability to duplicate, remove, or edit your block as HTML.

![Examples of the location of the "More Options" menu in a Query Total block. ](https://wordpress.org/documentation/files/2025/04/query-total-more-options.png)Examples of the location of the “More Options” menu in a Query Total block.[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block settings

The block settings panel contains customization options specific to the block. To get to the settings, select the block and click to open the Inspector sidebar. You should see the block settings displayed below with the title “Query total” at the top:

![Illustrates how to open settings for Query Total block](https://wordpress.org/documentation/files/2025/04/query-total-access-settings-1024x685.png)Illustrates how to open settings for Query Total block### Color

Text and background colors can be set on a per-block basis, allowing you to call attention to important content. Using the Color settings, you can customize the block by adding text, background, and link colors.

![Color settings](https://wordpress.org/documentation/files/2025/04/image8.png)Color settings[See this guide for more information about changing colors.](https://wordpress.org/documentation/article/colors-settings-overview/)

### Typography

The Typography settings enable you to customize the font and text appearance of the content within the **Query Total** block. The settings have various options, such as font family, size, appearance, line height, letter case, letter spacing, and decoration.

[Get more details about changing typography settings.](https://wordpress.org/documentation/article/typography-settings-overview/)

### Dimensions

The **Query Total** block provides various options to adjust its dimensions, such as width and height, allowing you to customize the text layout to ensure visual consistency.

![Dimension settings](https://wordpress.org/documentation/files/2025/04/image5.png)Dimension settingsFor details refer to this support article: [Dimension settings overview](https://wordpress.org/documentation/article/dimension-controls-overview/)

### Border

The **Query Total** block provides border settings options to add border color, width, and radius.

![Border settings](https://wordpress.org/documentation/files/2025/04/image13.png)Border settingsFor details refer to this support article: [Border settings overview](https://wordpress.org/documentation/article/border-settings-overview/)

### Advanced

The Advanced tab lets you add CSS class(es) to your block. This will allow you to write custom CSS and styles to the block.

![Advanced tab](https://wordpress.org/documentation/files/2025/04/image15.png)Advanced tabThe Additional CSS class(es) enables you to write custom CSS class(es) to the block, so you can style it as you see fit.

## Changelog

- Updated 2025-06-28 (props to [@benazeer](https://profiles.wordpress.org/benazeer/))
    - Added overview and video
- Created 2025-04-29 (props to [@n8finch](https://profiles.wordpress.org/n8finch/))
