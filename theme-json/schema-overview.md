# theme.json Schema Overview

The `theme.json` file is WordPress's unified configuration system for block themes, controlling global styles, editor settings, and theme behavior.

## File Location

```
theme-root/
├── theme.json           # Theme configuration
├── styles/              # Optional style variations
│   ├── dark.json
│   └── contrast.json
└── ...
```

## Schema Version

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3
}
```

### Version History

| Version | WordPress | Key Changes |
|---------|-----------|-------------|
| 1 | 5.8 | Initial release |
| 2 | 5.9 | Added `appearanceTools`, renamed `settings.border.customColor` → `settings.border.color` |
| 3 | 6.6 | Changed `settings.typography.defaultFontSizes` default to `true`, added `settings.background.backgroundSize` |

**Always use version 3** for new themes. WordPress auto-migrates older versions.

## Top-Level Structure

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3,
  "title": "Theme Name",
  "description": "Theme description for style variations",
  "settings": { },
  "styles": { },
  "customTemplates": [ ],
  "templateParts": [ ],
  "patterns": [ ]
}
```

### Property Summary

| Property | Type | Purpose |
|----------|------|---------|
| `$schema` | string | JSON schema URL for IDE validation |
| `version` | integer | Schema version (1, 2, or 3) |
| `title` | string | Display name (used in style variations) |
| `description` | string | Description (used in style variations) |
| `settings` | object | Editor features and design tokens |
| `styles` | object | CSS styling rules |
| `customTemplates` | array | Custom template definitions |
| `templateParts` | array | Template part definitions |
| `patterns` | array | Pattern slugs to register |

## Inheritance Chain

WordPress merges theme.json from multiple sources in this order (later overrides earlier):

```
1. WordPress Core Defaults
        ↓
2. Theme's theme.json
        ↓
3. Child Theme's theme.json (if applicable)
        ↓
4. User Customizations (stored in database)
```

### Core Defaults Location

WordPress core defaults are defined in:
```
wp-includes/theme.json
```

### How Merging Works

**Settings**: Deep merged. Theme values override core, user overrides theme.

```json
// Core default
{ "settings": { "color": { "defaultPalette": true } } }

// Theme overrides
{ "settings": { "color": { "defaultPalette": false, "palette": [...] } } }

// Result: defaultPalette is false, palette from theme, other color settings from core
```

**Styles**: Deep merged at each level.

```json
// Theme
{ "styles": { "color": { "background": "#fff" } } }

// User customization
{ "styles": { "color": { "text": "#000" } } }

// Result: both background and text are applied
```

**Arrays** (palette, fontSizes, etc.): Theme arrays **replace** core arrays entirely, not merge.

```json
// Core has 12 default colors
// Theme defines 5 colors
// Result: Only 5 theme colors available (core colors removed)
```

## Accessing Merged Configuration

### PHP

```php
// Get complete merged settings
$settings = wp_get_global_settings();

// Get specific setting
$palette = wp_get_global_settings( array( 'color', 'palette' ) );

// Get complete merged styles
$styles = wp_get_global_styles();

// Get specific style
$background = wp_get_global_styles( array( 'color', 'background' ) );
```

### JavaScript (Block Editor)

```js
import { useSettings, useSetting } from '@wordpress/block-editor';

// Get multiple settings
const [ fontSizes, colors ] = useSettings( 'typography.fontSizes', 'color.palette' );

// Get single setting
const palette = useSetting( 'color.palette' );
```

## Context: Global vs Block-Level

Both `settings` and `styles` can be defined globally or per-block:

```json
{
  "settings": {
    "color": {
      "palette": [ /* global palette */ ]
    },
    "blocks": {
      "core/paragraph": {
        "color": {
          "palette": [ /* paragraph-only palette */ ]
        }
      }
    }
  },
  "styles": {
    "color": {
      "background": "#ffffff"
    },
    "blocks": {
      "core/paragraph": {
        "color": {
          "text": "#333333"
        }
      }
    }
  }
}
```

Block-level settings/styles override global ones for that specific block.

## Minimal Valid theme.json

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3
}
```

This uses all WordPress defaults.

## Complete Example

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3,
  "title": "My Theme",
  "settings": {
    "appearanceTools": true,
    "color": {
      "palette": [
        { "slug": "primary", "color": "#0066cc", "name": "Primary" },
        { "slug": "secondary", "color": "#333333", "name": "Secondary" }
      ]
    },
    "typography": {
      "fontFamilies": [
        {
          "slug": "system",
          "name": "System Font",
          "fontFamily": "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif"
        }
      ]
    },
    "layout": {
      "contentSize": "650px",
      "wideSize": "1200px"
    }
  },
  "styles": {
    "color": {
      "background": "var(--wp--preset--color--primary)",
      "text": "#ffffff"
    },
    "typography": {
      "fontFamily": "var(--wp--preset--font-family--system)",
      "fontSize": "1rem",
      "lineHeight": "1.6"
    },
    "elements": {
      "link": {
        "color": { "text": "#ffffff" },
        ":hover": { "color": { "text": "#cccccc" } }
      }
    }
  },
  "templateParts": [
    { "name": "header", "area": "header", "title": "Header" },
    { "name": "footer", "area": "footer", "title": "Footer" }
  ],
  "customTemplates": [
    { "name": "blank", "title": "Blank", "postTypes": ["page", "post"] }
  ],
  "patterns": [ "theme-slug/hero", "theme-slug/cta" ]
}
```

## Related Files

- [settings-color.md](settings-color.md) - Color settings
- [settings-typography.md](settings-typography.md) - Typography settings  
- [settings-spacing.md](settings-spacing.md) - Spacing settings
- [settings-layout.md](settings-layout.md) - Layout settings
- [settings-blocks.md](settings-blocks.md) - Per-block settings
- [settings-other.md](settings-other.md) - Border, shadow, dimensions, etc.
- [styles.md](styles.md) - Styles configuration
- [custom-templates.md](custom-templates.md) - Custom templates
- [template-parts.md](template-parts.md) - Template parts
- [patterns.md](patterns.md) - Pattern registration
- [css-generation.md](css-generation.md) - CSS custom properties and output
