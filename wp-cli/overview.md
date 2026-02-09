# WP-CLI

Command-line interface for WordPress.

**Source:** WP-CLI commands via `wp` binary

## Commands

| Command | Description |
|---------|-------------|
| [core.md](./core.md) | Core download, install, update |
| [db.md](./db.md) | Database operations |
| [plugin.md](./plugin.md) | Plugin management |
| [theme.md](./theme.md) | Theme management |
| [post.md](./post.md) | Post CRUD operations |
| [user.md](./user.md) | User management |
| [term.md](./term.md) | Taxonomy term operations |
| [option.md](./option.md) | Options management |
| [transient.md](./transient.md) | Transient management |
| [cache.md](./cache.md) | Object cache operations |
| [cron.md](./cron.md) | WP-Cron management |
| [rewrite.md](./rewrite.md) | Rewrite rules |
| [search-replace.md](./search-replace.md) | Database search/replace |

## Quick Reference

```bash
# Core
wp core download
wp core install --url=example.com --title="Site" --admin_user=admin

# Content
wp post create --post_title="Hello" --post_status=publish
wp post list --post_type=page

# Database
wp db export backup.sql
wp search-replace 'old.com' 'new.com' --dry-run

# Maintenance
wp cache flush
wp cron event run --due-now
wp plugin update --all
```

## Note

WP-CLI is a separate project from WordPress core. This documentation covers the most common bundled commands.
