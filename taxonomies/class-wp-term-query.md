# WP_Term_Query

Class used for querying terms from the database.

**Source:** `wp-includes/class-wp-term-query.php`  
**Since:** 4.6.0

## Class Declaration

```php
#[AllowDynamicProperties]
class WP_Term_Query
```

---

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$request` | string | public | SQL string used to perform database query |
| `$meta_query` | WP_Meta_Query\|false | public | Metadata query container |
| `$query_vars` | array | public | Query vars set by the user |
| `$query_var_defaults` | array | public | Default values for query vars |
| `$terms` | array | public | List of terms located by the query |

### Protected Properties

| Property | Type | Description |
|----------|------|-------------|
| `$meta_query_clauses` | array | Metadata query clauses |
| `$sql_clauses` | array | SQL query clauses (`select`, `from`, `where`, `orderby`, `limits`) |

---

## Query Variables

### Constructor Parameters

```php
public function __construct( string|array $query = '' )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | string\|array | Query parameters (see below) |

### Supported Query Variables

| Variable | Type | Default | Description |
|----------|------|---------|-------------|
| `taxonomy` | string\|string[] | `null` | Taxonomy name(s) to limit results |
| `object_ids` | int\|int[] | `null` | Object ID(s) to limit terms to |
| `orderby` | string | `'name'` | Field to order by (see Orderby Options) |
| `order` | string | `'ASC'` | `'ASC'` or `'DESC'` |
| `hide_empty` | bool\|int | `true` | Whether to hide terms not assigned to any posts |
| `include` | int[]\|string | `[]` | Term IDs to include |
| `exclude` | int[]\|string | `[]` | Term IDs to exclude (ignored if `include` is set) |
| `exclude_tree` | int[]\|string | `[]` | Term IDs to exclude with descendants |
| `number` | int\|string | `''` | Maximum number of terms. `''`/`0` for all |
| `offset` | int | `''` | Number to offset query |
| `fields` | string | `'all'` | Fields to return (see Fields Options) |
| `name` | string\|string[] | `''` | Term name(s) to match |
| `slug` | string\|string[] | `''` | Term slug(s) to match |
| `term_taxonomy_id` | int\|int[] | `''` | Term taxonomy ID(s) to match |
| `hierarchical` | bool | `true` | Whether to include terms with non-empty descendants |
| `search` | string | `''` | Search string (wildcards added automatically) |
| `name__like` | string | `''` | Partial name match |
| `description__like` | string | `''` | Partial description match |
| `pad_counts` | bool | `false` | Whether to pad children count to parent |
| `get` | string | `''` | `'all'` to return all terms regardless of ancestry |
| `child_of` | int | `0` | Term ID to retrieve children of |
| `parent` | int | `''` | Parent term ID for direct children |
| `childless` | bool | `false` | Limit to terms with no children |
| `cache_domain` | string | `'core'` | Unique cache key prefix |
| `cache_results` | bool | `true` | Whether to cache term information |
| `update_term_meta_cache` | bool | `true` | Whether to prime meta caches |
| `meta_key` | string\|string[] | `''` | Meta key(s) to filter by |
| `meta_value` | string\|string[] | `''` | Meta value(s) to filter by |
| `meta_compare` | string | `''` | Meta comparison operator |
| `meta_compare_key` | string | `''` | Meta key comparison operator |
| `meta_type` | string | `''` | Meta value type for CAST |
| `meta_type_key` | string | `''` | Meta key type for CAST |
| `meta_query` | array | `''` | Full meta query. See `WP_Meta_Query` |

### Orderby Options

| Value | Description |
|-------|-------------|
| `'name'` | Term name (default) |
| `'slug'` | Term slug |
| `'term_group'` | Term group |
| `'term_id'` | Term ID |
| `'id'` | Alias for `term_id` |
| `'description'` | Term description |
| `'parent'` | Parent term ID |
| `'term_order'` | Term order (requires `object_ids`) |
| `'count'` | Object count |
| `'include'` | Match order of `include` param |
| `'slug__in'` | Match order of `slug` param |
| `'meta_value'` | Meta value |
| `'meta_value_num'` | Numeric meta value |
| `{meta_key}` | Specific meta key |
| `{meta_query_clause}` | Meta query clause key |
| `'none'` | No ordering |

