# Comment Functions

Core functions for working with WordPress comments.

## Retrieval Functions

### get_comment()

Retrieves comment data given a comment ID or comment object.

```php
get_comment( $comment = null, $output = OBJECT ): WP_Comment|array|null
```

**Parameters:**
- `$comment` (WP_Comment|string|int) - Comment to retrieve. Default current global comment.
- `$output` (string) - Return type: `OBJECT`, `ARRAY_A`, or `ARRAY_N`. Default `OBJECT`.

**Returns:** `WP_Comment|array|null` - Comment object, array, or null if not found.

**Example:**
```php
$comment = get_comment( 123 );
echo $comment->comment_author;

// As associative array
$comment = get_comment( 123, ARRAY_A );
echo $comment['comment_author'];
```

---

### get_comments()

Retrieves a list of comments matching query arguments.

```php
get_comments( $args = '' ): WP_Comment[]|int[]|int
```

**Parameters:**
- `$args` (string|array) - See [WP_Comment_Query](./class-wp-comment-query.md) for arguments.

**Returns:** `WP_Comment[]|int[]|int` - Comments array, IDs, or count if `count` is true.

**Example:**
```php
// Get approved comments for a post
$comments = get_comments( array(
    'post_id' => 42,
    'status'  => 'approve',
    'orderby' => 'comment_date',
    'order'   => 'ASC',
) );

// Count comments by author
$count = get_comments( array(
    'author_email' => 'user@example.com',
    'count'        => true,
) );
```

---

### get_approved_comments()

Retrieves approved comments for a post.

```php
get_approved_comments( $post_id, $args = array() ): WP_Comment[]|int[]|int
```

**Parameters:**
- `$post_id` (int) - Post ID.
- `$args` (array) - Optional. Query arguments.

**Returns:** `WP_Comment[]|int[]|int` - Approved comments.

**Example:**
```php
$comments = get_approved_comments( 42 );
```

---

### get_comment_count()

Retrieves total comment counts for the site or a post.

```php
get_comment_count( $post_id = 0 ): int[]
```

**Parameters:**
- `$post_id` (int) - Post ID. Default 0 for site-wide.

**Returns:** Array with keys: `approved`, `awaiting_moderation`, `spam`, `trash`, `post-trashed`, `total_comments`, `all`.

**Example:**
```php
$counts = get_comment_count( 42 );
echo "Approved: {$counts['approved']}, Pending: {$counts['awaiting_moderation']}";
```

---

### wp_count_comments()

Retrieves cached comment counts (preferred over `get_comment_count()`).

```php
wp_count_comments( $post_id = 0 ): stdClass
```

**Returns:** Object with properties: `approved`, `moderated`, `spam`, `trash`, `post-trashed`, `total_comments`, `all`.

---

## Creation Functions

### wp_insert_comment()

Inserts a comment directly into the database.

```php
wp_insert_comment( $commentdata ): int|false
```

**Parameters:**
- `$commentdata` (array):
  - `comment_post_ID` (int) - Post ID.
  - `comment_author` (string) - Author name.
  - `comment_author_email` (string) - Author email.
  - `comment_author_url` (string) - Author URL.
  - `comment_author_IP` (string) - Author IP.
  - `comment_content` (string) - Comment content.
  - `comment_date` (string) - Date in MySQL format.
  - `comment_date_gmt` (string) - GMT date.
  - `comment_approved` (int|string) - Status: 1, 0, 'spam', 'trash'.
  - `comment_type` (string) - Type. Default 'comment'.
  - `comment_parent` (int) - Parent ID for threading.
  - `user_id` (int) - User ID for registered users.
  - `comment_agent` (string) - Browser user agent.
  - `comment_karma` (int) - Karma score.
  - `comment_meta` (array) - Metadata key/value pairs.

**Returns:** `int|false` - Comment ID on success, false on failure.

**Example:**
```php
$comment_id = wp_insert_comment( array(
    'comment_post_ID'      => 42,
    'comment_author'       => 'John Doe',
    'comment_author_email' => 'john@example.com',
    'comment_content'      => 'Great post!',
    'comment_approved'     => 1,
    'user_id'              => 5,
    'comment_meta'         => array(
        'rating' => 5,
    ),
) );
```

**Note:** This bypasses validation and moderation. Use `wp_new_comment()` for user-submitted comments.

---

### wp_new_comment()

Adds a new comment with full validation, moderation, and notifications.

```php
wp_new_comment( $commentdata, $wp_error = false ): int|false|WP_Error
```

**Parameters:**
- `$commentdata` (array):
  - `comment_post_ID` (int) - Required. Post ID.
  - `comment_author` (string) - Author name.
  - `comment_author_email` (string) - Author email.
  - `comment_author_url` (string) - Author URL.
  - `comment_content` (string) - Comment content.
  - `comment_type` (string) - Comment type. Default 'comment'.
  - `comment_parent` (int) - Parent comment ID.
  - `user_id` (int) - User ID.
  - `comment_author_IP` (string) - Auto-detected if not provided.
  - `comment_agent` (string) - Auto-detected if not provided.
