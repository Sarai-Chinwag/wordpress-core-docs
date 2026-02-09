# Utility Hooks

Actions and filters for WordPress utility classes.

---

## Session Token Hooks

### session_token_manager

Filters the session token manager class.

```php
apply_filters( 'session_token_manager', string $manager )
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$manager` | string | `'WP_User_Meta_Session_Tokens'` | Class name for session management |

**Returns:** Class name implementing `WP_Session_Tokens`.

**Example:**

```php
add_filter( 'session_token_manager', function( $manager ) {
    return 'Redis_Session_Tokens';
} );
```

---

### attach_session_information

Filters information attached to new sessions.

```php
apply_filters( 'attach_session_information', array $session, int $user_id )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$session` | array | Session data array |
| `$user_id` | int | User ID |

**Returns:** Modified session data array.

**Default Session Data:**
- `expiration` — Expiration timestamp
- `ip` — Client IP address
- `ua` — User agent
- `login` — Login timestamp

**Example:**

```php
add_filter( 'attach_session_information', function( $session, $user_id ) {
    // Track login location
    $session['country'] = geoip_country_code();
    
    // Track device type
    $session['device'] = wp_is_mobile() ? 'mobile' : 'desktop';
    
    return $session;
}, 10, 2 );
```

---

## Duotone Hooks

### No public filters

`WP_Duotone` is primarily an internal class. Duotone presets are configured via `theme.json`:

```json
{
    "settings": {
        "color": {
            "duotone": [
                {
                    "slug": "custom-duo",
                    "colors": ["#000", "#fff"],
                    "name": "Custom Duotone"
                }
            ]
        }
    }
}
```

Block support is added via `block.json`:

```json
{
    "supports": {
        "filter": {
            "duotone": true
        }
    }
}
```

---

## Speculative Loading Hooks

### wp_speculation_rules_configuration

Filters the speculation rules configuration.

```php
apply_filters( 'wp_speculation_rules_configuration', ?array $config )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$config` | array\|null | Configuration with `mode` and `eagerness` keys, or `null` to disable |

**Returns:** Modified configuration or `null`.

**Configuration Values:**

| Key | Values | Description |
|-----|--------|-------------|
| `mode` | `'prefetch'`, `'prerender'`, `'auto'` | Speculation mode |
| `eagerness` | `'conservative'`, `'moderate'`, `'eager'`, `'auto'` | Loading eagerness |

**Example — Force prerender:**

```php
add_filter( 'wp_speculation_rules_configuration', function( $config ) {
    if ( null === $config ) {
        return null;
    }
    return array(
        'mode'      => 'prerender',
        'eagerness' => 'moderate',
    );
} );
```

**Example — Disable on specific conditions:**

```php
add_filter( 'wp_speculation_rules_configuration', function( $config ) {
    // Disable for WooCommerce checkout
    if ( function_exists( 'is_checkout' ) && is_checkout() ) {
        return null;
    }
    
    // Disable for logged-in users (default behavior)
    if ( is_user_logged_in() ) {
        return null;
    }
    
    return $config;
} );
```

---

### wp_speculation_rules_href_exclude_paths

Filters paths excluded from speculative loading.

```php
apply_filters( 'wp_speculation_rules_href_exclude_paths', array $paths, string $mode )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$paths` | array | Additional paths to exclude |
| `$mode` | string | Current mode (`'prefetch'` or `'prerender'`) |

**Returns:** Array of path patterns to exclude.

**Path Pattern Syntax:**
- Start with `/`
- Use `*` as wildcard
- Automatically prefixed for subdirectory installs

**Base Exclusions (cannot be removed):**
- `/wp-*.php`
- `/wp-admin/*`
- `/wp-content/uploads/*`
- `/wp-content/*`
- `/wp-content/plugins/*`
- Theme directories

**Example:**

```php
add_filter( 'wp_speculation_rules_href_exclude_paths', function( $paths, $mode ) {
    // Exclude dynamic pages
    $paths[] = '/cart/*';
    $paths[] = '/checkout/*';
    $paths[] = '/my-account/*';
    
    // Exclude pages with side effects
    $paths[] = '/*logout*';
    $paths[] = '/*action=*';
    
    // Mode-specific exclusions
    if ( 'prerender' === $mode ) {
        // Don't prerender heavy pages
        $paths[] = '/video/*';
    }
    
    return $paths;
}, 10, 2 );
```

---

### wp_load_speculation_rules

Fires when speculation rules are loaded, allowing custom rules.

```php
do_action( 'wp_load_speculation_rules', WP_Speculation_Rules $speculation_rules )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$speculation_rules` | WP_Speculation_Rules | Rules object to modify |

**Example — Add priority prefetch:**

```php
add_action( 'wp_load_speculation_rules', function( WP_Speculation_Rules $rules ) {
    // Eagerly prefetch product pages
    $rules->add_rule( 'prefetch', 'priority-products', array(
        'source'    => 'document',
        'where'     => array(
            'href_matches' => '/products/*',
        ),
        'eagerness' => 'eager',
    ) );
} );
```

**Example — Add list-based rule:**

```php
add_action( 'wp_load_speculation_rules', function( WP_Speculation_Rules $rules ) {
    // Prerender specific URLs
    $rules->add_rule( 'prerender', 'featured-pages', array(
        'source' => 'list',
        'urls'   => array(
            '/about/',
            '/contact/',
            '/pricing/',
        ),
    ) );
} );
```

---

## Usage Patterns

### WooCommerce Integration

```php
// Exclude dynamic WooCommerce pages
add_filter( 'wp_speculation_rules_href_exclude_paths', function( $paths ) {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return $paths;
    }
    
    $paths[] = '/' . get_option( 'woocommerce_cart_page_id' ) . '/*';
    $paths[] = '/' . get_option( 'woocommerce_checkout_page_id' ) . '/*';
    $paths[] = '/' . get_option( 'woocommerce_myaccount_page_id' ) . '/*';
    
    // Exclude all add-to-cart links
    $paths[] = '/*add-to-cart=*';
    
    return $paths;
} );

// Or disable entirely on WooCommerce pages
add_filter( 'wp_speculation_rules_configuration', function( $config ) {
    if ( is_woocommerce() || is_cart() || is_checkout() ) {
        return null;
    }
    return $config;
} );
```

### Membership Site

```php
// Enable speculative loading for members viewing public content
add_filter( 'wp_speculation_rules_configuration', function( $config ) {
    // Keep enabled for public pages even when logged in
    if ( ! is_singular( 'premium_content' ) ) {
        return array(
            'mode'      => 'prefetch',
            'eagerness' => 'conservative',
        );
    }
    return null; // Disable for premium content
} );
```
