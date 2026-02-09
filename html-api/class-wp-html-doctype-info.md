# WP_HTML_Doctype_Info

Represents a parsed DOCTYPE declaration token with document compatibility mode.

**Source:** `wp-includes/html-api/class-wp-html-doctype-info.php`  
**Since:** 6.7.0  
**Access:** private

---

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$name` | string\|null | DOCTYPE name (should be "html") |
| `$public_identifier` | string\|null | Public identifier |
| `$system_identifier` | string\|null | System identifier |
| `$indicated_compatibility_mode` | string | `"no-quirks"`, `"limited-quirks"`, or `"quirks"` |

All properties should be treated as read-only.

---

## Methods

### __construct()

Constructor. Do not call directly; use `from_doctype_token()`.

```php
private function __construct(
    ?string $name,
    ?string $public_identifier,
    ?string $system_identifier,
    bool $force_quirks_flag
)
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string\|null | DOCTYPE name |
| `$public_identifier` | string\|null | Public identifier |
| `$system_identifier` | string\|null | System identifier |
| `$force_quirks_flag` | bool | Whether force-quirks is set |

---

### from_doctype_token()

Parses a raw DOCTYPE token and returns information.

```php
public static function from_doctype_token( string $doctype_html ): ?self
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$doctype_html` | string | Complete DOCTYPE string |

**Returns:** `WP_HTML_Doctype_Info` instance or `null` if invalid.

**Example:**

```php
// Standard HTML5 DOCTYPE
$doctype = WP_HTML_Doctype_Info::from_doctype_token( '<!DOCTYPE html>' );
$doctype->name;                         // "html"
$doctype->public_identifier;            // null
$doctype->system_identifier;            // null
$doctype->indicated_compatibility_mode; // "no-quirks"

// Legacy DOCTYPE with public identifier
$doctype = WP_HTML_Doctype_Info::from_doctype_token(
    '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'
);
$doctype->public_identifier; // "-//W3C//DTD HTML 4.01//EN"
$doctype->system_identifier; // "http://www.w3.org/TR/html4/strict.dtd"

// Invalid input returns null
WP_HTML_Doctype_Info::from_doctype_token( 'not a doctype' );
// Returns: null

WP_HTML_Doctype_Info::from_doctype_token( ' <!DOCTYPE html>' );
// Returns: null (leading space invalid)

WP_HTML_Doctype_Info::from_doctype_token( '<!DOCTYPE html><p>' );
// Returns: null (extra content after DOCTYPE)
```

---

## Compatibility Modes

### No-Quirks Mode (Standards Mode)

Triggered by the standard HTML5 DOCTYPE:

```html
<!DOCTYPE html>
```

- CSS class/ID selectors match byte-for-byte (case-sensitive)
- TABLE start tag closes open P elements

### Limited-Quirks Mode

Triggered by XHTML Transitional/Frameset DOCTYPEs:

```html
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "...">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "...">
```

### Quirks Mode

Triggered by:
- Missing DOCTYPE
- DOCTYPE with `force-quirks` flag
- DOCTYPE name not "html"
- Various legacy public identifiers

```html
<!-- Quirks mode examples -->
<!DOCTYPE>
<!DOCTYPE html SYSTEM "http://www.ibm.com/data/dtd/v11/ibmxhtml1-transitional.dtd">
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
```

In quirks mode:
- CSS class/ID selectors match ASCII case-insensitively
- TABLE elements can nest inside P elements

---

## DOCTYPE Structure

```
<!DOCTYPE html PUBLIC "public id" "system id">
          │           │            │
          │           │            └─ system_identifier
          │           └─ public_identifier
          └─ name
```

### Name

The DOCTYPE name identifies the document's root element. For HTML documents, this should always be "html" (case-insensitive in parsing, stored lowercase).

### Public Identifier

Optional. Historically indicated a shared DTD location. Modern HTML5 documents should not have a public identifier.

### System Identifier

Optional. Historically specified where to find the DTD. Modern HTML5 documents should not have a system identifier.

---

## Force-Quirks Conditions

The parser sets the force-quirks flag when:

- DOCTYPE has no name
- DOCTYPE is malformed (missing quotes, etc.)
- Input ends before DOCTYPE is complete

---

## Example: Determining Compatibility Mode

```php
$html = file_get_contents( 'page.html' );
$processor = new WP_HTML_Tag_Processor( $html );

if ( $processor->next_token() && '#doctype' === $processor->get_token_type() ) {
    $doctype = $processor->get_doctype_info();
    
    if ( $doctype ) {
        echo "Mode: " . $doctype->indicated_compatibility_mode;
        echo "Name: " . ( $doctype->name ?? '(none)' );
        
        if ( $doctype->public_identifier ) {
            echo "Public: " . $doctype->public_identifier;
        }
    }
}
```

---

## Quirks Mode Detection Reference

The following public identifier prefixes trigger quirks mode:

- `+//Silmaril//dtd html Pro v0r11 19970101//`
- `-//AS//DTD HTML 3.0 asWedit + extensions//`
- `-//AdvaSoft Ltd//DTD HTML 3.0 asWedit + extensions//`
- `-//IETF//DTD HTML 2.0//` (and variants)
- `-//IETF//DTD HTML 3.0//` (and variants)
- `-//Netscape Comm. Corp.//DTD HTML//`
- `-//O'Reilly and Associates//DTD HTML 2.0//` (and variants)
- `-//SQ//DTD HTML 2.0 HoTMetaL + extensions//`
- `-//SoftQuad Software//DTD HoTMetaL PRO 6.0//`
- `-//W3C//DTD HTML 3.2//` (and variants)
- `-//W3C//DTD HTML 4.0 Frameset//`
- `-//W3C//DTD HTML 4.0 Transitional//`
- And many others from the HTML specification
