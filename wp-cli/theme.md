# WP-CLI: wp theme

Manages themes, including installs, activations, and updates.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp theme activate` | Activates a theme |
| `wp theme auto-updates` | Manages theme auto-updates |
| `wp theme delete` | Deletes one or more themes |
| `wp theme disable` | Disables a theme on a WordPress multisite install |
| `wp theme enable` | Enables a theme on a WordPress multisite install |
| `wp theme get` | Gets details about a theme |
| `wp theme install` | Installs one or more themes |
| `wp theme is-active` | Checks if a given theme is active |
| `wp theme is-installed` | Checks if a given theme is installed |
| `wp theme list` | Gets a list of themes |
| `wp theme mod` | Sets, gets, and removes theme mods |
| `wp theme path` | Gets the path to a theme or to the theme directory |
| `wp theme search` | Searches the WordPress.org theme directory |
| `wp theme status` | Reveals the status of one or all themes |
| `wp theme update` | Updates one or more themes |

---

## wp theme install

Installs one or more themes.

### Syntax

```bash
wp theme install <theme|zip|url>... [--version=<version>] [--force] [--activate] [--insecure]
```

### Options

| Option | Description |
|--------|-------------|
| `<theme\|zip\|url>...` | One or more themes to install. Accepts slug, local zip path, or remote URL |
| `--version=<version>` | Get a particular version from wordpress.org |
| `--force` | Overwrite any installed version without prompting |
| `--activate` | Activate the theme immediately after install |
| `--insecure` | Retry downloads without certificate validation |

### Examples

```bash
# Install and activate a theme
wp theme install twentytwentyfour --activate

# Install specific version
wp theme install twentytwentythree --version=1.2

# Install from local zip
wp theme install ../my-theme.zip

# Install from URL
wp theme install https://github.com/user/theme/archive/main.zip --force

# Install multiple themes
wp theme install twentytwentyfour twentytwentythree

# Force reinstall
wp theme install twentytwentyfour --force
```

---

## wp theme activate

Activates a theme.

### Syntax

```bash
wp theme activate <theme>
```

### Options

| Option | Description |
|--------|-------------|
| `<theme>` | The theme slug to activate |

### Examples

```bash
# Activate a theme
wp theme activate twentytwentyfour

# Activate child theme
wp theme activate my-child-theme
```

---

## wp theme delete

Deletes one or more themes.

### Syntax

```bash
wp theme delete [<theme>...] [--all] [--force]
```

### Options

| Option | Description |
|--------|-------------|
| `[<theme>...]` | One or more themes to delete |
| `--all` | Delete all themes except the active one |
| `--force` | Delete even if the theme is active (will switch to default first) |

### Examples

```bash
# Delete a theme
wp theme delete twentytwentyone

# Delete multiple themes
wp theme delete twentytwentyone twentytwenty

# Delete all inactive themes
wp theme delete --all
```

---

## wp theme list

Gets a list of themes.

### Syntax

```bash
wp theme list [--<field>=<value>] [--field=<field>] [--fields=<fields>] [--format=<format>] [--status=<status>] [--skip-update-check]
```

### Options

| Option | Description |
|--------|-------------|
| `--<field>=<value>` | Filter results based on field value |
| `--field=<field>` | Print value of a single field for each theme |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, count, json, yaml. Default: table |
| `--status=<status>` | Filter by status: active, parent, inactive |
| `--skip-update-check` | Skip the theme update check |

### Available Fields

- name
- status
- update
- version
- update_version
- auto_update

### Examples

```bash
# List all themes
wp theme list

# List as JSON
wp theme list --format=json

# Get just theme names
wp theme list --field=name

# List only active theme
wp theme list --status=active

# List inactive themes
wp theme list --status=inactive

