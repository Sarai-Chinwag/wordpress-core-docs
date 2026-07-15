---
type: document
title: Block patterns
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/block-patterns/"
tags:
timestamp: "2026-06-16T19:29:25+00:00"
wordpress:
  id: 2485
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:25"
  date_gmt: "2026-06-16 19:29:25"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: block-patterns
  parent: 2479
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/block-patterns/"
  comment_count: 0
---

A WordPress pattern is a collection of blocks arranged together into a thoughtful, intentional, and opinionated section for a post, page, or template.

You can build beautiful posts, pages, and templates with ease with [WordPress.com patterns](http://wordpress.com/patterns?ref=developer-docs), made by the design team at WordPress.com to effortlessly inherit your theme’s global styles. Choose from a vast collection of patterns and customize them in any way you like; no additional plugins or coding required. Think of these patterns as a component library for the Block Editor.

Interested in learning more about block themes and patterns beyond this resource? The [WordPress.org Theme Handbook](https://developer.wordpress.org/themes/) is the canonical resource for learning about block theme development and has plenty of handy tips. Additionally, it has a [chapter dedicated fully to patterns](https://developer.wordpress.org/themes/patterns/).

## Using patterns on WordPress.com

### Find patterns via the Block Editor

WordPress.com patterns are available in the block editor by following these instructions:

1. Navigate to the editor for any post, page, or template.
2. Click on the **+** button to bring up the block inserter.
3. Click the **Patterns** tab to browse a list of pattern categories (To browse all patterns in a grid view, scroll to the bottom of the list and click on **Explore all patterns**.)
4. Click your desired pattern to insert it into your post, page, or template.

[![WordPress page editor screen with the pattern inserter open on the left. It is showing multiple patterns to add to the content.](https://developer.wordpress.com/wp-content/uploads/2024/04/pattern-inserter.png)](https://developer.wordpress.com/wp-content/uploads/2024/04/pattern-inserter.png)From there, you can edit the content of the pattern (images, text, links, etc.) in the editor. Theme styles defined via the Site Editor will be automatically applied to the inserted pattern.

### Find patterns via the Pattern Library

To preview patterns at different screen widths and check the responsiveness of the designs, you can use [WordPress.com’s Pattern Library](https://wordpress.com/patterns?ref=developer-docs). The library not only allows you to browse, search, and preview patterns at different screen widths, but it also enables you to copy and paste patterns into the block editor.

When visiting the [Pattern Library](https://www.wordpress.com/patterns?ref=developer-docs), use the category navigation to view all available patterns. Alternatively, use the search form to search for patterns by keyword or feature. Once you find a pattern you’d like to use, click the **Copy** pattern button.

[![WordPress.com page from the pattern library. It shows an example pattern of a gallery with three images. Above the pattern is a "Copy Pattern" button.](https://developer.wordpress.com/wp-content/uploads/2024/04/pattern-library-single.png)](https://developer.wordpress.com/wp-content/uploads/2024/04/pattern-library-single.png)Once you’ve chosen a pattern, navigate to the editor for a post, page, or template on your WordPress.com website, and paste the pattern by using a keyboard shortcut (`command + v` on Mac or `ctrl + v` on Windows) or by right-clicking and selecting **Paste**.

Just like with other patterns, you can edit the content of the pasted pattern (images, text, links, etc.) in the Block Editor.

If you’re logged out of your WordPress.com account, you will only be able to copy the first three patterns in each category. For any other patterns, you’ll see a button that says **Get access** and, when clicked, will prompt you to [create a free WordPress.com account](https://wordpress.com/start/user-social?ref=developer-docs) or [log into an existing account](https://wordpress.com/log-in?ref=developer-docs).

## Building with patterns

Our block patterns are made to be portable, but your `theme.json` file will still need to follow some guidelines to ensure our patterns look their best.

Specifically, we assume the following slugs are defined in `spacing.spacingSizes`:

- `“slug”: "20”`
- `“slug”: "30"`
- `“slug”: "40"`
- `“slug”: "50"`
- `“slug”: "60"`
- `“slug”: "70"`
- `“slug”: "80"`

These are the same spacing presets that WordPress [generates by default](https://developer.wordpress.org/themes/global-settings-and-styles/settings/spacing/#spacing-scale-and-sizes). If they are missing from your theme, some block spacing may collapse entirely when you paste a pattern. Our patterns may still work if your theme uses different spacing presets, but this is the standard we adhere to.

### Pattern structure guidelines

In addition to using WordPress.com patterns in your posts, pages, and templates, you can also create your own. The WordPress.com design team has [published some of their learnings](https://developer.wordpress.org/news/2024/03/pattern-design-tips-and-tricks-for-developers/) on the WordPress Developer Blog, including some of the following suggested guidelines for creating patterns:

- A top-level [Group block](https://wordpress.com/support/wordpress-editor/blocks/group-block/) that spans the full width of the page.
    - This makes it easier to change the background color of a whole section of the page and to reorder the sections of a page, as each pattern is contained within a Group block.
    - These Group blocks typically have the left and right padding values mapped to the site’s global styles layout settings so that the pattern adapts to the theme.
- A container block ([Grid](https://wordpress.com/support/wordpress-editor/blocks/grid-block/), [Columns](https://wordpress.com/support/wordpress-editor/blocks/columns-block/), [Row and Stack](https://wordpress.com/support/wordpress-editor/blocks/row-stack-block/), etc.) are nested directly within the top-level block.
    - This block is set to the theme’s “wide” width value, allowing for the pattern’s contents to have a max-width, as defined by the theme.
- Two [Spacer blocks](https://wordpress.com/support/wordpress-editor/blocks/spacer-block/) are placed directly above and below the Container block.
    - These Spacer blocks allow you to select and manipulate the space between patterns without having to find the block’s relevant padding controls.

Get more information on [how specific blocks work and how to build with them here](https://wordpress.com/support/category/content-and-media/blocks/).

## Disabling patterns

To remove Block Patterns in most cases, consult the official WordPress documentation on [unregistering patterns](https://developer.wordpress.org/themes/patterns/registering-patterns/#unregistering-patterns). However, there may be cases where you want to disable patterns that are specific to WordPress.com.

Disabling patterns requires you to have access to either [SSH](https://wordpress.com/support/ssh/) or [SFTP](https://wordpress.com/support/sftp/) for your site to be able to edit your theme’s `functions.php` file.

To disable all non-user-created patterns, copy and paste the following code at the bottom of your theme’s `functions.php` file:

```
// Disable the remote patterns coming from the Dotorg pattern directory.
// See https://developer.wordpress.org/themes/patterns/registering-patterns/#disabling-remote-patterns
add_filter( 'should_load_remote_block_patterns', '__return_false' );
// Remove and unregister patterns from core, Dotcom, and plugins.
// See 		https://github.com/Automattic/jetpack/blob/d032fbb807e9cd69891e4fcbc0904a05508a1c67/projects/packages/jetpack-mu-wpcom/src/features/block-patterns/block-patterns.php#L107
add_filter( 'rest_dispatch_request', 'your_theme_restrict_block_editor_patterns', 12, 3 );
/**

Restricts block editor patterns in the editor by removing support for all patterns from:

Dotcom and plugins like Jetpack

Dotorg pattern directory except for theme patterns
*/
function your_theme_restrict_block_editor_patterns( $dispatch_result, $request, $route ) {
if ( strpos( $route, '/wp/v2/block-patterns/patterns' ) === 0 ) {
$patterns = WP_Block_Patterns_Registry::get_instance()->get_all_registered();
if ( ! empty( $patterns ) ) {
// Remove theme support for all patterns from Dotcom, and plugins.
// See https://developer.wordpress.org/themes/patterns/registering-patterns/#unregistering-patterns
foreach ( $patterns as $pattern ) {
unregister_block_pattern( $pattern['name'] );
}
  // Remove theme support for core patterns from the Dotorg pattern directory. 
  // See https://developer.wordpress.org/themes/patterns/registering-patterns/#removing-core-patterns
  remove_theme_support( 'core-block-patterns' );
```

} }

return $dispatch\_result; }&lt;textarea aria-hidden="true" class="a8c-docs-syntax\_\_copy-textarea"&gt;// Disable the remote patterns coming from the Dotorg pattern directory. // See <https://developer.wordpress.org/themes/patterns/registering-patterns/#disabling-remote-patterns>add\_filter( 'should\_load\_remote\_block\_patterns', '\_\_return\_false' );

// Remove and unregister patterns from core, Dotcom, and plugins. // See <https://github.com/Automattic/jetpack/blob/d032fbb807e9cd69891e4fcbc0904a05508a1c67/projects/packages/jetpack-mu-wpcom/src/features/block-patterns/block-patterns.php#L107>add\_filter( 'rest\_dispatch\_request', 'your\_theme\_restrict\_block\_editor\_patterns', 12, 3 );

/\*\*

- Restricts block editor patterns in the editor by removing support for all patterns from:
- - Dotcom and plugins like Jetpack
- - Dotorg pattern directory except for theme patterns \*/ function your\_theme\_restrict\_block\_editor\_patterns( $dispatch\_result, $request, $route ) { if ( strpos( $route, '/wp/v2/block-patterns/patterns' ) === 0 ) { $patterns = WP\_Block\_Patterns\_Registry::get\_instance()-&gt;get\_all\_registered();
        
        if ( ! empty( $patterns ) ) { // Remove theme support for all patterns from Dotcom, and plugins. // See <https://developer.wordpress.org/themes/patterns/registering-patterns/#unregistering-patterns>foreach ( $patterns as $pattern ) { unregister\_block\_pattern( $pattern\['name'\] ); }
        
        ```
        // Remove theme support for core patterns from the Dotorg pattern directory. 
          // See https://developer.wordpress.org/themes/patterns/registering-patterns/#removing-core-patterns
          remove_theme_support( 'core-block-patterns' );
        ```
        
        } }
    
    return $dispatch\_result; }&lt;/textarea&gt;CopyCopied
