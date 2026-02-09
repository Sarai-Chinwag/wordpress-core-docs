# WP-CLI: wp term

Manages taxonomy terms and term meta, with create, delete, and list commands.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp term create` | Creates a new term |
| `wp term delete` | Deletes an existing term |
| `wp term generate` | Generates some terms |
| `wp term get` | Gets details about a term |
| `wp term list` | Lists terms in a taxonomy |
| `wp term meta` | Manages term custom fields |
| `wp term migrate` | Migrates a term to another taxonomy |
| `wp term recount` | Recalculates post counts for terms |
| `wp term update` | Updates an existing term |

---

## wp term create

Creates a new term.

### Syntax

```bash
wp term create <taxonomy> <term> [--slug=<slug>] [--description=<description>] [--parent=<term-id>] [--porcelain]
```

### Options

| Option | Description |
|--------|-------------|
| `<taxonomy>` | Taxonomy for the new term (category, post_tag, or custom) |
| `<term>` | A name for the new term |
| `--slug=<slug>` | A unique slug for the new term. Defaults to sanitized term name |
| `--description=<description>` | A description for the new term |
| `--parent=<term-id>` | A parent term id for hierarchical taxonomies |
| `--porcelain` | Output just the new term id |

### Examples

```bash
# Create a category
wp term create category News

# Create with description
wp term create category "Tech News" --description="All technology-related news"

# Create with custom slug
wp term create category "Breaking News" --slug=breaking

# Create child category
wp term create category "Local News" --parent=15

# Create a tag
wp term create post_tag WordPress

# Get just the term ID
wp term create category News --porcelain

# Create custom taxonomy term
wp term create genre "Science Fiction"
```

---

## wp term delete

Deletes an existing term.

### Syntax

```bash
wp term delete <taxonomy> <term>... [--by=<field>]
```

### Options

| Option | Description |
|--------|-------------|
| `<taxonomy>` | Taxonomy of the term to delete |
| `<term>...` | One or more IDs or slugs of terms to delete |
| `--by=<field>` | Explicitly handle the provided term as a slug or id. Default: id |

### Examples

```bash
# Delete category by ID
wp term delete category 15

# Delete by slug
wp term delete category news --by=slug

# Delete multiple terms
wp term delete category 15 16 17

# Delete tag
wp term delete post_tag wordpress --by=slug

