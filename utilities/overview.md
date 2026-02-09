# Utility Classes

Core utility classes for common operations in WordPress.

**Source:** `wp-includes/`

## Components

| Component | Description |
|-----------|-------------|
| [class-wp-list-util.md](./class-wp-list-util.md) | Array/object list operations (filter, pluck, sort) |
| [class-wp-session-tokens.md](./class-wp-session-tokens.md) | User session token management |
| [class-wp-duotone.md](./class-wp-duotone.md) | Duotone color filter SVG generation |
| [speculative-loading.md](./speculative-loading.md) | Speculative loading / prerender API |
| [hooks.md](./hooks.md) | Related actions and filters |

## WP_List_Util

Utility for filtering, plucking, and sorting arrays of objects or arrays.

```php
$util = new WP_List_Util( $posts );
$filtered = $util->filter( array( 'post_status' => 'publish' ) )
                 ->sort( 'post_date', 'DESC' )
                 ->get_output();
```

## WP_Session_Tokens

Abstract class for managing user session tokens. Default implementation stores tokens in user meta.

```php
$manager = WP_Session_Tokens::get_instance( $user_id );
$token = $manager->create( $expiration );
$manager->verify( $token ); // true|false
$manager->destroy( $token );
```

## WP_Duotone

Generates SVG filter definitions for duotone color effects on images.

```
Block with duotone attribute
    └── render_duotone_support()
            ├── Parse colors (hex/rgb/hsl)
            ├── Generate SVG filter
            └── Output CSS and SVG
```

## Speculative Loading

Prefetch/prerender API using the Speculation Rules API (WordPress 6.8+).

```php
// Configuration
$config = wp_get_speculation_rules_configuration();
// Returns: ['mode' => 'prefetch', 'eagerness' => 'conservative']

// Full rules object
$rules = wp_get_speculation_rules();
```
