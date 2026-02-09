# Robots Hooks

## Filters

### wp_robots

Filters the directives to be included in the robots meta tag.

```php
apply_filters( 'wp_robots', array $robots ): array
```

**Since:** 5.7.0

**Parameters:**
- `$robots` — Associative array where keys are directive names and values are either:
  - `true` for boolean directives (e.g., `noindex`)
  - String values for parameterized directives (e.g., `max-image-preview` => `large`)

**Returns:** Modified directives array

**Default Callbacks:**

| Callback | Priority | Condition |
|----------|----------|-----------|
| `wp_robots_noindex` | 10 | Always registered |
| `wp_robots_noindex_embeds` | 10 | Always registered |
| `wp_robots_noindex_search` | 10 | Always registered |
| `wp_robots_max_image_preview_large` | 10 | Always registered |
| `wp_robots_no_robots` | 10 | Login page only |

**Example — Add noindex to author archives:**
```php
add_filter( 'wp_robots', function( $robots ) {
    if ( is_author() ) {
        $robots['noindex'] = true;
        $robots['follow'] = true;
    }
    return $robots;
} );
```

**Example — Remove max-image-preview:**
```php
add_filter( 'wp_robots', function( $robots ) {
    unset( $robots['max-image-preview'] );
    return $robots;
}, 20 );
```

---

### robots_txt

Filters the robots.txt output.

```php
apply_filters( 'robots_txt', string $output, bool $public ): string
```

**Since:** 3.0.0

**Parameters:**
- `$output` — The robots.txt content
- `$public` — Whether the site is public (`blog_public` option)

**Returns:** Modified robots.txt content string

**Example — Add sitemap:**
```php
add_filter( 'robots_txt', function( $output, $public ) {
    if ( $public ) {
        $output .= "Sitemap: " . home_url( '/sitemap.xml' ) . "\n";
    }
    return $output;
}, 10, 2 );
```

**Example — Block specific crawlers:**
```php
add_filter( 'robots_txt', function( $output ) {
    $output .= "\nUser-agent: GPTBot\n";
    $output .= "Disallow: /\n";
    $output .= "\nUser-agent: CCBot\n";
    $output .= "Disallow: /\n";
    return $output;
} );
```

**Example — Disallow entire site for non-public:**
```php
add_filter( 'robots_txt', function( $output, $public ) {
    if ( ! $public ) {
        return "User-agent: *\nDisallow: /\n";
    }
    return $output;
}, 10, 2 );
```

---

## Actions

### do_robotstxt

Fires when displaying the robots.txt file.

```php
do_action( 'do_robotstxt' )
```

**Since:** 2.1.0

Fires before the default robots.txt content is output. Headers have already been sent (`Content-Type: text/plain`).

**Example — Log robots.txt requests:**
```php
add_action( 'do_robotstxt', function() {
    error_log( 'robots.txt accessed: ' . $_SERVER['REMOTE_ADDR'] );
} );
```

**Example — Output additional content before default:**
```php
add_action( 'do_robotstxt', function() {
    echo "# Custom robots.txt for " . get_bloginfo( 'name' ) . "\n\n";
} );
```

---

### do_robots

Action hook for serving the robots.txt file.

```php
do_action( 'do_robots' )
```

**Since:** 2.1.0

Fired by `template-loader.php` when `is_robots()` is true. The default handler `do_robots()` is attached to this action.

**Example — Complete custom robots.txt:**
```php
// Remove default handler
remove_action( 'do_robots', 'do_robots' );

// Add custom handler
add_action( 'do_robots', function() {
    header( 'Content-Type: text/plain; charset=utf-8' );
    echo file_get_contents( ABSPATH . 'custom-robots.txt' );
} );
```

---

## Hook Registration Reference

From `wp-includes/default-filters.php`:

```php
// Meta robots filter callbacks
add_filter( 'wp_robots', 'wp_robots_noindex' );
add_filter( 'wp_robots', 'wp_robots_noindex_embeds' );
add_filter( 'wp_robots', 'wp_robots_noindex_search' );
add_filter( 'wp_robots', 'wp_robots_max_image_preview_large' );

// Output meta robots tag
add_action( 'wp_head', 'wp_robots', 1 );
add_action( 'login_head', 'wp_robots', 1 );
add_action( 'embed_head', 'wp_robots' );

// Login page gets noindex
if ( ... login context ... ) {
    add_filter( 'wp_robots', 'wp_robots_no_robots' );
}

// robots.txt handler
add_action( 'do_robots', 'do_robots' );
```

---

## Directive Reference

Standard robots meta directives:

| Directive | Type | Description |
|-----------|------|-------------|
| `index` | boolean | Allow indexing |
| `noindex` | boolean | Prevent indexing |
| `follow` | boolean | Follow links |
| `nofollow` | boolean | Don't follow links |
| `noarchive` | boolean | Don't cache/archive page |
| `nosnippet` | boolean | No text snippets in results |
| `max-snippet` | value | Max snippet length (`max-snippet:150`) |
| `max-image-preview` | value | Image preview size (`none`, `standard`, `large`) |
| `max-video-preview` | value | Video preview seconds (`-1` for unlimited) |
| `notranslate` | boolean | Don't offer translation |
| `noimageindex` | boolean | Don't index images |
| `unavailable_after` | value | Date to stop showing in results |
