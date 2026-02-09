# Embed Functions

Core functions for embedding content and managing oEmbed providers.

**Source:** `wp-includes/embed.php`

## Handler Registration

### wp_embed_register_handler()

Registers a custom embed handler for URLs that don't support oEmbed.

```php
wp_embed_register_handler( 
    string $id, 
    string $regex, 
    callable $callback, 
    int $priority = 10 
): void
```

**Parameters:**
- `$id` - Unique handler identifier
- `$regex` - Pattern to match URLs
- `$callback` - Function receiving `( $matches, $attr, $url, $rawattr )`
- `$priority` - Lower runs first (default 10)

**Example:**
```php
wp_embed_register_handler(
    'custom_video',
    '#https?://customvideo\.com/v/([a-z0-9]+)#i',
    function( $matches, $attr, $url, $rawattr ) {
        return '<iframe src="https://customvideo.com/embed/' . 
               esc_attr( $matches[1] ) . '"></iframe>';
    }
);
```

---

### wp_embed_unregister_handler()

Removes a previously registered embed handler.

```php
wp_embed_unregister_handler( string $id, int $priority = 10 ): void
```

---

## Provider Management

### wp_oembed_add_provider()

Adds an oEmbed provider URL pattern.

```php
wp_oembed_add_provider( 
    string $format, 
    string $provider, 
    bool $regex = false 
): void
```

**Parameters:**
- `$format` - URL pattern (wildcards `*` or regex if `$regex` is true)
- `$provider` - oEmbed endpoint URL
- `$regex` - Whether `$format` is a regex pattern

**Examples:**
```php
// Wildcard format
wp_oembed_add_provider(
    'https://example.com/video/*',
    'https://example.com/oembed'
);

// Regex format
wp_oembed_add_provider(
    '#https?://example\.com/(video|audio)/\d+#i',
    'https://example.com/oembed',
    true
);
```

---

### wp_oembed_remove_provider()

Removes an oEmbed provider.

```php
wp_oembed_remove_provider( string $format ): bool
```

**Returns:** `true` if removed, `false` otherwise.

---

## Fetching Embeds

### wp_oembed_get()

Fetches embed HTML for a URL using oEmbed.

```php
wp_oembed_get( string $url, array|string $args = '' ): string|false
```

**Parameters:**
- `$url` - URL to embed
- `$args` - Optional arguments:
  - `width` - Maximum width
  - `height` - Maximum height  
  - `discover` - Whether to attempt discovery (default true)

**Returns:** HTML string or `false` on failure.

**Example:**
```php
$html = wp_oembed_get( 
    'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    [ 'width' => 600 ]
);
```

---

### wp_embed_defaults()

Gets default embed dimensions based on theme content width.

```php
wp_embed_defaults( string $url = '' ): array
```

**Returns:** `[ 'width' => int, 'height' => int ]`

**Logic:**
- Width: `$content_width` global or 500px
- Height: min( width × 1.5, 1000 )

Filterable via `embed_defaults`.

---

### _wp_oembed_get_object()

Returns the singleton WP_oEmbed instance.

```php
_wp_oembed_get_object(): WP_oEmbed
```

**Note:** Private function, use `wp_oembed_get()` instead.

---

## Post Embed URLs

### get_post_embed_url()

Gets the URL to view a post embedded in an iframe.

```php
get_post_embed_url( int|WP_Post $post = null ): string|false
```

**Returns:** URL like `https://example.com/post-slug/embed/`

**Example:**
```php
$embed_url = get_post_embed_url( 123 );
// https://example.com/my-post/embed/
```

---

### get_oembed_endpoint_url()

Gets the oEmbed REST API endpoint URL.

```php
get_oembed_endpoint_url( string $permalink = '', string $format = 'json' ): string
```

**Parameters:**
- `$permalink` - Post URL (empty for base endpoint)
- `$format` - 'json' or 'xml'

**Returns:** REST endpoint URL with query params.

**Example:**
```php
$endpoint = get_oembed_endpoint_url( get_permalink( 123 ) );
// https://example.com/wp-json/oembed/1.0/embed?url=...
```

