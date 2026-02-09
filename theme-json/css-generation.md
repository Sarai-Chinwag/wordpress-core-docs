# CSS Generation

How WordPress generates CSS from theme.json configurations.

## Overview

WordPress processes theme.json and generates:

1. **CSS Custom Properties** (variables) from settings
2. **Utility Classes** for presets
3. **Global Styles** from styles configuration
4. **Block Styles** for per-block configurations

## CSS Custom Properties

### Property Naming Convention

```
--wp--preset--{category}--{slug}
--wp--custom--{path}
--wp--style--{property}
```

### Settings → CSS Variables

| Setting | CSS Variable Pattern |
|---------|---------------------|
| `color.palette` | `--wp--preset--color--{slug}` |
| `color.gradients` | `--wp--preset--gradient--{slug}` |
| `typography.fontFamilies` | `--wp--preset--font-family--{slug}` |
| `typography.fontSizes` | `--wp--preset--font-size--{slug}` |
| `spacing.spacingSizes` | `--wp--preset--spacing--{slug}` |
| `shadow.presets` | `--wp--preset--shadow--{slug}` |
| `custom.*` | `--wp--custom--{path-kebab-case}` |

### Example Generation

**theme.json:**

```json
{
  "settings": {
    "color": {
      "palette": [
        { "slug": "primary", "color": "#0066cc", "name": "Primary" },
        { "slug": "secondary", "color": "#ff6600", "name": "Secondary" }
      ]
    },
    "typography": {
      "fontFamilies": [
        { "slug": "body", "fontFamily": "Inter, sans-serif", "name": "Body" }
      ],
      "fontSizes": [
        { "slug": "small", "size": "0.875rem", "name": "Small" },
        { "slug": "medium", "size": "1rem", "name": "Medium" }
      ]
    },
    "spacing": {
      "spacingSizes": [
        { "slug": "10", "size": "0.5rem", "name": "XS" },
        { "slug": "20", "size": "1rem", "name": "S" }
      ]
    },
    "custom": {
      "lineHeight": {
        "body": 1.6,
        "heading": 1.2
      }
    }
  }
}
```

**Generated CSS:**

```css
body {
  --wp--preset--color--primary: #0066cc;
  --wp--preset--color--secondary: #ff6600;
  --wp--preset--font-family--body: Inter, sans-serif;
  --wp--preset--font-size--small: 0.875rem;
  --wp--preset--font-size--medium: 1rem;
  --wp--preset--spacing--10: 0.5rem;
  --wp--preset--spacing--20: 1rem;
  --wp--custom--line-height--body: 1.6;
  --wp--custom--line-height--heading: 1.2;
}
```

## Utility Classes

WordPress generates utility classes for presets:

### Color Classes

```css
/* Background colors */
.has-primary-background-color {
  background-color: var(--wp--preset--color--primary) !important;
}
.has-secondary-background-color {
  background-color: var(--wp--preset--color--secondary) !important;
}

/* Text colors */
.has-primary-color {
  color: var(--wp--preset--color--primary) !important;
}
.has-secondary-color {
  color: var(--wp--preset--color--secondary) !important;
}

/* Border colors */
.has-primary-border-color {
  border-color: var(--wp--preset--color--primary) !important;
}
```

### Gradient Classes

```css
.has-primary-to-secondary-gradient-background {
  background: var(--wp--preset--gradient--primary-to-secondary) !important;
}
```

### Font Size Classes

```css
.has-small-font-size {
  font-size: var(--wp--preset--font-size--small) !important;
}
.has-medium-font-size {
  font-size: var(--wp--preset--font-size--medium) !important;
}
```

### Font Family Classes

```css
.has-body-font-family {
  font-family: var(--wp--preset--font-family--body) !important;
}
```

## Global Styles

Styles from the `styles` section generate CSS rules:

### Root Styles

**theme.json:**

```json
{
  "styles": {
    "color": {
      "background": "#ffffff",
      "text": "#1a1a1a"
    },
    "typography": {
      "fontFamily": "var(--wp--preset--font-family--body)",
      "fontSize": "var(--wp--preset--font-size--medium)",
      "lineHeight": "1.6"
    }
  }
}
```

**Generated CSS:**

