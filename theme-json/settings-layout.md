# Layout Settings

Complete reference for `settings.layout` in theme.json.

## Overview

```json
{
  "settings": {
    "layout": {
      "contentSize": "650px",
      "wideSize": "1200px",
      "allowEditing": true,
      "allowCustomContentAndWideSize": true
    }
  }
}
```

## Layout Widths

### contentSize

The default maximum width for content blocks.

```json
{
  "settings": {
    "layout": {
      "contentSize": "650px"
    }
  }
}
```

**Accepted values:**
- CSS length: `"650px"`, `"40rem"`, `"60ch"`, `"80%"`
- CSS variable: `"var(--wp--custom--content-width)"`

**Effect:**
- Sets the default width for blocks when "None" alignment is selected
- Content blocks (paragraphs, headings, etc.) will not exceed this width
- Centered horizontally when inside a full-width container

### wideSize

The maximum width for wide-aligned blocks.

```json
{
  "settings": {
    "layout": {
      "wideSize": "1200px"
    }
  }
}
```

**Accepted values:**
- CSS length: `"1200px"`, `"75rem"`, `"90vw"`
- CSS variable: `"var(--wp--custom--wide-width)"`

**Effect:**
- Sets the width for blocks when "Wide width" alignment is selected
- Should be larger than `contentSize`
- Centered horizontally when inside a full-width container

### Relationship Between Sizes

```
|<----------------------- Full Width (100%) ----------------------->|
|                                                                   |
|    |<---------------- wideSize (1200px) ------------------>|      |
|    |                                                       |      |
|    |        |<------ contentSize (650px) ------>|          |      |
|    |        |                                   |          |      |
```

## Feature Toggles

### allowEditing

Controls whether users can edit layout settings in the editor.

```json
{
  "settings": {
    "layout": {
      "allowEditing": true
    }
  }
}
```

| Value | Effect |
|-------|--------|
| `true` (default) | Layout controls visible in editor |
| `false` | Layout controls hidden |

### allowCustomContentAndWideSize

Controls whether users can customize content and wide sizes per-block.

```json
{
  "settings": {
    "layout": {
      "allowCustomContentAndWideSize": true
    }
  }
}
```

| Value | Effect |
|-------|--------|
| `true` (default) | Custom width inputs available |
| `false` | Only theme-defined widths available |

## Generated CSS

Theme.json layout settings generate CSS custom properties:

```css
body {
  --wp--style--global--content-size: 650px;
  --wp--style--global--wide-size: 1200px;
}
```

And layout classes:

```css
/* Constrained layout (contentSize centered) */
.is-layout-constrained > :where(:not(.alignleft):not(.alignright):not(.alignfull)) {
  max-width: var(--wp--style--global--content-size);
  margin-left: auto !important;
  margin-right: auto !important;
}

/* Wide alignment */
.is-layout-constrained > .alignwide {
  max-width: var(--wp--style--global--wide-size);
}

/* Full alignment */
.is-layout-constrained > .alignfull {
  max-width: none;
}
```

## Layout Types

WordPress supports several layout types controlled by `layout.type`:

### Constrained (Default)

Content centered with max-width constraints.

```json
{
  "styles": {
    "blocks": {
      "core/group": {
        "layout": {
          "type": "constrained",
          "contentSize": "800px",
          "wideSize": "1100px"
        }
      }
    }
  }
}
```

**Behavior:**
- Child blocks default to `contentSize` width
- Wide-aligned blocks use `wideSize`
- Full-aligned blocks span 100%
- Content centered with auto margins

### Flex

Flexbox-based layout for horizontal/vertical arrangements.

```json
{
  "styles": {
    "blocks": {
      "core/group": {
        "layout": {
          "type": "flex",
          "flexWrap": "wrap",
          "justifyContent": "space-between",
          "orientation": "horizontal"
        }
      }
    }
  }
}
```

**Flex properties:**

| Property | Values | Description |
|----------|--------|-------------|
| `orientation` | "horizontal", "vertical" | Main axis direction |
| `justifyContent` | "left", "center", "right", "space-between" | Main axis alignment |
| `verticalAlignment` | "top", "center", "bottom", "stretch" | Cross axis alignment |
| `flexWrap` | "wrap", "nowrap" | Whether items wrap |

### Grid

CSS Grid-based layout.

```json
{
  "styles": {
    "blocks": {
      "core/group": {
        "layout": {
          "type": "grid",
          "columnCount": 3,
          "minimumColumnWidth": "200px"
        }
      }
    }
  }
}
```

**Grid properties:**

| Property | Type | Description |
|----------|------|-------------|
| `columnCount` | integer | Fixed number of columns |
| `minimumColumnWidth` | string | Auto-fit with min column width |

**Note:** `columnCount` and `minimumColumnWidth` are mutually exclusive.

### Flow

Default block layout (vertical stack).

