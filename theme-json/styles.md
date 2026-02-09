# Styles Configuration

Complete reference for `styles` in theme.json.

## Overview

The `styles` section defines CSS styling rules that WordPress applies globally and per-block.

```json
{
  "styles": {
    "border": { },
    "color": { },
    "css": "",
    "dimensions": { },
    "filter": { },
    "outline": { },
    "shadow": "",
    "spacing": { },
    "typography": { },
    "elements": { },
    "blocks": { },
    "variations": { }
  }
}
```

## Top-Level Style Properties

### color

Set global background and text colors.

```json
{
  "styles": {
    "color": {
      "background": "#ffffff",
      "text": "#1a1a1a",
      "gradient": "linear-gradient(135deg, #fff 0%, #f5f5f5 100%)"
    }
  }
}
```

| Property | Description |
|----------|-------------|
| `background` | Background color |
| `text` | Text color |
| `gradient` | Background gradient (overrides background color) |

**Using preset colors:**

```json
{
  "styles": {
    "color": {
      "background": "var(--wp--preset--color--base)",
      "text": "var(--wp--preset--color--contrast)"
    }
  }
}
```

### typography

Set global typography styles.

```json
{
  "styles": {
    "typography": {
      "fontFamily": "var(--wp--preset--font-family--body)",
      "fontSize": "var(--wp--preset--font-size--medium)",
      "fontStyle": "normal",
      "fontWeight": "400",
      "letterSpacing": "0",
      "lineHeight": "1.6",
      "textAlign": "left",
      "textColumns": "1",
      "textDecoration": "none",
      "textTransform": "none",
      "writingMode": "horizontal-tb"
    }
  }
}
```

| Property | Values |
|----------|--------|
| `fontFamily` | Font family value or CSS variable |
| `fontSize` | Size value or CSS variable |
| `fontStyle` | `normal`, `italic`, `oblique` |
| `fontWeight` | `100`-`900`, `normal`, `bold`, `lighter`, `bolder` |
| `letterSpacing` | CSS length value |
| `lineHeight` | Number or CSS value |
| `textAlign` | `left`, `center`, `right`, `justify` |
| `textColumns` | Number of columns |
| `textDecoration` | `none`, `underline`, `line-through`, `overline` |
| `textTransform` | `none`, `uppercase`, `lowercase`, `capitalize` |
| `writingMode` | `horizontal-tb`, `vertical-rl`, `vertical-lr` |

### spacing

Set global spacing.

```json
{
  "styles": {
    "spacing": {
      "blockGap": "var(--wp--preset--spacing--50)",
      "margin": {
        "top": "0",
        "right": "0",
        "bottom": "0",
        "left": "0"
      },
      "padding": {
        "top": "var(--wp--preset--spacing--50)",
        "right": "var(--wp--preset--spacing--40)",
        "bottom": "var(--wp--preset--spacing--50)",
        "left": "var(--wp--preset--spacing--40)"
      }
    }
  }
}
```

| Property | Description |
|----------|-------------|
| `blockGap` | Gap between blocks (single value or top/left object) |
| `margin` | Object with `top`, `right`, `bottom`, `left` |
| `padding` | Object with `top`, `right`, `bottom`, `left` |

**Block gap with separate axes:**

```json
{
  "styles": {
    "spacing": {
      "blockGap": {
        "top": "2rem",
        "left": "1rem"
      }
    }
  }
}
```

### border

Set global border styles.

```json
{
  "styles": {
    "border": {
      "color": "#e0e0e0",
      "radius": "0.5rem",
      "style": "solid",
      "width": "1px",
      "top": {
        "color": "#ccc",
        "style": "solid",
        "width": "2px"
      },
      "right": { },
      "bottom": { },
      "left": { }
    }
  }
}
```

| Property | Description |
|----------|-------------|
| `color` | Border color (all sides) |
| `radius` | Border radius (single value or object) |
| `style` | Border style: `solid`, `dashed`, `dotted`, `double`, `none` |
| `width` | Border width |
| `top`, `right`, `bottom`, `left` | Per-side overrides |

