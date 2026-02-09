# WordPress Internationalization (i18n) Standards

All user-facing strings must be translatable. This enables WordPress to support any language.

## Core Principles

1. **Wrap all user-facing strings** in translation functions
2. **Use text domains** to identify your plugin/theme
3. **Provide context** when string meaning is ambiguous
4. **Support pluralization** for quantity-dependent strings
5. **Never concatenate** translated strings

---

## Translation Functions

### Basic Translation

```php
// ✅ __() - Returns translated string
$message = __( 'Hello, World!', 'my-plugin' );

// ✅ _e() - Echoes translated string
_e( 'Hello, World!', 'my-plugin' );

// Text domain must match plugin/theme slug
// Defined in plugin header or theme style.css
```

### Escaped Translation

```php
// ✅ esc_html__() - Returns escaped translated string
$title = esc_html__( 'Page Title', 'my-plugin' );

// ✅ esc_html_e() - Echoes escaped translated string
esc_html_e( 'Welcome!', 'my-plugin' );

// ✅ esc_attr__() - For attribute values
echo '<input placeholder="' . esc_attr__( 'Enter name', 'my-plugin' ) . '">';

// ✅ esc_attr_e() - Echo attribute value
?>
<input placeholder="<?php esc_attr_e( 'Search...', 'my-plugin' ); ?>">
```

### Translation with Context

```php
// ✅ _x() - Add context for translators
$post = _x( 'Post', 'noun - a blog post', 'my-plugin' );
$post = _x( 'Post', 'verb - to publish', 'my-plugin' );

// ✅ _ex() - Echo with context
_ex( 'Read', 'past tense', 'my-plugin' );  // "I have read this"
_ex( 'Read', 'imperative', 'my-plugin' );  // "Read this book"

// ✅ esc_html_x() / esc_attr_x() - Escaped with context
echo esc_html_x( 'Order', 'sorting order', 'my-plugin' );
echo esc_html_x( 'Order', 'purchase order', 'my-plugin' );
```

### Pluralization

```php
// ✅ _n() - Singular/plural forms
$message = sprintf(
	_n(
		'%d item',      // Singular
		'%d items',     // Plural
		$count,         // Number to determine form
		'my-plugin'     // Text domain
	),
	$count              // Value for placeholder
);

// ✅ _nx() - Plural with context
$message = sprintf(
	_nx(
		'%d result',
		'%d results',
		$count,
		'search results',  // Context
		'my-plugin'
	),
	$count
);
```

### Translation with Placeholders

```php
// ✅ printf() with translated format string
printf(
	/* translators: %s: User name */
	esc_html__( 'Hello, %s!', 'my-plugin' ),
	esc_html( $user_name )
);

// ✅ sprintf() for variable assignment
$message = sprintf(
	/* translators: %s: Post title */
	__( 'You are editing "%s"', 'my-plugin' ),
	$post_title
);

// ✅ Multiple placeholders - use numbered
printf(
	/* translators: 1: User name, 2: Date */
	esc_html__( 'Last edited by %1$s on %2$s', 'my-plugin' ),
	esc_html( $user_name ),
	esc_html( $date )
);
```

---

## Translator Comments

### When to Add Comments

```php
// ✅ Always explain placeholders
/* translators: %s: Plugin name */
printf( __( 'Thank you for using %s!', 'my-plugin' ), $plugin_name );

// ✅ Explain ambiguous strings
/* translators: Navigation label for moving to next item */
__( 'Next', 'my-plugin' );

// ✅ Explain HTML in strings
/* translators: %s: Link to documentation. The <a> tag should not be translated. */
printf(
	__( 'See the <a href="%s">documentation</a> for help.', 'my-plugin' ),
	esc_url( $docs_url )
);

// ✅ Character limits
/* translators: Maximum 20 characters */
__( 'Submit', 'my-plugin' );
```

### Comment Format

```php
// ✅ Must be on the line immediately before the function
/* translators: %s: User name */
printf( __( 'Hello, %s', 'my-plugin' ), $name );

// ❌ Won't be extracted - comment too far
/* translators: %s: User name */

printf( __( 'Hello, %s', 'my-plugin' ), $name );

// ❌ Wrong format
// translators: %s: User name   <- Must use /* */
printf( __( 'Hello, %s', 'my-plugin' ), $name );
```

