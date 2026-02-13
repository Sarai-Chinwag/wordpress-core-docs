# WpOrg\Requests\Ssl

SSL certificate verification utilities for the Requests library.

**Source:** `wp-includes/Requests/src/Ssl.php`  
**Namespace:** `WpOrg\Requests`  
**Package:** `Requests\Utilities`  
**Modifier:** `final`

---

## Overview

A collection of static utilities for verifying SSL certificates against hostnames. Handles Subject Alternative Name (SAN) matching, wildcard certificate validation, and dNSName reference verification.

---

## Methods

### verify_certificate()

Verify a certificate against the hostname using common name and subject alternative names.

PHP does not natively check certificates against SANs, so this method handles that verification. It first checks `subjectAltName` extensions for DNS entries; if any DNS SANs exist, only those are checked. If no DNS SANs are found, it falls back to the certificate's Common Name (`subject.CN`).

```php
public static function verify_certificate( string|Stringable $host, array|ArrayAccess $cert ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$host` | `string\|Stringable` | Host name to verify against |
| `$cert` | `array\|ArrayAccess` | Certificate data from `openssl_x509_parse()` |

**Returns:** `bool` — `true` if the certificate matches the host.

**Throws:**
- `InvalidArgument` when `$host` is not a string or stringable.
- `InvalidArgument` when `$cert` is not an array or ArrayAccess.

---

### verify_reference_name()

Verify that a dNSName reference is valid for HTTPS usage.

Validation rules (based on Firefox's ruleset, with stricter wildcard handling):
- Wildcards can only occur in names with more than 3 components.
- Wildcards must be the **entire** first component (i.e., `*` only, not `w*` or `*w`).
- No whitespace allowed.
- No empty labels (consecutive dots).
- Wildcards are forbidden in any component other than the first.

```php
public static function verify_reference_name( string|Stringable $reference ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$reference` | `string\|Stringable` | Reference dNSName to validate |

**Returns:** `bool` — Whether the name is valid.

**Throws:** `InvalidArgument` when the argument is not a string or stringable.

---

### match_domain()

Match a hostname against a dNSName reference, supporting wildcard matching.

First validates the reference name via `verify_reference_name()`. Then checks for a direct string match. If the host is not an IP address (checked via `ip2long()`), attempts wildcard matching by replacing the first component of the host with `*`.

```php
public static function match_domain( string|Stringable $host, string|Stringable $reference ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$host` | `string\|Stringable` | Requested hostname |
| `$reference` | `string\|Stringable` | dNSName to match against |

**Returns:** `bool` — Whether the domain matches.

**Throws:** `InvalidArgument` when either argument is not a string or stringable.

---

## Certificate Verification Flow

```
verify_certificate($host, $cert)
│
├─ Check subjectAltName extensions
│  ├─ For each "DNS:" entry → match_domain($host, $altname)
│  │  └─ If any DNS SAN matched → return true
│  └─ If DNS SANs existed but none matched → return false
│
├─ No DNS SANs found → fall back to Common Name
│  └─ match_domain($host, $cert['subject']['CN'])
│
└─ No CN either → return false
```

```
match_domain($host, $reference)
│
├─ verify_reference_name($reference) fails → return false
├─ Direct string match → return true
├─ Host is IP address (ip2long) → return false
└─ Replace first component with '*', compare → return true/false
```
