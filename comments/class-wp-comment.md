# WP_Comment

Core class for organizing comments as instantiated objects.

**Since:** 4.4.0  
**Source:** `wp-includes/class-wp-comment.php`

## Overview

`WP_Comment` represents a single comment as an object with defined properties. It provides methods for accessing comment data and managing threaded comment hierarchies.

## Class Definition

```php
#[AllowDynamicProperties]
final class WP_Comment {
    // Properties and methods
}
```

**Note:** The class is `final` and cannot be extended.

## Properties

All properties are stored as strings for backward compatibility.

### Public Properties

| Property | Type | Description |
|----------|------|-------------|
| `$comment_ID` | string | Comment ID (numeric string) |
| `$comment_post_ID` | string | Associated post ID. Default '0' |
| `$comment_author` | string | Author display name. Default '' |
| `$comment_author_email` | string | Author email address. Default '' |
| `$comment_author_url` | string | Author website URL. Default '' |
| `$comment_author_IP` | string | Author IP address. Default '' |
| `$comment_date` | string | Local datetime (YYYY-MM-DD HH:MM:SS). Default '0000-00-00 00:00:00' |
| `$comment_date_gmt` | string | GMT datetime (YYYY-MM-DD HH:MM:SS). Default '0000-00-00 00:00:00' |
| `$comment_content` | string | Comment body content |
| `$comment_karma` | string | Karma score (numeric string). Default '0' |
| `$comment_approved` | string | Approval status. Default '1' |
| `$comment_agent` | string | Browser user agent. Default '' |
| `$comment_type` | string | Comment type. Default 'comment' (since 5.5.0) |
| `$comment_parent` | string | Parent comment ID (numeric string). Default '0' |
| `$user_id` | string | Registered user ID (numeric string). Default '0' |

### Protected Properties

| Property | Type | Description |
|----------|------|-------------|
| `$children` | array | Child comment objects |
| `$populated_children` | bool | Whether children have been populated |
| `$post_fields` | array | Post fields accessible via magic getter |

### Post Fields (Magic Getter)

These post fields are accessible on the comment object via `__get()`:

```php
$post_fields = array(
    'post_author', 'post_date', 'post_date_gmt', 'post_content',
    'post_title', 'post_excerpt', 'post_status', 'comment_status',
    'ping_status', 'post_name', 'to_ping', 'pinged', 'post_modified',
    'post_modified_gmt', 'post_content_filtered', 'post_parent',
    'guid', 'menu_order', 'post_type', 'post_mime_type', 'comment_count'
);
```

**Example:**
```php
$comment = get_comment( 123 );
echo $comment->post_title; // Accesses the parent post's title
```

## Methods

### get_instance()

Retrieves a WP_Comment instance by ID.

```php
public static function get_instance( $id ): WP_Comment|false
```

**Parameters:**
- `$id` (int) - Comment ID.

**Returns:** `WP_Comment|false` - Comment object or false if not found.

**Behavior:**
1. Checks object cache for the comment
2. Falls back to database query if not cached
3. Caches the result
4. Returns new WP_Comment instance

**Example:**
```php
$comment = WP_Comment::get_instance( 123 );
if ( $comment ) {
    echo $comment->comment_author;
}
```

---

### __construct()

Constructor. Populates properties from object vars.

```php
public function __construct( $comment )
```

**Parameters:**
- `$comment` (WP_Comment|stdClass) - Comment object to populate from.

**Note:** Typically you should use `get_comment()` or `WP_Comment::get_instance()` rather than instantiating directly.

---

### to_array()

Converts the comment object to an array.

```php
public function to_array(): array
```

**Returns:** Associative array of all object properties.

**Example:**
```php
$comment = get_comment( 123 );
$data = $comment->to_array();
// $data['comment_author'], $data['comment_content'], etc.
```

---

### get_children()

Retrieves child comments (replies).

```php
public function get_children( $args = array() ): WP_Comment[]
```

**Parameters:**
- `$args` (array):
  - `format` (string) - 'tree' for hierarchical, 'flat' for flattened. Default 'tree'.
  - `status` (string) - Comment status filter. Default 'all'.
  - `hierarchical` (string) - Threading mode: 'threaded', 'flat', or false. Default 'threaded'.
  - `orderby` (string|array) - Field(s) to order by.

