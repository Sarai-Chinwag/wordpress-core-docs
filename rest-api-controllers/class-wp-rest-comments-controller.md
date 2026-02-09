# WP_REST_Comments_Controller

Core controller used to access comments via the REST API.

## Class Synopsis

```php
class WP_REST_Comments_Controller extends WP_REST_Controller {
    protected $meta;
    
    public function __construct();
    public function register_routes();
    
    // Permission Checks
    public function get_items_permissions_check( $request );
    public function get_item_permissions_check( $request );
    public function create_item_permissions_check( $request );
    public function update_item_permissions_check( $request );
    public function delete_item_permissions_check( $request );
    
    // CRUD Operations
    public function get_items( $request );
    public function get_item( $request );
    public function create_item( $request );
    public function update_item( $request );
    public function delete_item( $request );
    
    // Data Preparation
    protected function prepare_item_for_database( $request );
    public function prepare_item_for_response( $item, $request );
    protected function prepare_links( $comment );
    
    // Schema & Parameters
    public function get_item_schema();
    public function get_collection_params();
    
    // Utilities
    protected function get_comment( $id );
    protected function normalize_query_param( $query_param );
    protected function prepare_status_response( $comment_approved );
    protected function handle_status_param( $new_status, $comment_id );
    protected function check_read_permission( $comment, $request );
    protected function check_read_post_permission( $post, $request );
    protected function check_edit_permission( $comment );
    protected function check_is_comment_content_allowed( $prepared_comment );
    protected function check_post_type_supports_notes( $post_type );
    public function check_comment_author_email( $value, $request, $param );
}
```

## Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/wp/v2/comments` | List comments |
| POST | `/wp/v2/comments` | Create a comment |
| GET | `/wp/v2/comments/{id}` | Get a single comment |
| POST/PUT/PATCH | `/wp/v2/comments/{id}` | Update a comment |
| DELETE | `/wp/v2/comments/{id}` | Delete a comment |

## Constructor

```php
public function __construct()
```

Sets namespace to `'wp/v2'`, rest_base to `'comments'`, and creates `WP_REST_Comment_Meta_Fields` instance.

## Collection Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `context` | string | 'view' | Scope under which request is made |
| `page` | integer | 1 | Current page |
| `per_page` | integer | 10 | Items per page (max 100) |
| `search` | string | - | Search string |
| `after` | date-time | - | Comments after date |
| `before` | date-time | - | Comments before date |
| `author` | array | - | Filter by author IDs |
| `author_exclude` | array | - | Exclude author IDs |
| `author_email` | string | - | Filter by author email |
| `exclude` | array | [] | Exclude specific IDs |
| `include` | array | [] | Include specific IDs |
| `offset` | integer | - | Offset for pagination |
| `order` | string | 'desc' | Sort order (asc/desc) |
| `orderby` | string | 'date_gmt' | Sort field |
| `parent` | array | - | Filter by parent IDs |
| `parent_exclude` | array | - | Exclude parent IDs |
| `post` | array | - | Filter by post IDs |
| `status` | string | 'approve' | Comment status |
| `type` | string | 'comment' | Comment type |
| `password` | string | - | Post password (for protected posts) |

### Orderby Options

- `date` - Comment date (local)
- `date_gmt` - Comment date (GMT)
- `id` - Comment ID
- `include` - Order by include parameter
- `post` - Post ID
- `parent` - Parent comment ID
- `type` - Comment type

### Status Values

- `approve` / `approved` - Approved comments
- `hold` - Pending/unapproved comments
- `spam` - Spam comments
- `trash` - Trashed comments
- `all` - All comments (requires capability)

## Schema Properties

| Property | Type | Context | Description |
|----------|------|---------|-------------|
| `id` | integer | view, edit, embed | Comment ID (readonly) |
| `author` | integer | view, edit, embed | Author user ID (0 if guest) |
| `author_email` | string (email) | edit | Author email |
| `author_ip` | string (ip) | edit | Author IP address |
| `author_name` | string | view, edit, embed | Author display name |
| `author_url` | string (uri) | view, edit, embed | Author URL |
| `author_user_agent` | string | edit | Author user agent |
| `content` | object | view, edit, embed | Comment content (raw/rendered) |
| `date` | string (date-time) | view, edit, embed | Date (site timezone) |
| `date_gmt` | string (date-time) | view, edit | Date (GMT) |
| `link` | string (uri) | view, edit, embed | Comment permalink (readonly) |
| `parent` | integer | view, edit, embed | Parent comment ID (default: 0) |
| `post` | integer | view, edit | Associated post ID (default: 0) |
| `status` | string | view, edit | Comment status |
| `type` | string | view, edit, embed | Comment type (readonly) |
| `author_avatar_urls` | object | view, edit, embed | Avatar URLs (readonly) |
| `meta` | object | view, edit | Comment meta |

## Permission Checks

### get_items_permissions_check()
- Validates read permission for specified posts
- Requires `moderate_comments` for comments without posts
- Requires `edit_posts` for protected parameters:
  - `author`, `author_exclude`, `author_email`
  - `type` (when not 'comment')
  - `status` (when not 'approve')
- Special handling for `note` type comments

### get_item_permissions_check()
- Validates comment exists
- Requires `moderate_comments` for `edit` context (or `edit_comment` for notes)
- Calls `check_read_permission()` and `check_read_post_permission()`

