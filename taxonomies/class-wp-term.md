# WP_Term

Core class used to implement the WP_Term object. Represents a single taxonomy term.

**Source:** `wp-includes/class-wp-term.php`  
**Since:** 4.4.0

## Class Declaration

```php
#[AllowDynamicProperties]
final class WP_Term
```

---

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$term_id` | int | public | Term ID |
| `$name` | string | public | The term's name. Default `''` |
| `$slug` | string | public | The term's slug. Default `''` |
| `$term_group` | int | public | The term's term_group. Default `''` |
| `$term_taxonomy_id` | int | public | Term Taxonomy ID. Default `0` |
| `$taxonomy` | string | public | The term's taxonomy name. Default `''` |
| `$description` | string | public | The term's description. Default `''` |
| `$parent` | int | public | ID of a term's parent term. Default `0` |
| `$count` | int | public | Cached object count for this term. Default `0` |
| `$filter` | string | public | Term object's sanitization level. Default `'raw'` |

### Virtual Properties

| Property | Type | Description |
|----------|------|-------------|
| `$data` | object | Sanitized term data (via `__get()`) |

---

## Methods

### get_instance()

Retrieve WP_Term instance.

```php
public static function get_instance( int $term_id, string $taxonomy = null ): WP_Term|WP_Error|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$taxonomy` | string | Taxonomy name. Used for disambiguating shared terms |

**Returns:**

- `WP_Term` — Term object if found
- `WP_Error` — If term is shared between taxonomies and insufficient data to distinguish
- `false` — For other failures

**Behavior:**

1. Converts `$term_id` to integer
2. Returns `false` if `$term_id` is empty/zero
3. Checks term cache first
4. If not cached or taxonomy mismatch, queries database
5. Handles shared terms between taxonomies:
   - If taxonomy specified, finds matching term
   - If only one term found, uses it
   - If multiple valid taxonomies, returns `WP_Error`
6. Returns `WP_Error` if taxonomy doesn't exist
7. Sanitizes term and caches if single result
8. Creates `WP_Term` object and applies filter

**Error Codes:**

- `ambiguous_term_id` — Term ID is shared between multiple taxonomies
- `invalid_taxonomy` — Invalid taxonomy

**Example:**

```php
$term = WP_Term::get_instance( 5, 'category' );

if ( $term instanceof WP_Term ) {
    echo $term->name;
}
```

---

### __construct()

Constructor.

```php
public function __construct( WP_Term|object $term )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | WP_Term\|object | Term object to copy properties from |

**Behavior:**

Iterates over `$term`'s public properties and assigns them to `$this`.

---

### filter()

Sanitizes term fields, according to the filter type provided.

```php
public function filter( string $filter ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$filter` | string | Filter context |

**Filter Contexts:**

| Context | Description |
|---------|-------------|
| `'raw'` | No sanitization |
| `'edit'` | For editing in admin |
| `'db'` | For database storage |
| `'display'` | For front-end display |
| `'attribute'` | For HTML attributes |
| `'js'` | For JavaScript |
| `'rss'` | For RSS feeds |

**Behavior:**

Calls `sanitize_term( $this, $this->taxonomy, $filter )` which modifies the object in place.

---

### to_array()

Converts an object to array.

```php
public function to_array(): array
```

**Returns:** Array of all public object properties.

**Example:**

```php
$term = get_term( 5 );
$array = $term->to_array();
// array( 'term_id' => 5, 'name' => '...', 'slug' => '...', ... )
```

---

### __get()

Getter for virtual properties.

```php
public function __get( string $key ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Property to get |

**Supported Keys:**

| Key | Returns |
|-----|---------|
| `'data'` | Sanitized stdClass with term columns |

**Behavior for `'data'`:**

1. Creates new stdClass
2. Copies columns: `term_id`, `name`, `slug`, `term_group`, `term_taxonomy_id`, `taxonomy`, `description`, `parent`, `count`
3. Returns sanitized via `sanitize_term( $data, $data->taxonomy, 'raw' )`

---

## Database Columns

| Column | Type | Description |
|--------|------|-------------|
| `term_id` | bigint(20) | Primary key in wp_terms |
| `name` | varchar(200) | Term name |
| `slug` | varchar(200) | URL-safe name |
| `term_group` | bigint(10) | Group for term aliases |
| `term_taxonomy_id` | bigint(20) | Primary key in wp_term_taxonomy |
| `taxonomy` | varchar(32) | Taxonomy name |
| `description` | longtext | Term description |
| `parent` | bigint(20) | Parent term_id |
| `count` | bigint(20) | Object count |

---

## Usage Examples

### Getting a Term

```php
// By ID
$term = get_term( 5 );

// By slug
$term = get_term_by( 'slug', 'uncategorized', 'category' );

// From cache
$term = WP_Term::get_instance( 5, 'category' );
```

### Working with Term Data

```php
$term = get_term( 5, 'category' );

// Access properties
echo $term->name;           // 'Uncategorized'
echo $term->slug;           // 'uncategorized'
echo $term->term_id;        // 5
echo $term->taxonomy;       // 'category'
echo $term->count;          // 10
echo $term->parent;         // 0

// Check hierarchy
if ( $term->parent > 0 ) {
    $parent = get_term( $term->parent, $term->taxonomy );
}
```

### Converting to Array

```php
$term = get_term( 5 );
$array = $term->to_array();

// Use with functions expecting arrays
$term = get_term( 5, 'category', ARRAY_A );
// Returns associative array directly
```

### Sanitization Contexts

```php
$term = get_term( 5 );

// For display (default)
echo esc_html( $term->name );

// Get for editing
$term_for_edit = get_term_to_edit( 5, 'category' );

// Apply specific filter
$term->filter( 'display' );
echo $term->description;  // Now display-sanitized
```

### Checking Term Type

```php
$term = get_term( 5 );

if ( $term instanceof WP_Term ) {
    // Valid term object
    echo $term->name;
} elseif ( is_wp_error( $term ) ) {
    // Error occurred
    echo $term->get_error_message();
} else {
    // Term not found (null)
    echo 'Term does not exist';
}
```

---

## Important Notes

1. **Do not instantiate directly** — Use `get_term()`, `get_term_by()`, or `WP_Term::get_instance()`

2. **Filter property** — The `$filter` property tracks the current sanitization state. Calling `filter()` updates both the property values and this flag

3. **Shared terms** — Prior to WordPress 4.2, terms could be shared across taxonomies. Use `wp_get_split_term()` if dealing with legacy data

4. **Dynamic properties** — The `#[AllowDynamicProperties]` attribute permits additional properties. The `object_id` property is added when using `'all_with_object_id'` fields in queries

5. **Caching** — Terms are cached in the `'terms'` cache group. Only single-taxonomy terms are cached to avoid ambiguity
