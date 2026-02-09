# WordPress Loading Functions

Functions defined in `wp-includes/load.php` that handle WordPress initialization.

## Server Environment Functions

### wp_get_server_protocol()

Returns the HTTP protocol sent by the server.

```php
function wp_get_server_protocol(): string
```

**Returns:** HTTP protocol string (HTTP/1.0, HTTP/1.1, HTTP/2, HTTP/3)

**Since:** 4.4.0

---

### wp_fix_server_vars()

Fixes `$_SERVER` variables for various hosting setups.

```php
function wp_fix_server_vars(): void
```

**Purpose:**
- Normalizes `REQUEST_URI` for IIS
- Handles ISAPI_Rewrite and IIS Mod-Rewrite
- Fixes `SCRIPT_FILENAME` for PHP CGI
- Populates empty `PHP_SELF`
- Calls `wp_populate_basic_auth_from_authorization_header()`

**Since:** 3.0.0

---

### wp_populate_basic_auth_from_authorization_header()

Extracts Basic Auth credentials from the Authorization header.

```php
function wp_populate_basic_auth_from_authorization_header(): void
```

**Purpose:** CGI/FastCGI servers often don't pass `PHP_AUTH_USER` and `PHP_AUTH_PW`. This function extracts them from `HTTP_AUTHORIZATION` header.

**Since:** 5.6.0

---

## Requirements Checking

### wp_check_php_mysql_versions()

Validates server meets minimum requirements.

```php
function wp_check_php_mysql_versions(): void
```

**Checks:**
- PHP version >= `$required_php_version`
- Required PHP extensions (json, hash)
- MySQLi extension (unless db.php drop-in exists)

**Dies:** With error message if requirements not met.

**Since:** 3.0.0

---

## Environment Functions

### wp_get_environment_type()

Returns the current environment type.

```php
function wp_get_environment_type(): string
```

**Returns:** One of: `local`, `development`, `staging`, `production`

**Configuration:**
```php
// In wp-config.php
define( 'WP_ENVIRONMENT_TYPE', 'development' );

// Or environment variable
putenv( 'WP_ENVIRONMENT_TYPE=development' );
```

**Since:** 5.5.0

---

### wp_get_development_mode()

Returns the current development mode.

```php
function wp_get_development_mode(): string
```

**Returns:** One of: `core`, `plugin`, `theme`, `all`, or empty string

**Configuration:**
```php
define( 'WP_DEVELOPMENT_MODE', 'theme' );
```

**Since:** 6.3.0

---

### wp_is_development_mode()

Checks if a specific development mode is active.

```php
function wp_is_development_mode( string $mode ): bool
```

**Parameters:**
- `$mode` - Mode to check: `core`, `plugin`, `theme`, or `all`

**Since:** 6.3.0

---

## Maintenance Mode

### wp_maintenance()

Displays maintenance message and dies if maintenance mode is active.

```php
function wp_maintenance(): void
```

**Behavior:**
- Checks `wp_is_maintenance_mode()`
- Loads `wp-content/maintenance.php` drop-in if exists
- Otherwise shows default message with 503 status

**Since:** 3.0.0

---

### wp_is_maintenance_mode()

Checks if maintenance mode is enabled.

```php
function wp_is_maintenance_mode(): bool
```

**Logic:**
- Checks for `.maintenance` file in ABSPATH
- File must contain `$upgrading` timestamp
- Timestamp must be < 10 minutes old
- Returns `false` during installation

**Filter:** `enable_maintenance_mode`

**Since:** 5.5.0

---

## Timer Functions

### timer_float()

Gets elapsed time since PHP script start.

```php
function timer_float(): float
```

**Returns:** Seconds since `$_SERVER['REQUEST_TIME_FLOAT']`

**Since:** 5.8.0

---

### timer_start()

Starts the WordPress page timer.

```php
function timer_start(): bool
```

**Sets:** `$timestart` global

**Since:** 0.71

---

### timer_stop()

Returns time elapsed since timer_start().

```php
function timer_stop( int|bool $display = 0, int $precision = 3 ): string
```

**Parameters:**
- `$display` - Echo result (1/true) or return (0/false)
- `$precision` - Decimal places

**Since:** 0.71

---

## Debug Mode

### wp_debug_mode()

Configures PHP error reporting based on WP_DEBUG settings.

```php
function wp_debug_mode(): void
```

**Constants Used:**
- `WP_DEBUG` - Enable debug mode
- `WP_DEBUG_DISPLAY` - Display errors (default: true)
- `WP_DEBUG_LOG` - Log errors to debug.log or custom path

