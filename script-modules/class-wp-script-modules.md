# WP_Script_Modules Class

Core class for registering and managing script modules.

**Since:** 6.5.0  
**Source:** `wp-includes/class-wp-script-modules.php`

## Properties

### Private Properties

| Property | Type | Description |
|----------|------|-------------|
| `$registered` | `array<string, array>` | Registered script modules, keyed by ID |
| `$queue` | `string[]` | IDs of enqueued script modules |
| `$done` | `string[]` | IDs of script modules that have been printed |
| `$a11y_available` | `bool` | Whether @wordpress/a11y module is available |
| `$dependents_map` | `array<string, string[]>` | Cache of dependents for each module |
| `$priorities` | `string[]` | Valid fetchpriority values: `['low', 'auto', 'high']` |
| `$modules_with_missing_dependencies` | `string[]` | IDs with missing deps (for warning deduplication) |

---

## Public Methods

### register()

Registers a script module.

```php
public function register(
    string $id,
    string $src,
    array $deps = array(),
    $version = false,
    array $args = array()
)
```

**Since:** 6.5.0  
**Updated:** 6.9.0 — Added `$args` parameter.

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$id` | `string` | Unique identifier. Must be non-empty. |
| `$src` | `string` | Full URL or path relative to WP root. |
| `$deps` | `array` | Dependencies (strings or arrays with `id` and `import` keys). |
| `$version` | `string\|false\|null` | Version string, `false` for WP version, `null` for none. |
| `$args` | `array` | `in_footer` (bool), `fetchpriority` ('auto'|'low'|'high'). |

#### Behavior

- Does nothing if a module with the same ID is already registered
- Emits `_doing_it_wrong()` if ID is empty
- Normalizes dependencies to arrays with `id` and `import` keys
- Validates `fetchpriority` value

---

### enqueue()

Marks a script module for output.

```php
public function enqueue(
    string $id,
    string $src = '',
    array $deps = array(),
    $version = false,
    array $args = array()
)
```

**Since:** 6.5.0  
**Updated:** 6.9.0 — Added `$args` parameter.

#### Behavior

- Adds `$id` to the queue if not already present
- If `$src` provided and module not registered, registers it

---

### dequeue()

Removes a script module from the queue.

```php
public function dequeue( string $id )
```

**Since:** 6.5.0

---

### deregister()

Removes a script module from the registry.

```php
public function deregister( string $id )
```

**Since:** 6.5.0

#### Behavior

Also calls `dequeue()` to remove from the queue.

---

### get_queue()

Gets IDs for queued script modules.

```php
public function get_queue(): array
```

**Since:** 6.9.0

#### Return

`string[]` — Array of script module IDs.

---

### set_fetchpriority()

Sets the fetch priority for a registered script module.

```php
public function set_fetchpriority( string $id, string $priority ): bool
```

**Since:** 6.9.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$id` | `string` | Script module identifier. |
| `$priority` | `string` | `'auto'`, `'low'`, or `'high'`. Empty string becomes `'auto'`. |

#### Return

`bool` — `true` on success, `false` if module not registered or invalid priority.

---

### set_in_footer()

Sets whether a script module should be printed in the footer.

```php
public function set_in_footer( string $id, bool $in_footer ): bool
```

