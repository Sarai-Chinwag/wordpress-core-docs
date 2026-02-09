# WordPress Post Functions Reference

Complete reference of all WordPress post/content functions.

## CRUD Functions

### get_post()

Retrieves post data given a post ID or post object.

```php
get_post( $post = null, $output = OBJECT, $filter = 'raw' )
```

**Parameters:**
- `$post` (int|WP_Post|null) - Post ID or object. Default global `$post`.
- `$output` (string) - OBJECT, ARRAY_A, or ARRAY_N
- `$filter` (string) - 'raw', 'edit', 'db', 'display'

**Returns:** WP_Post|array|null

```php
// Get as object
$post = get_post( 123 );

// Get as array
$post = get_post( 123, ARRAY_A );

// Get current post in loop
$post = get_post();
```

---

### get_posts()

Retrieves an array of posts matching given criteria.

```php
get_posts( $args = null )
```

**Parameters:**
- `$numberposts` (int) - Total posts to retrieve. Default 5. Use -1 for all.
- `$category` (int|string) - Category ID or comma-separated IDs
- `$include` (int[]) - Post IDs to include
- `$exclude` (int[]) - Post IDs to exclude
- `$orderby` (string) - Field to order by. Default 'date'
- `$order` (string) - ASC or DESC. Default DESC
- `$post_type` (string) - Post type. Default 'post'
- `$post_status` (string) - Status. Default 'publish'
- `$suppress_filters` (bool) - Default true
- Plus all WP_Query arguments

**Returns:** WP_Post[]|int[]

```php
// Recent 10 posts
$posts = get_posts( array(
    'numberposts' => 10,
    'post_type'   => 'post',
) );

// Posts from category
$posts = get_posts( array(
    'category' => 5,
    'orderby'  => 'title',
    'order'    => 'ASC',
) );

// Specific posts
$posts = get_posts( array(
    'include' => array( 1, 2, 3 ),
) );

// All posts of custom type
$posts = get_posts( array(
    'post_type'   => 'movie',
    'numberposts' => -1,
) );
```

---

### wp_insert_post()

Inserts or updates a post.

```php
wp_insert_post( $postarr, $wp_error = false, $fire_after_hooks = true )
```

**Parameters ($postarr):**
- `$ID` (int) - Post ID. If set, updates existing post.
- `$post_author` (int) - Author ID. Default current user.
- `$post_date` (string) - Post date. Default current time.
- `$post_date_gmt` (string) - GMT date.
- `$post_content` (string) - Content. Default empty.
- `$post_title` (string) - Title. Default empty.
- `$post_excerpt` (string) - Excerpt. Default empty.
- `$post_status` (string) - Status. Default 'draft'.
- `$post_type` (string) - Type. Default 'post'.
- `$comment_status` (string) - 'open' or 'closed'.
- `$ping_status` (string) - 'open' or 'closed'.
- `$post_password` (string) - Password.
- `$post_name` (string) - Slug.
- `$post_parent` (int) - Parent post ID.
- `$menu_order` (int) - Order.
- `$post_category` (int[]) - Category IDs.
- `$tags_input` (array) - Tags.
- `$tax_input` (array) - Taxonomy terms.
- `$meta_input` (array) - Post meta.
- `$page_template` (string) - Template file.
- `$import_id` (int) - Force specific ID.

**Returns:** int|WP_Error - Post ID on success, 0 or WP_Error on failure.

```php
// Create new post
$post_id = wp_insert_post( array(
    'post_title'    => 'My New Post',
    'post_content'  => 'This is the content.',
    'post_status'   => 'publish',
    'post_author'   => 1,
    'post_category' => array( 1, 2 ),
    'tags_input'    => array( 'tag1', 'tag2' ),
    'meta_input'    => array(
        '_custom_field' => 'value',
    ),
) );

// With error handling
$result = wp_insert_post( $postarr, true );
if ( is_wp_error( $result ) ) {
    echo $result->get_error_message();
}
```

---

### wp_update_post()

Updates an existing post.

```php
wp_update_post( $postarr = array(), $wp_error = false, $fire_after_hooks = true )
```

**Parameters:**
- `$postarr` (array|object) - Post data with 'ID' key required
- `$wp_error` (bool) - Return WP_Error on failure
- `$fire_after_hooks` (bool) - Fire after insert hooks

**Returns:** int|WP_Error

