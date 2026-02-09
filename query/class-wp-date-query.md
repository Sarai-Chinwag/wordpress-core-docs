# WP_Date_Query Class

Generates SQL clauses for filtering queries by date columns.

**Source:** `wp-includes/class-wp-date-query.php`  
**Since:** 3.7.0

## Overview

`WP_Date_Query` is a helper class used by `WP_Query`, `WP_Comment_Query`, and `WP_User_Query` to filter results based on date/time columns. It generates `WHERE` subclauses that can be appended to the primary SQL query.

## Basic Usage

Date queries are typically passed via the `date_query` argument in `WP_Query`:

```php
$query = new WP_Query( array(
    'post_type'  => 'post',
    'date_query' => array(
        array(
            'year'  => 2023,
            'month' => 12,
        ),
    ),
) );
```

## Constructor

```php
public function __construct( array $date_query, string $default_column = 'post_date' )
```

**Parameters:**
- `$date_query` — Array of date query clauses
- `$default_column` — Column to query against (default: `'post_date'`)

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$queries` | `array` | `[]` | Sanitized date query clauses |
| `$relation` | `string` | `'AND'` | Relation between top-level queries |
| `$column` | `string` | `'post_date'` | Default column to query |
| `$compare` | `string` | `'='` | Default comparison operator |
| `$time_keys` | `string[]` | (see below) | Supported time parameter keys |

**Time Keys:**
```php
array( 'after', 'before', 'year', 'month', 'monthnum', 'week', 'w', 
       'dayofyear', 'day', 'dayofweek', 'dayofweek_iso', 'hour', 'minute', 'second' )
