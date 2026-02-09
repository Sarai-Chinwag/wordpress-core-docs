# WordPress Translation Functions Reference

> Complete reference for WordPress internationalization functions.

## Basic Translation Functions

### `__( $text, $domain = 'default' )`
Retrieves the translation of a string.

```php
$translated = __( 'Hello World', 'my-plugin' );
```

**Parameters:**
- `$text` (string) - Text to translate
- `$domain` (string) - Text domain identifier

**Returns:** string - Translated text or original if no translation

---

### `_e( $text, $domain = 'default' )`
Displays the translation of a string (echoes output).

```php
_e( 'Hello World', 'my-plugin' );
```

**Note:** Use `echo __()` if you need to capture the output.

---

### `_x( $text, $context, $domain = 'default' )`
Retrieves translation with gettext context for disambiguation.

```php
// Same English word, different meanings
$verb = _x( 'Post', 'verb', 'my-plugin' );      // "Publish"
$noun = _x( 'Post', 'noun', 'my-plugin' );      // "Article"
```

**Parameters:**
- `$text` (string) - Text to translate
- `$context` (string) - Context information for translators
- `$domain` (string) - Text domain

---

### `_ex( $text, $context, $domain = 'default' )`
Displays translated string with gettext context.

```php
_ex( 'Read', 'past participle', 'my-plugin' );
```

---

## Escaped Translation Functions

### `esc_html__( $text, $domain = 'default' )`
Retrieves translation and escapes for safe HTML output.

```php
echo '<p>' . esc_html__( 'User content here', 'my-plugin' ) . '</p>';
```

---

### `esc_html_e( $text, $domain = 'default' )`
Displays escaped translation for HTML output.

```php
<p><?php esc_html_e( 'Safe HTML output', 'my-plugin' ); ?></p>
```

---

### `esc_attr__( $text, $domain = 'default' )`
Retrieves translation escaped for use in HTML attributes.

```php
echo '<input placeholder="' . esc_attr__( 'Enter name', 'my-plugin' ) . '">';
```

---

### `esc_attr_e( $text, $domain = 'default' )`
Displays translation escaped for HTML attributes.

```php
<input title="<?php esc_attr_e( 'Tooltip text', 'my-plugin' ); ?>">
```

---

### `esc_html_x( $text, $context, $domain = 'default' )`
Retrieves contextual translation escaped for HTML.

```php
echo esc_html_x( 'Draft', 'post status', 'my-plugin' );
```

---

### `esc_attr_x( $text, $context, $domain = 'default' )`
Retrieves contextual translation escaped for attributes.

```php
echo '<option value="draft">' . esc_attr_x( 'Draft', 'post status', 'my-plugin' ) . '</option>';
```

---

## Plural Translation Functions

### `_n( $single, $plural, $number, $domain = 'default' )`
Translates singular or plural form based on count.

```php
printf(
    _n( '%s comment', '%s comments', $count, 'my-plugin' ),
    number_format_i18n( $count )
);
```

**Parameters:**
- `$single` (string) - Singular form
- `$plural` (string) - Plural form
- `$number` (int) - Number to determine which form to use
- `$domain` (string) - Text domain

**Note:** Different languages have different plural rules. Some have 3+ plural forms.

---

### `_nx( $single, $plural, $number, $context, $domain = 'default' )`
Translates plural form with gettext context.

```php
printf(
    _nx( '%s group', '%s groups', $count, 'group of people', 'my-plugin' ),
    number_format_i18n( $count )
);
```

---

### `_n_noop( $singular, $plural, $domain = null )`
Registers plural strings without translating. For delayed translation.

```php
$messages = [
    'comment' => _n_noop( '%s comment', '%s comments', 'my-plugin' ),
    'post'    => _n_noop( '%s post', '%s posts', 'my-plugin' ),
];

// Later, when count is known:
printf( translate_nooped_plural( $messages['comment'], $count, 'my-plugin' ), $count );
```

**Returns:** array with singular, plural, context, and domain keys

---

