# WP_Plugin_Dependencies

Static class for resolving plugin dependencies declared via the `Requires Plugins` header.

**Source:** `wp-includes/class-wp-plugin-dependencies.php`  
**Since:** 6.5.0

## Overview

All methods are static. The class maintains internal state via static properties and must be initialized before use.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$plugins` | array | protected static | Cached result of `get_plugins()` |
| `$plugin_dirnames` | array | protected static | Map of slug → plugin filepath |
| `$dependencies` | array | protected static | Map of plugin filepath → dependency slugs |
| `$dependency_slugs` | array | protected static | All unique dependency slugs |
| `$dependent_slugs` | array | protected static | Map of plugin filepath → dependent slug |
| `$dependency_api_data` | array | protected static | WordPress.org API data for dependencies |
| `$dependency_filepaths` | string[] | protected static | Map of dependency slug → installed filepath |
| `$circular_dependencies_pairs` | array[] | protected static | Circular dependency pairings |
| `$circular_dependencies_slugs` | string[] | protected static | Slugs involved in circular deps |
| `$initialized` | bool | protected static | Whether class has been initialized |

---

## Public Methods

### initialize()

Initializes dependency data by reading plugin headers and fetching API data.

```php
public static function initialize(): void
```

**Note:** Only runs once; subsequent calls are no-ops.

---

### has_dependents()

Checks if other plugins depend on this plugin.

```php
public static function has_dependents( string $plugin_file ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugin_file` | string | Plugin filepath relative to plugins directory |

**Returns:** `true` if other plugins list this as a dependency.

---

### has_dependencies()

Checks if this plugin requires other plugins.

```php
public static function has_dependencies( string $plugin_file ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugin_file` | string | Plugin filepath relative to plugins directory |

**Returns:** `true` if plugin has a `Requires Plugins` header.

---

### has_active_dependents()

Checks if any active plugins depend on this plugin.

```php
public static function has_active_dependents( string $plugin_file ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugin_file` | string | Plugin filepath relative to plugins directory |

**Returns:** `true` if at least one active plugin requires this one.

**Use Case:** Prevent deactivation of plugins that active plugins depend on.

---

### get_dependents()

Gets filepaths of plugins that require a dependency.

```php
public static function get_dependents( string $slug ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Dependency plugin slug |

**Returns:** Array of dependent plugin filepaths.

---

### get_dependencies()

Gets dependency slugs for a plugin.

```php
public static function get_dependencies( string $plugin_file ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugin_file` | string | Plugin filepath relative to plugins directory |

**Returns:** Array of dependency slugs, or empty array if none.

---

### get_dependent_filepath()

Gets the filepath for a dependent plugin by its slug.

```php
public static function get_dependent_filepath( string $slug ): string|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Dependent plugin slug |

**Returns:** Plugin filepath, or `false` if not found.

---

### has_unmet_dependencies()

Checks if any required plugins are missing or inactive.

```php
public static function has_unmet_dependencies( string $plugin_file ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugin_file` | string | Plugin filepath relative to plugins directory |

**Returns:** `true` if any dependency is not installed or inactive.

---

### has_circular_dependency()

Checks if plugin is involved in a circular dependency.

```php
public static function has_circular_dependency( string $plugin_file ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugin_file` | string | Plugin filepath relative to plugins directory |

**Returns:** `true` if plugin has circular dependencies (A→B→A).

---

### get_dependent_names()

Gets human-readable names of plugins that require this one.

```php
public static function get_dependent_names( string $plugin_file ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugin_file` | string | Plugin filepath relative to plugins directory |

**Returns:** Array of dependent plugin names (sorted alphabetically).

---

### get_dependency_names()

Gets human-readable names of required plugins.

```php
public static function get_dependency_names( string $plugin_file ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugin_file` | string | Plugin filepath relative to plugins directory |

**Returns:** Map of dependency slug → name. Falls back to API data, then installed plugin name, then slug.

---

### get_dependency_filepath()

Gets installed filepath for a dependency.

```php
public static function get_dependency_filepath( string $slug ): string|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Dependency plugin slug |

**Returns:** Plugin filepath, or `false` if not installed.

---

### get_dependency_data()

Gets WordPress.org API data for a dependency.

```php
public static function get_dependency_data( string $slug ): array|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Dependency plugin slug |

**Returns:** API data array (name, short_description, icons, etc.), or `false` if unavailable.

---

### display_admin_notice_for_unmet_dependencies()

Displays admin warning if dependencies are missing.

```php
public static function display_admin_notice_for_unmet_dependencies(): void
```

**Output:** Warning notice with link to plugins page (respects multisite).

---

### display_admin_notice_for_circular_dependencies()

Displays admin warning for circular dependencies.

```php
public static function display_admin_notice_for_circular_dependencies(): void
```

**Output:** Warning notice listing circular dependency pairs.

---

### check_plugin_dependencies_during_ajax()

AJAX handler for post-installation dependency validation.

```php
public static function check_plugin_dependencies_during_ajax(): void
```

**AJAX Action:** Called after plugin installation.  
**Nonce:** `updates`  
**POST Parameter:** `slug`

**Response:**

| Key | Type | Description |
|-----|------|-------------|
| `slug` | string | Plugin slug |
| `pluginName` | string | Plugin name |
| `plugin` | string | Plugin filepath |
| `activateUrl` | string | Activation URL (if eligible) |
| `message` | string | Success message |
| `errorCode` | string | Error type |
| `errorMessage` | string | Error description |
| `errorData` | array | Inactive dependency names |

---

## Protected Methods

### get_plugins()

Returns cached plugin data.

```php
protected static function get_plugins(): array
```

**Returns:** Result of `get_plugins()`.

---

### read_dependencies_from_plugin_headers()

Parses `Requires Plugins` headers from all plugins.

```php
protected static function read_dependencies_from_plugin_headers(): void
```

**Populates:** `$dependencies`, `$dependency_slugs`, `$dependent_slugs`

---

### sanitize_dependency_slugs()

Sanitizes comma-separated dependency slugs.

```php
protected static function sanitize_dependency_slugs( string $slugs ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slugs` | string | Comma-separated slug string |

**Returns:** Array of sanitized slugs.

**Validation:** Must match WordPress.org slug format (`/^[a-z0-9]+(-[a-z0-9]+)*$/`).

**Filters:** Applies `wp_plugin_dependencies_slug` to each slug.

---

### get_dependency_filepaths()

Builds map of dependency slugs to installed filepaths.

```php
protected static function get_dependency_filepaths(): array
```

**Returns:** Map of slug → filepath (or `false` if not installed).

---

### get_dependency_api_data()

Fetches plugin data from WordPress.org API.

```php
protected static function get_dependency_api_data(): array|void
```

**Returns:** API data array, or void if not in admin context.

**Caching:** 
- Main data: `wp_plugin_dependencies_plugin_data` transient (no expiry)
- Per-slug timeout: `wp_plugin_dependencies_plugin_timeout_{$slug}` (12 hours)

**Context:** Only runs on `plugins.php` or `plugin-install.php`.

---

### get_plugin_dirnames()

Builds slug → filepath map for all plugins.

```php
protected static function get_plugin_dirnames(): array
```

**Returns:** Map of slug → plugin filepath.

---

### get_circular_dependencies()

Detects all circular dependency pairs.

```php
protected static function get_circular_dependencies(): array[]
```

**Returns:** Array of `[slug_a, slug_b]` pairs.

---

### check_for_circular_dependencies()

Recursive helper for circular dependency detection.

```php
protected static function check_for_circular_dependencies( 
    array $dependents, 
    array $dependencies 
): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$dependents` | array | Chain of dependent slugs being checked |
| `$dependencies` | array | Dependencies to check against |

**Returns:** Array of circular dependency pairs found.

---

### convert_to_slug()

Converts plugin filepath to slug.

```php
protected static function convert_to_slug( string $plugin_file ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugin_file` | string | Plugin filepath |

**Returns:** Plugin slug.

**Special Case:** `hello.php` → `hello-dolly`

**Logic:**
- With directory: `my-plugin/my-plugin.php` → `my-plugin`
- Single file: `my-plugin.php` → `my-plugin`
