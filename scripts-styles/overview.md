# Scripts & Styles API

System for registering, enqueueing, and outputting JavaScript and CSS assets in WordPress.

**Since:** 2.1.0 (scripts), 2.6.0 (styles)  
**Source:** `wp-includes/script-loader.php`, `wp-includes/functions.wp-scripts.php`, `wp-includes/functions.wp-styles.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core enqueue/register functions |
| [class-wp-scripts.md](./class-wp-scripts.md) | Script dependency manager |
| [class-wp-styles.md](./class-wp-styles.md) | Style dependency manager |
| [class-wp-dependencies.md](./class-wp-dependencies.md) | Base dependency class |
| [hooks.md](./hooks.md) | Actions and filters |

## Architecture

```
WP_Dependencies (base class)
    ├── WP_Scripts (JavaScript)
    │       └── _WP_Dependency (individual script)
    └── WP_Styles (CSS)
            └── _WP_Dependency (individual stylesheet)
```

## Registration Flow

```
wp_register_script() / wp_register_style()
    └── WP_Dependencies::add()
            └── new _WP_Dependency()
                    └── stored in $registered array
```

## Enqueue Flow

```
wp_enqueue_script() / wp_enqueue_style()
    ├── wp_register_*() (if src provided)
    └── WP_Dependencies::enqueue()
            └── added to $queue array
```

## Output Flow

```
wp_head / wp_footer
    └── wp_print_scripts() / wp_print_styles()
            └── WP_Dependencies::do_items()
                    ├── all_deps() — resolve dependency tree
                    └── do_item() — output each asset
                            └── apply_filters('script_loader_tag' / 'style_loader_tag')
```

## Script Loading Strategies (6.3.0+)

Scripts support delayed loading strategies:

| Strategy | Behavior |
|----------|----------|
| `defer` | Execute after parsing, maintain order |
| `async` | Execute when available, no order guarantee |

```php
wp_register_script( 'my-script', $src, array(), '1.0', array(
    'strategy'  => 'defer',
    'in_footer' => true,
) );
```

## Concatenation & Compression

Admin scripts/styles can be concatenated and compressed:

| Constant | Default | Description |
|----------|---------|-------------|
| `SCRIPT_DEBUG` | false | Load unminified versions |
| `CONCATENATE_SCRIPTS` | true | Combine scripts in admin |
| `COMPRESS_SCRIPTS` | true | Gzip compress scripts |
| `COMPRESS_CSS` | true | Gzip compress styles |

## Groups (Header vs Footer)

Scripts can be placed in header (group 0) or footer (group 1):

```php
// Footer placement via args
wp_enqueue_script( 'my-script', $src, array(), '1.0', true );
wp_enqueue_script( 'my-script', $src, array(), '1.0', array( 'in_footer' => true ) );
```

## RTL Support

Styles support automatic RTL switching:

```php
wp_register_style( 'my-style', 'my-style.css' );
wp_style_add_data( 'my-style', 'rtl', 'replace' ); // Load my-style-rtl.css in RTL
```

## Localization

Pass PHP data to JavaScript:

```php
wp_localize_script( 'my-script', 'myData', array(
    'ajaxUrl' => admin_url( 'admin-ajax.php' ),
    'nonce'   => wp_create_nonce( 'my-nonce' ),
) );
```

## Inline Scripts/Styles

Add inline code attached to registered assets:

```php
wp_add_inline_script( 'my-script', 'console.log("loaded");', 'after' );
wp_add_inline_style( 'my-style', '.custom { color: red; }' );
```

## Translation Support (5.0.0+)

Load script translations from JSON files:

```php
wp_set_script_translations( 'my-script', 'my-textdomain', plugin_dir_path( __FILE__ ) . 'languages' );
```
