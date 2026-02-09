# Typography Settings

Complete reference for `settings.typography` in theme.json.

## Overview

```json
{
  "settings": {
    "typography": {
      "customFontSize": true,
      "defaultFontSizes": true,
      "dropCap": true,
      "fluid": false,
      "fontFamilies": [],
      "fontSizes": [],
      "fontStyle": true,
      "fontWeight": true,
      "letterSpacing": true,
      "lineHeight": false,
      "textAlign": true,
      "textColumns": false,
      "textDecoration": true,
      "textTransform": true,
      "writingMode": false
    }
  }
}
```

## Feature Toggles

### customFontSize

Controls whether users can enter custom font sizes.

```json
{ "settings": { "typography": { "customFontSize": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Custom size input field available |
| `false` | Only preset font sizes available |

### defaultFontSizes

Whether to include WordPress default font sizes.

```json
{ "settings": { "typography": { "defaultFontSizes": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default in v3) | Core font sizes included (small, medium, large, x-large, xx-large) |
| `false` | Only theme-defined font sizes available |

**Note**: In theme.json v2, default was `false`. Changed to `true` in v3.

**WordPress default font sizes:**

| Slug | Size | Fluid |
|------|------|-------|
| small | 13px | No |
| medium | 20px | No |
| large | 36px | clamp(1.75rem, 3vw, 2.25rem) |
| x-large | 42px | clamp(2.5rem, 4vw, 2.625rem) |
| xx-large | 48px | clamp(2.75rem, 4.5vw, 3rem) |

### dropCap

Controls whether drop cap option is available for paragraphs.

```json
{ "settings": { "typography": { "dropCap": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Drop cap toggle in paragraph block |
| `false` | Drop cap option hidden |

### lineHeight

Controls whether line height can be customized.

```json
{ "settings": { "typography": { "lineHeight": true } } }
```

| Value | Effect |
|-------|--------|
| `true` | Line height input available |
| `false` (default) | Line height control hidden |

**Note**: Enable via `appearanceTools: true` as a shortcut.

### fontStyle

Controls whether font style (italic, normal) can be customized.

```json
{ "settings": { "typography": { "fontStyle": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Font style control available |
| `false` | Font style control hidden |

### fontWeight

Controls whether font weight can be customized.

```json
{ "settings": { "typography": { "fontWeight": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Font weight control available |
| `false` | Font weight control hidden |

### letterSpacing

Controls whether letter spacing can be customized.

```json
{ "settings": { "typography": { "letterSpacing": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Letter spacing input available |
| `false` | Letter spacing control hidden |

### textAlign

Controls whether text alignment can be customized.

```json
{ "settings": { "typography": { "textAlign": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Text alignment controls available |
| `false` | Text alignment controls hidden |

### textColumns

Controls whether text columns can be customized.

```json
{ "settings": { "typography": { "textColumns": true } } }
```

| Value | Effect |
|-------|--------|
| `true` | Text columns input available |
| `false` (default) | Text columns control hidden |

### textDecoration

Controls whether text decoration (underline, strikethrough) can be customized.

```json
{ "settings": { "typography": { "textDecoration": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Text decoration controls available |
| `false` | Text decoration controls hidden |

### textTransform

Controls whether text transform (uppercase, lowercase, capitalize) can be customized.

```json
{ "settings": { "typography": { "textTransform": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Text transform controls available |
| `false` | Text transform controls hidden |

### writingMode

Controls whether writing mode (horizontal, vertical) can be customized.

```json
{ "settings": { "typography": { "writingMode": true } } }
```

| Value | Effect |
|-------|--------|
| `true` | Writing mode controls available |
| `false` (default) | Writing mode controls hidden |

## Fluid Typography

### fluid

Enable fluid typography (responsive font sizes based on viewport).

```json
{
  "settings": {
    "typography": {
      "fluid": true
    }
  }
}
```

**Simple boolean:**

| Value | Effect |
|-------|--------|
| `true` | Fluid typography enabled with defaults |
| `false` (default) | Static font sizes |

**Advanced configuration:**

```json
{
  "settings": {
    "typography": {
      "fluid": {
        "minViewportWidth": "320px",
        "maxViewportWidth": "1600px"
      }
    }
  }
}
```

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `minViewportWidth` | string | "320px" | Viewport width where fluid scaling starts |
| `maxViewportWidth` | string | "1600px" | Viewport width where fluid scaling ends |

**How fluid works:**

When enabled, font sizes use CSS `clamp()` to scale smoothly between min and max viewport widths:

```css
/* Without fluid */
font-size: 36px;

/* With fluid */
font-size: clamp(1.75rem, 3vw, 2.25rem);
```

## Custom Presets

### fontFamilies

Define custom font family presets.

```json
{
  "settings": {
    "typography": {
      "fontFamilies": [
        {
          "slug": "system",
          "name": "System Font",
          "fontFamily": "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif"
        },
        {
          "slug": "heading",
          "name": "Heading Font",
          "fontFamily": "Georgia, 'Times New Roman', serif"
        },
        {
          "slug": "monospace",
          "name": "Monospace",
          "fontFamily": "Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace"
        }
      ]
    }
  }
}
```

**Each font family item:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `slug` | string | Yes | Unique identifier |
| `name` | string | Yes | Human-readable name |
| `fontFamily` | string | Yes | CSS font-family value |
| `fontFace` | array | No | Web font definitions (see below) |

**Generated CSS variable:**
```css
--wp--preset--font-family--{slug}: {fontFamily};

/* Example */
--wp--preset--font-family--system: -apple-system, BlinkMacSystemFont, 'Segoe UI', ...;
```

### fontFace (Web Fonts)

Define web fonts within a font family:

```json
{
  "settings": {
    "typography": {
      "fontFamilies": [
        {
          "slug": "inter",
          "name": "Inter",
          "fontFamily": "Inter, sans-serif",
          "fontFace": [
            {
              "fontFamily": "Inter",
              "fontWeight": "400",
              "fontStyle": "normal",
              "src": ["file:./assets/fonts/inter-regular.woff2"]
            },
            {
              "fontFamily": "Inter",
              "fontWeight": "400",
              "fontStyle": "italic",
              "src": ["file:./assets/fonts/inter-italic.woff2"]
            },
            {
              "fontFamily": "Inter",
              "fontWeight": "700",
              "fontStyle": "normal",
              "src": ["file:./assets/fonts/inter-bold.woff2"]
            }
          ]
        }
      ]
    }
  }
}
```

**Each fontFace item:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `fontFamily` | string | Yes | Font family name (matches @font-face) |
| `fontWeight` | string | Yes | Weight value (100-900, or "400 700" for variable) |
| `fontStyle` | string | Yes | "normal" or "italic" |
| `src` | array | Yes | Array of font file URLs |
| `fontDisplay` | string | No | "auto", "block", "swap", "fallback", "optional" |
| `fontStretch` | string | No | "normal", "condensed", "expanded", etc. |
| `unicodeRange` | string | No | Unicode range for subsetting |
| `sizeAdjust` | string | No | Size adjustment percentage |
| `ascentOverride` | string | No | Ascent metric override |
| `descentOverride` | string | No | Descent metric override |
| `lineGapOverride` | string | No | Line gap metric override |

**Font source formats:**

```json
{
  "src": [
    "file:./assets/fonts/font.woff2",
    "file:./assets/fonts/font.woff"
  ]
}
```

- `file:./` - Relative to theme root
- `file:/absolute/path` - Absolute path
- External URLs also supported

**Variable fonts:**

```json
{
  "fontFamily": "Inter",
  "fontWeight": "100 900",
  "fontStyle": "normal",
  "src": ["file:./assets/fonts/inter-variable.woff2"]
}
```

**Generated @font-face CSS:**

```css
@font-face {
  font-family: Inter;
  font-weight: 400;
  font-style: normal;
  font-display: fallback;
  src: url('/wp-content/themes/mytheme/assets/fonts/inter-regular.woff2') format('woff2');
}
```

### fontSizes

Define custom font size presets.

```json
{
  "settings": {
    "typography": {
      "fontSizes": [
        {
          "slug": "small",
          "size": "0.875rem",
          "name": "Small"
        },
        {
          "slug": "medium",
          "size": "1rem",
          "name": "Medium"
        },
        {
          "slug": "large",
          "size": "1.5rem",
          "name": "Large"
        },
        {
          "slug": "x-large",
          "size": "2rem",
          "name": "Extra Large"
        }
      ]
    }
  }
}
```

**Each font size item:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `slug` | string | Yes | Unique identifier |
| `size` | string | Yes | CSS font-size value |
| `name` | string | Yes | Human-readable name |
| `fluid` | object/boolean | No | Fluid typography settings for this size |

**Generated CSS variable:**
```css
--wp--preset--font-size--{slug}: {size};
```

**Generated class:**
```css
.has-{slug}-font-size {
  font-size: var(--wp--preset--font-size--{slug});
}
```

### Fluid Font Sizes

Enable fluid scaling per font size:

```json
{
  "settings": {
    "typography": {
      "fluid": true,
      "fontSizes": [
        {
          "slug": "small",
          "size": "0.875rem",
          "name": "Small",
          "fluid": false
        },
        {
          "slug": "large",
          "size": "2rem",
          "name": "Large",
          "fluid": {
            "min": "1.5rem",
            "max": "2rem"
          }
        },
        {
          "slug": "x-large",
          "size": "3rem",
          "name": "Extra Large",
          "fluid": {
            "min": "2rem",
            "max": "3rem"
          }
        }
      ]
    }
  }
}
```

**Fluid object properties:**

| Property | Type | Description |
|----------|------|-------------|
| `min` | string | Minimum font size (at minViewportWidth) |
| `max` | string | Maximum font size (at maxViewportWidth) |

**Generated fluid CSS:**
```css
--wp--preset--font-size--large: clamp(1.5rem, 1.5rem + ((1vw - 0.2rem) * 0.625), 2rem);
```

## Complete Example

```json
{
  "settings": {
    "typography": {
      "customFontSize": false,
      "defaultFontSizes": false,
      "dropCap": true,
      "lineHeight": true,
      "fontStyle": true,
      "fontWeight": true,
      "letterSpacing": true,
      "textAlign": true,
      "textColumns": true,
      "textDecoration": true,
      "textTransform": true,
      "writingMode": false,
      "fluid": {
        "minViewportWidth": "375px",
        "maxViewportWidth": "1440px"
      },
      "fontFamilies": [
        {
          "slug": "primary",
          "name": "Inter",
          "fontFamily": "'Inter', sans-serif",
          "fontFace": [
            {
              "fontFamily": "Inter",
              "fontWeight": "400 700",
              "fontStyle": "normal",
              "fontDisplay": "swap",
              "src": ["file:./assets/fonts/Inter-VariableFont.woff2"]
            }
          ]
        },
        {
          "slug": "secondary",
          "name": "Playfair Display",
          "fontFamily": "'Playfair Display', Georgia, serif",
          "fontFace": [
            {
              "fontFamily": "Playfair Display",
              "fontWeight": "400",
              "fontStyle": "normal",
              "fontDisplay": "swap",
              "src": ["file:./assets/fonts/PlayfairDisplay-Regular.woff2"]
            },
            {
              "fontFamily": "Playfair Display",
              "fontWeight": "700",
              "fontStyle": "normal",
              "fontDisplay": "swap",
              "src": ["file:./assets/fonts/PlayfairDisplay-Bold.woff2"]
            }
          ]
        },
        {
          "slug": "code",
          "name": "JetBrains Mono",
          "fontFamily": "'JetBrains Mono', monospace",
          "fontFace": [
            {
              "fontFamily": "JetBrains Mono",
              "fontWeight": "400",
              "fontStyle": "normal",
              "fontDisplay": "swap",
              "src": ["file:./assets/fonts/JetBrainsMono-Regular.woff2"]
            }
          ]
        }
      ],
      "fontSizes": [
        {
          "slug": "small",
          "size": "0.875rem",
          "name": "Small",
          "fluid": false
        },
        {
          "slug": "medium",
          "size": "1rem",
          "name": "Medium",
          "fluid": false
        },
        {
          "slug": "large",
          "size": "1.25rem",
          "name": "Large",
          "fluid": {
            "min": "1.125rem",
            "max": "1.25rem"
          }
        },
        {
          "slug": "x-large",
          "size": "2rem",
          "name": "Extra Large",
          "fluid": {
            "min": "1.5rem",
            "max": "2rem"
          }
        },
        {
          "slug": "xx-large",
          "size": "3rem",
          "name": "Huge",
          "fluid": {
            "min": "2rem",
            "max": "3rem"
          }
        }
      ]
    }
  }
}
```

## Per-Block Typography Settings

Override typography settings for specific blocks:

```json
{
  "settings": {
    "typography": {
      "fontSizes": [
        { "slug": "small", "size": "0.875rem", "name": "Small" },
        { "slug": "medium", "size": "1rem", "name": "Medium" },
        { "slug": "large", "size": "1.5rem", "name": "Large" }
      ]
    },
    "blocks": {
      "core/heading": {
        "typography": {
          "fontSizes": [
            { "slug": "medium", "size": "1.5rem", "name": "Medium" },
            { "slug": "large", "size": "2.5rem", "name": "Large" },
            { "slug": "x-large", "size": "4rem", "name": "Extra Large" }
          ]
        }
      },
      "core/code": {
        "typography": {
          "fontFamilies": [
            {
              "slug": "code",
              "name": "Monospace",
              "fontFamily": "monospace"
            }
          ]
        }
      }
    }
  }
}
```

## CSS Variable Reference

| Setting | CSS Variable Pattern |
|---------|---------------------|
| `fontFamilies` | `--wp--preset--font-family--{slug}` |
| `fontSizes` | `--wp--preset--font-size--{slug}` |

## Common Patterns

### Strict Type Scale

```json
{
  "settings": {
    "typography": {
      "customFontSize": false,
      "defaultFontSizes": false,
      "fontSizes": [ /* your sizes only */ ]
    }
  }
}
```

### System Fonts Only

```json
{
  "settings": {
    "typography": {
      "fontFamilies": [
        {
          "slug": "sans",
          "name": "Sans Serif",
          "fontFamily": "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif"
        },
        {
          "slug": "serif",
          "name": "Serif",
          "fontFamily": "Georgia, 'Times New Roman', Times, serif"
        },
        {
          "slug": "mono",
          "name": "Monospace",
          "fontFamily": "Consolas, Monaco, 'Courier New', monospace"
        }
      ]
    }
  }
}
```

### Full Fluid Typography

```json
{
  "settings": {
    "typography": {
      "fluid": {
        "minViewportWidth": "320px",
        "maxViewportWidth": "1400px"
      },
      "fontSizes": [
        { "slug": "small", "size": "1rem", "fluid": { "min": "0.875rem", "max": "1rem" } },
        { "slug": "medium", "size": "1.25rem", "fluid": { "min": "1rem", "max": "1.25rem" } },
        { "slug": "large", "size": "2rem", "fluid": { "min": "1.5rem", "max": "2rem" } },
        { "slug": "x-large", "size": "3rem", "fluid": { "min": "2rem", "max": "3rem" } },
        { "slug": "xx-large", "size": "4rem", "fluid": { "min": "2.5rem", "max": "4rem" } }
      ]
    }
  }
}
```
