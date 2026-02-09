# WP-CLI: wp search-replace

Searches/replaces strings in the database.

Search/replace intelligently handles PHP serialized data and does not change primary key values.

## Syntax

```bash
wp search-replace <old> <new> [<table>...] [--dry-run] [--network] [--all-tables-with-prefix] [--all-tables] [--export[=<file>]] [--export_insert_size=<rows>] [--skip-tables=<tables>] [--skip-columns=<columns>] [--include-columns=<columns>] [--precise] [--recurse-objects] [--verbose] [--regex] [--regex-flags=<regex-flags>] [--regex-delimiter=<regex-delimiter>] [--regex-limit=<regex-limit>] [--format=<format>] [--report] [--report-changed-only] [--log[=<file>]] [--before_context=<num>] [--after_context=<num>]
```

## Options

| Option | Description |
|--------|-------------|
| `<old>` | A string to search for within the database |
| `<new>` | Replace instances of the first string with this new string |
| `[<table>...]` | Tables to restrict the replacement to. Wildcards supported |
| `--dry-run` | Run the operation and show report, but don't save changes |
| `--network` | Search/replace through all tables in a multisite install |
| `--all-tables-with-prefix` | Enable on any tables matching the prefix |
| `--all-tables` | Enable on ALL tables in the database |
| `--export[=<file>]` | Write transformed data as SQL file instead of database |
| `--export_insert_size=<rows>` | Rows per INSERT statement. Default: 50 |
| `--skip-tables=<tables>` | Comma-separated tables to skip. Wildcards supported |
| `--skip-columns=<columns>` | Comma-separated columns to skip |
| `--include-columns=<columns>` | Only perform on specific columns |
| `--precise` | Force PHP instead of SQL (slower but more thorough) |
| `--recurse-objects` | Recurse into objects to replace. Default: true |
| `--verbose` | Print rows as they're updated |
| `--regex` | Use regular expression (without delimiters) |
| `--regex-flags=<flags>` | PCRE modifiers (e.g., 'i' for case-insensitive) |
| `--regex-delimiter=<delimiter>` | Regex delimiter. Default: / |
| `--regex-limit=<limit>` | Maximum replacements per row |
| `--format=<format>` | Output format: table, count. Default: table |
| `--report` | Show report of changes made |
| `--report-changed-only` | Only show tables with changes |
| `--log[=<file>]` | Log replacements to a file |
| `--before_context=<num>` | Characters before match in log |
| `--after_context=<num>` | Characters after match in log |

---

## Basic Examples

### Simple String Replacement

```bash
# Replace string
wp search-replace "old-string" "new-string"

# Dry run to see what would change
wp search-replace "old-string" "new-string" --dry-run
```

### Domain Migration

```bash
# Change site URL
wp search-replace "http://old-domain.com" "https://new-domain.com"

# Change domain with dry run first
wp search-replace "old-domain.com" "new-domain.com" --dry-run

# Include all tables with prefix
wp search-replace "old-domain.com" "new-domain.com" --all-tables-with-prefix
```

### HTTP to HTTPS Migration

```bash
# Change protocol
wp search-replace "http://example.com" "https://example.com"

# Or just protocol everywhere
wp search-replace "http://" "https://" --precise
```

---

## Table Filtering

### Specific Tables

```bash
# Only posts and postmeta
wp search-replace "old" "new" wp_posts wp_postmeta

# Using wildcards
wp search-replace "old" "new" 'wp_post*'
```

### Skip Tables

```bash
# Skip certain tables
wp search-replace "old" "new" --skip-tables=wp_users,wp_usermeta

# Skip with wildcards
wp search-replace "old" "new" --skip-tables='wp_*meta'
```

### Column Filtering

```bash
# Only specific columns
wp search-replace "old" "new" --include-columns=post_content,post_excerpt

# Skip specific columns
wp search-replace "old" "new" --skip-columns=guid,post_name
```

---

## Regular Expressions

```bash
# Basic regex
wp search-replace "(https?://)oldsite\.com" "\$1newsite.com" --regex

# Case-insensitive
wp search-replace "OLD-DOMAIN" "new-domain" --regex --regex-flags=i

# Multiple patterns
wp search-replace "(old|legacy)\.example\.com" "new.example.com" --regex

# Limit replacements per row
wp search-replace "pattern" "replacement" --regex --regex-limit=1
```

### Regex Examples

