# WordPress Localization Hooks Reference

> Filters and actions for customizing translation behavior.

## Translation Filters

### `gettext`

Filters translated text after translation lookup.

```php
apply_filters( 'gettext', string $translation, string $text, string $domain )
```

**Parameters:**
- `$translation` - Translated text
- `$text` - Original text
- `$domain` - Text domain

**Example - Replace specific translations:**
```php
add_filter( 'gettext', function( $translation, $text, $domain ) {
    if ( 'my-plugin' === $domain && 'Submit' === $text ) {
        return 'Send Message';
    }
    return $translation;
}, 10, 3 );
```

---

### `gettext_{$domain}`

Domain-specific translation filter. More efficient than checking domain in `gettext`.

```php
apply_filters( "gettext_{$domain}", string $translation, string $text, string $domain )
```

**Since:** WordPress 5.5.0

**Example:**
```php
add_filter( 'gettext_my-plugin', function( $translation, $text, $domain ) {
    if ( 'Hello' === $text ) {
        return 'Hi there';
    }
    return $translation;
}, 10, 3 );
```

---

### `gettext_with_context`

Filters translations that have gettext context.

```php
apply_filters( 'gettext_with_context', string $translation, string $text, string $context, string $domain )
```

**Example:**
```php
add_filter( 'gettext_with_context', function( $translation, $text, $context, $domain ) {
    if ( 'verb' === $context && 'Post' === $text ) {
        return 'Publish Now';
    }
    return $translation;
}, 10, 4 );
```

---

### `gettext_with_context_{$domain}`

Domain-specific contextual translation filter.

```php
apply_filters( "gettext_with_context_{$domain}", string $translation, string $text, string $context, string $domain )
```

**Since:** WordPress 5.5.0

---

### `ngettext`

Filters plural form translations.

```php
apply_filters( 'ngettext', string $translation, string $single, string $plural, int $number, string $domain )
```

**Example:**
```php
add_filter( 'ngettext', function( $translation, $single, $plural, $number, $domain ) {
    if ( 'my-plugin' === $domain && '%d item' === $single ) {
        return 1 === $number ? '%d product' : '%d products';
    }
    return $translation;
}, 10, 5 );
```

---

### `ngettext_{$domain}`

Domain-specific plural translation filter.

```php
apply_filters( "ngettext_{$domain}", string $translation, string $single, string $plural, int $number, string $domain )
```

**Since:** WordPress 5.5.0

---

### `ngettext_with_context`

Filters plural translations with gettext context.

```php
apply_filters( 'ngettext_with_context', string $translation, string $single, string $plural, int $number, string $context, string $domain )
```

---

### `ngettext_with_context_{$domain}`

Domain-specific contextual plural filter.

```php
apply_filters( "ngettext_with_context_{$domain}", string $translation, string $single, string $plural, int $number, string $context, string $domain )
```

**Since:** WordPress 5.5.0

---

## Locale Filters

### `locale`

Filters the locale of the WordPress installation.

```php
apply_filters( 'locale', string $locale )
```

**Example - Force locale based on URL:**
```php
add_filter( 'locale', function( $locale ) {
    if ( isset( $_GET['lang'] ) && 'de' === $_GET['lang'] ) {
        return 'de_DE';
    }
    return $locale;
} );
```

---

### `pre_determine_locale`

Short-circuits locale determination before default logic.

```php
apply_filters( 'pre_determine_locale', string|null $locale )
```

**Since:** WordPress 5.0.0

**Example:**
```php
add_filter( 'pre_determine_locale', function( $locale ) {
    // Use session-based locale
    if ( isset( $_SESSION['user_locale'] ) ) {
        return $_SESSION['user_locale'];
    }
    return $locale; // null continues normal determination
} );
```

---

### `determine_locale`

Filters the determined locale for the current request.

```php
apply_filters( 'determine_locale', string $locale )
```

**Since:** WordPress 5.0.0

---

## Text Domain Loading Filters

### `pre_load_textdomain`

Short-circuits translation file loading.

```php
apply_filters( 'pre_load_textdomain', bool|null $loaded, string $domain, string $mofile, string|null $locale )
```

**Since:** WordPress 6.3.0

**Example - Use custom translation source:**
```php
add_filter( 'pre_load_textdomain', function( $loaded, $domain, $mofile, $locale ) {
    if ( 'my-plugin' === $domain ) {
        // Load from API, cache, etc.
        load_custom_translations( $domain, $locale );
        return true; // Skip normal loading
    }
    return $loaded;
}, 10, 4 );
```

---

### `override_load_textdomain`

Allows overriding the default MO file loading.

```php
apply_filters( 'override_load_textdomain', bool $override, string $domain, string $mofile, string|null $locale )
```

**Example:**
```php
add_filter( 'override_load_textdomain', function( $override, $domain, $mofile, $locale ) {
    if ( 'my-plugin' === $domain ) {
        // Handle loading yourself
        return true;
    }
    return $override;
}, 10, 4 );
```

---

### `load_textdomain_mofile`

Filters the MO file path before loading.

```php
apply_filters( 'load_textdomain_mofile', string $mofile, string $domain )
```

**Example - Use custom translation directory:**
```php
add_filter( 'load_textdomain_mofile', function( $mofile, $domain ) {
    if ( 'my-plugin' === $domain ) {
        return '/custom/path/my-plugin-' . get_locale() . '.mo';
    }
    return $mofile;
}, 10, 2 );
```

