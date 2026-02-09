# WordPress Localization (i18n/l10n) API Overview

> WordPress internationalization (i18n) and localization (l10n) system for translating text strings.

## Core Concepts

### Internationalization (i18n)
The process of developing software so it can be localized. In WordPress, this means wrapping all user-facing strings in translation functions.

### Localization (l10n)
The process of translating internationalized software for a specific locale. WordPress uses gettext-style `.mo` and `.l10n.php` files for translations.

### Text Domains
A unique identifier that ties translated strings to a specific plugin, theme, or WordPress core. Each component should use its own text domain to avoid conflicts.

```php
// Core WordPress uses 'default' domain
__( 'Hello', 'default' );

// Plugins/themes use their own domain
__( 'Hello', 'my-plugin' );
```

## Translation File Formats

### MO Files (Machine Object)
Binary compiled translation files. The traditional format used by WordPress.

- **Location**: `wp-content/languages/`
- **Naming**: `{locale}.mo` for core, `{domain}-{locale}.mo` for plugins/themes
- **Example**: `fr_FR.mo`, `my-plugin-de_DE.mo`

### PHP Translation Files (since WP 6.5)
New format that's faster to load than MO files. Preferred format since WP 6.5.

- **Extension**: `.l10n.php`
- **Location**: Same as MO files
- **Format**: PHP array with translations and metadata

```php
// Example .l10n.php structure
return [
    'project-id-version' => 'My Plugin 1.0.0',
    'po-revision-date' => '2024-01-15 10:00:00+0000',
    'messages' => [
        'Hello' => 'Bonjour',
        'Goodbye' => 'Au revoir',
    ],
];
```

### PO Files (Portable Object)
Human-readable translation files used by translators. Not loaded at runtime.

```
msgid "Hello"
msgstr "Bonjour"

msgctxt "greeting"
msgid "Hi"
msgstr "Salut"
```

## Translation Flow

### 1. String Extraction
Developers wrap translatable strings in gettext functions. Tools like WP-CLI or POEdit extract these to `.pot` files.

### 2. Translation
Translators create `.po` files from `.pot` templates, providing translations for each string.

### 3. Compilation
PO files are compiled to binary `.mo` files (or converted to `.l10n.php` files).

### 4. Loading
WordPress loads translations via:
- **Automatic just-in-time loading** (since WP 4.6)
- **Explicit loading** via `load_textdomain()`, `load_plugin_textdomain()`, etc.

### 5. Translation Lookup
When a translation function is called:
1. `WP_Translation_Controller` checks loaded translations
2. Returns translated string or falls back to original

## Directory Structure

```
wp-content/
└── languages/
    ├── de_DE.mo              # Core German translation
    ├── de_DE.l10n.php        # Core German (PHP format)
    ├── admin-de_DE.mo        # Admin German translation
    ├── plugins/
    │   └── my-plugin-de_DE.mo
    └── themes/
        └── my-theme-de_DE.mo
```

## Locale Determination

WordPress determines the current locale through several methods:

1. **WPLANG constant** in `wp-config.php`
2. **Database option** `WPLANG`
3. **User preference** (admin area)
4. **URL parameter** `wp_lang` (login page)
5. **Cookie** `wp_lang`

```php
// Get current locale
$locale = get_locale();        // Site locale
$locale = get_user_locale();   // Current user's locale
$locale = determine_locale();  // Best locale for request
```

## Architecture Components

### WP_Translation_Controller
Singleton that manages all translation file loading and lookups. Introduced in WP 6.5.

```php
$controller = WP_Translation_Controller::get_instance();
$controller->load_file( '/path/to/translation.mo', 'my-plugin', 'de_DE' );
$translation = $controller->translate( 'Hello', '', 'my-plugin' );
```

### WP_Translations
Wrapper class providing backward compatibility with the old `$l10n` global. Acts as bridge to `WP_Translation_Controller`.

### WP_Locale
Stores locale-specific data: weekday/month names, date formats, text direction, number formats.

### WP_Locale_Switcher
Manages temporary locale switching, maintaining a stack of locales.

### POMO Classes
Legacy classes for reading MO/PO files:
- `MO` - Reads binary MO files
- `Translations` - Base translation container
- `NOOP_Translations` - No-op fallback
- `Translation_Entry` - Single translation entry

## Plural Forms

Languages have different plural rules. WordPress handles this via the `Plural-Forms` header:

```
Plural-Forms: nplurals=2; plural=(n != 1);  # English
Plural-Forms: nplurals=3; plural=(n==1 ? 0 : n>=2 && n<=4 ? 1 : 2);  # Czech
```

```php
// Translate with correct plural form
printf(
    _n( '%d comment', '%d comments', $count, 'my-plugin' ),
    $count
);
```

## Just-in-Time Loading (since WP 4.6)

WordPress automatically loads translations when first needed:

1. A translation function is called with a text domain
2. `get_translations_for_domain()` checks if domain is loaded
3. If not, `_load_textdomain_just_in_time()` attempts to find and load the translation file
4. `WP_Textdomain_Registry` tracks custom paths for each domain

This means `load_plugin_textdomain()` only needs to specify the path, not load immediately.

## RTL Support

WordPress automatically handles right-to-left languages:

```php
// Check if current locale is RTL
if ( is_rtl() ) {
    // Load RTL stylesheets
}

// WP_Locale stores text direction
$wp_locale->text_direction; // 'ltr' or 'rtl'
```

## Best Practices

1. **Always use text domains** - Never call `__()` without a domain (except core)
2. **Use context for ambiguous strings** - `_x( 'Post', 'verb', 'domain' )` vs `_x( 'Post', 'noun', 'domain' )`
3. **Keep strings complete** - Don't concatenate translated strings
4. **Use placeholders** - `sprintf( __( 'Hello %s', 'domain' ), $name )`
5. **Escape output** - Use `esc_html__()`, `esc_attr__()` for safe output
6. **Load translations at the right time** - Hook to `init` or later, not before

## Related Files

- `wp-includes/l10n.php` - Core translation functions
- `wp-includes/l10n/class-wp-translation-controller.php` - Translation management
- `wp-includes/l10n/class-wp-translations.php` - Compatibility wrapper
- `wp-includes/class-wp-locale.php` - Locale data
- `wp-includes/class-wp-locale-switcher.php` - Locale switching
- `wp-includes/pomo/` - MO/PO file handling
