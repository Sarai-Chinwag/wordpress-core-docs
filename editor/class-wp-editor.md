# _WP_Editors Class Reference

The `_WP_Editors` class facilitates adding the WordPress editor (TinyMCE and Quicktags) to pages. This is a private/internal class - use the public API functions like `wp_editor()` instead of calling methods directly.

**File:** `wp-includes/class-wp-editor.php`  
**Since:** 3.3.0

## Class Definition

```php
#[AllowDynamicProperties]
final class _WP_Editors {
    public static $mce_locale;
    
    private static $mce_settings = array();
    private static $qt_settings  = array();
    private static $plugins      = array();
    private static $qt_buttons   = array();
    private static $ext_plugins;
    private static $baseurl;
    private static $first_init;
    private static $this_tinymce       = false;
    private static $this_quicktags     = false;
    private static $has_tinymce        = false;
    private static $has_quicktags      = false;
    private static $has_medialib       = false;
    private static $editor_buttons_css = true;
    private static $drag_drop_upload   = false;
    private static $translation;
    private static $tinymce_scripts_printed = false;
    private static $link_dialog_printed     = false;
}
```

---

## Static Methods

### parse_settings()

Parse default arguments for an editor instance.

```php
public static function parse_settings( string $editor_id, array $settings ): array
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$editor_id` | string | HTML ID for the textarea and TinyMCE/Quicktags instances. Should not contain square brackets. |
| `$settings` | array | Array of editor arguments (see below). |

**Settings Array:**

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `wpautop` | bool | `true` (or `false` if post has blocks) | Whether to use `wpautop()` |
| `media_buttons` | bool | `true` | Show Add Media button |
| `default_editor` | string | `''` | Default editor: `tinymce` or `html` |
| `drag_drop_upload` | bool | `false` | Enable drag & drop uploading |
| `textarea_name` | string | `$editor_id` | Name attribute for textarea |
| `textarea_rows` | int | `20` | Number of textarea rows |
| `tabindex` | string/int | `''` | Tabindex value |
| `tabfocus_elements` | string | `':prev,:next'` | Tab focus navigation elements |
| `editor_css` | string | `''` | Extra CSS with `<style>` tags |
| `editor_class` | string | `''` | Extra CSS classes for textarea |
| `teeny` | bool | `false` | Use minimal editor config |
| `_content_editor_dfw` | bool | `false` | Distraction-free writing mode |
| `tinymce` | bool/array | `true` | Enable TinyMCE or pass settings |
| `quicktags` | bool/array | `true` | Enable Quicktags or pass settings |
| `editor_height` | int | — | Fixed height in pixels (50-5000) |

**Returns:** `array` - Parsed arguments array.

**Since:** 3.3.0

**Hooks:**
- `wp_editor_settings` - Filter settings before parsing

---

### editor()

Outputs the HTML for a single instance of the editor.

```php
public static function editor( string $content, string $editor_id, array $settings = array() ): void
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$content` | string | Initial content for the editor |
| `$editor_id` | string | HTML ID for the textarea and TinyMCE/Quicktags instances |
| `$settings` | array | See `parse_settings()` for description |

**Since:** 3.3.0

**Hooks:**
- `media_buttons` - Action after default media buttons are displayed
- `the_editor` - Filter the editor HTML markup
- `the_editor_content` - Filter the default editor content

**Example:**

```php
_WP_Editors::editor( 'Hello World', 'my_editor', array(
    'textarea_rows' => 10,
    'media_buttons' => false,
) );
```

---

### editor_settings()

Configure TinyMCE and Quicktags settings for an editor instance.

```php
public static function editor_settings( string $editor_id, array $set ): void
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$editor_id` | string | Unique editor identifier, e.g. 'content' |
| `$set` | array | Array of editor arguments |

**Since:** 3.3.0

