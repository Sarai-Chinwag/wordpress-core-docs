# WP_Block_Template

Class representing a block template.

**Since:** 5.8.0  
**Source:** `wp-includes/class-wp-block-template.php`

## Description

`WP_Block_Template` represents a full-page template or template part built with blocks. Templates can come from themes (files), the database (customized), or plugins.

## Properties

### $type

Template type identifier.

```php
public string $type
```

**Values:** `wp_template`, `wp_template_part`

**Since:** 5.8.0

---

### $theme

Theme the template belongs to.

```php
public string $theme
```

**Since:** 5.8.0

---

### $slug

Template slug identifier.

```php
public string $slug
```

**Example:** `single`, `archive`, `header`, `footer`

**Since:** 5.8.0

---

### $id

Full template ID.

```php
public string $id
```

**Format:** `{theme}//{slug}` (e.g., `twentytwentyfour//single`)

**Since:** 5.8.0

---

### $title

Human-readable title.

```php
public string $title = ''
```

**Since:** 5.8.0

---

### $content

Block content of the template.

```php
public string $content = ''
```

**Since:** 5.8.0

---

### $description

Template description.

```php
public string $description = ''
```

**Since:** 5.8.0

---

### $source

Source of the content.

```php
public string $source = 'theme'
```

**Values:**
- `theme` - From theme files
- `custom` - User-customized version
- `plugin` - From a plugin

**Since:** 5.8.0

---

### $origin

Original source when content has been customized.

```php
public string|null $origin
```

When `source` becomes `custom`, `origin` holds the previous source value.

**Since:** 5.9.0

---

### $wp_id

Database post ID (if stored in DB).

```php
public int|null $wp_id
```

**Since:** 5.8.0

---

### $status

Template status.

```php
public string $status
```

**Values:** `publish`, `draft`, `trash`

**Since:** 5.8.0

---

### $has_theme_file

Whether template is based on a theme file.

```php
public bool $has_theme_file
```

**Since:** 5.8.0

---

### $is_custom

Whether this is a custom template.

```php
public bool $is_custom = true
```

**Since:** 5.9.0

---

### $author

Author user ID.

```php
public int|null $author
```

Value of `0` means no author.

**Since:** 5.9.0

---

### $plugin

Plugin that registered this template.

```php
public string|null $plugin
```

**Since:** 6.7.0

---

### $post_types

Post types this template applies to.

```php
public string[]|null $post_types
```

**Since:** 5.9.0

---

### $area

Template part area.

```php
public string|null $area
```

**Areas:** `header`, `footer`, `sidebar`, `uncategorized`

**Since:** 5.9.0

---

### $modified

Last modified date.

```php
public string|null $modified
```

**Since:** 6.3.0

---

## Usage Examples

### Template Object Structure

```php
$template = new WP_Block_Template();
$template->type        = 'wp_template';
$template->theme       = 'twentytwentyfour';
$template->slug        = 'single';
$template->id          = 'twentytwentyfour//single';
$template->title       = 'Single Post';
$template->description = 'Template for displaying single posts';
$template->source      = 'theme';
$template->status      = 'publish';
$template->content     = '<!-- wp:template-part {"slug":"header"} /-->
<!-- wp:post-content /-->
<!-- wp:template-part {"slug":"footer"} /-->';
```

### Template Part Object

```php
$template_part = new WP_Block_Template();
$template_part->type   = 'wp_template_part';
$template_part->theme  = 'twentytwentyfour';
$template_part->slug   = 'header';
$template_part->id     = 'twentytwentyfour//header';
$template_part->title  = 'Header';
$template_part->area   = 'header';
$template_part->source = 'theme';
$template_part->content = '<!-- wp:site-title /-->
<!-- wp:navigation /-->';
```

### Customized Template

When a user modifies a theme template:

```php
$customized = new WP_Block_Template();
$customized->source = 'custom';         // Now stored in database
$customized->origin = 'theme';          // Originally from theme
$customized->wp_id  = 123;              // Database post ID
$customized->author = 1;                // User who customized
```

### Plugin-Registered Template

```php
$plugin_template = new WP_Block_Template();
$plugin_template->source = 'plugin';
$plugin_template->plugin = 'my-plugin';
$plugin_template->origin = 'plugin';
```

---

## Related Functions

### get_block_templates()

Retrieves a list of unified templates.

```php
get_block_templates( array $query = array(), string $template_type = 'wp_template' ): WP_Block_Template[]
```

**Example:**
```php
// Get all templates
$templates = get_block_templates();

// Get template by slug
$single = get_block_templates( array( 'slug__in' => array( 'single' ) ) );

// Get template parts for header area
$headers = get_block_templates(
    array( 'area' => 'header' ),
    'wp_template_part'
);
```

---

### get_block_template()

Retrieves a single unified template.

```php
get_block_template( string $id, string $template_type = 'wp_template' ): WP_Block_Template|null
```

**Example:**
```php
$template = get_block_template( 'twentytwentyfour//single' );
if ( $template ) {
    echo $template->content;
}
```

---

### get_block_file_template()

Gets a template from theme files.

```php
get_block_file_template( string $id, string $template_type = 'wp_template' ): WP_Block_Template|null
```

---

## Template Hierarchy

Block templates follow the WordPress template hierarchy:

| Template Slug | Purpose |
|---------------|---------|
| `index` | Fallback for all pages |
| `home` | Blog home page |
| `front-page` | Static front page |
| `singular` | Single post/page |
| `single` | Single post |
| `single-{post_type}` | Specific post type |
| `page` | Static page |
| `archive` | Archive pages |
| `author` | Author archives |
| `category` | Category archives |
| `tag` | Tag archives |
| `taxonomy-{taxonomy}` | Custom taxonomy |
| `search` | Search results |
| `404` | Not found |

---

## Template Parts

Common template part areas:

| Area | Purpose |
|------|---------|
| `header` | Site header |
| `footer` | Site footer |
| `sidebar` | Sidebar widgets |
| `uncategorized` | General purpose |

### Template Part Block

```html
<!-- wp:template-part {"slug":"header","area":"header"} /-->
```

Includes the template part with the matching slug.

---

## Storage

### Theme Files

Templates stored as HTML files:
- `wp-content/themes/{theme}/templates/single.html`
- `wp-content/themes/{theme}/parts/header.html`

### Database

Customized templates stored as `wp_template` post type:
- Post name: `{theme}//{slug}`
- Post content: Block content

```sql
SELECT * FROM wp_posts WHERE post_type = 'wp_template';
```
