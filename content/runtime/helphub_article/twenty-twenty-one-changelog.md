---
type: document
title: Twenty Twenty-One changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-twenty-one-changelog/"
tags:
timestamp: "2026-06-16T19:28:40+00:00"
wordpress:
  id: 2247
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:40"
  date_gmt: "2026-06-16 19:28:40"
  modified: "2026-06-16 19:28:40"
  modified_gmt: "2026-06-16 19:28:40"
  slug: twenty-twenty-one-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-twenty-one-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 2.8

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Remove all support for Internet Explorer, including IE-specific CSS and polyfill scripts. ([\#64590](https://core.trac.wordpress.org/ticket/64590))
- Add a small margin to left- and right-aligned Image blocks on small screens, and correct left and right margins for any block in right-to-left languages. ([\#56748](https://core.trac.wordpress.org/ticket/56748))
- Update `.screen-reader-text` class with `word-break` reset, to ensure screen readers will not read text as individual letters in hidden text. ([\#64375](https://core.trac.wordpress.org/ticket/64375))
- Only enqueue block editor assets in the admin. ([\#60111](https://core.trac.wordpress.org/ticket/60111))
- Consistently escape `get_search_query()` in `search.php` and `content-none.php` templates. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Consistently use theme version when enqueueing resources. ([\#64526](https://core.trac.wordpress.org/ticket/64526))
- Update all references to the Verse block to Poetry. ([\#64658](https://core.trac.wordpress.org/ticket/64658))
- Documentation: Fix variable type issues and remove PHPStan suppression comments. ([\[61676\]](https://core.trac.wordpress.org/changeset/61676))
- Documentation: Add missing `@return` tags and descriptions. ([\#64277](https://core.trac.wordpress.org/ticket/64277))
- Documentation: Remove redundant comment for conditionally-defined function. ([\[61608\]](https://core.trac.wordpress.org/changeset/61608))
- Documentation: Remove unnecessary annotations, such as `EscapeOutput`, for the `WordPress-Extra` and `WPThemeReview` coding standards. ([\[61654\]](https://core.trac.wordpress.org/changeset/61654))

## Version 2.7

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Use `wp_print_inline_script_tag()` when available to construct scripts while also ensuring filters may inject additional attributes on the `<script>` tags, such as nonce for Content Security Policy (CSP). ([\#63806](https://core.trac.wordpress.org/ticket/63806))
- Change the ‘Older posts’ and ‘Newer posts’ labels for post navigation links when the sort order is ascending so the labels accurately reflect the target pages. ([\#10219](https://core.trac.wordpress.org/ticket/10219))
- Fix the margin for List Item blocks, and the `line-height` for multiple blocks, in the editor styles. ([\#60196](https://core.trac.wordpress.org/ticket/60196), [\#63549](https://core.trac.wordpress.org/ticket/63549))
- Document the `twenty_twenty_one_content_width` filter. ([\#63664](https://core.trac.wordpress.org/ticket/63664))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))
- Update `npm` dependencies. ([\#63171](https://core.trac.wordpress.org/ticket/63171))

## Version 2.6

Released: August 5, 2025

- Add navigation menu toggle behaviors earlier, at `DOMContentLoaded` instead of at the `load` event. [\#63613](https://core.trac.wordpress.org/ticket/63613)

## Version 2.5

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Add `rel="home"` on header links. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Add `aria-controls` attributes to primary navigation sub-menu for additional context on what is being expanded. [\#62973](https://core.trac.wordpress.org/ticket/62973)
- Update `.screen-reader-text` class, replacing the obsolete `clip` property with `clip-path` and removing prefixed instances of `-webkit-clip-path`. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Replace references to “Add New” theme screen in `readme` file. [\#61219](https://core.trac.wordpress.org/ticket/61219)
- Update `npm` dependencies. [\[59530\]](https://core.trac.wordpress.org/changeset/59530)

## Version 2.4

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Resolve wrong drop cap alignment in RTL by removing the `float` property. ([\#52885](https://core.trac.wordpress.org/ticket/52885))
- Resolve bug in which the primary navigation was stuck in a vertical list when resizing the window. ([\#52663](https://core.trac.wordpress.org/ticket/52663))
- Fix vertical alignment of site title and navigation links by adjusting the top margin. ([\#61633](https://core.trac.wordpress.org/ticket/61633))
- Avoid showing float-clearing pseudo-elements in Row and Grid blocks in modern browsers, but keep them for Internet Explorer. ([\#61611](https://core.trac.wordpress.org/ticket/61611))
- Edit `initial-scale` value in viewport meta tag to `1.0` instead of `1`. [\[59026\]](https://core.trac.wordpress.org/changeset/59026)
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 2.3

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/)

- Check for `WP_Error` before outputting `get_the_tag_list()` to prevent a fatal error on PHP 8. ([\#60800](https://core.trac.wordpress.org/ticket/60800))
- Remove the sub-menu toggle button if the navigation is not the primary menu. ([\#52694](https://core.trac.wordpress.org/ticket/52694))
- Fix search box alignment with the submit button. ([\#52551](https://core.trac.wordpress.org/ticket/52551))
- Fix typography settings for the Quote block. ([\#55991](https://core.trac.wordpress.org/ticket/55991))
- Fix font size and text color in Latest Comments block. ([\#61082](https://core.trac.wordpress.org/ticket/61082))
- Fix `code` element showing outside of section area. ([\#52780](https://core.trac.wordpress.org/ticket/52780))
- Adjust CSS breakpoints to prevent primary menu from disappearing at 481 to 482 pixels wide. ([\#52354](https://core.trac.wordpress.org/ticket/52354))
- Update CSS to use shorthand values. ([\#53874](https://core.trac.wordpress.org/ticket/53874))
- Edit CSS comments and remove empty rulesets. ([\#59493](https://core.trac.wordpress.org/ticket/59493))
- Update `npm` dependencies. ([\[58562\]](https://core.trac.wordpress.org/changeset/58562))
- Fix spelling mistake in a comment in header styles. ([\[57987\]](https://core.trac.wordpress.org/changeset/57987/trunk/src/wp-content/themes/twentytwentyone))

## Version 2.2

Released: April 2nd, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/)

- Update the CSS for the pullquote block to support block typography options. ([\#57854](https://core.trac.wordpress.org/ticket/57854))
- Add “blog” and “portfolio” subject tags. ([\#59495](https://core.trac.wordpress.org/ticket/59495))

## Version 2.1

Released: January 16, 2024.

- Revert usage of `str_contains()` in older bundled themes ([\#60241](https://core.trac.wordpress.org/ticket/57377))

## Version 2.0

Released: November 7, 2023 with [WordPress 6.4](https://wordpress.org/documentation/wordpress-version/version-6-4/).

- Move quotation marks inside a Quote block with a custom background color when in the editor ([\#57377](https://core.trac.wordpress.org/ticket/57377))
- Update default themes to use new script function signature: the last parameter of `wp_register_script()` and `wp_enqueue_script()` is an array instead of the boolean `true` ([\#59302](https://core.trac.wordpress.org/ticket/59302))
- Use `defer` loading strategy for theme scripts ([\#59316](https://core.trac.wordpress.org/ticket/59316))

## Version 1.9

Released: August 8, 2023 with [WordPress 6.3](https://wordpress.org/documentation/wordpress-version/version-6-3/)

- Correct `font-weight` for `b` and `strong` elements in editor styles ([\#58383](https://core.trac.wordpress.org/ticket/58383))
- Replace the experimental link color theme support ([\#58702](https://core.trac.wordpress.org/ticket/58702))
- Enable Dark Mode in the block editor iframe ([\#58835](https://core.trac.wordpress.org/ticket/58835))
- Deprecate the skip link focus fix, removing the script from the `wp_print_footer_scripts` action ([\#54421](https://core.trac.wordpress.org/ticket/54421))
- Improve various globals documentation, as per docblock standards ([\#58684](https://core.trac.wordpress.org/ticket/58684))
- Remove call to `load_theme_textdomain()` function ([\#58318](https://core.trac.wordpress.org/ticket/58318))

## Version 1.8

Released: March 29, 2023 with [WordPress 6.2](https://wordpress.org/news/2023/03/dolphy/)

- Comment missing at the end of HTML tag in author-bio.php ([\#56476](https://core.trac.wordpress.org/ticket/56476))
- Add Mastodon domains for menu item icons. ([\#57293](https://core.trac.wordpress.org/ticket/55931))
- Refactor or remove navigation item padding CSS ([\#53220](https://core.trac.wordpress.org/ticket/53220))
- Disable spellcheck for all password fields for better privacy ([\#56763](https://core.trac.wordpress.org/ticket/56763))
- Bug in `primary-navigation.js` ([\#53331](https://core.trac.wordpress.org/ticket/53331))
- Mark strings for screen readers ([\#29748](https://core.trac.wordpress.org/ticket/49099))
- Group block styles are breaking the row variation ([\#56226](https://core.trac.wordpress.org/ticket/56226))
- Correct type in rss\_widget\_feed\_link filter docs ([\#57594](https://core.trac.wordpress.org/ticket/57594))
- Use the new `/documentation/` URLs for HelpHub links in Bundled Themes. ([\#57726](https://core.trac.wordpress.org/ticket/57726))

## Version 1.7

Released: November 1, 2022 with [WordPress 6.1](https://wordpress.org/news/2022/11/misha/)

- Add blockType suggestions to block patterns ([\#53647](https://core.trac.wordpress.org/ticket/53647))
- Comment missing at the end of HTML tag ([\#55724](https://core.trac.wordpress.org/ticket/55724))
- Comment missing at the end of HTML tag in class file ([\#55725](https://core.trac.wordpress.org/ticket/55725))
- Consider removing `.woocommerce` class from theme styles ([\#56366](https://core.trac.wordpress.org/ticket/56366))
- Remove spacer block styles ([\#56222](https://core.trac.wordpress.org/ticket/56222))
- Separator block is having issue in editor site with background color for default and thick style ([\#56173](https://core.trac.wordpress.org/ticket/56173))
- heading nested inside cover width discrepancy in Editor ([\#56050](https://core.trac.wordpress.org/ticket/56050))
- Remove closing PHP tags from bundled themes ([\#40039](https://core.trac.wordpress.org/ticket/40039))

## Version 1.6

Released: May 24, 2022 with [WordPress 6.0](https://wordpress.org/news/2022/05/arturo/)

- Replace GitHub with .org link in Theme URI ([\#55018](https://core.trac.wordpress.org/ticket/55018))
- Allow editor styles to control block margins ([\#54250](https://core.trac.wordpress.org/ticket/54250))
- Reverse logic for `prefers-reduced-motion` media query ([\#54174](https://core.trac.wordpress.org/ticket/54174))
- Define List item separator as a WP\_Locale property ([\#39733](https://core.trac.wordpress.org/ticket/39733))
- Prevent loading translation file twice ([\#53589](https://core.trac.wordpress.org/ticket/53589))
- Correct translator comment in twenty\_twenty\_one\_continue\_reading\_text ([\#55564](https://core.trac.wordpress.org/ticket/55564))
- Rename parameters that use reserved keywords in bundled themes ([\#55327](https://core.trac.wordpress.org/ticket/55327))
- Make translator comments referencing the post title consistent ([\#55564](https://core.trac.wordpress.org/ticket/55564))
- Rename parameters that use reserved keywords in `wp-includes/class.wp-styles.php` ([\#55327](https://core.trac.wordpress.org/ticket/55327))
- Update NPM dependencies for default themes ([\#54727](https://core.trac.wordpress.org/ticket/54727))
- i18n fix for privacy policy section title ([\#55709](https://core.trac.wordpress.org/ticket/55709))
- Add a missing HTML comment to indicate the end of .post-thumbnail section ([\#55724](https://core.trac.wordpress.org/ticket/55724))

## Version 1.5

Released: January 25, 2022

- Image block control button alignment issue while using inside column ([\#54254](https://core.trac.wordpress.org/ticket/54254))
- Default image alignment in editor ([\#53809](https://core.trac.wordpress.org/ticket/53809))
- get\_attachment\_image\_attributes\_image\_attributes not checking if variable isset properly ([\#54464](https://core.trac.wordpress.org/ticket/54464))
- Add privacy policy link to footer ([\#53445](https://core.trac.wordpress.org/ticket/53445))
- Dark Mode toggle also appears in bottom left corner ([\#53892](https://core.trac.wordpress.org/ticket/53892))
- Dark mode in the new Widgets makes impossible to read ([\#53429](https://core.trac.wordpress.org/ticket/53429))
- Investigate duplicate rules in `ie-editor.css` ([\#53605](https://core.trac.wordpress.org/ticket/53605))
- JS Error for Anchors that load custom modals or react hash routes ([\#53619](https://core.trac.wordpress.org/ticket/53619))
- Missing esc\_html\_\_() in functions.php ([\#54127](https://core.trac.wordpress.org/ticket/54127))
- RSS widget has empty link (feed icon) ([\#52880](https://core.trac.wordpress.org/ticket/52880))
- Social icons have duplicate height and width values ([\#54208](https://core.trac.wordpress.org/ticket/54208))
- footer links lack closing span tag ([\#54209](https://core.trac.wordpress.org/ticket/54209))
- List based widgets need style adjustments in the widget editor ([\#53629](https://core.trac.wordpress.org/ticket/53629))
- Skip link focus fix is output twice in Twenty Twenty-One if SCRIPT\_DEBUG is enabled ([\#54429](https://core.trac.wordpress.org/ticket/54429))
- Return type not matched in PHPDoc – Bundled Themes ([\#53878](https://core.trac.wordpress.org/ticket/53878))
- Remove “role” attribute on HTML5 elements with a default landmark role. ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Core themes need to display required text field information ([\#54392](https://core.trac.wordpress.org/ticket/54392))
- Bundled Themes: Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 1.4

Released: July 20, 2021

- Check for navigation element before using it ([\#52773](https://core.trac.wordpress.org/ticket/52773))
- Display page title as the H1 heading when a static page is selected as the “Posts page” ([\#52938](https://core.trac.wordpress.org/ticket/52938))
- Update `twenty_twenty_one_password_form` function to actually use a `$post` parameter ([\#53091](https://core.trac.wordpress.org/ticket/53091))
- Improve display of blocks in widget areas ([\#53422](https://core.trac.wordpress.org/ticket/53422))
- Use the theme version when enqueueing theme assets ([\#53502](https://core.trac.wordpress.org/ticket/53502))
- Ensure Duotone images are displayed correctly in Dark Mode ([\#53531](https://core.trac.wordpress.org/ticket/53531))
- Ensure the dropdown arrow displays for `<select>` elements when focused ([\#53560](https://core.trac.wordpress.org/ticket/53560))
- Correct customzier typo ([\#53598](https://core.trac.wordpress.org/ticket/53598))

## Version 1.3

Released: April 14, 2021

- Update IE specific editor stylesheet ([\#52981](https://core.trac.wordpress.org/ticket/52981))

## Version 1.2

Released: March 9, 2021

- Buttons lose contrast consistency in Dark Mode ([\#](https://core.trac.wordpress.org/ticket/)[51927](https://core.trac.wordpress.org/ticket/51927))
- missing styles for button\[type=submit\] ([\#](https://core.trac.wordpress.org/ticket/)[52029](https://core.trac.wordpress.org/ticket/52029))
- Twenty Twenty-One: Clean up CSS build process ([\#](https://core.trac.wordpress.org/ticket/)[52156](https://core.trac.wordpress.org/ticket/52156))
- style.css has errors in PhpStorm IDE ([\#](https://core.trac.wordpress.org/ticket/)[52176](https://core.trac.wordpress.org/ticket/52176))
- twenty\_twenty\_one\_get\_attachment\_image\_attributes affects the admin panel ([\#](https://core.trac.wordpress.org/ticket/)[52212](https://core.trac.wordpress.org/ticket/52212))
- Transparent png logo isn’t visible on focus ([\#](https://core.trac.wordpress.org/ticket/)[52257](https://core.trac.wordpress.org/ticket/52257))
- Inline images displaying on new lines (as display: block) ([\#](https://core.trac.wordpress.org/ticket/)[52287](https://core.trac.wordpress.org/ticket/52287))
- fix leftover rtlcss call in build script ([\#](https://core.trac.wordpress.org/ticket/)[52293](https://core.trac.wordpress.org/ticket/52293))
- Add missing HTML comment for Header tag ([\#52328](https://core.trac.wordpress.org/ticket/52328))
- Use Yoda condition ([\#52329](https://core.trac.wordpress.org/ticket/))
- Menu button has the wrong colors ([\#](https://core.trac.wordpress.org/ticket/)[52374](https://core.trac.wordpress.org/ticket/52374))
- Re-add .css.map files ([\#](https://core.trac.wordpress.org/ticket/)[52377](https://core.trac.wordpress.org/ticket/52377))
- Word wrap missing in comments ([\#](https://core.trac.wordpress.org/ticket/)[52380](https://core.trac.wordpress.org/ticket/52380))
- correct starter content function docs ([\#](https://core.trac.wordpress.org/ticket/)[52410](https://core.trac.wordpress.org/ticket/52410))
- list bullets have different styles in the editor and front([\#](https://core.trac.wordpress.org/ticket/)[52412](https://core.trac.wordpress.org/ticket/52412))
- Add support for the font size option for the code block ([\#](https://core.trac.wordpress.org/ticket/)[52431](https://core.trac.wordpress.org/ticket/52431))
- Vertical buttons block has the wrong width ([\#](https://core.trac.wordpress.org/ticket/)[52432](https://core.trac.wordpress.org/ticket/52432))
- Search block editor styles are broken in 5.7 ([\#](https://core.trac.wordpress.org/ticket/)[52433](https://core.trac.wordpress.org/ticket/52433))
- Dark Mode toggle is causing JavaScript error in block editor ([\#](https://core.trac.wordpress.org/ticket/)[52473](https://core.trac.wordpress.org/ticket/52473))
- Typo in style.css – missing `var(...)` ([\#](https://core.trac.wordpress.org/ticket/)[52477](https://core.trac.wordpress.org/ticket/52477))
- The color options for social icons does not work with the custom style ([\#](https://core.trac.wordpress.org/ticket/)[52499](https://core.trac.wordpress.org/ticket/52499))
- Use correct accent marks in the spelling of block pattern alt text ([\#](https://core.trac.wordpress.org/ticket/)[52500](https://core.trac.wordpress.org/ticket/52500))
- Synchronise ignored files between git and svn ([\#](https://core.trac.wordpress.org/ticket/)[52502](https://core.trac.wordpress.org/ticket/52502))
- Twenty Twenty-One has unit-less CSS variable unfit for cal() ([\#](https://core.trac.wordpress.org/ticket/)[52564](https://core.trac.wordpress.org/ticket/52564))
- With WP 5.7 RC2, the text color for the dark background color palette is dark instead of white ([\#](https://core.trac.wordpress.org/ticket/)[52702](https://core.trac.wordpress.org/ticket/52702))

## Version 1.1

Released: December 22, 2020

- Prevent `<iframe>` embeds from being too narrow. ([\#52004](https://core.trac.wordpress.org/ticket/52004))
- Allow local anchor links to be used in primary navigation. ([\#52006](https://core.trac.wordpress.org/ticket/52006))
- Do not specify `loading=“eager”` for single post thumbnails. ([\#52139](https://core.trac.wordpress.org/ticket/52139))
- Improve strings found in post navigations for easier translating. ([\#52](#52047)[0](https://core.trac.wordpress.org/ticket/52047)[47](#52047))
- Use consistent HTML comments after closing HTML tags. ([\#51950](https://core.trac.wordpress.org/ticket/51950))
- Use a more specific and translatable link for Dark Mode instructions. ([\#52010](https://core.trac.wordpress.org/ticket/52010))
- Make text within code blocks readable in Dark Mode. ([\#51985](https://core.trac.wordpress.org/ticket/51985))
- Improve styling for striped tables in Dark Mode. ([\#52129](https://core.trac.wordpress.org/ticket/52129))
- Set a max-width on input fields ([\#52083](https://core.trac.wordpress.org/ticket/52083))
- Use `esc_url()` for the WordPress.org link in `footer.php`. ([\#51954](https://core.trac.wordpress.org/ticket/51954))
- Only load IE specific polyfills when actually using Internet Explorer. ([\#52098](https://core.trac.wordpress.org/ticket/52098))
- Correct version format in file-header.scss. ([\#52044](https://core.trac.wordpress.org/ticket/52044))
- Correct `@since` inline documentation tags. ([\#51958](https://core.trac.wordpress.org/ticket/51958))
- Add a PostCSS configuration file. ([\#52040](https://core.trac.wordpress.org/ticket/52040))
- Fix typos in inline comments. ([\#52042](https://core.trac.wordpress.org/ticket/52042), [\#52071](https://core.trac.wordpress.org/ticket/52071))
- Clarify a sentence in `readme.txt`. ([\#52120](https://core.trac.wordpress.org/ticket/52120))

## Version 1.0

Released: December 8, 2020

Initial Release.
