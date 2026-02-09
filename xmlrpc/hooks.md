# WordPress XML-RPC Hooks Reference

All hooks available in the WordPress XML-RPC server implementation.

## Filters

### `xmlrpc_enabled`

Controls whether XML-RPC methods requiring authentication are enabled.

```php
add_filter( 'xmlrpc_enabled', function( bool $is_enabled ): bool {
    return false; // Disable authenticated XML-RPC methods
});
```

**Since:** 3.5.0

**Parameters:**
- `$is_enabled` (bool) - Whether XML-RPC is enabled. Default `true`.

**Note:** Does NOT disable pingbacks or unauthenticated endpoints. For granular control, use `xmlrpc_methods`.

---

### `xmlrpc_methods`

Filters the methods exposed by the XML-RPC server.

```php
add_filter( 'xmlrpc_methods', function( array $methods ): array {
    // Remove pingback method
    unset( $methods['pingback.ping'] );
    
    // Add custom method
    $methods['custom.myMethod'] = 'my_custom_xmlrpc_method';
    
    return $methods;
});
```

**Since:** 1.5.0

**Parameters:**
- `$methods` (string[]) - Array of XML-RPC methods keyed by methodName.

---

### `xmlrpc_login_error`

Filters the XML-RPC user login error message.

```php
add_filter( 'xmlrpc_login_error', function( IXR_Error $error, WP_Error $user ): IXR_Error {
    // Customize error message
    return new IXR_Error( 403, 'Authentication failed.' );
}, 10, 2 );
```

**Since:** 3.5.0

**Parameters:**
- `$error` (IXR_Error) - The XML-RPC error message.
- `$user` (WP_Error) - WP_Error object from authentication attempt.

---

### `xmlrpc_blog_options`

Filters the XML-RPC blog options property.

```php
add_filter( 'xmlrpc_blog_options', function( array $blog_options ): array {
    // Add custom option
    $blog_options['custom_option'] = array(
        'desc'     => 'My Custom Option',
        'readonly' => true,
        'value'    => get_option( 'my_custom_option' ),
    );
    return $blog_options;
});
```

**Since:** 2.6.0

**Parameters:**
- `$blog_options` (array) - Array of XML-RPC blog options.

---

### `xmlrpc_default_post_fields`

Filters the default post query fields for XML-RPC methods.

```php
add_filter( 'xmlrpc_default_post_fields', function( array $fields, string $method ): array {
    return array( 'post', 'terms', 'custom_fields', 'enclosure' );
}, 10, 2 );
```

**Since:** 3.4.0

**Parameters:**
- `$fields` (array) - Post fields to retrieve. Default: `['post', 'terms', 'custom_fields']`
- `$method` (string) - Method name (e.g., `'wp.getPost'`, `'wp.getPosts'`)

---

### `xmlrpc_default_taxonomy_fields`

Filters the default taxonomy query fields.

```php
add_filter( 'xmlrpc_default_taxonomy_fields', function( array $fields, string $method ): array {
    return array( 'labels', 'cap', 'object_type', 'menu' );
}, 10, 2 );
```

**Since:** 3.4.0

**Parameters:**
- `$fields` (array) - Taxonomy fields. Default: `['labels', 'cap', 'object_type']`
- `$method` (string) - Method name

---

### `xmlrpc_default_user_fields`

Filters the default user query fields.

```php
add_filter( 'xmlrpc_default_user_fields', function( array $fields, string $method ): array {
    return array( 'basic' ); // Only basic fields
}, 10, 2 );
```

**Since:** 3.5.0

**Parameters:**
- `$fields` (array) - User fields. Default: `['all']`
- `$method` (string) - Method name

---

### `xmlrpc_default_posttype_fields`

Filters the default post type query fields.

```php
add_filter( 'xmlrpc_default_posttype_fields', function( array $fields, string $method ): array {
    return array( 'labels', 'cap', 'taxonomies', 'menu' );
}, 10, 2 );
```

**Since:** 3.4.0

**Parameters:**
- `$fields` (array) - Post type fields. Default: `['labels', 'cap', 'taxonomies']`
- `$method` (string) - Method name

---

### `xmlrpc_default_revision_fields`

Filters the default revision query fields.

