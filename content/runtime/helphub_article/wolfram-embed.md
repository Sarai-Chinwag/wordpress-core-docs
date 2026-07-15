---
type: document
title: Wolfram embed
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/wolfram-embed/"
tags:
timestamp: "2026-06-16T19:28:27+00:00"
wordpress:
  id: 2203
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:27"
  date_gmt: "2026-06-16 19:28:27"
  modified: "2026-06-16 19:28:27"
  modified_gmt: "2026-06-16 19:28:27"
  slug: wolfram-embed
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/wolfram-embed/"
  comment_count: 0
  terms:
    category:
      - customization
      - embed-blocks
---

[Go back to the list of **Blocks**](https://wordpress.org/documentation/article/blocks/)

With the Wolfram embed block, you can embed [Wolfram Notebook](https://www.wolfram.com/featureset/notebooks/) content into your posts and pages (deployed through the Wolfram Cloud). All of the Wolfram services are tied together by the Wolfram Language: Wolfram Cloud Notebooks are the cloud-hosted version of Wolfram Language Notebooks.

****Example of a Wolfram embed:****

![Screenshot of  Wolfram](https://wordpress.org/documentation/files/2022/04/00-example-wolfram-embed-1.webp)****Steps to embed Wolfram Notebook content****

1. First, find the Wolfram Notebook content that you want to embed. If already embedded in a page, open the Notebook in the Wolfram Cloud to locate and copy its wolframcloud.com URL.

![](https://wordpress.org/documentation/files/2022/04/01-open-in-wolfram-cloud-link.webp)![Screenshot of Wolfram and the correct URL to copy to use the embed block.](https://wordpress.org/documentation/files/2022/04/02-copy-url-browser-bar-wolfram-embed.webp)1. Go to your post or page and add the Wolfram embed block. One way to do this is to press the “/” key to open the block inserter and type /wolfram.

![Embed option for the Wolfram block to paste the URL.](https://wordpress.org/documentation/files/2022/04/03-add-wolfram-embed-block.webp)[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

1. Paste the link into the text box and click the “Embed” button.

![Embed option for the Wolfram block to paste the URL.](https://wordpress.org/documentation/files/2022/04/04-paste-wolfram-cloud-url.webp)If the link can be successfully embedded into your post/page, you will see the preview in your block editor.

![Preview of the embedded Wolfram video within the WordPress editor.](https://wordpress.org/documentation/files/2022/04/05-preview-editor-wolfram-embed.webp)If you use a URL that can’t be embedded, the block displays the message: *“Sorry, this content could not be embedded.”* You will have two choices: try again with a different URL or convert it to a link.

![Example of a URL that cannot be embedded. Two options are presented, try again or convert to link.](https://wordpress.org/documentation/files/2022/04/06-incorrect-url-wolfram-embed.webp)1. Click the “Preview” button in the top right corner of the post/page to see how it will look on the front end.

![Preview of the embedded Wolfram
 within the WordPress editor.](https://wordpress.org/documentation/files/2022/04/07-preview-frontend-wolfram-embed.webp)## Block Toolbar

Besides the “Mover” and “Drag &amp; Drop Handle”, the Block Toolbar for the Wolfram embed block shows four buttons:

- Transform to – also the icon for the block
- Change alignment
- Edit URL, and
- More options

![Block Toolbar with options available for the Wolfram embed](https://wordpress.org/documentation/files/2022/04/08-block-toolbar-wolfram-embed.webp)**Transform to**

The first option will allow you to transform a Wolfram embed into a Paragraph. This will convert the Notebook content embedded to a link. Additionally, you can transform a Wolfram embed into Columns or into a Group.

![Options to transform the Wolfram block to Paragraph, Columns or Group.](https://wordpress.org/documentation/files/2022/04/09-transform-to-option-wolfram-embed.webp)Transforming it into a Group will give you the ability to change the following, among other options:

- The background color around the Wolfram embed
- The padding, margin, and spacing dimensions of the block
- The block border settings (width, style, color, and radius)

**Note**: you can preview what each block (paragraph, column, or group) will look like by hovering the mouse over each option.

[![](https://i2.wp.com/wordpress.org/documentation/files/2022/04/10-editor-view-with-block-settings-panel-wolfram-embed-1024x686.webp?ssl=1)](https://wordpress.org/documentation/files/2022/04/10-editor-view-with-block-settings-panel-wolfram-embed-1024x686.webp)

[![](https://i1.wp.com/wordpress.org/documentation/files/2022/04/11-frontend-view-block-with-background-wolfram-embed.webp?ssl=1)](https://wordpress.org/documentation/files/2022/04/11-frontend-view-block-with-background-wolfram-embed.webp)

**Left image: Editor view of a Wolfram embed block as a group with color, dimension, and border settings. Right image: Front-end view of a Wolfram embed block with a border and a light grey background.**

**Change Alignment**

- **None** – Default alignment option
- **Wide width** – Increase the width of the post beyond the content size
- **Full width** – Extend the block to cover the full width of the screen
- **Align left** – Make the block left-aligned
- **Align center** – Make the block alignment centered
- **Align right** – Make the block right-aligned

![Alignment options for the Wolfram block: wide width, full width, align left, align center, and align right.](https://wordpress.org/documentation/files/2022/04/12-change-alignment-wolfram-embed.webp)**Edit URL**

Via the edit URL, you can change the Wolfram embed URL in the embed block. Overwrite the existing URL and click on the “Embed” button on the right.

![Editing the block URL via the "edit" option.](https://wordpress.org/documentation/files/2022/04/13-edit-url-wolfram-embed.webp)**More Options**

These controls give you the option to copy, duplicate, and edit your block as HTML.

[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block Settings

There are two additional options in the block settings sidebar: Media Settings and Advanced.

**Media Settings**

Via the Media Settings, you can control the behavior of the Wolfram embed block when viewed on the screen of a smaller device.

![Media settings for the embed block with the toggle OFF for resizing on smaller devices.](https://wordpress.org/documentation/files/2022/04/16-media-settings-on-wolfram-embed.webp)

![Media settings for the embed block with the toggle ON for resizing on smaller devices.](https://wordpress.org/documentation/files/2022/04/17-media-settings-off-wolfram-embed.webp)

The toggle switch turns on or off the resize functionality for smaller devices. The default setting is “on” or blue.

- “On”: This embed will preserve its aspect ratio when the browser is resized. The toggle switch turns blue in the “On” position.
- “Off”: This embed may not preserve its aspect ratio when the browser is resized.

**Advanced**

In the Advanced tab, you can add additional CSS class(es) to your block. This allows you to write custom CSS and style the block as you see fit.

![Additional CSS Class(es) option for the Wolfram Embed block.](https://wordpress.org/documentation/files/2022/04/18-advanced-tab-wolfram-embed.webp)## Changelog

- Updated 2022-11-25
    - Removed redundant content
    - Aligned images for mobile view
    - Added alt text to images
- Updated 2022-05-14
    - Added link to Wolfram Notebooks for more information
- Created 2022-04-29
