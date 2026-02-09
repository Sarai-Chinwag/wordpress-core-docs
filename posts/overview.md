# WordPress Posts Overview

Core documentation for WordPress post/content management system.

## Source Files

- `/wp-includes/post.php` - Core post API (CRUD, meta, statuses)
- `/wp-includes/post-template.php` - Template tags (the_title, the_content, etc.)
- `/wp-includes/post-thumbnail-template.php` - Featured image functions
- `/wp-includes/post-formats.php` - Post format functions
- `/wp-includes/revision.php` - Revision/autosave system

## Post Object (WP_Post)

Every post in WordPress is a `WP_Post` object with these properties:

| Property | Type | Description |
|----------|------|-------------|
| `ID` | int | Post ID |
| `post_author` | int | User ID of author |
| `post_date` | string | Local publication date (Y-m-d H:i:s) |
| `post_date_gmt` | string | GMT publication date |
| `post_content` | string | Full post content |
| `post_title` | string | Post title |
| `post_excerpt` | string | Post excerpt |
| `post_status` | string | Post status (publish, draft, etc.) |
| `post_type` | string | Post type (post, page, custom) |
| `post_name` | string | URL slug |
| `post_parent` | int | Parent post ID (hierarchical types) |
| `post_modified` | string | Last modified date |
| `guid` | string | Global unique identifier |
| `menu_order` | int | Display order |
| `post_mime_type` | string | MIME type (attachments) |
| `comment_count` | int | Number of comments |
| `comment_status` | string | open/closed |
| `ping_status` | string | open/closed |

## Post Statuses

### Built-in Statuses

| Status | Description | Visibility |
|--------|-------------|------------|
| `publish` | Publicly visible | Public |
| `future` | Scheduled for future publication | Protected |
| `draft` | Not published, date floating | Protected |
| `pending` | Awaiting review | Protected |
| `private` | Visible only to logged-in users with permission | Private |
| `trash` | In trash, can be restored | Internal |
| `auto-draft` | Auto-saved draft, no content yet | Internal |
| `inherit` | Used by revisions/attachments | Internal |

### Status Properties

```php
register_post_status( 'custom-status', array(
    'label'                     => 'Custom Status',
    'public'                    => false,      // Shown on frontend
    'internal'                  => false,      // Internal use only
    'protected'                 => false,      // Requires login
    'private'                   => false,      // Private to user
    'publicly_queryable'        => false,      // Can query on frontend
    'exclude_from_search'       => true,       // Exclude from search
    'show_in_admin_all_list'    => true,       // Show in admin list
    'show_in_admin_status_list' => true,       // Show in status dropdown
    'date_floating'             => false,      // Date not fixed
    'label_count'               => _n_noop(...),
) );
```

### Status Functions

```php
// Get status object
$status = get_post_status_object( 'publish' );

// Get all statuses
$statuses = get_post_stati( array( 'public' => true ), 'objects' );

// Check viewability
is_post_status_viewable( 'publish' );  // true
is_post_status_viewable( 'draft' );    // false
```

## Post Formats

Post formats are a theme feature that allows different presentation styles for posts.

### Available Formats

| Format | Description |
|--------|-------------|
| `standard` | Default format (no format set) |
| `aside` | Brief snippet, no title |
| `chat` | Chat transcript |
| `gallery` | Image gallery |
| `link` | Link to another site |
| `image` | Single image |
| `quote` | Quotation |
| `status` | Short status update |
| `video` | Video content |
| `audio` | Audio content |

### Theme Support

```php
// In theme's functions.php
add_theme_support( 'post-formats', array(
    'aside',
    'gallery',
    'quote',
    'image',
    'video',
) );
```

### Format Functions

```php
// Get post format
$format = get_post_format( $post_id );  // Returns 'gallery', 'quote', etc. or false

// Check format
if ( has_post_format( 'video' ) ) { ... }
if ( has_post_format( array( 'video', 'audio' ) ) ) { ... }

// Set format
set_post_format( $post_id, 'gallery' );

// Get format display name
$name = get_post_format_string( 'gallery' );  // 'Gallery'

// Get all format strings
$formats = get_post_format_strings();

// Get format archive link
$url = get_post_format_link( 'video' );
```

## CRUD Operations

### Create

```php
$post_id = wp_insert_post( array(
    'post_title'    => 'My Post Title',
    'post_content'  => 'Post content here...',
    'post_status'   => 'publish',
    'post_author'   => get_current_user_id(),
    'post_type'     => 'post',
    'post_category' => array( 1, 2 ),
    'tags_input'    => array( 'tag1', 'tag2' ),
    'meta_input'    => array(
        'custom_field' => 'value',
    ),
) );
```

### Read

```php
// Single post
$post = get_post( $post_id );
$post = get_post( $post_id, ARRAY_A );  // As array

// Multiple posts
$posts = get_posts( array(
    'numberposts' => 10,
    'post_type'   => 'post',
    'post_status' => 'publish',
) );

// Via WP_Query
$query = new WP_Query( array( 'p' => $post_id ) );
```

### Update

```php
$post_id = wp_update_post( array(
    'ID'           => $post_id,
    'post_title'   => 'Updated Title',
    'post_content' => 'Updated content',
) );
```

### Delete

```php
// Move to trash (default)
wp_trash_post( $post_id );

// Restore from trash
wp_untrash_post( $post_id );

// Permanent delete
wp_delete_post( $post_id, true );  // true = force delete
```

## Post Meta

Post meta stores custom data associated with posts.

