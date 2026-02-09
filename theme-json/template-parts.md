# Template Parts

Complete reference for `templateParts` in theme.json.

## Overview

The `templateParts` array registers reusable template sections like headers, footers, and sidebars.

```json
{
  "templateParts": [
    {
      "name": "header",
      "area": "header",
      "title": "Header"
    },
    {
      "name": "footer",
      "area": "footer",
      "title": "Footer"
    },
    {
      "name": "sidebar",
      "area": "uncategorized",
      "title": "Sidebar"
    }
  ]
}
```

## Template Part Definition

Each template part object:

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `name` | string | Yes | File name (without extension) in `parts/` directory |
| `area` | string | No | Semantic area: `header`, `footer`, or `uncategorized` |
| `title` | string | No | Display name in editor |

## File Structure

Template parts are stored in the `parts/` directory:

```
theme-root/
├── theme.json
├── templates/
│   ├── index.html
│   ├── single.html
│   └── page.html
└── parts/
    ├── header.html
    ├── header-minimal.html
    ├── footer.html
    ├── footer-minimal.html
    ├── sidebar.html
    └── comments.html
```

## Areas

### header

Semantic header area. Shows in the "Header" section of the Site Editor.

```json
{
  "templateParts": [
    {
      "name": "header",
      "area": "header",
      "title": "Header"
    },
    {
      "name": "header-dark",
      "area": "header",
      "title": "Header (Dark)"
    }
  ]
}
```

### footer

Semantic footer area. Shows in the "Footer" section of the Site Editor.

```json
{
  "templateParts": [
    {
      "name": "footer",
      "area": "footer",
      "title": "Footer"
    },
    {
      "name": "footer-minimal",
      "area": "footer",
      "title": "Footer (Minimal)"
    }
  ]
}
```

### uncategorized

General purpose template parts (sidebars, CTAs, etc.).

```json
{
  "templateParts": [
    {
      "name": "sidebar",
      "area": "uncategorized",
      "title": "Sidebar"
    },
    {
      "name": "cta-newsletter",
      "area": "uncategorized",
      "title": "Newsletter CTA"
    }
  ]
}
```

**Note:** `uncategorized` is the default if `area` is omitted.

## Using Template Parts

### In Templates

Include template parts using the block markup:

```html
<!-- templates/index.html -->
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main"} -->
<main class="wp-block-group">
  <!-- wp:query -->
  <!-- wp:post-template -->
    <!-- wp:post-title /-->
    <!-- wp:post-excerpt /-->
  <!-- /wp:post-template -->
  <!-- /wp:query -->
</main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
```

### Block Attributes

| Attribute | Type | Description |
|-----------|------|-------------|
| `slug` | string | Template part name (matches `name` in theme.json) |
| `tagName` | string | HTML wrapper element (`header`, `footer`, `aside`, `section`, `div`) |
| `theme` | string | Theme slug (for cross-theme parts) |
| `area` | string | Semantic area (when creating new parts in editor) |

**With semantic HTML:**

```html
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->
<!-- wp:template-part {"slug":"sidebar","tagName":"aside"} /-->
<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
```

**With additional classes:**

```html
<!-- wp:template-part {"slug":"header","tagName":"header","className":"site-header"} /-->
```

## Template Part Content Examples

### Basic Header

`parts/header.html`:

```html
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">

  <!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
  <div class="wp-block-group">
  
    <!-- wp:site-title /-->
    
    <!-- wp:navigation {"layout":{"type":"flex","justifyContent":"right"}} /-->
    
  </div>
  <!-- /wp:group -->

</div>
<!-- /wp:group -->
```

### Header with Logo

`parts/header-logo.html`:

```html
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
<div class="wp-block-group">

  <!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
  <div class="wp-block-group">
  
    <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
    <div class="wp-block-group">
      <!-- wp:site-logo {"width":60} /-->
      <!-- wp:site-title /-->
    </div>
    <!-- /wp:group -->
    
    <!-- wp:navigation /-->
    
  </div>
  <!-- /wp:group -->

</div>
<!-- /wp:group -->
```

### Minimal Footer

`parts/footer.html`:

