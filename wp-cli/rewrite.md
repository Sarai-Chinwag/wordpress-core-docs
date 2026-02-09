# WP-CLI: wp rewrite

Lists or flushes the site's rewrite rules, updates the permalink structure.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp rewrite flush` | Flushes rewrite rules |
| `wp rewrite list` | Gets a list of the current rewrite rules |
| `wp rewrite structure` | Updates the permalink structure |

---

## wp rewrite flush

Flushes rewrite rules.

### Syntax

```bash
wp rewrite flush [--hard]
```

### Options

| Option | Description |
|--------|-------------|
| `--hard` | Perform a hard flush, updating .htaccess (Apache) or web.config (IIS) |

### Examples

```bash
# Flush rewrite rules
wp rewrite flush

# Hard flush (regenerates .htaccess)
wp rewrite flush --hard
```

### When to Flush

Flush rewrite rules after:
- Changing permalink structure
- Registering new post types or taxonomies
- Installing/activating plugins that add custom URLs
- Modifying rewrite rules in code
- Troubleshooting 404 errors on valid URLs

### Notes

- A soft flush only updates the database option
- A hard flush also regenerates `.htaccess` (Apache) or `web.config` (IIS)
- Flushing rewrites on every page load is bad practice—only do it when necessary

---

## wp rewrite structure

Updates the permalink structure.

### Syntax

```bash
wp rewrite structure <permastruct> [--category-base=<base>] [--tag-base=<base>] [--hard]
```

### Options

| Option | Description |
|--------|-------------|
| `<permastruct>` | The new permalink structure |
| `--category-base=<base>` | Set the category base |
| `--tag-base=<base>` | Set the tag base |
| `--hard` | Perform a hard flush |

### Common Permalink Structures

| Structure | Example URL |
|-----------|-------------|
| `/%postname%/` | /hello-world/ |
| `/%year%/%monthnum%/%postname%/` | /2024/01/hello-world/ |
| `/%year%/%monthnum%/%day%/%postname%/` | /2024/01/15/hello-world/ |
| `/%category%/%postname%/` | /news/hello-world/ |
| `/blog/%postname%/` | /blog/hello-world/ |
| `/%post_id%/%postname%/` | /123/hello-world/ |
| `/archives/%post_id%` | /archives/123 |

### Structure Tags

| Tag | Description |
|-----|-------------|
| `%year%` | Four-digit year (2024) |
| `%monthnum%` | Two-digit month (01-12) |
| `%day%` | Two-digit day (01-31) |
| `%hour%` | Two-digit hour (00-23) |
| `%minute%` | Two-digit minute (00-59) |
| `%second%` | Two-digit second (00-59) |
| `%post_id%` | Post ID |
| `%postname%` | Post slug |
| `%category%` | Category slug |
| `%author%` | Author nicename |

### Examples

```bash
# Set to post name only
wp rewrite structure '/%postname%/'

# Set date-based structure
wp rewrite structure '/%year%/%monthnum%/%postname%/'

# Set with custom prefix
wp rewrite structure '/blog/%postname%/'

# Set with category and tag bases
wp rewrite structure '/%postname%/' --category-base=topics --tag-base=tags

# Set with hard flush
wp rewrite structure '/%postname%/' --hard

# Include category in URL
wp rewrite structure '/%category%/%postname%/'
```

---

## wp rewrite list

Gets a list of the current rewrite rules.

### Syntax

```bash
wp rewrite list [--match=<url>] [--source=<source>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `--match=<url>` | Show rewrite rules matching a particular URL |
| `--source=<source>` | Show rewrite rules from a particular source |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, json, count, yaml |

### Available Fields

- match
- query
- source

### Sources

| Source | Description |
|--------|-------------|
| `post` | Post rewrites |
| `date` | Date archive rewrites |
| `root` | Root rewrites |
| `comments` | Comment rewrites |
| `search` | Search rewrites |
| `author` | Author archive rewrites |
| `page` | Page rewrites |
| `category` | Category rewrites |
| `post_tag` | Tag rewrites |
| `other` | Other rewrites (REST API, etc.) |

### Examples

```bash
# List all rewrite rules
wp rewrite list

