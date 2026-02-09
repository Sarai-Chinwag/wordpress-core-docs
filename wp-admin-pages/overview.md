# Admin Pages

WordPress admin (`wp-admin/`) page files.

**Source:** `wp-admin/*.php`

## Page Categories

| Category | Description |
|----------|-------------|
| [core.md](./core.md) | Dashboard, profile, about |
| [posts.md](./posts.md) | Post management screens |
| [pages.md](./pages.md) | Page management screens |
| [media.md](./media.md) | Media library screens |
| [comments.md](./comments.md) | Comment management |
| [themes.md](./themes.md) | Theme management |
| [plugins.md](./plugins.md) | Plugin management |
| [users.md](./users.md) | User management |
| [tools.md](./tools.md) | Tools screens |
| [settings.md](./settings.md) | Settings screens |
| [network.md](./network.md) | Multisite network admin |

## URL Structure

```
/wp-admin/index.php          → Dashboard
/wp-admin/edit.php           → Posts list
/wp-admin/post-new.php       → New post
/wp-admin/upload.php         → Media library
/wp-admin/themes.php         → Themes
/wp-admin/plugins.php        → Plugins
/wp-admin/users.php          → Users
/wp-admin/options-general.php → General settings
```

## Adding Admin Pages

```php
add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $callback );
add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback );
```