```php
add_filter( 'xmlrpc_default_revision_fields', function( array $fields, string $method ): array {
    return array( 'post_date', 'post_date_gmt', 'post_content' );
}, 10, 2 );
```

**Since:** 3.5.0

**Parameters:**
- `$fields` (array) - Revision fields. Default: `['post_date', 'post_date_gmt']`
- `$method` (string) - Method name

---

### `xmlrpc_prepare_post`

Filters XML-RPC-prepared data for the given post.

```php
add_filter( 'xmlrpc_prepare_post', function( array $_post, array $post, array $fields ): array {
    // Add custom data
    $_post['custom_data'] = get_post_meta( $post['ID'], 'my_meta', true );
    return $_post;
}, 10, 3 );
```

**Since:** 3.4.0

**Parameters:**
- `$_post` (array) - Modified post data
- `$post` (array) - Original post data
- `$fields` (array) - Requested fields

---

### `xmlrpc_prepare_post_type`

Filters XML-RPC-prepared data for the given post type.

```php
add_filter( 'xmlrpc_prepare_post_type', function( array $_post_type, WP_Post_Type $post_type ): array {
    return $_post_type;
}, 10, 2 );
```

**Since:** 3.4.0 (WP_Post_Type param since 4.6.0)

---

### `xmlrpc_prepare_taxonomy`

Filters XML-RPC-prepared data for the given taxonomy.

```php
add_filter( 'xmlrpc_prepare_taxonomy', function( array $_taxonomy, WP_Taxonomy $taxonomy, array $fields ): array {
    return $_taxonomy;
}, 10, 3 );
```

**Since:** 3.4.0

---

### `xmlrpc_prepare_term`

Filters XML-RPC-prepared data for the given term.

```php
add_filter( 'xmlrpc_prepare_term', function( array $_term, array|object $term ): array {
    return $_term;
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_prepare_media_item`

Filters XML-RPC-prepared data for the given media item.

```php
add_filter( 'xmlrpc_prepare_media_item', function( array $_media_item, WP_Post $media_item, string $thumbnail_size ): array {
    // Add full-size URL
    $_media_item['full_url'] = wp_get_attachment_url( $media_item->ID );
    return $_media_item;
}, 10, 3 );
```

**Since:** 3.4.0

---

### `xmlrpc_prepare_page`

Filters XML-RPC-prepared data for the given page.

```php
add_filter( 'xmlrpc_prepare_page', function( array $_page, WP_Post $page ): array {
    return $_page;
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_prepare_comment`

Filters XML-RPC-prepared data for the given comment.

```php
add_filter( 'xmlrpc_prepare_comment', function( array $_comment, WP_Comment $comment ): array {
    return $_comment;
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_prepare_user`

Filters XML-RPC-prepared data for the given user.

```php
add_filter( 'xmlrpc_prepare_user', function( array $_user, WP_User $user, array $fields ): array {
    return $_user;
}, 10, 3 );
```

**Since:** 3.5.0

---

### `xmlrpc_wp_insert_post_data`

Filters post data array to be inserted via XML-RPC.

```php
add_filter( 'xmlrpc_wp_insert_post_data', function( array $post_data, array $content_struct ): array {
    // Modify post data before insert
    return $post_data;
}, 10, 2 );
```

**Since:** 3.4.0

**Parameters:**
- `$post_data` (array) - Parsed array of post data
- `$content_struct` (array) - Original content structure from request

---

### `xmlrpc_allow_anonymous_comments`

Filters whether to allow anonymous comments over XML-RPC.

```php
add_filter( 'xmlrpc_allow_anonymous_comments', '__return_true' );
```

**Since:** 2.7.0

**Parameters:**
- `$allow` (bool) - Whether to allow anonymous commenting. Default `false`.

---

### `xmlrpc_text_filters`

Filters the MovableType text filters list.

```php
add_filter( 'xmlrpc_text_filters', function( array $filters ): array {
    return $filters;
});
```

**Since:** 2.2.0

---

### `xmlrpc_pingback_error`

Filters the XML-RPC pingback error return.

```php
add_filter( 'xmlrpc_pingback_error', function( IXR_Error $error ): IXR_Error {
    // Customize pingback error
    return $error;
});
```

**Since:** 3.5.1

---

