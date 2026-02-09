# Comment Hooks

Actions and filters for customizing the WordPress comment system.

## Query Hooks

### Actions

#### `pre_get_comments`

Fires before comments are retrieved.

```php
do_action_ref_array( 'pre_get_comments', array( &$query ) );
```

**Parameters:**
- `$query` (WP_Comment_Query) - Query instance (by reference).

**Example:**
```php
add_action( 'pre_get_comments', function( $query ) {
    // Exclude specific author from all comment queries
    if ( empty( $query->query_vars['author__not_in'] ) ) {
        $query->query_vars['author__not_in'] = array();
    }
    $query->query_vars['author__not_in'][] = 123;
} );
```

---

#### `parse_comment_query`

Fires after comment query vars are parsed.

```php
do_action_ref_array( 'parse_comment_query', array( &$query ) );
```

---

### Filters

#### `comments_pre_query`

Short-circuits the comment query.

```php
$comment_data = apply_filters_ref_array( 'comments_pre_query', array( $comment_data, &$query ) );
```

**Parameters:**
- `$comment_data` (array|int|null) - Return non-null to bypass query.
- `$query` (WP_Comment_Query) - Query instance.

**Return:** Array of comments, count, or null to continue.

**Example:**
```php
add_filter( 'comments_pre_query', function( $data, $query ) {
    // Return cached results for specific queries
    if ( $query->query_vars['post_id'] === 42 ) {
        return get_transient( 'cached_comments_42' );
    }
    return null; // Continue with database query
}, 10, 2 );
```

---

#### `comments_clauses`

Filters the SQL query clauses.

```php
$clauses = apply_filters_ref_array( 'comments_clauses', array( compact( $pieces ), &$query ) );
```

**Parameters:**
- `$clauses` (array):
  - `fields` - SELECT clause
  - `join` - JOIN clause
  - `where` - WHERE clause
  - `orderby` - ORDER BY clause
  - `limits` - LIMIT clause
  - `groupby` - GROUP BY clause
- `$query` (WP_Comment_Query) - Query instance.

**Example:**
```php
add_filter( 'comments_clauses', function( $clauses, $query ) {
    global $wpdb;
    // Add custom join
    $clauses['join'] .= " LEFT JOIN {$wpdb->usermeta} ON user_id = {$wpdb->usermeta}.user_id";
    return $clauses;
}, 10, 2 );
```

---

#### `the_comments`

Filters retrieved comments.

```php
$comments = apply_filters_ref_array( 'the_comments', array( $comments, &$query ) );
```

---

#### `found_comments_query`

Filters the query for found comment count.

```php
$found_query = apply_filters( 'found_comments_query', 'SELECT FOUND_ROWS()', $query );
```

---

## Comment Retrieval Hooks

#### `get_comment`

Filters a comment after retrieval.

```php
$comment = apply_filters( 'get_comment', $comment );
```

**Parameters:**
- `$comment` (WP_Comment) - Comment object.

---

## Comment Submission Hooks

### Actions

#### `preprocess_comment`

Filters comment data before processing.

```php
$commentdata = apply_filters( 'preprocess_comment', $commentdata );
```

**Parameters:**
- `$commentdata` (array) - Comment data including author info, content, post ID.

**Example:**
```php
add_filter( 'preprocess_comment', function( $commentdata ) {
    // Add custom data
    $commentdata['comment_meta'] = array(
        'submitted_url' => $_SERVER['HTTP_REFERER'],
    );
    return $commentdata;
} );
```

---

#### `check_comment_flood`

Fires before flood check.

```php
do_action( 'check_comment_flood', $ip, $email, $date, $wp_error );
```

---

#### `comment_duplicate_trigger`

Fires when duplicate comment detected.

```php
do_action( 'comment_duplicate_trigger', $commentdata );
```

---

#### `wp_insert_comment`

Fires after comment inserted to database.

```php
do_action( 'wp_insert_comment', $id, $comment );
```

**Parameters:**
- `$id` (int) - Comment ID.
- `$comment` (WP_Comment) - Comment object.

---

#### `comment_post`

Fires after comment inserted via `wp_new_comment()`.

```php
do_action( 'comment_post', $comment_id, $comment_approved, $commentdata );
```

**Parameters:**
- `$comment_id` (int) - Comment ID.
- `$comment_approved` (int|string) - 1, 0, 'spam', or 'trash'.
- `$commentdata` (array) - Comment data.

