# Dynamic Blocks

Dynamic blocks render on the server at page load time, allowing blocks to display current data like posts, user info, or computed values.

## When to Use Dynamic Blocks

Use dynamic blocks when:
- Content depends on server data (posts, users, options)
- Content changes without editing (recent posts, current date)
- Content requires PHP processing (shortcode execution)
- Security requires server-side escaping
- Content varies by user (logged-in status, permissions)

## render.php Method (Recommended)

The simplest approach using block.json's `render` field:

### block.json

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "my-plugin/recent-posts",
    "title": "Recent Posts",
    "category": "widgets",
    "attributes": {
        "numberOfPosts": {
            "type": "number",
            "default": 5
        },
        "displayDate": {
            "type": "boolean",
            "default": true
        }
    },
    "supports": {
        "align": true
    },
    "editorScript": "file:./index.js",
    "style": "file:./style.css",
    "render": "file:./render.php"
}
```

### render.php

```php
<?php
/**
 * Renders the block on the frontend.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block content (inner blocks HTML).
 * @param WP_Block $block      Block instance.
 */

$number_of_posts = $attributes['numberOfPosts'] ?? 5;
$display_date    = $attributes['displayDate'] ?? true;

$recent_posts = get_posts( [
    'numberposts' => $number_of_posts,
    'post_status' => 'publish',
] );

if ( empty( $recent_posts ) ) {
    return '<p>' . esc_html__( 'No posts found.', 'my-plugin' ) . '</p>';
}

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; ?>>
    <ul class="recent-posts-list">
        <?php foreach ( $recent_posts as $post ) : ?>
            <li>
                <a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
                    <?php echo esc_html( get_the_title( $post ) ); ?>
                </a>
                <?php if ( $display_date ) : ?>
                    <time datetime="<?php echo esc_attr( get_the_date( 'c', $post ) ); ?>">
                        <?php echo esc_html( get_the_date( '', $post ) ); ?>
                    </time>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
```

### Available Variables in render.php

| Variable | Type | Description |
|----------|------|-------------|
| `$attributes` | array | Block attributes |
| `$content` | string | Inner blocks HTML (if any) |
| `$block` | WP_Block | Block instance object |

## render_callback Method

Alternative method using PHP callback:

```php
// In your plugin or functions.php
add_action( 'init', function() {
    register_block_type(
        __DIR__ . '/blocks/recent-posts',
        [
            'render_callback' => 'render_recent_posts_block',
        ]
    );
} );