**Behavior:**
- `WP_DEBUG=true`: `error_reporting(E_ALL)`
- `WP_DEBUG=false`: Reports only core/compile/parse errors
- Disables display for XMLRPC, REST, AJAX, JSON requests

**Filter:** `enable_wp_debug_mode_checks`

**Since:** 3.0.0

---

## Language Directory

### wp_set_lang_dir()

Sets the `WP_LANG_DIR` constant.

```php
function wp_set_lang_dir(): void
```

**Priority:**
1. Custom `WP_LANG_DIR` if already defined
2. `WP_CONTENT_DIR/languages` if exists
3. `ABSPATH/WPINC/languages` fallback

**Since:** 3.0.0

---

## Database Functions

### require_wp_db()

Loads wpdb class and creates `$wpdb` instance.

```php
function require_wp_db(): void
```

**Process:**
1. Includes `class-wpdb.php`
2. Includes `wp-content/db.php` drop-in if exists
3. Creates `new wpdb()` with credentials from constants

**Since:** 2.5.0

---

### wp_set_wpdb_vars()

Configures database table prefix and field types.

```php
function wp_set_wpdb_vars(): void
```

**Sets:**
- `$wpdb->field_types` - Format specifiers for columns
- Table prefix via `$wpdb->set_prefix()`

**Dies:** If table prefix is invalid

**Since:** 3.0.0

---

## Object Cache

### wp_using_ext_object_cache()

Gets/sets whether external object cache is in use.

```php
function wp_using_ext_object_cache( ?bool $using = null ): bool
```

**Parameters:**
- `$using` - Set value, or null to just get current value

**Since:** 3.7.0

---

### wp_start_object_cache()

Initializes the object cache system.

```php
function wp_start_object_cache(): void
```

**Process:**
1. Loads `object-cache.php` drop-in if exists
2. Otherwise loads built-in cache (`cache.php`)
3. Calls `wp_cache_init()`
4. Registers global cache groups (for multisite)
5. Registers non-persistent groups

**Filter:** `enable_loading_object_cache_dropin`

**Since:** 3.0.0

---

## Installation Check

### wp_not_installed()

Redirects to installer if WordPress is not installed.

```php
function wp_not_installed(): void
```

**Behavior:**
- Returns if `is_blog_installed()` or `wp_installing()`
- On multisite: dies with error
- Otherwise: redirects to `/wp-admin/install.php`

**Since:** 3.0.0

---

## Plugin Loading

### wp_get_mu_plugins()

Gets array of must-use plugin files.

```php
function wp_get_mu_plugins(): array
```

**Returns:** Array of absolute paths to PHP files in `WPMU_PLUGIN_DIR`

**Since:** 3.0.0

---

### wp_get_active_and_valid_plugins()

Gets active plugin files.

```php
function wp_get_active_and_valid_plugins(): array
```

**Process:**
- Reads `active_plugins` option
- Validates each plugin file exists
- Excludes network plugins (if multisite)
- Skips paused plugins in recovery mode

**Since:** 3.0.0

---

### wp_skip_paused_plugins()

Removes paused plugins from array.

```php
function wp_skip_paused_plugins( array $plugins ): array
```

**Purpose:** Recovery mode skips plugins that caused fatal errors.

**Since:** 5.2.0

---

## Theme Loading

### wp_get_active_and_valid_themes()

Gets active theme directories.

```php
function wp_get_active_and_valid_themes(): array
```

**Returns:** Array with child theme path (if applicable) and parent theme path

**Since:** 5.1.0

---

### wp_skip_paused_themes()

Removes paused themes from array.

```php
function wp_skip_paused_themes( array $themes ): array
```

**Since:** 5.2.0

---

## Recovery Mode

### wp_is_recovery_mode()

Checks if recovery mode is active.

```php
function wp_is_recovery_mode(): bool
```

**Since:** 5.2.0

---

### is_protected_endpoint()

Checks if current endpoint should be protected against WSODs.

```php
function is_protected_endpoint(): bool
```

**Protected:**
- `wp-login.php`
- Admin backend (non-AJAX)
- Protected AJAX actions

**Filter:** `is_protected_endpoint`

**Since:** 5.2.0

---

### is_protected_ajax_action()

Checks if current AJAX action should be protected.

```php
function is_protected_ajax_action(): bool
```

**Protected Actions:**
- `edit-theme-plugin-file`
- `heartbeat`
- `install-plugin`
- `install-theme`
- `update-plugin`
- `update-theme`
- `activate-plugin`

