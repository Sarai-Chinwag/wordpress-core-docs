# WP_Ability_Categories_Registry

Singleton registry for managing ability categories.

**Source:** `wp-includes/abilities-api/class-wp-ability-categories-registry.php`  
**Since:** 6.9.0

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$registered` | array | private | Map of slug → WP_Ability_Category |
| `$instance` | self\|null | private static | Singleton instance |

---

## Methods

### get_instance()

Returns the singleton registry instance.

```php
public static function get_instance(): ?self
```

**Returns:** Registry instance, or `null` if called before initialization.

**Note:** Fires `wp_abilities_api_categories_init` action on first call.

---

### register()

Registers a new ability category.

```php
public function register( string $slug, array $args ): ?WP_Ability_Category
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Category slug |
| `$args` | array | Configuration array |

**Returns:** `WP_Ability_Category` on success, `null` on failure.

**Validation:**
- Slug must be lowercase alphanumeric with dashes
- Required args: `label`, `description`

**Filters:**
- `wp_register_ability_category_args` — Modify args before registration

**Errors (via `_doing_it_wrong`):**
- Invalid slug format
- Duplicate slug

---

### unregister()

Removes a registered category.

```php
public function unregister( string $slug ): ?WP_Ability_Category
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Category slug to remove |

**Returns:** Removed `WP_Ability_Category`, or `null` if not found.

---

### get_registered()

Retrieves a single registered category.

```php
public function get_registered( string $slug ): ?WP_Ability_Category
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Category slug |

**Returns:** `WP_Ability_Category` or `null` if not registered.

---

### get_all_registered()

Retrieves all registered categories.

```php
public function get_all_registered(): array
```

**Returns:** Array of `WP_Ability_Category` instances.

---

### is_registered()

Checks if a category is registered.

```php
public function is_registered( string $slug ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Category slug |

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
