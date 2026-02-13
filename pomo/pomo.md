# POMO — PO/MO Translation File Handling

WordPress gettext-based internationalization subsystem for reading, writing, and managing PO and MO translation files.

**Since:** 2.8.0
**Source:** `wp-includes/pomo/`

## Components

| Component | Description |
|-----------|-------------|
| [class-translation-entry.md](./class-translation-entry.md) | Encapsulates a single translatable string |
| [class-translations.md](./class-translations.md) | Base class: a set of translation entries with headers |
| [class-gettext-translations.md](./class-gettext-translations.md) | Gettext-aware translations with plural form parsing |
| [class-noop-translations.md](./class-noop-translations.md) | No-op implementation (passthrough, no actual translation) |
| [class-mo.md](./class-mo.md) | MO (Machine Object) binary file reader/writer |
| [class-po.md](./class-po.md) | PO (Portable Object) text file reader/writer |
| [class-plural-forms.md](./class-plural-forms.md) | Plural-Forms expression parser and evaluator |
| [streams.md](./streams.md) | Stream reader classes for binary file I/O |

## Architecture

```
Translations (2.8.0)
    ├── entries[], headers[]
    ├── translate(), translate_plural()
    └── add_entry(), merge_with()

Gettext_Translations (2.8.0) extends Translations
    ├── Plural-Forms header parsing
    ├── make_plural_form_function() → Plural_Forms
    └── make_headers() from raw translation string

MO (2.8.0) extends Gettext_Translations
    ├── import_from_file() / import_from_reader()
    ├── export() / export_to_file()
    └── Binary MO format: magic, revision, string tables

PO (2.8.0) extends Gettext_Translations
    ├── import_from_file() — line-by-line PO parser
    ├── export() / export_to_file()
    └── poify() / unpoify() — PO string escaping

NOOP_Translations (2.8.0)
    └── Same interface as Translations, all methods are no-ops

Translation_Entry (2.8.0)
    ├── singular, plural, context, translations[]
    ├── key() — generates lookup key (context\x04singular)
    └── merge_with() — merges flags, references, comments

Plural_Forms (4.9.0)
    ├── Shunting-yard parser → Reverse Polish Notation
    ├── execute() — stack-based RPN evaluator
    └── get() — cached plural form lookup

POMO_Reader → POMO_FileReader (file handle I/O)
           → POMO_StringReader (in-memory string I/O)
               → POMO_CachedFileReader (file read into memory)
                   → POMO_CachedIntFileReader
```

## Key Concepts

### Translation Lookup

Translations are keyed by a combination of context and singular string. The key format is:

- **Without context:** `singular`
- **With context:** `context\x04singular` (EOT character as separator)

Line endings are normalized to `\n` in keys.

### MO File Format

MO files are binary, containing:
1. **Magic number** (`0x950412de`) — also determines byte order
2. **Revision** — only revision 0 is supported
3. **String count** and table offsets
4. **Original strings table** — length/offset pairs
5. **Translation strings table** — length/offset pairs
6. **Hash table** (optional, skipped on read)
7. **String data** — null-terminated strings

Context is separated by `\x04`, plural forms by `\x00`.

### PO File Format

PO files are text-based with entries like:

```po
# translator comment
#. extracted comment
#: file.php:42
#, php-format
msgctxt "context"
msgid "singular"
msgid_plural "plural"
msgstr[0] "translation"
msgstr[1] "translations"
```

### Plural Forms

The `Plural-Forms` header (e.g., `nplurals=2; plural=n != 1;`) is parsed by the `Plural_Forms` class using the shunting-yard algorithm to convert the C-like expression to RPN, then evaluated with a stack-based interpreter. Results are cached per-number.

## Constants

| Constant | Value | Source |
|----------|-------|--------|
| `PO_MAX_LINE_LEN` | `79` | `po.php` |

## File Map

| File | Classes |
|------|---------|
| `entry.php` | `Translation_Entry` |
| `translations.php` | `Translations`, `Gettext_Translations`, `NOOP_Translations` |
| `mo.php` | `MO` |
| `po.php` | `PO` |
| `plural-forms.php` | `Plural_Forms` |
| `streams.php` | `POMO_Reader`, `POMO_FileReader`, `POMO_StringReader`, `POMO_CachedFileReader`, `POMO_CachedIntFileReader` |
