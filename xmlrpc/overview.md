# WordPress XML-RPC API Overview

WordPress provides XML-RPC functionality for remote publishing and content management. This API allows external applications to interact with WordPress for creating, editing, and managing content.

## Architecture

### Core Components

**Source File:** `wp-includes/class-wp-xmlrpc-server.php`

The XML-RPC system consists of:

1. **`wp_xmlrpc_server`** - Main server class extending `IXR_Server`
2. **Endpoint:** `xmlrpc.php` in the WordPress root directory
3. **IXR Library:** Internal XML-RPC handling library

### Class Hierarchy

```
IXR_Server
    └── wp_xmlrpc_server
```

### Properties

| Property | Type | Description |
|----------|------|-------------|
| `$methods` | array | Registered XML-RPC methods |
| `$blog_options` | array | Available blog options for retrieval/modification |
| `$error` | IXR_Error | Current error instance |
| `$auth_failed` | bool | Authentication failure flag |
| `$is_enabled` | bool | Whether XML-RPC is enabled |

## API Categories

### WordPress API (`wp.*`)

Modern WordPress-specific methods for comprehensive content management:

| Method | Description | Since |
|--------|-------------|-------|
| `wp.getUsersBlogs` | Get user's blogs | 2.6.0 |
| `wp.newPost` | Create new post (any type) | 3.4.0 |
| `wp.editPost` | Edit existing post | 3.4.0 |
| `wp.deletePost` | Delete a post | 3.4.0 |
| `wp.getPost` | Retrieve single post | 3.4.0 |
| `wp.getPosts` | Retrieve multiple posts | 3.4.0 |
| `wp.newTerm` | Create taxonomy term | 3.4.0 |
| `wp.editTerm` | Edit taxonomy term | 3.4.0 |
| `wp.deleteTerm` | Delete taxonomy term | 3.4.0 |
| `wp.getTerm` | Get single term | 3.4.0 |
| `wp.getTerms` | Get multiple terms | 3.4.0 |
| `wp.getTaxonomy` | Get taxonomy info | 3.4.0 |
| `wp.getTaxonomies` | Get all taxonomies | 3.4.0 |
| `wp.getUser` | Get user data | 3.5.0 |
| `wp.getUsers` | Get multiple users | 3.5.0 |
| `wp.getProfile` | Get current user profile | 3.5.0 |
| `wp.editProfile` | Edit user profile | 3.5.0 |
| `wp.getPage` | Get single page | 2.2.0 |
| `wp.getPages` | Get multiple pages | 2.2.0 |
| `wp.newPage` | Create new page | 2.2.0 |
| `wp.deletePage` | Delete a page | 2.2.0 |
| `wp.editPage` | Edit a page | 2.2.0 |
| `wp.getPageList` | Get page list | 2.2.0 |
| `wp.getAuthors` | Get site authors | 2.2.0 |
| `wp.getTags` | Get all tags | 2.7.0 |
| `wp.newCategory` | Create category | 2.2.0 |
| `wp.deleteCategory` | Delete category | 2.5.0 |
| `wp.suggestCategories` | Search categories | 2.2.0 |
| `wp.getComment` | Get single comment | 2.7.0 |
| `wp.getComments` | Get multiple comments | 2.7.0 |
| `wp.deleteComment` | Delete comment | 2.7.0 |
| `wp.editComment` | Edit comment | 2.7.0 |
| `wp.newComment` | Create comment | 2.7.0 |
| `wp.getCommentCount` | Get comment counts | 2.5.0 |
| `wp.getCommentStatusList` | Get comment statuses | 2.7.0 |
| `wp.getPostStatusList` | Get post statuses | 2.5.0 |
| `wp.getPageStatusList` | Get page statuses | 2.5.0 |
| `wp.getPageTemplates` | Get page templates | 2.6.0 |
| `wp.getOptions` | Get blog options | 2.6.0 |
| `wp.setOptions` | Set blog options | 2.6.0 |
| `wp.getMediaItem` | Get media item | 3.1.0 |
| `wp.getMediaLibrary` | Get media library | 3.1.0 |
| `wp.getPostFormats` | Get post formats | 3.1.0 |
| `wp.getPostType` | Get post type info | 3.4.0 |
| `wp.getPostTypes` | Get all post types | 3.4.0 |
| `wp.getRevisions` | Get post revisions | 3.5.0 |
| `wp.restoreRevision` | Restore a revision | 3.5.0 |
| `wp.uploadFile` | Upload file (alias) | - |
| `wp.deleteFile` | Delete file (alias) | - |
| `wp.getCategories` | Get categories (alias) | - |

