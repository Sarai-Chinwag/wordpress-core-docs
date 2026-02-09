# Widget Hooks

Actions and filters for the Widgets API.

**Source:** `wp-includes/widgets.php`, `wp-includes/class-wp-widget.php`

## Actions

### widgets_init

Fires after all default WordPress widgets have been registered.

```php
do_action( 'widgets_init' )
```

**When:** During `wp_widgets_init()`, after core widgets are registered  
**Since:** 2.2.0

**Usage:**
```php
add_action( 'widgets_init', function() {
    // Register custom widgets
    register_widget( 'My_Custom_Widget' );
    
    // Register custom sidebars
    register_sidebar( array(
        'name' => 'Footer Area',
        'id'   => 'footer-1',
    ) );
    
    // Unregister unwanted core widgets
    unregister_widget( 'WP_Widget_Meta' );
});
```

---

### register_sidebar

Fires after a sidebar has been registered.

```php
do_action( 'register_sidebar', array $sidebar )
```

**Parameters:**
- `$sidebar` - Parsed sidebar arguments

**When:** After sidebar added to `$wp_registered_sidebars`  
**Since:** 3.0.0

```php
add_action( 'register_sidebar', function( $sidebar ) {
    error_log( 'Sidebar registered: ' . $sidebar['id'] );
});
```

---

### dynamic_sidebar_before

Fires before widgets are rendered in a dynamic sidebar.

```php
do_action( 'dynamic_sidebar_before', int|string $index, bool $has_widgets )
```

**Parameters:**
- `$index` - Sidebar index, name, or ID
- `$has_widgets` - Whether sidebar has widgets (default `true`)

**When:** Start of `dynamic_sidebar()`, before any widget output  
**Since:** 3.9.0

**Note:** Also fires for empty sidebars and in admin (Inactive Widgets).

```php
add_action( 'dynamic_sidebar_before', function( $index, $has_widgets ) {
    if ( $has_widgets ) {
        echo '<div class="sidebar-wrapper">';
    }
}, 10, 2 );
```

---

### dynamic_sidebar

Fires before a widget's display callback is called.

```php
do_action( 'dynamic_sidebar', array $widget )
```

**Parameters:**
- `$widget` - Associative array with `name`, `id`, `callback`, `params`, `classname`, `description`

**When:** Inside `dynamic_sidebar()` loop, before each widget renders  
**Since:** 3.0.0

**Note:** Does not fire for empty sidebars.

```php
add_action( 'dynamic_sidebar', function( $widget ) {
    // Track which widgets are displayed
    error_log( 'Displaying widget: ' . $widget['id'] );
});
```

---

### dynamic_sidebar_after

Fires after widgets are rendered in a dynamic sidebar.

```php
do_action( 'dynamic_sidebar_after', int|string $index, bool $has_widgets )
```

**Parameters:**
- `$index` - Sidebar index, name, or ID
- `$has_widgets` - Whether sidebar has widgets

**When:** End of `dynamic_sidebar()`, after all widget output  
**Since:** 3.9.0

```php
add_action( 'dynamic_sidebar_after', function( $index, $has_widgets ) {
    if ( $has_widgets ) {
        echo '</div><!-- .sidebar-wrapper -->';
    }
}, 10, 2 );
```

---

### the_widget

Fires before rendering a widget via `the_widget()`.

```php
do_action( 'the_widget', string $widget, array $instance, array $args )
```

**Parameters:**
- `$widget` - Widget class name
- `$instance` - Widget instance settings
- `$args` - Widget display arguments

**When:** Inside `the_widget()`, before `widget()` method called  
**Since:** 3.0.0

```php
add_action( 'the_widget', function( $widget, $instance, $args ) {
    error_log( "the_widget called for: $widget" );
}, 10, 3 );
```

---

### wp_register_sidebar_widget

Fires when a widget is registered.

```php
do_action( 'wp_register_sidebar_widget', array $widget )
```

