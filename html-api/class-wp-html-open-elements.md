# WP_HTML_Open_Elements

Stack of open elements used during HTML parsing for tree construction.

**Source:** `wp-includes/html-api/class-wp-html-open-elements.php`  
**Since:** 6.4.0  
**Access:** private

---

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$stack` | WP_HTML_Token[] | public | Array of open element tokens |

---

## Methods

### Stack Access

#### at()

Returns the token at the nth position from the top.

```php
public function at( int $nth ): ?WP_HTML_Token
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$nth` | int | 1-based position (1 = top) |

**Returns:** Token at position or `null`.

---

#### current_node()

Returns the most recently added element.

```php
public function current_node(): ?WP_HTML_Token
```

**Returns:** Last token on stack or `null`.

---

#### current_node_is()

Checks if the current node matches a name or type.

```php
public function current_node_is( string $identity ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$identity` | string | Tag name or type (e.g., `"DIV"`, `"#text"`, `"#tag"`) |

**Returns:** `true` if current node matches.

---

#### count()

Returns the number of elements on the stack.

```php
public function count(): int
```

**Returns:** Stack size.

---

### Stack Searching

#### contains()

Checks if a node name is in the stack.

```php
public function contains( string $node_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$node_name` | string | Tag name to find |

**Returns:** `true` if found.

---

#### contains_node()

Checks if a specific token is in the stack.

```php
public function contains_node( WP_HTML_Token $token ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | WP_HTML_Token | Token to find |

**Returns:** `true` if found.

---

### Scope Checking

#### has_element_in_scope()

Checks if an element is in general scope.

```php
public function has_element_in_scope( string $tag_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag_name` | string | Tag name to find |

**Returns:** `true` if in scope.

Scope terminators: APPLET, CAPTION, HTML, TABLE, TD, TH, MARQUEE, OBJECT, TEMPLATE, MathML elements, SVG elements.

---

#### has_element_in_list_item_scope()

Checks if an element is in list item scope.

```php
public function has_element_in_list_item_scope( string $tag_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag_name` | string | Tag name to find |

**Returns:** `true` if in list item scope.

Additional terminators: OL, UL.

---

#### has_element_in_button_scope()

Checks if an element is in button scope.

```php
public function has_element_in_button_scope( string $tag_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag_name` | string | Tag name to find |

**Returns:** `true` if in button scope.

Additional terminator: BUTTON.

---

#### has_element_in_table_scope()

Checks if an element is in table scope.

```php
public function has_element_in_table_scope( string $tag_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag_name` | string | Tag name to find |

**Returns:** `true` if in table scope.

Terminators: HTML, TABLE, TEMPLATE only.

---

#### has_element_in_select_scope()

Checks if an element is in select scope.

```php
public function has_element_in_select_scope( string $tag_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag_name` | string | Tag name to find |

**Returns:** `true` if in select scope.

Only OPTION and OPTGROUP do NOT terminate scope.

---

#### has_p_in_button_scope()

Checks if a P element is in button scope (optimized).

```php
public function has_p_in_button_scope(): bool
```

**Returns:** `true` if P in button scope.

This is pre-calculated for performance.

---

#### has_element_in_specific_scope()

General scope check with custom termination list.

```php
public function has_element_in_specific_scope( string $tag_name, $termination_list ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag_name` | string | Tag name to find |
| `$termination_list` | string[] | Elements that terminate the search |

**Returns:** `true` if element found before terminator.

---

### Stack Modification

#### push()

Pushes an element onto the stack.

```php
public function push( WP_HTML_Token $stack_item ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$stack_item` | WP_HTML_Token | Token to add |

---

#### pop()

Pops the top element from the stack.

```php
public function pop(): bool
```

**Returns:** `true` if element was popped.

---

#### pop_until()

Pops elements until a specific tag is popped.

```php
public function pop_until( string $html_tag_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$html_tag_name` | string | Tag name to pop to |

**Returns:** `true` if tag was found and popped.

---

#### remove_node()

Removes a specific node from anywhere in the stack.

```php
public function remove_node( WP_HTML_Token $token ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | WP_HTML_Token | Token to remove |

**Returns:** `true` if removed.

---

### Table Context Clearing

#### clear_to_table_context()

Clears stack to TABLE, TEMPLATE, or HTML element.

```php
public function clear_to_table_context(): void
```

---

#### clear_to_table_body_context()

Clears stack to TBODY, TFOOT, THEAD, TEMPLATE, or HTML element.

```php
public function clear_to_table_body_context(): void
```

---

#### clear_to_table_row_context()

Clears stack to TR, TEMPLATE, or HTML element.

```php
public function clear_to_table_row_context(): void
```

---

### Stack Traversal

#### walk_down()

Generator that walks from first added (top) to last added (bottom).

```php
public function walk_down()
```

**Example:**

```php
// For '<em><strong><a>text'
foreach ( $stack->walk_down() as $node ) {
    echo $node->node_name . ' -> ';
}
// Output: EM -> STRONG -> A ->
```

---

#### walk_up()

Generator that walks from last added (bottom) to first added (top).

```php
public function walk_up( ?WP_HTML_Token $above_this_node = null )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$above_this_node` | WP_HTML_Token\|null | Start above this node |

**Example:**

```php
// For '<em><strong><a>text'
foreach ( $stack->walk_up() as $node ) {
    echo $node->node_name . ' -> ';
}
// Output: A -> STRONG -> EM ->
```

---

### Event Handlers

#### set_push_handler()

Sets a callback for when elements are pushed.

```php
public function set_push_handler( Closure $handler ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handler` | Closure | Called with pushed token |

---

#### set_pop_handler()

Sets a callback for when elements are popped.

```php
public function set_pop_handler( Closure $handler ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handler` | Closure | Called with popped token |

---

### Internal Methods

#### after_element_push()

Updates internal state after push.

```php
public function after_element_push( WP_HTML_Token $item ): void
```

Updates `has_p_in_button_scope` cache and calls push handler.

---

#### after_element_pop()

Updates internal state after pop.

```php
public function after_element_pop( WP_HTML_Token $item ): void
```

Updates `has_p_in_button_scope` cache and calls pop handler.

---

### Security

#### __wakeup()

Prevents unserialization.

```php
public function __wakeup()
```

**Throws:** `LogicException`

---

## Scope Termination Reference

| Scope Type | Terminating Elements |
|------------|---------------------|
| General | APPLET, CAPTION, HTML, TABLE, TD, TH, MARQUEE, OBJECT, TEMPLATE, MathML (mi, mo, mn, ms, mtext, annotation-xml), SVG (foreignObject, desc, title) |
| List Item | General + OL, UL |
| Button | General + BUTTON |
| Table | HTML, TABLE, TEMPLATE |
| Select | Everything except OPTION, OPTGROUP |

---

## Usage Example

```php
$stack = new WP_HTML_Open_Elements();

// Set up handlers for tracking
$stack->set_push_handler( function( $token ) {
    echo "Opened: {$token->node_name}\n";
} );

$stack->set_pop_handler( function( $token ) {
    echo "Closed: {$token->node_name}\n";
} );

// Simulate parsing '<div><p>text</p></div>'
$stack->push( new WP_HTML_Token( 'bk1', 'DIV', false ) );
$stack->push( new WP_HTML_Token( 'bk2', 'P', false ) );

// Check scope
$stack->has_element_in_scope( 'P' );     // true
$stack->has_p_in_button_scope();         // true

// Pop P
$stack->pop();

// P is no longer in scope
$stack->has_element_in_scope( 'P' );     // false
```
