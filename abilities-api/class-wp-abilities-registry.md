# WP_Abilities_Registry

Singleton registry for managing registered abilities.

**Source:** `wp-includes/abilities-api/class-wp-abilities-registry.php`  
**Since:** 6.9.0

## Overview

The registry is a singleton initialized during WordPress bootstrap. Access via `WP_Abilities_Registry::get_instance()` or use the wrapper functions in `abilities-api.php`.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$registered` | array | private | Map of ability name → WP_Ability |
| `$instance` | self\|null | private static | Singleton instance |

---

## Methods

### get_instance()

Returns the singleton registry instance.

```php
public static function get_instance(): ?self
```

**Returns:** Registry instance, or `null` if called before initialization.

**Note:** Fires `wp_abilities_api_init` action on first call.

---

### register()

Registers a new ability.

```php
public function register( string $name, array $args ): ?WP_Ability
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Namespaced ability name |
| `$args` | array | Configuration array |

**Returns:** `WP_Ability` on success, `null` on failure.

**Validation:**
- Name must contain namespace prefix (forward slash)
- Name must be lowercase alphanumeric with dashes and slashes
- Category must be registered
- Required args: `label`, `description`, `category`, `execute_callback`, `permission_callback`

**Filters:**
- `wp_register_ability_args` — Modify args before registration

**Errors (via `_doing_it_wrong`):**
- Invalid ability name format
- Category not registered
- Duplicate ability name
- Invalid configuration

---

### unregister()

Removes a registered ability.

```php
public function unregister( string $name ): ?WP_Ability
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Ability name to remove |

**Returns:** Removed `WP_Ability`, or `null` if not found.

---

### get_registered()

Retrieves a single registered ability.

```php
public function get_registered( string $name ): ?WP_Ability
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Ability name |

**Returns:** `WP_Ability` or `null` if not registered.

---

### get_all_registered()

Retrieves all registered abilities.

```php
public function get_all_registered(): array
```

**Returns:** Array of `WP_Ability` instances.

---

### is_registered()

Checks if an ability is registered.

```php
public function is_registered( string $name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Ability name |

**Returns:** `true` if registered, `false` otherwise.

---

### __wakeup()

Prevents unserialization (security hardening).

```php
public function __wakeup(): void
```

**Throws:** `LogicException`

---

### __sleep()

Prevents serialization (security hardening).

```php
public function __sleep(): array
```

**Throws:** `LogicException`

---

## Name Validation

Ability names must:

1. Contain a namespace prefix with forward slash: `my-plugin/ability`
2. Use only lowercase alphanumeric characters, dashes, and forward slashes
3. Be unique within the registry

Valid: `my-plugin/export-users`, `core/create-post`  
Invalid: `export_users`, `MyPlugin/Ability`, `my-plugin`