---

## Text Domain

### Plugin Text Domain

```php
<?php
/**
 * Plugin Name: My Plugin
 * Text Domain: my-plugin
 * Domain Path: /languages
 */

// Load translations
function my_plugin_load_textdomain() {
	load_plugin_textdomain(
		'my-plugin',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}
add_action( 'plugins_loaded', 'my_plugin_load_textdomain' );
```

### Theme Text Domain

```css
/*
Theme Name: My Theme
Text Domain: my-theme
*/
```

```php
// In functions.php
function my_theme_setup() {
	load_theme_textdomain( 'my-theme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_theme_setup' );
```

### Text Domain Rules

```php
// ✅ Text domain must be a string literal
__( 'Hello', 'my-plugin' );

// ❌ Never use variables for text domain
$domain = 'my-plugin';
__( 'Hello', $domain );  // Won't be extracted!

// ❌ Never use constants
define( 'MY_TEXTDOMAIN', 'my-plugin' );
__( 'Hello', MY_TEXTDOMAIN );  // Won't be extracted!
```

---

## Common Patterns

### Dates and Times

```php
// ✅ Use WordPress date formatting
$date = date_i18n(
	get_option( 'date_format' ),
	strtotime( $post->post_date )
);

// ✅ Relative time
$time_diff = human_time_diff( strtotime( $post->post_date ), current_time( 'timestamp' ) );
printf(
	/* translators: %s: Human-readable time difference */
	esc_html__( '%s ago', 'my-plugin' ),
	$time_diff
);
```

### Numbers

```php
// ✅ Format numbers for locale
$formatted = number_format_i18n( $number );
$formatted = number_format_i18n( $price, 2 );  // With decimals
```

### Lists

```php
// ✅ Join items with localized separator
$items = array( 'Red', 'Green', 'Blue' );
$list = wp_sprintf_l( '%l', $items );  // "Red, Green, and Blue"
```

---

## Anti-Patterns

### Don't Concatenate Strings

```php
// ❌ Word order varies by language
echo __( 'Written by', 'my-plugin' ) . ' ' . $author;

// ✅ Use placeholder
printf(
	/* translators: %s: Author name */
	esc_html__( 'Written by %s', 'my-plugin' ),
	esc_html( $author )
);
```

### Don't Split Sentences

```php
// ❌ Impossible to translate properly
echo __( 'Click', 'my-plugin' );
echo ' <a href="#">' . __( 'here', 'my-plugin' ) . '</a> ';
echo __( 'for more info.', 'my-plugin' );

// ✅ Keep sentence together
printf(
	/* translators: %s: Link URL */
	wp_kses(
		__( 'Click <a href="%s">here</a> for more info.', 'my-plugin' ),
		array( 'a' => array( 'href' => array() ) )
	),
	esc_url( $url )
);
```

### Don't Assume Word Order

```php
// ❌ English word order
/* translators: 1: count, 2: type */
printf( __( '%1$d %2$s found', 'my-plugin' ), $count, $type );
// Works: "5 posts found"
// Breaks in languages where adjective follows noun

// ✅ Use descriptive placeholders
/* translators: 1: Number of items, 2: Item type */
printf( __( 'Found %1$d %2$s', 'my-plugin' ), $count, $type );
// Or provide context with _x()
```

### Don't Use Variables in Strings

```php
// ❌ Variable in translated string
$action = 'save';
__( "Click to $action", 'my-plugin' );  // Won't extract!

// ✅ Use placeholders
printf(
	/* translators: %s: Action name */
	__( 'Click to %s', 'my-plugin' ),
	$action
);
```

### Don't Translate HTML

```php
// ❌ HTML shouldn't be translated
__( '<strong>Important:</strong> Read this.', 'my-plugin' );

// ✅ Keep HTML outside or document it
/* translators: Important notice text, wrapped in <strong> tags */
'<strong>' . esc_html__( 'Important:', 'my-plugin' ) . '</strong> ' . 
esc_html__( 'Read this.', 'my-plugin' );
```

