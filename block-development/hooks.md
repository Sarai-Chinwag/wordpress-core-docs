# Block Hooks (Hooked Blocks)

Block hooks automatically insert blocks at specified positions relative to other blocks, without modifying templates directly.

## Basic Usage

In block.json:

```json
{
    "name": "my-plugin/newsletter-signup",
    "blockHooks": {
        "core/post-content": "after"
    }
}
```

This automatically inserts the newsletter signup block after every post content block.

## Hook Positions

| Position | Description |
|----------|-------------|
| `before` | Insert before the target block |
| `after` | Insert after the target block |
| `firstChild` | Insert as first child inside target |
| `lastChild` | Insert as last child inside target |

## Multiple Hooks

Hook to multiple blocks:

```json
{
    "blockHooks": {
        "core/post-content": "after",
        "core/post-excerpt": "after",
        "core/query": "lastChild"
    }
}
```

## Hook Examples

### After Post Content

```json
{
    "name": "my-plugin/share-buttons",
    "blockHooks": {
        "core/post-content": "after"
    }
}
```

### Before Navigation

```json
{
    "name": "my-plugin/announcement-bar",
    "blockHooks": {
        "core/navigation": "before"
    }
}
```

### Inside Header (First Child)

```json
{
    "name": "my-plugin/site-notice",
    "blockHooks": {
        "core/group": "firstChild"
    }
}
```

Note: `firstChild` and `lastChild` require the target block to have InnerBlocks support.

### Inside Footer (Last Child)

```json
{
    "name": "my-plugin/back-to-top",
    "blockHooks": {
        "core/template-part": "lastChild"
    }
}
```

## Conditional Hooks with PHP

Use the `hooked_block_types` filter for conditional insertion:

```php
add_filter( 'hooked_block_types', function( $hooked_blocks, $position, $anchor_block, $context ) {
    // Only add to single posts
    if ( is_singular( 'post' ) && 'core/post-content' === $anchor_block && 'after' === $position ) {
        $hooked_blocks[] = 'my-plugin/related-posts';
    }
    
    return $hooked_blocks;
}, 10, 4 );
```

### Context-Aware Hooks

```php
add_filter( 'hooked_block_types', function( $hooked_blocks, $position, $anchor_block, $context ) {
    // $context is a WP_Block_Template or WP_Post object
    
    // Only in specific templates
    if ( $context instanceof WP_Block_Template ) {
        if ( 'single' === $context->slug && 'after' === $position && 'core/post-content' === $anchor_block ) {
            $hooked_blocks[] = 'my-plugin/author-bio';
        }
    }
    
    return $hooked_blocks;
}, 10, 4 );
```

### Remove Default Hooks

```php
add_filter( 'hooked_block_types', function( $hooked_blocks, $position, $anchor_block, $context ) {
    // Remove a hooked block
    if ( 'core/post-content' === $anchor_block && 'after' === $position ) {
        $key = array_search( 'my-plugin/newsletter', $hooked_blocks, true );
        if ( false !== $key ) {
            unset( $hooked_blocks[ $key ] );
        }
    }
    
    return $hooked_blocks;
}, 10, 4 );
```

## Modifying Hooked Block Attributes

Use the `hooked_block_{block_name}` filter:

```php
add_filter( 'hooked_block_my-plugin/newsletter-signup', function( $parsed_hooked_block, $hooked_block_type, $relative_position, $parsed_anchor_block ) {
    // Modify attributes based on anchor block
    if ( 'core/post-content' === $parsed_anchor_block['blockName'] ) {
        $parsed_hooked_block['attrs']['variant'] = 'inline';
    }
    
    return $parsed_hooked_block;
}, 10, 4 );
```

### Dynamic Attributes

```php
add_filter( 'hooked_block_my-plugin/share-buttons', function( $parsed_hooked_block ) {
    // Add current post URL
    $parsed_hooked_block['attrs']['shareUrl'] = get_permalink();
    $parsed_hooked_block['attrs']['shareTitle'] = get_the_title();
    
    return $parsed_hooked_block;
} );
```

## User Control Over Hooked Blocks

Users can remove hooked blocks from the Site Editor:

1. Open Site Editor → Templates
2. Edit the template
3. Select the hooked block
4. Delete it

Once removed, WordPress stores this preference and won't auto-insert again.

### Detecting User Modifications