### create_item_permissions_check()
- Requires login if `comment_registration` is enabled
- Notes always require login
- Anonymous comments require `rest_allow_anonymous_comments` filter
- Validates `author`, `author_ip`, `status` settings require appropriate capabilities
- Validates post exists and is not draft/trash
- Validates comments are open for the post

### update_item_permissions_check()
- Requires `edit_comment` capability (via `check_edit_permission()`)

### delete_item_permissions_check()
- Requires `edit_comment` capability

## Comment Types

The controller supports two comment types:

### Regular Comments (`comment`)
- Standard user comments on posts
- Subject to comment moderation, flood control, and duplicate checking
- Anonymous submission possible if allowed

### Notes (`note`)
- Internal editorial notes (since WordPress 6.x)
- Requires authentication
- Not subject to moderation/flood control
- Requires post type support (`'note'` comment type)

## Key Methods

### get_comment()
```php
protected function get_comment( int $id ): WP_Comment|WP_Error
```
Gets the comment if ID is valid. Also validates the associated post exists.

### check_read_permission()
```php
protected function check_read_permission( WP_Comment $comment, WP_REST_Request $request ): bool
```
Checks if a comment can be read. Validates comment status and post visibility.

### check_edit_permission()
```php
protected function check_edit_permission( WP_Comment $comment ): bool
```
Checks if the user can edit a comment. Uses `edit_comment` capability.

### check_is_comment_content_allowed()
```php
protected function check_is_comment_content_allowed( array $prepared_comment ): bool
```
Validates that the comment content meets requirements (not empty for regular comments, may include note status for notes).

### prepare_status_response()
```php
protected function prepare_status_response( string $comment_approved ): string
```
Converts database status values to API status strings:
- `'hold'` / `'0'` → `'hold'`
- `'approve'` / `'1'` → `'approved'`
- `'spam'` → `'spam'`
- `'trash'` → `'trash'`

### handle_status_param()
```php
protected function handle_status_param( string $new_status, int $comment_id ): bool
```
Updates comment status using `wp_set_comment_status()`.

### normalize_query_param()
```php
protected function normalize_query_param( string $query_param ): string
```
Maps API parameter names to `WP_Comment_Query` parameter names.

## Response Links

| Relation | Description |
|----------|-------------|
| `self` | Link to this comment |
| `collection` | Link to comments collection |
| `author` | Link to author user (embeddable, if logged in) |
| `up` | Link to parent post (embeddable) |
| `in-reply-to` | Link to parent comment (embeddable) |
| `children` | Link to child comments (embeddable) |

## Deletion Behavior

### DELETE /wp/v2/comments/{id}

**Parameters:**
- `force` - If `true`, permanently delete. If `false`, move to trash.
- `password` - Post password if the parent post is protected

**Trash Support:**
Controlled by `EMPTY_TRASH_DAYS` constant and `rest_comment_trashable` filter.

**Response:**
```json
// With force=true
{
    "deleted": true,
    "previous": { ... }
}

// With force=false (trashed)
{
    "id": 123,
    "status": "trash",
    ...
}
```

## Avatar URLs

If avatars are enabled, includes avatar URLs at multiple sizes:

```json
{
    "author_avatar_urls": {
        "24": "https://secure.gravatar.com/avatar/...?s=24",
        "48": "https://secure.gravatar.com/avatar/...?s=48",
        "96": "https://secure.gravatar.com/avatar/...?s=96"
    }
}
```

## Usage Example

```php
// Get comments for a specific post
$request = new WP_REST_Request( 'GET', '/wp/v2/comments' );
$request->set_param( 'post', 123 );
$request->set_param( 'per_page', 20 );
$request->set_param( 'orderby', 'date' );
$request->set_param( 'order', 'asc' );

$controller = new WP_REST_Comments_Controller();
$response = $controller->get_items( $request );

// Create a comment
$request = new WP_REST_Request( 'POST', '/wp/v2/comments' );
$request->set_param( 'post', 123 );
$request->set_param( 'content', 'Great article!' );
$request->set_param( 'author_name', 'John Doe' );
$request->set_param( 'author_email', 'john@example.com' );

$response = $controller->create_item( $request );

// Reply to a comment
$request = new WP_REST_Request( 'POST', '/wp/v2/comments' );
$request->set_param( 'post', 123 );
$request->set_param( 'parent', 456 ); // Parent comment ID
$request->set_param( 'content', 'I agree!' );

$response = $controller->create_item( $request );

// Update comment status (moderate)
$request = new WP_REST_Request( 'POST', '/wp/v2/comments/123' );
$request->set_param( 'status', 'approved' );

$response = $controller->update_item( $request );
```

## Anonymous Comments

By default, anonymous comment creation via REST API is disabled. Enable with:

```php
add_filter( 'rest_allow_anonymous_comments', function( $allow, $request ) {
    return true;
}, 10, 2 );
```

## Source

`wp-includes/rest-api/endpoints/class-wp-rest-comments-controller.php`

## Since

WordPress 4.7.0

## Changelog

| Version | Description |
|---------|-------------|
| 4.7.0 | Introduced |
| 4.8.0 | `rest_pre_insert_comment` can return `WP_Error` |
| 5.0.0 | Added `rest_after_insert_comment` action |
