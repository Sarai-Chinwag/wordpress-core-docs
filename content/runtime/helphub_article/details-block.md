---
type: document
title: Details block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/details-block/"
tags:
timestamp: "2026-06-16T19:28:18+00:00"
wordpress:
  id: 2152
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:18"
  date_gmt: "2026-06-16 19:28:18"
  modified: "2026-06-16 19:28:18"
  modified_gmt: "2026-06-16 19:28:18"
  slug: details-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/details-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - text-blocks
---

[Go to the list of Blocks](https://wordpress.org/documentation/article/blocks/)

The Details block displays a text summary and an arrow button: When you click on the text or the button, the block opens and reveals additional content on the page.

This block provides a way to show or hide content on your site. This can be useful on faq pages, showing /hiding detailed event information etc.

The Summary is customizable by selecting the “Write summary…” placeholder text and adding your own text. By default, the block uses the summary content as its label, similar to how the Heading block works.

The additional content blocks that you place inside the Details block that are hidden until you click on the summary text or the button. Because the content is hidden until you open the block, it is referred to as “hidden content”.

**Closed state:**

![The details block is closed and the icon in the arrow button points towards the summary text.](https://wordpress.org/documentation/files/2023/07/63-summary-closed.png)**Open state:**

![The details block is open and the arrow icon points towards the content  below the summary,](https://wordpress.org/documentation/files/2023/07/63-summary-open.png)## Add a Details block

To add a Details block, click on the **Block Inserter** (+) and select the Details block.
You can also type /details and hit enter in a new paragraph block to add one quickly.

![Using the slash inserter to type /details](https://wordpress.org/documentation/files/2023/07/63-details-slash-inserter.png)Using the slash inserter## Block toolbar

Every block comes with unique toolbar icons and block-specific user controls that allow you to manipulate the block right in the editor.

The Details block shows five buttons in the block toolbar:

- Transform to
- Drag icon
- Move arrows
- Change alignment
- More rich text controls
- More options

![block toolbar](https://wordpress.org/documentation/files/2023/08/Details-block-toolbar.png)### Transform to

![block toolbar transform menu ](https://wordpress.org/documentation/files/2023/08/Details-transform-menu.png)Click on the transform button to place the block inside a group or columns block.

### Drag

![block toolbar drag handles](https://wordpress.org/documentation/files/2023/08/Details-drag-.png)To drag and drop the block to a new location on the page template, click and hold the rectangle of dots, then drag to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block.

### Move

![block toolbar move arrows](https://wordpress.org/documentation/files/2023/08/Details-move.png)The up and down arrow icons can be used to move the block up and down on the page.

[Get more information about moving a block within the Editor.](https://wordpress.org/documentation/article/site-logo-block/)

### Change alignment

![block toolbar alignment options](https://wordpress.org/documentation/files/2023/08/Details-alignment.png)Change the alignment of the block to none, wide, or full width.

### More rich text options

The drop-down menu to the left of the [More options menu](https://wordpress.org/documentation/article/more-options/) contains a range of additional rich text editing options such as highlighting, inline code, strikethrough, and more.

[Read about more rich text editing options.](https://wordpress.org/documentation/article/more-text-editing-overview/)

### More options

The [More Options menu](https://wordpress.org/documentation/article/more-options) represented by three vertical dots on the far right of the toolbar gives you more features such as the ability to duplicate or remove your block.

[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block settings

The block settings panel contains customization options specific to the block. To open it, select the block and click the Settings button next to the Publish or Save button.

![The Details block settings sidebar.](https://wordpress.org/documentation/files/2023/08/Screenshot-2026-02-17-at-4.10.31-PM.png)### Open by default

Enabling this option keeps the block open and the hidden content will be disaplay until closed.

### Advanced

The Details block provides the following Advanced settings options: HTML anchor, Additional CSS Class(es), Name attribute, Styles, and Allowed blocks.

Use the **Name attribute** setting to group related Details blocks together. Details blocks with the same name attribute work like an accordion: opening one closes the others in that group.

For example, if **Summary 1** and **Summary 2** both use the name attribute `faq`, opening one will close the other. If **Summary 3** uses a different name attribute, it will open and close independently.

Leave this field blank if you want each Details block to open and close on its own.

[Learn more about advanced settings](https://wordpress.org/documentation/article/advanced-settings-overview/)

## Styles

![The styles tab in the Details block settings sidebar.](https://wordpress.org/documentation/files/2023/07/63-details-sidebar-styles.png)### Color

The block provides dimension settings options to add text, background, and link color.

[See this guide for more information about changing colors.](https://wordpress.org/documentation/article/colors-settings-overview/)

### Typography

The block provides typography settings to change the font family, appearance, line height, letter spacing, decoration, letter case, and font size.

[Get more details about changing typography settings.](https://wordpress.org/documentation/article/typography-settings-overview/)

### Dimensions

The block provides dimension settings options to add padding and margin.

For details refer to this support article: [Dimension settings overview](https://wordpress.org/documentation/article/dimension-controls-overview/)

### Border

The block provides border settings options to add border color, style, width, and radius.

For details refer to this support article: [Border settings overview](https://wordpress.org/documentation/article/border-settings-overview/)

## Changelog

- Updated 2026-05-25 (props @kjoyner @awetz583)
    - Updated “Advanced” section to refer to new overview page
- 2026-02-17 (props to @awetz583)
    - Added heading for add a block
    - Updated advanced screenshots and added information for Manage allowed blocks setting
    - Updated heading case and size
- 2025-12-02
    - Added rich text options for 6.9. Props @annezazu.
- 2024-07-05
    - Added name attribute in advanced settings for 6.8
- 2024-06-13 Updated video to 6.5 version
- 2023-12-05 Headings case resolved
- Created 2023-08-08
