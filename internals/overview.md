# Internals

Internal WordPress classes not intended for direct plugin use.

**Source:** `wp-includes/class-wp-*.php`

## Components

| Component | Description |
|-----------|-------------|
| [class-wp-meta-query.md](./class-wp-meta-query.md) | Meta query SQL generation |
| [class-wp-tax-query.md](./class-wp-tax-query.md) | Taxonomy query SQL generation |
| [class-wp-textdomain-registry.md](./class-wp-textdomain-registry.md) | Translation file registry |
| [class-wp-token-map.md](./class-wp-token-map.md) | Token compression map |
| [class-wp-url-pattern-prefixer.md](./class-wp-url-pattern-prefixer.md) | URL pattern handling |
| [class-wp-matchesmapregex.md](./class-wp-matchesmapregex.md) | Rewrite rule matching |

## Note

These classes are used internally by WordPress core. While not private, their APIs may change between versions. Use documented public functions when possible.