```php
// Update title and content
wp_update_post( array(
    'ID'           => 123,
    'post_title'   => 'Updated Title',
    'post_content' => 'Updated content',
) );

// Update status
wp_update_post( array(
    'ID'          => 123,
    'post_status' => 'draft',
) );
```

---

### wp_delete_post()

Trashes or permanently deletes a post.

```php
wp_delete_post( $post_id = 0, $force_delete = false )
```

**Parameters:**
- `$post_id` (int) - Post ID
- `$force_delete` (bool) - Skip trash, delete permanently

**Returns:** WP_Post|false|null - Post data on success, false/null on failure

```php
// Move to trash
wp_delete_post( 123 );

// Permanently delete
wp_delete_post( 123, true );
```

---

### wp_trash_post()

Moves a post to trash.

```php
wp_trash_post( $post_id = 0 )
```

**Returns:** WP_Post|false|null

```php
wp_trash_post( 123 );
```

---

### wp_untrash_post()

Restores a post from trash.

```php
wp_untrash_post( $post_id = 0 )
```

**Returns:** WP_Post|false|null

Post is restored to 'draft' status by default (since 5.6.0).

---

### wp_publish_post()

Publishes a post by transitioning status.

```php
wp_publish_post( $post )
```

**Parameters:**
- `$post` (int|WP_Post) - Post ID or object

---

## Post Field Functions

### get_post_field()

Retrieves data from a specific post field.

```php
get_post_field( $field, $post = null, $context = 'display' )
```

**Parameters:**
- `$field` (string) - Field name (post_title, post_content, etc.)
- `$post` (int|WP_Post) - Post ID or object
- `$context` (string) - 'raw', 'edit', 'db', 'display'

**Returns:** mixed

```php
$title = get_post_field( 'post_title', 123 );
$status = get_post_field( 'post_status', 123 );
$content = get_post_field( 'post_content', 123, 'raw' );
```

---

### get_post_status()

Retrieves the post status.

```php
get_post_status( $post = null )
```

**Returns:** string|false

```php
$status = get_post_status( 123 );  // 'publish', 'draft', etc.
```

---

### get_post_type()

Retrieves the post type.

```php
get_post_type( $post = null )
```

**Returns:** string|false

```php
$type = get_post_type( 123 );  // 'post', 'page', 'movie', etc.
```

---

### get_post_mime_type()

Retrieves the MIME type of an attachment.

```php
get_post_mime_type( $post = null )
```

**Returns:** string|false

```php
$mime = get_post_mime_type( $attachment_id );  // 'image/jpeg'
```

---

### get_post_ancestors()

Retrieves ancestor post IDs (for hierarchical types).

```php
get_post_ancestors( $post )
```

**Returns:** int[] - Array of ancestor IDs (immediate parent first)

```php
$ancestors = get_post_ancestors( $page_id );
// Returns: array( 123, 456, 789 ) where 123 is direct parent
```

---

## Template Tags

### the_ID()

Displays the post ID in the loop.

```php
the_ID()
```

---

### get_the_ID()

Retrieves the post ID in the loop.

```php
get_the_ID()
```

**Returns:** int|false

---

### the_title()

Displays the post title.

```php
the_title( $before = '', $after = '', $display = true )
```

**Parameters:**
- `$before` (string) - Markup before title
- `$after` (string) - Markup after title
- `$display` (bool) - Echo or return

```php
the_title();
the_title( '<h1>', '</h1>' );
$title = the_title( '', '', false );  // Return instead of echo
```

---

### get_the_title()

Retrieves the post title.

```php
get_the_title( $post = 0 )
```

**Returns:** string

```php
$title = get_the_title( 123 );
```

Note: For protected posts, returns "Protected: {title}". For private posts, returns "Private: {title}".

---

### the_title_attribute()

Displays sanitized title for use in attributes.

```php
the_title_attribute( $args = '' )
```

**Parameters:**
- `$before` (string)
- `$after` (string)
- `$echo` (bool)
- `$post` (WP_Post)

```php
<a href="..." title="<?php the_title_attribute(); ?>">Link</a>
```

---

### the_content()

Displays the post content.

```php
the_content( $more_link_text = null, $strip_teaser = false )
```

**Parameters:**
- `$more_link_text` (string) - Text for "more" link
- `$strip_teaser` (bool) - Strip teaser content

```php
the_content();
the_content( 'Continue reading &rarr;' );
```

---

### get_the_content()

Retrieves the post content.

```php
get_the_content( $more_link_text = null, $strip_teaser = false, $post = null )
```

