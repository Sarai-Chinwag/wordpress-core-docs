---
type: document
title: Twenty Sixteen changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-sixteen-changelog/"
tags:
timestamp: "2026-06-16T19:28:15+00:00"
wordpress:
  id: 2139
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:15"
  date_gmt: "2026-06-16 19:28:15"
  modified: "2026-06-16 19:28:15"
  modified_gmt: "2026-06-16 19:28:15"
  slug: twenty-sixteen-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-sixteen-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 3.8

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Ensure the Quote block inherits group color settings from the parent block, if the parent has a text color set in the block settings and the Quote block does not have a text color set in the block settings. ([\#51236](https://core.trac.wordpress.org/ticket/51236))
- Update `.screen-reader-text` class with `word-break` reset, to ensure screen readers will not read text as individual letters in hidden text. ([\#64375](https://core.trac.wordpress.org/ticket/64375))
- Remove default `type` attributes from `style` tags because the HTML5 standard does not require them. ([\#64428](https://core.trac.wordpress.org/ticket/64428))
- Consistently escape `get_search_query()` in `search.php` template. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Documentation: Add missing `@return` tags and descriptions. ([\#64277](https://core.trac.wordpress.org/ticket/64277))

## Version 3.7

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Remove code for obsolete browsers, including conditional comments for Internet Explorer and the contents of IE-specific stylesheets and HTML5 Shiv files. ([\#58836](https://core.trac.wordpress.org/ticket/58836))
- Modernize Genericons by removing EOT, TTF, and SVG source references; by correcting the `transition` values; and by removing `filter` and prefixed `transform` rules from the rotate and flip classes. ([\#62128](https://core.trac.wordpress.org/ticket/62128))
- Use `wp_print_inline_script_tag()` when available to construct scripts while also ensuring filters may inject additional attributes on the `<script>` tags, such as nonce for Content Security Policy (CSP). ([\#63806](https://core.trac.wordpress.org/ticket/63806))
- Prevent output of empty heading and/or link tags if the Site Title or Tagline has no value. ([\#44656](https://core.trac.wordpress.org/ticket/44656))
- Document the `twentysixteen_author_avatar_size` filter. ([\#63647](https://core.trac.wordpress.org/ticket/63647))
- Document the `twentysixteen_content_width` filter. ([\#63646](https://core.trac.wordpress.org/ticket/63646))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))

## Version 3.6

Released: August 5, 2025

- Ensure that the Quote block’s Plain style does not have a border in the editor. [\#63424](https://core.trac.wordpress.org/ticket/63424)

## Version 3.5

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Add `aria-current="page"` on header links that point to the current URL. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Update `.screen-reader-text` class, replacing the obsolete `clip` property with `clip-path`. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Replace references to “Add New” theme screen in `readme` file. [\#61219](https://core.trac.wordpress.org/ticket/61219)
- Correct the border of the Latest Comments block in the editor. [\#62282](https://core.trac.wordpress.org/ticket/62282)

## Version 3.4

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Fix editor styles for Table and Calendar blocks and captions. ([\#58355](https://core.trac.wordpress.org/ticket/58355))
- Fix Pullquote block spacing and borders, and add theme preset border colors. ([\#59754](https://core.trac.wordpress.org/ticket/59754))
- Respect user-defined typography settings in Button blocks. ([\#58609](https://core.trac.wordpress.org/ticket/58609))
- Show the Verse block in the same font family in the editor as it has on the front end. ([\#61140](https://core.trac.wordpress.org/ticket/61140))
- Match the Quote block border color to its text color in the editor. ([\#56565](https://core.trac.wordpress.org/ticket/56565))
- Set Quote block border width to 4 pixels, regardless of font size. ([\#60239](https://core.trac.wordpress.org/ticket/60239))
- Fix Code block typography and padding in editor styles. ([\#61700](https://core.trac.wordpress.org/ticket/61700))
- Respect user-defined typography settings in the Pullquote block. ([\#59919](https://core.trac.wordpress.org/ticket/59919))
- Edit `initial-scale` value in viewport meta tag to `1.0` instead of `1`. [\[59026\]](https://core.trac.wordpress.org/changeset/59026)
- Adjust comment spacing to meet coding standards. ([\#62160](https://core.trac.wordpress.org/ticket/62160))
- Load block patterns on the `init` hook to avoid triggering notices caused by loading the translations too early. ([\#62237](https://core.trac.wordpress.org/ticket/62237))
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 3.3

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/)

- Fix mismatch of visual and Document Object Model (DOM) order of elements in the footer by showing the the site information links below the social menu at **any** screen width. ([\#60496](https://core.trac.wordpress.org/ticket/60496))
- Increase padding for the `pre` element in the editor to match the front. ([\#61306](https://core.trac.wordpress.org/ticket/61306))
- Update HelpHub link for post format documentation to avoid unnecessary redirections. ([\[57800\]](https://core.trac.wordpress.org/changeset/57800/))

## Version 3.2

Released: April 2nd, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/)

- Add `border-radius` to avatar images in the editor. This ensures that avatars design in the Post Author or Avatar blocks in the editor matches the front end. ([\#59253](https://core.trac.wordpress.org/ticket/59253))
- Cast font URL functions to `string` for `add_editor_style()`, to avoid PHP warnings on child themes ([\#59704](https://core.trac.wordpress.org/ticket/59704))
- Add missing text domain to various block patterns. ([\#60245](https://core.trac.wordpress.org/ticket/60245))
- Fix typos ([\#60268](https://core.trac.wordpress.org/ticket/60268))

## Version 3.1

Released: November 7, 2023

- Use default display for `summary` element within a Details block, to ensure the toggle icon appears ([\#58915](https://core.trac.wordpress.org/ticket/58915))
- Implement `the_header_image_tag` function for enhanced compatibility with new image features such as lazy loading, async decoding and fetch priority ([\#58675](https://core.trac.wordpress.org/ticket/58675))
- Update default themes to use new script function signature: the last parameter of `wp_register_script()` and `wp_enqueue_script()` is an array instead of the boolean `true` ([\#59302](https://core.trac.wordpress.org/ticket/59302))
- Use `defer` loading strategy for theme scripts ([\#59316](https://core.trac.wordpress.org/ticket/59316))

## Version 3.0

Released: August 8, 2023

- Reflect Quote block text color on the entire block ([\#57204](https://core.trac.wordpress.org/ticket/57204))
- Fix List block padding in the editor when the list has a background color ([\#58409](https://core.trac.wordpress.org/ticket/58409))
- Fix Letter Case control implementation on the Button block ([\[55999](https://core.trac.wordpress.org/changeset/55999)\])
- Replace the deprecated jQuery `unbind` method with `off` ([\#58225](https://core.trac.wordpress.org/ticket/58225))
- Deprecate the skip link focus fix, switching the enqueue function to just register the script ([\#54421](https://core.trac.wordpress.org/ticket/54421))
- Remove call to `load_theme_textdomain()` function if the WordPress version is at least 4.6 ([\#58318](https://core.trac.wordpress.org/ticket/58318))
- Add “Requires at least” and “Requires PHP” to readme.txt ([\#57857](https://core.trac.wordpress.org/ticket/57857))

## Version 2.9

Released: March 29, 2023

- Fix Separator block “Dots” style variation ([\#56008](https://core.trac.wordpress.org/ticket/56008))
- Gallery block produces shifted or scrambled output ([\#56412](https://core.trac.wordpress.org/ticket/56412))
- Bundle Google Fonts locally ([\#55985](https://core.trac.wordpress.org/ticket/55985))
- Mark strings for screen readers ([\#29748](https://core.trac.wordpress.org/ticket/29748))
- Use the new `/documentation/` URLs for HelpHub links ([\#57726](https://core.trac.wordpress.org/ticket/57726))

## Version 2.8

Released: November 1, 2022

- Pullquote Block: Color not reflected in editor and front end ([\#56008](https://core.trac.wordpress.org/ticket/56008))

## Version 2.7

Released: May 24, 2022

- Remove .entry-content selector from button styles ([\#55167](https://core.trac.wordpress.org/ticket/55167))
- Rename parameters that use reserved keywords in bundled themes ([\#55327](https://core.trac.wordpress.org/ticket/55327))
- Note visually hidden text for translators ([\#55591](https://core.trac.wordpress.org/ticket/55591))

## Version 2.6

Released: January 25, 2022

- font-style error in blocks.css ([\#46807](https://core.trac.wordpress.org/ticket/46807))
- Table block does not respect the alignment options ([\#54317](https://core.trac.wordpress.org/ticket/54317))
- Return type not matched in PHPDoc – Bundled Themes ([\#53878](https://core.trac.wordpress.org/ticket/53878))
- Remove “role” attribute on HTML5 elements with a default landmark role. ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Bundled themes patterns: remove unwanted trailing spaces from translated strings ([\#53774](https://core.trac.wordpress.org/ticket/53774))
- Bundled Themes: Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 2.5

Released: July 20, 2021

- Improve display of blocks in widget areas.

## Version 2.4

Released: March 9, 2021

- Core blocks are positioned incorrectly in some core bundled themes. ([\#52009](https://core.trac.wordpress.org/ticket/52009))
- Problem with post metabox styles. ([\#52646](https://core.trac.wordpress.org/ticket/52646))
- Add support for the font size option for the code block. ([\#52431](https://core.trac.wordpress.org/ticket/52431))

## Version 2.3

Released: December 8, 2020

- Introduce block patterns for Twenty Sixteen. ([\#51101](https://core.trac.wordpress.org/ticket/51101))
- Correct list block alignment in editor styles. ([\#51157](https://core.trac.wordpress.org/ticket/51157))
- Declare support for the html5 feature navigation-widgets. ([\#51445](https://core.trac.wordpress.org/ticket/51445))
- Use correct value for the speak property in various CSS files. ([\#51622](https://core.trac.wordpress.org/ticket/51622))

## Version 2.2

Released: August 11, 2020

- Fixes issues where tables created by the table block have an extra border on the left side which extends below the table. ([\#50180 )](https://core.trac.wordpress.org/ticket/50180)

## Version 2.1

Released: March 31, 2020

- Update calendar widget styles for 5.4 markup. ([\#49549](https://core.trac.wordpress.org/ticket/49549))
- Fixed Text color setting in pullquote block not applied. ([\#47019](https://core.trac.wordpress.org/ticket/47019))

## Version 2.0

Released: May 7, 2019

- Trigger a new `wp_body_open` action immediately after the opening `body` tag, and add shim. ([\#12563](https://core.trac.wordpress.org/ticket/12563), [\#46679](https://core.trac.wordpress.org/ticket/46679))
- Use theme version number when enqueuing styles. ([\#39997](https://core.trac.wordpress.org/ticket/39997))
- Update readme.txt file content to fix validation errors. ([\#45871](https://core.trac.wordpress.org/ticket/45871))
- Update link to child theme and post thumbnail documentation to point to their new locations. ([\#46450](https://core.trac.wordpress.org/ticket/46450), [\#46823](https://core.trac.wordpress.org/ticket/46823))
- Fix inconsistent HTML comments after closing HTML tags. ([\#46871](https://core.trac.wordpress.org/ticket/46871))

## Version 1.9

Released: February 21, 2019

- Add escaping to the pingback URL. ([\#43717](https://core.trac.wordpress.org/ticket/43717))
- Implement preconnect for Google Fonts. ([\#44668](https://core.trac.wordpress.org/ticket/44668))

## Version 1.8

Released: January 9, 2019

- Make sure button blocks respect the default rounded style, as well as the squared and outline options. ([\#45541](https://core.trac.wordpress.org/ticket/45541))
- Bump version numbers of updated scripts and stylesheets to prevent caching. ([\#45679](https://core.trac.wordpress.org/ticket/45679))

## Version 1.7

Released: December 19, 2018

- Update styles so button blocks will apply theme’s custom colors. ([\#45427](https://core.trac.wordpress.org/ticket/45427))
- Swap incorrect styles for `sub` and `sup` in the editor styles, so the styles are correct. ([\#44776](https://core.trac.wordpress.org/ticket/44776))
- Correct block appender appearance in block editor. ([\#45450](https://core.trac.wordpress.org/ticket/45450))
- Remove the term “Gutenberg” from code comments. ([\#45452](https://core.trac.wordpress.org/ticket/45452))

## Version 1.6

Released: December 6, 2018

- Add front end styles, editor styles and a custom color palette for the new block-based editor. ([\#45044](https://core.trac.wordpress.org/ticket/45044) and [\#45245](https://core.trac.wordpress.org/ticket/45245))
- Add theme support for responsive block embeds. ([\#45274](https://core.trac.wordpress.org/ticket/45274))
- Update theme’s wide image styles and JavaScript to include image blocks. ([\#45380](https://core.trac.wordpress.org/ticket/45380))

## Version 1.5

Released: May 17, 2018

- Remove the svn:executable property from files that don’t need it. ([\#42594](https://core.trac.wordpress.org/ticket/42594))
- General: Fix some precision alignment formatting warnings. ([\#41057)](https://core.trac.wordpress.org/ticket/41057)
- Code is Poetry. WordPress’ code just… wasn’t. ([\#41057](https://core.trac.wordpress.org/ticket/41057))
- Add link to privacy policy page in footer. ([\#43715](https://core.trac.wordpress.org/ticket/43715))
- Comments: Move comment consent input outside the label for a11y. ([\#43436](https://core.trac.wordpress.org/ticket/43436))

## Version 1.4

Released: November 14, 2017

- Allow category display in post preview even when there is only one category. ([\#39531](https://core.trac.wordpress.org/ticket/39531))
- Replace a variety of http links referenced in inline docs with their `https` counterparts. ([\#40732](https://core.trac.wordpress.org/ticket/40732))
- Correct the `@return` value for `twentysixteen_post_thumbnail_sizes_attr()`. ([\#41830](https://core.trac.wordpress.org/ticket/41830))
- Replace inline control structureв to improve code readability. ([\#38468](https://core.trac.wordpress.org/ticket/38468))
- Make sure comment number comparison in comments.php works as expected. ([\#39660](https://core.trac.wordpress.org/ticket/39660))
- Change tag cloud format to a list (ul) for better semantics and accessibility. ([\#40138](https://core.trac.wordpress.org/ticket/40138))

## Version 1.3

Released: August 15, 2016

- Update deprecated theme tags. ([\#457](https://github.com/WordPress/twentysixteen/issues/457))
- Make twentysixteen\_categorized\_blog() function pluggable. ([\#446](https://github.com/WordPress/twentysixteen/issues/446))
- Add clearfix for blockquote. ([\#462](https://github.com/WordPress/twentysixteen/issues/462))
- Add styles for date/time input\[type\]s introduced in HTML5. ([\#437](https://github.com/WordPress/twentysixteen/issues/437))
- Remove .pot files from Default Themes. ([\#473](https://github.com/WordPress/twentysixteen/issues/473))

## Version 1.2

Released: April 12, 2016

- Remove title attribute from search field
- Prevent overflowing of fieldsets on small screens
- jQuery: Replace use of the `.load()` method for the “load” event with `.on( 'load', handler )`
- Adding site logo functionality
- Add selective refresh support for site title and tagline
- Add customize-selective-refresh-widgets theme support

## Version 1.1

Released: January 6, 2016

- Remove unnecessary crop parameter
- Remove an extra separator in post meta for single author blog
- Comment tag fix
- Filter tag cloud widget font size to avoid !important in CSS
- Fix incorrect opacity property for IE specific stylesheet.
- Escape attribute text properly in `aria-label` attributes

## Version 1.0

Released: December 8, 2015

Initial Release.