# Delete all terms in a taxonomy
wp term delete category $(wp term list category --field=term_id)
```

---

## wp term list

Lists terms in a taxonomy.

### Syntax

```bash
wp term list <taxonomy>... [--<field>=<value>] [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<taxonomy>...` | List the terms of one or more taxonomies |
| `--<field>=<value>` | Filter by one or more fields |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, ids, json, count, yaml |

### Common Filters

| Filter | Description |
|--------|-------------|
| `--hide_empty` | Whether to hide terms not assigned to any posts |
| `--include=<ids>` | Include specific term IDs |
| `--exclude=<ids>` | Exclude specific term IDs |
| `--number=<number>` | Maximum number of terms to return |
| `--offset=<number>` | Offset to start from |
| `--orderby=<field>` | Field to order by: name, slug, count, term_id |
| `--order=<ASC\|DESC>` | Order direction |
| `--parent=<id>` | Filter by parent term ID |
| `--childless` | Return only terms with no children |
| `--search=<string>` | Search terms by name |

### Available Fields

- term_id
- term_taxonomy_id
- name
- slug
- description
- parent
- count
- url

### Examples

```bash
# List all categories
wp term list category

# List tags
wp term list post_tag

# List as JSON
wp term list category --format=json

# Get just IDs
wp term list category --format=ids

# Get just slugs
wp term list category --field=slug

# List specific fields
wp term list category --fields=term_id,name,slug,count

# List with URLs
wp term list post_tag --include=123 --field=url

# Count terms
wp term list category --format=count

# List non-empty categories
wp term list category --hide_empty=true

# List top-level categories only
wp term list category --parent=0

# Search terms
wp term list category --search=news

# Order by count
wp term list category --orderby=count --order=DESC
```

---

## wp term get

Gets details about a term.

### Syntax

```bash
wp term get <taxonomy> <term> [--by=<field>] [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<taxonomy>` | Taxonomy of the term |
| `<term>` | ID or slug of the term |
| `--by=<field>` | Explicitly handle as slug or id. Default: id |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, json, yaml |

### Examples

```bash
# Get term details
wp term get category 15

# Get by slug
wp term get category news --by=slug

# Get specific fields
wp term get category 199 --format=json --fields=term_id,name,slug,count

# Get just the name
wp term get category 15 --field=name

# Get as JSON
wp term get category 15 --format=json
```

---

## wp term update

Updates an existing term.

### Syntax

```bash
wp term update <taxonomy> <term> [--by=<field>] [--name=<name>] [--slug=<slug>] [--description=<description>] [--parent=<term-id>]
```

### Options

| Option | Description |
|--------|-------------|
| `<taxonomy>` | Taxonomy of the term |
| `<term>` | ID or slug of the term |
| `--by=<field>` | Explicitly handle as slug or id. Default: id |
| `--name=<name>` | New name for the term |
| `--slug=<slug>` | New slug for the term |
| `--description=<description>` | New description |
| `--parent=<term-id>` | New parent term ID |

### Examples

```bash
# Update term name
wp term update category 15 --name=Apple

# Update slug
wp term update category 15 --slug=apple-fruit

# Update description
wp term update category 15 --description="A delicious fruit"

# Update parent
wp term update category 15 --parent=10

# Update by slug
wp term update category news --by=slug --name="Latest News"
```

---

## wp term generate

Generates some terms.

### Syntax

```bash
wp term generate <taxonomy> [--count=<number>] [--max_depth=<number>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<taxonomy>` | Taxonomy to generate terms for |
| `--count=<number>` | How many terms to generate. Default: 100 |
| `--max_depth=<number>` | For hierarchical taxonomies, max depth. Default: 1 |
| `--format=<format>` | Output format: progress, ids |

### Examples

```bash
# Generate 10 categories
wp term generate category --count=10

# Generate tags
wp term generate post_tag --count=50

# Generate hierarchical categories
wp term generate category --count=20 --max_depth=3

# Get IDs of generated terms
wp term generate category --count=5 --format=ids
```

---

## wp term recount

Recalculates number of posts assigned to each term.

### Syntax

```bash
wp term recount <taxonomy>...
```

### Options

| Option | Description |
|--------|-------------|
| `<taxonomy>...` | One or more taxonomies to recount |

### Examples

```bash
# Recount categories
wp term recount category

# Recount tags
wp term recount post_tag

# Recount multiple taxonomies
wp term recount category post_tag

# Recount custom taxonomy
wp term recount genre
```

---

## wp term migrate

Migrate a term of a taxonomy to another taxonomy.

### Syntax

```bash
wp term migrate <term> <from-taxonomy> <to-taxonomy>
```

### Options

| Option | Description |
|--------|-------------|
| `<term>` | Term ID to migrate |
| `<from-taxonomy>` | Source taxonomy |
| `<to-taxonomy>` | Target taxonomy |

### Examples

```bash
# Migrate term to different taxonomy
wp term migrate 15 category post_tag
```

---

## wp term meta

Adds, updates, deletes, and lists term custom fields.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp term meta add` | Adds a meta field |
| `wp term meta delete` | Deletes a meta field |
| `wp term meta get` | Gets meta field value |
| `wp term meta list` | Lists all metadata for a term |
| `wp term meta patch` | Updates a nested value |
| `wp term meta pluck` | Gets a nested value |
| `wp term meta update` | Updates a meta field |

### wp term meta add

```bash
wp term meta add <id> <key> <value> [--format=<format>]
```

### wp term meta delete

```bash
wp term meta delete <id> <key> [<value>] [--all]
```

### wp term meta get

```bash
wp term meta get <id> <key> [--format=<format>]
```

### wp term meta list

```bash
wp term meta list <id> [--keys=<keys>] [--fields=<fields>] [--format=<format>] [--orderby=<fields>] [--order=<order>]
```

### wp term meta update

```bash
wp term meta update <id> <key> <value> [--format=<format>]
```

### Examples

```bash
# Add term meta
wp term meta add 15 color "#ff0000"

# List term meta
wp term meta list 15

# Get specific meta
wp term meta get 15 color

# Update term meta
wp term meta update 15 color "#00ff00"

# Delete term meta
wp term meta delete 15 color

# Add serialized meta
wp term meta add 15 settings '{"display":"grid"}' --format=json
```

---

## Common Taxonomies

| Taxonomy | Description |
|----------|-------------|
| `category` | Post categories (hierarchical) |
| `post_tag` | Post tags (non-hierarchical) |
| `nav_menu` | Navigation menus |
| `link_category` | Link categories |
| `post_format` | Post formats |

Custom taxonomies registered by themes or plugins will also be available.

---

## Practical Examples

### Bulk Operations

```bash
# Delete all terms in a taxonomy
wp term list my_taxonomy --field=term_id | xargs -I {} wp term delete my_taxonomy {}

# Export terms as JSON
wp term list category --format=json > categories.json

# Create hierarchy
PARENT=$(wp term create category "Parent" --porcelain)
wp term create category "Child 1" --parent=$PARENT
wp term create category "Child 2" --parent=$PARENT
```

### Migration and Maintenance

```bash
# Find empty categories
wp term list category --hide_empty=false --format=table

# Recount all taxonomies
wp term recount $(wp taxonomy list --field=name)

# Find duplicate slugs (should not happen, but useful for debugging)
wp term list category --fields=slug,name | sort | uniq -d
```
