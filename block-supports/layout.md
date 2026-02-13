# layout.php — Layout Block Support

The largest and most complex block support. Handles layout types (flow, constrained, flex, grid), gap/spacing styles, child layout positioning, and classic theme compatibility.

**Source:** `wp-includes/block-supports/layout.php`  
**Since:** 5.8.0

---

## Support Keys

- `supports.layout`
- `supports.__experimentalLayout` (legacy fallback)

---

## Registered Attribute

| Attribute | Type |
|-----------|------|
| `layout` | `object` |

---

## Layout Types

### wp_get_layout_definitions()

```php
function wp_get_layout_definitions(): array
```

**Since:** 6.3.0  
**Since:** 6.6.0 Updated specificity for 0-1-0 global styles compatibility.  
**Access:** private

Returns definitions for four layout types:

| Type | Slug | CSS Class | Display Mode |
|------|------|-----------|-------------|
| `default` | `flow` | `is-layout-flow` | (block) |
| `constrained` | `constrained` | `is-layout-constrained` | (block) |
| `flex` | `flex` | `is-layout-flex` | `flex` |
| `grid` | `grid` | `is-layout-grid` | `grid` |

Each definition includes `baseStyles` and `spacingStyles` arrays with selector/rules pairs.

#### Flow/Constrained Base Styles
- `.alignleft`: float left with inline margins
- `.alignright`: float right with inline margins
- `.aligncenter`: auto left/right margins

#### Constrained Additional Base Styles
- Non-aligned children: `max-width: var(--wp--style--global--content-size)`, auto margins
- `.alignwide`: `max-width: var(--wp--style--global--wide-size)`

#### Flex Base Styles
- `flex-wrap: wrap`, `align-items: center`
- Children: `margin: 0` (with `:is(*, div)` for +001 specificity)

#### Grid Base Styles
- Children: `margin: 0` (with `:is(*, div)` for +001 specificity)

---

## Functions

### wp_register_layout_support()

```php
function wp_register_layout_support( WP_Block_Type $block_type )
```

**Since:** 5.8.0  
**Since:** 6.3.0 Check for layout support via `layout` key with fallback to `__experimentalLayout`.  
**Access:** private

---

### wp_get_layout_style()

```php
function wp_get_layout_style(
    string $selector,
    array $layout,
    bool $has_block_gap_support = false,
    string|array|null $gap_value = null,
    bool $should_skip_gap_serialization = false,
    string $fallback_gap_value = '0.5em',
    ?array $block_spacing = null
): string
```

**Since:** 5.9.0  
**Since:** 6.1.0 Added `$block_spacing` param, use style engine to enqueue styles.  
**Since:** 6.3.0 Added grid layout type.  
**Since:** 6.6.0 Removed duplicated selector; enabled negative margins for alignfull children.  
**Access:** private

Generates CSS rules based on layout type:

**Flow (`default`):**
- Block gap via `margin-block-start`/`margin-block-end` on `> *` and `> * + *`

**Constrained:**
- `contentSize` → `max-width` on non-aligned children
- `wideSize` → `max-width` on `.alignwide`
- `.alignfull` → `max-width: none`
- `justifyContent` → `margin-left`/`margin-right` adjustments (`left`, `right`, `center`)
- Negative margins for `.alignfull` when block has custom padding
- Block gap same as flow

**Flex:**
- `orientation` → horizontal (default) or vertical (`flex-direction: column`)
- `justifyContent` → maps to `justify-content` or `align-items` depending on orientation
- `verticalAlignment` → maps to `align-items` or `justify-content`
- `flexWrap: nowrap` → `flex-wrap: nowrap`
- Gap: row and column gap support (array or single value)

**Grid:**
- `columnCount` → `grid-template-columns: repeat(N, minmax(0, 1fr))`
- `minimumColumnWidth` → `grid-template-columns: repeat(auto-fill, minmax(min(W, 100%), 1fr))` + `container-type: inline-size`
- Gap support same as flex

All styles stored in style engine `block-supports` context.

---

### wp_render_layout_support_flag()

