# WP-CLI: wp post

Manages posts, content, and meta.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp post create` | Creates a new post |
| `wp post delete` | Deletes an existing post |
| `wp post edit` | Launches system editor to edit post content |
| `wp post exists` | Verifies whether a post exists |
| `wp post generate` | Generates some posts |
| `wp post get` | Gets details about a post |
| `wp post list` | Gets a list of posts |
| `wp post meta` | Manages post custom fields |
| `wp post term` | Manages post terms |
| `wp post update` | Updates one or more existing posts |
| `wp post url-to-id` | Gets the post ID for a given URL |

---

## wp post create

Creates a new post.

### Syntax

```bash
wp post create [--post_author=<post_author>] [--post_date=<post_date>] [--post_date_gmt=<post_date_gmt>] [--post_content=<post_content>] [--post_content_filtered=<post_content_filtered>] [--post_title=<post_title>] [--post_excerpt=<post_excerpt>] [--post_status=<post_status>] [--post_type=<post_type>] [--comment_status=<comment_status>] [--ping_status=<ping_status>] [--post_password=<post_password>] [--post_name=<post_name>] [--from-post=<post_id>] [--to_ping=<to_ping>] [--pinged=<pinged>] [--post_modified=<post_modified>] [--post_modified_gmt=<post_modified_gmt>] [--post_parent=<post_parent>] [--menu_order=<menu_order>] [--post_mime_type=<post_mime_type>] [--guid=<guid>] [--post_category=<post_category>] [--tags_input=<tags_input>] [--tax_input=<tax_input>] [--meta_input=<meta_input>] [<file>] [--<field>=<value>] [--edit] [--porcelain]
```

### Options

| Option | Description |
|--------|-------------|
| `--post_author=<post_author>` | User ID of the author. Default: current user |
| `--post_date=<post_date>` | The date of the post. Default: current time |
| `--post_date_gmt=<post_date_gmt>` | The date in GMT timezone |
| `--post_content=<post_content>` | The post content. Default: empty |
| `--post_content_filtered=<post_content_filtered>` | Filtered post content |
| `--post_title=<post_title>` | The post title. Default: empty |
| `--post_excerpt=<post_excerpt>` | The post excerpt. Default: empty |
| `--post_status=<post_status>` | Status: draft, publish, pending, future, private. Default: draft |
| `--post_type=<post_type>` | Post type: post, page, or custom. Default: post |
| `--comment_status=<comment_status>` | open or closed |
| `--ping_status=<ping_status>` | open or closed |
| `--post_password=<post_password>` | Password to access the post |
| `--post_name=<post_name>` | The post slug |
| `--from-post=<post_id>` | Post ID to duplicate |
| `--post_parent=<post_parent>` | Parent post ID |
| `--menu_order=<menu_order>` | Display order |
| `--post_category=<post_category>` | Category names, slugs, or IDs |
| `--tags_input=<tags_input>` | Tag names, slugs, or IDs |
| `--tax_input=<tax_input>` | Taxonomy terms keyed by taxonomy name |
| `--meta_input=<meta_input>` | JSON array of post meta values |
| `[<file>]` | Read content from file. Use `-` for STDIN |
| `--edit` | Open editor to write content |
| `--porcelain` | Output just the new post id |

### Examples

```bash
# Create basic post
wp post create --post_type=post --post_title='A sample post'

# Create published post
wp post create --post_type=post --post_title='My Post' --post_status=publish

# Create page
wp post create --post_type=page --post_title='About Us' --post_status=publish

# Create post with content
wp post create --post_title='My Post' --post_content='This is the content.'

# Create post from file
wp post create ./content.txt --post_title='Post from file'

# Create post with categories
wp post create --post_title='Categorized Post' --post_category=news,updates

# Create post with tags
wp post create --post_title='Tagged Post' --tags_input=wordpress,tutorial

# Create scheduled post
wp post create --post_type=post --post_title='Future Post' --post_status=future --post_date='2030-12-01 07:00:00'

# Create post with meta
wp post create --post_title='Meta Post' --meta_input='{"key1":"value1","key2":"value2"}'

