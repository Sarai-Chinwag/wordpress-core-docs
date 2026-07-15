---
type: document
title: Twenty Nineteen changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-nineteen-changelog/"
tags:
timestamp: "2026-06-16T19:28:15+00:00"
wordpress:
  id: 2137
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:15"
  date_gmt: "2026-06-16 19:28:15"
  modified: "2026-06-16 19:28:15"
  modified_gmt: "2026-06-16 19:28:15"
  slug: twenty-nineteen-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-nineteen-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 3.3

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Correct center or right alignment for Download link in the File block. ([\#59263](https://core.trac.wordpress.org/ticket/59263))
- Ensure that Pullquote block color is reflected on citation text. ([\#58100](https://core.trac.wordpress.org/ticket/58100))
- Fix the font family of Calendar block in the editor, matching it to the front end. ([\#63331](https://core.trac.wordpress.org/ticket/63331))
- Update `.screen-reader-text` class with `word-break` reset, to ensure screen readers will not read text as individual letters in hidden text. ([\#64375](https://core.trac.wordpress.org/ticket/64375))
- Remove default `type` attributes from `style` tags because the HTML5 standard does not require them. ([\#64428](https://core.trac.wordpress.org/ticket/64428))
- Consistently escape `get_search_query()` in `search.php` template. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Update all references to the Verse block to Poetry. ([\#64658](https://core.trac.wordpress.org/ticket/64658))
- Documentation: Add missing `@return` tags and descriptions. ([\#64277](https://core.trac.wordpress.org/ticket/64277))
- Documentation: Remove a legacy WPCS annotation. ([\[61630\]](https://core.trac.wordpress.org/changeset/61630))

## Version 3.2

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Change the ‘Older posts’ and ‘Newer posts’ labels for post navigation links when the sort order is ascending so the labels accurately reflect the target pages. ([\#10219](https://core.trac.wordpress.org/ticket/10219))
- Make mobile navigation menu scrollable, especially when the primary menu contains many items. ([\#45902](https://core.trac.wordpress.org/ticket/45902))
- Add `label` text to use explicit labels (with `for` and `id` attributes) in Customizer hue picker. ([\#42078](https://core.trac.wordpress.org/ticket/42078))
- Use correct escaping function for `alt` attributes in block patterns. ([\#63264](https://core.trac.wordpress.org/ticket/63264))
- Document the `twentynineteen_can_show_post_thumbnail` filter. ([\#63645](https://core.trac.wordpress.org/ticket/63645))
- Document the `twentynineteen_content_width` filter. ([\#63664](https://core.trac.wordpress.org/ticket/63664))
- Add missing `@since` tag for `twentynineteen_scripts()`. ([\#63692](https://core.trac.wordpress.org/ticket/63692))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))
- Update `npm` dependencies. ([\#63171](https://core.trac.wordpress.org/ticket/63171))

## Version 3.1

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Omit `aria-expanded` and `aria-haspopup` attributes outside of the primary menu. [\#62896](https://core.trac.wordpress.org/ticket/62896)
- Add `aria-current="page"` on header links that point to the current URL. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Update `.screen-reader-text` class, removing the obsolete `clip` property. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Replace references to “Add New” theme screen in `readme` file. [\#61219](https://core.trac.wordpress.org/ticket/61219)
- Update `npm` dependencies. [\[59530\]](https://core.trac.wordpress.org/changeset/59530)

## Version 3.0

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Add spacing between each Reply heading and its Cancel reply link in the comments template. ([\#59334](https://core.trac.wordpress.org/ticket/59334))
- Use the same “Published in” link text for any attachment page, repurposing text from the image template. ([\#45473](https://core.trac.wordpress.org/ticket/45473))
- Fix navigation with multiple links in a right-to-left language. ([\#46658](https://core.trac.wordpress.org/ticket/46658))
- Fix avatar image size in Avatar and Author blocks without changing the size for the Comments section. ([\#60664](https://core.trac.wordpress.org/ticket/60664), [\#62096](https://core.trac.wordpress.org/ticket/62096))
- Add center alignment to Archives and Categories List blocks in the editor. ([\#61186](https://core.trac.wordpress.org/ticket/61186))
- Fix Pullquote block font size and citation display. ([\#61507](https://core.trac.wordpress.org/ticket/61507))
- Respect user-defined typography settings in the Button block. ([\#61437](https://core.trac.wordpress.org/ticket/61437))
- Reduce spacing below the Audio block’s `audio` element by setting it to `display: block`. ([\#53681](https://core.trac.wordpress.org/ticket/53681))
- Edit `initial-scale` value in viewport meta tag to `1.0` instead of `1`. [\[59026\]](https://core.trac.wordpress.org/changeset/59026)
- Remove the use of empty rulesets in Sass files. ([\#61933](https://core.trac.wordpress.org/ticket/61933))
- Add missing documentation for helper function parameters, and edit spacing for DocBlocks. ([\#62112](https://core.trac.wordpress.org/ticket/62112))
- Document the `$defaults` parameter in `twentynineteen_comment_form_defaults()`. ([\[59218\]](https://core.trac.wordpress.org/changeset/59218))
- Load block patterns on the `init` hook to avoid triggering notices caused by loading the translations too early. ([\#62237](https://core.trac.wordpress.org/ticket/62237))
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 2.9

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/)

- Show URL in print styles more reliably. ([\#45944](https://core.trac.wordpress.org/ticket/45944))
- Fix custom font sizes with the Button block so they match what is selected instead of 88.9% of that value. ([\#56443](https://core.trac.wordpress.org/ticket/56443))
- Fix Button block padding within the editor. ([\#61235](https://core.trac.wordpress.org/ticket/61235))
- Use the same font size for the entry title `h1` heading in the editor as it is on the front. ([\#58440](https://core.trac.wordpress.org/ticket/58440))
- Include a contributing text file with Sass compiler instructions. ([\#46108](https://core.trac.wordpress.org/ticket/46108))
- Update `npm` dependencies. ([\[58562\]](https://core.trac.wordpress.org/changeset/58562))
- Rearrange comments in the SCSS files so they do not create CSS rulesets without properties. ([\#59493](https://core.trac.wordpress.org/ticket/59493))
- Remove measurement in `px` for zero values and remove empty spaces at the ends of lines in CSS. ([\#53874](https://core.trac.wordpress.org/ticket/53874))

## Version 2.8

Released: April 2nd, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/)

- Correct line height CSS for the Button block. ([\#58443](https://core.trac.wordpress.org/ticket/58443))
- Add `border-radius` to avatar images in the editor. This ensures that avatars design in the Post Author or Avatar blocks in the editor matches the front end. ([\#59285](https://core.trac.wordpress.org/ticket/59285))
- Adjust CSS selectors to ensure that the Customizer Color option works on multiple WordPress versions. Corrects the color for the file, button, quote, pullquote, and search blocks. ([\#59922](https://core.trac.wordpress.org/ticket/59922))
- Fix typos ([\#60268](https://core.trac.wordpress.org/ticket/60268), ([\#60310](https://core.trac.wordpress.org/ticket/60310))

## Version 2.7

Released: November 7, 2023

- Set the default width and height attributes of the SVG social icons to match the dimensions used within the CSS ([\#45950](https://core.trac.wordpress.org/ticket/45950))
- Add margins to editor iframe content ([\#59449](https://core.trac.wordpress.org/ticket/59449))
- Correct the required WordPress version in theme headers ([\#59557](https://core.trac.wordpress.org/ticket/59557))
- Display default “Blue” and “Dark blue” color names correctly in the color palette ([\#59566](https://core.trac.wordpress.org/ticket/59566))
- Update default themes to use new script function signature: the last parameter of `wp_enqueue_script()` is an array instead of the boolean `true` ([\#59302](https://core.trac.wordpress.org/ticket/59302))
- Use `defer` loading strategy for theme scripts ([\#59316](https://core.trac.wordpress.org/ticket/59316))

## Version 2.6

Released: August 8, 2023

- Ensure Separator block supports theme preset colors in the editor ([\#58558](https://core.trac.wordpress.org/ticket/58558))
- Set the body background color and foreground color together ([\#45916](https://core.trac.wordpress.org/ticket/45916))
- Fix a translation issue in Comments navigation text, ensuring that translators can control word order for “Previous Comments” and “Next Comments” links ([\#58149](https://core.trac.wordpress.org/ticket/58149))
- Add the `#content` fragment identifier to paginated links so the screen scrolls down to the content section when clicking on pagination links located on paginated pages ([\#45920](https://core.trac.wordpress.org/ticket/45920))
- Prevent an `event.target.matches` console error related to the main navigation on Firefox ([\#46474](https://core.trac.wordpress.org/ticket/46474))
- Remove unused function parameters and variables ([\#57397](https://core.trac.wordpress.org/ticket/57397))
- Deprecate the skip link focus fix, removing the script from the `wp_print_footer_scripts` action ([\#54421](https://core.trac.wordpress.org/ticket/54421))
- Remove call to `load_theme_textdomain()` function ([\#58318](https://core.trac.wordpress.org/ticket/58318))
- Add “Requires PHP” to readme.txt ([\#57857](https://core.trac.wordpress.org/ticket/57857))

## Version 2.5

Released: March 29, 2023

- Remove the incorrect “flexible-header” tag. ([\#46213](https://core.trac.wordpress.org/ticket/46213))
- Remove title attributes ([\#57199](https://core.trac.wordpress.org/ticket/57199))
- Mark strings for screen readers ([\#29748](https://core.trac.wordpress.org/ticket/29748))
- Use the new `/documentation/` URLs for HelpHub links ([\#57726](https://core.trac.wordpress.org/ticket/57726))
- Use strict comparison in bundled themes’ PHP files. ([\[55420](https://core.trac.wordpress.org/changeset/55420)\])
- Update PostCSS to version 8.x. ([\#57554](https://core.trac.wordpress.org/ticket/57554))

## Version 2.4

Released: November 1, 2022

- Consider a custom hover/underline style ([\#45925](https://core.trac.wordpress.org/ticket/45925))
- Consider syncing up font smoothing between the front end and block-based editor ([\#45909](https://core.trac.wordpress.org/ticket/45909))
- Pullquote Block Text Color not reflected on frontend ([\#55981](https://core.trac.wordpress.org/ticket/55981))
- Search Button hover color issue ([\#56573](https://core.trac.wordpress.org/ticket/56573))
- Text color not reflected in Editor for citation in Quote block ([\#55992](https://core.trac.wordpress.org/ticket/55992))
- Remove closing PHP tags from bundled themes ([\#40039](https://core.trac.wordpress.org/ticket/40039))

## Version 2.3

Released: May 24, 2022

- Avoid columns set to full width to extend beyond editor bounds ([\#54169](https://core.trac.wordpress.org/ticket/54169))
- Display Image block at the same size whether the image is linked or not ([\#48697](https://core.trac.wordpress.org/ticket/48697))
- Define List item separator as a WP\_Locale property ([\#39733](https://core.trac.wordpress.org/ticket/39733))
- Override flex order in comment form ([\#46600](https://core.trac.wordpress.org/ticket/46600))
- Rename parameters that use reserved keywords in bundled themes ([\#55327](https://core.trac.wordpress.org/ticket/55327))
- Update NPM dependencies for default themes ([\#54727](https://core.trac.wordpress.org/ticket/54727))
- Note visually hidden text for translators ([\#55591](https://core.trac.wordpress.org/ticket/55591))

## Version 2.2

Released: January 25, 2022

- Return type not matched in PHPDoc – Bundled Themes ([\#53878](https://core.trac.wordpress.org/ticket/53878))
- Remove “role” attribute on HTML5 elements with a default landmark role. ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Core themes need to display required text field information ([\#54392](https://core.trac.wordpress.org/ticket/54392))
- Bundled Themes: Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 2.1

Released: July 20, 2021

- Set a default color for button links in the editor. ([\#52555](https://core.trac.wordpress.org/ticket/52555))
- Fix pullquote styling in editor when block has alignment. ([\#53112](https://core.trac.wordpress.org/ticket/53112))
- Update margins on full- and wide-aligned blocks in the editor. ([\#53428](https://core.trac.wordpress.org/ticket/53428))
- Correct customzier typo. ([\#53598](https://core.trac.wordpress.org/ticket/53598))

## Version 2.0

Released: March 9, 2021

- Add “Read More” link text when using post excerpts. ([\#46177](https://core.trac.wordpress.org/ticket/46177))
- Add space between checkbox and text on for the cookies checkbox comments. ([\#46601](https://core.trac.wordpress.org/ticket/46601))
- unordered list styles in RTL languages. ([\#51573](https://core.trac.wordpress.org/ticket/51573))
- Synchronise ignored files between git and svn. ([\#52502](https://core.trac.wordpress.org/ticket/52502))

## Version 1.9

Released: December 22, 2020

- Add images for use in block patterns. ([\#51996](https://core.trac.wordpress.org/ticket/51996))
- Add the block-patterns tag to the appropriate SASS file. ([\#52159](https://core.trac.wordpress.org/ticket/52159))

## Version 1.8

Released: December 8, 2020

- Remove unnecessary references to some variables in twentynineteen\_hsl\_hex() before they are defined. ([\#49052](https://core.trac.wordpress.org/ticket/49052))
- Remove trailing commas after selectors in style-editor.scss. Remove one empty CSS block. ([\#51095](https://core.trac.wordpress.org/ticket/51095))
- Introduce block patterns for Twenty Nineteen. Add block-patterns tag to Twenty Nineteen. ([\#51099](https://core.trac.wordpress.org/ticket/51099))
- Correct punctuation in “Your comment is awaiting moderation” string. ([\#49867](https://core.trac.wordpress.org/ticket/49867))
- Declare support for the html5 feature navigation-widgets. ([\#51445](https://core.trac.wordpress.org/ticket/51445))
- Remove extra space from the comment link in TwentyNineteen\_Walker\_Comment. ([\#51533](https://core.trac.wordpress.org/ticket/51533))
- Docs: Fix and upgrade object docblock notations. ([\#50768](https://core.trac.wordpress.org/ticket/50768#comment:28))

## Version 1.7

Released: August 11, 2020

- Fixes the issue by adding specific styles for the horizontal rule tag. ([\#45912](https://core.trac.wordpress.org/ticket/45912))
- Add changes on horizontal rule tag to style-rtl.css file. ([\#45912](https://core.trac.wordpress.org/ticket/45912))
- Fixes dropcap appearing higher than expected in Firefox issue by adding moz specific top margin for the dropcap. ([\#45876](https://core.trac.wordpress.org/ticket/45876))
- Fixes the issue of long submenu item titles that do not wrap. ([\#45866](https://core.trac.wordpress.org/ticket/45866))
- Update editor styles to prepare for changes coming to the editor in 5.5. ([\#49613](https://core.trac.wordpress.org/ticket/49613))
- Ensure parity between the block editor and the front-end in Twenty Nineteen. ([\#49843](https://core.trac.wordpress.org/ticket/49843))

## Version 1.6

Released: June 10, 2020

- Consider decreasing the font size for widget titles. ([\#45865](https://core.trac.wordpress.org/ticket/45865))
- Center- and right-aligned heading accents appear broken. ([\#49699](https://core.trac.wordpress.org/ticket/49699))

## Version 1.5

Released: March 31, 2020

- Improve code organisation in template-functions.php ([\#45984](https://core.trac.wordpress.org/ticket/45984))
- Fixed Text color setting in pullquote block not applied. ([\#49410](https://core.trac.wordpress.org/ticket/49410))
- Update margins in editor styles to address upcoming block editor margin changes. ([\#48526](https://core.trac.wordpress.org/ticket/48526))

## Version 1.4

Released: May 7, 2019

- Trigger a new `wp_body_open` action immediately after the opening `body` tag, and add shim. ([\#12563](https://core.trac.wordpress.org/ticket/12563), [\#46679](https://core.trac.wordpress.org/ticket/46679))
- Update RTL styles to include less aggressive non-latin font fallbacks. ([\#45731](https://core.trac.wordpress.org/ticket/45731))
- Update readme.txt file content to fix validation errors. ([\#45871](https://core.trac.wordpress.org/ticket/45871))
- Remove stray `÷` character from theme’s SCSS. ([\#46083](https://core.trac.wordpress.org/ticket/46083))
- Remove forced left border on the quote block. ([\#46239](https://core.trac.wordpress.org/ticket/46239))
- Avoid nested links in the comment meta. ([\#46291](https://core.trac.wordpress.org/ticket/46291))
- Improve custom color behavior for InnerBlocks. ([\#46432](https://core.trac.wordpress.org/ticket/46432))
- Fix padding discrepancies in responsive styles for the Columns block. ([\#46643](https://core.trac.wordpress.org/ticket/46643), [\#46999](https://core.trac.wordpress.org/ticket/46999))
- Correct theme’s URL to its location in the WordPress.org Theme Repository. ([\#46668](https://core.trac.wordpress.org/ticket/46668))
- Prevent too-long strings from causing horizontal scrolling. ([\#46704](https://core.trac.wordpress.org/ticket/46704))
- Fix inconsistent indentation in the theme’s SCSS. ([\#46821](https://core.trac.wordpress.org/ticket/46821))
- Fix inconsistent HTML comments after closing HTML tags. ([\#46871](https://core.trac.wordpress.org/ticket/46871))

## Version 1.3

Released: February 21, 2019

- Fix page title alignment when there are no posts. ([\#45887](https://core.trac.wordpress.org/ticket/45887))
- Implement a less aggressive approach to non-latin font fallbacks. ([\#45731](https://core.trac.wordpress.org/ticket/45731))

## Version 1.2

Released: January 9, 2019

- Update navigation JavaScript so it no longer follows links on touch start . ([\#45510](https://core.trac.wordpress.org/ticket/45510))
- Correct opacity and text shadow on submenus when there’s a featured image. ([\#45689](https://core.trac.wordpress.org/ticket/45689))
- Update the theme’s description and tags. ([\#45693](https://core.trac.wordpress.org/ticket/45693))
- Improve menu’s semantics and keyboard navigation. ([\#45713](https://core.trac.wordpress.org/ticket/45713))
- Remove underline from icon next to ‘Continue Reading’ link. ([\#45715](https://core.trac.wordpress.org/ticket/45715))
- Style right-aligned images to be pushed outside of the content column on the front end, to match how they look in the editor. ([\#45716](https://core.trac.wordpress.org/ticket/45716))
- Correct hover styles on outlined button blocks. ([\#45726](https://core.trac.wordpress.org/ticket/45726))
- Bump version numbers of updated scripts and stylesheets to prevent caching. ([\#45679](https://core.trac.wordpress.org/ticket/45679))

## Version 1.1

Released: December 19, 2018

- General code and documentation improvements. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44187](https://core.trac.wordpress.org/changeset/44187) and [r44199](https://core.trac.wordpress.org/changeset/44199))
- Remove customization to the block editor toolbar that was causing issues. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44189](https://core.trac.wordpress.org/changeset/44189))
- Add breakpoint to columns block for better display on tablets. ([\#45369](https://core.trac.wordpress.org/ticket/45369))
- Correct issue with primary color theme option not working. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44192](https://core.trac.wordpress.org/changeset/44192))
- Add front end center align styles for the archive and category blocks. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44193](https://core.trac.wordpress.org/changeset/44193))
- Fix image\_filter theme option conditional function. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44193](https://core.trac.wordpress.org/changeset/44193))
- Remove duplicate rule-line when a separator block is followed by H1/H2 in the editor. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44193](https://core.trac.wordpress.org/changeset/44193))
- Fix the gallery caption link color. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44196](https://core.trac.wordpress.org/changeset/44196))
- Remove left padding from pullquote blocks. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44196](https://core.trac.wordpress.org/changeset/44196))
- Print `skip-link-focus-fix` inline instead of enqueuing as blocking script. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44196](https://core.trac.wordpress.org/changeset/44196))
- Improve strings with placeholders to make them easier to translate. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44196](https://core.trac.wordpress.org/changeset/44196))
- Fix PHP warning that appeared in on single posts with featured images. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44199](https://core.trac.wordpress.org/changeset/44199))
- Add missing text domain and escaping to comment author text. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44199](https://core.trac.wordpress.org/changeset/44199))
- Remove hyphens rule for cover block text. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44199](https://core.trac.wordpress.org/changeset/44199))
- Fix left/right-aligned pullquote spacing. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44201](https://core.trac.wordpress.org/changeset/44201))
- Improve `readme.txt` to follow the correct standards for themes. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44201](https://core.trac.wordpress.org/changeset/44201))
- Sync up minor code formatting and missing styles from GitHub repo to SVN. ([\#45424](https://core.trac.wordpress.org/ticket/45424), in [r44202](https://core.trac.wordpress.org/changeset/44202))

## Version 1.0

Released: December 6, 2018

Initial Release.