**Hooks:**
- `quicktags_settings` - Filter Quicktags settings
- `teeny_mce_plugins` - Filter teenyMCE plugins list
- `mce_external_plugins` - Filter external TinyMCE plugins
- `tiny_mce_plugins` - Filter default TinyMCE plugins
- `mce_external_languages` - Filter translations for external plugins
- `mce_css` - Filter stylesheets loaded in TinyMCE
- `teeny_mce_buttons` - Filter teeny toolbar buttons
- `mce_buttons` - Filter first toolbar row
- `mce_buttons_2` - Filter second toolbar row
- `mce_buttons_3` - Filter third toolbar row
- `mce_buttons_4` - Filter fourth toolbar row
- `teeny_mce_before_init` - Filter teenyMCE config before init
- `tiny_mce_before_init` - Filter TinyMCE config before init

---

### enqueue_scripts()

Enqueue editor scripts based on what's needed.

```php
public static function enqueue_scripts( bool $default_scripts = false ): void
```

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$default_scripts` | bool | `false` | Whether to enqueue default scripts |

**Since:** 3.3.0

**Enqueued Scripts:**
- `editor` - If TinyMCE is used
- `quicktags` - If Quicktags is used
- `wplink` - If wplink plugin or link button is used
- `jquery-ui-autocomplete` - For link search
- `media-upload` - If media library is used
- `wp-embed` - For embed support

**Hooks:**
- `wp_enqueue_editor` - Fires when editor scripts/styles are enqueued

---

### enqueue_default_editor()

Enqueue all editor scripts for post-page-load initialization.

```php
public static function enqueue_default_editor(): void
```

**Since:** 4.8.0

**Description:**

Use this when you need to initialize the editor after the page has loaded. This enqueues all necessary scripts and adds the `print_default_editor_scripts` action to output configuration.

**Example:**

```php
// In your plugin/theme
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_editor();
} );
```

---

### print_default_editor_scripts()

Print all editor scripts and default settings for post-page-load initialization.

```php
public static function print_default_editor_scripts(): void
```

**Since:** 4.8.0

**Hooks:**
- `print_default_editor_scripts` - Fires after all scripts and settings are printed

**Output:**

Outputs a JavaScript object `window.wp.editor.getDefaultSettings()` that returns default TinyMCE and Quicktags configuration.

---

### get_mce_locale()

Returns the TinyMCE locale code.

```php
public static function get_mce_locale(): string
```

**Returns:** `string` - ISO 639-1 two-letter language code (e.g., 'en', 'de', 'fr').

**Since:** 4.8.0

---

### get_baseurl()

Returns the TinyMCE base URL.

```php
public static function get_baseurl(): string
```

**Returns:** `string` - URL to TinyMCE directory (e.g., `https://example.com/wp-includes/js/tinymce`).

**Since:** 4.8.0

---

### wp_mce_translation()

Get TinyMCE translation strings as JSON or JavaScript.

```php
public static function wp_mce_translation( string $mce_locale = '', bool $json_only = false ): string
```

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$mce_locale` | string | `''` | The locale for the editor |
| `$json_only` | bool | `false` | Return only JSON (no JS calls) |

**Returns:** `string` - JSON encoded translation object or JS snippet with `tinymce.addI18n()` call.

**Since:** 3.9.0

**Hooks:**
- `wp_mce_translation` - Filter translated strings

---

### force_uncompressed_tinymce()

Force uncompressed TinyMCE when a custom theme is defined.

```php
public static function force_uncompressed_tinymce(): void
```

**Since:** 5.0.0

**Description:**

The compressed TinyMCE file cannot handle custom themes, so this ensures WordPress uses uncompressed TinyMCE when needed.

---

### print_tinymce_scripts()

Print the main TinyMCE scripts.

```php
public static function print_tinymce_scripts(): void
```

**Since:** 4.8.0

**Description:**

Outputs the TinyMCE JavaScript and translation strings. Only runs once per page.

---

### editor_js()

Print the TinyMCE configuration and initialization scripts.

```php
public static function editor_js(): void
```

**Since:** 3.3.0

**Output:**

Generates the `tinyMCEPreInit` JavaScript object containing:
- `baseURL` - TinyMCE base URL
- `suffix` - Script suffix (`.min` in production)
- `mceInit` - TinyMCE initialization settings per editor
- `qtInit` - Quicktags initialization settings per editor
- `ref` - Reference settings (plugins, theme, language)

**Hooks:**
- `before_wp_tiny_mce` - Before TinyMCE settings are printed
- `wp_tiny_mce_init` - After tinymce.js is loaded, before instances are created
- `after_wp_tiny_mce` - After TinyMCE instances are created

---

### wp_fullscreen_html()

Output HTML for distraction-free writing mode.

```php
public static function wp_fullscreen_html(): void
```

**Since:** 3.2.0  
**Deprecated:** 4.3.0

---

### wp_link_query()

Perform post queries for internal linking.

```php
public static function wp_link_query( array $args = array() ): array|false
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Query arguments |