---

### get_post_embed_html()

Generates the full embed code (iframe + blockquote fallback).

```php
get_post_embed_html( int $width, int $height, int|WP_Post $post = null ): string|false
```

**Returns:** Complete embed markup including:
- `<blockquote>` fallback with link
- `<iframe>` with sandbox restrictions
- Inline JavaScript for communication

**Example:**
```php
$embed_code = get_post_embed_html( 600, 400, $post );
```

---

## oEmbed Response Data

### get_oembed_response_data()

Builds oEmbed response array for a post.

```php
get_oembed_response_data( WP_Post|int $post, int $width ): array|false
```

**Returns:** Array with oEmbed spec fields:
```php
[
    'version'       => '1.0',
    'provider_name' => 'Site Name',
    'provider_url'  => 'https://example.com',
    'author_name'   => 'Display Name',
    'author_url'    => 'https://example.com/author/...',
    'title'         => 'Post Title',
    'type'          => 'link', // becomes 'rich' after filtering
]
```

**Validation:**
- Returns `false` if post doesn't exist
- Returns `false` if not publicly viewable
- Returns `false` if post type doesn't support embeds

---

### get_oembed_response_data_rich()

Filter callback that adds rich embed data.

```php
get_oembed_response_data_rich( 
    array $data, 
    WP_Post $post, 
    int $width, 
    int $height 
): array
```

**Adds:**
- `width`, `height` - Dimensions
- `type` - Changed to 'rich' (or 'video' for video attachments)
- `html` - Full embed markup
- `thumbnail_url`, `thumbnail_width`, `thumbnail_height` - If available

---

### get_oembed_response_data_for_url()

Gets oEmbed data for a URL (handles multisite).

```php
get_oembed_response_data_for_url( string $url, array $args ): object|false
```

**Multisite handling:**
- Detects target blog from URL
- Switches blog context if needed
- Rejects deleted/spam/archived sites

---

## Format Handling

### wp_oembed_ensure_format()

Validates format parameter.

```php
wp_oembed_ensure_format( string $format ): string
```

**Returns:** 'json' or 'xml' (defaults to 'json').

---

## Filtering & Security

### wp_filter_oembed_result()

Sanitizes oEmbed HTML from untrusted providers.

```php
wp_filter_oembed_result( 
    string|false $result, 
    object $data, 
    string $url 
): string|false
```

**Security measures:**
- Only `<a>`, `<blockquote>`, `<iframe>` allowed
- Adds `sandbox="allow-scripts"` to iframes
- Adds `security="restricted"` attribute
- Generates unique secret for iframe communication
- Adds `data-secret` attributes

**Note:** Trusted providers (in built-in list) bypass this filter.

---

### wp_filter_oembed_iframe_title_attribute()

Ensures iframes have title attributes for accessibility.

```php
wp_filter_oembed_iframe_title_attribute( 
    string|false $result, 
    object $data, 
    string $url 
): string|false
```

---

### wp_filter_pre_oembed_result()

Short-circuits oEmbed for local URLs.

```php
wp_filter_pre_oembed_result( 
    null|string $result, 
    string $url, 
    array $args 
): null|string
```

If URL belongs to current site, fetches embed data directly instead of making HTTP request.

---

## Embed Handlers

### wp_embed_handler_youtube()

Handles YouTube embed/v URLs not parseable by standard oEmbed.

```php
wp_embed_handler_youtube( 
    array $matches, 
    array $attr, 
    string $url, 
    array $rawattr 
): string
```

Converts `youtube.com/embed/ID` to `youtube.com/watch?v=ID` and processes.

---

### wp_embed_handler_audio()

Converts audio file URLs to `[audio]` shortcode.

```php
wp_embed_handler_audio( 
    array $matches, 
    array $attr, 
    string $url, 
    array $rawattr 
): string
```

---

### wp_embed_handler_video()

Converts video file URLs to `[video]` shortcode.

```php
wp_embed_handler_video( 
    array $matches, 
    array $attr, 
    string $url, 
    array $rawattr 
): string
```

