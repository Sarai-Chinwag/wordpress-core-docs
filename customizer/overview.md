# WordPress Customizer API Overview

The WordPress Customizer (Theme Customization API) provides a framework for live-previewing any changes to WordPress settings. Introduced in WordPress 3.4, it allows developers to customize and preview changes to the site before publishing them.

## Architecture

The Customizer consists of four primary object types that work together in a hierarchical structure:

```
Panels (optional containers)
  └── Sections (containers for controls)
       └── Controls (UI elements)
            └── Settings (data storage)
```

### Core Classes

| Class | Purpose | Since |
|-------|---------|-------|
| `WP_Customize_Manager` | Central orchestrator, factory for all components | 3.4 |
| `WP_Customize_Setting` | Handles data storage, sanitization, and preview | 3.4 |
| `WP_Customize_Section` | UI container for controls | 3.4 |
| `WP_Customize_Panel` | UI container for sections | 4.0 |
| `WP_Customize_Control` | UI element for user input | 3.4 |
| `WP_Customize_Selective_Refresh` | Partial content refresh | 4.5 |
| `WP_Customize_Partial` | Defines refreshable content regions | 4.5 |

## Live Preview System

The Customizer implements a sophisticated live preview system:

### Preview Transport Methods

1. **`refresh`** (default) - Reloads the entire preview iframe when setting changes
2. **`postMessage`** - Uses JavaScript to update preview without reload

```php
$wp_customize->add_setting( 'my_setting', array(
    'transport' => 'postMessage', // Enable JS-based preview
) );
```

### Preview Flow

1. User makes changes in the Customizer pane
2. Changes are stored in a **changeset** (post type: `customize_changeset`)
3. Preview iframe displays changes without saving to database
4. On publish, settings are persisted to their storage locations

## Changesets (Since 4.7)

Changesets allow saving customizations without publishing:

- **UUID-based** - Each changeset has a unique identifier
- **Transactional** - All-or-nothing publishing
- **Schedulable** - Can be scheduled for future publishing
- **Collaborative** - Supports autosave revisions per user
- **Branching** - Optional concurrent changeset support

### Changeset Statuses

| Status | Description |
|--------|-------------|
| `auto-draft` | Unsaved work in progress |
| `draft` | Saved but not published |
| `pending` | Awaiting review |
| `future` | Scheduled for publication |
| `publish` | Applied to the site |

## Selective Refresh (Since 4.5)

Selective refresh updates only specific portions of the preview:

```php
$wp_customize->selective_refresh->add_partial( 'blogname', array(
    'selector' => '.site-title a',
    'render_callback' => function() {
        bloginfo( 'name' );
    },
) );
```

### Benefits
- **Performance** - Updates only what changed
- **UX** - Smoother preview experience
- **Reliability** - Maintains scroll position and state

## Registration Hook

All Customizer components should be registered on the `customize_register` action:

```php
add_action( 'customize_register', function( $wp_customize ) {
    // Add panels, sections, controls, settings, and partials
} );
```

## Basic Example

```php
add_action( 'customize_register', function( $wp_customize ) {
    // Add a section
    $wp_customize->add_section( 'my_section', array(
        'title'    => __( 'My Section' ),
        'priority' => 30,
    ) );

    // Add a setting
    $wp_customize->add_setting( 'my_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    // Add a control
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'my_color',
        array(
            'label'   => __( 'My Color' ),
            'section' => 'my_section',
        )
    ) );
} );
```

## Built-in Control Types

### Basic Controls (via `type` argument)
- `text` - Text input (default)
- `checkbox` - Checkbox
- `textarea` - Multi-line text
- `radio` - Radio buttons (requires `choices`)
- `select` - Dropdown (requires `choices`)
- `dropdown-pages` - Page selector
- `email`, `url`, `number`, `hidden`, `date` - HTML5 inputs

### Specialized Control Classes
- `WP_Customize_Color_Control` - Color picker
- `WP_Customize_Media_Control` - Media library attachment
- `WP_Customize_Image_Control` - Image upload
- `WP_Customize_Upload_Control` - File upload
- `WP_Customize_Cropped_Image_Control` - Image with cropping
- `WP_Customize_Code_Editor_Control` - Syntax-highlighted code editor
- `WP_Customize_Date_Time_Control` - Date/time picker

## Capability Model

The Customizer uses WordPress capabilities for access control:

- **`customize`** - Meta capability that maps to `edit_theme_options`
- Controls inherit capability from their associated settings
- Sections and panels have their own `capability` property

## Theme Support

Settings can require theme support:

```php
$wp_customize->add_setting( 'header_image', array(
    'theme_supports' => 'custom-header',
) );
```

## Starter Content (Since 4.7)

Themes can provide starter content that's imported on fresh installations:

```php
add_theme_support( 'starter-content', array(
    'widgets' => array( /* ... */ ),
    'posts' => array( /* ... */ ),
    'nav_menus' => array( /* ... */ ),
    'options' => array( /* ... */ ),
    'theme_mods' => array( /* ... */ ),
) );
```

## JavaScript API

The Customizer has a robust JavaScript API (`wp.customize`):

```javascript
// React to setting changes
wp.customize( 'my_setting', function( setting ) {
    setting.bind( function( value ) {
        // Update preview
    } );
} );

// From preview frame
wp.customize.preview.bind( 'active', function() {
    // Preview is ready
} );
```

## Related Files

| File | Purpose |
|------|---------|
| `class-wp-customize-manager.php` | Manager class |
| `class-wp-customize-setting.php` | Settings class |
| `class-wp-customize-section.php` | Sections class |
| `class-wp-customize-panel.php` | Panels class |
| `class-wp-customize-control.php` | Controls class |
| `customize/` | Specialized subclasses |
