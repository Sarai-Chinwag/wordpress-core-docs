---
type: document
title: Footnotes block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/footnotes-block/"
tags:
timestamp: "2026-06-16T19:28:18+00:00"
wordpress:
  id: 2155
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:18"
  date_gmt: "2026-06-16 19:28:18"
  modified: "2026-06-16 19:28:18"
  modified_gmt: "2026-06-16 19:28:18"
  slug: footnotes-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/footnotes-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - text-blocks
---

WordPress 6.3 introduces a new feature to insert and display footnotes. This option can be found on the toolbar of individual blocks under the [Rich Editing](https://wordpress.org/documentation/article/more-text-editing-overview/) option.

![Overview of how to insert Footnotes.](https://wordpress.org/documentation/files/2023/08/footnote-block.png)## Adding the Footnotes Block

The Footnotes block will be added to your page or post as soon as you insert your first note using the Rich Text option. This new block works like other blocks and it can be moved around and removed.

From 6.4, the Footnotes block can be removed, a provision has been made to make re-insertion easier. Additionally, the footnotes block is now displayed in the inserter for improved discoverability. It will show even if anchors are not yet inserted into the content. This modification strеamlinеs and improvеs thе discovеrability of thе Footnotеs block, with thе wider goal of crеating a morе usеr-friеndly еxpеriеncе.

![The footnotes block can be added manually.](https://wordpress.org/documentation/files/2023/08/footnotes-inserter.png)The text in the placeholder is a starting point, future refinements may include instructions on how to insert anchors.

![An empty footnotes block](https://wordpress.org/documentation/files/2023/08/footnotes-block-empty-1024x433.png)The user experience was enhanced in the most recent update by giving placeholder instructions for scenarios where the Footnotes block is not available for custom post types. This enhancement seeks to provide users with clearer guidance by providing instructions when the Footnotes block is missing in specified instances.

![Footnotes block placeholder when it's not available on custom post types](https://wordpress.org/documentation/files/2023/12/image.png)Adding Footnote blocks to templates is also not possible at the moment but it is [being explored](https://github.com/WordPress/gutenberg/issues/52554).

Attempting to remove a Footnotes block triggers a warning regarding its removal and its impact. It advises that footnote references in the content area will continue to show if the block is removed. The user is required to confirm the deletion request before the block is deleted.

![The prompt when attempting to remove a footnotes block](https://wordpress.org/documentation/files/2023/12/image-3-1024x651.png)## Adding individual notes

To add new notes, highlight some text and open the “Rich Text” menu. Then select the “Footnotes” option.

Notes are automatically linked to the original text and include a “go back” link for convenience.

If you move your blocks around after having added notes, the numbers and order of the notes will be automatically updated to match the changes you made.

## Customize the Footnotes Block

The Footnotes block has been improved with more design flexibility in this release. The block now has settings for [typography](https://wordpress.org/documentation/article/typography-settings-overview/), [dimensions](https://wordpress.org/documentation/article/dimension-controls-overview/), and [border](https://wordpress.org/documentation/article/border-settings-overview/) control. [Color](https://wordpress.org/documentation/article/colors-settings-overview/) support has been adjusted, with link and text now being the default, rather than background and text. These modifications attempt to give users more flexibility when it comes to modifying the Footnotes block.

![Footnote block settings options](https://wordpress.org/documentation/files/2023/12/image-1.png)![Footnote block text color settings](https://wordpress.org/documentation/files/2023/12/image-2-1024x491.png)## Changelog

- Updated 2023-12-12
    - Updating content for WordPress 6.4
- Created 2023-08-08
