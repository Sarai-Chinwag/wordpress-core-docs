# WP_Ability_Category

Represents a registered ability category for grouping related abilities.

**Source:** `wp-includes/abilities-api/class-wp-ability-category.php`  
**Since:** 6.9.0

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$slug` | string | protected | Category slug identifier |
| `$label` | string | protected | Human-readable label |
| `$description` | string | protected | Category description |
| `$meta` | array | protected | Additional metadata |

---

## Methods

### __construct()

Instantiates a category. Do not call directly; use `wp_register_ability_category()`.

```php
public function __construct( string $slug, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Category slug |
| `$args` | array | Configuration array |

---

### get_slug()

Returns the category slug.

```php
public function get_slug(): string
```

---

### get_label()

Returns the human-readable label.

```php
public function get_label(): string
```

---

### get_description()

Returns the category description.

```php
public function get_description(): string
```

---

### get_meta()

Returns all metadata.

```php
public function get_meta(): array
```

---

### prepare_properties() <small>(protected)</small>

Validates and prepares configuration arguments.

```php
protected function prepare_properties( array $args ): array
```

**Throws:** `InvalidArgumentException` if `label` or `description` missing/invalid.

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
