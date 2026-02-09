# WP_HTML_Stack_Event

Record of a stack operation during HTML parsing.

**Source:** `wp-includes/html-api/class-wp-html-stack-event.php`  
**Since:** 6.6.0  
**Access:** private

---

## Constants

### POP

```php
const POP = 'pop';
```

Indicates an element was popped off the stack of open elements.

---

### PUSH

```php
const PUSH = 'push';
```

Indicates an element was pushed onto the stack of open elements.

---

## Properties

### token

```php
public $token;
```

Type: `WP_HTML_Token`

The token associated with this stack event. For both PUSH and POP events, this references the opening token.

---

### operation

```php
public $operation;
```

Type: `string`

The type of stack operation: `self::PUSH` or `self::POP`.

---

### provenance

```php
public $provenance;
```

Type: `string`

Indicates whether the element is real or virtual:

- `"real"` — Element exists in the source HTML
- `"virtual"` — Element was implicitly created by the parser

---

## Methods

### __construct()

Creates a stack event record.

```php
public function __construct( WP_HTML_Token $token, string $operation, string $provenance )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | WP_HTML_Token | Associated opening token |
| `$operation` | string | `self::PUSH` or `self::POP` |
| `$provenance` | string | `"virtual"` or `"real"` |

---

## Usage Example

```php
// When parsing '<div><p>text'
// The parser creates stack events:

// 1. Push HTML (virtual - implied)
$event1 = new WP_HTML_Stack_Event( $html_token, WP_HTML_Stack_Event::PUSH, 'virtual' );

// 2. Push BODY (virtual - implied)
$event2 = new WP_HTML_Stack_Event( $body_token, WP_HTML_Stack_Event::PUSH, 'virtual' );

// 3. Push DIV (real - from source)
$event3 = new WP_HTML_Stack_Event( $div_token, WP_HTML_Stack_Event::PUSH, 'real' );

// 4. Push P (real - from source)
$event4 = new WP_HTML_Stack_Event( $p_token, WP_HTML_Stack_Event::PUSH, 'real' );
```

---

## Virtual vs Real Elements

### Virtual Elements

Created implicitly by the parser when required elements are missing:

```html
<!-- Input -->
<p>Hello</p>

<!-- Parser creates virtual HTML and BODY -->
<html>
  <body>
    <p>Hello</p>
  </body>
</html>
```

### Real Elements

Explicitly present in the source HTML:

```html
<!-- Input -->
<div class="container"><p>Hello</p></div>

<!-- DIV and P are "real" elements -->
```

---

## Internal Usage

The HTML processor uses stack events to track which elements are encountered during parsing. These events form a queue that supplies "match" events to the caller:

```php
// Inside WP_HTML_Processor
private $element_queue = array();

// When processing, events are added to the queue
$this->element_queue[] = new WP_HTML_Stack_Event(
    $token,
    WP_HTML_Stack_Event::PUSH,
    $this->is_virtual() ? 'virtual' : 'real'
);
```
