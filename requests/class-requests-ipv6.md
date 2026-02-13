# WpOrg\Requests\Ipv6

IPv6 address validation and manipulation utilities.

**Source:** `wp-includes/Requests/src/Ipv6.php`  
**Namespace:** `WpOrg\Requests`  
**Package:** `Requests\Utilities`  
**Modifier:** `final`

---

## Overview

Provides methods to compress, uncompress, and validate IPv6 addresses. Handles the `::` shorthand notation per RFC 4291 and supports IPv4-mapped IPv6 addresses (e.g., `::FFFF:129.144.52.38`).

---

## Public Methods

### uncompress()

Expand an IPv6 address by replacing `::` with the appropriate number of zero groups.

```php
public static function uncompress( string|Stringable $ip ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ip` | `string\|Stringable` | Compressed IPv6 address |

**Returns:** `string` — Uncompressed IPv6 address.

**Throws:** `InvalidArgument` when the argument is not a string or stringable.

If the address does not contain exactly one `::`, returns it unchanged. Accounts for IPv4-mapped addresses (presence of `.` in the second half).

**Examples:**
- `FF01::101` → `FF01:0:0:0:0:0:0:101`
- `::1` → `0:0:0:0:0:0:0:1`
- `::` → `0:0:0:0:0:0:0:0`

---

### compress()

Compress an IPv6 address by replacing the longest run of consecutive zero groups with `::`.

```php
public static function compress( string $ip ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ip` | `string` | IPv6 address (compressed or uncompressed) |

**Returns:** `string` — Compressed IPv6 address.

Internally calls `uncompress()` first, then `split_v6_v4()`. Strips leading zeros from each group, finds the longest sequence of zero groups, and replaces it with `::`.

**Examples:**
- `FF01:0:0:0:0:0:0:101` → `FF01::101`
- `0:0:0:0:0:0:0:1` → `::1`

---

### check_ipv6()

Validate an IPv6 address.

```php
public static function check_ipv6( string $ip ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ip` | `string` | IPv6 address to validate |

**Returns:** `bool` — `true` if the address is valid.

Validates that:
- Pure IPv6: exactly 8 groups of 1–4 hex digits, each 0x0000–0xFFFF.
- IPv4-mapped: 6 IPv6 groups + 4 IPv4 octets (0–255, no leading zeros).
- No empty groups after uncompression.

---

## Private Methods

### split_v6_v4()

Split an IPv6 address into its IPv6 and IPv4 parts.

```php
private static function split_v6_v4( string $ip ): string[]
```

**Returns:** Array where `[0]` is the IPv6 portion and `[1]` is the IPv4 portion (empty string if no IPv4 part).

Used by `compress()` and `check_ipv6()` to handle IPv4-mapped addresses like `0:0:0:0:0:FFFF:129.144.52.38`.
