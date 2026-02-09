# WP-CLI: wp transient

Adds, gets, and deletes entries in the WordPress Transient Cache.

By default, the transient cache uses the WordPress database to persist values between requests. On a single site installation, values are stored in the `wp_options` table. On a multisite installation, values are stored in `wp_options` or `wp_sitemeta`, depending on use of the `--network` flag.

When a persistent object cache drop-in is installed (e.g., Redis or Memcached), the transient cache skips the database and simply wraps the WP Object Cache.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp transient delete` | Deletes a transient value |
| `wp transient get` | Gets a transient value |
| `wp transient list` | Lists transients and their values |
| `wp transient patch` | Updates a nested value from a transient |
| `wp transient pluck` | Gets a nested value from a transient |
| `wp transient set` | Sets a transient value |
| `wp transient type` | Determines the type of transients implementation |

---

## wp transient get

Gets a transient value.

### Syntax

```bash
wp transient get <key> [--format=<format>] [--network]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Transient key |
| `--format=<format>` | Output format: var_export, json, yaml |
| `--network` | Get the value of a network (site) transient (multisite) |

### Examples

```bash
# Get transient value
wp transient get my_transient

# Get as JSON
wp transient get my_transient --format=json

# Get network transient (multisite)
wp transient get my_network_transient --network
```

---

## wp transient set

Sets a transient value.

### Syntax

```bash
wp transient set <key> <value> [<expiration>] [--network]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Transient key |
| `<value>` | Value to store |
| `[<expiration>]` | Time until expiration in seconds. Default: 0 (no expiration) |
| `--network` | Set the value of a network (site) transient (multisite) |

### Examples

```bash
# Set transient
wp transient set my_transient "my_value"

# Set with expiration (1 hour)
wp transient set my_transient "my_value" 3600

# Set with expiration (1 day)
wp transient set my_transient "my_value" 86400

# Set network transient (multisite)
wp transient set my_network_transient "value" 3600 --network

# Set without expiration
wp transient set persistent_data "never expires" 0
```

---

## wp transient delete

Deletes a transient value.

### Syntax

```bash
wp transient delete <key> [--network] [--all] [--expired]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Transient key (unless using --all or --expired) |
| `--network` | Delete a network (site) transient (multisite) |
| `--all` | Delete all transients |
| `--expired` | Delete all expired transients |

### Examples

```bash
# Delete specific transient
wp transient delete my_transient

# Delete network transient (multisite)
wp transient delete my_network_transient --network

# Delete all expired transients
wp transient delete --expired

# Delete all transients
wp transient delete --all

# Delete all network transients (multisite)
wp transient delete --all --network
```

### Notes

Deleting expired transients is a common maintenance task to keep the `wp_options` table clean:

```bash
# Clean up expired transients
wp transient delete --expired
# Output: Success: 42 expired transients deleted from the database.
```

---

## wp transient list

Lists transients and their values.

### Syntax

```bash
wp transient list [--search=<pattern>] [--exclude=<pattern>] [--network] [--unserialize] [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `--search=<pattern>` | Use wildcards (*?) to match transient name |
| `--exclude=<pattern>` | Pattern to exclude from results |
| `--network` | List network (site) transients (multisite) |
| `--unserialize` | Unserialize transient values |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, json, count, yaml |

### Available Fields

- name
- value
- expiration

### Examples

```bash
# List all transients
wp transient list

# List as JSON
wp transient list --format=json

# Count transients
wp transient list --format=count

# Search for transients
wp transient list --search="feed_*"

# List transient names only
wp transient list --field=name

# List specific fields
wp transient list --fields=name,expiration

# Exclude patterns
wp transient list --exclude="*feed*"

