# WP_List_Table API

`WP_List_Table` is the base class for displaying data in admin tables (posts, users, comments, etc.). While marked for internal use, it's widely used by plugin developers.

## Class Overview

**File:** `wp-admin/includes/class-wp-list-table.php`

The class provides:
- Pagination
- Bulk actions
- Column sorting
- Search functionality
- Screen options integration

## Creating a Custom List Table

### Step 1: Extend the Class

```php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class My_Custom_List_Table extends WP_List_Table {

    public function __construct() {
        parent::__construct( array(
            'singular' => 'item',     // Singular label
            'plural'   => 'items',    // Plural label
            'ajax'     => false,      // Enable AJAX
            'screen'   => null,       // Screen ID (auto-detected)
        ) );
    }
}
```

### Step 2: Define Columns

```php
public function get_columns() {
    return array(
        'cb'      => '<input type="checkbox" />',  // Checkbox column
        'title'   => __( 'Title' ),
        'author'  => __( 'Author' ),
        'date'    => __( 'Date' ),
        'status'  => __( 'Status' ),
    );
}
```

### Step 3: Define Sortable Columns

```php
protected function get_sortable_columns() {
    return array(
        'title' => array( 'title', false ),      // false = asc by default
        'date'  => array( 'date', true ),        // true = desc by default
    );
}
```

### Step 4: Prepare Items

```php
public function prepare_items() {
    // Set column headers
    $this->_column_headers = array(
        $this->get_columns(),
        array(),  // Hidden columns
        $this->get_sortable_columns(),
    );
    
    // Process bulk actions
    $this->process_bulk_action();
    
    // Get data
    $data = $this->get_data();
    
    // Handle sorting
    $orderby = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : 'title';
    $order   = isset( $_GET['order'] ) ? sanitize_key( $_GET['order'] ) : 'asc';
    
    usort( $data, function( $a, $b ) use ( $orderby, $order ) {
        $result = strcmp( $a[ $orderby ], $b[ $orderby ] );
        return ( $order === 'asc' ) ? $result : -$result;
    } );
    
    // Pagination
    $per_page     = $this->get_items_per_page( 'items_per_page', 20 );
    $current_page = $this->get_pagenum();
    $total_items  = count( $data );
    
    $this->items = array_slice( $data, ( $current_page - 1 ) * $per_page, $per_page );
    
    $this->set_pagination_args( array(
        'total_items' => $total_items,
        'per_page'    => $per_page,
        'total_pages' => ceil( $total_items / $per_page ),
    ) );
}
```

### Step 5: Display Column Content

```php
// Default column handler
protected function column_default( $item, $column_name ) {
    return isset( $item[ $column_name ] ) ? esc_html( $item[ $column_name ] ) : '';
}

// Checkbox column
protected function column_cb( $item ) {
    return sprintf(
        '<input type="checkbox" name="items[]" value="%d" />',
        absint( $item['id'] )
    );
}

// Title column with row actions
protected function column_title( $item ) {
    $actions = array(
        'edit'   => sprintf(
            '<a href="%s">%s</a>',
            admin_url( 'admin.php?page=my-page&action=edit&id=' . absint( $item['id'] ) ),
            __( 'Edit' )
        ),
        'delete' => sprintf(
            '<a href="%s" onclick="return confirm(\'Are you sure?\')">%s</a>',
            wp_nonce_url(
                admin_url( 'admin.php?page=my-page&action=delete&id=' . absint( $item['id'] ) ),
                'delete_item_' . $item['id']
            ),
            __( 'Delete' )
        ),
    );
    
    return sprintf(
        '<strong><a href="%s">%s</a></strong>%s',
        admin_url( 'admin.php?page=my-page&action=edit&id=' . absint( $item['id'] ) ),
        esc_html( $item['title'] ),
        $this->row_actions( $actions )
    );
}
```

### Step 6: Define Bulk Actions

```php
protected function get_bulk_actions() {
    return array(
        'delete' => __( 'Delete' ),
        'export' => __( 'Export' ),
    );
}

public function process_bulk_action() {
    if ( 'delete' === $this->current_action() ) {
        // Verify nonce
        check_admin_referer( 'bulk-items' );
        
        $items = isset( $_GET['items'] ) ? array_map( 'absint', $_GET['items'] ) : array();
        
        foreach ( $items as $item_id ) {
            // Delete item
            $this->delete_item( $item_id );
        }
    }
}
```

## Advanced Features

### Views/Filters

