# Sitemaps API

Framework for generating XML sitemaps in WordPress.

**Since:** 5.5.0  
**Source:** `wp-includes/sitemaps.php`, `wp-includes/sitemaps/`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core retrieval and registration functions |
| [class-wp-sitemaps.md](./class-wp-sitemaps.md) | Main sitemap controller |
| [class-wp-sitemaps-provider.md](./class-wp-sitemaps-provider.md) | Abstract base provider class |
| [class-wp-sitemaps-registry.md](./class-wp-sitemaps-registry.md) | Provider registry |
| [hooks.md](./hooks.md) | Actions and filters |

## Built-in Providers

| Provider | Class | Object Type | Description |
|----------|-------|-------------|-------------|
| `posts` | `WP_Sitemaps_Posts` | `post` | Public post types |
| `taxonomies` | `WP_Sitemaps_Taxonomies` | `term` | Public taxonomies |
| `users` | `WP_Sitemaps_Users` | `user` | Authors with published posts |

## Architecture

```
WP_Sitemaps (main controller)
    ├── WP_Sitemaps_Registry (provider management)
    │       └── WP_Sitemaps_Provider[] (posts, taxonomies, users)
    ├── WP_Sitemaps_Index (index generation)
    ├── WP_Sitemaps_Renderer (XML output)
    └── WP_Sitemaps_Stylesheet (XSL styling)
```

## URL Structure

| URL | Description |
|-----|-------------|
| `/wp-sitemap.xml` | Index listing all sitemaps |
| `/wp-sitemap-posts-post-1.xml` | Posts sitemap page 1 |
| `/wp-sitemap-posts-page-1.xml` | Pages sitemap page 1 |
| `/wp-sitemap-taxonomies-category-1.xml` | Categories sitemap page 1 |
| `/wp-sitemap-users-1.xml` | Users sitemap page 1 |
| `/wp-sitemap.xsl` | Stylesheet for sitemaps |
| `/wp-sitemap-index.xsl` | Stylesheet for index |

## Registration Flow

```
wp_sitemaps_init action
    └── wp_register_sitemap_provider()
            └── WP_Sitemaps_Registry::add_provider()
                    └── Store WP_Sitemaps_Provider instance
```

## Request Flow

```
/wp-sitemap.xml
    └── template_redirect
            └── WP_Sitemaps::render_sitemaps()
                    ├── (index) WP_Sitemaps_Index::get_sitemap_list()
                    │       └── WP_Sitemaps_Renderer::render_index()
                    └── (provider) WP_Sitemaps_Provider::get_url_list()
                            └── WP_Sitemaps_Renderer::render_sitemap()
```

## Robots.txt Integration

The sitemap index URL is automatically added to `robots.txt` for public sites:

```
Sitemap: https://example.com/wp-sitemap.xml
```
