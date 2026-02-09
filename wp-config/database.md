# Database Settings

WordPress requires a MySQL or MariaDB database. These constants configure the database connection.

## Required Constants

### DB_NAME

```php
define( 'DB_NAME', 'wordpress' );
```

- **Required**: Yes
- **Type**: String
- **Purpose**: Name of the database WordPress will use
- **Notes**: Database must exist before WordPress installation

### DB_USER

```php
define( 'DB_USER', 'db_username' );
```

- **Required**: Yes
- **Type**: String
- **Purpose**: MySQL username with access to the database
- **Security**: Create a dedicated user for WordPress; never use `root` in production

### DB_PASSWORD

```php
define( 'DB_PASSWORD', 'secure_password_here' );
```

- **Required**: Yes
- **Type**: String
- **Purpose**: Password for the database user
- **Security**: Use strong, unique passwords; consider environment variables for sensitive data

### DB_HOST

```php
define( 'DB_HOST', 'localhost' );
```

- **Required**: Yes
- **Type**: String
- **Default**: `localhost`
- **Purpose**: MySQL server hostname or IP address

#### Common Values

| Value | Description |
|-------|-------------|
| `localhost` | Local MySQL server (most common) |
| `127.0.0.1` | Local server via TCP/IP |
| `localhost:/path/to/socket` | Unix socket connection |
| `mysql.example.com` | Remote MySQL server |
| `mysql.example.com:3307` | Remote server with custom port |

#### Port and Socket Examples

```php
// Custom port
define( 'DB_HOST', 'localhost:3307' );

// Unix socket (common on Linux)
define( 'DB_HOST', 'localhost:/var/run/mysqld/mysqld.sock' );

// Remote host with port
define( 'DB_HOST', 'db.example.com:3306' );
```

## Character Set Constants

### DB_CHARSET

```php
define( 'DB_CHARSET', 'utf8mb4' );
```

- **Required**: No (but recommended)
- **Type**: String
- **Default**: `utf8mb4` (since WordPress 4.2)
- **Purpose**: Database character set for storing content
- **Recommendation**: Always use `utf8mb4` for full Unicode support (including emoji)

#### Common Values

| Value | Description |
|-------|-------------|
| `utf8mb4` | Full Unicode support including 4-byte characters (emoji) |
| `utf8` | Basic Unicode (3-byte max, no emoji) |
| `latin1` | Western European (legacy) |

### DB_COLLATE

```php
define( 'DB_COLLATE', '' );
```

- **Required**: No
- **Type**: String
- **Default**: Empty string (MySQL default for charset)
- **Purpose**: Database collation for sorting and comparison

#### Common Values

| Value | Description |
|-------|-------------|
| `''` | Use MySQL default (recommended) |
| `utf8mb4_unicode_ci` | Case-insensitive Unicode sorting |
| `utf8mb4_unicode_520_ci` | Unicode 5.2.0 sorting (WordPress default since 4.6) |
| `utf8mb4_general_ci` | Faster but less accurate sorting |

**Note**: Leave empty unless you have specific requirements. WordPress handles this automatically.

## Advanced Database Constants

### WP_ALLOW_REPAIR

```php
define( 'WP_ALLOW_REPAIR', true );
```

- **Type**: Boolean
- **Default**: Not defined (false)
- **Purpose**: Enables the database repair page at `/wp-admin/maint/repair.php`
- **Security**: Only enable temporarily when needed; remove after repair

**Important**: This page is accessible without authentication! Always remove or set to `false` after use.

### CUSTOM_USER_TABLE

```php
define( 'CUSTOM_USER_TABLE', 'shared_users' );
```

- **Type**: String
- **Purpose**: Use a custom users table (for sharing users across installations)
- **Use Case**: Multiple WordPress installations sharing user accounts

### CUSTOM_USER_META_TABLE

```php
define( 'CUSTOM_USER_META_TABLE', 'shared_usermeta' );
```

- **Type**: String
- **Purpose**: Use a custom user meta table
- **Note**: Usually used together with `CUSTOM_USER_TABLE`

## Database Connection Examples

### Standard Local Setup

```php
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'wp_user' );
define( 'DB_PASSWORD', 'strong_password' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
```

### Remote Database

```php
define( 'DB_NAME', 'wordpress_prod' );
define( 'DB_USER', 'wp_remote' );
define( 'DB_PASSWORD', 'very_strong_password' );
define( 'DB_HOST', 'db.example.com:3306' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
```

### Using Environment Variables

```php
define( 'DB_NAME', getenv( 'WORDPRESS_DB_NAME' ) ?: 'wordpress' );
define( 'DB_USER', getenv( 'WORDPRESS_DB_USER' ) ?: 'root' );
define( 'DB_PASSWORD', getenv( 'WORDPRESS_DB_PASSWORD' ) ?: '' );
define( 'DB_HOST', getenv( 'WORDPRESS_DB_HOST' ) ?: 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
```

### Socket Connection (Unix/Linux)

```php
define( 'DB_HOST', 'localhost:/var/lib/mysql/mysql.sock' );
// or
define( 'DB_HOST', 'localhost:/tmp/mysql.sock' );
```

## Shared User Tables Across Sites

For sharing users between multiple WordPress installations:

```php
// Site A - Primary (creates the tables)
$table_prefix = 'site_a_';

// Site B - Uses Site A's user tables
$table_prefix = 'site_b_';
define( 'CUSTOM_USER_TABLE', 'site_a_users' );
define( 'CUSTOM_USER_META_TABLE', 'site_a_usermeta' );
```

**Considerations**:
- User roles/capabilities are stored in usermeta with table-prefix-specific keys
- Each site may need to add its own capability keys
- Plugins may not fully support this configuration

## Troubleshooting

### Error: "Error establishing a database connection"

1. Verify DB_NAME, DB_USER, DB_PASSWORD are correct
2. Check DB_HOST (try `127.0.0.1` instead of `localhost`)
3. Ensure MySQL/MariaDB service is running
4. Confirm user has privileges on the database

### Test Database Connection

```php
<?php
// test-db.php (delete after testing!)
$conn = new mysqli( 'localhost', 'db_user', 'db_pass', 'db_name' );
if ( $conn->connect_error ) {
    die( 'Connection failed: ' . $conn->connect_error );
}
echo 'Connected successfully';
$conn->close();
```

### Grant Permissions (MySQL)

```sql
-- Create database
CREATE DATABASE wordpress CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;

-- Create user and grant privileges
CREATE USER 'wp_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON wordpress.* TO 'wp_user'@'localhost';
FLUSH PRIVILEGES;
```

## Security Best Practices

1. **Unique database name**: Don't use `wordpress` or predictable names
2. **Dedicated user**: Never use MySQL root account
3. **Strong password**: Use generated passwords (32+ characters)
4. **Minimal privileges**: Grant only necessary permissions
5. **Local connections**: Use `localhost` when possible; restrict remote access
6. **Environment variables**: Store credentials in environment, not in files committed to version control
