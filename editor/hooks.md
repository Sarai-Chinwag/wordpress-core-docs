# Editor Hooks Reference

Filters and actions for customizing the WordPress Classic Editor (TinyMCE and Quicktags).

---

## Filters

### wp_editor_settings

Filter the `wp_editor()` settings before parsing.

```php
apply_filters( 'wp_editor_settings', array $settings, string $editor_id )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$settings` | array | Array of editor arguments |
| `$editor_id` | string | Unique editor identifier (e.g., 'content', 'classic-block') |

**Since:** 4.0.0

**Example:**

```php
add_filter( 'wp_editor_settings', function( $settings, $editor_id ) {
    if ( 'content' === $editor_id ) {
        $settings['textarea_rows'] = 25;
        $settings['media_buttons'] = true;
    }
    return $settings;
}, 10, 2 );
```

---

### wp_default_editor

Filter which editor should be displayed by default.

```php
apply_filters( 'wp_default_editor', string $editor )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$editor` | string | The default editor: `'tinymce'`, `'html'`, or `'test'` |

**Since:** 2.5.0

**Example:**

```php
// Force Code editor for all users
add_filter( 'wp_default_editor', function() {
    return 'html';
} );
```

---

### user_can_richedit

Filter whether the user can access the visual editor.

```php
apply_filters( 'user_can_richedit', bool $can_richedit )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$can_richedit` | bool | Whether the user can access the visual editor |

**Since:** 2.1.0

**Example:**

```php
// Disable visual editor for subscribers
add_filter( 'user_can_richedit', function( $can ) {
    if ( current_user_can( 'subscriber' ) ) {
        return false;
    }
    return $can;
} );
```

---

### the_editor

Filter the HTML markup output that displays the editor.

```php
apply_filters( 'the_editor', string $output )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$output` | string | Editor's HTML markup (contains `%s` placeholder for content) |

**Since:** 2.1.0

**Example:**

```php
add_filter( 'the_editor', function( $output ) {
    // Add a wrapper div
    return '<div class="my-editor-wrapper">' . $output . '</div>';
} );
```

---

### the_editor_content

Filter the default editor content.

```php
apply_filters( 'the_editor_content', string $content, string $default_editor )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$content` | string | The editor content |
| `$default_editor` | string | The default editor: `'html'` or `'tinymce'` |

**Since:** 2.1.0

**Example:**

```php
add_filter( 'the_editor_content', function( $content, $editor ) {
    if ( 'tinymce' === $editor && empty( $content ) ) {
        return '<p>Start writing here...</p>';
    }
    return $content;
}, 10, 2 );
```

---

### format_for_editor

Filter text after it's formatted for the editor.

```php
apply_filters( 'format_for_editor', string $text, string $default_editor )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$text` | string | The formatted text |
| `$default_editor` | string | The default editor: `'html'` or `'tinymce'` |

**Since:** 4.3.0

---

### quicktags_settings

Filter the Quicktags settings.

```php
apply_filters( 'quicktags_settings', array $settings, string $editor_id )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$settings` | array | Quicktags settings (`id`, `buttons`) |
| `$editor_id` | string | Unique editor identifier |

**Since:** 3.3.0

**Example:**

```php
add_filter( 'quicktags_settings', function( $settings, $editor_id ) {
    // Add spell button, remove close button
    $settings['buttons'] = 'strong,em,link,block,del,ins,img,ul,ol,li,code,spell';
    return $settings;
}, 10, 2 );
```

---

### mce_css

Filter the comma-delimited list of stylesheets to load in TinyMCE.

```php
apply_filters( 'mce_css', string $stylesheets )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$stylesheets` | string | Comma-delimited list of stylesheet URLs |

**Since:** 2.1.0

**Example:**

```php
add_filter( 'mce_css', function( $mce_css ) {
    if ( ! empty( $mce_css ) ) {
        $mce_css .= ',';
    }
    $mce_css .= plugins_url( 'editor-style.css', __FILE__ );
    return $mce_css;
} );
```

---

### editor_stylesheets

Filter the array of URLs of stylesheets applied to the editor.

```php
apply_filters( 'editor_stylesheets', array $stylesheets )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$stylesheets` | array | Array of stylesheet URLs |

**Since:** 4.3.0

---

### tiny_mce_plugins

Filter the list of default TinyMCE plugins.

```php
apply_filters( 'tiny_mce_plugins', array $plugins, string $editor_id )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugins` | array | Array of default TinyMCE plugins |
| `$editor_id` | string | Unique editor identifier |

