# Spacing Settings

Complete reference for `settings.spacing` in theme.json.

## Overview

```json
{
  "settings": {
    "spacing": {
      "blockGap": null,
      "customSpacingSize": true,
      "defaultSpacingSizes": true,
      "margin": false,
      "padding": false,
      "spacingSizes": [],
      "spacingScale": {},
      "units": ["px", "em", "rem", "vh", "vw", "%"]
    }
  }
}
```

## Feature Toggles

### blockGap

Controls whether gap between blocks can be customized.

```json
{ "settings": { "spacing": { "blockGap": true } } }
```

| Value | Effect |
|-------|--------|
| `true` | Block gap controls available |
| `false` | Block gap controls hidden |
| `null` (default) | Block gap supported but no default rendered |

When enabled, adds gap control to blocks that support it (Group, Columns, etc.).

**Note**: Enable via `appearanceTools: true` as a shortcut.

### margin

Controls whether margin can be customized.

```json
{ "settings": { "spacing": { "margin": true } } }
```

| Value | Effect |
|-------|--------|
| `true` | Margin controls available |
| `false` (default) | Margin controls hidden |

**Note**: Enable via `appearanceTools: true` as a shortcut.

### padding

Controls whether padding can be customized.

```json
{ "settings": { "spacing": { "padding": true } } }
```

| Value | Effect |
|-------|--------|
| `true` | Padding controls available |
| `false` (default) | Padding controls hidden |

**Note**: Enable via `appearanceTools: true` as a shortcut.

### customSpacingSize

Controls whether users can enter custom spacing values.

