# Root Files

Entry point files in the WordPress root directory.

**Source:** WordPress installation root

## Bootstrap

| File | Description |
|------|-------------|
| [index.php.md](./index.php.md) | Front controller entry point |
| [wp-load.php.md](./wp-load.php.md) | Environment loader |
| [wp-blog-header.php.md](./wp-blog-header.php.md) | Template loader |
| [wp-settings.php.md](./wp-settings.php.md) | Core initialization |
| [wp-config.php.md](./wp-config.php.md) | Site configuration |
| [wp-config-sample.php.md](./wp-config-sample.php.md) | Config template |

## Authentication

| File | Description |
|------|-------------|
| [wp-login.php.md](./wp-login.php.md) | Login/logout handling |
| [wp-signup.php.md](./wp-signup.php.md) | Multisite signup |
| [wp-activate.php.md](./wp-activate.php.md) | Account activation |

## Endpoints

| File | Description |
|------|-------------|
| [wp-cron.php.md](./wp-cron.php.md) | Cron execution endpoint |
| [wp-mail.php.md](./wp-mail.php.md) | Post-by-email handler |
| [wp-trackback.php.md](./wp-trackback.php.md) | Trackback handler |
| [wp-comments-post.php.md](./wp-comments-post.php.md) | Comment submission |
| [xmlrpc.php.md](./xmlrpc.php.md) | XML-RPC endpoint |
| [wp-links-opml.php.md](./wp-links-opml.php.md) | Blogroll export |

## Request Flow

```
index.php
    └── wp-blog-header.php
            ├── wp-load.php
            │       └── wp-config.php
            │               └── wp-settings.php
            └── template-loader.php
```
