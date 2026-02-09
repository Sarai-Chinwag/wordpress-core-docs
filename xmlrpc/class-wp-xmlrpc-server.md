# wp_xmlrpc_server Class Reference

**File:** `wp-includes/class-wp-xmlrpc-server.php`  
**Since:** 1.5.0

WordPress XMLRPC server implementation providing compatibility for Blogger API, MetaWeblog API, MovableType, pingback, and WordPress-native methods.

## Class Declaration

```php
#[AllowDynamicProperties]
class wp_xmlrpc_server extends IXR_Server
```

## Properties

### `$methods`

```php
public array $methods
```

Registered XML-RPC methods, keyed by method name.

### `$blog_options`

```php
public array $blog_options
```

Available blog options for `wp.getOptions` and `wp.setOptions`.

### `$error`

```php
public IXR_Error $error
```

Current error instance.

### `$auth_failed`

```php
protected bool $auth_failed = false
```

Flag indicating authentication has failed in this instance.

### `$is_enabled`

```php
private bool $is_enabled
```

Whether XML-RPC is enabled.

---

## Core Methods

### `__construct()`

Registers all XMLRPC methods and initializes blog options.

```php
public function __construct()
```

**Since:** 1.5.0

### `serve_request()`

Serves the XML-RPC request.

```php
public function serve_request()
```

**Since:** 2.9.0

### `login()`

Authenticates user credentials.

```php
public function login( string $username, #[\SensitiveParameter] string $password ): WP_User|false
```

**Since:** 2.8.0

**Parameters:**
- `$username` - User's username
- `$password` - User's password

**Returns:** `WP_User` on success, `false` on failure

### `login_pass_ok()` (Deprecated)

```php
public function login_pass_ok( string $username, #[\SensitiveParameter] string $password ): bool
```

**Deprecated:** 2.8.0 - Use `login()` instead.

### `escape()`

Escapes string or array for database.

```php
public function escape( string|array &$data ): string|void
```

**Since:** 1.5.2

### `error()`

Sends error response to client.

```php
public function error( IXR_Error|string $error, false $message = false )
```

**Since:** 5.7.3

### `minimum_args()`

Checks if method received minimum required arguments.

```php
protected function minimum_args( array $args, int $count ): bool
```

**Since:** 3.4.0

---

## WordPress API Methods (`wp.*`)

### `wp_getUsersBlogs()`

Retrieves the blogs of the user.

```php
public function wp_getUsersBlogs( array $args ): array|IXR_Error
```

**Since:** 2.6.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | string | Username |
| 1 | string | Password |

**Returns:**
```php
array(
    'isAdmin'   => bool,
    'isPrimary' => bool,
    'url'       => string,
    'blogid'    => string,
    'blogName'  => string,
    'xmlrpc'    => string,
)
```

---

### `wp_newPost()`

Creates a new post for any registered post type.

```php
public function wp_newPost( array $args ): int|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | array | Content struct |

**Content Struct:**
```php
array(
    'post_type'      => 'post',      // Default 'post'
    'post_status'    => 'draft',     // Default 'draft'
    'post_title'     => '',
    'post_author'    => 0,
    'post_excerpt'   => '',
    'post_content'   => '',
    'post_date_gmt'  => '',
    'post_date'      => '',
    'post_password'  => '',          // 20-char limit
    'comment_status' => 'open',      // 'open' or 'closed'
    'ping_status'    => 'open',      // 'open' or 'closed'
    'sticky'         => false,
    'post_thumbnail' => 0,           // Attachment ID
    'custom_fields'  => array(),
    'terms'          => array(),     // taxonomy => term_ids
    'terms_names'    => array(),     // taxonomy => term_names
    'enclosure'      => array(
        'url'    => '',
        'length' => 0,
        'type'   => '',
    ),
)
```

**Returns:** Post ID on success.

---

### `wp_editPost()`

Edits a post for any registered post type.

```php
public function wp_editPost( array $args ): true|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | int | Post ID |
| 4 | array | Content struct |

**Returns:** `true` on success.

---

### `wp_deletePost()`

Deletes a post for any registered post type.

```php
public function wp_deletePost( array $args ): true|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | int | Post ID |

**Returns:** `true` on success.

---

### `wp_getPost()`

Retrieves a post.

```php
public function wp_getPost( array $args ): array|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | int | Post ID |
| 4 | array | Optional. Fields to return |

