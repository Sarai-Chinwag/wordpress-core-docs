# WP_Block_Templates_Registry

Core class for interacting with registered templates.

**Since:** 6.7.0  
**Source:** `wp-includes/class-wp-block-templates-registry.php`

## Description

`WP_Block_Templates_Registry` is a singleton that allows plugins to programmatically register block templates. This provides a way to define templates without requiring theme files.

## Properties

### $registered_templates (private)

Registered templates as `$name => $instance` pairs.

```php
private WP_Block_Template[] $registered_templates = array()
```

**Since:** 6.7.0

---

### $instance (private static)

Container for the main singleton instance.

```php
private static WP_Block_Templates_Registry|null $instance = null
```

**Since:** 6.7.0

---

## Methods

### get_instance()

Retrieves the main singleton instance.

```php
public static function get_instance(): WP_Block_Templates_Registry
```

**Returns:** *(WP_Block_Templates_Registry)* - The main instance

**Since:** 6.7.0

---

### register()

Registers a template.

```php
public function register(
    string $template_name,
    array $args = array()
): WP_Block_Template|WP_Error
```

**Parameters:**
- `$template_name` *(string)* - Template name including namespace (format: `plugin//slug`)
- `$args` *(array)* - Optional. Template arguments:
  - `content` *(string)* - Block content
  - `title` *(string)* - Human-readable title
  - `description` *(string)* - Template description
  - `post_types` *(string[])* - Post types this template applies to

**Returns:** *(WP_Block_Template|WP_Error)* - Registered template or error

**Since:** 6.7.0

**Validation Rules:**
- Name must be a string
- Name must not contain uppercase characters
- Name must follow pattern: `plugin//slug`
- Template must not already be registered

**Example:**
```php
$registry = WP_Block_Templates_Registry::get_instance();

$template = $registry->register( 'my-plugin//product-showcase', array(
    'title'       => 'Product Showcase',
    'description' => 'A template for displaying product features',
    'content'     => '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
    <!-- wp:heading -->
    <h2>Featured Product</h2>
    <!-- /wp:heading -->
    <!-- wp:post-featured-image /-->
    <!-- wp:post-content /-->
</div>
<!-- /wp:group -->',
    'post_types'  => array( 'product' ),
) );
```

---

### unregister()

Unregisters a template.

```php
public function unregister( string $template_name ): WP_Block_Template|WP_Error
```

**Parameters:**
- `$template_name` *(string)* - Template name including namespace

**Returns:** *(WP_Block_Template|WP_Error)* - Unregistered template or error

**Since:** 6.7.0

**Example:**
```php
$registry = WP_Block_Templates_Registry::get_instance();
$result = $registry->unregister( 'my-plugin//product-showcase' );

if ( is_wp_error( $result ) ) {
    echo $result->get_error_message();
}
```

---

### get_registered()

Retrieves a registered template by name.

```php
public function get_registered( string $template_name ): WP_Block_Template|null
```

**Parameters:**
- `$template_name` *(string)* - Template name including namespace

**Returns:** *(WP_Block_Template|null)* - Registered template or null

**Since:** 6.7.0

**Example:**
```php
$registry = WP_Block_Templates_Registry::get_instance();
$template = $registry->get_registered( 'my-plugin//product-showcase' );

if ( $template ) {
    echo $template->title;
}
```

---

### get_by_slug()

Retrieves a registered template by slug.

```php
public function get_by_slug( string $template_slug ): WP_Block_Template|null
```

**Parameters:**
- `$template_slug` *(string)* - Template slug (without namespace)

**Returns:** *(WP_Block_Template|null)* - Registered template or null

**Since:** 6.7.0

**Example:**
```php
$registry = WP_Block_Templates_Registry::get_instance();
$template = $registry->get_by_slug( 'product-showcase' );
```

---

### get_by_query()

Retrieves registered templates matching a query.

```php
public function get_by_query( array $query = array() ): WP_Block_Template[]
```

**Parameters:**
- `$query` *(array)* - Query arguments:
  - `slug__in` *(string[])* - Slugs to include
  - `slug__not_in` *(string[])* - Slugs to exclude
  - `post_type` *(string)* - Filter by post type

**Returns:** *(WP_Block_Template[])* - Matching templates

**Since:** 6.7.0

