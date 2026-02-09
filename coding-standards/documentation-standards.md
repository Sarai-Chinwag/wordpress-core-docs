# WordPress Documentation Standards

Good documentation is part of writing good code. Every function, class, and hook should be documented.

## PHPDoc Standards

### File Headers

```php
<?php
/**
 * Class file for My_Plugin_Class.
 *
 * @package    My_Plugin
 * @subpackage Admin
 * @since      1.0.0
 */
```

### Class Documentation

```php
/**
 * Handles the admin settings page.
 *
 * This class is responsible for registering settings,
 * rendering the settings page, and processing form submissions.
 *
 * @since 1.0.0
 */
class My_Plugin_Admin_Settings {

	/**
	 * The plugin options.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $options;

	/**
	 * Singleton instance.
	 *
	 * @since 1.0.0
	 * @var My_Plugin_Admin_Settings|null
	 */
	private static $instance = null;
}
```

### Function Documentation

```php
/**
 * Retrieves post data by ID with optional formatting.
 *
 * Fetches the post from the database and optionally applies
 * content filters and formats the output.
 *
 * @since 1.0.0
 * @since 1.2.0 Added $format parameter.
 * @since 2.0.0 Returns WP_Error on failure instead of false.
 *
 * @see get_post()
 * @see apply_filters()
 *
 * @global wpdb $wpdb WordPress database object.
 *
 * @param int    $post_id       The post ID to retrieve.
 * @param string $format        Optional. Output format: 'raw', 'edit', or 'display'.
 *                              Default 'display'.
 * @param bool   $apply_filters Optional. Whether to apply content filters.
 *                              Default true.
 *
 * @return array|WP_Error Post data array on success, WP_Error on failure.
 */
function my_plugin_get_post_data( $post_id, $format = 'display', $apply_filters = true ) {
	// Implementation
}
```

### Hook Documentation

```php
/**
 * Fires after the post has been saved.
 *
 * @since 1.0.0
 *
 * @param int   $post_id   The post ID.
 * @param array $post_data The post data array.
 * @param bool  $is_update Whether this is an update or new post.
 */
do_action( 'my_plugin_after_save_post', $post_id, $post_data, $is_update );

/**
 * Filters the post title before display.
 *
 * @since 1.0.0
 *
 * @param string $title   The post title.
 * @param int    $post_id The post ID.
 *
 * @return string Modified title.
 */
$title = apply_filters( 'my_plugin_post_title', $title, $post_id );
```

### Method Documentation

```php
class My_Plugin_API {

	/**
	 * Sends a request to the external API.
	 *
	 * @since 1.0.0
	 *
	 * @param string $endpoint The API endpoint path.
	 * @param array  $args {
	 *     Optional. Request arguments.
	 *
	 *     @type string $method  HTTP method. Default 'GET'.
	 *     @type array  $headers Request headers.
	 *     @type mixed  $body    Request body.
	 *     @type int    $timeout Timeout in seconds. Default 30.
	 * }
	 *
	 * @return array|WP_Error Response array or WP_Error on failure.
	 */
	public function request( $endpoint, $args = array() ) {
		// Implementation
	}
}
```

### Property Documentation

```php
/**
 * The database table name.
 *
 * @since 1.0.0
 * @var string
 */
private $table_name;

/**
 * Cached query results.
 *
 * @since 1.0.0
 * @var array<string, mixed>
 */
private $cache = array();

/**
 * Whether the class has been initialized.
 *
 * @since 1.0.0
 * @var bool
 */
private $initialized = false;
```

---

## PHPDoc Tags Reference

### Common Tags

```php
/**
 * @param   type $name Description.
 * @return  type       Description.
 * @throws  ExceptionClass Description of when thrown.
 *
 * @since   1.0.0      When introduced.
 * @since   1.2.0      Description of change in this version.
 *
 * @see     function_name() Related function.
 * @see     Class_Name      Related class.
 * @see     https://example.com External reference.
 *
 * @link    https://example.com/docs Full documentation.
 *
 * @global  type $varname Description of global used.
 *
 * @var     type         For properties and variables.
 *
 * @access  private      Visibility (when not using PHP keywords).
 *
 * @deprecated 2.0.0     Description. Use other_function() instead.
 *
 * @todo    Description of remaining work.
 *
 * @example path/to/example.php Description.
 */
```

