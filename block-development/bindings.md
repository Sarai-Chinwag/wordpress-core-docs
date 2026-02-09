# Block Bindings

Block bindings connect block attributes to external data sources like post meta, site options, or custom sources.

## Overview

Block bindings allow:
- Displaying post meta in blocks
- Connecting blocks to site options
- Creating dynamic content without custom blocks
- Pattern-based templates with dynamic data

## Supported Blocks and Attributes

WordPress 6.5+ supports bindings on these core blocks:

| Block | Bindable Attributes |
|-------|---------------------|
| `core/paragraph` | `content` |
| `core/heading` | `content` |
| `core/image` | `url`, `alt`, `title` |
| `core/button` | `url`, `text`, `linkTarget`, `rel` |

## Using Bindings

### In Block Markup

Bindings are specified in the block's HTML comment:

```html
<!-- wp:paragraph {
    "metadata": {
        "bindings": {
            "content": {
                "source": "core/post-meta",
                "args": {
                    "key": "custom_excerpt"
                }
            }
        }
    }
} -->
<p></p>
<!-- /wp:paragraph -->
```

### In Patterns

Create patterns with bound blocks:

```php
register_block_pattern(
    'my-plugin/product-card',
    [
        'title'   => __( 'Product Card', 'my-plugin' ),
        'content' => '
            <!-- wp:group {"layout":{"type":"constrained"}} -->
            <div class="wp-block-group">
                <!-- wp:heading {
                    "metadata": {
                        "bindings": {
                            "content": {
                                "source": "core/post-meta",
                                "args": {"key": "product_name"}
                            }
                        }
                    }
                } -->
                <h2 class="wp-block-heading"></h2>
                <!-- /wp:heading -->
                
                <!-- wp:image {
                    "metadata": {
                        "bindings": {
                            "url": {
                                "source": "core/post-meta",
                                "args": {"key": "product_image_url"}
                            },
                            "alt": {
                                "source": "core/post-meta",
                                "args": {"key": "product_name"}
                            }
                        }
                    }
                } -->
                <figure class="wp-block-image"><img src="" alt=""/></figure>
                <!-- /wp:image -->
                
                <!-- wp:paragraph {
                    "metadata": {
                        "bindings": {
                            "content": {
                                "source": "core/post-meta",
                                "args": {"key": "product_description"}
                            }
                        }
                    }
                } -->
                <p></p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        ',
    ]
);
```

## Built-in Binding Sources

### core/post-meta

Bind to post meta fields:

```html
<!-- wp:paragraph {
    "metadata": {
        "bindings": {
            "content": {
                "source": "core/post-meta",
                "args": {
                    "key": "my_meta_key"
                }
            }
        }
    }
} -->
<p></p>
<!-- /wp:paragraph -->
```

**Requirements:**

The meta field must be registered with `show_in_rest`:

```php
register_post_meta( 'post', 'my_meta_key', [
    'type'         => 'string',
    'single'       => true,
    'show_in_rest' => true,
    'default'      => '',
] );
```

For images (URL from meta):

```php
register_post_meta( 'post', 'featured_video_thumbnail', [
    'type'         => 'string',
    'single'       => true,
    'show_in_rest' => true,
] );
```

```html
<!-- wp:image {
    "metadata": {
        "bindings": {
            "url": {
                "source": "core/post-meta",
                "args": {"key": "featured_video_thumbnail"}
            }
        }
    }
} -->
<figure class="wp-block-image"><img src="" alt=""/></figure>
<!-- /wp:image -->
```

## Custom Binding Sources

Register your own data sources:

```php
add_action( 'init', function() {
    register_block_bindings_source(
        'my-plugin/user-data',
        [
            'label'              => __( 'User Data', 'my-plugin' ),
            'get_value_callback' => 'my_plugin_get_user_binding_value',
            'uses_context'       => [ 'postId' ],
        ]
    );
} );

function my_plugin_get_user_binding_value( $source_args, $block_instance, $attribute_name ) {
    $field = $source_args['field'] ?? '';
    
    // Get current user or post author
    $user_id = get_current_user_id();
    if ( isset( $block_instance->context['postId'] ) ) {
        $user_id = get_post_field( 'post_author', $block_instance->context['postId'] );
    }
    
    if ( ! $user_id ) {
        return null;
    }
    
    $user = get_userdata( $user_id );
    
    switch ( $field ) {
        case 'display_name':
            return $user->display_name;
        case 'email':
            return $user->user_email;
        case 'bio':
            return $user->description;
        case 'avatar_url':
            return get_avatar_url( $user_id );
        default:
            return null;
    }
}
```

