# HTML API

The HTML API provides a set of classes for parsing and modifying HTML documents in WordPress without using regular expressions or DOM parsing.

**Since:** WordPress 6.2.0

## Overview

The HTML API enables developers to:

- Find and modify HTML tags and attributes
- Parse HTML documents following the WHATWG HTML specification
- Safely transform HTML without breaking document structure
- Process HTML in a streaming, memory-efficient manner

## Classes

| Class | Since | Description |
|-------|-------|-------------|
| `WP_HTML_Tag_Processor` | 6.2.0 | Low-level tag finding and attribute modification |
| `WP_HTML_Processor` | 6.4.0 | Full HTML parsing with tree traversal |

## Quick Start

### Modifying Attributes

```php
$html = '<div class="old"><img src="photo.jpg"></div>';
$processor = new WP_HTML_Tag_Processor( $html );

if ( $processor->next_tag( 'img' ) ) {
    $processor->set_attribute( 'loading', 'lazy' );
    $processor->add_class( 'responsive' );
}

echo $processor->get_updated_html();
// <div class="old"><img loading="lazy" class="responsive" src="photo.jpg"></div>
```

### Finding Specific Tags

```php
$processor = new WP_HTML_Tag_Processor( $html );

// Find by tag name
$processor->next_tag( 'div' );

// Find by class
$processor->next_tag( array( 'class_name' => 'featured' ) );

// Find by tag and class
$processor->next_tag( array( 
    'tag_name'   => 'img',
    'class_name' => 'hero',
) );
```

### Traversing the DOM

```php
$processor = WP_HTML_Processor::create_fragment( $html );

// Move through all tags
while ( $processor->next_tag() ) {
    $tag = $processor->get_tag();
    $depth = $processor->get_current_depth();
    echo str_repeat( '  ', $depth ) . "<{$tag}>\n";
}
```

## Documentation

- [WP_HTML_Tag_Processor](./class-wp-html-tag-processor.md) — Tag finding and attributes
- [WP_HTML_Processor](./class-wp-html-processor.md) — Full HTML parsing
- [Query Syntax](./queries.md) — Finding tags
- [Modifying HTML](./modifications.md) — Changing attributes and classes
- [Bookmarks](./bookmarks.md) — Saving and restoring positions

## Key Concepts

### Cursor-Based Processing

The HTML API uses a cursor that moves forward through the document. You cannot move backward (except with bookmarks).

```php
$processor = new WP_HTML_Tag_Processor( $html );

// Cursor starts before first tag
$processor->next_tag();  // Moves to first tag
$processor->next_tag();  // Moves to second tag
// Cannot go back to first tag without bookmarks
```

### Tag Processor vs HTML Processor

| Feature | WP_HTML_Tag_Processor | WP_HTML_Processor |
|---------|----------------------|-------------------|
| Find tags | ✅ | ✅ |
| Modify attributes | ✅ | ✅ |
| DOM tree awareness | ❌ | ✅ |
| Nesting depth | ❌ | ✅ |
| CSS selectors | ❌ | ✅ |
| Performance | Faster | Slower |

Use `WP_HTML_Tag_Processor` for simple attribute modifications. Use `WP_HTML_Processor` when you need DOM structure awareness.

### Read-Only vs Modifications

Reading operations are instant. Modifications are queued and applied when you call `get_updated_html()`.

```php
$processor = new WP_HTML_Tag_Processor( $html );

if ( $processor->next_tag( 'img' ) ) {
    // Read (instant)
    $src = $processor->get_attribute( 'src' );
    
    // Modify (queued)
    $processor->set_attribute( 'loading', 'lazy' );
}

// Apply all queued modifications
$new_html = $processor->get_updated_html();
```

## Common Patterns

### Add Lazy Loading to All Images

```php
$processor = new WP_HTML_Tag_Processor( $content );

while ( $processor->next_tag( 'img' ) ) {
    if ( null === $processor->get_attribute( 'loading' ) ) {
        $processor->set_attribute( 'loading', 'lazy' );
    }
}

$content = $processor->get_updated_html();
```

### Add Target to External Links

```php
$processor = new WP_HTML_Tag_Processor( $content );

while ( $processor->next_tag( 'a' ) ) {
    $href = $processor->get_attribute( 'href' );
    if ( $href && ! str_starts_with( $href, home_url() ) ) {
        $processor->set_attribute( 'target', '_blank' );
        $processor->set_attribute( 'rel', 'noopener noreferrer' );
    }
}

$content = $processor->get_updated_html();
```

### Remove Inline Styles

```php
$processor = new WP_HTML_Tag_Processor( $content );

while ( $processor->next_tag() ) {
    $processor->remove_attribute( 'style' );
}

$content = $processor->get_updated_html();
```

## Why Not Regex?

Regular expressions cannot reliably parse HTML:

```php
// This regex fails on nested quotes, comments, CDATA, etc.
$html = preg_replace( '/<img([^>]*)>/', '<img$1 loading="lazy">', $html );
```

The HTML API handles all edge cases correctly:

```php
$processor = new WP_HTML_Tag_Processor( $html );
while ( $processor->next_tag( 'img' ) ) {
    $processor->set_attribute( 'loading', 'lazy' );
}
$html = $processor->get_updated_html();
```

## Why Not DOMDocument?

`DOMDocument` has issues:

- Modifies HTML structure (adds doctype, html, body)
- Encoding problems with UTF-8
- Memory-intensive for large documents
- Alters whitespace and formatting

The HTML API preserves the original document structure exactly.
