---
type: document
title: Twenty Twenty changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-twenty-changelog/"
tags:
timestamp: "2026-06-16T19:28:48+00:00"
wordpress:
  id: 2291
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:48"
  date_gmt: "2026-06-16 19:28:48"
  modified: "2026-06-16 19:28:48"
  modified_gmt: "2026-06-16 19:28:48"
  slug: twenty-twenty-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-twenty-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 3.1

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Fix Pullquote block citation’s letter case in the editor, when a user selects one of the Letter case settings. ([\#62773](https://core.trac.wordpress.org/ticket/62773))
- Update `.screen-reader-text` class with `word-break` reset, to ensure screen readers will not read text as individual letters in hidden text. ([\#64375](https://core.trac.wordpress.org/ticket/64375))
- Consistently escape `get_search_query()` in `index.php` template. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Update all references to the Verse block to Poetry. ([\#64658](https://core.trac.wordpress.org/ticket/64658))
- Documentation: Fix `@return` type in template functions. ([\[61676\]](https://core.trac.wordpress.org/changeset/61676))
- Documentation: Add missing `@return` tags and descriptions. ([\#64277](https://core.trac.wordpress.org/ticket/64277))
- Documentation: Add missing variable names to some `@param` tags. ([\[61317\]](https://core.trac.wordpress.org/changeset/61317))
- Documentation: Remove unnecessary annotations, such as `EscapeOutput`, for the `WordPress-Extra` coding standard. ([\[61643\]](https://core.trac.wordpress.org/changeset/61643))

## Version 3.0

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Use `wp_print_inline_script_tag()` when available to construct scripts while also ensuring filters may inject additional attributes on the `<script>` tags, such as nonce for Content Security Policy (CSP). ([\#63806](https://core.trac.wordpress.org/ticket/63806))
- Change the ‘Older posts’ and ‘Newer posts’ labels for post navigation links when the sort order is ascending so the labels accurately reflect the target pages. ([\#10219](https://core.trac.wordpress.org/ticket/10219))
- Prevent output of empty heading and/or link tags if the Site Title or Tagline has no value. ([\#44656](https://core.trac.wordpress.org/ticket/44656))
- Fix scroll jump when closing navigation and search modals, which occurred if the close button was triggered while the page was not scrolled all the way to the top. ([\#52116](https://core.trac.wordpress.org/ticket/52116))
- Fix font inconsistency for Latest Posts block by ensuring that the font used on the front end is also used in the block editor. ([\#63798](https://core.trac.wordpress.org/ticket/63798))
- Use appropriate JSON encoding flags for `twentytwenty-customize-preview` script tag. ([\#63851](https://core.trac.wordpress.org/ticket/63851))
- Add `label` text to use explicit labels (with `for` and `id` attributes) in Customizer hue picker. ([\#42078](https://core.trac.wordpress.org/ticket/42078))
- Include correct Docblock for `do_action( 'wp_body_open' )`. ([\#63654](https://core.trac.wordpress.org/ticket/63654))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))
- Update `npm` dependencies. ([\#63171](https://core.trac.wordpress.org/ticket/63171))

## Version 2.9

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Dismiss navigation submenus with the `esc` key. [\#49950](https://core.trac.wordpress.org/ticket/49950)
- Add `rel="home"` to the site logo link, and add `aria-current="page"` when visiting the front page. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Update `.screen-reader-text` class, removing the obsolete `clip` property and prefixed instances of `-webkit-clip-path`. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Correct the font weight of the Quote block in the editor. [\#62753](https://core.trac.wordpress.org/ticket/62753)
- Fix spacing between post content and the author or date in the Latest Posts block. [\#62243](https://core.trac.wordpress.org/ticket/62243)
- Add a solid border style for the Pullquote block in the editor when the user selects a border color or thickness. [\#62301](https://core.trac.wordpress.org/ticket/62301)
- Update `npm` dependencies. [\[59530\]](https://core.trac.wordpress.org/changeset/59530)

## Version 2.8

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Adjust margins in the Customizer so that the widget edit buttons are not obstructed on smaller screens. ([\#49008](https://core.trac.wordpress.org/ticket/49008))
- Correct `font-size` for Code block and other preformatted elements. ([\#61845](https://core.trac.wordpress.org/ticket/61845))
- Show the Verse block in the same font family in the editor as it has on the front end. ([\#61140](https://core.trac.wordpress.org/ticket/61140))
- Reorganize color styles so that selecting a background color does not override selected text colors—in any block—or the color chosen for a Separator block. ([\#57544](https://core.trac.wordpress.org/ticket/57544))
- Adjust the border styles for Quote blocks that set alignment with classes. ([\#61132](https://core.trac.wordpress.org/ticket/61132))
- Add missing Plain style for the Quote block. ([\#56011](https://core.trac.wordpress.org/ticket/56011))
- Respect user-defined font size settings in Table and Calendar blocks. ([\#56157](https://core.trac.wordpress.org/ticket/56157), [\#59996](https://core.trac.wordpress.org/ticket/59996))
- Respect user-defined typography settings in the Pullquote block. ([\#55975](https://core.trac.wordpress.org/ticket/55975))
- Fix the alignment of centered block captions on screens narrower than 1,000 pixels. ([\#50317](https://core.trac.wordpress.org/ticket/50317))
- Remove extra space from viewport meta tag. [\[59026\]](https://core.trac.wordpress.org/changeset/59026)
- Load block patterns on the `init` hook to avoid triggering notices caused by loading the translations too early. ([\#62237](https://core.trac.wordpress.org/ticket/62237))
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 2.7

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/)

- Fix the margins and padding of ordered and unordered lists within the editor. ([\#56083](https://core.trac.wordpress.org/ticket/56083))
- Fix Button block link letter spacing to match what a user might select in the block’s typography settings. ([\#58024](https://core.trac.wordpress.org/ticket/58024))
- Fix `code` element showing outside of section area. ([\#52780](https://core.trac.wordpress.org/ticket/52780))
- Remove empty spaces at the ends of lines in CSS. ([\#53874](https://core.trac.wordpress.org/ticket/53874))
- Use the `$theme_version` variable for the Inter font stylesheet. ([\#60779](https://core.trac.wordpress.org/ticket/60779))
- Update `npm` dependencies. ([\[58562\]](https://core.trac.wordpress.org/changeset/58562))
- Correct typos in JavaScript wordmark. ([\[58397\]](https://core.trac.wordpress.org/changeset/58397/trunk/src/wp-content/themes/twentytwenty))
- Fix spelling mistake in `intrinsicRatioVideos`. ([\[57987\]](https://core.trac.wordpress.org/changeset/57987/trunk/src/wp-content/themes/twentytwenty))

## Version 2.6

Released: April 2nd, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/)

- Replace `wp_date()` with `date_i18n()` ([\#48589](https://core.trac.wordpress.org/ticket/48589))
- Move the Inter font declaration to a separate file and enqueue the file. This allows the font to be dequeued by a child theme or plugin. ([\#48630](https://core.trac.wordpress.org/ticket/48630))
- Fix Table block default and custom border colors. ([\#58022](https://core.trac.wordpress.org/ticket/58022))
- Scope `.privacy-policy` styles to the footer only. This changeset fixes an issue where the `.privacy-policy` styles were applied to other locations than the footer exclusively, like the `privacy-policy` page itself. ([\#60469](https://core.trac.wordpress.org/ticket/60469))

## Version 2.5

Released: January 16, 2024.

- Revert usage of `str_contains()` in older bundled themes ([\#60241](https://core.trac.wordpress.org/ticket/57377))

## Version 2.4

Released: November 7, 2023 with [WordPress 6.4](https://wordpress.org/documentation/wordpress-version/version-6-4/).

- Fix text color in the iframe editor when the background color is dark ([\#59086](https://core.trac.wordpress.org/ticket/59086))
- Update default themes to use new script function signature: the last parameter of `wp_enqueue_script()` is an array instead of the boolean `true` or `false` ([\#59302](https://core.trac.wordpress.org/ticket/59302))
- Use `defer` loading strategy for theme scripts ([\#59316](https://core.trac.wordpress.org/ticket/59316))

## Version 2.3

Released: August 8, 2023 with [WordPress 6.3](https://wordpress.org/documentation/wordpress-version/version-6-3/)

- Fix Button block text color when located in footer widgets ([\#57087](https://core.trac.wordpress.org/ticket/57087))
- Fix Letter Case control implementation on the Button block ([\[56000\]](https://core.trac.wordpress.org/changeset/56000))
- Inherit Quote block’s paragraph custom letter spacing in the editor ([\#58033](https://core.trac.wordpress.org/ticket/58033))
- Fix left margin in Latest Posts &amp; Latest Comments blocks ([\#58396](https://core.trac.wordpress.org/ticket/58396))
- Remove various unused function parameters and variables ([\#57371](https://core.trac.wordpress.org/ticket/57371))
- Deprecate the skip link focus fix, removing the script from the `wp_print_footer_scripts` action ([\#54421](https://core.trac.wordpress.org/ticket/54421))
- Remove call to `load_theme_textdomain()` function ([\#58318](https://core.trac.wordpress.org/ticket/58318))
- Add “Requires at least” and “Requires PHP” to readme.txt ([\#57857](https://core.trac.wordpress.org/ticket/57857))

## Version 2.2

Released: March 29, 2023 with [WordPress 6.2](https://wordpress.org/news/2023/03/dolphy/)

- Add Mastodon domains for menu item icons. ([\#49099](https://core.trac.wordpress.org/ticket/49099))
- Mark strings for screen readers ([\#29748](https://core.trac.wordpress.org/ticket/29748))
- Pullquote block: Add citation text color issue ([\#55990](https://core.trac.wordpress.org/ticket/55990))
- Use the new `/documentation/` URLs for HelpHub links in Bundled Themes. ([\#57726](https://core.trac.wordpress.org/ticket/57726))
- Use strict comparison in bundled themes’ PHP files. (\[[55420](https://core.trac.wordpress.org/changeset/55420/trunk/src/wp-content/themes)\])
- Deprecation warnings on PHP 8.1 because of `wp_add_inline_style()` ([\#57777](https://core.trac.wordpress.org/ticket/57777))
- Improve various globals documentation, as per docblock standards. (\[[55472](https://core.trac.wordpress.org/changeset/55472)\])
- Remove title attributes ([\#57199](https://core.trac.wordpress.org/ticket/57199))

## Version 2.1

Released: November 1, 2022 with [WordPress 6.1](https://wordpress.org/news/2022/11/misha/)

- “Add citation” text font-style issue in Quote block ([\#](https://core.trac.wordpress.org/ticket/49099)[55931](https://core.trac.wordpress.org/ticket/55931))
- “Wide line” separator breaks inside columns. ([\#](https://core.trac.wordpress.org/ticket/49099)[53643](https://core.trac.wordpress.org/ticket/53643))
- Comments accessibility – links should be identifiable ([\#](https://core.trac.wordpress.org/ticket/49099)[56269](https://core.trac.wordpress.org/ticket/56269))
- Fix social icons margin in widget area ([\#](https://core.trac.wordpress.org/ticket/49099)[56474](https://core.trac.wordpress.org/ticket/56474))
- Latest Posts block set to 2 columns displays single column in editor ([\#](https://core.trac.wordpress.org/ticket/49099)[56175](https://core.trac.wordpress.org/ticket/56175))
- Post title block alignment setting is not working ([\#](https://core.trac.wordpress.org/ticket/49099)[56167](https://core.trac.wordpress.org/ticket/56167))
- Remove Left Padding in Social icon block in editor ([\#](https://core.trac.wordpress.org/ticket/49099)[55987](https://core.trac.wordpress.org/ticket/55987))
- Separator Block backslash issue in editor ([\#](https://core.trac.wordpress.org/ticket/49099)[55910](https://core.trac.wordpress.org/ticket/55910))
- Width discrepancy between editor and preview when nested in cover block ([\#](https://core.trac.wordpress.org/ticket/49099)[56049](https://core.trac.wordpress.org/ticket/56049))
- Button-style link with Outline style is missing the border ([\#](https://core.trac.wordpress.org/ticket/49099)[55824](https://core.trac.wordpress.org/ticket/55824))
- Links do not inherit user-defined text colors in the editor ([\#](https://core.trac.wordpress.org/ticket/49099)[56214](https://core.trac.wordpress.org/ticket/56214))
- style of rtl paragraph ([\#](https://core.trac.wordpress.org/ticket/49099)[49447](https://core.trac.wordpress.org/ticket/49447))
- text-transform issue in H6 Heading block ([\#](https://core.trac.wordpress.org/ticket/49099)[56194](https://core.trac.wordpress.org/ticket/56194))
- update selectors in `get_non_latin_css()` ([\#](https://core.trac.wordpress.org/ticket/49099)[56396](https://core.trac.wordpress.org/ticket/56396))
- word wrap in comments required message ([\#](https://core.trac.wordpress.org/ticket/49099)[56397](https://core.trac.wordpress.org/ticket/56397))
- Correctly escape stylesheet URL ([\#](https://core.trac.wordpress.org/ticket/49099)[56696](https://core.trac.wordpress.org/ticket/56696))
- Remove closing PHP tags from bundled themes ([\#](https://core.trac.wordpress.org/ticket/49099)[40039](https://core.trac.wordpress.org/ticket/40039))

## Version 2.0

Released: May 24, 2022 with [WordPress 6.0](https://wordpress.org/news/2022/05/arturo/)

- Add Noto Serif as a fallback font before Garamond ([\#50723](https://core.trac.wordpress.org/ticket/50723))
- Improve padding for number input type ([\#53115](https://core.trac.wordpress.org/ticket/53115))
- Fix aria-expanded handling in search toggle ([\#53951](https://core.trac.wordpress.org/ticket/53951))

## Version 1.9

Released: January 25, 2022

- Add Support for wa.me (WhatsApp’s preferred link) ([\#50542](https://core.trac.wordpress.org/ticket/50542))
- Add privacy policy link to footer ([\#53446](https://core.trac.wordpress.org/ticket/53446))
- Custom Logo bug in the Customizer ([\#51337](https://core.trac.wordpress.org/ticket/51337))
- Editor title alignment broken by Gutenberg plugin v11.4.0 updates ([\#54056](https://core.trac.wordpress.org/ticket/54056))
- Inline style class names are duplicated ([\#54196](https://core.trac.wordpress.org/ticket/54196))
- Remove “role” attribute on HTML5 elements with a default landmark role ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Bundled Themes: Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 1.8

Released: July 20, 2021

- Ensure custom primary color is applied to text in the editor ([\#50120](https://core.trac.wordpress.org/ticket/50120))
- Hide some elements for print that are not useful in that context ([\#50433](https://core.trac.wordpress.org/ticket/50433))
- Correct `label` attribute references to `aria_label` in `get_search_form` ([\#51877](https://core.trac.wordpress.org/ticket/51877))
- Update theme information in the `package.json` file ([\#53196](https://core.trac.wordpress.org/ticket/53196))
- Remove extra margin within the Query Loop block ([\#53482](https://core.trac.wordpress.org/ticket/53482))

## Version 1.7

Released: March 9, 2021

- Ordered list styling in Classic Editor ([\#50454](https://core.trac.wordpress.org/ticket/50454))
- Core blocks are positioned incorrectly in some core bundled themes ([\#52009](https://core.trac.wordpress.org/ticket/52009))
- Exclude Twenty Twenty from .gitignore ([\#52265](https://core.trac.wordpress.org/ticket/52265))
- Remove aria-expanded on Close Search button ([\#52355](https://core.trac.wordpress.org/ticket/52355))
- RTL list styles ([\#52401](https://core.trac.wordpress.org/ticket/52401))
- Synchronise ignored files between git and svn ([\#52502](https://core.trac.wordpress.org/ticket/52502))

## Version 1.6

Released: December 8, 2020

- Add context to adjectives and homonyms. This allows for better localization in languages where adjectives are translated differently depending on which noun they modify, or when a different translation is required for a noun vs. a verb. ([\#49797](https://core.trac.wordpress.org/ticket/49797))
- Introduce block patterns for Twenty Twenty and add the block-patterns tag. ([\#51098](https://core.trac.wordpress.org/ticket/51098))
- Correct heading blocks alignment in editor styles. This explicitly sets top and bottom margins instead of defining all four sides in shorthand notation. ([\#51148](https://core.trac.wordpress.org/ticket/51148))
- Update the URL for PHP date formats table in translator comments. ([\#51335](#51335))
- Correctly indent nested unordered lists in RTL editor styles. ([\#51574](https://core.trac.wordpress.org/ticket/51574))
- Declare support for the HTML5 feature navigation-widgets. ([\#51445](https://core.trac.wordpress.org/ticket/51445))
- Remove extra space from the comment link in TwentyTwenty\_Walker\_Comment. ([\#51533](https://core.trac.wordpress.org/ticket/51533))

## Version 1.5

Released: August 11, 2020

- Ensure appropriate title for author archives for that don’t have posts. ([\#50421](https://core.trac.wordpress.org/ticket/50421))
- Twenty Twenty uses overly specific selector for button background. ([\#50271](https://core.trac.wordpress.org/ticket/50271))
- Modifies the Customize setting Site Identity &gt; Retina logo so that the option is hidden if there is no logo is set in Site Identity &gt; Logo. ([\#50109](https://core.trac.wordpress.org/ticket/50109))
- Removes the unnecessary `$css_dependencies` variable in `twentytwenty_block_editor_styles()`. ([\#49986](https://core.trac.wordpress.org/ticket/49986))
- Fixes the issue with button styles not working when the Gutenberg plugin is activated while maintaining backwards compatibility. ([\#49896](https://core.trac.wordpress.org/ticket/49896))
- Fixes the issue of caption being escaped by replacing `esc_html` with `wp_kses_post` in the caption in featured images. ([\#49833](https://core.trac.wordpress.org/ticket/49833))
- Removes `text-transform: uppercase;` from button blocks in order to give the user the option to have a button without All Capital letters. ([\#49710](https://core.trac.wordpress.org/ticket/49710))
- Fixes the disappearing + in the block editor when using the latest version of the Gutenberg plugin. ([\#49610](https://core.trac.wordpress.org/ticket/49610))
- Fixes the image alignment issue by removing `margin-left: auto;` and `margin-right: auto;` from `.editor-styles-wrapper .wp-block-image.is-resized`. ([\#49600](https://core.trac.wordpress.org/ticket/49600))
- Fixes the issue of number of comments not translatable by removing the single quote from around the 1 in the `elseif` conditional of the comments template. ([\#49058](https://core.trac.wordpress.org/ticket/49058))
- Adds a Social Icons Filter to Twenty Twenty that allows for new icons to be added to the theme by filter. ([\#48713](https://core.trac.wordpress.org/ticket/48713))

## Version 1.4

Released: June 10, 2020

- Fixed comments template number of replies not translatable. ([\#49058](https://core.trac.wordpress.org/ticket/49058))
- Fixed inconsistent top and bottom margins for `.alignwide` and `.alignfull` on Chrome vs Safari. ([\#](#49435)[49435](https://core.trac.wordpress.org/ticket/49435))
- Fixed HTML in featured image caption is being escaped. ([\#49833](https://core.trac.wordpress.org/ticket/49833))
- Fixed small typo. ([\#49932](https://core.trac.wordpress.org/ticket/49932))
- Fixed uses overly specific selector for button background. ([\#50271](https://core.trac.wordpress.org/ticket/50271))

## Version 1.3

Released: May 14, 2020

- Fixed custom post types that don’t support authors, shows author box. ([\#48803](https://core.trac.wordpress.org/ticket/48803))
- Fixed anchor links don’t work in mobile menu. ([\#48916](https://core.trac.wordpress.org/ticket/49523))
- Added icon for g.page links. ([\#49088](https://core.trac.wordpress.org/ticket/49088))
- Fixed missing license for images. ([\#49316](https://core.trac.wordpress.org/ticket/49316))
- Fixed image caption is not aligned center when image is, on the front-end. ([\#49320](https://core.trac.wordpress.org/ticket/49320))
- Fixed submenu items disappearing underneath the Cover block. ([\#49322](https://core.trac.wordpress.org/ticket/49322))
- Fixed resized images are centered inside the editor (with no alignment set) since WordPress 5.4. ([\#49600](https://core.trac.wordpress.org/ticket/49600))
- Fixed block editor inserter is missing the `+`. ([\#49610](https://core.trac.wordpress.org/ticket/49610))
- Fixed inline images in list blocks are not positioned correctly. ([\#49793](https://core.trac.wordpress.org/ticket/49793))
- Added GPLv2 compatible TikTok icon to the social icon menu. ([\#49893](https://core.trac.wordpress.org/ticket/49893))
- Fixed button styles produce inconsistent output and cannot be edited. ([\#49896](https://core.trac.wordpress.org/ticket/49896))
- Fixed remove unnecessary `$css_dependencies` variable in `twentytwenty_block_editor_styles()`. ([\#49986](https://core.trac.wordpress.org/ticket/49986))
- Added customizer retina\_logo should be hidden when no logo is set. ([\#50109](https://core.trac.wordpress.org/ticket/50109))

## Version 1.2

Released: March 31, 2020

- Remove Non-printable characters from starter-content.php file ([\#49534](https://core.trac.wordpress.org/ticket/48550))
- Fixed searchform.php error ([\#49523](https://core.trac.wordpress.org/ticket/49523))
- Fixed Author Bio/Post Meta Width in Cover Template in Mobile ([\#49254](https://core.trac.wordpress.org/ticket/49254))
- Remove unnecessary escaping for get\_the\_title() ([\#49190](https://core.trac.wordpress.org/ticket/49190))
- Added social icon for WhatsApp ([\#49098](https://core.trac.wordpress.org/ticket/49098))
- Fixed Property font-size is overwritten – coding standard. ([\#49015](https://core.trac.wordpress.org/ticket/49015))
- Fixed Property border-style is overwritten – coding standard. ([\#49006](https://core.trac.wordpress.org/ticket/49006))
- Fixed Post nav pages link outside of the container ([\#48979](https://core.trac.wordpress.org/ticket/48979))
- Fixed Menu rendering problem Unicode (Bangla) ([\#48970](https://core.trac.wordpress.org/ticket/48970))
- Fixed Menu on a mobile device becomes responsive after tapping a few times and switching pages ([\#48643](https://core.trac.wordpress.org/ticket/48643))
- Added theme support for responsive embeds ([\#48552](https://core.trac.wordpress.org/ticket/48552))
- Update calendar widget styles for 5.4 markup. ([\#49549](https://core.trac.wordpress.org/ticket/49549))

## Version 1.1

Released: December 12, 2019

- Add customizer option to show or hide author bio ([\#48550](https://core.trac.wordpress.org/ticket/48550))
- Replace JS-based smooth scroll with CSS ([\#48551](https://core.trac.wordpress.org/ticket/48551), [\#48763](https://core.trac.wordpress.org/ticket/48763), [\#48866](https://core.trac.wordpress.org/ticket/48866))
- Fix on mobile devices using a webkit browser, the menu and search modals could not be opened due to a `TypeError: document.body is null` ([\#48601](https://core.trac.wordpress.org/ticket/48601))
- Fix correctly align the author bio and bottom post meta on single posts on mobile ([\#48619](https://core.trac.wordpress.org/ticket/48619))
- Remove duplicate array key/value in `TwentyTwenty_Non_Latin_Languages::get_non_latin_css()` ([\#48624](https://core.trac.wordpress.org/ticket/48624))
- Make the checkbox in the comment form larger and more consistent with other checkboxes ([\#48652](https://core.trac.wordpress.org/ticket/48652))
- Fix typos in a variable name and inline comment in assets/js/color-calculations.js. ([\#48704](https://core.trac.wordpress.org/ticket/48704))
- Fix placeholder misalignment in Firefox when a `height` is added as an inline style to the input field ([\#48876](https://core.trac.wordpress.org/ticket/48876))
- Pass `$post_meta` and `$location` values to `twentytwenty_start_of_post_meta_list` and `twentytwenty_end_of_post_meta_list` actions to provide better context ([\#48906](https://core.trac.wordpress.org/ticket/48906))
- Remove redundant `echo` for `bloginfo()` call in `footer.php` ([\#48918](https://core.trac.wordpress.org/ticket/48918))

## Version 1.0

Released: November 12, 2019

Initial Release.