### Type Hints

```php
/**
 * @param string          $text      A string.
 * @param int             $count     An integer.
 * @param float           $price     A float.
 * @param bool            $active    A boolean.
 * @param array           $items     An array.
 * @param object          $obj       An object.
 * @param mixed           $data      Any type.
 * @param callable        $callback  A callable.
 * @param resource        $handle    A resource.
 * @param null            $nothing   Null.
 *
 * @param string[]        $names     Array of strings.
 * @param int[]           $ids       Array of integers.
 * @param WP_Post[]       $posts     Array of WP_Post objects.
 *
 * @param string|int      $value     String or integer.
 * @param array|null      $data      Array or null.
 * @param WP_Post|false   $post      WP_Post or false.
 *
 * @param array<string, int> $map    Associative array.
 */
```

---

## Inline Comments

### When to Comment

```php
// ✅ Explain WHY, not WHAT
// Use object cache to avoid repeated database queries on archive pages.
$cached = wp_cache_get( $cache_key, 'my_plugin' );

// ✅ Clarify complex logic
// Bitwise AND to check if user has both read and write permissions.
if ( ( $permissions & ( PERM_READ | PERM_WRITE ) ) === ( PERM_READ | PERM_WRITE ) ) {

// ✅ Document workarounds
// Workaround for core bug #12345 - remove after WP 6.5.
add_filter( 'the_content', 'my_temp_fix', 5 );

// ✅ Mark temporary code
// TODO: Replace with REST API endpoint in 2.0.
// FIXME: This breaks with special characters in titles.

// ❌ Don't state the obvious
// Increment the counter.
$counter++;

// ❌ Don't duplicate the code
// Set the title to the post title.
$title = $post->post_title;
```

### Comment Format

```php
// ✅ Single-line: lowercase, no period for short comments
// check user permissions

// ✅ Single-line: sentence case with period for full sentences
// This checks if the user has permission to edit the post.

// ✅ Multi-line for longer explanations
/*
 * This function handles a complex process that requires
 * multiple steps and has several edge cases to consider.
 * See the documentation at https://example.com for details.
 */
```

---

## JSDoc Standards

### Function Documentation

```javascript
/**
 * Fetches posts from the REST API.
 *
 * @since 1.0.0
 *
 * @param {Object}  options           Request options.
 * @param {string}  options.postType  Post type to fetch.
 * @param {number}  options.perPage   Number of posts per page.
 * @param {number}  [options.page=1]  Page number (optional, default 1).
 * @param {string}  [options.orderby] Order by field (optional).
 *
 * @return {Promise<Array>} Promise resolving to array of posts.
 *
 * @example
 * const posts = await fetchPosts( { postType: 'post', perPage: 10 } );
 */
async function fetchPosts( options ) {
	// Implementation
}
```

### Class Documentation

```javascript
/**
 * Manages the post editor interface.
 *
 * @since 1.0.0
 *
 * @class
 */
class PostEditor {
	/**
	 * The current post ID.
	 *
	 * @since 1.0.0
	 *
	 * @type {number}
	 */
	postId;

	/**
	 * Creates a new PostEditor instance.
	 *
	 * @since 1.0.0
	 *
	 * @param {number} postId The post ID to edit.
	 * @param {Object} config Editor configuration.
	 */
	constructor( postId, config ) {
		this.postId = postId;
	}

	/**
	 * Saves the current post.
	 *
	 * @since 1.0.0
	 *
	 * @return {Promise<boolean>} True if save succeeded.
	 */
	async save() {
		// Implementation
	}
}
```

### Event Documentation

```javascript
/**
 * Fires when the editor is initialized.
 *
 * @since 1.0.0
 *
 * @event PostEditor#initialized
 * @type {CustomEvent}
 * @property {Object} detail        Event details.
 * @property {number} detail.postId The post ID.
 */
this.dispatchEvent( new CustomEvent( 'initialized', {
	detail: { postId: this.postId },
} ) );
```

### JSDoc Types

