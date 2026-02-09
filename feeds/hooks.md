# WordPress Feed Hooks

## Filters

### Content Filters

#### the_title_rss

Filters the post title for use in feeds.

```php
apply_filters( 'the_title_rss', string $title ): string
```

**Parameters:**
- `$title` - The current post title

**Example:**
```php
add_filter( 'the_title_rss', function( $title ) {
    return '[' . get_bloginfo('name') . '] ' . $title;
} );
```

---

#### the_content_feed

Filters the post content for feeds.

```php
apply_filters( 'the_content_feed', string $content, string $feed_type ): string
```

**Parameters:**
- `$content` - Post content with `the_content` filter applied
- `$feed_type` - Feed type: `'rss2'`, `'atom'`, `'rss'`, `'rdf'`

**Example:**
```php
add_filter( 'the_content_feed', function( $content, $feed_type ) {
    // Add featured image to feed content
    if ( has_post_thumbnail() ) {
        $image = get_the_post_thumbnail( null, 'large' );
        $content = $image . $content;
    }
    return $content;
}, 10, 2 );
```

---

#### the_excerpt_rss

Filters the post excerpt for feeds.

```php
apply_filters( 'the_excerpt_rss', string $output ): string
```

**Parameters:**
- `$output` - The current post excerpt

---

#### the_category_rss

Filters all post categories/tags for feed display.

```php
apply_filters( 'the_category_rss', string $the_list, string $type ): string
```

**Parameters:**
- `$the_list` - Formatted category/tag XML
- `$type` - Feed type: `'rss2'`, `'atom'`, `'rdf'`

---

### Blog Info Filters

#### get_bloginfo_rss

Filters blog information for use in RSS feeds.

```php
apply_filters( 'get_bloginfo_rss', string $info, string $show ): string
```

**Parameters:**
- `$info` - Converted string value of blog information
- `$show` - The type of blog information requested

---

#### bloginfo_rss

Filters blog information for display in RSS feeds.

```php
apply_filters( 'bloginfo_rss', string $rss_container, string $show ): string
```

**Parameters:**
- `$rss_container` - RSS container for the blog information
- `$show` - The type of blog information requested

---

### Title Filters

#### get_wp_title_rss

Filters the blog title for use as the feed title.

```php
apply_filters( 'get_wp_title_rss', string $title, string $deprecated ): string
```

**Parameters:**
- `$title` - The current blog title
- `$deprecated` - Unused (deprecated in 4.4.0)

---

#### wp_title_rss

Filters the blog title for display in feeds.

```php
apply_filters( 'wp_title_rss', string $wp_title_rss, string $deprecated ): string
```

---

### Link Filters

#### the_permalink_rss

Filters the post permalink for use in feeds.

```php
apply_filters( 'the_permalink_rss', string $post_permalink ): string
```

**Example:**
```php
add_filter( 'the_permalink_rss', function( $permalink ) {
    // Add tracking parameter
    return add_query_arg( 'utm_source', 'rss', $permalink );
} );
```

---

#### comments_link_feed

Filters the comments permalink for the current post.

```php
apply_filters( 'comments_link_feed', string $comment_permalink ): string
```

**Parameters:**
- `$comment_permalink` - The current comment permalink with `#comments` appended

---

#### self_link

Filters the current feed URL.

```php
apply_filters( 'self_link', string $feed_link ): string
```

---

### Comment Filters

#### comment_author_rss

Filters the comment author for use in feeds.

```php
apply_filters( 'comment_author_rss', string $comment_author ): string
```

---

#### comment_text_rss

Filters the comment content for use in feeds.

```php
apply_filters( 'comment_text_rss', string $comment_text ): string
```

---

#### comment_link

Filters the comment permalink.

```php
apply_filters( 'comment_link', string $comment_permalink ): string
```

---

### Enclosure Filters

#### rss_enclosure

Filters the RSS enclosure HTML tag.

```php
apply_filters( 'rss_enclosure', string $html_link_tag ): string
```

**Parameters:**
- `$html_link_tag` - The `<enclosure>` tag with URL, length, and type

---

#### atom_enclosure

Filters the Atom enclosure HTML link tag.

```php
apply_filters( 'atom_enclosure', string $html_link_tag ): string
```

**Parameters:**
- `$html_link_tag` - The `<link rel="enclosure">` tag

