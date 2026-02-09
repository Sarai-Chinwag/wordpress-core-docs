# Bookmark Functions Reference

## Data Retrieval Functions

### get_bookmark()

Retrieves bookmark data by ID or object.

```php
get_bookmark( $bookmark, $output = OBJECT, $filter = 'raw' )
```

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$bookmark` | int\|stdClass | — | Bookmark ID or object |
| `$output` | string | `OBJECT` | Return type: `OBJECT`, `ARRAY_A`, or `ARRAY_N` |
| `$filter` | string | `'raw'` | How to sanitize fields |

**Returns:** `array|object|null` — Bookmark data or null if not found.

**Example:**

```php
// Get bookmark as object
$link = get_bookmark( 42 );
echo $link->link_name;
echo $link->link_url;

// Get as associative array
$link = get_bookmark( 42, ARRAY_A );
echo $link['link_name'];

// Get as numeric array
$link = get_bookmark( 42, ARRAY_N );
echo $link[0]; // link_id
```

**Notes:**
- Uses object cache (`bookmark` cache group)
- Falls back to global `$link` if no ID provided
- Retrieves `link_category` as array of term IDs

---

### get_bookmark_field()

Retrieves a single field from a bookmark.

```php
get_bookmark_field( $field, $bookmark, $context = 'display' )
```

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$field` | string | — | Field name (e.g., `link_url`, `link_name`) |
| `$bookmark` | int | — | Bookmark ID |
| `$context` | string | `'display'` | Sanitization context |

**Returns:** `string|WP_Error` — Field value or error.

**Example:**

```php
$url = get_bookmark_field( 'link_url', 42 );
$name = get_bookmark_field( 'link_name', 42 );
$desc = get_bookmark_field( 'link_description', 42, 'edit' );
```

**Available Fields:**

- `link_id` — Bookmark ID (int)
- `link_url` — URL
- `link_name` — Display name
- `link_image` — Image URL
- `link_target` — Target attribute (`_blank`, `_top`)
- `link_category` — Array of category IDs
- `link_description` — Description text
- `link_visible` — Visibility (`Y` or `N`)
- `link_owner` — Owner user ID (int)
- `link_rating` — Rating (int)
- `link_updated` — Last updated timestamp
- `link_rel` — Rel attribute (XFN)
- `link_notes` — Private notes
- `link_rss` — RSS feed URL

---

### get_bookmarks()

Retrieves a list of bookmarks matching criteria.

```php
get_bookmarks( $args = '' )
```

**Parameters (as array):**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `orderby` | string | `'name'` | Sort field. See options below |
| `order` | string | `'ASC'` | `'ASC'` or `'DESC'` |
| `limit` | int | `-1` | Number to return (`-1` for all) |
| `category` | string | `''` | Comma-separated category IDs |
| `category_name` | string | `''` | Category name to filter by |
| `hide_invisible` | int\|bool | `1` | Hide links with `link_visible='N'` |
| `show_updated` | int\|bool | `0` | Include update timestamp fields |
| `include` | string | `''` | Comma-separated IDs to include |
| `exclude` | string | `''` | Comma-separated IDs to exclude |
| `search` | string | `''` | Search term (matches URL, name, description) |

**Orderby Options:**

- `id` / `link_id` — By ID
- `name` / `link_name` — By name (default)
- `url` / `link_url` — By URL
- `visible` / `link_visible` — By visibility
- `rating` / `link_rating` — By rating
- `owner` / `link_owner` — By owner
- `updated` / `link_updated` — By update time
- `notes` / `link_notes` — By notes
- `description` / `link_description` — By description
- `length` — By character length of name
- `rand` — Random order (disables caching)

**Returns:** `object[]` — Array of bookmark objects.

**Examples:**

```php
// Get all bookmarks
$bookmarks = get_bookmarks();

// Get bookmarks from category 5, ordered by rating
$bookmarks = get_bookmarks( array(
    'category' => 5,
    'orderby' => 'rating',
    'order' => 'DESC',
) );

// Search bookmarks
$bookmarks = get_bookmarks( array(
    'search' => 'wordpress',
) );

// Get specific bookmarks
$bookmarks = get_bookmarks( array(
    'include' => '1,5,10',
) );

// Exclude certain bookmarks
$bookmarks = get_bookmarks( array(
    'exclude' => '3,7',
    'limit' => 10,
) );
```

**Notes:**
- Results are cached (except when `orderby='rand'`)
- When `include` is set, `exclude`, `category`, and `category_name` are ignored
- The `category_name` parameter looks up the category by name and converts to ID

---

## Template Functions

### wp_list_bookmarks()

Outputs or returns HTML list of bookmarks, optionally grouped by category.

```php
wp_list_bookmarks( $args = '' )
```

