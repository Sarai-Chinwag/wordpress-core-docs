---
type: document
title: Comparing Patterns, Template Parts, and Synced Patterns (Reusable Blocks)
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/comparing-patterns-template-parts-and-reusable-blocks/"
tags:
timestamp: "2026-06-16T19:28:33+00:00"
wordpress:
  id: 2217
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:33"
  date_gmt: "2026-06-16 19:28:33"
  modified: "2026-06-16 19:28:33"
  modified_gmt: "2026-06-16 19:28:33"
  slug: comparing-patterns-template-parts-and-reusable-blocks
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/comparing-patterns-template-parts-and-reusable-blocks/"
  comment_count: 0
  terms:
    category:
      - appearance
      - customization
---

## Overview

With more types of reusable content you can create with WordPress, this article seeks to clarify when it makes sense to use certain types in different situations to help guide you to make the best decisions possible. At a high level, this will focus on Template Part blocks, Block Patterns, and Synced Patterns (Reusable Blocks).

WordPress 6.3 renamed Reusable Blocks to Patterns. A synced pattern will behave in exactly the same way as a reusable block.

### Template Part

The Template Part block is an advanced block that can be used with a block theme or a theme that supports [template editing](https://wordpress.org/themes/tags/template-editing/). They often come with your theme and are used to organize and display your site structure. For more information, you can learn more in the [Template Part block support article](https://wordpress.org/documentation/article/template-part-block/).

### Synced pattern (Reusable block)

Synced pattern is a kind of block pattern that enabled Synced option, and it will behave in exactly the same way as a reusable block. Editing the synced pattern will update it anywhere it is used. After creating a synced pattern, you can ‘Detach’ it to a regular block, and edit the block without affecting your already saved synced pattern. For more information, you can learn more in the [Synced Pattern article](https://wordpress.org/documentation/article/reusable-blocks/).

### Block Patterns

Block Patterns are a collection of predefined blocks that you can insert into posts and pages and then customize with your own content. For more information, you can learn more in the [Block Pattern support article](https://wordpress.org/documentation/article/block-pattern/).

Here’s a table comparing these different options to each other:

|  | **Template Part** | **Synced Patterns**  **(Reusable Block)** | **Patterns** |
|---|---|---|---|
| Type | Site Structure | User Content | User Content |
| Syncing Ability | Synced | Synced | Un-synced |
| Example | Footer | Business hours | Call to action |

Site structure means it should not be a part of your content, like a post or page. Syncing ability touches on whether if you update it in one spot, it updates everywhere the same block is used.

## Guidelines

Based on the above, this means it’s best to use template parts and Synced pattern for things you want to have in sync with each other whereas patterns are best for content that you expect to change across your site.

In general, template parts should not be added to a Synced pattern or a regular pattern since this is meant to represent site structure rather than content. A template part can include a Synced pattern though or be built using patterns! You can also use block patterns to build templates and template parts, but you should not use a template part inside a pattern.

## Situationals

### Repeated content across your site

This could be everything from how to get in touch to your business hours to your social media accounts. To avoid having to add the same content to a paragraph block every time you want to place it at the end of your post, you can make it a Synced pattern.

### Repeated structure across your site

For anything that’s more about site structure that’s repeated across your site, like a Header or Footer, it’s best to use a template part. These carry semantic meaning within block themes so it’s important to make the distinction.

### Repeated design or layout

When it’s less about content and more about wanting to repeat a design or layout, patterns are best to use. This is because the content doesn’t need to be synced and, instead, what you want repeated is how something visually looks.

## Changelog

- Updated 2023-08-08
    - WP 6.3 introduced custom patterns, and Reusable Block was renamed to Synced Pattern.
