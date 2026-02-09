# WP_Locale Class Reference

> Stores translated locale-specific data including weekdays, months, date formats, and text direction.

**File:** `wp-includes/class-wp-locale.php`  
**Since:** WordPress 2.1.0  
**Global:** Available as `$wp_locale`

## Overview

`WP_Locale` is instantiated once per request and stored in the global `$wp_locale`. It provides locale-aware data for date formatting, number formatting, and text direction.

```php
global $wp_locale;
echo $wp_locale->get_weekday( 0 ); // "Sunday" or translated equivalent
```

## Properties

### Weekday Names

```php
/**
 * @var string[] Full weekday names, indexed 0-6 (Sunday-Saturday)
 */
public $weekday = [];

/**
 * @var string[] Single-letter weekday initials, keyed by full name
 */
public $weekday_initial = [];

/**
 * @var string[] Three-letter weekday abbreviations, keyed by full name
 */
public $weekday_abbrev = [];
```

### Month Names

```php
/**
 * @var string[] Full month names, indexed '01'-'12'
 */
public $month = [];

/**
 * @var string[] Genitive month names (for languages that need them)
 * @since 4.4.0
 */
public $month_genitive = [];

/**
 * @var string[] Three-letter month abbreviations, keyed by full name
 */
public $month_abbrev = [];
```

### Time & Text

```php
/**
 * @var string[] Meridiem strings: 'am', 'pm', 'AM', 'PM'
 */
public $meridiem = [];

/**
 * @var string Text direction: 'ltr' or 'rtl'
 */
public $text_direction = 'ltr';

/**
 * @var string List item separator (e.g., ", " in English)
 * @since 6.0.0
 */
public $list_item_separator;

/**
 * @var string Word count type: 'words', 'characters_excluding_spaces', 'characters_including_spaces'
 * @since 6.2.0
 */
public $word_count_type;
```

### Number Formatting

```php
/**
 * @var array {
 *     @type string $thousands_sep Thousands separator (e.g., "," or ".")
 *     @type string $decimal_point Decimal point (e.g., "." or ",")
 * }
 */
public $number_format = [];
```

## Methods

### Constructor

```php
public function __construct()
```

Calls `init()` to set up translated strings and `register_globals()` for backward compatibility.

---

### `init()`

Sets up all translated strings for weekdays, months, meridiems, number formats, and text direction.

```php
public function init()
```

**Internally calls translation functions like:**
```php
$this->weekday[0] = __( 'Sunday' );
$this->month['01'] = __( 'January' );
$this->meridiem['am'] = __( 'am' );
```

---

### Weekday Methods

#### `get_weekday( $weekday_number )`

Returns full translated weekday name.

```php
public function get_weekday( $weekday_number ): string
```

**Parameters:**
- `$weekday_number` (int) - 0 for Sunday through 6 for Saturday

**Example:**
```php
global $wp_locale;
echo $wp_locale->get_weekday( 1 ); // "Monday" or "Lundi" etc.
```

---

#### `get_weekday_initial( $weekday_name )`

Returns single-letter weekday initial.

```php
public function get_weekday_initial( $weekday_name ): string
```

**Parameters:**
- `$weekday_name` (string) - Full translated weekday name

**Example:**
```php
global $wp_locale;
$weekday = $wp_locale->get_weekday( 2 );
echo $wp_locale->get_weekday_initial( $weekday ); // "T" for Tuesday
```

**Note:** Uses context to differentiate conflicting initials (Tuesday/Thursday, Sunday/Saturday).

---

#### `get_weekday_abbrev( $weekday_name )`

Returns three-letter weekday abbreviation.

```php
public function get_weekday_abbrev( $weekday_name ): string
```

**Example:**
```php
global $wp_locale;
$weekday = $wp_locale->get_weekday( 3 );
echo $wp_locale->get_weekday_abbrev( $weekday ); // "Wed"
```

---

### Month Methods

#### `get_month( $month_number )`

Returns full translated month name.

```php
public function get_month( $month_number ): string
```

**Parameters:**
- `$month_number` (string|int) - '01' through '12' (or 1-12, auto-padded)

**Example:**
```php
global $wp_locale;
echo $wp_locale->get_month( 3 );   // "March"
echo $wp_locale->get_month( '03' ); // "March"
```

**Returns:** Empty string if month number is invalid.

---

#### `get_month_abbrev( $month_name )`

Returns three-letter month abbreviation.

```php
public function get_month_abbrev( $month_name ): string
```

**Example:**
```php
global $wp_locale;
$month = $wp_locale->get_month( 12 );
echo $wp_locale->get_month_abbrev( $month ); // "Dec"
```

