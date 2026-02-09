# Embeds / oEmbed API

Framework for embedding rich media content from URLs, both consuming external oEmbed providers and serving WordPress content as embeddable.

**Since:** 2.9.0 (consuming), 4.4.0 (provider)  
**Source:** `wp-includes/embed.php`, `wp-includes/class-wp-embed.php`, `wp-includes/class-wp-oembed.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core embed and oEmbed functions |
| [class-wp-embed.md](./class-wp-embed.md) | Embed handler for content processing |
| [class-wp-oembed.md](./class-wp-oembed.md) | oEmbed consumer for fetching remote embeds |
| [hooks.md](./hooks.md) | Actions and filters |

## Dual Roles

WordPress operates as both:

1. **oEmbed Consumer** - Fetches and displays embeds from external providers (YouTube, Vimeo, Twitter, etc.)
2. **oEmbed Provider** - Serves WordPress posts as embeddable content for other sites

## oEmbed Consumption Flow

```
URL in content (standalone or [embed] shortcode)
    └── WP_Embed::autoembed() / WP_Embed::shortcode()
            ├── Check registered handlers (wp_embed_register_handler)
            │       └── Return custom HTML if matched
            ├── Check cache (post meta or oembed_cache post type)
            │       └── Return cached HTML if fresh
            └── wp_oembed_get()
                    └── WP_oEmbed::get_html()
                            ├── apply_filters('pre_oembed_result') - short circuit
                            ├── get_provider() - find matching provider
                            │       ├── Check built-in providers list
                            │       └── discover() - parse <link> tags if enabled
                            ├── fetch() - HTTP request to provider
                            │       └── Parse JSON/XML response
                            ├── data2html() - convert response to HTML
                            │       └── apply_filters('oembed_dataparse')
                            └── apply_filters('oembed_result')
```

## oEmbed Provider Flow (WordPress as Provider)

```
External site requests: /wp-json/oembed/1.0/embed?url=POST_URL
    └── WP_oEmbed_Controller::get_item()
            ├── get_oembed_response_data()
            │       ├── Validate post exists & is public
            │       ├── Check post type supports embeds
            │       └── Build response data (title, author, etc.)
            └── get_oembed_response_data_rich()
                    ├── Add width/height
                    ├── get_post_embed_html() - iframe + blockquote
                    └── Add thumbnail if available
```

## Provider Registration

### Built-in Providers

WordPress includes 30+ sanctioned providers:

| Provider | URL Patterns | Since |
|----------|--------------|-------|
| YouTube | youtube.com, youtu.be | 2.9.0 |
| Vimeo | vimeo.com | 2.9.0 |
| Twitter/X | twitter.com | 3.4.0 |
| TikTok | tiktok.com | 5.4.0 |
| Spotify | spotify.com | 3.6.0 |
| SoundCloud | soundcloud.com | 3.5.0 |
| Flickr | flickr.com, flic.kr | 2.9.0 |
| Reddit | reddit.com | 4.4.0 |
| Bluesky | bsky.app | 6.6.0 |

See `WP_oEmbed::__construct()` for complete list.

### Adding Custom Providers

```php
// Simple wildcard format
wp_oembed_add_provider(
    'https://example.com/*',
    'https://example.com/oembed'
);

// Regex format
wp_oembed_add_provider(
    '#https?://example\.com/video/(\d+)#i',
    'https://example.com/oembed',
    true // is regex
);
```

### Custom Embed Handlers

For sites without oEmbed support:

```php
wp_embed_register_handler(
    'custom_video',
    '#https?://customvideo\.com/v/([a-z0-9]+)#i',
    function( $matches, $attr, $url, $rawattr ) {
        return sprintf(
            '<iframe src="https://customvideo.com/embed/%s" width="%d" height="%d"></iframe>',
            esc_attr( $matches[1] ),
            esc_attr( $attr['width'] ),
            esc_attr( $attr['height'] )
        );
    }
);
```

## Caching

Embed results are cached in two locations:

### Post Meta (when post context exists)
```
_oembed_{hash}      = HTML result or '{{unknown}}'
_oembed_time_{hash} = timestamp
```

### oembed_cache Post Type (no post context)
```php
post_type   = 'oembed_cache'
post_name   = md5(url + attributes)
post_content = HTML result
```

Cache TTL defaults to `DAY_IN_SECONDS`, filterable via `oembed_ttl`.

## Discovery

When a URL doesn't match known providers, WordPress can discover oEmbed endpoints via `<link>` tags:

```html
<link rel="alternate" type="application/json+oembed" 
      href="https://example.com/oembed?url=..." />
```

Controlled by `embed_oembed_discover` filter (default: true).

## Embed Templates

When WordPress serves its own posts as embeds:

| Template | Purpose |
|----------|---------|
| `embed.php` | Main template wrapper |
| `embed-content.php` | Post content display |
| `embed-404.php` | Not found fallback |
| `header-embed.php` | Embed header |
| `footer-embed.php` | Embed footer |

Themes can override in `theme-compat/` or theme root.

## Security

### Trusted vs Untrusted Providers

- **Trusted** (in `$providers` list): Full HTML allowed
- **Untrusted** (discovered): Filtered through `wp_filter_oembed_result()`
  - Only `<a>`, `<blockquote>`, `<iframe>` allowed
  - iframe gets `sandbox="allow-scripts"` and `security="restricted"`

### Iframe Sandboxing

Embeds from untrusted sources get:
```html
<iframe sandbox="allow-scripts" security="restricted" ...>
```

## Global Instance

```php
global $wp_embed;
// Instance of WP_Embed, initialized during WordPress load
```
