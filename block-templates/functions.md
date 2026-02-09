# Block Template Functions

## Template Retrieval

### get_block_template()

Retrieves a single unified template object by its ID.

```php
get_block_template( string $id, string $template_type = 'wp_template' ): ?WP_Block_Template
```

**Parameters:**
- `$id` - Template unique identifier (e.g., `theme_slug//template_slug`)
- `$template_type` - Either `'wp_template'` or `'wp_template_part'`

**Returns:** `WP_Block_Template` object or `null` if not found.

**Example:**
```php
// Get the single post template
$template = get_block_template( 'twentytwentyfour//single', 'wp_template' );

if ( $template ) {
    echo $template->content;
}

// Get header template part
$header = get_block_template( 'my-theme//header', 'wp_template_part' );
```

---

### get_block_templates()

Retrieves a list of unified template objects based on a query.

```php
get_block_templates( array $query = array(), string $template_type = 'wp_template' ): WP_Block_Template[]
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query['slug__in']` | `string[]` | List of slugs to include |
| `$query['wp_id']` | `int` | Post ID of customized template |
| `$query['area']` | `string` | Template part area (for `wp_template_part` only) |
| `$query['post_type']` | `string` | Post type to get templates for |
| `$template_type` | `string` | `'wp_template'` or `'wp_template_part'` |

**Returns:** Array of `WP_Block_Template` objects.

**Examples:**
```php
// Get all templates
$templates = get_block_templates();

// Get specific templates by slug
$templates = get_block_templates( array(
    'slug__in' => array( 'single', 'page', 'archive' ),
) );

// Get templates for a specific post type
$templates = get_block_templates( array(
    'post_type' => 'product',
) );

// Get all header template parts
$headers = get_block_templates( array(
    'area' => WP_TEMPLATE_PART_AREA_HEADER,
), 'wp_template_part' );

// Get all footer template parts
$footers = get_block_templates( array(
    'area' => WP_TEMPLATE_PART_AREA_FOOTER,
), 'wp_template_part' );
```

---

### get_block_file_template()

Retrieves a template from theme files or plugin registration (fallback when not in database).

```php
get_block_file_template( string $id, string $template_type = 'wp_template' ): ?WP_Block_Template
```

**Parameters:**
- `$id` - Template unique identifier
- `$template_type` - Either `'wp_template'` or `'wp_template_part'`

**Returns:** `WP_Block_Template` or `null`.

**Example:**
```php
// Get template from theme file only (ignore database customizations)
$template = get_block_file_template( 'twentytwentyfour//single' );
```

---

## Template Registration (6.7+)

### register_block_template()

Registers a block template programmatically (for plugins).

```php
register_block_template( string $template_name, array $args = array() ): WP_Block_Template|WP_Error
```

**Parameters:**

| Argument | Type | Description |
|----------|------|-------------|
| `$template_name` | `string` | Template name as `plugin_uri//template_name` |
| `$args['title']` | `string` | Title shown in Site Editor |
| `$args['description']` | `string` | Template description |
| `$args['content']` | `string` | Default block content |
| `$args['post_types']` | `string[]` | Post types this template applies to |
| `$args['plugin']` | `string` | Plugin slug that registers the template |

**Returns:** `WP_Block_Template` on success, `WP_Error` on failure.

**Example:**
```php
add_action( 'init', function() {
    register_block_template(
        'my-plugin//product-landing',
        array(
            'title'       => __( 'Product Landing Page', 'my-plugin' ),
            'description' => __( 'A template for product landing pages.', 'my-plugin' ),
            'content'     => '<!-- wp:heading --><h2>Product Name</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Product description here.</p><!-- /wp:paragraph -->',
            'post_types'  => array( 'page', 'product' ),
        )
    );
} );
```

---

### unregister_block_template()

Unregisters a previously registered block template.

```php
unregister_block_template( string $template_name ): WP_Block_Template|WP_Error
```

**Example:**
```php
unregister_block_template( 'my-plugin//product-landing' );
```

---

## Template Resolution

### locate_block_template()

Finds a block template with equal or higher specificity than a given PHP template.

```php
locate_block_template( string $template, string $type, array $templates ): string
```

**Parameters:**
- `$template` - Path to PHP template (from `locate_template()`)
- `$type` - Sanitized template type (e.g., `'single'`, `'page'`)
- `$templates` - List of template candidates in descending priority

**Returns:** Path to template canvas file, or fallback PHP template.

**Note:** This is an internal function called by WordPress during template loading. It sets the global `$_wp_current_template_content` and `$_wp_current_template_id`.

---

### resolve_block_template()

Returns the correct `wp_template` to render for the request template type.

```php
resolve_block_template( 
    string $template_type, 
    array $template_hierarchy, 
    string $fallback_template 
): ?WP_Block_Template
```

