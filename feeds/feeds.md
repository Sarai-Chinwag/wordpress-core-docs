# WordPress Feed API Overview

The WordPress Feed API provides functionality for both generating outgoing feeds (RSS, Atom, RDF) and consuming external feeds via SimplePie integration.

## Feed Types

WordPress supports multiple feed formats out of the box:

| Format | Template File | Content-Type | Description |
|--------|--------------|--------------|-------------|
| RSS 2.0 | `feed-rss2.php` | `application/rss+xml` | Default feed format, most widely used |
| Atom | `feed-atom.php` | `application/atom+xml` | Modern syndication format with richer metadata |
| RSS 1.0 (RDF) | `feed-rdf.php` | `application/rdf+xml` | RDF-based RSS with Dublin Core elements |
| RSS 0.92 | `feed-rss.php` | `application/rss+xml` | Legacy format with minimal features |

### Comment Feeds

WordPress also generates dedicated comment feeds:

| Format | Template File | Description |
|--------|--------------|-------------|
| RSS 2.0 Comments | `feed-rss2-comments.php` | Site-wide or per-post comment feeds |
| Atom Comments | `feed-atom-comments.php` | Atom format with threading support (RFC 4685) |

## Feed URLs

Standard feed endpoints:

```
/feed/                  # Default feed (RSS 2.0)
/feed/rss2/             # RSS 2.0 explicitly
/feed/atom/             # Atom feed
/feed/rdf/              # RSS 1.0 (RDF)
/feed/rss/              # RSS 0.92

/comments/feed/         # Site-wide comment feed
/category/{slug}/feed/  # Category feed
/tag/{slug}/feed/       # Tag feed
/author/{name}/feed/    # Author feed
/{post-slug}/feed/      # Post comment feed
```

## SimplePie Integration

WordPress uses SimplePie for consuming external feeds. The integration consists of:

### Core Classes

| Class | File | Purpose |
|-------|------|---------|
| `WP_Feed_Cache_Transient` | `class-wp-feed-cache-transient.php` | Caches feed data using site transients |
| `WP_Feed_Cache` | `class-wp-feed-cache.php` | Legacy cache wrapper (deprecated 5.6.0) |
| `WP_SimplePie_File` | `class-wp-simplepie-file.php` | HTTP requests via WordPress HTTP API |
| `WP_SimplePie_Sanitize_KSES` | `class-wp-simplepie-sanitize-kses.php` | Content sanitization using KSES |

### Cache Behavior

Feed caching uses WordPress transients with multisite-aware storage:

- **Default lifetime**: 12 hours (43200 seconds)
- **Storage**: Site transients (`*_site_transient()`)
- **Transient names**: `feed_{hash}` for data, `feed_mod_{hash}` for modification time

## Feed Generation Flow

1. Request hits feed endpoint (e.g., `/feed/`)
2. WordPress loads the appropriate template (`feed-rss2.php`)
3. Template sets `Content-Type` header via `feed_content_type()`
4. Template loops through posts using `have_posts()` / `the_post()`
5. Feed-specific functions format content (e.g., `the_title_rss()`, `the_content_feed()`)

## Feed Consumption Flow

1. Call `fetch_feed( $url )` with feed URL(s)
2. SimplePie instance is created and configured
3. WordPress HTTP API fetches the feed
4. Content is sanitized via `WP_SimplePie_Sanitize_KSES`
5. Data is cached in transients
6. Returns `SimplePie\SimplePie` object or `WP_Error`

## Key Concepts

### Enclosures

Media attachments (audio, video) stored in post meta as `enclosure`:

```
URL
Size (bytes)
MIME type
```

Functions `rss_enclosure()` and `atom_enclosure()` output appropriate XML.

### Content vs Excerpt

The `rss_use_excerpt` option controls feed content:
- **Enabled**: Only excerpt in `<description>`
- **Disabled**: Excerpt in `<description>`, full content in `<content:encoded>`

### Atom Text Constructs

`prep_atom_text_construct()` determines content type per RFC 4287:
- `text` - No markup
- `html` - Tag soup (CDATA wrapped)
- `xhtml` - Well-formed XML (wrapped in `<div xmlns="...">`)

## Multisite Considerations

As of WordPress 6.9, feed caching uses global cache via `*_site_transient()` functions, ensuring consistent caching across multisite networks.

## Security

- Content is sanitized via `wp_kses_post()` when consuming feeds
- Enclosures validate MIME types against `get_allowed_mime_types()`
- Password-protected posts exclude content from feeds
- URLs are escaped with `esc_url()` throughout

## Related Files

```
wp-includes/
├── feed.php                           # Core feed functions
├── feed-atom.php                      # Atom post template
├── feed-atom-comments.php             # Atom comment template
├── feed-rdf.php                       # RDF/RSS 1.0 template
├── feed-rss.php                       # RSS 0.92 template
├── feed-rss2.php                      # RSS 2.0 post template
├── feed-rss2-comments.php             # RSS 2.0 comment template
├── class-wp-feed-cache.php            # Legacy cache (deprecated)
├── class-wp-feed-cache-transient.php  # Transient cache handler
├── class-wp-simplepie-file.php        # HTTP file fetcher
├── class-wp-simplepie-sanitize-kses.php  # KSES sanitizer
└── class-simplepie.php                # SimplePie autoloader
```
