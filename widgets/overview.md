# Widgets API

Framework for creating dynamic sidebars and registering widgets in WordPress.

**Since:** 2.2.0  
**Source:** `wp-includes/widgets.php`, `wp-includes/class-wp-widget.php`, `wp-includes/class-wp-widget-factory.php`, `wp-includes/widgets/`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core widget and sidebar functions |
| [class-wp-widget.md](./class-wp-widget.md) | Base widget class for extending |
| [class-wp-widget-factory.md](./class-wp-widget-factory.md) | Widget factory singleton |
| [hooks.md](./hooks.md) | Actions and filters |

## Architecture Overview

The Widgets API consists of three main concepts:

1. **Widgets** - Discrete content blocks that can be placed in sidebars
2. **Sidebars (Widget Areas)** - Named regions where widgets can be assigned
3. **Widget Factory** - Singleton that manages widget registration

## Global Variables

```php
global $wp_registered_sidebars;     // Registered sidebars
global $wp_registered_widgets;       // Registered widget instances
global $wp_registered_widget_controls; // Widget control/form callbacks
global $wp_registered_widget_updates; // Widget update callbacks
global $wp_widget_factory;           // WP_Widget_Factory singleton
```

## Registration Flow

```
wp_widgets_init()
    └── register_widget( 'My_Widget_Class' )
            └── WP_Widget_Factory::register()
                    └── new My_Widget_Class()

'widgets_init' action
    └── WP_Widget_Factory::_register_widgets()
            └── WP_Widget::_register()
                    └── wp_register_sidebar_widget()
                    └── _register_widget_update_callback()
                    └── _register_widget_form_callback()
```

## Sidebar Registration Flow

```
register_sidebar( $args )
    └── Adds to $wp_registered_sidebars
    └── add_theme_support( 'widgets' )
    └── do_action( 'register_sidebar', $sidebar )
```

## Widget Display Flow

```
dynamic_sidebar( $index )
    ├── do_action( 'dynamic_sidebar_before' )
    ├── foreach ( $sidebars_widgets[ $index ] as $widget_id )
    │       ├── apply_filters( 'dynamic_sidebar_params' )
    │       ├── do_action( 'dynamic_sidebar', $widget )
    │       └── call_user_func_array( $callback, $params )
    ├── do_action( 'dynamic_sidebar_after' )
    └── return apply_filters( 'dynamic_sidebar_has_widgets' )
```

## Widget Instance Storage

Widget settings are stored in the options table:

- Option name: `widget_{$id_base}` (e.g., `widget_text`)
- Multi-widget format with numeric keys for each instance
- Special key `_multiwidget` indicates multi-widget format

## Sidebars-Widgets Mapping

Widget-to-sidebar assignments stored in `sidebars_widgets` option:

```php
array(
    'sidebar-1' => array( 'text-1', 'search-2' ),
    'sidebar-2' => array( 'archives-1' ),
    'wp_inactive_widgets' => array( 'calendar-1' ),
)
```

## Default Widgets

WordPress ships with these core widgets:

| Class | ID Base | Description |
|-------|---------|-------------|
| `WP_Widget_Pages` | `pages` | List of pages |
| `WP_Widget_Calendar` | `calendar` | Calendar |
| `WP_Widget_Archives` | `archives` | Monthly archives |
| `WP_Widget_Links` | `links` | Blogroll links (if enabled) |
| `WP_Widget_Media_Audio` | `media_audio` | Audio player |
| `WP_Widget_Media_Image` | `media_image` | Single image |
| `WP_Widget_Media_Video` | `media_video` | Video player |
| `WP_Widget_Media_Gallery` | `media_gallery` | Image gallery |
| `WP_Widget_Meta` | `meta` | Login/RSS/WordPress links |
| `WP_Widget_Search` | `search` | Search form |
| `WP_Widget_Text` | `text` | Arbitrary text/HTML |
| `WP_Widget_Categories` | `categories` | Category list |
| `WP_Widget_Recent_Posts` | `recent-posts` | Recent posts |
| `WP_Widget_Recent_Comments` | `recent-comments` | Recent comments |
| `WP_Widget_RSS` | `rss` | RSS feed entries |
| `WP_Widget_Tag_Cloud` | `tag_cloud` | Tag cloud |
| `WP_Nav_Menu_Widget` | `nav_menu` | Navigation menu |
| `WP_Widget_Custom_HTML` | `custom_html` | Custom HTML code |
| `WP_Widget_Block` | `block` | Gutenberg block container |

## Block-Based Widgets (5.8+)

Since WordPress 5.8, the widgets screen uses the block editor by default:

```php
// Check if block widgets are enabled
if ( wp_use_widgets_block_editor() ) {
    // Block-based widget editor
}

// Disable block widgets (in theme)
remove_theme_support( 'widgets-block-editor' );
```

## Creating a Custom Widget

```php
class My_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'my_widget',           // id_base
            'My Widget',           // name
            array(                 // widget_options
                'classname'   => 'my_widget',
                'description' => 'A custom widget.',
            )
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . 
                 apply_filters( 'widget_title', $instance['title'] ) . 
                 $args['after_title'];
        }
        // Widget content here
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input class="widefat" 
                   id="<?php echo $this->get_field_id( 'title' ); ?>" 
                   name="<?php echo $this->get_field_name( 'title' ); ?>" 
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        return $instance;
    }
}

add_action( 'widgets_init', function() {
    register_widget( 'My_Widget' );
});
```

## Registering a Sidebar

```php
add_action( 'widgets_init', function() {
    register_sidebar( array(
        'name'          => 'Main Sidebar',
        'id'            => 'sidebar-1',
        'description'   => 'Widgets in this area appear on all posts and pages.',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
});
```

## Displaying a Sidebar

```php
// In theme template
if ( is_active_sidebar( 'sidebar-1' ) ) {
    dynamic_sidebar( 'sidebar-1' );
}
```

## Programmatic Widget Output

```php
// Display a widget directly without sidebar
the_widget( 'WP_Widget_Recent_Posts', array(
    'title'  => 'Recent Posts',
    'number' => 5,
), array(
    'before_widget' => '<div class="widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
) );
```
