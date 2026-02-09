# WordPress PHP Coding Standards

## Naming Conventions

### Functions

```php
// ✅ Lowercase with underscores, prefixed
function theme_name_setup_feature() {}
function plugin_name_register_settings() {}

// ❌ Wrong
function themeNameSetup() {}     // camelCase
function setup_feature() {}       // No prefix (collision risk)
```

**Prefix everything** to avoid namespace collisions. Use your plugin/theme slug.

### Classes

```php
// ✅ Capitalized words, underscores
class Theme_Name_Custom_Walker {}
class Plugin_Name_Admin_Settings {}

// ❌ Wrong
class ThemeNameWalker {}  // No underscores
class customWalker {}     // lowercase start
```

### Class Files

```php
// ✅ class-{classname}.php, lowercase, hyphens
class-theme-name-custom-walker.php
class-plugin-name-admin-settings.php

// ❌ Wrong
ThemeNameWalker.php
custom_walker.php
```

### Hook Names (Actions/Filters)

```php
// ✅ Lowercase, underscores, prefixed
do_action( 'theme_name_after_header' );
apply_filters( 'plugin_name_output_data', $data );

// ❌ Wrong
do_action( 'afterHeader' );        // camelCase
do_action( 'after_header' );       // No prefix
```

### Constants

```php
// ✅ Uppercase, underscores, prefixed
define( 'THEME_NAME_VERSION', '1.0.0' );
define( 'PLUGIN_NAME_PATH', plugin_dir_path( __FILE__ ) );

// ❌ Wrong
define( 'version', '1.0.0' );  // lowercase, no prefix
```

### Variables

```php
// ✅ Lowercase, underscores
$post_id = get_the_ID();
$user_data = get_userdata( $user_id );

// ❌ Wrong
$postId = get_the_ID();    // camelCase
$p = get_the_ID();         // Non-descriptive
```

---

## Formatting

### Indentation

- **Use TABS, not spaces** for indentation
- Each logical level = 1 tab

```php
// ✅ Correct
function example() {
	if ( $condition ) {
		do_something();
	}
}

// ❌ Wrong (spaces)
function example() {
    if ( $condition ) {
        do_something();
    }
}
```

### Brace Style

Opening brace on **same line** for functions, classes, control structures:

```php
// ✅ Correct
function example() {
	// code
}

if ( $condition ) {
	// code
} elseif ( $other ) {
	// code
} else {
	// code
}

// ❌ Wrong (Allman style)
function example()
{
	// code
}
```

### Spacing

**Inside parentheses:**
```php
// ✅ Spaces inside
if ( $condition ) {}
function_call( $arg1, $arg2 );
array( 'key' => 'value' );

// ❌ No spaces
if ($condition) {}
function_call($arg1, $arg2);
```

**Around operators:**
```php
// ✅ Correct
$sum = $a + $b;
$result = ( $a === $b ) ? 'yes' : 'no';

// ❌ Wrong
$sum=$a+$b;
```

**Type casting:**
```php
// ✅ Space after cast
$count = (int) $_GET['count'];
$flag = (bool) $value;

// ❌ Wrong
$count = (int)$_GET['count'];
```

### Array Syntax

```php
// ✅ Long arrays use array() - WPCS standard
$options = array(
	'key1' => 'value1',
	'key2' => 'value2',
);

// Short syntax acceptable in modern WP (5.4+)
$options = [
	'key1' => 'value1',
	'key2' => 'value2',
];
```

**Always include trailing comma** in multi-line arrays.

### Yoda Conditions

```php
// ✅ Constant/literal on LEFT (prevents accidental assignment)
if ( true === $condition ) {}
if ( 'value' === $variable ) {}
if ( null === $result ) {}

// ❌ Wrong (assignment typo possible)
if ( $condition === true ) {}
if ( $condition = true ) {}  // Bug! Assignment, not comparison
```

---

## Control Structures

### Always Use Braces

```php
// ✅ Always braces, even for single statements
if ( $condition ) {
	do_something();
}

// ❌ Wrong (error-prone)
if ( $condition )
	do_something();
```

### Strict Comparisons