**Per-corner radius:**

```json
{
  "styles": {
    "border": {
      "radius": {
        "topLeft": "1rem",
        "topRight": "1rem",
        "bottomLeft": "0",
        "bottomRight": "0"
      }
    }
  }
}
```

### shadow

Apply box shadow.

```json
{
  "styles": {
    "shadow": "var(--wp--preset--shadow--md)"
  }
}
```

Or custom value:

```json
{
  "styles": {
    "shadow": "0 4px 6px -1px rgba(0, 0, 0, 0.1)"
  }
}
```

### outline

Set outline styles.

```json
{
  "styles": {
    "outline": {
      "color": "#0066cc",
      "offset": "2px",
      "style": "solid",
      "width": "2px"
    }
  }
}
```

### dimensions

Set dimension constraints.

```json
{
  "styles": {
    "dimensions": {
      "aspectRatio": "16/9",
      "minHeight": "100vh"
    }
  }
}
```

### filter

Apply CSS filters (primarily for images).

```json
{
  "styles": {
    "filter": {
      "duotone": "var(--wp--preset--duotone--blue-orange)"
    }
  }
}
```

### css

Add arbitrary CSS. Applied to the root element.

```json
{
  "styles": {
    "css": "scroll-behavior: smooth; text-rendering: optimizeLegibility;"
  }
}
```

**For blocks:**

```json
{
  "styles": {
    "blocks": {
      "core/button": {
        "css": "& .wp-block-button__link { text-shadow: none; }"
      }
    }
  }
}
```

The `&` represents the block's root selector.

## Elements

Style HTML elements globally.

```json
{
  "styles": {
    "elements": {
      "button": { },
      "caption": { },
      "cite": { },
      "heading": { },
      "h1": { },
      "h2": { },
      "h3": { },
      "h4": { },
      "h5": { },
      "h6": { },
      "link": { }
    }
  }
}
```

### button

Style all buttons.

```json
{
  "styles": {
    "elements": {
      "button": {
        "color": {
          "background": "var(--wp--preset--color--primary)",
          "text": "#ffffff"
        },
        "typography": {
          "fontSize": "1rem",
          "fontWeight": "600"
        },
        "border": {
          "radius": "0.5rem",
          "width": "0"
        },
        "spacing": {
          "padding": {
            "top": "0.75rem",
            "right": "1.5rem",
            "bottom": "0.75rem",
            "left": "1.5rem"
          }
        },
        ":hover": {
          "color": {
            "background": "var(--wp--preset--color--primary-dark)"
          }
        },
        ":focus": {
          "outline": {
            "color": "var(--wp--preset--color--primary)",
            "offset": "2px",
            "style": "solid",
            "width": "2px"
          }
        },
        ":active": {
          "color": {
            "background": "var(--wp--preset--color--primary-darker)"
          }
        }
      }
    }
  }
}
```

### link

Style all links.

```json
{
  "styles": {
    "elements": {
      "link": {
        "color": {
          "text": "var(--wp--preset--color--primary)"
        },
        "typography": {
          "textDecoration": "underline"
        },
        ":hover": {
          "color": {
            "text": "var(--wp--preset--color--primary-dark)"
          },
          "typography": {
            "textDecoration": "none"
          }
        },
        ":focus": {
          "outline": {
            "color": "var(--wp--preset--color--primary)",
            "offset": "2px"
          }
        },
        ":visited": {
          "color": {
            "text": "var(--wp--preset--color--secondary)"
          }
        }
      }
    }
  }
}
```

### heading (All Headings)

Style all heading levels at once.

```json
{
  "styles": {
    "elements": {
      "heading": {
        "color": {
          "text": "var(--wp--preset--color--contrast)"
        },
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--heading)",
          "fontWeight": "700",
          "lineHeight": "1.2"
        },
        "spacing": {
          "margin": {
            "top": "0",
            "bottom": "0.5em"
          }
        }
      }
    }
  }
}
```

