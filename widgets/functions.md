# Widget Functions

Core functions for registering and managing widgets and sidebars.

**Source:** `wp-includes/widgets.php`

## Widget Registration

### register_widget()

Registers a widget class with WordPress.

```php
register_widget( string|WP_Widget $widget ): void
```

**Parameters:**
- `$widget` - Class name of a `WP_Widget` subclass, or an instance of `WP_Widget`

**Since:** 2.8.0, 4.6.0 (accepts instance)

```php
// Register by class name
register_widget( 'My_Custom_Widget' );

// Register by instance (4.6.0+)
register_widget( new My_Custom_Widget() );
```

---

### unregister_widget()

Unregisters a widget class. Useful for removing default widgets.

```php
unregister_widget( string|WP_Widget $widget ): void
```

**Parameters:**
- `$widget` - Class name of a `WP_Widget` subclass, or an instance

**Since:** 2.8.0, 4.6.0 (accepts instance)

```php
add_action( 'widgets_init', function() {
    unregister_widget( 'WP_Widget_Meta' );
    unregister_widget( 'WP_Widget_Calendar' );
});
```

---

## Sidebar Registration

### register_sidebar()

Registers a sidebar (widget area) and returns its ID.

```php
register_sidebar( array|string $args = array() ): string
```

**Parameters:**
- `$args` - Array or query string of arguments

**Arguments:**
| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `name` | string | `'Sidebar $i'` | Display name in admin |
| `id` | string | `'sidebar-$i'` | Unique identifier |
| `description` | string | `''` | Description shown in admin |
| `class` | string | `''` | Extra CSS class for admin |
| `before_widget` | string | `'<li id="%1$s" class="widget %2$s">'` | HTML before each widget |
| `after_widget` | string | `'</li>\n'` | HTML after each widget |
| `before_title` | string | `'<h2 class="widgettitle">'` | HTML before widget title |
| `after_title` | string | `'</h2>\n'` | HTML after widget title |
| `before_sidebar` | string | `''` | HTML before sidebar (5.6.0+) |
| `after_sidebar` | string | `''` | HTML after sidebar (5.6.0+) |
| `show_in_rest` | bool | `false` | Show in REST API (5.9.0+) |

**Returns:** Sidebar ID

**Since:** 2.2.0, 5.6.0 (before_sidebar/after_sidebar), 5.9.0 (show_in_rest)

```php
register_sidebar( array(
    'name'          => __( 'Footer Widget Area', 'theme' ),
    'id'            => 'footer-widgets',
    'description'   => __( 'Widgets displayed in the footer.', 'theme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
) );
```

---

### register_sidebars()

Registers multiple sidebars at once.

```php
register_sidebars( int $number = 1, array|string $args = array() ): void
```

**Parameters:**
- `$number` - Number of sidebars to create
- `$args` - Arguments (see `register_sidebar()`)

**Since:** 2.2.0

```php
// Create 3 footer widget areas
register_sidebars( 3, array(
    'name'          => __( 'Footer Area %d', 'theme' ),
    'id'            => 'footer-area',
    'before_widget' => '<div class="footer-widget">',
    'after_widget'  => '</div>',
) );
// Creates: footer-area, footer-area-2, footer-area-3
```

---

### unregister_sidebar()

Removes a sidebar from the registered list.

```php
unregister_sidebar( string|int $sidebar_id ): void
```

**Parameters:**
- `$sidebar_id` - The sidebar ID

**Since:** 2.2.0

```php
unregister_sidebar( 'sidebar-1' );
```

---

### is_registered_sidebar()

Checks if a sidebar is registered.

```php
is_registered_sidebar( string|int $sidebar_id ): bool
```

**Parameters:**
- `$sidebar_id` - The sidebar ID

**Returns:** `true` if registered, `false` otherwise

**Since:** 4.4.0

```php
if ( is_registered_sidebar( 'footer-widgets' ) ) {
    // Sidebar exists
}
```

---

## Sidebar Display

### dynamic_sidebar()

Displays the widgets assigned to a sidebar.

```php
dynamic_sidebar( int|string $index = 1 ): bool
```

**Parameters:**
- `$index` - Sidebar ID, name, or numeric index

**Returns:** `true` if sidebar found and displayed, `false` otherwise

**Since:** 2.2.0

```php
// By ID (recommended)
dynamic_sidebar( 'sidebar-1' );

// By name
dynamic_sidebar( 'Main Sidebar' );

// By numeric index
dynamic_sidebar( 1 );
```

---

### is_active_sidebar()

Checks if a sidebar contains widgets.

```php
is_active_sidebar( string|int $index ): bool
```

**Parameters:**
- `$index` - Sidebar ID, name, or numeric index

