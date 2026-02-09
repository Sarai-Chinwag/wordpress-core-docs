# Walker_Nav_Menu Class

The `Walker_Nav_Menu` class is responsible for rendering navigation menu HTML. It extends the base `Walker` class and traverses menu items hierarchically to generate properly nested list markup.

## Class Definition

```php
class Walker_Nav_Menu extends Walker {
    public $tree_type = array( 'post_type', 'taxonomy', 'custom' );
    
    public $db_fields = array(
        'parent' => 'menu_item_parent',
        'id'     => 'db_id',
    );
    
    private $privacy_policy_url;
}
```

**Location:** `wp-includes/class-walker-nav-menu.php`

**Since:** WordPress 3.0.0

## Properties

### $tree_type

```php
public $tree_type = array( 'post_type', 'taxonomy', 'custom' );
```

Defines what types of content this walker handles. Matches menu item types.

### $db_fields

```php
public $db_fields = array(
    'parent' => 'menu_item_parent',
    'id'     => 'db_id',
);
```

Maps walker fields to menu item properties:
- `parent` - Field containing parent item ID
- `id` - Field containing item's unique ID

### $privacy_policy_url

```php
private $privacy_policy_url;
```

Cached privacy policy URL. Set in constructor and used to add `rel="privacy-policy"` to privacy policy links.

## Methods

### __construct()

```php
public function __construct()
```

Constructor that initializes the privacy policy URL.

**Since:** WordPress 6.8.0

---

### start_lvl()

Opens a new sub-menu level.

```php
public function start_lvl( 
    string &$output, 
    int $depth = 0, 
    stdClass $args = null 
): void
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$output` | string | HTML output (by reference) |
| `$depth` | int | Nesting depth (0-based) |
| `$args` | stdClass | wp_nav_menu() arguments |

**Output:**

```html
<ul class="sub-menu">
```

**Filters Applied:**

- `nav_menu_submenu_css_class` - Modify sub-menu classes
- `nav_menu_submenu_attributes` - Modify sub-menu HTML attributes

**Example Override:**

```php
class Custom_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n{$indent}<ul class=\"dropdown-menu\">\n";
    }
}
```

---

### end_lvl()

Closes a sub-menu level.

```php
public function end_lvl( 
    string &$output, 
    int $depth = 0, 
    stdClass $args = null 
): void
```

**Output:**

```html
</ul>
```

---

### start_el()

Renders a menu item's opening tag and content.

```php
public function start_el( 
    string &$output, 
    WP_Post $data_object, 
    int $depth = 0, 
    stdClass $args = null, 
    int $current_object_id = 0 
): void
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$output` | string | HTML output (by reference) |
| `$data_object` | WP_Post | Menu item post object |
| `$depth` | int | Nesting depth (0-based) |
| `$args` | stdClass | wp_nav_menu() arguments |
| `$current_object_id` | int | Current item ID (optional) |

**Output Structure:**

```html
<li id="menu-item-123" class="menu-item menu-item-type-post_type ...">
    <a href="/page/" aria-current="page">Page Title</a>
```

**Filters Applied (in order):**

1. `nav_menu_item_args` - Modify args for this item
2. `nav_menu_css_class` - Modify item's CSS classes
3. `nav_menu_item_id` - Modify item's ID attribute
4. `nav_menu_item_attributes` - Modify `<li>` attributes
5. `the_title` - Filter the title
6. `nav_menu_item_title` - Filter title again (menu-specific)
7. `nav_menu_link_attributes` - Modify `<a>` attributes
8. `walker_nav_menu_start_el` - Modify entire item output

**Link Attributes Built:**

| Attribute | Source |
|-----------|--------|
| `href` | `$menu_item->url` |
| `target` | `$menu_item->target` |
| `rel` | `$menu_item->xfn` (+ `privacy-policy` if applicable) |
| `aria-current` | `'page'` if current item |
| `title` | `$menu_item->attr_title` (if different from title) |

**Example Override:**

```php
class Bootstrap_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $classes[] = 'dropdown';
        }
        
        $class_names = implode( ' ', array_filter( $classes ) );
        
        $output .= $indent . '<li class="' . esc_attr( $class_names ) . '">';
        
        $atts = array(
            'href'  => $item->url,
            'class' => 'nav-link',
        );
        
        if ( $item->current ) {
            $atts['class'] .= ' active';
            $atts['aria-current'] = 'page';
        }
        
        if ( in_array( 'menu-item-has-children', $item->classes ) && $depth === 0 ) {
            $atts['class'] .= ' dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
            $atts['aria-expanded'] = 'false';
        }
        
        $attributes = $this->build_atts( $atts );
        
        $output .= '<a' . $attributes . '>';
        $output .= $args->link_before . $item->title . $args->link_after;
        $output .= '</a>';
    }
}
```

---

### end_el()

Closes a menu item.

```php
public function end_el( 
    string &$output, 
    WP_Post $data_object, 
    int $depth = 0, 
    stdClass $args = null 
): void
```

**Output:**

```html
</li>
```

---

### build_atts()

Builds an HTML attribute string from an array.

