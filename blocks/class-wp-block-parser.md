# WP_Block_Parser

Parses a document and constructs a list of parsed block objects.

**Since:** 5.0.0  
**Source:** `wp-includes/class-wp-block-parser.php`

## Description

`WP_Block_Parser` tokenizes HTML content containing block comment delimiters and builds a tree of block structures. The parser handles nested blocks, void blocks, and freeform content.

## Related Classes

- **WP_Block_Parser_Block** - Holds block structure data
- **WP_Block_Parser_Frame** - Stack frame during parsing

## Properties

### $document

Input document being parsed.

```php
public string $document
```

**Example:** `"Pre-text\n<!-- wp:paragraph -->This is inside a block!<!-- /wp:paragraph -->"`

**Since:** 5.0.0

---

### $offset

Tracks parsing progress through document.

```php
public int $offset
```

**Since:** 5.0.0

---

### $output

List of parsed blocks.

```php
public array[] $output
```

**Since:** 5.0.0

---

### $stack

Stack of partially-parsed structures during parse.

```php
public WP_Block_Parser_Frame[] $stack
```

**Since:** 5.0.0

---

## Methods

### parse()

Parses a document and returns a list of block structures.

```php
public function parse( string $document ): array[]
```

**Parameters:**
- `$document` *(string)* - Input document

**Returns:** *(array[])* - Array of parsed block structures

**Since:** 5.0.0

Returns best-effort parse on invalid input (does not throw errors).

**Example:**
```php
$parser = new WP_Block_Parser();
$blocks = $parser->parse( $post->post_content );

foreach ( $blocks as $block ) {
    echo $block['blockName'] . "\n";
}
```

---

### proceed()

Processes the next token and returns whether to continue.

```php
public function proceed(): bool
```

**Returns:** *(bool)* - Whether to continue processing tokens

**Since:** 5.0.0  
**Access:** Internal

Token types handled:
- `no-more-tokens` - End of document
- `void-block` - Self-closing block (`<!-- wp:name /-->`)
- `block-opener` - Opening block tag (`<!-- wp:name -->`)
- `block-closer` - Closing block tag (`<!-- /wp:name -->`)

---

### next_token()

Scans document for the next valid token.

```php
public function next_token(): array
```

**Returns:** *(array)* - Token info: `[ type, block_name, attrs, start_offset, length ]`

**Since:** 5.0.0  
**Since:** 4.6.1 - Fixed catastrophic backtracking bug  
**Access:** Internal

**Token Types:**
- `no-more-tokens` - No more tokens found
- `void-block` - Self-closing block
- `block-opener` - Opening delimiter
- `block-closer` - Closing delimiter

---

### freeform()

Returns a new block object for freeform HTML.

```php
public function freeform( string $inner_html ): WP_Block_Parser_Block
```

**Parameters:**
- `$inner_html` *(string)* - HTML content

**Returns:** *(WP_Block_Parser_Block)* - Freeform block with null `blockName`

**Since:** 5.0.0  
**Access:** Internal

---

### add_freeform()

Pushes freeform text from document to output.

```php
public function add_freeform( int|null $length = null ): void
```

**Parameters:**
- `$length` *(int|null)* - Bytes to output (defaults to remaining document)

**Since:** 5.0.0  
**Access:** Internal

---

### add_inner_block()

Adds a block as inner block of current stack top.

```php
public function add_inner_block(
    WP_Block_Parser_Block $block,
    int $token_start,
    int $token_length,
    int|null $last_offset = null
): void
```

**Parameters:**
- `$block` *(WP_Block_Parser_Block)* - Block to add
- `$token_start` *(int)* - Byte offset of first token
- `$token_length` *(int)* - Total byte length
- `$last_offset` *(int|null)* - Last offset for continuation

**Since:** 5.0.0  
**Access:** Internal

---

### add_block_from_stack()

Pushes top block from stack to output.

```php
public function add_block_from_stack( int|null $end_offset = null ): void
```

**Parameters:**
- `$end_offset` *(int|null)* - Where to stop outputting HTML

**Since:** 5.0.0  
**Access:** Internal

---

## WP_Block_Parser_Block

Holds the block structure in memory.

