# Custom Templates

Complete reference for `customTemplates` in theme.json.

## Overview

The `customTemplates` array registers custom page/post templates that users can select in the editor.

```json
{
  "customTemplates": [
    {
      "name": "blank",
      "title": "Blank",
      "postTypes": ["page", "post"]
    },
    {
      "name": "full-width",
      "title": "Full Width",
      "postTypes": ["page"]
    }
  ]
}
```

## Template Definition

Each template object:

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `name` | string | Yes | Template file name (without extension) |
| `title` | string | Yes | Display name in editor template selector |
| `postTypes` | array | No | Post types this template is available for |

## File Structure

Templates are stored in the `templates/` directory:

```
theme-root/
├── theme.json
├── templates/
│   ├── index.html           # Required fallback
│   ├── single.html          # Single post
│   ├── page.html            # Pages
│   ├── archive.html         # Archives
│   ├── blank.html           # Custom: Blank template
│   ├── full-width.html      # Custom: Full width template
│   └── landing-page.html    # Custom: Landing page template
└── parts/
    ├── header.html
    └── footer.html
```

## Registration

### Basic Template

```json
{
  "customTemplates": [
    {
      "name": "blank",
      "title": "Blank"
    }
  ]
}
```

With corresponding `templates/blank.html`:

```html
<!-- wp:post-content /-->
```

### Template with Post Types

```json
{
  "customTemplates": [
    {
      "name": "full-width",
      "title": "Full Width",
      "postTypes": ["page"]
    }
  ]
}
```

Only available when editing pages.

### Multiple Post Types

```json
{
  "customTemplates": [
    {
      "name": "no-title",
      "title": "No Title",
      "postTypes": ["page", "post"]
    }
  ]
}
```

Available for both pages and posts.

### All Post Types

Omit `postTypes` to make available for all:

```json
{
  "customTemplates": [
    {
      "name": "blank",
      "title": "Blank"
    }
  ]
}
```

## Template Content Examples

### Blank Template

`templates/blank.html`:

```html
<!-- wp:post-content {"layout":{"type":"constrained"}} /-->
```

Minimal template with just the content.

### Full Width Template

`templates/full-width.html`:

```html
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main","layout":{"type":"default"}} -->
<main class="wp-block-group">
  <!-- wp:post-content {"layout":{"type":"default"}} /-->
</main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
```

No width constraints on content.

### Landing Page Template

`templates/landing-page.html`:

```html
<!-- wp:group {"tagName":"main","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<main class="wp-block-group" style="padding-top:0;padding-bottom:0">
  <!-- wp:post-content {"layout":{"type":"default"}} /-->
</main>
<!-- /wp:group -->
```

No header/footer, full-width, no padding.

### Page with Sidebar Template

`templates/page-sidebar.html`:

```html
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main","layout":{"type":"constrained"}} -->
<main class="wp-block-group">
  <!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
  <div class="wp-block-columns">
    
    <!-- wp:column {"width":"70%"} -->
    <div class="wp-block-column" style="flex-basis:70%">
      <!-- wp:post-content /-->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"width":"30%"} -->
    <div class="wp-block-column" style="flex-basis:30%">
      <!-- wp:template-part {"slug":"sidebar"} /-->
    </div>
    <!-- /wp:column -->

  </div>
  <!-- /wp:columns -->
</main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
```

### Single Post - No Featured Image

`templates/single-no-image.html`:

```html
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main","layout":{"type":"constrained"}} -->
<main class="wp-block-group">

  <!-- wp:group {"layout":{"type":"constrained","contentSize":"720px"}} -->
  <div class="wp-block-group">
    <!-- wp:post-title {"level":1} /-->
    <!-- wp:post-date /-->
    <!-- wp:post-content /-->
    <!-- wp:post-terms {"term":"post_tag"} /-->
  </div>
  <!-- /wp:group -->

  <!-- wp:comments /-->
  
</main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
```