**Field Groups:** `'post'`, `'taxonomies'`, `'custom_fields'`, `'enclosure'`

---

### `wp_getPosts()`

Retrieves posts.

```php
public function wp_getPosts( array $args ): array|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | array | Optional. Filter parameters |
| 4 | array | Optional. Fields to return |

**Filter Options:**
- `post_type` - Post type (default 'post')
- `post_status` - Status filter
- `number` - Number of posts
- `offset` - Offset
- `orderby` - Order by field
- `order` - ASC or DESC
- `s` - Search query

---

### `wp_newTerm()`

Creates a new term.

```php
public function wp_newTerm( array $args ): int|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | array | Content struct |

**Content Struct:**
```php
array(
    'name'        => 'Term Name',  // Required
    'taxonomy'    => 'category',   // Required
    'parent'      => 0,            // Optional
    'description' => '',           // Optional
    'slug'        => '',           // Optional
)
```

**Returns:** Term ID on success.

---

### `wp_editTerm()`

Edits a term.

```php
public function wp_editTerm( array $args ): true|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | int | Term ID |
| 4 | array | Content struct |

---

### `wp_deleteTerm()`

Deletes a term.

```php
public function wp_deleteTerm( array $args ): true|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | string | Taxonomy name |
| 4 | int | Term ID |

---

### `wp_getTerm()`

Retrieves a term.

```php
public function wp_getTerm( array $args ): array|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | string | Taxonomy name |
| 4 | int | Term ID |

---

### `wp_getTerms()`

Retrieves all terms for a taxonomy.

```php
public function wp_getTerms( array $args ): array|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | string | Taxonomy name |
| 4 | array | Optional. Filter |

**Filter Options:** `number`, `offset`, `orderby`, `order`, `hide_empty`, `search`

---

### `wp_getTaxonomy()`

Retrieves a taxonomy.

```php
public function wp_getTaxonomy( array $args ): array|IXR_Error
```

**Since:** 3.4.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | string | Taxonomy name |
| 4 | array | Optional. Fields |

**Field Options:** `'labels'`, `'cap'`, `'menu'`, `'object_type'`

---

### `wp_getTaxonomies()`

Retrieves all taxonomies.

```php
public function wp_getTaxonomies( array $args ): array|IXR_Error
```

**Since:** 3.4.0

---

### `wp_getUser()`

Retrieves a user.

```php
public function wp_getUser( array $args ): array|IXR_Error
```

**Since:** 3.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | int | User ID |
| 4 | array | Optional. Fields |

**Field Options:** `'basic'`, `'all'`, or individual field names

---

### `wp_getUsers()`

Retrieves users.

```php
public function wp_getUsers( array $args ): array|IXR_Error
```

**Since:** 3.5.0

**Filter Options:** `number` (default 50), `offset`, `role`, `who`, `orderby`, `order`

---

### `wp_getProfile()`

Retrieves information about the requesting user.

```php
public function wp_getProfile( array $args ): array|IXR_Error
```

**Since:** 3.5.0

---

### `wp_editProfile()`

Edits user's profile.

```php
public function wp_editProfile( array $args ): true|IXR_Error
```

**Since:** 3.5.0

**Content Fields:** `first_name`, `last_name`, `url`, `display_name`, `nickname`, `nicename`, `bio`

---

### `wp_getPage()`

Retrieves a page.

```php
public function wp_getPage( array $args ): array|IXR_Error
```

**Since:** 2.2.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | int | Page ID |
| 2 | string | Username |
| 3 | string | Password |

---

### `wp_getPages()`

Retrieves pages.

```php
public function wp_getPages( array $args ): array|IXR_Error
```

**Since:** 2.2.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | int | Optional. Number of pages (default 10) |

---

### `wp_newPage()`

Creates a new page.

```php
public function wp_newPage( array $args ): int|IXR_Error
```

**Since:** 2.2.0

---

### `wp_deletePage()`

Deletes a page.

```php
public function wp_deletePage( array $args ): true|IXR_Error
```

**Since:** 2.2.0

---

### `wp_editPage()`

Edits a page.

```php
public function wp_editPage( array $args ): array|IXR_Error
```

**Since:** 2.2.0

---

### `wp_getPageList()`

Retrieves page list.

```php
public function wp_getPageList( array $args ): array|IXR_Error
```

**Since:** 2.2.0

---

### `wp_getAuthors()`

