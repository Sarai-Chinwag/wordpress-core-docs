# WP-CLI: wp option

Retrieves and sets site options, including plugin and WordPress settings.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp option add` | Adds a new option value |
| `wp option delete` | Deletes an option |
| `wp option get` | Gets the value for an option |
| `wp option get-autoload` | Gets the 'autoload' value for an option |
| `wp option list` | Lists options and their values |
| `wp option patch` | Updates a nested value in an option |
| `wp option pluck` | Gets a nested value from an option |
| `wp option set-autoload` | Sets the 'autoload' value for an option |
| `wp option update` | Updates an option value |

---

## wp option get

Gets the value for an option.

### Syntax

```bash
wp option get <key> [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | The option name |
| `--format=<format>` | Output format: var_export, json, yaml. Default: var_export |

### Examples

```bash
# Get site URL
wp option get siteurl

# Get home URL
wp option get home

# Get blog name
wp option get blogname

# Get as JSON
wp option get active_plugins --format=json

# Get admin email
wp option get admin_email

# Get date format
wp option get date_format

# Get time format
wp option get time_format

# Get timezone
wp option get timezone_string

# Get permalink structure
wp option get permalink_structure

# Get posts per page
wp option get posts_per_page
```

---

## wp option add

Adds a new option value.

### Syntax

```bash
wp option add <key> [<value>] [--format=<format>] [--autoload=<autoload>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | The name of the option to add |
| `[<value>]` | The value for the option. Reads from STDIN if not provided |
| `--format=<format>` | Format for the value: plaintext, json. Default: plaintext |
| `--autoload=<autoload>` | Should this option be autoloaded: yes, no. Default: yes |

### Examples

```bash
# Add simple option
wp option add my_option "my value"

# Add JSON option
wp option add my_settings '{"key": "value", "enabled": true}' --format=json

# Add option without autoload
wp option add large_data "lots of data" --autoload=no

# Add option from STDIN
echo "value from stdin" | wp option add my_stdin_option

# Add numeric option
wp option add my_number 42
```

---

## wp option update

Updates an option value.

### Syntax

```bash
wp option update <key> [<value>] [--autoload=<autoload>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | The name of the option to update |
| `[<value>]` | The new value. Reads from STDIN if not provided |
| `--autoload=<autoload>` | Set autoload: yes, no |
| `--format=<format>` | Format for the value: plaintext, json. Default: plaintext |

### Examples

```bash
# Update site URL
wp option update siteurl "https://example.com"

# Update home URL
wp option update home "https://example.com"

# Update blog name
wp option update blogname "My Awesome Blog"

# Update admin email
wp option update admin_email "admin@example.com"

# Update permalink structure
wp option update permalink_structure "/%postname%/"

# Update JSON option
wp option update my_settings '{"foo": "bar"}' --format=json

# Update and set autoload
wp option update my_option "new value" --autoload=no

# Update from STDIN
echo "new value" | wp option update my_option

# Update timezone
wp option update timezone_string "America/New_York"

# Update posts per page
wp option update posts_per_page 20
```

---

## wp option delete

Deletes an option.

### Syntax

```bash
wp option delete <key>...
```

### Options

| Option | Description |
|--------|-------------|
| `<key>...` | One or more options to delete |

### Examples

```bash
# Delete option
wp option delete my_option

# Delete multiple options
wp option delete option1 option2 option3

# Delete transient-related options
wp option delete _transient_feed_*
```

---

## wp option list

Lists options and their values.

### Syntax

```bash
wp option list [--search=<pattern>] [--exclude=<pattern>] [--autoload=<value>] [--transients] [--unserialize] [--field=<field>] [--fields=<fields>] [--format=<format>] [--orderby=<fields>] [--order=<order>]
```

### Options

| Option | Description |
|--------|-------------|
| `--search=<pattern>` | Use wildcards (*?) to match option name |
| `--exclude=<pattern>` | Pattern to exclude options from listing |
| `--autoload=<value>` | Filter by autoload value: on, off, yes, no |
| `--transients` | List only transients |
| `--unserialize` | Unserialize values in output |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, json, count, yaml |
| `--orderby=<fields>` | Order by: option_id, option_name, option_value |
| `--order=<order>` | Order direction: asc, desc |

### Available Fields

- option_id
- option_name
- option_value
- autoload

### Examples

```bash
# List all options
wp option list

# List as JSON
wp option list --format=json

# Search for options
wp option list --search="siteurl"

# Search with wildcard
wp option list --search="*_transient_*"

# List only autoloaded options
wp option list --autoload=yes

# List non-autoloaded options
wp option list --autoload=no

# List transients only
wp option list --transients

# Count options
wp option list --format=count

# List specific fields
wp option list --fields=option_name,autoload

# Exclude patterns
wp option list --exclude="_transient_*"

# Get option names only
wp option list --field=option_name

# Order by name
wp option list --orderby=option_name --order=asc
```

---

## wp option pluck

Gets a nested value from an option.

### Syntax

```bash
wp option pluck <key> <key-path>... [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | The option name |
| `<key-path>...` | Path to the nested value |
| `--format=<format>` | Output format: var_export, json, yaml |

### Examples

```bash
# Get nested value from serialized option
wp option pluck my_settings key1

# Get deeply nested value
wp option pluck my_settings section subsection value

# Get array index
wp option pluck active_plugins 0

# Output as JSON
wp option pluck my_settings --format=json
```

---

## wp option patch

Updates a nested value in an option.

### Syntax

```bash
wp option patch <action> <key> <key-path>... [<value>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<action>` | The action to perform: insert, update, delete |
| `<key>` | The option name |
| `<key-path>...` | Path to the nested value |
| `[<value>]` | The new value (for insert/update) |
| `--format=<format>` | Format for the value: plaintext, json |

### Examples

```bash
# Update nested value
wp option patch update my_settings key1 "new value"

# Insert new nested value
wp option patch insert my_settings new_key "new value"

# Delete nested value
wp option patch delete my_settings old_key

# Update deeply nested value
wp option patch update my_settings section subsection "value"

# Update with JSON
wp option patch update my_settings data '{"nested": "value"}' --format=json
```

---

## wp option get-autoload

Gets the 'autoload' value for an option.

### Syntax

```bash
wp option get-autoload <key>
```

### Examples

```bash
# Check if option is autoloaded
wp option get-autoload siteurl
# Output: yes

wp option get-autoload large_cached_data
# Output: no
```

---

## wp option set-autoload

Sets the 'autoload' value for an option.

### Syntax

```bash
wp option set-autoload <key> <autoload>
```

### Options

| Option | Description |
|--------|-------------|
| `<key>` | The option name |
| `<autoload>` | The autoload value: yes, no |

### Examples

```bash
# Disable autoload for large option
wp option set-autoload large_cached_data no

# Enable autoload
wp option set-autoload my_important_option yes
```

---

## Common WordPress Options

### Site Settings

| Option | Description |
|--------|-------------|
| `siteurl` | WordPress address (URL) |
| `home` | Site address (URL) |
| `blogname` | Site title |
| `blogdescription` | Site tagline |
| `admin_email` | Admin email address |
| `users_can_register` | Whether users can register |
| `default_role` | Default role for new users |

### Reading Settings

| Option | Description |
|--------|-------------|
| `posts_per_page` | Blog pages show at most |
| `posts_per_rss` | Syndication feeds show |
| `show_on_front` | Front page displays: posts or page |
| `page_on_front` | Front page ID |
| `page_for_posts` | Posts page ID |

### Discussion Settings

| Option | Description |
|--------|-------------|
| `default_comment_status` | Default comment status |
| `default_ping_status` | Default ping status |
| `comment_moderation` | Comment must be manually approved |
| `comment_registration` | Users must be registered to comment |

### Permalinks

| Option | Description |
|--------|-------------|
| `permalink_structure` | Custom permalink structure |
| `category_base` | Category base |
| `tag_base` | Tag base |

### Date/Time

| Option | Description |
|--------|-------------|
| `date_format` | Date format |
| `time_format` | Time format |
| `timezone_string` | Timezone |
| `gmt_offset` | UTC offset |
| `start_of_week` | Week starts on |

---

## Practical Examples

### Site Migration

```bash
# Update URLs after domain change
wp option update siteurl "https://newdomain.com"
wp option update home "https://newdomain.com"

# Also run search-replace for content
wp search-replace "olddomain.com" "newdomain.com"
```

### Performance Optimization

```bash
# Find large autoloaded options
wp option list --autoload=yes --format=csv | awk -F, '{print length($3), $2}' | sort -rn | head -20

# Disable autoload for large options
wp option set-autoload heavy_option no
```

### Debugging

```bash
# Check active plugins
wp option get active_plugins --format=json | jq

# Check theme mods
wp option get theme_mods_mytheme --format=json

# List all transients
wp option list --search="_transient_*" --format=count
```