function render_recent_posts_block( $attributes, $content, $block ) {
    $number_of_posts = $attributes['numberOfPosts'] ?? 5;
    
    $recent_posts = get_posts( [
        'numberposts' => $number_of_posts,
    ] );
    
    $wrapper_attributes = get_block_wrapper_attributes();
    
    ob_start();
    ?>
    <div <?php echo $wrapper_attributes; ?>>
        <ul>
            <?php foreach ( $recent_posts as $post ) : ?>
                <li>
                    <a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
                        <?php echo esc_html( get_the_title( $post ) ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}
```

## Using get_block_wrapper_attributes()

This function generates wrapper attributes including support styles:

```php
// Basic usage
$wrapper_attributes = get_block_wrapper_attributes();
// Output: class="wp-block-my-plugin-recent-posts"

// With additional attributes
$wrapper_attributes = get_block_wrapper_attributes( [
    'class' => 'my-custom-class',
    'data-count' => $attributes['numberOfPosts'],
] );
// Output: class="wp-block-my-plugin-recent-posts my-custom-class" data-count="5"

// Classes are merged, not replaced
$wrapper_attributes = get_block_wrapper_attributes( [
    'class' => 'extra-class another-class',
] );
// Output: class="wp-block-my-plugin-recent-posts extra-class another-class has-blue-background-color"
```

## Editor Component for Dynamic Blocks

The edit function should preview the block:

```js
import { useBlockProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { Spinner } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit( { attributes, setAttributes } ) {
    const { numberOfPosts, displayDate } = attributes;
    
    // Option 1: Fetch data and render in JS
    const { posts, isLoading } = useSelect( ( select ) => {
        const { getEntityRecords, isResolving } = select( coreStore );
        return {
            posts: getEntityRecords( 'postType', 'post', {
                per_page: numberOfPosts,
                status: 'publish',
            } ),
            isLoading: isResolving( 'getEntityRecords', [ 'postType', 'post', {
                per_page: numberOfPosts,
                status: 'publish',
            } ] ),
        };
    }, [ numberOfPosts ] );
    
    return (
        <div { ...useBlockProps() }>
            <InspectorControls>
                <PanelBody title="Settings">
                    <RangeControl
                        label="Number of Posts"
                        value={ numberOfPosts }
                        onChange={ ( value ) => setAttributes( { numberOfPosts: value } ) }
                        min={ 1 }
                        max={ 10 }
                    />
                    <ToggleControl
                        label="Display Date"
                        checked={ displayDate }
                        onChange={ ( value ) => setAttributes( { displayDate: value } ) }
                    />
                </PanelBody>
            </InspectorControls>
            
            { isLoading && <Spinner /> }
            { ! isLoading && posts && (
                <ul className="recent-posts-list">
                    { posts.map( ( post ) => (
                        <li key={ post.id }>
                            <a href={ post.link }>
                                { post.title.rendered }
                            </a>
                            { displayDate && (
                                <time>{ new Date( post.date ).toLocaleDateString() }</time>
                            ) }
                        </li>
                    ) ) }
                </ul>
            ) }
        </div>
    );
}
```

### Using ServerSideRender

For simpler cases or when JS preview isn't practical:

```js
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit( { attributes, setAttributes } ) {
    return (
        <div { ...useBlockProps() }>
            <InspectorControls>
                {/* Controls */}
            </InspectorControls>
            
            <ServerSideRender
                block="my-plugin/recent-posts"
                attributes={ attributes }
            />
        </div>
    );
}
```

ServerSideRender props:
- `block` - Block name
- `attributes` - Current attributes
- `urlQueryArgs` - Additional query args
- `EmptyResponsePlaceholder` - Component for empty response
- `ErrorResponsePlaceholder` - Component for errors
- `LoadingResponsePlaceholder` - Loading component

## Save Function for Dynamic Blocks

Dynamic blocks typically return `null` from save:

```js
export default function Save() {
    return null;
}
```

Or simply omit the save function - WordPress uses `null` by default.

## Dynamic Blocks with Inner Blocks

```json
{
    "name": "my-plugin/dynamic-container",
    "render": "file:./render.php"
}
```

```js
// edit.js
export default function Edit() {
    return (
        <div { ...useBlockProps() }>
            <InnerBlocks />
        </div>
    );
}

export function Save() {
    return (
        <div { ...useBlockProps.save() }>
            <InnerBlocks.Content />
        </div>
    );
}
```

```php
<?php
// render.php
// $content contains the rendered inner blocks
$wrapper_attributes = get_block_wrapper_attributes();
?>
<section <?php echo $wrapper_attributes; ?>>
    <header>
        <h2><?php echo esc_html( $attributes['title'] ?? '' ); ?></h2>
    </header>
    <div class="container-content">
        <?php echo $content; // Inner blocks HTML ?>
    </div>
</section>
```

## Accessing Block Context

```php
<?php
// render.php
// Access context from parent blocks
$post_id = $block->context['postId'] ?? get_the_ID();
$post_type = $block->context['postType'] ?? 'post';

$post = get_post( $post_id );

if ( ! $post ) {
    return '';
}

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; ?>>
    <p>Post: <?php echo esc_html( $post->post_title ); ?></p>
</div>
```

## Block Instance ($block)

The WP_Block instance provides:

```php
<?php
// Block name
$block_name = $block->name;

// Block attributes (same as $attributes)
$attrs = $block->attributes;

// Block context from ancestors
$context = $block->context;

// Parsed inner blocks
$inner_blocks = $block->inner_blocks;

// Inner content (markup between inner blocks)
$inner_content = $block->inner_content;

// Render inner blocks manually
$rendered_inner = '';
foreach ( $block->inner_blocks as $inner_block ) {
    $rendered_inner .= render_block( $inner_block->parsed_block );
}
```

## Caching Considerations

Dynamic blocks can impact performance. Consider caching:

```php
<?php
// render.php
$cache_key = 'my_block_' . md5( serialize( $attributes ) );
$cached = get_transient( $cache_key );

if ( false !== $cached ) {
    return $cached;
}

// Generate output
$output = '';
// ... build $output ...

// Cache for 1 hour
set_transient( $cache_key, $output, HOUR_IN_SECONDS );

return $output;
```

Clear cache when data changes:

```php
add_action( 'save_post', function( $post_id ) {
    // Clear relevant block caches
    delete_transient( 'my_block_recent_posts' );
} );
```

## Complete Example: User Profile Block

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "my-plugin/user-profile",
    "title": "User Profile",
    "category": "widgets",
    "attributes": {
        "userId": {
            "type": "number"
        },
        "showBio": {
            "type": "boolean",
            "default": true
        },
        "showAvatar": {
            "type": "boolean",
            "default": true
        },
        "avatarSize": {
            "type": "number",
            "default": 96
        }
    },
    "usesContext": [ "postId" ],
    "supports": {
        "align": true,
        "spacing": {
            "padding": true
        }
    },
    "editorScript": "file:./index.js",
    "style": "file:./style.css",
    "render": "file:./render.php"
}
```

```php
<?php
// render.php
$user_id = $attributes['userId'] ?? 0;

// Fall back to post author if no user specified
if ( ! $user_id && isset( $block->context['postId'] ) ) {
    $user_id = get_post_field( 'post_author', $block->context['postId'] );
}

if ( ! $user_id ) {
    return '<p>' . esc_html__( 'No user selected.', 'my-plugin' ) . '</p>';
}

$user = get_userdata( $user_id );

if ( ! $user ) {
    return '<p>' . esc_html__( 'User not found.', 'my-plugin' ) . '</p>';
}

$show_bio    = $attributes['showBio'] ?? true;
$show_avatar = $attributes['showAvatar'] ?? true;
$avatar_size = $attributes['avatarSize'] ?? 96;

$wrapper_attributes = get_block_wrapper_attributes( [
    'class' => 'user-profile',
] );
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php if ( $show_avatar ) : ?>
        <div class="user-profile__avatar">
            <?php echo get_avatar( $user_id, $avatar_size ); ?>
        </div>
    <?php endif; ?>
    
    <div class="user-profile__info">
        <h3 class="user-profile__name">
            <?php echo esc_html( $user->display_name ); ?>
        </h3>
        
        <?php if ( $show_bio && $user->description ) : ?>
            <p class="user-profile__bio">
                <?php echo esc_html( $user->description ); ?>
            </p>
        <?php endif; ?>
        
        <a href="<?php echo esc_url( get_author_posts_url( $user_id ) ); ?>" class="user-profile__link">
            <?php esc_html_e( 'View all posts', 'my-plugin' ); ?>
        </a>
    </div>
</div>
```

```js
// edit.js
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, RangeControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit( { attributes, setAttributes, context } ) {
    const { userId, showBio, showAvatar, avatarSize } = attributes;
    
    // Get author from post context if no user selected
    const postAuthor = useSelect( ( select ) => {
        if ( userId ) return null;
        if ( ! context.postId ) return null;
        
        const post = select( 'core' ).getEntityRecord( 'postType', 'post', context.postId );
        return post?.author;
    }, [ userId, context.postId ] );
    
    return (
        <>
            <InspectorControls>
                <PanelBody title="Settings">
                    <ToggleControl
                        label="Show Avatar"
                        checked={ showAvatar }
                        onChange={ ( value ) => setAttributes( { showAvatar: value } ) }
                    />
                    { showAvatar && (
                        <RangeControl
                            label="Avatar Size"
                            value={ avatarSize }
                            onChange={ ( value ) => setAttributes( { avatarSize: value } ) }
                            min={ 32 }
                            max={ 256 }
                        />
                    ) }
                    <ToggleControl
                        label="Show Bio"
                        checked={ showBio }
                        onChange={ ( value ) => setAttributes( { showBio: value } ) }
                    />
                </PanelBody>
            </InspectorControls>
            
            <div { ...useBlockProps() }>
                <ServerSideRender
                    block="my-plugin/user-profile"
                    attributes={ attributes }
                />
            </div>
        </>
    );
}
```

## Best Practices

1. **Escape output:** Always escape data in render.php.

2. **Use get_block_wrapper_attributes():** Ensures support styles work.

3. **Handle missing data:** Check for null/empty before rendering.

4. **Consider performance:** Cache expensive queries.

5. **Match editor preview:** Make edit component match rendered output.

6. **Provide loading states:** Show spinners during data fetching.

7. **Use context:** Leverage block context for post/user data.
