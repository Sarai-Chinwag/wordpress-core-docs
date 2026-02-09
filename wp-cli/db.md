# WP-CLI: wp db

Performs basic database operations using credentials stored in wp-config.php.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp db check` | Checks the current status of the database |
| `wp db clean` | Removes all tables with `$table_prefix` from the database |
| `wp db cli` | Opens a MySQL console using credentials from wp-config.php |
| `wp db columns` | Displays information about a given table |
| `wp db create` | Creates a new database |
| `wp db drop` | Deletes the existing database |
| `wp db export` | Exports the database to a file or to STDOUT |
| `wp db import` | Imports a database from a file or from STDIN |
| `wp db optimize` | Optimizes the database |
| `wp db prefix` | Displays the database table prefix |
| `wp db query` | Executes a SQL query against the database |
| `wp db repair` | Repairs the database |
| `wp db reset` | Removes all tables from the database |
| `wp db search` | Finds a string in the database |
| `wp db size` | Displays the database name and size |
| `wp db tables` | Lists the database tables |

---

## wp db export

Exports the database to a file or to STDOUT.

### Syntax

```bash
wp db export [<file>] [--dbuser=<value>] [--dbpass=<value>] [--<field>=<value>] [--tables=<tables>] [--exclude_tables=<tables>] [--include-tablespaces] [--porcelain] [--add-drop-table] [--defaults]
```

### Alias

`wp db dump`

### Options

| Option | Description |
|--------|-------------|
| `[<file>]` | The name of the SQL file to export. If '-', outputs to STDOUT |
| `--dbuser=<value>` | Username to pass to mysqldump. Defaults to DB_USER |
| `--dbpass=<value>` | Password to pass to mysqldump. Defaults to DB_PASSWORD |
| `--tables=<tables>` | Comma-separated list of tables to export |
| `--exclude_tables=<tables>` | Comma-separated list of tables to skip |
| `--include-tablespaces` | Skip adding --no-tablespaces option to mysqldump |
| `--porcelain` | Output filename for the exported database |
| `--add-drop-table` | Include DROP TABLE IF EXISTS before each CREATE TABLE |
| `--defaults` | Load environment's MySQL option files |
| `--<field>=<value>` | Extra arguments to pass to mysqldump |

### Examples

```bash
# Export database (auto-generated filename)
wp db export

# Export to specific file
wp db export backup.sql

# Export with DROP TABLE statements
wp db export --add-drop-table

# Export specific tables
wp db export --tables=wp_options,wp_users

# Export tables matching wildcard
wp db export --tables=$(wp db tables 'wp_user*' --format=csv)

# Export all tables with prefix
wp db export --tables=$(wp db tables --all-tables-with-prefix --format=csv)

# Skip specific tables
wp db export --exclude_tables=wp_options,wp_posts

# Export to STDOUT
wp db export -

# Export with custom WHERE clause
wp db export --no-create-info=true --tables=wp_posts --where="ID in (100,101,102)"

# Export related meta
wp db export --no-create-info=true --tables=wp_postmeta --where="post_id in (100,101,102)"

# Get just the filename
wp db export --porcelain
```

---

## wp db import

Imports a database from a file or from STDIN.

### Syntax

```bash
wp db import [<file>] [--dbuser=<value>] [--dbpass=<value>] [--<field>=<value>] [--skip-optimization] [--defaults]
```

### Options

| Option | Description |
|--------|-------------|
| `[<file>]` | The name of the SQL file to import. If '-', reads from STDIN |
| `--dbuser=<value>` | Username to pass to mysql. Defaults to DB_USER |
| `--dbpass=<value>` | Password to pass to mysql. Defaults to DB_PASSWORD |
| `--skip-optimization` | Don't disable auto-commit and key checks during import |
| `--defaults` | Load environment's MySQL option files |
| `--<field>=<value>` | Extra arguments to pass to mysql |

### Examples

```bash
# Import from file
wp db import backup.sql

# Import with auto-discovered filename
wp db import

# Import from STDIN
cat backup.sql | wp db import -