# Duplicate existing post
wp post create --from-post=123 --post_title='Duplicated Post'

# Get just the post ID
wp post create --post_title='New Post' --porcelain

# Create post with STDIN content
echo "This is the content" | wp post create - --post_title='From STDIN'

# Open editor to write content
wp post create --post_title='Edit Me' --edit
```

---

## wp post delete

Deletes an existing post.

### Syntax

```bash
wp post delete <id>... [--force] [--defer-term-counting]
```

### Options

| Option | Description |
|--------|-------------|
| `<id>...` | One or more IDs of posts to delete |
| `--force` | Skip the trash and permanently delete |
| `--defer-term-counting` | Recalculate term counts after all deletes complete |

### Examples

```bash
# Trash a post
wp post delete 123

# Permanently delete
wp post delete 123 --force

# Delete multiple posts
wp post delete 123 456 789 --force

# Delete all posts of a type
wp post delete $(wp post list --post_type=post --format=ids) --force
```

---

## wp post list

Gets a list of posts.

### Syntax

```bash
wp post list [--<field>=<value>] [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `--<field>=<value>` | Filter by field value (post_type, post_status, etc.) |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, ids, json, count, yaml |

### Common Filters

| Filter | Description |
|--------|-------------|
| `--post_type=<type>` | Filter by post type |
| `--post_status=<status>` | Filter by status |
| `--posts_per_page=<number>` | Number of posts to return |
| `--author=<id>` | Filter by author ID |
| `--category=<id>` | Filter by category ID |
| `--tag=<slug>` | Filter by tag slug |
| `--s=<search>` | Search posts |
| `--orderby=<field>` | Order by field |
| `--order=<ASC|DESC>` | Sort order |

### Examples

```bash
# List all posts
wp post list

# List only published posts
wp post list --post_status=publish

# List pages
wp post list --post_type=page

# List as JSON
wp post list --format=json

# Get just IDs
wp post list --format=ids

# List specific fields
wp post list --fields=ID,post_title,post_status

# List posts by author
wp post list --author=1

# Search posts
wp post list --s=wordpress

# List with custom query
wp post list --post_type=post --posts_per_page=5 --orderby=date --order=DESC

# Count posts
wp post list --post_type=post --format=count

# List drafts
wp post list --post_status=draft

# List trashed posts
wp post list --post_status=trash
```

---

## wp post update

Updates one or more existing posts.

### Syntax

```bash
wp post update <id>... [--post_author=<post_author>] [--post_date=<post_date>] [--post_content=<post_content>] [--post_title=<post_title>] [--post_excerpt=<post_excerpt>] [--post_status=<post_status>] [--post_name=<post_name>] [--post_parent=<post_parent>] [--menu_order=<menu_order>] [--comment_status=<comment_status>] [--ping_status=<ping_status>] [--<field>=<value>] [--defer-term-counting]
```

### Options

Same as `wp post create`, applied to existing posts.

### Examples

```bash
# Update post status
wp post update 123 --post_status=draft

# Update title
wp post update 123 --post_title='New Title'

# Update content
wp post update 123 --post_content='Updated content here.'

# Update multiple posts
wp post update 123 456 --post_status=publish

# Update all drafts to published
wp post update $(wp post list --post_status=draft --format=ids) --post_status=publish

# Change author
wp post update 123 --post_author=5

# Update content from file
wp post update 123 content.txt
```

---

## wp post get

Gets details about a post.

### Syntax

```bash
wp post get <id> [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<id>` | The ID of the post |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, json, yaml |

### Examples

```bash
# Get post details
wp post get 123

# Get specific fields
wp post get 123 --fields=ID,post_title,post_status

# Get as JSON
wp post get 123 --format=json

# Get just the title
wp post get 123 --field=post_title

# Get the content
wp post get 123 --field=post_content
```

---

## wp post meta

Adds, updates, deletes, and lists post custom fields.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp post meta add` | Adds a meta field |
| `wp post meta delete` | Deletes a meta field |
| `wp post meta get` | Gets meta field value |
| `wp post meta list` | Lists all metadata for a post |
| `wp post meta patch` | Update a nested value |
| `wp post meta pluck` | Get a nested value |
| `wp post meta update` | Updates a meta field |

### wp post meta add

```bash
wp post meta add <id> <key> <value> [--format=<format>]
```

### wp post meta delete

```bash
wp post meta delete <id> <key> [<value>] [--all]
```

### wp post meta get

```bash
wp post meta get <id> <key> [--format=<format>]
```

### wp post meta list

```bash
wp post meta list <id> [--keys=<keys>] [--fields=<fields>] [--format=<format>] [--orderby=<fields>] [--order=<order>] [--unserialize]
```

### wp post meta update

```bash
wp post meta update <id> <key> <value> [--format=<format>]
```

### Examples

```bash
# Add post meta
wp post meta add 123 featured true

# List all meta
wp post meta list 123

# Get specific meta
wp post meta get 123 _thumbnail_id

# Update meta
wp post meta update 123 featured false

# Delete meta
wp post meta delete 123 featured

# Delete all instances of a key
wp post meta delete 123 featured --all

# Add serialized meta
wp post meta add 123 settings '{"key":"value"}' --format=json

# List specific keys
wp post meta list 123 --keys=featured,_edit_lock
```

---

## wp post term

Adds, updates, removes, and lists post terms.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp post term add` | Adds a term to a post |
| `wp post term list` | Lists post terms |
| `wp post term remove` | Removes a term from a post |
| `wp post term set` | Sets the terms for a post |

### wp post term add

```bash
wp post term add <id> <taxonomy> <term>... [--by=<field>]
```

### wp post term list

```bash
wp post term list <id> <taxonomy>... [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### wp post term remove

```bash
wp post term remove <id> <taxonomy> [<term>...] [--by=<field>] [--all]
```

### wp post term set

```bash
wp post term set <id> <taxonomy> <term>... [--by=<field>]
```

### Examples

```bash
# Add category to post
wp post term add 123 category news

# Add multiple terms
wp post term add 123 post_tag tag1 tag2 tag3

# List post categories
wp post term list 123 category

# List tags
wp post term list 123 post_tag --fields=term_id,name,slug

# Remove term
wp post term remove 123 category news

# Remove all terms from taxonomy
wp post term remove 123 post_tag --all

# Set terms (replaces existing)
wp post term set 123 category news updates
```

---

## wp post exists

Verifies whether a post exists.

### Syntax

```bash
wp post exists <id>
```

### Examples

```bash
# Check if post exists
wp post exists 123 && echo "Exists" || echo "Does not exist"
```

---

## wp post generate

Generates some posts.

### Syntax

```bash
wp post generate [--count=<number>] [--post_type=<type>] [--post_status=<status>] [--post_author=<login>] [--post_date=<yyyy-mm-dd-hh-ii-ss>] [--post_date_gmt=<yyyy-mm-dd-hh-ii-ss>] [--post_content] [--max_depth=<number>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `--count=<number>` | How many posts to generate. Default: 100 |
| `--post_type=<type>` | Post type. Default: post |
| `--post_status=<status>` | Post status. Default: publish |
| `--post_author=<login>` | Author login |
| `--post_date=<yyyy-mm-dd-hh-ii-ss>` | Post date |
| `--post_content` | If set, generates content |
| `--max_depth=<number>` | For hierarchical post types, max depth |
| `--format=<format>` | Output format: progress, ids |

### Examples

```bash
# Generate 10 posts
wp post generate --count=10

# Generate pages
wp post generate --count=5 --post_type=page

# Generate drafts
wp post generate --count=10 --post_status=draft

# Generate with content
wp post generate --count=5 --post_content

# Generate with specific author
wp post generate --count=5 --post_author=admin
```

---

## wp post edit

Launches system editor to edit post content.

### Syntax

```bash
wp post edit <id>
```

### Examples

```bash
# Edit post in system editor
wp post edit 123
```

---

## wp post url-to-id

Gets the post ID for a given URL.

### Syntax

```bash
wp post url-to-id <url>
```

### Examples

```bash
# Get post ID from URL
wp post url-to-id https://example.com/hello-world/
```