### `_nx_noop( $singular, $plural, $context, $domain = null )`
Registers contextual plural strings without translating.

```php
$labels = [
    'people'  => _nx_noop( '%s group', '%s groups', 'group of people', 'my-plugin' ),
    'animals' => _nx_noop( '%s group', '%s groups', 'group of animals', 'my-plugin' ),
];
```

---

### `translate_nooped_plural( $nooped_plural, $count, $domain = 'default' )`
Translates a nooped plural when the count is known.

```php
$message = _n_noop( '%s item', '%s items', 'my-plugin' );
$translated = translate_nooped_plural( $message, $count, 'my-plugin' );
```

---

## Text Domain Loading Functions

### `load_textdomain( $domain, $mofile, $locale = null )`
Loads a `.mo` or `.l10n.php` file into a text domain.

```php
load_textdomain( 'my-plugin', '/path/to/my-plugin-de_DE.mo' );
```

**Parameters:**
- `$domain` (string) - Text domain
- `$mofile` (string) - Path to MO file
- `$locale` (string|null) - Locale, defaults to current

**Returns:** bool - True on success

---

### `load_plugin_textdomain( $domain, $deprecated = false, $plugin_rel_path = false )`
Loads plugin translations. **Registers path for just-in-time loading (since WP 6.7).**

```php
// In plugin main file
add_action( 'init', function() {
    load_plugin_textdomain( 'my-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
});
```

**Note:** Since WP 4.6, WordPress first checks `wp-content/languages/plugins/` before the plugin's directory.

---

### `load_muplugin_textdomain( $domain, $mu_plugin_rel_path = '' )`
Loads must-use plugin translations.

```php
load_muplugin_textdomain( 'my-mu-plugin', 'my-mu-plugin/languages' );
```

---

### `load_theme_textdomain( $domain, $path = false )`
Loads theme translations.

```php
// In functions.php
add_action( 'after_setup_theme', function() {
    load_theme_textdomain( 'my-theme', get_template_directory() . '/languages' );
});
```

---

### `load_child_theme_textdomain( $domain, $path = false )`
Loads child theme translations.

```php
load_child_theme_textdomain( 'my-child-theme', get_stylesheet_directory() . '/languages' );
```

---

### `load_default_textdomain( $locale = null )`
Loads WordPress core translations.

```php
load_default_textdomain( 'fr_FR' );
```

**Note:** Called automatically by WordPress. Rarely needed manually.

---

### `unload_textdomain( $domain, $reloadable = false )`
Unloads translations for a text domain.

```php
unload_textdomain( 'my-plugin' );
```

**Parameters:**
- `$domain` (string) - Text domain to unload
- `$reloadable` (bool) - If true, allows just-in-time reloading

---

### `load_script_textdomain( $handle, $domain = 'default', $path = '' )`
Loads translations for a registered script.

```php
wp_register_script( 'my-script', plugin_url( '/js/app.js', __FILE__ ) );
wp_set_script_translations( 'my-script', 'my-plugin', plugin_dir_path( __FILE__ ) . 'languages' );
```

**Returns:** string|false - JSON-encoded translations or false

---

## Locale Functions

### `get_locale()`
Returns the current site locale.

```php
$locale = get_locale(); // e.g., 'en_US', 'de_DE', 'fr_FR'
```

---

### `get_user_locale( $user = 0 )`
Returns a user's locale preference.

```php
$locale = get_user_locale();           // Current user
$locale = get_user_locale( 42 );       // User ID 42
$locale = get_user_locale( $user );    // WP_User object
```

Falls back to `get_locale()` if user has no preference.

---

### `determine_locale()`
Determines the best locale for the current request.

```php
$locale = determine_locale();
```

Considers:
- Admin area → user locale
- Login page → `wp_lang` parameter/cookie
- Frontend → site locale
- Installing → `language` parameter

---

### `switch_to_locale( $locale )`
Temporarily switches to a different locale.

```php
switch_to_locale( 'de_DE' );
echo __( 'Hello', 'my-plugin' ); // German translation
restore_previous_locale();
```