# Import without optimizations
wp db import backup.sql --skip-optimization
```

---

## wp db query

Executes a SQL query against the database.

### Syntax

```bash
wp db query [<sql>] [--dbuser=<value>] [--dbpass=<value>] [--<field>=<value>] [--defaults]
```

### Options

| Option | Description |
|--------|-------------|
| `[<sql>]` | A SQL query. If not passed, reads from STDIN |
| `--dbuser=<value>` | Username. Defaults to DB_USER |
| `--dbpass=<value>` | Password. Defaults to DB_PASSWORD |
| `--defaults` | Load environment's MySQL option files |
| `--<field>=<value>` | Extra arguments to pass to mysql |

### Examples

```bash
# Execute query
wp db query "SELECT * FROM wp_options LIMIT 10"

# Get specific value
wp db query 'SELECT option_value FROM wp_options WHERE option_name="siteurl"'

# Skip column names in output
wp db query 'SELECT option_value FROM wp_options WHERE option_name="home"' --skip-column-names

# Execute query from file
wp db query < script.sql

# Count posts
wp db query "SELECT COUNT(*) FROM wp_posts WHERE post_status='publish'"

# Check all tables
wp db query "CHECK TABLE $(wp db tables | paste -s -d, -);"

# Show table structure
wp db query "DESCRIBE wp_posts"

# Show create table
wp db query "SHOW CREATE TABLE wp_posts"

# Complex query with JOIN
wp db query "SELECT p.post_title, u.user_login FROM wp_posts p JOIN wp_users u ON p.post_author = u.ID LIMIT 10"
```

### Multisite Note

The global `--url` parameter has no effect on `wp db query`. For multisite, manually modify table names to include site ID (e.g., `wp_2_options` for site 2).

---

## wp db search

Finds a string in the database.

### Syntax

```bash
wp db search <search> [<tables>...] [--network] [--all-tables-with-prefix] [--all-tables] [--before_context=<num>] [--after_context=<num>] [--regex] [--regex-flags=<flags>] [--regex-delimiter=<delim>] [--table_column_once] [--one_line] [--matches_only] [--stats] [--table_column_color=<color>] [--id_color=<color>] [--match_color=<color>]
```

### Options

| Option | Description |
|--------|-------------|
| `<search>` | String to search for |
| `[<tables>...]` | Tables to search. Default: all tables |
| `--network` | Search through multisite tables |
| `--all-tables-with-prefix` | Search tables matching prefix |
| `--all-tables` | Search ALL tables in database |
| `--before_context=<num>` | Number of characters to display before match |
| `--after_context=<num>` | Number of characters to display after match |
| `--regex` | Use regular expression |
| `--regex-flags=<flags>` | PCRE modifiers (e.g., 'i' for case-insensitive) |
| `--table_column_once` | Show table:column only once per row |
| `--one_line` | One result per line |
| `--matches_only` | Only show matching strings |
| `--stats` | Show match statistics |

### Examples

```bash
# Search for string
wp db search "old-domain.com"

# Search in specific tables
wp db search "old-domain.com" wp_posts wp_postmeta

# Search with context
wp db search "old-domain.com" --before_context=40 --after_context=40

# Case-insensitive regex search
wp db search "https?://example" --regex --regex-flags=i

# Search and show stats
wp db search "old-domain.com" --stats

# Show matches only
wp db search "old-domain.com" --matches_only
```

---

## wp db optimize

Optimizes the database.

### Syntax

```bash
wp db optimize
```

### Examples

```bash
# Optimize all tables
wp db optimize
```

---

## wp db repair

Repairs the database.

### Syntax

```bash
wp db repair
```

### Examples

```bash
# Repair all tables
wp db repair
```

---

## wp db check

Checks the current status of the database.

### Syntax

```bash
wp db check
```

### Examples

```bash
# Check database status
wp db check
```

---

## wp db create

Creates a new database.

### Syntax

```bash
wp db create [--dbuser=<value>] [--dbpass=<value>]
```

### Examples

```bash
# Create database using wp-config.php credentials
wp db create
```

---

## wp db drop

Deletes the existing database.

### Syntax

```bash
wp db drop [--yes] [--dbuser=<value>] [--dbpass=<value>]
```

### Options

| Option | Description |
|--------|-------------|
| `--yes` | Answer yes to confirmation message |

### Examples

```bash
# Drop database (with confirmation)
wp db drop

# Drop database without confirmation
wp db drop --yes
```

---

## wp db reset

Removes all tables from the database.

### Syntax

```bash
wp db reset [--yes] [--dbuser=<value>] [--dbpass=<value>]
```

### Options

| Option | Description |
|--------|-------------|
| `--yes` | Answer yes to confirmation message |

### Examples

```bash
# Reset database (with confirmation)
wp db reset