```php
add_filter( 'hooked_block_types', function( $hooked_blocks, $position, $anchor_block, $context ) {
    // Check if user has modified this template
    if ( $context instanceof WP_Block_Template && $context->wp_id ) {
        // Template has been customized, respect user's changes
        // The block will only appear if not explicitly removed
    }
    
    return $hooked_blocks;
}, 10, 4 );
```

## Complete Example: Related Posts Block

### block.json

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "my-plugin/related-posts",
    "title": "Related Posts",
    "category": "widgets",
    "attributes": {
        "numberOfPosts": {
            "type": "number",
            "default": 3
        },
        "showThumbnails": {
            "type": "boolean",
            "default": true
        }
    },
    "blockHooks": {
        "core/post-content": "after"
    },
    "supports": {
        "align": [ "wide", "full" ],
        "spacing": {
            "margin": true,
            "padding": true
        }
    },
    "editorScript": "file:./index.js",
    "style": "file:./style.css",
    "render": "file:./render.php"
}
```

### Conditional Registration

```php
// Only hook on single posts
add_filter( 'hooked_block_types', function( $hooked_blocks, $position, $anchor_block, $context ) {
    if ( 'core/post-content' !== $anchor_block || 'after' !== $position ) {
        return $hooked_blocks;
    }
    
    // Remove from our block.json default
    $key = array_search( 'my-plugin/related-posts', $hooked_blocks, true );
    if ( false !== $key ) {
        unset( $hooked_blocks[ $key ] );
    }
    
    // Only add on single posts
    if ( is_singular( 'post' ) ) {
        $hooked_blocks[] = 'my-plugin/related-posts';
    }
    
    return $hooked_blocks;
}, 10, 4 );
```

### render.php

```php
<?php
// Don't render if not on a single post
if ( ! is_singular( 'post' ) ) {
    return '';
}

$current_post_id = get_the_ID();
$number_of_posts = $attributes['numberOfPosts'] ?? 3;
$show_thumbnails = $attributes['showThumbnails'] ?? true;

// Get related posts by category
$categories = get_the_category( $current_post_id );
if ( empty( $categories ) ) {
    return '';
}

$related_posts = get_posts( [
    'numberposts'  => $number_of_posts,
    'category__in' => wp_list_pluck( $categories, 'term_id' ),
    'post__not_in' => [ $current_post_id ],
    'orderby'      => 'rand',
] );

if ( empty( $related_posts ) ) {
    return '';
}

$wrapper_attributes = get_block_wrapper_attributes( [
    'class' => 'related-posts',
] );
?>
<aside <?php echo $wrapper_attributes; ?>>
    <h3><?php esc_html_e( 'Related Posts', 'my-plugin' ); ?></h3>
    <ul class="related-posts__list">
        <?php foreach ( $related_posts as $post ) : ?>
            <li class="related-posts__item">
                <?php if ( $show_thumbnails && has_post_thumbnail( $post ) ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="related-posts__thumbnail">
                        <?php echo get_the_post_thumbnail( $post, 'thumbnail' ); ?>
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="related-posts__title">
                    <?php echo esc_html( get_the_title( $post ) ); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>
```

## Hooks vs Templates vs Patterns

| Approach | Use When |
|----------|----------|
| Block Hooks | Automatic insertion, plugin-defined |
| Templates | User-customizable layouts |
| Patterns | Reusable content structures |

### Block Hooks Are Best For:
- Plugin features that should appear automatically
- Default content that users can remove
- Cross-template consistent elements

### Templates Are Better For:
- User-customizable layouts
- Theme-specific structures
- Full page designs

## Debugging Hooks

Check which blocks are hooked:

```php
add_action( 'init', function() {
    $block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
    
    foreach ( $block_types as $block_type ) {
        if ( ! empty( $block_type->block_hooks ) ) {
            error_log( sprintf(
                'Block %s hooks: %s',
                $block_type->name,
                print_r( $block_type->block_hooks, true )
            ) );
        }
    }
} );
```

## Best Practices

1. **Be conservative:** Only auto-insert where it makes sense.

2. **Respect user choices:** Don't override user template modifications.

3. **Use filters for conditions:** Not everything should hook unconditionally.

4. **Provide settings:** Let users configure or disable hooked blocks.

5. **Consider performance:** Hooked blocks add to render time.

6. **Document behavior:** Tell users where blocks will appear.

7. **Test all contexts:** Verify hooks work in archives, singles, etc.

8. **Handle empty states:** Don't render empty markup.