```html
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<div class="wp-block-group">

  <!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
  <div class="wp-block-group">
  
    <!-- wp:paragraph -->
    <p>© 2024 <a href="/">Site Name</a>. All rights reserved.</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:social-links {"iconColor":"contrast","iconColorValue":"#1a1a1a","className":"is-style-logos-only"} -->
    <ul class="wp-block-social-links has-icon-color is-style-logos-only">
      <!-- wp:social-link {"url":"https://twitter.com","service":"twitter"} /-->
      <!-- wp:social-link {"url":"https://instagram.com","service":"instagram"} /-->
    </ul>
    <!-- /wp:social-links -->
    
  </div>
  <!-- /wp:group -->

</div>
<!-- /wp:group -->
```

### Full Footer

`parts/footer-full.html`:

```html
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"tertiary","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-tertiary-background-color has-background">

  <!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
  <div class="wp-block-columns">
  
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:site-title /-->
      <!-- wp:paragraph -->
      <p>A brief description of your site and what makes it special.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:heading {"level":3,"fontSize":"small"} -->
      <h3 class="wp-block-heading has-small-font-size">Quick Links</h3>
      <!-- /wp:heading -->
      <!-- wp:navigation {"layout":{"type":"flex","orientation":"vertical"}} /-->
    </div>
    <!-- /wp:column -->

    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:heading {"level":3,"fontSize":"small"} -->
      <h3 class="wp-block-heading has-small-font-size">Connect</h3>
      <!-- /wp:heading -->
      <!-- wp:social-links {"className":"is-style-logos-only"} -->
      <ul class="wp-block-social-links is-style-logos-only">
        <!-- wp:social-link {"url":"#","service":"twitter"} /-->
        <!-- wp:social-link {"url":"#","service":"instagram"} /-->
        <!-- wp:social-link {"url":"#","service":"linkedin"} /-->
      </ul>
      <!-- /wp:social-links -->
    </div>
    <!-- /wp:column -->

  </div>
  <!-- /wp:columns -->

  <!-- wp:separator {"className":"is-style-wide"} -->
  <hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
  <!-- /wp:separator -->

  <!-- wp:paragraph {"align":"center","fontSize":"small"} -->
  <p class="has-text-align-center has-small-font-size">© 2024 Site Name. All rights reserved.</p>
  <!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
```

### Sidebar

`parts/sidebar.html`:

```html
<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group">

  <!-- wp:search {"label":"Search","buttonText":"Search"} /-->

  <!-- wp:heading {"level":3,"fontSize":"medium"} -->
  <h3 class="wp-block-heading has-medium-font-size">Categories</h3>
  <!-- /wp:heading -->
  <!-- wp:categories /-->

  <!-- wp:heading {"level":3,"fontSize":"medium"} -->
  <h3 class="wp-block-heading has-medium-font-size">Recent Posts</h3>
  <!-- /wp:heading -->
  <!-- wp:latest-posts {"postsToShow":5} /-->

  <!-- wp:heading {"level":3,"fontSize":"medium"} -->
  <h3 class="wp-block-heading has-medium-font-size">Archives</h3>
  <!-- /wp:heading -->
  <!-- wp:archives /-->

</div>
<!-- /wp:group -->
```

### Comments Section

`parts/comments.html`:

```html
<!-- wp:comments -->
<div class="wp-block-comments">
  <!-- wp:heading {"level":2} -->
  <h2 class="wp-block-heading">Comments</h2>
  <!-- /wp:heading -->

  <!-- wp:comments-title /-->

  <!-- wp:comment-template -->
    <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
    <div class="wp-block-group">
      <!-- wp:avatar {"size":40} /-->
      <!-- wp:group -->
      <div class="wp-block-group">
        <!-- wp:comment-author-name /-->
        <!-- wp:comment-date /-->
        <!-- wp:comment-content /-->
        <!-- wp:comment-reply-link /-->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
  <!-- /wp:comment-template -->

  <!-- wp:comments-pagination -->
    <!-- wp:comments-pagination-previous /-->
    <!-- wp:comments-pagination-numbers /-->
    <!-- wp:comments-pagination-next /-->
  <!-- /wp:comments-pagination -->

  <!-- wp:post-comments-form /-->
</div>
<!-- /wp:comments -->
```