# List as JSON
wp rewrite list --format=json

# List rules matching a URL
wp rewrite list --match='/hello-world/'

# List rules from specific source
wp rewrite list --source=post

# List category rules
wp rewrite list --source=category

# Count rules
wp rewrite list --format=count

# List as CSV
wp rewrite list --format=csv

# Show only match and query fields
wp rewrite list --fields=match,query
```

---

## Understanding Rewrite Rules

### How Rewrites Work

1. WordPress receives a request URL
2. It matches the URL against rewrite rules
3. The matching rule transforms the URL into query variables
4. WordPress uses query variables to determine what to display

### Example Rule

```
match: ^category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$
query: index.php?category_name=$matches[1]&feed=$matches[2]
source: category
```

This rule matches URLs like `/category/news/feed/rss2/` and converts them to internal query parameters.

---

## Practical Examples

### Site Migration

```bash
# After changing domain, update permalink structure
wp rewrite structure '/%postname%/'
wp rewrite flush --hard
```

### Custom Post Type Setup

After registering a custom post type with `rewrite` args:
```bash
# Flush to register new rules
wp rewrite flush
```

### Debugging 404s

```bash
# Check if URL matches any rule
wp rewrite list --match='/my-custom-page/'

# If no match, flush rules
wp rewrite flush --hard

# List all rules to inspect
wp rewrite list --format=csv > rewrite-rules.csv
```

### Changing Permalink Structure

```bash
# Current structure check
wp option get permalink_structure

# Update structure
wp rewrite structure '/%year%/%monthnum%/%postname%/'

# Verify
wp option get permalink_structure
```

### Category/Tag Base Changes

```bash
# Change category base from 'category' to 'topics'
wp rewrite structure '/%postname%/' --category-base=topics

# Remove category base entirely (set to '.')
wp rewrite structure '/%postname%/' --category-base=.

# Change tag base
wp rewrite structure '/%postname%/' --tag-base=tagged
```

### Export Rules for Analysis

```bash
# Export all rules to JSON
wp rewrite list --format=json > rewrite-rules.json

# Export to CSV for spreadsheet
wp rewrite list --format=csv > rewrite-rules.csv

# Count rules by source
wp rewrite list --format=json | jq 'group_by(.source) | map({source: .[0].source, count: length})'
```

---

## Common Issues

### 404 on Valid Posts

1. Flush rewrites:
   ```bash
   wp rewrite flush --hard
   ```

2. Check .htaccess exists and is writable

3. Verify mod_rewrite is enabled (Apache)

### Custom Post Type Not Working

1. Ensure post type is registered with `public => true`

2. Flush after registration:
   ```bash
   wp rewrite flush
   ```

### REST API 404s

1. Check for conflicting rules:
   ```bash
   wp rewrite list --match='/wp-json/wp/v2/posts'
   ```

2. Flush rewrites:
   ```bash
   wp rewrite flush --hard
   ```

### Permalink Changes Not Taking Effect

1. Hard flush:
   ```bash
   wp rewrite flush --hard
   ```

2. Check file permissions on .htaccess

3. Clear any caching plugins

---

## .htaccess Template

Standard WordPress .htaccess for Apache:

```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
```

For subdirectory installations, `RewriteBase` will be different (e.g., `/blog/`).

---

## Best Practices

1. **Don't flush on every page load**: Only flush when rules change

2. **Use hard flush sparingly**: Only when .htaccess needs updating

3. **Backup .htaccess**: Before making changes

4. **Test after changes**: Verify URLs still work

5. **Avoid complex structures**: Simpler is faster and more reliable

6. **SEO considerations**: Changing permalink structure can affect SEO; use redirects