### h1-h6 (Specific Headings)

Style individual heading levels.

```json
{
  "styles": {
    "elements": {
      "heading": {
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--heading)",
          "fontWeight": "700",
          "lineHeight": "1.2"
        }
      },
      "h1": {
        "typography": {
          "fontSize": "var(--wp--preset--font-size--xx-large)"
        }
      },
      "h2": {
        "typography": {
          "fontSize": "var(--wp--preset--font-size--x-large)"
        }
      },
      "h3": {
        "typography": {
          "fontSize": "var(--wp--preset--font-size--large)"
        }
      },
      "h4": {
        "typography": {
          "fontSize": "var(--wp--preset--font-size--medium)"
        }
      },
      "h5": {
        "typography": {
          "fontSize": "var(--wp--preset--font-size--small)"
        }
      },
      "h6": {
        "typography": {
          "fontSize": "var(--wp--preset--font-size--small)",
          "textTransform": "uppercase",
          "letterSpacing": "0.05em"
        }
      }
    }
  }
}
```

### caption

Style figure captions, table captions.

```json
{
  "styles": {
    "elements": {
      "caption": {
        "color": {
          "text": "var(--wp--preset--color--muted)"
        },
        "typography": {
          "fontSize": "var(--wp--preset--font-size--small)",
          "fontStyle": "italic"
        }
      }
    }
  }
}
```

### cite

Style citation elements.

```json
{
  "styles": {
    "elements": {
      "cite": {
        "typography": {
          "fontStyle": "normal",
          "fontWeight": "600"
        }
      }
    }
  }
}
```

## Pseudo-Classes

Supported pseudo-classes for elements:

| Pseudo-class | Supported on |
|--------------|--------------|
| `:hover` | button, link |
| `:focus` | button, link |
| `:active` | button, link |
| `:visited` | link |

```json
{
  "styles": {
    "elements": {
      "link": {
        "color": { "text": "#0066cc" },
        ":hover": { "color": { "text": "#004499" } },
        ":focus": { "color": { "text": "#004499" } },
        ":active": { "color": { "text": "#003366" } },
        ":visited": { "color": { "text": "#551a8b" } }
      }
    }
  }
}
```

## Per-Block Styles

Apply styles to specific blocks.

```json
{
  "styles": {
    "blocks": {
      "core/paragraph": {
        "typography": {
          "lineHeight": "1.75"
        },
        "spacing": {
          "margin": {
            "bottom": "1.5em"
          }
        }
      },
      "core/heading": {
        "spacing": {
          "margin": {
            "top": "2em",
            "bottom": "0.5em"
          }
        }
      },
      "core/image": {
        "border": {
          "radius": "0.5rem"
        },
        "shadow": "var(--wp--preset--shadow--sm)"
      },
      "core/quote": {
        "border": {
          "left": {
            "color": "var(--wp--preset--color--primary)",
            "style": "solid",
            "width": "4px"
          }
        },
        "spacing": {
          "padding": {
            "left": "1.5rem"
          }
        },
        "typography": {
          "fontStyle": "italic"
        }
      },
      "core/code": {
        "color": {
          "background": "var(--wp--preset--color--tertiary)",
          "text": "var(--wp--preset--color--contrast)"
        },
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--mono)",
          "fontSize": "0.9em"
        },
        "spacing": {
          "padding": {
            "top": "1rem",
            "right": "1.5rem",
            "bottom": "1rem",
            "left": "1.5rem"
          }
        },
        "border": {
          "radius": "0.5rem"
        }
      },
      "core/separator": {
        "color": {
          "background": "var(--wp--preset--color--tertiary)"
        },
        "border": {
          "width": "0"
        }
      },
      "core/button": {
        "border": {
          "radius": "0.5rem"
        },
        "typography": {
          "fontWeight": "600"
        }
      },
      "core/navigation": {
        "typography": {
          "fontSize": "var(--wp--preset--font-size--small)",
          "fontWeight": "500"
        }
      }
    }
  }
}
```