```json
{
  "styles": {
    "blocks": {
      "core/group": {
        "layout": {
          "type": "flow"
        }
      }
    }
  }
}
```

## Complete Example

```json
{
  "settings": {
    "layout": {
      "contentSize": "min(100% - 2rem, 720px)",
      "wideSize": "min(100% - 2rem, 1280px)",
      "allowEditing": true,
      "allowCustomContentAndWideSize": false
    }
  },
  "styles": {
    "spacing": {
      "blockGap": "var(--wp--preset--spacing--50)"
    },
    "blocks": {
      "core/group": {
        "variations": {
          "group-row": {
            "layout": {
              "type": "flex",
              "flexWrap": "wrap",
              "justifyContent": "space-between"
            }
          },
          "group-stack": {
            "layout": {
              "type": "flex",
              "orientation": "vertical"
            }
          },
          "group-grid": {
            "layout": {
              "type": "grid",
              "minimumColumnWidth": "250px"
            }
          }
        }
      }
    }
  }
}
```

## Per-Block Layout Settings

### Overriding Content Width Per Block

```json
{
  "settings": {
    "layout": {
      "contentSize": "650px",
      "wideSize": "1200px"
    },
    "blocks": {
      "core/post-content": {
        "layout": {
          "contentSize": "720px",
          "wideSize": "1100px"
        }
      },
      "core/group": {
        "layout": {
          "allowCustomContentAndWideSize": true
        }
      }
    }
  }
}
```

### Disabling Layout for Specific Blocks

```json
{
  "settings": {
    "blocks": {
      "core/cover": {
        "layout": {
          "allowEditing": false
        }
      }
    }
  }
}
```

## Layout in Styles

Apply specific layout settings in styles section:

```json
{
  "styles": {
    "blocks": {
      "core/post-content": {
        "layout": {
          "type": "constrained",
          "contentSize": "720px"
        }
      },
      "core/columns": {
        "layout": {
          "type": "flex",
          "flexWrap": "wrap"
        }
      },
      "core/query": {
        "layout": {
          "type": "grid",
          "columnCount": 3
        }
      }
    }
  }
}
```

## Responsive Considerations

### Using min() for Responsive Widths

```json
{
  "settings": {
    "layout": {
      "contentSize": "min(100% - 3rem, 720px)",
      "wideSize": "min(100% - 2rem, 1280px)"
    }
  }
}
```

**Breakdown:**
- `min(100% - 3rem, 720px)` means "720px or viewport width minus padding, whichever is smaller"
- Automatically responsive without media queries
- The `3rem` and `2rem` act as horizontal padding on small screens

### Using CSS Custom Properties

```json
{
  "settings": {
    "custom": {
      "layout": {
        "contentWidth": "720px",
        "wideWidth": "1280px",
        "padding": "1.5rem"
      }
    },
    "layout": {
      "contentSize": "min(100% - calc(var(--wp--custom--layout--padding) * 2), var(--wp--custom--layout--content-width))",
      "wideSize": "min(100% - calc(var(--wp--custom--layout--padding) * 2), var(--wp--custom--layout--wide-width))"
    }
  }
}
```

## Common Patterns

### Blog/Article Layout

```json
{
  "settings": {
    "layout": {
      "contentSize": "680px",
      "wideSize": "1100px"
    }
  }
}
```

Narrow content for readability, wider for images/embeds.

### Landing Page Layout

```json
{
  "settings": {
    "layout": {
      "contentSize": "1200px",
      "wideSize": "1400px"
    }
  }
}
```

Wider content area for marketing pages.

### Magazine Layout

```json
{
  "settings": {
    "layout": {
      "contentSize": "960px",
      "wideSize": "1280px"
    }
  }
}
```

Medium-wide for multi-column content.

### Full-Width Theme

```json
{
  "settings": {
    "layout": {
      "contentSize": "100%",
      "wideSize": "100%"
    }
  }
}
```

No width constraints (useful for page builders).

## CSS Classes Generated

| Class | Purpose |
|-------|---------|
| `.is-layout-constrained` | Constrained layout container |
| `.is-layout-flex` | Flex layout container |
| `.is-layout-grid` | Grid layout container |
| `.is-layout-flow` | Flow layout container |
| `.alignwide` | Wide alignment |
| `.alignfull` | Full width alignment |
| `.alignleft` | Float left |
| `.alignright` | Float right |
| `.aligncenter` | Center alignment |

## Root Padding Awareness

For full-width backgrounds that respect root padding:

```json
{
  "settings": {
    "useRootPaddingAwareAlignments": true,
    "layout": {
      "contentSize": "650px",
      "wideSize": "1200px"
    }
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

When `useRootPaddingAwareAlignments` is `true`:
- Full-width blocks extend to viewport edge
- But their inner content respects root padding
- Creates "bleed" effect for backgrounds
