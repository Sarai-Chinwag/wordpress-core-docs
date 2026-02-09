# Embed Hooks

Actions and filters for the WordPress Embeds/oEmbed system.

## Filters

### Provider Management

#### oembed_providers

Filters the list of registered oEmbed providers.

```php
apply_filters( 'oembed_providers', array $providers ): array
```

**Location:** `WP_oEmbed::__construct()`

**Parameters:**
- `$providers` - Array of URL pattern → endpoint mappings

**Example:**
```php
add_filter( 'oembed_providers', function( $providers ) {
    // Add custom provider
    $providers['#https?://custom\.example\.com/video/\d+#i'] = [
        'https://custom.example.com/oembed',
        true // is regex
    ];
    
    // Remove a provider
    unset( $providers['#https?://tiktok\.com.*#i'] );
    
    return $providers;
} );
```

---

### Embed Defaults

#### embed_defaults

Filters default embed dimensions.

```php
apply_filters( 'embed_defaults', array $size, string $url ): array
```

**Location:** `wp_embed_defaults()`

**Parameters:**
- `$size` - `[ 'width' => int, 'height' => int ]`
- `$url` - URL being embedded

**Example:**
```php
add_filter( 'embed_defaults', function( $size, $url ) {
    if ( str_contains( $url, 'youtube.com' ) ) {
        return [ 'width' => 800, 'height' => 450 ];
    }
    return $size;
}, 10, 2 );
```

---

### Pre-Fetch Hooks

#### pre_oembed_result

Short-circuits oEmbed fetching before HTTP request.

```php
apply_filters( 'pre_oembed_result', null|string $result, string $url, array $args ): null|string
```

**Location:** `WP_oEmbed::get_html()`

**Parameters:**
- `$result` - Return non-null to skip fetching
- `$url` - Content URL
- `$args` - Width, height, discover settings

**Example:**
```php
add_filter( 'pre_oembed_result', function( $result, $url, $args ) {
    // Return cached HTML from external cache
    $cached = wp_cache_get( 'oembed_' . md5( $url ), 'embeds' );
    return $cached ?: $result;
}, 10, 3 );
```

---

#### embed_oembed_discover

Controls whether URL discovery is attempted.

```php
apply_filters( 'embed_oembed_discover', bool $enable ): bool
```

**Location:** `WP_Embed::shortcode()`

**Default:** `true`

**Example:**
```php
// Disable discovery (only use registered providers)
add_filter( 'embed_oembed_discover', '__return_false' );
```

---

### HTTP Request Hooks

#### oembed_remote_get_args

Filters HTTP request arguments.

```php
apply_filters( 'oembed_remote_get_args', array $args, string $url ): array
```

**Location:** `WP_oEmbed::discover()`, `WP_oEmbed::_fetch_with_format()`

**Parameters:**
- `$args` - WP_Http request arguments
- `$url` - URL being fetched

**Example:**
```php
add_filter( 'oembed_remote_get_args', function( $args, $url ) {
    $args['timeout'] = 30; // Increase timeout
    $args['user-agent'] = 'MyPlugin/1.0';
    return $args;
}, 10, 2 );
```

---

#### oembed_fetch_url

Filters the provider URL before fetch.

```php
apply_filters( 'oembed_fetch_url', string $provider, string $url, array $args ): string
```

**Location:** `WP_oEmbed::fetch()`

**Parameters:**
- `$provider` - Full provider URL with query params
- `$url` - Original content URL
- `$args` - Embed arguments

**Example:**
```php
add_filter( 'oembed_fetch_url', function( $provider, $url, $args ) {
    // Add custom parameter
    return add_query_arg( 'theme', 'dark', $provider );
}, 10, 3 );
```

---

#### oembed_linktypes

Filters discoverable link types.

```php
apply_filters( 'oembed_linktypes', array $linktypes ): array
```

**Location:** `WP_oEmbed::discover()`

**Default:**
```php
[
    'application/json+oembed' => 'json',
    'text/xml+oembed' => 'xml',
    'application/xml+oembed' => 'xml',
]
```

---

### Result Processing

#### oembed_result

Filters the final oEmbed HTML result.

```php
apply_filters( 'oembed_result', string|false $data, string $url, array $args ): string|false
```

**Location:** `WP_oEmbed::get_html()`

**Parameters:**
- `$data` - HTML result (or false)
- `$url` - Content URL
- `$args` - Embed arguments

---

#### oembed_dataparse

Filters HTML generated from oEmbed data.

