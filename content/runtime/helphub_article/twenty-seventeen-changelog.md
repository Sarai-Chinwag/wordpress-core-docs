---
type: document
title: Twenty Seventeen changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-seventeen-changelog/"
tags:
timestamp: "2026-06-16T19:28:15+00:00"
wordpress:
  id: 2138
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:15"
  date_gmt: "2026-06-16 19:28:15"
  modified: "2026-06-16 19:28:15"
  modified_gmt: "2026-06-16 19:28:15"
  slug: twenty-seventeen-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-seventeen-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 4.1

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Restore `$post_id` parameter to the `twentyseventeen_edit_link()` function because it is being passed in some templates. ([\#64825](https://core.trac.wordpress.org/ticket/64825))
- Update `.screen-reader-text` class with `word-break` reset, to ensure screen readers will not read text as individual letters in hidden text. ([\#64375](https://core.trac.wordpress.org/ticket/64375))
- Remove default `type` attributes from `style` tags because the HTML5 standard does not require them. ([\#64428](https://core.trac.wordpress.org/ticket/64428))
- Consistently escape `get_search_query()` in `search.php` template. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Documentation: Add missing `@return` tags and descriptions. ([\#64277](https://core.trac.wordpress.org/ticket/64277))

## Version 4.0

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Remove code for obsolete browsers, including conditional comments for Internet Explorer and the contents of IE-specific stylesheets and HTML5 Shiv files. ([\#58836](https://core.trac.wordpress.org/ticket/58836))
- Use `wp_print_inline_script_tag()` when available to construct scripts while also ensuring filters may inject additional attributes on the `<script>` tags, such as nonce for Content Security Policy (CSP). ([\#63806](https://core.trac.wordpress.org/ticket/63806))
- Prevent output of empty heading and/or link tags if the Site Title or Tagline has no value. ([\#44656](https://core.trac.wordpress.org/ticket/44656))
- Add `label` text to use explicit labels (with `for` and `id` attributes) in Customizer hue picker. ([\#42078](https://core.trac.wordpress.org/ticket/42078))
- Escape translations in block patterns. ([\#63264](https://core.trac.wordpress.org/ticket/63264))
- Document the `twentyseventeen_should_show_featured_image` filter. ([\#63644](https://core.trac.wordpress.org/ticket/63644))
- Document the `the_content` filter. ([\#63637](https://core.trac.wordpress.org/ticket/63637))
- Add missing `@since` tag for `twentyseventeen_scripts()`. ([\#63692](https://core.trac.wordpress.org/ticket/63692))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))

## Version 3.9

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Add `aria-current="page"` on header links that point to the current URL. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Update `.screen-reader-text` class, replacing the obsolete `clip` property with `clip-path`. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Replace references to “Add New” theme screen in `readme` file. [\#61219](https://core.trac.wordpress.org/ticket/61219)

## Version 3.8

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Add spacing between each Reply heading and its Cancel reply link in the comments template. ([\#59334](https://core.trac.wordpress.org/ticket/59334))
- Restrict front page panels to show only pages with ‘publish’ or ‘private’ status, and show a placeholder in the Customizer if the page has a different status. ([\#46604](https://core.trac.wordpress.org/ticket/46604))
- Remove extra spacing from floated images when they are the first image. ([\#46785](https://core.trac.wordpress.org/ticket/46785))
- Respect user-defined font weight settings in Button blocks. ([\#60937](https://core.trac.wordpress.org/ticket/60937))
- Fix Gallery block caption styles when the Gallery is inside a different block. ([\#50376](https://core.trac.wordpress.org/ticket/50376))
- Show the Verse block in the same font family in the editor as it has on the front end. ([\#61140](https://core.trac.wordpress.org/ticket/61140))
- Fix Pullquote block text color settings in the editor. ([\#46080](https://core.trac.wordpress.org/ticket/46080))
- Fix Search block button styles in the editor. ([\#61888](https://core.trac.wordpress.org/ticket/61888))
- Edit `initial-scale` value in viewport meta tag to `1.0` instead of `1`. [\[59026\]](https://core.trac.wordpress.org/changeset/59026)
- Load block patterns on the `init` hook to avoid triggering notices caused by loading the translations too early. ([\#62237](https://core.trac.wordpress.org/ticket/62237))
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 3.7

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/)

- Add a `twentyseventeen_should_show_featured_image` filter to adjust when a featured image should display in the header. ([\#39281](https://core.trac.wordpress.org/ticket/39281))
- Fix inconsistent alignment, font style and margin for the `figure` caption in Image and similar blocks within the editor. ([\#58539](https://core.trac.wordpress.org/ticket/58539))
- Improve header image quality with mobile devices and browsers at a narrow width. ([\#39253](https://core.trac.wordpress.org/ticket/39253))
- Correct image height for the Site Logo block, and remove box shadow when the “Link image to home” setting is enabled. ([\#58474](https://core.trac.wordpress.org/ticket/58474))
- Set a default border style of `solid` for the Pullquote block when the user adds a border. ([\#61362](https://core.trac.wordpress.org/ticket/61362))
- Fix the font weight of links in the Latest Comments block, and remove unused rulesets. ([\#61180](https://core.trac.wordpress.org/ticket/61180))
- Use a consistent space between comments in a Latest Comments block, within a post, as typography size is increased. ([\#59130](https://core.trac.wordpress.org/ticket/59130))
- Center the Calendar block’s header cells when added to a post. ([\#58547](https://core.trac.wordpress.org/ticket/58547))
- Remove blank CSS lines. ([\#59493](https://core.trac.wordpress.org/ticket/59493))
- Optimize theme screenshot. ([\[58442\]](https://core.trac.wordpress.org/changeset/58442/))
- Correct a spelling mistake in a comment within `dark.css`. ([\[57987\]](https://core.trac.wordpress.org/changeset/57987/trunk/src/wp-content/themes/twentyseventeen))
- Update HelpHub link for post format documentation to avoid unnecessary redirections. ([\[57800\]](https://core.trac.wordpress.org/changeset/57800/))

## Version 3.6

Released: April 2nd, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/)

- Cast font URL functions to `string` for `add_editor_style()`, to avoid PHP warnings on child themes. ([\#59074](https://core.trac.wordpress.org/ticket/59704))
- Add missing text domain to various block patterns. ([\#60245](https://core.trac.wordpress.org/ticket/60245))
- Correct a typo ([\#60310](https://core.trac.wordpress.org/ticket/60310))

## Version 3.5

Released: January 16, 2024

- Revert usage of `str_contains()` in older bundled themes ([\#60241](https://core.trac.wordpress.org/ticket/60241)).

## Version 3.4

Released: November 7, 2023

- Update default themes to use new script function signature: the last parameter of `wp_register_script()` and `wp_enqueue_script()` is an array instead of the boolean `true` ([\#59302](https://core.trac.wordpress.org/ticket/59302))
- Use `defer` loading strategy for theme scripts ([\#59316](https://core.trac.wordpress.org/ticket/59316))

## Version 3.3

Released: August 8, 2023

- Improve Grid View variation rendering in the editor for the Post List block by removing an unwanted `disc` list style ([\#58531](https://core.trac.wordpress.org/ticket/58531))
- Deprecate the skip link focus fix, switching the enqueue function to just register the script ([\#54421](https://core.trac.wordpress.org/ticket/54421))
- Remove Internet Explorer-specific checks ([\#56699](https://core.trac.wordpress.org/ticket/56699))
- Make `twentyseventeen_is_static_front_page()` an alias of `twentyseventeen_is_frontpage()` because both functions returned same result ([\#43515](https://core.trac.wordpress.org/ticket/43515))
- Fix documentation for template functions ([\#58695](https://core.trac.wordpress.org/ticket/58695))
- Remove call to `load_theme_textdomain()` function ([\#58318](https://core.trac.wordpress.org/ticket/58318))
- Add “Requires at least” and “Requires PHP” to readme.txt ([\#57857](https://core.trac.wordpress.org/ticket/57857))
- Replace usage of `strpos()` with `str_contains()` ([\#58206](https://core.trac.wordpress.org/ticket/58206))

## Version 3.2

Released: March 29, 2023

- Remove letter-spacing from Farsi/Persian alphabet ([\#56994](https://core.trac.wordpress.org/ticket/56994))
- Fix comment indentation in `twentyseventeen_setup()` ([\[54902](https://core.trac.wordpress.org/changeset/54902)\])
- Improve various globals documentation, as per docblock standards ([\#57069](https://core.trac.wordpress.org/ticket/57069))
- Document the `$twentyseventeencounter` global. ([\[55004](https://core.trac.wordpress.org/changeset/55004)\])
- Bundle Google Fonts locally ([\#55985](https://core.trac.wordpress.org/ticket/55985))
- Mark strings for screen readers ([\#29748](https://core.trac.wordpress.org/ticket/29748))
- Use the new `/documentation/` URLs for HelpHub links ([\#57726](https://core.trac.wordpress.org/ticket/57726))

## Version 3.1

Released: November 1, 2022

- Button text word break does not apply correctly ([\#55783](https://core.trac.wordpress.org/ticket/55783))
- Scaling Issue on Front Page Parallax Image Using Safari on iPadOS ([\#48195](https://core.trac.wordpress.org/ticket/48195))
- Update jQuery scrollTo to the latest version ([\#56702](https://core.trac.wordpress.org/ticket/56702))
- Remove closing PHP tags from bundled themes ([\#40039](https://core.trac.wordpress.org/ticket/40039))

## Version 3.0

Released: May 24, 2022

- Remove bottom border (box-shadow) from linked images ([\#55141](https://core.trac.wordpress.org/ticket/55141))
- Define List item separator as a WP\_Locale property ([\#39733](https://core.trac.wordpress.org/ticket/39733))
- Note visually hidden text for translators ([\#55591](https://core.trac.wordpress.org/ticket/55591))

## Version 2.9

Released: January 25, 2022

- Remove “role” attribute on HTML5 elements with a default landmark role. ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Return type not matched in PHPDoc – Bundled Themes ([\#53878](https://core.trac.wordpress.org/ticket/53878))
- Change WhatsApp URL in social links menu ([\#51946](https://core.trac.wordpress.org/ticket/51946))
- Post title’s margin-bottom on front page is too large ([\#43628](https://core.trac.wordpress.org/ticket/43628))
- Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 2.8

Released: July 20, 2021

- Avoid JS errors when displaying legacy widgets. ([\#53512](https://core.trac.wordpress.org/ticket/53512))
- Improve display of blocks in widget areas. ([\#53422](https://core.trac.wordpress.org/ticket/53422))

## Version 2.7

Released: April 14, 2021

- Post metabox style has a border ([\#52816](https://core.trac.wordpress.org/ticket/52816))

## Version 2.6

Released: March 9, 2021

- Core blocks are positioned incorrectly in some core bundled themes. ([\#52009](https://core.trac.wordpress.org/ticket/52009))
- Add support for the font size option for the code block. ([\#52431](https://core.trac.wordpress.org/ticket/52431))

## Version 2.5

Released: December 8, 2020

- Introduce block patterns for Twenty Seventeen. ([\#51100](https://core.trac.wordpress.org/ticket/51100))
- Correct list block alignment in editor styles. ([\#51157](https://core.trac.wordpress.org/ticket/51157))
- Declare support for the html5 feature navigation-widgets. ([\#51445](https://core.trac.wordpress.org/ticket/51445))

## Version 2.4

Released: August 11, 2020

- Fixes navbar z-index issue by upping the z-index value to 1000 from 7. ([\#39384)](https://core.trac.wordpress.org/ticket/39384)
- Fixes issues where pagination does not work on the page that is set to the home page. ([\#39685)](https://core.trac.wordpress.org/ticket/39685)
- Adds Telegram and Whatsapp support and SVG’s to Social Media Menu. ([\#43999)](https://core.trac.wordpress.org/ticket/43999)
- Fixes CSS issue when using rowspan in tables. This issue does not apply to the Table Block, just tables inserted as custom html. ([\#44004)](https://core.trac.wordpress.org/ticket/44004)

## Version 2.3

Released: March 31, 2020

- Update calendar widget styles for 5.4 markup. ([\#49549](https://core.trac.wordpress.org/ticket/49549))

## Version 2.2

Released: May 7, 2019

- Trigger a new `wp_body_open` action immediately after the opening `body` tag, and add shim. ([\#12563](https://core.trac.wordpress.org/ticket/12563), [\#46679](https://core.trac.wordpress.org/ticket/46679))
- Use theme version number when enqueuing styles. ([\#39997](https://core.trac.wordpress.org/ticket/39997))
- Correct hover styles for MediaElement JS buttons. ([\#40843](https://core.trac.wordpress.org/ticket/40843))
- Update readme.txt file content to fix validation errors. ([\#45871](https://core.trac.wordpress.org/ticket/45871))
- Make `th` styling match on the front-end and in the editor. ([\#46568](https://core.trac.wordpress.org/ticket/46568))
- Prevent too-long strings from causing horizontal scrolling. ([\#46703](https://core.trac.wordpress.org/ticket/46703))
- Fix inconsistent HTML comments after closing HTML tags. ([\#46871](https://core.trac.wordpress.org/ticket/46871))

## Version 2.1

Released: February 21, 2019

- Add escaping to the pingback URL. ([\#43717](https://core.trac.wordpress.org/ticket/43717))
- Fix issue with YouTube videos used in the Header Media area displaying offset in Safari. ([\#40522](https://core.trac.wordpress.org/ticket/40522))
- Make sure right-aligned quotes are correctly positioned on page load. ([\#40103](https://core.trac.wordpress.org/ticket/40103))
- Correct the documentation for `twentyseventeen_scripts()` function. ([\#45466](https://core.trac.wordpress.org/ticket/45466))
- Update `@link` information in index.php. ([\#45222](https://core.trac.wordpress.org/ticket/45222))
- Remove unneeded `default_text_color` from doc block, and add information for the `twentyseventeen_custom_header_setup()` function. ([\#44920](https://core.trac.wordpress.org/ticket/44920))
- Correct “frontpage” to “front page” in the code comments. ([\#42666](https://core.trac.wordpress.org/ticket/42666))
- In the code comments, correct the number of recent blog posts that will be displayed on the static front page. ([\#42621](https://core.trac.wordpress.org/ticket/42621))

## Version 2.0

Released: January 9, 2019

- Use simple counter rather than `uniqid()` for generating unique IDs for HTML elements. ([\#44883](https://core.trac.wordpress.org/ticket/44883))
- Fix block editor custom color styles, to make sure they’re being correctly applied to blocks. ([\#45426](https://core.trac.wordpress.org/ticket/45426))
- Make sure button blocks respect the default rounded style, as well as the squared and outline options. ([\#45541](https://core.trac.wordpress.org/ticket/45541))
- Bump version numbers of updated scripts and stylesheets to prevent caching. ([\#45679](https://core.trac.wordpress.org/ticket/45679))

## Version 1.9

Released: December 19, 2018

- Remove unneeded ordered list styles from editor styles, which caused issues in starting order. ([\#44775](https://core.trac.wordpress.org/ticket/44775))
- Add focus styles to the cookies consent checkbox in the comment form. ([\#44699](https://core.trac.wordpress.org/ticket/44699))
- Remove legacy Internet Explorer 8 styles from the editor that were making it impossible to resize images. ([\#39738](https://core.trac.wordpress.org/ticket/39738))
- Correct font family used for Simplified Chinese in the block editor styles. ([\#45408](https://core.trac.wordpress.org/ticket/45408))
- Correct block appender appearance in block editor. ([\#45450](https://core.trac.wordpress.org/ticket/45450))
- Remove the term “Gutenberg” from code comments and editor styles. ([\#45452](https://core.trac.wordpress.org/ticket/45452))

## Version 1.8

Released: December 6, 2018

- Add front end and editor styles for the new block-based editor. ([\#45045](https://core.trac.wordpress.org/ticket/45045) and [\#45246](https://core.trac.wordpress.org/ticket/45246))
- Add theme support for responsive block embeds. ([\#45274](https://core.trac.wordpress.org/ticket/45274))

## Version 1.7

Released: August 2, 2018

- Correct list item style for nested unordered lists. ([\#44109](https://core.trac.wordpress.org/ticket/44109))

## Version 1.6

Released: May 17, 2018

- Add link to privacy policy page in footer. ([\#43715](https://core.trac.wordpress.org/ticket/43715))
- Comments: Move comment consent input outside the label for a11y. ([\#43436](https://core.trac.wordpress.org/ticket/43436))

## Version 1.5

Released: April 3, 2018

- Various code improvements for formatting. ([\#41057](https://core.trac.wordpress.org/ticket/41057))
- Use consistent wording when referring to the front page in inline docs. ([\#42666](https://core.trac.wordpress.org/ticket/42666))
- Correct the number of recent posts in a comment in `template-parts/page/content-front-page-panels.php`. ([\#42621](https://core.trac.wordpress.org/ticket/42621))
- Remove unnecessary comment in `front-page.php`. ([\#42820](https://core.trac.wordpress.org/ticket/42820))
- Underline links in comments. ([\#43317](https://core.trac.wordpress.org/ticket/43317))

## Version 1.4

Released: November 14, 2017

- Remove/merge unused variables in `content-front-page.php`. ([\#39771](https://core.trac.wordpress.org/ticket/39771))
- Correct the `@return` value for `twentyseventeen_post_thumbnail_sizes_attr()`. ([\#41830](https://core.trac.wordpress.org/ticket/41830))
- Document the type of `$item` argument in `twentyseventeen_dropdown_icon_to_menu_link()` more accurately. ([\#41923](https://core.trac.wordpress.org/ticket/41923))
- Add Periscope icon to supported social links. ([\#40959](https://core.trac.wordpress.org/ticket/40959))
- Add Docker Hub icon to supported social links. ([\#41529](https://core.trac.wordpress.org/ticket/41529))
- Add missing labels for `<aside role="complementary">` widget areas. ([\#42056](https://core.trac.wordpress.org/ticket/42056))
- Change tag cloud format to a list (ul) for better semantics and accessibility. ([\#40184](https://core.trac.wordpress.org/ticket/40184)), ([\#40138](https://core.trac.wordpress.org/ticket/40138))
- Add missing `@return` tag for `twentyseventeen_video_controls()`. ([\#41927](https://core.trac.wordpress.org/ticket/41927))
- Fix positioning of edit shortcuts when partials are nested inside a frontpage panel. ([\#41557](https://core.trac.wordpress.org/ticket/41557))
- Fix double bottom-margins below embeds. ([\#42118](https://core.trac.wordpress.org/ticket/42118))
- Make gallery link styles consistent in all widget areas. ([\#42302](https://core.trac.wordpress.org/ticket/42302)), ([\#41969](https://core.trac.wordpress.org/ticket/41969))

## Version 1.3

Released: June 8, 2017

- Improve styles for 4.8 widgets. ([\#40745](https://core.trac.wordpress.org/ticket/40745))
- Remove uneccessary return statement. ([\#40516](https://core.trac.wordpress.org/ticket/40516))
- Improves code readability and code standards in files. ([\#39152](https://core.trac.wordpress.org/ticket/39152))
- Hardens the logic for calling featured image in `header.php`. ([\#39302](https://core.trac.wordpress.org/ticket/39302))
- Correct `@param` entry for `twentyseventeen_front_page_sections` filter. ([\#39488](https://core.trac.wordpress.org/ticket/39488))
- Remove extra asterisk from a translator comment so the comment could be parsed correctly. ([\#39116](https://core.trac.wordpress.org/ticket/39116))
- Correct `@param` entries for `twentyseventeen_custom_colors_css` filter. ([\#39575](https://core.trac.wordpress.org/ticket/39575))
- Remove duplicate `global $post` declaration in `twentyseventeen_front_page_section()`. ([\#39590](https://core.trac.wordpress.org/ticket/39590))
- Improve typography for Simplified Chinese `(zh_CN)`. ([\#39379](https://core.trac.wordpress.org/ticket/39379))
- Allow category display in post preview even when only one category. ([\#39531](https://core.trac.wordpress.org/ticket/39531))
- Rename “Sidebar” widget area for clarity. ([\#39567](https://core.trac.wordpress.org/ticket/39567))
- Correct grammar in ‘Page Layout’ control description. ([\#40107](https://core.trac.wordpress.org/ticket/40107))

## Version 1.2

Released: April 18, 2017

- Declare jQuery dependency for `navigation.js`. ([\#40224](https://core.trac.wordpress.org/ticket/40224))
- Correctly escape translatable strings in HTML attributes. ([\#40216](https://core.trac.wordpress.org/ticket/40216))
- Fix incorrect heading hierarchy for front page posts. ([\#40264](https://core.trac.wordpress.org/ticket/40264))

## Version 1.1

Released: January 6, 2017

- Fix incorrect `$content_width` value in theme. ([\#39272](https://core.trac.wordpress.org/ticket/39272))
- Ensure functions in `customize-controls.js` don’t count on Customizer sections always being present. ([\#39335](https://core.trac.wordpress.org/ticket/39335))
- Deprecate `page_home` nav menu item starter content in favor of `link_home`. ([\#39104](https://core.trac.wordpress.org/ticket/39104))
- Introduce a theme-specific filter `twentyseventeen_starter_content` for customizing the starter content array. ([\#39109](https://core.trac.wordpress.org/ticket/39109))

## Version 1.0

Released: December 6, 2016

Initial Release.
