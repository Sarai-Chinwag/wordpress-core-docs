# Interactivity API Directives

All `data-wp-*` directive attributes processed by the Interactivity API.

**Source:** `wp-includes/interactivity-api/class-wp-interactivity-api.php`  
**Since:** 6.5.0

## Directive Syntax

```
data-wp-{directive}[--{suffix}][---{unique-id}]="[namespace::]{value}"
```

- **directive**: The directive name (e.g., `bind`, `class`, `text`)
- **suffix**: Modifier for the directive (e.g., attribute name for `bind`)
- **unique-id**: Optional unique identifier for multiple same-suffix directives
- **namespace**: Optional store namespace (defaults to nearest `data-wp-interactive`)
- **value**: Reference path or JSON

## Reference Paths

Directives reference state and context using dot notation:

```
state.propertyName           → $state_data['namespace']['propertyName']
context.itemName             → Current context's ['namespace']['itemName']
state.nested.property        → $state_data['namespace']['nested']['property']
!state.isHidden              → Negated value
state.items.length           → Array count or string length (since 6.8.0)
```

---

## data-wp-interactive

Defines the namespace for an interactive region.

**Since:** 6.5.0

**Syntax:**
```html
<div data-wp-interactive="myPlugin">
    <!-- All nested directives use "myPlugin" namespace -->
</div>

<div data-wp-interactive='{"namespace":"myPlugin"}'>
    <!-- JSON format also supported -->
</div>
```

**Behavior:**
- Sets default namespace for all descendant directives
- Nested `data-wp-interactive` creates new scope
- Namespace restored when exiting element

---

## data-wp-context

Provides local context data for an element and its descendants.

**Since:** 6.5.0

**Syntax:**
```html
<div data-wp-context='{"isOpen": false, "count": 0}'>
    <!-- context.isOpen and context.count available here -->
</div>

<div data-wp-context='otherPlugin::{"id": 123}'>
    <!-- Uses explicit namespace -->
</div>
```

**PHP Helper:**
```php
<div <?php echo wp_interactivity_data_wp_context( array( 
    'isOpen' => false,
    'count'  => 0,
) ); ?>>
```

**Behavior:**
- Context is scoped to element and descendants
- Nested contexts merge with parent via `array_replace_recursive()`
- Access via `context.propertyName` in other directives

---

## data-wp-bind--{attribute}

Dynamically binds an attribute value.

**Since:** 6.5.0

**Syntax:**
```html
<a data-wp-bind--href="state.url">Link</a>
<img data-wp-bind--src="state.imageUrl" data-wp-bind--alt="state.imageAlt">
<button data-wp-bind--disabled="state.isLoading">Submit</button>
```

**Behavior:**
- Sets attribute to evaluated value
- `false` removes non-aria/data attributes
- For `aria-*` and `data-*` attributes, booleans become `"true"`/`"false"` strings
- `null` removes the attribute

**Multiple bindings with unique IDs:**
```html
<div 
    data-wp-bind--data-value---1="state.value1"
    data-wp-bind--data-value---2="state.value2"
>
```

---

## data-wp-class--{classname}

Toggles a CSS class based on a boolean value.

**Since:** 6.5.0

**Syntax:**
```html
<div data-wp-class--is-open="state.isOpen">
    <!-- Has "is-open" class when state.isOpen is truthy -->
</div>

<div data-wp-class--active="context.isActive" data-wp-class--highlighted="state.isHighlighted">
    <!-- Multiple class toggles -->
</div>
```

**Behavior:**
- Truthy value adds the class
- Falsy value removes the class
- Class name is the suffix after `--`

**With unique IDs:**
```html
<div data-wp-class--featured---abc="state.isFeatured">
    <!-- Toggles class "featured---abc" -->
</div>
```

---

## data-wp-style--{property}

Sets an inline style property.

**Since:** 6.5.0

**Syntax:**
```html
<div data-wp-style--color="state.textColor">
    <!-- Sets style="color: {value};" -->
</div>

<div 
    data-wp-style--background-color="state.bgColor"
    data-wp-style--font-size="state.fontSize"
>
    <!-- Multiple style properties -->
</div>
```

**Behavior:**
- Sets the CSS property to evaluated value
- Empty/null/false removes the property
- Merges with existing `style` attribute
- Removes entire `style` attribute if empty

---

## data-wp-text

Sets the text content of an element.

**Since:** 6.5.0

**Syntax:**
```html
<span data-wp-text="state.message"></span>
<p data-wp-text="context.item.description"></p>
```

**Behavior:**
- Replaces all inner content with evaluated value
- Value is HTML-escaped via `esc_html()`
- Only strings and numbers are rendered
- Other types (null, boolean, array) clear the content

---

## data-wp-each

Iterates over an array, rendering content for each item.

**Since:** 6.5.0  
**Since:** 6.9.0 — Adds list path to `data-wp-each-child`.

**Syntax:**
```html
<template data-wp-each="state.items">
    <li data-wp-text="context.item.name"></li>
</template>

<!-- With custom item name -->
<template data-wp-each--product="state.products">
    <div data-wp-text="context.product.title"></div>
</template>
```

**Requirements:**
- Must be on a `<template>` tag
- Value must evaluate to a list (indexed array)
- Template content must start and end with tags (no loose text)

**Context Variable:**
- Default: `context.item`
- With suffix: `context.{suffix}` (e.g., `data-wp-each--product` → `context.product`)
- Suffix is converted from kebab-case to camelCase

**data-wp-each-child:**
Rendered items automatically receive `data-wp-each-child="{namespace}::{path}"` attribute. This marks them as generated content to prevent re-processing.

**Skipped Cases:**
- Non-template elements
- Associative arrays (objects in JS)
- Template content with top-level text nodes
- Elements with existing `data-wp-each-child` (manual SSR)

---

## data-wp-router-region

Marks a region for client-side navigation updates.

**Since:** 6.5.0

**Syntax:**
```html
<main data-wp-router-region="main-content">
    <!-- This region updates during client-side navigation -->
</main>
```

**Behavior:**
- First occurrence triggers setup (once per page)
- Enqueues loading bar animation styles
- Adds loading bar markup to footer via `wp_footer`
- Works with `@wordpress/interactivity-router` module

**Loading Bar Classes:**
- `.wp-interactivity-router-loading-bar` — Base styles
- `.start-animation` — Applied when navigation starts
- `.finish-animation` — Applied when navigation completes

---

## Directive Processing Order

Directives are processed in this order on element entry:

1. `data-wp-interactive` — Establish namespace
2. `data-wp-router-region` — Setup router
3. `data-wp-context` — Establish context
4. `data-wp-bind` — Bind attributes
5. `data-wp-class` — Toggle classes
6. `data-wp-style` — Set styles
7. `data-wp-text` — Set text content
8. `data-wp-each` — Loop (processed last to avoid reprocessing)

On element exit, the order is reversed.

---

## Incompatible Elements

Directives inside these elements are **not processed**:

- `<svg>` — Not compatible with Tag Processor
- `<math>` — Not compatible with Tag Processor

A `_doing_it_wrong` notice is triggered if directives are found on these elements.

---

## Namespace Resolution

When a directive doesn't specify a namespace:

1. Uses the namespace from the nearest ancestor `data-wp-interactive`
2. Falls back to empty/undefined if no `data-wp-interactive` found

**Explicit namespace:**
```html
<div data-wp-interactive="pluginA">
    <span data-wp-text="pluginB::state.message">
        <!-- Uses pluginB namespace explicitly -->
    </span>
</div>
```