# Reset without confirmation
wp db reset --yes
```

---

## wp db clean

Removes all tables with `$table_prefix` from the database.

### Syntax

```bash
wp db clean [--yes]
```

### Options

| Option | Description |
|--------|-------------|
| `--yes` | Answer yes to confirmation message |

### Examples

```bash
# Clean tables with prefix
wp db clean --yes
```

---

## wp db tables

Lists the database tables.

### Syntax

```bash
wp db tables [<table>...] [--scope=<scope>] [--network] [--all-tables-with-prefix] [--all-tables] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `[<table>...]` | List specific tables. Wildcards supported |
| `--scope=<scope>` | Scope: all, global, ms_global, blog, old |
| `--network` | List tables for all sites in network |
| `--all-tables-with-prefix` | List all tables with the current prefix |
| `--all-tables` | List all tables in the database |
| `--format=<format>` | Output format: list, csv |

### Examples

```bash
# List all WordPress tables
wp db tables

# List tables matching pattern
wp db tables 'wp_post*'

# List as CSV
wp db tables --format=csv

# List all tables with prefix
wp db tables --all-tables-with-prefix

# List all tables in database
wp db tables --all-tables
```

---

## wp db cli

Opens a MySQL console using credentials from wp-config.php.

### Syntax

```bash
wp db cli [--database=<database>] [--default-character-set=<charset>] [--dbuser=<value>] [--dbpass=<value>] [--<field>=<value>] [--defaults]
```

### Examples

```bash
# Open MySQL console
wp db cli

# Open with specific database
wp db cli --database=other_db
```

---

## wp db size

Displays the database name and size.

### Syntax

```bash
wp db size [--size_format=<format>] [--tables] [--human-readable] [--format=<format>] [--scope=<scope>] [--network] [--all-tables-with-prefix] [--all-tables] [--order=<order>] [--orderby=<orderby>]
```

### Options

| Option | Description |
|--------|-------------|
| `--size_format=<format>` | Size format: b, kb, mb, gb, tb |
| `--tables` | Show size for each table |
| `--human-readable` | Human readable sizes |
| `--format=<format>` | Output format: table, csv, json, yaml |
| `--order=<order>` | Order: asc, desc |
| `--orderby=<orderby>` | Order by: name, size |

### Examples

```bash
# Show database size
wp db size

# Show size in MB
wp db size --size_format=mb

# Show table sizes
wp db size --tables

# Human readable with table breakdown
wp db size --tables --human-readable

# Order tables by size
wp db size --tables --orderby=size --order=desc
```

---

## wp db prefix

Displays the database table prefix.

### Syntax

```bash
wp db prefix
```

### Examples

```bash
# Get table prefix
wp db prefix
# Output: wp_
```

---

## wp db columns

Displays information about a given table.

### Syntax

```bash
wp db columns <table> [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<table>` | Name of the table |
| `--format=<format>` | Output format: table, csv, json, yaml |

### Examples

```bash
# Show columns for posts table
wp db columns wp_posts

# Show as JSON
wp db columns wp_posts --format=json
```

---

## Practical Examples

### Backup and Restore

```bash
# Create timestamped backup
wp db export backup-$(date +%Y%m%d-%H%M%S).sql

# Restore from backup
wp db import backup-20240101-120000.sql

# Backup specific tables
wp db export --tables=wp_posts,wp_postmeta posts-backup.sql
```

### Database Maintenance

```bash
# Check, repair, and optimize
wp db check
wp db repair
wp db optimize

# Find large tables
wp db size --tables --orderby=size --order=desc --human-readable
```

### Site Migration

```bash
# Export database
wp db export migration.sql

# On new server, import
wp db import migration.sql

# Then search-replace URLs
wp search-replace "old-domain.com" "new-domain.com"
```

### Debugging

```bash
# Find where a string appears
wp db search "broken-link.com" --stats

# Check for orphaned postmeta
wp db query "SELECT pm.meta_id FROM wp_postmeta pm LEFT JOIN wp_posts p ON pm.post_id = p.ID WHERE p.ID IS NULL"

# Find posts by specific author
wp db query "SELECT ID, post_title FROM wp_posts WHERE post_author = 1 AND post_status = 'publish'"
```
