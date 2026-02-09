# WP_Token_Map

High-performance data structure for string key-to-value lookups with optimized memory layout.

**Source:** `wp-includes/class-wp-token-map.php`  
**Since:** 6.6.0

## Overview

`WP_Token_Map` provides efficient string token lookup and transformation. It's optimized for static datasets like HTML named character references, smilies, or other fixed mappings.

The class uses a packed binary format internally to maximize cache locality and minimize memory access during lookups. It supports precomputation for zero-cost initialization in production.

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `STORAGE_VERSION` | `'6.6.0-trunk'` | Format version for precomputed tables |
| `MAX_LENGTH` | `256` | Maximum bytes for keys and values |

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$key_length` | int | private | Prefix length for grouping (default 2) |
| `$large_words` | array | private | Packed strings for tokens longer than key_length |
| `$groups` | string | private | Null-delimited group prefixes |
| `$small_words` | string | private | Packed short tokens |
| `$small_mappings` | string[] | private | Replacements for short tokens |

---

## Methods

### from_array()

Creates a token map from an associative array.

```php
public static function from_array( array $mappings, int $key_length = 2 ): ?WP_Token_Map
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$mappings` | array | Key-value pairs (token → replacement) |
| `$key_length` | int | Group prefix length (default 2) |

**Returns:** `WP_Token_Map` on success, `null` if any token exceeds `MAX_LENGTH`.

**Example:**

```php
$smilies = WP_Token_Map::from_array( array(
    '8O' => '😯',
    ':(' => '🙁',
    ':)' => '🙂',
    ':?' => '😕',
) );
```

---

### from_precomputed_table()

Creates a token map from precomputed data.

```php
public static function from_precomputed_table( array $state ): ?WP_Token_Map
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$state` | array | Precomputed state array |

**State Array Keys:**
- `storage_version` — Must match `STORAGE_VERSION`
- `key_length` — Group prefix length
- `groups` — Null-delimited group prefixes
- `large_words` — Packed token strings
- `small_words` — Packed short tokens
- `small_mappings` — Short token replacements

**Returns:** `WP_Token_Map` or `null` on version mismatch/missing data.

---

### contains()

Checks if a word exists as a lookup key.

```php
public function contains( string $word, string $case_sensitivity = 'case-sensitive' ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$word` | string | Token to check |
| `$case_sensitivity` | string | `'case-sensitive'` or `'ascii-case-insensitive'` |

**Returns:** `true` if token exists in map.

**Example:**

```php
$smilies->contains( ':)' );  // true
$smilies->contains( 'nope' ); // false
```

---

### read_token()

Reads a token starting at the given offset and returns its mapping.

```php
public function read_token(
    string $text,
    int $offset = 0,
    ?int &$matched_token_byte_length = null,
    string $case_sensitivity = 'case-sensitive'
): ?string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$text` | string | Text to search in |
| `$offset` | int | Starting byte position |
| `&$matched_token_byte_length` | int\|null | Receives matched token length |
| `$case_sensitivity` | string | `'case-sensitive'` or `'ascii-case-insensitive'` |

**Returns:** Mapped value if token found, `null` otherwise.

**Example:**

```php
$result = $smilies->read_token( 'Hello :) world', 6, $length );
// $result = '🙂'
// $length = 2
```

---

### to_array()

Exports the map back to an associative array.

```php
public function to_array(): array
```

**Returns:** Array of `token => replacement` pairs.

---

### precomputed_php_source_table()

Generates PHP source code for precomputed loading.

```php
public function precomputed_php_source_table( string $indent = "\t" ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$indent` | string | Indentation string |

**Returns:** PHP code that can be pasted into a source file.

**Example Output:**

```php
WP_Token_Map::from_precomputed_table(
    array(
        "storage_version" => "6.6.0-trunk",
        "key_length" => 2,
        "groups" => "",
        "large_words" => array(),
        "small_words" => "8O\x00:)\x00:(\x00:?\x00",
        "small_mappings" => array( "😯", "🙂", "🙁", "😕" )
    )
);
```

---

## Internal Methods

### read_small_token() <small>(private)</small>

Searches for short tokens (≤ key_length).

```php
private function read_small_token(
    string $text,
    int $offset = 0,
    ?int &$matched_token_byte_length = null,
    string $case_sensitivity = 'case-sensitive'
): ?string
```

---

### longest_first_then_alphabetical() <small>(private static)</small>

Comparison function ensuring longer matches take priority.

```php
private static function longest_first_then_alphabetical( string $a, string $b ): int
```

Sorts by length descending, then alphabetically. Prevents substring matches masking longer tokens.

---

## Architecture

### Large vs. Small Words

Tokens are classified by length relative to `key_length`:

- **Small words:** Length ≤ `key_length` — stored in packed `$small_words` string
- **Large words:** Length > `key_length` — grouped by prefix in `$large_words` array

### Packed Format

Large words use a binary packed format:

```
┌────────────────┬───────────────┬─────────────────┬────────┐
│ Length of rest │ Rest of key   │ Length of value │ Value  │
│ of key (bytes) │               │ (bytes)         │        │
├────────────────┼───────────────┼─────────────────┼────────┤
│ 0x08           │ nterDot;      │ 0x02            │ ·      │
└────────────────┴───────────────┴─────────────────┴────────┘
```

### Choosing Key Length

The `key_length` parameter affects performance:

- **Too long:** Many single-token groups, wasted overhead
- **Too short:** Large groups requiring linear search

For HTML character references (2,000+ entries), `key_length = 2` provides good distribution. For smaller sets like smilies, `key_length = 1` may be better.

---

## Performance Tips

1. **Precompute for production:** Use `precomputed_php_source_table()` to generate static code
2. **Strip common prefixes:** If all tokens share a prefix (like `&` for HTML entities), exclude it and check manually
3. **Experiment with key_length:** Test different values for your specific dataset

---

## Usage in WordPress

Primary use case is HTML named character reference decoding in the HTML API:

```php
// In wp-includes/html-api/html5-named-character-references.php
return WP_Token_Map::from_precomputed_table( array(
    // ... precomputed HTML entity mappings
) );
```
