# WP_HTML_Tag_Processor

Linear HTML scanner for finding and modifying HTML tags and their attributes.

**Source:** `wp-includes/html-api/class-wp-html-tag-processor.php`  
**Since:** 6.2.0

## Constants

### Bookmarks & Limits

| Constant | Value | Description |
|----------|-------|-------------|
| `MAX_BOOKMARKS` | `10` | Maximum bookmarks allowed |
| `MAX_SEEK_OPS` | `1000` | Maximum seek operations (prevents infinite loops) |

### Class Operations

| Constant | Value | Description |
|----------|-------|-------------|
| `ADD_CLASS` | `true` | Add a CSS class |
| `REMOVE_CLASS` | `false` | Remove a CSS class |
| `SKIP_CLASS` | `null` | Skip class modification |

### Parser States

| Constant | Description |
|----------|-------------|
| `STATE_READY` | Parser ready to run |
| `STATE_COMPLETE` | Nothing left to parse |
| `STATE_INCOMPLETE_INPUT` | HTML ended mid-token |
| `STATE_MATCHED_TAG` | Found an HTML tag |
| `STATE_TEXT_NODE` | Found a text node |
| `STATE_CDATA_NODE` | Found CDATA section |
| `STATE_COMMENT` | Found a comment |
| `STATE_DOCTYPE` | Found DOCTYPE declaration |
| `STATE_PRESUMPTUOUS_TAG` | Found empty end tag `</>` |
| `STATE_FUNKY_COMMENT` | Invalid closer became comment |

### Comment Types

| Constant | Description |
|----------|-------------|
| `COMMENT_AS_ABRUPTLY_CLOSED_COMMENT` | Comment closed abruptly `<!-->` or `<!--->` |
| `COMMENT_AS_CDATA_LOOKALIKE` | Bogus CDATA `<![CDATA[...]]>` |
| `COMMENT_AS_HTML_COMMENT` | Standard comment `<!-- ... -->` |
| `COMMENT_AS_PI_NODE_LOOKALIKE` | Processing instruction `<?...?>` |
| `COMMENT_AS_INVALID_HTML` | Invalid comment-like markup |

### Document Modes

| Constant | Description |
|----------|-------------|
| `NO_QUIRKS_MODE` | Standards mode |
| `QUIRKS_MODE` | Quirks mode |

### Text Classifications

| Constant | Description |
|----------|-------------|
| `TEXT_IS_GENERIC` | Normal text content |
| `TEXT_IS_NULL_SEQUENCE` | Text contains only NULL bytes |
| `TEXT_IS_WHITESPACE` | Text is only whitespace |