---

#### `get_month_genitive( $month_number )`

Returns genitive form of month name (for grammatical cases).

```php
public function get_month_genitive( $month_number ): string
```

**Since:** WordPress 6.8.0

**Example:**
```php
global $wp_locale;
echo $wp_locale->get_month_genitive( 1 ); // "January" (genitive form)
```

**Note:** In many languages, month names change form based on grammatical context.

---

### Meridiem & Text Direction

#### `get_meridiem( $meridiem )`

Returns translated meridiem string.

```php
public function get_meridiem( $meridiem ): string
```

**Parameters:**
- `$meridiem` (string) - 'am', 'pm', 'AM', or 'PM'

**Example:**
```php
global $wp_locale;
echo $wp_locale->get_meridiem( 'AM' ); // "AM" or locale equivalent
```

---

#### `is_rtl()`

Checks if the current locale is right-to-left.

```php
public function is_rtl(): bool
```

**Example:**
```php
global $wp_locale;
if ( $wp_locale->is_rtl() ) {
    echo 'Right-to-left language';
}
```

**See also:** `is_rtl()` global function.

---

### List & Word Count

#### `get_list_item_separator()`

Returns the locale-appropriate list separator.

```php
public function get_list_item_separator(): string
```

**Since:** WordPress 6.0.0

**Example:**
```php
global $wp_locale;
$separator = $wp_locale->get_list_item_separator();
echo implode( $separator, ['one', 'two', 'three'] );
// English: "one, two, three"
// Some languages may use different separators
```

---

#### `get_word_count_type()`

Returns how words should be counted for this locale.

```php
public function get_word_count_type(): string
```

**Since:** WordPress 6.2.0

**Returns:** One of:
- `'words'` - Count space-separated words (most languages)
- `'characters_excluding_spaces'` - Count characters without spaces (CJK languages)
- `'characters_including_spaces'` - Count all characters

**Example:**
```php
global $wp_locale;
$type = $wp_locale->get_word_count_type();
// Japanese/Chinese: 'characters_excluding_spaces'
// English: 'words'
```

---

### Backward Compatibility

#### `register_globals()`

Registers locale data as global variables (deprecated, for backward compatibility).

```php
public function register_globals()
```

**Sets globals:**
- `$weekday`
- `$weekday_initial`
- `$weekday_abbrev`
- `$month`
- `$month_abbrev`

---

## Usage Examples

### Formatting a Date

```php
global $wp_locale;

$weekday_num = date( 'w' ); // 0-6
$month_num = date( 'm' );   // 01-12
$day = date( 'd' );
$year = date( 'Y' );

$weekday = $wp_locale->get_weekday( $weekday_num );
$month = $wp_locale->get_month( $month_num );

echo "$weekday, $month $day, $year";
// "Wednesday, February 14, 2024"
```

### Number Formatting

```php
global $wp_locale;

$number = 1234567.89;
$formatted = number_format(
    $number,
    2,
    $wp_locale->number_format['decimal_point'],
    $wp_locale->number_format['thousands_sep']
);
// English: "1,234,567.89"
// German:  "1.234.567,89"
```

### Building a Month Selector

```php
global $wp_locale;

echo '<select name="month">';
for ( $i = 1; $i <= 12; $i++ ) {
    $month_num = zeroise( $i, 2 );
    $month_name = $wp_locale->get_month( $month_num );
    echo "<option value=\"$month_num\">$month_name</option>";
}
echo '</select>';
```

### RTL-Aware Layout

```php
global $wp_locale;

$float_dir = $wp_locale->is_rtl() ? 'right' : 'left';
echo "<div style=\"float: $float_dir;\">Content</div>";
```

## Related Classes

- **WP_Locale_Switcher** - Manages locale switching
- **WP_Translation_Controller** - Manages translation loading

## Hooks

The `WP_Locale` class doesn't define its own hooks, but the translation functions it uses internally trigger standard gettext hooks.

## Translatable Strings

`WP_Locale::init()` uses these translation patterns:

```php
// Weekdays with context for disambiguation
_x( 'S', 'Sunday initial' );
_x( 'S', 'Saturday initial' );

// Month abbreviations with context
_x( 'Jan', 'January abbreviation' );

// Number format (special handling)
__( 'number_format_thousands_sep' ); // Returns ',' if untranslated
__( 'number_format_decimal_point' ); // Returns '.' if untranslated

// Text direction
_x( 'ltr', 'text direction' ); // Return 'rtl' for RTL languages
```
