# Query Functions

Functions for querying posts, managing The Loop, and checking query conditions.

**Source:** `wp-includes/query.php`

## Loop Functions

### have_posts()

Determines whether current WordPress query has posts to loop over.

```php
function have_posts(): bool
```

**Returns:** `true` if posts are available, `false` if end of the loop.

**Usage:**
```php
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        // Display post
    }
}
```

**Notes:**
- Calls `loop_end` action when loop completes
- Calls `loop_no_results` action if no posts found
- Automatically rewinds posts when finished

---

### the_post()

Iterates the post index in the loop and sets up global post data.

```php
function the_post(): void
```

**Effects:**
- Advances `$wp_query->current_post`
- Sets global `$post` to current post
- Calls `setup_postdata()` to populate globals
- Fires `loop_start` action on first iteration

**Usage:**
```php
while ( have_posts() ) {
    the_post();
    the_title();
    the_content();
}
```

---

### rewind_posts()

Rewind the loop posts to the beginning.

```php
function rewind_posts(): void
```

**Usage:**
```php
// Loop through posts twice
while ( have_posts() ) { the_post(); /* first pass */ }
rewind_posts();
while ( have_posts() ) { the_post(); /* second pass */ }
```

---

### in_the_loop()

Determines whether the caller is inside The Loop.

```php
function in_the_loop(): bool
```

**Returns:** `true` if inside loop, `false` otherwise.

**Usage:**
```php
if ( in_the_loop() ) {
    // Safe to use template tags like the_title()
}
```

**Since:** 2.0.0

---

### setup_postdata()

Sets up global post data for template tags.

```php
function setup_postdata( WP_Post|object|int $post ): bool
```

**Parameters:**
- `$post` — Post object or ID

**Returns:** `true` when finished.

**Sets Globals:**
- `$id` — Post ID
- `$authordata` — Author user object
- `$currentday` — Day in DD.MM.YY format
- `$currentmonth` — Month number
- `$page` — Current page for paginated posts
- `$pages` — Array of post content pages
- `$multipage` — Whether post has multiple pages
- `$more` — Whether to show full content
- `$numpages` — Number of pages

**Usage:**
```php
$posts = get_posts( $args );
foreach ( $posts as $post ) {
    setup_postdata( $post );
    the_title();
    the_excerpt();
}
wp_reset_postdata();
```

**Since:** 1.5.0, 4.4.0 (added post ID support)

---

### generate_postdata()

Generates post data array without setting globals.

```php
function generate_postdata( WP_Post|object|int $post ): array|false
```

**Parameters:**
- `$post` — Post object or ID

**Returns:** Array of post elements or `false` on failure.

**Array Keys:**
- `id`, `authordata`, `currentday`, `currentmonth`
- `page`, `pages`, `multipage`, `more`, `numpages`

**Since:** 5.2.0

---

## Query Variable Functions

### get_query_var()

Retrieves the value of a query variable.

```php
function get_query_var( string $query_var, mixed $default_value = '' ): mixed
```

**Parameters:**
- `$query_var` — Variable key to retrieve
- `$default_value` — Value if variable not set (default: `''`)

**Usage:**
```php
$paged = get_query_var( 'paged', 1 );
$cat_id = get_query_var( 'cat' );
$search_term = get_query_var( 's' );
```

**Since:** 1.5.0, 3.9.0 (added `$default_value`)

---

### set_query_var()

Sets the value of a query variable.

```php
function set_query_var( string $query_var, mixed $value ): void
```

**Parameters:**
- `$query_var` — Query variable key
- `$value` — Query variable value

**Usage:**
```php
set_query_var( 'posts_per_page', 20 );
```

**Note:** Only affects current request; doesn't persist.

**Since:** 2.2.0

---

### get_queried_object()

Retrieves the currently queried object.

```php
function get_queried_object(): WP_Term|WP_Post_Type|WP_Post|WP_User|null
```

**Returns:** Depends on context:
- Category/tag/taxonomy archive → `WP_Term`
- Post type archive → `WP_Post_Type`
- Single post/page → `WP_Post`
- Author archive → `WP_User`
- Otherwise → `null`

**Usage:**
```php
$obj = get_queried_object();
if ( $obj instanceof WP_Term ) {
    echo $obj->name;
}
```

**Since:** 3.1.0

---

### get_queried_object_id()

Retrieves the ID of the currently queried object.

```php
function get_queried_object_id(): int
```

**Returns:** ID of queried object, or `0` if none.

