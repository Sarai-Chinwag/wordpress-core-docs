# Robots API

Controls robots.txt generation and meta robots directives for search engine crawlers.

**Since:** 2.1.0 (robots.txt), 5.7.0 (meta robots)  
**Source:** `wp-includes/robots-template.php`, `wp-includes/functions.php`, `wp-includes/query.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core robots functions |
| [hooks.md](./hooks.md) | Actions and filters |

## Two Systems

WordPress has two separate robots mechanisms:

### 1. robots.txt File

Virtual file served at `/robots.txt`. Generated dynamically via `do_robots()`.

```
User-agent: *
Disallow: /wp-admin/
Allow: /wp-admin/admin-ajax.php
```

### 2. Meta Robots Tag

HTML meta tag in `<head>` controlling per-page indexing. Generated via `wp_robots()`.

```html
<meta name='robots' content='noindex, nofollow' />
```

## Default Behavior

### robots.txt
- Always disallows `/wp-admin/`
- Always allows `/wp-admin/admin-ajax.php`
- Customizable via `robots_txt` filter

### Meta Robots (Default Filters)

| Filter Callback | Condition | Directives Added |
|-----------------|-----------|------------------|
| `wp_robots_noindex` | Site not public | `noindex, nofollow` |
| `wp_robots_noindex_embeds` | Embed requests | `noindex, nofollow` |
| `wp_robots_noindex_search` | Search results | `noindex, nofollow` |
| `wp_robots_max_image_preview_large` | Site is public | `max-image-preview:large` |

## Request Flow

```
Request: /robots.txt
    └── is_robots() returns true
        └── template-loader.php fires 'do_robots' action
            └── do_robots() outputs robots.txt content

Request: Any page
    └── wp_head action
        └── wp_robots()
            └── apply_filters('wp_robots', [])
                └── Each callback adds directives
                    └── Output: <meta name='robots' content='...' />
```

## Directive Format

The `wp_robots` filter receives/returns an associative array:

```php
// Boolean directive (no value)
$robots['noindex'] = true;  // Outputs: noindex

// String directive (with value)
$robots['max-image-preview'] = 'large';  // Outputs: max-image-preview:large
```
