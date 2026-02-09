# Other Settings

Complete reference for border, shadow, dimensions, position, background, appearance tools, custom properties, and other settings.

## appearanceTools

Meta-setting that enables multiple design tools at once.

```json
{
  "settings": {
    "appearanceTools": true
  }
}
```

**What it enables:**

| Setting | Path |
|---------|------|
| Background images | `background.backgroundImage` |
| Background size | `background.backgroundSize` |
| Border color | `border.color` |
| Border radius | `border.radius` |
| Border style | `border.style` |
| Border width | `border.width` |
| Button colors | `color.button` |
| Caption colors | `color.caption` |
| Heading colors | `color.heading` |
| Link colors | `color.link` |
| Text columns | `typography.textColumns` |
| Line height | `typography.lineHeight` |
| Writing mode | `typography.writingMode` |
| Block gap | `spacing.blockGap` |
| Margin | `spacing.margin` |
| Padding | `spacing.padding` |
| Min height | `dimensions.minHeight` |
| Aspect ratio | `dimensions.aspectRatio` |
| Position sticky | `position.sticky` |

**Equivalent to:**

```json
{
  "settings": {
    "background": {
      "backgroundImage": true,
      "backgroundSize": true
    },
    "border": {
      "color": true,
      "radius": true,
      "style": true,
      "width": true
    },
    "color": {
      "button": true,
      "caption": true,
      "heading": true,
      "link": true
    },
    "dimensions": {
      "aspectRatio": true,
      "minHeight": true
    },
    "position": {
      "sticky": true
    },
    "spacing": {
      "blockGap": true,
      "margin": true,
      "padding": true
    },
    "typography": {
      "lineHeight": true,
      "textColumns": true,
      "writingMode": true
    }
  }
}
```

**Note:** `appearanceTools` is an "opt-in" flag. You can combine it with explicit settings to override specific values:

```json
{
  "settings": {
    "appearanceTools": true,
    "border": {
      "radius": false
    }
  }
}
```

This enables everything except border radius.

## Border Settings

```json
{
  "settings": {
    "border": {
      "color": true,
      "radius": true,
      "style": true,
      "width": true
    }
  }
}
```

### color

Controls whether border color can be customized.

| Value | Effect |
|-------|--------|
| `true` | Border color picker available |
| `false` (default) | Border color control hidden |

### radius

Controls whether border radius can be customized.

| Value | Effect |
|-------|--------|
| `true` | Border radius input available |
| `false` (default) | Border radius control hidden |

### style

Controls whether border style can be customized.

| Value | Effect |
|-------|--------|
| `true` | Border style selector available (solid, dashed, dotted) |
| `false` (default) | Border style control hidden |

### width

Controls whether border width can be customized.

| Value | Effect |
|-------|--------|
| `true` | Border width input available |
| `false` (default) | Border width control hidden |

## Shadow Settings

```json
{
  "settings": {
    "shadow": {
      "defaultPresets": true,
      "presets": []
    }
  }
}
```

### defaultPresets

Whether to include WordPress default shadow presets.

```json
{ "settings": { "shadow": { "defaultPresets": true } } }
```

| Value | Effect |
|-------|--------|
| `true` (default) | Core shadows included |
| `false` | Only theme-defined shadows available |

**WordPress default shadows:**

| Slug | CSS Value |
|------|-----------|
| natural | `6px 6px 9px rgba(0, 0, 0, 0.2)` |
| deep | `12px 12px 50px rgba(0, 0, 0, 0.4)` |
| sharp | `6px 6px 0px rgba(0, 0, 0, 0.2)` |
| outlined | `6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1)` |
| crisp | `6px 6px 0px rgba(0, 0, 0, 1)` |

### presets

Define custom shadow presets.

```json
{
  "settings": {
    "shadow": {
      "defaultPresets": false,
      "presets": [
        {
          "slug": "sm",
          "name": "Small",
          "shadow": "0 1px 2px 0 rgb(0 0 0 / 0.05)"
        },
        {
          "slug": "md",
          "name": "Medium",
          "shadow": "0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)"
        },
        {
          "slug": "lg",
          "name": "Large",
          "shadow": "0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)"
        },
        {
          "slug": "xl",
          "name": "Extra Large",
          "shadow": "0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)"
        },
        {
          "slug": "inner",
          "name": "Inner",
          "shadow": "inset 0 2px 4px 0 rgb(0 0 0 / 0.05)"
        }
      ]
    }
  }
}
```

