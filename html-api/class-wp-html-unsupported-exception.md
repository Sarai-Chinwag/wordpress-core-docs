# WP_HTML_Unsupported_Exception

Exception thrown when the HTML processor encounters unsupported markup.

**Source:** `wp-includes/html-api/class-wp-html-unsupported-exception.php`  
**Since:** 6.4.0  
**Since:** 6.7.0 Gained contextual debugging information  
**Access:** private  
**Extends:** `Exception`

---

## Overview

The HTML API aims to operate in compliance with the HTML5 specification but does not implement the full specification. When it encounters markup it cannot handle safely, it throws this exception rather than producing incorrect output.

This exception is caught internally by the processor and causes parsing to stop gracefully.

---

## Properties

### token_name

```php
public $token_name;
```

Type: `string`

Normalized name of the matched token when the exception was raised. This doesn't necessarily mean the token itself was unsupported — it may have triggered an unsupported code path.

---

### token_at

```php
public $token_at;
```

Type: `int`

Byte offset into the input HTML where the parser was when the exception was raised.

---

### token

```php
public $token;
```

Type: `string`

Full raw text of the matched token. Unlike `token_name`, this preserves original casing, duplicated attributes, and other syntactic variations.

---

### stack_of_open_elements

```php
public $stack_of_open_elements = array();
```

Type: `string[]`

List of element names that were open when the exception was raised. Useful for understanding the parsing context.

---

### active_formatting_elements

```php
public $active_formatting_elements = array();
```

Type: `string[]`

List of active formatting element names when the exception was raised.

---

## Methods

### __construct()

Creates an unsupported exception with context.

```php
public function __construct(
    string $message,
    string $token_name,
    int $token_at,
    string $token,
    array $stack_of_open_elements,
    array $active_formatting_elements
)
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$message` | string | Explanation of what is unsupported |
| `$token_name` | string | Normalized token name |
| `$token_at` | int | Byte offset of token |
| `$token` | string | Raw token text |
| `$stack_of_open_elements` | string[] | Open element names |
| `$active_formatting_elements` | string[] | Formatting element names |

---

## Usage Example

```php
$processor = WP_HTML_Processor::create_fragment( $html );

while ( $processor->next_tag() ) {
    // Process tags...
}

// Check if parsing stopped due to unsupported markup
if ( $processor->get_last_error() ) {
    $exception = $processor->get_unsupported_exception();
    
    if ( $exception ) {
        echo "Unsupported: " . $exception->getMessage() . "\n";
        echo "Token: " . $exception->token_name . "\n";
        echo "At byte: " . $exception->token_at . "\n";
        echo "Raw: " . $exception->token . "\n";
        echo "Stack: " . implode( ' > ', $exception->stack_of_open_elements ) . "\n";
    }
}
```

---

## Common Causes

The following are verified causes found via `bail()` calls in the source:

### Foster Parenting

Tables with improperly nested content (verified: `'Foster parenting is not supported.'`):

```html
<table><div>This content needs foster parenting</div></table>
```

### Adoption Agency Algorithm (partial)

The adoption agency algorithm is partially implemented. It bails when looping is required or when "any other end tag" handling is needed (verified: `'Cannot run adoption agency when looping required.'`, `'Cannot run adoption agency when "any other end tag" is required.'`).

### Active Formatting Element Reconstruction

Bails when reconstruction requires advancing and rewinding (verified: `'Cannot reconstruct active formatting elements when advancing and rewinding is required.'`).

### FORM Element Nesting

Bails when closing a FORM would disrupt breadcrumb tracking (verified: `'Cannot close a FORM when other elements remain open...'`).

---

## Debugging Parse Failures

The exception provides all context needed to reproduce and debug failures:

```php
$exception = $processor->get_unsupported_exception();

if ( $exception ) {
    // Show context around the failure
    $html = $processor->get_updated_html();
    $context_start = max( 0, $exception->token_at - 50 );
    $context = substr( $html, $context_start, 100 );
    
    echo "Context: ...{$context}...\n";
    echo "Stack: " . implode( ' > ', $exception->stack_of_open_elements ) . "\n";
    echo "Formatting: " . implode( ', ', $exception->active_formatting_elements ) . "\n";
}
```