**Since:** 6.9.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$id` | `string` | Script module identifier. |
| `$in_footer` | `bool` | Whether to print in footer. |

#### Return

`bool` — `true` on success, `false` if module not registered.

#### Note

Only relevant in block themes. Classic themes always print in footer.

---

### add_hooks()

Adds the hooks to print script module output.

```php
public function add_hooks()
```

**Since:** 6.5.0

#### Hooks Added

**Frontend (block themes):**
- `wp_head` → `print_import_map()`, `print_script_module_preloads()`, `print_head_enqueued_script_modules()`
- `wp_footer` → `print_enqueued_script_modules()`, `print_script_module_data()`, `print_a11y_script_module_html()`

**Frontend (classic themes):**
- `wp_footer` → All output methods

**Admin:**
- `admin_print_footer_scripts` → All output methods

---

### print_import_map()

Prints the import map.

```php
public function print_import_map()
```

**Since:** 6.5.0

#### Output

```html
<script type="importmap" id="wp-importmap">
{"imports":{"@wordpress/interactivity":"..."}}
</script>
```

Only prints if there are imports to include.

---

### print_head_enqueued_script_modules()

Prints enqueued script modules in `<head>`.

```php
public function print_head_enqueued_script_modules()
```

**Since:** 6.9.0

#### Behavior

- Only used in block themes
- Prints modules where `in_footer` is `false`
- Skips if any dependency is set to print in footer

---

### print_enqueued_script_modules()

Prints enqueued script modules in footer.

```php
public function print_enqueued_script_modules()
```

**Since:** 6.5.0

#### Behavior

Prints all remaining queued modules that haven't been printed yet.

---

### print_script_module_preloads()

Prints modulepreload links for dependencies.

```php
public function print_script_module_preloads()
```

**Since:** 6.5.0

#### Output

```html
<link rel="modulepreload" href="..." id="module-id-js-modulepreload" fetchpriority="...">
```

#### Behavior

- Only preloads static dependencies
- Does not preload modules marked for enqueue (they get `<script>` tags instead)
- Inherits highest `fetchpriority` from dependent enqueued modules

---

### print_script_module_data()

Prints data associated with script modules.

```php
public function print_script_module_data(): void
```

**Since:** 6.7.0

#### Output

```html
<script type="application/json" id="wp-script-module-data-my-module">
{"key":"value"}
</script>
```

#### Behavior

- Applies `script_module_data_{$module_id}` filter for each module
- Only prints if filter returns non-empty array
- Uses safe JSON encoding (escapes `<`, preserves `/`, handles UTF-8)
- Sets `$a11y_available` flag if `@wordpress/a11y` is encountered

---

### print_a11y_script_module_html()

Prints accessibility announcement HTML.

```php
public function print_a11y_script_module_html()
```

**Since:** 6.7.0

#### Output

Hidden container with ARIA live regions for `@wordpress/a11y` module.

#### Behavior

Only prints if `@wordpress/a11y` module is in use.

---

## Private Methods

### get_src()

Gets the versioned URL for a script module.

```php
private function get_src( string $id ): string
```

**Since:** 6.5.0

#### Behavior

- Returns empty string if module not registered
- Appends `?ver=` query param based on version setting
- Applies `script_module_loader_src` filter

---

### get_dependencies()

Recursively retrieves all dependencies for given module IDs.

```php
private function get_dependencies(
    array $ids,
    array $import_types = array( 'static', 'dynamic' )
): array
```

**Since:** 6.5.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ids` | `string[]` | Module identifiers to get dependencies for. |
| `$import_types` | `string[]` | Types to include: `'static'`, `'dynamic'`, or both. |

#### Return

`array<string, array>` — Dependencies keyed by ID.

---

### get_dependents()

Gets direct dependents of a script module (not recursive).

```php
private function get_dependents( string $id ): array
```

**Since:** 6.9.0

#### Return

`string[]` — IDs of modules that depend on this one.

#### Behavior

Caches results in `$dependents_map` for performance.

---

### get_recursive_dependents()

Gets all dependents recursively.

```php
private function get_recursive_dependents( string $id ): array
```

**Since:** 6.9.0

#### Return

`string[]` — All IDs that depend on this module (direct and indirect).

---

### get_sorted_dependencies()

Sorts module IDs in dependency order.

```php
private function get_sorted_dependencies(
    array $ids,
    array $import_types = array( 'static', 'dynamic' )
): array
```

**Since:** 6.9.0

#### Return

`string[]` — Sorted IDs (dependencies before dependents).

---

### get_highest_fetchpriority()

Gets the highest fetch priority among given module IDs.

```php
private function get_highest_fetchpriority( array $ids ): string
```

**Since:** 6.9.0

#### Return

`'low'|'auto'|'high'` — Highest priority found.

#### Behavior

Priority order: `low` < `auto` < `high`

---

### print_script_module()

Prints a single script module tag.

```php
private function print_script_module( string $id )
```

**Since:** 6.9.0

#### Output

```html
<script type="module" src="..." id="module-id-js-module" fetchpriority="..."></script>
```

#### Behavior

- Skips if already printed or not in queue
- Determines effective `fetchpriority` from dependents
- Adds `data-wp-fetchpriority` if inherited priority differs from registered

---

### get_import_map()

Builds the import map array.

```php
private function get_import_map(): array
```

**Since:** 6.5.0

#### Return

```php
array(
    'imports' => array(
        'module-id' => 'https://...',
    )
)
```

---

### is_valid_fetchpriority()

Validates a fetchpriority value.

```php
private function is_valid_fetchpriority( $priority ): bool
```

**Since:** 6.9.0

---

### sort_item_dependencies()

Recursively sorts a single module's dependencies.

```php
private function sort_item_dependencies(
    string $id,
    array $import_types,
    array &$sorted
): bool
```

**Since:** 6.9.0

#### Return

`bool` — `true` on success, `false` if missing dependencies.

#### Behavior

Emits `_doing_it_wrong()` if module has missing dependencies (once per module).

---

### get_marked_for_enqueue()

Retrieves modules marked for enqueue.

```php
private function get_marked_for_enqueue(): array
```

**Since:** 6.5.0

**Note:** Private method, but some ecosystem plugins access via Reflection. Use `get_queue()` instead.
