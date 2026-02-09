# WordPress Classic Editor API Overview

The WordPress Classic Editor API provides integration with TinyMCE (visual editor) and Quicktags (code editor) for rich text editing throughout WordPress. This is the editor system used before the Block Editor (Gutenberg).

## Architecture

The editor system consists of:

1. **`_WP_Editors` Class** - Core class that manages editor instances, configuration, and output
2. **Public Functions** - Wrapper functions like `wp_editor()` for easy integration
3. **TinyMCE Integration** - Visual WYSIWYG editor with toolbar customization
4. **Quicktags Integration** - HTML code editor with button toolbar

## Key Components

### TinyMCE (Visual Editor)

TinyMCE is a JavaScript-based WYSIWYG editor. WordPress integrates TinyMCE 4.x with custom plugins:

- **wordpress** - Core WordPress integration plugin
- **wpautoresize** - Auto-resize editor height
- **wpeditimage** - Image editing capabilities
- **wpemoji** - Emoji support
- **wpgallery** - Gallery shortcode handling
- **wplink** - Internal linking dialog
- **wpdialogs** - Dialog system
- **wptextpattern** - Text pattern formatting
- **wpview** - Preview embeds and shortcodes

### Quicktags (Code Editor)

Quicktags provides a toolbar for the HTML/Code view with buttons for common HTML tags:

- `strong`, `em`, `link`, `block`, `del`, `ins`
- `img`, `ul`, `ol`, `li`, `code`, `more`, `close`

## Basic Usage

```php
// Simple editor
wp_editor( $content, 'my_editor' );

// With custom settings
wp_editor( $content, 'my_editor', array(
    'textarea_name' => 'my_content',
    'textarea_rows' => 15,
    'media_buttons' => true,
    'teeny'         => false,
    'tinymce'       => true,
    'quicktags'     => true,
) );
```

## Editor Settings

| Setting | Type | Default | Description |
|---------|------|---------|-------------|
| `wpautop` | bool | `true` | Whether to use `wpautop()` for paragraph handling |
| `media_buttons` | bool | `true` | Show the Add Media button |
| `default_editor` | string | `''` | Which editor tab shows on load (`tinymce` or `html`) |
| `drag_drop_upload` | bool | `false` | Enable drag & drop uploading |
| `textarea_name` | string | `$editor_id` | Name attribute for the textarea |
| `textarea_rows` | int | `20` | Number of rows in textarea |
| `tabindex` | int/string | `''` | Tab index value |
| `editor_css` | string | `''` | Extra CSS (include `<style>` tags) |
| `editor_class` | string | `''` | Extra CSS classes for textarea |
| `teeny` | bool | `false` | Use minimal editor config |
| `tinymce` | bool/array | `true` | Enable TinyMCE or pass settings |
| `quicktags` | bool/array | `true` | Enable Quicktags or pass settings |

## Editor Tabs

The editor provides two tabs when both TinyMCE and Quicktags are enabled:

1. **Visual** - TinyMCE WYSIWYG editor
2. **Code** - Quicktags HTML editor (formerly "Text")

The default tab is determined by:
1. The `default_editor` setting
2. `wp_default_editor()` function (checks user preference)

## Toolbars

### TinyMCE Toolbars

TinyMCE supports up to 4 toolbars. By default:

**Toolbar 1:**
`formatselect`, `bold`, `italic`, `bullist`, `numlist`, `blockquote`, `alignleft`, `aligncenter`, `alignright`, `link`, `wp_more`, `spellchecker`, `fullscreen`, `wp_adv`

**Toolbar 2 (toggled by wp_adv):**
`strikethrough`, `hr`, `forecolor`, `pastetext`, `removeformat`, `charmap`, `outdent`, `indent`, `undo`, `redo`, `wp_help`

### Teeny Mode

The "teeny" mode provides a minimal toolbar:
`bold`, `italic`, `underline`, `blockquote`, `strikethrough`, `bullist`, `numlist`, `alignleft`, `aligncenter`, `alignright`, `undo`, `redo`, `link`, `fullscreen`

## Files

- **Class**: `wp-includes/class-wp-editor.php`
- **Functions**: `wp-includes/general-template.php`
- **TinyMCE**: `wp-includes/js/tinymce/`
- **Quicktags**: `wp-includes/js/quicktags.js`
- **Styles**: `wp-includes/css/editor.css`

## Security Considerations

1. **User Capability** - Media buttons require `upload_files` capability
2. **Rich Edit** - TinyMCE only loads if `user_can_richedit()` returns true
3. **Browser Support** - TinyMCE checks for compatible browsers
4. **ID Restrictions** - Editor IDs cannot contain square brackets

## Related APIs

- **Block Editor** - Modern editor using blocks (`@wordpress/block-editor`)
- **Code Editor** - CodeMirror-based editor for code files
- **Media Modal** - Media library integration via `wp.media`
