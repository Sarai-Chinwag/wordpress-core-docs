# generated-classname.php — Generated Class Name Block Support

Generates the default `wp-block-{name}` CSS class for server-rendered blocks.

**Source:** `wp-includes/block-supports/generated-classname.php`  
**Since:** 5.6.0

---

## Support Key

`supports.className` — defaults to `true`.

---

## Functions

### wp_get_block_default_classname()

```php
function wp_get_block_default_classname( string $block_name ): string
```

**Since:** 5.6.0  
**Access:** private

Generates the class name `wp-block-{name}` from the block name. WordPress core blocks have their `core/` or `core-` prefix stripped:
- `core/paragraph` → `wp-block-paragraph`
- `core-embed/youtube` → `wp-block-embed-youtube`
- `my-plugin/my-block` → `wp-block-my-plugin-my-block`

#### Hooks

| Hook | Type | Description |
|------|------|-------------|
| `block_default_classname` | filter | Filters the default block className for server-rendered blocks. Receives `$class_name` and `$block_name`. Since 5.6.0. |

---

### wp_apply_generated_classname_support()

```php
function wp_apply_generated_classname_support( WP_Block_Type $block_type ): array
```

**Since:** 5.6.0  
**Access:** private

Note: This function only receives `$block_type` (no `$block_attributes`). Checks `block_has_support( $block_type, 'className', true )`.

**Returns:** Array with `class` set to the generated classname.

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'generated-classname',
    array(
        'apply' => 'wp_apply_generated_classname_support',
    )
);
```

Note: No `register_attribute` callback — this support only has an `apply` callback.
