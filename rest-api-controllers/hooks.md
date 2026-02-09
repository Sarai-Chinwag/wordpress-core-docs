# REST API Controller Hooks

## Overview

REST API controllers fire numerous hooks for filtering and action purposes. Most hooks include a dynamic portion based on the resource type (post type, taxonomy, etc.).

## Common Hook Patterns

### Dynamic Hook Names

Many hooks use the pattern `rest_{action}_{type}` where:
- `{action}` - The operation (insert, prepare, delete, query)
- `{type}` - Post type, taxonomy, or resource type

Example: `rest_insert_post`, `rest_prepare_page`, `rest_delete_category`

---

## Post Controller Hooks

### rest_{$post_type}_query
Filters `WP_Query` arguments when querying posts.

```php
apply_filters( "rest_{$post_type}_query", array $args, WP_REST_Request $request );
```

**Parameters:**
- `$args` - Array of arguments for `WP_Query`
- `$request` - The REST API request

**Hook Names:** `rest_post_query`, `rest_page_query`, `rest_attachment_query`

**Since:** 4.7.0

---

### rest_pre_insert_{$post_type}
Filters a post before it is inserted via the REST API.

```php
apply_filters( "rest_pre_insert_{$post_type}", stdClass $prepared_post, WP_REST_Request $request );
```

**Parameters:**
- `$prepared_post` - Post object prepared for database
- `$request` - Request object

**Hook Names:** `rest_pre_insert_post`, `rest_pre_insert_page`

**Since:** 4.7.0

---

### rest_insert_{$post_type}
Fires after a post is created or updated via the REST API.

```php
do_action( "rest_insert_{$post_type}", WP_Post $post, WP_REST_Request $request, bool $creating );
```

**Parameters:**
- `$post` - Inserted or updated post object
- `$request` - Request object
- `$creating` - `true` when creating, `false` when updating

**Hook Names:** `rest_insert_post`, `rest_insert_page`, `rest_insert_attachment`

**Since:** 4.7.0

---

### rest_after_insert_{$post_type}
Fires after a post is completely created or updated (after all meta/terms).

```php
do_action( "rest_after_insert_{$post_type}", WP_Post $post, WP_REST_Request $request, bool $creating );
```

**Parameters:**
- `$post` - Inserted or updated post object
- `$request` - Request object
- `$creating` - `true` when creating, `false` when updating

**Hook Names:** `rest_after_insert_post`, `rest_after_insert_page`

**Since:** 5.0.0

---

### rest_delete_{$post_type}
Fires after a post is deleted or trashed via the REST API.

```php
do_action( "rest_delete_{$post_type}", WP_Post $post, WP_REST_Response $response, WP_REST_Request $request );
```

**Parameters:**
- `$post` - Deleted or trashed post
- `$response` - Response data
- `$request` - Request sent to API

**Hook Names:** `rest_delete_post`, `rest_delete_page`, `rest_delete_attachment`

**Since:** 4.7.0

---

### rest_prepare_{$post_type}
Filters the post data for a REST API response.

```php
apply_filters( "rest_prepare_{$post_type}", WP_REST_Response $response, WP_Post $post, WP_REST_Request $request );
```

**Parameters:**
- `$response` - Response object
- `$post` - Post object
- `$request` - Request object

**Hook Names:** `rest_prepare_post`, `rest_prepare_page`, `rest_prepare_attachment`

**Since:** 4.7.0

---

### rest_{$post_type}_trashable
Filters whether a post is trashable.

```php
apply_filters( "rest_{$post_type}_trashable", bool $supports_trash, WP_Post $post );
```

**Parameters:**
- `$supports_trash` - Whether post type supports trashing
- `$post` - Post being considered

**Since:** 4.7.0

---

### rest_{$post_type}_item_schema
Filters the post's schema.

```php
apply_filters( "rest_{$post_type}_item_schema", array $schema );
```

**Parameters:**
- `$schema` - Item schema data

**Since:** 5.4.0

---

### rest_{$post_type}_collection_params
Filters collection parameters for the posts controller.

```php
apply_filters( "rest_{$post_type}_collection_params", array $query_params, WP_Post_Type $post_type );
```

**Parameters:**
- `$query_params` - JSON Schema-formatted collection parameters
- `$post_type` - Post type object

**Since:** 4.7.0

---

### rest_query_var-{$key}
Filters a specific query var for `get_items()`.

```php
apply_filters( "rest_query_var-{$key}", mixed $value );
```

**Parameters:**
- `$value` - The query_var value

**Since:** 4.7.0

---

## User Controller Hooks

### rest_user_query
Filters `WP_User_Query` arguments.