---

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$html` | string | protected | Input HTML document |
| `$parser_state` | string | protected | Current parser state |
| `$compat_mode` | string | protected | Document compatibility mode |
| `$comment_type` | string\|null | protected | Type of comment if matched |
| `$text_node_classification` | string | protected | Classification of matched text |
| `$bookmarks` | WP_HTML_Span[] | protected | Named bookmark positions |
| `$lexical_updates` | WP_HTML_Text_Replacement[] | protected | Pending text replacements |
| `$seek_count` | int | protected | Number of seek operations performed |

---

## Methods

### __construct()

Creates a new HTML Tag Processor instance.

```php
public function __construct( $html )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$html` | string | HTML to process |

---

### next_tag()

Finds the next tag matching the query.

```php
public function next_tag( $query = null ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | array\|string\|null | Search criteria |

**Query Options:**

| Key | Type | Description |
|-----|------|-------------|
| `tag_name` | string\|null | Tag name to find |
| `match_offset` | int\|null | Nth matching tag (1-based) |
| `class_name` | string\|null | Required CSS class |
| `tag_closers` | string\|null | `"visit"` or `"skip"` closing tags |

**Returns:** `true` if tag found, `false` otherwise.

**Example:**

```php
$processor = new WP_HTML_Tag_Processor( $html );

// Find any tag
$processor->next_tag();

// Find by tag name
$processor->next_tag( 'img' );
$processor->next_tag( array( 'tag_name' => 'img' ) );

// Find by class
$processor->next_tag( array( 'class_name' => 'featured' ) );

// Find third DIV with class
$processor->next_tag( array(
    'tag_name'     => 'div',
    'class_name'   => 'card',
    'match_offset' => 3,
) );

// Include closing tags
$processor->next_tag( array( 'tag_closers' => 'visit' ) );
```

---

### next_token()

Finds the next token in the HTML document.

```php
public function next_token(): bool
```

**Returns:** `true` if token found, `false` otherwise.

Tokens include tags, text nodes, comments, DOCTYPE declarations, and processing instructions.

**Example:**

```php
while ( $processor->next_token() ) {
    switch ( $processor->get_token_name() ) {
        case '#text':
            $text = $processor->get_modifiable_text();
            break;
        case 'DIV':
            // Found a DIV tag
            break;
    }
}
```

---

### paused_at_incomplete_token()

Indicates whether parsing stopped due to incomplete input.

```php
public function paused_at_incomplete_token(): bool
```

**Returns:** `true` if paused at incomplete token.

---

### get_tag()

Returns the uppercase tag name of the matched tag.

```php
public function get_tag(): ?string
```

**Returns:** Tag name (e.g., `"DIV"`) or `null` if not on a tag.

---

### get_qualified_tag_name()

Returns the qualified tag name including namespace prefix.

```php
public function get_qualified_tag_name(): ?string
```

**Returns:** Qualified name (e.g., `"svg:rect"`) or `null`.

---

### get_namespace()

Returns the namespace of the current token.

```php
public function get_namespace(): string
```

**Returns:** One of `"html"`, `"svg"`, or `"math"`.

---

### change_parsing_namespace()

Switches parsing into a different namespace.

```php
public function change_parsing_namespace( string $new_namespace ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$new_namespace` | string | `"html"`, `"svg"`, or `"math"` |

**Returns:** `true` if namespace changed successfully.

---

### is_tag_closer()

Returns whether the current tag is a closing tag.

```php
public function is_tag_closer(): bool
```

**Returns:** `true` for closing tags like `</div>`.

---

### has_self_closing_flag()

Indicates if the tag has the self-closing flag (`/>`).

```php
public function has_self_closing_flag(): bool
```

**Returns:** `true` if self-closing flag present.

Note: This reports the flag's presence, not whether the element is actually void.

---

### get_token_type()

Returns the type of the current token.

```php
public function get_token_type(): ?string
```

**Returns:** One of `"#tag"`, `"#text"`, `"#cdata-section"`, `"#comment"`, `"#doctype"`, `"#presumptuous-tag"`, `"#funky-comment"`, or `null`.

---

### get_token_name()

Returns the name of the current token.

```php
public function get_token_name(): ?string
```

**Returns:** Tag name for tags, `"#text"` for text, `"#comment"` for comments, etc.

---

### get_comment_type()

Returns the type of comment for comment tokens.

```php
public function get_comment_type(): ?string
```

**Returns:** One of the `COMMENT_AS_*` constants or `null`.

---

### get_full_comment_text()

Returns the full comment text including delimiters.

```php
public function get_full_comment_text(): ?string
```

**Returns:** Complete comment string or `null`.

---

### get_attribute()

Returns the value of an attribute on the current tag.

```php
public function get_attribute( $name )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Attribute name (case-insensitive) |

**Returns:**
- `string` — Attribute value
- `true` — Boolean attribute present
- `null` — Attribute not present

**Example:**

```php
$src = $processor->get_attribute( 'src' );
$disabled = $processor->get_attribute( 'disabled' ); // true or null
```

---

### get_qualified_attribute_name()

Returns the qualified attribute name with namespace prefix.

```php
public function get_qualified_attribute_name( $attribute_name ): ?string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$attribute_name` | string | Attribute name |

**Returns:** Qualified name (e.g., `"xlink:href"`) or `null`.

---

### get_attribute_names_with_prefix()

Returns attribute names that start with a given prefix.

```php
public function get_attribute_names_with_prefix( $prefix ): ?array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$prefix` | string | Attribute name prefix |

**Returns:** Array of matching attribute names or `null`.

**Example:**

```php
// Get all data-* attributes
$data_attrs = $processor->get_attribute_names_with_prefix( 'data-' );
```

---

### set_attribute()

Sets or updates an attribute on the current tag.

```php
public function set_attribute( $name, $value ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Attribute name |
| `$value` | string\|bool | Attribute value (`true` for boolean, `false` to remove) |

**Returns:** `true` if attribute was set.

Handles HTML encoding automatically.

**Example:**

```php
$processor->set_attribute( 'class', 'featured' );
$processor->set_attribute( 'disabled', true );  // <button disabled>
$processor->set_attribute( 'disabled', false ); // removes attribute
```

---

### remove_attribute()

Removes an attribute from the current tag.

```php
public function remove_attribute( $name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Attribute name |

**Returns:** `true` if attribute was removed.

---

### add_class()

Adds a CSS class to the current tag.

```php
public function add_class( $class_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$class_name` | string | Class name to add |

**Returns:** `true` if class was added.

Safe to call multiple times; preserves existing classes.

---

### remove_class()

Removes a CSS class from the current tag.

```php
public function remove_class( $class_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$class_name` | string | Class name to remove |

**Returns:** `true` if class was removed.

Removes the `class` attribute entirely if the last class is removed.

---

### has_class()

Checks if the current tag has a specific CSS class.

```php
public function has_class( $wanted_class ): ?bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$wanted_class` | string | Class name to check |

**Returns:** `true` if class present, `false` if not, `null` if not on a tag.

---

### class_list()

Generator yielding all CSS classes on the current tag.

```php
public function class_list()
```

**Example:**

```php
foreach ( $processor->class_list() as $class ) {
    echo $class;
}
```

---

### get_modifiable_text()

Returns the decoded text content for the current token.

```php
public function get_modifiable_text(): string
```

**Returns:** Decoded text content.

Works for text nodes, comments, SCRIPT/STYLE contents, TITLE/TEXTAREA contents.

---

### set_modifiable_text()

Sets the text content for the current token.

```php
public function set_modifiable_text( string $plaintext_content ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plaintext_content` | string | New text content (unescaped) |

**Returns:** `true` if text was updated.

Handles HTML encoding automatically. Some content restrictions apply (e.g., can't insert `</script` into SCRIPT).

---

### subdivide_text_appropriately()

Subdivides the current text node for specialized processing.

```php
public function subdivide_text_appropriately(): bool
```

**Returns:** `true` if subdivision occurred.

---

### set_bookmark()

Creates a named bookmark at the current position.

```php
public function set_bookmark( $name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Bookmark name |

**Returns:** `true` if bookmark was set.

---

### has_bookmark()

Checks if a bookmark exists.

```php
public function has_bookmark( $bookmark_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$bookmark_name` | string | Bookmark name |

**Returns:** `true` if bookmark exists.

---

### release_bookmark()

Releases a bookmark.

```php
public function release_bookmark( $name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Bookmark name |

**Returns:** `true` if bookmark was released.

---

### seek()

Moves the processor to a bookmark position.

```php
public function seek( $bookmark_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$bookmark_name` | string | Bookmark name |

**Returns:** `true` if seek succeeded.

Limited by `MAX_SEEK_OPS` to prevent infinite loops.

---

### get_updated_html()

Returns the processed HTML with all modifications applied.

```php
public function get_updated_html(): string
```

**Returns:** Modified HTML document.

---

### __toString()

Converts the processor to its updated HTML string.

```php
public function __toString(): string
```

**Returns:** Same as `get_updated_html()`.

---

### get_doctype_info()

Returns DOCTYPE information for the current DOCTYPE token.

```php
public function get_doctype_info(): ?WP_HTML_Doctype_Info
```

**Returns:** `WP_HTML_Doctype_Info` instance or `null`.

---

## Usage Examples

### Lazy Loading Images

```php
$processor = new WP_HTML_Tag_Processor( $html );
while ( $processor->next_tag( 'img' ) ) {
    if ( null === $processor->get_attribute( 'loading' ) ) {
        $processor->set_attribute( 'loading', 'lazy' );
    }
}
echo $processor->get_updated_html();
```

### Adding Classes Based on Attributes

```php
$processor = new WP_HTML_Tag_Processor( $html );
while ( $processor->next_tag( 'a' ) ) {
    $href = $processor->get_attribute( 'href' );
    if ( $href && str_starts_with( $href, 'http' ) ) {
        $processor->add_class( 'external-link' );
        $processor->set_attribute( 'target', '_blank' );
    }
}
```

### Processing All Tokens

```php
$processor = new WP_HTML_Tag_Processor( $html );
while ( $processor->next_token() ) {
    $type = $processor->get_token_type();
    $name = $processor->get_token_name();
    
    if ( '#text' === $type ) {
        $text = $processor->get_modifiable_text();
        // Process text...
    }
}
```

### Using Bookmarks

```php
$processor = new WP_HTML_Tag_Processor( $html );
while ( $processor->next_tag( 'ul' ) ) {
    $processor->set_bookmark( 'list-start' );
    $count = 0;
    
    while ( $processor->next_tag( array( 'tag_closers' => 'visit' ) ) ) {
        if ( 'LI' === $processor->get_tag() && ! $processor->is_tag_closer() ) {
            $count++;
        }
        if ( 'UL' === $processor->get_tag() && $processor->is_tag_closer() ) {
            break;
        }
    }
    
    $processor->seek( 'list-start' );
    $processor->set_attribute( 'data-count', (string) $count );
    $processor->release_bookmark( 'list-start' );
}
```