**Example:**
```php
add_action( 'comment_post', function( $id, $approved, $data ) {
    if ( $approved === 1 ) {
        // Send notification for approved comments
        do_action( 'my_new_comment_notification', $id );
    }
}, 10, 3 );
```

---

### Filters

#### `pre_comment_approved`

Filters comment approval status.

```php
$approved = apply_filters( 'pre_comment_approved', $approved, $commentdata );
```

**Parameters:**
- `$approved` (int|string|WP_Error) - 1, 0, 'spam', 'trash', or WP_Error.
- `$commentdata` (array) - Comment data.

**Example:**
```php
add_filter( 'pre_comment_approved', function( $approved, $data ) {
    // Auto-approve registered users
    if ( ! empty( $data['user_id'] ) && $data['user_id'] > 0 ) {
        return 1;
    }
    return $approved;
}, 10, 2 );
```

---

#### `duplicate_comment_id`

Filters duplicate detection.

```php
$dupe_id = apply_filters( 'duplicate_comment_id', $dupe_id, $commentdata );
```

**Return:** Empty value to allow duplicate.

---

#### `wp_is_comment_flood`

Filters flood detection result.

```php
$is_flood = apply_filters( 'wp_is_comment_flood', false, $ip, $email, $date, $wp_error );
```

---

#### `comment_flood_filter`

Filters flood check timing.

```php
$flood = apply_filters( 'comment_flood_filter', false, $time_lastcomment, $time_newcomment );
```

---

#### `comment_flood_message`

Filters flood error message.

```php
$message = apply_filters( 'comment_flood_message', __( 'You are posting comments too quickly. Slow down.' ) );
```

---

## Comment Content Filters

#### `pre_comment_author_name`

Filters author name before saving.

```php
$author = apply_filters( 'pre_comment_author_name', $author );
```

---

#### `pre_comment_author_email`

Filters author email before saving.

```php
$email = apply_filters( 'pre_comment_author_email', $email );
```

---

#### `pre_comment_author_url`

Filters author URL before saving.

```php
$url = apply_filters( 'pre_comment_author_url', $url );
```

---

#### `pre_comment_content`

Filters comment content before saving.

```php
$content = apply_filters( 'pre_comment_content', $content );
```

---

#### `pre_comment_user_ip`

Filters author IP before saving.

```php
$ip = apply_filters( 'pre_comment_user_ip', $ip );
```

---

#### `pre_comment_user_agent`

Filters user agent before saving.

```php
$agent = apply_filters( 'pre_comment_user_agent', $agent );
```

---

## Comment Update Hooks

#### `edit_comment`

Fires after comment is updated.

```php
do_action( 'edit_comment', $comment_id, $data );
```

---

#### `wp_update_comment_data`

Filters comment data before update.

```php
$data = apply_filters( 'wp_update_comment_data', $data, $comment, $commentarr );
```

---

#### `comment_save_pre`

Filters comment content before update.

```php
$content = apply_filters( 'comment_save_pre', $content );
```

---

## Comment Status Hooks

### Actions

#### `wp_set_comment_status`

Fires after status is set.

```php
do_action( 'wp_set_comment_status', $comment_id, $status );
```

---

#### `transition_comment_status`

Fires when status changes.

```php
do_action( 'transition_comment_status', $new_status, $old_status, $comment );
```

---

#### `comment_{$old_status}_to_{$new_status}`

Dynamic hook for specific transitions.

```php
do_action( "comment_{$old_status}_to_{$new_status}", $comment );
```

**Example hooks:**
- `comment_unapproved_to_approved`
- `comment_approved_to_spam`
- `comment_spam_to_approved`
- `comment_approved_to_trash`

---

#### `comment_{$new_status}_{$comment_type}`

Dynamic hook for status + type.

```php
do_action( "comment_{$new_status}_{$comment_type}", $comment_id, $comment );
```

**Example hooks:**
- `comment_approved_comment`
- `comment_unapproved_pingback`
- `comment_spam_trackback`

---

### Trash/Spam Actions

#### `trash_comment` / `trashed_comment`

```php
do_action( 'trash_comment', $comment_id, $comment );
do_action( 'trashed_comment', $comment_id, $comment );
```

---

#### `untrash_comment` / `untrashed_comment`

