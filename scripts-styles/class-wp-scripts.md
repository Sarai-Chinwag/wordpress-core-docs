# WP_Scripts

Core class for registering and outputting JavaScript files.

**Source:** `wp-includes/class-wp-scripts.php`  
**Since:** 2.1.0  
**Extends:** [WP_Dependencies](./class-wp-dependencies.md)

## Properties

### Public Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$base_url` | string | 2.6.0 | Base URL for scripts (trailing slash) |
| `$content_url` | string | 2.8.0 | URL of wp-content directory |
| `$default_version` | string | 2.6.0 | Default version string |
| `$in_footer` | array | 2.8.0 | Handles of scripts enqueued in footer |
| `$concat` | string | 2.8.0 | Handles to concatenate |
| `$concat_version` | string | 2.8.0 | Deprecated (3.4.0) |
| `$do_concat` | bool | 2.8.0 | Whether to concatenate |
| `$print_html` | string | 2.8.0 | HTML markup when concatenating |
| `$print_code` | string | 2.8.0 | Inline code when concatenating |
| `$ext_handles` | string | 2.8.0 | External handles (unused in core) |
| `$ext_version` | string | 2.8.0 | External versions (unused in core) |
| `$default_dirs` | array | 2.8.0 | Default script directories |

### Private Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$dependents_map` | array | 6.3.0 | Cache of dependent handles |
| `$delayed_strategies` | string[] | 6.3.0 | Valid delayed strategies (`defer`, `async`) |

---

## Methods

### __construct()

Initializes the scripts object and fires initialization action.

```php
public function __construct()
```

**Since:** 2.6.0

**Hooks:** Calls `do_action_ref_array( 'wp_default_scripts', array( &$this ) )`

---

### init()

Fires the initialization action.

```php
public function init(): void
```

**Since:** 3.4.0

**Hooks:**

```php
do_action_ref_array( 'wp_default_scripts', array( &$this ) );
```

---

### print_scripts()

Prints scripts and their dependencies.

```php
public function print_scripts(
    string|string[]|false $handles = false,
    int|false $group = false
): string[]
```

