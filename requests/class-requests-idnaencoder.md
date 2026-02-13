# WpOrg\Requests\IdnaEncoder

IDNA (Internationalized Domain Names in Applications) encoder using Punycode.

**Source:** `wp-includes/Requests/src/IdnaEncoder.php`  
**Namespace:** `WpOrg\Requests`  
**Package:** `Requests\Utilities`

---

## Overview

Encodes internationalized domain names to their ASCII-Compatible Encoding (ACE) form using Punycode (RFC 3492). Splits hostnames by `.`, encodes each label individually, and prepends the `xn--` ACE prefix. Note: the `nameprep` step (RFC 3491) is not yet implemented — it returns the input unchanged.

---

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `ACE_PREFIX` | `'xn--'` | ACE prefix for IDNA labels |
| `MAX_LENGTH` | `64` | Maximum ASCII length for an IDNA label. @since 2.0.0 |
| `BOOTSTRAP_BASE` | `36` | Punycode base |
| `BOOTSTRAP_TMIN` | `1` | Punycode tmin |
| `BOOTSTRAP_TMAX` | `26` | Punycode tmax |
| `BOOTSTRAP_SKEW` | `38` | Punycode skew |
| `BOOTSTRAP_DAMP` | `700` | Punycode damp |
| `BOOTSTRAP_INITIAL_BIAS` | `72` | Punycode initial bias |
| `BOOTSTRAP_INITIAL_N` | `128` | Punycode initial n |

---

## Public Methods

### encode()

Encode a hostname using Punycode. Splits by `.` and encodes each label via `to_ascii()`.

```php
public static function encode( string|Stringable $hostname ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$hostname` | `string\|Stringable` | Hostname to encode |

**Returns:** `string` — Punycode-encoded hostname.

**Throws:** `InvalidArgument` when the argument is not a string or stringable.

---

### to_ascii()

Convert a single UTF-8 label to ASCII using the IDNA algorithm.

```php
public static function to_ascii( string $text ): string
```

**Steps:**
1. If already ASCII and < 64 chars, return as-is.
2. Apply `nameprep()` (currently a no-op).
3. If ASCII after nameprep and < 64 chars, return.
4. Reject if already has `xn--` prefix.
5. Punycode-encode via `punycode_encode()`.
6. Prepend `xn--`.
7. Verify length < 64.

**Throws:**
- `Exception` `idna.provided_too_long` — ASCII input ≥ 64 chars
- `Exception` `idna.prepared_too_long` — Post-nameprep ASCII ≥ 64 chars
- `Exception` `idna.provided_is_prefixed` — Input starts with `xn--`
- `Exception` `idna.encoded_too_long` — Encoded result ≥ 64 chars

---

### punycode_encode()

RFC 3492 Section 6.3 Punycode encoder.

```php
public static function punycode_encode( string $input ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$input` | `string` | UTF-8 string to encode |

**Returns:** `string` — Punycode-encoded string (without ACE prefix).

**Throws:** `Exception` `idna.character_outside_domain` — Character below initial_n but above ASCII (never occurs with Punycode).

---

## Protected Methods

| Method | Signature | Description |
|--------|-----------|-------------|
| `is_ascii()` | `(string $text): bool` | Check if string is ASCII-only (regex-based) |
| `nameprep()` | `(string $text): string` | Placeholder for RFC 3491 nameprep — returns input unchanged |
| `utf8_to_codepoints()` | `(string $input): array` | Convert UTF-8 to array of Unicode codepoints. Throws `Exception` `idna.invalidcodepoint` on invalid UTF-8. |
| `digit_to_char()` | `(int $digit): string` | Convert digit 0–35 to a-z/0-9. Throws `Exception` `idna.invalid_digit` on out of range. |
| `adapt()` | `(int $delta, int $numpoints, bool $firsttime): int\|float` | Punycode bias adaptation (RFC 3492 Section 6.1) |

---

## Encoding Flow

```
encode("münchen.de")
│
├─ Split: ["münchen", "de"]
├─ to_ascii("münchen")
│  ├─ Not ASCII → nameprep (no-op) → still not ASCII
│  ├─ No "xn--" prefix
│  ├─ punycode_encode("münchen")
│  │  ├─ utf8_to_codepoints() → [109, 252, 110, 99, 104, 101, 110]
│  │  ├─ Basic chars: "mnchen" + "-"
│  │  └─ Encode non-basic: ü (252) → delta encoding
│  ├─ Prepend "xn--" → "xn--mnchen-3ya"
│  └─ Length check < 64
├─ to_ascii("de") → "de" (already ASCII)
└─ Join: "xn--mnchen-3ya.de"
```
