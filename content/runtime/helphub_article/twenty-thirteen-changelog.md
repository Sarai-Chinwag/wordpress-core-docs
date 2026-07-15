---
type: document
title: Twenty Thirteen changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-thirteen-changelog/"
tags:
timestamp: "2026-06-16T19:28:16+00:00"
wordpress:
  id: 2141
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:16"
  date_gmt: "2026-06-16 19:28:16"
  modified: "2026-06-16 19:28:16"
  modified_gmt: "2026-06-16 19:28:16"
  slug: twenty-thirteen-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-thirteen-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 4.6

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Remove default `type` attributes from `style` tags because the HTML5 standard does not require them. ([\#64428](https://core.trac.wordpress.org/ticket/64428))
- Consistently escape `get_search_query()` in `search.php` template. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Documentation: Add missing `@return` tags and descriptions. ([\#64277](https://core.trac.wordpress.org/ticket/64277))

## Version 4.5

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Remove code for obsolete browsers, including conditional comments for Internet Explorer and the contents of IE-specific stylesheets and HTML5 Shiv files. ([\#58836](https://core.trac.wordpress.org/ticket/58836))
- Modernize Genericons by removing EOT, TTF, and SVG source references and by removing CSS hacks for Internet Explorer. ([\#62128](https://core.trac.wordpress.org/ticket/62128))
- Change the ‘Older posts’ and ‘Newer posts’ navigation links when the sort order is ascending so the labels accurately reflect the target pages. ([\#10219](https://core.trac.wordpress.org/ticket/10219))
- Prevent output of empty heading and/or link tags if the Site Title or Tagline has no value. ([\#44656](https://core.trac.wordpress.org/ticket/44656))
- Correct `alt` attributes for some images in block patterns. ([\#63264](https://core.trac.wordpress.org/ticket/63264))
- Document the `twentythirteen_credits` action hook. ([\#63648](https://core.trac.wordpress.org/ticket/63648))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))

## Version 4.4

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Move the skip link to the top of the body content, so it is the first focusable item on the page. [\#62968](https://core.trac.wordpress.org/ticket/62968)
- Add `aria-current="page"` on header links that point to the current URL. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Update `.screen-reader-text` class, replacing the obsolete `clip` property with `clip-path`. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Replace references to “Add New” theme screen in `readme` file. [\#61219](https://core.trac.wordpress.org/ticket/61219)
- Correct the border of the Latest Comments block in the editor. [\#62282](https://core.trac.wordpress.org/ticket/62282)

## Version 4.3

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Show the Verse block in the same font family in the editor as it has on the front end. ([\#61140](https://core.trac.wordpress.org/ticket/61140))
- Respect user-defined font size settings in Code blocks. ([\#61697](https://core.trac.wordpress.org/ticket/61697))
- Add missing `initial-scale` value in viewport meta tag. ([\[59026\]](https://core.trac.wordpress.org/changeset/59026))
- Load block patterns on the `init` hook to avoid triggering notices caused by loading the translations too early. ([\#62237](https://core.trac.wordpress.org/ticket/62237))
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 4.2

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/)

- Update Table block font size so it inherits any custom size set on the block. ([\#56204](https://core.trac.wordpress.org/ticket/56204))
- Remove empty spaces at the ends of lines in CSS. ([\#53874](https://core.trac.wordpress.org/ticket/53874))
- Update HelpHub link for post format documentation to avoid unnecessary redirections. ([\[57800\]](https://core.trac.wordpress.org/changeset/57800/))

## Version 4.1

Released: April 2nd, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/)

- Cast font URL functions to `string` for `add_editor_style()`, to avoid PHP warnings on child themes. ([\#59704](https://core.trac.wordpress.org/ticket/59704))

## Version 4.0

Released: November 7, 2023

- Use default display for `summary` element within a Details block, to ensure the toggle icon appears ([\#58915](https://core.trac.wordpress.org/ticket/58915))
- Update default themes to use new script function signature: the last parameter of `wp_enqueue_script()` is an array instead of the boolean `true` ([\#59302](https://core.trac.wordpress.org/ticket/59302))
- Use `defer` loading strategy for theme scripts ([\#59316](https://core.trac.wordpress.org/ticket/59316))

## Version 3.9

Released: August 8, 2023

- Remove an unnecessary bottom border from the Table block ([\#56538](https://core.trac.wordpress.org/ticket/56538))
- Deprecate the skip link focus fix, removing the script from the functions.js file ([\#54421](https://core.trac.wordpress.org/ticket/54421))
- Remove Internet Explorer-specific checks ([\#56699](https://core.trac.wordpress.org/ticket/56699))
- Remove call to `load_theme_textdomain()` function if the WordPress version is at least 4.6 ([\#58318](https://core.trac.wordpress.org/ticket/58318))
- Add “Requires at least” and “Requires PHP” to readme.txt ([\#57857](https://core.trac.wordpress.org/ticket/57857))

## Version 3.8

Released: March 29, 2023

- Improve various globals documentation, as per docblock standards ([\#57069](https://core.trac.wordpress.org/ticket/57069))
- Remove title attributes ([\#57199](https://core.trac.wordpress.org/ticket/57199))
- Fix Separator block “Dots” style variation ([\#56008](https://core.trac.wordpress.org/ticket/56008))
- Bundle Google Fonts locally ([\#55985](https://core.trac.wordpress.org/ticket/55985))
- Mark strings for screen readers ([\#29748](https://core.trac.wordpress.org/ticket/29748))
- Use the new `/documentation/` URLs for HelpHub links ([\#57726](https://core.trac.wordpress.org/ticket/57726))
- Use strict comparison in bundled themes’ PHP files. ([\[55420](https://core.trac.wordpress.org/changeset/55420)\])
- Improve various globals documentation, as per docblock standards ([\#57069](https://core.trac.wordpress.org/ticket/57069))

## Version 3.7

Released: November 1, 2022

- Multiple Themes: Correctly escape stylesheet URL ([\#56696](https://core.trac.wordpress.org/ticket/56695))

## Version 3.6

Released: May 24, 2022

- Add gradient background options using the theme color scheme ([\#49762](https://core.trac.wordpress.org/ticket/49762))
- Define List item separator as a WP\_Locale property ([\#39733](https://core.trac.wordpress.org/ticket/39733))
- Rename parameters that use reserved keywords in bundled themes ([\#55327](https://core.trac.wordpress.org/ticket/55327))
- Note visually hidden text for translators ([\#55591](https://core.trac.wordpress.org/ticket/55591))

## Version 3.5

Released: January 25, 2022

- Remove “role” attribute on HTML5 elements with a default landmark role. ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Bundled Themes: Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 3.4

Released: July 20, 2021

- Add Block Patterns. ([\#51104](https://core.trac.wordpress.org/ticket/51104))
- Add “No Shadow” style to button block. ([\#51223](https://core.trac.wordpress.org/ticket/51223))
- Improve display of blocks in widget areas. ([\#53422](https://core.trac.wordpress.org/ticket/53422))
- Improve the display of the Query Loop block. ([\#53438](https://core.trac.wordpress.org/ticket/53438))

## Version 3.3

Released: March 9, 2021

- Core blocks are positioned incorrectly in some core bundled themes. ([\#52009](https://core.trac.wordpress.org/ticket/52009))
- Cover block alignment issues. ([\#51224](https://core.trac.wordpress.org/ticket/51224))

## Version 3.2

Released: December 8, 2020

- Prevent incorrect link color within the Social Icon block. ([\#50809](https://core.trac.wordpress.org/ticket/50809))
- Correct alignment of blocks inside a full-width or wide-width group block. ([\#51440](https://core.trac.wordpress.org/ticket/51440))
- For image attachments, replace the text “Return to” with “Go to”. ([\#47235](https://core.trac.wordpress.org/ticket/47235))
- Correct list block alignment in editor styles. ([\#51157](https://core.trac.wordpress.org/ticket/51157))
- Declare support for the HTML5 feature navigation-widgets. ([\#51445](https://core.trac.wordpress.org/ticket/51445))

## Version 3.1

Released: August 11, 2020

- Add custom color palettes for block editor. ([\#50120](https://core.trac.wordpress.org/ticket/50120))
- Use HTTPS for XHTML Friends Network URL. ([\#48002](https://core.trac.wordpress.org/ticket/48002))
- Consistently check for WP\_Error before outputting get\_the\_tag\_list(). ([\#39860](https://core.trac.wordpress.org/ticket/39860))
- Use strict type check for in\_array() and array\_search() where strings are involved. ([\#49542](https://core.trac.wordpress.org/ticket/49542))

## Version 3.0

Released: March 31, 2020

- Update calendar widget styles for 5.4 markup. ([\#49546](https://core.trac.wordpress.org/ticket/49546))

## Version 2.9

Released: May 7, 2019

- Trigger a new `wp_body_open` action immediately after the opening `body` tag, and add shim. ([\#12563](https://core.trac.wordpress.org/ticket/12563), [\#46679](https://core.trac.wordpress.org/ticket/46679))
- Use theme version number when enqueuing styles, and correct Genericons stylesheet version number. ([\#39997](https://core.trac.wordpress.org/ticket/39997))
- Update readme.txt file content to fix validation errors. ([\#45871](https://core.trac.wordpress.org/ticket/45871))
- Update link to child theme documentation to point to its new locations. ([\#46450](https://core.trac.wordpress.org/ticket/46450))

## Version 2.8

Released: February 21, 2019

- Add escaping to the pingback URL. ([\#43717](https://core.trac.wordpress.org/ticket/43717))

## Version 2.7

Released: January 9, 2019

- Make sure button blocks respect the default rounded style, as well as the squared and outline options. ([\#45541](https://core.trac.wordpress.org/ticket/45541))
- Bump version numbers of updated scripts and stylesheets to prevent caching. ([\#45679](https://core.trac.wordpress.org/ticket/45679))

## Version 2.6

Released: December 19, 2018

- Update styles so button blocks will apply theme’s custom colors. ([\#45431](https://core.trac.wordpress.org/ticket/45431))
- Correct block appender appearance in block editor. ([\#45450](https://core.trac.wordpress.org/ticket/45450))
- Remove the term “Gutenberg” from code comments. ([\#45452](https://core.trac.wordpress.org/ticket/45452))

## Version 2.5

Released: December 6, 2018

- Add front end styles, editor styles and a custom color palette for the new block-based editor. Also add support and styles for wide block alignments. ([\#45041](https://core.trac.wordpress.org/ticket/45041) and [\#45242](https://core.trac.wordpress.org/ticket/45242))
- Add theme support for responsive block embeds. ([\#45274](https://core.trac.wordpress.org/ticket/45274))

## Version 2.4

Released: May 17, 2018

- Code is Poetry. WordPress’ code just… wasn’t. ([\#41057](https://core.trac.wordpress.org/ticket/41057))
- Docs: Remove @summary tags from JSDoc. ([\#42901](https://core.trac.wordpress.org/ticket/42901))
- Add link to privacy policy page in footer. ([\#43715](https://core.trac.wordpress.org/ticket/43715))
- Comments: Move comment consent input outside the label for a11y. ([\#43436](https://core.trac.wordpress.org/ticket/43436))

## Version 2.3

Released: November 14, 2017

- Change tag cloud format to a list (ul) for better semantics and accessibility. ([\#40138](https://core.trac.wordpress.org/ticket/40138))
- Make sure new gallery widgets look good in themes. ([\#41969](https://core.trac.wordpress.org/ticket/41969))

## Version 2.2

Released: June 8, 2017

- Improve styles for 4.8 widgets. ([\#40745](https://core.trac.wordpress.org/ticket/40745))

## Version 2.1

Released: December 6, 2016

- Add preconnect to fonts.gstatic.com. ([\#37171](https://core.trac.wordpress.org/ticket/37171))

## Version 2.0

Released August 15, 2016

- Remove .pot files from Default Themes. ([\#34884](https://core.trac.wordpress.org/ticket/34884))
- Fix selective refresh of Masonry-laid out widgets by deferring initialization until DOM ready. ([\#37390](https://core.trac.wordpress.org/ticket/37390))
- Fix PHP 7 compatibility issues. ([\#37227](https://core.trac.wordpress.org/ticket/37227))
- Update theme tags. ([\#37426](https://core.trac.wordpress.org/ticket/37426))

## Version 1.9

Released April 12, 2016

- Add selective refresh framework with implementation for widgets and re-implementation for nav menus. ([\#27355](https://core.trac.wordpress.org/ticket/27355))
- Standardize on “front end”/”back end” (noun) and “front-end”/”back-end”. ([\#34887](https://core.trac.wordpress.org/ticket/34887))
- Use selective refresh to preview changes to site title and tagline in core themes. ([\#27355](https://core.trac.wordpress.org/ticket/27355))
- Prevent elements within fieldsets from overflowing in Webkit. ([\#35421](https://core.trac.wordpress.org/ticket/#35421))
- Removes title attribute from footer. ([\#35843 ](https://core.trac.wordpress.org/ticket/35843))
- Fixes insufficient check for existence of DOM elements in jQuery object. ([\#34033](https://core.trac.wordpress.org/ticket/34033))
- Update screenshot to 1200 x 900. ([\#34806](https://core.trac.wordpress.org/ticket/34806))
- Require opt-in for selective refresh of widgets. ([\#27355](https://core.trac.wordpress.org/ticket/27355))

## Version 1.8

Released January 6, 2016

- Add missing loop to image.php template. ([\#35110](https://core.trac.wordpress.org/ticket/35110))

## Version 1.7

Released December 8, 2015

- Correct license information in readme.txt. ([\#33590](https://core.trac.wordpress.org/ticket/33590))

## Version 1.6

Released August 18, 2015

- Add readme file to explain basic theme usage, link to changelog in Codex, and include license information. ([\#31814](https://core.trac.wordpress.org/ticket/31814))
- Use https for Google API external libraries. ([\#32552](https://core.trac.wordpress.org/ticket/32552))
- Set the max-width of images in themes to 100%, not in pixels. ([\#33022](https://core.trac.wordpress.org/ticket/33022) and [\#31250](https://core.trac.wordpress.org/ticket/31250))
- Fixed: Remove Genericons example.html files.

## Version 1.5

Released April 23, 2015

- Fix escaping and minor code style issues ([\#29127](https://core.trac.wordpress.org/ticket/29127))
- Update editor styles to improve image and caption display in small screens ([\#31250](https://core.trac.wordpress.org/ticket/31250))
- Replace current() with reset(), which is guaranteed to be the first item ([\#31259](https://core.trac.wordpress.org/ticket/31259), [\#31260](https://core.trac.wordpress.org/ticket/31260))
- Update CSS rules for `.screen-reader-text` to be consistent with current accessibility guidelines ([\#31279](https://core.trac.wordpress.org/ticket/31279))
- Add ARIA attributes to menu toggle and add documentation for new `onResizeARIA` function ([\#31527](https://core.trac.wordpress.org/ticket/31527))
- Use SSL for theme and author URIs ([\#31699](https://core.trac.wordpress.org/ticket/31699))
- Make sure submenu links work correctly on small screens with touch events ([\#31762](https://core.trac.wordpress.org/ticket/31762))
- Add trailing slashes to theme URIs to avoid a redirect ([\#31839](https://core.trac.wordpress.org/ticket/31839))

## Version 1.4

Released: December 18, 2014

- Move the “Continue Reading” arrows back inside the translatable strings so they can be localised. ([\#30641](https://core.trac.wordpress.org/ticket/30641))
- Use proper way to get customizer settings values. ([\#29577](https://core.trac.wordpress.org/ticket/29577))
- Replace ellipses appended to automatically generated excerpts with both ellipses and a “Continue Reading” link to meet accessibility-ready requirements. ([\#30178](https://core.trac.wordpress.org/ticket/30178))
- Fix non-responsive layout in IE8. ([\#24194](https://core.trac.wordpress.org/ticket/24194))
- Add bottom margin to audio and video players. ([\#29146](https://core.trac.wordpress.org/ticket/29146))
- Improve keyboard accessibility on Custom Header and Custom Background screen. ([\#29289](https://core.trac.wordpress.org/ticket/29289))
- Change instances of “Theme Customizer” to just “Customizer”, as the Customizer isn’t necessarily theme-specific. ([\#29947](https://core.trac.wordpress.org/ticket/29947))
- Use HTTPS URLs for core.trac.wordpress.org. ([\#27115](https://core.trac.wordpress.org/ticket/27115))
- Prevent the arrow in “Continue reading” links from wrapping to a second line. ([\#27908](https://core.trac.wordpress.org/ticket/27908))

## Version 1.3

Released: September 4, 2014

- Make small-screen menu accessible to keyboard commands and voice-driven software by using a focusable `button` element rather than `h3` for the toggle element. ([\#28293](https://core.trac.wordpress.org/ticket/28293))
- Adjust background size of header image(s) for small devices. ([\#26856](https://core.trac.wordpress.org/ticket/26856))
- Make submenu links work correctly on tablets. ([\#24767](https://core.trac.wordpress.org/ticket/24767))
- Update to Genericons 3.0.3. ([\#25391](https://core.trac.wordpress.org/ticket/25391))
- Fix layout issue with search form in older versions of Safari and Android. ([\#24192](https://core.trac.wordpress.org/ticket/24192))
- Add `accessibility-ready` tag. ([\#28225](https://core.trac.wordpress.org/ticket/28225))

## Version 1.2

Released: May 8, 2014

- Use correct logic in IE conditional comments in header template. ([\#28151](https://core.trac.wordpress.org/ticket/28151))
- Prevent ‘Page %s’ from being added to page title on 404 error pages in bundled themes. ([\#16468](https://core.trac.wordpress.org/ticket/16468))
- Style to support the new HTML5 line-break-less galleries. ([\#27637](https://core.trac.wordpress.org/ticket/27637))
- Implement HTML5 markup for galleries and captions. ([\#27502](https://core.trac.wordpress.org/ticket/27502))
- Add Audio, Video, and Gallery Styles to editor styles. ([\#27462](https://core.trac.wordpress.org/ticket/27462))
- On attachment pages for audio and video, display players. Currently, only a link is displayed. Add minimal CSS rules for compatibility. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- In `prepend_attachment`, add logic to support attachment types that are not `image`. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- In `get_post_class()`, don’t add the `has-post-thumbnail` class for attachment pages. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- Improve menu navigation for keyboard and voice-over interactions by properly focusing on submenu items when they are open. ([\#24839](https://core.trac.wordpress.org/ticket/24839))
- Remove doc block comments for `@return void`. ([\#27098](https://core.trac.wordpress.org/ticket/27098))
- Don’t print the featured image when viewing an attachment. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- Update the HTML5 Shiv across the default themes to 3.7.0. ([\#26491](https://core.trac.wordpress.org/ticket/26491))
- Use the ‘display’ filter for get\_bloginfo( ‘name’ ) attached to the wp\_title filter. ([\#26811](https://core.trac.wordpress.org/ticket/26811))
- New screenshots at 880×660 to maximize theme goodness in the new theme viewer design. ([\#26159](https://core.trac.wordpress.org/ticket/26159))
- Add and display new tags to highlight the ever-growing number of responsive themes available. ([\#21442](https://core.trac.wordpress.org/ticket/21442))
- Implement Microsoft-specific `@viewport` rules for better responsive styling in Windows 8 “snapped” views. ([\#25888](https://core.trac.wordpress.org/ticket/25888))
- Capitalize “Not Found” string for use in a page title. ([\#24891](https://core.trac.wordpress.org/ticket/24891), [r25907](https://core.trac.wordpress.org/changeset/25907))

## Version 1.1

Released: October 24, 2013

- Translator comments are special, make sure they are parsed properly. ([\#25256](https://core.trac.wordpress.org/ticket/25256))
- Restore the original “Not found” string. ([\#24891](https://core.trac.wordpress.org/ticket/24891))
- Fix description layout on attachment outputs. ([\#25578](https://core.trac.wordpress.org/ticket/25578))
- Use correct font name in comment docs. ([\#25593](https://core.trac.wordpress.org/ticket/25593))
- Don’t use `/**` docblocks for simple multiline comments. ([\#25256](https://core.trac.wordpress.org/ticket/25256))
- Remove unneeded .single-attachment selector. ([\#25506](https://core.trac.wordpress.org/ticket/25506))
- Update code comments to reflect WP inline docs standards. ([\#25256](https://core.trac.wordpress.org/ticket/25256))
- Fix case where comment layout can break if a really, really long word is in the comment content. ([\#25195](https://core.trac.wordpress.org/ticket/25195))
- Revert combining two similar ‘Nothing Found’ strings. ([\#24891](https://core.trac.wordpress.org/ticket/24891))
- Ensure custom headers are set up after the localization is initialized. ([\#24943](https://core.trac.wordpress.org/ticket/24943))

## Version 1.0

Released: August 1, 2013

Initial release.
