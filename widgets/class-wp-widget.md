# WP_Widget

Base class for creating widgets. Must be extended.

**Source:** `wp-includes/class-wp-widget.php`  
**Since:** 2.8.0

## Class Synopsis

```php
#[AllowDynamicProperties]
class WP_Widget {
    // Properties
    public $id_base;
    public $name;
    public $option_name;
    public $alt_option_name;
    public $widget_options;
    public $control_options;
    public $number;
    public $id;
    public $updated;

    // Constructor
    public function __construct( $id_base, $name, $widget_options = array(), $control_options = array() );

    // Methods to override
    public function widget( $args, $instance );  // Required
    public function update( $new_instance, $old_instance );
    public function form( $instance );

    // Helper methods
    public function get_field_name( $field_name );
    public function get_field_id( $field_name );
    public function get_settings();
    public function save_settings( $settings );
    public function is_preview();

    // Internal methods (do not override)
    public function _register();
    public function _set( $number );
    public function _get_display_callback();
    public function _get_update_callback();
    public function _get_form_callback();
    public function _register_one( $number = -1 );
    public function display_callback( $args, $widget_args = 1 );
    public function update_callback( $deprecated = 1 );
    public function form_callback( $widget_args = 1 );
}
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$id_base` | string | Root ID for all instances of this widget type |
| `$name` | string | Widget display name |
| `$option_name` | string | Option name where settings are stored (`widget_{$id_base}`) |
| `$alt_option_name` | string | Alternative (legacy) option name |
| `$widget_options` | array | Options passed to `wp_register_sidebar_widget()` |
| `$control_options` | array | Options passed to `wp_register_widget_control()` |
| `$number` | int\|false | Instance number of current widget |
| `$id` | string\|false | Full widget ID (`{$id_base}-{$number}`) |
| `$updated` | bool | Whether settings have been updated this request |

## Constructor

### __construct()

```php
public function __construct( 
    string $id_base, 
    string $name, 
    array $widget_options = array(), 
    array $control_options = array() 
)
```

**Parameters:**
- `$id_base` - Base ID for the widget (lowercase, unique). If empty, derived from class name.
- `$name` - Display name shown in admin
- `$widget_options` - Options for `wp_register_sidebar_widget()`
- `$control_options` - Options for `wp_register_widget_control()`

**Widget Options:**
| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `classname` | string | Class name | CSS class for widget container |
| `description` | string | `''` | Widget description |
| `customize_selective_refresh` | bool | `false` | Enable selective refresh in Customizer |
| `show_instance_in_rest` | bool | `false` | Expose instance settings in REST API |

**Control Options:**
| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `id_base` | string | `$id_base` | Base ID (set automatically) |
| `width` | int | 250 | Control form width |
| `height` | int | 200 | Control form height (unused) |

```php
public function __construct() {
    parent::__construct(
        'my_widget',                    // id_base
        __( 'My Widget', 'textdomain' ), // name
        array(
            'classname'                   => 'widget_my_widget',
            'description'                 => __( 'Displays something useful.', 'textdomain' ),
            'customize_selective_refresh' => true,
            'show_instance_in_rest'       => true,
        ),
        array(
            'width'  => 400,
            'height' => 350,
        )
    );
}
```

## Methods to Override

### widget()

**Required.** Outputs the widget content on the front end.

```php
public function widget( array $args, array $instance )
```

**Parameters:**
- `$args` - Display arguments from sidebar
- `$instance` - Widget instance settings

**Display Arguments ($args):**
| Key | Description |
|-----|-------------|
| `before_widget` | HTML before widget (contains `%1$s` for ID, `%2$s` for class) |
| `after_widget` | HTML after widget |
| `before_title` | HTML before title |
| `after_title` | HTML after title |
| `widget_id` | Full widget ID |
| `widget_name` | Widget display name |

