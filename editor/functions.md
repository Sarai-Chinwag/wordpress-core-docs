# Editor Functions Reference

Public functions for working with the WordPress Classic Editor (TinyMCE and Quicktags).

**File:** `wp-includes/general-template.php` (primary)  
**Additional:** `wp-includes/formatting.php`, `wp-includes/theme.php`

---

## wp_editor()

Renders a TinyMCE/Quicktags editor instance.

```php
function wp_editor( string $content, string $editor_id, array $settings = array() ): void
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$content` | string | Initial content for the editor |
| `$editor_id` | string | HTML ID for the textarea. Should not contain square brackets. |
| `$settings` | array | Editor configuration (see Settings below) |

**Settings:**

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `wpautop` | bool | `true` | Whether to use `wpautop()` for paragraphs |
| `media_buttons` | bool | `true` | Show the Add Media button |
| `default_editor` | string | `''` | Default tab: `'tinymce'` or `'html'` |
| `drag_drop_upload` | bool | `false` | Enable drag & drop uploading |
| `textarea_name` | string | `$editor_id` | Name attribute for the textarea |
| `textarea_rows` | int | `20` | Number of textarea rows |
| `tabindex` | string/int | `''` | Tabindex value |
| `tabfocus_elements` | string | `':prev,:next'` | Elements for Tab key navigation |
| `editor_css` | string | `''` | Extra CSS (include `<style>` tags) |
| `editor_class` | string | `''` | Extra CSS classes for textarea |
| `teeny` | bool | `false` | Use minimal editor (like Press This) |
| `tinymce` | bool/array | `true` | Load TinyMCE, or array of settings |
| `quicktags` | bool/array | `true` | Load Quicktags, or array of settings |

**Since:** 3.3.0

**Example - Basic Usage:**

```php
$content = get_post_meta( $post_id, '_my_content', true );
wp_editor( $content, 'my_custom_editor' );
```

**Example - With Settings:**

```php
wp_editor( $content, 'my_editor', array(
    'textarea_name' => 'my_meta_field',
    'textarea_rows' => 10,
    'media_buttons' => false,
    'teeny'         => true,
    'quicktags'     => array(
        'buttons' => 'strong,em,link,ul,ol,li,code',
    ),
) );
```

**Example - TinyMCE Only:**

```php
wp_editor( $content, 'visual_only', array(
    'quicktags' => false,
    'tinymce'   => array(
        'toolbar1' => 'bold,italic,link,unlink',
        'toolbar2' => '',
    ),
) );
```

**Example - Quicktags Only:**

```php
wp_editor( $content, 'code_only', array(
    'tinymce'   => false,
    'quicktags' => array(
        'buttons' => 'strong,em,link,code',
    ),
) );
```

**Notes:**

- TinyMCE cannot be safely moved in the DOM after initialization
- Don't use inside meta boxes with TinyMCE; use `edit_form_advanced` action instead
- Editor IDs with square brackets are deprecated (since 3.9.0)

---

## wp_enqueue_editor()

Enqueue editor scripts and styles for late initialization.

```php
function wp_enqueue_editor(): void
```

**Since:** 4.8.0

**Description:**

Use this when you need to initialize the editor after the page has loaded. Call during `wp_enqueue_scripts` or `admin_enqueue_scripts`.

After enqueueing, use `wp.editor.initialize()` in JavaScript to create instances.

**Example:**

```php
// PHP: Enqueue the editor
add_action( 'wp_enqueue_scripts', function() {
    if ( is_page( 'contact' ) ) {
        wp_enqueue_editor();
    }
} );
```

```javascript
// JavaScript: Initialize editor after page load
jQuery(document).ready(function($) {
    var settings = wp.editor.getDefaultSettings();
    wp.editor.initialize('my_editor_id', settings);
});
```

---

## wp_default_editor()

Determine which editor should be displayed by default.

```php
function wp_default_editor(): string
```

**Returns:** `string` - Either `'tinymce'`, `'html'`, or `'test'`.

**Since:** 2.5.0

**Description:**

Checks user preferences (stored in user settings cookie) to determine which editor tab to show. Falls back to TinyMCE if the user can use rich editing.

**Example:**

```php
$default = wp_default_editor();

if ( 'html' === $default ) {
    // User prefers the Code editor
}
```

**Hooks:**
- `wp_default_editor` - Filter the default editor choice

---

## user_can_richedit()

Check if the current user can access the visual editor.

```php
function user_can_richedit(): bool
```

**Returns:** `bool` - Whether the user can access the visual editor.

**Since:** 2.1.0

**Description:**

Checks multiple conditions:
1. User's "rich_editing" preference (defaults to true for logged-out users)
2. Browser compatibility (Safari, Chrome, Firefox, Edge, Opera, IE 11+)
3. Mobile device support

**Example:**

```php
if ( user_can_richedit() ) {
    // Show TinyMCE
} else {
    // Fall back to textarea
}
```

**Hooks:**
- `user_can_richedit` - Filter whether the user can access the visual editor

---

## format_for_editor()

Format text for display in the editor.