**Since:** 2.1.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handles` | string\|string[]\|false | Scripts to print (false = queue) |
| `$group` | int\|false | Group level or false |

**Returns:** Handles of printed scripts.

---

### print_extra_script()

Prints extra data attached to a script.

```php
public function print_extra_script(
    string $handle,
    bool $display = true
): bool|string|void
```

**Since:** 3.3.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Script handle |
| `$display` | bool | Print or return |

**Returns:** Void if no data, script if `$display` true, true otherwise.

---

### do_item()

Processes and outputs a single script.

```php
public function do_item(
    string $handle,
    int|false $group = false
): bool
```

**Since:** 2.6.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Script handle |
| `$group` | int\|false | Group level |

**Returns:** `true` on success, `false` on failure.

**Behavior:**
- Skips scripts with conditional comments
- Handles defer/async strategies
- Outputs translations before script
- Applies `script_loader_src` and `script_loader_tag` filters

---

### add_inline_script()

Adds inline JavaScript to a registered script.

```php
public function add_inline_script(
    string $handle,
    string $data,
    string $position = 'after'
): bool
```

**Since:** 4.5.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Script handle (lowercase) |
| `$data` | string | JavaScript code |
| `$position` | string | `'before'` or `'after'` |

**Returns:** `true` on success, `false` on failure.

---

### get_inline_script_data()

Gets inline script data without tags.

```php
public function get_inline_script_data(
    string $handle,
    string $position = 'after'
): string
```

**Since:** 6.3.0

**Returns:** Inline script code or empty string.

---

### get_inline_script_tag()

Gets inline script with `<script>` tags.

```php
public function get_inline_script_tag(
    string $handle,
    string $position = 'after'
): string
```

**Since:** 6.3.0

**Returns:** Complete script tag or empty string.

---

### localize()

Attaches localization data to a script.

```php
public function localize(
    string $handle,
    string $object_name,
    array $l10n
): bool
```

**Since:** 2.1.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Script handle |
| `$object_name` | string | JavaScript variable name |
| `$l10n` | array | Data to localize |

**Returns:** `true` on success.

**Note:** For `jquery` handle, automatically uses `jquery-core`.

---

### set_group()

Sets the group level for a script handle.

```php
public function set_group(
    string $handle,
    bool $recursion,
    int|false $group = false
): bool
```

**Since:** 2.8.0

**Returns:** `true` if not already in a lower group.

---

### set_translations()

Sets translation text domain for a script.

```php
public function set_translations(
    string $handle,
    string $domain = 'default',
    string $path = ''
): bool
```

**Since:** 5.0.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Script handle |
| `$domain` | string | Text domain |
| `$path` | string | Path to translation files |

**Returns:** `true` on success, `false` if handle not registered.

**Note:** Automatically adds `wp-i18n` as a dependency.

---

### print_translations()

Outputs translation strings for a script.

```php
public function print_translations(
    string $handle,
    bool $display = true
): string|false
```

**Since:** 5.0.0

**Returns:** Translation script or `false` if none.

---

### all_deps()

Determines all dependencies for given handles.

```php
public function all_deps(
    string|string[] $handles,
    bool $recursion = false,
    int|false $group = false
): bool
```

**Since:** 2.1.0

**Hooks:**

```php
$this->to_do = apply_filters( 'print_scripts_array', $this->to_do );
```

---

### do_head_items()

Processes scripts for the head group.

```php
public function do_head_items(): string[]
```

**Since:** 2.8.0

**Returns:** Handles of processed scripts.

---

### do_footer_items()

Processes scripts for the footer group.

```php
public function do_footer_items(): string[]
```

**Since:** 2.8.0

**Returns:** Handles of processed scripts.

---

### in_default_dir()

Checks if source is in a default directory.

```php
public function in_default_dir( string $src ): bool
```

**Since:** 2.8.0

**Returns:** `true` if in default directory.

---

### add_data()

Adds data to a registered script with validation.

```php
public function add_data(
    string $handle,
    string $key,
    mixed $value
): bool
```

**Since:** 6.3.0

**Validated Keys:**
- `strategy` — Must be `'defer'` or `'async'`
- `fetchpriority` — Must be `'auto'`, `'low'`, or `'high'`
- `conditional` — Clears dependencies

**Returns:** `true` on success, `false` on failure or invalid value.

---

### reset()

Resets concatenation properties.

```php
public function reset(): void
```

**Since:** 2.8.0

Clears: `do_concat`, `print_code`, `concat`, `concat_version`, `print_html`, `ext_version`, `ext_handles`

---

### get_dependency_warning_message()

Gets localized warning message for missing dependencies.

```php
protected function get_dependency_warning_message(
    string $handle,
    string[] $missing_dependency_handles
): string
```

**Since:** 6.9.1

---

## Private Methods

### are_all_dependents_in_footer()

Checks if all dependents of a handle are in footer group.

```php
private function are_all_dependents_in_footer( string $handle ): bool
```

**Since:** 6.4.0

---

### get_dependents()

Gets all scripts that depend on a handle.

```php
private function get_dependents( string $handle ): string[]
```

**Since:** 6.3.0

---

### is_delayed_strategy()

Checks if strategy is `defer` or `async`.

```php
private function is_delayed_strategy( mixed $strategy ): bool
```

**Since:** 6.3.0

---

### is_valid_fetchpriority()

Validates fetchpriority value.

```php
private function is_valid_fetchpriority( mixed $priority ): bool
```

**Since:** 6.9.0

Valid values: `'auto'`, `'low'`, `'high'`

---

### get_eligible_loading_strategy()

Determines the best loading strategy for a script.

```php
private function get_eligible_loading_strategy( string $handle ): string
```

**Since:** 6.3.0

**Returns:** `'async'`, `'defer'`, or empty string.

**Logic:**
- `async` can fallback to `defer`
- `defer` cannot use `async`
- Scripts with `after` inline scripts cannot be delayed

---

### filter_eligible_strategies()

Filters eligible strategies based on dependents.

```php
private function filter_eligible_strategies(
    string $handle,
    ?string[] $eligible_strategies = null,
    array $checked = array(),
    array &$stored_results = array()
): string[]
```

**Since:** 6.3.0

---

### get_highest_fetchpriority_with_dependents()

Gets highest fetchpriority considering dependents.

```php
private function get_highest_fetchpriority_with_dependents(
    string $handle,
    array $checked = array(),
    array &$stored_results = array()
): ?string
```

**Since:** 6.9.0

Priority order: `low` < `auto` < `high`

---

### has_inline_script()

Checks if handle has inline scripts.

```php
private function has_inline_script(
    string $handle,
    ?string $position = null
): bool
```

**Since:** 6.3.0

---

## Deprecated Methods

### print_scripts_l10n()

```php
public function print_scripts_l10n( string $handle, bool $display = true )
```

**Deprecated:** 3.3.0 — Use `print_extra_script()`.

---

### print_inline_script()

```php
public function print_inline_script( string $handle, string $position = 'after', bool $display = true )
```

**Deprecated:** 6.3.0 — Use `get_inline_script_data()` or `get_inline_script_tag()`.
