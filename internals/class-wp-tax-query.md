# WP_Tax_Query

SQL generator for taxonomy term queries.

**Source:** `wp-includes/class-wp-tax-query.php`  
**Since:** 3.1.0

## Overview

`WP_Tax_Query` generates SQL `JOIN` and `WHERE` clauses for filtering database queries by taxonomy terms. It powers the `tax_query` parameter in `WP_Query` and similar query classes.

The class supports complex nested queries, multiple taxonomies, and various matching operators including hierarchical term inclusion.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$queries` | array | public | Parsed tax query clauses |
| `$relation` | string | public | Relation between clauses (`'AND'` or `'OR'`) |
| `$primary_table` | string | public | Primary table being filtered |
| `$primary_id_column` | string | public | ID column in primary table |
| `$table_aliases` | array | protected | JOIN table aliases |
| `$queried_terms` | array | public | Terms/taxonomies for reference by WP_Query |

## Static Properties

| Property | Type | Description |
|----------|------|-------------|
| `$no_results` | array | Standard "return nothing" SQL |

---

## Methods

### __construct()

Constructs a tax query from parameters.

```php
public function __construct( array $tax_query )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tax_query` | array | Tax query clauses |

**Tax Query Structure:**

```php
$tax_query = array(
    'relation' => 'AND', // Optional. 'AND' or 'OR'. Default 'AND'.
    array(
        'taxonomy'         => 'category',
        'terms'            => array( 5, 10 ),
        'field'            => 'term_id',        // 'term_id', 'slug', 'name', 'term_taxonomy_id'
        'operator'         => 'IN',             // 'IN', 'NOT IN', 'AND', 'EXISTS', 'NOT EXISTS'
        'include_children' => true,             // Include child terms
    ),
);
```

**Clause Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `taxonomy` | string | `''` | Taxonomy name |
| `terms` | string\|int\|array | `array()` | Term(s) to match |
| `field` | string | `'term_id'` | Field to match terms against |
| `operator` | string | `'IN'` | SQL operator |
| `include_children` | bool | `true` | Include child terms (hierarchical only) |

---

### get_sql()

Generates SQL clauses to append to a query.

```php
public function get_sql( string $primary_table, string $primary_id_column ): string[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$primary_table` | string | Main table (e.g., `wp_posts`) |
| `$primary_id_column` | string | ID column in primary table |

**Returns:** Array with `'join'` and `'where'` keys.

**Example:**

```php
$tax_query = new WP_Tax_Query( array(
    array( 'taxonomy' => 'category', 'terms' => array( 5 ) )
) );

$sql = $tax_query->get_sql( $wpdb->posts, 'ID' );
// $sql['join']  = ' LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)'
// $sql['where'] = ' AND ( wp_term_relationships.term_taxonomy_id IN (5) )'
```

---

### sanitize_query()

Validates and normalizes query clauses.

```php
public function sanitize_query( array $queries ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$queries` | array | Raw query clauses |

**Returns:** Sanitized clauses with defaults applied.

---

### sanitize_relation()

Validates a relation operator.

```php
public function sanitize_relation( string $relation ): string
```

**Returns:** `'AND'` or `'OR'`

---

### transform_query()

Transforms term field values between formats.

```php
public function transform_query( array &$query, string $resulting_field ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `&$query` | array | Query clause (modified in place) |
| `$resulting_field` | string | Target field format |

Converts between `slug`, `name`, `term_id`, and `term_taxonomy_id`.

**Error Handling:**

Sets `$query` to `WP_Error` if terms don't exist (with `'AND'` operator).

---

### get_sql_for_clause()

Generates SQL for a single first-order clause.

```php
public function get_sql_for_clause( array &$clause, array $parent_query ): array
```

**Returns:** Array with `'join'` and `'where'` arrays.

---

## Operators

| Operator | Description |
|----------|-------------|
| `IN` | Object has any of the terms (default) |
| `NOT IN` | Object has none of the terms |
| `AND` | Object has all of the terms |
| `EXISTS` | Object has any term in the taxonomy |
| `NOT EXISTS` | Object has no terms in the taxonomy |

**Since:** 4.1.0 (`EXISTS` and `NOT EXISTS`)

---

## Field Types

| Field | Description |
|-------|-------------|
| `term_id` | Term ID (default) |
| `slug` | Term slug |
| `name` | Term name |
| `term_taxonomy_id` | Term-taxonomy ID (for cross-taxonomy queries) |

**Note:** When using `term_taxonomy_id`, the `taxonomy` parameter is optional.

---

## Query Examples

### Single Taxonomy

```php
$tax_query = array(
    array(
        'taxonomy' => 'category',
        'terms'    => array( 'news', 'featured' ),
        'field'    => 'slug',
    ),
);
```

### Multiple Taxonomies (AND)

```php
$tax_query = array(
    'relation' => 'AND',
    array(
        'taxonomy' => 'category',
        'terms'    => array( 5 ),
    ),
    array(
        'taxonomy' => 'post_tag',
        'terms'    => array( 'featured' ),
        'field'    => 'slug',
    ),
);
```

### Exclude Terms

```php
$tax_query = array(
    array(
        'taxonomy' => 'category',
        'terms'    => array( 10, 20 ),
        'operator' => 'NOT IN',
    ),
);
```

### All Terms Required

```php
$tax_query = array(
    array(
        'taxonomy' => 'post_tag',
        'terms'    => array( 'red', 'blue', 'green' ),
        'field'    => 'slug',
        'operator' => 'AND',
    ),
);
```

### Nested Query

```php
$tax_query = array(
    'relation' => 'OR',
    array(
        'taxonomy' => 'category',
        'terms'    => array( 5 ),
    ),
    array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'post_format',
            'terms'    => array( 'post-format-video' ),
            'field'    => 'slug',
        ),
        array(
            'taxonomy' => 'post_tag',
            'terms'    => array( 'featured' ),
            'field'    => 'slug',
        ),
    ),
);
```

### Taxonomy Exists

```php
$tax_query = array(
    array(
        'taxonomy' => 'custom_taxonomy',
        'operator' => 'EXISTS',
    ),
);
```

---

## Internal Methods

### is_first_order_clause() <small>(protected static)</small>

Determines if a clause is first-order.

```php
protected static function is_first_order_clause( array $query ): bool
```

First-order if contains: `terms`, `taxonomy`, `include_children`, `field`, or `operator`.

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

Only `IN` clauses with `OR` relation can share joins.

---

### clean_query() <small>(private)</small>

Validates and transforms a single query clause.

```php
private function clean_query( array &$query ): void
```

**Validation:**
- Taxonomy must exist (unless using `term_taxonomy_id`)
- Terms transformed to `term_taxonomy_id` for SQL
- Child terms included if `include_children` is true

**Errors:**

Sets `$query` to `WP_Error` with:
- `invalid_taxonomy` — Taxonomy doesn't exist
- `inexistent_terms` — Terms not found (with `AND` operator)

---

## Generated SQL Patterns

### IN Operator

```sql
LEFT JOIN wp_term_relationships AS tt1
  ON (wp_posts.ID = tt1.object_id)
WHERE tt1.term_taxonomy_id IN (5, 10, 15)
```

### NOT IN Operator

```sql
WHERE wp_posts.ID NOT IN (
    SELECT object_id FROM wp_term_relationships
    WHERE term_taxonomy_id IN (5, 10, 15)
)
```

### AND Operator

```sql
WHERE (
    SELECT COUNT(1) FROM wp_term_relationships
    WHERE term_taxonomy_id IN (5, 10, 15)
    AND object_id = wp_posts.ID
) = 3
```

### EXISTS / NOT EXISTS

```sql
WHERE EXISTS (
    SELECT 1 FROM wp_term_relationships
    INNER JOIN wp_term_taxonomy
      ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
    WHERE wp_term_taxonomy.taxonomy = 'category'
    AND wp_term_relationships.object_id = wp_posts.ID
)
```

---

## Queried Terms Reference

The `$queried_terms` property provides term data for parent queries:

```php
$tax_query->queried_terms = array(
    'category' => array(
        'terms' => array( 5, 10 ),
        'field' => 'term_id',
    ),
    'post_tag' => array(
        'terms' => array( 'featured' ),
        'field' => 'slug',
    ),
);
```

Used by `WP_Query` for:
- Setting query vars (`cat`, `tag`, etc.)
- Generating canonical URLs
- Building navigation

---

## Performance Considerations

1. **JOIN Optimization:** `IN` clauses with `OR` share table aliases
2. **NOT IN Subquery:** Uses subquery instead of JOIN for exclusion
3. **AND Counting:** Requires counting query for all-match logic
4. **Child Terms:** `include_children` triggers term hierarchy lookup
