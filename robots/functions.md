# Robots Functions

## Conditional Functions

### is_robots()

Determines whether the query is for the robots.txt file.

```php
function is_robots(): bool
```

**Since:** 2.1.0

**Returns:** `bool` — True if requesting robots.txt

**Usage:**
```php
if ( is_robots() ) {
    // Custom robots.txt handling
}
```

**Note:** Must be called after the query is run. Before then, always returns false.

---

## robots.txt Generation

### do_robots()

Displays the default robots.txt file content.

```php
function do_robots(): void
```

**Since:** 2.1.0, 5.3.0 (removed "Disallow: /" for non-public sites)

**Output:**
```
User-agent: *
Disallow: /wp-admin/
Allow: /wp-admin/admin-ajax.php
```

**Fires:**
- `do_robotstxt` action before output
- `robots_txt` filter on final output

**Note:** Since 5.3.0, non-public sites no longer output `Disallow: /`. Instead, the `wp_robots_no_robots()` callback adds `noindex` to the meta tag.

---

## Meta Robots Generation

### wp_robots()

Displays the robots meta tag as necessary.

```php
function wp_robots(): void
```

**Since:** 5.7.0, 5.7.1 (allows conflicting directives)

Gathers directives via `wp_robots` filter, sanitizes them, and outputs the meta tag if any directives exist.

**Output:** (if directives present)
```html
<meta name='robots' content='noindex, follow, max-image-preview:large' />
```

**Hooked to:**
- `wp_head` (priority 1)
- `login_head` (priority 1)
- `embed_head` (default priority)

---

## Directive Callbacks

These functions are designed as `wp_robots` filter callbacks.

### wp_robots_noindex()

Adds `noindex` if the site is not public (Settings → Reading → Discourage search engines).

```php
function wp_robots_noindex( array $robots ): array
```

**Since:** 5.7.0

**Parameters:**
- `$robots` — Associative array of robots directives

**Returns:** Modified directives array

**Behavior:**
- If `blog_public` option is false → calls `wp_robots_no_robots()`
- Otherwise → returns unchanged

**Registered:** `add_filter( 'wp_robots', 'wp_robots_noindex' )`

---

### wp_robots_noindex_embeds()

Adds `noindex` for embed requests.

```php
function wp_robots_noindex_embeds( array $robots ): array
```

**Since:** 5.7.0

**Behavior:**
- If `is_embed()` is true → calls `wp_robots_no_robots()`
- Otherwise → returns unchanged

**Registered:** `add_filter( 'wp_robots', 'wp_robots_noindex_embeds' )`

---

### wp_robots_noindex_search()

Adds `noindex` for search result pages.

```php
function wp_robots_noindex_search( array $robots ): array
```

**Since:** 5.7.0

**Behavior:**
- If `is_search()` is true → calls `wp_robots_no_robots()`
- Otherwise → returns unchanged

**Registered:** `add_filter( 'wp_robots', 'wp_robots_noindex_search' )`

---

### wp_robots_no_robots()

Core function that adds `noindex` and appropriate follow directive.

```php
function wp_robots_no_robots( array $robots ): array
```

**Since:** 5.7.0

**Behavior:**
- Always adds `noindex`
- If site is public → adds `follow`
- If site is not public → adds `nofollow`

**Returns:** Directives with `noindex` + `follow`/`nofollow`

**Registered:** Only on login page via `add_filter( 'wp_robots', 'wp_robots_no_robots' )` in `wp-login.php`

---

### wp_robots_sensitive_page()

Adds `noindex` and `noarchive` for sensitive pages.

```php
function wp_robots_sensitive_page( array $robots ): array
```

**Since:** 5.7.0

**Behavior:**
- Adds `noindex`
- Adds `noarchive`

**Usage:**
```php
// For a custom sensitive page template
add_filter( 'wp_robots', 'wp_robots_sensitive_page' );
```

**Not registered by default** — available for custom use.

---

### wp_robots_max_image_preview_large()

Adds `max-image-preview:large` for public sites.

```php
function wp_robots_max_image_preview_large( array $robots ): array
```

**Since:** 5.7.0

**Behavior:**
- If site is public → adds `max-image-preview` = `large`
- Otherwise → returns unchanged

**Purpose:** Allows search engines to display large image previews in results.

**Registered:** `add_filter( 'wp_robots', 'wp_robots_max_image_preview_large' )`

---

## Common Patterns

### Noindex a Custom Post Type Archive

```php
add_filter( 'wp_robots', function( $robots ) {
    if ( is_post_type_archive( 'secret_docs' ) ) {
        $robots['noindex'] = true;
        $robots['nofollow'] = true;
    }
    return $robots;
} );
```

### Remove All Robots Directives

```php
add_filter( 'wp_robots', '__return_empty_array', 999 );
```

### Add Custom Directive

```php
add_filter( 'wp_robots', function( $robots ) {
    $robots['nosnippet'] = true;
    $robots['max-video-preview'] = '0';
    return $robots;
} );
```

### Force Index Despite Site Settings

```php
add_filter( 'wp_robots', function( $robots ) {
    if ( is_singular( 'product' ) ) {
        unset( $robots['noindex'] );
        $robots['index'] = true;
    }
    return $robots;
}, 999 );
```
