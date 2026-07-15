---
type: document
title: Custom HTML
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/custom-html/"
tags:
timestamp: "2026-06-16T19:28:55+00:00"
wordpress:
  id: 2322
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:55"
  date_gmt: "2026-06-16 19:28:55"
  modified: "2026-06-16 19:28:55"
  modified_gmt: "2026-06-16 19:28:55"
  slug: custom-html
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/custom-html/"
  comment_count: 0
  terms:
    category:
      - customization
      - widget-blocks
---

[Go back to the list of Blocks](https://wordpress.org/documentation/article/blocks/)

**Hypertext Markup Language (HTML)**, is language used to describe the semantic content of web pages. This can be added using the custom HTML block. This block allows you to insert your code so you can fine-tune your content.

Starting in WordPress 7.0, the Custom HTML block introduces separate editing panels for HTML, CSS, and JavaScript. The CSS and JavaScript panels are only available to users with the unfiltered\_html capability. If a user lacks this capability (for example, a Contributor), WordPress will sanitize the block’s content using the function [wp\_kses()](https://developer.wordpress.org/reference/functions/wp_kses/), stripping disallowed tags such as `<script>` and `<iframe>`. In this case, the CSS and JavaScript panels are not shown, and any disallowed markup is removed when the post is saved or updated.

[Learn more about WordPress user roles and capabilities](https://wordpress.org/documentation/article/roles-and-capabilities/)

## Add a Custom HTML block

In order to add a custom HTML block, click on the **Block Inserter** icon.

You can also type `/html` and hit enter in a new paragraph block to add one quickly.

![Adding a block with a slash html command](https://wordpress.org/documentation/files/2019/03/Screenshot-2026-05-20-at-10.56.23-AM.png)[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

## Editing the block

Once you add the block, click on the Edit HTML button to open the editing modal.

![Custom HTML block empty state showing an Edit HTML button](https://wordpress.org/documentation/files/2019/03/html-editing-block-1024x360.png)Enter HTML code and see the preview of your output to the right of the code editor. You can expand the modal to fullscreen the Enable/disable fullscreen button on the top right of the modal. When you are done entering code, press the Update button.

![Custom HTML block edit state showing the HTML code pane on the left and HTML output preview on the right](https://wordpress.org/documentation/files/2019/03/html-edit-modal-1024x605.png)## Block toolbar

The Custom HTML block has the following options on the block toolbar:

![Custom HTML block toolbar](https://wordpress.org/documentation/files/2019/03/html-block-toolbar.png)### Block moving tools

The block-moving tools allow you to move the block in the editor. Use the six dots icon to drag and drop the block and place it anywhere on the page. Alternatively, click on the up and down arrows to move the block up or down.

![Custom HTML block toolbar with block moving tools highlighted](https://wordpress.org/documentation/files/2019/03/html-move-tools.png)[Get more information about moving a block within the editor](https://wordpress.org/documentation/article/moving-blocks/)

### Edit Code button

Press this button to make changes to your Custom HTML block code.

### More options

These controls give you the option to copy, duplicate, or rename your block.

[](https://wordpress.org/documentation/article/adding-a-new-block/)[Read about these and other settings](https://wordpress.org/documentation/article/more-options/)

## Block settings

While most blocks have specific options in the editor sidebar in addition to the options found in the block toolbar, the HTML block does not have extra options.

## Changelog

- Updated 2026-05-20 (props to @awetz583 @atachibana @lanamiro1)
    - Updated information, video and screenshots for 7.0
- Updated 2026-05-01
    - Updated formatting and added link to roles and capabilities
- Updated 2025-07-21
    - Added detail HTML processing
- Updated 2022-11-26
    - Removed redudant content
    - Aligned images for mobile view
    - Added heading
- Updated 2022-04-20
    - Update screenshots to 5.9
    - Add More Options section
