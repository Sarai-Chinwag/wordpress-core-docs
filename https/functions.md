# HTTPS Functions

Detection and migration functions for WordPress HTTPS support.

**Source:** `wp-includes/https-detection.php`, `wp-includes/https-migration.php`

---

## Detection Functions

### wp_is_using_https()

Checks whether the website is using HTTPS (both home and site URLs).

```php
wp_is_using_https(): bool
```

### Returns

`true` if both home and site URLs use HTTPS, `false` otherwise.

### Example

```php
if ( wp_is_using_https() ) {
    // Site is fully HTTPS
}
```

---

### wp_is_home_url_using_https()

Checks whether the current home URL is using HTTPS.

```php
wp_is_home_url_using_https(): bool
```

### Returns

`true` if `home_url()` uses HTTPS scheme, `false` otherwise.

---

### wp_is_site_url_using_https()

Checks whether the WordPress installation URL is using HTTPS.

```php
wp_is_site_url_using_https(): bool
```

This checks the URL where WordPress application files (e.g. `wp-blog-header.php` or `wp-admin/`) are accessible.

**Note:** Uses direct option access for `siteurl` and manually applies the `site_url` filter, because `site_url()` adjusts the scheme based on the current request.

### Returns

`true` if site URL uses HTTPS scheme, `false` otherwise.

---

### wp_is_https_supported()

Checks whether HTTPS is supported for the server and domain.

```php
wp_is_https_supported(): bool
```

**Warning:** This function makes an HTTP request to detect HTTPS support. Use cautiously in performance-sensitive environments.

### Returns

`true` if HTTPS is supported (no detection errors), `false` otherwise.

### Example

```php
if ( wp_is_https_supported() ) {
    // Safe to migrate to HTTPS
    wp_update_urls_to_https();
}
```

---

### wp_get_https_detection_errors()

Runs a remote HTTPS request to detect errors with HTTPS support.

```php
wp_get_https_detection_errors(): array
```

**Since:** 6.4.0  
**Access:** Private

### Detection Process

1. Apply `pre_wp_get_https_detection_errors` filter (allows short-circuit)
2. Make HTTPS request with SSL verification enabled
3. On SSL failure, retry without SSL verification
4. Verify response code is 200
5. Verify response comes from this site via `wp_is_local_html_output()`

### Returns

Array of error codes and messages, or empty array if no errors.

### Error Codes

| Code | Description |
|------|-------------|
| `https_request_failed` | HTTPS request failed entirely |
| `ssl_verification_failed` | SSL certificate verification failed |
| `bad_response_code` | Non-200 HTTP response |
| `bad_response_source` | Response doesn't appear to be from this site |

---

### wp_is_local_html_output()

Checks whether HTML string is likely output from this WordPress site.

```php
wp_is_local_html_output( string $html ): ?bool
```

**Access:** Private

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$html` | string | Full HTML output string |

### Detection Methods

1. Check for Really Simple Discovery link (`rsd_link`)
2. Check for REST API link (`rest_output_link_wp_head`)

### Returns

- `true` - HTML appears to be from this site
- `false` - HTML is not from this site
- `null` - Unable to determine (detection methods disabled)

---

## Migration Functions

### wp_should_replace_insecure_home_url()

Checks whether WordPress should replace old HTTP URLs with HTTPS.

```php
wp_should_replace_insecure_home_url(): bool
```

### Conditions

Returns `true` when ALL of these are met:
1. Site is using HTTPS (`wp_is_using_https()`)
2. `https_migration_required` option is set
3. Home and site URLs use the same domain

### Returns

`true` if insecure URLs should be replaced, `false` otherwise.

### Example

```php
// Check before manually replacing URLs
if ( wp_should_replace_insecure_home_url() ) {
    // WordPress is handling URL replacement
}
```

---

### wp_replace_insecure_home_url()

Replaces insecure HTTP URLs in content with HTTPS equivalents.

```php
wp_replace_insecure_home_url( string $content ): string
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$content` | string | Content to process |

### Replacement Behavior

- `http://example.com` → `https://example.com`
- `http:\/\/example.com` → `https:\/\/example.com` (escaped URLs in JSON)

### Returns

Content with HTTP URLs replaced, or original content if replacement not needed.

### Example

```php
// Applied automatically via filters, but can be called directly
$safe_content = wp_replace_insecure_home_url( $content );
```

---

### wp_update_urls_to_https()

Updates the `home` and `siteurl` options to use HTTPS.

```php
wp_update_urls_to_https(): bool
```

### Behavior

1. Gets current `home` and `siteurl` values
2. Replaces `http://` with `https://`
3. Updates both options
4. Verifies `wp_is_using_https()` returns true
5. **Reverts changes if verification fails** (e.g., constants override URLs)

### Returns

`true` on success, `false` on failure (with changes reverted).

### Example

```php
if ( wp_is_https_supported() && ! wp_is_using_https() ) {
    $success = wp_update_urls_to_https();
    if ( $success ) {
        // Successfully migrated to HTTPS
    } else {
        // Migration failed, possibly due to constants
    }
}
```

---

### wp_update_https_migration_required()

Updates the `https_migration_required` option when home URL changes.

```php
wp_update_https_migration_required( mixed $old_url, mixed $new_url ): void
```

**Access:** Private  
**Hooked to:** `update_option_home` action

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$old_url` | mixed | Previous home URL value |
| `$new_url` | mixed | New home URL value |

### Behavior

1. Skips during WordPress installation
2. Resets option if new URL is not HTTPS version of old URL
3. Sets `https_migration_required` to:
   - `false` for fresh sites (no content to migrate)
   - `true` for existing sites with content