**Each shadow preset:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `slug` | string | Yes | Unique identifier |
| `name` | string | Yes | Human-readable name |
| `shadow` | string | Yes | CSS box-shadow value |

**Generated CSS variable:**
```css
--wp--preset--shadow--{slug}: {shadow};
```

## Dimensions Settings

```json
{
  "settings": {
    "dimensions": {
      "aspectRatio": true,
      "minHeight": true
    }
  }
}
```

### aspectRatio

Controls whether aspect ratio can be set on blocks.

| Value | Effect |
|-------|--------|
| `true` | Aspect ratio control available |
| `false` (default) | Aspect ratio control hidden |

**Supported blocks:** Image, Cover, Group, Post Featured Image

**Available ratios:** 1/1, 4/3, 3/4, 3/2, 2/3, 16/9, 9/16, custom

### minHeight

Controls whether minimum height can be set.

| Value | Effect |
|-------|--------|
| `true` | Min height input available |
| `false` (default) | Min height control hidden |

**Supported blocks:** Cover, Group, Post Content

## Position Settings

```json
{
  "settings": {
    "position": {
      "sticky": true
    }
  }
}
```

### sticky

Controls whether blocks can be made sticky.

| Value | Effect |
|-------|--------|
| `true` | Sticky position option available |
| `false` (default) | Sticky position hidden |

**Supported blocks:** Group, Columns, Image, any block with position support

**How it works:**
- Block stays fixed when scrolling past it
- Stays within its parent container bounds
- Useful for sticky headers, sidebars, CTAs

## Background Settings

```json
{
  "settings": {
    "background": {
      "backgroundImage": true,
      "backgroundSize": true
    }
  }
}
```

### backgroundImage

Controls whether background images can be set.

| Value | Effect |
|-------|--------|
| `true` | Background image control available |
| `false` (default) | Background image control hidden |

**Supported blocks:** Group, Columns, Cover

### backgroundSize

Controls whether background size/position can be customized.

| Value | Effect |
|-------|--------|
| `true` | Background size controls available |
| `false` (default) | Background size controls hidden |

**Options:** cover, contain, auto, custom size

**Note:** Requires `backgroundImage: true` to be useful.

## Custom Properties

Define custom CSS properties for use throughout your theme.

```json
{
  "settings": {
    "custom": {
      "lineHeightHeading": 1.2,
      "lineHeightBody": 1.6,
      "fontSizeBase": "1rem",
      "spacing": {
        "gutter": "1.5rem",
        "section": "4rem"
      },
      "colors": {
        "accent": "#ff6600",
        "muted": "#666666"
      },
      "transitions": {
        "fast": "150ms ease-in-out",
        "normal": "300ms ease-in-out"
      }
    }
  }
}
```

**Generated CSS variables:**

```css
--wp--custom--line-height-heading: 1.2;
--wp--custom--line-height-body: 1.6;
--wp--custom--font-size-base: 1rem;
--wp--custom--spacing--gutter: 1.5rem;
--wp--custom--spacing--section: 4rem;
--wp--custom--colors--accent: #ff6600;
--wp--custom--colors--muted: #666666;
--wp--custom--transitions--fast: 150ms ease-in-out;
--wp--custom--transitions--normal: 300ms ease-in-out;
```

**Naming convention:**
- Property names: camelCase → kebab-case
- Nested objects: double dashes between levels
- `lineHeightBody` → `--wp--custom--line-height-body`
- `spacing.gutter` → `--wp--custom--spacing--gutter`

### Using Custom Properties

**In theme.json styles:**

```json
{
  "styles": {
    "typography": {
      "lineHeight": "var(--wp--custom--line-height-body)"
    },
    "elements": {
      "heading": {
        "typography": {
          "lineHeight": "var(--wp--custom--line-height-heading)"
        }
      }
    }
  }
}
```

**In CSS:**

```css
.my-component {
  line-height: var(--wp--custom--line-height-body);
  padding: var(--wp--custom--spacing--gutter);
  transition: all var(--wp--custom--transitions--fast);
}

.accent-text {
  color: var(--wp--custom--colors--accent);
}
```

### Organizing Custom Properties