---

## JavaScript i18n

### Using @wordpress/i18n

```javascript
import { __, _x, _n, sprintf } from '@wordpress/i18n';

// Basic translation
const message = __( 'Hello, World!', 'my-plugin' );

// With context
const noun = _x( 'Post', 'noun', 'my-plugin' );

// Pluralization
const items = _n( '%d item', '%d items', count, 'my-plugin' );

// With placeholders
const greeting = sprintf(
	/* translators: %s: User name */
	__( 'Hello, %s!', 'my-plugin' ),
	userName
);
```

### Setting Up JS Translations

```php
// In PHP, register and enqueue with translations
function my_plugin_enqueue_scripts() {
	wp_enqueue_script(
		'my-plugin-script',
		plugin_dir_url( __FILE__ ) . 'js/script.js',
		array( 'wp-i18n' ),  // Depend on wp-i18n
		'1.0.0',
		true
	);
	
	// Set the script translations
	wp_set_script_translations(
		'my-plugin-script',
		'my-plugin',
		plugin_dir_path( __FILE__ ) . 'languages'
	);
}
add_action( 'admin_enqueue_scripts', 'my_plugin_enqueue_scripts' );
```

### Block Editor

```javascript
// In block registration
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

registerBlockType( 'my-plugin/my-block', {
	title: __( 'My Block', 'my-plugin' ),
	description: __( 'A custom block.', 'my-plugin' ),
	// ...
} );
```

---

## Generating Translation Files

### Using WP-CLI

```bash
# Generate POT file
wp i18n make-pot . languages/my-plugin.pot --domain=my-plugin

# Create PO file for specific locale
# (Translators edit this file)
cp languages/my-plugin.pot languages/my-plugin-de_DE.po

# Compile PO to MO (binary format)
wp i18n make-mo languages/

# Generate JSON for JavaScript
wp i18n make-json languages/ --no-purge
```

### POT File Structure

```pot
# Copyright (C) 2024 Author Name
# This file is distributed under the GPL v2.
msgid ""
msgstr ""
"Project-Id-Version: My Plugin 1.0.0\n"
"Report-Msgid-Bugs-To: https://example.com/support\n"
"POT-Creation-Date: 2024-01-15T12:00:00+00:00\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=UTF-8\n"
"Content-Transfer-Encoding: 8bit\n"
"PO-Revision-Date: YEAR-MO-DA HO:MI+ZONE\n"
"Last-Translator: FULL NAME <EMAIL@ADDRESS>\n"
"Language-Team: LANGUAGE <LL@li.org>\n"

#: includes/class-main.php:42
msgid "Hello, World!"
msgstr ""

#. translators: %s: User name
#: includes/class-main.php:56
msgid "Hello, %s!"
msgstr ""

#: includes/class-main.php:70
msgctxt "noun - a blog post"
msgid "Post"
msgstr ""

#: includes/class-main.php:85
msgid "%d item"
msgid_plural "%d items"
msgstr[0] ""
msgstr[1] ""
```

---

## File Organization

```
my-plugin/
├── languages/
│   ├── my-plugin.pot              # Template (source strings)
│   ├── my-plugin-de_DE.po         # German translations (human-readable)
│   ├── my-plugin-de_DE.mo         # German translations (compiled)
│   ├── my-plugin-fr_FR.po         # French translations
│   ├── my-plugin-fr_FR.mo
│   ├── my-plugin-de_DE-script.json # German JS translations
│   └── my-plugin-fr_FR-script.json
├── my-plugin.php
└── ...
```

---

## Testing Translations

### Using Debug Translations

```php
// In wp-config.php, set a test locale
define( 'WPLANG', 'de_DE' );

// Or use a translation testing plugin that wraps strings
// to identify untranslated content
```

### Checklist

- [ ] All user-facing strings wrapped in translation functions
- [ ] Text domain matches plugin/theme slug
- [ ] No variables or constants used for text domain
- [ ] Translator comments for all placeholders
- [ ] No string concatenation across translations
- [ ] Pluralization used where appropriate
- [ ] Context provided for ambiguous strings
- [ ] POT file generated and up to date
- [ ] JavaScript strings properly translated