```php
public function widget( $args, $instance ) {
    $title = ! empty( $instance['title'] ) 
        ? $instance['title'] 
        : __( 'Default Title', 'textdomain' );

    /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

    echo $args['before_widget'];

    if ( ! empty( $title ) ) {
        echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
    }

    // Your widget content here
    echo '<p>Hello World!</p>';

    echo $args['after_widget'];
}
```

---

### update()

Sanitizes and saves widget settings.

```php
public function update( array $new_instance, array $old_instance ): array
```

**Parameters:**
- `$new_instance` - New settings from form submission
- `$old_instance` - Previously saved settings

**Returns:** Settings array to save, or `false` to cancel saving

```php
public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    
    $instance['title'] = sanitize_text_field( $new_instance['title'] );
    $instance['count'] = absint( $new_instance['count'] );
    $instance['show_date'] = ! empty( $new_instance['show_date'] );
    
    // For HTML content (with capability check)
    if ( current_user_can( 'unfiltered_html' ) ) {
        $instance['content'] = $new_instance['content'];
    } else {
        $instance['content'] = wp_kses_post( $new_instance['content'] );
    }

    return $instance;
}
```

---

### form()

Outputs the widget settings form in admin.

```php
public function form( array $instance ): string|void
```

**Parameters:**
- `$instance` - Current widget settings

**Returns:** `'noform'` if no form needed, otherwise void

```php
public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 5;
    $show_date = ! empty( $instance['show_date'] );
    ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">
            <?php esc_html_e( 'Title:', 'textdomain' ); ?>
        </label>
        <input class="widefat" 
               id="<?php echo $this->get_field_id( 'title' ); ?>" 
               name="<?php echo $this->get_field_name( 'title' ); ?>" 
               type="text" 
               value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'count' ); ?>">
            <?php esc_html_e( 'Number to show:', 'textdomain' ); ?>
        </label>
        <input id="<?php echo $this->get_field_id( 'count' ); ?>" 
               name="<?php echo $this->get_field_name( 'count' ); ?>" 
               type="number" 
               min="1" 
               max="20"
               value="<?php echo esc_attr( $count ); ?>">
    </p>
    <p>
        <input type="checkbox" 
               class="checkbox" 
               id="<?php echo $this->get_field_id( 'show_date' ); ?>" 
               name="<?php echo $this->get_field_name( 'show_date' ); ?>"
               <?php checked( $show_date ); ?>>
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>">
            <?php esc_html_e( 'Display date?', 'textdomain' ); ?>
        </label>
    </p>
    <?php
}
```

## Helper Methods

### get_field_name()

Generates the `name` attribute for form fields.

```php
public function get_field_name( string $field_name ): string
```

**Since:** 2.8.0, 4.4.0 (array format support)

```php
$this->get_field_name( 'title' );
// 'widget-my_widget[3][title]'

$this->get_field_name( 'options[color]' );
// 'widget-my_widget[3][options][color]'
```

---

### get_field_id()

Generates the `id` attribute for form fields.

```php
public function get_field_id( string $field_name ): string
```

**Since:** 2.8.0, 4.4.0 (array format support)

```php
$this->get_field_id( 'title' );
// 'widget-my_widget-3-title'

$this->get_field_id( 'options[color]' );
// 'widget-my_widget-3-options-color'
```

---

### get_settings()

Retrieves settings for all instances of this widget type.

```php
public function get_settings(): array
```

**Returns:** Multi-dimensional array keyed by instance number

```php
$settings = $this->get_settings();
// array(
//     2 => array( 'title' => 'Widget One', ... ),
//     3 => array( 'title' => 'Widget Two', ... ),
// )
```

---

### save_settings()

Saves settings for all instances.

```php
public function save_settings( array $settings ): void
```

```php
$settings = $this->get_settings();
$settings[ $this->number ]['title'] = 'New Title';
$this->save_settings( $settings );
```

---

### is_preview()

Checks if rendering inside the Customizer preview.

```php
public function is_preview(): bool
```

**Since:** 3.9.0

