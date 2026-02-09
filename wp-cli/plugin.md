# WP-CLI: wp plugin

Manages plugins, including installs, activations, and updates.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp plugin activate` | Activates one or more plugins |
| `wp plugin auto-updates` | Manages plugin auto-updates |
| `wp plugin deactivate` | Deactivates one or more plugins |
| `wp plugin delete` | Deletes plugin files without deactivating or uninstalling |
| `wp plugin get` | Gets details about an installed plugin |
| `wp plugin install` | Installs one or more plugins |
| `wp plugin is-active` | Checks if a given plugin is active |
| `wp plugin is-installed` | Checks if a given plugin is installed |
| `wp plugin list` | Gets a list of plugins |
| `wp plugin path` | Gets the path to a plugin or the plugin directory |
| `wp plugin search` | Searches the WordPress.org plugin directory |
| `wp plugin status` | Reveals the status of one or all plugins |
| `wp plugin toggle` | Toggles a plugin's activation state |
| `wp plugin uninstall` | Uninstalls one or more plugins |
| `wp plugin update` | Updates one or more plugins |
| `wp plugin verify-checksums` | Verifies plugin files against WordPress.org's checksums |

---

## wp plugin install

Installs one or more plugins.

### Syntax

```bash
wp plugin install <plugin|zip|url>... [--version=<version>] [--force] [--ignore-requirements] [--activate] [--activate-network] [--insecure]
```

### Options

| Option | Description |
|--------|-------------|
| `<plugin\|zip\|url>...` | One or more plugins to install. Accepts slug, local zip path, or remote URL |
| `--version=<version>` | Get a particular version from wordpress.org instead of stable |
| `--force` | Overwrite any installed version without prompting |
| `--ignore-requirements` | Install while ignoring WP or PHP version requirements |
| `--activate` | Activate immediately after install |
| `--activate-network` | Network activate immediately after install |
| `--insecure` | Retry downloads without certificate validation if TLS fails |

### Examples

```bash
# Install and activate from wordpress.org
wp plugin install bbpress --activate

# Install specific version
wp plugin install akismet --version=5.0

# Install development version
wp plugin install bbpress --version=dev

# Install from local zip file
wp plugin install ../my-plugin.zip

# Install from remote URL
wp plugin install https://github.com/user/plugin/archive/main.zip --force

# Install multiple plugins
wp plugin install akismet jetpack wordfence --activate

# Forcefully reinstall all installed plugins
wp plugin install $(wp plugin list --field=name) --force
```

---

## wp plugin activate

Activates one or more plugins.

### Syntax

```bash
wp plugin activate [<plugin>...] [--all] [--exclude=<name>] [--network]
```

### Options

| Option | Description |
|--------|-------------|
| `[<plugin>...]` | One or more plugins to activate |
| `--all` | Activate all plugins |
| `--exclude=<name>` | Comma-separated list of plugins to exclude |
| `--network` | Network activate the plugin (multisite) |

### Examples

```bash
# Activate single plugin
wp plugin activate akismet

# Activate multiple plugins
wp plugin activate akismet jetpack

# Activate all plugins
wp plugin activate --all

# Activate all except specific ones
wp plugin activate --all --exclude=debug-bar,query-monitor

# Network activate
wp plugin activate akismet --network
```

---

## wp plugin deactivate

Deactivates one or more plugins.

### Syntax

```bash
wp plugin deactivate [<plugin>...] [--uninstall] [--all] [--exclude=<name>] [--network]
```

### Options

| Option | Description |
|--------|-------------|
| `[<plugin>...]` | One or more plugins to deactivate |
| `--uninstall` | Uninstall after deactivation |
| `--all` | Deactivate all plugins |
| `--exclude=<name>` | Comma-separated list of plugins to exclude |
| `--network` | Network deactivate (multisite) |

### Examples

```bash
# Deactivate single plugin
wp plugin deactivate akismet

# Deactivate and uninstall
wp plugin deactivate akismet --uninstall

# Deactivate all plugins
wp plugin deactivate --all

