# Color Settings

Complete reference for `settings.color` in theme.json.

## Overview

```json
{
  "settings": {
    "color": {
      "background": true,
      "custom": true,
      "customDuotone": true,
      "customGradient": true,
      "defaultDuotone": true,
      "defaultGradients": true,
      "defaultPalette": true,
      "duotone": [],
      "gradients": [],
      "link": false,
      "palette": [],
      "text": true,
      "heading": false,
      "button": false,
      "caption": false
    }
  }
}
```

## Feature Toggles

### background

Controls whether blocks can set background colors.

```json
{ "settings": { "color": { "background": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Background color picker available |
| `false` | Background color picker hidden |

### text

Controls whether blocks can set text colors.

```json
{ "settings": { "color": { "text": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Text color picker available |
| `false` | Text color picker hidden |

### link

Controls whether link color can be customized globally.

```json
{ "settings": { "color": { "link": true } } }
```

| Value | Effect |
|-------|--------|
| `true` | Link color picker available |
| `false` (default) | Link color picker hidden |

**Note**: Enable via `appearanceTools: true` as a shortcut.

### heading

Controls whether heading colors can be customized.

```json
{ "settings": { "color": { "heading": true } } }
```

| Value | Effect |
|-------|--------|
| `true` | Heading color picker available |
| `false` (default) | Heading color picker hidden |

**Note**: Enable via `appearanceTools: true` as a shortcut.

### button

Controls whether button colors can be customized.

```json
{ "settings": { "color": { "button": true } } }
```

| Value | Effect |
|-------|--------|
| `true` | Button color picker available |
| `false` (default) | Button color picker hidden |

**Note**: Enable via `appearanceTools: true` as a shortcut.

### caption

Controls whether caption colors can be customized.

```json
{ "settings": { "color": { "caption": true } } }
```

| Value | Effect |
|-------|--------|
| `true` | Caption color picker available |
| `false` (default) | Caption color picker hidden |

**Note**: Enable via `appearanceTools: true` as a shortcut.

### custom

Controls whether users can pick arbitrary colors (not in palette).

```json
{ "settings": { "color": { "custom": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Full color picker available |
| `false` | Only palette colors available |

### customGradient

Controls whether users can create custom gradients.

```json
{ "settings": { "color": { "customGradient": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Gradient editor available |
| `false` | Only preset gradients available |

### customDuotone

Controls whether users can create custom duotone filters.

```json
{ "settings": { "color": { "customDuotone": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Custom duotone editor available |
| `false` | Only preset duotone filters available |

## Default Presets

### defaultPalette

Whether to include WordPress default colors.

```json
{ "settings": { "color": { "defaultPalette": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Core colors (black, cyan-bluish-gray, etc.) included |
| `false` | Only theme-defined colors available |

**WordPress default palette** (when `true`):
- Black (#000000)
- Cyan bluish gray (#abb8c3)
- White (#ffffff)
- Pale pink (#f78da7)
- Vivid red (#cf2e2e)
- Luminous vivid orange (#ff6900)
- Luminous vivid amber (#fcb900)
- Light green cyan (#7bdcb5)
- Vivid green cyan (#00d084)
- Pale cyan blue (#8ed1fc)
- Vivid cyan blue (#0693e6)
- Vivid purple (#9b51e0)

### defaultGradients

Whether to include WordPress default gradients.

```json
{ "settings": { "color": { "defaultGradients": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Core gradients included |
| `false` | Only theme-defined gradients available |

### defaultDuotone

Whether to include WordPress default duotone presets.

```json
{ "settings": { "color": { "defaultDuotone": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Core duotone filters included |
| `false` | Only theme-defined duotone filters available |

## Custom Presets

### palette

Define custom color presets.

```json
{
  "settings": {
    "color": {
      "palette": [
        {
          "slug": "primary",
          "color": "#0066cc",
          "name": "Primary"
        },
        {
          "slug": "secondary", 
          "color": "#ff6600",
          "name": "Secondary"
        },
        {
          "slug": "dark",
          "color": "#1a1a1a",
          "name": "Dark"
        },
        {
          "slug": "light",
          "color": "#f5f5f5",
          "name": "Light"
        }
      ]
    }
  }
}
```

**Each palette item:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `slug` | string | Yes | Unique identifier (used in CSS variable) |
| `color` | string | Yes | Hex, RGB, RGBA, or HSL color value |
| `name` | string | Yes | Human-readable name shown in editor |

**Generated CSS variable:**
```css
--wp--preset--color--{slug}: {color};

/* Example */
--wp--preset--color--primary: #0066cc;
```

**Usage in theme.json styles:**
```json
{
  "styles": {
    "color": {
      "background": "var(--wp--preset--color--primary)"
    }
  }
}
```

**Usage in blocks:**
```html
<!-- Background color -->
<div class="has-primary-background-color has-background">

<!-- Text color -->
<p class="has-secondary-color has-text-color">
```

### gradients

Define custom gradient presets.

```json
{
  "settings": {
    "color": {
      "gradients": [
        {
          "slug": "primary-to-secondary",
          "gradient": "linear-gradient(135deg, #0066cc 0%, #ff6600 100%)",
          "name": "Primary to Secondary"
        },
        {
          "slug": "vertical-dark",
          "gradient": "linear-gradient(180deg, #1a1a1a 0%, #333333 100%)",
          "name": "Vertical Dark"
        },
        {
          "slug": "radial-light",
          "gradient": "radial-gradient(circle, #ffffff 0%, #f5f5f5 100%)",
          "name": "Radial Light"
        }
      ]
    }
  }
}
```

**Each gradient item:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `slug` | string | Yes | Unique identifier |
| `gradient` | string | Yes | CSS gradient value |
| `name` | string | Yes | Human-readable name |

**Supported gradient types:**
- `linear-gradient()`
- `radial-gradient()`
- `conic-gradient()`
- Repeating variants

**Generated CSS variable:**
```css
--wp--preset--gradient--{slug}: {gradient};
```

**Generated class:**
```css
.has-{slug}-gradient-background {
  background: var(--wp--preset--gradient--{slug});
}
```

### duotone

Define custom duotone filter presets for images.

```json
{
  "settings": {
    "color": {
      "duotone": [
        {
          "slug": "blue-orange",
          "colors": ["#0066cc", "#ff6600"],
          "name": "Blue and Orange"
        },
        {
          "slug": "dark-grayscale",
          "colors": ["#000000", "#ffffff"],
          "name": "Dark Grayscale"
        },
        {
          "slug": "purple-yellow",
          "colors": ["#674399", "#fcb900"],
          "name": "Purple and Yellow"
        }
      ]
    }
  }
}
```

**Each duotone item:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `slug` | string | Yes | Unique identifier |
| `colors` | array | Yes | Array of exactly 2 colors [shadow, highlight] |
| `name` | string | Yes | Human-readable name |

**How duotone works:**
1. First color = darkest tones (shadows)
2. Second color = lightest tones (highlights)
3. Mid-tones blend between the two

**Generated CSS:**
```css
/* SVG filter definition injected into page */
<svg><filter id="wp-duotone-blue-orange">...</filter></svg>

/* Applied via CSS */
.wp-duotone-blue-orange img {
  filter: url(#wp-duotone-blue-orange);
}
```

## Complete Example

```json
{
  "settings": {
    "color": {
      "background": true,
      "text": true,
      "link": true,
      "heading": true,
      "button": true,
      "caption": true,
      "custom": false,
      "customGradient": false,
      "customDuotone": false,
      "defaultPalette": false,
      "defaultGradients": false,
      "defaultDuotone": false,
      "palette": [
        { "slug": "base", "color": "#ffffff", "name": "Base" },
        { "slug": "contrast", "color": "#1a1a1a", "name": "Contrast" },
        { "slug": "primary", "color": "#0066cc", "name": "Primary" },
        { "slug": "secondary", "color": "#ff6600", "name": "Secondary" },
        { "slug": "tertiary", "color": "#f5f5f5", "name": "Tertiary" }
      ],
      "gradients": [
        {
          "slug": "primary-gradient",
          "gradient": "linear-gradient(180deg, #0066cc 0%, #004499 100%)",
          "name": "Primary Gradient"
        }
      ],
      "duotone": [
        {
          "slug": "primary-contrast",
          "colors": ["#0066cc", "#ffffff"],
          "name": "Primary and White"
        }
      ]
    }
  }
}
```

This configuration:
- Enables all color controls
- Disables custom color pickers (strict palette)
- Removes all WordPress defaults
- Defines a focused 5-color palette
- Adds one gradient
- Adds one duotone filter

## Per-Block Color Settings

Override color settings for specific blocks:

```json
{
  "settings": {
    "color": {
      "custom": false,
      "palette": [
        { "slug": "primary", "color": "#0066cc", "name": "Primary" },
        { "slug": "white", "color": "#ffffff", "name": "White" }
      ]
    },
    "blocks": {
      "core/button": {
        "color": {
          "custom": true,
          "palette": [
            { "slug": "button-primary", "color": "#00cc66", "name": "Button Primary" },
            { "slug": "button-dark", "color": "#1a1a1a", "name": "Button Dark" }
          ]
        }
      },
      "core/heading": {
        "color": {
          "text": false,
          "background": false
        }
      }
    }
  }
}
```

This gives buttons their own palette while removing color controls entirely from headings.

## CSS Variable Reference

| Setting | CSS Variable Pattern |
|---------|---------------------|
| `palette` | `--wp--preset--color--{slug}` |
| `gradients` | `--wp--preset--gradient--{slug}` |

## Common Patterns

### Strict Design System (No Custom Colors)

```json
{
  "settings": {
    "color": {
      "custom": false,
      "customGradient": false,
      "customDuotone": false,
      "defaultPalette": false,
      "defaultGradients": false,
      "defaultDuotone": false,
      "palette": [ /* your colors only */ ]
    }
  }
}
```

### Minimal (Background and Text Only)

```json
{
  "settings": {
    "color": {
      "background": true,
      "text": true,
      "link": false,
      "heading": false,
      "button": false,
      "custom": true,
      "defaultPalette": false,
      "gradients": [],
      "duotone": []
    }
  }
}
```

### Full Control (Everything Enabled)

```json
{
  "settings": {
    "appearanceTools": true,
    "color": {
      "custom": true,
      "customGradient": true,
      "customDuotone": true,
      "defaultPalette": true,
      "defaultGradients": true,
      "defaultDuotone": true,
      "palette": [ /* extend with theme colors */ ],
      "gradients": [ /* extend with theme gradients */ ],
      "duotone": [ /* extend with theme duotone */ ]
    }
  }
}
```
