---
type: document
title: Twenty Fifteen changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-fifteen-changelog/"
tags:
timestamp: "2026-06-16T19:28:14+00:00"
wordpress:
  id: 2136
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:14"
  date_gmt: "2026-06-16 19:28:14"
  modified: "2026-06-16 19:28:14"
  modified_gmt: "2026-06-16 19:28:14"
  slug: twenty-fifteen-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-fifteen-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 4.2

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Remove default `type` attributes from `style` tags because the HTML5 standard does not require them. ([\#64428](https://core.trac.wordpress.org/ticket/64428))
- Consistently escape `get_search_query()` in `search.php` template. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Documentation: Add missing `@return` tags and descriptions. ([\#64277](https://core.trac.wordpress.org/ticket/64277))

## Version 4.1

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Remove code for obsolete browsers, including conditional comments for Internet Explorer and the contents of IE-specific stylesheets and HTML5 Shiv files. ([\#58836](https://core.trac.wordpress.org/ticket/58836))
- Modernize Genericons by removing EOT, TTF, and SVG source references and by correcting the `transition` values. ([\#62128](https://core.trac.wordpress.org/ticket/62128))
- Use `wp_print_inline_script_tag()` when available to construct scripts while also ensuring filters may inject additional attributes on the `<script>` tags, such as nonce for Content Security Policy (CSP). ([\#63806](https://core.trac.wordpress.org/ticket/63806))
- Prevent output of empty heading and/or link tags if the Site Title or Tagline has no value. ([\#44656](https://core.trac.wordpress.org/ticket/44656))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))

## Version 4.0

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Fix `aria-expanded` in primary menu, and add `aria-controls` to explicitly define controlled content in menus. [\#62936](https://core.trac.wordpress.org/ticket/62936)
- Add `aria-current="page"` on header links that point to the current URL. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Update `.screen-reader-text` class, replacing the obsolete `clip` property with `clip-path`. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Replace references to “Add New” theme screen in `readme` file. [\#61219](https://core.trac.wordpress.org/ticket/61219)

## Version 3.9

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Fix microformat information by moving the visibly hidden “Author” text outside the `vcard` container. ([\#46233](https://core.trac.wordpress.org/ticket/46233))
- Fix link hover effect in editor styles. ([\#61844](https://core.trac.wordpress.org/ticket/61844))
- Fix Pullquote block issues with text color and border. ([\#59801](https://core.trac.wordpress.org/ticket/59801))
- Fix Code block font family in the iframe editor. ([\#61571](https://core.trac.wordpress.org/ticket/61571))
- Show the Verse block in the same font family in the editor as it has on the front end. ([\#61140](https://core.trac.wordpress.org/ticket/61140))
- Fix padding for List blocks with a background color in the non-framed editor. ([\#60197](https://core.trac.wordpress.org/ticket/60197))
- Add missing `initial-scale` value in viewport meta tag. ([\[59026\]](https://core.trac.wordpress.org/changeset/59026))
- Document the `$more` parameter in `twentyfifteen_excerpt_more()`. ([\#62079](https://core.trac.wordpress.org/ticket/62079))
- Load block patterns on the `init` hook to avoid triggering notices caused by loading the translations too early. ([\#62237](https://core.trac.wordpress.org/ticket/62237))
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 3.8

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/)

- Match the Quote and Pullquote blocks’ citation text color to the block’s text color when a user chooses a special color for the block. ([\#59802](https://core.trac.wordpress.org/ticket/59802))
- Reduce the thickness of the Separator block in the iframe editor. ([\#60079](https://core.trac.wordpress.org/ticket/60079))
- Update HelpHub link for post format documentation to avoid unnecessary redirections. ([\[57800\]](https://core.trac.wordpress.org/changeset/57800/))

## Version 3.7

Released: March 26, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/)

- Cast font URL functions to `string` for `add_editor_style()`, to avoid PHP warnings on child themes. ([\#59704](https://core.trac.wordpress.org/ticket/59704))
- Add top margin to the File block button styles. ([\#58498](https://core.trac.wordpress.org/ticket/58498))
- Fix typo ([\#60268](https://core.trac.wordpress.org/ticket/60268))

## Version 3.6

Released: November 7, 2023

- Update default themes to use new script function signature: the last parameter of `wp_register_script()` and `wp_enqueue_script()` is an array instead of the boolean `true` ([\#59302](https://core.trac.wordpress.org/ticket/59302))
- Use `defer` loading strategy for theme scripts ([\#59316](https://core.trac.wordpress.org/ticket/59316))

## Version 3.5

Released: August 8, 2023

- Fix Letter Case control implementation on the Button block ([\[55998](https://core.trac.wordpress.org/changeset/55998)\])
- Deprecate the skip link focus fix, switching the enqueue function to just register the script ([\#54421](https://core.trac.wordpress.org/ticket/54421))
- Remove Internet Explorer-specific checks ([\#56699](https://core.trac.wordpress.org/ticket/56699))
- Remove call to `load_theme_textdomain()` function if the WordPress version is at least 4.6 ([\#58318](https://core.trac.wordpress.org/ticket/58318))
- Add “Requires PHP” to readme.txt and “Requires at least” in style.css ([\#57857](https://core.trac.wordpress.org/ticket/57857))

## Version 3.4

Released: March 29, 2023

- Fix Separator block “Dots” style variation ([\#56008](https://core.trac.wordpress.org/ticket/56008))
- Bundle Google Fonts locally ([\#55985](https://core.trac.wordpress.org/ticket/55985))
- Mark strings for screen readers ([\#29748](https://core.trac.wordpress.org/ticket/29748))
- Use the new `/documentation/` URLs for HelpHub links ([\#57726](https://core.trac.wordpress.org/ticket/57726))

## Version 3.3

Released: November 1, 2022

- Button border issue ([\#55006](https://core.trac.wordpress.org/ticket/55006))
- H5 and H6 headings have the same font size ([\#52028](https://core.trac.wordpress.org/ticket/52028))

## Version 3.2

Released: May 24, 2022

- Add gradient background options using the theme color scheme ([\#49760](https://core.trac.wordpress.org/ticket/49760))
- Use #page height instead of body height in sidebar scroll calculation ([\#40492](https://core.trac.wordpress.org/ticket/40492))
- Note visually hidden text for translators ([\#55591](https://core.trac.wordpress.org/ticket/55591))

## Version 3.1

Released: January 25, 2022

- Remove “role” attribute on HTML5 elements with a default landmark role. ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Bundled Themes: Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 3.0

Released: July 20, 2021

- Add Block Patterns ([\#51102](https://core.trac.wordpress.org/ticket/51102))

## Version 2.9

Released: March 9, 2021

- Problem with post metabox styles. ([\#52646](https://core.trac.wordpress.org/ticket/52646))

## Version 2.8

Released: December 8, 2020

- Correct list block alignment in editor styles. ([\#51157](https://core.trac.wordpress.org/ticket/51157))
- Declare support for the html5 feature navigation-widgets. ([\#51445](https://core.trac.wordpress.org/ticket/51445))
- Use correct value for the speak property in various CSS files. ([\#51622](https://core.trac.wordpress.org/ticket/51622))

## Version 2.7

Released: August 11, 2020

- Fixes bulleted list block appearing too far to the left in the editor by removing unnecessary margin rules for bulleted lists in the editor. ([\#50029 ](https://core.trac.wordpress.org/ticket/50029))

## Version 2.6

Released: March 31, 2020

- Update calendar widget styles for 5.4 markup. ([\#49549](https://core.trac.wordpress.org/ticket/49549))

## Version 2.5

Released: May 7, 2019

- Trigger a new `wp_body_open` action immediately after the opening `body` tag, and add shim. ([\#12563](https://core.trac.wordpress.org/ticket/12563), [\#46679](https://core.trac.wordpress.org/ticket/46679))
- Use theme version number when enqueuing styles. ([\#39997](https://core.trac.wordpress.org/ticket/39997))
- Update readme.txt file content to fix validation errors. ([\#45871](https://core.trac.wordpress.org/ticket/45871))
- Update link to child theme and post thumbnail documentation to point to their new locations. ([\#46450](https://core.trac.wordpress.org/ticket/46450), [\#46823](https://core.trac.wordpress.org/ticket/46823))
- Fix typo in theme’s print styles. ([\#46767](https://core.trac.wordpress.org/ticket/46767))
- Fix inconsistent HTML comments after closing HTML tags. ([\#46871](https://core.trac.wordpress.org/ticket/46871))

## Version 2.4

Released: February 21, 2019

- Add escaping to the pingback URL. ([\#43717](https://core.trac.wordpress.org/ticket/43717))

## Version 2.3

Released: January 9, 2019

- Make sure button blocks respect the default rounded style, as well as the squared and outline options. ([\#45541](https://core.trac.wordpress.org/ticket/45541))
- Bump version numbers of updated scripts and stylesheets to prevent caching. ([\#45679](https://core.trac.wordpress.org/ticket/45679))

## Version 2.2

Released: December 19, 2018

- Update styles so button blocks will apply theme’s custom colors. ([\#45428](https://core.trac.wordpress.org/ticket/45428))
- Correct block appender appearance in block editor. ([\#45450](https://core.trac.wordpress.org/ticket/45450))
- Remove the term “Gutenberg” from code comments. ([\#45452](https://core.trac.wordpress.org/ticket/45452))

## Version 2.1

Released: December 6, 2018

- Add front end styles, editor styles and a custom color palette for the new block-based editor. ([\#45043](https://core.trac.wordpress.org/ticket/45043) and [\#45244](https://core.trac.wordpress.org/ticket/45244))
- Add theme support for responsive block embeds. ([\#45274](https://core.trac.wordpress.org/ticket/45274))

## Version 2.0

Released: May 17, 2018

- Code is Poetry. WordPress’ code just… wasn’t. ([\#41057](https://core.trac.wordpress.org/ticket/41057))
- Docs: Remove @summary tags from JSDoc. ([\#42901](https://core.trac.wordpress.org/ticket/42901))
- Add link to privacy policy page in footer. ([\#43715](https://core.trac.wordpress.org/ticket/43715))
- Comments: Move comment consent input outside the label for a11y. ([\#43436](https://core.trac.wordpress.org/ticket/43436))

## Version 1.9

Released: November 14, 2017

- Remove “called called” dittography typo. ([\#41836](https://core.trac.wordpress.org/ticket/41836)), ([\#41841](https://core.trac.wordpress.org/ticket/41841))
- Add missing comma in `ie.css`. ([\#41890](https://core.trac.wordpress.org/ticket/41890))
- Change tag cloud format to a list (ul) for better semantics and accessibility. ([\#40138](https://core.trac.wordpress.org/ticket/40138))
- Add missing singular placeholder in comments.php. ([\#39660](https://core.trac.wordpress.org/ticket/39660))

## Version 1.8

Released: June 8, 2017

- Improve styles for 4.8 widgets. ([\#40745](https://core.trac.wordpress.org/ticket/40745))
- Allow category display in post preview even when only one category ([\#39531](https://core.trac.wordpress.org/ticket/39531))

## Version 1.7

Released: December 6, 2016

- Add documentation to filters in themes. ([\#38382](https://core.trac.wordpress.org/ticket/38382))
- Add preconnect to fonts.gstatic.com. ([\#37171](https://core.trac.wordpress.org/ticket/37171))

## Version 1.6

Released: August 15, 2016

- Remove .pot files from Default Themes. ([\#34884](https://core.trac.wordpress.org/ticket/34884))
- Update theme tags. ([\#37426](https://core.trac.wordpress.org/ticket/37426))

## Version 1.5

Released: April 12, 2016

- Add left margin for lists inside blockquotes in editor-style.css. ([\#33380](https://core.trac.wordpress.org/ticket/33380))
- Use selective refresh to preview changes to site title and tagline in core themes. ([\#27355](https://core.trac.wordpress.org/ticket/27355))
- Prevent elements within fieldsets from overflowing in Webkit. ([\#35421](https://core.trac.wordpress.org/ticket/#35421))
- Add support for site logos. ([\#35944](https://core.trac.wordpress.org/ticket/#35944))
- Fixes insufficient check for existence of DOM elements in jQuery object. ([\#34033](https://core.trac.wordpress.org/ticket/34033))
- Update screenshot to 1200 x 900. ([\#34806](https://core.trac.wordpress.org/ticket/34806))
- Require opt-in for selective refresh of widgets. ([\#27355](https://core.trac.wordpress.org/ticket/27355))

## Version 1.4

Released: December 8, 2015

- Correct license information in readme.txt. ([\#33590](https://core.trac.wordpress.org/ticket/33590))
- Add a missing comma in rtl.css. ([\#33985](https://core.trac.wordpress.org/ticket/33985))
- Document the ‘twentyfifteen\_color\_schemes’ filter. ([\#34119](https://core.trac.wordpress.org/ticket/34119))

## Version 1.3

Released August 18, 2015

- Update readme.txt file. Fix typo in readme file and format the release dates as per other bundled themes readme.txt file format. ([\#31814](https://core.trac.wordpress.org/ticket/31814))
- Add missing social link Genericons styles for Skype and Path. ([\#32332](https://core.trac.wordpress.org/ticket/32332))
- Wrap navigation helpers into a function so it can be called on a refresh event of the Customize Preview. ([\#32576](https://core.trac.wordpress.org/ticket/32576))
- Use https for Google API external libraries. ([\#32552](https://core.trac.wordpress.org/ticket/32552))
- Use default strings and textdomain for comments link. ([\#32001](https://core.trac.wordpress.org/ticket/32001))
- Display sidebar background color with Header Image. ([\#31460](https://core.trac.wordpress.org/ticket/31460))
- Don’t hyphenate input elements. ([\#32880](https://core.trac.wordpress.org/ticket/32880))
- Set the max-width of images in themes to 100%, not in pixels. ([\#33022](https://core.trac.wordpress.org/ticket/33022) and [\#31250](https://core.trac.wordpress.org/ticket/31250))

## Version 1.2

Released May 6, 2015

- Remove Genericons example.html files.

## Version 1.1

Released April 23, 2015

- Keep sub-menus open when visiting sub-menu pages. ([\#30722](https://core.trac.wordpress.org/ticket/30722))
- Use better, universal sans-serif fonts for RTL. ([\#30752](https://core.trac.wordpress.org/ticket/30752))
- Remove URLs from reset credits. ([\#30764](https://core.trac.wordpress.org/ticket/30764))
- Move `js` and `no-js` class name functionality out of header template and into a `wp_head` hook in functions.php file. ([\#30770](https://core.trac.wordpress.org/ticket/30770))
- Remove URLs from reset credits. ([\#30764](https://core.trac.wordpress.org/ticket/30764))
- Add styles for multi-site registration forms. ([\#30776](https://core.trac.wordpress.org/ticket/30776))
- Fix missing style for menu in small screens. ([\#30857](https://core.trac.wordpress.org/ticket/30857))
- Remove border on post navigation when post thumbnail is available. ([\#30918](https://core.trac.wordpress.org/ticket/30918))
- Remove unused CSS rules for `wp_page_menu` since those are not used in the theme. ([\#30957](https://core.trac.wordpress.org/ticket/30957))
- Add print section to the table of contents in the stylesheet. ([\#30993](https://core.trac.wordpress.org/ticket/30993))
- Move RSS icon style rule lower to prevent it from being overridden by other social icon rules. ([\#31129](https://core.trac.wordpress.org/ticket/31129))
- Update editor styles to improve image and caption display in small screens. ([\#31250](https://core.trac.wordpress.org/ticket/31250))
- Add ARIA attributes to menu toggle and add documentation for new onResizeARIA function.([\#31527](https://core.trac.wordpress.org/ticket/31527))
- Use SSL for theme and author URIs. ([\#31699](https://core.trac.wordpress.org/ticket/31699))
- Adjust scroll behavior to include sidebar height in calculation. ([\#31734](https://core.trac.wordpress.org/ticket/31734))
- Add trailing slashes to theme URIs to avoid a redirect. ([\#31839](https://core.trac.wordpress.org/ticket/31839))

## Version 1.0

Released: December 18, 2014

Initial Release.
