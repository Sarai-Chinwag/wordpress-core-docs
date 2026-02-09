# WP_HTML_Text_Replacement

Data structure for queuing text replacements in an HTML document.

**Source:** `wp-includes/html-api/class-wp-html-text-replacement.php`  
**Since:** 6.2.0  
**Access:** private

---

## Overview

Represents a text replacement operation: a span of the original document to be replaced with new text. These replacements are queued and applied in batch for efficiency.

---

## Properties

### start

```php
public $start;
```

Type: `int`

Byte offset where the replacement span begins.

---

### length

```php
public $length;
```

Type: `int`

Byte length of the original text being replaced.

**Since:** 6.5.0 (replaced `end` with `length` to align with `substr()`)

---

### text

```php
public $text;
```

Type: `string`

The new text to insert in place of the original.

---

## Methods

### __construct()

Creates a text replacement.

```php
public function __construct( int $start, int $length, string $text )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$start` | int | Byte offset where replacement begins |
| `$length` | int | Byte length of span being replaced |
| `$text` | string | New text to insert |

---

## Usage Examples

### Replacing Text

```php
$html = '<div id="old-id">content</div>';
//       0         1         2         3
//       0123456789012345678901234567890

// Replace "old-id" with "new-id"
$replacement = new WP_HTML_Text_Replacement( 9, 6, 'new-id' );
// $replacement->start = 9 (position of "old-id")
// $replacement->length = 6 (length of "old-id")
// $replacement->text = 'new-id'
```

### Inserting Text

```php
// Insert " class=\"example\"" after tag name
// <div> -> <div class="example">
$replacement = new WP_HTML_Text_Replacement( 4, 0, ' class="example"' );
// $replacement->start = 4 (after "div")
// $replacement->length = 0 (inserting, not replacing)
// $replacement->text = ' class="example"'
```

### Removing Text

```php
// Remove an attribute
// <div class="old"> -> <div>
$replacement = new WP_HTML_Text_Replacement( 4, 12, '' );
// $replacement->start = 4
// $replacement->length = 12 (including space and attribute)
// $replacement->text = '' (empty = deletion)
```

---

## Internal Usage

The tag processor queues replacements in `$lexical_updates`:

```php
// When set_attribute() is called:
$this->lexical_updates[ $comparable_name ] = new WP_HTML_Text_Replacement(
    $existing_attribute->start,
    $existing_attribute->length,
    $updated_attribute
);

// When adding a new attribute:
$this->lexical_updates[ $comparable_name ] = new WP_HTML_Text_Replacement(
    $this->tag_name_starts_at + $this->tag_name_length,
    0,  // Insert, don't replace
    ' ' . $updated_attribute
);
```

Replacements are applied in `apply_attributes_updates()` when `get_updated_html()` is called, sorted by position to handle shifts correctly.
