# HTTPS Detection & Migration

Framework for detecting HTTPS support and migrating sites from HTTP to HTTPS.

**Since:** 5.7.0  
**Source:** `wp-includes/https-detection.php`, `wp-includes/https-migration.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Detection and migration functions |
| [hooks.md](./hooks.md) | Filters for customizing behavior |

## Detection Flow

```
wp_is_using_https()
    ├── wp_is_home_url_using_https()
    │       └── Check if home_url() uses HTTPS scheme
    └── wp_is_site_url_using_https()
            └── Check if site_url() uses HTTPS scheme

wp_is_https_supported()
    └── wp_get_https_detection_errors()
            ├── apply_filters('pre_wp_get_https_detection_errors')
            ├── wp_remote_request() with sslverify=true
            ├── Fallback: wp_remote_request() with sslverify=false
            ├── Check response code (200)
            └── wp_is_local_html_output() verification
```

## Migration Flow

```
wp_update_urls_to_https()
    ├── Get current 'home' and 'siteurl' options
    ├── Replace http:// with https://
    ├── update_option() for both
    ├── Verify wp_is_using_https()
    └── Revert on failure

update_option('home')
    └── wp_update_https_migration_required()
            ├── Check if new URL is HTTPS version of old
            ├── Set 'https_migration_required' option
            └── Fresh sites skip migration

wp_replace_insecure_home_url()
    └── wp_should_replace_insecure_home_url()
            ├── Check wp_is_using_https()
            ├── Check 'https_migration_required' option
            ├── Verify home/site domains match
            └── apply_filters('wp_should_replace_insecure_home_url')
```

## Key Options

| Option | Description |
|--------|-------------|
| `home` | Site address (URL) |
| `siteurl` | WordPress address (URL) |
| `https_migration_required` | Whether HTTP→HTTPS content replacement is needed |
| `fresh_site` | Whether site has content (fresh sites skip migration) |

## Content Replacement

When `https_migration_required` is true and the site uses HTTPS, WordPress automatically replaces HTTP URLs in content:

- **Replaced:** `http://example.com` → `https://example.com`
- **Escaped URLs:** `http:\/\/example.com` → `https:\/\/example.com`

Applied via filters on `the_content`, `the_excerpt`, etc.

## Error Detection

The detection system identifies these error types:

| Error Code | Description |
|------------|-------------|
| `https_request_failed` | HTTPS request failed entirely |
| `ssl_verification_failed` | HTTPS works but SSL certificate invalid |
| `bad_response_code` | Non-200 response from HTTPS request |
| `bad_response_source` | Response doesn't appear to be from this site |