Using the custom source:

```html
<!-- wp:paragraph {
    "metadata": {
        "bindings": {
            "content": {
                "source": "my-plugin/user-data",
                "args": {
                    "field": "display_name"
                }
            }
        }
    }
} -->
<p></p>
<!-- /wp:paragraph -->
```

### Source Registration Options

```php
register_block_bindings_source(
    'my-plugin/custom-source',
    [
        // Display name in editor
        'label' => __( 'Custom Source', 'my-plugin' ),
        
        // Callback to get value
        'get_value_callback' => 'my_callback',
        
        // Context values needed
        'uses_context' => [ 'postId', 'postType' ],
    ]
);
```

### Callback Parameters

```php
function my_binding_callback( $source_args, $block_instance, $attribute_name ) {
    // $source_args - Arguments from the binding (e.g., {"key": "my_field"})
    // $block_instance - WP_Block instance
    // $attribute_name - Which attribute is being bound (e.g., "content", "url")
    
    // Access block context
    $post_id = $block_instance->context['postId'] ?? null;
    
    // Return the value for this attribute
    return 'bound value';
}
```

## Site Option Binding

Create a binding source for site options:

```php
register_block_bindings_source(
    'my-plugin/site-option',
    [
        'label'              => __( 'Site Option', 'my-plugin' ),
        'get_value_callback' => function( $source_args ) {
            $option_name = $source_args['option'] ?? '';
            
            if ( ! $option_name ) {
                return null;
            }
            
            // Whitelist allowed options for security
            $allowed_options = [
                'blogname',
                'blogdescription',
                'admin_email',
                'my_plugin_custom_option',
            ];
            
            if ( ! in_array( $option_name, $allowed_options, true ) ) {
                return null;
            }
            
            return get_option( $option_name );
        },
    ]
);
```

## Computed Bindings

Create bindings that compute values:

```php
register_block_bindings_source(
    'my-plugin/computed',
    [
        'label'              => __( 'Computed Value', 'my-plugin' ),
        'uses_context'       => [ 'postId' ],
        'get_value_callback' => function( $source_args, $block_instance ) {
            $compute = $source_args['compute'] ?? '';
            $post_id = $block_instance->context['postId'] ?? get_the_ID();
            
            switch ( $compute ) {
                case 'reading_time':
                    $content = get_post_field( 'post_content', $post_id );
                    $word_count = str_word_count( wp_strip_all_tags( $content ) );
                    $minutes = ceil( $word_count / 200 );
                    return sprintf( _n( '%d min read', '%d min read', $minutes, 'my-plugin' ), $minutes );
                    
                case 'word_count':
                    $content = get_post_field( 'post_content', $post_id );
                    return number_format( str_word_count( wp_strip_all_tags( $content ) ) );
                    
                case 'comment_count':
                    return get_comments_number( $post_id );
                    
                default:
                    return null;
            }
        },
    ]
);
```

```html
<!-- wp:paragraph {
    "metadata": {
        "bindings": {
            "content": {
                "source": "my-plugin/computed",
                "args": {"compute": "reading_time"}
            }
        }
    }
} -->
<p></p>
<!-- /wp:paragraph -->
```

## Editor Integration

### JavaScript Source Registration (Experimental)

For editor-side binding support:

```js
import { registerBlockBindingsSource } from '@wordpress/blocks';

registerBlockBindingsSource( {
    name: 'my-plugin/js-source',
    label: 'JavaScript Source',
    getValues( { bindings } ) {
        const values = {};
        
        for ( const [ attributeName, binding ] of Object.entries( bindings ) ) {
            // Return value for each bound attribute
            values[ attributeName ] = `Value for ${ binding.args?.key }`;
        }
        
        return values;
    },
    setValues( { bindings, dispatch } ) {
        // Handle saving values back (if supported)
    },
    canUserEditValue( { binding } ) {
        // Can this binding be edited in the editor?
        return true;
    },
} );
```

## Complete Example: Product Block Bindings

### Register Meta Fields