**Returns:** string

---

### the_excerpt()

Displays the post excerpt.

```php
the_excerpt()
```

---

### get_the_excerpt()

Retrieves the post excerpt.

```php
get_the_excerpt( $post = null )
```

**Returns:** string

---

### has_excerpt()

Checks if post has a custom excerpt.

```php
has_excerpt( $post = 0 )
```

**Returns:** bool

---

### the_guid()

Displays the post GUID.

```php
the_guid( $post = 0 )
```

---

### get_the_guid()

Retrieves the post GUID.

```php
get_the_guid( $post = 0 )
```

**Returns:** string

---

### post_class()

Displays class attribute for post container.

```php
post_class( $css_class = '', $post = null )
```

```php
<article <?php post_class(); ?>>
<article <?php post_class( 'featured' ); ?>>
<article <?php post_class( array( 'class1', 'class2' ) ); ?>>
```

---

### get_post_class()

Retrieves array of post class names.

```php
get_post_class( $css_class = '', $post = null )
```

**Returns:** string[]

Classes include: `post-{ID}`, `{post_type}`, `type-{post_type}`, `status-{status}`, `format-{format}`, `has-post-thumbnail`, `sticky`, `hentry`, `category-{slug}`, `tag-{slug}`

---

### body_class()

Displays class attribute for body element.

```php
body_class( $css_class = '' )
```

```php
<body <?php body_class(); ?>>
```

---

### get_body_class()

Retrieves array of body class names.

```php
get_body_class( $css_class = '' )
```

**Returns:** string[]

---

## Post Meta Functions

### add_post_meta()

Adds a meta field to a post.

```php
add_post_meta( $post_id, $meta_key, $meta_value, $unique = false )
```

**Parameters:**
- `$post_id` (int)
- `$meta_key` (string)
- `$meta_value` (mixed) - Serialized if non-scalar
- `$unique` (bool) - Prevent duplicates

**Returns:** int|false - Meta ID or false

```php
add_post_meta( 123, 'views', 0, true );
add_post_meta( 123, 'gallery_images', array( 1, 2, 3 ) );
```

---

### get_post_meta()

Retrieves post meta value(s).

```php
get_post_meta( $post_id, $key = '', $single = false )
```

**Parameters:**
- `$post_id` (int)
- `$key` (string) - Meta key. Empty = all meta.
- `$single` (bool) - Return single value or array

**Returns:** mixed

```php
// Single value
$views = get_post_meta( 123, 'views', true );

// All values for key
$all_views = get_post_meta( 123, 'views', false );

// All post meta
$all_meta = get_post_meta( 123 );
```

---

### update_post_meta()

Updates a post meta field.

```php
update_post_meta( $post_id, $meta_key, $meta_value, $prev_value = '' )
```

**Returns:** int|bool - Meta ID if new, true if updated, false on failure

```php
update_post_meta( 123, 'views', 100 );

// Only update if current value matches
update_post_meta( 123, 'views', 100, 50 );
```

---

### delete_post_meta()

Deletes a post meta field.

```php
delete_post_meta( $post_id, $meta_key, $meta_value = '' )
```

**Returns:** bool

```php
// Delete all with key
delete_post_meta( 123, 'views' );

// Delete specific value
delete_post_meta( 123, 'gallery_images', array( 1, 2 ) );
```

---

### delete_post_meta_by_key()

Deletes all post meta with given key across all posts.

```php
delete_post_meta_by_key( $post_meta_key )
```

**Returns:** bool

---

### register_post_meta()

Registers a meta key for a post type.

```php
register_post_meta( $post_type, $meta_key, $args )
```

**Parameters ($args):**
- `$type` (string) - 'string', 'boolean', 'integer', 'number', 'array', 'object'
- `$description` (string)
- `$single` (bool)
- `$default` (mixed)
- `$sanitize_callback` (callable)
- `$auth_callback` (callable)
- `$show_in_rest` (bool|array)
- `$revisions_enabled` (bool)

```php
register_post_meta( 'post', 'my_meta', array(
    'type'              => 'string',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'sanitize_text_field',
    'auth_callback'     => function() {
        return current_user_can( 'edit_posts' );
    },
) );
```

---

### get_post_custom()

Retrieves all post meta for a post.

```php
get_post_custom( $post_id = 0 )
```

**Returns:** array

---

### get_post_custom_keys()

Retrieves meta field names for a post.

```php
get_post_custom_keys( $post_id = 0 )
```