```php
function format_for_editor( string $text, string $default_editor = null ): string
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$text` | string | The text to format |
| `$default_editor` | string | The default editor (`'html'` or `'tinymce'`) |

**Returns:** `string` - The formatted text.

**Since:** 4.3.0

**File:** `wp-includes/formatting.php`

**Description:**

Escapes the text using `htmlspecialchars()` with the blog's charset. Used internally by `_WP_Editors::editor()` when TinyMCE is active.

**Example:**

```php
$content = format_for_editor( $raw_content, 'tinymce' );
```

**Hooks:**
- `format_for_editor` - Filter the formatted text

---

## get_editor_stylesheets()

Get the stylesheets applied to the editor.

```php
function get_editor_stylesheets(): array
```

**Returns:** `array` - Array of stylesheet URLs.

**Since:** 4.3.0

**File:** `wp-includes/theme.php`

**Description:**

Returns URLs for editor stylesheets registered by the theme via `add_editor_style()`. Checks both parent and child themes.

**Example:**

```php
$stylesheets = get_editor_stylesheets();

foreach ( $stylesheets as $url ) {
    echo '<link rel="stylesheet" href="' . esc_url( $url ) . '">';
}
```

**Hooks:**
- `editor_stylesheets` - Filter the array of stylesheet URLs

---

## wp_enqueue_code_editor()

Enqueue assets for the code editor (CodeMirror).

```php
function wp_enqueue_code_editor( array $args ): array|false
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Configuration arguments |

**Args:**

| Key | Type | Description |
|-----|------|-------------|
| `type` | string | MIME type of file being edited |
| `file` | string | Filename (extension used for type detection) |
| `theme` | WP_Theme | Theme being edited |
| `plugin` | string | Plugin being edited |
| `codemirror` | array | CodeMirror setting overrides |
| `csslint` | array | CSSLint rule overrides |
| `jshint` | array | JSHint rule overrides |
| `htmlhint` | array | HTMLHint rule overrides |

**Returns:** `array|false` - Settings for the code editor, or false if not enqueued.

**Since:** 4.9.0

**File:** `wp-includes/general-template.php`

**Description:**

Enqueues CodeMirror for syntax highlighting in code editors. Returns false if the user has disabled syntax highlighting.

**Example:**

```php
$settings = wp_enqueue_code_editor( array(
    'type' => 'text/css',
) );

if ( $settings ) {
    wp_add_inline_script(
        'code-editor',
        sprintf(
            'jQuery(function($){wp.codeEditor.initialize("my_css_textarea", %s);});',
            wp_json_encode( $settings )
        )
    );
}
```

---

## wp_get_code_editor_settings()

Get code editor settings without enqueueing.

```php
function wp_get_code_editor_settings( array $args ): array|false
```

**Parameters:**

Same as `wp_enqueue_code_editor()`.

**Returns:** `array|false` - Code editor settings, or false if disabled.

**Since:** 4.9.0

**Hooks:**
- `wp_code_editor_settings` - Filter the code editor settings

---

## Related JavaScript API

After enqueueing with `wp_enqueue_editor()`, these JavaScript functions are available:

### wp.editor.initialize()

```javascript
wp.editor.initialize( id, settings );
```

Initialize a TinyMCE/Quicktags editor instance.

### wp.editor.remove()

```javascript
wp.editor.remove( id );
```

Remove an editor instance.

### wp.editor.getContent()

```javascript
var content = wp.editor.getContent( id );
```

Get editor content.

### wp.editor.getDefaultSettings()

```javascript
var settings = wp.editor.getDefaultSettings();
```

Get default editor settings object.

---

## Usage Patterns

### Settings Page Editor

```php
function my_settings_page() {
    $content = get_option( 'my_content', '' );
    ?>
    <form method="post" action="options.php">
        <?php settings_fields( 'my_settings' ); ?>
        
        <?php wp_editor( $content, 'my_content_editor', array(
            'textarea_name' => 'my_content',
            'textarea_rows' => 15,
        ) ); ?>
        
        <?php submit_button(); ?>
    </form>
    <?php
}
```

### Frontend Editor

```php
function frontend_editor_shortcode() {
    if ( ! is_user_logged_in() ) {
        return 'Please log in to edit.';
    }
    
    wp_enqueue_editor();
    
    ob_start();
    wp_editor( '', 'frontend_content', array(
        'textarea_name' => 'user_content',
        'media_buttons' => false,
        'teeny'         => true,
        'textarea_rows' => 8,
    ) );
    return ob_get_clean();
}
add_shortcode( 'editor', 'frontend_editor_shortcode' );
```

### Meta Box with Quicktags Only

```php
function my_meta_box_callback( $post ) {
    $content = get_post_meta( $post->ID, '_my_meta', true );
    
    // Use Quicktags only to avoid TinyMCE DOM issues in meta boxes
    wp_editor( $content, 'my_meta_editor', array(
        'textarea_name' => 'my_meta',
        'tinymce'       => false,
        'media_buttons' => false,
        'textarea_rows' => 5,
        'quicktags'     => array(
            'buttons' => 'strong,em,link,code',
        ),
    ) );
}
```