```css
body {
  background-color: #ffffff;
  color: #1a1a1a;
  font-family: var(--wp--preset--font-family--body);
  font-size: var(--wp--preset--font-size--medium);
  line-height: 1.6;
}
```

### Element Styles

**theme.json:**

```json
{
  "styles": {
    "elements": {
      "link": {
        "color": { "text": "#0066cc" },
        ":hover": { "color": { "text": "#004499" } }
      },
      "h1": {
        "typography": { "fontSize": "2.5rem" }
      }
    }
  }
}
```

**Generated CSS:**

```css
a {
  color: #0066cc;
}
a:hover {
  color: #004499;
}
h1 {
  font-size: 2.5rem;
}
```

### Block Styles

**theme.json:**

```json
{
  "styles": {
    "blocks": {
      "core/paragraph": {
        "typography": { "lineHeight": "1.75" }
      },
      "core/button": {
        "border": { "radius": "0.5rem" }
      }
    }
  }
}
```

**Generated CSS:**

```css
.wp-block-paragraph {
  line-height: 1.75;
}
.wp-block-button .wp-block-button__link {
  border-radius: 0.5rem;
}
```

## Layout CSS

### Content Width

**theme.json:**

```json
{
  "settings": {
    "layout": {
      "contentSize": "720px",
      "wideSize": "1200px"
    }
  }
}
```

**Generated CSS:**

```css
body {
  --wp--style--global--content-size: 720px;
  --wp--style--global--wide-size: 1200px;
}

.is-layout-constrained > :where(:not(.alignleft):not(.alignright):not(.alignfull)) {
  max-width: var(--wp--style--global--content-size);
  margin-left: auto !important;
  margin-right: auto !important;
}

.is-layout-constrained > .alignwide {
  max-width: var(--wp--style--global--wide-size);
}

.is-layout-constrained > .alignfull {
  max-width: none;
}
```

### Block Gap

**theme.json:**

```json
{
  "styles": {
    "spacing": {
      "blockGap": "2rem"
    }
  }
}
```

**Generated CSS:**

```css
body {
  --wp--style--block-gap: 2rem;
}

.is-layout-flow > * + * {
  margin-block-start: var(--wp--style--block-gap);
}

.is-layout-flex {
  gap: var(--wp--style--block-gap);
}

.is-layout-grid {
  gap: var(--wp--style--block-gap);
}
```

## @font-face Generation

**theme.json:**

```json
{
  "settings": {
    "typography": {
      "fontFamilies": [
        {
          "slug": "inter",
          "name": "Inter",
          "fontFamily": "'Inter', sans-serif",
          "fontFace": [
            {
              "fontFamily": "Inter",
              "fontWeight": "400",
              "fontStyle": "normal",
              "fontDisplay": "swap",
              "src": ["file:./assets/fonts/inter-regular.woff2"]
            },
            {
              "fontFamily": "Inter",
              "fontWeight": "700",
              "fontStyle": "normal",
              "fontDisplay": "swap",
              "src": ["file:./assets/fonts/inter-bold.woff2"]
            }
          ]
        }
      ]
    }
  }
}
```

**Generated CSS:**

```css
@font-face {
  font-family: 'Inter';
  font-weight: 400;
  font-style: normal;
  font-display: swap;
  src: url('/wp-content/themes/theme-slug/assets/fonts/inter-regular.woff2') format('woff2');
}

@font-face {
  font-family: 'Inter';
  font-weight: 700;
  font-style: normal;
  font-display: swap;
  src: url('/wp-content/themes/theme-slug/assets/fonts/inter-bold.woff2') format('woff2');
}

body {
  --wp--preset--font-family--inter: 'Inter', sans-serif;
}
```

## Duotone Filters

**theme.json:**

```json
{
  "settings": {
    "color": {
      "duotone": [
        {
          "slug": "blue-orange",
          "colors": ["#0066cc", "#ff6600"],
          "name": "Blue and Orange"
        }
      ]
    }
  }
}
```

**Generated Output:**

WordPress injects an SVG filter definition and CSS:

```html
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" style="position: fixed;">
  <filter id="wp-duotone-blue-orange">
    <feColorMatrix type="matrix" values="..."/>
    <feComponentTransfer color-interpolation-filters="sRGB">
      <feFuncR type="table" tableValues="0 1"/>
      <feFuncG type="table" tableValues="0.4 0.6"/>
      <feFuncB type="table" tableValues="0.8 0.4"/>
    </feComponentTransfer>
  </filter>
</svg>
```

