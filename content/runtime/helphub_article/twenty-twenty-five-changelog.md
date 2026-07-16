---
type: document
title: Twenty Twenty-Five changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-twenty-five-changelog/"
tags:
timestamp: "2026-06-16T19:28:13+00:00"
wordpress:
  id: 2130
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:13"
  date_gmt: "2026-06-16 19:28:13"
  modified: "2026-06-16 19:28:13"
  modified_gmt: "2026-06-16 19:28:13"
  slug: twenty-twenty-five-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-twenty-five-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 1.5

May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Exclude sticky posts in templates that have multiple Query blocks with offsets, to prevent repeating sticky posts in each query. ([\#62975](https://core.trac.wordpress.org/ticket/62975))
- Remove the text color setting in the ‘Written by’ pattern, and inherit color from a parent element, to avoid potential problems with very low color contrast. ([\#62982](https://core.trac.wordpress.org/ticket/62982))
- Update Fira Sans font for the theme, to resolve rendering issues with the backtick character. ([\#63964](https://core.trac.wordpress.org/ticket/63964))
- Documentation: Remove redundant comments for conditionally-defined functions. ([\#64265](https://core.trac.wordpress.org/ticket/64265))

## Version 1.4

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Introduce minification for `style.css`. ([\#63012](https://core.trac.wordpress.org/ticket/63012))
- Add `path` data to the theme stylesheet so it can be inlined, to avoid a render-blocking external stylesheet. ([\#63007](https://core.trac.wordpress.org/ticket/63007))
- Prevent `pre` elements from overflowing their container by setting the element’s `overflow-x` to `auto`. ([\#63875](https://core.trac.wordpress.org/ticket/63875))
- Remove redundant `echo` from `esc_html_e()` in the ‘Cover with big heading’ block pattern. ([\#63345](https://core.trac.wordpress.org/ticket/63345))
- Fix typo in font credit URL protocol. ([\#63747](https://core.trac.wordpress.org/ticket/63747))

## Version 1.3

Released: August 5, 2025

- Ensure editor styles are enqueued, using a relative path in `add_editor_style()` instead of a full URL. [\#63399](https://core.trac.wordpress.org/ticket/63399)

## Version 1.2

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Improve text strings for patterns and templates. [\#62482](https://core.trac.wordpress.org/ticket/62482)

## Version 1.1

Released: February 11, 2025

- Pin a `theme.json` schema version to Twenty Twenty-Five ([\#62455](https://core.trac.wordpress.org/ticket/62455))

## Version 1.0

Released: November 12, 2024

Initial Release.
