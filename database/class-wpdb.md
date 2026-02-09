# class wpdb

WordPress database access abstraction class.

**Since:** 0.71  
**Source:** `wp-includes/class-wpdb.php`

---

## Overview

The `wpdb` class provides methods for interacting with the WordPress database. A global instance `$wpdb` is available throughout WordPress.

```php
global $wpdb;
$results = $wpdb->get_results( "SELECT * FROM {$wpdb->posts}" );
```

---

## Properties

### Table Name Properties (Per-Site)

These properties contain the prefixed table names for per-site tables.

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$posts` | string | 1.5.0 | Posts table |
| `$postmeta` | string | 1.5.0 | Post metadata table |
| `$comments` | string | 1.5.0 | Comments table |
| `$commentmeta` | string | 2.9.0 | Comment metadata table |
| `$terms` | string | 2.3.0 | Terms table |
| `$term_taxonomy` | string | 2.3.0 | Term taxonomy table |
| `$term_relationships` | string | 2.3.0 | Term relationships table |
| `$termmeta` | string | 4.4.0 | Term metadata table |
| `$options` | string | 1.5.0 | Options table |
| `$links` | string | 1.5.0 | Links table |

### Table Name Properties (Global)

Global tables shared across multisite.

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$users` | string | 1.5.0 | Users table |
| `$usermeta` | string | 2.3.0 | User metadata table |

### Table Name Properties (Multisite Global)

Multisite-only global tables.

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$blogs` | string\|null | 3.0.0 | Blogs table |
| `$blogmeta` | string\|null | 5.1.0 | Blog metadata table |
| `$site` | string\|null | 3.0.0 | Sites table |
| `$sitemeta` | string\|null | 3.0.0 | Site metadata table |
| `$signups` | string\|null | 3.0.0 | Signups table |
| `$registration_log` | string\|null | 3.0.0 | Registration log table |
| `$sitecategories` | string\|null | 3.0.0 | Sitewide terms table (deprecated) |

### Table List Arrays

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$tables` | string[] | 2.5.0 | List of per-site table names (unprefixed) |
| `$global_tables` | string[] | 3.0.0 | List of global table names |
| `$ms_global_tables` | string[] | 3.0.0 | List of multisite global table names |
| `$old_tables` | string[] | 2.9.0 | List of deprecated table names |
| `$old_ms_global_tables` | string[] | 6.1.0 | List of deprecated MS global table names |

### Prefix Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$prefix` | string | 2.5.0 | Current table prefix (includes blog ID in multisite) |
| `$base_prefix` | string | 3.0.0 | Base table prefix (without blog ID) |

### Query State Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$last_query` | string | 0.71 | The last SQL query executed |
| `$last_result` | stdClass[]\|null | 0.71 | Results from the last query |
| `$last_error` | string | 2.5.0 | Error message from the last query |
| `$num_queries` | int | 1.2.0 | Total number of queries executed |
| `$num_rows` | int | 0.71 | Number of rows returned by last SELECT |
| `$rows_affected` | int | 0.71 | Number of rows affected by last query |
| `$insert_id` | int | 0.71 | AUTO_INCREMENT ID from last INSERT |
| `$func_call` | string | 3.0.0 | Description of last query call |

### Query Logging

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$queries` | array[] | 1.5.0 | Log of executed queries (when SAVEQUERIES enabled) |

Each query log entry is an array: `[ SQL, time, caller, start_time, custom_data ]`

### Error Handling Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$show_errors` | bool | 0.71 | Whether to display SQL errors |
| `$suppress_errors` | bool | 2.5.0 | Whether to suppress errors during bootstrap |
| `$error` | WP_Error\|string | 2.5.0 | Last SQL error encountered |

### Connection Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$ready` | bool | 2.3.2 | Whether connection is ready for queries |
| `$blogid` | int | 3.0.0 | Current blog ID |
| `$siteid` | int | 3.0.0 | Current site/network ID |
| `$is_mysql` | bool | 3.3.0 | Whether using MySQL |

### Character Set Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$charset` | string | 2.2.0 | Database character set |
| `$collate` | string | 2.2.0 | Database collation |
| `$field_types` | array | 2.8.0 | Format specifiers for known columns |