```php
do_action( 'untrash_comment', $comment_id, $comment );
do_action( 'untrashed_comment', $comment_id, $comment );
```

---

#### `spam_comment` / `spammed_comment`

```php
do_action( 'spam_comment', $comment_id, $comment );
do_action( 'spammed_comment', $comment_id, $comment );
```

---

#### `unspam_comment` / `unspammed_comment`

```php
do_action( 'unspam_comment', $comment_id, $comment );
do_action( 'unspammed_comment', $comment_id, $comment );
```

---

## Comment Deletion Hooks

#### `delete_comment`

Fires before comment is deleted.

```php
do_action( 'delete_comment', $comment_id, $comment );
```

---

#### `deleted_comment`

Fires after comment is deleted.

```php
do_action( 'deleted_comment', $comment_id, $comment );
```

---

## Comment Display Hooks

### Template Filters

#### `comments_template`

Filters path to comments template.

```php
$include = apply_filters( 'comments_template', $theme_template );
```

---

#### `comments_array`

Filters comments before display.

```php
$comments = apply_filters( 'comments_array', $comments, $post_id );
```

---

#### `comments_template_query_args`

Filters query args in `comments_template()`.

```php
$args = apply_filters( 'comments_template_query_args', $args );
```

---

### Comment Author Filters

#### `get_comment_author`

Filters returned author name.

```php
$author = apply_filters( 'get_comment_author', $author, $comment_id, $comment );
```

---

#### `comment_author`

Filters author name for display.

```php
echo apply_filters( 'comment_author', $author, $comment_id );
```

---

#### `get_comment_author_email`

Filters returned author email.

```php
$email = apply_filters( 'get_comment_author_email', $email, $comment_id, $comment );
```

---

#### `get_comment_author_url`

Filters returned author URL.

```php
$url = apply_filters( 'get_comment_author_url', $url, $comment_id, $comment );
```

---

#### `get_comment_author_link`

Filters author link HTML.

```php
$link = apply_filters( 'get_comment_author_link', $link, $author, $comment_id );
```

---

### Comment Content Filters

#### `get_comment_text`

Filters comment text before retrieval.

```php
$text = apply_filters( 'get_comment_text', $text, $comment, $args );
```

---

#### `comment_text`

Filters comment text for display.

```php
echo apply_filters( 'comment_text', $text, $comment, $args );
```

---

#### `get_comment_excerpt`

Filters comment excerpt.

```php
$excerpt = apply_filters( 'get_comment_excerpt', $excerpt, $comment_id, $comment );
```

---

### Comment Link Filters

#### `get_comment_link`

Filters comment permalink.

```php
$link = apply_filters( 'get_comment_link', $link, $comment, $args, $cpage );
```

---

#### `get_comments_link`

Filters post comments link.

```php
$link = apply_filters( 'get_comments_link', $link, $post );
```

---

### Comment Class Filters

#### `comment_class`

Filters CSS classes for comment.

```php
$classes = apply_filters( 'comment_class', $classes, $css_class, $comment_id, $comment, $post );
```

---

### wp_list_comments Filters

#### `wp_list_comments_args`

Filters `wp_list_comments()` arguments.

```php
$args = apply_filters( 'wp_list_comments_args', $args );
```

---

#### `comment_reply_link`

Filters reply link HTML.

```php
$link = apply_filters( 'comment_reply_link', $link, $args, $comment, $post );
```

---

#### `comment_reply_link_args`

Filters reply link arguments.

```php
$args = apply_filters( 'comment_reply_link_args', $args, $comment, $post );
```

---

#### `cancel_comment_reply_link`

Filters cancel reply link HTML.

```php
$link = apply_filters( 'cancel_comment_reply_link', $link, $url, $text );
```

---

## Comment Form Hooks

### Actions

#### `comment_form_before`

Fires before comment form.

```php
do_action( 'comment_form_before' );
```

---

#### `comment_form_top`

Fires at top of form, inside form tag.

```php
do_action( 'comment_form_top' );
```

---

#### `comment_form_before_fields`

Fires before comment form fields.

```php
do_action( 'comment_form_before_fields' );
```

---

#### `comment_form_after_fields`

Fires after comment form fields.

```php
do_action( 'comment_form_after_fields' );
```

---

#### `comment_form`

Fires at bottom of form, before closing tag.

```php
do_action( 'comment_form', $post_id );
```