```php
protected function get_views() {
    $current = isset( $_GET['status'] ) ? sanitize_key( $_GET['status'] ) : 'all';
    
    $views = array(
        'all'       => sprintf(
            '<a href="%s" class="%s">%s <span class="count">(%d)</span></a>',
            admin_url( 'admin.php?page=my-page' ),
            $current === 'all' ? 'current' : '',
            __( 'All' ),
            $this->count_items()
        ),
        'published' => sprintf(
            '<a href="%s" class="%s">%s <span class="count">(%d)</span></a>',
            admin_url( 'admin.php?page=my-page&status=published' ),
            $current === 'published' ? 'current' : '',
            __( 'Published' ),
            $this->count_items( 'published' )
        ),
        'draft'     => sprintf(
            '<a href="%s" class="%s">%s <span class="count">(%d)</span></a>',
            admin_url( 'admin.php?page=my-page&status=draft' ),
            $current === 'draft' ? 'current' : '',
            __( 'Draft' ),
            $this->count_items( 'draft' )
        ),
    );
    
    return $views;
}
```

### Search Box

```php
// In prepare_items()
$search = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';

if ( ! empty( $search ) ) {
    $data = array_filter( $data, function( $item ) use ( $search ) {
        return stripos( $item['title'], $search ) !== false;
    } );
}
```

### Extra Table Navigation

```php
protected function extra_tablenav( $which ) {
    if ( $which === 'top' ) {
        ?>
        <div class="alignleft actions">
            <select name="filter_category">
                <option value="">All Categories</option>
                <option value="cat1">Category 1</option>
                <option value="cat2">Category 2</option>
            </select>
            <?php submit_button( __( 'Filter' ), '', 'filter_action', false ); ?>
        </div>
        <?php
    }
}
```

### No Items Message

```php
public function no_items() {
    _e( 'No items found.' );
}
```

## Display the Table

```php
add_action( 'admin_menu', 'register_my_list_page' );

function register_my_list_page() {
    $hook = add_menu_page(
        'My Items',
        'My Items',
        'manage_options',
        'my-items',
        'render_my_list_page'
    );
    
    // Add screen options
    add_action( "load-$hook", 'add_my_list_screen_options' );
}

function add_my_list_screen_options() {
    add_screen_option( 'per_page', array(
        'label'   => __( 'Items per page' ),
        'default' => 20,
        'option'  => 'items_per_page',
    ) );
    
    // Instantiate table (required for screen options)
    $GLOBALS['my_list_table'] = new My_Custom_List_Table();
}

function render_my_list_page() {
    $table = $GLOBALS['my_list_table'];
    $table->prepare_items();
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php _e( 'My Items' ); ?></h1>
        <a href="<?php echo admin_url( 'admin.php?page=my-items&action=new' ); ?>" class="page-title-action">
            <?php _e( 'Add New' ); ?>
        </a>
        <hr class="wp-header-end">
        
        <form method="get">
            <input type="hidden" name="page" value="my-items">
            <?php
            $table->views();
            $table->search_box( __( 'Search Items' ), 'search' );
            $table->display();
            ?>
        </form>
    </div>
    <?php
}
```

## Key Methods Reference

| Method | Description |
|--------|-------------|
| `get_columns()` | Define table columns |
| `get_sortable_columns()` | Define sortable columns |
| `prepare_items()` | Prepare data for display |
| `column_default()` | Default column output |
| `column_{name}()` | Custom output for specific column |
| `get_bulk_actions()` | Define bulk actions |
| `current_action()` | Get current bulk action |
| `process_bulk_action()` | Handle bulk action |
| `get_views()` | Define filter views |
| `extra_tablenav()` | Extra controls in tablenav |
| `row_actions()` | Display row actions |
| `display()` | Render the table |
| `search_box()` | Display search box |
| `get_pagenum()` | Current page number |
| `get_items_per_page()` | Items per page setting |
| `set_pagination_args()` | Set pagination parameters |

## Built-in List Table Classes

WordPress includes these specialized list tables:

- `WP_Posts_List_Table` - Posts/Pages
- `WP_Comments_List_Table` - Comments
- `WP_Users_List_Table` - Users
- `WP_Media_List_Table` - Media Library
- `WP_Terms_List_Table` - Categories/Tags
- `WP_Plugins_List_Table` - Plugins
- `WP_Themes_List_Table` - Themes
- `WP_Links_List_Table` - Links (deprecated)

Use `_get_list_table()` to get an instance:

```php
$table = _get_list_table( 'WP_Posts_List_Table' );
```

## Filters

| Filter | Description |
|--------|-------------|
| `manage_{screen_id}_columns` | Modify column headers |
| `manage_{post_type}_posts_columns` | Modify post type columns |
| `{post_type}_row_actions` | Modify row actions for post type |
| `list_table_primary_column` | Set primary column |
| `default_hidden_columns` | Set default hidden columns |
