# WP_HTML_Span

Lightweight data structure representing a span of bytes in an HTML document.

**Source:** `wp-includes/html-api/class-wp-html-span.php`  
**Since:** 6.2.0  
**Access:** private

---

## Overview

This is a two-tuple in disguise, used to avoid the memory overhead of using an array for the same purpose. It represents a contiguous range of bytes in the input HTML.

---

## Properties

### start

```php
public $start;
```

Type: `int`

Byte offset where the span begins in the document.

---

### length

```php
public $length;
```

Type: `int`

Byte length of the span.

**Since:** 6.5.0 (replaced `end` with `length` to align with `substr()`)

---

## Methods

### __construct()

Creates a span.

```php
public function __construct( int $start, int $length )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$start` | int | Byte offset where span begins |
| `$length` | int | Byte length of span |

---

## Usage Example

```php
$html = '<div class="example">content</div>';
//       0         1         2         3
//       0123456789012345678901234567890123

// Span representing the class attribute value "example"
$span = new WP_HTML_Span( 12, 7 );
$value = substr( $html, $span->start, $span->length );
// Returns: "example"
```

---

## Internal Usage

The span is used internally by the tag processor for:

- Tracking duplicate attribute positions
- Marking bookmark locations
- Defining ranges for text replacements

```php
// Example: bookmarks are stored as spans
$this->bookmarks[ $name ] = new WP_HTML_Span(
    $this->token_starts_at,
    $this->token_length
);
```