**Returns:** `true` if sidebar has widgets, `false` otherwise

**Since:** 2.8.0

```php
if ( is_active_sidebar( 'sidebar-1' ) ) {
    echo '<aside class="sidebar">';
    dynamic_sidebar( 'sidebar-1' );
    echo '</aside>';
}
```

---

### is_dynamic_sidebar()

Checks if any sidebar is in use (has widgets).

```php
is_dynamic_sidebar(): bool
```

**Returns:** `true` if any sidebar has widgets

**Since:** 2.2.0

```php
if ( is_dynamic_sidebar() ) {
    // At least one sidebar has widgets
}
```

---

## Widget Status

### is_active_widget()

Determines if a widget type is active in any sidebar.

```php
is_active_widget( 
    callable|false $callback = false, 
    string|false $widget_id = false, 
    string|false $id_base = false, 
    bool $skip_inactive = true 
): string|false
```

**Parameters:**
- `$callback` - Widget callback function
- `$widget_id` - Specific widget instance ID
- `$id_base` - Widget type ID base
- `$skip_inactive` - Whether to skip inactive widgets

**Returns:** Sidebar ID where widget is active, or `false`

**Since:** 2.2.0

```php
// Check if any search widget is active
if ( is_active_widget( false, false, 'search' ) ) {
    // Search widget is active somewhere
}

// Check if specific widget instance is active
$sidebar = is_active_widget( false, 'text-3', false );
```

---

### the_widget()

Displays a widget directly (outside a sidebar).

```php
the_widget( 
    string $widget, 
    array $instance = array(), 
    array $args = array() 
): void
```

**Parameters:**
- `$widget` - Widget class name
- `$instance` - Widget instance settings
- `$args` - Display arguments

**Default `$args`:**
| Key | Default |
|-----|---------|
| `before_widget` | `'<div class="widget %s">'` |
| `after_widget` | `'</div>'` |
| `before_title` | `'<h2 class="widgettitle">'` |
| `after_title` | `'</h2>'` |

**Since:** 2.8.0

```php
the_widget( 
    'WP_Widget_Recent_Posts',
    array(
        'title'  => 'Latest Articles',
        'number' => 3,
    ),
    array(
        'before_widget' => '<section class="recent-posts">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    )
);
```

---

## Low-Level Widget Registration

### wp_register_sidebar_widget()

Registers a widget instance (low-level function).

```php
wp_register_sidebar_widget( 
    int|string $id, 
    string $name, 
    callable $output_callback, 
    array $options = array(),
    mixed ...$params 
): void
```

**Parameters:**
- `$id` - Widget ID
- `$name` - Widget display name
- `$output_callback` - Function to generate widget output
- `$options` - Widget options (classname, description, show_instance_in_rest)
- `...$params` - Additional parameters for callback

**Since:** 2.2.0, 5.8.0 (show_instance_in_rest)

*Note: Prefer extending `WP_Widget` over using this directly.*

---

### wp_unregister_sidebar_widget()

Removes a widget instance.

```php
wp_unregister_sidebar_widget( int|string $id ): void
```

**Since:** 2.2.0

---

### wp_register_widget_control()

Registers widget control callback (settings form).

```php
wp_register_widget_control( 
    int|string $id, 
    string $name, 
    callable $control_callback, 
    array $options = array(),
    mixed ...$params 
): void
```

**Options:**
- `width` - Form width (default: 250)
- `height` - Form height (default: 200, never used)
- `id_base` - Required for multi-widgets

**Since:** 2.2.0

---

### wp_unregister_widget_control()

Removes widget control callback.

```php
wp_unregister_widget_control( int|string $id ): void
```

**Since:** 2.2.0

---

## Widget Information

### wp_widget_description()

Gets a widget's description.

```php
wp_widget_description( int|string $id ): string|void
```

**Since:** 2.5.0

```php
echo wp_widget_description( 'text-2' );
```

---

### wp_sidebar_description()

Gets a sidebar's description.

```php
wp_sidebar_description( string $id ): string|void
```

**Since:** 2.9.0

```php
echo wp_sidebar_description( 'sidebar-1' );
```

---

## Sidebar Widget Management

### wp_get_sidebars_widgets()

Gets all sidebars and their assigned widgets.

```php
wp_get_sidebars_widgets(): array
```

**Returns:** Array of sidebar IDs to widget ID arrays

**Since:** 2.2.0

```php
$sidebars = wp_get_sidebars_widgets();
// array(
//     'sidebar-1' => array( 'text-1', 'search-2' ),
//     'wp_inactive_widgets' => array( 'calendar-1' ),
// )
```

---

### wp_set_sidebars_widgets()

Sets the sidebar widget assignments.

```php
wp_set_sidebars_widgets( array $sidebars_widgets ): void
```

