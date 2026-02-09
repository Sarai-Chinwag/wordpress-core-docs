# WP_Navigation_Fallback

Manages fallback behavior for Navigation menus in block themes.

**Since:** 6.3.0  
**File:** `wp-includes/class-wp-navigation-fallback.php`

## Overview

When a block theme uses the Navigation block without specifying a particular navigation menu, WordPress needs a fallback strategy to display something meaningful. `WP_Navigation_Fallback` handles this by:

1. Finding the most recently published navigation menu
2. Converting a classic menu if no block navigation exists
3. Creating a default navigation with a Page List block

## Class Definition

```php
class WP_Navigation_Fallback {
    public static function update_wp_navigation_post_schema( $schema );
    public static function get_fallback();
    private static function get_most_recently_published_navigation();
    private static function create_classic_menu_fallback();
    private static function get_fallback_classic_menu();
    private static function get_most_recently_created_nav_menu( $classic_nav_menus );
    private static function get_nav_menu_with_primary_slug( $classic_nav_menus );
    private static function get_nav_menu_at_primary_location();
    private static function create_default_fallback();
    private static function get_default_fallback_blocks();
}
```

## Public Methods

### get_fallback()

Gets (and/or creates) an appropriate fallback Navigation Menu.

```php
public static function get_fallback(): ?WP_Post
```

**Returns:** The fallback Navigation Post (`wp_navigation` CPT) or `null`.

**Fallback Priority:**
1. Most recently published `wp_navigation` post
2. Convert classic menu to block navigation (if no block nav exists)
3. Create default navigation with Page List block

**Example:**
```php
$fallback_nav = WP_Navigation_Fallback::get_fallback();

if ( $fallback_nav ) {
    echo do_blocks( $fallback_nav->post_content );
}
```

---

### update_wp_navigation_post_schema()

Updates the `wp_navigation` REST API schema to expose additional fields in embeddable links.

```php
public static function update_wp_navigation_post_schema( array $schema ): array
```

**Since:** 6.4.0

**Purpose:** The Navigation Fallback REST endpoint may embed the full Navigation Menu object. The editor requires additional fields beyond the default Posts Controller output.

**Exposed Fields:**
- `status` - Added to `embed` context
- `content` - Added to `embed` context
- `content.raw` - Added to `embed` context  
- `content.rendered` - Added to `embed` context
- `content.block_version` - Added to `embed` context
- `title.raw` - Added to `embed` context

**Hook Usage:**
```php
add_filter( 'rest_wp_navigation_item_schema', 
    array( 'WP_Navigation_Fallback', 'update_wp_navigation_post_schema' ) 
);
```

## Private Methods

### get_most_recently_published_navigation()

Finds the most recently published `wp_navigation` post.

```php
private static function get_most_recently_published_navigation(): ?WP_Post
```

**Query:**
- Post type: `wp_navigation`
- Status: `publish`
- Order: `DESC` by date
- Limit: 1

---

### create_classic_menu_fallback()

Creates a Navigation Menu post from an existing Classic Menu.

```php
private static function create_classic_menu_fallback(): int|WP_Error
```

**Process:**
1. Find best classic menu candidate
2. Convert using `WP_Classic_To_Block_Menu_Converter::convert()`
3. Insert as `wp_navigation` post

**Returns:** Post ID on success, `WP_Error` on failure.

---

### get_fallback_classic_menu()

Determines the most appropriate classic navigation menu to use as fallback.

```php
private static function get_fallback_classic_menu(): ?WP_Term
```

**Selection Priority:**
1. Menu assigned to `primary` location
2. Menu with slug `primary`
3. Most recently created menu

---

### get_nav_menu_at_primary_location()

Gets the classic menu assigned to the `primary` navigation menu location.

```php
private static function get_nav_menu_at_primary_location(): ?WP_Term
```

---

### get_nav_menu_with_primary_slug()

Returns the classic menu with the slug `primary`.

```php
private static function get_nav_menu_with_primary_slug( array $classic_nav_menus ): ?WP_Term
```

---

### get_most_recently_created_nav_menu()

Sorts classic menus and returns the most recently created one.

```php
private static function get_most_recently_created_nav_menu( array $classic_nav_menus ): WP_Term
```

---

### create_default_fallback()

Creates a default Navigation Block Menu with Page List.

```php
private static function create_default_fallback(): int|WP_Error
```

**Created Post:**
- Content: `<!-- wp:page-list /-->`
- Title: "Navigation"
- Slug: `navigation`
- Type: `wp_navigation`
- Status: `publish`

---

### get_default_fallback_blocks()

Gets the block markup for the default fallback.

```php
private static function get_default_fallback_blocks(): string
```

**Returns:** `<!-- wp:page-list /-->` if the Page List block is registered, empty string otherwise.

## Related Hook

### wp_navigation_should_create_fallback

Controls whether a fallback navigation should be created.

```php
apply_filters( 'wp_navigation_should_create_fallback', bool $create )
```

**Parameters:**
- `$create` - Whether to create a fallback (default `true`)

**Example:**
```php
// Prevent automatic navigation creation
add_filter( 'wp_navigation_should_create_fallback', '__return_false' );
```

## Usage Context

This class is primarily used by:

1. **Navigation Block** - When rendered without a `ref` attribute pointing to a specific `wp_navigation` post
2. **REST API** - Via `WP_REST_Navigation_Fallback_Controller` at `/wp/v2/navigation/fallback`
3. **Site Editor** - To provide a navigation when none exists

## Example: REST API Usage

```bash
# Get the fallback navigation menu
curl https://example.com/wp-json/wp/v2/navigation/fallback
```

Response includes the full navigation post with embedded content when available.

## Classic Menu Conversion

When converting classic menus, the class uses `WP_Classic_To_Block_Menu_Converter` to transform menu items into block markup:

```php
// Classic menu item becomes:
<!-- wp:navigation-link {"label":"Home","url":"https://example.com/"} /-->

// Submenu items become:
<!-- wp:navigation-submenu {"label":"Products","url":"https://example.com/products/"} -->
    <!-- wp:navigation-link {"label":"Widget","url":"https://example.com/products/widget/"} /-->
<!-- /wp:navigation-submenu -->
```
