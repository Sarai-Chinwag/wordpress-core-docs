# WP_Site_Health_Auto_Updates

Tests automatic update capabilities and configuration.

**Since:** 5.2.0  
**Source:** `wp-admin/includes/class-wp-site-health-auto-updates.php`

## Constructor

Requires `wp-admin/includes/class-wp-upgrader.php`.

---

## Methods

### run_tests()

Executes all auto-update tests and returns results.

```php
public function run_tests(): array
```

**Returns:** Array of test result objects with `description` and `severity` properties.

**Severities:**
- `pass` — Test passed
- `info` — Informational
- `warning` — Non-critical issue
- `fail` — Critical failure

---

### test_constants()

Checks if auto-update constants are correctly configured.

```php
public function test_constants( 
    string $constant, 
    bool|string|array $value 
): array|null
```

**Parameters:**
- `$constant` — Constant name (e.g., `WP_AUTO_UPDATE_CORE`)
- `$value` — Expected value(s)

**Checks:** `WP_AUTO_UPDATE_CORE` should be `true`, `'beta'`, `'rc'`, `'development'`, `'branch-development'`, or `'minor'`

---

### test_wp_version_check_attached()

Verifies `wp_version_check()` filter is attached.

```php
public function test_wp_version_check_attached(): array|null
```

**Fails if:** Plugin disabled updates via `wp_version_check` filter

---

### test_filters_automatic_updater_disabled()

Checks `automatic_updater_disabled` filter.

```php
public function test_filters_automatic_updater_disabled(): array|null
```

**Fails if:** `apply_filters('automatic_updater_disabled', false)` returns `true`

---

### test_wp_automatic_updates_disabled()

Checks if `WP_Automatic_Updater::is_disabled()` returns true.

```php
public function test_wp_automatic_updates_disabled(): array|false
```

---

### test_if_failed_update()

Checks for previous auto-update failures.

```php
public function test_if_failed_update(): array|false
```

**Checks:** `auto_core_update_failed` site option

**Severity:**
- `warning` if non-critical failure (retry pending)
- `warning` if critical failure (updates disabled until manual update)

---

### test_vcs_abspath()

Detects version control systems (.svn, .git, .hg, .bzr).

```php
public function test_vcs_abspath(): array
```

**Filter:** `automatic_updates_is_vcs_checkout` — Allow updates despite VCS

---

### test_check_wp_filesystem_method()

Checks if FTP credentials are required.

```php
public function test_check_wp_filesystem_method(): array
```

**Fails if:** Site requires FTP credentials for updates

---

### test_all_files_writable()

Verifies all core files are writable.

```php
public function test_all_files_writable(): array|false
```

**Process:**
1. Gets checksums from WordPress.org
2. Checks each file's writeability
3. Reports up to 20 unwritable files

---

### test_accepts_dev_updates()

For development versions, checks if dev updates allowed.

```php
public function test_accepts_dev_updates(): array|false|null
```

**Checks:**
- `WP_AUTO_UPDATE_CORE` not set to `'minor'` or `false`
- `allow_dev_auto_core_updates` filter

---

### test_accepts_minor_updates()

Checks if security/maintenance updates allowed.

```php
public function test_accepts_minor_updates(): array|null
```

**Checks:**
- `WP_AUTO_UPDATE_CORE` not `false`
- `allow_minor_auto_core_updates` filter

---

## Test Results Format

Each test returns:

```php
array(
    'description' => 'Human-readable explanation',
    'severity'    => 'pass|info|warning|fail',
)
```

Or `null`/`false` if test passes or doesn't apply.

---

## Integration with Site Health

Called by `WP_Site_Health::get_test_background_updates()`:

```php
$updater = new WP_Site_Health_Auto_Updates();
$tests   = $updater->run_tests();

foreach ( $tests as $test ) {
    if ( 'fail' === $test->severity ) {
        // Mark as critical
    } elseif ( 'warning' === $test->severity ) {
        // Mark as recommended
    }
}
```

---

## Related Constants

| Constant | Values | Effect |
|----------|--------|--------|
| `WP_AUTO_UPDATE_CORE` | `true` | All auto-updates |
| | `false` | No auto-updates |
| | `'minor'` | Security/maintenance only |
| | `'beta'`, `'rc'`, `'development'` | Pre-release updates |
| `DISALLOW_FILE_MODS` | `true` | Disables all file modifications |
| `AUTOMATIC_UPDATER_DISABLED` | `true` | Disables automatic updater |

---

## Related Filters

| Filter | Purpose |
|--------|---------|
| `automatic_updater_disabled` | Disable auto-updater |
| `allow_dev_auto_core_updates` | Allow dev version updates |
| `allow_minor_auto_core_updates` | Allow minor updates |
| `automatic_updates_is_vcs_checkout` | Allow updates in VCS dirs |