**Since:** 2.2.0

```php
$sidebars = wp_get_sidebars_widgets();
$sidebars['sidebar-1'][] = 'text-5';
wp_set_sidebars_widgets( $sidebars );
```

---

### wp_get_sidebar()

Gets a registered sidebar by ID.

```php
wp_get_sidebar( string $id ): array|null
```

**Returns:** Sidebar data array or `null`

**Since:** 5.9.0

```php
$sidebar = wp_get_sidebar( 'sidebar-1' );
// array(
//     'id'            => 'sidebar-1',
//     'name'          => 'Main Sidebar',
//     'description'   => '...',
//     'before_widget' => '...',
//     ...
// )
```

---

## Block Widget Functions (5.8+)

### wp_use_widgets_block_editor()

Checks if the block widget editor should be used.

```php
wp_use_widgets_block_editor(): bool
```

**Returns:** `true` if block editor enabled for widgets

**Since:** 5.8.0

```php
if ( wp_use_widgets_block_editor() ) {
    // Block-based widget editor is active
}
```

---

### wp_parse_widget_id()

Parses a widget ID into its components.

```php
wp_parse_widget_id( string $id ): array
```

**Returns:** Array with `id_base` and optionally `number`

**Since:** 5.8.0

```php
$parsed = wp_parse_widget_id( 'text-3' );
// array( 'id_base' => 'text', 'number' => 3 )

$parsed = wp_parse_widget_id( 'my_single_widget' );
// array( 'id_base' => 'my_single_widget' )
```

---

### wp_find_widgets_sidebar()

Finds which sidebar contains a widget.

```php
wp_find_widgets_sidebar( string $widget_id ): string|null
```

**Returns:** Sidebar ID or `null`

**Since:** 5.8.0

```php
$sidebar = wp_find_widgets_sidebar( 'text-3' );
// 'sidebar-1' or null
```

---

### wp_assign_widget_to_sidebar()

Assigns a widget to a sidebar.

```php
wp_assign_widget_to_sidebar( string $widget_id, string $sidebar_id ): void
```

**Since:** 5.8.0

```php
// Move widget to a sidebar
wp_assign_widget_to_sidebar( 'text-3', 'footer-widgets' );

// Remove from all sidebars (make inactive)
wp_assign_widget_to_sidebar( 'text-3', '' );
```

---

### wp_render_widget()

Renders a widget and returns the output.

```php
wp_render_widget( string $widget_id, string $sidebar_id ): string
```

**Returns:** Widget HTML output

**Since:** 5.8.0

```php
$html = wp_render_widget( 'text-3', 'sidebar-1' );
```

---

### wp_render_widget_control()

Renders a widget's control form and returns output.

```php
wp_render_widget_control( string $id ): string|null
```

**Returns:** Form HTML or `null`

**Since:** 5.8.0

```php
$form = wp_render_widget_control( 'text-3' );
```

---

## RSS Widget Helpers

### wp_widget_rss_output()

Displays RSS feed entries.

```php
wp_widget_rss_output( string|array|object $rss, array $args = array() ): void
```

**Args:**
- `show_author` - Display author (default: 0)
- `show_date` - Display date (default: 0)
- `show_summary` - Display excerpt (default: 0)
- `items` - Number of items (default: 10, max: 20)

**Since:** 2.5.0

---

### wp_widget_rss_form()

Displays RSS widget settings form.

```php
wp_widget_rss_form( array|string $args, array $inputs = null ): void
```

**Since:** 2.5.0

---

### wp_widget_rss_process()

Processes and validates RSS widget settings.

```php
wp_widget_rss_process( array $widget_rss, bool $check_feed = true ): array
```

**Returns:** Processed settings with `title`, `url`, `link`, `items`, `error`, etc.

**Since:** 2.5.0

---

## Internal Functions

### _get_widget_id_base()

Extracts the base ID from a widget ID.

```php
_get_widget_id_base( string $id ): string
```

**Since:** 2.8.0

```php
_get_widget_id_base( 'text-3' );  // 'text'
_get_widget_id_base( 'search-1' ); // 'search'
```

---

### retrieve_widgets()

Validates and remaps widgets after theme change.

```php
retrieve_widgets( string|bool $theme_changed = false ): array
```

**Since:** 2.8.0

---

### wp_map_sidebars_widgets()

Maps widgets between old and new sidebars during theme switch.

```php
wp_map_sidebars_widgets( array $existing_sidebars_widgets ): array
```

**Since:** 4.9.0

---

### wp_widgets_init()

Registers all default widgets and fires `widgets_init`.

```php
wp_widgets_init(): void
```

**Since:** 2.2.0

*Called internally during WordPress initialization.*