**Example:**
```php
$registry = WP_Block_Templates_Registry::get_instance();

// Get templates for 'product' post type
$product_templates = $registry->get_by_query( array(
    'post_type' => 'product',
) );

// Get specific templates
$templates = $registry->get_by_query( array(
    'slug__in' => array( 'single', 'archive' ),
) );

// Exclude certain templates
$templates = $registry->get_by_query( array(
    'slug__not_in' => array( 'index' ),
) );
```

---

### get_all_registered()

Retrieves all registered templates.

```php
public function get_all_registered(): WP_Block_Template[]
```

**Returns:** *(WP_Block_Template[])* - Associative array of templates

**Since:** 6.7.0

**Example:**
```php
$registry = WP_Block_Templates_Registry::get_instance();
$all_templates = $registry->get_all_registered();

foreach ( $all_templates as $name => $template ) {
    echo "$name: {$template->title}\n";
}
```

---

### is_registered()

Checks if a template is registered.

```php
public function is_registered( string|null $template_name ): bool
```

**Parameters:**
- `$template_name` *(string|null)* - Template name

**Returns:** *(bool)* - True if registered

**Since:** 6.7.0

**Example:**
```php
$registry = WP_Block_Templates_Registry::get_instance();

if ( ! $registry->is_registered( 'my-plugin//custom' ) ) {
    $registry->register( 'my-plugin//custom', array(
        'title' => 'Custom Template',
        'content' => '<!-- wp:paragraph --><p>Custom</p><!-- /wp:paragraph -->',
    ) );
}
```

---

## Usage Examples

### Complete Plugin Template Registration

```php
add_action( 'init', function() {
    $registry = WP_Block_Templates_Registry::get_instance();
    
    // Register a landing page template
    $registry->register( 'my-plugin//landing-page', array(
        'title'       => __( 'Landing Page', 'my-plugin' ),
        'description' => __( 'A full-width landing page template', 'my-plugin' ),
        'post_types'  => array( 'page' ),
        'content'     => '
<!-- wp:cover {"minHeight":500,"align":"full"} -->
<div class="wp-block-cover alignfull">
    <!-- wp:heading {"textAlign":"center","level":1} -->
    <h1 class="has-text-align-center">Welcome</h1>
    <!-- /wp:heading -->
</div>
<!-- /wp:cover -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
    <!-- wp:post-content /-->
</div>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer"} /-->
        ',
    ) );
    
    // Register a portfolio template
    $registry->register( 'my-plugin//portfolio', array(
        'title'       => __( 'Portfolio', 'my-plugin' ),
        'description' => __( 'Grid layout for portfolio items', 'my-plugin' ),
        'post_types'  => array( 'portfolio' ),
        'content'     => '
<!-- wp:template-part {"slug":"header"} /-->

<!-- wp:query {"queryId":1,"query":{"postType":"portfolio"}} -->
<div class="wp-block-query">
    <!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
        <!-- wp:post-featured-image /-->
        <!-- wp:post-title /-->
    <!-- /wp:post-template -->
</div>
<!-- /wp:query -->

<!-- wp:template-part {"slug":"footer"} /-->
        ',
    ) );
} );
```

### Template Resulting Object

When registered, the template has these properties set:

```php
$template->id          // 'twentytwentyfour//landing-page' (uses active theme)
$template->theme       // 'twentytwentyfour'
$template->plugin      // 'my-plugin'
$template->slug        // 'landing-page'
$template->type        // 'wp_template'
$template->source      // 'plugin'
$template->origin      // 'plugin'
$template->status      // 'publish'
$template->is_custom   // false (if matches default type)
```

### Checking Template Availability

```php
add_action( 'admin_init', function() {
    $registry = WP_Block_Templates_Registry::get_instance();
    
    // Check before registering
    if ( $registry->is_registered( 'my-plugin//landing-page' ) ) {
        return; // Already registered
    }
    
    // Get all templates for a post type
    $product_templates = $registry->get_by_query( array(
        'post_type' => 'product',
    ) );
    
    if ( empty( $product_templates ) ) {
        // Register default product template
    }
} );
```

### Cleanup on Deactivation

```php
register_deactivation_hook( __FILE__, function() {
    $registry = WP_Block_Templates_Registry::get_instance();
    
    $my_templates = array(
        'my-plugin//landing-page',
        'my-plugin//portfolio',
    );
    
    foreach ( $my_templates as $template_name ) {
        if ( $registry->is_registered( $template_name ) ) {
            $registry->unregister( $template_name );
        }
    }
} );
```