**Returns:** array|void

---

### get_post_custom_values()

Retrieves values for a specific meta key.

```php
get_post_custom_values( $key = '', $post_id = 0 )
```

**Returns:** array|null

---

## Featured Image Functions

### has_post_thumbnail()

Checks if post has a featured image.

```php
has_post_thumbnail( $post = null )
```

**Returns:** bool

---

### get_post_thumbnail_id()

Retrieves the featured image attachment ID.

```php
get_post_thumbnail_id( $post = null )
```

**Returns:** int|false

---

### the_post_thumbnail()

Displays the featured image.

```php
the_post_thumbnail( $size = 'post-thumbnail', $attr = '' )
```

**Parameters:**
- `$size` (string|int[]) - Size name or array( width, height )
- `$attr` (string|array) - HTML attributes

```php
the_post_thumbnail();
the_post_thumbnail( 'large' );
the_post_thumbnail( 'full', array( 'class' => 'featured-img' ) );
the_post_thumbnail( array( 300, 200 ) );
```

---

### get_the_post_thumbnail()

Retrieves the featured image HTML.

```php
get_the_post_thumbnail( $post = null, $size = 'post-thumbnail', $attr = '' )
```

**Returns:** string

---

### get_the_post_thumbnail_url()

Retrieves the featured image URL.

```php
get_the_post_thumbnail_url( $post = null, $size = 'post-thumbnail' )
```

**Returns:** string|false

---

### the_post_thumbnail_url()

Displays the featured image URL.

```php
the_post_thumbnail_url( $size = 'post-thumbnail' )
```

---

### get_the_post_thumbnail_caption()

Retrieves the featured image caption.

```php
get_the_post_thumbnail_caption( $post = null )
```

**Returns:** string

---

### set_post_thumbnail()

Sets the featured image for a post.

```php
set_post_thumbnail( $post, $thumbnail_id )
```

**Returns:** int|bool

---

### delete_post_thumbnail()

Removes the featured image.

```php
delete_post_thumbnail( $post )
```

**Returns:** bool

---

### update_post_thumbnail_cache()

Primes the cache for post thumbnails in a query.

```php
update_post_thumbnail_cache( $wp_query = null )
```

---

## Post Format Functions

### get_post_format()

Retrieves the format slug for a post.

```php
get_post_format( $post = null )
```

**Returns:** string|false

```php
$format = get_post_format( $post_id );  // 'gallery', 'video', etc.
```

---

### has_post_format()

Checks if post has specified format(s).

```php
has_post_format( $format = array(), $post = null )
```

**Returns:** bool

```php
if ( has_post_format( 'video' ) ) { ... }
if ( has_post_format( array( 'video', 'audio' ) ) ) { ... }
```

---

### set_post_format()

Assigns a format to a post.

```php
set_post_format( $post, $format )
```

**Returns:** array|WP_Error|false

```php
set_post_format( 123, 'gallery' );
set_post_format( 123, '' );  // Remove format (set to standard)
```

---

### get_post_format_strings()

Returns format slugs with display names.

```php
get_post_format_strings()
```

**Returns:** string[]

```php
$formats = get_post_format_strings();
// array( 'standard' => 'Standard', 'aside' => 'Aside', ... )
```

---

### get_post_format_slugs()

Retrieves array of format slugs.

```php
get_post_format_slugs()
```

**Returns:** string[]

---

### get_post_format_string()

Returns display name for a format.

```php
get_post_format_string( $slug )
```

**Returns:** string

```php
$name = get_post_format_string( 'gallery' );  // 'Gallery'
```

---

### get_post_format_link()

Returns URL to post format archive.

```php
get_post_format_link( $format )
```

**Returns:** string|WP_Error|false

---

## Revision Functions

### wp_save_post_revision()

Creates a revision for current post version.

```php
wp_save_post_revision( $post_id )
```

**Returns:** int|WP_Error|void

---

### wp_get_post_revisions()

Retrieves all revisions of a post.

```php
wp_get_post_revisions( $post = 0, $args = null )
```

**Parameters ($args):**
- `$order` (string) - 'DESC' (default) or 'ASC'
- `$orderby` (string) - Default 'date ID'
- `$check_enabled` (bool) - Check if revisions enabled. Default true.

**Returns:** WP_Post[]|int[]

---

### wp_get_latest_revision_id_and_total_count()

Returns latest revision ID and count.

```php
wp_get_latest_revision_id_and_total_count( $post = 0 )
```