## Complete theme.json Example

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3,
  "customTemplates": [
    {
      "name": "blank",
      "title": "Blank",
      "postTypes": ["page", "post"]
    },
    {
      "name": "full-width",
      "title": "Full Width",
      "postTypes": ["page"]
    },
    {
      "name": "landing-page",
      "title": "Landing Page",
      "postTypes": ["page"]
    },
    {
      "name": "page-sidebar",
      "title": "Page with Sidebar",
      "postTypes": ["page"]
    },
    {
      "name": "single-no-image",
      "title": "Post - No Featured Image",
      "postTypes": ["post"]
    },
    {
      "name": "single-narrow",
      "title": "Post - Narrow Content",
      "postTypes": ["post"]
    },
    {
      "name": "portfolio-item",
      "title": "Portfolio Item",
      "postTypes": ["portfolio"]
    }
  ]
}
```

## Custom Post Type Templates

For custom post types:

```json
{
  "customTemplates": [
    {
      "name": "product-full",
      "title": "Product - Full Width",
      "postTypes": ["product"]
    },
    {
      "name": "event-single",
      "title": "Event Detail",
      "postTypes": ["event"]
    }
  ]
}
```

**Note:** The custom post type must already be registered in WordPress for the template to appear.

## How Users Select Templates

1. Edit a page/post in the block editor
2. Open the document settings sidebar (right panel)
3. Find "Template" section
4. Click the template name to open selector
5. Choose from available templates

Templates appear based on:
- Whether template's `postTypes` includes current post type
- If `postTypes` is omitted, template appears for all post types

## Template Hierarchy

Custom templates exist alongside WordPress's template hierarchy:

```
1. Custom template (if selected)
       ↓
2. Standard hierarchy (single-{post-type}.html, single.html, etc.)
       ↓
3. index.html (fallback)
```

When a user selects a custom template, it overrides the standard hierarchy for that specific post/page.

## Best Practices

### Naming Conventions

```json
{
  "customTemplates": [
    { "name": "page-blank", "title": "Page - Blank" },
    { "name": "page-full-width", "title": "Page - Full Width" },
    { "name": "page-sidebar-left", "title": "Page - Sidebar Left" },
    { "name": "page-sidebar-right", "title": "Page - Sidebar Right" },
    { "name": "single-minimal", "title": "Post - Minimal" },
    { "name": "single-featured", "title": "Post - Large Featured Image" },
    { "name": "archive-grid", "title": "Archive - Grid Layout" }
  ]
}
```

### Descriptive Titles

Good titles:
- "Landing Page (No Header/Footer)"
- "Full Width - No Sidebar"
- "Blog Post - Featured Image Hero"

Bad titles:
- "Template 1"
- "Custom"
- "New Layout"

### Limit Template Count

Aim for 3-6 custom templates. Too many creates confusion.

### Document Templates

Include template descriptions in theme documentation so users understand when to use each.

## PHP Access

Check if a custom template is being used:

```php
// Get current template
$template = get_page_template_slug();

// Check for specific template
if ( 'blank' === get_page_template_slug() ) {
    // This page uses the blank template
}
```

Get all registered custom templates:

```php
$theme = wp_get_theme();
$templates = $theme->get_page_templates();
// Returns array: ['blank' => 'Blank', 'full-width' => 'Full Width', ...]
```

## Relationship with templateParts

Custom templates typically use template parts:

```html
<!-- templates/full-width.html -->
<!-- wp:template-part {"slug":"header"} /-->
<!-- wp:post-content /-->
<!-- wp:template-part {"slug":"footer"} /-->
```

Define template parts in `templateParts`:

```json
{
  "customTemplates": [
    { "name": "full-width", "title": "Full Width" }
  ],
  "templateParts": [
    { "name": "header", "area": "header", "title": "Header" },
    { "name": "footer", "area": "footer", "title": "Footer" }
  ]
}
```

See [template-parts.md](template-parts.md) for details.