```php
apply_filters( 'rest_user_query', array $prepared_args, WP_REST_Request $request );
```

**Parameters:**
- `$prepared_args` - Arguments for `WP_User_Query`
- `$request` - REST API request

**Since:** 4.7.0

---

### rest_pre_insert_user
Filters user data before insertion.

```php
apply_filters( 'rest_pre_insert_user', object $prepared_user, WP_REST_Request $request );
```

**Parameters:**
- `$prepared_user` - User object
- `$request` - Request object

**Since:** 4.7.0

---

### rest_insert_user
Fires after a user is created or updated.

```php
do_action( 'rest_insert_user', WP_User $user, WP_REST_Request $request, bool $creating );
```

**Parameters:**
- `$user` - Inserted or updated user object
- `$request` - Request object
- `$creating` - `true` when creating, `false` when updating

**Since:** 4.7.0

---

### rest_after_insert_user
Fires after a user is completely created or updated.

```php
do_action( 'rest_after_insert_user', WP_User $user, WP_REST_Request $request, bool $creating );
```

**Since:** 5.0.0

---

### rest_delete_user
Fires after a user is deleted.

```php
do_action( 'rest_delete_user', WP_User $user, WP_REST_Response $response, WP_REST_Request $request );
```

**Since:** 4.7.0

---

### rest_prepare_user
Filters user data for response.

```php
apply_filters( 'rest_prepare_user', WP_REST_Response $response, WP_User $user, WP_REST_Request $request );
```

**Since:** 4.7.0

---

### rest_user_collection_params
Filters collection parameters for users.

```php
apply_filters( 'rest_user_collection_params', array $query_params );
```

**Since:** 4.7.0

---

## Comment Controller Hooks

### rest_comment_query
Filters `WP_Comment_Query` arguments.

```php
apply_filters( 'rest_comment_query', array $prepared_args, WP_REST_Request $request );
```

**Since:** 4.7.0

---

### rest_pre_insert_comment
Filters a comment before insertion.

```php
apply_filters( 'rest_pre_insert_comment', array|WP_Error $prepared_comment, WP_REST_Request $request );
```

**Parameters:**
- `$prepared_comment` - Prepared comment data (or `WP_Error` to short-circuit)
- `$request` - Request object

**Since:** 4.7.0, 4.8.0 (can return `WP_Error`)

---

### rest_insert_comment
Fires after a comment is created or updated.

```php
do_action( 'rest_insert_comment', WP_Comment $comment, WP_REST_Request $request, bool $creating );
```

**Since:** 4.7.0

---

### rest_after_insert_comment
Fires after a comment is completely created or updated.

```php
do_action( 'rest_after_insert_comment', WP_Comment $comment, WP_REST_Request $request, bool $creating );
```

**Since:** 5.0.0

---

### rest_delete_comment
Fires after a comment is deleted.

```php
do_action( 'rest_delete_comment', WP_Comment $comment, WP_REST_Response $response, WP_REST_Request $request );
```

**Since:** 4.7.0

---

### rest_prepare_comment
Filters comment data for response.

```php
apply_filters( 'rest_prepare_comment', WP_REST_Response $response, WP_Comment $comment, WP_REST_Request $request );
```

**Since:** 4.7.0

---

### rest_allow_anonymous_comments
Filters whether anonymous comments can be created.

```php
apply_filters( 'rest_allow_anonymous_comments', bool $allow_anonymous, WP_REST_Request $request );
```

**Parameters:**
- `$allow_anonymous` - Whether to allow (default `false`)
- `$request` - Request object

**Since:** 4.7.0

---

### rest_comment_trashable
Filters whether a comment can be trashed.

```php
apply_filters( 'rest_comment_trashable', bool $supports_trash, WP_Comment $comment );
```

**Since:** 4.7.0

---

## Term Controller Hooks

### rest_{$taxonomy}_query
Filters `get_terms()` arguments.

```php
apply_filters( "rest_{$taxonomy}_query", array $prepared_args, WP_REST_Request $request );
```

**Hook Names:** `rest_category_query`, `rest_post_tag_query`

**Since:** 4.7.0

---

### rest_pre_insert_{$taxonomy}
Filters term data before insertion.

```php
apply_filters( "rest_pre_insert_{$taxonomy}", object $prepared_term, WP_REST_Request $request );
```

**Hook Names:** `rest_pre_insert_category`, `rest_pre_insert_post_tag`

**Since:** 4.7.0

---

### rest_insert_{$taxonomy}
Fires after a term is created or updated.

```php
do_action( "rest_insert_{$taxonomy}", WP_Term $term, WP_REST_Request $request, bool $creating );
```

