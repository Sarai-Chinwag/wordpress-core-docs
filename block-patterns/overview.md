# Block Patterns API Overview

Block patterns are predefined block layouts that users can insert into content with a single click. Introduced in WordPress 5.5, patterns provide reusable design templates ranging from simple text layouts to complex multi-column designs.

## Core Concepts

### What Are Block Patterns?

Block patterns are collections of blocks that form a cohesive design unit. Unlike reusable blocks (synced patterns), block patterns are templates—inserting a pattern creates a copy that can be freely modified without affecting the original.

**Pattern Properties:**
- `name` - Unique identifier with namespace (e.g., `my-plugin/hero-section`)
- `title` - Human-readable display name (required)
- `content` - Block HTML markup or `filePath` to a PHP file (required)
- `description` - Hidden text for search/discovery
- `categories` - Array of category slugs for organization
- `keywords` - Search aliases
- `blockTypes` - Blocks that can use this pattern (transforms, placeholders)
- `postTypes` - Restrict pattern to specific post types
- `templateTypes` - Template types where pattern fits (e.g., `404`, `single`)
- `viewportWidth` - Preview width in inserter
- `inserter` - Whether visible in inserter (default: true)
- `source` - Origin of pattern (core, theme, plugin, pattern-directory)

### Pattern Categories

Categories organize patterns in the inserter. WordPress registers these core categories:

| Category | Description |
|----------|-------------|
| `banner` | Bold sections for key content |
| `buttons` | Button and CTA patterns |
| `columns` | Multi-column layouts |
| `text` | Text-focused patterns |
| `query` / `posts` | Post display layouts |
| `featured` | Curated high-quality patterns |
| `call-to-action` | Conversion-focused sections |
| `team` | Team member displays |
| `testimonials` | Reviews and feedback |
| `services` | Service descriptions |
| `contact` | Contact information |
| `about` | Introduction sections |
| `portfolio` | Work showcases |
| `gallery` | Image layouts |
| `media` | Video/audio layouts |
| `videos` | Video-specific layouts |
| `audio` | Audio-specific layouts |
| `header` | Site header designs |
| `footer` | Site footer designs |

### Pattern Sources

WordPress loads patterns from multiple sources:

1. **Core Patterns** - Built into WordPress (`wp-includes/block-patterns/`)
2. **Theme Patterns** - From theme's `patterns/` directory
3. **Plugin Patterns** - Registered programmatically
4. **Remote Patterns** - From wordpress.org/patterns (Pattern Directory)
5. **theme.json Patterns** - Referenced by slug in theme.json

## Registration Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                        WordPress Init                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  1. Core Categories Registered                                   │
│     └─► _register_core_block_patterns_and_categories()          │
│                                                                  │
│  2. Core Patterns Registered (if theme supports)                 │
│     └─► query-standard-posts, query-grid-posts, etc.            │
│                                                                  │
│  3. Theme Patterns Registered                                    │
│     └─► _register_theme_block_patterns()                         │
│         └─► Scans theme/patterns/ directory                      │
│         └─► Child theme overrides parent patterns                │
│                                                                  │
│  4. Remote Patterns Loaded (if enabled)                          │
│     └─► _load_remote_block_patterns()                            │
│     └─► _load_remote_featured_patterns()                         │
│     └─► _register_remote_theme_patterns()                        │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

## Theme Pattern Files

Themes can define patterns as PHP files in the `patterns/` directory:

```php
<?php
/**
 * Title: Hero Section
 * Slug: my-theme/hero-section
 * Categories: banner, featured
 * Keywords: hero, header, intro
 * Block Types: core/post-content
 * Post Types: page
 * Viewport Width: 1200
 * Inserter: yes
 */
?>
<!-- wp:cover {"url":"..."} -->
<div class="wp-block-cover">
    <!-- wp:heading -->
    <h2>Welcome</h2>
    <!-- /wp:heading -->
</div>
<!-- /wp:cover -->
```

**File Header Fields:**
- `Title` - Pattern title (required)
- `Slug` - Unique pattern name (required)
- `Categories` - Comma-separated category slugs
- `Keywords` - Comma-separated search terms
- `Block Types` - Comma-separated block types
- `Post Types` - Comma-separated post type restrictions
- `Template Types` - Comma-separated template types
- `Viewport Width` - Integer width for preview
- `Inserter` - `yes` or `no`

## Core Block Patterns

WordPress ships with query-focused patterns:

| Pattern | Description |
|---------|-------------|
| `core/query-standard-posts` | Basic post list with title, image, excerpt |
| `core/query-medium-posts` | Medium-sized post layout |
| `core/query-small-posts` | Compact post listing |
| `core/query-grid-posts` | Grid layout for posts |
| `core/query-large-title-posts` | Large title emphasis |
| `core/query-offset-posts` | Offset/featured first post layout |

## Theme Support

Themes control core pattern loading:

```php
// Enable core patterns (default)
add_theme_support( 'core-block-patterns' );

// Disable core patterns
remove_theme_support( 'core-block-patterns' );
```

## Pattern Directory Integration

Themes can reference patterns from wordpress.org/patterns in theme.json:

```json
{
    "patterns": [
        "short-text-surrounded-by-round-images",
        "partner-logos"
    ]
}
```

These patterns are fetched via the REST API and cached.

## Block Hooks Integration

Since WordPress 6.5, pattern content is processed through the Block Hooks system:

```php
$content = apply_block_hooks_to_content(
    $content,
    $pattern,
    'insert_hooked_blocks_and_set_ignored_hooked_blocks_metadata'
);
```

This allows hooked blocks to be inserted into pattern content automatically.

## Best Practices

### Pattern Naming
- Use namespace prefix: `theme-slug/pattern-name` or `plugin-slug/pattern-name`
- Use lowercase with hyphens
- Be descriptive: `theme/hero-with-cta` not `theme/pattern-1`

### Pattern Content
- Use semantic HTML structure
- Include placeholder content users will replace
- Use theme-aware values where possible (colors, fonts)
- Test with different content lengths

### Performance
- Use `filePath` for lazy loading large patterns
- Patterns in `patterns/` directory are auto-cached
- Remote patterns are cached via transients

### Accessibility
- Include proper heading hierarchy
- Use meaningful alt text in placeholder images
- Ensure color contrast meets WCAG standards

## Version History

| Version | Changes |
|---------|---------|
| 5.5.0 | Block Patterns API introduced |
| 5.8.0 | `blockTypes` property added |
| 5.9.0 | Pattern Directory integration |
| 6.0.0 | Theme patterns from `patterns/` directory |
| 6.1.0 | `postTypes` property added |
| 6.2.0 | `templateTypes` property added |
| 6.3.0 | Pattern `source` tracking added |
| 6.4.0 | `WP_Theme::get_block_patterns()` method |
| 6.5.0 | `filePath` property for lazy loading |

## Related APIs

- [WP_Block_Patterns_Registry](class-wp-block-patterns-registry.md) - Pattern registry class
- [WP_Block_Pattern_Categories_Registry](class-wp-block-pattern-categories-registry.md) - Category registry
- [Pattern Functions](functions.md) - Registration functions
- [Pattern Hooks](hooks.md) - Available filters and actions
