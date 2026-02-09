# Taxonomy API

Framework for classifying and organizing WordPress content through hierarchical and non-hierarchical term groupings.

**Since:** 2.3.0  
**Source:** `wp-includes/taxonomy.php`, `wp-includes/class-wp-taxonomy.php`, `wp-includes/class-wp-term.php`, `wp-includes/class-wp-term-query.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core registration, retrieval, and manipulation functions |
| [class-wp-taxonomy.md](./class-wp-taxonomy.md) | Taxonomy definition and configuration |
| [class-wp-term.md](./class-wp-term.md) | Individual term instance |
| [class-wp-term-query.md](./class-wp-term-query.md) | Term querying and retrieval |
| [hooks.md](./hooks.md) | Actions and filters |

## Built-in Taxonomies

| Taxonomy | Hierarchical | Object Types | Description |
|----------|--------------|--------------|-------------|
| `category` | Yes | post | Post categories |
| `post_tag` | No | post | Post tags |
| `nav_menu` | No | nav_menu_item | Navigation menus |
| `link_category` | No | link | Link categories |
| `post_format` | No | post | Post formats |
| `wp_theme` | No | wp_template, wp_template_part, wp_global_styles | Theme association |
| `wp_template_part_area` | No | wp_template_part | Template part areas |
| `wp_pattern_category` | No | wp_block | Block pattern categories |

## Registration Flow

```
init hook
    └── register_taxonomy()
            └── new WP_Taxonomy()
                    ├── set_props()
                    │       ├── apply_filters('register_taxonomy_args')
                    │       ├── apply_filters('register_{$taxonomy}_taxonomy_args')
                    │       └── get_taxonomy_labels()
                    ├── add_rewrite_rules()
                    └── add_hooks()
            └── do_action('registered_taxonomy')
            └── do_action('registered_taxonomy_{$taxonomy}')
```

## Term Retrieval Flow

```
get_terms() / WP_Term_Query::query()
    ├── parse_query()
    │       ├── apply_filters('get_terms_defaults')
    │       └── do_action('parse_term_query')
    ├── do_action_ref_array('pre_get_terms')
    ├── apply_filters('get_terms_args')
    ├── apply_filters('list_terms_exclusions')
    ├── apply_filters('get_terms_fields')
    ├── apply_filters('terms_clauses')
    ├── apply_filters_ref_array('terms_pre_query')
    ├── Database query
    ├── _prime_term_caches()
    └── apply_filters('get_terms')
```

## Term Modification Flow

```
wp_insert_term()
    ├── apply_filters('pre_insert_term')
    ├── sanitize_term()
    ├── apply_filters('wp_insert_term_data')
    ├── Database insert
    ├── do_action('create_term')
    ├── do_action('create_{$taxonomy}')
    ├── apply_filters('term_id_filter')
    ├── clean_term_cache()
    ├── do_action('created_term')
    ├── do_action('created_{$taxonomy}')
    ├── do_action('saved_term')
    └── do_action('saved_{$taxonomy}')

wp_update_term()
    ├── get_term()
    ├── sanitize_term()
    ├── apply_filters('wp_update_term_parent')
    ├── apply_filters('wp_update_term_data')
    ├── do_action('edit_terms')
    ├── Database update
    ├── do_action('edited_terms')
    ├── do_action('edit_term_taxonomy')
    ├── do_action('edited_term_taxonomy')
    ├── do_action('edit_term')
    ├── do_action('edit_{$taxonomy}')
    ├── clean_term_cache()
    ├── do_action('edited_term')
    ├── do_action('edited_{$taxonomy}')
    ├── do_action('saved_term')
    └── do_action('saved_{$taxonomy}')
```

## Database Schema

### wp_terms

| Column | Type | Description |
|--------|------|-------------|
| `term_id` | bigint(20) | Term ID (primary key) |
| `name` | varchar(200) | Term name |
| `slug` | varchar(200) | URL-friendly name |
| `term_group` | bigint(10) | Group for term aliases |

### wp_term_taxonomy

| Column | Type | Description |
|--------|------|-------------|
| `term_taxonomy_id` | bigint(20) | Term taxonomy ID (primary key) |
| `term_id` | bigint(20) | Foreign key to wp_terms |
| `taxonomy` | varchar(32) | Taxonomy name |
| `description` | longtext | Term description |
| `parent` | bigint(20) | Parent term ID |
| `count` | bigint(20) | Object count |

### wp_term_relationships

| Column | Type | Description |
|--------|------|-------------|
| `object_id` | bigint(20) | Post/object ID |
| `term_taxonomy_id` | bigint(20) | Foreign key to wp_term_taxonomy |
| `term_order` | int(11) | Sort order |

### wp_termmeta

| Column | Type | Description |
|--------|------|-------------|
| `meta_id` | bigint(20) | Meta ID (primary key) |
| `term_id` | bigint(20) | Foreign key to wp_terms |
| `meta_key` | varchar(255) | Meta key |
| `meta_value` | longtext | Meta value |