```php
function wp_render_layout_support_flag( string $block_content, array $block ): string
```

**Since:** 5.8.0  
**Since:** 6.3.0 Adds compound class for global spacing; checks `layout` with `__experimentalLayout` fallback.  
**Since:** 6.6.0 Removed duplicate container class.  
**Access:** private

**Processing:**

1. **Child layout**: Handles `$block['attrs']['style']['layout']` (selfStretch, flexSize, columnSpan, rowSpan) and `$block['parentLayout']`
   - Generates deterministic class via `wp_unique_id_from_values()`
   - `fixed` selfStretch → `flex-basis` + `box-sizing: border-box`
   - `fill` selfStretch → `flex-grow: 1`
   - `columnSpan` → `grid-column: span N`
   - `rowSpan` → `grid-row: span N`
   - Responsive column span: `@container` query resets to `1/-1` when grid is too narrow

2. **Parent layout**: Reads `$used_layout` from block attributes or fallback
   - Legacy `inherit: true` or `contentSize` → sets type to `constrained`
   - `useRootPaddingAwareAlignments` + constrained → adds `has-global-padding`
   - Adds orientation, justification, and nowrap classes
   - Generates layout CSS via `wp_get_layout_style()` (skipped if theme supports `disable-layout-styles`)
   - Adds compound class: `wp-block-{name}-{layout-class}`

3. **Inner block wrapper detection**: Searches for the inner wrapper tag by matching original `class` attribute from `$block['innerContent'][0]`

---

### wp_add_parent_layout_to_parsed_block()

```php
function wp_add_parent_layout_to_parsed_block( array $parsed_block, array $source_block, WP_Block $parent_block ): array
```

**Since:** 6.6.0  
**Access:** private

Adds `parentLayout` to `$parsed_block` from the parent block's layout attribute.

---

### wp_restore_group_inner_container()

```php
function wp_restore_group_inner_container( string $block_content, array $block ): string
```

**Since:** 5.8.0  
**Since:** 6.6.1 Removed inner container from Grid variations.  
**Access:** private

For themes without theme.json: restores the `wp-block-group__inner-container` div for the Group block. Skips for flex/grid layouts. Transfers `is-layout-*` classes from outer to inner wrapper.

---

### wp_restore_image_outer_container()

```php
function wp_restore_image_outer_container( string $block_content, array $block ): string
```

**Since:** 6.0.0  
**Access:** private

For themes without theme.json: wraps aligned Image blocks (`alignleft`, `aligncenter`, `alignright`) in a `<div class="wp-block-image">` wrapper, transferring custom classes up and removing `wp-block-image` from the inner `<figure>`.

---

## Generated CSS Classes

| Class | Condition |
|-------|-----------|
| `is-layout-flow` | Flow layout type |
| `is-layout-constrained` | Constrained layout type |
| `is-layout-flex` | Flex layout type |
| `is-layout-grid` | Grid layout type |
| `has-global-padding` | Constrained + `useRootPaddingAwareAlignments` |
| `is-horizontal` / `is-vertical` | Flex orientation |
| `is-content-justification-{value}` | Content justification |
| `is-nowrap` | Flex nowrap |
| `wp-block-{name}-is-layout-{class}` | Compound class for global styles |
| `wp-container-{blockName}-is-layout-{hash}` | Unique layout container |
| `wp-container-content-{hash}` | Unique child layout container |
| `is-position-sticky` / `is-position-fixed` | (from position.php, not here) |

---

## Hooks

| Hook | Type | Priority | Callback |
|------|------|----------|----------|
| `render_block` | filter | 10 | `wp_render_layout_support_flag` |
| `render_block_data` | filter | 10 | `wp_add_parent_layout_to_parsed_block` |
| `render_block_core/group` | filter | 10 | `wp_restore_group_inner_container` |
| `render_block_core/image` | filter | 10 | `wp_restore_image_outer_container` |

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'layout',
    array(
        'register_attribute' => 'wp_register_layout_support',
    )
);
```

Note: No `apply` callback — all rendering via `render_block` filter.
