# WP_User_Query Class

Core class for querying users with flexible filtering, sorting, and pagination.

**Since:** 3.1.0  
**Source:** `wp-includes/class-wp-user-query.php`

## Overview

`WP_User_Query` provides a powerful interface for retrieving users from the database with support for role/capability filtering, meta queries, search, and pagination.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_User_Query {
    public $query_vars = array();
    private $results;
    private $total_users = 0;
    public $meta_query = false;
    public $request;
    
    // SQL clause properties
    public $query_fields;
    public $query_from;
    public $query_where;
    public $query_orderby;
    public $query_limit;
}
```

## Constructor

```php
public function __construct( null|string|array $query = null )
```

If `$query` is provided, immediately prepares and executes the query.

**Example:**
```php
$query = new WP_User_Query( array(
    'role' => 'author',
    'orderby' => 'registered',
    'order' => 'DESC',
) );

$users = $query->get_results();
```

## Query Variables

### Role & Capability Filtering

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `role` | string\|string[] | `''` | Role(s) users must have (AND logic) |
| `role__in` | string[] | `[]` | Roles to include (OR logic) |
| `role__not_in` | string[] | `[]` | Roles to exclude |
| `capability` | string\|string[] | `''` | Capabilities users must have (AND logic) |
| `capability__in` | string[] | `[]` | Capabilities to include (OR logic) |
| `capability__not_in` | string[] | `[]` | Capabilities to exclude |

**Examples:**
```php
// Users with author role
'role' => 'author'

// Users with author OR editor role
'role__in' => array( 'author', 'editor' )

// Users with both roles (rare, but possible)
'role' => array( 'author', 'premium_member' )

// Users who can edit posts
'capability' => 'edit_posts'

// Exclude administrators
'role__not_in' => array( 'administrator' )
```

**Note:** Capability queries only work for capabilities stored in the database, not those filtered via `map_meta_cap`.

---

### ID Filtering

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `include` | int[] | `[]` | User IDs to include |
| `exclude` | int[] | `[]` | User IDs to exclude |

---

### Login/Nicename Filtering

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `login` | string | `''` | Exact login match |
| `login__in` | string[] | `[]` | Logins to include |
| `login__not_in` | string[] | `[]` | Logins to exclude |
| `nicename` | string | `''` | Exact nicename match |
| `nicename__in` | string[] | `[]` | Nicenames to include |
| `nicename__not_in` | string[] | `[]` | Nicenames to exclude |

---

### Search

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `search` | string | `''` | Search keyword |
| `search_columns` | string[] | `[]` | Columns to search |

**Search columns:** `'ID'`, `'user_login'`, `'user_email'`, `'user_url'`, `'user_nicename'`, `'display_name'`

**Wildcards:** Use `*` for leading/trailing wildcards.

```php
// Search all relevant columns
'search' => '*john*'

// Search specific columns
'search' => 'john',
'search_columns' => array( 'user_login', 'display_name' )

// Email search (auto-detected)
'search' => 'john@example.com'
```

---

### Meta Queries

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `meta_key` | string\|string[] | `''` | Meta key(s) to filter |
| `meta_value` | string\|string[] | `''` | Meta value(s) to filter |
| `meta_compare` | string | `'='` | Comparison operator |
| `meta_compare_key` | string | `'='` | Key comparison operator |
| `meta_type` | string | `'CHAR'` | Value data type for CAST |
| `meta_type_key` | string | `'CHAR'` | Key data type for CAST |
| `meta_query` | array | `[]` | Full meta query array |

**Example:**
```php
'meta_query' => array(
    'relation' => 'AND',
    array(
        'key'     => 'last_login',
        'value'   => strtotime( '-30 days' ),
        'compare' => '>',
        'type'    => 'NUMERIC',
    ),
    array(
        'key'     => 'subscription_status',
        'value'   => 'active',
    ),
)
```

---

### Sorting

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `orderby` | string\|array | `'login'` | Field(s) to order by |
| `order` | string | `'ASC'` | Sort direction |

**Orderby values:**

| Value | Description |
|-------|-------------|
| `'ID'` / `'id'` | User ID |
| `'login'` / `'user_login'` | Username |
| `'nicename'` / `'user_nicename'` | URL slug |
| `'email'` / `'user_email'` | Email |
| `'url'` / `'user_url'` | Website |
| `'registered'` / `'user_registered'` | Registration date |
| `'name'` / `'display_name'` | Display name |
| `'post_count'` | Number of posts |
| `'meta_value'` | Meta value (requires `meta_key`) |
| `'meta_value_num'` | Meta value as number |
| `'include'` | Preserve `include` order |
| `'login__in'` | Preserve `login__in` order |
| `'nicename__in'` | Preserve `nicename__in` order |

**Multi-column sorting:**
```php
'orderby' => array(
    'display_name' => 'ASC',
    'ID' => 'DESC',
)
```

---

### Pagination

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `number` | int | `-1` | Users to return (-1 for all) |
| `offset` | int | `0` | Users to skip |
| `paged` | int | `1` | Page number |
| `count_total` | bool | `true` | Count total users |

**Example:**
```php
// Page 2, 20 per page
'number' => 20,
'paged'  => 2,
```

---

### Fields

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `fields` | string\|string[] | `'all'` | Fields to return |

**Field options:**

| Value | Returns |
|-------|---------|
| `'all'` | Array of `WP_User` objects |
| `'ID'` | Array of IDs |
| `'display_name'` | Array of display names |
| `'user_login'` | Array of logins |
| Array | Objects with specified fields |

```php
// Just IDs
'fields' => 'ID'

