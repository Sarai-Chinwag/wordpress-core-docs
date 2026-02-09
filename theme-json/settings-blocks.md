# Per-Block Settings

Complete reference for `settings.blocks` in theme.json.

## Overview

The `settings.blocks` object allows you to override global settings for specific blocks.

```json
{
  "settings": {
    "color": { /* global color settings */ },
    "typography": { /* global typography settings */ },
    "spacing": { /* global spacing settings */ },
    "layout": { /* global layout settings */ },
    "blocks": {
      "core/paragraph": { /* paragraph-specific settings */ },
      "core/heading": { /* heading-specific settings */ },
      "core/button": { /* button-specific settings */ }
    }
  }
}
```

## Structure

Each block entry uses the same settings schema as the global level:

```json
{
  "settings": {
    "blocks": {
      "core/block-name": {
        "color": { },
        "typography": { },
        "spacing": { },
        "layout": { },
        "border": { },
        "shadow": { },
        "dimensions": { },
        "position": { },
        "custom": { }
      }
    }
  }
}
```

## Block Identification

Blocks are identified by their full name including namespace:

| Block | Identifier |
|-------|------------|
| Paragraph | `core/paragraph` |
| Heading | `core/heading` |
| Button | `core/button` |
| Group | `core/group` |
| Columns | `core/columns` |
| Image | `core/image` |
| Cover | `core/cover` |
| Navigation | `core/navigation` |
| Post Title | `core/post-title` |
| Post Content | `core/post-content` |
| Query Loop | `core/query` |
| Site Title | `core/site-title` |
| Site Logo | `core/site-logo` |

Third-party blocks use their plugin namespace:

```json
{
  "settings": {
    "blocks": {
      "woocommerce/product-grid": { },
      "acf/my-custom-block": { },
      "theme-slug/hero": { }
    }
  }
}
```

## Common Use Cases

### Different Palettes Per Block

Give buttons a different color palette than general content:

```json
{
  "settings": {
    "color": {
      "palette": [
        { "slug": "primary", "color": "#0066cc", "name": "Primary" },
        { "slug": "secondary", "color": "#333333", "name": "Secondary" },
        { "slug": "white", "color": "#ffffff", "name": "White" }
      ]
    },
    "blocks": {
      "core/button": {
        "color": {
          "palette": [
            { "slug": "cta-primary", "color": "#ff6600", "name": "CTA Primary" },
            { "slug": "cta-secondary", "color": "#00cc66", "name": "CTA Secondary" },
            { "slug": "cta-dark", "color": "#1a1a1a", "name": "CTA Dark" },
            { "slug": "white", "color": "#ffffff", "name": "White" }
          ]
        }
      }
    }
  }
}
```

### Different Font Sizes Per Block

Larger font size presets for headings:

```json
{
  "settings": {
    "typography": {
      "fontSizes": [
        { "slug": "small", "size": "0.875rem", "name": "Small" },
        { "slug": "medium", "size": "1rem", "name": "Medium" },
        { "slug": "large", "size": "1.25rem", "name": "Large" }
      ]
    },
    "blocks": {
      "core/heading": {
        "typography": {
          "fontSizes": [
            { "slug": "medium", "size": "1.5rem", "name": "Medium" },
            { "slug": "large", "size": "2rem", "name": "Large" },
            { "slug": "x-large", "size": "3rem", "name": "Extra Large" },
            { "slug": "xx-large", "size": "4rem", "name": "Huge" }
          ]
        }
      },
      "core/post-title": {
        "typography": {
          "fontSizes": [
            { "slug": "large", "size": "2.5rem", "name": "Large" },
            { "slug": "x-large", "size": "3.5rem", "name": "Extra Large" }
          ]
        }
      }
    }
  }
}
```

### Disable Features for Specific Blocks

Remove color controls from paragraphs:

```json
{
  "settings": {
    "color": {
      "background": true,
      "text": true,
      "custom": true
    },
    "blocks": {
      "core/paragraph": {
        "color": {
          "background": false,
          "text": false
        }
      },
      "core/list": {
        "color": {
          "background": false,
          "text": false
        }
      }
    }
  }
}
```

### Custom Spacing Per Block

Different spacing options for layout blocks:

