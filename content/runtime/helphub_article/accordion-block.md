---
type: document
title: Accordion block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/accordion-block/"
tags:
timestamp: "2026-06-16T19:28:12+00:00"
wordpress:
  id: 2123
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:12"
  date_gmt: "2026-06-16 19:28:12"
  modified: "2026-06-16 19:28:12"
  modified_gmt: "2026-06-16 19:28:12"
  slug: accordion-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/accordion-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - design-blocks
---

The Accordion block lets you show content in collapsible sections so visitors can expand just the parts they need. It’s commonly used for FAQs, schedules, or any long page you want to make easier to scan. Each Accordion contains Accordion Item blocks. Every item has:

- Accordion Heading: the clickable title.
- Accordion Panel: the content that expands and collapses. You can add any blocks in the panel.

## Requirements

- WordPress 6.9 or later.

## Add the Accordion block

1. Open a post or page in the editor.
2. Select where you want the accordion to appear.
3. Open the block inserter (+) and search for “Accordion.”
4. Select Accordion to add it to your content.

## Add, edit, and reorder Accordion Items

- Add a new item: Click the + Add accordion item button inside the block (or use the inserter at the end of the list).
- Edit a heading: Click the Accordion Heading and type a short, descriptive title.
- Add content: Click inside the Accordion Panel and add any blocks you need (paragraphs, images, lists, etc.).
- Reorder items: Use the move handles in the toolbar or drag items in List View to change the order.
- Expand/collapse while editing: Click a heading to toggle the panel open or closed so you can focus on one item at a time.

## Block toolbar

When you select:

- Accordion: You’ll see alignment and positioning controls, plus handles to move the entire accordion.
- Accordion Item: You’ll see move/drag controls and basic formatting for the heading. Use List View to quickly select the Heading or Panel inside an item.

## Block settings

### Open by default

When on, Accordion content will be displayed by default.

### Auto-close

When on, this will automatically close accordions when a new one is opened.

### Show icon

When on, an icon will display with an additional option to select it to display on the right or left side.

### Icon position

Position the icon to the left or right of the the accordion title.

### Advanced

The Accordion block provides the following Advanced settings options: HTML anchor, Additional CSS Class(es), and Styles.

[Learn more about advanced settings](https://wordpress.org/documentation/article/advanced-settings-overview/)

### Styles

Depending on your theme, you may see controls for colors, typography, borders, and spacing. These affect the overall look of headings and panels.

## Accordion inner blocks

The Accordion block is made of a few blocks to pull the feature together:

- Accordion item
- Accordion panel

These inner blocks may include additional style controls depending on your theme (colors, typography, spacing). For the Accordion item, you can pick the semantic heading level for the item’s title (for example, H3, H4). Use levels that fit your page outline.

## Tips

- Keep headings short and descriptive so visitors know what each item contains.
- Use consistent heading levels across items (for example, all H3s) that fit your page’s heading structure.
- For long content, consider splitting items into smaller sections or using lists inside the panel.
- Save frequently used accordions (like an FAQ) as a Pattern so you can reuse them across your site.

## Accessibility

- The Accordion block follows accessible patterns so headings act as buttons and panels announce their expanded/collapsed state to assistive technologies.
- Best practices:
    - Use meaningful, concise headings.
    - Avoid placing interactive elements (like links or buttons) inside the heading itself; put them in the panel.
    - Choose heading levels that follow your page hierarchy.

## Demo

## Frequently asked questions

**What’s the difference between Accordion and Details?**

- Details creates a single collapsible section. Accordion is a list of coordinated collapsible items with options to allow one or multiple open at once.

**Can I open more than one item at the same time?**

- Yes. Turn on “Allow multiple items to be open” in the Accordion block settings.

**How do I make a specific item open by default?**

- Select the Accordion Item, then enable “Initially open” in its settings.

**Can I add any blocks inside an Accordion Panel?**

- Yes. Panels can contain any blocks, including images, lists, and embeds.

## Changelog

- Updated 2026-05-25 (props @kjoyner @awetz583)
    - Updated “Advanced” section to refer to new overview page
- Created 2025-12-02