**Usage:**
```php
$term_id = get_queried_object_id(); // On taxonomy archive
$post_id = get_queried_object_id(); // On singular
```

**Since:** 3.1.0

---

## Query Execution Functions

### query_posts()

Sets up The Loop with query parameters. **Avoid using this function.**

```php
function query_posts( array|string $query ): WP_Post[]|int[]
```

**Parameters:**
- `$query` — Array or query string of WP_Query arguments

**Returns:** Array of post objects or IDs.

**⚠️ Warning:** This function:
- Completely overrides the main query
- Breaks pagination
- Causes conditional tag issues
- Should **never** be used in themes or plugins

**Use Instead:**
```php
// For modifying main query:
add_action( 'pre_get_posts', function( $query ) {
    if ( $query->is_main_query() ) {
        $query->set( 'posts_per_page', 5 );
    }
} );

// For secondary queries:
$custom_query = new WP_Query( $args );
```

**Since:** 1.5.0

---

### wp_reset_query()

Destroys the previous query and restores the original.

```php
function wp_reset_query(): void
```

**Effects:**
- Restores `$wp_query` to `$wp_the_query`
- Calls `wp_reset_postdata()`

**Usage:** Only after `query_posts()`, which you shouldn't use.

**Since:** 2.3.0

---

### wp_reset_postdata()

Restores the global `$post` to the current post in the main query.

```php
function wp_reset_postdata(): void
```

**Usage:**
```php
$my_query = new WP_Query( $args );
while ( $my_query->have_posts() ) {
    $my_query->the_post();
    // ...
}
wp_reset_postdata(); // Restore main query's $post
```

**Since:** 3.0.0

---

## Conditional Tags

All conditional tags check against the global `$wp_query` object.

### is_main_query()

Determines whether the query is the main query.

```php
function is_main_query(): bool
```

**⚠️ Important:** Inside `pre_get_posts`, use the method version:
```php
add_action( 'pre_get_posts', function( $query ) {
    if ( $query->is_main_query() ) { // Use $query, not is_main_query()
        // ...
    }
} );
```

**Since:** 3.3.0

---

### is_singular()

Determines whether the query is for a single post (post, page, attachment, CPT).

```php
function is_singular( string|string[] $post_types = '' ): bool
```

**Parameters:**
- `$post_types` — Post type(s) to check against (optional)

**Usage:**
```php
is_singular();              // Any single post
is_singular( 'post' );      // Single blog post
is_singular( 'product' );   // Single product
is_singular( array( 'post', 'page' ) );
```

**Since:** 1.5.0

---

### is_single()

Determines whether the query is for an existing single post.

```php
function is_single( int|string|int[]|string[] $post = '' ): bool
```

**Parameters:**
- `$post` — Post ID, title, slug, or array (optional)

**Note:** Works for posts and custom post types, **excludes pages and attachments**.

**Usage:**
```php
is_single();              // Any single post
is_single( 15 );          // Post ID 15
is_single( 'hello-world' ); // Post with slug
```

**Since:** 1.5.0

---

### is_page()

Determines whether the query is for an existing single page.

```php
function is_page( int|string|int[]|string[] $page = '' ): bool
```

**Parameters:**
- `$page` — Page ID, title, slug, path, or array (optional)

**Usage:**
```php
is_page();                    // Any page
is_page( 42 );                // Page ID 42
is_page( 'about' );           // Page with slug 'about'
is_page( 'company/about' );   // Page path
is_page( array( 'about', 'contact' ) );
```

**Since:** 1.5.0

---

### is_attachment()

Determines whether the query is for an existing attachment page.

```php
function is_attachment( int|string|int[]|string[] $attachment = '' ): bool
```

**Since:** 2.0.0

---

### is_archive()

Determines whether the query is for an existing archive page.

```php
function is_archive(): bool
```

**Returns:** `true` for category, tag, author, date, CPT archive, or custom taxonomy archive.

**Since:** 1.5.0

---

### is_category()

Determines whether the query is for a category archive.

```php
function is_category( int|string|int[]|string[] $category = '' ): bool
```

**Parameters:**
- `$category` — Category ID, name, slug, or array (optional)

**Since:** 1.5.0

---

### is_tag()

Determines whether the query is for a tag archive.

```php
function is_tag( int|string|int[]|string[] $tag = '' ): bool
```

**Since:** 2.3.0

---

### is_tax()

Determines whether the query is for a custom taxonomy archive.

```php
function is_tax( string|string[] $taxonomy = '', int|string|int[]|string[] $term = '' ): bool
```

