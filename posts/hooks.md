# WordPress Post Hooks Reference

Complete reference of hooks related to posts, content, revisions, and featured images.

## Post CRUD Hooks

### Insertion Hooks (Create)

#### pre_post_insert
Fires immediately before a new post is inserted.

```php
do_action( 'pre_post_insert', $data );
```
- `$data` (array) - Unslashed post data

*Since: 6.9.0*

---

#### wp_insert_post_empty_content
Filters whether the post should be considered empty.

```php
apply_filters( 'wp_insert_post_empty_content', $maybe_empty, $postarr );
```
- `$maybe_empty` (bool) - Whether post is empty
- `$postarr` (array) - Post data

Return `true` to prevent insertion.

---

#### wp_insert_post_parent
Filters the post parent (for hierarchy loop prevention).

```php
apply_filters( 'wp_insert_post_parent', $post_parent, $post_id, $new_postarr, $postarr );
```

---

#### wp_insert_post_data
Filters slashed post data before database insertion.

```php
apply_filters( 'wp_insert_post_data', $data, $postarr, $unsanitized_postarr, $update );
```
- `$data` (array) - Slashed, sanitized, processed post data
- `$postarr` (array) - Sanitized but unprocessed post data
- `$unsanitized_postarr` (array) - Original unsanitized data
- `$update` (bool) - Whether updating existing post

---

#### wp_insert_attachment_data
Same as above, but for attachments.

```php
apply_filters( 'wp_insert_attachment_data', $data, $postarr, $unsanitized_postarr, $update );
```

---

#### wp_insert_post
Fires after a post is saved (create or update).

```php
do_action( 'wp_insert_post', $post_id, $post, $update );
```
- `$post_id` (int)
- `$post` (WP_Post)
- `$update` (bool)

---

#### save_post_{$post_type}
Fires after a post of specific type is saved.

```php
do_action( "save_post_{$post->post_type}", $post_id, $post, $update );
```

Examples: `save_post_post`, `save_post_page`, `save_post_movie`

---

#### save_post
Fires after any post is saved.

```php
do_action( 'save_post', $post_id, $post, $update );
```

**Note:** This fires for ALL post types including revisions. Check `$update` and post type if needed.

---

#### wp_after_insert_post
Fires after a post is fully inserted/updated, including terms and meta.

```php
do_action( 'wp_after_insert_post', $post, $update, $post_before );
```
- `$post` (WP_Post) - Post object after changes
- `$update` (bool)
- `$post_before` (WP_Post|null) - Post before changes (null if new)

*Since: 5.6.0* - Preferred over `save_post` for most uses.

---

### Update Hooks

#### pre_post_update
Fires before a post is updated.

```php
do_action( 'pre_post_update', $post_id, $data );
```
- `$post_id` (int)
- `$data` (array) - Unslashed post data

---

#### edit_post_{$post_type}
Fires after a specific post type is updated.

```php
do_action( "edit_post_{$post->post_type}", $post_id, $post );
```

---

#### edit_post
Fires after any post is updated.

```php
do_action( 'edit_post', $post_id, $post );
```

---

#### post_updated
Fires after a post is updated (with before/after comparison).

```php
do_action( 'post_updated', $post_id, $post_after, $post_before );
```

---

### Delete Hooks

#### pre_delete_post
Filters whether to proceed with deletion.

```php
apply_filters( 'pre_delete_post', $check, $post, $force_delete );
```

Return non-null to short-circuit.

---

#### before_delete_post
Fires before a post is deleted.

```php
do_action( 'before_delete_post', $post_id, $post );
```

---

#### delete_post_{$post_type}
Fires before a specific post type is deleted.

```php
do_action( "delete_post_{$post->post_type}", $post_id, $post );
```

---

#### delete_post
Fires just before the post is deleted from database.

```php
do_action( 'delete_post', $post_id, $post );
```

---

#### deleted_post_{$post_type}
Fires after a specific post type is deleted.

```php
do_action( "deleted_post_{$post->post_type}", $post_id, $post );
```

---

#### deleted_post
Fires after a post is deleted.

```php
do_action( 'deleted_post', $post_id, $post );
```

---

#### after_delete_post
Fires at the conclusion of wp_delete_post().

```php
do_action( 'after_delete_post', $post_id, $post );
```

---

### Trash Hooks

#### pre_trash_post
Filters whether to proceed with trashing.

```php
apply_filters( 'pre_trash_post', $trash, $post, $previous_status );
```

---

#### wp_trash_post
Fires before a post is sent to trash.

```php
do_action( 'wp_trash_post', $post_id, $previous_status );
```

---

#### trashed_post
Fires after a post is trashed.

```php
do_action( 'trashed_post', $post_id, $previous_status );
```

---

