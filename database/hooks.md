# Database API Hooks

Actions and filters for the WordPress Database API (WPDB).

---

## Filters

### query

Filters the database query before execution.

```php
apply_filters( 'query', string $query )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | string | The SQL query |

**Returns:** Modified query string. Return empty/false to cancel query.

**Note:** Some queries execute before plugins load and cannot be filtered.

**Example:**

```php
add_filter( 'query', function( $query ) {
    // Log all queries
    error_log( $query );
    return $query;
} );

// Modify queries (dangerous - use carefully!)
add_filter( 'query', function( $query ) {
    // Add a custom WHERE clause to all post queries
    if ( strpos( $query, 'wp_posts' ) !== false && strpos( $query, 'SELECT' ) === 0 ) {
        // Be very careful with query modification
    }
    return $query;
} );
```

---

### log_query_custom_data

Filters custom data logged alongside a query (when SAVEQUERIES is enabled).

```php
apply_filters( 'log_query_custom_data', array $query_data, string $query, float $query_time, string $query_callstack, float $query_start )
```

**Since:** 5.3.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query_data` | array | Custom query data |
| `$query` | string | The SQL query |
| `$query_time` | float | Query execution time in seconds |
| `$query_callstack` | string | Comma-separated calling functions |
| `$query_start` | float | Unix timestamp when query started |

**Returns:** Modified query data array.

**Example:**

```php
add_filter( 'log_query_custom_data', function( $query_data, $query, $query_time, $callstack, $start ) {
    // Add memory usage to query log
    $query_data['memory'] = memory_get_usage();
    
    // Flag slow queries
    if ( $query_time > 0.5 ) {
        $query_data['slow'] = true;
    }
    
    return $query_data;
}, 10, 5 );
```

---

### pre_get_table_charset

Filters the table charset before querying the database.

```php
apply_filters( 'pre_get_table_charset', string|WP_Error|null $charset, string $table )
```

**Since:** 4.2.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$charset` | string\|WP_Error\|null | Character set, error, or null to continue |
| `$table` | string | Table name |

**Returns:** Character set string, WP_Error, or null to query the database.

**Example:**

```php
add_filter( 'pre_get_table_charset', function( $charset, $table ) {
    // Override charset for specific table
    if ( $table === 'my_custom_table' ) {
        return 'utf8mb4';
    }
    return $charset;
}, 10, 2 );
```

---

### pre_get_col_charset

Filters the column charset before querying the database.

```php
apply_filters( 'pre_get_col_charset', string|null|false|WP_Error $charset, string $table, string $column )
```

**Since:** 4.2.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$charset` | string\|null\|false\|WP_Error | Character set or null to continue |
| `$table` | string | Table name |
| `$column` | string | Column name |

**Returns:** Character set, false (no charset), WP_Error, or null to query database.

**Example:**

```php
add_filter( 'pre_get_col_charset', function( $charset, $table, $column ) {
    // Binary column that stores encoded data
    if ( $table === 'my_table' && $column === 'encrypted_data' ) {
        return 'binary';
    }
    return $charset;
}, 10, 3 );
```

---

### incompatible_sql_modes

Filters the list of incompatible SQL modes to remove.

```php
apply_filters( 'incompatible_sql_modes', array $incompatible_modes )
```

**Since:** 3.9.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incompatible_modes` | array | Array of SQL mode names |

**Default modes removed:**
- `NO_ZERO_DATE`
- `ONLY_FULL_GROUP_BY`
- `STRICT_TRANS_TABLES`
- `STRICT_ALL_TABLES`
- `TRADITIONAL`
- `ANSI`

**Returns:** Modified array of incompatible modes.

**Example:**

```php
add_filter( 'incompatible_sql_modes', function( $modes ) {
    // Allow ONLY_FULL_GROUP_BY for strict SQL compliance
    $key = array_search( 'ONLY_FULL_GROUP_BY', $modes );
    if ( $key !== false ) {
        unset( $modes[ $key ] );
    }
    return $modes;
} );
```

---

## Practical Examples

### Query Monitoring Plugin

```php
class Query_Monitor {
    private $slow_threshold = 0.1; // 100ms
    private $slow_queries = array();

    public function __construct() {
        add_filter( 'query', array( $this, 'before_query' ) );
        add_filter( 'log_query_custom_data', array( $this, 'after_query' ), 10, 5 );
        add_action( 'shutdown', array( $this, 'report' ) );
    }

    public function before_query( $query ) {
        // Store query start time
        $this->current_query_start = microtime( true );
        return $query;
    }

    public function after_query( $data, $query, $time, $callstack, $start ) {
        if ( $time > $this->slow_threshold ) {
            $this->slow_queries[] = array(
                'query'    => $query,
                'time'     => $time,
                'caller'   => $callstack,
            );
            $data['flagged_slow'] = true;
        }
        return $data;
    }

    public function report() {
        if ( ! empty( $this->slow_queries ) && WP_DEBUG ) {
            error_log( 'Slow queries: ' . print_r( $this->slow_queries, true ) );
        }
    }
}
new Query_Monitor();
```

---

### Custom Table Charset Override

```php
/**
 * Force utf8mb4 for all custom plugin tables.
 */
add_filter( 'pre_get_table_charset', function( $charset, $table ) {
    if ( strpos( $table, 'my_plugin_' ) === 0 ) {
        return 'utf8mb4';
    }
    return $charset;
}, 10, 2 );
```

---

### Query Modification (Use With Extreme Caution)

```php
/**
 * Add soft-delete filter to post queries.
 * WARNING: This is dangerous and can break WordPress.
 * Only shown for educational purposes.
 */
add_filter( 'query', function( $query ) {
    global $wpdb;
    
    // Only modify SELECT queries on posts table
    if ( preg_match( '/^\s*SELECT.*FROM\s+' . preg_quote( $wpdb->posts ) . '/i', $query ) ) {
        // Don't modify if already has our clause
        if ( strpos( $query, 'is_deleted' ) === false ) {
            // This is oversimplified - real implementation needs proper parsing
            // $query = preg_replace( '/WHERE/', 'WHERE is_deleted = 0 AND', $query );
        }
    }
    
    return $query;
} );
```

---

## Notes

### Query Filter Timing

The `query` filter fires inside `$wpdb->query()`, which means:

1. Queries during WordPress bootstrap (before plugins load) are **not filterable**
2. Queries made by `insert()`, `update()`, `delete()`, `replace()` go through `query()`
3. Direct `mysqli_query()` calls bypass the filter

### SAVEQUERIES Performance

When `SAVEQUERIES` is defined:

```php
define( 'SAVEQUERIES', true );
```

- All queries are logged to `$wpdb->queries`
- `log_query_custom_data` filter fires for each query
- Memory usage increases
- **Only enable in development**

### Query Filter Best Practices

1. **Don't modify queries** unless absolutely necessary
2. **Never use for security** - use `prepare()` instead
3. **Log, don't block** - return the query unchanged for monitoring
4. **Test thoroughly** - query modifications can break core functionality
5. **Check query type** - ensure you're only affecting intended queries