```css
.wp-duotone-blue-orange img,
.wp-duotone-blue-orange .wp-block-cover__image-background {
  filter: url(#wp-duotone-blue-orange);
}
```

## CSS Output Location

### Frontend

CSS is output in `<head>` via `wp_head`:

```html
<style id="global-styles-inline-css">
  /* CSS Custom Properties */
  body { --wp--preset--color--primary: #0066cc; ... }
  
  /* Global styles */
  body { background-color: #fff; ... }
  
  /* Element styles */
  a { color: #0066cc; }
  
  /* Block styles */
  .wp-block-paragraph { ... }
  
  /* Utility classes */
  .has-primary-color { color: var(--wp--preset--color--primary) !important; }
</style>
```

### Editor

Similar CSS is injected into the block editor iframe.

## Specificity

WordPress uses specific selectors to balance cascade:

| Context | Selector Pattern | Specificity |
|---------|-----------------|-------------|
| Root styles | `body` | 0,0,1,1 |
| Elements | `a`, `h1`, etc. | 0,0,0,1 |
| Blocks | `.wp-block-{name}` | 0,0,1,0 |
| Utility classes | `.has-{preset}-{property}` | 0,0,1,0 + `!important` |
| User styles | Various | Depends |

The `!important` on utility classes ensures they override other styles when applied.

## Custom CSS Property

Add arbitrary CSS via the `css` property:

**theme.json:**

```json
{
  "styles": {
    "css": "scroll-behavior: smooth;",
    "blocks": {
      "core/button": {
        "css": "& .wp-block-button__link { transition: all 0.2s ease; }"
      }
    }
  }
}
```

**Generated CSS:**

```css
body {
  scroll-behavior: smooth;
}

.wp-block-button .wp-block-button__link {
  transition: all 0.2s ease;
}
```

The `&` in block CSS references the block's root selector.

## Accessing Generated CSS

### PHP

```php
// Get all generated CSS
$css = wp_get_global_stylesheet();

// Get CSS for specific context
$css = wp_get_global_stylesheet( array( 'variables', 'presets', 'styles' ) );
```

### Inspecting Output

View generated CSS:

1. Open browser DevTools
2. Find `<style id="global-styles-inline-css">`
3. Or check `<style id="wp-block-library-inline-css">`

## Performance Considerations

### CSS Size

Theme.json-generated CSS is typically:
- Inlined in `<head>` (no extra HTTP request)
- Deferred for editor styles
- Cached after first generation

### Reducing Output

Minimize CSS by:

1. **Disable unused presets:**
   ```json
   { "settings": { "color": { "defaultPalette": false } } }
   ```

2. **Limit preset count:**
   Fewer colors/fonts/sizes = less CSS

3. **Disable unused features:**
   ```json
   { "settings": { "color": { "duotone": [] } } }
   ```

### Caching

WordPress caches the generated CSS. Cache is invalidated when:
- theme.json changes
- User customizes global styles
- Theme is updated

## Block-Level Variables

Per-block settings create scoped variables:

**theme.json:**

```json
{
  "settings": {
    "blocks": {
      "core/button": {
        "color": {
          "palette": [
            { "slug": "btn-primary", "color": "#00cc00", "name": "Button Primary" }
          ]
        }
      }
    }
  }
}
```

**Generated CSS:**

```css
.wp-block-button {
  --wp--preset--color--btn-primary: #00cc00;
}

/* Utility class scoped to button */
.wp-block-button .has-btn-primary-background-color {
  background-color: var(--wp--preset--color--btn-primary) !important;
}
```

## Style Variations

Style variations (in `styles/` directory) generate their own CSS:

```
styles/dark.json
styles/high-contrast.json
```

When a variation is selected, its CSS overrides the main theme.json values.

## CSS Logical Properties

WordPress uses CSS logical properties for better internationalization:

```css
/* Instead of */
margin-top: 1rem;
padding-left: 2rem;

/* WordPress generates */
margin-block-start: 1rem;
padding-inline-start: 2rem;
```

This ensures proper spacing in RTL languages.
