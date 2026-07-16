---
type: document
title: Twenty Twelve changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-twelve-changelog/"
tags:
timestamp: "2026-06-16T19:28:16+00:00"
wordpress:
  id: 2142
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:16"
  date_gmt: "2026-06-16 19:28:16"
  modified: "2026-06-16 19:28:16"
  modified_gmt: "2026-06-16 19:28:16"
  slug: twenty-twelve-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-twelve-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 4.8

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Remove default `type` attributes from `style` tags because the HTML5 standard does not require them. ([\#64428](https://core.trac.wordpress.org/ticket/64428))
- Consistently escape `get_search_query()` in `search.php` template. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Update all references to the Verse block to Poetry. ([\#64658](https://core.trac.wordpress.org/ticket/64658))
- Documentation: Add missing `@return` tags and descriptions. ([\#64277](https://core.trac.wordpress.org/ticket/64277))

## Version 4.7

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Remove code for obsolete browsers, including conditional comments for Internet Explorer and the contents of IE-specific stylesheets and HTML5 Shiv files. ([\#58836](https://core.trac.wordpress.org/ticket/58836))
- Change the ‘Older posts’ and ‘Newer posts’ navigation links when the sort order is ascending so the labels accurately reflect the target pages. ([\#10219](https://core.trac.wordpress.org/ticket/10219))
- Prevent output of empty heading and/or link tags if the Site Title or Tagline has no value. ([\#44656](https://core.trac.wordpress.org/ticket/44656))
- Restore support for Image block Rounded style by adding the radius ruleset from the `block-library` style into the theme. ([\#64041](https://core.trac.wordpress.org/ticket/64041))
- Document the `twentytwelve_credits` action hook. ([\#63648](https://core.trac.wordpress.org/ticket/63648))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))

## Version 4.6

Released July 16, 2025, with [WordPress 6.8.2](https://wordpress.org/documentation/wordpress-version/version-6-8-2/).

- Fix alignment and styling of `figcaption` elements in the block editor. [\#63073](https://core.trac.wordpress.org/ticket/63073)

## Version 4.5

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Move the skip link to the top of the body content, so it is the first focusable item on the page. [\#62967](https://core.trac.wordpress.org/ticket/62967)
- Add ARIA attributes to the mobile menu toggle button. [\#62892](https://core.trac.wordpress.org/ticket/62892)
- Add `aria-current="page"` on header links that point to the current URL, and add `rel="home"` to the header image link. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Update the Left-aligned Large Quote pattern to use the Quote block instead of Paragraph blocks. [\#61765](https://core.trac.wordpress.org/ticket/61765)
- Update `.screen-reader-text` class, replacing the obsolete `clip` property with `clip-path`. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Replace references to “Add New” theme screen in `readme` file. [\#61219](https://core.trac.wordpress.org/ticket/61219)

## Version 4.4

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Prevent navigation submenus from hiding behind page content by increasing their `z-index` to `99999`. ([\#55892](https://core.trac.wordpress.org/ticket/55892))
- Respect user-defined font size settings in Code blocks. ([\#61753](https://core.trac.wordpress.org/ticket/61753))
- Fix Code block font family difference in editors. ([\#61808](https://core.trac.wordpress.org/ticket/61808))
- Fix Button block Outline style text color on the front end. ([\#61846](https://core.trac.wordpress.org/ticket/61846))
- Fix Navigation block submenus, preventing them from being cut off. ([\#61672](https://core.trac.wordpress.org/ticket/61672))
- Add missing `initial-scale` value in viewport meta tag. ([\[59026\]](https://core.trac.wordpress.org/changeset/59026))
- Load block patterns on the `init` hook to avoid triggering notices caused by loading the translations too early. ([\#62237](https://core.trac.wordpress.org/ticket/62237))
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 4.3

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/)

- Update Table block font size so it inherits any custom size set on the block. ([\#58074](https://core.trac.wordpress.org/ticket/58074))
- Correct Pullquote block alignment so it centers within the non-framed editor. ([\#57472](https://core.trac.wordpress.org/ticket/57472))
- Remove the last sentence of the ‘Left-aligned Image and Paragraph’ pattern to resolve oddly spelled words. ([\[57987\]](https://core.trac.wordpress.org/changeset/57987/trunk/src/wp-content/themes/twentytwelve), [\#61004](https://core.trac.wordpress.org/ticket/61004))
- Remove blank CSS lines. ([\#59493](https://core.trac.wordpress.org/ticket/59493))

## Version 4.2

Released: April 2nd, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/)

## Version 4.1

Released: November 7, 2023

- Implement `the_header_image_tag` function for enhanced compatibility with new image features such as lazy loading, async decoding and fetch priority ([\#58675](https://core.trac.wordpress.org/ticket/58675))
- Update default themes to use new script function signature: the last parameter of `wp_enqueue_script()` is an array instead of the boolean `true` ([\#59302](https://core.trac.wordpress.org/ticket/59302))
- Use `defer` loading strategy for theme scripts ([\#59316](https://core.trac.wordpress.org/ticket/59316))

## Version 4.0

Released: August 8, 2023

- Remove call to `load_theme_textdomain()` function if the WordPress version is at least 4.6 ([\#58318](https://core.trac.wordpress.org/ticket/58318))
- Add “Requires at least” and “Requires PHP” to readme.txt ([\#57857](https://core.trac.wordpress.org/ticket/57857))

## Version 3.9

Released: March 29, 2023

- Improve various globals documentation, as per docblock standards ([\#57069](https://core.trac.wordpress.org/ticket/57069))
- Remove title attributes ([\#57199](https://core.trac.wordpress.org/ticket/57199))
- Bundle Google Fonts locally ([\#55985](https://core.trac.wordpress.org/ticket/55985))
- Properly reflect text color changes in Table block ([\#56466](https://core.trac.wordpress.org/ticket/56466))
- Use strict comparison in bundled themes’ PHP files. ([\[55420](https://core.trac.wordpress.org/changeset/55420)\])

## Version 3.8

Released: November 1, 2022

- Multiple Themes: Correctly escape stylesheet URL ([\#56696](https://core.trac.wordpress.org/ticket/56695))

## Version 3.7

Released: May 24, 2022

- Typo correction in a bundled pattern ([\#55099](https://core.trac.wordpress.org/ticket/55099)).
- Define List item separator as a WP\_Locale property ([\#39733](https://core.trac.wordpress.org/ticket/39733))

## Version 3.6

Released: January 25, 2022

- Remove “role” attribute on HTML5 elements with a default landmark role. ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Bundled Themes: Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 3.5

Released: July 26, 2021

- Bundled themes: block-patterns.php file should use `get_template_directory_uri` instead of `get_stylesheet_directory_uri` ([\#53769](https://core.trac.wordpress.org/ticket/53769))

## Version 3.4

Released: July 20, 2021

- Introduce block patterns for Twenty Twelve. ([\#51105](https://core.trac.wordpress.org/ticket/51105))

## Version 3.3

Released: December 8, 2020

- For image attachments, replace the text “Return to” with “Go to”. ([\#47235](https://core.trac.wordpress.org/ticket/47235))
- Correct punctuation in “Your comment is awaiting moderation” string. ([\#49867](https://core.trac.wordpress.org/ticket/49867))

## Version 3.2

Released: August 11, 2020

- Add custom color palettes for block editor. ([\#50120](https://core.trac.wordpress.org/ticket/50120))
- Use HTTPS for XHTML Friends Network URL. ([\#48002](https://core.trac.wordpress.org/ticket/48002))
- Consistently check for WP\_Error before outputting get\_the\_tag\_list(). ([\#39860](https://core.trac.wordpress.org/ticket/39860))
- Use strict type check for in\_array() and array\_search() where strings are involved. ([\#49542](https://core.trac.wordpress.org/ticket/49542))

## Version 3.1

Released: March 31, 2020

- Update calendar widget styles for 5.4 markup. ([\#49549](https://core.trac.wordpress.org/ticket/49549))

## Version 3.0

Released: May 7, 2019

- Trigger a new `wp_body_open` action immediately after the opening `body` tag, and add shim. ([\#12563](https://core.trac.wordpress.org/ticket/12563), [\#46679](https://core.trac.wordpress.org/ticket/46679))
- Use theme version number when enqueuing styles. ([\#39997](https://core.trac.wordpress.org/ticket/39997))
- Update readme.txt file content to fix validation errors. ([\#45871](https://core.trac.wordpress.org/ticket/45871))
- Update link to child theme documentation to point to its new locations. ([\#46450](https://core.trac.wordpress.org/ticket/46450))
- Correct `linear-gradient` syntax in the theme’s CSS. ([\#46786](https://core.trac.wordpress.org/ticket/46786))

## Version 2.9

Released: February 21, 2019

- Add escaping to the pingback URL. ([\#43717](https://core.trac.wordpress.org/ticket/43717))

## Version 2.8

Released: January 9, 2019

- Correct `px` and `em` order in the blocks.css. ([\#45794](https://core.trac.wordpress.org/ticket/45794))
- Make sure button blocks respect the default rounded style, as well as the squared and outline options. ([\#45541](https://core.trac.wordpress.org/ticket/45541))
- Bump version numbers of updated scripts and stylesheets to prevent caching. ([\#45679](https://core.trac.wordpress.org/ticket/45679))

## Version 2.7

Released: December 19, 2018

- Update styles so button blocks will apply theme’s custom colors. ([\#45432](https://core.trac.wordpress.org/ticket/45432))
- Correct block appender appearance in block editor. ([\#45450](https://core.trac.wordpress.org/ticket/45450))
- Remove the term “Gutenberg” from code comments and editor styles. ([\#45452](https://core.trac.wordpress.org/ticket/45452))

## Version 2.6

Released: December 6, 2018

- Add front end styles, editor styles and a custom color palette for the new block-based editor. ([\#45040](https://core.trac.wordpress.org/ticket/45040) and [\#45240](https://core.trac.wordpress.org/ticket/45240))
- Add theme support for responsive block embeds. ([\#45274](https://core.trac.wordpress.org/ticket/45274))

## Version 2.5

Released: May 17, 2018

- Code is Poetry. WordPress’ code just… wasn’t. ([\#41057](https://core.trac.wordpress.org/ticket/41057))
- Add link to privacy policy page in footer. ([\#43715](https://core.trac.wordpress.org/ticket/43715))
- Comments: Move comment consent input outside the label for a11y. ([\#43436](https://core.trac.wordpress.org/ticket/43436))

## Version 2.4

Released: November 14, 2017

- Remove “called called” and “can can” dittography. ([\#41836](https://core.trac.wordpress.org/ticket/41836))
- Change tag cloud format to a list (ul) for better semantics and accessibility. ([\#40138](https://core.trac.wordpress.org/ticket/40138))
- Make sure new gallery widgets look good in themes. ([\#41969](https://core.trac.wordpress.org/ticket/41969))

## Version 2.3

Released: June 8, 2017

- Improve styles for 4.8 widgets. ([\#40745](https://core.trac.wordpress.org/ticket/40745))

## Version 2.2

Released: December 6, 2016

- Add preconnect to fonts.gstatic.com. ([\#37171](https://core.trac.wordpress.org/ticket/37171))

## Version 2.1

Released: August 15, 2016

- Remove .pot files from Default Themes. ([\#34884](https://core.trac.wordpress.org/ticket/34884))
- Update theme tags. ([\#37426](https://core.trac.wordpress.org/ticket/37426))

## Version 2.0

Released: April 12, 2016

- Standardize on “front end”/”back end” (noun) and “front-end”/”back-end”. ([\#34887](https://core.trac.wordpress.org/ticket/34887))
- Use selective refresh to preview changes to site title and tagline in core themes. ([\#27355](https://core.trac.wordpress.org/ticket/27355))
- Require opt-in for selective refresh of widgets. ([\#27355](https://core.trac.wordpress.org/ticket/27355))

## Version 1.9

Released: December 8, 2015

- Correct license information in readme.txt. ([\#33590](https://core.trac.wordpress.org/ticket/33590))

## Version 1.8

Released August 18, 2015

- Fix content skip link appearance. ([\#32232](https://core.trac.wordpress.org/ticket/32232))
- Add readme file to explain basic theme usage, link to changelog in Codex, and include license information. ([\#31814](https://core.trac.wordpress.org/ticket/31814))
- Use https for Google API external libraries. ([\#32552](https://core.trac.wordpress.org/ticket/32552))

## Version 1.7

Released April 23, 2015

- Fix escaping and minor code style issues ([\#29127](https://core.trac.wordpress.org/ticket/29127))
- Fill in support for `screen-reader-text` class ([\#31095](https://core.trac.wordpress.org/ticket/31095))
- Replace current() with reset(), which is guaranteed to be the first item ([\#31259](https://core.trac.wordpress.org/ticket/31259), [\#31260](https://core.trac.wordpress.org/ticket/31260))
- Update CSS rules for `.screen-reader-text` to be consistent with current accessibility guidelines ([\#31279](https://core.trac.wordpress.org/ticket/31279))
- Use SSL for theme and author URIs ([\#31699](https://core.trac.wordpress.org/ticket/31699))
- Add trailing slashes to theme URIs to avoid a redirect ([\#31839](https://core.trac.wordpress.org/ticket/31839))

## Version 1.6

Released: December 18, 2014

- Fix widget stacking problem in older IE browsers for Front Page template. ([\#28938](https://core.trac.wordpress.org/ticket/28938))
- Menu on touch devices: fix jQuery selector for menu items with submenus. ([\#24767](https://core.trac.wordpress.org/ticket/24767))
- Use proper way to get customizer settings values.([\#29577](https://core.trac.wordpress.org/ticket/29577))
- Improve keyboard accessibility on Custom Header and Custom Background screen. ([\#29289](https://core.trac.wordpress.org/ticket/29289))
- Change instances of “Theme Customizer” to just “Customizer”, as the Customizer isn’t necessarily theme-specific. ([\#29947](https://core.trac.wordpress.org/ticket/29947))
- Add an alt attribute with the site title for header images linked to the home page. ([\#15926](https://core.trac.wordpress.org/ticket/15926))
- Use HTTPS URLs for core.trac.wordpress.org. ([\#27115](https://core.trac.wordpress.org/ticket/27115))
- Prevent the arrow in “Continue reading” links from wrapping to a second line. ([\#27908](https://core.trac.wordpress.org/ticket/27908))

## Version 1.5

Released: September 4, 2014

- Make small-screen menu accessible to keyboard commands and voice-driven software by using a focusable button element rather than `h3` for the toggle element. ([\#28224](https://core.trac.wordpress.org/ticket/28224))
- Bump JS version. ([\#24767](https://core.trac.wordpress.org/ticket/24767))
- Make submenu links work correctly on tablets. ([\#24767](https://core.trac.wordpress.org/ticket/24767))
- Avoid a PHP notice in bundled themes if no images were found. ([\#28361](https://core.trac.wordpress.org/ticket/28361))
- Use correct logic in IE conditional comments in header template. ([\#28151](https://core.trac.wordpress.org/ticket/28151))
- Prevent ‘Page %s’ from being added to page title on 404 error pages. ([\#16468](https://core.trac.wordpress.org/ticket/16468))

## Version 1.4

Released: May 8, 2014

- On attachment pages for audio and video, display players. Currently, only a link is displayed. Add minimal CSS rules for compatibility. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- In `prepend_attachment`, add logic to support attachment types that are not `image`. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- In `get_post_class()`, don’t add the `has-post-thumbnail` class for attachment pages. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- Improve menu navigation for keyboard and voice-over interactions by properly focusing on submenu items when they are open. ([\#24839](https://core.trac.wordpress.org/ticket/24839))
- Remove doc block comments for `@return void`. ([\#27098](https://core.trac.wordpress.org/ticket/27098))
- Style `select` element. ([\#27434](https://core.trac.wordpress.org/ticket/27434))
- Remove unused `singular` selectors in print CSS block. ([\#26866](https://core.trac.wordpress.org/ticket/26866))
- Don’t print the featured image when viewing an attachment. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- Update the HTML5 Shiv across the default themes to 3.7.0. ([\#26491](https://core.trac.wordpress.org/ticket/26491))
- Use the ‘display’ filter for get\_bloginfo( ‘name’ ) attached to the wp\_title filter. ([\#26811](https://core.trac.wordpress.org/ticket/26811))
- New screenshots at 880×660 to maximize theme goodness in the new theme viewer design. ([\#26159](https://core.trac.wordpress.org/ticket/26159))
- Add and display new tags to highlight the ever-growing number of responsive themes available. ([\#21442](https://core.trac.wordpress.org/ticket/21442))
- Implement Microsoft-specific `@viewport` rules for better responsive styling in Windows 8 “snapped” views. ([\#25888](https://core.trac.wordpress.org/ticket/25888))

## Version 1.3

Released: October 24, 2013

- Translator comments are special, make sure they are parsed properly. ([\#25256](https://core.trac.wordpress.org/ticket/25256))
- Don’t use `/**` docblocks for simple multiline comments. ([\#25256](https://core.trac.wordpress.org/ticket/25256))
- Update code comments to reflect WP inline docs standards. ([\#25256](https://core.trac.wordpress.org/ticket/25256))
- Spell out duplicate hook locations. ([\#25658](https://core.trac.wordpress.org/ticket/))
- Use the correct body class for attachments in the IE stylesheet. ([\#25506](https://core.trac.wordpress.org/ticket/25506))
- Use the correct body class for attachments where .single-attachment is only used when the attachment’s parent is not a page. ([\#25506](https://core.trac.wordpress.org/ticket/25506))
- Simplify header image check. ([\#25400](https://core.trac.wordpress.org/ticket/25400))

## Version 1.2

Released: August 1, 2013

- Load Google Font in the visual editor to improve user experience. [\#22499](https://core.trac.wordpress.org/ticket/22499))
- Fix button active state to avoid a 2px shift. ([\#22825](https://core.trac.wordpress.org/ticket/22825))
- Fix double featured images in Front Page Template. Show featured image in single page views. ([\#22943](https://core.trac.wordpress.org/ticket/22943))
- Update post author comment markup and styles, improving hCard data parsing and simplifying styles.([\#23128](https://core.trac.wordpress.org/ticket/23128))
- Better layout for floated image captions. ([\#23147](https://core.trac.wordpress.org/ticket/23147))
- Remove unnecessary class values in posts navigation. ([\#23152](https://core.trac.wordpress.org/ticket/23152))
- Properly style visited links in entries, widgets, and comment text. [\#23200](https://core.trac.wordpress.org/ticket/23200))
- Clear center-aligned images properly. ([\#23244](https://core.trac.wordpress.org/ticket/23244))
- Use `.text()` instead of `.html()` for blogname and blog description in Theme Customizer JavaScript handlers. ([\#23435](https://core.trac.wordpress.org/ticket/23435))
- Better handling for cases where a background color is set to white or an empty value (like first run with no theme\_mods set) and a background image is enabled, which resulted previously in a broken layout. ([\#23586](https://core.trac.wordpress.org/ticket/23586))
- Enable live preview for Header Text Color in Theme Customizer. Change also removes an !important declaration (yay) in Custom Header CSS rules. Fix regression introduced in r23572, allow hide/show of Header Text in Customizer. ([\#23600](https://core.trac.wordpress.org/ticket/23600))
- Improve Appearance &gt; Header styles to match front end view better — including loading special Google Font there. Add back missing space in CSS value. ([\#23790](https://core.trac.wordpress.org/ticket/23790))
- Add identifier to style elements added by the theme. ([\#24033](https://core.trac.wordpress.org/ticket/24033))
- Add .displaying-header-text to the default themes, as the Custom Header page toggles this class. ([\#24113](https://core.trac.wordpress.org/ticket/24113))
- In editor-style.css change .mceWPnextpage to .mce-wp-nextpage to match the core fix for Chrome. ([\#24177](https://core.trac.wordpress.org/ticket/24177))
- Fix minor indentation issues in CSS files (spaces to tabs). ([\#24196](https://core.trac.wordpress.org/changeset/24196))
- Remove the\_title\_attribute() title attributes where it duplicates the\_title() in anchor text. ([\#24203](https://core.trac.wordpress.org/ticket/24203))
- Remove /extend/ from Theme URI headers in default themes. ([\#24389](https://core.trac.wordpress.org/ticket/24389))

## Version 1.1

Released: December 11, 2012

Initial release.
