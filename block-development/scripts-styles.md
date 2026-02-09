# Block Scripts and Styles

Block scripts and styles are defined in block.json and automatically registered when the block is registered.

## Asset Fields Overview

| Field | Editor | Frontend | Use Case |
|-------|--------|----------|----------|
| `editorScript` | ✓ | ✗ | Block registration, edit component |
| `editorStyle` | ✓ | ✗ | Editor-only styling |
| `script` | ✓ | ✓ | Shared functionality |
| `style` | ✓ | ✓ | Block styling (both contexts) |
| `viewScript` | ✗ | ✓ | Frontend interactivity |
| `viewScriptModule` | ✗ | ✓ | ES Module for frontend |
| `viewStyle` | ✗ | ✓ | Frontend-only styling |

## editorScript

JavaScript that runs only in the editor:

```json
{
    "editorScript": "file:./index.js"
}
```

This is your main entry point containing:
- Block registration
- Edit component
- Block settings

### Multiple Editor Scripts

```json
{
    "editorScript": [
        "file:./index.js",
        "file:./sidebar.js"
    ]
}
```

### Using a Registered Handle

```json
{
    "editorScript": "my-plugin-editor-script"
}
```

Requires manual registration:

```php
add_action( 'init', function() {
    wp_register_script(
        'my-plugin-editor-script',
        plugins_url( 'build/editor.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor' ],
        '1.0.0',
        true
    );
} );
```

## editorStyle

CSS that loads only in the editor:

```json
{
    "editorStyle": "file:./editor.css"
}
```

Use for:
- Editor-specific UI adjustments
- Preview styling differences
- Block control styling

Example editor.css:

```css
/* Style the placeholder */
.wp-block-my-plugin-card .components-placeholder {
    padding: 40px;
}

/* Editor-specific layout */
.wp-block-my-plugin-card [data-type="core/paragraph"] {
    margin: 0;
}
```

## style

CSS that loads in both editor and frontend:

```json
{
    "style": "file:./style.css"
}
```

This should contain your block's main styling:

```css
.wp-block-my-plugin-card {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.wp-block-my-plugin-card__title {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.wp-block-my-plugin-card__content {
    line-height: 1.6;
}
```

## script

JavaScript that runs in both editor and frontend:

```json
{
    "script": "file:./script.js"
}
```

Use for shared utilities or when the same behavior is needed everywhere.

## viewScript

JavaScript that runs only on the frontend when the block is present:

```json
{
    "viewScript": "file:./view.js"
}
```

Use for:
- DOM manipulation
- Event handlers
- Third-party library initialization
- Interactive features

Example view.js:

```js
document.addEventListener( 'DOMContentLoaded', function() {
    const cards = document.querySelectorAll( '.wp-block-my-plugin-card' );
    
    cards.forEach( ( card ) => {
        card.addEventListener( 'click', function() {
            this.classList.toggle( 'is-expanded' );
        } );
    } );
} );
```

### Multiple View Scripts

```json
{
    "viewScript": [
        "file:./view.js",
        "file:./animations.js"
    ]
}
```

## viewScriptModule (WordPress 6.5+)

ES Module for frontend - uses native browser module loading:

```json
{
    "viewScriptModule": "file:./view.js"
}
```

Benefits:
- Native ES modules (import/export)
- Better tree shaking
- Modern JavaScript features
- Automatic dependencies via Script Modules API

Example view.js as module:

```js
// Can use ES module syntax
import { animate } from './animations.js';

const cards = document.querySelectorAll( '.wp-block-my-plugin-card' );
cards.forEach( animate );
```

### viewScriptModule with Interactivity API

```json
{
    "viewScriptModule": "file:./view.js",
    "supports": {
        "interactivity": true
    }
}
```

```js
// view.js
import { store, getContext } from '@wordpress/interactivity';

store( 'my-plugin/card', {
    actions: {
        toggle() {
            const context = getContext();
            context.isExpanded = ! context.isExpanded;
        },
    },
} );
```

## viewStyle (WordPress 6.5+)

CSS that loads only on the frontend:

```json
{
    "viewStyle": "file:./view.css"
}
```

Use for:
- Frontend-only animations
- Styles that conflict with editor
- Performance optimization (reduce editor CSS)

## viewScript vs viewScriptModule

| Feature | viewScript | viewScriptModule |
|---------|------------|------------------|
| Module syntax | No (IIFE/UMD) | Yes (ES modules) |
| Browser support | All | Modern browsers |
| Load timing | After DOM ready | Deferred, module |
| Dependencies | Via wp_script_add_data | Via Script Modules API |
| Interactivity API | Manual integration | Native support |