**Since:** 3.3.0  
**Modified:** 5.3.0 - Added `$editor_id` parameter

**Default Plugins:**

`charmap`, `colorpicker`, `hr`, `lists`, `media`, `paste`, `tabfocus`, `textcolor`, `fullscreen`, `wordpress`, `wpautoresize`, `wpeditimage`, `wpemoji`, `wpgallery`, `wplink`, `wpdialogs`, `wptextpattern`, `wpview`

**Example:**

```php
add_filter( 'tiny_mce_plugins', function( $plugins ) {
    // Remove paste plugin
    $key = array_search( 'paste', $plugins );
    if ( false !== $key ) {
        unset( $plugins[ $key ] );
    }
    return $plugins;
} );
```

---

### teeny_mce_plugins

Filter the list of teenyMCE plugins.

```php
apply_filters( 'teeny_mce_plugins', array $plugins, string $editor_id )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$plugins` | array | Array of teenyMCE plugins |
| `$editor_id` | string | Unique editor identifier |

**Since:** 2.7.0  
**Modified:** 3.3.0 - Added `$editor_id` parameter

**Default Teeny Plugins:**

`colorpicker`, `lists`, `fullscreen`, `image`, `wordpress`, `wpeditimage`, `wplink`

---

### mce_external_plugins

Filter the list of TinyMCE external plugins.

```php
apply_filters( 'mce_external_plugins', array $external_plugins, string $editor_id )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$external_plugins` | array | Associative array: `'plugin_name' => 'url'` |
| `$editor_id` | string | Unique editor identifier |

**Since:** 2.5.0  
**Modified:** 5.3.0 - Added `$editor_id` parameter

**Example:**

```php
add_filter( 'mce_external_plugins', function( $plugins ) {
    $plugins['myplugin'] = plugins_url( 'js/mce-plugin.js', __FILE__ );
    return $plugins;
} );

// Also add the button
add_filter( 'mce_buttons', function( $buttons ) {
    $buttons[] = 'myplugin_button';
    return $buttons;
} );
```

---

### mce_external_languages

Filter translations for external TinyMCE plugins.

```php
apply_filters( 'mce_external_languages', array $translations, string $editor_id )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$translations` | array | Associative array: `'plugin_name' => 'path/to/lang.php'` |
| `$editor_id` | string | Unique editor identifier |

**Since:** 2.5.0  
**Modified:** 5.3.0 - Added `$editor_id` parameter

---

### mce_buttons

Filter the first-row list of TinyMCE buttons (Visual tab).

```php
apply_filters( 'mce_buttons', array $buttons, string $editor_id )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$buttons` | array | First-row list of buttons |
| `$editor_id` | string | Unique editor identifier |

**Since:** 2.0.0  
**Modified:** 3.3.0 - Added `$editor_id` parameter

**Default First Row:**

`formatselect`, `bold`, `italic`, `bullist`, `numlist`, `blockquote`, `alignleft`, `aligncenter`, `alignright`, `link`, `wp_more`, `spellchecker`, `fullscreen`, `wp_adv`

**Example:**

```php
add_filter( 'mce_buttons', function( $buttons ) {
    // Add table button
    array_push( $buttons, 'table' );
    return $buttons;
} );
```

---

### mce_buttons_2

Filter the second-row list of TinyMCE buttons.

```php
apply_filters( 'mce_buttons_2', array $buttons, string $editor_id )
```

**Since:** 2.0.0

**Default Second Row:**

`strikethrough`, `hr`, `forecolor`, `pastetext`, `removeformat`, `charmap`, `outdent`, `indent`, `undo`, `redo`, `wp_help`

---

### mce_buttons_3

Filter the third-row list of TinyMCE buttons.

```php
apply_filters( 'mce_buttons_3', array $buttons, string $editor_id )
```

**Since:** 2.0.0

**Default:** Empty array

---

### mce_buttons_4

Filter the fourth-row list of TinyMCE buttons.

```php
apply_filters( 'mce_buttons_4', array $buttons, string $editor_id )
```

**Since:** 2.5.0

**Default:** Empty array

---

### teeny_mce_buttons

Filter the list of teenyMCE buttons.

```php
apply_filters( 'teeny_mce_buttons', array $buttons, string $editor_id )
```

**Since:** 2.7.0

**Default Teeny Buttons:**

`bold`, `italic`, `underline`, `blockquote`, `strikethrough`, `bullist`, `numlist`, `alignleft`, `aligncenter`, `alignright`, `undo`, `redo`, `link`, `fullscreen`

---

### tiny_mce_before_init

