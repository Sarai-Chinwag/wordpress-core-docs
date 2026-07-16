---
type: document
title: Query Loop block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/query-loop-block/"
tags:
timestamp: "2026-06-16T19:28:36+00:00"
wordpress:
  id: 2232
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:36"
  date_gmt: "2026-06-16 19:28:36"
  modified: "2026-06-16 19:28:36"
  modified_gmt: "2026-06-16 19:28:36"
  slug: query-loop-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/query-loop-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - theme-blocks
---

[Go back to the list of **Blocks**](https://wordpress.org/documentation/article/blocks/)

The Query Loop block is an advanced block that allows you to display posts based on specified parameters, like a PHP loop without the code. You can think of it as a more complex and powerful [Latest Posts Block](https://wordpress.org/documentation/article/latest-posts-block/). With various block patterns integrated into the block setup, you can do things like create a portfolio or a page full of your favorite recipes.

![Query Loop block inserted into a page, displaying a grid of recent blog posts with featured images.](https://wordpress.org/documentation/files/2021/07/query-loop-grid-featured-image.png)## Add a Query Loop block

To add the Query Loop block to the page, click (+) icon to open the block inserter pop-up window. Look for the Query Loop using the search bar and click the block icon to add it to the editor.

Alternatively, you can quickly add the Query Loop block by typing `/query loop` and pressing Enter.

![Add a Query Loop block by typing /query in the editor](https://wordpress.org/documentation/files/2021/07/query-loop-add-block.png)After adding the Query Loop block you will see two options:

- **Choose**
- **Start blank**

![Choose a pattern or start blank when adding the query loop](https://wordpress.org/documentation/files/2021/07/query-loop-add-block-options.png)### Choose a pattern

The Choose option allows you to select from patterns in your theme that use the Query Loop. Each Query Loop block is made up of various nested post blocks, like the [Featured Image](https://wordpress.org/documentation/article/post-featured-image-block/), [Excerpt](https://wordpress.org/documentation/article/post-excerpt-block/), and [Pagination](https://wordpress.org/documentation/article/pagination-block/) blocks. So depending on which pattern you choose, the blocks your Query Loop starts with may vary.

![Pattern modal open with different query loop layouts](https://wordpress.org/documentation/files/2026/05/query-loop-choose-pattern.jpg)Example of pattern options for the Query Loop in the WordPress Twenty Twenty-Five theme### Start blank

If you select the Start blank option, you can select different variations of the Query Loop to start with. Each variation starts with a different combination of nested post blocks. You can remove these nested blocks or add additional ones after adding the block to the page.

![Default layout options for the query loop ](https://wordpress.org/documentation/files/2026/05/query-loop-start-blank-post-options.png)[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

## Anatomy of the Query Loop block

![List View of query loop showing nested post blocks](https://wordpress.org/documentation/files/2021/07/query-loop-list-view.png)Example in List View of a Query Loop blockOnce added to the page, open [List View](https://wordpress.org/documentation/article/list-view/) to see how the Query Loop is structured. The Query Loop is made up of several nested parts, and each one controls a different part of the display.

### Query Loop

Use the Query Loop block settings to control which posts appear. This includes options such as post type, filters, order, and the number of items shown.

### Post Template

Post Template is a container block inside the Query Loop that controls the layout that repeats for each post in the Query Loop. For example, you can display posts in a list or grid.

The Post Template accepts inner blocks. You can add post blocks, such as the post Title, Featured Image, Excerpt, Date, and other blocks like Group, Columns, or Row to create more custom layouts. Common blocks you may use inside the Post Template include:

- [Title](https://wordpress.org/documentation/article/title-block/)
- [Excerpt](https://wordpress.org/documentation/article/post-excerpt-block/)
- [Date](https://wordpress.org/documentation/article/post-date-block/)
- [Featured Image](https://wordpress.org/documentation/article/post-featured-image-block/)
- [Read More](https://wordpress.org/documentation/article/read-more-block/)
- [Author](https://wordpress.org/documentation/article/post-author-block/)
- [Categories](https://wordpress.org/documentation/article/categories-block/)
- [Tags](https://wordpress.org/documentation/article/post-tags-block/)

[Learn more about the Post Template block](https://wordpress.org/documentation/article/post-template-block/).

### Pagination (optional)

The Pagination block lets visitors move through multiple pages of results. You can choose which navigation elements to include, such as previous and next links or page numbers. Remove this block if it’s not needed — you can add it back at any time if desired.

[Learn more about the Pagination block](https://wordpress.org/documentation/article/pagination-block/).

### No Results (optional)

Use No Results to add a message that appears when the query does not find any posts. This message only displays on the published page when there are no matching results. You can delete the No Results section, but it’s recommended so that this area does not appear blank for visitors if no posts are able to display.

## How to customize the appearance

The Query Loop block is made up of nested blocks. To customize how posts appear, select the part of the Query Loop you want to change, such as the Query Loop, Post Template, Title, Featured Image, or Pagination block.

Use [List View](https://wordpress.org/documentation/article/list-view/) to see the nested block structure and select the correct block. Changes made inside the Post Template repeat for each post in the Query Loop. For example, if you move the Featured Image above the Post Title, that change applies to every post in the list.

### Common customizations

Common ways to customize the Query Loop include:

- Change how many posts appear, or filter them by category or tag, in the Query Loop block’s settings.
- Change width, alignment, spacing, or color settings for supported blocks.
- Switch between list and grid layouts by selecting the Post Template block.
- Add or remove additional blocks inside the Post Template, such as Featured Image, Excerpt, Author, or Date.
- Add layout blocks, such as Group, Columns, or Row, to create a more custom repeated post layout.
- Rearrange blocks inside the Post Template using drag and drop or List View.
- Customize the No Results block message that displays when no posts are found.

**Note:** If you do not see options for choosing a post type, filter settings, or other query settings, select the Query Loop block and change [Query Type](#query-type) from Default to Custom in the block settings sidebar.

### Link titles and images to posts

Post titles and featured images inside the Query Loop do not automatically link to the post or page in every layout. To make them clickable, select each nested block and enable its link setting.

- Select the [Title block](https://wordpress.org/documentation/article/title-block) and turn on **Make title a link**.
- Select the [Featured Image](https://wordpress.org/documentation/article/post-featured-image-block) block and turn on **Link to Post.**

These settings apply to each item shown by the Query Loop because they are inside the Post Template.

### Styles

The Query Loop block itself does not include style settings like color and spacing. Select a nested block inside the Query Loop, such as the Post Template, Title, or Excerpt, and use that block’s settings to change styles.

### List or Grid view

To switch between list and grid layouts, select the [Post Template block](https://wordpress.org/documentation/article/post-template-block/). In the block’s toolbar, you can select **List View** or **Grid View** to stack your posts in a list or display them in multiple columns within a grid.

Switch between List and Grid layout in the Post Template block toolbar.## Block toolbar

![query loop block toolbar settings](https://wordpress.org/documentation/files/2026/05/query-loop-block-toolbar.png)Each block has a block toolbar, which lets you customize or modify the block’s options in the editor. To view the block toolbar, select the Query Loop block. The toolbar gives you quick access to common block actions, such as moving the block, changing its alignment, replacing the design, or opening more options.

The Query Loop block toolbar includes:

- Transform to
- Move controls
- Change alignment
- Change design
- More options

### Transform to

![Dropdown of transform options for the query loop in the block toolbar](https://wordpress.org/documentation/files/2026/05/query-loop-transform.png)The Transform to tool allows you to convert the Query Loop block into the Group, Columns, or Details blocks.

### Move controls

![query loop move controls in the block toolbar](https://wordpress.org/documentation/files/2026/05/query-loop-move-controls.png)Click the the drag/drop button (six dots) to move the block to a new location on the page. A blue separator line appears to indicate where the block will be placed.

The up and down arrow icons can be used to move the block up and down on the page.

[Get more information about moving a block within the editor.](https://wordpress.org/documentation/article/moving-blocks/)

### Change alignment

![Dropdown of alignment controls in the query loop block toolbar](https://wordpress.org/documentation/files/2026/05/query-loop-align-options.png)Use the change alignment tool to align the Query Loop block. Choose one of the following options:

- **None –** leaves the block the current size.
- **Wide width –** increase the width of the block beyond the content size.
- **Full width –** extend the block to cover the full width of the screen.

The Wide width and Full width alignment settings must be enabled by your WordPress theme.

### Change design

Use Change design to choose a different Query Loop design or pattern. This replaces the current Query Loop layout with the selected design.

![Dropdown of layout options under the change design tool in the query loop block toolbar](https://wordpress.org/documentation/files/2026/05/query-loop-change-design-1024x721.png)Example of patterns to select in the WordPress Twenty Twenty-Five theme when selecting Change design in the Query Loop block toolbar.### More options

Use More options to access additional block actions, such as duplicate, copy, group, lock, or delete. Available options may vary depending on your theme and permissions.

[Read about these and other settings](https://wordpress.org/documentation/article/more-options/).

## Block settings

![Settings button highlighted in the block editor next to the Save button.](https://wordpress.org/documentation/files/2019/03/block-settings-7-0.png)Use the Settings section to customize and control which content appears in the Query Loop. To open it, select the block and click the settings icon next to the **Publish/Update** button.

![Query Loop settings panel with layout options, query type choices, and a template query warning.](https://wordpress.org/documentation/files/2021/07/query-loop-block-settings-default-selected-471x1024.png)Query Loop block settings### Layout

![Query Loop layout settings showing content and wide width fields with center justification selected.](https://wordpress.org/documentation/files/2026/05/query-loop-layout-settings-edited.png)“Inner blocks use content width” setting enabled in block settingsUse the Layout settings to control how nested blocks inside the Query Loop use the available width and additional alignment options for content. The Query Loop block includes the **Inner blocks use content width** setting. When this setting is turned off, nested blocks fill the width of the Query Loop container.

Visit the [Layout Settings Overview](https://wordpress.org/documentation/article/layout-settings-overview/) guide for more information about these settings.

### Settings

#### Query type

The Query type is set to **Default** automatically which means WordPress will otherwise rely on the template being used to determine what posts appear.

To view a list of posts on a page, change this query type to **Custom**. When you choose Custom, the following options appear:

- Post type
- Order by
- Sticky posts
- Display options
- Filters

![Custom query type selected in the Query Loop block settings](https://wordpress.org/documentation/files/2026/05/query-loop-custom-query-type-selected-outlined-513x1024.png)Custom selected as the Query type#### Post type

WordPress contains different types of content, and they are divided into collections called **Post types**. By default, there are a few different ones, such as blog posts and pages, but plugins could add more. Other content types may be displayed here if your site includes plugins or custom post types.

#### Order by

- Newest to Oldest (default)
- Oldest to Newest
- Alphabetical A to Z
- Alphabetical Z to A

#### Sticky posts

This option allows you to choose between three options:

- **Include (default)** – Displays sticky posts.
- **Exclude** – Removes sticky posts.
- **Ignore** – Ignore sticky posts.
- **Only** – Shows only sticky posts.

#### Display options

![Overlay of display options in the query loop block settings](https://wordpress.org/documentation/files/2026/05/query-loop-display-options-1024x439.png)Display options menu (three dots) selected to see all optionsDisplay options allow you to customize how many posts you want to show in various ways. Some display controls may be hidden by default. To show them, open the Display options menu (three dots) next to the Display label. Select from the following options:

- **Items per Page** – Choose how many posts you want to show within the Query Loop block.
- **Offset** – Enable the Query Loop block to skip a certain number of WordPress posts before starting output.
- **Max page to show** – Limits how many pieces of content to show.

If you don’t see this section, you must change the [Query type](#query-type) to **Custom**.

#### Filters

Use Filters to control which posts appear in the Query Loop.

If you do not see this section, change Query type from Default to Custom.

**Filter settings are hidden** until you add them. Select the Filter options button (+), then choose the filter you want to use. The filters available **may change** depending on the selected post type, theme, and plugins used on your site.

![Overlay of filter options for the query loop](https://wordpress.org/documentation/files/2026/05/query-loop-select-filters-button-1024x501.png)Filter options you can enable.- **Taxonomies** – Show or hide posts based on [categories](https://wordpress.org/documentation/article/posts-categories-screen/) and [tags](https://wordpress.org/documentation/article/posts-tags-screen/).
    - You can also exclude posts by categories and tags.
- **Authors:** Show posts by one or more selected authors.
- **Keyword** – Show posts that match one or more keywords.
    - If you enter more than one keyword, results must match every keyword.
    - You cannot use this filter to show results that match only one of several keywords.
- **Format** – Show posts assigned to a specific [Post Format](https://developer.wordpress.org/advanced-administration/wordpress/post-formats/), such as Aside, Gallery, Image, Link, Quote, Status, Video, Audio, or Chat.
    - Post Formats are different from visual formatting, and your theme may not support them.

![Taxonomy filter options in the Query Loop block settings](https://wordpress.org/documentation/files/2026/05/query-loop-filter-options-435x1024.png)All filter options enabled for posts in the Query LoopDepending on your site, you may also see filters for custom taxonomies added by a theme or plugin, such as [WooCommerce](https://wordpress.org/plugins/woocommerce/) product categories. These filters work like categories or tags and let you show content assigned to specific taxonomy terms.

If Post type is set to Page, you may see different filter options, such as:

- **Authors** – Show pages by one or more selected authors.
- **Keyword** – Show pages that match one or more keywords.
- **Parents** – Show pages nested under one or more selected parent pages.

![query loop page filter options in block settings](https://wordpress.org/documentation/files/2026/05/query-loop-page-filter-options.png)All filter options enabled for pages in the Query Loop### Advanced

The Query Loop provides the following Advanced Settings options: HTML Anchor, Additional CSS Class(es), HTML Element, and Reload Full Page.

The **Reload Full Page** setting is enabled by default. This setting reloads the entire page when visitors move between pages of Query Loop results. This setting is enabled by default and is generally the safest option for predictable navigation and accessibility. When turned off, only the posts inside the Query Loop update instead of reloading the full page.

[Learn more about advanced settings](https://wordpress.org/documentation/article/advanced-settings-overview/)

## Demo

This video shows how to add a Columns block inside the Post Template to create a repeated layout with the featured post image on the left and post title, date, and excerpt on the right.

## Changelog

- Updated 2026-06-07-2026 (props to @kjoyner @jessedyck)
    - Fixed typos and clarified some sentences.
    - Removed Ascending and Descending from Order by
- Updated 2026-06-03-2026 (props @kjoyner)
    - Updated alt text and added video description
- Updated 2026-05-30 (props @kjoyner @shazzad @awetz583)
    - Added screenshot of default Query Loop block settings
    - Clarified the Query Type “Custom” setting
- Updated 2026-05-24 (props to @kjoyner @awetz583 @shazzad @ntsekouras @mcsf @jasmussen @cagrimmett @`bradhogan` @liviopv @tehjaymo @cuemarie)
    - Removed italicized content
    - Updated screenshots and video to reflect WordPress 7.0
    - Updated “Anatomy of a Query Loop” section to be separated by it’s default options
    - Updated any screenshots with example layouts that contained low contrast between text and background
    - Added list of common blocks users may use inside the Query Loop
    - Added information about excluding categories and tags
    - Added “Demo” section
    - Added “Where to find other Query Loop settings” section
    - Updated “Advanced Settings” section to refer to new parent page
- Updated 2025-07-05
    - Updated Order by to include new Ascending and Descending order
        Updated Sticky posts to include new Ignore option
- Updated 2023-03-26
    - Revised formatting for the whole article
    - Added videos/screenshots where applicable
    - Updated Block Settings Color section
    - Updated Filters section flow along with new parent filter, multiple author, and custom taxonomies filtering
    - Updated block creation and replacement flows
    - Added a mention and a screenshot on customizing what is shown when the Query Loop block shows no results
    - Added a link to Pagination block
    - Updated all the screenshots for 6.2
- Added in resources section on 2021-07-14
- **Created** 2021-07-08