### Fields Options

| Value | Returns |
|-------|---------|
| `'all'` | Array of `WP_Term` objects |
| `'all_with_object_id'` | Array of `WP_Term` objects with `object_id` property |
| `'ids'` | Array of term IDs (`int[]`) |
| `'tt_ids'` | Array of term taxonomy IDs (`int[]`) |
| `'names'` | Array of term names (`string[]`) |
| `'slugs'` | Array of term slugs (`string[]`) |
| `'count'` | Number of matching terms (`int`) |
| `'id=>parent'` | Associative array: term_id => parent (`int[]`) |
| `'id=>name'` | Associative array: term_id => name (`string[]`) |
| `'id=>slug'` | Associative array: term_id => slug (`string[]`) |

---

## Methods

### __construct()

Sets up the term query, based on the query vars passed.

```php
public function __construct( string|array $query = '' )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | string\|array | Query string or array of arguments |

**Behavior:**

- Sets default query vars
- If query provided, calls `query()`

---

### parse_query()

Parse arguments passed to the term query with default query parameters.

```php
public function parse_query( string|array $query = '' ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | string\|array | Query arguments |

**Filters Applied:**

- `get_terms_defaults` — Filter default query arguments

**Actions Fired:**

- `parse_term_query` — After query vars parsed

**Behavior:**

1. Applies `get_terms_defaults` filter
2. Merges with defaults
3. Converts `number` and `offset` to integers
4. If `parent` is set, disables `child_of`
5. If `get` is `'all'`, resets hierarchy/empty filters
6. Fires `parse_term_query` action

---

### query()

Sets up the query and retrieves the results.

```php
public function query( string|array $query ): WP_Term[]|int[]|string[]|string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | string\|array | Query arguments |

**Returns:** Array of terms, or count as numeric string.

---

### get_terms()

Retrieves the query results.

```php
public function get_terms(): WP_Term[]|int[]|string[]|string
```

**Returns:** Based on `fields` parameter:

- `'all'`, `'all_with_object_id'` — `WP_Term[]`
- `'count'` — Numeric string
- `'names'`, `'slugs'`, `'id=>name'`, `'id=>slug'` — `string[]`
- `'ids'`, `'tt_ids'`, `'id=>parent'` — `int[]`

**Filters Applied:**

- `get_terms_args` — Filter query arguments
- `list_terms_exclusions` — Filter exclusion SQL
- `get_terms_fields` — Filter SELECT fields
- `terms_clauses` — Filter all SQL clauses
- `terms_pre_query` — Short-circuit opportunity
- `get_terms` — Filter final results (via `get_terms()` wrapper)

**Actions Fired:**

- `pre_get_terms` — Before query execution

**Execution Flow:**

1. `parse_query()` — Parse arguments
2. Set up `WP_Meta_Query`
3. Fire `pre_get_terms` action
4. Determine if taxonomy is hierarchical
5. Apply `get_terms_args` filter
6. Build SQL clauses:
   - Taxonomy filter
   - Inclusions/exclusions
   - Name/slug filters
   - Object ID filters
   - Parent/count filters
   - Search conditions
   - Meta query joins
7. Apply `terms_clauses` filter
8. Check cache or execute query
9. Prime term caches
10. Handle hierarchy (`child_of`, `pad_counts`, `hide_empty`)
11. Apply offset/number limits for hierarchical
12. Format results based on `fields`
13. Cache results

---

### parse_orderby() <small>(protected)</small>

Parse and sanitize 'orderby' keys passed to the term query.

```php
protected function parse_orderby( string $orderby_raw ): string|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$orderby_raw` | string | Alias for the field to order by |

**Returns:** Value for ORDER clause, or `false`.

**Filters Applied:**

- `get_terms_orderby` — Filter ORDERBY clause

---

### parse_orderby_meta() <small>(protected)</small>

Generate the ORDER BY clause for an 'orderby' param that is potentially related to a meta query.

```php
protected function parse_orderby_meta( string $orderby_raw ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$orderby_raw` | string | Raw orderby value |

**Returns:** ORDER BY clause.

---

### parse_order() <small>(protected)</small>

Parse an 'order' query variable and cast it to ASC or DESC.

```php
protected function parse_order( string $order ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$order` | string | Order query variable |

**Returns:** `'ASC'` or `'DESC'`.

---

### get_search_sql() <small>(protected)</small>

Used internally to generate a SQL string related to the 'search' parameter.

```php
protected function get_search_sql( string $search ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$search` | string | Search string |

**Returns:** Search SQL (matches name or slug with wildcards).

---

### format_terms() <small>(protected)</small>

Format response depending on field requested.

```php
protected function format_terms( WP_Term[] $term_objects, string $_fields ): WP_Term[]|int[]|string[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_objects` | WP_Term[] | Array of term objects |
| `$_fields` | string | Field to format |

**Returns:** Formatted array based on `$_fields`.

---

### populate_terms() <small>(protected)</small>

Creates an array of term objects from an array of term IDs.

```php
protected function populate_terms( Object[]|int[] $terms ): WP_Term[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$terms` | Object[]\|int[] | List of objects or term IDs |

**Returns:** Array of `WP_Term` objects.

---

### generate_cache_key() <small>(protected)</small>

Generate cache key.

```php
protected function generate_cache_key( array $args, string $sql ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Query arguments |
| `$sql` | string | SQL statement |

**Returns:** Cache key string.

---

## Usage Examples

### Basic Query

```php
$query = new WP_Term_Query( array(
    'taxonomy'   => 'category',
    'hide_empty' => false,
) );

foreach ( $query->terms as $term ) {
    echo $term->name;
}
```

### Get Term IDs Only

```php
$query = new WP_Term_Query( array(
    'taxonomy' => 'post_tag',
    'fields'   => 'ids',
    'number'   => 10,
) );

$term_ids = $query->terms; // array( 1, 2, 3, ... )
```

### Search Terms

```php
$query = new WP_Term_Query( array(
    'taxonomy' => 'category',
    'search'   => 'news',
    'fields'   => 'all',
) );
```

### With Meta Query

```php
$query = new WP_Term_Query( array(
    'taxonomy'   => 'genre',
    'meta_query' => array(
        array(
            'key'     => 'popularity',
            'value'   => 100,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        ),
    ),
    'orderby'    => 'meta_value_num',
    'meta_key'   => 'popularity',
    'order'      => 'DESC',
) );
```

### Get Terms for Specific Posts

```php
$query = new WP_Term_Query( array(
    'taxonomy'   => 'category',
    'object_ids' => array( 1, 2, 3 ),
    'fields'     => 'all_with_object_id',
) );

foreach ( $query->terms as $term ) {
    echo "Post {$term->object_id} has category: {$term->name}";
}
```

### Hierarchical Query

```php
$query = new WP_Term_Query( array(
    'taxonomy'   => 'category',
    'child_of'   => 5,  // Get descendants of term 5
    'hide_empty' => false,
) );

// Or get direct children only
$query = new WP_Term_Query( array(
    'taxonomy'   => 'category',
    'parent'     => 5,  // Direct children of term 5
    'hide_empty' => false,
) );
```

### Count Terms

```php
$query = new WP_Term_Query( array(
    'taxonomy' => 'category',
    'fields'   => 'count',
) );

$count = $query->terms; // "42" (string)
```

### Using get_terms() Wrapper

```php
// Simpler syntax using get_terms()
$terms = get_terms( array(
    'taxonomy'   => 'category',
    'hide_empty' => false,
    'number'     => 10,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );
```

---

## SQL Clauses

The `$sql_clauses` property contains:

| Key | Description |
|-----|-------------|
| `select` | SELECT clause |
| `from` | FROM clause with JOINs |
| `where` | Array of WHERE conditions |
| `orderby` | ORDER BY clause |
| `limits` | LIMIT clause |

Access the full query via `$query->request` after execution.