### Block Elements

Style elements within specific blocks.

```json
{
  "styles": {
    "blocks": {
      "core/button": {
        "elements": {
          "link": {
            "color": {
              "text": "#ffffff"
            },
            ":hover": {
              "color": {
                "text": "#ffffff"
              }
            }
          }
        }
      },
      "core/post-content": {
        "elements": {
          "link": {
            "typography": {
              "textDecoration": "underline"
            }
          },
          "heading": {
            "typography": {
              "fontFamily": "var(--wp--preset--font-family--heading)"
            }
          }
        }
      }
    }
  }
}
```

## Block Style Variations

Style registered block variations.

```json
{
  "styles": {
    "blocks": {
      "core/button": {
        "variations": {
          "outline": {
            "color": {
              "background": "transparent",
              "text": "var(--wp--preset--color--primary)"
            },
            "border": {
              "color": "currentColor",
              "style": "solid",
              "width": "2px"
            },
            ":hover": {
              "color": {
                "background": "var(--wp--preset--color--primary)",
                "text": "#ffffff"
              }
            }
          }
        }
      },
      "core/group": {
        "variations": {
          "group-row": {
            "spacing": {
              "blockGap": "1rem"
            }
          },
          "group-stack": {
            "spacing": {
              "blockGap": "0.5rem"
            }
          }
        }
      },
      "core/separator": {
        "variations": {
          "wide": {
            "border": {
              "width": "3px"
            }
          },
          "dots": {
            "color": {
              "background": "transparent"
            },
            "css": "& { border-style: dotted; border-width: 2px; }"
          }
        }
      }
    }
  }
}
```

## Complete Example