**Returns:** array|WP_Error

```php
$info = wp_get_latest_revision_id_and_total_count( 123 );
// array( 'latest_id' => 456, 'count' => 5 )
```

---

### wp_get_post_autosave()

Retrieves autosaved data for a post.

```php
wp_get_post_autosave( $post_id, $user_id = 0 )
```

**Returns:** WP_Post|false

---

### wp_get_post_revision()

Gets a specific revision.

```php
wp_get_post_revision( &$post, $output = OBJECT, $filter = 'raw' )
```

**Returns:** WP_Post|array|null

---

### wp_is_post_revision()

Checks if post is a revision.

```php
wp_is_post_revision( $post )
```

**Returns:** int|false - Parent post ID or false

---

### wp_is_post_autosave()

Checks if post is an autosave.

```php
wp_is_post_autosave( $post )
```

**Returns:** int|false - Parent post ID or false

---

### wp_restore_post_revision()

Restores a post to specified revision.

```php
wp_restore_post_revision( $revision, $fields = null )
```

**Returns:** int|false|null - Post ID on success

---

### wp_delete_post_revision()

Deletes a revision.

```php
wp_delete_post_revision( $revision )
```

**Returns:** WP_Post|false|null

---

### wp_revisions_enabled()

Checks if revisions are enabled for a post.

```php
wp_revisions_enabled( $post )
```

**Returns:** bool

---

### wp_revisions_to_keep()

Gets number of revisions to retain.

```php
wp_revisions_to_keep( $post )
```

**Returns:** int - -1 for unlimited, 0 for disabled

---

### wp_get_post_revisions_url()

Gets URL for viewing/restoring revisions.

```php
wp_get_post_revisions_url( $post = 0 )
```

**Returns:** string|null

---

## Taxonomy Functions (Post-related)

### wp_get_post_categories()

Retrieves categories for a post.

```php
wp_get_post_categories( $post_id = 0, $args = array() )
```

**Returns:** array|WP_Error

```php
$cats = wp_get_post_categories( 123 );  // Array of IDs
$cats = wp_get_post_categories( 123, array( 'fields' => 'all' ) );  // Term objects
```

---

### wp_get_post_tags()

Retrieves tags for a post.

```php
wp_get_post_tags( $post_id = 0, $args = array() )
```

**Returns:** array|WP_Error

---

### wp_get_post_terms()

Retrieves terms for a post from any taxonomy.

```php
wp_get_post_terms( $post_id = 0, $taxonomy = 'post_tag', $args = array() )
```

**Returns:** array|WP_Error

```php
$terms = wp_get_post_terms( 123, 'genre' );
```

---

### wp_set_post_categories()

Sets categories for a post.

```php
wp_set_post_categories( $post_id = 0, $post_categories = array(), $append = false )
```

---

### wp_set_post_tags()

Sets tags for a post.

```php
wp_set_post_tags( $post_id = 0, $tags = '', $append = false )
```

---

### wp_set_post_terms()

Sets terms for a post.

```php
wp_set_post_terms( $post_id = 0, $terms = '', $taxonomy = 'post_tag', $append = false )
```

---

## Sticky Post Functions

### stick_post()

Makes a post sticky.

```php
stick_post( $post_id )
```

---

### unstick_post()

Removes sticky status.

```php
unstick_post( $post_id )
```

---

### is_sticky()

Checks if post is sticky.

```php
is_sticky( $post_id = 0 )
```

**Returns:** bool

---

## Post Status Functions

### get_post_status_object()

Retrieves a post status object.

```php
get_post_status_object( $post_status )
```

**Returns:** stdClass|null

---

### get_post_stati()

Gets list of post statuses.

```php
get_post_stati( $args = array(), $output = 'names', $operator = 'and' )
```

**Returns:** string[]|stdClass[]

```php
$public_statuses = get_post_stati( array( 'public' => true ) );
```

---

### get_post_statuses()

Gets array of status labels.

```php
get_post_statuses()
```

**Returns:** string[] - array( 'draft' => 'Draft', ... )

---

### register_post_status()

Registers a custom post status.

```php
register_post_status( $post_status, $args = array() )
```

---

### is_post_status_viewable()

Checks if status is viewable.

```php
is_post_status_viewable( $post_status )
```

**Returns:** bool

---

## Counting Functions

### wp_count_posts()

Counts posts by status.

```php
wp_count_posts( $type = 'post', $perm = '' )
```

**Returns:** stdClass

