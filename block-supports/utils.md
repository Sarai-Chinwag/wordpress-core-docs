# utils.php — Block Support Utility Functions

Shared utility functions used across block support files.

**Source:** `wp-includes/block-supports/utils.php`  
**Since:** 6.0.0

---

## Functions

### wp_should_skip_block_supports_serialization()

```php
function wp_should_skip_block_supports_serialization( WP_Block_Type $block_type, string $feature_set, ?string $feature = null ): bool
```

**Since:** 6.0.0  
**Access:** private

Checks whether serialization of a block's supported properties should be skipped. This is the mechanism by which blocks opt out of server-side style/class generation for specific features.

**Logic:**

1. Returns `false` if `$block_type` is not an object or `$feature_set` is falsy
2. Reads `$block_type->supports[$feature_set]['__experimentalSkipSerialization']`
3. If the value is an **array**: returns `true` if `$feature` is in the array
4. If the value is a **boolean**: returns that boolean directly

**Usage pattern in block.json:**

```json
{
  "supports": {
    "color": {
      "text": true,
      "background": true,
      "__experimentalSkipSerialization": true
    }
  }
}
```

Or skip only specific features:

```json
{
  "supports": {
    "color": {
      "text": true,
      "background": true,
      "__experimentalSkipSerialization": ["text"]
    }
  }
}
```

This function is called by nearly every block support's `apply` and `render` functions.