**Parameters:**
- `$template_type` - Current template type
- `$template_hierarchy` - Ordered template hierarchy
- `$fallback_template` - PHP fallback template path

**Returns:** `WP_Block_Template` or `null`.

---

### get_template_hierarchy()

Gets the template hierarchy for a given template slug.

```php
get_template_hierarchy( 
    string $slug, 
    bool $is_custom = false, 
    string $template_prefix = '' 
): string[]
```

**Parameters:**
- `$slug` - Template slug to get hierarchy for
- `$is_custom` - Whether template is custom (not part of standard hierarchy)
- `$template_prefix` - Template prefix for extracting main type

**Returns:** Array of template slugs in hierarchy order.

**Examples:**
```php
// Get hierarchy for single-post template
$hierarchy = get_template_hierarchy( 'single-post' );
// Returns: ['single-post', 'single', 'singular', 'index']

// Get hierarchy for category-news template
$hierarchy = get_template_hierarchy( 'category-news' );
// Returns: ['category-news', 'category', 'archive', 'index']

// Get hierarchy for a custom template
$hierarchy = get_template_hierarchy( 'my-custom-template', true );
// Returns: ['page', 'singular', 'index']
```

---

## Template Output

### get_the_block_template_html()

Returns the markup for the current template.

```php
get_the_block_template_html(): string
```

**Returns:** Processed block template markup wrapped in `.wp-site-blocks`.

**Usage:** Called internally by `template-canvas.php`. Processes embeds, shortcodes, blocks, and applies content filters.

---

### block_template_part()

Prints a block template part.

```php
block_template_part( string $part ): void
```

**Parameters:**
- `$part` - Template part slug (e.g., `'header'`, `'footer'`)

**Example:**
```php
// In a hybrid theme PHP template
block_template_part( 'header' );
the_content();
block_template_part( 'footer' );
```

---

### block_header_area()

Prints the header block template part.

```php
block_header_area(): void
```

**Example:**
```php
// Shorthand for block_template_part( 'header' )
block_header_area();
```

---

### block_footer_area()

Prints the footer block template part.

```php
block_footer_area(): void
```

---

## Utility Functions

### get_block_theme_folders()

Returns folder names used by block themes for templates.

```php
get_block_theme_folders( ?string $theme_stylesheet = null ): array
```

**Returns:**
```php
array(
    'wp_template'      => 'templates',    // or 'block-templates' for legacy
    'wp_template_part' => 'parts',        // or 'block-template-parts' for legacy
)
```

---

### get_allowed_block_template_part_areas()

Returns allowed area values for template parts.

```php
get_allowed_block_template_part_areas(): array[]
```

**Returns:** Array of area definitions with `area`, `label`, `description`, `icon`, and `area_tag`.

---

### get_default_block_template_types()

Returns default template types with titles and descriptions.

```php
get_default_block_template_types(): array[]
```

**Returns:** Associative array keyed by template slug with `title` and `description`.

**Included templates:** `index`, `home`, `front-page`, `singular`, `single`, `page`, `archive`, `author`, `category`, `taxonomy`, `date`, `tag`, `attachment`, `search`, `privacy-policy`, `404`, plus post format templates.

---

### wp_generate_block_templates_export_file()

Creates a ZIP export of current templates and template parts.

```php
wp_generate_block_templates_export_file(): string|WP_Error
```

**Returns:** Path to ZIP file or `WP_Error`.

**Contents:**
- All templates in `templates/` folder
- All template parts in `parts/` folder
- Merged `theme.json` (theme + user settings)
- Complete theme files (excluding `.git`, `node_modules`, etc.)

---

## Internal Functions

### _get_block_template_file()

Retrieves template file metadata from theme.

```php
_get_block_template_file( string $template_type, string $slug ): ?array
```

**Returns:** Array with `slug`, `path`, `theme`, `type`, plus `area` (for parts) or `postTypes` (for templates).

---

### _get_block_templates_files()

Retrieves all template files from theme matching a query.

```php
_get_block_templates_files( string $template_type, array $query = array() ): ?array
```

---

### _build_block_template_result_from_file()

Builds a `WP_Block_Template` object from a theme file.

```php
_build_block_template_result_from_file( array $template_file, string $template_type ): WP_Block_Template
```

---

### _build_block_template_result_from_post()

Builds a `WP_Block_Template` object from a database post.

```php
_build_block_template_result_from_post( WP_Post $post ): WP_Block_Template|WP_Error
```

---

### _strip_template_file_suffix()

Strips `.php` or `.html` suffix from template file names.

```php
_strip_template_file_suffix( string $template_file ): string
```

---

### inject_ignored_hooked_blocks_metadata_attributes()

Injects `ignoredHookedBlocks` metadata into templates for Block Hooks.

```php
inject_ignored_hooked_blocks_metadata_attributes( stdClass $changes ): stdClass|WP_Error
```

Used when saving templates to preserve Block Hooks state.
