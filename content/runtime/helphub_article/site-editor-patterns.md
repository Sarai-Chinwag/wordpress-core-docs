---
type: document
title: Site Editor Patterns
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/site-editor-patterns/"
tags:
timestamp: "2026-06-16T19:28:18+00:00"
wordpress:
  id: 2151
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:18"
  date_gmt: "2026-06-16 19:28:18"
  modified: "2026-06-16 19:28:18"
  modified_gmt: "2026-06-16 19:28:18"
  slug: site-editor-patterns
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/site-editor-patterns/"
  comment_count: 0
  terms:
    category:
      - customization
      - site-editor
---

Since WordPress version 6.3, it is possible to create and manage your site’s [Patterns and template parts](https://wordpress.org/documentation/article/comparing-patterns-template-parts-and-reusable-blocks/) via the Site Editor’s sidebar. You can learn about the Site Editor in this article: [Site Editor](https://wordpress.org/documentation/article/site-editor/).

The Site Editor Patterns menu is **only** available when you install and activate a [Block theme](https://wordpress.org/documentation/article/block-themes/) on your site.

## **Working with patterns**

Navigate to **Appearance &gt; Editor &gt; Patterns** to access your Patterns and template parts.

Please note that template parts are now listed under **Patterns**.

![Showing the location Pattern menu itim](https://wordpress.org/documentation/files/2023/08/patterns-1024x639.png)## **Template parts**

The first type of pattern you will find are **Template parts**. Template parts are **included with block themes** and are typically used on multiple templates across your site.

If you click on the **Actions** (ellipsis) button, you will see options to **edit** or **duplicate** that Template part.

Finally, you can edit the Template part by clicking directly on it.

![Template parts and their option](https://wordpress.org/documentation/files/2023/08/template_parts-1024x640.png)## **My patterns**

The first item in the Patterns section is **My patterns**. This section lists all the custom patterns you added to your site yourself. They can be filtered by [**Synced**](https://wordpress.org/documentation/article/reusable-blocks/) or **Standard** (non-synced).

If you have a lot of Patterns, the **Command Palette** is another great find them. Learn more about the [Command Palette here](https://wordpress.org/support/article/site-editor-command-palette).

If you click on the **Actions** (ellipsis) button next to each pattern, you will see options to **Edit**, **Duplicate**, **Rename, Export as JSON** or **Delete** that pattern.

![My patterns action menu](https://wordpress.org/documentation/files/2023/08/my_patterns_options-1024x640.png)You can edit any pattern just by clicking on the pattern itself.

## **Theme patterns**

Underneath **My patterns**, you can find regular patterns that come bundled with your theme. These patterns **cannot be edited directly** (hence they are marked with a lock symbol). Instead, you can click on the **Actions** (ellipsis) button and click **Duplicate** to create an editable copy of that pattern. This copy will be listed under **My patterns**.

![Theme patterns' duplicate option](https://wordpress.org/documentation/files/2023/08/theme_patterns_duplicate-1-1024x640.png)## **Add or import new patterns**

There is an **Add Pattern** button in the right corner that you can click on to create new patterns. If you click on it, you will see three options: **Add Pattern, Add Template part,** and **Import pattern from JSON**.

![Plus sign icon to create new patterns](https://wordpress.org/documentation/files/2023/08/add_pattern_button-1024x640.png)You can learn more about the difference between [Patterns and template parts here](https://wordpress.org/documentation/article/comparing-patterns-template-parts-and-reusable-blocks/).

## **Export patterns**

You can export patterns from the **My Patterns** section in the Site Editor. Patterns that come with a theme are locked and cannot be exported.

To export a single pattern, go to **Patterns &gt; My Patterns**. Click the **Actions** (ellipsis) button next to the pattern. Select **Export as JSON**, which downloads the pattern as a .json file.

To export multiple patterns, in My Patterns, select the box to check all patterns located at the bottom. And then click the **Download icon**. This downloads a .zip file containing .json files for each pattern chosen.Besides that, the box to check all patterns located at the bottom allows you to bulk **Delete** patterns as well.

![Export patterns option showcased on single pattern and as a part of the bulk edit.](https://wordpress.org/documentation/files/2023/08/export_patterns-1024x640.png)## **Appearance Settings**

In the top-right corner of the **Patterns** screen, just below the **Add Pattern** button, you’ll find options to customize how patterns are displayed.

The first icon, **Layout**, lets you switch between grid and list views, depending on your preference.

The second icon, **View Options**, provides more detailed controls. You can change the sort order of patterns, adjust the preview size, set the number of patterns per page, and choose which pattern details are displayed in the list.

![Appearance Settings icons and opened appearance settings section](https://wordpress.org/documentation/files/2023/08/layout-1024x640.png)## Changelog

- Updated 2025-06-05
    - Completly rewritten all content to match WP 6.8 FSE capabilities
- Updated 2023-08-24
    - Updated formatting
    - Updated category and subcategory
    - Fixed some typos
- Created 2023-08-08
