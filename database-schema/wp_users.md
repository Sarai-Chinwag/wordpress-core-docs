# wp_users

Stores WordPress user accounts. Core authentication and profile data.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `ID` | bigint(20) unsigned | NO | auto_increment | Unique user identifier |
| `user_login` | varchar(60) | NO | '' | Username for login |
| `user_pass` | varchar(255) | NO | '' | Hashed password (phpass) |
| `user_nicename` | varchar(50) | NO | '' | URL-friendly username slug |
| `user_email` | varchar(100) | NO | '' | User email address |
| `user_url` | varchar(100) | NO | '' | User website URL |
| `user_registered` | datetime | NO | 0000-00-00 00:00:00 | Registration timestamp |
| `user_activation_key` | varchar(255) | NO | '' | Password reset key |
| `user_status` | int(11) | NO | 0 | Deprecated (was spam flag in MU) |
| `display_name` | varchar(250) | NO | '' | Public display name |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | ID | Yes | Primary key |
| `user_login_key` | user_login | No | Login lookup |
| `user_nicename` | user_nicename | No | Author archive URLs |
| `user_email` | user_email | No | Email lookup |

## Foreign Key Relationships

Referenced by:
- `wp_posts.post_author` → `wp_users.ID`
- `wp_comments.user_id` → `wp_users.ID`
- `wp_usermeta.user_id` → `wp_users.ID`
- `wp_links.link_owner` → `wp_users.ID`

## Password Hashing

WordPress uses phpass-based hashing:
- Passwords start with `$P$` (portable hash)
- Modern WP also supports bcrypt (`$2y$`)
- Never store or compare plaintext passwords

```php
// Check password
wp_check_password( $plaintext, $hash, $user_id );

// Hash password
wp_hash_password( $plaintext );
```

## Common Queries

### Get user by ID
```sql
SELECT * FROM wp_users WHERE ID = 1;
```

### Get user by login
```sql
SELECT * FROM wp_users WHERE user_login = 'admin';
```

### Get user by email
```sql
SELECT * FROM wp_users WHERE user_email = 'user@example.com';
```

### Get all users with roles
```sql
SELECT u.ID, u.user_login, u.display_name, um.meta_value as capabilities
FROM wp_users u
JOIN wp_usermeta um ON u.ID = um.user_id
WHERE um.meta_key = 'wp_capabilities';
```

### Get users registered in date range
```sql
SELECT * FROM wp_users 
WHERE user_registered BETWEEN '2024-01-01' AND '2024-12-31'
ORDER BY user_registered DESC;
```

### Count users by registration month
```sql
SELECT DATE_FORMAT(user_registered, '%Y-%m') as month, COUNT(*) as count
FROM wp_users
GROUP BY month
ORDER BY month DESC;
```

### Get user with post count
```sql
SELECT u.*, COUNT(p.ID) as post_count
FROM wp_users u
LEFT JOIN wp_posts p ON u.ID = p.post_author 
  AND p.post_type = 'post' 
  AND p.post_status = 'publish'
GROUP BY u.ID
ORDER BY post_count DESC;
```

## WordPress API Functions

- `get_user_by( $field, $value )` - Get user by ID, slug, email, or login
- `get_userdata( $user_id )` - Get user data object
- `wp_get_current_user()` - Current logged-in user
- `wp_create_user()` - Create new user
- `wp_update_user()` - Update user
- `wp_delete_user()` - Delete user
- `username_exists()` - Check if username taken
- `email_exists()` - Check if email registered

## Security Notes

- `user_login` cannot be changed after creation
- `user_email` must be unique
- `user_activation_key` is time-limited and single-use
- `user_status` is deprecated—spam status stored in usermeta
