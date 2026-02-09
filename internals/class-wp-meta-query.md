# WP_Meta_Query

SQL generator for meta (custom field) queries.

**Source:** `wp-includes/class-wp-meta-query.php`  
**Since:** 3.2.0

## Overview

`WP_Meta_Query` generates SQL `JOIN` and `WHERE` clauses for filtering database queries by metadata. It's the engine behind the `meta_query` parameter in `WP_Query`, `WP_User_Query`, `WP_Term_Query`, and `WP_Comment_Query`.

The class supports complex nested queries with AND/OR logic, multiple comparison operators, and type casting for proper sorting.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$queries` | array | public | Parsed meta query clauses |
| `$relation` | string | public | Relation between clauses (`'AND'` or `'OR'`) |
| `$meta_table` | string | public | Meta table name (e.g., `wp_postmeta`) |
| `$meta_id_column` | string | public | Column name for object ID in meta table |
| `$primary_table` | string | public | Primary table being filtered |
| `$primary_id_column` | string | public | ID column in primary table |
| `$table_aliases` | array | protected | JOIN table aliases |
| `$clauses` | array | protected | Flattened clause array (keyed by name) |
| `$has_or_relation` | bool | protected | Whether query contains OR relations |

---

## Methods

### __construct()

Constructs a meta query from parameters.

```php
public function __construct( array $meta_query = array() )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_query` | array | Meta query clauses |

**Meta Query Structure:**

```php
$meta_query = array(
    'relation' => 'AND', // Optional. 'AND' or 'OR'. Default 'AND'.
    array(
        'key'         => 'color',           // Meta key
        'value'       => 'blue',            // Meta value
        'compare'     => '=',               // Comparison operator
        'type'        => 'CHAR',            // Value type for CAST
    ),
    'price_clause' => array(               // Named clause for orderby
        'key'         => 'price',
        'value'       => array( 10, 100 ),
        'compare'     => 'BETWEEN',
        'type'        => 'NUMERIC',
    ),
);
```

**Clause Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `key` | string\|string[] | Meta key(s) to filter by |
| `compare_key` | string | Key comparison operator |
| `type_key` | string | Key type for CAST (`'BINARY'`) |
| `value` | mixed | Meta value(s) to filter by |
| `compare` | string | Value comparison operator |
| `type` | string | Value type for CAST |

---

### parse_query_vars()

Constructs meta query from legacy query vars.

```php
public function parse_query_vars( array $qv ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$qv` | array | Query variables |

Handles `meta_key`, `meta_value`, `meta_compare`, `meta_type`, etc.

---

### get_sql()

Generates SQL clauses to append to a query.

```php
public function get_sql(
    string $type,
    string $primary_table,
    string $primary_id_column,
    object $context = null
): string[]|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$type` | string | Meta type (`'post'`, `'user'`, `'term'`, etc.) |
| `$primary_table` | string | Main table (e.g., `wp_posts`) |
| `$primary_id_column` | string | ID column in primary table |
| `$context` | object | Parent query object (optional) |

**Returns:** Array with `'join'` and `'where'` keys, or `false` if no meta table.

**Filters:**
- `get_meta_sql` — Modify generated SQL

**Example:**

```php
$meta_query = new WP_Meta_Query( array(
    array( 'key' => 'featured', 'value' => '1' )
) );

$sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
// $sql['join']  = ' INNER JOIN wp_postmeta ON ( wp_posts.ID = wp_postmeta.post_id )'
// $sql['where'] = ' AND ( wp_postmeta.meta_key = \'featured\' AND wp_postmeta.meta_value = \'1\' )'
```

---

### get_clauses()

Returns flattened array of parsed clauses.

```php
public function get_clauses(): array
```

**Returns:** Clauses keyed by name, with `'alias'` and `'cast'` added.

Used for `orderby` to reference named clauses:

```php
$args = array(
    'meta_query' => array(
        'price_clause' => array( 'key' => 'price', 'type' => 'NUMERIC' ),
    ),
    'orderby' => 'price_clause',
);
```

---

### has_or_relation()

Checks if query contains any OR relations.

```php
public function has_or_relation(): bool
```

When `true`, the parent query may need `DISTINCT` or `GROUP BY`.

---

### get_cast_for_type()

Returns MySQL CAST type for a meta type.

```php
public function get_cast_for_type( string $type = '' ): string
```

| Input | Output |
|-------|--------|
| `''` | `'CHAR'` |
| `'NUMERIC'` | `'SIGNED'` |
| `'BINARY'` | `'BINARY'` |
| `'CHAR'` | `'CHAR'` |
| `'DATE'` | `'DATE'` |
| `'DATETIME'` | `'DATETIME'` |
| `'DECIMAL(10,2)'` | `'DECIMAL(10,2)'` |
| `'SIGNED'` | `'SIGNED'` |
| `'UNSIGNED'` | `'UNSIGNED'` |
| `'TIME'` | `'TIME'` |

---

### sanitize_query()

Validates and normalizes query clauses.

```php
public function sanitize_query( array $queries ): array
```

Removes empty clauses, sets relations, and recurses into nested queries.

---

### get_sql_for_clause()

Generates SQL for a single first-order clause.

```php
public function get_sql_for_clause( array &$clause, array $parent_query, string $clause_key = '' ): array
```

**Returns:** Array with `'join'` and `'where'` arrays.

---

## Comparison Operators

### Value Comparison (`compare`)

| Operator | Description |
|----------|-------------|
| `=` | Equal (default for scalar) |
| `!=` | Not equal |
| `>` | Greater than |
| `>=` | Greater than or equal |
| `<` | Less than |
| `<=` | Less than or equal |
| `LIKE` | SQL LIKE (wildcards added) |
| `NOT LIKE` | SQL NOT LIKE |
| `IN` | In array (default for array value) |
| `NOT IN` | Not in array |
| `BETWEEN` | Between two values |
| `NOT BETWEEN` | Not between two values |
| `REGEXP` | Regular expression match |
| `NOT REGEXP` | Not matching regex |
| `RLIKE` | Alias for REGEXP |
| `EXISTS` | Key exists (ignores value) |
| `NOT EXISTS` | Key doesn't exist |

### Key Comparison (`compare_key`)

| Operator | Description |
|----------|-------------|
| `=` | Exact match (default) |
| `!=` | Not equal |
| `LIKE` | Pattern match |
| `NOT LIKE` | Not matching pattern |
| `IN` | Key in array |
| `NOT IN` | Key not in array |
| `REGEXP` | Regex match |
| `NOT REGEXP` | Not matching regex |
| `EXISTS` | Alias for `=` |
| `NOT EXISTS` | Alias for `!=` |

**Since:** 5.1.0 (key comparison) / 5.3.0 (extended operators)

---

## Complex Query Examples

### AND with Multiple Keys

```php
$meta_query = array(
    'relation' => 'AND',
    array( 'key' => 'color', 'value' => 'blue' ),
    array( 'key' => 'size', 'value' => 'large' ),
);
```

### OR Query

```php
$meta_query = array(
    'relation' => 'OR',
    array( 'key' => 'color', 'value' => 'blue' ),
    array( 'key' => 'color', 'value' => 'red' ),
);
```

### Nested Query

```php
$meta_query = array(
    'relation' => 'AND',
    array(
        'relation' => 'OR',
        array( 'key' => 'color', 'value' => 'blue' ),
        array( 'key' => 'color', 'value' => 'green' ),
    ),
    array( 'key' => 'price', 'value' => 50, 'compare' => '<=', 'type' => 'NUMERIC' ),
);
```

### Named Clauses for Ordering

```php
$args = array(
    'meta_query' => array(
        'relation' => 'AND',
        'color_clause' => array( 'key' => 'color' ),
        'price_clause' => array( 'key' => 'price', 'type' => 'NUMERIC' ),
    ),
    'orderby' => array(
        'color_clause' => 'ASC',
        'price_clause' => 'DESC',
    ),
);
```

---

## Internal Methods

### is_first_order_clause() <small>(protected)</small>

Determines if a clause is first-order (has `key` or `value`).

```php
protected function is_first_order_clause( array $query ): bool
```

---

### get_sql_clauses() <small>(protected)</small>

Entry point for SQL generation.

```php
protected function get_sql_clauses(): array
```

---

### get_sql_for_query() <small>(protected)</small>

Recursively generates SQL for nested queries.

```php
protected function get_sql_for_query( array &$query, int $depth = 0 ): array
```

---

### find_compatible_table_alias() <small>(protected)</small>

Finds existing JOIN that can be reused.

```php
protected function find_compatible_table_alias( array $clause, array $parent_query ): string|false
```

Optimizes by sharing table joins for compatible clauses.

**Filters:**
- `meta_query_find_compatible_table_alias`

---

## Performance Considerations

1. **JOIN Optimization:** The class reuses table aliases when possible
2. **LEFT vs INNER JOIN:** `NOT EXISTS` clauses force `LEFT JOIN` on all joins
3. **OR Relations:** May require `DISTINCT` in parent query
4. **Type Casting:** `NUMERIC` comparisons add CAST overhead
