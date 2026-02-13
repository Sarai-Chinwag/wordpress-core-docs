# WP_HTML_Processor_State

Internal state management for the HTML processor during parsing.

**Source:** `wp-includes/html-api/class-wp-html-processor-state.php`  
**Since:** 6.4.0  
**Access:** private

---

## Constants

### Insertion Modes

| Constant | Description |
|----------|-------------|
| `INSERTION_MODE_INITIAL` | Initial state for full parser (@since 6.4.0) |
| `INSERTION_MODE_BEFORE_HTML` | Before HTML element (@since 6.7.0) |
| `INSERTION_MODE_BEFORE_HEAD` | Before HEAD element (@since 6.7.0) |
| `INSERTION_MODE_IN_HEAD` | Inside HEAD element (@since 6.7.0) |
| `INSERTION_MODE_IN_HEAD_NOSCRIPT` | Inside NOSCRIPT in HEAD (@since 6.7.0) |
| `INSERTION_MODE_AFTER_HEAD` | After HEAD, before BODY (@since 6.7.0) |
| `INSERTION_MODE_IN_BODY` | Inside BODY (main mode) (@since 6.4.0) |
| `INSERTION_MODE_IN_TABLE` | Inside TABLE element (@since 6.7.0) |
| `INSERTION_MODE_IN_TABLE_TEXT` | Processing table text (@since 6.7.0) |
| `INSERTION_MODE_IN_CAPTION` | Inside CAPTION element (@since 6.7.0) |
| `INSERTION_MODE_IN_COLUMN_GROUP` | Inside COLGROUP element (@since 6.7.0) |
| `INSERTION_MODE_IN_TABLE_BODY` | Inside TBODY/THEAD/TFOOT (@since 6.7.0) |
| `INSERTION_MODE_IN_ROW` | Inside TR element (@since 6.7.0) |
| `INSERTION_MODE_IN_CELL` | Inside TD/TH element (@since 6.7.0) |
| `INSERTION_MODE_IN_SELECT` | Inside SELECT element (@since 6.7.0) |
| `INSERTION_MODE_IN_SELECT_IN_TABLE` | SELECT inside TABLE (@since 6.7.0) |
| `INSERTION_MODE_IN_TEMPLATE` | Inside TEMPLATE element (@since 6.7.0) |
| `INSERTION_MODE_AFTER_BODY` | After BODY closes (@since 6.7.0) |
| `INSERTION_MODE_IN_FRAMESET` | Inside FRAMESET element (@since 6.7.0) |
| `INSERTION_MODE_AFTER_FRAMESET` | After FRAMESET closes (@since 6.7.0) |
| `INSERTION_MODE_AFTER_AFTER_BODY` | Final state after body (@since 6.7.0) |
| `INSERTION_MODE_AFTER_AFTER_FRAMESET` | Final state after frameset (@since 6.7.0) |

---

## Properties

### Stack of Open Elements

```php
public $stack_of_open_elements;
```

Type: `WP_HTML_Open_Elements`

Tracks which elements are currently open. The stack grows downwards; the first added is at the top, the most recent at the bottom.

---

### Active Formatting Elements

```php
public $active_formatting_elements;
```

Type: `WP_HTML_Active_Formatting_Elements`

Tracks formatting elements for handling mis-nested tags.

---

### Current Token

```php
public $current_token = null;
```

Type: `WP_HTML_Token|null`

Reference to the currently-matched tag.

---

### Insertion Mode

```php
public $insertion_mode = self::INSERTION_MODE_INITIAL;
```

Type: `string`

Current insertion mode for tree construction.

---

### Stack of Template Insertion Modes

```php
public $stack_of_template_insertion_modes = array();
```

Type: `array<string>`

Stack for tracking insertion modes when entering TEMPLATE elements.

---

### Context Node (Deprecated)

```php
public $context_node = null;
```

Type: `null`

**Deprecated:** 6.8.0 — Context node is tracked internally by WP_HTML_Processor.

---

### Encoding

```php
public $encoding = null;
```

Type: `string|null`

The recognized encoding of the input byte stream.

---

### Encoding Confidence

```php
public $encoding_confidence = 'tentative';
```

Type: `string`

Confidence level: `"tentative"`, `"certain"`, or `"irrelevant"`.

---

### HEAD Element Pointer

```php
public $head_element = null;
```

Type: `WP_HTML_Token|null`

Points to the HEAD element when encountered.

---

### FORM Element Pointer

```php
public $form_element = null;
```

Type: `WP_HTML_Token|null`

Points to the last opened FORM element. Used to associate form controls even with badly nested markup.

---

### Frameset-OK Flag

```php
public $frameset_ok = true;
```

Type: `bool`

Indicates whether a FRAMESET element is allowed. Initially `true`, set to `false` after certain tokens.

---

## Methods

### __construct()

Creates a new empty state.

```php
public function __construct()
```

Initializes the stack of open elements and active formatting elements.

---

## Usage Example

```php
// State is managed internally by WP_HTML_Processor
$processor = WP_HTML_Processor::create_fragment( '<div><p>Hello' );

// The processor maintains state internally:
// - stack_of_open_elements: [HTML, BODY, DIV, P]
// - insertion_mode: IN_BODY
// - active_formatting_elements: []

while ( $processor->next_tag() ) {
    // As the processor parses, state is updated
    // - Elements are pushed/popped from stacks
    // - Insertion mode changes based on context
}
```

---

## Insertion Mode Flow

```
INITIAL
    └─ (DOCTYPE or implied)
BEFORE_HTML
    └─ (HTML tag or implied)
BEFORE_HEAD
    └─ (HEAD tag or implied)
IN_HEAD
    ├─ IN_HEAD_NOSCRIPT (if NOSCRIPT)
    └─ (HEAD closes or implied)
AFTER_HEAD
    └─ (BODY or FRAMESET or implied)
IN_BODY                     IN_FRAMESET
    ├─ IN_TABLE                 └─ AFTER_FRAMESET
    │   ├─ IN_CAPTION               └─ AFTER_AFTER_FRAMESET
    │   ├─ IN_COLUMN_GROUP
    │   ├─ IN_TABLE_BODY
    │   │   └─ IN_ROW
    │   │       └─ IN_CELL
    │   ├─ IN_SELECT
    │   │   └─ IN_SELECT_IN_TABLE
    │   └─ IN_TABLE_TEXT
    ├─ IN_TEMPLATE (recursive)
    └─ (BODY closes)
AFTER_BODY
    └─ AFTER_AFTER_BODY
```

---

## Encoding Confidence Levels

| Level | Meaning |
|-------|---------|
| `tentative` | Encoding may change if contradicting information found |
| `certain` | Encoding is definitely known |
| `irrelevant` | No encoding needed (already Unicode) |