#### pre_untrash_post
Filters whether to proceed with untrashing.

```php
apply_filters( 'pre_untrash_post', $untrash, $post, $previous_status );
```

---

#### untrash_post
Fires before a post is restored from trash.

```php
do_action( 'untrash_post', $post_id, $previous_status );
```

---

#### untrashed_post
Fires after a post is restored from trash.

```php
do_action( 'untrashed_post', $post_id, $previous_status );
```

---

#### wp_untrash_post_status
Filters the status assigned to restored posts.

```php
apply_filters( 'wp_untrash_post_status', $new_status, $post_id, $previous_status );
```

Default is 'draft' (since 5.6.0).

---

## Post Status Hooks

### transition_post_status
Fires when post status changes.

```php
do_action( 'transition_post_status', $new_status, $old_status, $post );
```

---

### {$old_status}_to_{$new_status}
Dynamic hook for specific status transitions.

```php
do_action( "{$old_status}_to_{$new_status}", $post );
```

Examples:
- `draft_to_publish`
- `pending_to_publish`
- `publish_to_trash`

---

### {$new_status}_{$post_type}
Fires for specific status and post type.

```php
do_action( "{$new_status}_{$post->post_type}", $post_id, $post );
```

Examples:
- `publish_post`
- `publish_page`
- `draft_movie`

---

## Content Display Hooks

### the_title
Filters the post title.

```php
apply_filters( 'the_title', $post_title, $post_id );
```

---

### protected_title_format
Filters the "Protected: %s" format.

```php
apply_filters( 'protected_title_format', $prepend, $post );
```

---

### private_title_format
Filters the "Private: %s" format.

```php
apply_filters( 'private_title_format', $prepend, $post );
```

---

### the_content
Filters the post content for display.

```php
apply_filters( 'the_content', $content );
```

This is a critical filter - many plugins add functionality here (embeds, shortcodes, etc.).

---

### the_content_more_link
Filters the "read more" link.

```php
apply_filters( 'the_content_more_link', $more_link_element, $more_link_text );
```

---

### the_excerpt
Filters the displayed excerpt.

```php
apply_filters( 'the_excerpt', $post_excerpt );
```

---

### get_the_excerpt
Filters the retrieved excerpt.

```php
apply_filters( 'get_the_excerpt', $post_excerpt, $post );
```

---

### excerpt_length
Filters auto-generated excerpt length (words).

```php
apply_filters( 'excerpt_length', $length );
```

Default: 55 words

---

### excerpt_more
Filters the "read more" text for auto-excerpts.

```php
apply_filters( 'excerpt_more', $more );
```

Default: ` [&hellip;]`

---

### the_guid
Filters the post GUID.

```php
apply_filters( 'the_guid', $post_guid, $post_id );
```

---

### get_the_guid
Filters the retrieved GUID.

```php
apply_filters( 'get_the_guid', $post_guid, $post_id );
```

---

## Post Class Hooks

### post_class
Filters the array of post CSS classes.

```php
apply_filters( 'post_class', $classes, $css_class, $post_id );
```
- `$classes` (string[]) - Array of class names
- `$css_class` (string[]) - Additional classes
- `$post_id` (int)

---

### post_class_taxonomies
Filters taxonomies used for class generation.

```php
apply_filters( 'post_class_taxonomies', $taxonomies, $post_id, $classes, $css_class );
```

---

### body_class
Filters the body CSS classes.

```php
apply_filters( 'body_class', $classes, $css_class );
```

---

## Post Meta Hooks

### added_post_meta
Fires after post meta is added.

```php
do_action( 'added_post_meta', $meta_id, $post_id, $meta_key, $meta_value );
```

---

### updated_post_meta
Fires after post meta is updated.

```php
do_action( 'updated_post_meta', $meta_id, $post_id, $meta_key, $meta_value );
```

---

### deleted_post_meta
Fires after post meta is deleted.

```php
do_action( 'deleted_post_meta', $meta_ids, $post_id, $meta_key, $meta_value );
```

---

### add_post_meta
Fires before adding post meta.

```php
do_action( 'add_post_meta', $post_id, $meta_key, $meta_value );
```

---

### update_post_meta
Fires before updating post meta.

```php
do_action( 'update_post_meta', $meta_id, $post_id, $meta_key, $meta_value );
```

---

### delete_post_meta
Fires before deleting post meta.

```php
do_action( 'delete_post_meta', $meta_ids, $post_id, $meta_key, $meta_value );
```

---

## Post Field Filters

### edit_{$field}
Filters post field for editing.

```php
apply_filters( "edit_{$field}", $value, $post_id );
```

Examples: `edit_post_content`, `edit_post_title`

---

### {$field}_edit_pre
Filters post field before editing (prefixed fields).

```php
apply_filters( "{$field_no_prefix}_edit_pre", $value, $post_id );
```