**Parameters:**
- `$widget` - Widget data array with `name`, `id`, `callback`, `params`, plus options

**When:** Inside `wp_register_sidebar_widget()` when widget is callable  
**Since:** 3.0.0

```php
add_action( 'wp_register_sidebar_widget', function( $widget ) {
    // Log all widget registrations
});
```

---

### wp_unregister_sidebar_widget

Fires just before a widget is removed.

```php
do_action( 'wp_unregister_sidebar_widget', int|string $id )
```

**Parameters:**
- `$id` - Widget ID being unregistered

**When:** Start of `wp_unregister_sidebar_widget()`  
**Since:** 3.0.0

```php
add_action( 'wp_unregister_sidebar_widget', function( $id ) {
    error_log( "Widget unregistered: $id" );
});
```

---

### in_widget_form

Fires at the end of a widget's control form.

```php
do_action_ref_array( 'in_widget_form', array( &$widget, &$return, $instance ) )
```

**Parameters:**
- `&$widget` - Widget instance (by reference)
- `&$return` - Return value from `form()` (by reference)
- `$instance` - Widget instance settings

**When:** After `WP_Widget::form()` completes  
**Since:** 2.8.0

**Note:** Only fires if `widget_form_callback` filter didn't return `false`.

```php
// Add a field to ALL widget forms
add_action( 'in_widget_form', function( $widget, $return, $instance ) {
    $custom = isset( $instance['my_custom_field'] ) 
        ? $instance['my_custom_field'] 
        : '';
    ?>
    <p>
        <label for="<?php echo $widget->get_field_id( 'my_custom_field' ); ?>">
            Custom Field:
        </label>
        <input class="widefat" 
               id="<?php echo $widget->get_field_id( 'my_custom_field' ); ?>"
               name="<?php echo $widget->get_field_name( 'my_custom_field' ); ?>"
               value="<?php echo esc_attr( $custom ); ?>">
    </p>
    <?php
}, 10, 3 );
```

---

## Filters

### sidebars_widgets

Filters the list of sidebars and their widgets.

```php
apply_filters( 'sidebars_widgets', array $sidebars_widgets )
```

**Parameters:**
- `$sidebars_widgets` - Associative array of sidebar IDs to widget ID arrays

**When:** End of `wp_get_sidebars_widgets()`  
**Since:** 2.7.0

```php
add_filter( 'sidebars_widgets', function( $sidebars_widgets ) {
    // Hide a widget on certain pages
    if ( is_front_page() && isset( $sidebars_widgets['sidebar-1'] ) ) {
        $sidebars_widgets['sidebar-1'] = array_diff(
            $sidebars_widgets['sidebar-1'],
            array( 'text-3' )
        );
    }
    return $sidebars_widgets;
});
```

---

### register_sidebar_defaults

Filters default sidebar arguments.

```php
apply_filters( 'register_sidebar_defaults', array $defaults )
```

**Parameters:**
- `$defaults` - Default sidebar arguments

**When:** Inside `register_sidebar()`, before merging with provided args  
**Since:** 5.3.0

```php
add_filter( 'register_sidebar_defaults', function( $defaults ) {
    $defaults['before_widget'] = '<section id="%1$s" class="widget %2$s">';
    $defaults['after_widget']  = '</section>';
    $defaults['before_title']  = '<h3 class="widget-title">';
    $defaults['after_title']   = '</h3>';
    return $defaults;
});
```

---

### dynamic_sidebar_params

Filters widget display parameters.

```php
apply_filters( 'dynamic_sidebar_params', array $params )
```

**Parameters:**
- `$params` - Array containing sidebar args and widget args

**Structure:**
```php
array(
    0 => array(  // Sidebar/widget args
        'name'          => 'Sidebar Name',
        'id'            => 'sidebar-1',
        'description'   => 'Description',
        'class'         => '',
        'before_widget' => '...',
        'after_widget'  => '...',
        'before_title'  => '...',
        'after_title'   => '...',
        'widget_id'     => 'text-3',
        'widget_name'   => 'Text',
    ),
    1 => array(  // Widget-specific args
        'number' => 3,
    ),
)
```