```php
add_action( 'init', function() {
    $product_meta = [
        'product_name'        => [ 'type' => 'string' ],
        'product_price'       => [ 'type' => 'number' ],
        'product_description' => [ 'type' => 'string' ],
        'product_image_url'   => [ 'type' => 'string' ],
        'product_buy_url'     => [ 'type' => 'string' ],
    ];
    
    foreach ( $product_meta as $key => $args ) {
        register_post_meta( 'product', $key, [
            'type'         => $args['type'],
            'single'       => true,
            'show_in_rest' => true,
        ] );
    }
} );
```

### Custom Binding for Formatted Price

```php
register_block_bindings_source(
    'my-plugin/product',
    [
        'label'              => __( 'Product Data', 'my-plugin' ),
        'uses_context'       => [ 'postId' ],
        'get_value_callback' => function( $source_args, $block_instance ) {
            $field = $source_args['field'] ?? '';
            $post_id = $block_instance->context['postId'] ?? get_the_ID();
            
            if ( get_post_type( $post_id ) !== 'product' ) {
                return null;
            }
            
            switch ( $field ) {
                case 'formatted_price':
                    $price = get_post_meta( $post_id, 'product_price', true );
                    return $price ? '$' . number_format( $price, 2 ) : null;
                    
                case 'availability':
                    $stock = get_post_meta( $post_id, 'product_stock', true );
                    return $stock > 0 ? __( 'In Stock', 'my-plugin' ) : __( 'Out of Stock', 'my-plugin' );
                    
                default:
                    return null;
            }
        },
    ]
);
```

### Pattern Using Bindings

```php
register_block_pattern(
    'my-plugin/product-card',
    [
        'title'      => __( 'Product Card', 'my-plugin' ),
        'categories' => [ 'my-plugin-products' ],
        'content'    => '
<!-- wp:group {"className":"product-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group product-card">

    <!-- wp:image {
        "className":"product-image",
        "metadata":{
            "bindings":{
                "url":{"source":"core/post-meta","args":{"key":"product_image_url"}},
                "alt":{"source":"core/post-meta","args":{"key":"product_name"}}
            }
        }
    } -->
    <figure class="wp-block-image product-image"><img src="" alt=""/></figure>
    <!-- /wp:image -->

    <!-- wp:heading {
        "level":3,
        "metadata":{
            "bindings":{
                "content":{"source":"core/post-meta","args":{"key":"product_name"}}
            }
        }
    } -->
    <h3 class="wp-block-heading"></h3>
    <!-- /wp:heading -->

    <!-- wp:paragraph {
        "className":"product-price",
        "metadata":{
            "bindings":{
                "content":{"source":"my-plugin/product","args":{"field":"formatted_price"}}
            }
        }
    } -->
    <p class="product-price"></p>
    <!-- /wp:paragraph -->

    <!-- wp:paragraph {
        "metadata":{
            "bindings":{
                "content":{"source":"core/post-meta","args":{"key":"product_description"}}
            }
        }
    } -->
    <p></p>
    <!-- /wp:paragraph -->

    <!-- wp:button {
        "metadata":{
            "bindings":{
                "url":{"source":"core/post-meta","args":{"key":"product_buy_url"}},
                "text":{"source":"my-plugin/product","args":{"field":"availability"}}
            }
        }
    } -->
    <div class="wp-block-button"><a class="wp-block-button__link wp-element-button"></a></div>
    <!-- /wp:button -->

</div>
<!-- /wp:group -->
        ',
    ]
);
```

## Security Considerations

1. **Whitelist accessible data:** Don't expose sensitive meta or options.

2. **Validate source args:** Check that requested fields are allowed.

3. **Escape output:** Values are auto-escaped, but be careful with HTML.

4. **Consider user permissions:** Some data may be user-specific.

```php
function secure_binding_callback( $source_args, $block_instance ) {
    $allowed_keys = [ 'public_field', 'display_name' ];
    $key = $source_args['key'] ?? '';
    
    if ( ! in_array( $key, $allowed_keys, true ) ) {
        return null; // Don't expose unauthorized data
    }
    
    return get_post_meta( $post_id, $key, true );
}
```

## Best Practices

1. **Register meta properly:** Always use `show_in_rest => true`.

2. **Provide fallbacks:** Handle missing data gracefully.

3. **Use context:** Access postId from block context when available.

4. **Document your sources:** Help users understand available bindings.

5. **Consider caching:** Cache expensive computations.

6. **Test in editor:** Verify bindings work in the block editor.

7. **Security first:** Never expose sensitive data through bindings.