```json
{
  "settings": {
    "custom": {
      "typography": {
        "lineHeight": {
          "heading": 1.2,
          "body": 1.6,
          "tight": 1.25,
          "loose": 1.8
        },
        "letterSpacing": {
          "tight": "-0.025em",
          "normal": "0",
          "wide": "0.05em"
        }
      },
      "layout": {
        "contentWidth": "720px",
        "wideWidth": "1200px",
        "fullWidth": "100%",
        "sidebarWidth": "300px"
      },
      "effects": {
        "shadow": {
          "sm": "0 1px 2px rgba(0,0,0,0.1)",
          "md": "0 4px 8px rgba(0,0,0,0.1)",
          "lg": "0 8px 16px rgba(0,0,0,0.1)"
        },
        "radius": {
          "sm": "0.25rem",
          "md": "0.5rem",
          "lg": "1rem",
          "full": "9999px"
        }
      },
      "animation": {
        "duration": {
          "fast": "150ms",
          "normal": "300ms",
          "slow": "500ms"
        },
        "easing": {
          "default": "ease-in-out",
          "bounce": "cubic-bezier(0.68, -0.55, 0.265, 1.55)"
        }
      }
    }
  }
}
```

## useRootPaddingAwareAlignments

Enable root padding awareness for full-width blocks.

```json
{
  "settings": {
    "useRootPaddingAwareAlignments": true
  }
}
```

| Value | Effect |
|-------|--------|
| `true` | Full-width blocks extend to viewport edge but respect root padding for inner content |
| `false` (default) | Standard alignment behavior |

**Combined with styles:**

```json
{
  "settings": {
    "useRootPaddingAwareAlignments": true
  },
  "styles": {
    "spacing": {
      "padding": {
        "left": "var(--wp--preset--spacing--50)",
        "right": "var(--wp--preset--spacing--50)"
      }
    }
  }
}
```

**Result:**
- Body has horizontal padding
- Full-width blocks ignore this padding for backgrounds
- But their inner content still respects the padding

## Complete Example

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3,
  "settings": {
    "appearanceTools": true,
    "useRootPaddingAwareAlignments": true,
    "border": {
      "color": true,
      "radius": true,
      "style": true,
      "width": true
    },
    "shadow": {
      "defaultPresets": false,
      "presets": [
        { "slug": "sm", "name": "Small", "shadow": "0 1px 3px rgba(0,0,0,0.12)" },
        { "slug": "md", "name": "Medium", "shadow": "0 4px 6px rgba(0,0,0,0.1)" },
        { "slug": "lg", "name": "Large", "shadow": "0 10px 20px rgba(0,0,0,0.15)" },
        { "slug": "xl", "name": "XL", "shadow": "0 20px 40px rgba(0,0,0,0.2)" }
      ]
    },
    "dimensions": {
      "aspectRatio": true,
      "minHeight": true
    },
    "position": {
      "sticky": true
    },
    "background": {
      "backgroundImage": true,
      "backgroundSize": true
    },
    "custom": {
      "typography": {
        "lineHeight": {
          "tight": 1.2,
          "normal": 1.5,
          "relaxed": 1.75
        }
      },
      "spacing": {
        "gutter": "clamp(1rem, 3vw, 2rem)",
        "section": "clamp(3rem, 8vw, 6rem)"
      },
      "transition": {
        "default": "200ms ease-in-out"
      },
      "radius": {
        "default": "0.5rem",
        "large": "1rem",
        "full": "9999px"
      }
    },
    "blocks": {
      "core/button": {
        "border": {
          "radius": true,
          "color": false,
          "width": false
        },
        "shadow": {
          "presets": [
            { "slug": "btn-shadow", "name": "Button", "shadow": "0 2px 4px rgba(0,0,0,0.2)" }
          ]
        }
      },
      "core/group": {
        "background": {
          "backgroundImage": true,
          "backgroundSize": true
        },
        "position": {
          "sticky": true
        }
      }
    }
  }
}
```

## CSS Variable Reference

| Setting | CSS Variable Pattern |
|---------|---------------------|
| `shadow.presets` | `--wp--preset--shadow--{slug}` |
| `custom.*` | `--wp--custom--{path-kebab-case}` |

## Per-Block Support

Not all blocks support all settings. Here's what common blocks support:

| Block | Border | Shadow | Dimensions | Position | Background |
|-------|--------|--------|------------|----------|------------|
| Group | ✓ | ✓ | ✓ | ✓ | ✓ |
| Columns | ✓ | ✓ | ✓ | ✓ | ✓ |
| Column | ✓ | ✓ | ✓ | - | - |
| Cover | ✓ | - | ✓ | - | ✓ |
| Image | ✓ | ✓ | ✓ | - | - |
| Button | ✓ | ✓ | - | - | - |
| Heading | - | - | - | - | - |
| Paragraph | - | - | - | - | - |
| Quote | ✓ | - | - | - | - |
| Separator | ✓ | - | - | - | - |

Check block.json `supports` for definitive support information.
