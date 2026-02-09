# Hooks

The HTML API does not define any actions or filters.

**Source:** `wp-includes/html-api/`

---

## Overview

The HTML API is designed as a pure parsing and modification library without WordPress hook integration. It operates on HTML strings directly without triggering actions or applying filters.

This design choice keeps the API:

- **Fast** — No hook overhead during parsing
- **Predictable** — Output depends only on input and method calls
- **Isolated** — No side effects from other plugins
- **Testable** — Easy to unit test without WordPress context

---

## Integration Points

If you need hook-like behavior, implement it at the calling layer:

```php
// Apply filters before processing
$html = apply_filters( 'my_plugin_before_html_processing', $html );

$processor = new WP_HTML_Tag_Processor( $html );
while ( $processor->next_tag( 'img' ) ) {
    $processor->set_attribute( 'loading', 'lazy' );
}
$result = $processor->get_updated_html();

// Apply filters after processing
$result = apply_filters( 'my_plugin_after_html_processing', $result );
```

---

## Related WordPress Hooks

While the HTML API itself has no hooks, it's often used in contexts where WordPress hooks apply:

### Content Filters

```php
add_filter( 'the_content', function( $content ) {
    $processor = new WP_HTML_Tag_Processor( $content );
    while ( $processor->next_tag( 'a' ) ) {
        $href = $processor->get_attribute( 'href' );
        if ( $href && str_starts_with( $href, 'http' ) ) {
            $processor->set_attribute( 'rel', 'noopener' );
        }
    }
    return $processor->get_updated_html();
} );
```

### Block Rendering

```php
add_filter( 'render_block', function( $block_content, $block ) {
    if ( 'core/image' !== $block['blockName'] ) {
        return $block_content;
    }
    
    $processor = new WP_HTML_Tag_Processor( $block_content );
    if ( $processor->next_tag( 'img' ) ) {
        $processor->add_class( 'block-image' );
    }
    return $processor->get_updated_html();
}, 10, 2 );
```

### Widget Output

```php
add_filter( 'widget_text_content', function( $content ) {
    $processor = WP_HTML_Processor::create_fragment( $content );
    // Structure-aware modifications...
    return $processor->get_updated_html() ?? $content;
} );
```
