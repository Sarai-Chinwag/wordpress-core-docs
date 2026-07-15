---
type: document
title: Synced Patterns (Reusable blocks)
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/reusable-blocks/"
tags:
timestamp: "2026-06-16T19:28:35+00:00"
wordpress:
  id: 2228
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:35"
  date_gmt: "2026-06-16 19:28:35"
  modified: "2026-06-16 19:28:35"
  modified_gmt: "2026-06-16 19:28:35"
  slug: reusable-blocks
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/reusable-blocks/"
  comment_count: 0
  terms:
    category:
      - block-editor
      - customization
---

[](https://wordpress.org/documentation/article/blocks/)[Go back to the list of **Blocks**](https://wordpress.org/documentation/article/blocks/)

Synced pattern is a type of block pattern that enabled Synced option, and it will behave in exactly the same way as a reusable block. Editing the synced pattern will update it anywhere it is used. After creating a synced pattern, you can ‘detach’ it to a regular block, and edit the block without affecting your already saved synced pattern. For more information, you can learn more in the Synced Pattern article.

WordPress 6.3 renamed Reusable Blocks to Patterns. A synced pattern will behave in exactly the same way as a reusable block.

## Creating a Synced Pattern

Let’s say you have a paragraph block which you often fill with the same text at the end of your post. This could be everything from how to get in touch to your business hours to your social media accounts. To avoid having to add the same content to a paragraph block every time you want to place it at the end of your post, you can make it a synced pattern. To accomplish this, follow these steps:

1. Select the block or blocks you want to turn into a pattern.
2. Click on the three dot menu that opens up the additional settings.
3. Click on “Create pattern”.
4. Enter the name of pattern.
5. Turn on Synced option
6. Click Create.

You’ll then be able to locate the created synced patterns at Synced Patterns (crossing rhombus icon) of Block Inserter.

![The Block inserter with the "Synced Patterns" icon highlighted.](https://wordpress.org/documentation/files/2023/07/WP-6-3-working-with-patterns.jpeg)## Using a Synced Pattern

After you’ve created a Synced Pattern, you can then use it wherever you’d like. You’ll also have a few more options for adding one into your content:

- You can open up the **Block Inserter** and switch to the **Synced Patterns** section to add whichever option you want.
- Click on the add block button and search for the name of the synced pattern you want to use.
- You can type / followed by the name of the synced pattern you want to use.

After inserting the Synced Pattern you want to use, make sure to select ‘**Detach pattern**‘ (formerly known as *“***Convert to Regular Block**“) option shown below if you wish to make any changes to the block on that page or post only. Note that this option won’t be available if the Synced Pattern is locked.

![Synced Pattern Toolbar with the "Detach Pattern" option highlighted.](https://wordpress.org/documentation/files/2023/07/wp-6-3-detach-pattern.jpeg)## Selecting and editing a Synced Pattern

If you’d like to edit a synced pattern, you can do so in two ways:

- You can add the block directly into a post or page and edit it from there. If you do this, you’ll see the synced pattern mentioned in the saving flow when you save the post or page itself.
- You can go to **Options &gt; Manage Patterns**, which will take you to a specific interface where you can directly edit patterns as you’d like.

*Keep in mind that, when a synced pattern is changed, the change will be reflected in all the places where the same synced pattern was used.*

## Removing a Synced Pattern

To remove a synced pattern, click on the **three dots** icon, and select the option to **Manage Patterns**. From there you can edit and delete patterns as you’d like.

Keep in mind that, when a synced pattern is removed, the removal will be reflected in all the places where the same synced pattern was used. You’ll see the message below a where removed synced pattern existed:

![A block with a message saying "Block has been deleted or Is unavailable."](https://wordpress.org/documentation/files/2023/07/wp-6-3-missing-reusable-block-1024x494.jpeg)## Demonstration of a Synced Pattern

In this demo, we insert Synced Patterns in the three ways described above (Block Inserter, Add Bloock icon, ‘/’ key). A change in one pattern (in this case, a change in text color) will be reflected in others. Next, detach the middle Synced Pattern. Synchronization is then lost. And if you look at it in the list view, it is back to a normal block.

## Changelog

- Updated 2024-01-09
    - Updated for WordPress 6.4
- Updated 2023-08-08
    - Replaced “Reusable Blocks” with “Patterns”
- Updated 2021-07-13
