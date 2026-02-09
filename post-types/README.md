# Custom Post Types

Custom Post Types extend WordPress beyond posts and pages, allowing you to create any content structure.

**Since:** WordPress 3.0.0

## Overview

WordPress includes built-in post types:

- `post` — Blog posts
- `page` — Static pages
- `attachment` — Media files
- `revision` — Post revisions
- `nav_menu_item` — Navigation menu items
- `wp_block` — Reusable blocks
- `wp_template` — Block templates
- `wp_template_part` — Template parts

## register_post_type()

Registers a custom post type.

```php
register_post_type( string $post_type, array $args = array() ): WP_Post_Type|WP_Error
```

### Basic Example

```php
add_action( 'init', function() {
    register_post_type( 'product', array(
        'labels' => array(
            'name'          => __( 'Products', 'my-plugin' ),
            'singular_name' => __( 'Product', 'my-plugin' ),
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-cart',
        'supports'     => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest' => true,
    ) );
} );
```

### Full Configuration

```php
register_post_type( 'product', array(
    // Labels
    'labels' => array(
        'name'                  => _x( 'Products', 'Post type general name', 'my-plugin' ),
        'singular_name'         => _x( 'Product', 'Post type singular name', 'my-plugin' ),
        'menu_name'             => _x( 'Products', 'Admin Menu text', 'my-plugin' ),
        'add_new'               => __( 'Add New', 'my-plugin' ),
        'add_new_item'          => __( 'Add New Product', 'my-plugin' ),
        'edit_item'             => __( 'Edit Product', 'my-plugin' ),
        'new_item'              => __( 'New Product', 'my-plugin' ),
        'view_item'             => __( 'View Product', 'my-plugin' ),
        'view_items'            => __( 'View Products', 'my-plugin' ),
        'search_items'          => __( 'Search Products', 'my-plugin' ),
        'not_found'             => __( 'No products found.', 'my-plugin' ),
        'not_found_in_trash'    => __( 'No products found in Trash.', 'my-plugin' ),
        'all_items'             => __( 'All Products', 'my-plugin' ),
        'archives'              => __( 'Product Archives', 'my-plugin' ),
        'attributes'            => __( 'Product Attributes', 'my-plugin' ),
        'insert_into_item'      => __( 'Insert into product', 'my-plugin' ),
        'uploaded_to_this_item' => __( 'Uploaded to this product', 'my-plugin' ),
        'featured_image'        => _x( 'Product Image', 'Overrides "Featured Image"', 'my-plugin' ),
        'set_featured_image'    => _x( 'Set product image', 'Overrides "Set featured image"', 'my-plugin' ),
        'remove_featured_image' => _x( 'Remove product image', 'Overrides "Remove featured image"', 'my-plugin' ),
        'use_featured_image'    => _x( 'Use as product image', 'Overrides "Use as featured image"', 'my-plugin' ),
        'filter_items_list'     => __( 'Filter products list', 'my-plugin' ),
        'items_list_navigation' => __( 'Products list navigation', 'my-plugin' ),
        'items_list'            => __( 'Products list', 'my-plugin' ),
    ),
    
    // Visibility
    'public'              => true,
    'publicly_queryable'  => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'show_in_rest'        => true,  // Enable Gutenberg & REST API
    
    // URLs
    'has_archive'         => true,  // /products/
    'rewrite'             => array(
        'slug'       => 'products',
        'with_front' => false,
    ),
    
    // Capabilities
    'capability_type'     => 'post',  // or 'page', or custom
    'map_meta_cap'        => true,
    
    // Features
    'supports'            => array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        'comments',
        'trackbacks',
        'revisions',
        'custom-fields',
        'page-attributes',
        'post-formats',
    ),
    
    // Admin
    'menu_position'       => 5,
    'menu_icon'           => 'dashicons-cart',
    
    // Hierarchy
    'hierarchical'        => false,  // true = like pages
    
    // Query
    'query_var'           => true,
    'exclude_from_search' => false,
    
    // REST API
    'rest_base'           => 'products',
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    
    // Template
    'template'            => array(
        array( 'core/paragraph', array( 'placeholder' => 'Add product description...' ) ),
    ),
    'template_lock'       => false,  // 'all', 'insert', or false
) );
```

---

## Supports

The `supports` argument enables features:

| Feature | Description |
|---------|-------------|
| `title` | Post title |
| `editor` | Content editor |
| `author` | Author dropdown |
| `thumbnail` | Featured image |
| `excerpt` | Excerpt metabox |
| `comments` | Comments |
| `trackbacks` | Trackbacks/pingbacks |
| `revisions` | Post revisions |
| `custom-fields` | Custom fields metabox |
| `page-attributes` | Parent/order (needs hierarchical) |
| `post-formats` | Post formats |

Add support later:

```php
add_post_type_support( 'product', 'excerpt' );
remove_post_type_support( 'product', 'comments' );
```

---

## Custom Capabilities

For fine-grained permissions:

```php
register_post_type( 'product', array(
    'capability_type' => 'product',
    'map_meta_cap'    => true,
    'capabilities'    => array(
        'edit_post'          => 'edit_product',
        'read_post'          => 'read_product',
        'delete_post'        => 'delete_product',
        'edit_posts'         => 'edit_products',
        'edit_others_posts'  => 'edit_others_products',
        'publish_posts'      => 'publish_products',
        'read_private_posts' => 'read_private_products',
    ),
) );

// Grant to administrator
$admin = get_role( 'administrator' );
$admin->add_cap( 'edit_products' );
$admin->add_cap( 'edit_others_products' );
// ... add all caps
```

---

## Querying Custom Post Types

### WP_Query

```php
$products = new WP_Query( array(
    'post_type'      => 'product',
    'posts_per_page' => 10,
    'orderby'        => 'title',
    'order'          => 'ASC',
) );

while ( $products->have_posts() ) {
    $products->the_post();
    the_title();
}
wp_reset_postdata();
```

### get_posts()

```php
$products = get_posts( array(
    'post_type'   => 'product',
    'numberposts' => 10,
) );
```

---

## REST API

With `show_in_rest => true`:

```
GET    /wp-json/wp/v2/products
GET    /wp-json/wp/v2/products/{id}
POST   /wp-json/wp/v2/products
PUT    /wp-json/wp/v2/products/{id}
DELETE /wp-json/wp/v2/products/{id}
```

---

## Helper Functions

### get_post_type()

```php
$type = get_post_type( $post_id );  // 'product'
```

### get_post_type_object()

```php
$obj = get_post_type_object( 'product' );
echo $obj->labels->singular_name;
```

### get_post_types()

```php
// All public post types
$types = get_post_types( array( 'public' => true ) );

// With full objects
$types = get_post_types( array( 'public' => true ), 'objects' );
```

### post_type_exists()

```php
if ( post_type_exists( 'product' ) ) {
    // Post type is registered
}
```

---

## Template Hierarchy

WordPress looks for these templates:

1. `single-{post_type}-{slug}.php`
2. `single-{post_type}.php`
3. `single.php`
4. `singular.php`
5. `index.php`

For archives:

1. `archive-{post_type}.php`
2. `archive.php`
3. `index.php`

---

## Best Practices

1. **Register on `init`** — Not too early, not too late
2. **Flush rewrite rules** — On activation only, not every load
3. **Use text domains** — All labels should be translatable
4. **Enable REST API** — `show_in_rest` for Gutenberg support
5. **Set appropriate capabilities** — Match your permissions model
6. **Prefix slugs** — Avoid conflicts with other plugins
