# WP_Block_Bindings_Registry

Singleton registry for managing block bindings sources.

**Source:** `wp-includes/class-wp-block-bindings-registry.php`  
**Since:** 6.5.0

## Overview

The registry manages all registered block bindings sources. Access via `WP_Block_Bindings_Registry::get_instance()` or use the wrapper functions in `block-bindings.php`.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$sources` | WP_Block_Bindings_Source[] | private | Map of source name → WP_Block_Bindings_Source |
| `$instance` | self\|null | private static | Singleton instance |
| `$allowed_source_properties` | string[] | private | Valid keys for source registration |
| `$supported_blocks` | string[] | private | Block types supporting bindings |

### Allowed Source Properties

- `label`
- `get_value_callback`
- `uses_context`

### Supported Blocks (Legacy Property)

- `core/paragraph`
- `core/heading`
- `core/image`
- `core/button`

**Note:** As of 6.9.0, use `get_block_bindings_supported_attributes()` for the canonical list.

---

## Methods

### get_instance()

Returns the singleton registry instance.

```php
public static function get_instance(): WP_Block_Bindings_Registry
```

**Returns:** Registry instance (creates if needed).

---

### register()

Registers a new block bindings source.

```php
public function register( string $source_name, array $source_properties ): WP_Block_Bindings_Source|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$source_name` | string | Namespaced source name |
| `$source_properties` | array | Configuration array |

**Returns:** `WP_Block_Bindings_Source` on success, `false` on failure.

**Validation (triggers `_doing_it_wrong`):**

- Source name must be a string
- Source name must not contain uppercase characters
- Source name must match pattern: `/^[a-z0-9-]+\/[a-z0-9-]+$/`
- Source must not already be registered
- Must include `label` property
- Must include `get_value_callback` property
- `get_value_callback` must be callable
- `uses_context` must be an array (if provided)
- No invalid properties allowed

**Example:**

```php
$registry = WP_Block_Bindings_Registry::get_instance();

$source = $registry->register( 'my-plugin/options', array(
    'label'              => 'Site Options',
    'get_value_callback' => function( $args, $block, $attr ) {
        return get_option( $args['option'] ?? '' );
    },
) );
```

---

### unregister()

Removes a registered block bindings source.

```php
public function unregister( string $source_name ): WP_Block_Bindings_Source|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$source_name` | string | Source name including namespace |

**Returns:** Removed `WP_Block_Bindings_Source`, or `false` if not found.

**Errors (via `_doing_it_wrong`):**

- Source not found

---

### get_all_registered()

Retrieves all registered sources.

```php
public function get_all_registered(): WP_Block_Bindings_Source[]
```

**Returns:** Array of `WP_Block_Bindings_Source` instances.

---

### get_registered()

Retrieves a single registered source.

```php
public function get_registered( string $source_name ): WP_Block_Bindings_Source|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$source_name` | string | Source name |

**Returns:** `WP_Block_Bindings_Source` or `null` if not registered.

---

### is_registered()

Checks if a source is registered.

```php
public function is_registered( ?string $source_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$source_name` | string\|null | Source name to check |

**Returns:** `true` if registered, `false` otherwise.

---

### __wakeup()

Validates data integrity on unserialization.

```php
public function __wakeup(): void
```

**Throws:** `UnexpectedValueException` if `$sources` is invalid or contains non-`WP_Block_Bindings_Source` items.

---

## Name Validation

Source names must:

1. Contain a namespace prefix with forward slash: `my-plugin/source`
2. Use only lowercase alphanumeric characters, dashes, and forward slashes
3. Match regex: `/^[a-z0-9-]+\/[a-z0-9-]+$/`
4. Be unique within the registry

**Valid:** `my-plugin/user-meta`, `core/post-data`, `acf/field-value`  
**Invalid:** `user_meta`, `MyPlugin/Source`, `my-plugin`, `CORE/POST-DATA`
