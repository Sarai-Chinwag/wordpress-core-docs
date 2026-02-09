# WP-CLI: wp cache

Adds, removes, fetches, and flushes the WP Object Cache object.

By default, the WP Object Cache exists in PHP memory for the length of the request and is emptied at the end. Use a persistent object cache drop-in (e.g., Redis, Memcached) to persist the object cache between requests.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp cache add` | Adds a value to the object cache |
| `wp cache decr` | Decrements a value in the object cache |
| `wp cache delete` | Removes a value from the object cache |
| `wp cache flush` | Flushes the object cache |
| `wp cache flush-group` | Removes all cache items in a group |
| `wp cache get` | Gets a value from the object cache |
| `wp cache incr` | Increments a value in the object cache |
| `wp cache patch` | Updates a nested value from the cache |
| `wp cache pluck` | Gets a nested value from the cache |
| `wp cache replace` | Replaces a value in the object cache (if it exists) |
| `wp cache set` | Sets a value to the object cache |
| `wp cache supports` | Determines whether the cache supports a feature |
| `wp cache type` | Attempts to determine which object cache is being used |

---

## wp cache flush

Flushes the object cache.

### Syntax

```bash
wp cache flush
```

### Examples

```bash
# Flush the entire cache
wp cache flush
```

### Notes

- This command flushes the entire object cache
- For persistent caches (Redis, Memcached), this clears all cached data
- Use with caution in production as it may temporarily increase load

---

## wp cache type

Attempts to determine which object cache is being used.

### Syntax

```bash
wp cache type
```

### Examples

```bash
# Check cache type
wp cache type
# Output: Default (no persistent cache)
# Or: Redis
# Or: Memcached
```

---

## wp cache get

Gets a value from the object cache.

### Syntax

```bash
wp cache get <key> [<group>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Cache key |
| `[<group>]` | Cache group. Default: default |
| `--format=<format>` | Output format: var_export, json, yaml |

### Examples

```bash
# Get cached value
wp cache get my_key

# Get from specific group
wp cache get my_key my_group

# Get as JSON
wp cache get my_key my_group --format=json
```

---

## wp cache set

Sets a value to the object cache, regardless of whether it already exists.

### Syntax

```bash
wp cache set <key> <value> [<group>] [<expiration>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Cache key |
| `<value>` | Value to store |
| `[<group>]` | Cache group. Default: default |
| `[<expiration>]` | Time to live in seconds. Default: 0 (no expiration) |

### Examples

```bash
# Set cache value
wp cache set my_key "my_value"

# Set with group
wp cache set my_key "my_value" my_group

# Set with expiration (300 seconds = 5 minutes)
wp cache set my_key "my_value" my_group 300

# Set with no expiration
wp cache set my_key "my_value" my_group 0
```

---

## wp cache add

Adds a value to the object cache (only if it doesn't already exist).

### Syntax

```bash
wp cache add <key> <value> [<group>] [<expiration>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Cache key |
| `<value>` | Value to add |
| `[<group>]` | Cache group. Default: default |
| `[<expiration>]` | Time to live in seconds. Default: 0 (no expiration) |

### Examples

```bash
# Add cache value (fails if key exists)
wp cache add my_key "my_value"

# Add with group
wp cache add my_key "my_value" my_group

# Add with expiration
wp cache add my_key "my_value" my_group 3600
```

---

## wp cache delete

Removes a value from the object cache.

### Syntax

```bash
wp cache delete <key> [<group>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Cache key |
| `[<group>]` | Cache group. Default: default |

### Examples

```bash
# Delete cached value
wp cache delete my_key

# Delete from specific group
wp cache delete my_key my_group
```

---

## wp cache replace

Replaces a value in the object cache, if the value already exists.

### Syntax

```bash
wp cache replace <key> <value> [<group>] [<expiration>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Cache key |
| `<value>` | New value |
| `[<group>]` | Cache group. Default: default |
| `[<expiration>]` | Time to live in seconds. Default: 0 |

### Examples

```bash
# Replace existing value
wp cache replace my_key "new_value"

# Replace with group
wp cache replace my_key "new_value" my_group

# Replace with expiration
wp cache replace my_key "new_value" my_group 600
```

---

## wp cache incr

Increments a value in the object cache.

### Syntax

```bash
wp cache incr <key> [<offset>] [<group>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Cache key |
| `[<offset>]` | Amount to increment. Default: 1 |
| `[<group>]` | Cache group. Default: default |

### Examples

```bash
# Increment by 1
wp cache incr my_counter

# Increment by 5
wp cache incr my_counter 5

# Increment in specific group
wp cache incr my_counter 1 my_group
```

---

## wp cache decr

Decrements a value in the object cache.

### Syntax

```bash
wp cache decr <key> [<offset>] [<group>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Cache key |
| `[<offset>]` | Amount to decrement. Default: 1 |
| `[<group>]` | Cache group. Default: default |

### Examples

```bash
# Decrement by 1
wp cache decr my_counter

# Decrement by 5
wp cache decr my_counter 5

# Decrement in specific group
wp cache decr my_counter 1 my_group
```

---

## wp cache flush-group

Removes all cache items in a group, if the object cache implementation supports it.

### Syntax

```bash
wp cache flush-group <group>
```

### Options

| Option | Description |
|--------|-------------|
| `<group>` | Cache group to flush |

### Examples

```bash
# Flush specific group
wp cache flush-group my_group

# Flush posts group
wp cache flush-group posts
```

### Notes

Not all cache implementations support group flushing. Use `wp cache supports flush_group` to check.

---

## wp cache pluck

Gets a nested value from the cache.

### Syntax

```bash
wp cache pluck <key> <key-path>... [<group>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Cache key |
| `<key-path>...` | Path to nested value |
| `[<group>]` | Cache group |
| `--format=<format>` | Output format |

### Examples

```bash
# Get nested value
wp cache pluck my_key nested_key

# Get deeply nested
wp cache pluck my_key level1 level2 level3
```

---

## wp cache patch

Updates a nested value from the cache.

### Syntax

```bash
wp cache patch <action> <key> <key-path>... <value> [<group>] [<expiration>]
```

### Options

| Option | Description |
|--------|-------------|
| `<action>` | Patch action: insert, update, delete |
| `<key>` | Cache key |
| `<key-path>...` | Path to nested value |
| `<value>` | New value (for insert/update) |
| `[<group>]` | Cache group |
| `[<expiration>]` | Time to live |

### Examples

```bash
# Update nested value
wp cache patch update my_key nested_key "new_value"

# Insert new nested value
wp cache patch insert my_key new_nested "value"

# Delete nested value
wp cache patch delete my_key old_nested
```

---

## wp cache supports

Determines whether the object cache implementation supports a particular feature.

### Syntax

```bash
wp cache supports <feature>
```

### Options

| Option | Description |
|--------|-------------|
| `<feature>` | Feature to check |

### Supported Features

| Feature | Description |
|---------|-------------|
| `add_multiple` | Add multiple values at once |
| `set_multiple` | Set multiple values at once |
| `get_multiple` | Get multiple values at once |
| `delete_multiple` | Delete multiple values at once |
| `flush_runtime` | Flush runtime cache only |
| `flush_group` | Flush a specific cache group |

### Examples

```bash
# Check if group flushing is supported
wp cache supports flush_group

# Check for multiple operations
wp cache supports get_multiple
wp cache supports set_multiple
```

---

## Common Cache Groups

WordPress uses various cache groups internally:

| Group | Description |
|-------|-------------|
| `default` | Default cache group |
| `options` | Cached options |
| `posts` | Cached posts |
| `post_meta` | Cached post metadata |
| `terms` | Cached taxonomy terms |
| `users` | Cached user objects |
| `user_meta` | Cached user metadata |
| `comment` | Cached comments |
| `counts` | Various counts |
| `plugins` | Plugin data |
| `themes` | Theme data |
| `site-options` | Multisite network options |
| `site-transient` | Site transients |
| `transient` | Transients |

---

## Practical Examples

### Debugging Cache Issues

```bash
# Check what cache is being used
wp cache type

# Verify cache is working
wp cache set test_key "test_value" default 60
wp cache get test_key
wp cache delete test_key

# Check cache support
wp cache supports flush_group
wp cache supports get_multiple
```

### Cache Maintenance

```bash
# Flush cache after making changes
wp cache flush

# Flush specific group (if supported)
wp cache flush-group posts

# Clear and repopulate
wp cache flush
wp post list --format=ids | head -10 | xargs -I {} wp post get {}
```

### Performance Testing

```bash
# Set up counter
wp cache set page_views 0

# Increment
wp cache incr page_views

# Check value
wp cache get page_views
```

---

## Notes

- Object cache is transient by default and only persists within a single request
- Install a persistent object cache drop-in (Redis, Memcached) for cross-request caching
- The `wp cache` commands are primarily useful for debugging and testing
- In production, cache operations typically happen through WordPress code