```php
apply_filters( 'oembed_dataparse', string|false $return, object $data, string $url ): string|false
```

**Location:** `WP_oEmbed::data2html()`

**Parameters:**
- `$return` - Generated HTML
- `$data` - oEmbed response object
- `$url` - Content URL

**Example:**
```php
add_filter( 'oembed_dataparse', function( $html, $data, $url ) {
    if ( isset( $data->type ) && $data->type === 'video' ) {
        // Wrap in responsive container
        return '<div class="video-wrapper">' . $html . '</div>';
    }
    return $html;
}, 10, 3 );
```

---

#### embed_oembed_html

Filters cached or fetched embed HTML.

```php
apply_filters( 'embed_oembed_html', string $cache, string $url, array $attr, int $post_id ): string
```

**Location:** `WP_Embed::shortcode()`

**Parameters:**
- `$cache` - Cached/fetched HTML
- `$url` - Content URL
- `$attr` - Shortcode attributes
- `$post_id` - Post ID context

**Example:**
```php
add_filter( 'embed_oembed_html', function( $html, $url, $attr, $post_id ) {
    // Add lazy loading to iframes
    return str_replace( '<iframe', '<iframe loading="lazy"', $html );
}, 10, 4 );
```

---

#### embed_handler_html

Filters custom handler output.

```php
apply_filters( 'embed_handler_html', string $return, string $url, array $attr ): string
```

**Location:** `WP_Embed::get_embed_handler_html()`

---

### Fallback Handling

#### embed_maybe_make_link

Filters fallback when URL can't be embedded.

```php
apply_filters( 'embed_maybe_make_link', string $output, string $url ): string
```

**Location:** `WP_Embed::maybe_make_link()`

**Example:**
```php
add_filter( 'embed_maybe_make_link', function( $output, $url ) {
    // Don't link unknown URLs
    return $url;
}, 10, 2 );
```

---

### Caching

#### oembed_ttl

Filters cache duration.

```php
apply_filters( 'oembed_ttl', int $time, string $url, array $attr, int $post_id ): int
```

**Location:** `WP_Embed::shortcode()`

**Default:** `DAY_IN_SECONDS` (86400)

**Example:**
```php
add_filter( 'oembed_ttl', function( $ttl, $url ) {
    // Cache YouTube for a week
    if ( str_contains( $url, 'youtube.com' ) ) {
        return WEEK_IN_SECONDS;
    }
    return $ttl;
}, 10, 2 );
```

---

#### embed_cache_oembed_types

Filters post types for caching.

```php
apply_filters( 'embed_cache_oembed_types', array $post_types ): array
```

**Location:** `WP_Embed::cache_oembed()`

**Default:** Post types with `show_ui = true`

---

### Default Handlers

#### load_default_embeds

Controls loading of default embed handlers.

```php
apply_filters( 'load_default_embeds', bool $load ): bool
```

**Location:** `wp_maybe_load_embeds()`

**Default:** `true`

**Example:**
```php
// Disable default handlers (audio, video file embeds)
add_filter( 'load_default_embeds', '__return_false' );
```

---

#### wp_audio_embed_handler

Filters audio file handler callback.

```php
apply_filters( 'wp_audio_embed_handler', callable $handler ): callable
```

**Default:** `'wp_embed_handler_audio'`

---

#### wp_video_embed_handler

Filters video file handler callback.

```php
apply_filters( 'wp_video_embed_handler', callable $handler ): callable
```

**Default:** `'wp_embed_handler_video'`

---

### Specific Handler Filters

#### wp_embed_handler_youtube

Filters YouTube handler output.

```php
apply_filters( 'wp_embed_handler_youtube', string $embed, array $attr, string $url, array $rawattr ): string
```

---

#### wp_embed_handler_audio

Filters audio handler output.

```php
apply_filters( 'wp_embed_handler_audio', string $audio, array $attr, string $url, array $rawattr ): string
```

---

#### wp_embed_handler_video

Filters video handler output.

```php
apply_filters( 'wp_embed_handler_video', string $video, array $attr, string $url, array $rawattr ): string
```

---

### WordPress as Provider

#### oembed_min_max_width

Filters embed dimension limits.

```php
apply_filters( 'oembed_min_max_width', array $min_max ): array
```

**Location:** `get_oembed_response_data()`

**Default:** `[ 'min' => 200, 'max' => 600 ]`

---

#### oembed_response_data

Filters oEmbed response data.

