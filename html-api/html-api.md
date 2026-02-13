# HTML API

WordPress HTML parsing and modification framework providing spec-compliant HTML5 processing.

**Since:** 6.2.0  
**Source:** `wp-includes/html-api/`

## Components

| Component | Description |
|-----------|-------------|
| [class-wp-html-tag-processor.md](./class-wp-html-tag-processor.md) | Tag-level HTML scanner and modifier |
| [class-wp-html-processor.md](./class-wp-html-processor.md) | Full HTML5 parser with tree construction |
| [class-wp-html-decoder.md](./class-wp-html-decoder.md) | HTML character reference decoding |
| [class-wp-html-doctype-info.md](./class-wp-html-doctype-info.md) | DOCTYPE token parsing |
| [class-wp-html-open-elements.md](./class-wp-html-open-elements.md) | Stack of open elements |
| [class-wp-html-active-formatting-elements.md](./class-wp-html-active-formatting-elements.md) | Active formatting elements list |
| [class-wp-html-processor-state.md](./class-wp-html-processor-state.md) | Parser state management |
| [class-wp-html-token.md](./class-wp-html-token.md) | Token representation |
| [class-wp-html-attribute-token.md](./class-wp-html-attribute-token.md) | Attribute token data |
| [class-wp-html-span.md](./class-wp-html-span.md) | Text span data structure |
| [class-wp-html-text-replacement.md](./class-wp-html-text-replacement.md) | Text replacement data |
| [class-wp-html-stack-event.md](./class-wp-html-stack-event.md) | Stack operation record |
| [class-wp-html-unsupported-exception.md](./class-wp-html-unsupported-exception.md) | Unsupported markup exception |
| [hooks.md](./hooks.md) | Actions and filters |

## Architecture

```
WP_HTML_Tag_Processor (6.2.0)
    └── Linear token scanner
    └── Attribute modification
    └── Bookmark navigation

WP_HTML_Processor (6.4.0) extends WP_HTML_Tag_Processor
    └── HTML5 tree construction
    └── Stack of open elements
    └── Active formatting elements
    └── Breadcrumb navigation
```

## Usage Patterns

### Tag Processor (Simple Modifications)

```php
// Modify attributes on specific tags
$processor = new WP_HTML_Tag_Processor( $html );
while ( $processor->next_tag( 'img' ) ) {
    $processor->set_attribute( 'loading', 'lazy' );
}
$html = $processor->get_updated_html();
```

### HTML Processor (Structure-Aware)

```php
// Modify based on document structure
$processor = WP_HTML_Processor::create_fragment( $html );
while ( $processor->next_tag( array( 'breadcrumbs' => array( 'FIGURE', 'IMG' ) ) ) ) {
    $processor->add_class( 'figure-image' );
}
$html = $processor->get_updated_html();
```

## Processing Flow

### Tag Processor

```
next_tag() / next_token()
    ├── parse_next_tag()
    ├── parse_next_attribute() (loop)
    └── matches() query check

Modification methods:
    ├── set_attribute() → lexical_updates[]
    ├── remove_attribute() → lexical_updates[]
    ├── add_class() → classname_updates[]
    ├── remove_class() → classname_updates[]
    └── set_modifiable_text() → lexical_updates[]

get_updated_html()
    └── apply_attributes_updates()
```

### HTML Processor

```
create_fragment() / create_full_parser()
    └── Initialize state, stacks

next_tag() / next_token()
    └── step() insertion mode dispatch
        ├── step_in_body()
        ├── step_in_table()
        ├── step_in_head()
        └── ... other modes

Tree operations:
    ├── insert_html_element()
    ├── generate_implied_end_tags()
    ├── reconstruct_active_formatting_elements()
    └── run_adoption_agency_algorithm()
```

## Token Types

| Token | Description |
|-------|-------------|
| `#tag` | HTML element (opening or closing) |
| `#text` | Text node content |
| `#comment` | HTML comment |
| `#doctype` | DOCTYPE declaration |
| `#cdata-section` | CDATA section (only in foreign content — SVG/MathML) |
| `#funky-comment` | Invalid tag closer as comment |
| `#presumptuous-tag` | Empty end tag `</>` |

## Compatibility Modes

| Mode | Description |
|------|-------------|
| `no-quirks` | Standards mode |
| `limited-quirks` | Almost standards mode |
| `quirks` | Quirks mode (legacy) |

## Special Elements

Certain elements have special parsing rules:

- **SCRIPT**: Raw text with legacy comment handling
- **STYLE**: Raw text
- **TITLE/TEXTAREA**: Decoded plaintext
- **IFRAME/NOSCRIPT/NOEMBED**: Raw text, no decoding

## Namespaces

| Namespace | Context |
|-----------|---------|
| `html` | Standard HTML |
| `svg` | SVG foreign content |
| `math` | MathML foreign content |

## Design Principles

1. **Spec Compliance**: Implements HTML5 parsing specification
2. **Safety First**: Aborts on unsupported markup rather than breaking documents
3. **Garbage-in, Garbage-out**: The Tag Processor passes invalid inputs through unchanged; the HTML Processor will abort (bail) on unsupported or unrecognized markup rather than producing incorrect output
4. **Minimal Diff**: Preserves original formatting where possible
5. **No Tree Construction**: Tag Processor operates linearly
6. **Memory Efficient**: Negligible memory overhead