**When:** Inside `dynamic_sidebar()`, after substituting HTML placeholders  
**Since:** 2.5.0

```php
// Add custom class to specific widget
add_filter( 'dynamic_sidebar_params', function( $params ) {
    if ( 'featured-widget' === $params[0]['widget_id'] ) {
        $params[0]['before_widget'] = str_replace(
            'class="widget',
            'class="widget featured',
            $params[0]['before_widget']
        );
    }
    return $params;
});
```

---

### dynamic_sidebar_has_widgets

Filters whether a sidebar has widgets.

```php
apply_filters( 'dynamic_sidebar_has_widgets', bool $did_one, int|string $index )
```

**Parameters:**
- `$did_one` - Whether at least one widget was rendered
- `$index` - Sidebar ID, name, or index

**When:** Return value of `dynamic_sidebar()`  
**Since:** 3.9.0

```php
add_filter( 'dynamic_sidebar_has_widgets', function( $did_one, $index ) {
    // Force sidebar to report widgets even if empty
    if ( 'special-sidebar' === $index ) {
        return true;
    }
    return $did_one;
}, 10, 2 );
```

---

### is_active_sidebar

Filters whether a sidebar is considered active.

```php
apply_filters( 'is_active_sidebar', bool $is_active_sidebar, int|string $index )
```

**Parameters:**
- `$is_active_sidebar` - Whether sidebar has widgets
- `$index` - Sidebar ID, name, or index

**When:** Return value of `is_active_sidebar()`  
**Since:** 3.9.0

```php
add_filter( 'is_active_sidebar', function( $is_active, $index ) {
    // Treat sidebar as always active (for fallback content)
    if ( 'fallback-sidebar' === $index ) {
        return true;
    }
    return $is_active;
}, 10, 2 );
```

---

### widget_display_callback

Filters widget instance before display.

```php
apply_filters( 'widget_display_callback', array $instance, WP_Widget $widget, array $args )
```

**Parameters:**
- `$instance` - Widget instance settings
- `$widget` - Widget object
- `$args` - Sidebar display arguments

**Returns:** Instance array, or `false` to prevent display

**When:** Inside `WP_Widget::display_callback()`  
**Since:** 2.8.0

```php
// Conditionally hide widgets
add_filter( 'widget_display_callback', function( $instance, $widget, $args ) {
    // Hide all widgets from logged-out users on certain sidebar
    if ( 'members-sidebar' === $args['id'] && ! is_user_logged_in() ) {
        return false;
    }
    return $instance;
}, 10, 3 );
```

---

### widget_update_callback

Filters widget instance before saving.

```php
apply_filters( 'widget_update_callback', array $instance, array $new_instance, array $old_instance, WP_Widget $widget )
```

**Parameters:**
- `$instance` - Settings after widget's `update()` method
- `$new_instance` - New settings from form
- `$old_instance` - Previous settings
- `$widget` - Widget object

**Returns:** Instance array, or `false` to prevent saving

**When:** Inside `WP_Widget::update_callback()`, after `update()` method  
**Since:** 2.8.0

```php
// Add timestamp to all widget saves
add_filter( 'widget_update_callback', function( $instance, $new, $old, $widget ) {
    if ( false !== $instance ) {
        $instance['_last_updated'] = time();
    }
    return $instance;
}, 10, 4 );
```

---

### widget_form_callback

Filters widget instance before form display.

```php
apply_filters( 'widget_form_callback', array $instance, WP_Widget $widget )
```

**Parameters:**
- `$instance` - Widget instance settings
- `$widget` - Widget object

**Returns:** Instance array, or `false` to prevent form display

**When:** Inside `WP_Widget::form_callback()`  
**Since:** 2.8.0

