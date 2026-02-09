# Custom Taxonomies

Taxonomies are classification systems for grouping content. WordPress includes categories and tags; you can create custom ones.

**Since:** WordPress 2.3.0 (register_taxonomy)

## Overview

Built-in taxonomies:

| Taxonomy | Type | Description |
|----------|------|-------------|
| `category` | Hierarchical | Post categories |
| `post_tag` | Non-hierarchical | Post tags |
| `nav_menu` | Internal | Navigation menus |
| `link_category` | Hierarchical | Link categories |
| `post_format` | Internal | Post formats |

## register_taxonomy()

Registers a custom taxonomy.

```php
register_taxonomy( 
    string       $taxonomy, 
    array|string $object_type, 
    array        $args = array() 
): WP_Taxonomy|WP_Error
```

### Basic Example

```php
add_action( 'init', function() {
    register_taxonomy( 'genre', 'book', array(
        'labels' => array(
            'name'          => __( 'Genres', 'my-plugin' ),
            'singular_name' => __( 'Genre', 'my-plugin' ),
        ),
        'hierarchical' => true,  // Like categories
        'show_in_rest' => true,  // Enable Gutenberg & REST API
    ) );
} );
```

### Full Configuration

```php
register_taxonomy( 'genre', array( 'book', 'magazine' ), array(
    // Labels
    'labels' => array(
        'name'                       => _x( 'Genres', 'taxonomy general name', 'my-plugin' ),
        'singular_name'              => _x( 'Genre', 'taxonomy singular name', 'my-plugin' ),
        'menu_name'                  => __( 'Genres', 'my-plugin' ),
        'all_items'                  => __( 'All Genres', 'my-plugin' ),
        'edit_item'                  => __( 'Edit Genre', 'my-plugin' ),
        'view_item'                  => __( 'View Genre', 'my-plugin' ),
        'update_item'                => __( 'Update Genre', 'my-plugin' ),
        'add_new_item'               => __( 'Add New Genre', 'my-plugin' ),
        'new_item_name'              => __( 'New Genre Name', 'my-plugin' ),
        'parent_item'                => __( 'Parent Genre', 'my-plugin' ),
        'parent_item_colon'          => __( 'Parent Genre:', 'my-plugin' ),
        'search_items'               => __( 'Search Genres', 'my-plugin' ),
        'popular_items'              => __( 'Popular Genres', 'my-plugin' ),
        'separate_items_with_commas' => __( 'Separate genres with commas', 'my-plugin' ),
        'add_or_remove_items'        => __( 'Add or remove genres', 'my-plugin' ),
        'choose_from_most_used'      => __( 'Choose from most used genres', 'my-plugin' ),
        'not_found'                  => __( 'No genres found.', 'my-plugin' ),
        'no_terms'                   => __( 'No genres', 'my-plugin' ),
        'items_list_navigation'      => __( 'Genres list navigation', 'my-plugin' ),
        'items_list'                 => __( 'Genres list', 'my-plugin' ),
        'back_to_items'              => __( '&larr; Back to Genres', 'my-plugin' ),
    ),
    
    // Structure
    'hierarchical'      => true,   // true = categories, false = tags
    
    // Visibility
    'public'            => true,
    'publicly_queryable'=> true,
    'show_ui'           => true,
    'show_in_menu'      => true,
    'show_in_nav_menus' => true,
    'show_in_rest'      => true,
    'show_tagcloud'     => true,
    'show_in_quick_edit'=> true,
    'show_admin_column' => true,
    
    // URLs
    'rewrite'           => array(
        'slug'         => 'genre',
        'with_front'   => false,
        'hierarchical' => true,
    ),
    
    // Query
    'query_var'         => true,  // or custom query var string
    
    // REST API
    'rest_base'         => 'genres',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
    
    // Capabilities
    'capabilities'      => array(
        'manage_terms' => 'manage_genres',
        'edit_terms'   => 'edit_genres',
        'delete_terms' => 'delete_genres',
        'assign_terms' => 'assign_genres',
    ),
    
    // Default term
    'default_term'      => array(
        'name' => 'Uncategorized',
        'slug' => 'uncategorized',
    ),
    
    // Sorting
    'sort'              => true,
) );
```

---

## Hierarchical vs Non-Hierarchical

| Feature | Hierarchical (Categories) | Non-Hierarchical (Tags) |
|---------|---------------------------|-------------------------|
| Parent/child | Yes | No |
| UI | Checkboxes | Text input / tag cloud |
| URLs | Can be nested | Flat |
| Use case | Strict classification | Free-form tagging |