## Complete theme.json Example

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3,
  "templateParts": [
    {
      "name": "header",
      "area": "header",
      "title": "Header"
    },
    {
      "name": "header-minimal",
      "area": "header",
      "title": "Header (Minimal)"
    },
    {
      "name": "header-centered",
      "area": "header",
      "title": "Header (Centered)"
    },
    {
      "name": "footer",
      "area": "footer",
      "title": "Footer"
    },
    {
      "name": "footer-minimal",
      "area": "footer",
      "title": "Footer (Minimal)"
    },
    {
      "name": "footer-large",
      "area": "footer",
      "title": "Footer (Large)"
    },
    {
      "name": "sidebar",
      "area": "uncategorized",
      "title": "Sidebar"
    },
    {
      "name": "sidebar-shop",
      "area": "uncategorized",
      "title": "Shop Sidebar"
    },
    {
      "name": "comments",
      "area": "uncategorized",
      "title": "Comments"
    },
    {
      "name": "post-meta",
      "area": "uncategorized",
      "title": "Post Meta"
    },
    {
      "name": "cta-newsletter",
      "area": "uncategorized",
      "title": "Newsletter CTA"
    }
  ]
}
```

## Swapping Template Parts

Users can swap template parts in the Site Editor:

1. Edit a template (Appearance → Editor → Templates)
2. Select the template part block
3. In the block toolbar, click "Replace"
4. Choose from other template parts in the same area

This allows users to try different headers/footers without editing the main template.

## Creating Template Part Variations

Register multiple parts for the same area:

```json
{
  "templateParts": [
    { "name": "header", "area": "header", "title": "Header - Default" },
    { "name": "header-centered", "area": "header", "title": "Header - Centered Logo" },
    { "name": "header-stacked", "area": "header", "title": "Header - Stacked" },
    { "name": "header-transparent", "area": "header", "title": "Header - Transparent" }
  ]
}
```

All appear as options when replacing the header template part.

## Best Practices

### Semantic HTML

Always use appropriate tag names:

```html
<!-- Good -->
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->
<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
<!-- wp:template-part {"slug":"sidebar","tagName":"aside"} /-->

<!-- Avoid -->
<!-- wp:template-part {"slug":"header"} /-->
```

### Consistent Naming

```
header.html          → Default header
header-{variant}.html → Header variants
footer.html          → Default footer
footer-{variant}.html → Footer variants
sidebar.html         → Main sidebar
sidebar-{context}.html → Context-specific sidebars
```

### Modular Design

Create small, focused template parts:

```json
{
  "templateParts": [
    { "name": "post-meta", "title": "Post Meta" },
    { "name": "author-bio", "title": "Author Bio" },
    { "name": "related-posts", "title": "Related Posts" },
    { "name": "share-buttons", "title": "Share Buttons" }
  ]
}
```

Use in templates:

```html
<!-- wp:post-content /-->
<!-- wp:template-part {"slug":"post-meta"} /-->
<!-- wp:template-part {"slug":"author-bio"} /-->
<!-- wp:template-part {"slug":"related-posts"} /-->
```

### Default Width Handling

Template parts inherit the parent's layout. For full-width parts:

```html
<!-- In template -->
<!-- wp:template-part {"slug":"header","tagName":"header","align":"full"} /-->
```

Or handle width inside the part:

```html
<!-- parts/header.html -->
<!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull">
  <!-- Content here is constrained, but background is full-width -->
</div>
<!-- /wp:group -->
```

## PHP Access

Get template part content:

```php
// Render a template part
block_template_part( 'header' );

// Check if template part exists
$template_part = get_block_template( 
    get_stylesheet() . '//header', 
    'wp_template_part' 
);

if ( $template_part ) {
    // Template part exists
}
```

Query all template parts:

```php
$template_parts = get_block_templates( 
    array( 'theme' => get_stylesheet() ), 
    'wp_template_part' 
);

foreach ( $template_parts as $part ) {
    echo $part->slug . ': ' . $part->title . "\n";
}
```