### Protected/Private Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$dbh` | mysqli\|false\|null | 0.71 | Database connection handle |
| `$dbuser` | string | 2.9.0 | Database username |
| `$dbpassword` | string | 3.1.0 | Database password |
| `$dbname` | string | 3.1.0 | Database name |
| `$dbhost` | string | 3.1.0 | Database host |
| `$result` | mysqli_result\|bool\|null | 0.71 | Raw query result |
| `$col_info` | array | 0.71 | Column info from last query |
| `$col_meta` | array | 4.2.0 | Cached column metadata |
| `$table_charset` | string[] | 4.2.0 | Cached table charsets |
| `$reconnect_retries` | int | 3.9.0 | Connection retry attempts (default 5) |
| `$incompatible_modes` | string[] | 3.9.0 | SQL modes to disable |
| `$time_start` | float | 1.5.0 | Query timer start time |

---

## Methods

### Constructor

#### __construct()

Creates a database connection.

```php
public function __construct( $dbuser, $dbpassword, $dbname, $dbhost )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$dbuser` | string | Database username |
| `$dbpassword` | string | Database password |
| `$dbname` | string | Database name |
| `$dbhost` | string | Database host |

**Note:** WordPress creates the global `$wpdb` instance automatically. Don't instantiate manually unless creating a secondary connection.

---

### Query Methods

#### query()

Executes a database query.

```php
public function query( $query ): int|bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | string | SQL query to execute |

**Returns:** 
- `int` - Number of rows affected/selected
- `true` - For CREATE, ALTER, TRUNCATE, DROP
- `false` - On error

**Example:**

```php
// SELECT - returns row count
$count = $wpdb->query( "SELECT * FROM {$wpdb->posts}" );

// UPDATE - returns affected rows
$affected = $wpdb->query( 
    $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_status = %s WHERE ID = %d", 'draft', 123 )
);

// CREATE - returns true
$result = $wpdb->query( "CREATE TABLE my_table (id INT)" );
```

---

#### get_var()

Retrieves a single value from the database.

```php
public function get_var( $query = null, $x = 0, $y = 0 ): string|null
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$query` | string\|null | null | SQL query. Null uses previous result |
| `$x` | int | 0 | Column index |
| `$y` | int | 0 | Row index |

**Returns:** String value or null on failure.

**Example:**

```php
// Count posts
$count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts}" );

// Get specific value
$title = $wpdb->get_var( 
    $wpdb->prepare( "SELECT post_title FROM {$wpdb->posts} WHERE ID = %d", 123 )
);

// Get from cached result (different column)
$wpdb->query( "SELECT post_title, post_date FROM {$wpdb->posts} LIMIT 1" );
$title = $wpdb->get_var( null, 0 ); // First column
$date = $wpdb->get_var( null, 1 );  // Second column
```

---

#### get_row()

Retrieves a single row from the database.

```php
public function get_row( $query = null, $output = OBJECT, $y = 0 ): array|object|null|void
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$query` | string\|null | null | SQL query |
| `$output` | string | OBJECT | Output format: OBJECT, ARRAY_A, ARRAY_N |
| `$y` | int | 0 | Row to return (0-indexed) |

**Returns:** Row data or null.

**Example:**

```php
// As object
$row = $wpdb->get_row( 
    $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d", 123 )
);
echo $row->post_title;

// As associative array
$row = $wpdb->get_row( 
    $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d", 123 ),
    ARRAY_A
);
echo $row['post_title'];

// As numeric array
$row = $wpdb->get_row( 
    $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d", 123 ),
    ARRAY_N
);
echo $row[0]; // First column
```

---

#### get_col()

Retrieves one column from the database.

```php
public function get_col( $query = null, $x = 0 ): array
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$query` | string\|null | null | SQL query |
| `$x` | int | 0 | Column to return (0-indexed) |

**Returns:** Array of values from the specified column.

**Example:**

```php
// Get all post IDs
$ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_status = 'publish'" );
// Returns: array( 1, 2, 3, 4, ... )

