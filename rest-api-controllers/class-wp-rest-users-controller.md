# WP_REST_Users_Controller

Core class used to manage users via the REST API.

## Class Synopsis

```php
class WP_REST_Users_Controller extends WP_REST_Controller {
    protected $meta;
    protected $allow_batch = array( 'v1' => true );
    
    public function __construct();
    public function register_routes();
    
    // Permission Checks
    public function get_items_permissions_check( $request );
    public function get_item_permissions_check( $request );
    public function create_item_permissions_check( $request );
    public function update_item_permissions_check( $request );
    public function update_current_item_permissions_check( $request );
    public function delete_item_permissions_check( $request );
    public function delete_current_item_permissions_check( $request );
    
    // CRUD Operations
    public function get_items( $request );
    public function get_item( $request );
    public function get_current_item( $request );
    public function create_item( $request );
    public function update_item( $request );
    public function update_current_item( $request );
    public function delete_item( $request );
    public function delete_current_item( $request );
    
    // Data Preparation
    protected function prepare_item_for_database( $request );
    public function prepare_item_for_response( $item, $request );
    protected function prepare_links( $user );
    
    // Schema & Parameters
    public function get_item_schema();
    public function get_collection_params();
    
    // Validation
    public function check_reassign( $value, $request, $param );
    public function check_username( $value, $request, $param );
    public function check_user_password( $value, $request, $param );
    protected function check_role_update( $user_id, $roles );
    
    // Utilities
    protected function get_user( $id );
}
```

## Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/wp/v2/users` | List users |
| POST | `/wp/v2/users` | Create a user |
| GET | `/wp/v2/users/{id}` | Get a single user |
| POST/PUT/PATCH | `/wp/v2/users/{id}` | Update a user |
| DELETE | `/wp/v2/users/{id}` | Delete a user |
| GET | `/wp/v2/users/me` | Get current user |
| POST/PUT/PATCH | `/wp/v2/users/me` | Update current user |
| DELETE | `/wp/v2/users/me` | Delete current user |

## Constructor

```php
public function __construct()
```

Sets namespace to `'wp/v2'`, rest_base to `'users'`, and creates `WP_REST_User_Meta_Fields` instance.

## Collection Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `context` | string | 'view' | Scope under which request is made |
| `page` | integer | 1 | Current page |
| `per_page` | integer | 10 | Items per page (max 100) |
| `search` | string | - | Search string |
| `exclude` | array | [] | Exclude specific IDs |
| `include` | array | [] | Include specific IDs |
| `offset` | integer | - | Offset for pagination |
| `order` | string | 'asc' | Sort order (asc/desc) |
| `orderby` | string | 'name' | Sort field |
| `slug` | array | - | Filter by user slugs |
| `roles` | array | - | Filter by roles |
| `capabilities` | array | - | Filter by capabilities |
| `who` | string | - | Filter authors ('authors') |
| `has_published_posts` | boolean/array | - | Filter by published posts |
| `search_columns` | array | [] | Columns to search |

### Orderby Options

- `id` - User ID
- `include` - Order by include parameter
- `name` - Display name
- `registered_date` - Registration date
- `slug` - User nicename
- `include_slugs` - Order by slug include
- `email` - Email address
- `url` - User URL

### Search Columns

- `id` - User ID
- `username` - Login name
- `slug` - Nicename
- `email` - Email (requires `list_users` capability)
- `name` - Display name

## Schema Properties

| Property | Type | Context | Required | Description |
|----------|------|---------|----------|-------------|
| `id` | integer | embed, view, edit | - | User ID (readonly) |
| `username` | string | edit | create | Login name |
| `name` | string | embed, view, edit | - | Display name |
| `first_name` | string | edit | - | First name |
| `last_name` | string | edit | - | Last name |
| `email` | string | edit | create | Email address |
| `url` | string | embed, view, edit | - | User URL |
| `description` | string | embed, view, edit | - | Biographical info |
| `link` | string | embed, view, edit | - | Author archive URL (readonly) |
| `locale` | string | edit | - | User locale |
| `nickname` | string | edit | - | Nickname |
| `slug` | string | embed, view, edit | - | User nicename |
| `registered_date` | string | edit | - | Registration date (readonly) |
| `roles` | array | edit | - | User roles |
| `password` | string | (never) | create | User password |
| `capabilities` | object | edit | - | All capabilities (readonly) |
| `extra_capabilities` | object | edit | - | Extra capabilities (readonly) |
| `avatar_urls` | object | embed, view, edit | - | Avatar URLs (readonly) |
| `meta` | object | view, edit | - | User meta |