```php
// Set default values for new widget instances
add_filter( 'widget_form_callback', function( $instance, $widget ) {
    if ( empty( $instance ) && 'my_widget' === $widget->id_base ) {
        $instance = array(
            'title' => 'Default Title',
            'count' => 5,
        );
    }
    return $instance;
}, 10, 2 );
```

---

### widget_title

Filters the widget title.

```php
apply_filters( 'widget_title', string $title, array $instance, string $id_base )
```

**Parameters:**
- `$title` - Widget title
- `$instance` - Widget instance settings
- `$id_base` - Widget type ID base

**When:** Inside individual widget `widget()` methods  
**Since:** 2.6.0

**Note:** Documented in `wp-includes/widgets/class-wp-widget-pages.php`

```php
// Modify all widget titles
add_filter( 'widget_title', function( $title, $instance, $id_base ) {
    if ( 'search' === $id_base && empty( $title ) ) {
        return __( 'Search This Site', 'theme' );
    }
    return $title;
}, 10, 3 );
```

---

### widget_text

Filters the content of the Text widget.

```php
apply_filters( 'widget_text', string $text, array $instance, WP_Widget_Text|WP_Widget_Custom_HTML $widget )
```

**Parameters:**
- `$text` - Widget content
- `$instance` - Widget settings
- `$widget` - Widget instance

**When:** Inside `WP_Widget_Text::widget()`  
**Since:** 2.3.0, 4.4.0 (added `$widget`), 4.8.1 (may be Custom HTML widget)

```php
add_filter( 'widget_text', function( $text, $instance, $widget ) {
    // Process shortcodes in text widgets
    return do_shortcode( $text );
}, 10, 3 );
```

---

### widget_text_content

Filters visual Text widget content.

```php
apply_filters( 'widget_text_content', string $text, array $instance, WP_Widget_Text $widget )
```

**Parameters:**
- `$text` - Widget content
- `$instance` - Widget settings
- `$widget` - Widget instance

**When:** Inside `WP_Widget_Text::widget()` for visual mode widgets  
**Since:** 4.8.0

**Note:** By default, `wpautop`, `wptexturize`, `capital_P_dangit`, `do_shortcode`, and `wp_filter_content_tags` are hooked.

```php
// Remove auto-paragraphs from visual text widgets
remove_filter( 'widget_text_content', 'wpautop' );
```

---

### widget_block_content

Filters Block widget content.

```php
apply_filters( 'widget_block_content', string $content, array $instance, WP_Widget_Block $widget )
```

**Parameters:**
- `$content` - Block HTML content
- `$instance` - Widget settings
- `$widget` - Widget instance

**When:** Inside `WP_Widget_Block::widget()`  
**Since:** 5.8.0

---

### widget_block_dynamic_classname

Filters Block widget container classname.

```php
apply_filters( 'widget_block_dynamic_classname', string $classname, string $block_name )
```

**Parameters:**
- `$classname` - CSS classname (e.g., `'widget_block widget_text'`)
- `$block_name` - Block type (e.g., `'core/paragraph'`)

**When:** Inside `WP_Widget_Block::get_dynamic_classname()`  
**Since:** 5.8.0

---

### use_widgets_block_editor

Filters whether to use the block editor for widgets.

```php
apply_filters( 'use_widgets_block_editor', bool $use_widgets_block_editor )
```

**Parameters:**
- `$use_widgets_block_editor` - Whether block editor is enabled (from theme support)

**When:** Inside `wp_use_widgets_block_editor()`  
**Since:** 5.8.0

```php
// Disable block widget editor
add_filter( 'use_widgets_block_editor', '__return_false' );
```

---

## Priority Reference

Typical action/filter order during widget display:

```
dynamic_sidebar_before
    └── For each widget:
        ├── dynamic_sidebar_params (filter)
        ├── dynamic_sidebar (action)
        ├── widget_display_callback (filter)
        └── WP_Widget::widget()
            └── widget_title (filter)
            └── widget_text / widget_text_content (filters)
dynamic_sidebar_after
dynamic_sidebar_has_widgets (filter)
```