# Deactivate all except specific ones
wp plugin deactivate --all --exclude=akismet,jetpack
```

---

## wp plugin delete

Deletes plugin files without deactivating or uninstalling.

### Syntax

```bash
wp plugin delete [<plugin>...] [--all] [--exclude=<name>]
```

### Options

| Option | Description |
|--------|-------------|
| `[<plugin>...]` | One or more plugins to delete |
| `--all` | Delete all plugins |
| `--exclude=<name>` | Comma-separated list to exclude |

### Examples

```bash
# Delete single plugin
wp plugin delete hello

# Delete multiple plugins
wp plugin delete hello akismet

# Delete all plugins
wp plugin delete --all
```

---

## wp plugin list

Gets a list of plugins.

### Syntax

```bash
wp plugin list [--<field>=<value>] [--field=<field>] [--fields=<fields>] [--format=<format>] [--status=<status>] [--skip-update-check] [--recently-active]
```

### Options

| Option | Description |
|--------|-------------|
| `--<field>=<value>` | Filter results based on field value |
| `--field=<field>` | Print value of a single field for each plugin |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, count, json, yaml. Default: table |
| `--status=<status>` | Filter by status: active, active-network, dropin, inactive, must-use |
| `--skip-update-check` | Skip the plugin update check |
| `--recently-active` | Show only recently active plugins |

### Available Fields

**Default fields:** name, status, update, version, update_version, auto_update

**Optional fields:** update_package, update_id, title, description, file, author, tested_up_to, requires, requires_php, wporg_status, wporg_last_updated

### Examples

```bash
# List all plugins
wp plugin list

# List active plugins only
wp plugin list --status=active

# List as JSON
wp plugin list --format=json

# Get just plugin names
wp plugin list --field=name

# Check WordPress.org status
wp plugin list --fields=name,wporg_status,wporg_last_updated

# List plugins needing updates
wp plugin list --update=available

# List inactive plugins
wp plugin list --status=inactive

# Count plugins
wp plugin list --format=count

# List must-use plugins
wp plugin list --status=must-use

