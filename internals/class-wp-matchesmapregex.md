# WP_MatchesMapRegex

Helper class for replacing `$matches[]` references in query strings without using `eval()`.

**Source:** `wp-includes/class-wp-matchesmapregex.php`  
**Since:** 2.9.0

## Overview

This class provides a safe way to substitute `$matches[n]` placeholders in rewrite rule query strings with actual matched values from regex captures. It eliminates the security risk of using `eval()` for dynamic string replacement.

Primarily used internally by WordPress's rewrite system to map URL regex captures to query parameters.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$_matches` | array | private | Captured regex matches for substitution |
| `$output` | string | public | Result string after mapping |
| `$_subject` | string | private | Query string containing `$matches[]` references |
| `$_pattern` | string | public | Regex pattern matching `$matches[n]` syntax |

---

## Methods

### __construct()

Creates a new mapper and performs substitution.

```php
public function __construct( string $subject, array $matches )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$subject` | string | Query string with `$matches[n]` placeholders |
| `$matches` | array | Captured values to substitute |

The result is immediately available in the `$output` property.

---

### apply()

Static helper for one-liner substitution.

```php
public static function apply( string $subject, array $matches ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$subject` | string | Query string with placeholders |
| `$matches` | array | Values to substitute |

**Returns:** String with all `$matches[n]` placeholders replaced.

**Example:**

```php
$query = 'post_type=page&pagename=$matches[1]&page=$matches[2]';
$captures = array( 'about-us', '2' );
$result = WP_MatchesMapRegex::apply( $query, $captures );
// Result: 'post_type=page&pagename=about-us&page=2'
```

---

### callback()

Internal callback for `preg_replace_callback()`.

```php
public function callback( array $matches ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$matches` | array | Regex matches from `preg_replace_callback()` |

**Returns:** URL-encoded replacement value, or empty string if index not found.

**Note:** Values are automatically `urlencode()`d for URL safety.

---

### _map() <small>(private)</small>

Performs the actual regex replacement.

```php
private function _map(): string
```

**Returns:** Subject string with all placeholders replaced.

---

## Pattern Matching

The class matches `$matches[n]` where `n` is a positive integer (1-9 followed by any digits):

```
(\$matches\[[1-9]+[0-9]*\])
```

- `$matches[1]` ✓
- `$matches[12]` ✓
- `$matches[0]` ✗ (zero not allowed)
- `$matches[]` ✗ (index required)

---

## Usage in WordPress

Used by the rewrite system when translating pretty permalinks to query strings:

```php
// Internal WordPress usage in class-wp-rewrite.php
$query = WP_MatchesMapRegex::apply( $query, $matches );
```

---

## Security Note

This class was introduced to eliminate `eval()` calls in the rewrite system. Prior to WordPress 2.9.0, placeholder substitution used `preg_replace()` with the `e` modifier, which is both deprecated and a security risk.