---

### `switch_to_user_locale( $user_id )`
Switches to a specific user's locale.

```php
switch_to_user_locale( $user_id );
$message = __( 'Welcome back!', 'my-plugin' );
restore_previous_locale();
```

---

### `restore_previous_locale()`
Restores the previous locale after a switch.

```php
switch_to_locale( 'fr_FR' );
// ... French output ...
restore_previous_locale(); // Back to previous
```

**Returns:** string|false - Restored locale or false

---

### `restore_current_locale()`
Restores the original locale, clearing the switch stack.

```php
switch_to_locale( 'de_DE' );
switch_to_locale( 'fr_FR' );
restore_current_locale(); // Back to original, not de_DE
```

---

### `is_locale_switched()`
Checks if the locale has been switched.

```php
if ( is_locale_switched() ) {
    // Currently in a switched locale context
}
```

---

## Utility Functions

### `is_rtl()`
Checks if the current locale is right-to-left.

```php
if ( is_rtl() ) {
    wp_enqueue_style( 'my-rtl-styles', 'rtl.css' );
}
```

---

### `is_textdomain_loaded( $domain )`
Checks if translations are loaded for a domain.

```php
if ( ! is_textdomain_loaded( 'my-plugin' ) ) {
    load_plugin_textdomain( 'my-plugin' );
}
```

---

### `has_translation( $singular, $textdomain = 'default', $locale = null )`
Checks if a translation exists for a string. **Since WP 6.7.**

```php
if ( has_translation( 'Welcome', 'my-plugin' ) ) {
    echo __( 'Welcome', 'my-plugin' );
} else {
    echo 'Welcome'; // Fallback
}
```

---

### `get_translations_for_domain( $domain )`
Returns the Translations object for a domain.

```php
$translations = get_translations_for_domain( 'my-plugin' );
$all_entries = $translations->entries;
```

**Returns:** Translations|NOOP_Translations

---

### `get_available_languages( $dir = null )`
Gets all available languages based on translation files.

```php
$languages = get_available_languages();
// ['de_DE', 'fr_FR', 'es_ES', ...]
```

---

### `wp_get_installed_translations( $type )`
Gets installed translations for plugins, themes, or core.

```php
$translations = wp_get_installed_translations( 'plugins' );
// ['my-plugin' => ['de_DE' => [...headers...], 'fr_FR' => [...]]]
```

**Parameters:**
- `$type` (string) - 'plugins', 'themes', or 'core'

---

### `wp_dropdown_languages( $args = [] )`
Renders a language selector dropdown.

```php
wp_dropdown_languages( [
    'id'       => 'locale',
    'name'     => 'locale',
    'selected' => get_locale(),
] );
```

---

### `wp_get_list_item_separator()`
Gets the locale-aware list separator.

```php
$items = ['apples', 'oranges', 'bananas'];
echo implode( wp_get_list_item_separator(), $items );
// English: "apples, oranges, bananas"
```

---

### `translate_user_role( $name, $domain = 'default' )`
Translates a user role name.

```php
$role_name = translate_user_role( 'Administrator' );
```

---

## Number/Date Formatting

### `number_format_i18n( $number, $decimals = 0 )`
Formats a number using locale-appropriate separators.

```php
echo number_format_i18n( 1234567.89, 2 );
// English: "1,234,567.89"
// German:  "1.234.567,89"
```

---

### `date_i18n( $format, $timestamp = false, $gmt = false )`
Formats a date using locale-translated month/day names.

```php
echo date_i18n( 'F j, Y' );
// English: "January 15, 2024"
// French:  "15 janvier 2024"
```

---

## Internal Functions

### `translate( $text, $domain = 'default' )`
Core translation function. **Use `__()` instead.**

### `translate_with_gettext_context( $text, $context, $domain = 'default' )`
Core contextual translation. **Use `_x()` instead.**

### `_load_textdomain_just_in_time( $domain )`
Internal function for automatic translation loading.

### `before_last_bar( $text )`
Removes trailing context from pipe-delimited strings (legacy format).
