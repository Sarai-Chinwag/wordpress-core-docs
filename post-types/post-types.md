# Post Types API

Framework for registering and managing WordPress post types.

**Since:** 2.9.0  
**Source:** `wp-includes/post.php`, `wp-includes/class-wp-post-type.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core registration and retrieval functions |
| [class-wp-post-type.md](./class-wp-post-type.md) | Post type object (since 4.6.0) |
| [hooks.md](./hooks.md) | Actions and filters |

## Registration Flow

```
init
    └── register_post_type()
            └── new WP_Post_Type()
                    ├── set_props()
                    ├── add_supports()
                    ├── add_rewrite_rules()
                    ├── register_meta_boxes()
                    ├── add_hooks()
                    └── register_taxonomies()
            └── do_action('registered_post_type')
            └── do_action('registered_post_type_{$post_type}')
```

## Unregistration Flow

```
unregister_post_type()
    └── WP_Post_Type
            ├── remove_supports()
            ├── remove_rewrite_rules()
            ├── unregister_meta_boxes()
            ├── remove_hooks()
            └── unregister_taxonomies()
    └── do_action('unregistered_post_type')
```

## Built-in Post Types

| Post Type | Description |
|-----------|-------------|
| `post` | Standard blog posts |
| `page` | Static pages (hierarchical) |
| `attachment` | Media library items |
| `revision` | Post revisions |
| `nav_menu_item` | Navigation menu items |
| `custom_css` | Custom CSS (Customizer) |
| `customize_changeset` | Customizer changesets |
| `oembed_cache` | oEmbed response cache |
| `user_request` | Privacy/data requests |
| `wp_block` | Reusable blocks (patterns) |
| `wp_template` | Block templates |
| `wp_template_part` | Block template parts |
| `wp_global_styles` | Global styles |
| `wp_navigation` | Navigation menus |
| `wp_font_family` | Font families |
| `wp_font_face` | Font faces |

## Quick Example

```php
add_action( 'init', function() {
    register_post_type( 'book', array(
        'label'              => __( 'Books' ),
        'public'             => true,
        'show_in_rest'       => true,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'books' ),
        'menu_icon'          => 'dashicons-book',
    ) );
} );
```