Retrieves authors list.

```php
public function wp_getAuthors( array $args ): array|IXR_Error
```

**Since:** 2.2.0

**Returns:**
```php
array(
    'user_id'      => int,
    'user_login'   => string,
    'display_name' => string,
)
```

---

### `wp_getTags()`

Gets the list of all tags.

```php
public function wp_getTags( array $args ): array|IXR_Error
```

**Since:** 2.7.0

**Returns:**
```php
array(
    'tag_id'   => int,
    'name'     => string,
    'count'    => int,
    'slug'     => string,
    'html_url' => string,
    'rss_url'  => string,
)
```

---

### `wp_newCategory()`

Creates a new category.

```php
public function wp_newCategory( array $args ): int|IXR_Error
```

**Since:** 2.2.0

**Content:**
```php
array(
    'name'        => 'Category Name',
    'slug'        => '',           // Optional
    'parent_id'   => 0,            // Optional
    'description' => '',           // Optional
)
```

---

### `wp_deleteCategory()`

Deletes a category.

```php
public function wp_deleteCategory( array $args ): bool|IXR_Error
```

**Since:** 2.5.0

---

### `wp_suggestCategories()`

Retrieves category list matching search.

```php
public function wp_suggestCategories( array $args ): array|IXR_Error
```

**Since:** 2.2.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | string | Search query |
| 4 | int | Max results |

---

### `wp_getComment()`

Retrieves a comment.

```php
public function wp_getComment( array $args ): array|IXR_Error
```

**Since:** 2.7.0

---

### `wp_getComments()`

Retrieves comments.

```php
public function wp_getComments( array $args ): array|IXR_Error
```

**Since:** 2.7.0

**Filter Options:** `status`, `post_id`, `post_type`, `offset`, `number` (default 10)

---

### `wp_deleteComment()`

Deletes a comment.

```php
public function wp_deleteComment( array $args ): bool|IXR_Error
```

**Since:** 2.7.0

---

### `wp_editComment()`

Edits a comment.

```php
public function wp_editComment( array $args ): true|IXR_Error
```

**Since:** 2.7.0

**Content:**
```php
array(
    'author'           => '',
    'author_url'       => '',
    'author_email'     => '',
    'content'          => '',
    'date_created_gmt' => IXR_Date,
    'status'           => 'approve',  // 'approve', 'hold', 'spam'
)
```

---

### `wp_newComment()`

Creates a new comment.

```php
public function wp_newComment( array $args ): int|IXR_Error
```

**Since:** 2.7.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | int\|string | Post ID or URL |
| 4 | array | Content struct |

---

### `wp_getCommentCount()`

Retrieves comment counts.

```php
public function wp_getCommentCount( array $args ): array|IXR_Error
```

**Since:** 2.5.0

**Returns:**
```php
array(
    'approved'            => int,
    'awaiting_moderation' => int,
    'spam'                => int,
    'total_comments'      => int,
)
```

---

### `wp_getCommentStatusList()`

Retrieves all comment statuses.

```php
public function wp_getCommentStatusList( array $args ): array|IXR_Error
```

**Since:** 2.7.0

---

### `wp_getPostStatusList()`

Retrieves post statuses.

```php
public function wp_getPostStatusList( array $args ): array|IXR_Error
```

**Since:** 2.5.0

---

### `wp_getPageStatusList()`

Retrieves page statuses.

```php
public function wp_getPageStatusList( array $args ): array|IXR_Error
```

**Since:** 2.5.0

---

### `wp_getPageTemplates()`

Retrieves page templates.

```php
public function wp_getPageTemplates( array $args ): array|IXR_Error
```

**Since:** 2.6.0

---

### `wp_getOptions()`

Retrieves blog options.

```php
public function wp_getOptions( array $args ): array|IXR_Error
```

**Since:** 2.6.0

---

### `wp_setOptions()`

Updates blog options.

```php
public function wp_setOptions( array $args ): array|IXR_Error
```

**Since:** 2.6.0

---

### `wp_getMediaItem()`

Retrieves a media item by ID.

```php
public function wp_getMediaItem( array $args ): array|IXR_Error
```

**Since:** 3.1.0

**Returns:**
```php
array(
    'attachment_id'    => string,
    'date_created_gmt' => IXR_Date,
    'parent'           => int,
    'link'             => string,
    'title'            => string,
    'caption'          => string,
    'description'      => string,
    'metadata'         => array,
    'type'             => string,   // MIME type
    'alt'              => string,
    'thumbnail'        => string,
)
```