**Since:** 4.7.0

---

### rest_after_insert_{$taxonomy}
Fires after a term is completely created or updated.

```php
do_action( "rest_after_insert_{$taxonomy}", WP_Term $term, WP_REST_Request $request, bool $creating );
```

**Since:** 5.0.0

---

### rest_delete_{$taxonomy}
Fires after a term is deleted.

```php
do_action( "rest_delete_{$taxonomy}", WP_Term $term, WP_REST_Response $response, WP_REST_Request $request );
```

**Since:** 4.7.0

---

### rest_prepare_{$taxonomy}
Filters term data for response.

```php
apply_filters( "rest_prepare_{$taxonomy}", WP_REST_Response $response, WP_Term $item, WP_REST_Request $request );
```

**Hook Names:** `rest_prepare_category`, `rest_prepare_post_tag`

**Since:** 4.7.0

---

### rest_{$taxonomy}_collection_params
Filters collection parameters for terms.

```php
apply_filters( "rest_{$taxonomy}_collection_params", array $query_params, WP_Taxonomy $taxonomy );
```

**Since:** 4.7.0

---

## Revision Controller Hooks

### rest_revision_query
Filters revision query arguments.

```php
apply_filters( 'rest_revision_query', array $args, WP_REST_Request $request );
```

**Since:** 4.7.0

---

## Attachment Controller Hooks

### rest_insert_attachment
Fires after an attachment is created or updated.

```php
do_action( 'rest_insert_attachment', WP_Post $attachment, WP_REST_Request $request, bool $creating );
```

**Since:** 4.7.0

---

### rest_after_insert_attachment
Fires after an attachment is completely created or updated.

```php
do_action( 'rest_after_insert_attachment', WP_Post $attachment, WP_REST_Request $request, bool $creating );
```

**Since:** 5.0.0

---

### wp_prevent_unsupported_mime_type_uploads
Filters whether to prevent uploads of unsupported image types.

```php
apply_filters( 'wp_prevent_unsupported_mime_type_uploads', bool $check_mime, string|null $mime_type );
```

**Parameters:**
- `$check_mime` - Whether to prevent (default `true`)
- `$mime_type` - MIME type being uploaded

**Since:** 6.8.0

---

## Meta Field Hooks

### rest_preprocess_comment
Filters comment data after preparation for database.

```php
apply_filters( 'rest_preprocess_comment', array $prepared_comment, WP_REST_Request $request );
```

**Since:** 4.7.0

---

## Usage Examples

### Modifying Post Query

```php
add_filter( 'rest_post_query', function( $args, $request ) {
    // Only show published posts to non-editors
    if ( ! current_user_can( 'edit_posts' ) ) {
        $args['post_status'] = 'publish';
    }
    return $args;
}, 10, 2 );
```

### Adding Custom Data to Response

```php
add_filter( 'rest_prepare_post', function( $response, $post, $request ) {
    $response->data['reading_time'] = calculate_reading_time( $post->post_content );
    return $response;
}, 10, 3 );
```

### Preventing Anonymous Comments

```php
add_filter( 'rest_allow_anonymous_comments', '__return_false' );
```

### Modifying User Creation

```php
add_action( 'rest_insert_user', function( $user, $request, $creating ) {
    if ( $creating ) {
        // Send welcome email
        wp_mail( $user->user_email, 'Welcome!', 'Your account has been created.' );
    }
}, 10, 3 );
```

### Custom Term Validation

```php
add_filter( 'rest_pre_insert_category', function( $prepared_term, $request ) {
    if ( strlen( $prepared_term->name ) < 3 ) {
        return new WP_Error( 
            'rest_term_name_too_short', 
            'Category name must be at least 3 characters.',
            array( 'status' => 400 )
        );
    }
    return $prepared_term;
}, 10, 2 );
```

## Hook Execution Order

### Create Operation
1. `*_permissions_check`
2. `rest_pre_insert_{type}`
3. Database insert
4. `rest_insert_{type}`
5. Meta/additional fields update
6. `rest_after_insert_{type}`
7. `rest_prepare_{type}`

### Update Operation
1. `*_permissions_check`
2. `rest_pre_insert_{type}`
3. Database update
4. `rest_insert_{type}`
5. Meta/additional fields update
6. `rest_after_insert_{type}`
7. `rest_prepare_{type}`

### Delete Operation
1. `*_permissions_check`
2. Database delete/trash
3. `rest_delete_{type}`
4. `rest_prepare_{type}` (for response)

### Read Operation
1. `*_permissions_check`
2. `rest_{type}_query`
3. Database query
4. `rest_prepare_{type}` (for each item)