### When to Use Each

**Use viewScript when:**
- Supporting older browsers
- Using jQuery or legacy libraries
- Simple DOM manipulation

**Use viewScriptModule when:**
- Using Interactivity API
- Modern JavaScript workflow
- Complex state management
- ES module dependencies

## Asset Registration Under the Hood

When you register a block, WordPress:

1. Reads block.json
2. Registers scripts/styles with generated handles
3. Enqueues them at appropriate times

Generated handles follow the pattern:
- `{block-namespace}-{block-name}-editor-script`
- `{block-namespace}-{block-name}-style`
- `{block-namespace}-{block-name}-view-script`

## Dependency Management

### Automatic Dependencies

With `@wordpress/scripts`, dependencies are auto-detected:

```js
// index.js
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
```

Creates `index.asset.php`:

```php
<?php return array(
    'dependencies' => array(
        'wp-blocks',
        'wp-block-editor',
        'wp-element',
    ),
    'version' => 'abc123',
);
```

### Manual Dependencies

For registered handles:

```php
wp_register_script(
    'my-plugin-view',
    plugins_url( 'build/view.js', __FILE__ ),
    [ 'jquery', 'lodash' ], // Dependencies
    '1.0.0',
    [ 'in_footer' => true ]
);
```

## Conditional Loading

### Block-Based Loading

Scripts/styles only load when block is present on page. This is automatic for:
- `viewScript`
- `viewScriptModule`
- `viewStyle`
- `style` (when render_callback is used)

### Force Loading

To always load (not recommended):

```php
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'my-plugin-card-style' );
} );
```

## Complete Example

### Directory Structure

```
my-plugin/
├── blocks/
│   └── card/
│       ├── block.json
│       ├── index.js        → editorScript
│       ├── edit.js
│       ├── save.js
│       ├── style.css       → style
│       ├── editor.css      → editorStyle
│       └── view.js         → viewScriptModule
```

### block.json

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "my-plugin/card",
    "title": "Interactive Card",
    "category": "design",
    "attributes": {
        "title": { "type": "string" },
        "content": { "type": "string" }
    },
    "supports": {
        "interactivity": true
    },
    "editorScript": "file:./index.js",
    "editorStyle": "file:./editor.css",
    "style": "file:./style.css",
    "viewScriptModule": "file:./view.js",
    "render": "file:./render.php"
}
```

### style.css

```css
/* Shared styles (editor + frontend) */
.wp-block-my-plugin-card {
    padding: 24px;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    transition: transform 0.2s ease;
}

.wp-block-my-plugin-card.is-expanded {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.wp-block-my-plugin-card__title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 12px;
}
```

### editor.css

```css
/* Editor-only styles */
.wp-block-my-plugin-card {
    position: relative;
}

.wp-block-my-plugin-card::after {
    content: 'Click to expand (preview)';
    position: absolute;
    bottom: 8px;
    right: 8px;
    font-size: 11px;
    color: #757575;
}
```

### view.js (Module)

```js
import { store, getContext } from '@wordpress/interactivity';

store( 'my-plugin/card', {
    state: {
        get expandedClass() {
            const { isExpanded } = getContext();
            return isExpanded ? 'is-expanded' : '';
        },
    },
    actions: {
        toggle() {
            const context = getContext();
            context.isExpanded = ! context.isExpanded;
        },
    },
} );
```

### render.php

```php
<?php
$wrapper_attributes = get_block_wrapper_attributes( [
    'data-wp-interactive' => 'my-plugin/card',
    'data-wp-context' => wp_json_encode( [ 'isExpanded' => false ] ),
    'data-wp-class--is-expanded' => 'state.expandedClass',
    'data-wp-on--click' => 'actions.toggle',
] );
?>
<div <?php echo $wrapper_attributes; ?>>
    <h3 class="wp-block-my-plugin-card__title">
        <?php echo esc_html( $attributes['title'] ?? '' ); ?>
    </h3>
    <div class="wp-block-my-plugin-card__content">
        <?php echo wp_kses_post( $attributes['content'] ?? '' ); ?>
    </div>
</div>
```

## Best Practices

1. **Minimize bundle size:** Split editor and view code.

2. **Use style for shared CSS:** Reduces duplication.

3. **Lazy load view scripts:** They only load when needed.

4. **Prefer viewScriptModule:** For modern, smaller bundles.

5. **Auto-generate dependencies:** Use @wordpress/scripts.

6. **Test loading:** Verify scripts load at correct times.

7. **Consider SSR:** Server-rendered content shouldn't require JS for basic display.