**Returns:** Array of `WP_Comment` objects.

**Example:**
```php
$comment = get_comment( 123 );

// Get threaded children
$children = $comment->get_children();

// Get flattened list of all descendants
$all_descendants = $comment->get_children( array(
    'format' => 'flat',
) );

// Get only approved children
$approved = $comment->get_children( array(
    'status' => 'approve',
) );
```

**Behavior:**
- If children haven't been populated, queries the database
- If `format` is 'flat', recursively collects all descendants
- Returns cached children on subsequent calls

---

### add_child()

Adds a child comment.

```php
public function add_child( WP_Comment $child ): void
```

**Parameters:**
- `$child` (WP_Comment) - Child comment object.

**Used by:** `WP_Comment_Query` when bulk-filling descendants.

---

### get_child()

Retrieves a specific child comment by ID.

```php
public function get_child( $child_id ): WP_Comment|false
```

**Parameters:**
- `$child_id` (int) - Child comment ID.

**Returns:** `WP_Comment|false` - Child comment or false if not found.

---

### populated_children()

Sets the populated_children flag.

```php
public function populated_children( $set ): void
```

**Parameters:**
- `$set` (bool) - Whether children have been populated.

**Purpose:** Prevents unnecessary database queries when calling `get_children()` on comments known to have no children.

---

### __isset()

Checks if a property is set (magic method).

```php
public function __isset( $name ): bool
```

**Behavior:**
- Returns true for standard comment properties
- For post fields, loads the associated post and checks that property

---

### __get()

Magic getter for post field access.

```php
public function __get( $name ): mixed
```

**Behavior:** If `$name` matches a post field and the comment has a valid `comment_post_ID`, retrieves the corresponding post property.

**Example:**
```php
$comment = get_comment( 123 );
echo $comment->post_title;      // Loads post and returns its title
echo $comment->post_type;       // Returns the post type
echo $comment->post_status;     // Returns the post status
```

## Usage Examples

### Basic Retrieval

```php
// Using get_comment()
$comment = get_comment( 123 );

// Using static method
$comment = WP_Comment::get_instance( 123 );

// From query results
$comments = get_comments( array( 'post_id' => 42 ) );
foreach ( $comments as $comment ) {
    echo $comment->comment_author . ': ' . $comment->comment_content;
}
```

### Working with Threading

```php
// Get top-level comments
$comments = get_comments( array(
    'post_id' => 42,
    'parent'  => 0,
    'status'  => 'approve',
) );

foreach ( $comments as $comment ) {
    echo $comment->comment_content;
    
    // Get replies
    $replies = $comment->get_children();
    foreach ( $replies as $reply ) {
        echo "  Reply: " . $reply->comment_content;
        
        // Nested replies
        $nested = $reply->get_children();
        // ...
    }
}
```

### Accessing Post Data

```php
$comment = get_comment( 123 );

// These access the parent post via magic getter
echo "Comment on: " . $comment->post_title;
echo "Post type: " . $comment->post_type;
echo "Post author ID: " . $comment->post_author;
```

### Converting to Array

```php
$comment = get_comment( 123 );
$data = $comment->to_array();

// Useful for serialization or API responses
$json = wp_json_encode( $data );
```

## Caching

Comments are cached in the object cache:
- Cache group: `comment`
- Cache key: Comment ID

```php
// Manual cache operations
$cached = wp_cache_get( 123, 'comment' );

// Clear cache
clean_comment_cache( 123 );
```

## Type Coercion

All numeric properties are stored as strings for backward compatibility:

```php
$comment = get_comment( 123 );

// These are strings, not integers
var_dump( $comment->comment_ID );       // string "123"
var_dump( $comment->comment_post_ID );  // string "42"
var_dump( $comment->user_id );          // string "5"

// Cast when needed
$id = (int) $comment->comment_ID;
```

## Related

- [get_comment()](./functions.md#get_comment) - Wrapper function
- [WP_Comment_Query](./class-wp-comment-query.md) - Query comments
- [Walker_Comment](https://developer.wordpress.org/reference/classes/walker_comment/) - Display walker