Filter the TinyMCE config before initialization.

```php
apply_filters( 'tiny_mce_before_init', array $mce_init, string $editor_id )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$mce_init` | array | TinyMCE configuration array |
| `$editor_id` | string | Unique editor identifier |

**Since:** 2.5.0

**Example:**

```php
add_filter( 'tiny_mce_before_init', function( $init ) {
    // Add custom styles to the Format dropdown
    $init['style_formats'] = json_encode( array(
        array(
            'title'   => 'Lead Paragraph',
            'block'   => 'p',
            'classes' => 'lead',
        ),
        array(
            'title'  => 'Highlight',
            'inline' => 'span',
            'classes' => 'highlight',
        ),
    ) );
    
    // Enable style_formats in toolbar
    $init['toolbar1'] = str_replace( 'formatselect', 'styleselect', $init['toolbar1'] );
    
    return $init;
} );
```

---

### teeny_mce_before_init

Filter the teenyMCE config before initialization.

```php
apply_filters( 'teeny_mce_before_init', array $mce_init, string $editor_id )
```

**Since:** 2.7.0

---

### wp_mce_translation

Filter translated strings prepared for TinyMCE.

```php
apply_filters( 'wp_mce_translation', array $strings, string $mce_locale )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$strings` | array | Key/value pairs of strings |
| `$mce_locale` | string | The locale code |

**Since:** 3.9.0

---

### wp_link_query_args

Filter the link query arguments.

```php
apply_filters( 'wp_link_query_args', array $query )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | array | WP_Query arguments |

**Since:** 3.7.0

**Example:**

```php
add_filter( 'wp_link_query_args', function( $query ) {
    // Only show pages in link search
    $query['post_type'] = 'page';
    return $query;
} );
```

---

### wp_link_query

Filter the link query results.

```php
apply_filters( 'wp_link_query', array $results, array $query )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$results` | array | Array of result arrays |
| `$query` | array | WP_Query arguments used |

**Since:** 3.7.0

**Example:**

```php
add_filter( 'wp_link_query', function( $results, $query ) {
    // Add custom entries to link search
    $results[] = array(
        'ID'        => 0,
        'title'     => 'External: Google',
        'permalink' => 'https://google.com',
        'info'      => 'External Link',
    );
    return $results;
}, 10, 2 );
```

---

### disable_captions

Filter to disable image captions.

```php
apply_filters( 'disable_captions', string $disabled )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$disabled` | string | Empty string by default, return truthy to disable |

**Example:**

```php
add_filter( 'disable_captions', '__return_true' );
```

---

## Actions

### media_buttons

Fires after the default media button(s) are displayed.

```php
do_action( 'media_buttons', string $editor_id )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$editor_id` | string | Unique editor identifier |

**Since:** 2.5.0

**Example:**

```php
add_action( 'media_buttons', function( $editor_id ) {
    if ( 'content' === $editor_id ) {
        echo '<button type="button" class="button insert-shortcode">Insert Shortcode</button>';
    }
} );
```

---

### wp_enqueue_editor

Fires when scripts and styles are enqueued for the editor.

```php
do_action( 'wp_enqueue_editor', array $to_load )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$to_load` | array | `['tinymce' => bool, 'quicktags' => bool]` |

**Since:** 3.9.0

**Example:**

```php
add_action( 'wp_enqueue_editor', function( $to_load ) {
    if ( $to_load['tinymce'] ) {
        wp_enqueue_script( 'my-tinymce-plugin' );
    }
} );
```

---

### before_wp_tiny_mce

Fires immediately before the TinyMCE settings are printed.

```php
do_action( 'before_wp_tiny_mce', array $mce_settings )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$mce_settings` | array | TinyMCE settings array |

**Since:** 3.2.0

---

### wp_tiny_mce_init

Fires after tinymce.js is loaded, but before any TinyMCE editor instances are created.

```php
do_action( 'wp_tiny_mce_init', array $mce_settings )
```

**Since:** 3.9.0

---

### after_wp_tiny_mce

Fires after any core TinyMCE editor instances are created.

```php
do_action( 'after_wp_tiny_mce', array $mce_settings )
```

**Since:** 3.2.0

---

### print_default_editor_scripts

Fires when editor scripts are loaded for later initialization.

```php
do_action( 'print_default_editor_scripts' )
```

**Since:** 4.8.0

---

## Deprecated Filters

### htmledit_pre

**Deprecated:** 4.3.0  
**Use instead:** `format_for_editor`

### richedit_pre

**Deprecated:** 4.3.0  
**Use instead:** `format_for_editor`