---

## Working with Terms

### wp_insert_term()

Creates a new term.

```php
$result = wp_insert_term( 'Science Fiction', 'genre', array(
    'slug'        => 'sci-fi',
    'description' => 'Science fiction books',
    'parent'      => 0,  // Or parent term ID
) );

if ( ! is_wp_error( $result ) ) {
    $term_id = $result['term_id'];
}
```

### wp_update_term()

Updates an existing term.

```php
wp_update_term( $term_id, 'genre', array(
    'name'        => 'Sci-Fi',
    'description' => 'Updated description',
) );
```

### wp_delete_term()

Deletes a term.

```php
wp_delete_term( $term_id, 'genre' );
```

### get_term()

Retrieves a single term.

```php
$term = get_term( $term_id, 'genre' );
echo $term->name;
```

### get_terms()

Retrieves multiple terms.

```php
$terms = get_terms( array(
    'taxonomy'   => 'genre',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
) );

foreach ( $terms as $term ) {
    echo $term->name . ' (' . $term->count . ')';
}
```

---

## Assigning Terms to Posts

### wp_set_object_terms()

```php
// Set terms (replaces existing)
wp_set_object_terms( $post_id, array( 'sci-fi', 'fantasy' ), 'genre' );

// Set by term ID
wp_set_object_terms( $post_id, array( 5, 12 ), 'genre' );

// Append instead of replace
wp_set_object_terms( $post_id, 'horror', 'genre', true );
```

### wp_remove_object_terms()

```php
wp_remove_object_terms( $post_id, 'horror', 'genre' );
```

### has_term()

```php
if ( has_term( 'sci-fi', 'genre', $post_id ) ) {
    // Post has the sci-fi genre
}
```

### get_the_terms()

```php
$terms = get_the_terms( $post_id, 'genre' );

if ( $terms && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        echo $term->name;
    }
}
```

---

## Querying by Taxonomy

### WP_Query

```php
$query = new WP_Query( array(
    'post_type' => 'book',
    'tax_query' => array(
        array(
            'taxonomy' => 'genre',
            'field'    => 'slug',
            'terms'    => 'sci-fi',
        ),
    ),
) );

// Multiple terms (OR)
$query = new WP_Query( array(
    'post_type' => 'book',
    'tax_query' => array(
        array(
            'taxonomy' => 'genre',
            'field'    => 'slug',
            'terms'    => array( 'sci-fi', 'fantasy' ),
            'operator' => 'IN',  // Default
        ),
    ),
) );

// Multiple taxonomies (AND)
$query = new WP_Query( array(
    'post_type' => 'book',
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'genre',
            'field'    => 'slug',
            'terms'    => 'sci-fi',
        ),
        array(
            'taxonomy' => 'author',
            'field'    => 'slug',
            'terms'    => 'asimov',
        ),
    ),
) );

// NOT IN
$query = new WP_Query( array(
    'post_type' => 'book',
    'tax_query' => array(
        array(
            'taxonomy' => 'genre',
            'field'    => 'slug',
            'terms'    => 'romance',
            'operator' => 'NOT IN',
        ),
    ),
) );
```

---

## REST API

With `show_in_rest => true`:

```
GET    /wp-json/wp/v2/genres
GET    /wp-json/wp/v2/genres/{id}
POST   /wp-json/wp/v2/genres
PUT    /wp-json/wp/v2/genres/{id}
DELETE /wp-json/wp/v2/genres/{id}
```

---

## Template Hierarchy

1. `taxonomy-{taxonomy}-{term}.php`
2. `taxonomy-{taxonomy}.php`
3. `taxonomy.php`
4. `archive.php`
5. `index.php`

---

## Term Meta

**Since:** WordPress 4.4.0

```php
// Add meta
add_term_meta( $term_id, 'color', '#ff0000' );

// Get meta
$color = get_term_meta( $term_id, 'color', true );

// Update meta
update_term_meta( $term_id, 'color', '#00ff00' );

// Delete meta
delete_term_meta( $term_id, 'color' );
```

### Register Term Meta

```php
register_term_meta( 'genre', 'color', array(
    'type'         => 'string',
    'single'       => true,
    'show_in_rest' => true,
) );
```

---

## Best Practices

1. **Register on `init`** — After post types
2. **Flush permalinks** — On activation only
3. **Use `show_in_rest`** — For Gutenberg support
4. **Show admin column** — Better content management
5. **Set default term** — Prevent unclassified content
6. **Prefix taxonomy names** — Avoid conflicts
