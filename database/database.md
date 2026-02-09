# WordPress Database API (WPDB)

WordPress database abstraction layer built on MySQLi.

**Since:** 0.71  
**Source:** `wp-includes/class-wpdb.php`

## Components

| Component | Description |
|-----------|-------------|
| [class-wpdb.md](./class-wpdb.md) | Main database class - properties, methods, usage |
| [hooks.md](./hooks.md) | Database-related actions and filters |

---

## Architecture

### Global Instance

WordPress instantiates a single global `$wpdb` object during bootstrap:

```php
global $wpdb;

// Use the global instance
$results = $wpdb->get_results( "SELECT * FROM {$wpdb->posts}" );
```

### Connection Flow

```
wp-config.php (credentials)
    └── wp-settings.php
            └── require_wp_db()
                    └── new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST )
                            ├── __construct()
                            │       ├── init credentials
                            │       └── db_connect()
                            ├── init_charset()
                            ├── set_charset()
                            ├── set_sql_mode()
                            └── select( DB_NAME )
```

### Drop-In Support

Custom database handlers via `wp-content/db.php`:

```php
// wp-content/db.php
class my_wpdb extends wpdb {
    // Custom implementation
}

$wpdb = new my_wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
```

---

## Table Prefixes

WordPress uses prefixes to namespace tables, enabling multiple installations in one database.

### Prefix Properties

| Property | Description | Example |
|----------|-------------|---------|
| `$prefix` | Current blog prefix | `wp_` or `wp_2_` |
| `$base_prefix` | Base prefix (no blog ID) | `wp_` |

### Table Name Properties

Access prefixed table names directly:

```php
global $wpdb;

// Per-site tables
$wpdb->posts;            // wp_posts
$wpdb->postmeta;         // wp_postmeta
$wpdb->comments;         // wp_comments
$wpdb->commentmeta;      // wp_commentmeta
$wpdb->terms;            // wp_terms
$wpdb->term_taxonomy;    // wp_term_taxonomy
$wpdb->term_relationships; // wp_term_relationships
$wpdb->termmeta;         // wp_termmeta
$wpdb->options;          // wp_options
$wpdb->links;            // wp_links

// Global tables (shared in multisite)
$wpdb->users;            // wp_users
$wpdb->usermeta;         // wp_usermeta

// Multisite-only global tables
$wpdb->blogs;            // wp_blogs
$wpdb->blogmeta;         // wp_blogmeta
$wpdb->site;             // wp_site
$wpdb->sitemeta;         // wp_sitemeta
$wpdb->signups;          // wp_signups
$wpdb->registration_log; // wp_registration_log
```

### Using Table Names in Queries

**Always use properties, never hardcode:**

```php
// ✅ Correct
$wpdb->query( "SELECT * FROM {$wpdb->posts} WHERE post_status = 'publish'" );

// ❌ Wrong - breaks with custom prefixes
$wpdb->query( "SELECT * FROM wp_posts WHERE post_status = 'publish'" );
```

### Multisite Table Switching

```php
// Get prefix for specific blog
$blog_prefix = $wpdb->get_blog_prefix( $blog_id );

// Switch blog context
$old_blog_id = $wpdb->set_blog_id( $new_blog_id );

// Returns to original after use
$wpdb->set_blog_id( $old_blog_id );
```

---

## Prepared Statements

**CRITICAL:** Always use `$wpdb->prepare()` for user input to prevent SQL injection.

### Placeholders

| Placeholder | Type | Description |
|-------------|------|-------------|
| `%d` | Integer | Signed integer |
| `%f` | Float | Floating-point number |
| `%s` | String | String (auto-quoted) |
| `%i` | Identifier | Table/column names (since 6.2) |

### Basic Usage

```php
// Single placeholder
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE ID = %d",
    $post_id
);

// Multiple placeholders
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE post_type = %s AND post_status = %s",
    $post_type,
    $status
);

// Array of values
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE ID = %d AND post_type = %s",
    array( $post_id, $post_type )
);
```

### Identifier Placeholder (%i)

For dynamic table/column names (since WordPress 6.2):

```php
$sql = $wpdb->prepare(
    "SELECT * FROM %i WHERE %i = %s",
    $table_name,
    $column_name,
    $value
);
```

### Numbered Placeholders

```php
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE post_author = %1\$d OR post_author = %1\$d",
    $author_id
);
```

### LIKE Queries

Use `$wpdb->esc_like()` before `prepare()`:

```php
$search = $wpdb->esc_like( $user_input );
$sql = $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE post_title LIKE %s",
    '%' . $search . '%'
);
```

### Escaping Literal %

Double the percent sign:

```php
$sql = $wpdb->prepare(
    "SELECT DATE_FORMAT(post_date, '%%Y-%%m') FROM {$wpdb->posts} WHERE ID = %d",
    $post_id
);
```

---

## Query Methods Overview

### Data Retrieval

| Method | Returns | Use Case |
|--------|---------|----------|
| `get_var()` | Single value | Counts, single field |
| `get_row()` | Single row | One record |
| `get_col()` | Array of values | One column from many rows |
| `get_results()` | Array of rows | Multiple records |
| `query()` | Affected rows or bool | Direct SQL execution |

### Data Modification