---

#### `comment_form_after`

Fires after comment form.

```php
do_action( 'comment_form_after' );
```

---

#### `comment_form_comments_closed`

Fires if comments are closed.

```php
do_action( 'comment_form_comments_closed' );
```

---

### Filters

#### `comment_form_default_fields`

Filters default form fields.

```php
$fields = apply_filters( 'comment_form_default_fields', $fields );
```

**Example:**
```php
add_filter( 'comment_form_default_fields', function( $fields ) {
    // Add phone field
    $fields['phone'] = '<p class="comment-form-phone">
        <label for="phone">Phone</label>
        <input id="phone" name="phone" type="tel" />
    </p>';
    return $fields;
} );
```

---

#### `comment_form_defaults`

Filters form default arguments.

```php
$defaults = apply_filters( 'comment_form_defaults', $defaults );
```

---

#### `comment_form_fields`

Filters all form fields.

```php
$fields = apply_filters( 'comment_form_fields', $fields );
```

---

#### `comment_form_field_{$name}`

Filters individual form field.

```php
$field = apply_filters( 'comment_form_field_comment', $field );
$field = apply_filters( 'comment_form_field_author', $field );
$field = apply_filters( 'comment_form_field_email', $field );
$field = apply_filters( 'comment_form_field_url', $field );
$field = apply_filters( 'comment_form_field_cookies', $field );
```

---

#### `comment_form_logged_in`

Filters logged-in message.

```php
$message = apply_filters( 'comment_form_logged_in', $message, $commenter, $user_identity );
```

---

#### `comment_form_submit_button`

Filters submit button HTML.

```php
$button = apply_filters( 'comment_form_submit_button', $button, $args );
```

---

#### `comment_form_submit_field`

Filters submit field wrapper.

```php
$field = apply_filters( 'comment_form_submit_field', $field, $args );
```

---

## Comment Count Hooks

#### `get_comments_number`

Filters comment count for a post.

```php
$count = apply_filters( 'get_comments_number', $count, $post_id );
```

---

#### `wp_count_comments`

Filters comment count stats.

```php
$count = apply_filters( 'wp_count_comments', array(), $post_id );
```

---

#### `pre_wp_update_comment_count_now`

Short-circuits comment count update.

```php
$new = apply_filters( 'pre_wp_update_comment_count_now', null, $old, $post_id );
```

---

#### `wp_update_comment_count`

Fires after comment count updated.

```php
do_action( 'wp_update_comment_count', $post_id, $new, $old );
```

---

## Cookie Hooks

#### `comment_cookie_lifetime`

Filters cookie expiration.

```php
$lifetime = apply_filters( 'comment_cookie_lifetime', YEAR_IN_SECONDS );
```

---

#### `wp_get_current_commenter`

Filters current commenter data.

```php
$commenter = apply_filters( 'wp_get_current_commenter', $commenter );
```

---

## Notification Hooks

#### `notify_moderator`

Filters whether to notify moderator.

```php
$notify = apply_filters( 'notify_moderator', $notify, $comment_id );
```

---

#### `notify_post_author`

Filters whether to notify post author.

```php
$notify = apply_filters( 'notify_post_author', $notify, $comment_id );
```

---

## Pagination Hooks

#### `get_page_of_comment`

Filters calculated comment page.

```php
$page = apply_filters( 'get_page_of_comment', $page, $args, $original_args, $comment_id );
```

---

#### `get_page_of_comment_query_args`

Filters query args for page calculation.

```php
$args = apply_filters( 'get_page_of_comment_query_args', $args );
```

---

## Miscellaneous Hooks

#### `get_default_comment_status`

Filters default comment status for post type.

```php
$status = apply_filters( 'get_default_comment_status', $status, $post_type, $comment_type );
```

---

#### `comments_open`

Filters whether comments are open.

```php
$open = apply_filters( 'comments_open', $open, $post_id );
```

---

#### `pings_open`

Filters whether pings are open.

```php
$open = apply_filters( 'pings_open', $open, $post_id );
```

---

#### `comment_max_links_url`

Filters link count for moderation.

```php
$count = apply_filters( 'comment_max_links_url', $count, $url, $comment );
```

---

#### `wp_get_comment_fields_max_lengths`

Filters field max lengths.

```php
$lengths = apply_filters( 'wp_get_comment_fields_max_lengths', $lengths );
```