```php
$counts = wp_count_posts();
echo $counts->publish;  // 50
echo $counts->draft;    // 10
```

---

### wp_count_attachments()

Counts attachments by MIME type.

```php
wp_count_attachments( $mime_type = '' )
```

**Returns:** stdClass

```php
$counts = wp_count_attachments( 'image' );
```

---

## Utility Functions

### sanitize_post()

Sanitizes all post fields.

```php
sanitize_post( $post, $context = 'display' )
```

---

### sanitize_post_field()

Sanitizes a specific post field.

```php
sanitize_post_field( $field, $value, $post_id, $context = 'display' )
```

---

### wp_unique_post_slug()

Generates a unique post slug.

```php
wp_unique_post_slug( $slug, $post_id, $post_status, $post_type, $post_parent )
```

**Returns:** string

---

### wp_resolve_post_date()

Validates and returns a post date.

```php
wp_resolve_post_date( $post_date = '', $post_date_gmt = '' )
```

**Returns:** string|false

---

### get_extended()

Gets content before/after `<!--more-->`.

```php
get_extended( $post )
```

**Returns:** array - array( 'main', 'extended', 'more_text' )

```php
$parts = get_extended( $post->post_content );
echo $parts['main'];      // Before <!--more-->
echo $parts['extended'];  // After <!--more-->
```

---

### post_password_required()

Checks if post requires password.

```php
post_password_required( $post = null )
```

**Returns:** bool

---

### get_the_password_form()

Gets the password form HTML.

```php
get_the_password_form( $post = 0 )
```

**Returns:** string

---

### wp_get_recent_posts()

Retrieves recent posts.

```php
wp_get_recent_posts( $args = array(), $output = ARRAY_A )
```

**Returns:** array|false

---

### clean_post_cache()

Clears all caches for a post.

```php
clean_post_cache( $post )
```

---

### update_post_cache()

Updates post cache from array of posts.

```php
update_post_cache( &$posts )
```

---

## Pagination Functions

### wp_link_pages()

Displays pagination for multi-page posts.

```php
wp_link_pages( $args = '' )
```

**Parameters:**
- `$before` (string) - HTML before links
- `$after` (string) - HTML after links
- `$link_before` (string) - HTML before each link
- `$link_after` (string) - HTML after each link
- `$next_or_number` (string) - 'number' or 'next'
- `$separator` (string) - Between links
- `$nextpagelink` (string) - Next page text
- `$previouspagelink` (string) - Previous page text
- `$pagelink` (string) - Format ('%' = page number)
- `$echo` (bool)

```php
wp_link_pages( array(
    'before' => '<nav class="page-links">Pages: ',
    'after'  => '</nav>',
) );
```

---

## Page Functions

### wp_dropdown_pages()

Displays dropdown of pages.

```php
wp_dropdown_pages( $args = '' )
```

---

### wp_list_pages()

Displays list of pages.

```php
wp_list_pages( $args = '' )
```

---

### get_pages()

Retrieves array of pages.

```php
get_pages( $args = array() )
```

---

### get_page_by_path()

Gets page by path/slug.

```php
get_page_by_path( $page_path, $output = OBJECT, $post_type = 'page' )
```

---

### get_page_by_title()

Gets page by title (deprecated 6.2.0).

```php
get_page_by_title( $page_title, $output = OBJECT, $post_type = 'page' )
```

**Use instead:**
```php
$page = get_posts( array(
    'post_type'              => 'page',
    'title'                  => $title,
    'posts_per_page'         => 1,
    'update_post_term_cache' => false,
    'update_post_meta_cache' => false,
) );
```

---

### get_page_uri()

Gets URI path for a page.

```php
get_page_uri( $page = 0 )
```

**Returns:** string - 'parent-slug/page-slug'

---

### get_page_template_slug()

Gets template slug assigned to page.

```php
get_page_template_slug( $post = null )
```

**Returns:** string|false

---

## Attachment Functions (in post.php)

### get_attached_file()

Gets file path for attachment.

```php
get_attached_file( $attachment_id, $unfiltered = false )
```

---

### update_attached_file()

Updates file path for attachment.

```php
update_attached_file( $attachment_id, $file )
```

---

### get_children()

Retrieves child posts/attachments.

```php
get_children( $args = '', $output = OBJECT )
```

```php
$attachments = get_children( array(
    'post_parent' => $post_id,
    'post_type'   => 'attachment',
    'post_mime_type' => 'image',
) );
```
