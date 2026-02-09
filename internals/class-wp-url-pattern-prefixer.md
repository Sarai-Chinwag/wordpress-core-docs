# WP_URL_Pattern_Prefixer

Prefixes URL patterns with base paths for WordPress installations.

**Source:** `wp-includes/class-wp-url-pattern-prefixer.php`  
**Since:** 6.8.0  
**Access:** private

## Overview

This class handles URL pattern prefixing for WordPress sites that may be installed in subdirectories. It ensures URL patterns work correctly regardless of where WordPress is installed relative to the hostname root.

Primarily used for speculative loading features where URL patterns need to match actual site URLs.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$contexts` | array | private | Map of context names to escaped base paths |

---

## Methods

### __construct()

Creates a prefixer with the specified contexts.

```php
public function __construct( array $contexts = array() )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$contexts` | array | Map of `context_name => base_path` pairs |

If no contexts provided, uses default contexts from `get_default_contexts()`.

All paths are automatically:
- Trailed with a slash
- Escaped for URL pattern syntax

---

### prefix_path_pattern()

Prefixes a URL path pattern with the appropriate base path.

```php
public function prefix_path_pattern( string $path_pattern, string $context = 'home' ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$path_pattern` | string | URL pattern starting with path segment |
| `$context` | string | Context key (default `'home'`) |

**Returns:** Prefixed URL pattern.

**Behavior:**
- If pattern already starts with context path, it's deduplicated
- Leading slashes are normalized
- Special characters in paths are enclosed in braces if needed

**Example:**

```php
$prefixer = new WP_URL_Pattern_Prefixer();

// WordPress installed at site root
$prefixer->prefix_path_pattern( '/page/*' );
// Returns: '/page/*'

// WordPress installed at /blog/
$prefixer->prefix_path_pattern( '/page/*' );
// Returns: '/blog/page/*'
```

**Error Handling:**

Invalid contexts trigger `_doing_it_wrong()` and return the original pattern unchanged.

---

### get_default_contexts()

Returns the default context paths for a WordPress installation.

```php
public static function get_default_contexts(): array
```

**Returns:** Array with these context keys:

| Context | Description | Example Path |
|---------|-------------|--------------|
| `home` | Site home URL path | `/` or `/blog/` |
| `site` | WordPress URL path | `/` or `/wordpress/` |
| `uploads` | Uploads directory path | `/wp-content/uploads/` |
| `content` | wp-content directory path | `/wp-content/` |
| `plugins` | Plugins directory path | `/wp-content/plugins/` |
| `template` | Current theme directory path | `/wp-content/themes/theme/` |
| `stylesheet` | Stylesheet theme directory path | `/wp-content/themes/child/` |

**Note:** All paths are escaped for URL pattern syntax.

---

### escape_pattern_string() <small>(private static)</small>

Escapes a string for use in URL pattern components.

```php
private static function escape_pattern_string( string $str ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$str` | string | String to escape |

**Returns:** String with URL pattern special characters escaped.

**Escaped Characters:** `+`, `*`, `?`, `:`, `{`, `}`, `(`, `)`, `\`

Follows the [URLPattern specification](https://urlpattern.spec.whatwg.org/#escape-a-pattern-string).

---

## URL Pattern Syntax

URL patterns follow the [URLPattern Web API specification](https://urlpattern.spec.whatwg.org/):

| Pattern | Description |
|---------|-------------|
| `*` | Matches any characters (non-greedy) |
| `:name` | Named parameter |
| `:name*` | Named parameter matching multiple segments |
| `{group}` | Grouping (for escaping) |

---

## Usage Context

This class supports speculative loading features in WordPress 6.8+:

```php
// Internal usage for speculation rules
$prefixer = new WP_URL_Pattern_Prefixer();
$pattern = $prefixer->prefix_path_pattern( '/*', 'home' );

// Pattern used in speculation rules JSON:
// { "where": { "href_matches": "/blog/*" } }
```

---

## Multisite Considerations

On multisite installations:

- **Subdomain sites:** Context paths typically start from root (`/`)
- **Subdirectory sites:** Context paths include the site path (`/site1/`, `/site2/`)

The prefixer handles this automatically via WordPress URL functions.

---

## Security Note

The class is marked `@access private` — it's intended for internal WordPress use. The API may change without notice in future versions.
