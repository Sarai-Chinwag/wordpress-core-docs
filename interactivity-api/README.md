# Interactivity API

The Interactivity API enables developers to create interactive, dynamic block experiences using declarative directives in HTML, with server-side rendering and client-side hydration.

**Since:** WordPress 6.5.0

## Overview

The Interactivity API provides:

- Declarative directives (`data-wp-*`) for reactive behavior
- Server-side directive processing
- Client-side state hydration
- Seamless integration with WordPress blocks

## Directives Reference

| Directive | Description |
|-----------|-------------|
| `data-wp-interactive` | Declares the interactive namespace |
| `data-wp-context` | Provides local context data |
| `data-wp-bind` | Binds attribute values to state |
| `data-wp-class` | Toggles CSS classes based on state |
| `data-wp-style` | Sets inline styles from state |
| `data-wp-text` | Sets text content from state |
| `data-wp-on` | Attaches event handlers |
| `data-wp-watch` | Runs effects when state changes |
| `data-wp-init` | Runs once on initialization |
| `data-wp-each` | Iterates over arrays |
| `data-wp-router-region` | Defines client-side navigation regions |

## Quick Start

### PHP (Server-Side)

```php
// In your block's render.php
<?php
wp_interactivity_state( 'my-plugin', array(
    'isOpen' => false,
    'count'  => 0,
) );
?>

<div 
    data-wp-interactive="my-plugin"
    <?php echo wp_interactivity_data_wp_context( array( 'id' => 123 ) ); ?>
>
    <button data-wp-on--click="actions.toggle">
        <span data-wp-text="state.isOpen ? 'Close' : 'Open'"></span>
    </button>
    
    <div data-wp-class--hidden="!state.isOpen">
        <p data-wp-text="state.count"></p>
        <button data-wp-on--click="actions.increment">+1</button>
    </div>
</div>
```

### JavaScript (Client-Side)

```js
// view.js (loaded as viewScriptModule)
import { store, getContext } from '@wordpress/interactivity';

store( 'my-plugin', {
    actions: {
        toggle() {
            const context = getContext();
            context.isOpen = ! context.isOpen;
        },
        increment() {
            const { state } = store( 'my-plugin' );
            state.count++;
        },
    },
} );
```

## Core Functions

### wp_interactivity_state()

Gets and/or sets the initial state for a store namespace.

```php
wp_interactivity_state( ?string $namespace = null, array $state = array() ): array
```

**Example:**

```php
// Set state
wp_interactivity_state( 'my-plugin', array(
    'isLoading' => false,
    'items'     => array(),
) );

// Get state (inside derived state getters)
$state = wp_interactivity_state();
```

---

### wp_interactivity_config()

Gets and/or sets configuration for a store namespace.

```php
wp_interactivity_config( string $namespace, array $config = array() ): array
```

**Example:**

```php
wp_interactivity_config( 'my-plugin', array(
    'apiEndpoint' => rest_url( 'my-plugin/v1/items' ),
    'nonce'       => wp_create_nonce( 'wp_rest' ),
) );
```

---

### wp_interactivity_data_wp_context()

Generates a `data-wp-context` attribute with encoded JSON.

```php
wp_interactivity_data_wp_context( array $context, string $namespace = '' ): string
```

**Example:**

```php
<div <?php echo wp_interactivity_data_wp_context( array(
    'postId'   => get_the_ID(),
    'isActive' => true,
) ); ?>>
```

Outputs: `data-wp-context='{"postId":123,"isActive":true}'`

---

### wp_interactivity_get_context()

Gets the current context during directive processing.

```php
wp_interactivity_get_context( ?string $namespace = null ): array
```

---

### wp_interactivity_get_element()

Returns the current element being processed.

```php
wp_interactivity_get_element(): ?array
```

**Returns:** `array{ attributes: array<string, string|bool> }` or `null`

---

### wp_interactivity_process_directives()

Processes directives in HTML content.

```php
wp_interactivity_process_directives( string $html ): string
```

---

## Directive Syntax

### Binding Attributes

```html
<!-- Bind src attribute to state.imageUrl -->
<img data-wp-bind--src="state.imageUrl">

<!-- Bind multiple attributes -->
<a 
    data-wp-bind--href="state.url"
    data-wp-bind--title="state.title"
>
```

### Toggling Classes

```html
<!-- Add 'active' class when state.isActive is true -->
<div data-wp-class--active="state.isActive">

<!-- Multiple classes -->
<div 
    data-wp-class--loading="state.isLoading"
    data-wp-class--error="state.hasError"
>
```

### Setting Styles

```html
<!-- Set background color from state -->
<div data-wp-style--background-color="state.bgColor">

<!-- Set display based on condition -->
<div data-wp-style--display="state.isVisible ? 'block' : 'none'">
```

### Event Handlers

```html
<!-- Click handler -->
<button data-wp-on--click="actions.handleClick">

<!-- With modifiers -->
<form data-wp-on--submit--prevent="actions.handleSubmit">

<!-- Window/document events -->
<div data-wp-on-window--resize="callbacks.onResize">
```

### Text Content

```html
<!-- Set text from state -->
<span data-wp-text="state.message"></span>

<!-- With expression -->
<span data-wp-text="state.count + ' items'"></span>
```

### Iteration

```html
<template data-wp-each="state.items">
    <li data-wp-text="context.item.name"></li>
</template>
```

### Context

```html
<!-- Parent provides context -->
<div data-wp-context='{"itemId": 1}'>
    <!-- Children can access context.itemId -->
    <button data-wp-on--click="actions.selectItem">
        Select Item <span data-wp-text="context.itemId"></span>
    </button>
</div>
```

## Client-Side Store

```js
import { store, getContext, getElement } from '@wordpress/interactivity';

const { state, actions } = store( 'my-plugin', {
    // Reactive state
    state: {
        count: 0,
        get doubled() {
            return state.count * 2;
        },
    },
    
    // Actions modify state
    actions: {
        increment() {
            state.count++;
        },
        
        *fetchData() {
            // Generators for async
            const response = yield fetch( '/api/data' );
            const data = yield response.json();
            state.items = data;
        },
    },
    
    // Side effects
    callbacks: {
        logCount() {
            console.log( 'Count changed:', state.count );
        },
    },
} );
```

## Block Integration

### block.json

```json
{
    "viewScriptModule": "file:./view.js",
    "supports": {
        "interactivity": true
    }
}
```

### render.php

```php
<?php
wp_interactivity_state( 'my-block', array(
    'isExpanded' => false,
) );
?>

<div 
    <?php echo get_block_wrapper_attributes(); ?>
    data-wp-interactive="my-block"
>
    <!-- Interactive content -->
</div>
```

## Best Practices

1. **Use namespaced stores** — Prevents conflicts between blocks
2. **Minimize initial state** — Only include what's needed for first render
3. **Use context for local data** — State is global, context is scoped
4. **Prefer derived state** — Use getters instead of duplicating data
5. **Handle async with generators** — Cleaner than promises in actions
