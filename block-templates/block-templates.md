# Block Templates System

WordPress Block Templates (also known as FSE - Full Site Editing templates) are a fundamental part of block themes. They allow themes and plugins to define site structure using blocks stored as HTML files or in the database.

## Template Types

### wp_template

Full page templates that control the entire page layout. Stored in the theme's `templates/` directory (or legacy `block-templates/`).

**Examples:**
- `index.html` - Fallback for all pages
- `single.html` - Single posts
- `page.html` - Static pages
- `archive.html` - Archive listings
- `404.html` - Not found pages

### wp_template_part

Reusable template sections. Stored in the theme's `parts/` directory (or legacy `block-template-parts/`).

**Examples:**
- `header.html` - Site header
- `footer.html` - Site footer
- `sidebar.html` - Sidebar content

## Template Hierarchy (Block Theme)

The block template hierarchy mirrors classic PHP templates but uses `.html` files with block markup:

```
front-page.html
├── home.html
│   └── index.html
│
single-{post-type}-{slug}.html
├── single-{post-type}.html
│   ├── single.html
│   │   ├── singular.html
│   │   │   └── index.html
│
page-{slug}.html
├── page-{id}.html
│   ├── page.html
│   │   ├── singular.html
│   │   │   └── index.html
│
archive.html
├── author-{nicename}.html
├── author-{id}.html
├── author.html
├── category-{slug}.html
├── category-{id}.html
├── category.html
├── tag-{slug}.html
├── tag-{id}.html
├── tag.html
├── taxonomy-{taxonomy}-{term}.html
├── taxonomy-{taxonomy}.html
├── taxonomy.html
└── date.html
    └── index.html

search.html
└── index.html

404.html
└── index.html
```

## Template Sources

Templates can come from multiple sources, listed by priority:

1. **Database (custom)** - User-modified templates stored as `wp_template` posts
2. **Theme files** - `.html` files in the theme's `templates/` directory
3. **Parent theme files** - `.html` files in parent theme (for child themes)
4. **Plugin-registered** - Templates registered via `register_block_template()`

## Template Part Areas

Template parts are categorized by area using the `wp_template_part_area` taxonomy:

| Constant | Value | Description | HTML Tag |
|----------|-------|-------------|----------|
| `WP_TEMPLATE_PART_AREA_HEADER` | `header` | Site header | `<header>` |
| `WP_TEMPLATE_PART_AREA_FOOTER` | `footer` | Site footer | `<footer>` |
| `WP_TEMPLATE_PART_AREA_SIDEBAR` | `sidebar` | Sidebar | `<aside>` |
| `WP_TEMPLATE_PART_AREA_UNCATEGORIZED` | `uncategorized` | General/other | `<div>` |

## Theme Directory Structure

```
my-theme/
├── templates/              # Block templates (wp_template)
│   ├── index.html
│   ├── single.html
│   ├── page.html
│   └── archive.html
├── parts/                  # Template parts (wp_template_part)
│   ├── header.html
│   ├── footer.html
│   └── sidebar.html
├── theme.json              # Theme configuration
└── style.css               # Theme metadata
```

### Legacy Folder Names

For backward compatibility, WordPress also checks:
- `block-templates/` (instead of `templates/`)
- `block-template-parts/` (instead of `parts/`)

## Template Resolution Flow

1. Request comes in (e.g., viewing a single post)
2. WordPress determines template type (`single`)
3. `locate_block_template()` is called
4. Builds template hierarchy (`single-post-{slug}`, `single-post`, `single`, `singular`, `index`)
5. Queries database for user-customized templates
6. Falls back to theme files if no custom template
7. Renders through `template-canvas.php`

## Template Canvas

Block templates are rendered through `wp-includes/template-canvas.php`, which:

1. Sets up viewport meta tag
2. Renders title tag
3. Calls `get_the_block_template_html()` to process blocks
4. Wraps output in `.wp-site-blocks` container

## Template Identification

Templates use a composite ID format: `{theme}//{slug}`

**Examples:**
- `twentytwentyfour//single`
- `my-theme//page-about`
- `twentytwentyfour//header` (template part)

## Global Variables

When a block template is active:

| Variable | Description |
|----------|-------------|
| `$_wp_current_template_content` | Raw block content of current template |
| `$_wp_current_template_id` | Template ID (e.g., `theme//slug`) |

## Theme Support

Block templates require the theme to declare support:

```php
// Usually automatic for block themes (those with templates/index.html)
add_theme_support( 'block-templates' );
```

Check if supported:

```php
if ( current_theme_supports( 'block-templates' ) ) {
    // Block templates are active
}
```

## Empty Template Handling

Since WordPress 6.8, empty templates display a warning to logged-in users via `wp_render_empty_block_template_warning()`, prompting them to edit the template in the Site Editor.

## Related Files

- `wp-includes/block-template.php` - Core template loading functions
- `wp-includes/block-template-utils.php` - Utility functions for templates
- `wp-includes/class-wp-block-template.php` - Template object class
- `wp-includes/class-wp-block-templates-registry.php` - Template registration
- `wp-includes/template-canvas.php` - Template rendering wrapper