### Blogger API (`blogger.*`)

Legacy Blogger-compatible methods:

| Method | Description |
|--------|-------------|
| `blogger.getUsersBlogs` | Get user's blogs |
| `blogger.getUserInfo` | Get user information |
| `blogger.getPost` | Get single post |
| `blogger.getRecentPosts` | Get recent posts |
| `blogger.newPost` | Create new post |
| `blogger.editPost` | Edit a post |
| `blogger.deletePost` | Delete a post |

### MetaWeblog API (`metaWeblog.*`)

MetaWeblog protocol with MovableType extensions:

| Method | Description |
|--------|-------------|
| `metaWeblog.newPost` | Create new post |
| `metaWeblog.editPost` | Edit a post |
| `metaWeblog.getPost` | Get single post |
| `metaWeblog.getRecentPosts` | Get recent posts |
| `metaWeblog.getCategories` | Get categories |
| `metaWeblog.newMediaObject` | Upload media file |
| `metaWeblog.deletePost` | Delete post (alias) |
| `metaWeblog.getUsersBlogs` | Get blogs (alias) |

### MovableType API (`mt.*`)

MovableType-compatible methods:

| Method | Description |
|--------|-------------|
| `mt.getCategoryList` | Get all categories |
| `mt.getRecentPostTitles` | Get recent post titles |
| `mt.getPostCategories` | Get post's categories |
| `mt.setPostCategories` | Set post's categories |
| `mt.supportedMethods` | List supported methods |
| `mt.supportedTextFilters` | List text filters |
| `mt.getTrackbackPings` | Get trackbacks |
| `mt.publishPost` | Publish a post |

### Pingback (`pingback.*`)

Pingback protocol implementation:

| Method | Description |
|--------|-------------|
| `pingback.ping` | Register a pingback |
| `pingback.extensions.getPingbacks` | Get pingbacks for URL |

### Demo Methods

Test methods for verifying connectivity:

| Method | Description |
|--------|-------------|
| `demo.sayHello` | Returns "Hello!" |
| `demo.addTwoNumbers` | Adds two numbers |

## Authentication

### Login Process

1. Client sends username/password with each request
2. `login()` method authenticates via `wp_authenticate()`
3. On success, sets current user via `wp_set_current_user()`
4. On failure, returns `IXR_Error(403)`

### Security Features

- **Rate Limiting:** Failed auth flags `$auth_failed` to prevent brute force
- **Capability Checks:** Each method verifies user capabilities
- **Sensitive Parameter Handling:** Uses `#[\SensitiveParameter]` attribute

```php
public function login(
    $username,
    #[\SensitiveParameter]
    $password
) { ... }
```

## Enabling/Disabling XML-RPC

### Check Status

```php
// XML-RPC is enabled by default since WordPress 3.5.0
```

### Disable Authenticated Methods

```php
// Disables methods requiring authentication (not pingbacks)
add_filter( 'xmlrpc_enabled', '__return_false' );
```

### Remove Specific Methods

```php
add_filter( 'xmlrpc_methods', function( $methods ) {
    unset( $methods['pingback.ping'] );
    return $methods;
});
```

## Blog Options

Available options accessible via `wp.getOptions`/`wp.setOptions`:

### Read-Only Options

| Option | Description |
|--------|-------------|
| `software_name` | "WordPress" |
| `software_version` | WordPress version |
| `blog_url` | Site URL |
| `home_url` | Home URL |
| `login_url` | Login URL |
| `admin_url` | Admin URL |
| `image_default_link_type` | Default image link type |
| `image_default_size` | Default image size |
| `image_default_align` | Default image alignment |
| `template` | Current template |
| `stylesheet` | Current stylesheet |
| `post_thumbnail` | Theme thumbnail support |

### Writable Options

| Option | Description |
|--------|-------------|
| `time_zone` | GMT offset |
| `blog_title` | Site title |
| `blog_tagline` | Site tagline |
| `date_format` | Date format |
| `time_format` | Time format |
| `users_can_register` | Registration enabled |
| `thumbnail_size_w` | Thumbnail width |
| `thumbnail_size_h` | Thumbnail height |
| `thumbnail_crop` | Crop thumbnails |
| `medium_size_w` | Medium width |
| `medium_size_h` | Medium height |
| `medium_large_size_w` | Medium-large width |
| `medium_large_size_h` | Medium-large height |
| `large_size_w` | Large width |
| `large_size_h` | Large height |
| `default_comment_status` | Default comment status |
| `default_ping_status` | Default ping status |

