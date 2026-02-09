# wp_usermeta

Key-value storage for user metadata. Stores capabilities, preferences, and custom user data.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `umeta_id` | bigint(20) unsigned | NO | auto_increment | Unique identifier for the meta entry |
| `user_id` | bigint(20) unsigned | NO | 0 | Associated user ID (FK → wp_users.ID) |
| `meta_key` | varchar(255) | YES | NULL | Meta key name |
| `meta_value` | longtext | YES | NULL | Meta value (can be serialized) |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | umeta_id | Yes | Primary key |
| `user_id` | user_id | No | All meta for a user |
| `meta_key` | meta_key(191) | No | Lookup by key name |

## Foreign Key Relationships

- `user_id` → `wp_users.ID` (the user this meta belongs to)

## Core Meta Keys

### Authentication & Capabilities

| Key | Description |
|-----|-------------|
| `wp_capabilities` | Serialized array of role(s) → true |
| `wp_user_level` | Deprecated numeric user level (0-10) |
| `session_tokens` | Active login sessions |

### Profile Information

| Key | Description |
|-----|-------------|
| `nickname` | User's nickname |
| `first_name` | First name |
| `last_name` | Last name |
| `description` | Biographical info |

### Preferences

| Key | Description |
|-----|-------------|
| `admin_color` | Admin color scheme |
| `use_ssl` | Force SSL on admin |
| `show_admin_bar_front` | Show admin bar on frontend |
| `locale` | User-specific locale |
| `rich_editing` | Use visual editor |
| `syntax_highlighting` | Code syntax highlighting |
| `comment_shortcuts` | Keyboard shortcuts for comments |

### Dashboard & Admin

| Key | Description |
|-----|-------------|
| `dismissed_wp_pointers` | Dismissed admin pointers |
| `wp_dashboard_quick_press_last_post_id` | Quick Draft post ID |
| `community-events-location` | Dashboard events location |
| `closedpostboxes_*` | Collapsed metaboxes |
| `metaboxhidden_*` | Hidden metaboxes |
| `screen_layout_*` | Screen column layout |

## Capabilities Format

```php
// wp_capabilities value (serialized)
a:1:{s:13:"administrator";b:1;}

// Decoded
['administrator' => true]
```

## Common Queries

### Get all meta for a user
```sql
SELECT meta_key, meta_value 
FROM wp_usermeta 
WHERE user_id = 1;
```

### Get specific meta value
```sql
SELECT meta_value 
FROM wp_usermeta 
WHERE user_id = 1 
  AND meta_key = 'first_name';
```

### Get all administrators
```sql
SELECT u.* 
FROM wp_users u
JOIN wp_usermeta um ON u.ID = um.user_id
WHERE um.meta_key = 'wp_capabilities' 
  AND um.meta_value LIKE '%administrator%';
```

### Get users with specific meta
```sql
SELECT u.*, um.meta_value as custom_field
FROM wp_users u
JOIN wp_usermeta um ON u.ID = um.user_id
WHERE um.meta_key = 'my_custom_field';
```

### Delete orphaned usermeta
```sql
DELETE um FROM wp_usermeta um
LEFT JOIN wp_users u ON um.user_id = u.ID
WHERE u.ID IS NULL;
```

### Count users by role
```sql
SELECT 
  CASE 
    WHEN meta_value LIKE '%administrator%' THEN 'administrator'
    WHEN meta_value LIKE '%editor%' THEN 'editor'
    WHEN meta_value LIKE '%author%' THEN 'author'
    WHEN meta_value LIKE '%contributor%' THEN 'contributor'
    WHEN meta_value LIKE '%subscriber%' THEN 'subscriber'
    ELSE 'other'
  END as role,
  COUNT(*) as count
FROM wp_usermeta
WHERE meta_key = 'wp_capabilities'
GROUP BY role;
```

## WordPress API Functions

- `get_user_meta( $user_id, $key, $single )` - Get meta value(s)
- `add_user_meta( $user_id, $key, $value, $unique )` - Add meta
- `update_user_meta( $user_id, $key, $value )` - Update meta
- `delete_user_meta( $user_id, $key, $value )` - Delete meta
- `get_user_option( $option, $user_id )` - Get user option
- `update_user_option( $user_id, $option, $value )` - Update user option

## Multisite Notes

In multisite, capabilities use the blog prefix:
- `wp_capabilities` → single site or main site
- `wp_2_capabilities` → site ID 2
- `wp_3_capabilities` → site ID 3

The `{$prefix}_user_level` follows the same pattern.

## Performance Notes

- Session tokens can grow large with many active sessions
- Stale session data should be periodically cleaned
- Use `get_user_meta()` with `$single = true` when expecting one value