---

### `wp_getMediaLibrary()`

Retrieves media library items.

```php
public function wp_getMediaLibrary( array $args ): array|IXR_Error
```

**Since:** 3.1.0

**Filter Options:** `parent_id`, `mime_type`, `offset`, `number` (default 5)

---

### `wp_getPostFormats()`

Retrieves post formats.

```php
public function wp_getPostFormats( array $args ): array|IXR_Error
```

**Since:** 3.1.0

---

### `wp_getPostType()`

Retrieves a post type.

```php
public function wp_getPostType( array $args ): array|IXR_Error
```

**Since:** 3.4.0

---

### `wp_getPostTypes()`

Retrieves post types.

```php
public function wp_getPostTypes( array $args ): array|IXR_Error
```

**Since:** 3.4.0

---

### `wp_getRevisions()`

Retrieves revisions for a post.

```php
public function wp_getRevisions( array $args ): array|IXR_Error
```

**Since:** 3.5.0

---

### `wp_restoreRevision()`

Restores a post revision.

```php
public function wp_restoreRevision( array $args ): bool|IXR_Error
```

**Since:** 3.5.0

---

## Blogger API Methods (`blogger.*`)

### `blogger_getUsersBlogs()`

Retrieves blogs that user owns.

```php
public function blogger_getUsersBlogs( array $args ): array|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |

---

### `blogger_getUserInfo()`

Retrieves user's data.

```php
public function blogger_getUserInfo( array $args ): array|IXR_Error
```

**Since:** 1.5.0

**Returns:**
```php
array(
    'nickname'  => string,
    'userid'    => int,
    'url'       => string,
    'lastname'  => string,
    'firstname' => string,
)
```

---

### `blogger_getPost()`

Retrieves a post.

```php
public function blogger_getPost( array $args ): array|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | int | Post ID |
| 2 | string | Username |
| 3 | string | Password |

---

### `blogger_getRecentPosts()`

Retrieves the list of recent posts.

```php
public function blogger_getRecentPosts( array $args ): array|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | string | App key (unused) |
| 1 | int | Blog ID (unused) |
| 2 | string | Username |
| 3 | string | Password |
| 4 | int | Optional. Number of posts |

---

### `blogger_newPost()`

Creates a new post.

```php
public function blogger_newPost( array $args ): int|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | string | App key (unused) |
| 1 | int | Blog ID (unused) |
| 2 | string | Username |
| 3 | string | Password |
| 4 | string | Content |
| 5 | int | Publish flag (0=draft, 1=publish) |

---

### `blogger_editPost()`

Edits a post.

```php
public function blogger_editPost( array $args ): true|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | int | Post ID |
| 2 | string | Username |
| 3 | string | Password |
| 4 | string | Content |
| 5 | int | Publish flag |

---

### `blogger_deletePost()`

Deletes a post.

```php
public function blogger_deletePost( array $args ): true|IXR_Error
```

**Since:** 1.5.0

---

### `blogger_getTemplate()` (Deprecated)

```php
public function blogger_getTemplate( array $args ): IXR_Error
```

**Deprecated:** 3.5.0 - Always returns error.

### `blogger_setTemplate()` (Deprecated)

```php
public function blogger_setTemplate( array $args ): IXR_Error
```

**Deprecated:** 3.5.0 - Always returns error.

---

## MetaWeblog API Methods (`metaWeblog.*`)

### `mw_newPost()`

Creates a new post.

```php
public function mw_newPost( array $args ): int|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | array | Content struct |
| 4 | int | Optional. Publish flag (default 0) |

**Content Struct:**
```php
array(
    'title'              => '',
    'description'        => '',       // Post content
    'mt_excerpt'         => '',
    'mt_text_more'       => '',       // More content
    'mt_keywords'        => array(),  // Tags
    'mt_tb_ping_urls'    => array(),  // Trackback URLs
    'categories'         => array(),
    'wp_slug'            => '',
    'wp_password'        => '',
    'wp_page_parent_id'  => 0,
    'wp_page_order'      => 0,
    'wp_author_id'       => 0,
    'post_status'        => '',       // or page_status
    'mt_allow_comments'  => 'open',   // 'open', 'closed', or int
    'mt_allow_pings'     => 'open',
    'date_created_gmt'   => IXR_Date,
    'dateCreated'        => IXR_Date,
    'wp_post_thumbnail'  => 0,
    'wp_post_format'     => '',
    'sticky'             => false,
    'custom_fields'      => array(),
    'enclosure'          => array(),
)
```