## Permission Checks

### get_items_permissions_check()
- Returns `true` for public requests
- Requires `list_users` for filtering by roles or capabilities
- Requires `list_users` for `edit` context
- Requires `list_users` for ordering by email or registered_date
- Requires `edit_posts` for `who=authors` filter

### get_item_permissions_check()
- Always allows viewing own profile
- Requires `edit_user` capability for `edit` context
- For other users: requires `edit_user`, `list_users`, or user must have published posts

### create_item_permissions_check()
- Requires `create_users` capability

### update_item_permissions_check()
- Requires `edit_user` capability
- Requires `promote_user` to change roles

### delete_item_permissions_check()
- Requires `delete_user` capability

## Key Methods

### get_user()
```php
protected function get_user( int $id ): WP_User|WP_Error
```
Gets the user if ID is valid. On multisite, verifies user is a member of the current blog.

### get_current_item()
```php
public function get_current_item( WP_REST_Request $request ): WP_REST_Response|WP_Error
```
Retrieves the currently authenticated user. Returns 401 if not logged in.

### check_role_update()
```php
protected function check_role_update( int $user_id, array $roles ): true|WP_Error
```
Validates role changes:
- Role must exist
- Cannot remove `edit_users` from own account (unless multisite super admin)
- Role must be in editable roles

### check_username()
```php
public function check_username( string $value, WP_REST_Request $request, string $param ): string|WP_Error
```
Validates username:
- Must pass `validate_username()`
- Must not be in `illegal_user_logins` filter

### check_user_password()
```php
public function check_user_password( string $value, WP_REST_Request $request, string $param ): string|WP_Error
```
Validates password:
- Cannot be empty
- Cannot contain backslash character

### check_reassign()
```php
public function check_reassign( int|bool $value, WP_REST_Request $request, string $param ): int|bool|WP_Error
```
Validates the `reassign` parameter for deletion:
- Accepts user ID (integer)
- Accepts `false`, `'false'`, or empty string (don't reassign)

## Deletion Behavior

### DELETE /wp/v2/users/{id}

**Required Parameters:**
- `force` - Must be `true` (users don't support trashing)
- `reassign` - User ID to reassign content to, or `false`

**Multisite Note:** User deletion is not supported on multisite. Returns error with status 501.

**Response:**
```json
{
    "deleted": true,
    "previous": {
        "id": 123,
        "username": "johndoe",
        "name": "John Doe",
        ...
    }
}
```

## Response Links

| Relation | Description |
|----------|-------------|
| `self` | Link to this user |
| `collection` | Link to users collection |

## Avatar URLs

If avatars are enabled (`show_avatars` option), the response includes avatar URLs at multiple sizes:

```json
{
    "avatar_urls": {
        "24": "https://secure.gravatar.com/avatar/...?s=24",
        "48": "https://secure.gravatar.com/avatar/...?s=48",
        "96": "https://secure.gravatar.com/avatar/...?s=96"
    }
}
```

## Usage Example

```php
// List users who have published posts
$request = new WP_REST_Request( 'GET', '/wp/v2/users' );
$request->set_param( 'has_published_posts', true );
$request->set_param( 'orderby', 'name' );

$controller = new WP_REST_Users_Controller();
$response = $controller->get_items( $request );

// Create a new user
$request = new WP_REST_Request( 'POST', '/wp/v2/users' );
$request->set_param( 'username', 'newuser' );
$request->set_param( 'email', 'newuser@example.com' );
$request->set_param( 'password', 'securepassword123' );
$request->set_param( 'roles', array( 'author' ) );

$response = $controller->create_item( $request );

// Get current user
$request = new WP_REST_Request( 'GET', '/wp/v2/users/me' );
$response = $controller->get_current_item( $request );

// Delete user and reassign content
$request = new WP_REST_Request( 'DELETE', '/wp/v2/users/123' );
$request->set_param( 'force', true );
$request->set_param( 'reassign', 1 ); // Reassign to user ID 1

$response = $controller->delete_item( $request );
```

## Multisite Considerations

- Users must be members of the current blog
- User deletion returns 501 (not supported)
- User creation uses `wpmu_create_user()` and `add_user_to_blog()`

## Source

`wp-includes/rest-api/endpoints/class-wp-rest-users-controller.php`

## Since

WordPress 4.7.0

## Changelog

| Version | Description |
|---------|-------------|
| 4.7.0 | Introduced |
| 5.0.0 | Added `rest_after_insert_user` action |
| 6.6.0 | Added batching support |
| 6.8.0 | Added `search_columns` parameter |
