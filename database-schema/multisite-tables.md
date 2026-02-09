# Multisite Database Tables

WordPress Multisite adds network-level tables and per-site table copies.

## Network Tables

These tables exist once per network, typically without a numeric prefix.

### wp_blogs

Stores all sites in the network.

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `blog_id` | bigint(20) | NO | auto_increment | Site ID |
| `site_id` | bigint(20) | NO | 0 | Network ID (FK → wp_site.id) |
| `domain` | varchar(200) | NO | '' | Site domain |
| `path` | varchar(100) | NO | '' | Site path |
| `registered` | datetime | NO | 0000-00-00 00:00:00 | Registration date |
| `last_updated` | datetime | NO | 0000-00-00 00:00:00 | Last update |
| `public` | tinyint(2) | NO | 1 | Is public |
| `archived` | tinyint(2) | NO | 0 | Is archived |
| `mature` | tinyint(2) | NO | 0 | Is mature content |
| `spam` | tinyint(2) | NO | 0 | Is spam |
| `deleted` | tinyint(2) | NO | 0 | Is deleted |
| `lang_id` | int(11) | NO | 0 | Language ID |

**Indexes:**
- `PRIMARY` (blog_id)
- `domain` (domain(50), path(5))
- `lang_id` (lang_id)

### wp_site

Stores network definitions (for multi-network setups).

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `id` | bigint(20) | NO | auto_increment | Network ID |
| `domain` | varchar(200) | NO | '' | Network domain |
| `path` | varchar(100) | NO | '' | Network path |

**Indexes:**
- `PRIMARY` (id)
- `domain` (domain(140), path(51))

### wp_sitemeta

Network-wide options (like wp_options but for the network).

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `meta_id` | bigint(20) | NO | auto_increment | Unique ID |
| `site_id` | bigint(20) | NO | 0 | Network ID |
| `meta_key` | varchar(255) | YES | NULL | Option name |
| `meta_value` | longtext | YES | NULL | Option value |

**Indexes:**
- `PRIMARY` (meta_id)
- `meta_key` (meta_key(191))
- `site_id` (site_id)

**Common sitemeta keys:**
- `site_name` - Network name
- `admin_email` - Super admin email
- `active_sitewide_plugins` - Network-activated plugins
- `site_admins` - Super admin usernames
- `registration` - Registration settings
- `blog_upload_space` - Upload quota per site

### wp_blogmeta

Per-site metadata (added WordPress 5.1).

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `meta_id` | bigint(20) unsigned | NO | auto_increment | Unique ID |
| `blog_id` | bigint(20) | NO | 0 | Site ID |
| `meta_key` | varchar(255) | YES | NULL | Meta key |
| `meta_value` | longtext | YES | NULL | Meta value |

**Indexes:**
- `PRIMARY` (meta_id)
- `meta_key` (meta_key(191))
- `blog_id` (blog_id)

### wp_registration_log

User registration log (legacy).

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `ID` | bigint(20) | NO | auto_increment | Log ID |
| `email` | varchar(255) | NO | '' | Email used |
| `IP` | varchar(30) | NO | '' | IP address |
| `blog_id` | bigint(20) | NO | 0 | Site registered on |
| `date_registered` | datetime | NO | 0000-00-00 00:00:00 | Registration date |

### wp_signups

Pending user/site signups awaiting activation.

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `signup_id` | bigint(20) | NO | auto_increment | Signup ID |
| `domain` | varchar(200) | NO | '' | Requested domain |
| `path` | varchar(100) | NO | '' | Requested path |
| `title` | longtext | NO | NULL | Requested site title |
| `user_login` | varchar(60) | NO | '' | Username |
| `user_email` | varchar(100) | NO | '' | Email |
| `registered` | datetime | NO | 0000-00-00 00:00:00 | Signup date |
| `activated` | datetime | NO | 0000-00-00 00:00:00 | Activation date |
| `active` | tinyint(1) | NO | 0 | Is activated |
| `activation_key` | varchar(50) | NO | '' | Activation key |
| `meta` | longtext | YES | NULL | Signup metadata |

## Per-Site Tables

Each site in a multisite network gets its own set of core tables with a numeric prefix:

| Main Site | Site 2 | Site 3 |
|-----------|--------|--------|
| wp_posts | wp_2_posts | wp_3_posts |
| wp_postmeta | wp_2_postmeta | wp_3_postmeta |
| wp_comments | wp_2_comments | wp_3_comments |
| wp_commentmeta | wp_2_commentmeta | wp_3_commentmeta |
| wp_terms | wp_2_terms | wp_3_terms |
| wp_termmeta | wp_2_termmeta | wp_3_termmeta |
| wp_term_taxonomy | wp_2_term_taxonomy | wp_3_term_taxonomy |
| wp_term_relationships | wp_2_term_relationships | wp_3_term_relationships |
| wp_options | wp_2_options | wp_3_options |
| wp_links | wp_2_links | wp_3_links |

## Shared Tables

These tables are shared across all sites:
- `wp_users` - Single user table for entire network
- `wp_usermeta` - User meta with per-site capabilities

**Per-site user capabilities:**
```
wp_capabilities     → Main site roles
wp_2_capabilities   → Site 2 roles
wp_3_capabilities   → Site 3 roles
```

## Common Queries

### List all sites
```sql
SELECT blog_id, domain, path, registered 
FROM wp_blogs 
WHERE deleted = 0 AND spam = 0 
ORDER BY blog_id;
```

### Get site by domain
```sql
SELECT * FROM wp_blogs 
WHERE domain = 'example.com' 
  AND path = '/';
```

### Get network options
```sql
SELECT meta_key, meta_value 
FROM wp_sitemeta 
WHERE site_id = 1;
```

### Get super admins
```sql
SELECT meta_value 
FROM wp_sitemeta 
WHERE meta_key = 'site_admins';
```

### Count posts across all sites
```sql
SELECT 
  b.blog_id,
  b.domain,
  (SELECT COUNT(*) FROM CONCAT('wp_', IF(b.blog_id=1,'','2_'), 'posts') 
   WHERE post_status='publish') as post_count
FROM wp_blogs b
WHERE b.deleted = 0;
-- Note: Dynamic table names require procedural code
```

### Get users for a specific site
```sql
SELECT u.* 
FROM wp_users u
JOIN wp_usermeta um ON u.ID = um.user_id
WHERE um.meta_key = 'wp_2_capabilities';
```

## WordPress API Functions

- `get_sites( $args )` - Get sites
- `get_site( $site_id )` - Get single site
- `get_blog_details( $blog_id )` - Get site details
- `get_current_blog_id()` - Current site ID
- `switch_to_blog( $blog_id )` - Switch context
- `restore_current_blog()` - Restore context
- `is_multisite()` - Check if multisite
- `get_network_option( $network_id, $option )` - Get sitemeta
- `update_network_option( $network_id, $option, $value )` - Update sitemeta
- `get_blog_option( $blog_id, $option )` - Get site option
- `add_blog_meta( $blog_id, $key, $value )` - Add blogmeta
- `get_blog_meta( $blog_id, $key, $single )` - Get blogmeta

## Table Prefix in Multisite

```php
global $wpdb;

// Current site prefix (e.g., "wp_" or "wp_2_")
$wpdb->prefix;

// Base prefix (always "wp_")
$wpdb->base_prefix;

// Get prefix for specific site
$wpdb->get_blog_prefix( $blog_id );
```
