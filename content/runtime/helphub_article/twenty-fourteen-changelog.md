---
type: document
title: Twenty Fourteen changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-fourteen-changelog/"
tags:
timestamp: "2026-06-16T19:28:16+00:00"
wordpress:
  id: 2140
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:16"
  date_gmt: "2026-06-16 19:28:16"
  modified: "2026-06-16 19:28:16"
  modified_gmt: "2026-06-16 19:28:16"
  slug: twenty-fourteen-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-fourteen-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 4.5

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Remove default `type` attributes from `style` tags because the HTML5 standard does not require them. ([\#64428](https://core.trac.wordpress.org/ticket/64428))
- Consistently escape `get_search_query()` in `search.php` template. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Documentation: Fix `@return` type in `Featured_Content::pre_get_posts()`. ([\[61676\]](https://core.trac.wordpress.org/changeset/61676))
- Documentation: Add missing `@return` tags and descriptions. ([\#64277](https://core.trac.wordpress.org/ticket/64277))

## Version 4.4

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Remove code for obsolete browsers, including conditional comments for Internet Explorer and the contents of IE-specific stylesheets and HTML5 Shiv files. ([\#58836](https://core.trac.wordpress.org/ticket/58836))
- Modernize Genericons by removing EOT, TTF, and SVG source references and by removing CSS hacks for Internet Explorer. ([\#62128](https://core.trac.wordpress.org/ticket/62128))
- Prevent output of empty heading and/or link tags if the Site Title or Tagline has no value. ([\#44656](https://core.trac.wordpress.org/ticket/44656))
- Use correct escaping function for `alt` attributes in block patterns. ([\#63264](https://core.trac.wordpress.org/ticket/63264))
- Document the `twentyfourteen_credits` action hook. ([\#63648](https://core.trac.wordpress.org/ticket/63648))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))

## Version 4.3

Released: August 5, 2025

- Fix link color for Latest Comments blocks when added in the Content Sidebar. [\#63520](https://core.trac.wordpress.org/ticket/63520)

## Version 4.2

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Move the skip link to the top of the body content, so it is the first focusable item on the page. [\#62969](https://core.trac.wordpress.org/ticket/62969)
- Add `aria-current="page"` on header links that point to the current URL. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Prevent a fatal error occurring with paginated navigation. [\#62972](https://core.trac.wordpress.org/ticket/62972)
- Update `.screen-reader-text` class, replacing the obsolete `clip` property with `clip-path`. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Replace references to “Add New” theme screen in `readme` file. [\#61219](https://core.trac.wordpress.org/ticket/61219)

## Version 4.1

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Update border styles for Table blocks plus editor styles for figure captions, including `font-weight` and alignment. ([\#61563](https://core.trac.wordpress.org/ticket/61563))
- Show the Verse block in the same font family in the editor as it has on the front end. ([\#61140](https://core.trac.wordpress.org/ticket/61140))
- Add missing `initial-scale` value in viewport meta tag. ([\[59026\]](https://core.trac.wordpress.org/changeset/59026))
- Adjust comment spacing and punctuation to meet coding standards. ([\#62098](https://core.trac.wordpress.org/ticket/62098))
- Document the `$args` parameter in `Featured_Content::hide_featured_term()`. ([\[59210\]](https://core.trac.wordpress.org/changeset/59210))
- Load block patterns on the `init` hook to avoid triggering notices caused by loading the translations too early. ([\#62237](https://core.trac.wordpress.org/ticket/62237))
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 4.0

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/)

- Use `underline` as the text decoration for post content links within the editor so the style matches the front. ([\#61441](https://core.trac.wordpress.org/ticket/61441))
- Fix Table block border colors when a user selects a different color for the block. ([\#60293](https://core.trac.wordpress.org/ticket/60293))
- Support custom font sizes in the Pullquote block, but keep the same base font size when users do not change it. ([\#59800](https://core.trac.wordpress.org/ticket/59800), [\#61034](https://core.trac.wordpress.org/ticket/61034))
- Fix missing Search block border with the “Button inside” option. ([\#60164](https://core.trac.wordpress.org/ticket/60164))
- Remove blank CSS lines. ([\#59493](https://core.trac.wordpress.org/ticket/59493))
- Fix a typo in documentation for the `Featured_Content` class. ([\[57987\]](https://core.trac.wordpress.org/changeset/57987/trunk/src/wp-content/themes/twentyfourteen))
- Update HelpHub link for post format documentation to avoid unnecessary redirections. ([\[57800\]](https://core.trac.wordpress.org/changeset/57800/))

## Version 3.9

Released: April 2nd, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/)

- Cast font URL functions to `string` for `add_editor_style()`, to avoid PHP warnings on child themes. ([\#59704](https://core.trac.wordpress.org/ticket/59704))

## Version 3.8

Released: November 7, 2023

- Implement `the_header_image_tag` function for enhanced compatibility with new image features such as lazy loading, async decoding and fetch priority ([\#58675](https://core.trac.wordpress.org/ticket/58675))
- Update default themes to use new script function signature: the last parameter of `wp_enqueue_script()` is an array instead of the boolean `true` ([\#59302](https://core.trac.wordpress.org/ticket/59302))
- Use `defer` loading strategy for theme scripts ([\#59316](https://core.trac.wordpress.org/ticket/59316))

## Version 3.7

Released: August 8, 2023

- Fix Button block `line-height` by replacing pixel measurements with unitless relative measurements ([\#58444](https://core.trac.wordpress.org/ticket/58444))
- Fix the text color of default Button block links located on sidebars or widgets when hovering over them ([\#58509](https://core.trac.wordpress.org/ticket/58509))
- Fix Letter Case control implementation on the Button block ([\[55997](https://core.trac.wordpress.org/changeset/55997)\])
- Deprecate the skip link focus fix, removing the script from the `functions.js` file ([\#54421](https://core.trac.wordpress.org/ticket/54421))
- Remove call to `load_theme_textdomain()` function if the WordPress version is at least 4.6 ([\#58318](https://core.trac.wordpress.org/ticket/58318))
- Add “Requires PHP” to readme.txt and “Requires at least” in style.css ([\#57857](https://core.trac.wordpress.org/ticket/57857))

## Version 3.6

Released: March 29, 2023

- Fix Separator block “Dots” style variation ([\#56008](https://core.trac.wordpress.org/ticket/56008))
- Text color not reflected in Editor and front in Pullquote block ([\#56006](https://core.trac.wordpress.org/ticket/56006))
- Bundle Google Fonts locally ([\#55985](https://core.trac.wordpress.org/ticket/55985))
- Mark strings for screen readers ([\#29748](https://core.trac.wordpress.org/ticket/29748))
- Use the new `/documentation/` URLs for HelpHub links ([\#57726](https://core.trac.wordpress.org/ticket/57726))
- Use strict comparison in bundled themes’ PHP files. ([\[55420](https://core.trac.wordpress.org/changeset/55420)\])
- Improve various globals documentation, as per docblock standards ([\#57069](https://core.trac.wordpress.org/ticket/57069))

## Version 3.5

Released: November 1, 2022

- Multiple Themes: Correctly escape stylesheet URL ([\#56696](https://core.trac.wordpress.org/ticket/56695))

## Version 3.4

Released: May 24, 2022

- Note visually hidden text for translators ([\#55591](https://core.trac.wordpress.org/ticket/55591))

## Version 3.3

Released: January 25, 2022

- Remove “role” attribute on HTML5 elements with a default landmark role. ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Bundled themes patterns: remove unwanted trailing spaces from translated strings ([\#53774](https://core.trac.wordpress.org/ticket/53774))
- Bundled Themes: Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 3.2

Released: July 20, 2021

- Introduce block patterns for Twenty Fourteen. ([\#51103](https://core.trac.wordpress.org/ticket/51103))
- Improve display of blocks in widget areas. ([\#53422](https://core.trac.wordpress.org/ticket/53422))

## Version 3.1

Released: March 9, 2021

- Core blocks are positioned incorrectly in some core bundled themes. ([\#52009](https://core.trac.wordpress.org/ticket/52009))
- Add support for the font size option for the code block. ([\#52431](https://core.trac.wordpress.org/ticket/52431))

## Version 3.0

Released: December 8, 2020

- Correct list block alignment in editor styles. ([\#51157](https://core.trac.wordpress.org/ticket/51157))
- Declare support for the html5 feature navigation-widgets. ([\#51445](https://core.trac.wordpress.org/ticket/51445))

## Version 2.9

Released: August 11, 2020

- Add custom color palettes for block editor. ([\#50120](https://core.trac.wordpress.org/ticket/50120))
- Use HTTPS for XHTML Friends Network URL. ([\#48002](https://core.trac.wordpress.org/ticket/48002))
- Remove “whitelist” and “blacklist” in favor of more clear and inclusive language. ([\#50413](https://core.trac.wordpress.org/ticket/50413))
- Capitalize “ID”, when referring to a post ID, term ID, etc. in a more consistent way. ([\#49572](https://core.trac.wordpress.org/ticket/49572))
- Use strict type check for in\_array() and array\_search() where strings are involved. ([\#49542](https://core.trac.wordpress.org/ticket/49542))

## Version 2.8

Released: March 31, 2020

- Update calendar widget styles for 5.4 markup. ([\#49549](https://core.trac.wordpress.org/ticket/49549))

## Version 2.7

Released: May 7, 2019

- Trigger a new `wp_body_open` action immediately after the opening `body` tag, and add shim. ([\#12563](https://core.trac.wordpress.org/ticket/12563), [\#46679](https://core.trac.wordpress.org/ticket/46679))
- Use theme version number when enqueuing styles. ([\#39997](https://core.trac.wordpress.org/ticket/39997))
- Update readme.txt file content to fix validation errors. ([\#45871](https://core.trac.wordpress.org/ticket/45871))
- Update link to child theme documentation to point to its new locations. ([\#46450](https://core.trac.wordpress.org/ticket/46450))
- Fix inconsistent HTML comments after closing HTML tags. ([\#46871](https://core.trac.wordpress.org/ticket/))

## Version 2.6

Released: February 21, 2019

- Add escaping to the pingback URL. ([\#43717](https://core.trac.wordpress.org/ticket/43717))

## Version 2.5

Released: January 9, 2019

- Fix video play icon alignment. ([\#44664](https://core.trac.wordpress.org/ticket/44664))
- Make sure button blocks respect the default rounded style, as well as the squared and outline options. ([\#45541](https://core.trac.wordpress.org/ticket/45541))
- Remove text underline from button blocks. ([\#45732](https://core.trac.wordpress.org/ticket/45732))
- Bump version numbers of updated scripts and stylesheets to prevent caching. ([\#45679](https://core.trac.wordpress.org/ticket/45679))

## Version 2.4

Released: December 19, 2018

- Update styles so button blocks will apply theme’s custom colors. ([\#45429](https://core.trac.wordpress.org/ticket/45429))
- Correct block appender appearance in block editor. ([\#45450](https://core.trac.wordpress.org/ticket/45450))
- Remove the term “Gutenberg” from code comments. ([\#45452](https://core.trac.wordpress.org/ticket/45452))

## Version 2.3

Released: December 6, 2018

- Add front end styles, editor styles and a custom color palette for the new block-based editor. ([\#45042](https://core.trac.wordpress.org/ticket/45042) and [\#45243](https://core.trac.wordpress.org/ticket/45243))
- Add theme support for responsive block embeds. ([\#45274](https://core.trac.wordpress.org/ticket/45274))

## Version 2.2

Released: May 17, 2018

- Code is Poetry. WordPress’ code just… wasn’t. ([\#41057](https://core.trac.wordpress.org/ticket/41057))
- Docs: Remove @summary tags from JSDoc. ([\#42901](https://core.trac.wordpress.org/ticket/42901))
- Twenty Fourteen: Remove redundant @access and @static notations from classes. ([\#41452](https://core.trac.wordpress.org/ticket/41452)), ([\#42803](https://core.trac.wordpress.org/ticket/42803)), ([\#42505](https://core.trac.wordpress.org/ticket/42505))
- Add link to privacy policy page in footer. ([\#43715](https://core.trac.wordpress.org/ticket/43715))
- Comments: Move comment consent input outside the label for a11y. ([\#43436](https://core.trac.wordpress.org/ticket/43436))

## Version 2.1

Released: November 14, 2017

- Upgrade MediaElement.js from 2.22.0 to 4.2.3. ([\#39686](https://core.trac.wordpress.org/ticket/39686))
- Remove “called called” and “can can” dittography. ([\#41836](https://core.trac.wordpress.org/ticket/41836))
- Upgrade MediaElement.js from 2.22.0 to 4.2.3. ([\#39686](https://core.trac.wordpress.org/ticket/39686))
- Change tag cloud format to a list (ul) for better semantics and accessibility. ([\#40138](https://core.trac.wordpress.org/ticket/40138))
- Add missing singular placeholder in comments.php. ([\#39660](https://core.trac.wordpress.org/ticket/39660))
- Make sure new gallery widgets look good in themes. ([\#41969](https://core.trac.wordpress.org/ticket/41969))

## Version 2.0

Released: June 8, 2017

- Improve styles for 4.8 widgets. ([\#40745](https://core.trac.wordpress.org/ticket/40745))
- Allow category display in post preview even when only one category. ([\#39531](https://core.trac.wordpress.org/ticket/39531))
- Fix fatal errors in WordPress versions before 4.0.0. ([\#39407](https://core.trac.wordpress.org/ticket/39407))

## Version 1.9

Released: December 6, 2016

- Add preconnect to fonts.gstatic.com. ([\#37171](https://core.trac.wordpress.org/ticket/37171))
- Adds new styles to help positioning of Customizer edit shortcuts. ([\#27403](https://core.trac.wordpress.org/ticket/27403)), ([\#38651](https://core.trac.wordpress.org/ticket/38651))

## Version 1.8

Released: August 15, 2016

- Remove .pot files from Default Themes. ([\#34884](https://core.trac.wordpress.org/ticket/34884))
- Fix PHP 7 compatibility issues. ([\#37227](https://core.trac.wordpress.org/ticket/37227))
- Update theme tags. ([\#37426](https://core.trac.wordpress.org/ticket/37426))

## Version 1.7

Released: April 12, 2016

- Standardize on “front end”/”back end” (noun) and “front-end”/”back-end”. ([\#34887](https://core.trac.wordpress.org/ticket/34887))
- Use selective refresh to preview changes to site title and tagline in core themes. ([\#27355](https://core.trac.wordpress.org/ticket/27355))
- Prevent elements within fieldsets from overflowing in Webkit. ([\#35421](https://core.trac.wordpress.org/ticket/#35421))
- Fixes insufficient check for existence of DOM elements in jQuery object. ([\#34033](https://core.trac.wordpress.org/ticket/34033))
- Update screenshot to 1200 x 900. ([\#34806](https://core.trac.wordpress.org/ticket/34806))
- Require opt-in for selective refresh of widgets. ([\#27355](https://core.trac.wordpress.org/ticket/27355))

## Version 1.6

Released: December 8, 2015

- Correct license information in readme.txt. ([\#33590](https://core.trac.wordpress.org/ticket/33590))

## Version 1.5

Released August 18, 2015

- Add readme file to explain basic theme usage, link to changelog in Codex, and include license information. ([\#31814](https://core.trac.wordpress.org/ticket/31814))
- Use https for Google API external libraries. ([\#32552](https://core.trac.wordpress.org/ticket/32552))
- Set the max-width of images in themes to 100%, not in pixels. ([\#33022](https://core.trac.wordpress.org/ticket/33022) and [\#31250](https://core.trac.wordpress.org/ticket/31250))
- Fixed: Remove Genericons example.html files.

## Version 1.4

Released April 23, 2015

- Fix escaping and minor code style issues. ([\#29127](https://core.trac.wordpress.org/ticket/))
- Remove URLs from reset credits. ([\#30764](https://core.trac.wordpress.org/ticket/))
- Update editor styles to improve image and caption display in small screens. ([\#31250](https://core.trac.wordpress.org/ticket/31250))
- Replace current() with reset(), which is guaranteed to be the first item. ([\#31259](https://core.trac.wordpress.org/ticket/31259)), [\#31260](https://core.trac.wordpress.org/ticket/31260))
- Update CSS rules for `.screen-reader-text` to be consistent with current accessibility guidelines. ( [\#31279](https://core.trac.wordpress.org/ticket/31279))
- Make twentyfourteen\_post\_thumbnail() pluggable and document the feature. ([\#31374](https://core.trac.wordpress.org/ticket/31374))
- Add ARIA attributes to menu toggle and add documentation for new `onResizeARIA` function. ([\#31527](https://core.trac.wordpress.org/ticket/31527))

## Version 1.3

Released: December 18, 2014

- Remove Genericons as a dependency from loading the main stylesheet and IE-specific stylesheet. ([\#30532](https://core.trac.wordpress.org/ticket/30532))
- Move the “Continue Reading” arrows back inside the translatable strings so they can be localised. ([\#30641](https://core.trac.wordpress.org/ticket/30641))
- Replace ellipses appended to automatically generated excerpts with both ellipses and a “Continue Reading” link to meet accessibility-ready requirements. ([\#30176](https://core.trac.wordpress.org/ticket/30176))
- Add aria-hidden attribute to reduce verbosity on archive pages. ([\#30144](https://core.trac.wordpress.org/ticket/30144))
- Add alt text in archives to avoid confusing link texts. ([\#30144](https://core.trac.wordpress.org/ticket/30144))
- Update table styles in editor CSS file for new TinyMCE class names. ([\#28703](https://core.trac.wordpress.org/ticket/28703))
- Fix keyboard focus on Appearance &gt; Header view. ([\#29787](https://core.trac.wordpress.org/ticket/29787))
- Make featured content in Customizer contextual to the front page. ([\#29578](https://core.trac.wordpress.org/ticket/29578))
- Change instances of “Theme Customizer” to just “Customizer”, as the Customizer isn’t necessarily theme-specific. ([\#29947](https://core.trac.wordpress.org/ticket/29947))
- Add an alt attribute with the site title for header images linked to the home page. ([\#15926](https://core.trac.wordpress.org/ticket/15926))
- Move custom description for background color and image from sections to controls in the customizer. ([\#29490](https://core.trac.wordpress.org/ticket/29490))
- Use HTTPS URLs for core.trac.wordpress.org. ([\#27115](https://core.trac.wordpress.org/ticket/27115))
- Include Latin Extended font subset for Lato. ([\#29690](https://core.trac.wordpress.org/ticket/29690))
- Prevent the arrow in “Continue reading” links from wrapping to a second line. ([\#27908](https://core.trac.wordpress.org/ticket/27908))
- Use correct check for the front page in Featured\_Content::pre\_get\_posts(). ([\#29550](https://core.trac.wordpress.org/ticket/29550))

## Version 1.2

Released: September 4, 2014

- Remove unused variable. ([\#28928](https://core.trac.wordpress.org/ticket/))
- Optimize featured content lookup to reduce the number of queries for featured posts. ([\#26744](https://core.trac.wordpress.org/ticket/26744))
- Improve styles for media “play” button. ([\#26469](https://core.trac.wordpress.org/ticket/26469))
- RTL display adjustment for Custom Header. ([\#28670](https://core.trac.wordpress.org/ticket/28670))
- Fix a display issue in screen sizes over 846 pixels where a post’s featured image covers the post meta of the post above. ([\#28649](https://core.trac.wordpress.org/ticket/28649))
- Fix header display on multisite signup and activate views. ([\#28573](https://core.trac.wordpress.org/ticket/28573))
- More graceful handling of super-long site titles in small screens: add an ellipsis and adjust `max-width` more carefully. ([\#28237](https://core.trac.wordpress.org/ticket/28237))
- Fix display of center-aligned images with captions in TinyMCE. ([\#28048](https://core.trac.wordpress.org/ticket/28048))
- Fix masthead behavior in IE when a custom header image is present. ([\#27220](https://core.trac.wordpress.org/ticket/27220))
- Adjust spacing for menu toggle button to avoid overflowing accented characters. ([\#27456](https://core.trac.wordpress.org/ticket/27456))
- Fix menu toggle display on older Android devices. ([\#27456](https://core.trac.wordpress.org/ticket/27456))
- First pass at better Audio/Video player styling with genericons. ([\#26469](https://core.trac.wordpress.org/ticket/26469))
- Update to Genericons 3.0.3. ([\#28456](https://core.trac.wordpress.org/ticket/28456))
- Apply `max-width` values to avoid site title breaking the layout in small screens. ([\#28237](https://core.trac.wordpress.org/ticket/28237))
- Fix playlist track color in content sidebar. ([\#28457](https://core.trac.wordpress.org/ticket/28457))
- Apply .widget input and textarea styles only if they are inside .widget-area. ([\#27677](https://core.trac.wordpress.org/ticket/27677))
- Add documentation for global variables used in twentyfourteen\_wp\_title(). ([\#28421](https://core.trac.wordpress.org/ticket/28421))
- Change hardcoded pagination base to use the WordPress Rewrite object’s `pagination_base` value instead. Document global variable usage properly. ([\#28405](https://core.trac.wordpress.org/ticket/28405))
- Adjust spacing for site description (tagline) to avoid cutting off accented characters. ([\#28397](https://core.trac.wordpress.org/ticket/28397))
- Avoid passing an empty string to document.getElementById(). ([\#28340](https://core.trac.wordpress.org/ticket/28340))
- Bail early from Featured\_Content::hide\_featured\_term() if term objects are unavailable. ([\#28072](https://core.trac.wordpress.org/ticket/28072))
- Correct escaping for parent post link and attachment link in image template. ([\#28251](https://core.trac.wordpress.org/ticket/28251))

## Version 1.1

Released: May 8, 2014

- Use correct logic in IE conditional comments in header template. ([\#28151](https://core.trac.wordpress.org/ticket/28151))
- Prevent Page %s from being added to page title on 404 error pages in bundled themes. ([\#16468](https://core.trac.wordpress.org/ticket/16468))
- Avoid a PHP notice in Ephemera widget. ([\#28055](https://core.trac.wordpress.org/ticket/28055))
- Style to support the new HTML5 line-break-less galleries. ([\#27637](https://core.trac.wordpress.org/ticket/27637))
- Implement HTML5 markup for galleries. ([\#27502](https://core.trac.wordpress.org/ticket/27502))
- Fix typo in contextual help. ([\#27493](https://core.trac.wordpress.org/ticket/27493))
- Improved gallery styles in visual editor. ([\#27462](https://core.trac.wordpress.org/ticket/27462))
- Add Audio, Video, and Gallery Styles to editor styles. ([\#27462](https://core.trac.wordpress.org/ticket/27462))
- Load Masonry after window load event to give more time for widget content to load before drawing the layout. ([\#27051](https://core.trac.wordpress.org/ticket/v))
- Revert r27623 post\_class filter removal since it will visually break pre-WP 3.9 installs. ([\#18804](https://core.trac.wordpress.org/ticket/18804))
- Remove `post_class` filter for has-post-thumbnail now that it’s added in core for every theme. ([\#18804](https://core.trac.wordpress.org/ticket/18804))
- Remove doc block comments for `@return void`. ([\#27098](https://core.trac.wordpress.org/ticket/27098))
- Make small-screen menu accessible to keyboard commands and voice-driven software by using a focusable `button` element rather than `h1` for the toggle element.([\#27147](https://core.trac.wordpress.org/ticket/27147))
- Improve i18n in Ephemera widget for better translation of plurals for post format archives. ([\#27069](https://core.trac.wordpress.org/ticket/27069))
- Make sure we only hide post content on small screens for default post types: post and page. ([\#27031](https://core.trac.wordpress.org/ticket/27031))
- Merge two similar strings in Customizer featured content help text. ([\#26647](https://core.trac.wordpress.org/ticket/26647))
- Add a `.button` class. ([\#27075](https://core.trac.wordpress.org/ticket/27075))
- Add context and a missing period to widget descriptions. ( [\#26668](https://core.trac.wordpress.org/ticket/26668))
- Don’t add the `has-post-thumbnail` class or print the featured image when viewing an attachment. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- Update the HTML5 Shiv across the default themes to 3.7.0. ([\#26491](https://core.trac.wordpress.org/ticket/26491))
- Fix Ephemera Widget to avoid showing full post content when displayed in single post or page. Restore the global `$more` to its original value after the widget output to avoid any issues caused by changing a global variable. ([\#26961](https://core.trac.wordpress.org/ticket/26961))
- Translate `featured` tag slug used to link to specific tags in Posts editor. ([\#26526](https://core.trac.wordpress.org/ticket/26526))
- Fix unreachable links when the content area is shorter than the sidebar in smaller viewpoints. ([\#26782](https://core.trac.wordpress.org/ticket/26782))
- Delete the `featured_content_ids` transient on theme switch to make sure child themes can override the Featured Content quantity value. Also remove quantity parameter so child themes can change the amount of featured posts with `$max_posts`. ([\#26660](https://core.trac.wordpress.org/ticket/26660))
- Make sure `featured` tag is hidden on front-end views as expected. Add a check for the tag name in case we’re using default values and the default ID of `0` does not match the term id of the `featured` tag. ([\#26732](https://core.trac.wordpress.org/ticket/26732))
- Fix gap above static pages. ([\#26694](https://core.trac.wordpress.org/ticket/26694))
- Use the ‘display’ filter for get\_bloginfo( ‘name’ ) attached to the wp\_title filter. ([\#26811](https://core.trac.wordpress.org/ticket/26811))

## Version 1.0

Released: December 12, 2013

Initial release.
