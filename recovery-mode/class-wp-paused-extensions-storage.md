# WP_Paused_Extensions_Storage

Storage class for managing paused plugins and themes during recovery mode.

**Source:** `wp-includes/class-wp-paused-extensions-storage.php`  
**Since:** 5.2.0

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$type` | string | protected | Extension type: `'plugin'` or `'theme'` |

## Option Storage

Paused extensions are stored in a session-specific option:

**Option Name:** `{session_id}_paused_extensions`

**Structure:**
```php
array(
    'plugin' => array(
        'plugin-slug' => array(
            'type'    => E_ERROR,
            'file'    => '/path/to/file.php',
            'line'    => 42,
            'message' => 'Error message',
        ),
    ),
    'theme' => array(
        'theme-slug' => array( /* error info */ ),
    ),
)
```

**Note:** Extensions are only paused for the current recovery mode session. Different sessions have separate storage.

---

## Methods

### __construct()

Creates a storage instance for the specified extension type.

```php
public function __construct( string $extension_type )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$extension_type` | string | Either `'plugin'` or `'theme'` |

---

### set()

Records an extension error, pausing the extension.

```php
public function set( string $extension, array $error ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$extension` | string | Plugin or theme directory name |
| `$error` | array | Error info from `error_get_last()` |

**Returns:** `true` on success, `false` on failure.

**Error Array:**
- `type` — PHP error type constant
- `file` — File where error occurred
- `line` — Line number
- `message` — Error message

**Behavior:**
- Skips update if identical error already stored
- Creates option if it doesn't exist
- Option autoload disabled

---

### delete()

Removes an extension from paused list.

```php
public function delete( string $extension ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$extension` | string | Plugin or theme directory name |

**Returns:** `true` on success (including if not paused), `false` on failure.

**Behavior:**
- Removes extension from type array
- Cleans up empty type arrays
- Deletes entire option if no paused extensions remain

---

### get()

Gets the error for a specific paused extension.

```php
public function get( string $extension ): array|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$extension` | string | Plugin or theme directory name |

**Returns:** Error array if paused, `null` otherwise.

---

### get_all()

Gets all paused extensions of this type with their errors.

```php
public function get_all(): array
```

**Returns:** Associative array of extension slug => error info.

---

### delete_all()

Removes all paused extensions of this type.

```php
public function delete_all(): bool
```

**Returns:** `true` on success, `false` on failure.

**Behavior:**
- Removes type key from option
- Deletes entire option if no other types remain

---

### is_api_loaded() <small>(protected)</small>

Checks if the options API is available.

```php
protected function is_api_loaded(): bool
```

**Returns:** `true` if `get_option()` exists.

**Purpose:** Recovery mode runs early in the WordPress load sequence. This ensures the options API is available before attempting storage operations.

---

### get_option_name() <small>(protected)</small>

Gets the session-specific option name.

```php
protected function get_option_name(): string
```

**Returns:** Option name, or empty string if recovery mode not active.

**Format:** `{session_id}_paused_extensions`

**Requirements:**
- Recovery mode must be active
- Session ID must be set

---

## Usage

WordPress provides two pre-configured instances:

```php
// Get paused plugins storage
$plugins = wp_paused_plugins();

// Get paused themes storage  
$themes = wp_paused_themes();

// Check if a plugin is paused
$error = $plugins->get( 'my-plugin' );
if ( $error ) {
    // Plugin is paused, $error contains error details
}

// Get all paused plugins
$all_paused = $plugins->get_all();
```

---

## Session Isolation

Each recovery mode session has its own paused extensions:

```
Session A: abc123_paused_extensions → pauses plugin-x
Session B: def456_paused_extensions → pauses plugin-y
```

This allows multiple administrators to debug different issues simultaneously without interference.