```json
{
  "styles": {
    "color": {
      "background": "var(--wp--preset--color--base)",
      "text": "var(--wp--preset--color--contrast)"
    },
    "typography": {
      "fontFamily": "var(--wp--preset--font-family--body)",
      "fontSize": "var(--wp--preset--font-size--medium)",
      "lineHeight": "1.6"
    },
    "spacing": {
      "blockGap": "var(--wp--preset--spacing--50)",
      "padding": {
        "left": "var(--wp--preset--spacing--50)",
        "right": "var(--wp--preset--spacing--50)"
      }
    },
    "elements": {
      "button": {
        "color": {
          "background": "var(--wp--preset--color--primary)",
          "text": "var(--wp--preset--color--base)"
        },
        "typography": {
          "fontSize": "var(--wp--preset--font-size--small)",
          "fontWeight": "600"
        },
        "border": {
          "radius": "var(--wp--custom--radius--default)"
        },
        ":hover": {
          "color": {
            "background": "var(--wp--preset--color--primary-dark)"
          }
        }
      },
      "link": {
        "color": {
          "text": "var(--wp--preset--color--primary)"
        },
        ":hover": {
          "typography": {
            "textDecoration": "none"
          }
        }
      },
      "heading": {
        "color": {
          "text": "var(--wp--preset--color--contrast)"
        },
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--heading)",
          "fontWeight": "700",
          "lineHeight": "1.2"
        }
      },
      "h1": {
        "typography": { "fontSize": "clamp(2.5rem, 5vw, 4rem)" }
      },
      "h2": {
        "typography": { "fontSize": "clamp(2rem, 4vw, 3rem)" }
      },
      "h3": {
        "typography": { "fontSize": "clamp(1.5rem, 3vw, 2rem)" }
      },
      "h4": {
        "typography": { "fontSize": "var(--wp--preset--font-size--large)" }
      },
      "h5": {
        "typography": { "fontSize": "var(--wp--preset--font-size--medium)" }
      },
      "h6": {
        "typography": {
          "fontSize": "var(--wp--preset--font-size--small)",
          "textTransform": "uppercase",
          "letterSpacing": "0.1em"
        }
      },
      "caption": {
        "color": { "text": "var(--wp--preset--color--muted)" },
        "typography": { "fontSize": "var(--wp--preset--font-size--small)" }
      }
    },
    "blocks": {
      "core/site-title": {
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--heading)",
          "fontSize": "var(--wp--preset--font-size--large)",
          "fontWeight": "700"
        },
        "elements": {
          "link": {
            "color": { "text": "inherit" },
            "typography": { "textDecoration": "none" },
            ":hover": {
              "color": { "text": "var(--wp--preset--color--primary)" }
            }
          }
        }
      },
      "core/navigation": {
        "typography": {
          "fontSize": "var(--wp--preset--font-size--small)"
        },
        "elements": {
          "link": {
            "typography": { "textDecoration": "none" },
            ":hover": {
              "typography": { "textDecoration": "underline" }
            }
          }
        }
      },
      "core/post-title": {
        "typography": {
          "fontSize": "clamp(2rem, 5vw, 3.5rem)"
        },
        "elements": {
          "link": {
            "color": { "text": "inherit" },
            "typography": { "textDecoration": "none" },
            ":hover": {
              "color": { "text": "var(--wp--preset--color--primary)" }
            }
          }
        }
      },
      "core/quote": {
        "border": {
          "left": {
            "color": "var(--wp--preset--color--primary)",
            "width": "4px",
            "style": "solid"
          }
        },
        "spacing": {
          "padding": { "left": "1.5rem" }
        },
        "typography": {
          "fontStyle": "italic",
          "fontSize": "var(--wp--preset--font-size--large)"
        },
        "elements": {
          "cite": {
            "typography": {
              "fontStyle": "normal",
              "fontSize": "var(--wp--preset--font-size--small)"
            }
          }
        }
      },
      "core/pullquote": {
        "border": {
          "top": { "width": "4px", "style": "solid" },
          "bottom": { "width": "4px", "style": "solid" }
        },
        "spacing": {
          "padding": { "top": "2rem", "bottom": "2rem" }
        }
      },
      "core/code": {
        "color": {
          "background": "var(--wp--preset--color--tertiary)"
        },
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--mono)"
        },
        "border": { "radius": "var(--wp--custom--radius--default)" },
        "spacing": {
          "padding": {
            "top": "1rem",
            "right": "1.5rem",
            "bottom": "1rem",
            "left": "1.5rem"
          }
        }
      },
      "core/separator": {
        "color": {
          "background": "var(--wp--preset--color--tertiary)"
        },
        "border": { "width": "0" }
      },
      "core/image": {
        "border": { "radius": "var(--wp--custom--radius--default)" }
      },
      "core/button": {
        "variations": {
          "outline": {
            "border": {
              "color": "currentColor",
              "style": "solid",
              "width": "2px"
            },
            "color": {
              "background": "transparent"
            }
          }
        }
      }
    }
  }
}
```

## CSS Output

WordPress generates CSS from styles following this pattern:

```css
/* Global color */
body {
  background-color: var(--wp--preset--color--base);
  color: var(--wp--preset--color--contrast);
}

/* Global typography */
body {
  font-family: var(--wp--preset--font-family--body);
  font-size: var(--wp--preset--font-size--medium);
  line-height: 1.6;
}

/* Elements */
h1, h2, h3, h4, h5, h6 {
  font-family: var(--wp--preset--font-family--heading);
  font-weight: 700;
  line-height: 1.2;
}

a {
  color: var(--wp--preset--color--primary);
}

a:hover {
  text-decoration: none;
}

/* Blocks */
.wp-block-quote {
  border-left: 4px solid var(--wp--preset--color--primary);
  padding-left: 1.5rem;
  font-style: italic;
}

/* Block variations */
.wp-block-button.is-style-outline .wp-block-button__link {
  background: transparent;
  border: 2px solid currentColor;
}
```
