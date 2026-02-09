# Charset and Collation

WordPress uses UTF-8 character encoding with MySQL/MariaDB collations optimized for Unicode.

## Default Settings

Since WordPress 4.2 (2015):

```php
// wp-config.php defaults
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );  // Uses database default
```

## utf8mb4 vs utf8

| Feature | utf8 | utf8mb4 |
|---------|------|---------|
| Max bytes per character | 3 | 4 |
| Emoji support | ❌ | ✅ |
| Full Unicode | ❌ | ✅ |
| Supplementary characters | ❌ | ✅ |

**WordPress requires utf8mb4** for full emoji and international character support.

## Common Collations

| Collation | Description |
|-----------|-------------|
| `utf8mb4_unicode_ci` | Unicode sorting, case-insensitive |
| `utf8mb4_unicode_520_ci` | Unicode 5.2, improved sorting |
| `utf8mb4_general_ci` | Faster but less accurate sorting |
| `utf8mb4_bin` | Binary comparison (case-sensitive) |
| `utf8mb4_0900_ai_ci` | MySQL 8.0 default, accent-insensitive |

WordPress default: `utf8mb4_unicode_520_ci`

## Checking Current Settings

### Database Level

```sql
SELECT @@character_set_database, @@collation_database;
```

### Table Level

```sql
SELECT table_name, table_collation 
FROM information_schema.tables 
WHERE table_schema = 'your_database';
```

### Column Level

```sql
SELECT column_name, character_set_name, collation_name
FROM information_schema.columns
WHERE table_schema = 'your_database'
  AND table_name = 'wp_posts';
```

### Show Table Status

```sql
SHOW TABLE STATUS LIKE 'wp_posts';
```

## WordPress Configuration

### In wp-config.php

```php
// Full 4-byte UTF-8 (recommended)
define( 'DB_CHARSET', 'utf8mb4' );

// Let WordPress choose collation
define( 'DB_COLLATE', '' );

// Or specify explicitly
define( 'DB_COLLATE', 'utf8mb4_unicode_520_ci' );
```

### In $wpdb

```php
global $wpdb;
$wpdb->charset;   // 'utf8mb4'
$wpdb->collate;   // 'utf8mb4_unicode_520_ci'
```

## Converting Existing Tables

### Check for Mixed Encodings

```sql
SELECT table_name, table_collation
FROM information_schema.tables
WHERE table_schema = 'your_database'
  AND table_collation NOT LIKE 'utf8mb4%';
```

### Convert Table to utf8mb4

```sql
ALTER TABLE wp_posts 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_520_ci;
```

### Convert All Tables

```sql
-- Generate ALTER statements
SELECT CONCAT(
    'ALTER TABLE `', table_name, '` ',
    'CONVERT TO CHARACTER SET utf8mb4 ',
    'COLLATE utf8mb4_unicode_520_ci;'
)
FROM information_schema.tables
WHERE table_schema = 'your_database'
  AND table_type = 'BASE TABLE';
```

## Index Length Limits

### The 767 Byte Limit

Older MySQL (pre-5.7) limits index key length to 767 bytes.

With utf8mb4 (4 bytes/char): `767 / 4 = 191 characters max`

This is why you see indexes like:
```sql
KEY `meta_key` (`meta_key`(191))
```

### Modern MySQL (5.7+)

With `innodb_large_prefix=ON` and `ROW_FORMAT=DYNAMIC`:
- Index limit: 3072 bytes
- 768 characters for utf8mb4

WordPress tables use `ROW_FORMAT=Dynamic` when available.

## Common Issues

### Emoji Broken

**Cause:** Tables still using utf8 (3-byte)
**Fix:** Convert to utf8mb4

### "Specified key was too long"

**Cause:** Index exceeds byte limit
**Fix:** 
- Use `(191)` prefix for varchar indexes
- Enable large prefix support
- Use `ROW_FORMAT=DYNAMIC`

### Collation Mismatch Errors

**Cause:** Joining tables with different collations
**Fix:** Ensure all tables use same collation, or cast in query:

```sql
SELECT * FROM wp_posts p
JOIN wp_postmeta pm ON p.ID = pm.post_id
WHERE pm.meta_key COLLATE utf8mb4_unicode_520_ci = 'my_key';
```

### Mojibake (Garbled Characters)

**Cause:** Double-encoding or wrong connection charset
**Fix:** 
```php
// Ensure connection uses utf8mb4
$wpdb->set_charset( $wpdb->dbh, 'utf8mb4' );
```

## Best Practices

1. **Use utf8mb4** for new installations
2. **Use utf8mb4_unicode_520_ci** collation
3. **Set charset in wp-config.php** before install
4. **Check collation consistency** across all tables
5. **Backup before converting** existing databases
6. **Test emoji** after conversion (📝✅🎉)

## Checking Emoji Support

```sql
-- Insert test emoji
INSERT INTO wp_options (option_name, option_value, autoload) 
VALUES ('emoji_test', '🎉📝✅', 'no');

-- Verify it stored correctly
SELECT option_value FROM wp_options WHERE option_name = 'emoji_test';

-- Clean up
DELETE FROM wp_options WHERE option_name = 'emoji_test';
```

## Server Requirements

- MySQL 5.5.3+ or MariaDB 5.5+
- `innodb_file_format = Barracuda` (for large indexes)
- `innodb_large_prefix = ON` (MySQL < 8.0)
