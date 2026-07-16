---
type: document
title: Content block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/post-content-block/"
tags:
timestamp: "2026-06-16T19:28:27+00:00"
wordpress:
  id: 2205
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:27"
  date_gmt: "2026-06-16 19:28:27"
  modified: "2026-06-16 19:28:27"
  modified_gmt: "2026-06-16 19:28:27"
  slug: post-content-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/post-content-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - theme-blocks
---

[Go to the List of Blocks](https://wordpress.org/documentation/article/blocks/)

Use the *Content* block to display the contents of a post or page. This block is a child block of the [*Query Loop*](https://wordpress.org/documentation/article/query-loop-block/) block and helps to customize the appearance of the query loop. **The option to add this block is only available in [Site editor](https://wordpress.org/documentation/article/site-editor/).**

To add a *Content* block, first ensure that you are editing the page or post template.

![A screenshot of the document overview sidebar in the WordPress edit Template screen. The list view tab is active and a content block is highlighted. ](https://wordpress.org/documentation/files/2022/03/content-list-view.jpg)The list view tab of the document overviewAfter block you want to precede Content block, hover to activate the **inline block Inserter** and click to add the *Content* block in the desired location. You may need to type *Content* in the block search dialog to find it.

![A screenshot of the inline block inserter. The search bar of the block inserter contains the text "content". The Content block is available as an option to insert into the page.](https://wordpress.org/documentation/files/2022/03/content-inserter.jpg)Adding Content block via the inline block inserterYou can also type /content and hit enter in a new paragraph block to add the *Content* block quickly.

![How to add Content block quickly](https://wordpress.org/documentation/files/2022/03/content-slash-inserter.jpg)Adding Content via “/” quick-addThe inner blocks contain an empty paragraph as a template when the Content block doesn’t already have content in it.

![A screenshot of the empty paragraph in inner block when the block doesn't have any other content in it.](https://wordpress.org/documentation/files/2024/03/268028952-efb999ca-1819-4e93-b942-b60993608e31-1024x223.png)[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

## Block toolbar

To view the block toolbar, click on the block and the toolbar will be displayed.

Every block comes with unique toolbar icons. These block-specific controls allow you to manipulate the block right in the editor.

The *Content* block shows four buttons in the block toolbar:

- Transform to
- Drag icon
- Move arrows
- More options

![Content block toolbar](https://wordpress.org/documentation/files/2022/03/Screen-Shot-2022-03-23-at-3.08.55-PM.png)Content block toolbar**Transform to**

Click on the **Transform** button to convert into Columns, Details, Group, or Excerpt blocks.

- **Excerpt**: Display only a trimmed version of the post content, commonly used in blog listings or archive templates.
- **Columns**: Organize your content into multiple columns for a more structured layout.
- **Details**: Collapse content inside a toggle panel to display it on demand.
- **Group**: Wrap the block in a container, allowing you to apply background, spacing, and layout styles.

![The transform dropdown on the Content block](https://wordpress.org/documentation/files/2022/03/content-transforms.png)Content block transform options**Drag icon**

![Drag icon in the Content block](https://wordpress.org/documentation/files/2022/03/02-post-content.png)Content block drag iconTo drag and drop the block to a new location on the page template, click and hold the **drag** icon, then drag the block to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block.

**Move arrows**

![Move arrows in the Content block](https://wordpress.org/documentation/files/2022/03/01-post-content-1.png)Move arrows in the Content blockThe **up and down** arrow icons can be used to move the block up and down on the page.

[Get more information about moving a block within the editor.](https://wordpress.org/documentation/article/moving-blocks/)

### Options

The **Options** button on a block toolbar gives you more features to customize the block. These controls allow you to duplicate, and edit your block as HTML.

[](https://wordpress.org/documentation/article/more-options/)[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block settings

In addition to the block toolbar, every block has specific options in the editor sidebar.

*If you do not see the sidebar, click the **settings** icon next to the **Save** button.*

![The block settings icon](https://wordpress.org/documentation/files/2023/04/settings-1.png)Also, the Block Settings panel is divided into **Settings** and **Styles** tabs.

### Layout

The Layout menu under the Settings tab lets you add custom content width to the *Content* block.

When you toggle this option off, the *Content* block inherits the layout width options set by the theme.

![Content width options](https://wordpress.org/documentation/files/2023/04/content-width-1024x213.png)Content width inherited from the layoutOtherwise, you can customize the content width and justification when it’s toggled on.

![Setting content width for Content block](https://wordpress.org/documentation/files/2023/04/settings-content-width-1024x220.png)Setting the custom Content width![Setting Justification for Content block](https://wordpress.org/documentation/files/2023/04/justification-1-1024x422.png)Setting constrained layout justification### Advanced settings 

The Advanced section lets you add CSS class(es) to your block. This will allow you to write custom CSS and styles to the block.

![Advanced setting in Content block](https://lh4.googleusercontent.com/ql3NySmHv-UbS9HqLQkycDVcqQgSyKGuS28dVa4ojJeiib3CGQm_XLFCXFS6ma9DEQeizapklRsYYvPbWVAFmaMAlNaYak-IeckP2MrqkRFQQ8ToUjXSR4tshb47jFQPgSLIMy_T)Advanced setting in Content block## Styles

### Heading Color 

The Content block now supports **heading color customization**. You can define a default color for headings (e.g., H1–H6) directly within the block settings or through Global Styles. This makes it easier to ensure consistent typography and design across your templates. When applied, block-level heading color styles will take precedence over global settings.

![Heading color settings](https://wordpress.org/documentation/files/2022/03/content-heading-1024x972.png)Heading color settings### Typography

The under the **Style** tab, you to change the block content’s font size.

![Typography support for Content block](https://wordpress.org/documentation/files/2023/04/typography-supports-1-1024x239.png)Changing font size in the Content block[Get more details about changing typography settings.](https://wordpress.org/documentation/article/typography-settings-overview/)

### Dimensions

The *paragraph* block provides various options to adjust its dimensions, such as width and height, allowing you to customize the text layout to ensure visual consistency.

For details refer to this support article: [Dimension settings overview](https://wordpress.org/documentation/article/dimension-controls-overview/)

### Border

The *paragraph* block provides border settings options to add border color, width, and radius.

For details refer to this support article: [Border settings overview](https://wordpress.org/documentation/article/border-settings-overview/)

## Changelog

- Update 2025-04-22 (props to [@karthickmurugan](https://profiles.wordpress.org/karthickmurugan/) and [@milana\_cap](https://profiles.wordpress.org/milana_cap/))
    - Add Border and Spacing support
    - Add Heading color support
    - Update screenshots to 6.8 version
    - Update title to Content block
    - Update all instances for block name
    - Update availability of the block (only in Site editor) and content that explains it.
- Updated 2023-08-24
    - Updated screenshots for 6.3
    - Instructions now account for adding the block as a child block of a Query Loop
- Updated 2023-04-25
    - Updated screenshots for 6.2
    - Added typography support
- Created 2022-03-25