**Args:**

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `pagenum` | int | `1` | Page number |
| `s` | string | — | Search keywords |

**Returns:** `array|false` - Array of results or false if none.

**Result Array:**

```php
array(
    array(
        'ID'        => 123,           // Post ID
        'title'     => 'Post Title',  // Escaped post title
        'permalink' => 'https://...',  // Post permalink
        'info'      => '2024/01/15',  // Date or post type label
    ),
    // ...
)
```

**Since:** 3.1.0

**Hooks:**
- `wp_link_query_args` - Filter query arguments
- `wp_link_query` - Filter query results

---

### wp_link_dialog()

Output the dialog HTML for internal linking.

```php
public static function wp_link_dialog(): void
```

**Since:** 3.1.0

**Description:**

Outputs the modal dialog used by the wplink TinyMCE plugin for inserting/editing links. Only outputs once per page.

---

## Private Methods

### _parse_init()

Parse initialization array to JavaScript object string.

```php
private static function _parse_init( array $init ): string
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$init` | array | Initialization settings |

**Returns:** `string` - JavaScript object literal string.

**Since:** 3.3.0

---

### default_settings()

Returns the default TinyMCE settings.

```php
private static function default_settings(): array
```

**Returns:** `array` - Default TinyMCE configuration (excludes plugins, buttons, selector).

**Since:** 4.8.0

**Default Settings Include:**
- `theme` - 'modern'
- `skin` - 'lightgray'
- `language` - User's locale
- `formats` - Alignment and strikethrough formats
- `relative_urls` - false
- `browser_spellcheck` - true
- `resize` - 'vertical'
- `menubar` - false
- `branding` - false
- `content_css` - Dashicons and wp-content.css

---

### get_translation()

Get the translation strings array.

```php
private static function get_translation(): array
```

**Returns:** `array` - Translated strings for TinyMCE UI.

**Since:** 4.7.0

**Description:**

Returns an array of translated strings for TinyMCE's interface. Strings may be simple strings or arrays with format `array( 'Label', 'keyboard_shortcut' )`.

---

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$mce_locale` | string | TinyMCE locale code |
| `$mce_settings` | array | TinyMCE settings per editor ID |
| `$qt_settings` | array | Quicktags settings per editor ID |
| `$plugins` | array | Enabled TinyMCE plugins |
| `$qt_buttons` | array | Enabled Quicktags buttons |
| `$ext_plugins` | string | External plugin initialization code |
| `$baseurl` | string | TinyMCE base URL |
| `$first_init` | array | First-run initialization settings |
| `$this_tinymce` | bool | Current instance uses TinyMCE |
| `$this_quicktags` | bool | Current instance uses Quicktags |
| `$has_tinymce` | bool | Any instance uses TinyMCE |
| `$has_quicktags` | bool | Any instance uses Quicktags |
| `$has_medialib` | bool | Any instance uses media library |
| `$editor_buttons_css` | bool | Whether to print editor-buttons CSS |
| `$drag_drop_upload` | bool | Drag & drop upload enabled |
| `$translation` | array | Cached translation strings |
| `$tinymce_scripts_printed` | bool | TinyMCE scripts already output |
| `$link_dialog_printed` | bool | Link dialog already output |

---

## Usage Notes

1. **Don't use directly** - Use `wp_editor()` wrapper function instead
2. **One-time init** - TinyMCE cannot be safely moved in DOM after initialization
3. **ID restrictions** - Editor IDs cannot contain square brackets (deprecated since 3.9.0)
4. **Meta boxes** - Avoid TinyMCE in meta boxes; use Quicktags only or use edit_form_advanced action