---

### `load_translation_file`

Filters the translation file path (MO or PHP).

```php
apply_filters( 'load_translation_file', string $file, string $domain, string $locale )
```

**Since:** WordPress 6.5.0

---

### `translation_file_format`

Filters preferred translation file format.

```php
apply_filters( 'translation_file_format', string $format, string $domain )
```

**Since:** WordPress 6.5.0

**Parameters:**
- `$format` - 'php' or 'mo' (default: 'php')
- `$domain` - Text domain

**Example - Force MO files:**
```php
add_filter( 'translation_file_format', function( $format, $domain ) {
    return 'mo'; // Always use MO files instead of PHP
}, 10, 2 );
```

---

### `override_unload_textdomain`

Allows overriding text domain unloading.

```php
apply_filters( 'override_unload_textdomain', bool $override, string $domain, bool $reloadable )
```

---

## Script Translation Filters

### `pre_load_script_translations`

Short-circuits script translation loading.

```php
apply_filters( 'pre_load_script_translations', string|false|null $translations, string|false $file, string $handle, string $domain )
```

**Since:** WordPress 5.0.2

---

### `load_script_translation_file`

Filters the script translation file path.

```php
apply_filters( 'load_script_translation_file', string|false $file, string $handle, string $domain )
```

---

### `load_script_translations`

Filters loaded script translations (JSON).

```php
apply_filters( 'load_script_translations', string $translations, string $file, string $handle, string $domain )
```

---

### `load_script_textdomain_relative_path`

Filters the relative path used for finding script translations.

```php
apply_filters( 'load_script_textdomain_relative_path', string|false $relative, string $src )
```

---

## Locale Switching Actions

### `switch_locale`

Fires when the locale is switched.

```php
do_action( 'switch_locale', string $locale, int|false $user_id )
```

**Since:** WordPress 4.7.0

**Example:**
```php
add_action( 'switch_locale', function( $locale, $user_id ) {
    // Clear locale-specific caches
    wp_cache_delete( 'my_locale_cache' );
}, 10, 2 );
```

---

### `restore_previous_locale`

Fires when the locale is restored.

```php
do_action( 'restore_previous_locale', string $locale, string $previous_locale )
```

**Since:** WordPress 4.7.0

---

### `change_locale`

Fires when the locale is changed (switch or restore).

```php
do_action( 'change_locale', string $locale )
```

**Since:** WordPress 4.7.0

**Example:**
```php
add_action( 'change_locale', function( $locale ) {
    // Re-initialize locale-dependent features
    global $wp_locale;
    $wp_locale = new WP_Locale();
} );
```

---

## Text Domain Loading Actions

### `load_textdomain`

Fires before a MO file is loaded.

```php
do_action( 'load_textdomain', string $domain, string $mofile )
```

**Example:**
```php
add_action( 'load_textdomain', function( $domain, $mofile ) {
    error_log( "Loading translations for {$domain} from {$mofile}" );
}, 10, 2 );
```

---

### `unload_textdomain`

Fires before a text domain is unloaded.

```php
do_action( 'unload_textdomain', string $domain, bool $reloadable )
```

**Since:** WordPress 3.0.0 (reloadable param added 6.1.0)

---

## Language List Filters

### `get_available_languages`

Filters the list of available language codes.

```php
apply_filters( 'get_available_languages', string[] $languages, string $dir )
```

**Example:**
```php
add_filter( 'get_available_languages', function( $languages, $dir ) {
    // Add a custom language
    $languages[] = 'custom_LANG';
    return $languages;
}, 10, 2 );
```

---

## Practical Examples

### Override All Translations for a Domain

```php
add_filter( 'gettext_my-plugin', function( $translation, $text, $domain ) {
    $overrides = [
        'Submit'  => 'Send',
        'Cancel'  => 'Never mind',
        'Save'    => 'Keep it',
    ];
    
    return $overrides[ $text ] ?? $translation;
}, 10, 3 );
```

### Log Untranslated Strings (Development)

```php
add_filter( 'gettext', function( $translation, $text, $domain ) {
    if ( $translation === $text && 'default' !== $domain ) {
        error_log( "Untranslated [{$domain}]: {$text}" );
    }
    return $translation;
}, 10, 3 );
```

### Dynamic Locale Based on User Meta

```php
add_filter( 'locale', function( $locale ) {
    if ( is_user_logged_in() ) {
        $user_locale = get_user_meta( get_current_user_id(), 'preferred_locale', true );
        if ( $user_locale ) {
            return $user_locale;
        }
    }
    return $locale;
} );
```

### Preload Translations from Cache

```php
add_filter( 'pre_load_textdomain', function( $loaded, $domain, $mofile, $locale ) {
    $cache_key = "translations_{$domain}_{$locale}";
    $cached = wp_cache_get( $cache_key, 'l10n' );
    
    if ( $cached ) {
        // Inject cached translations
        return true;
    }
    
    return $loaded; // Continue normal loading
}, 10, 4 );
```

### Force RTL for Testing

```php
add_filter( 'locale', function( $locale ) {
    if ( isset( $_GET['test_rtl'] ) ) {
        return 'he_IL'; // Hebrew (RTL language)
    }
    return $locale;
} );
```
