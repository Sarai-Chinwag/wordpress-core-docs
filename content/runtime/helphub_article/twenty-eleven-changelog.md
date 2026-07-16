---
type: document
title: Twenty Eleven changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-eleven-changelog/"
tags:
timestamp: "2026-06-16T19:28:17+00:00"
wordpress:
  id: 2143
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:17"
  date_gmt: "2026-06-16 19:28:17"
  modified: "2026-06-16 19:28:17"
  modified_gmt: "2026-06-16 19:28:17"
  slug: twenty-eleven-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-eleven-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 5.1

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Remove default `type` attributes from `style` and `link` tags because the HTML5 standard does not require them. ([\#64428](https://core.trac.wordpress.org/ticket/64428))
- Consistently escape `get_search_query()` in `search.php` template. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Documentation: Improve PHP docblocks with corrected descriptions, missing/corrected tags, and specific types. ([\#64211](https://core.trac.wordpress.org/ticket/64211))
- Documentation: Add missing variable names to some `@param` tags. ([\[61315\]](https://core.trac.wordpress.org/changeset/61315))
- Documentation: Add missing `@return` tags and descriptions. ([\#64277](https://core.trac.wordpress.org/ticket/64277))

## Version 5.0

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Remove code for obsolete browsers, including conditional comments for Internet Explorer and the contents of IE-specific stylesheets and HTML5 Shiv files. ([\#58836](https://core.trac.wordpress.org/ticket/58836))
- Change the ‘Older posts’ and ‘Newer posts’ navigation links when the sort order is ascending so the labels accurately reflect the target pages. ([\#10219](https://core.trac.wordpress.org/ticket/10219))
- Prevent output of empty heading and/or link tags if the Site Title or Tagline has no value. ([\#44656](https://core.trac.wordpress.org/ticket/44656))
- Use correct escaping function for `alt` attributes in block patterns. ([\#63264](https://core.trac.wordpress.org/ticket/63264))
- Document the `twentyeleven_credits` action hook. ([\#63648](https://core.trac.wordpress.org/ticket/63648))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))

## Version 4.9

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Add `aria-current="page"` on header links that point to the current URL, and add `rel="home"` to the header image link. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Update `.screen-reader-text` class, replacing the obsolete `clip` property with `clip-path`. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Replace references to “Add New” theme screen in `readme` file. [\#61219](https://core.trac.wordpress.org/ticket/61219)
- Improve documentation for `twentyeleven_attachment_size` filter. [\#63160](https://core.trac.wordpress.org/ticket/63160)

## Version 4.8

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Remove floating and absolute positioning to make post navigation links clickable on small screens and to match the visual order of the post navigation and post date to the markup order. ([\#62008](https://core.trac.wordpress.org/ticket/62008))
- Fix Gallery block caption styles when the Gallery is inside a different block. ([\#50376](https://core.trac.wordpress.org/ticket/50376))
- Show the Verse block in the same font family in the editor as it has on the front end. ([\#61140](https://core.trac.wordpress.org/ticket/61140))
- Respect user-defined font size settings in Code blocks. ([\#61753](https://core.trac.wordpress.org/ticket/61753))
- Add missing `initial-scale` value in viewport meta tag. ([\[59026\]](https://core.trac.wordpress.org/changeset/59026))
- Document the `$instance` parameter in Ephemera widget form. ([\[59200\]](https://core.trac.wordpress.org/changeset/59200))
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 4.7

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/)

- Fix margins and padding around the text of the Media &amp; Text block. ([\#57195](https://core.trac.wordpress.org/ticket/57195))
- Remove Pullquote citation text color so it matches the quote text, whether the block has its default color or a special text color in block settings. ([\#56524](https://core.trac.wordpress.org/ticket/56524))
- Respect custom font weight and font style settings with Quote and Pullquote blocks, including their citations. ([\#56695](https://core.trac.wordpress.org/ticket/56695))
- Remove negative values for padding. ([\#46771](https://core.trac.wordpress.org/ticket/46771))
- Remove measurement in `px` for zero values in CSS. ([\#53874](https://core.trac.wordpress.org/ticket/53874))
- Remove blank CSS lines. ([\#59493](https://core.trac.wordpress.org/ticket/59493))
- Update HelpHub link for post format documentation to avoid unnecessary redirections. ([\[57800\]](https://core.trac.wordpress.org/changeset/57800/))

## Version 4.6

Released: April 2nd, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/)

- Fix typos. ([\#60383](https://core.trac.wordpress.org/ticket/60383))

## Version 4.5

Released: November 7, 2023

- Implement `the_header_image_tag` function for enhanced compatibility with new image features such as lazy loading, async decoding and fetch priority ([\#58675](https://core.trac.wordpress.org/ticket/58675))
- Update default themes to use new script function signature: the last parameter of `wp_enqueue_script()` is an array instead of the boolean `true` ([\#59302](https://core.trac.wordpress.org/ticket/59302))
- Use `defer` loading strategy for theme scripts ([\#59316](https://core.trac.wordpress.org/ticket/59316))

## Version 4.4

Released: August 8, 2023

- Remove call to `load_theme_textdomain()` function if the WordPress version is at least 4.6 ([\#58318](https://core.trac.wordpress.org/ticket/58318))
- Add “Requires PHP” to readme.txt and “Requires at least” in style.css ([\#57857](https://core.trac.wordpress.org/ticket/57857))

## Version 4.3

Released: March 29, 2023

- Remove title attributes ([\#57199](https://core.trac.wordpress.org/ticket/57199))
- Fix Separator block “Dots” style variation ([\#56008](https://core.trac.wordpress.org/ticket/56008))
- Use the new `/documentation/` URLs for HelpHub links ([\#57726](https://core.trac.wordpress.org/ticket/57726))
- Use strict comparison in bundled themes’ PHP files. ([\[55420](https://core.trac.wordpress.org/changeset/55420)\])

## Version 4.2

Released: November 1, 2022

- screen\_icon() and get\_current\_theme() are deprecated ([\#54833](https://core.trac.wordpress.org/ticket/54833))
- Asterisk symbol alignment with WooCommerce reviews rating label ([\#56297](https://core.trac.wordpress.org/ticket/56297))
- Table thead color not reflected in editor and front side ([\#56462](https://core.trac.wordpress.org/ticket/56462))
- Correctly escape template directory uri ([\#56717](https://core.trac.wordpress.org/ticket/56717))
- Multiple Themes: Correctly escape stylesheet URL ([\#56696](https://core.trac.wordpress.org/ticket/56695))

## Version 4.1

Released: May 24, 2022

- Define List item separator as a WP\_Locale property ([\#39733](https://core.trac.wordpress.org/ticket/39733))

## Version 4.0

Released: January 25, 2022

- Searchform collides with menu on small screens ([\#40398](https://core.trac.wordpress.org/ticket/40398))
- comment form styling ([\#54408](https://core.trac.wordpress.org/ticket/54408))
- Remove “role” attribute on HTML5 elements with a default landmark role. ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Bundled Themes: Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 3.9

Released: July 26, 2021

- Bundled themes: block-patterns.php file should use `get_template_directory_uri` instead of `get_stylesheet_directory_uri` ([\#53769](https://core.trac.wordpress.org/ticket/53769))

## Version 3.8

Released: July 20, 2021

- Introduce block patterns for Twenty Eleven. ([\#51106](https://core.trac.wordpress.org/ticket/51106))

## Version 3.7

Released: March 9, 2021

- Some core blocks are positioned incorrectly. ([\#52009](https://core.trac.wordpress.org/ticket/52009))
- Featured Images no longer display in-post if no header size match. ([\#52516](https://core.trac.wordpress.org/ticket/52516))

## Version 3.6

Released: December 8, 2020

- For image attachments, replace the text “Return to” with “Go to”. ([\#47235](https://core.trac.wordpress.org/ticket/47235))
- Correct punctuation in “Your comment is awaiting moderation” string. ([\#49867](https://core.trac.wordpress.org/ticket/49867))
- Correct list block alignment in editor styles. ([\#51157](https://core.trac.wordpress.org/ticket/51157))
- Docs: Add missing @return type for twentyeleven\_auto\_excerpt\_more(). ([\#51477](https://core.trac.wordpress.org/ticket/51477))
- Docs: Fix and upgrade object docblock notations. ([\#50768](https://core.trac.wordpress.org/ticket/50768#comment:28))

## Version 3.5

Released: August 11, 2020

- Add custom color palettes for block editor. ([\#50120](https://core.trac.wordpress.org/ticket/50120))
- Use HTTPS for XHTML Friends Network URL. ([\#48002](https://core.trac.wordpress.org/ticket/48002))
- Fixes the width of the category dropdown by limiting the width of select items in widgets using max-width: 100%. ([\#37926](https://core.trac.wordpress.org/ticket/37926))
- Use strict type check for in\_array() and array\_search() where strings are involved. ([\#49542](https://core.trac.wordpress.org/ticket/49542))

## Version 3.4

Released: March 31, 2020

- Update calendar widget styles for 5.4 markup. ([\#49549](https://core.trac.wordpress.org/ticket/49549))

## Version 3.3

Released: May 7, 2019

- Trigger a new `wp_body_open` action immediately after the opening `body` tag, and add shim. ([\#12563](https://core.trac.wordpress.org/ticket/12563), [\#46679](https://core.trac.wordpress.org/ticket/46679))
- Update readme.txt file content to fix validation errors. ([\#45871](https://core.trac.wordpress.org/ticket/45871))
- Update link to child theme documentation to point to its new locations. ([\#46450](https://core.trac.wordpress.org/ticket/46450))
- Correct `linear-gradient` syntax in the theme’s CSS. ([\#46770](https://core.trac.wordpress.org/ticket/46770))
- Update support forum links to point to their new location. ([\#46790](https://core.trac.wordpress.org/ticket/46790))

## Version 3.2

Released: February 21, 2019

- Add escaping to the pingback URL. ([\#43717](https://core.trac.wordpress.org/ticket/43717))

## Version 3.1

Released: January 9, 2019

- Make sure button blocks respect the default rounded style, as well as the squared and outline options. ([\#45541](https://core.trac.wordpress.org/ticket/45541))
- Bump version numbers of updated scripts and stylesheets to prevent caching. ([\#45679](https://core.trac.wordpress.org/ticket/45679))

## Version 3.0

Released: December 19, 2018

- Replace erroneous `font-size` with `font-weight` in editor styles. ([\#45421](https://core.trac.wordpress.org/ticket/45421))
- Update styles so button blocks will apply theme’s custom colors. ([\#45433](https://core.trac.wordpress.org/ticket/45433))
- Correct block appender appearance in block editor. ([\#45450](https://core.trac.wordpress.org/ticket/45450))
- Remove the term “Gutenberg” from code comments. ([\#45452](https://core.trac.wordpress.org/ticket/45452))

## Version 2.9

Released: December 6, 2018

- Add front end styles, editor styles and a custom color palette for the new block-based editor. ([\#45039](https://core.trac.wordpress.org/ticket/45039) and [\#45239](https://core.trac.wordpress.org/ticket/45239))
- Add theme support for responsive block embeds. ([\#45274](https://core.trac.wordpress.org/ticket/45274))

## Version 2.8

Released: May 17, 2018

- General: Reformat inline if () statements inside HTML tags. ([\#41057](https://core.trac.wordpress.org/ticket/41057))
- Code is Poetry. WordPress’ code just… wasn’t. ([\#41057](https://core.trac.wordpress.org/ticket/41057))
- Add link to privacy policy page in footer. ([\#43715](https://core.trac.wordpress.org/ticket/43715))
- Comments: Move comment consent input outside the label for a11y. ([\#43436](https://core.trac.wordpress.org/ticket/43436))

## Version 2.7

Released: November 14, 2017

- Change tag cloud format to a list (ul) for better semantics and accessibility. ([\#40138](https://core.trac.wordpress.org/ticket/40138))
- Make sure new gallery widgets look good in themes. ([\#41969](https://core.trac.wordpress.org/ticket/41969))

## Version 2.6

Released: June 8, 2017

- Improve styles for 4.8 widgets. ([\#40745](https://core.trac.wordpress.org/ticket/40745))

## Version 2.5

Released: August 15, 2016

- Twenty Eleven Ephemera widget fix for caching in Customizer preview. ([\#36429](https://core.trac.wordpress.org/ticket/36429))
- Update theme tags. ([\#37426](https://core.trac.wordpress.org/ticket/37426))

## Version 2.4

Released: April 12, 2016

- Use selective refresh to preview changes to site title and tagline in core themes. ([\#27355](https://core.trac.wordpress.org/ticket/27355))
- Captioned image fix for editor. ([\#33153](https://core.trac.wordpress.org/ticket/33153))
- Require opt-in for selective refresh of widgets. ([\#27355](https://core.trac.wordpress.org/ticket/27355))

## Version 2.3

Released: December 8, 2015

- Correct license information in readme.txt. ([\#33590](https://core.trac.wordpress.org/ticket/33590))

## Version 2.2

Released August 18, 2015

- Add readme file to explain basic theme usage, link to changelog in Codex, and include license information. ([\#31814](https://core.trac.wordpress.org/ticket/31814))
- Update the Twenty\_Eleven\_Ephemera\_Widget class constructor. Remove deprecated constructor notice (Since Twenty Eleven can be used with WordPress releases prior to 4.3, it can’t contain calls to functions that were introduced after its initial release.) ([\#32881](https://core.trac.wordpress.org/ticket/32881))
- Fix “Skip to content” links appearance after ([31464](https://core.trac.wordpress.org/changeset/31464)). See: ([\#32231](https://core.trac.wordpress.org/ticket/32231)).

## Version 2.1

Released April 23, 2015

- Fix indentation (spaces to tabs), fix escaping and minor code style issues ([\#29127](https://core.trac.wordpress.org/ticket/29127))
- Add postMessage support for header\_textcolor to improve the user experience in the Customizer ([\#24128](https://core.trac.wordpress.org/ticket/24128))
- Remove URLs from reset credits ([\#30764](https://core.trac.wordpress.org/ticket/30764))
- Fill in support for `screen-reader-text` class ([\#31095](https://core.trac.wordpress.org/ticket/31095))
- Replace current() with reset(), which is guaranteed to be the first item ([\#31259](https://core.trac.wordpress.org/ticket/31259), [\#31260](https://core.trac.wordpress.org/ticket/31260))
- Update CSS rules for `.screen-reader-text` to be consistent with current accessibility guidelines ( [\#31279](https://core.trac.wordpress.org/ticket/31279))
- Use SSL for theme and author URIs ([\#31699](https://core.trac.wordpress.org/ticket/31699))
- Add trailing slashes to theme URIs to avoid a redirect ([\#31839](https://core.trac.wordpress.org/ticket/31839))

## Version 2.0

Released: December 18, 2014

- Add bottom margin to audio and video players. ([\#29146](https://core.trac.wordpress.org/ticket/29146))
- Change Twenty Eleven’s header preview callback. ([\#29289](https://core.trac.wordpress.org/ticket/29289))
- Don’t display modified excerpt link in wp-admin. ([\#30026](https://core.trac.wordpress.org/ticket/30026))
- Change instances of “Theme Customizer” to just “Customizer”, as the Customizer isn’t necessarily theme-specific. ([\#29947](https://core.trac.wordpress.org/ticket/29947))
- Add an alt attribute with the site title for header images linked to the home page. ([\#15926](https://core.trac.wordpress.org/ticket/15926))
- Use HTTPS URLs for core.trac.wordpress.org. ([\#27115](https://core.trac.wordpress.org/ticket/27115))
- Prevent the arrow in “Continue reading” links from wrapping to a second line. ([\#27908](https://core.trac.wordpress.org/ticket27908/))

## Version 1.9

Released: September 4, 2014

- Avoid a PHP notice in bundled themes if no images were found. ([\#28361](https://core.trac.wordpress.org/ticket/28361))

## Version 1.8

Released: May 8, 2014

- Use correct logic in IE conditional comments in header template. ([\#28151](https://core.trac.wordpress.org/ticket/28151))
- Prevent ‘Page %s’ from being added to page title on 404 error pages in bundled themes. ([\#16468](https://core.trac.wordpress.org/ticket/16468))
- Correct description for twentyeleven\_theme\_options\_render\_page(). ([\#28057](https://core.trac.wordpress.org/ticket/28057))
- Add minimal CSS rules for audio, video, and display players on attachment pages. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- In `prepend_attachment`, add logic to support attachment types that are not `image`. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- In `get_post_class()`, don’t add the `has-post-thumbnail` class for attachment pages. ([\#27243](https://core.trac.wordpress.org/ticket/27243))
- Remove doc block comments for `@return void`. ([\#27098](https://core.trac.wordpress.org/ticket/27098))
- Make sure top post meta output isn’t broken on small screens. ([\#27061](https://core.trac.wordpress.org/ticket/27061))
- Only show secondary skip link on pages with secondary content, and remove duplicate title attribute in site title output. ([\#26950](https://core.trac.wordpress.org/ticket/26950))
- Update the HTML5 Shiv across the default themes to 3.7.0. ([\#26491](https://core.trac.wordpress.org/ticket/26491))
- New screenshot at 880×660 to maximize theme goodness in the new theme viewer design. ([\#26159](https://core.trac.wordpress.org/ticket/26159))
- Add and display new tags to highlight the ever-growing number of responsive themes available. ([\#21442](https://core.trac.wordpress.org/ticket/21442))
- Implement Microsoft-specific `@viewport` rules for better responsive styling in Windows 8 “snapped” views. ([\#25888](https://core.trac.wordpress.org/ticket/25888))

## Version 1.7

Released: Octoer 24, 2013

- Documentation: Spell out duplicate hook locations. ([\#25658](https://core.trac.wordpress.org/ticket/25658))
- Don’t use `/**` docblocks for simple multiline comments. ([\#25256](https://core.trac.wordpress.org/ticket/25256))
- Update code comments to reflect WP inline docs standards.([\#25256](https://core.trac.wordpress.org/ticket/25256))
- Fix some mobile layout bugs on single post format view. ([\#25019](https://core.trac.wordpress.org/ticket/25019))
- Theme folder moved to develop.svn.wordpress.org repository based on the old core.svn repository. ([\#24976](https://core.trac.wordpress.org/ticket/24976))

## Version 1.6

August 1, 2013

- Fix showcase template display in IE7 and IE8. ([\#18024](https://core.trac.wordpress.org/ticket/18024))
- Set images without WordPress-generated class to 100% maximum width, and fix spacing of images within caption containers. ([\#22366](https://core.trac.wordpress.org/ticket/22366))
- Improve spelling and grammar in documentation. ([\#22665](https://core.trac.wordpress.org/ticket/22665))
- Improve how gallery image IDs are retrieved for use in the Gallery post format template. Call get\_post\_galleries() correctly now that it has new arguments, and use a more accurate function\_exists call.([\#22907](https://core.trac.wordpress.org/ticket/22907))
- Use .text() instead of .html() for blogname and blogdescription in Theme Customizer JavaScript handlers. ([\#23435](https://core.trac.wordpress.org/ticket/23435))
- Use new URL extraction function, get\_the\_url() for link post formats in the Ephemera widget. ([\#23618](https://core.trac.wordpress.org/ticket/23618))
- Add identifier to style elements added by the theme. ([\#24033](https://core.trac.wordpress.org/ticket/24033))
- Add .displaying-header-text to the default themes, as the Custom Header page toggles this class. ([\#24113](https://core.trac.wordpress.org/ticket/24113))
- Remove the\_title\_attribute() title attributes where it duplicates the\_title() in anchor text. ([\#24203](https://core.trac.wordpress.org/ticket/24203))
- Remove /extend/ from Theme URI headers in default themes. ([\#24389](https://core.trac.wordpress.org/ticket/24389))
- Minor cleanup: remove extra spaces in CSS file and crush a few more kilobytes from a PNG file. ([r24144](https://core.trac.wordpress.org/changeset/24144))

## Version 1.5

December 11, 2012

- Continue reading link should be pluggable. ([\#16500](https://core.trac.wordpress.org/ticket/16500))
- Allow content-single.php to be overridden for post formats. ([\#17996](https://core.trac.wordpress.org/ticket/17996))
- Better closed comments notes. Check only for “comment” type comments when deciding whether to show the message. Check get\_comments\_number() instead of using $comments\_by\_type for showing a comments closed message. ([\#20469](https://core.trac.wordpress.org/ticket/20469))
- Fix gallery thumbnail image overflow. ([\#20478](https://core.trac.wordpress.org/ticket/20478))
- Style a few more common input types. ([\#20579](https://core.trac.wordpress.org/ticket/20579) &amp; [\#21757](https://core.trac.wordpress.org/ticket/21757))
- Update html5 shiv to stable version. ([\#20640](https://core.trac.wordpress.org/ticket/20640))
- Show categories and tags only when supported by post type, using is\_object\_in\_taxonomy() instead of only checking for ‘post’ post types. ([\#20922](https://core.trac.wordpress.org/ticket/20922))
- Remove an errant 1 pixel border below the header image. [\#21057](https://core.trac.wordpress.org/ticket/21057))
- More elegant fix for long word overflow in sidebars. ([\#21151](https://core.trac.wordpress.org/ticket/21151) &amp; [\#21503](https://core.trac.wordpress.org/ticket/21503))
- Fix typo, s/#entry-meta/.entry-meta/. ([\#21418](https://core.trac.wordpress.org/ticket/21418))
- Fix long URLs in comments overflow content area. ([\#21491](https://core.trac.wordpress.org/ticket/21491))
- Add new ‘flexible-header’ tag for themes. ([\#21605](https://core.trac.wordpress.org/ticket/21065))
- Add rule to force override the fixed width for Twitter embeds. ([\#21680](https://core.trac.wordpress.org/ticket/21680))
- Escape i18n attributes as late as possible. ([\#21756](https://core.trac.wordpress.org/ticket/21756))
- Improve styling and markup for gallery and attachment MCE views. Attachment views can now inherit from the theme’s editor-style.css. Adds a non-functional edit button to gallery views. ([\#21390](https://core.trac.wordpress.org/ticket/21390), [\#21813](https://core.trac.wordpress.org/ticket/21813), &amp; [\#21815](https://core.trac.wordpress.org/ticket/21815))
- Remove invalid pubdate value from time elements. ([\#22095](https://core.trac.wordpress.org/ticket/22095))
- Style &lt; small &gt; element in default themes a bit smaller than normal text. ([\#22109](https://core.trac.wordpress.org/ticket/22109))
- Allow show\_home argument to be overridden when using wp\_page\_menu as a fallback to a Custom Menu. ([\#22331](https://core.trac.wordpress.org/ticket/22331))
- Proper default background color. ([\#22347](https://core.trac.wordpress.org/ticket/22347))
- Escape navigation ID output. ([\#22690](https://core.trac.wordpress.org/ticket/22690))
- Remove buggy word-break property, use word-wrap instead, for better hyphenation and word breaking in nested comments. ([\#22751](https://core.trac.wordpress.org/ticket/22751))

## Version 1.4

June 13, 2012

- Style the samp and var elements the same way we style the code and kbd elements. ([\#17842](https://core.trac.wordpress.org/ticket/17842))
- Use one space, not two, after trailing punctuation. ([\#19537](https://core.trac.wordpress.org/ticket/19537))
- Callbacks for custom headers and custom backgrounds registered through add\_theme\_support() are now wp-head-callback, admin-head-callback, and admin-preview-callback. ([\#19910](https://core.trac.wordpress.org/ticket/19910))
- Fix incorrect end HTML comment. ([\#19978](https://core.trac.wordpress.org/ticket/19978))
- Move to add add\_theme\_support() for headers and backgrounds. Update functions.php to use the new add\_theme\_support() calls for backgrounds and headers.([\#20265](https://core.trac.wordpress.org/ticket/20265) &amp; [\#20249](https://core.trac.wordpress.org/ticket/20249))
- Remove use of HEADER\_IMAGE\_WIDTH and HEADER\_IMAGE\_HEIGHT from header.php. ([\#20265](https://core.trac.wordpress.org/ticket/20265))
- Fix typo and terminology in Twenty Eleven’s header template. ([\#20442](https://core.trac.wordpress.org/ticket/20442))
- Specify default background colors for the bundled themes. Change the default custom background callback to only operate on saved values, rather than default values. Prevent an unsaved default value from overriding a manually modified style.css file. Flexible heights for custom headers. [\#20448](https://core.trac.wordpress.org/ticket/20448))
- Provide backward compatibility for custom headers. ([\#20768](https://core.trac.wordpress.org/ticket/20768))

## Version 1.3

December 12, 2011

- Make date formats for transation.([\#16441](https://core.trac.wordpress.org/ticket/16441))
- Introduce image post format and miscellaneous style fixes. ([\#17198](https://core.trac.wordpress.org/ticket/17198))
- Simplify some Twenty-Eleven strings for i18n. ([\#17777](https://core.trac.wordpress.org/ticket/17777))
- Use get\_template\_directory() instead of TEMPLATEPATH. ([\#18071](https://core.trac.wordpress.org/ticket/18071))
- Fix @sinces documentation. Use the Settings fields/sections API. ([\#18045](https://core.trac.wordpress.org/ticket/18045))
- Fix alignment buttons when there is no content in editor under RTL. ([\#18247](https://core.trac.wordpress.org/ticket/18247))
- Make twentyeleven\_content\_nav() pluggable. ([\#18585](https://core.trac.wordpress.org/ticket/18585))
- Highlight current-menu-item and current-menu-ancestor. ([\#18643](https://core.trac.wordpress.org/ticket/18643))
- Indent code within an ‘if’ inside Twenty Eleven’s ephemera widget. ([\#18751](https://core.trac.wordpress.org/ticket/18751))
- Always call the loop properly in all template files rather than just calling the\_post(). ([\#18794](https://core.trac.wordpress.org/ticket/18794))
- Improve RTL css to better match LTR experience. ([\#18911](https://core.trac.wordpress.org/ticket/18911))
- Custom shadows for comment avatars in the dark color scheme. ([\#18930](https://core.trac.wordpress.org/ticket/18930))
- Footer widgets shouldn’t appear on the 404 page. ([\#18933](https://core.trac.wordpress.org/ticket/18933))
- Higher z-index for #branding. ([\#18938](https://core.trac.wordpress.org/ticket/18938))
- Make sure embeds and iframes fit their containers. ([\#18941](https://core.trac.wordpress.org/ticket/18941))
- phpdoc fix. ([\#18965](https://core.trac.wordpress.org/ticket/18965))
- Use get\_template\_directory() for include paths rather than FILE magic constant. Won’t go stale when twentyeleven\_setup() is overridden. ([\#18985](https://core.trac.wordpress.org/ticket/18985))
- Standardize some final help strings. Add contextual help for Twenty Eleven theme options page. ([\#19020](https://core.trac.wordpress.org/ticket/19020))
- Properly adjust margins for ordered lists in RTL in Twenty Eleven. ([\[1\]](https://core.trac.wordpress.org/ticket/19072))
- Give a min-height to posts of the status post format. ([\#19325](https://core.trac.wordpress.org/ticket/19325))
- Provide backward compatibility for multiple authors. ([\#19504](https://core.trac.wordpress.org/ticket/19504))
- Standardise on “Leave a reply”. ([r19375](https://core.trac.wordpress.org/changeset/19375))
- More consistent attribute escaping. ([r19582](https://core.trac.wordpress.org/changeset/19582))
- Backward compatible contextual help. ([r19580](https://core.trac.wordpress.org/changeset/19580))

## Version 1.2

July 12, 2011

- Don’t call comments\_popup\_link() if post\_password\_required(). That’ll result in double password messages. ([\#17962](https://core.trac.wordpress.org/ticket/17962))
- Fix search form width in IE7. ([\#18004](https://core.trac.wordpress.org/ticket/18004))
- Update editor style for blockquotes and images. ([\#18008](https://core.trac.wordpress.org/ticket/18008))
- Don’t set color in the \* selector in editor styles. ([\#18011](https://core.trac.wordpress.org/ticket/18011))
- Prefix theme\_options\_render\_page(). ([\#18045](https://core.trac.wordpress.org/ticket/18045))

## Version 1.1

Released: July 4, 2011

Initial release.