| Method | Operation | Returns |
|--------|-----------|---------|
| `insert()` | INSERT | Rows inserted (1) or false |
| `replace()` | REPLACE | Rows affected or false |
| `update()` | UPDATE | Rows updated or false |
| `delete()` | DELETE | Rows deleted or false |

### After INSERT

```php
$wpdb->insert( $wpdb->posts, array( 'post_title' => 'Hello' ) );
$new_id = $wpdb->insert_id; // Auto-increment ID
```

---

## Output Formats

Methods like `get_row()` and `get_results()` accept an output format:

| Constant | Type | Description |
|----------|------|-------------|
| `OBJECT` | stdClass | Default. Object with column properties |
| `OBJECT_K` | array | Objects keyed by first column value |
| `ARRAY_A` | array | Associative array (column => value) |
| `ARRAY_N` | array | Numeric array (indexed) |

```php
// As object (default)
$row = $wpdb->get_row( $sql, OBJECT );
echo $row->post_title;

// As associative array
$row = $wpdb->get_row( $sql, ARRAY_A );
echo $row['post_title'];

// As numeric array
$row = $wpdb->get_row( $sql, ARRAY_N );
echo $row[0]; // First column
```

---

## Error Handling

### Check for Errors

```php
$result = $wpdb->query( $sql );

if ( $result === false ) {
    // Query failed
    $error = $wpdb->last_error;
}
```

### Debug Mode

```php
// Show errors (typically in wp-config.php)
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );

// Or programmatically
$wpdb->show_errors();
$wpdb->hide_errors();
$wpdb->suppress_errors( true );
```

### Query Logging

```php
// Enable in wp-config.php
define( 'SAVEQUERIES', true );

// Access logged queries
print_r( $wpdb->queries );
// Each entry: [ SQL, time, caller, start_time, custom_data ]
```

---

## Properties Reference

### Query State

| Property | Type | Description |
|----------|------|-------------|
| `$last_query` | string | Last executed SQL |
| `$last_result` | array | Results from last SELECT |
| `$last_error` | string | Last error message |
| `$num_queries` | int | Total queries this request |
| `$num_rows` | int | Rows returned by last SELECT |
| `$rows_affected` | int | Rows affected by last INSERT/UPDATE/DELETE |
| `$insert_id` | int | AUTO_INCREMENT ID from last INSERT |

### Connection

| Property | Type | Description |
|----------|------|-------------|
| `$ready` | bool | Connection ready for queries |
| `$charset` | string | Connection character set |
| `$collate` | string | Connection collation |

---

## Character Set & Collation

### Automatic Handling

WordPress automatically handles character set conversion. The default is `utf8mb4`.

```php
// Get charset/collation for CREATE TABLE
$charset_collate = $wpdb->get_charset_collate();
// Returns: "DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci"
```

### Capability Checking

```php
if ( $wpdb->has_cap( 'utf8mb4' ) ) {
    // Database supports utf8mb4
}

if ( $wpdb->has_cap( 'utf8mb4_520' ) ) {
    // Supports utf8mb4_unicode_520_ci
}

if ( $wpdb->has_cap( 'identifier_placeholders' ) ) {
    // Supports %i placeholder (6.2+)
}
```

---

## Best Practices

### 1. Always Use Prepared Statements

```php
// ✅ Safe
$wpdb->prepare( "SELECT * FROM {$wpdb->users} WHERE ID = %d", $id );

// ❌ SQL Injection vulnerability
$wpdb->query( "SELECT * FROM {$wpdb->users} WHERE ID = $id" );
```

### 2. Use Table Properties

```php
// ✅ Prefix-aware
"SELECT * FROM {$wpdb->posts}"

// ❌ Breaks with custom prefixes
"SELECT * FROM wp_posts"
```

### 3. Check Return Values

```php
$inserted = $wpdb->insert( $wpdb->posts, $data );
if ( $inserted === false ) {
    // Handle error
    error_log( $wpdb->last_error );
}
```

### 4. Use Convenience Methods

```php
// ✅ Preferred for simple operations
$wpdb->insert( $wpdb->postmeta, array(
    'post_id'    => $post_id,
    'meta_key'   => '_custom_field',
    'meta_value' => $value,
) );

// ❌ Unnecessary for simple inserts
$wpdb->query( $wpdb->prepare(
    "INSERT INTO {$wpdb->postmeta} (post_id, meta_key, meta_value) VALUES (%d, %s, %s)",
    $post_id, '_custom_field', $value
) );
```

### 5. Specify Formats for Type Safety

```php
$wpdb->insert(
    $wpdb->postmeta,
    array(
        'post_id'    => $post_id,
        'meta_key'   => $key,
        'meta_value' => $value,
    ),
    array( '%d', '%s', '%s' ) // Explicit formats
);
```

---

## Performance Considerations

### Query Caching

WordPress object cache integrates with WPDB. Use higher-level APIs when possible:

```php
// ✅ Uses cache
$post = get_post( $id );

// ❌ Bypasses cache
$post = $wpdb->get_row( $wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE ID = %d", $id
) );
```

### Limit Results

```php
// Use LIMIT to prevent loading huge datasets
$wpdb->get_results( "SELECT * FROM {$wpdb->posts} LIMIT 100" );
```

### Flush After Large Operations

```php
$wpdb->flush(); // Clear cached results, free memory
```
