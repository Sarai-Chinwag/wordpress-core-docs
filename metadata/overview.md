# Metadata API

Framework for storing and retrieving key-value metadata for WordPress objects.

**Since:** 2.9.0  
**Source:** `wp-includes/meta.php`, `wp-includes/class-wp-metadata-lazyloader.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core CRUD and registration functions |
| [class-wp-metadata-lazyloader.md](./class-wp-metadata-lazyloader.md) | Lazy-loading metadata queue |
| [hooks.md](./hooks.md) | Actions and filters |

## Supported Object Types

| Type | Table | ID Column |
|------|-------|-----------|
| `post` | `wp_postmeta` | `post_id` |
| `user` | `wp_usermeta` | `user_id` |
| `comment` | `wp_commentmeta` | `comment_id` |
| `term` | `wp_termmeta` | `term_id` |
| `blog` | `wp_blogmeta` | `blog_id` |

Custom object types can use the API if they have an associated meta table.

## Data Storage

Metadata values are stored with the following behavior:

| PHP Type | Stored As | Retrieved As |
|----------|-----------|--------------|
| `false` | `''` (empty string) | `''` |
| `true` | `'1'` | `'1'` |
| integers/floats | string | string |
| arrays/objects | serialized | original type |

## CRUD Flow

```
add_metadata()
    ├── validate inputs
    ├── apply_filters('add_{$type}_metadata')  [short-circuit]
    ├── check unique constraint
    ├── sanitize_meta()
    ├── do_action('add_{$type}_meta')  [before]
    ├── INSERT into table
    ├── wp_cache_delete()
    ├── do_action('added_{$type}_meta')  [after]
    └── return meta_id

get_metadata()
    ├── get_metadata_raw()
    │   ├── apply_filters('get_{$type}_metadata')  [short-circuit]
    │   ├── check cache
    │   ├── update_meta_cache() if miss
    │   └── return value or null
    └── get_metadata_default() if null

update_metadata()
    ├── validate inputs
    ├── apply_filters('update_{$type}_metadata')  [short-circuit]
    ├── compare old/new values
    ├── add_metadata() if key doesn't exist
    ├── sanitize_meta()
    ├── do_action('update_{$type}_meta')  [before]
    ├── UPDATE table
    ├── wp_cache_delete()
    ├── do_action('updated_{$type}_meta')  [after]
    └── return true

delete_metadata()
    ├── validate inputs
    ├── apply_filters('delete_{$type}_metadata')  [short-circuit]
    ├── find matching meta_ids
    ├── do_action('delete_{$type}_meta')  [before]
    ├── DELETE from table
    ├── wp_cache_delete()
    ├── do_action('deleted_{$type}_meta')  [after]
    └── return true
```

## Registration Flow

```
register_meta()
    ├── apply_filters('register_meta_args')
    ├── validate args (type, revisions, etc.)
    ├── add sanitize_callback filter
    ├── add auth_callback filter
    ├── add default filter if needed
    └── store in $wp_meta_keys global
```

## Lazy-Loading

For performance when loading many objects, metadata can be lazy-loaded:

```
wp_metadata_lazyloader()->queue_objects( 'term', $term_ids )
    └── on first get_term_metadata() call:
        └── update_meta_cache() for ALL queued terms
```
