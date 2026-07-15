---
type: document
title: Plugin developer guidelines
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/plugin-developer-guidelines/"
tags:
timestamp: "2026-06-16T19:29:25+00:00"
wordpress:
  id: 2480
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:25"
  date_gmt: "2026-06-16 19:29:25"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: plugin-developer-guidelines
  parent: 2456
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/plugin-developer-guidelines/"
  comment_count: 0
---

The following are guidelines for WordPress plugins and not restrictions.

Want to create a plugin for WordPress.com? WordPress.com plugins are the same as regular WordPress plugins. This page offers a set of best practices. For more information, check out the [Plugin Developer Handbook](https://developer.wordpress.org/plugins/).

A WordPress.com plugin should:

- Adhere to all WordPress plugin coding standards, as well as [best practice guidelines](https://developer.wordpress.org/plugins/plugin-basics/best-practices/) for harmonious existence within WordPress and alongside other WordPress plugins.
- Not subvert the WordPress.com experience. For example, inserting spam links or up-selling services outside the WordPress.com ecosystem. WordPress.com users should have a unified and pleasant experience without plugin advertising appearing on WP-Admin or store.

## Main file naming

The main plugin file should adopt the name of the plugin, e.g., a plugin with the directory name `plugin-name` would have its main file named `plugin-name.php`.

## Text domains

Following guidelines for [Internationalization for WordPress Developers](https://codex.wordpress.org/I18n_for_WordPress_Developers), the text domain should match your plugin directory name, e.g., a plugin with a directory name `plugin-name` would have the text domain `plugin-name`. Do not use underscores.

## Localization

All text strings within plugin code should be in **English**. This is the WordPress default locale, and English should always be the first language. If your plugin is intended for a specific market (e.g., Spain or Italy), include appropriate translation files for those languages within your plugin package. Learn more at [Using Makepot to translate your plugin](https://codex.wordpress.org/I18n_for_WordPress_Developers#Translating_Plugins_and_Themes).

## Follow WordPress PHP guidelines

WordPress has a [set of guidelines](https://make.wordpress.org/core/handbook/coding-standards/php/) to keep all WordPress code consistent and easy to read. This includes quotes, indentation, brace style, shorthand php tags, Yoda conditions, naming conventions, and more. Please review the guidelines.

## Add Settings action link

Action links are the links that appear in `wp-admin/plugins.php` page in each plugin row. Adding a `Settings` action link is very useful and will be used to redirect users to after successful plugin installation. Use the `<a href="https://developer.wordpress.org/reference/hooks/plugin_action_links_plugin_file/">plugin_action_links_{$plugin_file}</a>` filter for adding the `Settings` or other action links.

## Custom database tables and data storage

Avoid creating custom database tables where WordPress [post types](https://codex.wordpress.org/Post_Types#Custom_Post_Types), [taxonomies](https://codex.wordpress.org/Taxonomies), and [options](https://codex.wordpress.org/Creating_Options_Pages), can provide a solution.

Consider the permanence of your data. Here’s a quick primer:

- If the data may not always be present (i.e., it expires), use a **transient**.
- If the data is persistent but not always present, consider using the **WP Cache**.
- If the data is persistent and always present, consider the **wp\_options** table.
- If the data type is an entity with `n` units, consider a **post type**.
- If the data is a means of sorting/categorizing an entity, consider a **taxonomy**.

Logs should be written to a file using the [WC\_Logger](http://docs.woocommerce.com/wc-apidocs/class-WC_Logger.html) class.

## Prevent data leaks[](https://woo.com/document/create-a-plugin/#section-7)

Try to prevent direct access data leaks. Add this line of code after the opening PHP tag in each PHP file:

```
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
```

## Readme[](https://woo.com/document/create-a-plugin/#section-8)

All plugins require a [standard WordPress readme](https://wordpress.org/plugins/about/readme.txt) file.

Your readme might look something like this:

```
=== Plugin Name ===
Contributors: (this should be a list of wordpress.org userid's)
Tags: comments, spam
Requires at least: 4.0.1
Tested up to: 4.3
Requires PHP: 5.6
Stable tag: 4.3
License: GPLv3 or later License
URI: http://www.gnu.org/licenses/gpl-3.0.html
```

## Plugin author name[](https://woo.com/document/create-a-plugin/#section-9)

Consistency is important to us and our customers. Products offered through WordPress.com should provide a consistent experience for all aspects of the product, including finding information on who to contact with queries.

Be sure to include the following plugin headers:

- The `Plugin Author` is YourName/YourCompany
- The Developer header is YourName/YourCompany, with the Developer URI field listed as <http://yourdomain.com/>

For example:

```
/**
 * Plugin Name: My awesome plugin
 * Plugin URI: http://yourgroovydomain.com/my-awesome-plugin/
 * Description: Your plugin's description text.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: http://yourgroovydomain.com/
 * Developer: Your Name
 * Developer URI: http://yourgroovydomain.com/
 * Text Domain: my-awesome-plugin
 * Domain Path: /languages
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
```

## Make it extensible[](https://woo.com/document/create-a-plugin/#section-13)

Developers should use WordPress actions and filters to allow for modification/customization without requiring users to touch the plugin’s core codebase. Check out [Writing Extensible Plugins with Actions and Filters](https://developer.wordpress.org/plugins/hooks/custom-hooks/) to learn more about extending WordPress.

With the new[ WordPress Block Editor — Gutenberg](https://developer.wordpress.org/block-editor/#develop-for-the-block-editor), you should[ add block patterns](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-patterns/) for your plugin If the functionality of your plugin is suitable for it. You can read more about[ extending blocks](https://developer.wordpress.org/block-editor/reference-guides/block-api/).

## Remove unused code

With version control, there’s no reason to leave commented-out code. Remove it and return it later as needed.

## Comment effectively

If you have a function, what does the function do? There should be comments for most if not all functions in your code. We recommend using [PHP Doc Blocks](http://en.wikipedia.org/wiki/PHPDoc) similar to [WooCommerce](https://github.com/woocommerce/woocommerce/).

## Avoid god objects

[God Objects](http://en.wikipedia.org/wiki/God_object) are objects that know or do too much. The point of object-oriented programming is to take a large problem and break it into smaller parts. When functions do too much, it’s hard to follow their logic, making bugs harder to fix. Instead of having massive functions, break them down into smaller pieces.

## Test your code with WP\_DEBUG

Always develop with [WP\_DEBUG](https://codex.wordpress.org/Debugging_in_WordPress) mode on, so you can see all PHP warnings sent to the screen. This will flag things like making sure a variable is set before checking the value.

## Separate business logic and presentation logic

It’s a good practice to separate business logic (i.e., how the plugin works) from [presentation logic](http://en.wikipedia.org/wiki/Presentation_logic) (i.e., how it looks). Two separate pieces of logic are more easily maintained and improved as necessary. As an example, have two different classes — one for displaying the end results, and one for the admin settings page.

## Use transients to store offsite information

If you provide a service via an API, it’s best to store that information so future queries can be done faster, lessening the load on your service. [WordPress transients](https://codex.wordpress.org/Transients_API) can be used to store data for a certain amount of time.

## Logging data

You may want to log data that can be useful for debugging purposes. This is great with two conditions:

- Allow any logging as an “opt-in.”
- Use the [WC\_Logger](http://docs.woocommerce.com/wc-apidocs/class-WC_Logger.html) class. A user can then view logs on their system status page.

If adding logging to your extension, here’s a snippet for presenting a link to the logs, in a way the extension user can easily make use of.

```
$label = __( 'Enable Logging', 'your-textdomain-here' );
$description = __( 'Enable the logging of errors.', 'your-textdomain-here' );
if ( defined( 'WC_LOG_DIR' ) ) {
$log_url = add_query_arg( 'tab', 'logs', add_query_arg( 'page', 'wc-status', admin_url( 'admin.php' ) ) );
$log_key = 'your-plugin-slug-here-' . sanitize_file_name( wp_hash( 'your-plugin-slug-here' ) ) . '-log';
$log_url = add_query_arg( 'log_file', $log_key, $log_url );
$label .= ' | ' . sprintf( __( '%1$sView Log%2$s', 'your-textdomain-here' ), '&lt;a href="' . esc_url( $log_url ) . '"&gt;', '&lt;/a&gt;' );
```

}

$form\_fields\['wc\_yourpluginslug\_debug'\] = array( 'title' =&gt; \_\_( 'Debug Log', 'your-textdomain-here' ), 'label' =&gt; $label, 'description' =&gt; $description, 'type' =&gt; 'checkbox', 'default' =&gt; 'no' );

Validate user input as early as possible to prevent unexpected data in your data store. Check out [WordPress Data Validation](https://codex.wordpress.org/Data_Validation), which has plenty of helpful methods for validating user input.

## Data validation

WordPress core has a set of reserved keywords, or terms, in WordPress that should not be used in certain circumstances as they may conflict with functionality. Here is a complete list of[ reserved keywords or terms](https://codex.wordpress.org/Reserved_Terms).

## Reserved terms

WordPress-specific global variables are used throughout WordPress code for various reasons. Almost all data that WordPress generates can be found in a global variable. It’s best to use the appropriate API functions when available, instead of modifying globals directly. Also, make sure that you are not overriding any global variable. It may affect other plugins’ functionality. Here is the complete list of[ WordPress Global Variables](https://codex.wordpress.org/Global_Variables).

## Avoid global variable conflicts

It’s a great practice to evaluate the performance of custom queries.[ The WordPress Query](https://codex.wordpress.org/Query_Overview) helper function allows you to run a variety of queries in performant ways. Use[ WordPress Query](https://codex.wordpress.org/Query_Overview) functions wherever possible and minimize custom queries throughout the codebase. A poorly written query has the potential to take the entire server down.

## Optimize custom Query

We aim to provide support for standard PHP extensions on our hosting platform so that your plugin can run. You can find a list of enabled PHP extensions on WordPress.com infrastructure [here](https://wordpress.com/support/php-environment/#php-modules). Your plugin should not use any PHP extensions that are not supported. As a best practice, your plugin should implement a fallback strategy if any PHP extension is not enabled. i.e., you can use GD Library when [ImageMagick](https://imagemagick.org/index.php) is not available.

## PHP extension requirements

If your plugin allows users to submit data be it on the Admin or the Public side; you must verify that the user is who they say they are and that they [have the necessary capability](https://developer.wordpress.org/plugins/security/checking-user-capabilities/) to perform the action. Doing both in tandem means that data is only changing when the user *expects* it to be changing. The nonce is essentially a unique hexadecimal serial number used to verify the origin and intent of requests for security purposes.

## Implement nonces

The best security strategy is maximum awareness among developers. You can review[ OWASP’s Top Ten](https://owasp.org/www-project-top-ten/) risks for spreading plugin security awareness. The plugin should aim to implement maximum security while minimizing security risks.

## Minimize security risks

Your plugin should follow[ WordPress versioning](https://make.wordpress.org/core/handbook/about/release-cycle/version-numbering/). It’s a delimited trio of version numbers that each increment according to a set of shared principles and rules outlined in [version numbering](https://make.wordpress.org/core/handbook/about/release-cycle/version-numbering/).

## Version management
