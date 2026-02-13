# Stream Readers

Classes for reading streams of data, used by the MO file parser. Handles byte-level I/O with endian-aware integer reading and mbstring overload safety.

**Source:** `wp-includes/pomo/streams.php`

## Class Hierarchy

```
POMO_Reader
    ├── POMO_FileReader          (reads from file handle)
    └── POMO_StringReader        (reads from in-memory string)
            └── POMO_CachedFileReader    (reads file into memory, then string-based)
                    └── POMO_CachedIntFileReader  (same as parent)
```

---

## POMO_Reader

Base class providing endian-aware integer reading and mbstring-safe string operations.

### Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$endian` | string | `'little'` | Byte order: `'little'` or `'big'` |
| `$_pos` | int | `0` | Current read position |
| `$is_overloaded` | bool | — | Whether `mbstring.func_overload` is active for string functions |

### Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `__construct()` | — | Detects mbstring overloading, initializes position to 0 |
| `POMO_Reader()` | — | **Deprecated 5.4.0.** PHP4 constructor |
| `setEndian( $endian )` | void | Sets byte order (`'big'` or `'little'`) |
| `readint32()` | int\|false | Reads a 32-bit integer using current endianness. Returns `false` if fewer than 4 bytes available |
| `readint32array( $count )` | array\|false | Reads `$count` 32-bit integers. Returns `false` if not enough data |
| `substr( $input_string, $start, $length )` | string | mbstring-safe `substr` (uses `'ascii'` encoding if overloaded) |
| `strlen( $input_string )` | int | mbstring-safe `strlen` |
| `str_split( $input_string, $chunk_size )` | array | Splits string into chunks (manual implementation if `str_split()` unavailable) |
| `pos()` | int | Returns current position |
| `is_resource()` | true | Always returns `true` |
| `close()` | true | Always returns `true` |

---

## POMO_FileReader

**Extends:** `POMO_Reader`

Reads from an actual file via `fopen()`/`fread()`.

### Properties

| Property | Type | Description |
|----------|------|-------------|
| `$_f` | resource\|false | File pointer opened in `'rb'` mode |

### Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `__construct( $filename )` | — | Opens file in binary read mode |
| `POMO_FileReader( $filename )` | — | **Deprecated 5.4.0.** PHP4 constructor |
| `read( $bytes )` | string\|false | Reads `$bytes` bytes via `fread()` |
| `seekto( $pos )` | bool | Seeks to absolute position. Returns `false` on failure |
| `is_resource()` | bool | Returns `is_resource( $this->_f )` |
| `feof()` | bool | Returns `feof( $this->_f )` |
| `close()` | bool | Closes the file handle |
| `read_all()` | string | Returns remaining contents via `stream_get_contents()` |

---

## POMO_StringReader

**Extends:** `POMO_Reader`

Reads from an in-memory string, providing file-like seek/read operations.

### Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$_str` | string | `''` | The string data |

### Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `__construct( $str = '' )` | — | Stores the string, resets position to 0 |
| `POMO_StringReader( $str = '' )` | — | **Deprecated 5.4.0.** PHP4 constructor |
| `read( $bytes )` | string | Reads `$bytes` bytes from current position, advances position (clamped to string length) |
| `seekto( $pos )` | int | Seeks to position (clamped to string length), returns new position |
| `length()` | int | Returns total string length |
| `read_all()` | string | Returns remaining data from current position |

---

## POMO_CachedFileReader

**Extends:** `POMO_StringReader`

Reads an entire file into memory at construction time, then operates as a string reader.

### Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `__construct( $filename )` | — | Reads file via `file_get_contents()`. Sets `$_str` to `false` on failure |
| `POMO_CachedFileReader( $filename )` | — | **Deprecated 5.4.0.** PHP4 constructor |

---

## POMO_CachedIntFileReader

**Extends:** `POMO_CachedFileReader`

Identical to `POMO_CachedFileReader`. Exists as a separate class for historical/type-distinction reasons. No additional functionality.

### Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `__construct( $filename )` | — | Delegates to parent |
| `POMO_CachedIntFileReader( $filename )` | — | **Deprecated 5.4.0.** PHP4 constructor |
