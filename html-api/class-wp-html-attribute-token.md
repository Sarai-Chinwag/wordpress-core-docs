# WP_HTML_Attribute_Token

Data structure representing an HTML attribute for the tag processor.

**Source:** `wp-includes/html-api/class-wp-html-attribute-token.php`  
**Since:** 6.2.0  
**Access:** private

---

## Properties

### name

```php
public $name;
```

Type: `string`

The attribute name.

---

### value_starts_at

```php
public $value_starts_at;
```

Type: `int`

Byte offset where the attribute value starts in the input HTML.

---

### value_length

```php
public $value_length;
```

Type: `int`

Byte length of the attribute value.

---

### start

```php
public $start;
```

Type: `int`

Byte offset where the attribute name starts in the input HTML.

---

### length

```php
public $length;
```

Type: `int`

Byte length of the entire attribute expression (name and optional value).

**Since:** 6.5.0 (replaced `end` with `length`)

---

### is_true

```php
public $is_true;
```

Type: `bool`

Whether this is a boolean attribute with value `true` (attribute present without value).

---

## Methods

### __construct()

Creates an attribute token.

```php
public function __construct( $name, $value_start, $value_length, $start, $length, $is_true )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Attribute name |
| `$value_start` | int | Byte offset of value start |
| `$value_length` | int | Byte length of value |
| `$start` | int | Byte offset of attribute start |
| `$length` | int | Byte length of entire attribute |
| `$is_true` | bool | Whether boolean attribute |

---

## Attribute Span Examples

### Quoted Attribute

```html
<div class="post">
     ^-----------^ length = 12 (including quotes)
     ^           start = 5
         ^---^   value portion (value_starts_at = 11, value_length = 4)
```

### Boolean Attribute

```html
<input type="checked" checked id="selector">
                      ^-----^ length = 6
                      is_true = true
```

### Unquoted Attribute

```html
<a rel=noopener>
   ^----------^ length = 11
   ^           start = 3
       ^------^ value portion
```

---

## Usage in WP_HTML_Tag_Processor

The tag processor creates these tokens internally when parsing attributes:

```php
$html = '<div id="test-4" class=outline title="data:text/plain;base64=xyz">';
$processor = new WP_HTML_Tag_Processor( $html );
$processor->next_tag();

// Internal attributes array might look like:
// [
//     'id' => WP_HTML_Attribute_Token( 'id', 9, 6, 5, 11, false ),
//     'class' => WP_HTML_Attribute_Token( 'class', 23, 7, 17, 13, false ),
//     'title' => WP_HTML_Attribute_Token( 'title', 38, 23, 31, 30, false ),
// ]
```

The token stores offsets into the original HTML string, allowing the processor to efficiently update or remove attributes by calculating replacement ranges.