// Specific fields
'fields' => array( 'ID', 'user_email', 'display_name' )
```

---

### Other Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `blog_id` | int | Current | Site ID (multisite) |
| `has_published_posts` | bool\|string[] | `null` | Has published posts |
| `who` | string | `''` | **Deprecated.** Use `capability` |
| `cache_results` | bool | `true` | Cache query results |

```php
// Users with published posts
'has_published_posts' => true

// Users with published posts in specific types
'has_published_posts' => array( 'post', 'page' )
```

---

## Methods

### prepare_query()

Prepares query variables.

```php
public function prepare_query( string|array $query = array() ): void
```

Called automatically by constructor, but can be called manually to reset query.

---

### query()

Executes the query.

```php
public function query(): void
```

Sets `$results` and `$total_users`.

---

### get_results()

Returns query results.

```php
public function get_results(): array
```

---

### get_total()

Returns total user count (for pagination).

```php
public function get_total(): int
```

---

### get()

Gets query variable.

```php
public function get( string $query_var ): mixed
```

---

### set()

Sets query variable.

```php
public function set( string $query_var, mixed $value ): void
```

---

### fill_query_vars()

Fills missing vars with defaults.

```php
public static function fill_query_vars( string|array $args ): array
```

---

## Hooks

### Actions

#### pre_get_users

Fires before query is parsed.

```php
do_action_ref_array( 'pre_get_users', array( &$this ) );
```

**Example:**
```php
add_action( 'pre_get_users', function( $query ) {
    if ( ! is_admin() ) {
        $query->set( 'role', 'subscriber' );
    }
} );
```

---

#### pre_user_query

Fires after parsing, before execution.

```php
do_action_ref_array( 'pre_user_query', array( &$this ) );
```

**Example:**
```php
add_action( 'pre_user_query', function( $query ) {
    // Modify SQL directly
    $query->query_where .= " AND user_status = 0";
} );
```

---

### Filters

#### users_pre_query

Short-circuits the query.

```php
$results = apply_filters_ref_array( 'users_pre_query', array( null, &$this ) );
```

Return non-null to bypass default query.

---

#### user_search_columns

Filters search columns.

```php
$columns = apply_filters( 'user_search_columns', $columns, $search, $this );
```

---

#### found_users_query

Filters the FOUND_ROWS() query.

```php
$sql = apply_filters( 'found_users_query', 'SELECT FOUND_ROWS()', $this );
```

---

## Usage Examples

### Basic Query

```php
$args = array(
    'role'    => 'subscriber',
    'orderby' => 'registered',
    'order'   => 'DESC',
    'number'  => 10,
);

$user_query = new WP_User_Query( $args );

if ( ! empty( $user_query->get_results() ) ) {
    foreach ( $user_query->get_results() as $user ) {
        echo $user->display_name . '<br>';
    }
} else {
    echo 'No users found.';
}
```

### Paginated Query

```php
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$per_page = 20;

$query = new WP_User_Query( array(
    'number' => $per_page,
    'paged'  => $paged,
) );

$total = $query->get_total();
$pages = ceil( $total / $per_page );

echo "Showing page {$paged} of {$pages} ({$total} users total)";
```

### Complex Meta Query

```php
$query = new WP_User_Query( array(
    'meta_query' => array(
        'relation' => 'AND',
        'membership' => array(
            'key'     => 'membership_level',
            'value'   => array( 'gold', 'platinum' ),
            'compare' => 'IN',
        ),
        'active' => array(
            'key'     => 'last_login',
            'value'   => strtotime( '-90 days' ),
            'compare' => '>',
            'type'    => 'NUMERIC',
        ),
    ),
    'orderby' => 'membership',
    'order'   => 'DESC',
) );
```

### Search with Specific Columns

```php
$query = new WP_User_Query( array(
    'search'         => '*smith*',
    'search_columns' => array( 'user_login', 'user_email', 'display_name' ),
) );
```

### Get Just IDs

```php
$query = new WP_User_Query( array(
    'role'   => 'editor',
    'fields' => 'ID',
) );

$editor_ids = $query->get_results(); // [1, 5, 12, ...]
```

### Multisite: Users on Specific Site

```php
$query = new WP_User_Query( array(
    'blog_id' => 2,
    'role'    => 'author',
) );
```

### Authors with Published Posts

```php
$query = new WP_User_Query( array(
    'has_published_posts' => array( 'post' ),
    'orderby'             => 'post_count',
    'order'               => 'DESC',
    'number'              => 10,
) );
```

### Exclude Specific Users

```php
$query = new WP_User_Query( array(
    'exclude' => array( 1, 2, 3 ), // Exclude admin IDs
    'role__not_in' => array( 'administrator' ),
) );
```

### Date-Based Query

```php
$query = new WP_User_Query( array(
    'date_query' => array(
        array(
            'after'  => '2024-01-01',
            'before' => '2024-12-31',
        ),
    ),
) );
```

## Performance Notes

1. **Disable total count** when not needed:
   ```php
   'count_total' => false
   ```

2. **Cache is disabled** when more than 3 fields requested.

3. **Large queries** should use pagination:
   ```php
   'number' => 100,
   'paged'  => $page,
   ```

4. **Results are cached** using salted cache keys based on query + last changed timestamps.