### `pingback_ping_source_uri`

Filters the pingback source URI.

```php
add_filter( 'pingback_ping_source_uri', function( string $pagelinkedfrom, string $pagelinkedto ): string {
    // Validate or modify source URI
    return $pagelinkedfrom;
}, 10, 2 );
```

**Since:** 3.6.0

---

### `pre_remote_source`

Filters the pingback remote source content.

```php
add_filter( 'pre_remote_source', function( string $remote_source, string $pagelinkedto ): string {
    return $remote_source;
}, 10, 2 );
```

**Since:** 2.5.0

---

### `pre_upload_error`

Filters whether to preempt the XML-RPC media upload.

```php
add_filter( 'pre_upload_error', function( bool $error ): bool|string {
    // Return string to abort with that error message
    if ( some_condition() ) {
        return 'Upload not allowed';
    }
    return false; // Allow upload
});
```

**Since:** 2.1.0

**Parameters:**
- `$error` (bool) - Whether to pre-empt upload. Default `false`.

**Returns:** `false` to allow, truthy string to abort with that error.

---

## Actions

### `xmlrpc_call`

Fires after XML-RPC user authentication but before method logic.

```php
add_action( 'xmlrpc_call', function( string $name, array|string $args, wp_xmlrpc_server $server ) {
    // Log XML-RPC call
    error_log( "XML-RPC call: $name" );
}, 10, 3 );
```

**Since:** 2.5.0 (args and server params since 5.7.0)

**Parameters:**
- `$name` (string) - Method name (e.g., `'wp.getPosts'`)
- `$args` (array|string) - Escaped arguments passed to method
- `$server` (wp_xmlrpc_server) - Server instance

**Used by all XML-RPC methods for logging/auditing.**

---

### `xmlrpc_call_success_wp_deletePage`

Fires after a page has been successfully deleted via XML-RPC.

```php
add_action( 'xmlrpc_call_success_wp_deletePage', function( int $page_id, array $args ) {
    // Handle post-deletion logic
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_wp_newCategory`

Fires after a new category has been created via XML-RPC.

```php
add_action( 'xmlrpc_call_success_wp_newCategory', function( int $cat_id, array $args ) {
    // Handle new category
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_wp_deleteCategory`

Fires after a category has been deleted via XML-RPC.

```php
add_action( 'xmlrpc_call_success_wp_deleteCategory', function( int $category_id, array $args ) {
    // Handle category deletion
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_wp_deleteComment`

Fires after a comment has been deleted via XML-RPC.

```php
add_action( 'xmlrpc_call_success_wp_deleteComment', function( int $comment_id, array $args ) {
    // Handle comment deletion
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_wp_editComment`

Fires after a comment has been updated via XML-RPC.

```php
add_action( 'xmlrpc_call_success_wp_editComment', function( int $comment_id, array $args ) {
    // Handle comment update
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_wp_newComment`

Fires after a new comment has been created via XML-RPC.

```php
add_action( 'xmlrpc_call_success_wp_newComment', function( int $comment_id, array $args ) {
    // Handle new comment
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_blogger_newPost`

Fires after a new post has been created via Blogger API.

```php
add_action( 'xmlrpc_call_success_blogger_newPost', function( int $post_id, array $args ) {
    // Handle new post
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_blogger_editPost`

Fires after a post has been updated via Blogger API.

```php
add_action( 'xmlrpc_call_success_blogger_editPost', function( int $post_id, array $args ) {
    // Handle post update
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_blogger_deletePost`

Fires after a post has been deleted via Blogger API.

```php
add_action( 'xmlrpc_call_success_blogger_deletePost', function( int $post_id, array $args ) {
    // Handle post deletion
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_mw_newPost`

Fires after a new post has been created via MetaWeblog API.

```php
add_action( 'xmlrpc_call_success_mw_newPost', function( int $post_id, array $args ) {
    // Handle new post
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_mw_editPost`

Fires after a post has been updated via MetaWeblog API.

```php
add_action( 'xmlrpc_call_success_mw_editPost', function( int $post_id, array $args ) {
    // Handle post update
}, 10, 2 );
```

**Since:** 3.4.0

---

### `xmlrpc_call_success_mw_newMediaObject`

Fires after a new attachment has been added via MetaWeblog API.