```php
// Add
add_post_meta( $post_id, 'key', 'value' );
add_post_meta( $post_id, 'key', 'value', true );  // Unique

// Get
$value = get_post_meta( $post_id, 'key', true );   // Single value
$values = get_post_meta( $post_id, 'key', false ); // All values
$all = get_post_meta( $post_id );                  // All meta

// Update
update_post_meta( $post_id, 'key', 'new_value' );
update_post_meta( $post_id, 'key', 'new', 'old' ); // With prev check

// Delete
delete_post_meta( $post_id, 'key' );
delete_post_meta( $post_id, 'key', 'specific_value' );

// Register (for REST API, etc.)
register_post_meta( 'post', 'my_meta_key', array(
    'show_in_rest' => true,
    'single'       => true,
    'type'         => 'string',
) );
```

## Revisions

Revisions track changes to posts over time.

### Configuration

```php
// In wp-config.php
define( 'WP_POST_REVISIONS', true );   // Unlimited (default)
define( 'WP_POST_REVISIONS', 5 );      // Keep 5 revisions
define( 'WP_POST_REVISIONS', false );  // Disable revisions
```

### Revision Functions

```php
// Get all revisions
$revisions = wp_get_post_revisions( $post_id );

// Get latest revision info
$info = wp_get_latest_revision_id_and_total_count( $post_id );
// Returns: array( 'latest_id' => 123, 'count' => 5 )

// Save a revision manually
$revision_id = wp_save_post_revision( $post_id );

// Restore a revision
wp_restore_post_revision( $revision_id );

// Delete a revision
wp_delete_post_revision( $revision_id );

// Check if post is a revision
$parent_id = wp_is_post_revision( $post );  // Returns parent ID or false

// Get autosave
$autosave = wp_get_post_autosave( $post_id, $user_id );

// Check revisions enabled
if ( wp_revisions_enabled( $post ) ) { ... }

// Get revision limit
$limit = wp_revisions_to_keep( $post );
```

### Revisioned Fields

By default, these fields are tracked:

- `post_title`
- `post_content`
- `post_excerpt`

Custom meta can also be revisioned:

```php
register_post_meta( 'post', 'my_meta', array(
    'revisions_enabled' => true,
) );
```

## Featured Images (Post Thumbnails)

### Theme Support

```php
// Enable for all post types
add_theme_support( 'post-thumbnails' );

// Enable for specific types
add_theme_support( 'post-thumbnails', array( 'post', 'page', 'movie' ) );

// Set custom size
set_post_thumbnail_size( 150, 150, true );  // 150x150, cropped
```

### Thumbnail Functions

```php
// Check if has thumbnail
if ( has_post_thumbnail( $post_id ) ) { ... }

// Get thumbnail ID
$thumb_id = get_post_thumbnail_id( $post_id );

// Display thumbnail
the_post_thumbnail();
the_post_thumbnail( 'large' );
the_post_thumbnail( array( 300, 200 ) );

// Get HTML
$html = get_the_post_thumbnail( $post_id, 'medium', array( 'class' => 'my-class' ) );

// Get URL
$url = get_the_post_thumbnail_url( $post_id, 'full' );

// Get caption
$caption = get_the_post_thumbnail_caption( $post_id );

// Set thumbnail
set_post_thumbnail( $post_id, $attachment_id );

// Remove thumbnail
delete_post_thumbnail( $post_id );
```

## Sticky Posts

Sticky posts appear at the top of archive listings.

```php
// Make sticky
stick_post( $post_id );

// Remove sticky
unstick_post( $post_id );

// Check if sticky
if ( is_sticky( $post_id ) ) { ... }

// Get all sticky post IDs
$stickies = get_option( 'sticky_posts' );
```

## Post Counting

```php
// Count by status
$counts = wp_count_posts( 'post' );
// Returns: stdClass { publish: 50, draft: 10, pending: 3, ... }

// Count attachments by MIME
$counts = wp_count_attachments( 'image' );
```

## Post Visibility

```php
// Check if post type is viewable
is_post_type_viewable( 'post' );

// Check if status is viewable
is_post_status_viewable( 'publish' );

// Check if specific post is publicly viewable
is_post_publicly_viewable( $post_id );

// Check if embeddable
is_post_embeddable( $post_id );
```

## Post Hierarchies

For hierarchical post types (pages):

```php
// Get ancestors
$ancestors = get_post_ancestors( $post_id );

// Get page children
$children = get_children( array( 'post_parent' => $page_id ) );

// Get page URI (path)
$uri = get_page_uri( $page_id );  // 'parent-page/child-page'
```

## Database Table

Posts are stored in `{prefix}_posts` table:

| Column | Type | Description |
|--------|------|-------------|
| ID | bigint(20) | Primary key |
| post_author | bigint(20) | User ID |
| post_date | datetime | Local datetime |
| post_date_gmt | datetime | GMT datetime |
| post_content | longtext | Content |
| post_title | text | Title |
| post_excerpt | text | Excerpt |
| post_status | varchar(20) | Status |
| comment_status | varchar(20) | Comment status |
| ping_status | varchar(20) | Ping status |
| post_password | varchar(255) | Password |
| post_name | varchar(200) | Slug |
| to_ping | text | URLs to ping |
| pinged | text | URLs pinged |
| post_modified | datetime | Modified date |
| post_modified_gmt | datetime | Modified GMT |
| post_content_filtered | longtext | Filtered content |
| post_parent | bigint(20) | Parent post ID |
| guid | varchar(255) | GUID |
| menu_order | int(11) | Order |
| post_type | varchar(20) | Type |
| post_mime_type | varchar(100) | MIME type |
| comment_count | bigint(20) | Comment count |