---

### Feed Configuration Filters

#### default_feed

Filters the default feed type.

```php
apply_filters( 'default_feed', string $feed_type ): string
```

**Parameters:**
- `$feed_type` - Default feed type (default: `'rss2'`)

**Example:**
```php
add_filter( 'default_feed', function() {
    return 'atom'; // Make Atom the default
} );
```

---

#### feed_content_type

Filters the content type for a specific feed type.

```php
apply_filters( 'feed_content_type', string $content_type, string $type ): string
```

**Parameters:**
- `$content_type` - MIME type for the feed
- `$type` - Feed type: `'rss'`, `'rss2'`, `'atom'`, `'rdf'`

---

### Update Frequency Filters

#### rss_update_period

Filters how often to update the RSS feed.

```php
apply_filters( 'rss_update_period', string $duration ): string
```

**Parameters:**
- `$duration` - Update period: `'hourly'`, `'daily'`, `'weekly'`, `'monthly'`, `'yearly'`

**Example:**
```php
add_filter( 'rss_update_period', function() {
    return 'daily';
} );
```

---

#### rss_update_frequency

Filters the RSS update frequency within the period.

```php
apply_filters( 'rss_update_frequency', string $frequency ): string
```

**Parameters:**
- `$frequency` - Integer as string (default: `'1'`)

---

### Date Filters

#### get_feed_build_date

Filters the last modified date for feeds.

```php
apply_filters( 'get_feed_build_date', string|false $max_modified_time, string $format ): string|false
```

**Parameters:**
- `$max_modified_time` - Formatted date or false
- `$format` - The date format requested

---

### Cache Filters

#### wp_feed_cache_transient_lifetime

Filters the transient lifetime of feed cache.

```php
apply_filters( 'wp_feed_cache_transient_lifetime', int $lifetime, string $name ): int
```

**Parameters:**
- `$lifetime` - Cache duration in seconds (default: 43200 / 12 hours)
- `$name` - Unique identifier for the cache object

**Example:**
```php
add_filter( 'wp_feed_cache_transient_lifetime', function( $lifetime, $name ) {
    // Cache for 1 hour instead of 12
    return HOUR_IN_SECONDS;
}, 10, 2 );
```

---

## Actions

### Feed Template Actions

#### rss_tag_pre

Fires between the XML declaration and root element.

```php
do_action( 'rss_tag_pre', string $context )
```

**Parameters:**
- `$context` - Feed type: `'rss2'`, `'rss2-comments'`, `'rdf'`, `'atom'`, `'atom-comments'`

**Example:**
```php
add_action( 'rss_tag_pre', function( $context ) {
    // Add XML stylesheet
    echo '<?xml-stylesheet type="text/xsl" href="' . 
         get_template_directory_uri() . '/feed.xsl"?>';
} );
```

---

### RSS 2.0 Actions

#### rss2_ns

Fires at the end of the RSS 2.0 root to add namespaces.

```php
do_action( 'rss2_ns' )
```

**Example:**
```php
add_action( 'rss2_ns', function() {
    echo 'xmlns:media="http://search.yahoo.com/mrss/"' . "\n";
} );
```

---

#### rss2_head

Fires at the end of the RSS 2.0 feed header.

```php
do_action( 'rss2_head' )
```

**Example:**
```php
add_action( 'rss2_head', function() {
    echo '<copyright>© ' . date('Y') . ' ' . get_bloginfo('name') . '</copyright>';
} );
```

---

#### rss2_item

Fires at the end of each RSS 2.0 feed item.

```php
do_action( 'rss2_item' )
```

**Example:**
```php
add_action( 'rss2_item', function() {
    // Add featured image as media:content
    if ( has_post_thumbnail() ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
        if ( $image ) {
            printf( '<media:content url="%s" type="image/jpeg" />', esc_url( $image[0] ) );
        }
    }
} );
```

---

### Atom Actions

#### atom_ns

Fires at the end of the Atom feed root to add namespaces.

```php
do_action( 'atom_ns' )
```

---

#### atom_head

Fires just before the first Atom feed entry.

```php
do_action( 'atom_head' )
```

---

#### atom_author

Fires at the end of each Atom author element.

```php
do_action( 'atom_author' )
```

---

#### atom_entry

Fires at the end of each Atom feed item.