## Data Structures

### Post Structure (wp.* methods)

```php
array(
    'post_id'           => '123',
    'post_title'        => 'Title',
    'post_date'         => IXR_Date,
    'post_date_gmt'     => IXR_Date,
    'post_modified'     => IXR_Date,
    'post_modified_gmt' => IXR_Date,
    'post_status'       => 'publish',
    'post_type'         => 'post',
    'post_name'         => 'slug',
    'post_author'       => '1',
    'post_password'     => '',
    'post_excerpt'      => '',
    'post_content'      => 'Content...',
    'post_parent'       => '0',
    'post_mime_type'    => '',
    'link'              => 'https://...',
    'guid'              => 'https://...',
    'menu_order'        => 0,
    'comment_status'    => 'open',
    'ping_status'       => 'open',
    'sticky'            => false,
    'post_thumbnail'    => array(...),
    'post_format'       => 'standard',
    'terms'             => array(...),
    'custom_fields'     => array(...),
    'enclosure'         => array(...),
)
```

### Term Structure

```php
array(
    'term_id'          => '5',
    'name'             => 'Category Name',
    'slug'             => 'category-name',
    'term_group'       => '0',
    'term_taxonomy_id' => '5',
    'taxonomy'         => 'category',
    'description'      => '',
    'parent'           => '0',
    'count'            => 10,
    'custom_fields'    => array(...),
)
```

### User Structure

```php
array(
    'user_id'      => '1',
    'username'     => 'admin',
    'first_name'   => 'John',
    'last_name'    => 'Doe',
    'registered'   => IXR_Date,
    'bio'          => '',
    'email'        => 'john@example.com',
    'nickname'     => 'John',
    'nicename'     => 'john',
    'url'          => 'https://...',
    'display_name' => 'John Doe',
    'roles'        => array('administrator'),
)
```

### Comment Structure

```php
array(
    'date_created_gmt' => IXR_Date,
    'user_id'          => '0',
    'comment_id'       => '1',
    'parent'           => '0',
    'status'           => 'approve',
    'content'          => 'Comment text...',
    'link'             => 'https://...',
    'post_id'          => '123',
    'post_title'       => 'Post Title',
    'author'           => 'Commenter',
    'author_url'       => '',
    'author_email'     => 'commenter@example.com',
    'author_ip'        => '192.168.1.1',
    'type'             => '',
)
```

## Error Codes

| Code | Description |
|------|-------------|
| 400 | Insufficient arguments |
| 401 | Permission denied |
| 403 | Invalid credentials / Forbidden |
| 404 | Resource not found |
| 405 | XML-RPC disabled |
| 409 | Conflict (modified since) |
| 500 | Internal server error |

### Pingback-Specific Errors

| Code | Description |
|------|-------------|
| 0 | Generic error |
| 16 | Source URL doesn't exist |
| 17 | Source doesn't link to target |
| 32 | Target doesn't exist |
| 33 | Target not pingback-enabled |
| 48 | Pingback already registered |

## Making XML-RPC Requests

### Request Format

```xml
<?xml version="1.0"?>
<methodCall>
    <methodName>wp.getPosts</methodName>
    <params>
        <param><value><int>1</int></value></param>
        <param><value><string>username</string></value></param>
        <param><value><string>password</string></value></param>
    </params>
</methodCall>
```

### PHP Example

```php
$client = new IXR_Client( 'https://example.com/xmlrpc.php' );
$client->query( 'wp.getPosts', 1, 'username', 'password', array(
    'post_type' => 'post',
    'number'    => 10,
));
$posts = $client->getResponse();
```

## Security Considerations

1. **Always use HTTPS** for XML-RPC connections
2. **Consider Application Passwords** instead of main credentials
3. **Disable if not needed** via `xmlrpc_enabled` filter
4. **Monitor for abuse** - common target for brute force attacks
5. **Use firewall rules** to restrict XML-RPC access if needed

## Related Files

- `wp-includes/class-IXR.php` - IXR library
- `xmlrpc.php` - Entry point
- `wp-includes/functions.php` - Helper functions (`xmlrpc_getposttitle`, etc.)
