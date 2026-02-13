# WP_HTML_Decoder

Decodes HTML character references in text content and attributes.

**Source:** `wp-includes/html-api/class-wp-html-decoder.php`  
**Since:** 6.6.0

---

## Methods

### attribute_starts_with()

Checks if a raw attribute value starts with a given string after decoding.

```php
public static function attribute_starts_with( $haystack, $search_text, $case_sensitivity = 'case-sensitive' ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$haystack` | string | Raw attribute value |
| `$search_text` | string | Plain string to match |
| `$case_sensitivity` | string | `"case-sensitive"` or `"ascii-case-insensitive"` |

**Returns:** `true` if attribute starts with the search text.

This compares the decoded value, handling all HTML character reference encodings.

**Example:**

```php
$value = 'http&colon;//wordpress.org/';

WP_HTML_Decoder::attribute_starts_with( $value, 'http:', 'ascii-case-insensitive' );
// Returns: true

WP_HTML_Decoder::attribute_starts_with( $value, 'https:', 'ascii-case-insensitive' );
// Returns: false

// Works with any encoding
$encoded = '&#x68;ttp:';
WP_HTML_Decoder::attribute_starts_with( $encoded, 'http:' );
// Returns: true
```

---

### decode_text_node()

Decodes a text node's content.

```php
public static function decode_text_node( $text ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$text` | string | Raw text content |

**Returns:** Decoded UTF-8 string.

Use this for text between tags (DATA sections), not for attribute values.

**Example:**

```php
$raw = '&ldquo;&#x1f604;&rdquo;';
$decoded = WP_HTML_Decoder::decode_text_node( $raw );
// Returns: "😄"
```

---

### decode_attribute()

Decodes an attribute value.

```php
public static function decode_attribute( $text ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$text` | string | Raw attribute value |

**Returns:** Decoded UTF-8 string.

Attribute values have different decoding rules than text nodes. Use this for attribute values.

**Example:**

```php
$raw = 'Eggs &amp; Milk';
$decoded = WP_HTML_Decoder::decode_attribute( $raw );
// Returns: "Eggs & Milk"
```

---

### decode()

Low-level decoder for arbitrary HTML text.

```php
public static function decode( $context, $text ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$context` | string | `"attribute"` or `"data"` |
| `$text` | string | Raw text to decode |

**Returns:** Decoded UTF-8 string.

**Example:**

```php
WP_HTML_Decoder::decode( 'data', '&copy;' );
// Returns: "©"
```

---

### read_character_reference()

Reads a character reference at a specific position.

```php
public static function read_character_reference( $context, $text, $at = 0, &$match_byte_length = null )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$context` | string | `"attribute"` or `"data"` |
| `$text` | string | Text containing reference |
| `$at` | int | Byte offset to start reading |
| `&$match_byte_length` | int | Set to length of matched reference |

**Returns:** `string|false` — Decoded character or `false` if no reference found (per source docblock). **Note:** The source docblock declares the return type as `string|false`, though the actual implementation returns `null` in no-match cases. This is a known discrepancy in the source.

**Example:**

```php
$text = 'Ships&hellip;';

// No reference at position 0
$result = WP_HTML_Decoder::read_character_reference( 'attribute', $text, 0 );
// Returns: null

// Reference at position 5
$result = WP_HTML_Decoder::read_character_reference( 'attribute', $text, 5, $length );
// Returns: "…"
// $length: 8 (length of "&hellip;")
```

---

### code_point_to_utf8_bytes()

Converts a Unicode code point to UTF-8 bytes.

```php
public static function code_point_to_utf8_bytes( $code_point ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$code_point` | int | Unicode code point |

**Returns:** UTF-8 encoded character or `"�"` for invalid code points.

**Example:**

```php
WP_HTML_Decoder::code_point_to_utf8_bytes( 0x1f170 );
// Returns: "🅰"

// Invalid code point (half of surrogate pair)
WP_HTML_Decoder::code_point_to_utf8_bytes( 0xd83c );
// Returns: "�"
```

---

## Character Reference Types

### Named References

```html
&amp;     → &
&lt;      → <
&gt;      → >
&quot;    → "
&copy;    → ©
&hellip;  → …
```

### Numeric References (Decimal)

```html
&#38;     → &
&#60;     → <
&#169;    → ©
&#128512; → 😀
```

### Numeric References (Hexadecimal)

```html
&#x26;    → &
&#x3C;    → <
&#xA9;    → ©
&#x1F600; → 😀
```

---

## Context Differences

### Attribute Context

In attributes, ambiguous references (not ending in `;`) that are followed by alphanumeric characters or `=` are NOT decoded:

```php
// "&not" followed by "in" is ambiguous in attributes
WP_HTML_Decoder::decode( 'attribute', '&notin' );
// Returns: "&notin" (unchanged)

WP_HTML_Decoder::decode( 'attribute', '&notin;' );
// Returns: "∉" (decoded)
```

### Data Context

In text content, ambiguous references are decoded:

```php
// "&not" is decoded even without "in"
WP_HTML_Decoder::decode( 'data', '&notin' );
// Returns: "¬in" (¬ = "not")

WP_HTML_Decoder::decode( 'data', '&notin;' );
// Returns: "∉" (decoded as single character)
```

---

## C1 Control Character Mapping

Numeric references in the C1 control range (0x80-0x9F) are remapped as if encoded in Windows-1252:

```php
WP_HTML_Decoder::decode( 'data', '&#x80;' );
// Returns: "€" (Euro sign, not control character)

WP_HTML_Decoder::decode( 'data', '&#x93;' );
// Returns: """ (left double quote)
```

This matches browser behavior for legacy compatibility.