```json
{ "settings": { "spacing": { "customSpacingSize": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Custom spacing input available |
| `false` | Only preset spacing sizes available |

### defaultSpacingSizes

Whether to include WordPress default spacing sizes.

```json
{ "settings": { "spacing": { "defaultSpacingSizes": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Core spacing sizes included |
| `false` | Only theme-defined spacing sizes available |

**WordPress default spacing scale:**

| Slug | Size | Name |
|------|------|------|
| 20 | 0.44rem | 2X-Small |
| 30 | 0.67rem | X-Small |
| 40 | 1rem | Small |
| 50 | 1.5rem | Medium |
| 60 | 2.25rem | Large |
| 70 | 3.38rem | X-Large |
| 80 | 5.06rem | 2X-Large |

### units

Define allowed CSS units for spacing values.

```json
{
  "settings": {
    "spacing": {
      "units": ["px", "em", "rem", "vh", "vw", "%"]
    }
  }
}
```

**Available units:**
- `px` - Pixels
- `em` - Relative to parent font size
- `rem` - Relative to root font size
- `vh` - Viewport height percentage
- `vw` - Viewport width percentage
- `%` - Percentage of parent
- `svw`, `svh` - Small viewport units
- `lvw`, `lvh` - Large viewport units
- `dvw`, `dvh` - Dynamic viewport units

**Example: Limit to rem only:**

```json
{
  "settings": {
    "spacing": {
      "units": ["rem"]
    }
  }
}
```

## Custom Presets

### spacingSizes

Define custom spacing presets.

```json
{
  "settings": {
    "spacing": {
      "spacingSizes": [
        { "slug": "10", "size": "0.25rem", "name": "Tiny" },
        { "slug": "20", "size": "0.5rem", "name": "X-Small" },
        { "slug": "30", "size": "1rem", "name": "Small" },
        { "slug": "40", "size": "1.5rem", "name": "Medium" },
        { "slug": "50", "size": "2rem", "name": "Large" },
        { "slug": "60", "size": "3rem", "name": "X-Large" },
        { "slug": "70", "size": "4rem", "name": "Huge" }
      ]
    }
  }
}
```

**Each spacing size item:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `slug` | string | Yes | Unique identifier (commonly numeric: 10, 20, 30...) |
| `size` | string | Yes | CSS size value |
| `name` | string | Yes | Human-readable name |

**Generated CSS variable:**
```css
--wp--preset--spacing--{slug}: {size};

/* Example */
--wp--preset--spacing--40: 1.5rem;
```

**Usage in theme.json styles:**
```json
{
  "styles": {
    "spacing": {
      "padding": {
        "top": "var(--wp--preset--spacing--40)",
        "bottom": "var(--wp--preset--spacing--40)"
      }
    }
  }
}
```

### spacingScale

Generate spacing sizes automatically using a mathematical scale.

```json
{
  "settings": {
    "spacing": {
      "spacingScale": {
        "operator": "*",
        "increment": 1.5,
        "steps": 7,
        "mediumStep": 1.5,
        "unit": "rem"
      }
    }
  }
}
```

**Spacing scale properties:**

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `operator` | string | "*" | Mathematical operator: "*" (multiply) or "+" (add) |
| `increment` | number | 1.5 | Value to multiply/add at each step |
| `steps` | integer | 7 | Number of sizes to generate |
| `mediumStep` | number | 1.5 | Value of the middle step |
| `unit` | string | "rem" | CSS unit for generated values |

**Example: Multiplicative scale (1.5x)**

```json
{
  "spacingScale": {
    "operator": "*",
    "increment": 1.5,
    "steps": 7,
    "mediumStep": 1.5,
    "unit": "rem"
  }
}
```

Generates (approximately):
- Step 1: 0.44rem
- Step 2: 0.67rem
- Step 3: 1rem
- Step 4: 1.5rem (medium)
- Step 5: 2.25rem
- Step 6: 3.38rem
- Step 7: 5.06rem

**Example: Additive scale (+0.5rem)**

```json
{
  "spacingScale": {
    "operator": "+",
    "increment": 0.5,
    "steps": 7,
    "mediumStep": 1.5,
    "unit": "rem"
  }
}
```

Generates:
- Step 1: 0rem
- Step 2: 0.5rem
- Step 3: 1rem
- Step 4: 1.5rem (medium)
- Step 5: 2rem
- Step 6: 2.5rem
- Step 7: 3rem

**Note**: `spacingScale` and `spacingSizes` are mutually exclusive. If both are defined, `spacingSizes` takes precedence.

## Complete Example

```json
{
  "settings": {
    "spacing": {
      "blockGap": true,
      "margin": true,
      "padding": true,
      "customSpacingSize": false,
      "defaultSpacingSizes": false,
      "units": ["rem", "%"],
      "spacingSizes": [
        { "slug": "10", "size": "0.25rem", "name": "3XS" },
        { "slug": "20", "size": "0.5rem", "name": "2XS" },
        { "slug": "30", "size": "0.75rem", "name": "XS" },
        { "slug": "40", "size": "1rem", "name": "S" },
        { "slug": "50", "size": "1.5rem", "name": "M" },
        { "slug": "60", "size": "2rem", "name": "L" },
        { "slug": "70", "size": "3rem", "name": "XL" },
        { "slug": "80", "size": "4rem", "name": "2XL" },
        { "slug": "90", "size": "6rem", "name": "3XL" }
      ]
    }
  }
}
```

This configuration:
- Enables all spacing controls (blockGap, margin, padding)
- Disables custom spacing input (strict preset use)
- Removes WordPress defaults
- Limits units to rem and %
- Defines a 9-step custom spacing scale

## Per-Block Spacing Settings

Override spacing settings for specific blocks:

```json
{
  "settings": {
    "spacing": {
      "padding": true,
      "margin": true,
      "blockGap": true
    },
    "blocks": {
      "core/paragraph": {
        "spacing": {
          "margin": true,
          "padding": false
        }
      },
      "core/group": {
        "spacing": {
          "padding": true,
          "margin": true,
          "blockGap": true,
          "spacingSizes": [
            { "slug": "small", "size": "1rem", "name": "Small" },
            { "slug": "large", "size": "4rem", "name": "Large" }
          ]
        }
      },
      "core/buttons": {
        "spacing": {
          "blockGap": true,
          "spacingSizes": [
            { "slug": "tight", "size": "0.5rem", "name": "Tight" },
            { "slug": "normal", "size": "1rem", "name": "Normal" },
            { "slug": "loose", "size": "2rem", "name": "Loose" }
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
| `spacingSizes` | `--wp--preset--spacing--{slug}` |

## Using Spacing Variables

### In theme.json styles

```json
{
  "styles": {
    "spacing": {
      "padding": {
        "top": "var(--wp--preset--spacing--50)",
        "right": "var(--wp--preset--spacing--40)",
        "bottom": "var(--wp--preset--spacing--50)",
        "left": "var(--wp--preset--spacing--40)"
      },
      "margin": {
        "top": "0",
        "bottom": "var(--wp--preset--spacing--60)"
      },
      "blockGap": "var(--wp--preset--spacing--40)"
    },
    "blocks": {
      "core/group": {
        "spacing": {
          "padding": {
            "top": "var(--wp--preset--spacing--60)",
            "bottom": "var(--wp--preset--spacing--60)"
          }
        }
      }
    }
  }
}
```

### In CSS

```css
.my-element {
  padding: var(--wp--preset--spacing--50);
  margin-bottom: var(--wp--preset--spacing--40);
  gap: var(--wp--preset--spacing--30);
}
```

## Common Patterns

### Strict Spacing System

```json
{
  "settings": {
    "spacing": {
      "customSpacingSize": false,
      "defaultSpacingSizes": false,
      "spacingSizes": [ /* your sizes only */ ]
    }
  }
}
```

### 8px Grid System

```json
{
  "settings": {
    "spacing": {
      "defaultSpacingSizes": false,
      "spacingSizes": [
        { "slug": "1", "size": "0.5rem", "name": "8px" },
        { "slug": "2", "size": "1rem", "name": "16px" },
        { "slug": "3", "size": "1.5rem", "name": "24px" },
        { "slug": "4", "size": "2rem", "name": "32px" },
        { "slug": "5", "size": "2.5rem", "name": "40px" },
        { "slug": "6", "size": "3rem", "name": "48px" },
        { "slug": "8", "size": "4rem", "name": "64px" },
        { "slug": "10", "size": "5rem", "name": "80px" },
        { "slug": "12", "size": "6rem", "name": "96px" }
      ]
    }
  }
}
```

### Modular Scale (Based on Typography)

```json
{
  "settings": {
    "spacing": {
      "defaultSpacingSizes": false,
      "spacingScale": {
        "operator": "*",
        "increment": 1.618,
        "steps": 9,
        "mediumStep": 1.5,
        "unit": "rem"
      }
    }
  }
}
```

Uses golden ratio (1.618) for harmonious spacing.

### Enable Everything (with appearanceTools)

```json
{
  "settings": {
    "appearanceTools": true
  }
}
```

This enables `blockGap`, `margin`, and `padding` all at once.

## Block Gap Specifics

Block gap controls vertical spacing between blocks inside container blocks.

**Blocks that support blockGap:**
- Group (`core/group`)
- Columns (`core/columns`)
- Column (`core/column`)
- Stack (`core/stack` - Group variation)
- Row (`core/row` - Group variation)
- Buttons (`core/buttons`)
- Social Links (`core/social-links`)
- Navigation (`core/navigation`)
- Post Template (`core/post-template`)
- Query Loop (`core/query`)
- Comments (`core/comments`)

**Gap inheritance:**

```json
{
  "styles": {
    "spacing": {
      "blockGap": "2rem"
    },
    "blocks": {
      "core/columns": {
        "spacing": {
          "blockGap": "1rem"
        }
      }
    }
  }
}
```

Global blockGap applies to body-level blocks. Block-specific overrides for nested containers.

**CSS output:**

```css
/* Global */
body {
  --wp--style--block-gap: 2rem;
}

/* For blocks that use gap */
.wp-block-group {
  gap: var(--wp--style--block-gap);
}

/* Block override */
.wp-block-columns {
  gap: 1rem;
}
```