```bash
# Remove width/height from images
wp search-replace ' width="\d+"' '' --regex
wp search-replace ' height="\d+"' '' --regex

# Update image URLs
wp search-replace 'src="http://old\.com/wp-content/uploads/' 'src="https://cdn.new.com/uploads/' --regex

# Fix protocol-relative URLs
wp search-replace '(src|href)="\/\/' '\$1="https://' --regex
```

**Note**: Regex search-replace is 15-20x slower than standard search-replace.

---

## Export Mode

Instead of modifying the database, export as SQL:

```bash
# Export to file
wp search-replace "old" "new" --export=migrated.sql

# Export to STDOUT
wp search-replace "old" "new" --export

# Control INSERT size
wp search-replace "old" "new" --export=migrated.sql --export_insert_size=100
```

---

## Multisite

```bash
# Search across network
wp search-replace "old" "new" --network

# Specific site in network
wp search-replace "old" "new" --url=site2.example.com
```

---

## Reporting and Logging

```bash
# Show detailed report
wp search-replace "old" "new" --report

# Only show changed tables
wp search-replace "old" "new" --report-changed-only

# Log all replacements
wp search-replace "old" "new" --log=changes.log

# Log with context
wp search-replace "old" "new" --log=changes.log --before_context=20 --after_context=20

# Verbose output
wp search-replace "old" "new" --verbose
```

---

## Practical Use Cases

### Site Migration Checklist

```bash
# 1. Backup first!
wp db export backup-before-migration.sql

# 2. Dry run
wp search-replace "http://old.com" "https://new.com" --dry-run

# 3. Execute
wp search-replace "http://old.com" "https://new.com" --all-tables-with-prefix --report

# 4. Update siteurl and home if needed
wp option update siteurl "https://new.com"
wp option update home "https://new.com"

# 5. Flush cache
wp cache flush
wp rewrite flush
```

### Fixing Serialized Data

The `--precise` flag ensures serialized data is properly handled:

```bash
# Safe for serialized data (default behavior handles this)
wp search-replace "old-path" "new-path"

# Extra thorough (slower)
wp search-replace "old-path" "new-path" --precise
```

### Content Cleanup

```bash
# Remove tracking parameters
wp search-replace '?utm_[^"]*"' '"' --regex wp_posts --include-columns=post_content

# Fix broken links
wp search-replace "broken-link.com" "working-link.com" wp_posts wp_postmeta

# Remove hardcoded domain from content
wp search-replace 'href="http://example.com/' 'href="/' --regex wp_posts
```

### Developer Environment Setup

```bash
# Clone production to local
wp db import production-dump.sql
wp search-replace "https://production.com" "http://local.test" --all-tables-with-prefix
wp search-replace "/var/www/production" "/Users/dev/sites/local" --all-tables-with-prefix
```

### Staging Environment

```bash
# Staging subdomain
wp search-replace "https://example.com" "https://staging.example.com" --all-tables-with-prefix

# Or staging subdirectory
wp search-replace "https://example.com" "https://example.com/staging" --all-tables-with-prefix
```

---

## Important Notes

### GUID Column

By default, search-replace skips the `guid` column because changing GUIDs can cause issues with RSS feeds and other systems. To include it:

```bash
# Include guid (usually not recommended)
wp search-replace "old" "new" --include-columns=guid
```

### Serialized Data

WP-CLI automatically handles serialized data. The string length in serialized arrays is recalculated after replacement, preventing data corruption.

### Backup First

**Always backup before search-replace:**

```bash
# Backup
wp db export pre-search-replace-$(date +%Y%m%d).sql

# Then search-replace
wp search-replace "old" "new"
```

### Test with Dry Run

```bash
# Always test first
wp search-replace "old" "new" --dry-run

# Review the report
wp search-replace "old" "new" --dry-run --report
```

---

## Output Example

```
+------------------+-----------------------+--------------+------+
| Table            | Column                | Replacements | Type |
+------------------+-----------------------+--------------+------+
| wp_options       | option_value          | 15           | PHP  |
| wp_posts         | post_content          | 42           | PHP  |
| wp_posts         | post_excerpt          | 3            | PHP  |
| wp_posts         | guid                  | 0            | SQL  |
| wp_postmeta      | meta_value            | 28           | PHP  |
+------------------+-----------------------+--------------+------+
Success: Made 88 replacements.
```

---

## Common Mistakes

1. **Forgetting dry run**: Always test first
2. **Not backing up**: Data loss is permanent
3. **Replacing too broadly**: Be specific with your search string
4. **Ignoring GUID**: Usually correct to skip it
5. **Forgetting cache flush**: Clear cache after changes
6. **Case sensitivity**: Use `--regex --regex-flags=i` for case-insensitive
