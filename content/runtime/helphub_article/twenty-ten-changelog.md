---
type: document
title: Twenty Ten changelog
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-ten-changelog/"
tags:
timestamp: "2026-06-16T19:28:17+00:00"
wordpress:
  id: 2144
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:17"
  date_gmt: "2026-06-16 19:28:17"
  modified: "2026-06-16 19:28:17"
  modified_gmt: "2026-06-16 19:28:17"
  slug: twenty-ten-changelog
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-ten-changelog/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

## Version 4.6

Released: May 20, 2026 with [WordPress 7.0](https://wordpress.org/documentation/wordpress-version/version-7-0/)

- Remove the auto-focus script, which forced a bypass of the navigation, main heading, and explanation on the 404 error page. ([\#64064](https://core.trac.wordpress.org/ticket/64064))
- Remove default `type` attributes from `script`, `style` and `link` tags because the HTML5 standard does not require them. ([\#64428](https://core.trac.wordpress.org/ticket/64428))
- Consistently escape `get_search_query()` in `search.php` template. ([\#58127](https://core.trac.wordpress.org/ticket/58127))
- Documentation: Add missing variable names to some `@param` tags. ([\[61314\]](https://core.trac.wordpress.org/changeset/61314))

## Version 4.5

Released: December 3, 2025 with [WordPress 6.9](https://wordpress.org/documentation/wordpress-version/version-6-9/)

- Change the ‘Older posts’ and ‘Newer posts’ navigation links when the sort order is ascending so the labels accurately reflect the target pages. ([\#10219](https://core.trac.wordpress.org/ticket/10219))
- Prevent output of empty heading and/or link tags if the Site Title or Tagline has no value. ([\#44656](https://core.trac.wordpress.org/ticket/44656))
- Use third-person singular verbs for function descriptions. ([\#63692](https://core.trac.wordpress.org/ticket/63692))

## Version 4.4

Released: April 15, 2025 with [WordPress 6.8](https://wordpress.org/documentation/wordpress-version/version-6-8/)

- Add `aria-current="page"` on header links that point to the current URL. [\#62895](https://core.trac.wordpress.org/ticket/62895)
- Move the skip link to the top of the body content, so it is the first focusable item on the page, and add CSS for visibility on focus. [\#14795](https://core.trac.wordpress.org/ticket/14795)
- Correct the styling of the File block. [\#62793](https://core.trac.wordpress.org/ticket/62793)
- Update `.screen-reader-text` class, replacing the obsolete `clip` property with `clip-path`. [\#62238](https://core.trac.wordpress.org/ticket/62238)
- Replace references to “Add New” theme screen in `readme` file. [\#61219](https://core.trac.wordpress.org/ticket/61219)

## Version 4.3

Released: November 12th, 2024 with [WordPress 6.7](https://wordpress.org/documentation/wordpress-version/version-6-7/)

- Respect user-defined font size settings in Table and Calendar blocks, and adjust the `line-height` for a different font size. ([\#58362](https://core.trac.wordpress.org/ticket/58362))
- Fix Gallery block caption styles when the Gallery is inside a different block. ([\#50376](https://core.trac.wordpress.org/ticket/50376))
- Document the `$css` parameter in `twentyten_remove_gallery_css()`. ([\[59219\]](https://core.trac.wordpress.org/changeset/59219))
- Load block patterns on the `init` hook to avoid triggering notices caused by loading the translations too early. ([\#62237](https://core.trac.wordpress.org/ticket/62237))
- Add contributors to copyright notices. ([\#61943](https://core.trac.wordpress.org/ticket/61943))

## Version 4.2

Released: July 16th, 2024 with [WordPress 6.6](https://wordpress.org/documentation/wordpress-version/version-6-6/).

- Remove blank CSS lines. ([\#59493](https://core.trac.wordpress.org/ticket/59493))
- Remove measurement in `px` for zero values and reorder `box-shadow` rules in CSS. ([\#53874](https://core.trac.wordpress.org/ticket/53874))

## Version 4.1

Released: April 2nd, 2024 with [WordPress 6.5](https://wordpress.org/documentation/wordpress-version/version-6-5/).

## Version 4.0

Released: November 7, 2023

- Implement `the_header_image_tag` function for enhanced compatibility with new image features such as lazy loading, async decoding and fetch priority ([\#58675](https://core.trac.wordpress.org/ticket/58675))

## Version 3.9

Released: August 8, 2023

- Decrease `line-height` in Pullquote block text and adjust the font size ([\#52546](https://core.trac.wordpress.org/ticket/52546))
- Reflect Heading block text color on front-end ([\#56603](https://core.trac.wordpress.org/ticket/56603))
- Prevent overriding the editor’s Block Inserter icon color ([\#57414](https://core.trac.wordpress.org/ticket/57414))
- Remove call to `load_theme_textdomain()` function if the WordPress version is at least 4.6 ([\#58318](https://core.trac.wordpress.org/ticket/58318))
- Add “Requires at least” and “Requires PHP” to readme.txt ([\#57857](https://core.trac.wordpress.org/ticket/57857))

## Version 3.8

Released: March 29, 2023

- Inconsistent function definition brace ([\#57210](https://core.trac.wordpress.org/ticket/57210))
- Remove title attributes ([\#57199](https://core.trac.wordpress.org/ticket/57199))
- Use strict comparison in bundled themes’ PHP files. ([\[55420](https://core.trac.wordpress.org/changeset/55420)\])

## Version 3.7

Released: November 1, 2022

- Escape ‘`get_permalink`‘ where appropriate in ‘`twentyten/functions.php`‘ ([\#56667](https://core.trac.wordpress.org/ticket/56667))
- Pullquote block paragraph text is too small in editor with WP6.1 ([\#56730](https://core.trac.wordpress.org/ticket/56730))
- Use ‘esc\_url’ for ‘get\_author\_posts\_url’ where appropriate ([\#56674](https://core.trac.wordpress.org/ticket/56674))
- Multiple Themes: Correctly escape stylesheet URL ([\#56696](https://core.trac.wordpress.org/ticket/56695))

## Version 3.6

Released: January 25, 2022

- Remove “role” attribute on HTML5 elements with a default landmark role. ([\#54079](https://core.trac.wordpress.org/ticket/54079))
- Bundled Themes: Add “Tested up to” in style.css ([\#53797](https://core.trac.wordpress.org/ticket/53797))

## Version 3.5

Released: July 26, 2021

- Block patterns file causes error in child themes ([\#53752](https://core.trac.wordpress.org/ticket/53752))
- Bundled themes: block-patterns.php file should use `get_template_directory_uri` instead of `get_stylesheet_directory_uri` ([\#53769](https://core.trac.wordpress.org/ticket/53769))

## Version 3.4

Released: July 20, 2021

- Introduce block patterns for Twenty Ten. ([\#51107](https://core.trac.wordpress.org/ticket/51107))
- Improve display of blocks in widget areas. ([\#53422](https://core.trac.wordpress.org/ticket/53422))

## Version 3.3

Released: March 9, 2021

- For attachments, replace the text “Return to” with “Go to”. ([\#47235](https://core.trac.wordpress.org/ticket/47235))

## Version 3.2

Released: December 8, 2020

- For attachments, replace the text “Return to” with “Go to”. ([\#47235](https://core.trac.wordpress.org/ticket/47235))
- Correct punctuation in “Your comment is awaiting moderation” string. ([\#49867](https://core.trac.wordpress.org/ticket/49867))
- Correct list block alignment in editor styles. ([\#51157](https://core.trac.wordpress.org/ticket/51157) )
- Docs: Fix typo in twentyten\_custom\_excerpt\_more() DocBlock. ([\#50768](https://core.trac.wordpress.org/ticket/50768#comment:25))
- Docs: Fix and upgrade object docblock notations. ([\#50768](https://core.trac.wordpress.org/ticket/50768#comment:28))

## Version 3.1

Released: August 11, 2020

- Add custom color palettes for block editor. ([\#50120](https://core.trac.wordpress.org/ticket/50120))
- Use HTTPS for XHTML Friends Network URL. ([\#48002](https://core.trac.wordpress.org/ticket/48002))
- Consistently check for WP\_Error before outputting get\_the\_tag\_list(). ([\#39860](https://core.trac.wordpress.org/ticket/39860))
- Use strict comparison where static strings are involved. ([\#49542](https://core.trac.wordpress.org/ticket/49542))
- Use comment instead of an empty string for the comment\_type DB field value in comments table. ([\#49236](https://core.trac.wordpress.org/ticket/49236))

## Version 3.0

Released: March 31, 2020

- Update calendar widget styles for 5.4 markup. ([\#49549](https://core.trac.wordpress.org/ticket/49549))

## Version 2.9

Released: May 7, 2019

- Trigger a new `wp_body_open` action immediately after the opening `body` tag, and add shim. ([\#12563](https://core.trac.wordpress.org/ticket/12563), [\#46679](https://core.trac.wordpress.org/ticket/46679))
- Replace `basename()` with `wp_basename()` to support multibyte filenames. ([\#43170](https://core.trac.wordpress.org/ticket/43170))
- Update readme.txt file content to fix validation errors. ([\#45871](https://core.trac.wordpress.org/ticket/45871))
- Update link to child theme documentation to point to its new locations. ([\#46450](https://core.trac.wordpress.org/ticket/46450))
- Fix inconsistent HTML comments after closing HTML tags. ([\#46871](https://core.trac.wordpress.org/ticket/46871))

## Version 2.8

Released: February 21, 2019

- Correct image and caption alignment. ([\#42604](https://core.trac.wordpress.org/ticket/42604))
- Add escaping to the pingback URL. ([\#43717](https://core.trac.wordpress.org/ticket/43717))

## Version 2.7

Released: December 19, 2018

- Fix visited link colors on button blocks using custom colors. ([\#45434](https://core.trac.wordpress.org/ticket/45434))
- Correct block appender appearance in block editor. ([\#45450](https://core.trac.wordpress.org/ticket/45450))
- Remove the term “Gutenberg” from code comments. ([\#45452](https://core.trac.wordpress.org/ticket/45452))

## Version 2.6

Released: December 6, 2018

- Add front end styles, editor styles and a custom color palette for the new block-based editor. ([\#45038](https://core.trac.wordpress.org/ticket/45038) and [\#45238](https://core.trac.wordpress.org/ticket/45238))
- Add theme support for responsive block embeds. ([\#45274](https://core.trac.wordpress.org/ticket/45274))

## Version 2.5

Released: May 17, 2018

- General: Fix some precision alignment formatting warnings. ([\#41057](https://core.trac.wordpress.org/ticket/41057))
- Code is Poetry. WordPress’ code just… wasn’t. ([\#41057](https://core.trac.wordpress.org/ticket/41057))
- Twenty Ten: Use global img contraint for captions. ([\#42604](https://core.trac.wordpress.org/ticket/42604))
- Restore `max-width` on `.wp-caption`. ([\#42604](https://core.trac.wordpress.org/ticket/42604))
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
- Introduce media widgets for images, audio, and video with extensible base for additional media widgets in the future. ([\#32417](https://core.trac.wordpress.org/ticket/32417)), ([\#39993](https://core.trac.wordpress.org/ticket/39993)), ([\#39994](https://core.trac.wordpress.org/ticket/39994)), ([\#39995](https://core.trac.wordpress.org/ticket/39995))

## Version 2.2

Released: August 15, 2016

- Update theme tags. ([\#37426](https://core.trac.wordpress.org/ticket/37426))

## Version 2.1

Released: December 8, 2015

- Correct license information in readme.txt. ([\#33590](https://core.trac.wordpress.org/ticket/33590))

## Version 2.0

Released August 18, 2015

- Add readme file to explain basic theme usage, link to changelog in Codex, and include license information. ([\#31814](https://core.trac.wordpress.org/ticket/31814))

## Version 1.9

Released: April 23, 2015

- Fix escaping and minor code style issues ([\#29127](https://core.trac.wordpress.org/ticket/29127))
- Remove URLs from reset credits ([\#30764](https://core.trac.wordpress.org/ticket/30764))
- Replace current() with reset(), which is guaranteed to be the first item ([\#31259](https://core.trac.wordpress.org/ticket/), [\#31260](https://core.trac.wordpress.org/ticket/31260))
- Update CSS rules for `.screen-reader-text` to be consistent with current accessibility guidelines ([\#31279](https://core.trac.wordpress.org/ticket/31279))
- Use SSL for theme and author URIs ([\#31699](https://core.trac.wordpress.org/ticket/31699))
- Add trailing slashes to theme URIs to avoid a redirect ([\#31839](https://core.trac.wordpress.org/ticket/31839))

## Version 1.8

Released: December 18, 2014

- Add bottom margin to audio and video players. ([\#29146](https://core.trac.wordpress.org/ticket/29146))
- Don’t display modified excerpt link in wp-admin. ([\#30026](https://core.trac.wordpress.org/ticket/30026))
- Prevent the arrow in “Continue reading” links from wrapping to a second line. ([\#27908](https://core.trac.wordpress.org/ticket/27908))

## Version 1.7

Released: September 4, 2014

- Avoid a PHP notice in bundled themes if no images were found. ([\#28361](https://core.trac.wordpress.org/ticket/28361))
- Correct attribute escaping in the attachment template. ([\#28251](https://core.trac.wordpress.org/ticket/28251))
- Prevent ‘Page %s’ from being added to page title on 404 error pages in bundled themes. ([\#16468](https://core.trac.wordpress.org/ticket/16468))
- New screenshots at 880×660 to maximize theme goodness in the new theme viewer design. ([\#26159](https://core.trac.wordpress.org/ticket/26159))
- Revert Twenty Ten’s original screenshot. ([\#26459](https://core.trac.wordpress.org/ticket/26459))
- If a theme only has a very-old-school 300px-wide screenshot (or narrower), don’t stretch it. ([\#26459](https://core.trac.wordpress.org/ticket/26459))
- Add and display new tags to highlight the ever-growing number of responsive themes available. ([\#21442](https://core.trac.wordpress.org/ticket/21442))
- Spell out duplicate hook locations. ([\#25658](https://core.trac.wordpress.org/ticket/))
- Don’t use `/**` docblocks for simple multiline comments. ([\#25256](https://core.trac.wordpress.org/ticket/25256))
- Update code comments to reflect WP inline docs standards. ([\#25256](https://core.trac.wordpress.org/ticket/25256))
- (Theme folder moved to ) New develop.svn.wordpress.org repository based on the old core.svn repository. ([\#24976](https://core.trac.wordpress.org/ticket/24976))

## Version 1.6

August 1, 2013

- Fix style element ID attribute value,. ([\#24033](https://core.trac.wordpress.org/ticket/24033))
- Add helpful descriptions to widget areas. ([\#15401](https://core.trac.wordpress.org/ticket/15401))
- Improve how gallery image IDs are retrieved for use in the Gallery post format template. ([\#23617](https://core.trac.wordpress.org/ticket/23617))
- Remove the\_title\_attribute() title attributes where it duplicates the\_title() in anchor text. ([\#24203](https://core.trac.wordpress.org/ticket/24203))
- Change gallery category post meta output to check for a “gallery” category using get\_term\_by() to avoid a possible WP\_Error for an empty result by getting a false (boolean) return value instead. And, change link output to use get\_category\_link() instead of get\_term\_link().([\#23837](https://core.trac.wordpress.org/ticket/23837))
- Remove the\_title\_attribute() title attributes where it duplicates the\_title() in anchor text. ([\#24203](https://core.trac.wordpress.org/ticket/24203))
- Fix minor indentation issues in CSS files (spaces to tabs). ([r24196](https://core.trac.wordpress.org/changeset/24196))
- Remove /extend/ from Theme URI headers in default themes. ([\#24389](https://core.trac.wordpress.org/ticket/24389))
- Improve color contrast for links and text. ([\#14794](https://core.trac.wordpress.org/ticket/14794))

## Version 1.5

December 11, 2012

- Remove extra end comment and indent code.([\#20469](https://core.trac.wordpress.org/ticket/20469))
- Add new ‘flexible-header’ tag for themes. ([\#21605](https://core.trac.wordpress.org/ticket/21065))
- Remove invalid rel attribute generator from footer markup. ([\#22095](https://core.trac.wordpress.org/ticket/22095))
- Allow show\_home argument to be overridden when using wp\_page\_menu as a fallback to a Custom Menu. ([\#22331](https://core.trac.wordpress.org/ticket/22331))
- Continue reading link should be pluggable. ([\#16500](https://core.trac.wordpress.org/ticket/16500))
- Improve code readability in twentyten\_comment. ([\#21474](https://core.trac.wordpress.org/ticket/21474))

## Version 1.4

June 13, 2012

- Coding standard: Use one space, not two, after trailing punctuation. ([\#19537](https://core.trac.wordpress.org/ticket/19537))
- Remove custom header and background constants. ([\#20249](https://core.trac.wordpress.org/ticket/20249))
- Update theme to use add\_theme\_support() for headers and backgrounds. ([\#20265](https://core.trac.wordpress.org/ticket/20265))
- Provide backward compatibility for custom header in bundled theme. ([\#20768](https://core.trac.wordpress.org/ticket/20768))

## Version 1.3

December 12, 2011

- Make date formats for translation. ([\#16441](https://core.trac.wordpress.org/ticket/16441))
- Fix alignment buttons when there is no content in editor under RTL. ([\#18247](https://core.trac.wordpress.org/ticket/18247))
- Fix UL, OL in editor-style.css. ([\#18314](https://core.trac.wordpress.org/ticket/18314))
- Use get\_template\_directory() instead of TEMPLATEPATH. ([\#18071](https://core.trac.wordpress.org/ticket/18071))
- More consistent attribute escaping. ([r19582](https://core.trac.wordpress.org/changeset/19582))
- Implement `rel="author"`. ([\#17722](https://core.trac.wordpress.org/ticket/17722))
- Add style: `overflow:auto` for pre tags. ([\#16317](https://core.trac.wordpress.org/ticket/16317))

## Version 1.2

February 23, 2011

- Center images on attachment pages. ([\#14284](https://core.trac.wordpress.org/ticket/14284))
- style.css cleanup. ([\#14298](https://core.trac.wordpress.org/ticket/14298))
- Fix image size handling. ([\#14303](https://core.trac.wordpress.org/ticket/14303))
- Check for header image before showing it. ([\#14486](https://core.trac.wordpress.org/ticket/14486))
- Set IE6 incompatible CSS rule in a different selector, because it causes all headings to be set in Georgia instead of Helvetica &amp; co. ([\#14688](https://core.trac.wordpress.org/ticket/14688))
- Fix some encoding issues. ([\#14735](https://core.trac.wordpress.org/ticket/14735))
- Add Post Format support which can be used to designate an Aside or a Gallery! ([\#14746](https://core.trac.wordpress.org/ticket/14746))
- Fix header positioning in IE9. ([\#14883](https://core.trac.wordpress.org/ticket/14883))
- Allow the various header constants to be redefined. ([\#14903](https://core.trac.wordpress.org/ticket/14903))
- Check for theme support before calling has\_post\_thumbnail for child theme compatibility. ([\#14903](https://core.trac.wordpress.org/ticket/14903))
- Use custom loops. ([\#15078](https://core.trac.wordpress.org/ticket/15078))
- Deprecate twentyten\_remove\_gallery\_css in favor of the use\_default\_gallery\_style filter. ([\#15103](https://core.trac.wordpress.org/ticket/15103))
- Utilize gallery-columns-# classes. ([\#15103](https://core.trac.wordpress.org/ticket/15103))
- Fix long taglines hidden under the header image lte IE7. ([\#15113](https://core.trac.wordpress.org/ticket/15113))
- Don’t let widget select boxes get cut off by the sidebar. ([\#15114](https://core.trac.wordpress.org/ticket/15114))
- Add a class to ‘Your comment is awaiting moderation’ in the comment walker and Twenty Ten’s callback. ([\#15206](https://core.trac.wordpress.org/ticket/15206))
- Revert replacement of get\_the\_category() with get\_the\_categories(). ([\#15407](https://core.trac.wordpress.org/ticket/15407))
- Don’t pass optional argument with its default value. ([\#15450](https://core.trac.wordpress.org/ticket/15450))
- Code cleanup. ([\#15476](https://core.trac.wordpress.org/ticket/15476))
- Add a simple filter to allow removing the recent comments default widget styles. ([\#15493](https://core.trac.wordpress.org/ticket/15493))
- Add ‘View Galleries’ link for post formats. ([\#15506](https://core.trac.wordpress.org/ticket/15506))
- Only link to the Gallery category if the post is in the category. ([\#15506](https://core.trac.wordpress.org/ticket/15506))
- Fix typo in loop.php. ([\#15537](https://core.trac.wordpress.org/ticket/15537))
- Mark Twenty Ten as GPL per new theme directory guidelines. ([\#15632](https://core.trac.wordpress.org/ticket/15632))
- Handle ‘This gallery contains X photos’ properly. ([\#15858](https://core.trac.wordpress.org/ticket/15858))
- Add post format CSS to stylesheet. ([\#16141](https://core.trac.wordpress.org/ticket/16141))
- Clear floats before page links in Twenty Ten. ([\#16178](https://core.trac.wordpress.org/ticket/16178))
- Provide backward compatibility with the gallery\_style filter. ([\#16610](https://core.trac.wordpress.org/ticket/16610))
- Make dropdown menus slightly wider to accommodate long words and minor cleanup of style.css. ([r14862](https://core.trac.wordpress.org/changeset/14862))
- Editor-style CSS cleanup. ([r14863](https://core.trac.wordpress.org/changeset/14863))
- Revert changeset which deals with plural form issues in comments. ([r17111](https://core.trac.wordpress.org/changeset/17111))
- WP 3.0 compatibility for post formats. ([r17469](https://core.trac.wordpress.org/changeset/17469))

## Version 1.1

July 29, 2010

- Clear #main in Twenty Ten to fix rendering in old Gecko browsers. ([\#13991](https://core.trac.wordpress.org/ticket/13991))
- style.css updates for theme repo sync. Change hex values to lowercase.([\#14284](https://core.trac.wordpress.org/ticket/14284))
- Capital p in WordPress. ([\#14293](https://core.trac.wordpress.org/ticket/14293))
- New theme description and stylesheet cleanup. ([\#14298](https://core.trac.wordpress.org/ticket/14298))
- Add single-attachment class and style to div#container of attachment.php. ([r15422](https://core.trac.wordpress.org/changeset/15422))
- Remove the color declaration from the strong tag so we don’t interfere with the user’s color choices. Slightly darkening body text for better readability. ([r15164](https://core.trac.wordpress.org/changeset/15164))

## Version 1.0.3

June 17, 2010

Initial release.
