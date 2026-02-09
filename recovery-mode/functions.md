# Error Protection Functions

Core functions for the error protection and recovery mode system.

**Source:** `wp-includes/error-protection.php`

---

## wp_recovery_mode()

Accesses the global WordPress Recovery Mode instance.

```php
wp_recovery_mode(): WP_Recovery_Mode
```

**Returns:** The singleton `WP_Recovery_Mode` instance.

**Example:**
```php
if ( wp_recovery_mode()->is_active() ) {
    // Currently in recovery mode
}
```

---

## wp_paused_plugins()

Gets the storage instance for paused plugins.

```php
wp_paused_plugins(): WP_Paused_Extensions_Storage
```

**Returns:** Singleton `WP_Paused_Extensions_Storage` configured for plugins.

**Example:**
```php
// Check if a plugin is paused
$error = wp_paused_plugins()->get( 'my-plugin' );

// Get all paused plugins
$paused = wp_paused_plugins()->get_all();

// Pause a plugin manually
wp_paused_plugins()->set( 'my-plugin', $error );
```

---

## wp_paused_themes()

Gets the storage instance for paused themes.

```php
wp_paused_themes(): WP_Paused_Extensions_Storage
```

**Returns:** Singleton `WP_Paused_Extensions_Storage` configured for themes.

**Example:**
```php
// Check if a theme is paused
$error = wp_paused_themes()->get( 'my-theme' );

// Get all paused themes
$paused = wp_paused_themes()->get_all();
```

---

## wp_get_extension_error_description()

Formats an error into a human-readable description.

```php
wp_get_extension_error_description( array $error ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$error` | array | Error details from `error_get_last()` |

**Returns:** Formatted error string with HTML code tags.

**Output Format:**
> An error of type `<code>E_ERROR</code>` was caused in line `<code>42</code>` of the file `<code>/path/to/file.php</code>`. Error message: `<code>Call to undefined function...</code>`

**Error Type Conversion:**
Numeric error types are converted to their constant names (e.g., `1` → `E_ERROR`).

---

## wp_register_fatal_error_handler()

Registers the shutdown handler for fatal errors.

```php
wp_register_fatal_error_handler(): void
```

**Behavior:**
1. Checks if fatal error handler is enabled
2. Looks for custom handler at `WP_CONTENT_DIR/fatal-error-handler.php`
3. Falls back to `WP_Fatal_Error_Handler` if custom handler invalid
4. Registers handler via `register_shutdown_function()`

**Custom Handler:**
```php
// wp-content/fatal-error-handler.php
return new class {
    public function handle() {
        // Custom error handling
    }
};
```

---

## wp_is_fatal_error_handler_enabled()

Checks whether the fatal error handler is enabled.

```php
wp_is_fatal_error_handler_enabled(): bool
```

**Returns:** `true` if enabled, `false` if disabled.

**Disabled When:**
- `WP_DISABLE_FATAL_ERROR_HANDLER` constant is `true`
- `wp_fatal_error_handler_enabled` filter returns `false`

**Filter:** `wp_fatal_error_handler_enabled`

**Important:** This filter runs very early, before plugins load. To use it, define `$wp_filter` global in wp-config.php:

```php
// wp-config.php
$GLOBALS['wp_filter'] = array(
    'wp_fatal_error_handler_enabled' => array(
        10 => array(
            array(
                'accepted_args' => 0,
                'function'      => function() {
                    return false; // Disable recovery mode
                },
            ),
        ),
    ),
);
```

---

## Function Summary

| Function | Purpose |
|----------|---------|
| `wp_recovery_mode()` | Access recovery mode instance |
| `wp_paused_plugins()` | Access paused plugins storage |
| `wp_paused_themes()` | Access paused themes storage |
| `wp_get_extension_error_description()` | Format error for display |
| `wp_register_fatal_error_handler()` | Register shutdown handler |
| `wp_is_fatal_error_handler_enabled()` | Check if handler is enabled |
