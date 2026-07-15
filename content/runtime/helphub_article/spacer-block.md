---
type: document
title: Spacer block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/spacer-block/"
tags:
timestamp: "2026-06-16T19:28:54+00:00"
wordpress:
  id: 2313
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:54"
  date_gmt: "2026-06-16 19:28:54"
  modified: "2026-06-16 19:28:54"
  modified_gmt: "2026-06-16 19:28:54"
  slug: spacer-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/spacer-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - design-blocks
---

If you want to have a space between two blocks, the Spacer block is what you will use.
A **vertical** spacer adds space between blocks in a column (as in a page or post).
A **horizontal** spacer adds space between blocks in a row (as in a [Navigation block](https://wordpress.org/support/article/navigation-block/)).

(Note: Using a Navigation block requires a [block theme](https://wordpress.org/themes/tags/full-site-editing/) or a theme that has support for [template editing](https://wordpress.org/themes/tags/template-editing/).)

In this video, you can see how you can use the spacer block and the different settings to modify it.

Demo of inserting Spacer block into post content and modifying its settings.## Add a Spacer block

To add an Spacer block, click on the **Add Block** icon.

You can also type `/spacer` and hit enter in a new *paragraph block* to add one quickly.

![How to add a space block to a page or post](https://user-images.githubusercontent.com/28687464/189541348-49772276-96e3-4eac-9fde-4b08df482b83.jpeg)Add Spacer Block## Block toolbar

In order to reveal the block toolbar, you can click on the block and the toolbar will display.

Every block comes with unique toolbar icons and blocks specific user controls that allow you to manipulate the block right in the editor.

The Spacer block shows four buttons in the block toolbar:

- Transform to
- Move controls
- More options

![The spacer block toolbar ](https://wordpress.org/documentation/files/2019/03/spacer-block-toolbar-all.png)Spacer Block Toolbar### Transform to:

![Transform options for Spacer Block](https://wordpress.org/documentation/files/2019/03/spacer-transforms.png)Transform options for Spacer BlockWhen you click on the **“Transform”** button, you can convert the **Spacer** block into **Columns**, **Separator**, **Details**, or **Group** blocks.

- **Separator**: Changes the Spacer into a visual horizontal line that helps divide content, providing a cleaner visual break between sections.
- **Group**: Allows you to wrap the Spacer inside a Group, enabling background color, padding, margin, and border customization for better layout styling.
- **Columns**: Useful if you want to place multiple blocks side-by-side; this transformation helps shift the layout into a multi-column structure.
- **Details**: Converts the Spacer into a collapsible content block, allowing additional context or content to be toggled by the user.

### Move controls

![Drag icon in the Spacer block](https://wordpress.org/documentation/files/2019/03/spacer-block-toolbar-drag-1.png)Drag icon in the Spacer blockTo drag and drop the block to a new location on the page template, click and hold the six dotted icon, then drag to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block.

![Move arrows in the Spacer block](https://wordpress.org/documentation/files/2019/03/spacer-block-toolbar-moving-1.png)Move arrows in the Spacer blockThe up and down arrow icons can be used to move a block up and down in your document.

[Get more information about moving a block within the editor.](https://wordpress.org/documentation/article/moving-blocks/)

### More options

These controls give you the option to copy, duplicate, and edit your block as HTML.

[](https://wordpress.org/documentation/article/moving-blocks/)[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block settings

![Block settings button location](https://wordpress.org/documentation/files/2019/03/block-settings-Screenshot-2026-03-08-at-8.13.56-AM-1-1-2.png)Every block has specific options in the editor sidebar in addition to the options found in the block toolbar. If you do not see the sidebar, click on the **Settings button** next to the Save/Publish button.

### Spacer settings

The Height setting adjusts the height of the space. The Width setting adjusts the width of the space. You can adjust the settings by either:

- Typing the number in the “Spacer Settings” box, or
- Dragging the handle at the bottom of the spacer (for the vertical spacer) or at the side of the spacer (for the horizontal spacer).

You can also change the unit by clicking on PX to display a dropdown with the other supported units- PX, %, EM, REM, VW, and VH.

![Spacer block settings, showing the supported units](https://wordpress.org/documentation/files/2024/01/image-9.png)The interactive resizable box and the sidebar preset controls used to tweaks the Spacer block.When Spacer is a child of a flex layout block (Row, Stack, Navigation) custom size controls are removed and flex child controls added instead.

![Fixed size control for Spacer block when it's a child of a flex layout block.](https://wordpress.org/documentation/files/2019/03/spacer-flexbox-1-1024x567.png)Fixed size flex control for Spacer block![Fill size control for Spacer block when it's a child of a flex layout block.](https://wordpress.org/documentation/files/2019/03/spacer-flexbox-2-1024x503.png)Fill size flex control for Spacer block### Dimensions

The paragraph provides dimension settings options to add margin. For details refer to this support article:

[Learn more about dimension controls](https://wordpress.org/documentation/article/dimension-controls-overview/)

### Advanced

The Separator block provides the following Advanced settings options: HTML Anchor, Additional CSS Class(es), and Styles.

[Learn more about advanced settings](https://wordpress.org/documentation/article/advanced-settings-overview/)

## Changelog

- Updated 2026-05-25 (props @kjoyner @awetz583)
    - Updated “Advanced” section to refer to new overview page
- 2026-04-20 (props to @awetz583 @hu55nain)
    - Remove reference to padding
    - Text formatting updates
- 2025-04-17 (props to [@karthickmurugan](https://profiles.wordpress.org/karthickmurugan/))
    - Update screenshots and videos to 6.8
    - Update Transform to section with new options.
- Updated 2024-01-30
    - Updated screenshots for 6.4
- Updated 2023-10-24
    - Update screenshots for 6.3
    - Add custom units for height and width
    - The resizable box and controls
    - Add dimnesions support for margin
    - Add spacing presets
    - Add flex child controls for Spacer
- Updated 2022-11-25
    - Removed redundant content
    - Added alt text
    - Aligned images for mobile view
- Update 2022-03-21
    - Updated all screenshots to WordPress 5.9
- Update 2021-06-22
    - Updated more options block
- Updated 2020-09-28
    - Updated 5.5 screenshots
    - Updated the block toolbar
    - Updated the block settings
- Created 2019-03-07
