# WP_Sitemaps

Main sitemap controller integrating all sitemap components.

**Source:** `wp-includes/sitemaps/class-wp-sitemaps.php`  
**Since:** 5.5.0

## Overview

The main class that orchestrates sitemap functionality including provider registration, rewrite rules, rendering, and robots.txt integration.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$index` | WP_Sitemaps_Index | public | Sitemap index generator |
| `$registry` | WP_Sitemaps_Registry | public | Provider registry |
| `$renderer` | WP_Sitemaps_Renderer | public | XML renderer |

---

## Methods

### __construct()

Initializes sitemap components.

```php
public function __construct()
```

**Creates:**
- `WP_Sitemaps_Registry` instance
- `WP_Sitemaps_Renderer` instance
- `WP_Sitemaps_Index` instance (with registry)

---

### init()

Initiates all sitemap functionality.

```php
public function init(): void
```

**Actions:**
- Registers rewrite rules (always, for proper 404 handling)
- Adds `template_redirect` action for rendering
- If sitemaps enabled:
  - Registers default providers
  - Adds sitemap to robots.txt

**Note:** Called automatically by `wp_sitemaps_get_server()`.

---

### sitemaps_enabled()

Determines whether sitemaps are enabled.

```php
public function sitemaps_enabled(): bool
```

**Returns:** `true` if sitemaps are enabled.

**Default:** Enabled when `blog_public` option is true.

**Hooks:**

```php
apply_filters( 'wp_sitemaps_enabled', bool $is_enabled )
```

**Example:**

```php
// Disable sitemaps entirely
add_filter( 'wp_sitemaps_enabled', '__return_false' );
```

---

### register_sitemaps()

Registers default sitemap providers.

```php
public function register_sitemaps(): void
```

**Registers:**
- `posts` → `WP_Sitemaps_Posts`
- `taxonomies` → `WP_Sitemaps_Taxonomies`
- `users` → `WP_Sitemaps_Users`

---

### register_rewrites()

Registers sitemap rewrite tags and routing rules.

```php
public function register_rewrites(): void
```

**Rewrite Tags:**
- `%sitemap%` — Provider name
- `%sitemap-subtype%` — Object subtype
- `%sitemap-stylesheet%` — XSL stylesheet type

**Rewrite Rules:**
| Pattern | Query |
|---------|-------|
| `^wp-sitemap\.xml$` | `sitemap=index` |
| `^wp-sitemap\.xsl$` | `sitemap-stylesheet=sitemap` |
| `^wp-sitemap-index\.xsl$` | `sitemap-stylesheet=index` |
| `^wp-sitemap-([a-z]+?)-([a-z\d_-]+?)-(\d+?)\.xml$` | Provider + subtype + page |
| `^wp-sitemap-([a-z]+?)-(\d+?)\.xml$` | Provider + page |

---

### render_sitemaps()

Renders sitemap templates based on rewrite rules.

```php
public function render_sitemaps(): void
```

**Hooked to:** `template_redirect`

**Flow:**

1. Check query vars (`sitemap`, `sitemap-subtype`, `sitemap-stylesheet`, `paged`)
2. If not sitemap request, return early
3. If sitemaps disabled, return 404
4. For stylesheet: render via `WP_Sitemaps_Stylesheet`
5. For index: render via `WP_Sitemaps_Renderer::render_index()`
6. For provider: get URLs and render via `WP_Sitemaps_Renderer::render_sitemap()`
7. If no URLs found, return 404

---

### add_robots()

Adds the sitemap index to robots.txt.

```php
public function add_robots( string $output, bool $is_public ): string
```

**Hooked to:** `robots_txt` filter (priority 0)

| Parameter | Type | Description |
|-----------|------|-------------|
| `$output` | string | Current robots.txt content |
| `$is_public` | bool | Whether site is public |

**Returns:** Modified robots.txt with sitemap URL.

**Output:**

```
Sitemap: https://example.com/wp-sitemap.xml
```

---

### redirect_sitemapxml()

Redirects `/sitemap-xml` to `/wp-sitemap.xml`.

```php
public function redirect_sitemapxml( bool $bypass, WP_Query $query ): bool
```

**Deprecated:** 6.7.0 — Use `WP_Rewrite::rewrite_rules()` instead.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$bypass` | bool | Pre_handle_404 filter value |
| `$query` | WP_Query | Query object |

**Returns:** Pass-through of bypass value.

---

## Usage Example

```php
// Get sitemap server
$sitemaps = wp_sitemaps_get_server();

// Access components
$providers = $sitemaps->registry->get_providers();
$index_url = $sitemaps->index->get_index_url();

// Check if enabled
if ( $sitemaps->sitemaps_enabled() ) {
    // Sitemaps are active
}
```
