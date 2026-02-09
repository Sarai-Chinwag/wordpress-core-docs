# WordPress Bookmarks/Links Manager

## Overview

The WordPress Bookmarks API (also known as Links Manager) is a **legacy feature** that was included in WordPress for managing blogroll links. It was hidden from the WordPress admin interface in version 3.5 (2012) but remains in core for backward compatibility.

## Status: Legacy/Deprecated

- **Hidden since**: WordPress 3.5
- **Still functional**: Yes, the API remains in core
- **Admin UI**: Requires the [Link Manager](https://wordpress.org/plugins/link-manager/) plugin to re-enable

## What It Does

The Links Manager allows storing and displaying external links (bookmarks) organized by categories. Each link can have:

- **URL** (`link_url`) - The destination address
- **Name** (`link_name`) - Display text
- **Description** (`link_description`) - Longer text about the link
- **Image** (`link_image`) - Optional icon/image
- **Target** (`link_target`) - `_blank`, `_top`, or empty
- **Category** (`link_category`) - Uses the `link_category` taxonomy
- **Visibility** (`link_visible`) - Y/N flag
- **Rating** (`link_rating`) - Numeric rating
- **Owner** (`link_owner`) - User ID who created it
- **Rel** (`link_rel`) - Relationship attribute (XFN)
- **Notes** (`link_notes`) - Private notes
- **RSS** (`link_rss`) - RSS feed URL for the link
- **Updated** (`link_updated`) - Last update timestamp

## Database

Links are stored in the `wp_links` table. Link categories use the standard taxonomy system with `link_category` as the taxonomy name.

## Source Files

| File | Purpose |
|------|---------|
| `wp-includes/bookmark.php` | Core bookmark data functions |
| `wp-includes/bookmark-template.php` | Template tags for displaying bookmarks |

## Common Use Cases

### Display a Blogroll

```php
wp_list_bookmarks( array(
    'title_li' => 'My Links',
    'categorize' => true,
) );
```

### Get All Bookmarks

```php
$links = get_bookmarks( array(
    'orderby' => 'name',
    'order' => 'ASC',
) );
```

### Get a Single Bookmark

```php
$bookmark = get_bookmark( 123 );
echo $bookmark->link_name;
```

## Why It's Still Relevant

While the feature is hidden, some sites still use it for:

- Legacy blogroll functionality
- Custom link directories
- Resource collections
- Partner/sponsor links

Themes that support this feature can display links using `wp_list_bookmarks()` in sidebars or dedicated pages.