// Get second column from cached result
$wpdb->query( "SELECT ID, post_title FROM {$wpdb->posts}" );
$titles = $wpdb->get_col( null, 1 );
```

---

#### get_results()

Retrieves multiple rows from the database.

```php
public function get_results( $query = null, $output = OBJECT ): array|object|null
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$query` | string\|null | null | SQL query |
| `$output` | string | OBJECT | Output format: OBJECT, OBJECT_K, ARRAY_A, ARRAY_N |

**Returns:** Array of results or null.

**Output Formats:**

| Constant | Description |
|----------|-------------|
| `OBJECT` | Array of row objects |
| `OBJECT_K` | Associative array keyed by first column value |
| `ARRAY_A` | Array of associative arrays |
| `ARRAY_N` | Array of numeric arrays |

**Example:**

```php
// Array of objects
$posts = $wpdb->get_results( "SELECT * FROM {$wpdb->posts} LIMIT 10" );
foreach ( $posts as $post ) {
    echo $post->post_title;
}

// Keyed by ID
$posts = $wpdb->get_results( 
    "SELECT ID, post_title FROM {$wpdb->posts}", 
    OBJECT_K 
);
echo $posts[123]->post_title; // Access by ID

// Array of associative arrays
$posts = $wpdb->get_results( 
    "SELECT * FROM {$wpdb->posts}", 
    ARRAY_A 
);
foreach ( $posts as $post ) {
    echo $post['post_title'];
}
```

---

### Data Manipulation Methods

#### insert()

Inserts a row into a table.

```php
public function insert( $table, $data, $format = null ): int|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$table` | string | Table name |
| `$data` | array | Column => value pairs |
| `$format` | string[]\|string\|null | Format for each value (%d, %f, %s) |

**Returns:** Number of rows inserted (1) or false on error.

**Example:**

```php
// Basic insert
$wpdb->insert(
    $wpdb->postmeta,
    array(
        'post_id'    => 123,
        'meta_key'   => '_custom_key',
        'meta_value' => 'custom_value',
    )
);
$meta_id = $wpdb->insert_id;

// With explicit formats
$wpdb->insert(
    $wpdb->posts,
    array(
        'post_title'   => 'Hello World',
        'post_content' => 'Content here',
        'post_status'  => 'publish',
        'post_author'  => 1,
    ),
    array( '%s', '%s', '%s', '%d' )
);

// NULL values
$wpdb->insert(
    $wpdb->posts,
    array(
        'post_title'  => 'Title',
        'post_parent' => null, // Sets to NULL
    )
);
```

---

#### replace()

Replaces a row or inserts if it doesn't exist (based on PRIMARY KEY or UNIQUE index).

```php
public function replace( $table, $data, $format = null ): int|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$table` | string | Table name |
| `$data` | array | Column => value pairs (must include key column) |
| `$format` | string[]\|string\|null | Format for each value |

**Returns:** Number of rows affected (1 for insert, 2 for replace) or false on error.

**Example:**

```php
// Replace existing or insert new
$wpdb->replace(
    $wpdb->options,
    array(
        'option_name'  => 'my_option',
        'option_value' => 'new_value',
        'autoload'     => 'yes',
    ),
    array( '%s', '%s', '%s' )
);
```

---

#### update()

Updates rows in a table.

```php
public function update( $table, $data, $where, $format = null, $where_format = null ): int|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$table` | string | Table name |
| `$data` | array | Column => value pairs to update |
| `$where` | array | Column => value pairs for WHERE clause |
| `$format` | string[]\|string\|null | Format for $data values |
| `$where_format` | string[]\|string\|null | Format for $where values |

**Returns:** Number of rows updated or false on error.

**Example:**

```php
// Update post
$wpdb->update(
    $wpdb->posts,
    array(
        'post_title'  => 'New Title',
        'post_status' => 'draft',
    ),
    array( 'ID' => 123 ),
    array( '%s', '%s' ),
    array( '%d' )
);

// Update with NULL in WHERE
$wpdb->update(
    $wpdb->posts,
    array( 'post_status' => 'trash' ),
    array( 'post_parent' => null ) // WHERE post_parent IS NULL
);
```

---

#### delete()

Deletes rows from a table.

```php
public function delete( $table, $where, $where_format = null ): int|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$table` | string | Table name |
| `$where` | array | Column => value pairs for WHERE clause |
| `$where_format` | string[]\|string\|null | Format for $where values |

**Returns:** Number of rows deleted or false on error.

**Example:**

```php
// Delete post meta
$wpdb->delete(
    $wpdb->postmeta,
    array(
        'post_id'  => 123,
        'meta_key' => '_custom_key',
    ),
    array( '%d', '%s' )
);