```javascript
/**
 * @param {string}            text      A string.
 * @param {number}            count     A number.
 * @param {boolean}           active    A boolean.
 * @param {Array}             items     An array.
 * @param {Object}            obj       An object.
 * @param {Function}          callback  A function.
 * @param {*}                 anything  Any type.
 * @param {null}              nothing   Null.
 * @param {undefined}         undef     Undefined.
 *
 * @param {string[]}          names     Array of strings.
 * @param {number[]}          ids       Array of numbers.
 * @param {Array<WP_Post>}    posts     Array of post objects.
 *
 * @param {string|number}     value     String or number.
 * @param {?Object}           data      Object or null.
 * @param {Object=}           optional  Optional object.
 * @param {number}            [opt=10]  Optional with default.
 *
 * @param {Object<string, number>} map  Object with string keys, number values.
 */
```

---

## Block Documentation

### block.json

```json
{
	"$schema": "https://schemas.wp.org/trunk/block.json",
	"apiVersion": 3,
	"name": "my-plugin/my-block",
	"version": "1.0.0",
	"title": "My Block",
	"category": "widgets",
	"icon": "smiley",
	"description": "A custom block that displays a greeting message.",
	"keywords": [ "greeting", "hello", "message" ],
	"supports": {
		"html": false,
		"align": [ "wide", "full" ]
	},
	"attributes": {
		"message": {
			"type": "string",
			"default": "Hello, World!"
		},
		"showIcon": {
			"type": "boolean",
			"default": true
		}
	},
	"example": {
		"attributes": {
			"message": "Welcome to my site!"
		}
	},
	"textdomain": "my-plugin",
	"editorScript": "file:./index.js",
	"style": "file:./style.css"
}
```

---

## Changelog Documentation

### CHANGELOG.md Format

```markdown
# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/),
and this project adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Added
- New feature description.

### Changed
- Change description.

## [1.2.0] - 2024-01-15

### Added
- Added support for custom post types.
- New `my_plugin_after_save` action hook.

### Changed
- Improved performance of database queries.
- Updated minimum PHP version to 7.4.

### Deprecated
- `my_old_function()` is deprecated. Use `my_new_function()` instead.

### Removed
- Removed support for PHP 7.2.

### Fixed
- Fixed issue with special characters in titles (#123).
- Fixed compatibility with WordPress 6.4.

### Security
- Fixed XSS vulnerability in settings page.

## [1.1.0] - 2023-12-01

### Added
- Initial release.
```

### Inline Version Documentation

```php
/**
 * Gets the formatted date.
 *
 * @since 1.0.0
 * @since 1.1.0 Added $format parameter.
 * @since 1.2.0 Added timezone support.
 *
 * @param string $format   Optional. PHP date format. Default 'Y-m-d'.
 * @param string $timezone Optional. Timezone identifier. Default site timezone.
 *
 * @return string Formatted date string.
 */
function get_formatted_date( $format = 'Y-m-d', $timezone = '' ) {
	// Implementation
}

/**
 * Old function for getting dates.
 *
 * @since      1.0.0
 * @deprecated 1.2.0 Use get_formatted_date() instead.
 * @see        get_formatted_date()
 *
 * @param string $format Date format.
 *
 * @return string Formatted date.
 */
function get_date_old( $format ) {
	_deprecated_function( __FUNCTION__, '1.2.0', 'get_formatted_date()' );
	return get_formatted_date( $format );
}
```

---

## Documentation Best Practices

### Be Complete

```php
// ✅ Document all parameters, even optional ones
/**
 * @param int    $post_id The post ID.
 * @param string $meta_key Optional. Meta key to retrieve. Default empty
 *                         returns all meta.
 * @param bool   $single   Optional. Whether to return single value.
 *                         Default false.
 */

// ❌ Incomplete
/**
 * @param int $post_id The post ID.
 */
```

### Be Accurate

```php
// ✅ Match actual return types
/**
 * @return WP_Post|null Post object or null if not found.
 */
function get_post_or_null( $id ) {
	$post = get_post( $id );
	return $post instanceof WP_Post ? $post : null;
}

// ❌ Inaccurate return type
/**
 * @return WP_Post The post object.  // Can actually return null!
 */
```

### Be Consistent

```php
// ✅ Consistent style throughout codebase
/**
 * Short description.
 *
 * Long description if needed.
 *
 * @since 1.0.0
 *
 * @param type $name Description.
 *
 * @return type Description.
 */

// Use same order: summary, description, @since, @see, @param, @return
```

### Keep Updated

When you change code, update the documentation:

1. Update `@since` tags for new parameters
2. Add deprecation notices for old code
3. Update return type if it changes
4. Update changelog