# Count themes
wp theme list --format=count
```

---

## wp theme search

Searches the WordPress.org theme directory.

### Syntax

```bash
wp theme search <search> [--page=<page>] [--per-page=<per-page>] [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<search>` | Search keyword |
| `--page=<page>` | Page to display. Default: 1 |
| `--per-page=<per-page>` | Results per page. Default: 10 |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, count, json, yaml |

### Examples

```bash
# Search for themes
wp theme search developer

# Search with more results
wp theme search developer --per-page=50

# Get just slugs
wp theme search developer --field=slug

# Search as JSON
wp theme search developer --format=json
```

---

## wp theme update

Updates one or more themes.

### Syntax

```bash
wp theme update [<theme>...] [--all] [--exclude=<name>] [--minor] [--patch] [--format=<format>] [--version=<version>] [--dry-run] [--insecure]
```

### Options

| Option | Description |
|--------|-------------|
| `[<theme>...]` | One or more themes to update |
| `--all` | Update all themes with available updates |
| `--exclude=<name>` | Comma-separated list to exclude |
| `--minor` | Only update minor releases |
| `--patch` | Only update patch releases |
| `--format=<format>` | Output format: table, csv, json, yaml |
| `--version=<version>` | Update to specific version |
| `--dry-run` | Preview what would be updated |
| `--insecure` | Retry downloads without certificate validation |

### Examples

```bash
# Update specific theme
wp theme update twentytwentyfour

# Update all themes
wp theme update --all

# Exclude themes from update
wp theme update --all --exclude=my-theme,other-theme

# Dry run
wp theme update --all --dry-run
```

---

## wp theme get

Gets details about a theme.

### Syntax

```bash
wp theme get <theme> [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<theme>` | The theme to get |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, json, yaml |

### Examples

```bash
# Get theme details
wp theme get twentytwentyfour

# Get specific fields
wp theme get twentytwentyfour --fields=name,title,version

# Get as JSON
wp theme get twentytwentyfour --format=json
```

---

## wp theme is-active

Checks if a given theme is active.

### Syntax

```bash
wp theme is-active <theme>
```

### Examples

```bash
# Check if theme is active
wp theme is-active twentytwentyfour && echo "Active" || echo "Not active"
```

---

## wp theme is-installed

Checks if a given theme is installed.

### Syntax

```bash
wp theme is-installed <theme>
```

### Examples

```bash
# Check if theme is installed
wp theme is-installed twentytwentyfour && echo "Installed" || echo "Not installed"
```

---

## wp theme path

Gets the path to a theme or to the theme directory.

### Syntax

```bash
wp theme path [<theme>] [--dir]
```

### Options

| Option | Description |
|--------|-------------|
| `[<theme>]` | The theme to get the path to |
| `--dir` | Return the path to the theme's directory |

### Examples

```bash
# Get themes directory
wp theme path

# Get specific theme path
wp theme path twentytwentyfour

# Get theme directory path
wp theme path twentytwentyfour --dir
```

---

## wp theme status

Reveals the status of one or all themes.

### Syntax

```bash
wp theme status [<theme>]
```

### Examples

```bash
# Show all theme statuses
wp theme status

# Show specific theme status
wp theme status twentytwentyfour
```

---

## wp theme mod

Sets, gets, and removes theme mods.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp theme mod get` | Gets theme mod value |
| `wp theme mod set` | Sets theme mod value |
| `wp theme mod list` | Lists all theme mods |
| `wp theme mod remove` | Removes theme mod |

### Examples

```bash
# List all theme mods
wp theme mod list

# Get specific mod
wp theme mod get background_color

# Set mod value
wp theme mod set background_color 000000

# Remove mod
wp theme mod remove background_color
```

---

## wp theme enable

Enables a theme on a WordPress multisite install.

### Syntax

```bash
wp theme enable <theme> [--network] [--activate]
```

### Options

| Option | Description |
|--------|-------------|
| `<theme>` | The theme to enable |
| `--network` | Enable for the entire network |
| `--activate` | Activate the theme after enabling |

### Examples

```bash
# Enable theme for network
wp theme enable twentytwentyfour --network

# Enable and activate
wp theme enable twentytwentyfour --network --activate
```

---

## wp theme disable

Disables a theme on a WordPress multisite install.

### Syntax

```bash
wp theme disable <theme> [--network]
```

### Options

| Option | Description |
|--------|-------------|
| `<theme>` | The theme to disable |
| `--network` | Disable for the entire network |

### Examples

```bash
# Disable theme from network
wp theme disable twentytwentyfour --network
```

---

## wp theme auto-updates

Manages theme auto-updates.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp theme auto-updates enable` | Enable auto-updates for themes |
| `wp theme auto-updates disable` | Disable auto-updates for themes |
| `wp theme auto-updates status` | Show auto-update status |

### Examples

```bash
# Enable auto-updates for a theme
wp theme auto-updates enable twentytwentyfour

# Disable auto-updates
wp theme auto-updates disable twentytwentyfour

# Enable for all themes
wp theme auto-updates enable --all

# Show status
wp theme auto-updates status
```
