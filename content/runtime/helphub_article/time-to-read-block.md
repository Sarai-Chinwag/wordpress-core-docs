---
type: document
title: Time to Read block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/time-to-read-block/"
tags:
timestamp: "2026-06-16T19:28:12+00:00"
wordpress:
  id: 2122
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:12"
  date_gmt: "2026-06-16 19:28:12"
  modified: "2026-06-16 19:28:12"
  modified_gmt: "2026-06-16 19:28:12"
  slug: time-to-read-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/time-to-read-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - text-blocks
---

The Time to Read block shows an estimated reading time for the current post or page. You can display a single time (for example, 3 min) or a time range (for example, 3–4 min). A Word Count variation is also available if you prefer to display the total number of words instead.

## Requirements

- WordPress 6.9 or later.

## Add the Time to Read block

1. Open a post or page in the editor.
2. Place your cursor where you want the block to appear.
3. Open the block inserter (+) and search for “Time to Read.”
4. Select Time to Read to add it.

Tip: You can switch between Time to Read and Word Count using the block’s variation picker after inserting it.

## Block toolbar

- Transform: Switch between Time to Read and Word Count variations.
- Drag/Move: Reorder the block on the page.
- Alignment: Align left, center, or right.
- More options: Duplicate, remove, and other standard block actions.

## Block settings

### Display as range

By default, this is enabled to show a small range (for example, 3–4 min) rather than a single average value. You can toggle this on and off to your liking.

### Word Count (variation)

The block comes with a variation that shows the total word count of the current post or page. You can switch to this variation by either adding it directly or transforming to it.

### Advanced

- HTML anchor: Add an anchor to link directly to this block (for example, article#reading-time).
- Additional CSS class(es): Add custom classes for further styling.

### Tips

- Place Time to Read near the title or byline so readers see it immediately.
- Use consistent styling across posts for a cohesive look.
- Consider using the Word Count variation for long-form content alongside Time to Read, depending on your audience.

## How it’s calculated

- The estimate is based on the content of the current post or page and uses language-aware counting (words or characters depending on your site language).
- Time to Read shows minutes; there isn’t a setting for seconds or custom words-per-minute in WordPress 6.9.

## Where it works best

- Posts and pages in the post editor.
- In templates or patterns, values display based on the current content context. Preview with a specific post or page to see realistic results.

## Demo

## Frequently asked questions

**Can I change the reading speed (words per minute)?**

- Not in WordPress 6.9. The estimate uses a default reading speed and language-aware counting.

**Can I show seconds or more precise timing?**

- No. The block displays minutes, either as a single value or a range.

**Does it count text inside all blocks?**

- It estimates based on your post/page content. Dynamically loaded content (shortcodes, external embeds, or content injected by plugins) may not be fully reflected.

## Troubleshooting

The value looks wrong or shows a very low number:

- Make sure you’re viewing a single post or page, not an index/archive.
- Update or save your draft to ensure the editor reflects your latest content.
- If your page relies heavily on shortcodes or external embeds, note the estimate may not include all external text.

**Styles don’t match the editor preview:**

- Theme styles affect the frontend appearance. Adjust colors/typography in the block’s Styles panel or via your theme’s design tools.

**The block doesn’t render in a template preview:**

- Open a specific post or page preview for that template to provide the correct content context.

## Changelog

- Created 2025-12-02
