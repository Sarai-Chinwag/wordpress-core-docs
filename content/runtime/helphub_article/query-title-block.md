---
type: document
title: Query Title block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/query-title-block/"
tags:
timestamp: "2026-06-16T19:28:13+00:00"
wordpress:
  id: 2127
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:13"
  date_gmt: "2026-06-16 19:28:13"
  modified: "2026-06-16 19:28:13"
  modified_gmt: "2026-06-16 19:28:13"
  slug: query-title-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/query-title-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - theme-blocks
---

The Query Title block displays a dynamic heading based on the type of content being viewed, such as a category name, search term etc.

It has two main variations:

## Archive Title

- Displays the title of the current archive page, such as a category, tag, author, or date.
- To add a Archive Title block, click the Block Inserter (+) icon, search for “Archive Title”, and select it from the list to insert it into your template.

![Archive Title](https://wordpress.org/documentation/files/2025/08/query-title-1-6.8-1024x604.png)## Search Result Title

- Displays a heading based on the user’s search query.
- To add a Search Results Title block, click the Block Inserter (+) icon, search for “Search Results Title”, and select it from the list to insert it into your template.

![Search Result Title](https://wordpress.org/documentation/files/2025/08/query-title-2-6.8-1024x607.png)Both of these are built on top of the same underlying block (core/query-title) and share the same functionality and controls — they differ only in what type of content they’re designed to display.

## Block toolbar

To view the block toolbar, click on the block, and the toolbar will be displayed.

Every block comes with unique toolbar icons and blocks specific user controls that allow you to manipulate the block right in the editor.

**The Query Title block shows seven buttons in the block toolbar ( From Left to Right ):**[](https://private-user-images.githubusercontent.com/80690679/457388405-46d04f7b-9832-4213-a87e-0b252ece1cdd.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3NTQwNjQxMzIsIm5iZiI6MTc1NDA2MzgzMiwicGF0aCI6Ii84MDY5MDY3OS80NTczODg0MDUtNDZkMDRmN2ItOTgzMi00MjEzLWE4N2UtMGIyNTJlY2UxY2RkLnBuZz9YLUFtei1BbGdvcml0aG09QVdTNC1ITUFDLVNIQTI1NiZYLUFtei1DcmVkZW50aWFsPUFLSUFWQ09EWUxTQTUzUFFLNFpBJTJGMjAyNTA4MDElMkZ1cy1lYXN0LTElMkZzMyUyRmF3czRfcmVxdWVzdCZYLUFtei1EYXRlPTIwMjUwODAxVDE1NTcxMlomWC1BbXotRXhwaXJlcz0zMDAmWC1BbXotU2lnbmF0dXJlPWI1YjdjNTA3NmQ5ZmUxNTM0YmNlN2U5OWQ4ZDU4NDdhNDgyODI3NGEwZWRiMDg5YmU5ZDQyYzAzMTg2NTdiMmQmWC1BbXotU2lnbmVkSGVhZGVycz1ob3N0In0.wQ_6TYYB9pL-TlBtbwl8MST1mlh-WFx_kZ1mSEN9QkE)

![Block toolbar](https://wordpress.org/documentation/files/2025/08/query-title-3-6.8-300x56.png)- Transform to
- Drag icon
- Move arrows
- Heading Level
- Text Alignment
- More options

### Transform To

Click on the Transform button to convert the Archive Title block into a Columns, Details, or Groupblock:

![Block toolbar - Transform To](https://wordpress.org/documentation/files/2025/08/query-title-4-6.8-300x56.png)### Drag

To drag and drop the block to a new location on the page template, click and hold the rectangle of dots, then drag it to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block.

![Block toolbar - Drag](https://wordpress.org/documentation/files/2025/08/query-title-5-6.8-300x56.png)### Move Up / Down Arrows

The up and down arrow icons can be used to move the block up and down on the page.
[Get more information about moving a block within the editor.](https://wordpress.org/documentation/article/moving-blocks/)

![Block toolbar - Move Up and Down Arrows](https://wordpress.org/documentation/files/2025/08/query-title-6-6.8-300x55.png)### Heading Level

You can choose the heading level for the Archive Title from H1–H6.

![Block toolbar - Heading Level](https://wordpress.org/documentation/files/2025/08/query-title-7-6.8-300x57.png)### Text Alignment

Click the Change alignment button in the Block toolbar to display the alignment drop-down. You can align the block text to the left, make it center-aligned or align it to the right.

![Block toolbar - Text Alignment](https://wordpress.org/documentation/files/2025/08/query-title-8-6.8-300x53.png)### Options Menu

The [More Options menu](https://wordpress.org/documentation/article/more-options) represented by three vertical dots on the far right of the toolbar gives you more features such as the ability to duplicate, remove, or edit your block as HTML.

![Block toolbar - Options Menu](https://wordpress.org/documentation/files/2025/08/query-title-9-6.8-300x56.png)## Block settings

The block settings panel contains customization options specific to the block. To get to the settings, select the block and click to open the Inspector sidebar. You should see the block settings displayed below with the title “Archive Title” at the top:

### Block Settings

![Block Settings panel](https://wordpress.org/documentation/files/2025/08/query-title-10-6.8-249x300.png)#### Show archive type in title

Toggle this option to include or exclude the archive type (e.g., “Category”, “Tag”, “Author”) in the title.

- Enabled (default): Displays titles like Category: Travel
- Disabled: Displays just Travel

### Style Settings

![Style Settings panel](https://wordpress.org/documentation/files/2025/08/query-title-11-6.8-300x1024.png)#### Color

Text and background colors can be set on a per-block basis, allowing you to call attention to important content. Using the Color settings, you can customize the block by adding text, background, and link colors.

[See this guide for more information about changing colors.](https://wordpress.org/documentation/article/colors-settings-overview/)

![Color panel](https://wordpress.org/documentation/files/2025/08/query-title-12-6.8-300x295.png)#### Typography

The Typography settings enable you to customize the font and text appearance of the content within the Archive Title block. The settings have various options, such as font family, size, appearance, line height, letter case, letter spacing, and decoration.

[Get more details about changing typography settings.](https://wordpress.org/documentation/article/typography-settings-overview/)

#### Dimensions

The Archive Title block provides various options to adjust its dimensions, such as width and height, allowing you to customize the text layout to ensure visual consistency.

#### Border

The Archive Title block provides border settings options to add border color, width, and radius.

For details refer to this support article: [Border settings overview](https://wordpress.org/documentation/article/border-settings-overview/)

#### Advanced

The Advanced tab lets you add CSS class(es) to your block. This will allow you to write custom CSS and styles to the block.

![Advanced Settings panel](https://wordpress.org/documentation/files/2025/08/query-title-13-6.8.png)## Changelog

- Created 2025-08-01