// Delete by NULL
$wpdb->delete(
    $wpdb->posts,
    array( 'post_author' => null ) // WHERE post_author IS NULL
);
```

---

### Prepared Statement Methods

#### prepare()

Prepares a SQL query for safe execution.

```php
public function prepare( $query, ...$args ): string|void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | string | Query with placeholders |
| `...$args` | mixed | Values to substitute |

**Placeholders:**

| Placeholder | Type | Description |
|-------------|------|-------------|
| `%d` | int | Integer |
| `%f` | float | Float |
| `%s` | string | String (auto-quoted) |
| `%i` | identifier | Table/column name (since 6.2) |

**Returns:** Sanitized query string.

**Example:**

```php
// Basic usage
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE ID = %d AND post_status = %s",
    123,
    'publish'
);

// Array of arguments
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE ID = %d",
    array( 123 )
);

// Identifier placeholder
$sql = $wpdb->prepare(
    "SELECT * FROM %i WHERE %i = %s",
    'my_table',
    'my_column',
    'value'
);

// Numbered placeholders
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE post_author = %1\$d OR post_parent = %1\$d",
    $user_id
);

// Escaping literal %
$sql = $wpdb->prepare(
    "SELECT DATE_FORMAT(post_date, '%%Y-%%m-%%d') FROM {$wpdb->posts} WHERE ID = %d",
    123
);
```

---

#### esc_like()

Escapes LIKE wildcards (%, _, \) before using in `prepare()`.

```php
public function esc_like( $text ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$text` | string | Raw text to escape |

**Returns:** Escaped text safe for LIKE.

**Example:**

```php
$search = '%test_value%';
$like = '%' . $wpdb->esc_like( $search ) . '%';
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE post_title LIKE %s",
    $like
);
// Result: WHERE post_title LIKE '%\%test\_value\%%'
```

---

### Escaping Methods

#### _real_escape()

Escapes a string using mysqli_real_escape_string().

```php
public function _real_escape( $data ): string
```

**Note:** Prefer `prepare()` over direct escaping.

---

#### _escape()

Escapes data (works on arrays).

```php
public function _escape( $data ): string|array
```

---

#### escape_by_ref()

Escapes content by reference.

```php
public function escape_by_ref( &$data ): void
```

---

#### quote_identifier()

Quotes an identifier (table/column name).

```php
public function quote_identifier( $identifier ): string
```

**Since:** 6.2.0

**Example:**

```php
$quoted = $wpdb->quote_identifier( 'table_name' );
// Returns: `table_name`

$quoted = $wpdb->quote_identifier( 'col`name' );
// Returns: `col``name` (backtick escaped)
```

---

### Table & Prefix Methods

#### tables()

Returns an array of WordPress table names.

```php
public function tables( $scope = 'all', $prefix = true, $blog_id = 0 ): string[]
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$scope` | string | 'all' | Table scope: 'all', 'blog', 'global', 'ms_global', 'old' |
| `$prefix` | bool | true | Whether to include table prefix |
| `$blog_id` | int | 0 | Blog ID for prefix (multisite) |

**Returns:** Array of table names.

**Example:**

```php
// All tables with prefix
$tables = $wpdb->tables();
// array( 'posts' => 'wp_posts', 'comments' => 'wp_comments', ... )

// Blog-specific tables only
$tables = $wpdb->tables( 'blog' );

// Global tables only
$tables = $wpdb->tables( 'global' );