```php
public function widget( $args, $instance ) {
    if ( $this->is_preview() ) {
        // Don't cache output in Customizer preview
    }
    // ...
}
```

## Complete Widget Example

```php
/**
 * Custom Social Links Widget
 */
class Social_Links_Widget extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'social_links',
            __( 'Social Links', 'theme' ),
            array(
                'classname'                   => 'widget_social_links',
                'description'                 => __( 'Display social media links.', 'theme' ),
                'customize_selective_refresh' => true,
            )
        );
    }

    /**
     * Front-end display
     */
    public function widget( $args, $instance ) {
        $title = apply_filters( 
            'widget_title', 
            empty( $instance['title'] ) ? '' : $instance['title'], 
            $instance, 
            $this->id_base 
        );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        echo '<ul class="social-links">';
        
        foreach ( array( 'twitter', 'facebook', 'instagram' ) as $network ) {
            if ( ! empty( $instance[ $network ] ) ) {
                printf(
                    '<li><a href="%s" class="%s">%s</a></li>',
                    esc_url( $instance[ $network ] ),
                    esc_attr( $network ),
                    esc_html( ucfirst( $network ) )
                );
            }
        }

        echo '</ul>';
        echo $args['after_widget'];
    }

    /**
     * Settings form
     */
    public function form( $instance ) {
        $defaults = array(
            'title'     => '',
            'twitter'   => '',
            'facebook'  => '',
            'instagram' => '',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php esc_html_e( 'Title:', 'theme' ); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo $this->get_field_id( 'title' ); ?>" 
                   name="<?php echo $this->get_field_name( 'title' ); ?>" 
                   type="text" 
                   value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>
        <?php
        foreach ( array( 'twitter', 'facebook', 'instagram' ) as $network ) :
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( $network ); ?>">
                <?php echo esc_html( ucfirst( $network ) ); ?> URL:
            </label>
            <input class="widefat" 
                   id="<?php echo $this->get_field_id( $network ); ?>" 
                   name="<?php echo $this->get_field_name( $network ); ?>" 
                   type="url" 
                   value="<?php echo esc_url( $instance[ $network ] ); ?>">
        </p>
        <?php
        endforeach;
    }

    /**
     * Save settings
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        
        foreach ( array( 'twitter', 'facebook', 'instagram' ) as $network ) {
            $instance[ $network ] = esc_url_raw( $new_instance[ $network ] );
        }

        return $instance;
    }
}

// Register the widget
add_action( 'widgets_init', function() {
    register_widget( 'Social_Links_Widget' );
});
```

## Internal Methods

These methods are used internally by WordPress and should not be overridden.

| Method | Description |
|--------|-------------|
| `_register()` | Registers all instances of this widget |
| `_set( $number )` | Sets the current instance number |
| `_get_display_callback()` | Returns display callback array |
| `_get_update_callback()` | Returns update callback array |
| `_get_form_callback()` | Returns form callback array |
| `_register_one( $number )` | Registers a single widget instance |
| `display_callback()` | Internal wrapper for `widget()` |
| `update_callback()` | Internal handler for form submission |
| `form_callback()` | Internal wrapper for `form()` |

## Filters in WP_Widget

### widget_display_callback

Filters instance settings before display.

```php
apply_filters( 'widget_display_callback', array $instance, WP_Widget $widget, array $args )
```

Return `false` to prevent widget from displaying.

---

### widget_update_callback

Filters instance settings before saving.

```php
apply_filters( 'widget_update_callback', array $instance, array $new_instance, array $old_instance, WP_Widget $widget )
```

Return `false` to prevent saving.

---

### widget_form_callback

Filters instance settings before form display.

```php
apply_filters( 'widget_form_callback', array $instance, WP_Widget $widget )
```

Return `false` to prevent form display.

---

### in_widget_form

Action fired at end of widget form.

```php
do_action_ref_array( 'in_widget_form', array( &$widget, &$return, $instance ) )
```

Use to add extra fields to any widget form.
