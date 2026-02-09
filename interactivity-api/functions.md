# Interactivity API Functions

Global wrapper functions for the Interactivity API.

**Source:** `wp-includes/interactivity-api/interactivity-api.php`

---

## wp_interactivity()

Retrieves the main WP_Interactivity_API instance.

```php
function wp_interactivity(): WP_Interactivity_API
```

**Since:** 6.5.0

**Returns:** `WP_Interactivity_API` — The singleton instance.

**Example:**
```php
$api = wp_interactivity();
$state = $api->state( 'myPlugin' );
```

---

## wp_interactivity_process_directives()

Processes interactivity directives in HTML content.

```php
function wp_interactivity_process_directives( string $html ): string
```

**Since:** 6.5.0

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$html` | `string` | The HTML content to process |

**Returns:** `string` — Processed HTML. Returns original content if HTML has unbalanced tags.

**Example:**
```php
$html = '<div data-wp-interactive="myPlugin" data-wp-class--active="state.isActive">Content</div>';
$processed = wp_interactivity_process_directives( $html );
```

---

## wp_interactivity_state()

Gets and/or sets the initial state for a store namespace.

```php
function wp_interactivity_state( ?string $store_namespace = null, array $state = array() ): array
```

**Since:** 6.5.0  
**Since:** 6.6.0 — Namespace can be omitted inside derived state getters.

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$store_namespace` | `string\|null` | The unique store namespace identifier |
| `$state` | `array` | State to merge with existing state |

**Returns:** `array` — Current state for the namespace (updated if `$state` provided).

**Example:**
```php
// Set initial state
wp_interactivity_state( 'myPlugin', array(
    'isOpen' => false,
    'count'  => 0,
) );

// Get state
$state = wp_interactivity_state( 'myPlugin' );

// Derived state with closure
wp_interactivity_state( 'myPlugin', array(
    'doubleCount' => function() {
        $state = wp_interactivity_state();
        return $state['count'] * 2;
    },
) );
```

---

## wp_interactivity_config()

Gets and/or sets configuration for a store namespace.

```php
function wp_interactivity_config( string $store_namespace, array $config = array() ): array
```

**Since:** 6.5.0

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$store_namespace` | `string` | The unique store namespace identifier |
| `$config` | `array` | Config to merge with existing config |

**Returns:** `array` — Current config for the namespace (updated if `$config` provided).

**Example:**
```php
wp_interactivity_config( 'myPlugin', array(
    'apiEndpoint' => '/wp-json/my-plugin/v1/',
    'debug'       => WP_DEBUG,
) );
```

---

## wp_interactivity_data_wp_context()

Generates a `data-wp-context` directive attribute from an array.

```php
function wp_interactivity_data_wp_context( array $context, string $store_namespace = '' ): string
```

**Since:** 6.5.0

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$context` | `array` | The context data to encode |
| `$store_namespace` | `string` | Optional namespace identifier |

**Returns:** `string` — Complete `data-wp-context` attribute string.

**Example:**
```php
<div <?php echo wp_interactivity_data_wp_context( array( 
    'isOpen' => true, 
    'count'  => 0 
) ); ?>>
    <!-- outputs: data-wp-context='{"isOpen":true,"count":0}' -->
</div>

// With namespace
<div <?php echo wp_interactivity_data_wp_context( 
    array( 'id' => 123 ), 
    'myPlugin' 
); ?>>
    <!-- outputs: data-wp-context='myPlugin::{"id":123}' -->
</div>
```

---

## wp_interactivity_get_context()

Gets the current context for a namespace during directive processing.

```php
function wp_interactivity_get_context( ?string $store_namespace = null ): array
```

**Since:** 6.6.0

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$store_namespace` | `string\|null` | Namespace identifier. Uses current namespace if omitted. |

**Returns:** `array` — Context for the namespace. Empty array if namespace not defined.

**Note:** Only usable during `process_directives()` execution. Triggers `_doing_it_wrong` otherwise.

**Example:**
```php
// In derived state getter
wp_interactivity_state( 'myPlugin', array(
    'fullName' => function() {
        $context = wp_interactivity_get_context();
        return $context['firstName'] . ' ' . $context['lastName'];
    },
) );
```

---

## wp_interactivity_get_element()

Returns array representation of the current element being processed.

```php
function wp_interactivity_get_element(): ?array
```

**Since:** 6.7.0

**Returns:** `array{attributes: array<string, string|bool>}|null` — Current element with attributes, or null if not processing.

**Note:** Only usable during `process_directives()` execution.

**Example:**
```php
wp_interactivity_state( 'myPlugin', array(
    'hasClass' => function() {
        $element = wp_interactivity_get_element();
        $class = $element['attributes']['class'] ?? '';
        return str_contains( $class, 'featured' );
    },
) );
```
