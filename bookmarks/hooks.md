# Bookmark Hooks Reference

## Filters

### get_bookmarks

Filters the returned list of bookmarks from `get_bookmarks()`.

```php
apply_filters( 'get_bookmarks', array $bookmarks, array $parsed_args )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$bookmarks` | array | List of bookmark objects |
| `$parsed_args` | array | Parsed query arguments |

**Example:**

```php
// Add custom property to all bookmarks
add_filter( 'get_bookmarks', function( $bookmarks, $args ) {
    foreach ( $bookmarks as $bookmark ) {
        $bookmark->is_external = ! str_contains( $bookmark->link_url, home_url() );
    }
    return $bookmarks;
}, 10, 2 );

// Filter out bookmarks with low ratings
add_filter( 'get_bookmarks', function( $bookmarks, $args ) {
    return array_filter( $bookmarks, function( $b ) {
        return $b->link_rating >= 3;
    } );
}, 10, 2 );
```

**Since:** 2.1.0

---

### wp_list_bookmarks

Filters the final HTML output of `wp_list_bookmarks()`.

```php
apply_filters( 'wp_list_bookmarks', string $html )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$html` | string | The complete HTML list of bookmarks |

**Example:**

```php
// Wrap output in custom container
add_filter( 'wp_list_bookmarks', function( $html ) {
    return '<div class="my-blogroll">' . $html . '</div>';
} );

// Add nofollow to all links
add_filter( 'wp_list_bookmarks', function( $html ) {
    return str_replace( '<a href=', '<a rel="nofollow" href=', $html );
} );
```

**Since:** 2.5.0

---

### link_category

Filters the category name when displaying bookmarks.

```php
apply_filters( 'link_category', string $cat_name )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cat_name` | string | The link category name |

**Example:**

```php
// Prefix all category names
add_filter( 'link_category', function( $name ) {
    return '📁 ' . $name;
} );

// Translate category names
add_filter( 'link_category', function( $name ) {
    $translations = array(
        'Friends' => 'Amigos',
        'Resources' => 'Recursos',
    );
    return $translations[ $name ] ?? $name;
} );
```

**Since:** 2.2.0

---

## Field Sanitization Filters

These dynamic filters are applied when sanitizing bookmark fields via `sanitize_bookmark_field()`.

### edit_{$field}

Filters a field value when being prepared for editing.

```php
apply_filters( "edit_{$field}", mixed $value, int $bookmark_id )
```

**Dynamic Field Names:**
- `edit_link_url`
- `edit_link_name`
- `edit_link_description`
- `edit_link_image`
- `edit_link_target`
- `edit_link_visible`
- `edit_link_owner`
- `edit_link_rating`
- `edit_link_updated`
- `edit_link_rel`
- `edit_link_notes`
- `edit_link_rss`

**Example:**

```php
// Decode entities for editing
add_filter( 'edit_link_description', function( $value, $id ) {
    return html_entity_decode( $value );
}, 10, 2 );
```

**Note:** After this filter, values are escaped with `esc_attr()` (or `esc_html()` for `link_notes`).

---

### pre_{$field}

Filters a field value before database storage.

```php
apply_filters( "pre_{$field}", mixed $value )
```

**Dynamic Field Names:**
- `pre_link_url`
- `pre_link_name`
- `pre_link_description`
- `pre_link_image`
- `pre_link_target`
- `pre_link_visible`
- `pre_link_owner`
- `pre_link_rating`
- `pre_link_updated`
- `pre_link_rel`
- `pre_link_notes`
- `pre_link_rss`

**Example:**

```php
// Ensure URLs have protocol
add_filter( 'pre_link_url', function( $url ) {
    if ( $url && ! preg_match( '#^https?://#', $url ) ) {
        $url = 'https://' . $url;
    }
    return $url;
} );

// Clean up descriptions before saving
add_filter( 'pre_link_description', function( $desc ) {
    return sanitize_textarea_field( $desc );
} );
```

---

### {$field}

Filters a field value for display context.

```php
apply_filters( "{$field}", mixed $value, int $bookmark_id, string $context )
```

**Dynamic Field Names:**
- `link_url`
- `link_name`
- `link_description`
- `link_image`
- `link_target`
- `link_visible`
- `link_owner`
- `link_rating`
- `link_updated`
- `link_rel`
- `link_notes`
- `link_rss`

**Example:**

```php
// Add UTM parameters to displayed URLs
add_filter( 'link_url', function( $url, $id, $context ) {
    if ( 'display' === $context ) {
        return add_query_arg( array(
            'utm_source' => 'blogroll',
            'utm_medium' => 'link',
        ), $url );
    }
    return $url;
}, 10, 3 );

// Truncate long descriptions
add_filter( 'link_description', function( $desc, $id, $context ) {
    if ( 'display' === $context && strlen( $desc ) > 100 ) {
        return substr( $desc, 0, 100 ) . '…';
    }
    return $desc;
}, 10, 3 );
```

---

## Filter Context Summary

| Context | Filter Applied | Then Escaped With |
|---------|---------------|-------------------|
| `raw` | None | None |
| `edit` | `edit_{$field}` | `esc_attr()` / `esc_html()` |
| `db` | `pre_{$field}` | None |
| `display` | `{$field}` | None |
| `attribute` | `{$field}` | `esc_attr()` |
| `js` | `{$field}` | `esc_js()` |

---

## Field Validation Notes

These fields have special validation that runs **before** any filters:

| Field | Validation |
|-------|------------|
| `link_id` | Cast to integer |
| `link_rating` | Cast to integer |
| `link_category` | Cast to array of integers, **no filters applied** |
| `link_visible` | Only `Y`, `N`, `y`, `n` allowed |
| `link_target` | Only `_top`, `_blank`, or empty allowed |

The `link_category` field is notable: it's returned immediately after validation with no filter hooks. This prevents the `link_category` filter (which filters category *names*) from affecting the array of category IDs.
