---
type: document
title: Terms Query block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/terms-query-block/"
tags:
timestamp: "2026-06-16T19:28:12+00:00"
wordpress:
  id: 2120
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:12"
  date_gmt: "2026-06-16 19:28:12"
  modified: "2026-06-16 19:28:12"
  modified_gmt: "2026-06-16 19:28:12"
  slug: terms-query-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/terms-query-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - text-blocks
---

The Terms Query block displays a list or grid of taxonomy terms (such as Categories, Tags, or custom taxonomies). It’s most useful in templates (for example, a “Categories” index or a directory page) where you want to list terms and design how each term appears.

## Requirements

- WordPress 6.9 or later.
- A block theme for editing templates in the Site Editor.
- The taxonomy you want to display must be public and available in the editor (show\_in\_rest enabled).

## Anatomy of the Terms Query block

![](https://wordpress.org/documentation/files/2025/11/Terms-query-anatomy.png)The block inspector provides a quick overview of the *Term Query* block’s structure. Each part gives you access to different settings:

- **Terms Query:** Configure the query parameters.
- **Term Template**: Choose how the content is displayed, either in a list or grid format.
- **Term Name**: Show the term name.
- **Term Description**: Show the term description.
- **Term Count:** Show the number of results for each term.

## Add the Terms Query block to a template

1. Go to Appearance &gt; Editor.
2. Open the template where you want the terms to appear (for example, a custom “Categories” template).
3. Place your cursor in the desired location.
4. Open the block inserter (+), search for “Terms Query,” and select it.

## Block configuration

After adding the *Terms Query* block you will see two options:

![](https://wordpress.org/documentation/files/2025/11/Terms-Query-block-options-1024x393.png)These variations offer two different layout options:

- Name: just shows the name of the term.
- Name &amp; Count: shows the name and the number of items in that term.

### How to customize the appearance

There are numerous ways to customize the *Term Query block,* partially because it’s made up of nested blocks that you can rearrange, add to, and more. When you customize one block in the *Term Query block*, the changes will apply to all blocks of the same type. While customizing this block, it might help to use the List View found in the top toolbar. Here are some ideas for customization to get you started:

- You can **change the width** of various aspects of the *Term Query* block.
- You can **change the alignmen**t of blocks within the **Term Query* block.*
- You can **rearrange the blocks** to your liking, dragging and dropping or using the movers to do so.
- You can **change the number of terms** listed by selecting the *Term Query* block and adjusting the Max Terms option in the block settings
- You can **set various color options** for the nested blocks.
- You can **change how the number of terms are displayed** by selecting the *Terms Number* block and changing the format in the block toolbar.
- You can **show the term description** by selecting the *Term Description* block and adjust the styles as needed.

## Block toolbar

To view the block toolbar, click on the block, and the toolbar will be displayed. Every block has unique toolbar icons and blocks specific user controls that allow you to manipulate the block right in the editor. The **Terms Query** block has the following:

- Transform to.
- Align none, wide width, full width.
- Move/drag to reposition in the template.
- More options (duplicate, lock, remove, etc.).

### Transform to

Click on the “Transform” button to convert the *Query Loop* block into a “Group” or “Columns” block.

![](https://wordpress.org/documentation/files/2025/11/transform-to-term-query.png)### Drag icon

To drag and drop the block to a new location, click and hold the rectangle of dots, then drag it to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block.

![](https://wordpress.org/documentation/files/2025/11/drag-handles-term-query.png)### Move arrows

The up and down arrow icons can be used to move the block up and down on the page.

![](https://wordpress.org/documentation/files/2025/11/move-handles-term-query-.png)Detailed instructions on moving a block within the editor can be found [here](https://wordpress.org/support/article/moving-blocks/)

### Align

Use the change alignment tool to align the *Terms Loop* block. Choose one of the following options:

- **None –** leaves the block the current size.
- **Wide width –** increase the width of the block beyond the content size.
- **Full width –** extend the block to cover the full width of the screen.

The “Wide width” and “Full width” alignment settings must be enabled by your WordPress theme.

![](https://wordpress.org/documentation/files/2025/11/align-terms-query.png)### List view (default)

Displays your terms in a stacked list. Select the Term Template block to edit this.

![](https://wordpress.org/documentation/files/2025/11/Terms-query-list-1024x393.png)### Grid view

Displays your terms in a grid view. Select the Term Template block to edit this.

![](https://wordpress.org/documentation/files/2025/11/Terms-query-grid-1024x287.png)### Options

The Options button on a block toolbar gives you more features to customize the block.

[Read about these and other settings.](https://wordpress.org/support/article/more-options/)

## Block Settings

### Inner blocks use content width

This option allows you to configure justification, content, and wide width settings for all nested blocks within the Query*Loop* block.

### Order by

- Name: A &gt; Z
- Name: Z &gt; A
- Count: High to Low
- Count: Low to High

### Selected terms

This option lets you pick specific taxonomies to show. Simply search and select what to add.

### Show empty terms

This option lets you display terms even if they are empty. This is off by default.

### Show nested terms

This option lets you display nested terms. This is off by default.

### Max terms

This option lets you limit the number of terms you want to show. To show all terms, use 0 (zero).

### Advanced Settings

The advanced tab lets you add a CSS class to your block, allowing you to write custom CSS and style the block as you see fit. It also allows you to assign an HTML element.

## Demo

## Tips

- Use List for hierarchical taxonomies; use Grid for scanning many terms quickly.
- Keep Term Name prominent; add Term Description for context on landing pages.
- Use Hide empty to avoid blank archives and keep the list relevant.
- Save a configured Terms Query section as a Pattern to reuse across templates.

## Frequently asked questions

**Can I show only top-level terms?**

- Yes. Leave Parent unset and turn Include subterms off.

**Can I display a custom taxonomy?**

- Yes, if it’s public and registered to show in the editor (show\_in\_rest true).

**Can I link the term name to its archive?**

- Term Name typically links to the term archive by default. You can control additional links (like Term Count) in its block settings.

## Changelog

- Created 2025-12-02