// Without prefixes
$tables = $wpdb->tables( 'all', false );
// array( 'posts', 'comments', 'users', ... )
```

---

#### set_prefix()

Sets the table prefix.

```php
public function set_prefix( $prefix, $set_table_names = true ): string|WP_Error
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$prefix` | string | - | New prefix (alphanumeric + underscore) |
| `$set_table_names` | bool | true | Whether to update table name properties |

**Returns:** Old prefix or WP_Error on invalid prefix.

---

#### get_blog_prefix()

Gets the prefix for a specific blog.

```php
public function get_blog_prefix( $blog_id = null ): string
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$blog_id` | int\|null | null | Blog ID (null for current) |

**Returns:** Blog table prefix.

**Example:**

```php
$prefix = $wpdb->get_blog_prefix( 2 );
// Returns: wp_2_ (for blog ID 2 in multisite)
```

---

#### set_blog_id()

Sets the blog ID and updates table prefixes.

```php
public function set_blog_id( $blog_id, $network_id = 0 ): int
```

**Returns:** Previous blog ID.

---

### Connection Methods

#### db_connect()

Connects to the database server.

```php
public function db_connect( $allow_bail = true ): bool
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$allow_bail` | bool | true | Whether to die on failure |

**Returns:** True on success, false on failure.

---

#### check_connection()

Checks if connection is alive and reconnects if needed.

```php
public function check_connection( $allow_bail = true ): bool|void
```

**Returns:** True if connected.

---

#### select()

Selects a database.

```php
public function select( $db, $dbh = null ): void
```

---

#### close()

Closes the database connection.

```php
public function close(): bool
```

**Since:** 4.5.0

**Returns:** True on success, false on failure.

---

#### parse_db_host()

Parses the DB_HOST setting for mysqli_real_connect().

```php
public function parse_db_host( $host ): array|false
```

**Since:** 4.9.0

**Returns:** Array of `[ host, port, socket, is_ipv6 ]` or false.

---

### Error Handling Methods

#### show_errors()

Enables showing database errors.

```php
public function show_errors( $show = true ): bool
```

**Returns:** Previous show_errors state.

---

#### hide_errors()

Disables showing database errors.

```php
public function hide_errors(): bool
```

**Returns:** Previous show_errors state.

---

#### suppress_errors()

Suppresses database errors.

```php
public function suppress_errors( $suppress = true ): bool
```

**Returns:** Previous suppress_errors state.

---

#### print_error()

Prints/logs a SQL error.

```php
public function print_error( $str = '' ): void|false
```

---

#### bail()

Displays error and dies (if show_errors enabled).

```php
public function bail( $message, $error_code = '500' ): void|false
```

---

### Character Set Methods

#### init_charset()

Initializes charset and collate properties.

```php
public function init_charset(): void
```

---

#### determine_charset()

Determines the best charset and collation.

```php
public function determine_charset( $charset, $collate ): array
```

**Returns:** Array with 'charset' and 'collate' keys.

---

#### set_charset()

Sets the connection's character set.

```php
public function set_charset( $dbh, $charset = null, $collate = null ): void
```

---

#### get_charset_collate()

Gets the database charset collate for CREATE TABLE.

```php
public function get_charset_collate(): string
```

**Returns:** e.g., `"DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci"`

**Example:**

```php
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE my_table (
    id INT AUTO_INCREMENT,
    name VARCHAR(255),
    PRIMARY KEY (id)
) $charset_collate";
```

---

#### get_table_charset()

Gets the character set for a table.

```php
protected function get_table_charset( $table ): string|WP_Error
```

---

#### get_col_charset()

Gets the character set for a column.

```php
public function get_col_charset( $table, $column ): string|false|WP_Error
```

---

#### get_col_length()

Gets the maximum string length for a column.

```php
public function get_col_length( $table, $column ): array|false|WP_Error
```

**Returns:** Array with 'type' ('byte' or 'char') and 'length', or false.

---

### SQL Mode Methods

#### set_sql_mode()

Sets SQL mode for WordPress compatibility.

```php
public function set_sql_mode( $modes = array() ): void
```

Removes incompatible modes: NO_ZERO_DATE, ONLY_FULL_GROUP_BY, STRICT_TRANS_TABLES, STRICT_ALL_TABLES, TRADITIONAL, ANSI.

---

### Capability Methods

#### has_cap()

Checks if the database supports a feature.

```php
public function has_cap( $db_cap ): bool
```

| Capability | Since | Description |
|------------|-------|-------------|
| `collation` | 2.5.0 | Collation support |
| `group_concat` | 2.7.0 | GROUP_CONCAT function |
| `subqueries` | 2.7.0 | Subquery support |
| `set_charset` | 2.7.0 | SET NAMES support |
| `utf8mb4` | 4.1.0 | 4-byte UTF-8 (always true since 6.6) |
| `utf8mb4_520` | 4.6.0 | utf8mb4_unicode_520_ci |
| `identifier_placeholders` | 6.2.0 | %i placeholder support |

**Example:**

```php
if ( $wpdb->has_cap( 'utf8mb4_520' ) ) {
    // Use better collation
}
```

---

### Column Info Methods

#### get_col_info()

Gets column metadata from the last query.

```php
public function get_col_info( $info_type = 'name', $col_offset = -1 ): mixed
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$info_type` | string | 'name' | Info type: name, table, def, max_length, not_null, etc. |
| `$col_offset` | int | -1 | Column index (-1 for all columns) |

**Example:**

```php
$wpdb->query( "SELECT * FROM {$wpdb->posts} LIMIT 1" );