- `$wp_error` (bool) - Return WP_Error on failure. Default false.

**Returns:** `int|false|WP_Error` - Comment ID, false, or WP_Error.

**Example:**
```php
$result = wp_new_comment( array(
    'comment_post_ID'      => 42,
    'comment_author'       => 'Jane Doe',
    'comment_author_email' => 'jane@example.com',
    'comment_content'      => 'Thanks for sharing!',
), true );

if ( is_wp_error( $result ) ) {
    echo $result->get_error_message();
}
```

---

## Update Functions

### wp_update_comment()

Updates an existing comment.

```php
wp_update_comment( $commentarr, $wp_error = false ): int|false|WP_Error
```

**Parameters:**
- `$commentarr` (array) - Must include `comment_ID`. Other fields optional.
- `$wp_error` (bool) - Return WP_Error on failure.

**Returns:** `int|false|WP_Error` - 1 on success, 0 if unchanged, false/WP_Error on failure.

**Example:**
```php
wp_update_comment( array(
    'comment_ID'      => 123,
    'comment_content' => 'Updated content',
    'comment_meta'    => array(
        'edited' => true,
    ),
) );
```

---

### wp_set_comment_status()

Sets comment approval status.

```php
wp_set_comment_status( $comment_id, $comment_status, $wp_error = false ): bool|WP_Error
```

**Parameters:**
- `$comment_id` (int|WP_Comment) - Comment ID or object.
- `$comment_status` (string) - 'hold', 'approve', 'spam', or 'trash'.
- `$wp_error` (bool) - Return WP_Error on failure.

**Example:**
```php
// Approve a comment
wp_set_comment_status( 123, 'approve' );

// Hold for moderation
wp_set_comment_status( 123, 'hold' );

// Mark as spam
wp_set_comment_status( 123, 'spam' );
```

---

## Deletion Functions

### wp_delete_comment()

Deletes a comment (moves to trash or permanently deletes).

```php
wp_delete_comment( $comment_id, $force_delete = false ): bool
```

**Parameters:**
- `$comment_id` (int|WP_Comment) - Comment ID or object.
- `$force_delete` (bool) - Bypass trash and permanently delete.

**Returns:** `bool` - True on success, false on failure.

**Example:**
```php
// Move to trash (if enabled)
wp_delete_comment( 123 );

// Permanently delete
wp_delete_comment( 123, true );
```

---

### wp_trash_comment()

Moves a comment to trash.

```php
wp_trash_comment( $comment_id ): bool
```

---

### wp_untrash_comment()

Restores a comment from trash.

```php
wp_untrash_comment( $comment_id ): bool
```

---

### wp_spam_comment()

Marks a comment as spam.

```php
wp_spam_comment( $comment_id ): bool
```

---

### wp_unspam_comment()

Removes spam status from a comment.

```php
wp_unspam_comment( $comment_id ): bool
```

---

## Status Functions

### wp_get_comment_status()

Gets the status of a comment.

```php
wp_get_comment_status( $comment_id ): string|false
```

**Returns:** 'approved', 'unapproved', 'spam', 'trash', or false.

**Example:**
```php
$status = wp_get_comment_status( 123 );
if ( 'approved' === $status ) {
    // Comment is visible
}
```

---

### comments_open()

Checks if comments are open for a post.

```php
comments_open( $post = null ): bool
```

---

### pings_open()

Checks if pings are open for a post.

```php
pings_open( $post = null ): bool
```

---

## Validation Functions

### check_comment()

Checks if a comment passes internal validation.

```php
check_comment( $author, $email, $url, $comment, $user_ip, $user_agent, $comment_type ): bool
```

**Checks:**
- Manual moderation setting
- Link count vs `comment_max_links`
- Moderation keywords
- Previously approved author

---

### wp_allow_comment()

Validates comment and returns approval status.

```php
wp_allow_comment( $commentdata, $wp_error = false ): int|string|WP_Error
```

**Returns:** `1` (approved), `0` (pending), 'spam', 'trash', or WP_Error.

---

### wp_check_comment_disallowed_list()

Checks if comment contains disallowed words.

```php
wp_check_comment_disallowed_list( $author, $email, $url, $comment, $user_ip, $user_agent ): bool
```

**Returns:** `true` if disallowed content found.

---

### wp_check_comment_flood()

Checks for comment flooding.

```php
wp_check_comment_flood( $is_flood, $ip, $email, $date, $avoid_die = false ): bool
```

---

### wp_filter_comment()

Filters and sanitizes comment data.

```php
wp_filter_comment( $commentdata ): array
```

---

## Comment Meta Functions

### add_comment_meta()

