# WP_HTML_Processor

Full HTML5 parser with tree construction, extending WP_HTML_Tag_Processor.

**Source:** `wp-includes/html-api/class-wp-html-processor.php`  
**Since:** 6.4.0  
**Extends:** `WP_HTML_Tag_Processor`

## Constants

### Bookmarks

| Constant | Value | Description |
|----------|-------|-------------|
| `MAX_BOOKMARKS` | `100` | Maximum bookmarks (overrides parent's 10) |

### Node Processing

| Constant | Value | Description |
|----------|-------|-------------|
| `PROCESS_NEXT_NODE` | `'process-next-node'` | Step to next node |
| `REPROCESS_CURRENT_NODE` | `'reprocess-current-node'` | Reprocess current node in newly-selected insertion mode (@since 6.4.0) |
| `PROCESS_CURRENT_NODE` | `'process-current-node'` | Process current node without advancing the parser (@since 6.5.0) |

---

## Static Methods

### create_fragment()

Creates an HTML processor for parsing an HTML fragment.

```php
public static function create_fragment( $html, $context = '<body>', $encoding = 'UTF-8' )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$html` | string | HTML fragment to process |
| `$context` | string | Context element (currently only `<body>` supported) |
| `$encoding` | string | Text encoding (currently only `UTF-8` supported) |

**Returns:** `static|null` — Processor instance or `null` on failure.

**Example:**

```php
$processor = WP_HTML_Processor::create_fragment( '<div><p>Hello</p></div>' );
while ( $processor->next_tag( 'p' ) ) {
    $processor->add_class( 'text' );
}
```

---

### create_full_parser()

Creates an HTML processor for parsing a complete HTML document.

```php
public static function create_full_parser( $html, $known_definite_encoding = 'UTF-8' )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$html` | string | Complete HTML document |
| `$known_definite_encoding` | string | Document encoding |

**Returns:** `static|null` — Processor instance or `null` on failure.

---

### normalize()

Normalizes an HTML fragment to well-formed HTML.

```php
public static function normalize( string $html ): ?string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$html` | string | HTML to normalize |

**Returns:** Normalized HTML string or `null` if normalization fails.

---

### is_special()

Determines if a tag name is a "special" element.

```php
public static function is_special( $tag_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag_name` | string | Tag name to check |

**Returns:** `true` if the element is special.

Special elements have unique parsing rules (e.g., TABLE, TEMPLATE, SCRIPT).

---

### is_void()

Determines if a tag name represents a void element.

```php
public static function is_void( $tag_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag_name` | string | Tag name to check |

**Returns:** `true` if the element is void.

Void elements cannot have content (e.g., IMG, BR, INPUT).

---

## Instance Methods

### __construct()

Constructor. Do not use directly; use `create_fragment()` or `create_full_parser()`.

```php
public function __construct( $html, $use_the_static_create_methods_instead = null )
```

---

### next_tag()

Finds the next tag matching the query, with structure-aware options.

```php
public function next_tag( $query = null ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | array\|string\|null | Search criteria |

**Extended Query Options:**

| Key | Type | Description |
|-----|------|-------------|
| `breadcrumbs` | array | Required ancestor path |

**Returns:** `true` if tag found.

**Example:**

```php
// Find IMG inside FIGURE
$processor->next_tag( array(
    'breadcrumbs' => array( 'FIGURE', 'IMG' ),
) );

// Find EM inside FIGCAPTION inside FIGURE
$processor->next_tag( array(
    'breadcrumbs' => array( 'FIGURE', 'FIGCAPTION', 'EM' ),
) );
```

---

### next_token()

Advances to the next token in the HTML document.

```php
public function next_token(): bool
```

**Returns:** `true` if token found.

---

### step()

Runs one step of the tree construction algorithm.

```php
public function step( $node_to_process = self::PROCESS_NEXT_NODE ): bool
// Internally uses REPROCESS_CURRENT_NODE to re-dispatch tokens when switching insertion modes.
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$node_to_process` | string | Processing mode constant |

**Returns:** `true` if step succeeded.

---

### get_breadcrumbs()

Returns the stack of open element names from root to current.

```php
public function get_breadcrumbs(): array
```

**Returns:** Array of tag names (e.g., `['HTML', 'BODY', 'DIV', 'P']`).

**Example:**

```php
// For '<html><body><div><p>text</p></div></body></html>'
// When positioned on the P tag:
$breadcrumbs = $processor->get_breadcrumbs();
// Returns: ['HTML', 'BODY', 'DIV', 'P']
```

---

### matches_breadcrumbs()

Checks if the current position matches a breadcrumb pattern.

```php
public function matches_breadcrumbs( $breadcrumbs ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$breadcrumbs` | array | Expected ancestor path |

**Returns:** `true` if breadcrumbs match.

---

### get_current_depth()

Returns the nesting depth of the current element.

```php
public function get_current_depth(): int
```

**Returns:** Nesting depth (0 = document root).

---

### expects_closer()

Determines if a node expects a closing tag.

```php
public function expects_closer( ?WP_HTML_Token $node = null ): ?bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$node` | WP_HTML_Token\|null | Node to check (current if null) |

**Returns:** `true` if closer expected, `false` if void, `null` if unknown.

---

### is_tag_closer()

Returns whether the current tag is a closing tag.

```php
public function is_tag_closer(): bool
```

**Returns:** `true` for closing tags.

---

### get_tag()

Returns the uppercase tag name for the current match.

```php
public function get_tag(): ?string
```

**Returns:** Tag name or `null`.

---

### get_namespace()

Returns the namespace of the current element.

```php
public function get_namespace(): string
```

**Returns:** `"html"`, `"svg"`, or `"math"`.

---

### has_self_closing_flag()

Indicates if the current tag has the self-closing flag.

```php
public function has_self_closing_flag(): bool
```

**Returns:** `true` if flag present.

---

### get_token_name()

Returns the name of the current token.

```php
public function get_token_name(): ?string
```

**Returns:** Token name or `null`.

---

### get_token_type()

Returns the type of the current token.

```php
public function get_token_type(): ?string
```

**Returns:** Token type or `null`.

---

### get_attribute()

Returns the value of an attribute.

```php
public function get_attribute( $name )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Attribute name |

**Returns:** Attribute value, `true` for boolean, or `null`.

---

### set_attribute()

Sets an attribute on the current tag.

```php
public function set_attribute( $name, $value ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Attribute name |
| `$value` | string\|bool | Attribute value |

**Returns:** `true` if set successfully.

---

### remove_attribute()

Removes an attribute from the current tag.

```php
public function remove_attribute( $name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Attribute name |

**Returns:** `true` if removed.

---

### get_attribute_names_with_prefix()

Returns attribute names starting with a prefix.

```php
public function get_attribute_names_with_prefix( $prefix ): ?array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$prefix` | string | Attribute name prefix |

**Returns:** Array of matching names or `null`.

---

### add_class()

Adds a CSS class to the current tag.

```php
public function add_class( $class_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$class_name` | string | Class to add |

**Returns:** `true` if added.

---

### remove_class()

Removes a CSS class from the current tag.

```php
public function remove_class( $class_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$class_name` | string | Class to remove |

**Returns:** `true` if removed.

---

### has_class()

Checks if the current tag has a CSS class.

```php
public function has_class( $wanted_class ): ?bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$wanted_class` | string | Class to check |

**Returns:** `true`, `false`, or `null`.

---

### class_list()

Generator yielding all CSS classes.

```php
public function class_list()
```

---

### get_modifiable_text()

Returns the text content for the current token.

```php
public function get_modifiable_text(): string
```

**Returns:** Decoded text content.

---

### get_comment_type()

Returns the type of comment token.

```php
public function get_comment_type(): ?string
```

**Returns:** Comment type constant or `null`.

---

### serialize()

Serializes the processed HTML. This is defined natively on `WP_HTML_Processor` (not inherited).

```php
public function serialize(): ?string
```

**Returns:** Serialized HTML or `null` on failure.

**Note:** `get_updated_html()` is inherited from `WP_HTML_Tag_Processor` and also works. `serialize()` is the processor-native method that processes the entire document.

---

### serialize_token()

Serializes just the current token.

```php
public function serialize_token(): string
```

**Returns:** Serialized token HTML.

---

### set_bookmark()

Creates a named bookmark at the current position.

```php
public function set_bookmark( $bookmark_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$bookmark_name` | string | Bookmark name |

**Returns:** `true` if set.

---

### has_bookmark()

Checks if a bookmark exists.

```php
public function has_bookmark( $bookmark_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$bookmark_name` | string | Bookmark name |

**Returns:** `true` if exists.

---

### release_bookmark()

Releases a bookmark.

```php
public function release_bookmark( $bookmark_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$bookmark_name` | string | Bookmark name |

**Returns:** `true` if released.

---

### seek()

Moves to a bookmark position.

```php
public function seek( $bookmark_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$bookmark_name` | string | Bookmark name |

**Returns:** `true` if seek succeeded.

---

### get_last_error()

Returns the last error message.

```php
public function get_last_error(): ?string
```

**Returns:** Error message or `null`.

---

### get_unsupported_exception()

Returns the exception for unsupported markup.

```php
public function get_unsupported_exception()
```

**Returns:** `WP_HTML_Unsupported_Exception` or `null`.

---

## Insertion Mode Methods

These internal methods handle HTML5 tree construction. They are invoked by `step()`.

| Method | Insertion Mode |
|--------|----------------|
| `step_initial()` | Initial |
| `step_before_html()` | Before HTML |
| `step_before_head()` | Before HEAD |
| `step_in_head()` | In HEAD |
| `step_in_head_noscript()` | In HEAD NOSCRIPT |
| `step_after_head()` | After HEAD |
| `step_in_body()` | In BODY |
| `step_in_table()` | In TABLE |
| `step_in_table_text()` | In TABLE text |
| `step_in_caption()` | In CAPTION |
| `step_in_column_group()` | In COLGROUP |
| `step_in_table_body()` | In TBODY |
| `step_in_row()` | In TR |
| `step_in_cell()` | In TD/TH |
| `step_in_select()` | In SELECT |
| `step_in_select_in_table()` | In SELECT in TABLE |
| `step_in_template()` | In TEMPLATE |
| `step_after_body()` | After BODY |
| `step_in_frameset()` | In FRAMESET |
| `step_after_frameset()` | After FRAMESET |
| `step_after_after_body()` | After after BODY |
| `step_after_after_frameset()` | After after FRAMESET |
| `step_in_foreign_content()` | In foreign content |

---

## Usage Examples

### Structure-Aware Modification

```php
$html = '<article><figure><img src="cat.jpg"><figcaption>A cat</figcaption></figure></article>';
$processor = WP_HTML_Processor::create_fragment( $html );

// Only match IMG inside FIGURE
while ( $processor->next_tag( array( 'breadcrumbs' => array( 'FIGURE', 'IMG' ) ) ) ) {
    $processor->add_class( 'figure-image' );
    $processor->set_attribute( 'loading', 'lazy' );
}

echo $processor->get_updated_html();
```

### Walking the Document Tree

```php
$processor = WP_HTML_Processor::create_fragment( $html );

while ( $processor->next_token() ) {
    $depth = $processor->get_current_depth();
    $breadcrumbs = $processor->get_breadcrumbs();
    $name = $processor->get_token_name();
    
    echo str_repeat( '  ', $depth ) . $name . "\n";
}
```

### Normalizing HTML

```php
$messy = '<p>one<p>two</p><div>three';
$clean = WP_HTML_Processor::normalize( $messy );
// Returns properly nested HTML
```

### Checking Element Nesting

```php
$processor = WP_HTML_Processor::create_fragment( $html );

while ( $processor->next_tag( 'a' ) ) {
    // Check if link is inside a heading
    if ( $processor->matches_breadcrumbs( array( 'H1', 'A' ) ) ||
         $processor->matches_breadcrumbs( array( 'H2', 'A' ) ) ) {
        $processor->add_class( 'heading-link' );
    }
}
```
