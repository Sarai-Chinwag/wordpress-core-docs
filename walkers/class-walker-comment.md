# Walker_Comment

Creates an HTML list of threaded comments.

**Since:** 2.7.0  
**Source:** `wp-includes/class-walker-comment.php`  
**Used by:** `wp_list_comments()`

## Class Synopsis

```php
class Walker_Comment extends Walker {
    public $tree_type = 'comment';
    public $db_fields = [
        'parent' => 'comment_parent',
        'id'     => 'comment_ID',
    ];
    
    public function start_lvl( &$output, $depth = 0, $args = [] );
    public function end_lvl( &$output, $depth = 0, $args = [] );
    public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 );
    public function end_el( &$output, $data_object, $depth = 0, $args = [] );
    
    // Override for orphan handling
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output );
    
    // Output methods
    protected function ping( $comment, $depth, $args );
    protected function comment( $comment, $depth, $args );
    protected function html5_comment( $comment, $depth, $args );
    
    // Filter method
    public function filter_comment_text( $comment_text, $comment ): string;
}
```

## Configuration

### `$db_fields`

```php
public $db_fields = [
    'parent' => 'comment_parent',  // WP_Comment->comment_parent
    'id'     => 'comment_ID',      // WP_Comment->comment_ID
];
```

## Methods

### `start_lvl()`

Opens a child comment container. Sets global `$comment_depth`.

```php
public function start_lvl( &$output, $depth = 0, $args = [] )
```

**Output by style:**
- `div`: Nothing (divs don't need container)
- `ol`: `<ol class="children">`
- `ul` (default): `<ul class="children">`

---

### `end_lvl()`

Closes the child comment container.

```php
public function end_lvl( &$output, $depth = 0, $args = [] )
```

**Output:**
```html
</ul><!-- .children -->
```

---

### `start_el()`

Outputs a comment. Delegates to rendering methods based on type and format.

```php
public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 )
```

**Sets globals:**
- `$comment_depth` — Current nesting depth
- `$comment` — Current comment object

**Rendering decision tree:**
1. If `$args['callback']` is set → Call custom callback
2. If pingback/trackback and `$args['short_ping']` → Call `ping()`
3. If `$args['format'] === 'html5'` → Call `html5_comment()`
4. Otherwise → Call `comment()`

---

### `end_el()`

Closes the comment element.

```php
public function end_el( &$output, $data_object, $depth = 0, $args = [] )
```

**Uses `$args['end-callback']`** if set, otherwise:
- `div` style: `</div><!-- #comment-## -->`
- List style: `</li><!-- #comment-## -->`

---

### `display_element()`

Override of parent method to handle deeply nested orphans.

```php
public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output )
```

**Special behavior:** When at max depth with remaining children, displays them inline at the current depth instead of orphaning them at the end.

Example with `max_depth = 2`:
```
Comment 1
  └── Reply 1.1
      Reply 1.1.1 (displayed here, not orphaned)
      Reply 1.1.2
```

## Rendering Methods

### `ping()`

Outputs a pingback/trackback in short format.

```php
protected function ping( $comment, $depth, $args )
```

**Output:**
```html
<li id="comment-123" class="pingback">
    <div class="comment-body">
        Pingback: <a href="...">Source Site</a> <span class="edit-link"><a href="...">Edit</a></span>
    </div>
```

---

### `comment()`

Outputs a standard comment (XHTML format).

```php
protected function comment( $comment, $depth, $args )
```

**Structure:**
```html
<li class="comment parent" id="comment-123">
    <div id="div-comment-123" class="comment-body">
        <div class="comment-author vcard">
            <img class="avatar" ... />
            <cite class="fn"><a href="...">Author Name</a></cite> <span class="says">says:</span>
        </div>
        <div class="comment-meta commentmetadata">
            <a href="#comment-123">January 1, 2024 at 12:00 pm</a>
            <a href="...">(Edit)</a>
        </div>
        <p>Comment text...</p>
        <div class="reply">
            <a href="?replytocom=123">Reply</a>
        </div>
    </div>
```

---

### `html5_comment()`

Outputs a comment in HTML5 format.

```php
protected function html5_comment( $comment, $depth, $args )
```

**Structure:**
```html
<li id="comment-123" class="comment parent">
    <article id="div-comment-123" class="comment-body">
        <footer class="comment-meta">
            <div class="comment-author vcard">
                <img class="avatar" ... />
                <b class="fn">Author Name</b> <span class="says">says:</span>
            </div>
            <div class="comment-metadata">
                <a href="#comment-123"><time datetime="2024-01-01T12:00:00+00:00">January 1, 2024 at 12:00 pm</time></a>
            </div>
        </footer>
        <div class="comment-content">
            <p>Comment text...</p>
        </div>
        <div class="reply">
            <a href="?replytocom=123">Reply</a>
        </div>
    </article>
```

## Filter Method

### `filter_comment_text()`

**Since:** 5.4.2

Removes links from pending comments if the commenter didn't consent to cookies.

```php
public function filter_comment_text( $comment_text, $comment ): string
```

Applied via `add_filter( 'comment_text', ... )` during regular comment output.

## Args Reference

| Arg | Type | Description |
|-----|------|-------------|
| `style` | `string` | `'div'`, `'ol'`, or `'ul'` (default) |
| `format` | `string` | `'html5'` for semantic markup |
| `callback` | `callable` | Custom function for `start_el()` |
| `end-callback` | `callable` | Custom function for `end_el()` |
| `short_ping` | `bool` | Use short format for pingbacks |
| `avatar_size` | `int` | Avatar pixel size (0 to disable) |
| `max_depth` | `int` | Maximum nesting depth |

## Usage Example

```php
// Direct usage
$walker = new Walker_Comment();
$comments = get_comments( [ 'post_id' => get_the_ID() ] );

echo '<ol class="comment-list">';
echo $walker->paged_walk(
    $comments,
    get_option( 'thread_comments_depth' ),
    get_query_var( 'cpage' ) ?: 1,
    get_option( 'comments_per_page' ),
    [
        'style'       => 'ol',
        'format'      => 'html5',
        'avatar_size' => 48,
    ]
);
echo '</ol>';

// Via wp_list_comments() with custom callback
wp_list_comments( [
    'callback' => function( $comment, $args, $depth ) {
        echo '<li>';
        echo '<strong>' . get_comment_author() . '</strong>';
        echo get_comment_text();
    },
    'end-callback' => function() {
        echo '</li>';
    },
] );
```

## CSS Classes

Applied to comment elements:

| Class | Condition |
|-------|-----------|
| `comment` | Standard comment |
| `pingback` | Pingback type |
| `trackback` | Trackback type |
| `parent` | Has child comments |
| `byuser` | By registered user |
| `bypostauthor` | By post author |
| `comment-author-{nicename}` | Author identifier |

## Related

- [`wp_list_comments()`](https://developer.wordpress.org/reference/functions/wp_list_comments/) — Main function using this walker
- [`get_comment_class()`](https://developer.wordpress.org/reference/functions/get_comment_class/) — CSS class generation
- [`comment_text`](https://developer.wordpress.org/reference/hooks/comment_text/) filter — Modify comment content