```php
apply_filters( 'oembed_response_data', array $data, WP_Post $post, int $width, int $height ): array
```

**Location:** `get_oembed_response_data()`

---

#### oembed_request_post_id

Filters post ID for oEmbed request.

```php
apply_filters( 'oembed_request_post_id', int $post_id, string $url ): int
```

**Location:** `get_oembed_response_data_for_url()`

---

#### post_embed_url

Filters post embed URL.

```php
apply_filters( 'post_embed_url', string $embed_url, WP_Post $post ): string
```

**Location:** `get_post_embed_url()`

---

#### oembed_endpoint_url

Filters oEmbed API endpoint URL.

```php
apply_filters( 'oembed_endpoint_url', string $url, string $permalink, string $format ): string
```

**Location:** `get_oembed_endpoint_url()`

---

#### embed_html

Filters generated embed HTML.

```php
apply_filters( 'embed_html', string $output, WP_Post $post, int $width, int $height ): string
```

**Location:** `get_post_embed_html()`

---

#### oembed_discovery_links

Filters discovery link HTML.

```php
apply_filters( 'oembed_discovery_links', string $output ): string
```

**Location:** `wp_oembed_add_discovery_links()`

---

#### oembed_iframe_title_attribute

Filters iframe title for accessibility.

```php
apply_filters( 'oembed_iframe_title_attribute', string $title, string $result, object $data, string $url ): string
```

**Location:** `wp_filter_oembed_iframe_title_attribute()`

---

#### the_excerpt_embed

Filters excerpt in embed template.

```php
apply_filters( 'the_excerpt_embed', string $output ): string
```

**Location:** `the_excerpt_embed()`

---

#### embed_site_title_html

Filters site title in embed footer.

```php
apply_filters( 'embed_site_title_html', string $site_title ): string
```

**Location:** `the_embed_site_title()`

---

## Actions

### Embed Template

#### enqueue_embed_scripts

Fires when embed template assets should be enqueued.

```php
do_action( 'enqueue_embed_scripts' )
```

**Location:** `enqueue_embed_scripts()`

**Example:**
```php
add_action( 'enqueue_embed_scripts', function() {
    wp_enqueue_style( 'my-embed-style', plugins_url( 'embed.css', __FILE__ ) );
} );
```

---

#### embed_head

Fires in embed template `<head>`.

```php
do_action( 'embed_head' )
```

Standard actions hooked:
- `enqueue_embed_scripts` (priority 1)
- `print_embed_styles` (priority 8)
- `wp_print_head_scripts` (priority 9)
- `print_embed_scripts` (priority default)

---

#### embed_footer

Fires in embed template footer.

```php
do_action( 'embed_footer' )
```

Standard actions hooked:
- `print_embed_sharing_dialog`
- `print_embed_scripts`
- `wp_print_footer_scripts`

---

#### embed_content

Fires after embed content.

```php
do_action( 'embed_content' )
```

---

#### embed_content_meta

Fires in embed meta section.

```php
do_action( 'embed_content_meta' )
```

Hooks for comments button and share button.

---

## Common Patterns

### Add YouTube Parameters

```php
add_filter( 'oembed_fetch_url', function( $provider, $url ) {
    if ( str_contains( $provider, 'youtube.com/oembed' ) ) {
        $provider = add_query_arg( [
            'rel' => 0,
            'modestbranding' => 1,
        ], $provider );
    }
    return $provider;
}, 10, 2 );
```

### Lazy Load All Embeds

```php
add_filter( 'embed_oembed_html', function( $html ) {
    return preg_replace(
        '/<iframe\s/',
        '<iframe loading="lazy" ',
        $html
    );
} );
```

### Disable Specific Provider

```php
add_filter( 'oembed_providers', function( $providers ) {
    foreach ( $providers as $pattern => $data ) {
        if ( str_contains( $pattern, 'tiktok' ) ) {
            unset( $providers[ $pattern ] );
        }
    }
    return $providers;
} );
```

### Custom oEmbed Response

```php
add_filter( 'oembed_response_data', function( $data, $post, $width, $height ) {
    $data['custom_field'] = get_post_meta( $post->ID, 'my_field', true );
    return $data;
}, 10, 4 );
```

### Wrap Embeds in Container

```php
add_filter( 'embed_oembed_html', function( $html, $url, $attr, $post_id ) {
    return sprintf(
        '<div class="embed-container" data-url="%s">%s</div>',
        esc_attr( $url ),
        $html
    );
}, 10, 4 );
```
