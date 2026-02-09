# theme.json

Global settings and styles configuration for WordPress block themes.

**Since:** 5.8.0  
**Current Schema Version:** 3  
**Source:** `wp-includes/class-wp-theme-json.php`

## Purpose

theme.json provides a centralized way to:
- Define design tokens (colors, fonts, spacing)
- Configure block editor features
- Apply global styles
- Control which settings appear in the editor

## File Locations

| Location | Origin | Purpose |
|----------|--------|---------|
| `wp-includes/theme.json` | `default` | WordPress defaults |
| `wp-content/themes/{theme}/theme.json` | `theme` | Theme configuration |
| Database (user changes) | `custom` | User customizations via Site Editor |

## Schema Structure

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3,
  "settings": { },
  "styles": { },
  "customTemplates": [ ],
  "templateParts": [ ],
  "patterns": [ ],
  "title": "Theme Name"
}
```

## Data Cascade

Settings and styles merge in order (later overrides earlier):

```
default → blocks → theme → custom
```

1. **default** — WordPress core defaults
2. **blocks** — Block-provided defaults
3. **theme** — Theme's theme.json
4. **custom** — User changes via Site Editor

## Version History

| Version | WordPress | Changes |
|---------|-----------|---------|
| 1 | 5.8 | Initial release |
| 2 | 5.9 | Removed `custom` prefix from settings |
| 3 | 6.6 | Changed spacing size merging behavior |

## Components

### Settings
| Component | Description |
|-----------|-------------|
| [settings-color.md](./settings-color.md) | Color palettes, gradients, duotone |
| [settings-typography.md](./settings-typography.md) | Font families, sizes, fluid typography |
| [settings-spacing.md](./settings-spacing.md) | Spacing scale, padding, margin |
| [settings-layout.md](./settings-layout.md) | Content width, wide/full alignment |
| [settings-blocks.md](./settings-blocks.md) | Per-block setting overrides |
| [settings-other.md](./settings-other.md) | Appearance tools, border, shadow |

### Styles & Structure
| Component | Description |
|-----------|-------------|
| [styles.md](./styles.md) | Global and element styles |
| [css-generation.md](./css-generation.md) | How CSS is generated from theme.json |
| [custom-templates.md](./custom-templates.md) | Custom template definitions |
| [template-parts.md](./template-parts.md) | Template part areas |
| [patterns.md](./patterns.md) | Pattern registration |
| [schema-overview.md](./schema-overview.md) | Full schema reference |

## Quick Example

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3,
  "settings": {
    "color": {
      "palette": [
        { "slug": "primary", "color": "#0073aa", "name": "Primary" },
        { "slug": "secondary", "color": "#23282d", "name": "Secondary" }
      ]
    },
    "typography": {
      "fontSizes": [
        { "slug": "small", "size": "14px", "name": "Small" },
        { "slug": "medium", "size": "18px", "name": "Medium" }
      ]
    }
  },
  "styles": {
    "color": {
      "background": "var(--wp--preset--color--primary)",
      "text": "#ffffff"
    }
  }
}
```

## CSS Custom Properties

theme.json generates CSS custom properties:

| Pattern | Example |
|---------|---------|
| `--wp--preset--color--{slug}` | `--wp--preset--color--primary` |
| `--wp--preset--font-size--{slug}` | `--wp--preset--font-size--medium` |
| `--wp--preset--spacing--{slug}` | `--wp--preset--spacing--20` |
| `--wp--preset--gradient--{slug}` | `--wp--preset--gradient--vivid-cyan` |
| `--wp--preset--shadow--{slug}` | `--wp--preset--shadow--natural` |
| `--wp--custom--{path}` | `--wp--custom--line-height--body` |