# List drop-in plugins
wp plugin list --status=dropin
```

---

## wp plugin search

Searches the WordPress.org plugin directory.

### Syntax

```bash
wp plugin search <search> [--page=<page>] [--per-page=<per-page>] [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<search>` | Search keyword |
| `--page=<page>` | Optional page to display. Default: 1 |
| `--per-page=<per-page>` | Optional number of results per page. Default: 10 |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields: name, slug, rating |
| `--format=<format>` | Output format: table, csv, count, json, yaml. Default: table |

### Examples

```bash
# Search for SEO plugins
wp plugin search seo

# Search with more results
wp plugin search seo --per-page=50

# Get just slugs
wp plugin search seo --field=slug

# Search as JSON
wp plugin search seo --format=json
```

---

## wp plugin update

Updates one or more plugins.

### Syntax

```bash
wp plugin update [<plugin>...] [--all] [--exclude=<name>] [--minor] [--patch] [--format=<format>] [--version=<version>] [--dry-run] [--insecure]
```

### Options

| Option | Description |
|--------|-------------|
| `[<plugin>...]` | One or more plugins to update |
| `--all` | Update all plugins with available updates |
| `--exclude=<name>` | Comma-separated list to exclude |
| `--minor` | Only perform updates for minor releases |
| `--patch` | Only perform updates for patch releases |
| `--format=<format>` | Output format: table, csv, json, yaml. Default: table |
| `--version=<version>` | Update to a specific version |
| `--dry-run` | Preview what would be updated |
| `--insecure` | Retry downloads without certificate validation |

### Examples

```bash
# Update specific plugin
wp plugin update akismet

# Update all plugins
wp plugin update --all

# Update all except specific ones
wp plugin update --all --exclude=akismet,jetpack

# Dry run to see what would update
wp plugin update --all --dry-run

# Update to specific version
wp plugin update akismet --version=5.0
```

---

## wp plugin get

Gets details about an installed plugin.

### Syntax

```bash
wp plugin get <plugin> [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<plugin>` | The plugin to get |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, json, yaml. Default: table |

### Examples

```bash
# Get plugin details
wp plugin get akismet

# Get specific fields
wp plugin get akismet --fields=name,version,status

# Get as JSON
wp plugin get akismet --format=json
```

---

## wp plugin is-active

Checks if a given plugin is active.

### Syntax

```bash
wp plugin is-active <plugin> [--network]
```

### Options

| Option | Description |
|--------|-------------|
| `<plugin>` | The plugin to check |
| `--network` | Check if network activated (multisite) |

### Examples

```bash
# Check if plugin is active
wp plugin is-active akismet && echo "Active" || echo "Inactive"

# Check network activation
wp plugin is-active akismet --network
```

---

## wp plugin is-installed

Checks if a given plugin is installed.

### Syntax

```bash
wp plugin is-installed <plugin>
```

### Examples

```bash
# Check if plugin is installed
wp plugin is-installed akismet && echo "Installed" || echo "Not installed"
```

---

## wp plugin path

Gets the path to a plugin or to the plugin directory.

### Syntax

```bash
wp plugin path [<plugin>] [--dir]
```

### Options

| Option | Description |
|--------|-------------|
| `[<plugin>]` | The plugin to get the path to |
| `--dir` | Return the path to the plugin's directory (not main file) |

### Examples

```bash
# Get plugins directory
wp plugin path

# Get specific plugin file path
wp plugin path akismet

# Get plugin directory path
wp plugin path akismet --dir
```

---

## wp plugin status

Reveals the status of one or all plugins.

### Syntax

```bash
wp plugin status [<plugin>]
```

### Examples

```bash
# Show all plugin statuses
wp plugin status

# Show specific plugin status
wp plugin status akismet
```

---

## wp plugin toggle

Toggles a plugin's activation state.

### Syntax

```bash
wp plugin toggle <plugin>... [--network]
```

### Options

| Option | Description |
|--------|-------------|
| `<plugin>...` | One or more plugins to toggle |
| `--network` | Toggle network activation (multisite) |

### Examples

```bash
# Toggle plugin activation
wp plugin toggle akismet

# Toggle multiple plugins
wp plugin toggle akismet jetpack
```

---

## wp plugin uninstall

Uninstalls one or more plugins.

### Syntax

```bash
wp plugin uninstall [<plugin>...] [--deactivate] [--skip-delete] [--all] [--exclude=<name>]
```

### Options

| Option | Description |
|--------|-------------|
| `[<plugin>...]` | Plugins to uninstall |
| `--deactivate` | Deactivate before uninstalling |
| `--skip-delete` | If set, plugin files won't be deleted (only runs uninstall hook) |
| `--all` | Uninstall all plugins |
| `--exclude=<name>` | Comma-separated list to exclude |

### Examples

```bash
# Uninstall plugin (deactivate first if needed)
wp plugin uninstall hello --deactivate

# Uninstall without deleting files
wp plugin uninstall hello --skip-delete
```

---

## wp plugin verify-checksums

Verifies plugin files against WordPress.org's checksums.

### Syntax

```bash
wp plugin verify-checksums [<plugin>...] [--all] [--strict] [--format=<format>] [--insecure] [--exclude=<name>]
```

### Options

| Option | Description |
|--------|-------------|
| `[<plugin>...]` | Plugins to verify |
| `--all` | Verify all plugins |
| `--strict` | Exit with error on any verification failure |
| `--format=<format>` | Output format: table, csv, json, yaml |
| `--insecure` | Retry without certificate validation |
| `--exclude=<name>` | Plugins to exclude |

### Examples

```bash
# Verify specific plugin
wp plugin verify-checksums akismet

# Verify all plugins
wp plugin verify-checksums --all

# Verify with strict mode
wp plugin verify-checksums akismet --strict
```

---

## wp plugin auto-updates

Manages plugin auto-updates.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp plugin auto-updates enable` | Enable auto-updates for plugins |
| `wp plugin auto-updates disable` | Disable auto-updates for plugins |
| `wp plugin auto-updates status` | Show auto-update status |

### Examples

```bash
# Enable auto-updates for a plugin
wp plugin auto-updates enable akismet

# Disable auto-updates
wp plugin auto-updates disable akismet

# Enable for all plugins
wp plugin auto-updates enable --all

# Show status
wp plugin auto-updates status
```
