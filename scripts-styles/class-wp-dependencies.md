# WP_Dependencies

Base class for managing dependencies. Extended by WP_Scripts and WP_Styles.

**Source:** `wp-includes/class-wp-dependencies.php`  
**Since:** 2.6.0

## Properties

### Public Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$registered` | _WP_Dependency[] | 2.6.8 | All registered items keyed by handle |
| `$queue` | string[] | 2.6.8 | Handles of queued items |
| `$to_do` | string[] | 2.6.0 | Handles pending processing |
| `$done` | string[] | 2.6.0 | Handles already processed |
| `$args` | array | 2.6.0 | Additional arguments per handle |
| `$groups` | (int\|false)[] | 2.8.0 | Group level per handle |
| `$group` | int | 2.8.0 | Deprecated (4.5.0) |

### Private Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$all_queued_deps` | array | 5.4.0 | Cache of flattened queue with dependencies |
| `$queued_before_register` | array | 5.9.0 | Items enqueued before registration |
| `$dependencies_with_missing_dependencies` | string[] | 6.9.1 | Handles with missing deps (for warning dedup) |

---

## Methods

### do_items()

Processes items and their dependencies.

```php
public function do_items(
    string|string[]|false $handles = false,
    int|false $group = false
): string[]
```

**Since:** 2.6.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handles` | string\|string[]\|false | Items to process (false = queue) |
| `$group` | int\|false | Group level |

**Returns:** Array of processed handles.

**Flow:**
1. Resolves all dependencies via `all_deps()`
2. Iterates `$to_do` array
3. Calls `do_item()` for each unprocessed handle
4. Adds successful items to `$done`

---

### do_item()

Processes a single item. Override in subclasses.

```php
public function do_item(
    string $handle,
    int|false $group = false
): bool
```

**Since:** 2.6.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Item handle |
| `$group` | int\|false | Group level |

**Returns:** `true` if registered, `false` otherwise.

**Note:** Base implementation only checks if handle is registered. Subclasses override to output assets.

---

### all_deps()

Recursively builds the dependency tree.

```php
public function all_deps(
    string|string[] $handles,
    bool $recursion = false,
    int|false $group = false
): bool
```

**Since:** 2.1.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handles` | string\|string[] | Handle(s) to resolve |
| `$recursion` | bool | Internal flag for recursive calls |
| `$group` | int\|false | Group level |

**Returns:** `true` on success, `false` on failure.

**Behavior:**
- Skips items already in `$done`
- Recursively resolves dependencies
- Handles query string args (e.g., `'handle?arg=value'`)
- Issues `_doing_it_wrong` for missing dependencies (6.9.1+)

---

### add()

Registers an item.

```php
public function add(
    string $handle,
    string|false $src,
    string[] $deps = array(),
    string|bool|null $ver = false,
    mixed $args = null
): bool
```

**Since:** 2.1.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Unique item name |
| `$src` | string\|false | URL or false for alias |
| `$deps` | string[] | Dependency handles |
| `$ver` | string\|bool\|null | Version (false=default, null=none) |
| `$args` | mixed | Additional args (e.g., media type) |

**Returns:** `true` if registered, `false` if already exists.

**Note:** Creates a `_WP_Dependency` instance stored in `$registered`.

---

### add_data()

Adds extra data to a registered item.

```php
public function add_data(
    string $handle,
    string $key,
    mixed $value
): bool
```

**Since:** 2.6.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Item handle |
| `$key` | string | Data key |
| `$value` | mixed | Data value |

**Returns:** `true` on success, `false` if not registered.

**Note:** `conditional` key is deprecated as of 6.9.0.

---

### get_data()

Gets extra data from a registered item.

```php
public function get_data(
    string $handle,
    string $key
): mixed
```

**Since:** 3.3.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Item handle |
| `$key` | string | Data key |

**Returns:** Data value or `false` if not found.

---

### remove()

Unregisters item(s).

```php
public function remove( string|string[] $handles ): void
```

**Since:** 2.1.0

---

### enqueue()

Adds item(s) to the queue.

```php
public function enqueue( string|string[] $handles ): void
```

**Since:** 2.1.0

**Behavior:**
- Parses query string args from handle
- Clears `$all_queued_deps` cache
- If not registered, stores in `$queued_before_register` for later

---

### dequeue()

Removes item(s) from the queue.

```php
public function dequeue( string|string[] $handles ): void
```

**Since:** 2.1.0

---

### query()

Queries item status.

```php
public function query(
    string $handle,
    string $status = 'registered'
): bool|_WP_Dependency
```

**Since:** 2.1.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Item handle |
| `$status` | string | Status to check |

| Status | Returns |
|--------|---------|
| `'registered'`, `'scripts'` | `_WP_Dependency` object or `false` |
| `'enqueued'`, `'queue'` | `true` if in queue or is dependency |
| `'to_do'`, `'to_print'` | `true` if pending |
| `'done'`, `'printed'` | `true` if processed |

---

### set_group()

Sets the group level for a handle.

```php
public function set_group(
    string $handle,
    bool $recursion,
    int|false $group
): bool
```

**Since:** 2.8.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Item handle |
| `$recursion` | bool | Internal flag |
| `$group` | int\|false | Group level |

**Returns:** `true` if not already in a lower group.

**Note:** Items can only move to lower groups, not higher.

---

### get_etag()

Generates ETag for cache validation.

```php
public function get_etag( string[] $load ): string
```

**Since:** 6.7.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$load` | string[] | Handles to include |

**Returns:** ETag string (e.g., `W/"abc123..."`).

**Note:** Uses MD5 hash of WordPress version and handle versions.

---

### get_dependency_warning_message() <small>(protected)</small>

Gets warning message for missing dependencies.

```php
protected function get_dependency_warning_message(
    string $handle,
    string[] $missing_dependency_handles
): string
```

**Since:** 6.9.1

---

### recurse_deps() <small>(protected)</small>

Recursively searches for a handle in the dependency tree.

```php
protected function recurse_deps(
    string[] $queue,
    string $handle
): bool
```

**Since:** 4.0.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$queue` | string[] | Queued handles |
| `$handle` | string | Handle to find |

**Returns:** `true` if found in dependency tree.

**Note:** Caches flattened result in `$all_queued_deps`.

---

## _WP_Dependency Class

Individual dependency item stored in `$registered`.

**Source:** `wp-includes/class-wp-dependency.php`

### Properties

| Property | Type | Description |
|----------|------|-------------|
| `$handle` | string | Unique identifier |
| `$src` | string\|false | Source URL or false |
| `$deps` | string[] | Dependency handles |
| `$ver` | string\|bool\|null | Version |
| `$args` | mixed | Additional args |
| `$extra` | array | Extra data |
| `$textdomain` | string | Translation domain |
| `$translations_path` | string | Path to translations |

### Methods

```php
public function __construct(
    string $handle,
    string|false $src,
    string[] $deps,
    string|bool|null $ver,
    mixed $args
)

public function add_data( string $key, mixed $value ): bool

public function set_translations(
    string $domain,
    string $path = ''
): bool
```

---

## Usage Example

```php
// Get the scripts instance
$scripts = wp_scripts();

// Check what's registered
foreach ( $scripts->registered as $handle => $dep ) {
    echo "$handle: {$dep->src}\n";
}

// Check queue
print_r( $scripts->queue );

// Check if processed
if ( $scripts->query( 'jquery', 'done' ) ) {
    echo "jQuery already printed";
}
```