Examples: `content_edit_pre`, `title_edit_pre`

---

### pre_{$field}
Filters post field before saving (prefixed fields).

```php
apply_filters( "pre_{$field}", $value );
```

Examples: `pre_post_content`, `pre_post_title`

---

### {$field}_save_pre
Filters post field before saving (prefixed fields, alternate).

```php
apply_filters( "{$field_no_prefix}_save_pre", $value );
```

Examples: `content_save_pre`, `title_save_pre`

---

## Featured Image Hooks

### has_post_thumbnail
Filters whether post has a thumbnail.

```php
apply_filters( 'has_post_thumbnail', $has_thumbnail, $post, $thumbnail_id );
```

---

### post_thumbnail_id
Filters the thumbnail attachment ID.

```php
apply_filters( 'post_thumbnail_id', $thumbnail_id, $post );
```

---

### post_thumbnail_size
Filters the requested thumbnail size.

```php
apply_filters( 'post_thumbnail_size', $size, $post_id );
```

---

### begin_fetch_post_thumbnail_html
Fires before fetching thumbnail HTML.

```php
do_action( 'begin_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );
```

---

### end_fetch_post_thumbnail_html
Fires after fetching thumbnail HTML.

```php
do_action( 'end_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );
```

---

### post_thumbnail_html
Filters the post thumbnail HTML.

```php
apply_filters( 'post_thumbnail_html', $html, $post_id, $post_thumbnail_id, $size, $attr );
```

---

### post_thumbnail_url
Filters the post thumbnail URL.

```php
apply_filters( 'post_thumbnail_url', $thumbnail_url, $post, $size );
```

---

### the_post_thumbnail_caption
Filters the displayed thumbnail caption.

```php
apply_filters( 'the_post_thumbnail_caption', $caption );
```

---

## Revision Hooks

### wp_save_post_revision_check_for_changes
Filters whether to check for changes before saving revision.

```php
apply_filters( 'wp_save_post_revision_check_for_changes', $check_for_changes, $latest_revision, $post );
```

---

### wp_save_post_revision_post_has_changed
Filters whether post has changed (for revision decision).

```php
apply_filters( 'wp_save_post_revision_post_has_changed', $post_has_changed, $latest_revision, $post );
```

---

### _wp_post_revision_fields
Filters which fields are tracked in revisions.

```php
apply_filters( '_wp_post_revision_fields', $fields, $post );
```

Default fields: `post_title`, `post_content`, `post_excerpt`

---

### wp_revisions_to_keep
Filters number of revisions to keep.

```php
apply_filters( 'wp_revisions_to_keep', $num, $post );
```

---

### wp_{$post_type}_revisions_to_keep
Filters revisions per post type.

```php
apply_filters( "wp_{$post->post_type}_revisions_to_keep", $num, $post );
```

---

### _wp_put_post_revision
Fires after a revision is saved.

```php
do_action( '_wp_put_post_revision', $revision_id, $post_id );
```

---

### wp_restore_post_revision
Fires after a revision is restored.

```php
do_action( 'wp_restore_post_revision', $post_id, $revision_id );
```

---

### wp_delete_post_revision
Fires after a revision is deleted.

```php
do_action( 'wp_delete_post_revision', $revision_id, $revision );
```

---

### wp_post_revision_meta_keys
Filters meta keys to be revisioned.

```php
apply_filters( 'wp_post_revision_meta_keys', $keys, $post_type );
```

---

## Sticky Post Hooks

### post_stuck
Fires after a post is made sticky.

```php
do_action( 'post_stuck', $post_id );
```

---

### post_unstuck
Fires after sticky is removed.

```php
do_action( 'post_unstuck', $post_id );
```

---

### is_sticky
Filters whether a post is sticky.

```php
apply_filters( 'is_sticky', $is_sticky, $post_id );
```

---

## Post Query Hooks

### posts_where
Filters the WHERE clause of post queries.

```php
apply_filters( 'posts_where', $where, $wp_query );
```

---

### posts_join
Filters the JOIN clause.

```php
apply_filters( 'posts_join', $join, $wp_query );
```

---

### posts_orderby
Filters the ORDER BY clause.

```php
apply_filters( 'posts_orderby', $orderby, $wp_query );
```

---

### posts_clauses
Filters all query clauses at once.

```php
apply_filters( 'posts_clauses', $clauses, $wp_query );
```

---

### the_posts
Filters retrieved posts array.

```php
apply_filters( 'the_posts', $posts, $wp_query );
```

---

## Slug/Permalink Hooks

### wp_unique_post_slug
Filters the unique slug before generation.

```php
apply_filters( 'pre_wp_unique_post_slug', $override_slug, $slug, $post_id, $post_status, $post_type, $post_parent );
```

