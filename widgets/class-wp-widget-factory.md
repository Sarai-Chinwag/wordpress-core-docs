# WP_Widget_Factory

Singleton that registers and manages WP_Widget classes.

**Source:** `wp-includes/class-wp-widget-factory.php`  
**Since:** 2.8.0  
**Global:** `$wp_widget_factory`

## Class Synopsis

```php
#[AllowDynamicProperties]
class WP_Widget_Factory {
    // Properties
    public $widgets = array();

    // Constructor
    public function __construct();

    // Methods
    public function register( string|WP_Widget $widget );
    public function unregister( string|WP_Widget $widget );
    public function _register_widgets();
    public function get_widget_object( string $id_base ): ?WP_Widget;
    public function get_widget_key( string $id_base ): string;
}
```

## Properties

### $widgets

Array of registered widget objects, keyed by class name or object hash.

```php
public array $widgets = array();
```

**Structure:**
```php
array(
    'WP_Widget_Text'    => WP_Widget_Text object,
    'WP_Widget_Search'  => WP_Widget_Search object,
    'a1b2c3d4e5f6...'   => My_Widget object (when registered by instance),
)
```

## Constructor

### __construct()

Initializes the factory and hooks widget registration.

```php
public function __construct()
```

Adds `_register_widgets()` to the `widgets_init` action at priority 100.

**Since:** 4.3.0

## Methods

### register()

Registers a widget subclass with the factory.

```php
public function register( string|WP_Widget $widget ): void
```

**Parameters:**
- `$widget` - Class name of a `WP_Widget` subclass, or an instance

**Since:** 2.8.0, 4.6.0 (accepts instance)

```php
global $wp_widget_factory;

// Register by class name (most common)
$wp_widget_factory->register( 'My_Custom_Widget' );

// Register by instance (useful for dependency injection)
$widget = new My_Custom_Widget( $some_dependency );
$wp_widget_factory->register( $widget );
```

**Notes:**
- When registering by class name, the class is instantiated immediately
- When registering by instance, the object is stored using `spl_object_hash()` as key

---

### unregister()

Removes a widget subclass from the factory.

```php
public function unregister( string|WP_Widget $widget ): void
```

**Parameters:**
- `$widget` - Class name of a `WP_Widget` subclass, or an instance

**Since:** 2.8.0, 4.6.0 (accepts instance)

```php
global $wp_widget_factory;

// Unregister by class name
$wp_widget_factory->unregister( 'WP_Widget_Meta' );

// Unregister by instance
$wp_widget_factory->unregister( $widget_instance );
```

---

### _register_widgets()

Internal method that registers all widget instances with WordPress.

```php
public function _register_widgets(): void
```

**Called by:** `widgets_init` action at priority 100

**Process:**
1. Gets all keys from `$this->widgets`
2. Gets all already-registered widget id_bases
3. For each widget:
   - Skips if id_base already registered (prevents duplicates)
   - Calls `WP_Widget::_register()` on the widget

**Since:** 2.8.0

---

### get_widget_object()

Retrieves a registered WP_Widget object by its id_base.

```php
public function get_widget_object( string $id_base ): ?WP_Widget
```

**Parameters:**
- `$id_base` - Widget type ID (e.g., `'text'`, `'search'`)

**Returns:** `WP_Widget` object or `null` if not found

**Since:** 5.8.0

```php
global $wp_widget_factory;

$text_widget = $wp_widget_factory->get_widget_object( 'text' );
if ( $text_widget ) {
    echo $text_widget->name; // 'Text'
}
```

---

### get_widget_key()

Retrieves the internal key for a widget type.

```php
public function get_widget_key( string $id_base ): string
```

**Parameters:**
- `$id_base` - Widget type ID

**Returns:** Internal key (class name or object hash), or empty string if not found

**Since:** 5.8.0

```php
global $wp_widget_factory;

$key = $wp_widget_factory->get_widget_key( 'text' );
// 'WP_Widget_Text'
```

## Usage Examples

### Accessing the Factory

```php
// Via global
global $wp_widget_factory;

// Check registered widgets
foreach ( $wp_widget_factory->widgets as $class => $widget ) {
    echo $widget->name . ': ' . $widget->id_base . "\n";
}
```

### Custom Widget Registration Workflow

```php
// In a plugin, register a widget with dependencies
add_action( 'widgets_init', function() {
    global $wp_widget_factory;
    
    // Create widget with injected dependency
    $api_client = new My_API_Client( API_KEY );
    $widget = new API_Widget( $api_client );
    
    $wp_widget_factory->register( $widget );
}, 10 );
```

### Checking if Widget Type Exists

```php
function is_widget_type_registered( $id_base ) {
    global $wp_widget_factory;
    return null !== $wp_widget_factory->get_widget_object( $id_base );
}

if ( is_widget_type_registered( 'custom_widget' ) ) {
    // Widget type exists
}
```

### Replacing a Core Widget

```php
add_action( 'widgets_init', function() {
    // Unregister the core search widget
    unregister_widget( 'WP_Widget_Search' );
    
    // Register custom replacement
    register_widget( 'My_Enhanced_Search_Widget' );
}, 20 );  // Priority 20 to run after core widgets are registered
```

## Relationship with register_widget()

The `register_widget()` and `unregister_widget()` functions are wrappers around the factory:

```php
function register_widget( $widget ) {
    global $wp_widget_factory;
    $wp_widget_factory->register( $widget );
}

function unregister_widget( $widget ) {
    global $wp_widget_factory;
    $wp_widget_factory->unregister( $widget );
}
```

## Registration Timing

The factory's `_register_widgets()` method runs at `widgets_init` priority 100:

```
widgets_init priority 1-99:   Theme/plugin widget registrations
widgets_init priority 100:    WP_Widget_Factory::_register_widgets()
                              └── Each widget's _register() called
                              └── wp_register_sidebar_widget()
                              └── _register_widget_update_callback()
                              └── _register_widget_form_callback()
```

This means you should use priorities < 100 for `register_widget()` calls.

## Deprecated Methods

### WP_Widget_Factory()

PHP4-style constructor, deprecated since 4.3.0.

```php
public function WP_Widget_Factory()  // @deprecated
```

Use `__construct()` instead.
