# class-wp-list-table.php

## Overview

Admin include file from WordPress core. This doc summarizes the public-facing classes and functions developers typically interact with.

## Classes

- `WP_List_Table` — Administration API: WP_List_Table class

### Developer Usage

`WP_List_Table` is the base class for custom admin tables. Extend it and implement `get_columns()`, `prepare_items()`, and column renderers. Load it with:

```php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
```