```php
protected function build_atts( array $atts = array() ): string
```

**Parameters:**

- `$atts` - Associative array of attribute => value pairs

**Returns:** String like ` class="nav-link" href="/page/"`

**Behavior:**

- Empty strings and `false` values are ignored
- `href` values are passed through `esc_url()`
- Other values are passed through `esc_attr()`

**Since:** WordPress 6.3.0

**Example:**

```php
$atts = array(
    'href'  => 'https://example.com',
    'class' => 'nav-link',
    'title' => '',  // Will be ignored
);

$string = $this->build_atts( $atts );
// Returns: ' href="https://example.com" class="nav-link"'
```

---

## Default HTML Output

For a typical menu, the walker produces:

```html
<ul id="menu-main" class="menu">
    <li id="menu-item-10" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item menu-item-10">
        <a href="/about/" aria-current="page">About</a>
    </li>
    <li id="menu-item-11" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-11">
        <a href="/services/">Services</a>
        <ul class="sub-menu">
            <li id="menu-item-12" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12">
                <a href="/services/consulting/">Consulting</a>
            </li>
            <li id="menu-item-13" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-13">
                <a href="/services/development/">Development</a>
            </li>
        </ul>
    </li>
    <li id="menu-item-14" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-14">
        <a href="https://external.com" target="_blank" rel="noopener">External Link</a>
    </li>
</ul>
```

## Custom Walker Examples

### Mega Menu Walker

```php
class Mega_Menu_Walker extends Walker_Nav_Menu {
    
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '<div class="mega-menu"><div class="mega-menu-inner"><ul class="mega-menu-list">';
        } else {
            $output .= '<ul class="sub-menu">';
        }
    }
    
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '</ul></div></div>';
        } else {
            $output .= '</ul>';
        }
    }
    
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = array_filter( (array) $item->classes );
        
        if ( $depth === 0 && in_array( 'menu-item-has-children', $classes ) ) {
            $classes[] = 'has-mega-menu';
        }
        
        $output .= '<li class="' . implode( ' ', $classes ) . '">';
        
        // Add description for top-level items
        if ( $depth === 1 && $item->description ) {
            $output .= '<a href="' . esc_url( $item->url ) . '">';
            $output .= '<strong>' . $item->title . '</strong>';
            $output .= '<span class="description">' . $item->description . '</span>';
            $output .= '</a>';
        } else {
            $output .= '<a href="' . esc_url( $item->url ) . '">' . $item->title . '</a>';
        }
    }
}
```

### Accessible Mobile Walker

```php
class Accessible_Mobile_Walker extends Walker_Nav_Menu {
    
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = array_filter( (array) $item->classes );
        $has_children = in_array( 'menu-item-has-children', $classes );
        
        $output .= '<li class="' . implode( ' ', $classes ) . '">';
        
        if ( $has_children ) {
            // Button to toggle submenu
            $output .= '<div class="menu-item-link-wrapper">';
            $output .= '<a href="' . esc_url( $item->url ) . '">' . $item->title . '</a>';
            $output .= '<button class="submenu-toggle" aria-expanded="false" aria-label="' . 
                       sprintf( esc_attr__( 'Toggle submenu for %s' ), $item->title ) . '">';
            $output .= '<span class="toggle-icon"></span>';
            $output .= '</button>';
            $output .= '</div>';
        } else {
            $output .= '<a href="' . esc_url( $item->url ) . '">' . $item->title . '</a>';
        }
    }
    
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul class="sub-menu" aria-hidden="true">';
    }
}
```

### Icon Menu Walker

```php
class Icon_Menu_Walker extends Walker_Nav_Menu {
    
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = array_filter( (array) $item->classes );
        
        // Look for icon class (e.g., "icon-home")
        $icon_class = '';
        foreach ( $classes as $class ) {
            if ( strpos( $class, 'icon-' ) === 0 ) {
                $icon_class = $class;
                break;
            }
        }
        
        $output .= '<li class="' . implode( ' ', $classes ) . '">';
        $output .= '<a href="' . esc_url( $item->url ) . '">';
        
        if ( $icon_class ) {
            $output .= '<i class="' . esc_attr( $icon_class ) . '" aria-hidden="true"></i>';
        }
        
        $output .= '<span class="menu-text">' . $item->title . '</span>';
        $output .= '</a>';
    }
}
```

## Using Custom Walkers

```php
// In template
wp_nav_menu( array(
    'theme_location' => 'primary',
    'walker'         => new Bootstrap_Walker(),
) );

// With filter
add_filter( 'wp_nav_menu_args', function( $args ) {
    if ( $args['theme_location'] === 'primary' ) {
        $args['walker'] = new Custom_Walker();
    }
    return $args;
} );
```

## Performance Considerations

- Walker instances are reused across menu calls
- The `build_atts()` method efficiently handles attribute escaping
- Privacy policy URL is cached in constructor
- Item spacing (`preserve`/`discard`) affects output size

## Related Classes

- `Walker` - Base walker class (wp-includes/class-wp-walker.php)
- `Walker_Page` - Similar walker for wp_list_pages()
- `Walker_Category` - Walker for category lists