**Filter:** `wp_protected_ajax_actions`

**Since:** 5.2.0

---

## Encoding

### wp_set_internal_encoding()

Sets PHP internal encoding to UTF-8.

```php
function wp_set_internal_encoding(): void
```

**Since:** 3.0.0

---

### wp_magic_quotes()

Adds magic quotes to superglobals.

```php
function wp_magic_quotes(): void
```

**Process:**
- Escapes `$_GET`, `$_POST`, `$_COOKIE`, `$_SERVER`
- Rebuilds `$_REQUEST` as `$_GET + $_POST`

**Since:** 3.0.0

---

## Shutdown

### shutdown_action_hook()

Fires shutdown action and closes cache.

```php
function shutdown_action_hook(): void
```

**Fires:** `shutdown` action

**Since:** 1.2.0

---

## Context Detection

### is_login()

Checks if on login screen.

```php
function is_login(): bool
```

**Since:** 6.1.0

---

### is_admin()

Checks if in admin area.

```php
function is_admin(): bool
```

**Since:** 1.5.1

---

### is_blog_admin()

Checks if in site admin (not network admin).

```php
function is_blog_admin(): bool
```

**Since:** 3.1.0

---

### is_network_admin()

Checks if in network admin.

```php
function is_network_admin(): bool
```

**Since:** 3.1.0

---

### is_user_admin()

Checks if in user admin.

```php
function is_user_admin(): bool
```

**Since:** 3.1.0

---

### is_multisite()

Checks if Multisite is enabled.

```php
function is_multisite(): bool
```

**Since:** 3.0.0

---

## Utility Functions

### absint()

Converts value to non-negative integer.

```php
function absint( mixed $maybeint ): int
```

**Since:** 2.5.0

---

### get_current_blog_id()

Returns current site ID.

```php
function get_current_blog_id(): int
```

**Since:** 3.1.0

---

### get_current_network_id()

Returns current network ID.

```php
function get_current_network_id(): int
```

**Since:** 4.6.0

---

### wp_installing()

Checks/sets installation mode.

```php
function wp_installing( ?bool $is_installing = null ): bool
```

**Since:** 4.4.0

---

### is_ssl()

Determines if SSL is being used.

```php
function is_ssl(): bool
```

**Checks:**
- `$_SERVER['HTTPS']` is 'on' or '1'
- `$_SERVER['SERVER_PORT']` is 443

**Since:** 2.6.0

---

## Request Detection

### wp_doing_ajax()

Checks if current request is WordPress AJAX.

```php
function wp_doing_ajax(): bool
```

**Filter:** `wp_doing_ajax`

**Since:** 4.7.0

---

### wp_doing_cron()

Checks if current request is WP-Cron.

```php
function wp_doing_cron(): bool
```

**Filter:** `wp_doing_cron`

**Since:** 4.8.0

---

### wp_using_themes()

Checks if themes should be loaded.

```php
function wp_using_themes(): bool
```

**Filter:** `wp_using_themes`

**Since:** 5.1.0

---

### wp_is_json_request()

Checks if request expects JSON response.

```php
function wp_is_json_request(): bool
```

**Since:** 5.0.0

---

### wp_is_jsonp_request()

Checks if request expects JSONP response.

```php
function wp_is_jsonp_request(): bool
```

**Since:** 5.2.0

---

### wp_is_xml_request()

Checks if request expects XML response.

```php
function wp_is_xml_request(): bool
```

**Since:** 5.2.0

---

## File Modification

### wp_is_file_mod_allowed()

Checks if file modifications are allowed.

```php
function wp_is_file_mod_allowed( string $context ): bool
```

**Filter:** `file_mod_allowed`

**Since:** 4.8.0

---

## Early Translation Loading

### wp_load_translations_early()

Loads translations before full WordPress init.

```php
function wp_load_translations_early(): void
```

**Purpose:** For error messages during bootstrap

**Since:** 3.4.0

---

## Byte Conversion

### wp_convert_hr_to_bytes()

Converts PHP ini shorthand to bytes.

```php
function wp_convert_hr_to_bytes( string $value ): int
```

**Examples:**
- `'40M'` → `41943040`
- `'1G'` → `1073741824`

**Since:** 2.3.0

---

### wp_is_ini_value_changeable()

Checks if PHP ini value can be changed at runtime.

```php
function wp_is_ini_value_changeable( string $setting ): bool
```

**Since:** 4.6.0