```json
{
  "settings": {
    "spacing": {
      "padding": true,
      "margin": true,
      "spacingSizes": [
        { "slug": "10", "size": "0.5rem", "name": "XS" },
        { "slug": "20", "size": "1rem", "name": "S" },
        { "slug": "30", "size": "1.5rem", "name": "M" },
        { "slug": "40", "size": "2rem", "name": "L" }
      ]
    },
    "blocks": {
      "core/group": {
        "spacing": {
          "spacingSizes": [
            { "slug": "20", "size": "1rem", "name": "S" },
            { "slug": "40", "size": "2rem", "name": "M" },
            { "slug": "60", "size": "4rem", "name": "L" },
            { "slug": "80", "size": "6rem", "name": "XL" },
            { "slug": "100", "size": "8rem", "name": "XXL" }
          ]
        }
      },
      "core/cover": {
        "spacing": {
          "spacingSizes": [
            { "slug": "40", "size": "3rem", "name": "M" },
            { "slug": "60", "size": "5rem", "name": "L" },
            { "slug": "80", "size": "8rem", "name": "XL" },
            { "slug": "100", "size": "12rem", "name": "XXL" }
          ]
        }
      }
    }
  }
}
```

### Block-Specific Layout

Different content widths for specific contexts:

```json
{
  "settings": {
    "layout": {
      "contentSize": "720px",
      "wideSize": "1200px"
    },
    "blocks": {
      "core/post-content": {
        "layout": {
          "contentSize": "680px",
          "wideSize": "1100px"
        }
      },
      "core/group": {
        "layout": {
          "allowCustomContentAndWideSize": true
        }
      },
      "core/cover": {
        "layout": {
          "contentSize": "900px"
        }
      }
    }
  }
}
```

### Restrict Custom Values Per Block

Allow custom colors globally but restrict buttons to palette only:

```json
{
  "settings": {
    "color": {
      "custom": true,
      "customGradient": true
    },
    "blocks": {
      "core/button": {
        "color": {
          "custom": false,
          "customGradient": false
        }
      },
      "core/site-title": {
        "color": {
          "custom": false
        }
      }
    }
  }
}
```

### Block-Specific Border Settings

```json
{
  "settings": {
    "border": {
      "color": true,
      "radius": true,
      "style": true,
      "width": true
    },
    "blocks": {
      "core/button": {
        "border": {
          "radius": true,
          "color": false,
          "style": false,
          "width": false
        }
      },
      "core/image": {
        "border": {
          "radius": true,
          "color": true,
          "width": true
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
    "color": {
      "defaultPalette": false,
      "palette": [
        { "slug": "primary", "color": "#0066cc", "name": "Primary" },
        { "slug": "secondary", "color": "#ff6600", "name": "Secondary" },
        { "slug": "dark", "color": "#1a1a1a", "name": "Dark" },
        { "slug": "light", "color": "#f5f5f5", "name": "Light" },
        { "slug": "white", "color": "#ffffff", "name": "White" }
      ],
      "custom": true
    },
    "typography": {
      "fontSizes": [
        { "slug": "small", "size": "0.875rem", "name": "Small" },
        { "slug": "medium", "size": "1rem", "name": "Medium" },
        { "slug": "large", "size": "1.25rem", "name": "Large" }
      ],
      "fontFamilies": [
        { "slug": "body", "name": "Body", "fontFamily": "Inter, sans-serif" },
        { "slug": "heading", "name": "Heading", "fontFamily": "Playfair Display, serif" }
      ]
    },
    "spacing": {
      "padding": true,
      "margin": true,
      "blockGap": true
    },
    "layout": {
      "contentSize": "720px",
      "wideSize": "1200px"
    },
    "blocks": {
      "core/heading": {
        "typography": {
          "fontSizes": [
            { "slug": "medium", "size": "1.5rem", "name": "Medium" },
            { "slug": "large", "size": "2rem", "name": "Large" },
            { "slug": "x-large", "size": "3rem", "name": "X-Large" }
          ]
        },
        "color": {
          "custom": false
        }
      },
      "core/paragraph": {
        "color": {
          "background": false
        }
      },
      "core/button": {
        "color": {
          "palette": [
            { "slug": "btn-primary", "color": "#0066cc", "name": "Primary" },
            { "slug": "btn-secondary", "color": "#ff6600", "name": "Secondary" },
            { "slug": "btn-dark", "color": "#1a1a1a", "name": "Dark" },
            { "slug": "btn-white", "color": "#ffffff", "name": "White" }
          ],
          "custom": false
        },
        "border": {
          "radius": true
        }
      },
      "core/group": {
        "spacing": {
          "spacingSizes": [
            { "slug": "small", "size": "1.5rem", "name": "Small" },
            { "slug": "medium", "size": "3rem", "name": "Medium" },
            { "slug": "large", "size": "5rem", "name": "Large" },
            { "slug": "x-large", "size": "8rem", "name": "X-Large" }
          ]
        },
        "layout": {
          "allowCustomContentAndWideSize": true
        }
      },
      "core/cover": {
        "spacing": {
          "spacingSizes": [
            { "slug": "medium", "size": "4rem", "name": "Medium" },
            { "slug": "large", "size": "6rem", "name": "Large" },
            { "slug": "x-large", "size": "10rem", "name": "X-Large" }
          ]
        }
      },
      "core/image": {
        "border": {
          "radius": true,
          "color": true,
          "width": true
        }
      },
      "core/post-content": {
        "layout": {
          "contentSize": "680px"
        }
      },
      "core/navigation": {
        "typography": {
          "fontSizes": [
            { "slug": "small", "size": "0.875rem", "name": "Small" },
            { "slug": "medium", "size": "1rem", "name": "Medium" }
          ]
        }
      }
    }
  }
}
```