**Since:** 5.0.0  
**Source:** `wp-includes/class-wp-block-parser-block.php`

### Properties

```php
public string|null $blockName;    // Block name, e.g., "core/paragraph"
public array|null  $attrs;        // Attributes from comment delimiters
public array       $innerBlocks;  // List of inner blocks
public string      $innerHTML;    // HTML after removing inner blocks
public array       $innerContent; // String fragments and null markers
```

### Constructor

```php
public function __construct(
    string|null $name,
    array|null $attrs,
    array $inner_blocks,
    string $inner_html,
    array $inner_content
)
```

**Example:**
```php
$block = new WP_Block_Parser_Block(
    'core/paragraph',
    array( 'align' => 'center' ),
    array(),
    '<p class="has-text-align-center">Hello</p>',
    array( '<p class="has-text-align-center">Hello</p>' )
);
```

---

## WP_Block_Parser_Frame

Stack frame during parsing.

**Since:** 5.0.0  
**Source:** `wp-includes/class-wp-block-parser-frame.php`

### Properties

```php
public WP_Block_Parser_Block $block;           // Block being built
public int                   $token_start;     // Byte offset of opener
public int                   $token_length;    // Opener token length
public int                   $prev_offset;     // Offset after last inner
public int|null              $leading_html_start; // Leading HTML start
```

---

## Parsing Example

### Input

```html
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Hello World</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:image {"id":123} /-->

Regular HTML content
```

### Output Structure

```php
array(
    // Group block with nested paragraph
    array(
        'blockName'    => 'core/group',
        'attrs'        => array( 'layout' => array( 'type' => 'constrained' ) ),
        'innerBlocks'  => array(
            array(
                'blockName'    => 'core/paragraph',
                'attrs'        => array( 'align' => 'center' ),
                'innerBlocks'  => array(),
                'innerHTML'    => '<p class="has-text-align-center">Hello World</p>',
                'innerContent' => array( '<p class="has-text-align-center">Hello World</p>' ),
            ),
        ),
        'innerHTML'    => '<div class="wp-block-group">\n\n</div>',
        'innerContent' => array(
            '<div class="wp-block-group">\n',
            null,  // Marks inner block position
            '\n</div>',
        ),
    ),
    
    // Void image block
    array(
        'blockName'    => 'core/image',
        'attrs'        => array( 'id' => 123 ),
        'innerBlocks'  => array(),
        'innerHTML'    => '',
        'innerContent' => array(),
    ),
    
    // Freeform content (classic/no block)
    array(
        'blockName'    => null,
        'attrs'        => array(),
        'innerBlocks'  => array(),
        'innerHTML'    => '\n\nRegular HTML content',
        'innerContent' => array( '\n\nRegular HTML content' ),
    ),
)
```

---

## Block Comment Syntax

### Basic Block

```html
<!-- wp:namespace/block-name {"attr":"value"} -->
<div>Content</div>
<!-- /wp:namespace/block-name -->
```

### Void Block (Self-Closing)

```html
<!-- wp:namespace/block-name {"attr":"value"} /-->
```

### Core Block (Shorthand)

Core blocks can omit the namespace:

```html
<!-- wp:paragraph -->
<p>Hello</p>
<!-- /wp:paragraph -->
```

Internally stored as `core/paragraph`.

### Attributes Format

JSON object immediately after block name:

```html
<!-- wp:image {"id":123,"sizeSlug":"large","linkDestination":"none"} -->
```

---

## Custom Parser

Replace the parser via filter:

```php
add_filter( 'block_parser_class', function() {
    return 'My_Custom_Block_Parser';
} );

class My_Custom_Block_Parser extends WP_Block_Parser {
    public function parse( $document ) {
        // Custom parsing logic
        return parent::parse( $document );
    }
}
```

---

## Performance Considerations

- Parser runs on every page load for posts with blocks
- `parse_blocks()` can be memory-intensive for large documents
- Consider `WP_Block_Processor` for streaming/low-overhead block finding
- Results are not cached by default

```php
// For simple block detection, use has_block() instead of full parse
if ( has_block( 'core/gallery', $post ) ) {
    // More efficient than parsing entire document
}
```