---

### `mw_editPost()`

Edits a post.

```php
public function mw_editPost( array $args ): true|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Post ID |
| 1 | string | Username |
| 2 | string | Password |
| 3 | array | Content struct |
| 4 | int | Optional. Publish flag |

---

### `mw_getPost()`

Retrieves a post.

```php
public function mw_getPost( array $args ): array|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Post ID |
| 1 | string | Username |
| 2 | string | Password |

**Returns:**
```php
array(
    'dateCreated'            => IXR_Date,
    'userid'                 => string,
    'postid'                 => string,
    'description'            => string,
    'title'                  => string,
    'link'                   => string,
    'permaLink'              => string,
    'categories'             => array,
    'mt_excerpt'             => string,
    'mt_text_more'           => string,
    'wp_more_text'           => string,
    'mt_allow_comments'      => int,
    'mt_allow_pings'         => int,
    'mt_keywords'            => string,
    'wp_slug'                => string,
    'wp_password'            => string,
    'wp_author_id'           => string,
    'wp_author_display_name' => string,
    'date_created_gmt'       => IXR_Date,
    'post_status'            => string,
    'custom_fields'          => array,
    'wp_post_format'         => string,
    'sticky'                 => bool,
    'date_modified'          => IXR_Date,
    'date_modified_gmt'      => IXR_Date,
    'enclosure'              => array,
    'wp_post_thumbnail'      => int,
)
```

---

### `mw_getRecentPosts()`

Retrieves list of recent posts.

```php
public function mw_getRecentPosts( array $args ): array|IXR_Error
```

**Since:** 1.5.0

---

### `mw_getCategories()`

Retrieves the list of categories.

```php
public function mw_getCategories( array $args ): array|IXR_Error
```

**Since:** 1.5.0

**Returns:**
```php
array(
    'categoryId'          => int,
    'parentId'            => int,
    'description'         => string,
    'categoryDescription' => string,
    'categoryName'        => string,
    'htmlUrl'             => string,
    'rssUrl'              => string,
)
```

---

### `mw_newMediaObject()`

Uploads a file.

```php
public function mw_newMediaObject( array $args ): array|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Blog ID (unused) |
| 1 | string | Username |
| 2 | string | Password |
| 3 | array | Data |

**Data Struct:**
```php
array(
    'name'    => 'filename.jpg',
    'type'    => 'image/jpeg',
    'bits'    => base64_decoded_binary,
    'post_id' => 0,  // Optional. Attach to post.
)
```

**Returns:**
```php
array(
    'attachment_id' => int,
    'id'            => int,      // Deprecated alias
    'file'          => string,   // Deprecated alias
    'url'           => string,   // Deprecated alias
    'link'          => string,
    'title'         => string,
    // ... full media item struct
)
```

---

## MovableType API Methods (`mt.*`)

### `mt_getRecentPostTitles()`

Retrieves the post titles of recent posts.

```php
public function mt_getRecentPostTitles( array $args ): array|IXR_Error
```

**Since:** 1.5.0

**Returns:**
```php
array(
    'dateCreated'      => IXR_Date,
    'userid'           => string,
    'postid'           => string,
    'title'            => string,
    'post_status'      => string,
    'date_created_gmt' => IXR_Date,
)
```

---

### `mt_getCategoryList()`

Retrieves the list of all categories.

```php
public function mt_getCategoryList( array $args ): array|IXR_Error
```

**Since:** 1.5.0

**Returns:**
```php
array(
    'categoryId'   => int,
    'categoryName' => string,
)
```

---

### `mt_getPostCategories()`

Retrieves post categories.

```php
public function mt_getPostCategories( array $args ): array|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Post ID |
| 1 | string | Username |
| 2 | string | Password |

**Returns:**
```php
array(
    'categoryName' => string,
    'categoryId'   => string,
    'isPrimary'    => bool,
)
```

---

### `mt_setPostCategories()`

Sets categories for a post.