## Inheritance Behavior

Per-block settings **completely override** the corresponding global setting, not merge:

```json
{
  "settings": {
    "color": {
      "palette": [
        { "slug": "a", "color": "#111", "name": "A" },
        { "slug": "b", "color": "#222", "name": "B" },
        { "slug": "c", "color": "#333", "name": "C" }
      ]
    },
    "blocks": {
      "core/button": {
        "color": {
          "palette": [
            { "slug": "x", "color": "#f00", "name": "X" }
          ]
        }
      }
    }
  }
}
```

Result:
- **Global**: Colors A, B, C available
- **Button**: Only color X available (A, B, C not inherited)

To include global colors in a block, you must redefine them:

```json
{
  "blocks": {
    "core/button": {
      "color": {
        "palette": [
          { "slug": "a", "color": "#111", "name": "A" },
          { "slug": "b", "color": "#222", "name": "B" },
          { "slug": "c", "color": "#333", "name": "C" },
          { "slug": "x", "color": "#f00", "name": "X" }
        ]
      }
    }
  }
}
```

## Core Block List

Common core blocks you can customize:

**Content Blocks:**
- `core/paragraph`
- `core/heading`
- `core/list`
- `core/list-item`
- `core/quote`
- `core/pullquote`
- `core/code`
- `core/preformatted`
- `core/verse`
- `core/table`
- `core/details`

**Media Blocks:**
- `core/image`
- `core/gallery`
- `core/audio`
- `core/video`
- `core/cover`
- `core/media-text`
- `core/file`

**Design Blocks:**
- `core/buttons`
- `core/button`
- `core/columns`
- `core/column`
- `core/group`
- `core/row`
- `core/stack`
- `core/separator`
- `core/spacer`

**Theme Blocks:**
- `core/navigation`
- `core/navigation-link`
- `core/site-title`
- `core/site-logo`
- `core/site-tagline`
- `core/query`
- `core/post-template`
- `core/post-title`
- `core/post-content`
- `core/post-excerpt`
- `core/post-featured-image`
- `core/post-date`
- `core/post-author`
- `core/post-terms`
- `core/comments`
- `core/comment-template`
- `core/search`
- `core/loginout`

**Widget Blocks:**
- `core/archives`
- `core/categories`
- `core/latest-posts`
- `core/latest-comments`
- `core/calendar`
- `core/tag-cloud`
- `core/rss`
- `core/social-links`
- `core/social-link`

**Embed Blocks:**
- `core/embed`
- `core/html`
- `core/shortcode`

## PHP Access to Block Settings

```php
// Get settings for a specific block
$button_settings = wp_get_global_settings( array(), array( 'block_name' => 'core/button' ) );

// Get specific setting for a block
$button_palette = wp_get_global_settings( 
    array( 'color', 'palette' ), 
    array( 'block_name' => 'core/button' ) 
);
```