---

## Discovery Links

### wp_oembed_add_discovery_links()

Outputs oEmbed discovery `<link>` tags in `<head>`.

```php
wp_oembed_add_discovery_links(): void
```

**Output (for embeddable posts):**
```html
<link rel="alternate" type="application/json+oembed" 
      href="https://example.com/wp-json/oembed/1.0/embed?url=..." />
<link rel="alternate" type="text/xml+oembed" 
      href="https://example.com/wp-json/oembed/1.0/embed?url=...&format=xml" />
```

---

### wp_oembed_add_host_js()

**Deprecated since 5.9.0** - Use `wp_maybe_enqueue_oembed_host_js()`.

Placeholder for backward compatibility.

---

### wp_maybe_enqueue_oembed_host_js()

Conditionally enqueues `wp-embed` script when content has post embeds.

```php
wp_maybe_enqueue_oembed_host_js( string $html ): string
```

**Detection:** Looks for `<blockquote ... wp-embedded-content` in HTML.

---

## Embed Template Functions

### the_excerpt_embed()

Displays post excerpt for embed template.

```php
the_excerpt_embed(): void
```

Filterable via `the_excerpt_embed`.

---

### wp_embed_excerpt_more()

Filters excerpt "more" string for embeds.

```php
wp_embed_excerpt_more( string $more_string ): string
```

Replaces `[...]` with `... Continue reading [title]`.

---

### wp_embed_excerpt_attachment()

Handles attachment excerpts in embeds.

```php
wp_embed_excerpt_attachment( string $content ): string
```

Shows audio/video player for media attachments.

---

### enqueue_embed_scripts()

Hook point for enqueueing embed iframe assets.

```php
enqueue_embed_scripts(): void
```

Fires `enqueue_embed_scripts` action.

---

### print_embed_scripts()

Prints JavaScript in embed iframe.

```php
print_embed_scripts(): void
```

Outputs `wp-embed-template.js`.

---

### wp_enqueue_embed_styles()

Enqueues CSS for embed iframe.

```php
wp_enqueue_embed_styles(): void
```

Outputs `wp-embed-template.css`.

---

### print_embed_comments_button()

Outputs comments button in embed footer.

```php
print_embed_comments_button(): void
```

---

### print_embed_sharing_button()

Outputs share button in embed footer.

```php
print_embed_sharing_button(): void
```

---

### print_embed_sharing_dialog()

Outputs sharing dialog with URL and HTML embed options.

```php
print_embed_sharing_dialog(): void
```

---

### the_embed_site_title()

Outputs site title with icon in embed footer.

```php
the_embed_site_title(): void
```

---

## REST API

### wp_oembed_register_route()

Registers the oEmbed REST endpoint.

```php
wp_oembed_register_route(): void
```

**Endpoint:** `GET /wp-json/oembed/1.0/embed`

**Parameters:**
- `url` (required) - Post URL
- `format` - 'json' or 'xml'
- `maxwidth` - Maximum width

---

## Internal Functions

### _oembed_rest_pre_serve_request()

Intercepts REST response to output XML format.

```php
_oembed_rest_pre_serve_request( 
    bool $served, 
    WP_HTTP_Response $result, 
    WP_REST_Request $request, 
    WP_REST_Server $server 
): bool
```

---

### _oembed_create_xml()

Converts oEmbed data array to XML string.

```php
_oembed_create_xml( array $data, SimpleXMLElement $node = null ): string|false
```

---

### _oembed_filter_feed_content()

Prepares oEmbed HTML for RSS feeds.

```php
_oembed_filter_feed_content( string $content ): string
```

Removes inline styles from `wp-embedded-content` iframes.

---

## Loading

### wp_maybe_load_embeds()

Conditionally loads default embed handlers.

```php
wp_maybe_load_embeds(): void
```

Registers handlers for:
- YouTube embed URLs
- Audio files (.mp3, .ogg, etc.)
- Video files (.mp4, .webm, etc.)

Controlled by `load_default_embeds` filter.