```php
public function mt_setPostCategories( array $args ): true|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Post ID |
| 1 | string | Username |
| 2 | string | Password |
| 3 | array | Categories |

**Categories Format:**
```php
array(
    array( 'categoryId' => 1 ),
    array( 'categoryId' => 2 ),
)
```

---

### `mt_supportedMethods()`

Retrieves array of methods supported by this server.

```php
public function mt_supportedMethods(): array
```

**Since:** 1.5.0

---

### `mt_supportedTextFilters()`

Retrieves text filters (returns empty array).

```php
public function mt_supportedTextFilters(): array
```

**Since:** 1.5.0

---

### `mt_getTrackbackPings()`

Retrieves trackbacks sent to a post.

```php
public function mt_getTrackbackPings( int $post_id ): array|IXR_Error
```

**Since:** 1.5.0

**Returns:**
```php
array(
    'pingTitle' => string,
    'pingURL'   => string,
    'pingIP'    => string,
)
```

---

### `mt_publishPost()`

Sets a post's publish status to 'publish'.

```php
public function mt_publishPost( array $args ): int|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | int | Post ID |
| 1 | string | Username |
| 2 | string | Password |

---

## Pingback Methods

### `pingback_ping()`

Retrieves a pingback and registers it.

```php
public function pingback_ping( array $args ): string|IXR_Error
```

**Since:** 1.5.0

**Arguments:**
| Index | Type | Description |
|-------|------|-------------|
| 0 | string | URL of page linked from |
| 1 | string | URL of page linked to |

**Returns:** Success message or error.

---

### `pingback_extensions_getPingbacks()`

Retrieves array of URLs that pingbacked the given URL.

```php
public function pingback_extensions_getPingbacks( string $url ): array|IXR_Error
```

**Since:** 1.5.0

---

## Demo Methods

### `sayHello()`

Returns "Hello!" for testing.

```php
public function sayHello(): string
```

**Since:** 1.5.0

### `addTwoNumbers()`

Adds two numbers for testing.

```php
public function addTwoNumbers( array $args ): int
```

**Since:** 1.5.0

---

## Helper Methods

### `get_custom_fields()`

Retrieves custom fields for post.

```php
public function get_custom_fields( int $post_id ): array
```

**Since:** 2.5.0

### `set_custom_fields()`

Sets custom fields for post.

```php
public function set_custom_fields( int $post_id, array $fields )
```

**Since:** 2.5.0

### `get_term_custom_fields()`

Retrieves custom fields for a term.

```php
public function get_term_custom_fields( int $term_id ): array
```

**Since:** 4.9.0

### `set_term_custom_fields()`

Sets custom fields for a term.

```php
public function set_term_custom_fields( int $term_id, array $fields )
```

**Since:** 4.9.0

### `add_enclosure_if_new()`

Adds an enclosure to a post if new.

```php
public function add_enclosure_if_new( int $post_id, array $enclosure )
```

**Since:** 2.8.0

### `attach_uploads()`

Attaches unattached uploads referenced in content.

```php
public function attach_uploads( int $post_id, string $post_content )
```

**Since:** 2.1.0

---

## Protected Preparation Methods

### `_prepare_post()`

Prepares post data for return.

```php
protected function _prepare_post( array $post, array $fields ): array
```

### `_prepare_post_type()`

Prepares post type data for return.

```php
protected function _prepare_post_type( WP_Post_Type $post_type, array $fields ): array
```

### `_prepare_taxonomy()`

Prepares taxonomy data for return.

```php
protected function _prepare_taxonomy( WP_Taxonomy $taxonomy, array $fields ): array
```

### `_prepare_term()`

Prepares term data for return.

```php
protected function _prepare_term( array|object $term ): array
```

### `_prepare_media_item()`

Prepares media item data for return.

```php
protected function _prepare_media_item( WP_Post $media_item, string $thumbnail_size = 'thumbnail' ): array
```

### `_prepare_page()`

Prepares page data for return.

```php
protected function _prepare_page( WP_Post $page ): array
```

### `_prepare_comment()`

Prepares comment data for return.

```php
protected function _prepare_comment( WP_Comment $comment ): array
```

### `_prepare_user()`

Prepares user data for return.

```php
protected function _prepare_user( WP_User $user, array $fields ): array
```

### `_convert_date()`

Converts WordPress date string to IXR_Date.

```php
protected function _convert_date( string $date ): IXR_Date
```

### `_convert_date_gmt()`

Converts WordPress GMT date string to IXR_Date.

```php
protected function _convert_date_gmt( string $date_gmt, string $date ): IXR_Date
```