```php
add_action( 'xmlrpc_call_success_mw_newMediaObject', function( int $attachment_id, array $args ) {
    // Handle new media upload
}, 10, 2 );
```

**Since:** 3.4.0

---

### `pingback_post`

Fires after a post pingback has been sent.

```php
add_action( 'pingback_post', function( int $comment_id ) {
    // Handle pingback registration
});
```

**Since:** 0.71

**Parameters:**
- `$comment_id` (int) - ID of the pingback comment

---

## Back-Compat Filters

### `pre_option_enable_xmlrpc`

Legacy filter from when `enable_xmlrpc` was an option.

```php
add_filter( 'pre_option_enable_xmlrpc', function( $value ) {
    return false; // Disable
});
```

**Since:** 2.3.0 (Deprecated 3.5.0)

**Note:** Use `xmlrpc_enabled` instead.

---

### `option_enable_xmlrpc`

Legacy filter from when `enable_xmlrpc` was an option.

```php
add_filter( 'option_enable_xmlrpc', function( $value ) {
    return true; // Enable
});
```

**Since:** 2.3.0 (Deprecated 3.5.0)

**Note:** Use `xmlrpc_enabled` instead.

---

## Related Filters (External)

### `allow_empty_comment`

Documented in `wp-includes/comment.php`. Used by `wp_newComment()`.

```php
add_filter( 'allow_empty_comment', function( bool $allow, array $comment ): bool {
    return $allow;
}, 10, 2 );
```

### `http_headers_useragent`

Documented in `wp-includes/class-wp-http.php`. Used for pingback verification.

---

## Common Use Cases

### Completely Disable XML-RPC

```php
// Disable authenticated methods
add_filter( 'xmlrpc_enabled', '__return_false' );

// Remove XML-RPC HTTP headers
add_filter( 'wp_headers', function( $headers ) {
    unset( $headers['X-Pingback'] );
    return $headers;
});

// Remove pingback link from head
remove_action( 'wp_head', 'rsd_link' );
```

### Disable Only Pingbacks

```php
add_filter( 'xmlrpc_methods', function( $methods ) {
    unset( $methods['pingback.ping'] );
    unset( $methods['pingback.extensions.getPingbacks'] );
    return $methods;
});
```

### Restrict XML-RPC to Specific IPs

```php
add_filter( 'xmlrpc_enabled', function( $enabled ) {
    $allowed_ips = array( '192.168.1.100', '10.0.0.1' );
    
    if ( ! in_array( $_SERVER['REMOTE_ADDR'], $allowed_ips, true ) ) {
        return false;
    }
    
    return $enabled;
});
```

### Log All XML-RPC Calls

```php
add_action( 'xmlrpc_call', function( $method, $args, $server ) {
    error_log( sprintf(
        '[XML-RPC] Method: %s, User: %s, IP: %s',
        $method,
        isset( $args[1] ) ? $args[1] : 'N/A',
        $_SERVER['REMOTE_ADDR']
    ));
}, 10, 3 );
```

### Add Custom XML-RPC Method

```php
add_filter( 'xmlrpc_methods', function( $methods ) {
    $methods['custom.getStats'] = 'my_custom_get_stats';
    return $methods;
});

function my_custom_get_stats( $args ) {
    global $wp_xmlrpc_server;
    
    $wp_xmlrpc_server->escape( $args );
    
    $username = $args[0];
    $password = $args[1];
    
    $user = $wp_xmlrpc_server->login( $username, $password );
    if ( ! $user ) {
        return $wp_xmlrpc_server->error;
    }
    
    // Check capability
    if ( ! current_user_can( 'manage_options' ) ) {
        return new IXR_Error( 401, 'Permission denied' );
    }
    
    // Return custom data
    return array(
        'posts_count'    => wp_count_posts()->publish,
        'comments_count' => wp_count_comments()->total_comments,
    );
}
```

### Modify Post Data Before Insert

```php
add_filter( 'xmlrpc_wp_insert_post_data', function( $post_data, $content_struct ) {
    // Auto-set post format based on content
    if ( strpos( $post_data['post_content'], '[gallery' ) !== false ) {
        $post_data['post_format'] = 'gallery';
    }
    
    return $post_data;
}, 10, 2 );
```