```php
do_action( 'atom_entry' )
```

---

### RDF Actions

#### rdf_ns

Fires at the end of the RDF feed root to add namespaces.

```php
do_action( 'rdf_ns' )
```

---

#### rdf_header

Fires at the end of the RDF feed header.

```php
do_action( 'rdf_header' )
```

---

#### rdf_item

Fires at the end of each RDF feed item.

```php
do_action( 'rdf_item' )
```

---

### RSS 0.92 Actions

#### rss_head

Fires at the end of the RSS 0.92 feed header.

```php
do_action( 'rss_head' )
```

---

#### rss_item

Fires at the end of each RSS 0.92 feed item.

```php
do_action( 'rss_item' )
```

---

### Comment Feed Actions

#### rss2_comments_ns

Fires at the end of the RSS 2.0 comments root to add namespaces.

```php
do_action( 'rss2_comments_ns' )
```

---

#### commentsrss2_head

Fires at the end of the RSS 2.0 comment feed header.

```php
do_action( 'commentsrss2_head' )
```

---

#### commentrss2_item

Fires at the end of each RSS 2.0 comment feed item.

```php
do_action( 'commentrss2_item', int $comment_id, int $comment_post_id )
```

**Parameters:**
- `$comment_id` - The ID of the comment being displayed
- `$comment_post_id` - The ID of the post the comment is connected to

---

#### atom_comments_ns

Fires inside the Atom comments feed root tag.

```php
do_action( 'atom_comments_ns' )
```

---

#### comments_atom_head

Fires at the end of the Atom comment feed header.

```php
do_action( 'comments_atom_head' )
```

---

#### comment_atom_entry

Fires at the end of each Atom comment feed item.

```php
do_action( 'comment_atom_entry', int $comment_id, int $comment_post_id )
```

---

### Feed Consumption Actions

#### wp_feed_options

Fires just before processing the SimplePie feed object.

```php
do_action_ref_array( 'wp_feed_options', array( SimplePie\SimplePie &$feed, string|array $url ) )
```

**Parameters:**
- `$feed` - SimplePie feed object (passed by reference)
- `$url` - URL or array of URLs being fetched

**Example:**
```php
add_action( 'wp_feed_options', function( $feed, $url ) {
    // Force cache refresh for specific feed
    if ( str_contains( $url, 'breaking-news.com' ) ) {
        $feed->set_cache_duration( 300 ); // 5 minutes
    }
    
    // Set custom timeout
    $feed->set_timeout( 30 );
}, 10, 2 );
```

---

## Common Patterns

### Add Featured Images to RSS

```php
add_action( 'rss2_ns', function() {
    echo 'xmlns:media="http://search.yahoo.com/mrss/"' . "\n";
} );

add_action( 'rss2_item', function() {
    if ( has_post_thumbnail() ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
        if ( $image ) {
            printf(
                '<media:content url="%s" medium="image" width="%d" height="%d" />',
                esc_url( $image[0] ),
                intval( $image[1] ),
                intval( $image[2] )
            );
        }
    }
} );
```

### Track Feed Subscribers

```php
add_filter( 'the_permalink_rss', function( $permalink ) {
    return add_query_arg( array(
        'utm_source'   => 'rss',
        'utm_medium'   => 'feed',
        'utm_campaign' => 'blog',
    ), $permalink );
} );
```

### Customize Feed Caching Per Source

```php
add_filter( 'wp_feed_cache_transient_lifetime', function( $lifetime, $name ) {
    // Parse URL from cache name (it's MD5 hashed, so we need another approach)
    // This example reduces ALL feed cache times
    return 30 * MINUTE_IN_SECONDS;
}, 10, 2 );
```

### Add Custom Elements to Feed Items

```php
add_action( 'rss2_item', function() {
    global $post;
    
    // Add reading time
    $word_count = str_word_count( strip_tags( $post->post_content ) );
    $reading_time = ceil( $word_count / 200 );
    echo '<reading_time>' . $reading_time . ' min</reading_time>';
    
    // Add custom taxonomy
    $topics = get_the_terms( $post->ID, 'topic' );
    if ( $topics && ! is_wp_error( $topics ) ) {
        foreach ( $topics as $topic ) {
            echo '<topic>' . esc_html( $topic->name ) . '</topic>';
        }
    }
} );
```