Return non-null to short-circuit.

---

### wp_unique_post_slug
Filters the generated unique slug.

```php
apply_filters( 'wp_unique_post_slug', $slug, $post_id, $post_status, $post_type, $post_parent, $original_slug );
```

---

## Attachment Hooks

### add_attachment
Fires after an attachment is created.

```php
do_action( 'add_attachment', $post_id );
```

---

### edit_attachment
Fires after an attachment is updated.

```php
do_action( 'edit_attachment', $post_id );
```

---

### attachment_updated
Fires after attachment update with before/after.

```php
do_action( 'attachment_updated', $post_id, $post_after, $post_before );
```

---

### delete_attachment
Fires before an attachment is deleted.

```php
do_action( 'delete_attachment', $post_id );
```

---

### deleted_attachment
Fires after an attachment is deleted.

```php
do_action( 'deleted_attachment', $post_id );
```

---

### get_attached_file
Filters the attached file path.

```php
apply_filters( 'get_attached_file', $file, $attachment_id );
```

---

### update_attached_file
Filters the file path before updating.

```php
apply_filters( 'update_attached_file', $file, $attachment_id );
```

---

## Post Count Hooks

### wp_count_posts
Filters post count results.

```php
apply_filters( 'wp_count_posts', $counts, $type, $perm );
```

---

### wp_count_attachments
Filters attachment count results.

```php
apply_filters( 'wp_count_attachments', $counts, $mime_type );
```

---

## Post Format Hooks

### post_formats_rewrite_base
Filters the post format rewrite base.

```php
apply_filters( 'post_formats_rewrite_base', 'type' );
```

---

## Page Hooks

### wp_dropdown_pages
Filters the pages dropdown HTML.

```php
apply_filters( 'wp_dropdown_pages', $output, $parsed_args, $pages );
```

---

### wp_list_pages
Filters the pages list HTML.

```php
apply_filters( 'wp_list_pages', $output, $parsed_args, $pages );
```

---

### wp_list_pages_excludes
Filters pages to exclude from list.

```php
apply_filters( 'wp_list_pages_excludes', $exclude_array );
```

---

## Link/Pagination Hooks

### wp_link_pages
Filters paginated post links HTML.

```php
apply_filters( 'wp_link_pages', $output, $args );
```

---

### wp_link_pages_args
Filters pagination arguments.

```php
apply_filters( 'wp_link_pages_args', $parsed_args );
```

---

### wp_link_pages_link
Filters individual page link.

```php
apply_filters( 'wp_link_pages_link', $link, $i );
```

---

## Password Protection Hooks

### post_password_required
Filters whether password is required.

```php
apply_filters( 'post_password_required', $required, $post );
```

---

### the_password_form
Filters the password form HTML.

```php
apply_filters( 'the_password_form', $output, $post );
```

---

## Common Usage Patterns

### Modify Content Before Display

```php
add_filter( 'the_content', function( $content ) {
    if ( is_single() ) {
        $content .= '<div class="author-bio">...</div>';
    }
    return $content;
} );
```

### Track Post Changes

```php
add_action( 'post_updated', function( $post_id, $post_after, $post_before ) {
    if ( $post_before->post_status !== $post_after->post_status ) {
        // Status changed
        log_status_change( $post_id, $post_before->post_status, $post_after->post_status );
    }
}, 10, 3 );
```

### Custom Post Creation Logic

```php
add_action( 'wp_after_insert_post', function( $post, $update, $post_before ) {
    if ( ! $update && $post->post_type === 'product' ) {
        // New product created
        setup_product_defaults( $post->ID );
    }
}, 10, 3 );
```

### Filter Revision Fields

```php
add_filter( '_wp_post_revision_fields', function( $fields, $post ) {
    if ( $post['post_type'] === 'book' ) {
        $fields['isbn'] = 'ISBN';  // Track custom field
    }
    return $fields;
}, 10, 2 );
```

### Conditional Featured Images

```php
add_filter( 'post_thumbnail_html', function( $html, $post_id, $thumb_id, $size, $attr ) {
    if ( empty( $html ) ) {
        // Return default image if no thumbnail
        return '<img src="' . get_template_directory_uri() . '/images/default.jpg" class="default-thumb" />';
    }
    return $html;
}, 10, 5 );
```

### Prevent Certain Status Transitions

```php
add_action( 'transition_post_status', function( $new, $old, $post ) {
    if ( $new === 'publish' && $post->post_type === 'article' ) {
        if ( ! has_post_thumbnail( $post->ID ) ) {
            // Revert to draft
            wp_update_post( array(
                'ID' => $post->ID,
                'post_status' => 'draft',
            ) );
            wp_die( 'Articles require a featured image before publishing.' );
        }
    }
}, 10, 3 );
```
