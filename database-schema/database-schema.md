# Database Schema

WordPress core database tables and structure.

**Source:** `wp-admin/includes/schema.php`

## Core Tables

| Table | Description |
|-------|-------------|
| [wp_posts.md](./wp_posts.md) | Posts, pages, and custom post types |
| [wp_postmeta.md](./wp_postmeta.md) | Post metadata |
| [wp_comments.md](./wp_comments.md) | Comments |
| [wp_commentmeta.md](./wp_commentmeta.md) | Comment metadata |
| [wp_users.md](./wp_users.md) | User accounts |
| [wp_usermeta.md](./wp_usermeta.md) | User metadata |
| [wp_terms.md](./wp_terms.md) | Taxonomy terms |
| [wp_term_taxonomy.md](./wp_term_taxonomy.md) | Term-taxonomy relationships |
| [wp_term_relationships.md](./wp_term_relationships.md) | Object-term relationships |
| [wp_termmeta.md](./wp_termmeta.md) | Term metadata |
| [wp_options.md](./wp_options.md) | Site options |
| [wp_links.md](./wp_links.md) | Blogroll links (legacy) |

## Schema Reference

| Topic | Description |
|-------|-------------|
| [table-prefixes.md](./table-prefixes.md) | Table prefix configuration |
| [charset-collation.md](./charset-collation.md) | Character set and collation |
| [multisite-tables.md](./multisite-tables.md) | Multisite-specific tables |
| [custom-tables.md](./custom-tables.md) | Creating custom tables |

## Key Relationships

```
wp_posts ─────┬──── wp_postmeta (1:many)
              ├──── wp_comments (1:many)
              └──── wp_term_relationships (many:many) ──── wp_terms

wp_users ─────┬──── wp_usermeta (1:many)
              └──── wp_posts (1:many via post_author)
```