```php
// ✅ Use === and !== for type-safe comparison
if ( 0 === $count ) {}
if ( false !== strpos( $haystack, $needle ) ) {}

// ❌ Loose comparison (type coercion bugs)
if ( $count == 0 ) {}       // '' == 0 is true!
if ( strpos( $h, $n ) ) {}  // Fails when position is 0
```

### Switch Statements

```php
switch ( $value ) {
	case 'option1':
		do_something();
		break;

	case 'option2':
		do_other();
		break;

	default:
		do_default();
		break;
}
```

---

## Functions and Methods

### Declare Return Types (PHP 7.0+)

```php
// ✅ Type declarations improve code correctness
function get_post_title( int $post_id ): string {
	$post = get_post( $post_id );
	return $post ? $post->post_title : '';
}

function process_items( array $items ): void {
	foreach ( $items as $item ) {
		// process
	}
}
```

### Nullable Types (PHP 7.1+)

```php
function find_user( int $id ): ?WP_User {
	$user = get_userdata( $id );
	return $user ?: null;
}
```

### Default Parameter Values

```php
// ✅ Defaults at end
function build_query( string $type, int $limit = 10, bool $published = true ) {}

// ❌ Wrong order
function build_query( int $limit = 10, string $type ) {}
```

---

## Error Handling

### Check Return Values

```php
// ✅ Always check for WP_Error
$result = wp_insert_post( $args );
if ( is_wp_error( $result ) ) {
	error_log( $result->get_error_message() );
	return false;
}

// ✅ Check function existence before calling
if ( function_exists( 'wp_some_function' ) ) {
	wp_some_function();
}
```

### Use WP_Error for Failures

```php
function my_plugin_process_data( $data ) {
	if ( empty( $data ) ) {
		return new WP_Error(
			'invalid_data',
			__( 'Data cannot be empty.', 'my-plugin' )
		);
	}
	// process...
	return $result;
}
```

---

## Deprecated Patterns

### Avoid These

```php
// ❌ extract() - Creates variables from array, hard to trace
extract( $args );  // Now $key1, $key2 exist magically

// ✅ Use explicit assignment
$key1 = $args['key1'] ?? '';
$key2 = $args['key2'] ?? '';

// ❌ eval() - Security nightmare
eval( $code );

// ❌ create_function() - Deprecated in PHP 7.2
$func = create_function( '$a', 'return $a * 2;' );

// ✅ Use closures
$func = function( $a ) {
	return $a * 2;
};
```

---

## File Structure

### Plugin Main File Header

```php
<?php
/**
 * Plugin Name:       My Plugin Name
 * Plugin URI:        https://example.com/plugins/my-plugin/
 * Description:       Brief description of the plugin.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Author Name
 * Author URI:        https://example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-plugin
 * Domain Path:       /languages
 */
```

### Theme style.css Header

```css
/*
Theme Name:        Theme Name
Theme URI:         https://example.com/themes/theme-name/
Author:            Author Name
Author URI:        https://example.com/
Description:       Theme description.
Version:           1.0.0
Requires at least: 6.0
Tested up to:      6.4
Requires PHP:      7.4
License:           GNU General Public License v2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:       theme-name
Tags:              blog, one-column
*/
```

### No Closing PHP Tag

```php
<?php
// File content here

// ✅ NO closing ?> tag at end of PHP-only files
// Prevents accidental whitespace output
```

---

## Performance Patterns

### Avoid Queries in Loops

```php
// ❌ N+1 query problem
foreach ( $post_ids as $id ) {
	$post = get_post( $id );  // Query each iteration
}

// ✅ Batch query
$posts = get_posts( array(
	'post__in'    => $post_ids,
	'numberposts' => -1,
) );
```

### Cache Expensive Operations

```php
// ✅ Use transients for expensive operations
function get_expensive_data() {
	$cache_key = 'my_plugin_expensive_data';
	$data = get_transient( $cache_key );
	
	if ( false === $data ) {
		$data = perform_expensive_operation();
		set_transient( $cache_key, $data, HOUR_IN_SECONDS );
	}
	
	return $data;
}
```

### Late Static Binding for Singletons

```php
class My_Plugin {
	private static $instance = null;
	
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function __construct() {
		// Initialize
	}
}
```
