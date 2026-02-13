# WP_HTML_Token

Represents a token in the HTML document for tracking in parser stacks.

**Source:** `wp-includes/html-api/class-wp-html-token.php`  
**Since:** 6.4.0  
**Access:** private

---

## Properties

### bookmark_name

```php
public $bookmark_name = null;
```

Type: `string` (source docblock declares `@var string`, though default value is `null`)

Name of bookmark corresponding to this token's location in the input HTML. A `null` value indicates a marker or virtual node without a bookmark.

Note: Having a bookmark name does not guarantee the token still exists — the source may have been modified.

---

### node_name

```php
public $node_name = null;
```

Type: `string|null`

Name of the node. Uppercase names are HTML elements (e.g., `"DIV"`). Lowercase names are special values (e.g., `"marker"`).

---

### has_self_closing_flag

```php
public $has_self_closing_flag = false;
```

Type: `bool`

Whether the token has the self-closing flag (`/>`). This reports presence of the flag, not whether the element is actually void.

---

### namespace

```php
public $namespace = 'html';
```

Type: `string`  
**Since:** 6.7.0

Indicates the element's namespace: `"html"`, `"svg"`, or `"math"`.

---

### integration_node_type

```php
public $integration_node_type = null;
```

Type: `string|null`  
**Since:** 6.7.0

Indicates the type of integration point: `"math"`, `"html"`, or `null` if not an integration point.

---

### on_destroy

```php
public $on_destroy = null;
```

Type: `callable|null`

Callback invoked when the token is garbage-collected. Typically used to release associated bookmarks.

---

## Methods

### __construct()

Creates a token reference.

```php
public function __construct(
    ?string $bookmark_name,
    string $node_name,
    bool $has_self_closing_flag,
    ?callable $on_destroy = null
)
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$bookmark_name` | string\|null | Bookmark name or `null` for markers |
| `$node_name` | string | Node name (uppercase for elements) |
| `$has_self_closing_flag` | bool | Whether self-closing flag present |
| `$on_destroy` | callable\|null | Cleanup callback |

**Example:**

```php
// Create a token for a DIV element
$token = new WP_HTML_Token(
    'bookmark_123',
    'DIV',
    false,
    function( $bookmark_name ) use ( $processor ) {
        $processor->release_bookmark( $bookmark_name );
    }
);

// Create a marker (no bookmark)
$marker = new WP_HTML_Token( null, 'marker', false );
```

---

### __destruct()

Destructor that invokes the on_destroy callback.

```php
public function __destruct()
```

When the token is garbage-collected, the destructor calls the `on_destroy` callback with the bookmark name, allowing automatic bookmark cleanup.

---

### __wakeup()

Prevents unserialization for security.

```php
public function __wakeup()
```

**Throws:** `LogicException`

---

## Usage Examples

### Creating Element Tokens

```php
// Token for an HTML element
$div = new WP_HTML_Token( 'bk_1', 'DIV', false );

// Token for a void element with self-closing flag
$img = new WP_HTML_Token( 'bk_2', 'IMG', true );

// Token in SVG namespace
$rect = new WP_HTML_Token( 'bk_3', 'rect', false );
$rect->namespace = 'svg';
```

### Creating Markers

```php
// Markers use lowercase names and no bookmark
$marker = new WP_HTML_Token( null, 'marker', false );
```

### With Cleanup Callback

```php
$processor = new WP_HTML_Tag_Processor( $html );
$processor->next_tag( 'div' );
$processor->set_bookmark( 'my-div' );

$token = new WP_HTML_Token(
    'my-div',
    'DIV',
    false,
    function( $bookmark_name ) use ( $processor ) {
        // Automatically release bookmark when token is destroyed
        $processor->release_bookmark( $bookmark_name );
    }
);

// When $token goes out of scope, the bookmark is released
```

---

## Node Name Conventions

| Pattern | Meaning | Example |
|---------|---------|---------|
| Uppercase | HTML element | `"DIV"`, `"P"`, `"SPAN"` |
| Lowercase | Special value | `"marker"`, `"#text"` |

---

## Integration Points

Integration points are elements in foreign content (SVG/MathML) where HTML parsing rules apply:

| Type | Description |
|------|-------------|
| `"math"` | MathML integration point |
| `"html"` | HTML integration point in foreign content |
| `null` | Not an integration point |

MathML integration points: `mi`, `mo`, `mn`, `ms`, `mtext`

HTML integration points: `annotation-xml` (with specific conditions), SVG `foreignObject`, `desc`, `title`
