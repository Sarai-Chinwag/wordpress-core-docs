# Text Diff Hooks

Filters for customizing diff output processing.

---

## Filters

### process_text_diff_html

Filters a diffed line after HTML encoding but before output.

**Since:** 4.1.0

```php
apply_filters( 'process_text_diff_html', string $processed_line, string $line, string $context ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$processed_line` | string | Line after `htmlspecialchars()` |
| `$line` | string | Original unprocessed line |
| `$context` | string | Line context: `'added'`, `'deleted'`, or `'unchanged'` |

**Returns:** Modified line content for output.

**Location:** `WP_Text_Diff_Renderer_Table::_added()`, `_deleted()`, `_context()`

---

### Example: Preserve Line Breaks

By default, line breaks are encoded. This preserves them as `<br>`:

```php
add_filter( 'process_text_diff_html', function( $processed_line, $line, $context ) {
    // Convert encoded line breaks back to <br> tags
    return str_replace( "\n", '<br>', $processed_line );
}, 10, 3 );
```

---

### Example: Custom Syntax Highlighting

Highlight code syntax in diff output:

```php
add_filter( 'process_text_diff_html', function( $processed_line, $line, $context ) {
    // Apply syntax highlighting to code
    if ( preg_match( '/^(function|class|public|private|protected)\s/', $line ) ) {
        return '<span class="code-keyword">' . $processed_line . '</span>';
    }
    return $processed_line;
}, 10, 3 );
```

---

### Example: Context-Aware Processing

Handle different line types differently:

```php
add_filter( 'process_text_diff_html', function( $processed_line, $line, $context ) {
    switch ( $context ) {
        case 'added':
            // Log additions
            error_log( "Added: {$line}" );
            break;
            
        case 'deleted':
            // Track deletions
            do_action( 'my_content_deleted', $line );
            break;
            
        case 'unchanged':
            // Unchanged lines - maybe truncate long ones
            if ( strlen( $processed_line ) > 200 ) {
                return substr( $processed_line, 0, 200 ) . '...';
            }
            break;
    }
    
    return $processed_line;
}, 10, 3 );
```

---

### Example: Remove HTML Encoding

Disable default HTML encoding (use with caution — XSS risk):

```php
add_filter( 'process_text_diff_html', function( $processed_line, $line, $context ) {
    // Return the original unescaped line
    // WARNING: Only do this if $line is from a trusted source!
    return $line;
}, 10, 3 );
```

---

### Example: Track Changes

Use the filter for change tracking without modifying output:

```php
add_filter( 'process_text_diff_html', function( $processed_line, $line, $context ) {
    static $changes = array( 'added' => 0, 'deleted' => 0 );
    
    if ( $context === 'added' ) {
        $changes['added']++;
    } elseif ( $context === 'deleted' ) {
        $changes['deleted']++;
    }
    
    // Store for later retrieval
    set_transient( 'last_diff_stats', $changes, HOUR_IN_SECONDS );
    
    return $processed_line;
}, 10, 3 );
```

---

## Filter Flow

```
Raw line from Text_Diff
        │
        ▼
htmlspecialchars( $line )
        │
        ▼
apply_filters( 'process_text_diff_html', ... )
        │
        ▼
addedLine() / deletedLine() / contextLine()
        │
        ▼
Final HTML output
```

---

## Notes

- The filter is only applied when `$encode = true` (default behavior)
- Word-level diffs (`<ins>`, `<del>` tags) bypass this filter since they're pre-processed
- The filter receives the full line content, not individual words
- Each line is filtered separately
