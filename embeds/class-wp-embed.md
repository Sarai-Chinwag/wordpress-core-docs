# WP_Embed Class

API for embedding rich media content from URLs into post content.

**Since:** 2.9.0  
**Source:** `wp-includes/class-wp-embed.php`

## Overview

`WP_Embed` is the core class that processes content and converts URLs to embedded media. It handles:

- `[embed]` shortcode processing
- Auto-embedding of standalone URLs
- Custom embed handler registration
- oEmbed result caching

## Global Instance

```php
global $wp_embed;
```

WordPress initializes `$wp_embed` during load. Use wrapper functions rather than accessing directly.

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$handlers` | array | Registered embed handlers by priority |
| `$post_ID` | int | Current post ID context |
| `$usecache` | bool | Whether to use cached results (default true) |
| `$linkifunknown` | bool | Link URLs that can't be embedded (default true) |
| `$last_attr` | array | Attributes from last shortcode call |
| `$last_url` | string | URL from last shortcode call |
| `$return_false_on_fail` | bool | Return false instead of link on failure |

## Constructor

```php
public function __construct()
```

Sets up:
- `the_content` filter at priority 8 for `run_shortcode()` and `autoembed()`
- Same filters for `widget_text_content` and `widget_block_content`
- Placeholder `[embed]` shortcode for `strip_shortcodes()`
- Admin ajax cache trigger on post save

## Methods

### Handler Registration

#### register_handler()

```php
public function register_handler( 
    string $id, 
    string $regex, 
    callable $callback, 
    int $priority = 10 
): void
```

Registers a custom embed handler.

**Parameters:**
- `$id` - Unique identifier
- `$regex` - URL matching pattern
- `$callback` - Handler function `( $matches, $attr, $url, $rawattr )`
- `$priority` - Lower executes first

**Internal structure:**
```php
$this->handlers[ $priority ][ $id ] = [
    'regex'    => $regex,
    'callback' => $callback,
];
```

---

#### unregister_handler()

```php
public function unregister_handler( string $id, int $priority = 10 ): void
```

Removes a registered handler.

---

### Content Processing

#### run_shortcode()

```php
public function run_shortcode( string $content ): string
```

Processes `[embed]` shortcodes in content.

**Process:**
1. Backs up all registered shortcodes
2. Removes all shortcodes
3. Registers only `[embed]` → `$this->shortcode()`
4. Runs `do_shortcode()`
5. Restores original shortcodes

**Why priority 8?** Runs before `wpautop()` (priority 10) to prevent `<p>` tags around embeds.

---

#### autoembed()

```php
public function autoembed( string $content ): string
```

Converts standalone URLs to embeds without shortcode.

**URL detection:**
- URLs on their own line (with optional whitespace)
- URLs alone in a `<p>` tag

**Process:**
1. Replace newlines in HTML tags with placeholders
2. Match standalone URLs via regex
3. Call `autoembed_callback()` for each match
4. Restore newlines

**Regex patterns:**
```
^(\s*)(https?://[^\s<>"]+)(\s*)$   // Line-level
(<p[^>]*>\s*)(https?://[^\s<>"]+)(\s*</p>)  // Paragraph-level
```

---

#### autoembed_callback()

```php
public function autoembed_callback( array $matches ): string
```

Callback for `autoembed()` regex replacements.

Temporarily sets `$linkifunknown = false` so failed embeds return the URL as-is, not as a link.

---

### Shortcode Handler

#### shortcode()

```php
public function shortcode( array $attr, string $url = '' ): string|false
```

Main `[embed]` shortcode handler.

**Attributes:**
- `src` - Alternative to URL in shortcode content
- `width` - Override width
- `height` - Override height

**Process:**
1. Get URL from content or `src` attribute
2. Fix KSES `&amp;` → `&` conversion
3. Check registered handlers first
4. Check cache (post meta or oembed_cache post type)
5. If not cached or expired, call `wp_oembed_get()`
6. Store result in cache
7. Return HTML or fallback link

**Caching keys:**
```php
$key_suffix = md5( $url . serialize( $attr ) );
$cachekey = '_oembed_' . $key_suffix;
$cachekey_time = '_oembed_time_' . $key_suffix;
```

**Cache TTL:** Controlled by `oembed_ttl` filter (default `DAY_IN_SECONDS`).

---

#### get_embed_handler_html()

```php
public function get_embed_handler_html( array $attr, string $url ): string|false
```

Checks registered handlers for URL match.

**Since:** 5.5.0

**Process:**
1. Sort handlers by priority (`ksort`)
2. Test each handler's regex against URL
3. If match, call handler callback
4. Apply `embed_handler_html` filter to result

---

### Caching

#### cache_oembed()

```php
public function cache_oembed( int $post_id ): void
```

Triggers caching of all embeds in a post's content.

Called via admin-ajax after post save. Processes content with `$usecache = false` to force fresh fetches.

---

#### delete_oembed_caches()

```php
public function delete_oembed_caches( int $post_id ): void
```

Deletes all oEmbed cache entries from post meta.

**Note:** Unused by core since 4.0.0.

Removes all meta keys starting with `_oembed_`.

---

#### find_oembed_post_id()

```php
public function find_oembed_post_id( string $cache_key ): int|null
```

Finds cached embed stored as `oembed_cache` post type.

**Since:** 4.9.0

Uses object cache (`oembed_cache_post` group) for performance.

---

### Fallback Handling

#### maybe_make_link()

```php
public function maybe_make_link( string $url ): string|false
```

Returns linked URL or plain URL when embed fails.

**Behavior:**
- If `$return_false_on_fail` → returns `false`
- If `$linkifunknown` → returns `<a href="...">URL</a>`
- Otherwise → returns URL as-is

Filtered by `embed_maybe_make_link`.

---

### Admin Integration

#### maybe_run_ajax_cache()

```php
public function maybe_run_ajax_cache(): void
```

Outputs JavaScript to trigger cache refresh on post save.

Hooked to `edit_form_advanced` and `edit_page_form`.

**Output:**
```javascript
jQuery( function($) {
    $.get( "/wp-admin/admin-ajax.php?action=oembed-cache&post=123" );
} );
```

---

## Usage Example

### Processing Content

```php
// WordPress handles this automatically via filters, but manually:
global $wp_embed;

$content = 'Check out this video: https://www.youtube.com/watch?v=dQw4w9WgXcQ';
$content = $wp_embed->autoembed( $content );
```

### Custom Handler

```php
global $wp_embed;

$wp_embed->register_handler(
    'viddler',
    '#https?://(?:www\.)?viddler\.com/v/([a-z0-9]+)#i',
    function( $matches, $attr, $url, $rawattr ) {
        return sprintf(
            '<iframe src="https://www.viddler.com/embed/%s" width="%d" height="%d"></iframe>',
            esc_attr( $matches[1] ),
            esc_attr( $attr['width'] ),
            esc_attr( $attr['height'] )
        );
    },
    5 // Higher priority (lower number)
);
```

### Disable Auto-Embed

```php
// Remove autoembed from content
remove_filter( 'the_content', [ $GLOBALS['wp_embed'], 'autoembed' ], 8 );
```

### Force Fresh Fetch

```php
global $wp_embed;

$wp_embed->usecache = false;
$html = $wp_embed->shortcode( [], 'https://example.com/video' );
$wp_embed->usecache = true;
```

## Filters Applied

| Filter | Location | Purpose |
|--------|----------|---------|
| `embed_handler_html` | `get_embed_handler_html()` | Filter handler output |
| `oembed_ttl` | `shortcode()` | Cache duration |
| `embed_oembed_html` | `shortcode()` | Filter cached/fetched HTML |
| `embed_oembed_discover` | `shortcode()` | Enable URL discovery |
| `embed_cache_oembed_types` | `cache_oembed()` | Post types to cache |
| `embed_maybe_make_link` | `maybe_make_link()` | Filter fallback link |

## Cache Storage

### With Post Context

```php
// Stored in post meta
update_post_meta( $post_id, '_oembed_abc123', '<iframe...>' );
update_post_meta( $post_id, '_oembed_time_abc123', time() );
```

### Without Post Context

```php
// Stored as oembed_cache post type
wp_insert_post([
    'post_type'    => 'oembed_cache',
    'post_status'  => 'publish',
    'post_name'    => 'abc123...',  // md5 hash
    'post_content' => '<iframe...>',
]);
```

### Failed Embed Marker

```php
// Stores special marker to prevent re-fetching
update_post_meta( $post_id, '_oembed_abc123', '{{unknown}}' );
```