# List network transients (multisite)
wp transient list --network
```

---

## wp transient type

Determines the type of transients implementation.

### Syntax

```bash
wp transient type
```

### Examples

```bash
# Check transient type
wp transient type
# Output: Options (database-based)
# Or: Object Cache (when persistent cache is used)
```

### Notes

- **Options**: Transients are stored in the `wp_options` table
- **Object Cache**: Transients use a persistent object cache (Redis, Memcached, etc.)

When using an object cache, transients bypass the database entirely, which is more performant.

---

## wp transient pluck

Gets a nested value from a transient.

### Syntax

```bash
wp transient pluck <key> <key-path>... [--format=<format>] [--network]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | Transient key |
| `<key-path>...` | Path to nested value |
| `--format=<format>` | Output format |
| `--network` | Network transient (multisite) |

### Examples

```bash
# Get nested value
wp transient pluck my_transient nested_key

# Get deeply nested
wp transient pluck my_transient level1 level2 level3

# Get as JSON
wp transient pluck my_transient data --format=json
```

---

## wp transient patch

Updates a nested value from a transient.

### Syntax

```bash
wp transient patch <action> <key> <key-path>... [<value>] [--format=<format>] [--network]
```

### Options

| Option | Description |
|--------|-------------|
| `<action>` | Patch action: insert, update, delete |
| `<key>` | Transient key |
| `<key-path>...` | Path to nested value |
| `[<value>]` | New value (for insert/update) |
| `--format=<format>` | Value format |
| `--network` | Network transient (multisite) |

### Examples

```bash
# Update nested value
wp transient patch update my_transient settings enabled true

# Insert new nested value
wp transient patch insert my_transient data new_key "value"

# Delete nested value
wp transient patch delete my_transient old_data
```

---

## Common WordPress Transients

WordPress core and plugins use transients for various purposes:

| Transient Pattern | Description |
|-------------------|-------------|
| `update_core` | Core update check data |
| `update_plugins` | Plugin update check data |
| `update_themes` | Theme update check data |
| `feed_*` | Cached RSS feed data |
| `dash_*` | Dashboard widget data |
| `doing_cron` | Cron lock |
| `timeout_*` | Transient expiration data |

---

## Database Storage

When not using an object cache, transients are stored in `wp_options`:

| Option Name Pattern | Description |
|---------------------|-------------|
| `_transient_{name}` | Transient value |
| `_transient_timeout_{name}` | Expiration timestamp |
| `_site_transient_{name}` | Network transient value |
| `_site_transient_timeout_{name}` | Network expiration timestamp |

---

## Practical Examples

### Maintenance

```bash
# Count all transients
wp transient list --format=count

# Delete expired transients (regular maintenance)
wp transient delete --expired

# Check transient storage type
wp transient type

# Find large transients
wp transient list --fields=name,value | head -50
```

### Debugging

```bash
# Check if a specific transient exists
wp transient get my_plugin_data

# List transients from a specific plugin
wp transient list --search="my_plugin_*"

# Check update transients
wp transient get update_plugins --format=json | jq

# View feed transients
wp transient list --search="feed_*"
```

### Cache Busting

```bash
# Clear all update transients to force update check
wp transient delete update_core
wp transient delete update_plugins
wp transient delete update_themes

# Then trigger update check
wp core check-update
wp plugin update --all --dry-run
```

### Performance Optimization

```bash
# Check how many transients are stored
wp transient list --format=count

# If using database (not object cache), clean up periodically
wp transient delete --expired

# Consider switching to object cache if you have many transients
wp transient type
```

### Multisite

```bash
# List network transients
wp transient list --network

# Delete network transients
wp transient delete --all --network

# Set network-wide transient
wp transient set network_notice "Maintenance scheduled" 86400 --network
```

---

## Best Practices

1. **Regular Cleanup**: Schedule `wp transient delete --expired` via cron to prevent `wp_options` table bloat

2. **Use Object Cache**: For high-traffic sites, install a persistent object cache to improve transient performance

3. **Reasonable Expirations**: Always set appropriate expiration times; avoid 0 (never expires) unless necessary

4. **Transient vs Option**: Use transients for cached/regeneratable data, options for persistent settings

5. **Check Before Set**: In code, always handle the case where `get_transient()` returns false

---

## Cron Job for Cleanup

Add to system crontab for regular transient cleanup:

```bash
# Clean expired transients daily at 3 AM
0 3 * * * cd /var/www/mysite && wp transient delete --expired --quiet
```
