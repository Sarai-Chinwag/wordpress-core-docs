# WP_HTML_Active_Formatting_Elements

List of active formatting elements for handling mis-nested formatting tags.

**Source:** `wp-includes/html-api/class-wp-html-active-formatting-elements.php`  
**Since:** 6.4.0  
**Access:** private

---

## Overview

The active formatting elements list handles cases where formatting elements are improperly nested in HTML. For example:

```html
<p><b>Bold <i>Bold-Italic</b> Italic</i></p>
```

In a proper tree, the `</b>` cannot close the `<b>` because `<i>` is still open. The active formatting elements list helps reconstruct the proper formatting after such cases.

Markers are inserted when entering certain elements (APPLET, OBJECT, MARQUEE, TEMPLATE, TD, TH, CAPTION) to prevent formatting from "leaking" across element boundaries.

---

## Methods

### count()

Returns the number of elements in the list.

```php
public function count()
```

**Returns:** Number of elements.

---

### current_node()

Returns the last element in the list.

```php
public function current_node()
```

**Returns:** `WP_HTML_Token|null` — Last element or `null` if empty.

---

### contains_node()

Checks if a specific token is in the list.

```php
public function contains_node( WP_HTML_Token $token )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | WP_HTML_Token | Token to find |

**Returns:** `bool` — `true` if found.

---

### push()

Adds an element to the list.

```php
public function push( WP_HTML_Token $token )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | WP_HTML_Token | Token to add |

Implements the "Noah's Ark clause" — if there are already three elements with the same tag name, namespace, and attributes after the last marker, the earliest one is removed before adding the new element.

---

### insert_marker()

Inserts a marker into the list.

```php
public function insert_marker(): void
```

Markers prevent formatting from leaking across element boundaries. They are inserted when entering:
- APPLET
- OBJECT
- MARQUEE
- TEMPLATE
- TD
- TH
- CAPTION

---

### remove_node()

Removes a specific token from the list.

```php
public function remove_node( WP_HTML_Token $token )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | WP_HTML_Token | Token to remove |

**Returns:** `bool` — `true` if found and removed.

---

### clear_up_to_last_marker()

Removes all elements up to and including the last marker.

```php
public function clear_up_to_last_marker(): void
```

Called when leaving elements that insert markers (APPLET, OBJECT, etc.) to clean up any formatting elements that were opened inside.

---

### walk_down()

Generator that walks from first (oldest) to last (newest).

```php
public function walk_down()
```

**Example:**

```php
// For '<em><strong><a>'
foreach ( $list->walk_down() as $node ) {
    echo $node->node_name . ' -> ';
}
// Output: EM -> STRONG -> A ->
```

---

### walk_up()

Generator that walks from last (newest) to first (oldest).

```php
public function walk_up()
```

**Example:**

```php
// For '<em><strong><a>'
foreach ( $list->walk_up() as $node ) {
    echo $node->node_name . ' -> ';
}
// Output: A -> STRONG -> EM ->
```

---

## Formatting Elements

The following elements are added to the active formatting elements list:

- A (anchor)
- B (bold)
- BIG
- CODE
- EM (emphasis)
- FONT
- I (italic)
- NOBR
- S (strikethrough)
- SMALL
- STRIKE
- STRONG
- TT (teletype)
- U (underline)

---

## Usage Example

```php
$list = new WP_HTML_Active_Formatting_Elements();

// Parsing '<td><b><i>' — marker inserted for TD
$list->insert_marker();
$list->push( new WP_HTML_Token( 'bk1', 'B', false ) );
$list->push( new WP_HTML_Token( 'bk2', 'I', false ) );

// List: [marker, B, I]
echo $list->count(); // 3

// Leaving TD — clear back to marker
$list->clear_up_to_last_marker();

// List is now empty
echo $list->count(); // 0
```

---

## Reconstruction Algorithm

When the parser needs to reconstruct active formatting elements (e.g., after text or a new element):

1. If the list is empty, or the last entry is a marker, or the last entry is already on the stack of open elements, stop.
2. Let entry be the last entry in the list.
3. Rewind: If entry is not the first entry and the entry before it is neither a marker nor in the stack, let entry be that previous entry and repeat step 3.
4. Advance: Create an element for the token for which entry was created, append it to the current node, push it onto the stack, and replace entry with a new entry for this element.
5. If entry is not the last entry in the list, go to step 4.

This ensures formatting is properly re-applied after being interrupted.