```

## Date Query Parameters

### Top-Level Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `relation` | `string` | `'AND'` | `'AND'` or `'OR'` between clauses |
| `column` | `string` | `'post_date'` | Column to query |

### Clause Parameters

Each clause in the date query array can contain:

#### Range Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `before` | `string|array` | Date to retrieve posts before |
| `after` | `string|array` | Date to retrieve posts after |
| `inclusive` | `bool` | Include boundary dates (default: `false`) |

**`before`/`after` Formats:**

String format (parsed by `strtotime()`):
```php
'after' => 'January 1st, 2023'
'before' => '2023-12-31'
'after' => '-1 week'
'before' => 'next monday'
```

Array format:
```php
'after' => array(
    'year'  => 2023,
    'month' => 1,
    'day'   => 1,
)
'before' => array(
    'year'  => 2023,
    'month' => 12,
    'day'   => 31,
)
```

Array keys for `before`/`after`:
- `year` — Required. Four-digit year.
- `month` — Optional. 1-12. Defaults to 1 (after) or 12 (before).
- `day` — Optional. 1-31. Defaults to 1 (after) or last day of month (before).

#### Specific Date/Time Parameters

| Parameter | Type | Range | Description |
|-----------|------|-------|-------------|
| `year` | `int|int[]` | Any 4-digit | Four-digit year |
| `month` | `int|int[]` | 1-12 | Month number |
| `monthnum` | `int|int[]` | 1-12 | Month number (alias) |
| `week` | `int|int[]` | 0-53 | Week of year |
| `w` | `int|int[]` | 0-53 | Week of year (alias) |
| `day` | `int|int[]` | 1-31 | Day of month |
| `dayofyear` | `int|int[]` | 1-366 | Day of year |
| `dayofweek` | `int|int[]` | 1-7 | Day of week (1=Sunday) |
| `dayofweek_iso` | `int|int[]` | 1-7 | Day of week ISO (1=Monday) |
| `hour` | `int|int[]` | 0-23 | Hour |
| `minute` | `int|int[]` | 0-59 | Minute |
| `second` | `int|int[]` | 0-59 | Second |

**Array values** are accepted when using `'IN'`, `'NOT IN'`, `'BETWEEN'`, or `'NOT BETWEEN'` compare operators.

#### Control Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `column` | `string` | (inherited) | Column for this clause |
| `compare` | `string` | `'='` | Comparison operator |

**Compare Operators:**
- `'='` — Equal (default)
- `'!='` — Not equal
- `'>'` — Greater than
- `'>='` — Greater than or equal
- `'<'` — Less than
- `'<='` — Less than or equal
- `'IN'` — Value in array
- `'NOT IN'` — Value not in array
- `'BETWEEN'` — Value between two values
- `'NOT BETWEEN'` — Value not between two values

## Valid Columns

Default allowed columns:
- `post_date` — Post publish date
- `post_date_gmt` — Post publish date (GMT)
- `post_modified` — Post modified date
- `post_modified_gmt` — Post modified date (GMT)
- `comment_date` — Comment date
- `comment_date_gmt` — Comment date (GMT)
- `user_registered` — User registration date

Multisite additional columns:
- `registered` — Blog registration date
- `last_updated` — Blog last update date

Use the `date_query_valid_columns` filter to add custom columns.

## Methods

### get_sql()

```php
public function get_sql(): string
```

Generates the WHERE clause. The returned string includes the leading ` AND `.

**Returns:** MySQL WHERE clause.

**Example:**
```php
$date_query = new WP_Date_Query( array(
    array( 'year' => 2023 ),
) );
$where = $date_query->get_sql();
// Returns: " AND ( YEAR( wp_posts.post_date ) = 2023 )"
```

### validate_column()

```php
public function validate_column( string $column ): string
```

Validates and prefixes column name.

**Returns:** Validated column name with table prefix.

### validate_date_values()

```php
public function validate_date_values( array $date_query = array() ): bool
```

Validates date values and triggers `_doing_it_wrong()` notices for invalid values.

**Returns:** `true` if all values valid, `false` if any fail.

### build_mysql_datetime()

```php
public function build_mysql_datetime( string|array $datetime, bool $default_to_max = false ): string|false
```

Builds MySQL format date/time string.

**Parameters:**
- `$datetime` — Date string or array of components
- `$default_to_max` — Round up incomplete dates (for `before` queries)

**Returns:** MySQL datetime string (`'YYYY-MM-DD HH:MM:SS'`) or `false` on failure.

### build_value()

```php
public function build_value( string $compare, string|array $value ): string|false|int
```

Builds SQL value based on comparison operator.

### build_time_query()

```php
public function build_time_query( 
    string $column, 
    string $compare, 
    int|null $hour = null, 
    int|null $minute = null, 
    int|null $second = null 
): string|false
```

Builds SQL for time-based queries.

### get_compare()

```php
public function get_compare( array $query ): string
```

Returns the comparison operator from a query clause.

### sanitize_relation()

```php
public function sanitize_relation( string $relation ): string
```

Sanitizes relation to `'AND'` or `'OR'`.

## Example Queries

### Posts from Last 30 Days

```php
$query = new WP_Query( array(
    'date_query' => array(
        array(
            'after' => '30 days ago',
        ),
    ),
) );
```

### Posts from Specific Year and Month

```php
$query = new WP_Query( array(
    'date_query' => array(
        array(
            'year'  => 2023,
            'month' => 6,
        ),
    ),
) );
```

### Posts Between Two Dates

```php
$query = new WP_Query( array(
    'date_query' => array(
        array(
            'after'     => 'January 1st, 2023',
            'before'    => 'December 31st, 2023',
            'inclusive' => true,
        ),
    ),
) );
```

### Posts Modified Recently

```php
$query = new WP_Query( array(
    'date_query' => array(
        array(
            'column' => 'post_modified',
            'after'  => '1 week ago',
        ),
    ),
) );
```

### Posts from Weekdays Only

```php
$query = new WP_Query( array(
    'date_query' => array(
        array(
            'dayofweek' => array( 2, 3, 4, 5, 6 ), // Mon-Fri
            'compare'   => 'IN',
        ),
    ),
) );
```

### Posts from Business Hours

```php
$query = new WP_Query( array(
    'date_query' => array(
        array(
            'hour'    => 9,
            'compare' => '>=',
        ),
        array(
            'hour'    => 17,
            'compare' => '<=',
        ),
        'relation' => 'AND',
    ),
) );
```

### Complex Multi-Clause Query

```php
$query = new WP_Query( array(
    'date_query' => array(
        'relation' => 'OR',
        // Posts from Q1 2023
        array(
            'after'  => array(
                'year'  => 2023,
                'month' => 1,
            ),
            'before' => array(
                'year'  => 2023,
                'month' => 3,
                'day'   => 31,
            ),
            'inclusive' => true,
        ),
        // OR posts from Q4 2023
        array(
            'after'  => array(
                'year'  => 2023,
                'month' => 10,
            ),
            'before' => array(
                'year'  => 2023,
                'month' => 12,
                'day'   => 31,
            ),
            'inclusive' => true,
        ),
    ),
) );
```

### Query by Specific Weeks

```php
$query = new WP_Query( array(
    'date_query' => array(
        array(
            'year' => 2023,
            'week' => array( 1, 2, 3 ),
            'compare' => 'IN',
        ),
    ),
) );
```

### Nested Date Query

```php
$query = new WP_Query( array(
    'date_query' => array(
        'relation' => 'AND',
        // Must be in 2023
        array(
            'year' => 2023,
        ),
        // AND either in summer OR on weekends
        array(
            'relation' => 'OR',
            array(
                'month'   => array( 6, 7, 8 ),
                'compare' => 'IN',
            ),
            array(
                'dayofweek' => array( 1, 7 ), // Sunday or Saturday
                'compare'   => 'IN',
            ),
        ),
    ),
) );
```

## Hooks

### date_query_valid_columns

Filter to add valid date query columns.

```php
add_filter( 'date_query_valid_columns', function( $columns ) {
    $columns[] = 'my_custom_date_column';
    return $columns;
} );
```

### get_date_sql

Filter the final date query WHERE clause.

```php
add_filter( 'get_date_sql', function( $where, $date_query ) {
    // Modify $where
    return $where;
}, 10, 2 );
```

## Notes

### Invalid Date Handling

Invalid dates (e.g., month=13) generate SQL that returns no results and trigger `_doing_it_wrong()` notices.

### GMT vs Local Time

By default, date queries use the `post_date` column (local time). For GMT comparisons, specify the column:

```php
'date_query' => array(
    array(
        'column' => 'post_date_gmt',
        'after'  => '2023-01-01 00:00:00',
    ),
)
```

### Performance

Complex date queries with multiple clauses can impact performance. Consider:
- Adding indexes to frequently queried date columns
- Using date ranges instead of individual date checks
- Caching query results
