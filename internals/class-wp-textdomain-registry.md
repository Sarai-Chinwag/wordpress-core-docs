# WP_Textdomain_Registry

Registry for managing translation file locations.

**Source:** `wp-includes/class-wp-textdomain-registry.php`  
**Since:** 6.1.0

## Overview

The `WP_Textdomain_Registry` class manages the mapping between text domains and their translation file locations. It enables just-in-time loading of translations by tracking where `.mo` and `.l10n.php` files are located for each domain and locale combination.

This class optimizes translation loading by caching file lookups and providing a central registry for plugins and themes to declare their translation paths.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$all` | array | protected | Map of domain → locale → path |
| `$current` | array | protected | Most recent path for each domain |
| `$custom_paths` | array | protected | Custom paths set by plugins/themes |
| `$cached_mo_files` | array | protected | **Deprecated since 6.5.0** |
| `$domains_with_translations` | string[] | protected | Domains known to have translations |

---

## Methods

### init()

Initializes the registry and sets up cache invalidation.

```php
public function init(): void
```

Hooks into `upgrader_process_complete` to invalidate translation file caches when translations are updated.

**Since:** 6.5.0

---

### get()

Returns the language directory path for a domain and locale.

```php
public function get( string $domain, string $locale ): string|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$domain` | string | Text domain |
| `$locale` | string | Locale code (e.g., `de_DE`) |

**Returns:** Path to language directory, or `false` if none available.

**Filters:**
- `lang_dir_for_domain` — Modify the determined path (since 6.6.0)

**Example:**

```php
$registry = new WP_Textdomain_Registry();
$path = $registry->get( 'my-plugin', 'de_DE' );
// Returns: '/path/to/wp-content/languages/plugins/'
```

---

### has()

Checks whether translation files might be available for a domain.

```php
public function has( string $domain ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$domain` | string | Text domain |

**Returns:** `true` if paths are available or haven't been checked yet.

Used by just-in-time loading to determine whether to attempt loading.

---

### set()

Sets the language directory path for a domain and locale.

```php
public function set( string $domain, string $locale, string|false $path ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$domain` | string | Text domain |
| `$locale` | string | Locale code |
| `$path` | string\|false | Path to directory, or `false` |

Also updates the `$current` map for direct access.

---

### set_custom_path()

Sets a custom translation path for a domain.

```php
public function set_custom_path( string $domain, string $path ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$domain` | string | Text domain |
| `$path` | string | Custom language directory path |

Used by `load_plugin_textdomain()` and `load_theme_textdomain()` to register bundled translations.

**Behavior:**
- Resets any cached paths for the domain
- Allows just-in-time loading to retry with new path

---

### get_language_files_from_path()

Retrieves translation files from a directory.

```php
public function get_language_files_from_path( string $path ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$path` | string | Directory to search |

**Returns:** Array of translation file paths (`.mo` and `.l10n.php` files).

**Filters:**
- `pre_get_language_files_from_path` — Short-circuit file lookup

**Caching:**
- Results cached in `translation_files` cache group
- Cache expires after 1 hour (`HOUR_IN_SECONDS`)

**Since:** 6.5.0

---

### invalidate_mo_files_cache()

Invalidates translation file caches after updates.

```php
public function invalidate_mo_files_cache( WP_Upgrader $upgrader, array $hook_extra ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$upgrader` | WP_Upgrader | Upgrader instance (unused) |
| `$hook_extra` | array | Update context data |

**Handled Update Types:**
- `plugin` — Clears `/wp-content/languages/plugins/` cache
- `theme` — Clears `/wp-content/languages/themes/` cache
- `core` — Clears `/wp-content/languages/` cache

Hooked to `upgrader_process_complete` action.

**Since:** 6.5.0

---

## Internal Methods

### get_paths_for_domain() <small>(private)</small>

Returns possible language directories for a domain.

```php
private function get_paths_for_domain( string $domain ): string[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$domain` | string | Text domain |

**Returns:** Array containing:
- `WP_LANG_DIR/plugins/`
- `WP_LANG_DIR/themes/`
- Custom path if set

---

### get_path_from_lang_dir() <small>(private)</small>

Searches language directories for translation files.

```php
private function get_path_from_lang_dir( string $domain, string $locale ): string|false
```

Searches all possible paths for `{domain}-{locale}.mo` or `{domain}-{locale}.l10n.php`.

**Fallback Behavior:**

If no exact match found but a custom path is set, returns the custom path as fallback.

---

## Translation File Types

The registry searches for two file types:

| Type | Example | Description |
|------|---------|-------------|
| `.mo` | `my-plugin-de_DE.mo` | Binary message catalog (traditional) |
| `.l10n.php` | `my-plugin-de_DE.l10n.php` | PHP translation file (since 6.5.0) |

PHP translation files (`.l10n.php`) are preferred for performance.

---

## Usage Example

```php
// In a plugin's load_textdomain:
global $wp_textdomain_registry;

// Register custom path
$wp_textdomain_registry->set_custom_path(
    'my-plugin',
    plugin_dir_path( __FILE__ ) . 'languages'
);

// Check if translations exist for locale
$path = $wp_textdomain_registry->get( 'my-plugin', get_user_locale() );
if ( $path ) {
    load_textdomain( 'my-plugin', $path . 'my-plugin-' . get_user_locale() . '.mo' );
}
```

---

## Relationship to load_*_textdomain()

The registry is used internally by:

- `load_plugin_textdomain()` — Registers plugin language paths
- `load_theme_textdomain()` — Registers theme language paths
- `_load_textdomain_just_in_time()` — Lazy-loads translations on demand

---

## Filter Reference

### lang_dir_for_domain

```php
apply_filters( 'lang_dir_for_domain', string|false $path, string $domain, string $locale )
```

Modify the language directory path for a domain.

**Since:** 6.6.0

---

### pre_get_language_files_from_path

```php
apply_filters( 'pre_get_language_files_from_path', null|array $files, string $path )
```

Short-circuit translation file lookup. Return array of paths to skip glob().

**Since:** 6.5.0