**Parameters:**
- `$taxonomy` — Taxonomy slug(s) (optional)
- `$term` — Term ID, name, slug, or array (optional)

**Note:** Returns `false` for category and tag archives (use `is_category()` or `is_tag()`).

**Usage:**
```php
is_tax();                           // Any custom taxonomy
is_tax( 'genre' );                  // 'genre' taxonomy
is_tax( 'genre', 'rock' );          // 'rock' term in 'genre'
is_tax( 'genre', array( 'rock', 'pop' ) );
```

**Since:** 2.5.0

---

### is_post_type_archive()

Determines whether the query is for a post type archive.

```php
function is_post_type_archive( string|string[] $post_types = '' ): bool
```

**Since:** 3.1.0

---

### is_author()

Determines whether the query is for an author archive.

```php
function is_author( int|string|int[]|string[] $author = '' ): bool
```

**Parameters:**
- `$author` — User ID, nickname, nicename, or array (optional)

**Since:** 1.5.0

---

### is_date()

Determines whether the query is for any date archive.

```php
function is_date(): bool
```

**Since:** 1.5.0

---

### is_year()

Determines whether the query is for a year archive.

```php
function is_year(): bool
```

**Since:** 1.5.0

---

### is_month()

Determines whether the query is for a month archive.

```php
function is_month(): bool
```

**Since:** 1.5.0

---

### is_day()

Determines whether the query is for a day archive.

```php
function is_day(): bool
```

**Since:** 1.5.0

---

### is_time()

Determines whether the query is for a specific time.

```php
function is_time(): bool
```

**Since:** 1.5.0

---

### is_home()

Determines whether the query is for the blog homepage.

```php
function is_home(): bool
```

**Note:** This is the "Posts page", not necessarily the front page. If a static page is set as the front page, `is_home()` is `true` on the posts page.

**Since:** 1.5.0

---

### is_front_page()

Determines whether the query is for the site front page.

```php
function is_front_page(): bool
```

**Returns:** `true` for:
- Posts page when "Front page displays" is set to "Your latest posts"
- Static page when set as "Front page"

**Since:** 2.5.0

---

### is_search()

Determines whether the query is for a search.

```php
function is_search(): bool
```

**Since:** 1.5.0

---

### is_feed()

Determines whether the query is for a feed.

```php
function is_feed( string|string[] $feeds = '' ): bool
```

**Parameters:**
- `$feeds` — Feed type(s) to check (optional): `'rss2'`, `'atom'`, `'rss'`, `'rdf'`

**Since:** 1.5.0

---

### is_comment_feed()

Determines whether the query is for a comments feed.

```php
function is_comment_feed(): bool
```

**Since:** 3.0.0

---

### is_404()

Determines whether the query is a 404 (returns no results).

```php
function is_404(): bool
```

**Since:** 1.5.0

---

### is_paged()

Determines whether the query is for a paged result (not page 1).

```php
function is_paged(): bool
```

**Since:** 1.5.0

---

### is_preview()

Determines whether the query is for a post/page preview.

```php
function is_preview(): bool
```

**Since:** 2.0.0

---

### is_trackback()

Determines whether the query is for a trackback endpoint.

```php
function is_trackback(): bool
```

**Since:** 1.5.0

---

### is_robots()

Determines whether the query is for robots.txt.

```php
function is_robots(): bool
```

**Since:** 2.1.0

---

### is_favicon()

Determines whether the query is for favicon.ico.

```php
function is_favicon(): bool
```

**Since:** 5.4.0

---

### is_embed()

Determines whether the query is for an embedded post.

```php
function is_embed(): bool
```

**Since:** 4.4.0

---

### is_privacy_policy()

Determines whether the query is for the Privacy Policy page.

```php
function is_privacy_policy(): bool
```

**Since:** 5.2.0

---

## Comment Loop Functions

### have_comments()

Determines whether current query has comments to loop over.

```php
function have_comments(): bool
```

**Since:** 2.2.0

---

### the_comment()

Iterates comment index and sets up global comment data.

```php
function the_comment(): void
```

**Usage:**
```php
if ( have_comments() ) {
    while ( have_comments() ) {
        the_comment();
        comment_author();
        comment_text();
    }
}
```

**Since:** 2.2.0

---

## Redirect Functions

### wp_old_slug_redirect()

Redirects old slugs to the correct permalink.

```php
function wp_old_slug_redirect(): void
```

**Hooks:**
- `old_slug_redirect_post_id` — Filter the redirect post ID
- `old_slug_redirect_url` — Filter the redirect URL

**Since:** 2.1.0