// Get all column names
$names = $wpdb->get_col_info( 'name' );

// Get specific column's max length
$max_length = $wpdb->get_col_info( 'max_length', 0 );
```

---

### Utility Methods

#### flush()

Clears cached query results.

```php
public function flush(): void
```

Resets: last_result, col_info, last_query, rows_affected, num_rows, last_error, and frees mysqli_result.

---

#### db_version()

Gets the database server version.

```php
public function db_version(): string|null
```

**Returns:** Version number (e.g., "8.0.28").

---

#### db_server_info()

Gets raw database server version string.

```php
public function db_server_info(): string
```

**Since:** 5.5.0

**Returns:** Full version string (e.g., "8.0.28-0ubuntu0.20.04.3").

---

#### check_database_version()

Checks if database meets minimum version requirement.

```php
public function check_database_version(): void|WP_Error
```

---

#### timer_start()

Starts the query timer.

```php
public function timer_start(): true
```

---

#### timer_stop()

Stops the query timer.

```php
public function timer_stop(): float
```

**Returns:** Time spent in seconds.

---

#### get_caller()

Gets comma-separated list of calling functions.

```php
public function get_caller(): string
```

---

#### log_query()

Logs a query to the queries array.

```php
public function log_query( $query, $query_time, $query_callstack, $query_start, $query_data ): void
```

**Since:** 5.3.0

---

### Text Processing Methods

#### strip_invalid_text_for_column()

Strips invalid characters for a specific column.

```php
public function strip_invalid_text_for_column( $table, $column, $value ): string|WP_Error
```

---

#### check_ascii()

Checks if a string is ASCII.

```php
protected function check_ascii( $input_string ): bool
```

---

### Placeholder Methods

#### placeholder_escape()

Generates a placeholder escape string.

```php
public function placeholder_escape(): string
```

**Since:** 4.8.3

---

#### add_placeholder_escape()

Escapes % characters in a query.

```php
public function add_placeholder_escape( $query ): string
```

---

#### remove_placeholder_escape()

Removes placeholder escapes from a query.

```php
public function remove_placeholder_escape( $query ): string
```

---

### Magic Methods

#### __get()

Makes private properties readable.

```php
public function __get( $name ): mixed
```

---

#### __set()

Makes private properties settable.

```php
public function __set( $name, $value ): void
```

---

#### __isset()

Checks if a private property is set.

```php
public function __isset( $name ): bool
```

---

#### __unset()

Unsets a private property.

```php
public function __unset( $name ): void
```

---

## Deprecated Methods

### supports_collation()

**Deprecated:** 3.5.0 - Use `has_cap( 'collation' )` instead.

```php
public function supports_collation(): bool
```

---

### escape()

**Deprecated:** 3.6.0 - Use `prepare()` or `esc_sql()` instead.

```php
public function escape( $data ): string|array
```

---

### _weak_escape()

**Deprecated:** 3.6.0 - Use `prepare()` or `esc_sql()` instead.

```php
public function _weak_escape( $data ): string
```

---

## Constants

These constants are defined in `class-wpdb.php`:

| Constant | Value | Description |
|----------|-------|-------------|
| `EZSQL_VERSION` | 'WP1.25' | ezSQL version identifier |
| `OBJECT` | 'OBJECT' | Return rows as objects |
| `OBJECT_K` | 'OBJECT_K' | Return objects keyed by first column |
| `ARRAY_A` | 'ARRAY_A' | Return rows as associative arrays |
| `ARRAY_N` | 'ARRAY_N' | Return rows as numeric arrays |