**Parameters (as array):**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `orderby` | string | `'name'` | Sort field |
| `order` | string | `'ASC'` | Sort direction |
| `limit` | int | `-1` | Number of links |
| `category` | string | `''` | Category IDs to include |
| `exclude_category` | string | `''` | Category IDs to exclude |
| `category_name` | string | `''` | Category name filter |
| `hide_invisible` | int\|bool | `1` | Hide invisible links |
| `show_updated` | int\|bool | `0` | Show last updated time |
| `echo` | int\|bool | `1` | Echo (`1`) or return (`0`) |
| `categorize` | int\|bool | `1` | Group by category |
| `title_li` | string | `'Bookmarks'` | Title text |
| `title_before` | string | `'<h2>'` | HTML before title |
| `title_after` | string | `'</h2>'` | HTML after title |
| `class` | string\|array | `'linkcat'` | CSS class(es) |
| `category_before` | string | `'<li id="%id" class="%class">'` | HTML before category |
| `category_after` | string | `'</li>'` | HTML after category |
| `category_orderby` | string | `'name'` | Category sort field |
| `category_order` | string | `'ASC'` | Category sort direction |
| `show_description` | int\|bool | `0` | Show link descriptions |
| `show_images` | int\|bool | `1` | Show link images |
| `show_rating` | int\|bool | `0` | Show link ratings |
| `show_name` | int\|bool | `0` | Show name alongside image |
| `before` | string | `'<li>'` | HTML before each link |
| `after` | string | `'</li>'` | HTML after each link |
| `between` | string | `"\n"` | Separator between link parts |
| `link_before` | string | `''` | HTML before link text (inside `<a>`) |
| `link_after` | string | `''` | HTML after link text (inside `<a>`) |

**Returns:** `void|string` — Void if `echo=1`, HTML string if `echo=0`.

**Examples:**

```php
// Basic blogroll in sidebar
wp_list_bookmarks();

// Custom styled blogroll
wp_list_bookmarks( array(
    'title_li' => 'Friends & Resources',
    'title_before' => '<h3 class="widget-title">',
    'title_after' => '</h3>',
    'categorize' => false,
    'show_description' => true,
    'between' => ' - ',
) );

// Get HTML without echoing
$html = wp_list_bookmarks( array(
    'echo' => false,
    'category' => 5,
) );

// Multiple categories, custom order
wp_list_bookmarks( array(
    'category' => '2,5,8',
    'orderby' => 'rating',
    'order' => 'DESC',
    'show_rating' => true,
) );

// Flat list (no category grouping)
wp_list_bookmarks( array(
    'categorize' => false,
    'title_li' => '',
    'before' => '',
    'after' => '<br />',
) );
```

**Output Structure (categorized):**

```html
<li id="linkcat-2" class="linkcat">
  <h2>Category Name</h2>
  <ul class='xoxo blogroll'>
    <li><a href="http://example.com" title="Description">Link Name</a></li>
    <li><a href="http://example2.com">Another Link</a></li>
  </ul>
</li>
```

---

### _walk_bookmarks()

**Private function** — Formats bookmark objects into HTML list items.

```php
_walk_bookmarks( $bookmarks, $args = '' )
```

**Note:** This is an internal function used by `wp_list_bookmarks()`. Theme developers should use `wp_list_bookmarks()` instead.

---

## Sanitization Functions

### sanitize_bookmark()

Sanitizes all fields of a bookmark.

```php
sanitize_bookmark( $bookmark, $context = 'display' )
```

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$bookmark` | stdClass\|array | — | Bookmark object or array |
| `$context` | string | `'display'` | Context: `'raw'`, `'edit'`, `'db'`, `'display'` |

**Returns:** `stdClass|array` — Sanitized bookmark (same type as input).

---

### sanitize_bookmark_field()

Sanitizes a single bookmark field.

```php
sanitize_bookmark_field( $field, $value, $bookmark_id, $context )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$field` | string | Field name |
| `$value` | mixed | Field value |
| `$bookmark_id` | int | Bookmark ID |
| `$context` | string | Context: `'raw'`, `'edit'`, `'db'`, `'display'`, `'attribute'`, `'js'` |

**Returns:** `mixed` — Sanitized value.

**Context Behaviors:**

| Context | Behavior |
|---------|----------|
| `raw` | Returns immediately after type enforcement |
| `edit` | Applies `edit_{$field}` filter, escapes for editing |
| `db` | Applies `pre_{$field}` filter for database storage |
| `display` | Applies `{$field}` filter for display |
| `attribute` | Display + `esc_attr()` |
| `js` | Display + `esc_js()` |

**Field-Specific Rules:**

- `link_id`, `link_rating` — Cast to integer
- `link_category` — Cast to array of integers, returned immediately (no filters)
- `link_visible` — Only allows `Y`, `N`, `y`, `n`
- `link_target` — Only allows `_top`, `_blank`, or empty

---

## Cache Functions

### clean_bookmark_cache()

Clears all caches related to a bookmark.

```php
clean_bookmark_cache( $bookmark_id )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$bookmark_id` | int | Bookmark ID to clear |

**Returns:** `void`

**Clears:**
- Individual bookmark cache (`bookmark` group)
- `get_bookmarks` result cache
- Object term cache for the bookmark

**Example:**

```php
// After manually updating a bookmark
$wpdb->update( $wpdb->links, $data, array( 'link_id' => 42 ) );
clean_bookmark_cache( 42 );
```