Adds metadata to a comment.

```php
add_comment_meta( $comment_id, $meta_key, $meta_value, $unique = false ): int|false
```

---

### get_comment_meta()

Retrieves comment metadata.

```php
get_comment_meta( $comment_id, $key = '', $single = false ): mixed
```

---

### update_comment_meta()

Updates comment metadata.

```php
update_comment_meta( $comment_id, $meta_key, $meta_value, $prev_value = '' ): int|bool
```

---

### delete_comment_meta()

Deletes comment metadata.

```php
delete_comment_meta( $comment_id, $meta_key, $meta_value = '' ): bool
```

---

## Template Functions

### wp_list_comments()

Displays a list of comments.

```php
wp_list_comments( $args = array(), $comments = null ): void|string
```

**Parameters:**
- `$args` (array):
  - `walker` (Walker_Comment) - Custom walker instance.
  - `max_depth` (int) - Maximum threading depth.
  - `style` (string) - 'ul', 'ol', or 'div'.
  - `callback` (callable) - Custom rendering callback.
  - `end-callback` (callable) - Callback after comment.
  - `type` (string) - 'all', 'comment', 'pingback', 'trackback', 'pings'.
  - `avatar_size` (int) - Avatar dimensions. Default 32.
  - `reverse_top_level` (bool) - Reverse comment order.
  - `short_ping` (bool) - Display short pings.
  - `echo` (bool) - Echo or return output.

**Example:**
```php
wp_list_comments( array(
    'style'       => 'ol',
    'avatar_size' => 64,
    'max_depth'   => 4,
    'type'        => 'comment',
) );
```

---

### comment_form()

Outputs a complete comment form.

```php
comment_form( $args = array(), $post = null ): void
```

**Parameters:**
- `$args` (array):
  - `fields` (array) - Author, email, URL, cookies fields.
  - `comment_field` (string) - Textarea HTML.
  - `must_log_in` (string) - Message for logged-out users.
  - `logged_in_as` (string) - Logged-in user message.
  - `title_reply` (string) - Form title.
  - `label_submit` (string) - Submit button text.
  - `class_form` (string) - Form CSS class.
  - `id_form` (string) - Form ID.

**Example:**
```php
comment_form( array(
    'title_reply'  => 'Share Your Thoughts',
    'label_submit' => 'Submit Comment',
) );
```

---

### comments_template()

Loads the comments template.

```php
comments_template( $file = '/comments.php', $separate_comments = false ): void
```

---

## Pagination Functions

### get_comment_pages_count()

Calculates total comment pages.

```php
get_comment_pages_count( $comments = null, $per_page = null, $threaded = null ): int
```

---

### get_page_of_comment()

Determines which page a comment appears on.

```php
get_page_of_comment( $comment_id, $args = array() ): int|null
```

---

## Utility Functions

### separate_comments()

Separates comments by type.

```php
separate_comments( &$comments ): array
```

**Returns:** Array with keys: 'comment', 'trackback', 'pingback', 'pings'.

---

### get_comment_statuses()

Returns available comment statuses.

```php
get_comment_statuses(): array
```

**Returns:** `array( 'hold' => 'Unapproved', 'approve' => 'Approved', 'spam' => 'Spam', 'trash' => 'Trash' )`

---

### get_default_comment_status()

Gets default comment status for a post type.

```php
get_default_comment_status( $post_type = 'post', $comment_type = 'comment' ): string
```

**Returns:** 'open' or 'closed'.

---

### clean_comment_cache()

Clears comment cache for given IDs.

```php
clean_comment_cache( $ids ): void
```

---

### wp_update_comment_count()

Updates post comment count.

```php
wp_update_comment_count( $post_id, $do_deferred = false ): bool|void
```

---

### wp_defer_comment_counting()

Defers comment count updates for batch operations.

```php
wp_defer_comment_counting( $defer = null ): bool
```

**Example:**
```php
wp_defer_comment_counting( true );
// ... import many comments ...
wp_defer_comment_counting( false ); // Updates all at once
```

---

## Cookie Functions

### wp_set_comment_cookies()

Sets commenter identity cookies.

```php
wp_set_comment_cookies( $comment, $user, $cookies_consent = true ): void
```

---

### sanitize_comment_cookies()

Sanitizes comment author cookies.

```php
sanitize_comment_cookies(): void
```

---

### wp_get_current_commenter()

Gets current commenter's info from cookies.

```php
wp_get_current_commenter(): array
```

**Returns:** `array( 'comment_author', 'comment_author_email', 'comment_author_url' )`

---

## Notification Functions

### wp_new_comment_notify_moderator()

Sends moderation notification email.

```php
wp_new_comment_notify_moderator( $comment_id ): bool
```

---

### wp_new_comment_notify_postauthor()

Sends notification to post author.

```php
wp_new_comment_notify_postauthor( $comment_id ): bool
```
