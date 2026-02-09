# WordPress Security Standards

Security is non-negotiable. Every input is untrusted. Every output must be escaped.

## The Golden Rules

1. **Never trust user input** - Validate and sanitize everything
2. **Escape all output** - Context-appropriate escaping
3. **Use nonces** - Prevent CSRF attacks
4. **Check capabilities** - Verify user permissions
5. **Use prepared statements** - Prevent SQL injection

---

## Input Sanitization

### When to Sanitize

Sanitize data when **receiving** it - from `$_GET`, `$_POST`, `$_REQUEST`, database, or any external source.

### Sanitization Functions

```php
// ✅ Text fields - strips tags, encodes special chars
$title = sanitize_text_field( $_POST['title'] );

// ✅ Textarea - preserves line breaks
$content = sanitize_textarea_field( $_POST['content'] );

// ✅ Email addresses
$email = sanitize_email( $_POST['email'] );

// ✅ File names - removes path traversal
$filename = sanitize_file_name( $_POST['filename'] );

// ✅ HTML classes
$class = sanitize_html_class( $_POST['class'] );

// ✅ Keys (lowercase alphanumeric, dashes, underscores)
$key = sanitize_key( $_POST['key'] );

// ✅ Title - like text field but allows some entities
$title = sanitize_title( $_POST['title'] );

// ✅ URLs
$url = esc_url_raw( $_POST['url'] );  // For database
$url = sanitize_url( $_POST['url'] );  // Alias

// ✅ Integers
$id = absint( $_POST['id'] );          // Positive integers
$number = intval( $_POST['number'] );  // Any integer

// ✅ Floats
$price = floatval( $_POST['price'] );

// ✅ Arrays
$ids = array_map( 'absint', $_POST['ids'] );
$names = array_map( 'sanitize_text_field', $_POST['names'] );
```

### Rich HTML Content

```php
// ✅ Allow specific HTML tags (post content level)
$content = wp_kses_post( $_POST['content'] );

// ✅ Custom allowed tags
$allowed = array(
	'a'      => array(
		'href'   => array(),
		'title'  => array(),
		'target' => array(),
	),
	'br'     => array(),
	'em'     => array(),
	'strong' => array(),
	'p'      => array(
		'class' => array(),
	),
);
$content = wp_kses( $_POST['content'], $allowed );

// ✅ Strip all HTML
$text = wp_strip_all_tags( $_POST['text'] );
```

---

## Output Escaping

### When to Escape

Escape data when **outputting** it - to HTML, URLs, attributes, JavaScript, etc.

### Escaping Functions

```php
// ✅ HTML content
echo esc_html( $user_input );

// ✅ HTML attributes
echo '<input value="' . esc_attr( $value ) . '">';

// ✅ URLs (in href, src, etc.)
echo '<a href="' . esc_url( $url ) . '">';
echo '<img src="' . esc_url( $image_url ) . '">';

// ✅ JavaScript strings
echo '<script>var name = "' . esc_js( $name ) . '";</script>';

// ✅ Textarea content
echo '<textarea>' . esc_textarea( $content ) . '</textarea>';

// ✅ XML content
echo '<item>' . esc_xml( $content ) . '</item>';
```

### Escaping with Translation

```php
// ✅ Escape + translate
echo esc_html__( 'Hello World', 'text-domain' );
esc_html_e( 'Hello World', 'text-domain' );

// ✅ Escape attribute + translate
echo '<input placeholder="' . esc_attr__( 'Enter name', 'text-domain' ) . '">';
esc_attr_e( 'Enter name', 'text-domain' );

// ✅ Escape with printf
printf(
	/* translators: %s: User name */
	esc_html__( 'Hello, %s!', 'text-domain' ),
	esc_html( $user_name )
);
```

### Context-Appropriate Escaping

```php
// ✅ In HTML content
<p><?php echo esc_html( $text ); ?></p>

// ✅ In HTML attribute
<div class="<?php echo esc_attr( $class ); ?>">

// ✅ In URL
<a href="<?php echo esc_url( $link ); ?>">

// ✅ In inline JavaScript
<button onclick="doSomething('<?php echo esc_js( $value ); ?>')">

// ✅ In data attribute (JSON)
<div data-config="<?php echo esc_attr( wp_json_encode( $config ) ); ?>">
```

### Allowed HTML

```php
// ✅ When you need to allow some HTML
echo wp_kses_post( $content );  // Post-level HTML

// ✅ Custom allowed HTML
$allowed = array(
	'a'      => array( 'href' => true, 'title' => true ),
	'strong' => array(),
	'em'     => array(),
);
echo wp_kses( $content, $allowed );
```

---

## Nonces (CSRF Protection)

### Creating Nonces

```php
// ✅ In forms
<form method="post">
	<?php wp_nonce_field( 'my_action', 'my_nonce' ); ?>
	<input type="text" name="data">
	<button type="submit">Save</button>
</form>

// ✅ In URLs
$url = wp_nonce_url( admin_url( 'admin.php?page=my-page' ), 'my_action' );

// ✅ Create nonce value directly
$nonce = wp_create_nonce( 'my_action' );
```

### Verifying Nonces

```php
// ✅ Verify form nonce
function handle_form_submission() {
	// Verify nonce FIRST
	if ( ! isset( $_POST['my_nonce'] ) || 
	     ! wp_verify_nonce( $_POST['my_nonce'], 'my_action' ) ) {
		wp_die( __( 'Security check failed.', 'text-domain' ) );
	}
	
	// Process form...
}

// ✅ Verify AJAX nonce
function handle_ajax_request() {
	check_ajax_referer( 'my_ajax_action', 'nonce' );
	
	// Process request...
}

// ✅ Verify URL nonce
function handle_url_action() {
	if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'my_action' ) ) {
		wp_die( __( 'Invalid request.', 'text-domain' ) );
	}
	
	// Process action...
}
```

### Nonces in REST API

```php
// ✅ Pass nonce to JavaScript
wp_localize_script( 'my-script', 'myPluginData', array(
	'nonce'   => wp_create_nonce( 'wp_rest' ),
	'ajaxUrl' => admin_url( 'admin-ajax.php' ),
) );

// ✅ JavaScript AJAX with nonce
jQuery.ajax( {
	url: myPluginData.ajaxUrl,
	method: 'POST',
	data: {
		action: 'my_action',
		nonce: myPluginData.nonce,
		// ... other data
	}
} );

// ✅ Fetch with nonce header
fetch( '/wp-json/my-plugin/v1/endpoint', {
	method: 'POST',
	headers: {
		'Content-Type': 'application/json',
		'X-WP-Nonce': myPluginData.nonce,
	},
	body: JSON.stringify( data ),
} );
```

---

## Capability Checks

### Always Verify Permissions

```php
// ✅ Check before any privileged action
function delete_item( $item_id ) {
	// Verify user can delete
	if ( ! current_user_can( 'delete_posts' ) ) {
		wp_die( __( 'You do not have permission to delete items.', 'text-domain' ) );
	}
	
	// Proceed with deletion...
}

// ✅ Check specific post permissions
function edit_post_handler( $post_id ) {
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( __( 'You cannot edit this post.', 'text-domain' ) );
	}
	
	// Proceed...
}

// ✅ Admin page capability
function add_admin_page() {
	add_menu_page(
		__( 'My Plugin', 'text-domain' ),
		__( 'My Plugin', 'text-domain' ),
		'manage_options',  // Only administrators
		'my-plugin',
		'render_page'
	);
}
```

### Common Capabilities

```php
// Content management
'edit_posts'           // Edit own posts
'edit_others_posts'    // Edit others' posts
'publish_posts'        // Publish posts
'delete_posts'         // Delete own posts
'delete_others_posts'  // Delete others' posts
'upload_files'         // Upload to media library

// Administration
'manage_options'       // Access Settings
'activate_plugins'     // Activate plugins
'edit_theme_options'   // Customize theme
'manage_categories'    // Manage taxonomies

// User management
'list_users'           // View user list
'create_users'         // Create new users
'edit_users'           // Edit user profiles
'delete_users'         // Delete users
'promote_users'        // Change user roles
```

### Complete Security Pattern

```php
// ✅ Full security check pattern
function process_secure_action() {
	// 1. Verify nonce (CSRF protection)
	if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'my_action' ) ) {
		wp_die( __( 'Security check failed.', 'text-domain' ) );
	}
	
	// 2. Verify capability (authorization)
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have permission.', 'text-domain' ) );
	}
	
	// 3. Sanitize input
	$data = sanitize_text_field( $_POST['data'] );
	
	// 4. Validate data
	if ( empty( $data ) ) {
		wp_die( __( 'Data is required.', 'text-domain' ) );
	}
	
	// 5. Process action
	// ...
}
```

---

## Database Security

### Prepared Statements (CRITICAL)

```php
// ❌ NEVER concatenate user input into queries
$results = $wpdb->get_results(
	"SELECT * FROM {$wpdb->posts} WHERE post_title = '$user_input'"
);  // SQL INJECTION VULNERABLE!

// ✅ ALWAYS use prepare()
$results = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} WHERE post_title = %s",
		$user_input
	)
);

// ✅ Multiple placeholders
$results = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} 
		 WHERE post_type = %s 
		 AND post_status = %s 
		 AND ID > %d",
		$post_type,
		$post_status,
		$min_id
	)
);
```

### Placeholder Types

```php
%s  // String (quoted automatically)
%d  // Integer
%f  // Float

// ✅ Examples
$wpdb->prepare( "WHERE name = %s", $name );       // Strings
$wpdb->prepare( "WHERE id = %d", $id );           // Integers
$wpdb->prepare( "WHERE price = %f", $price );     // Floats
```

### IN Clauses

```php
// ✅ IN clause with multiple values
$ids = array( 1, 2, 3, 4, 5 );
$placeholders = implode( ', ', array_fill( 0, count( $ids ), '%d' ) );

$results = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} WHERE ID IN ($placeholders)",
		$ids
	)
);
```

### LIKE Clauses

```php
// ✅ LIKE clause with wildcards
$search = 'test';
$results = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} WHERE post_title LIKE %s",
		'%' . $wpdb->esc_like( $search ) . '%'
	)
);

// Note: esc_like() escapes %, _, and \ in the search term
// Wildcards are added OUTSIDE the prepare placeholder
```

### Table and Column Names

```php
// ❌ Can't use prepare() for table/column names
$wpdb->prepare( "SELECT * FROM %s", $table );  // Won't work!

// ✅ Whitelist table/column names
$allowed_tables = array( 'posts', 'postmeta', 'users' );
if ( ! in_array( $table, $allowed_tables, true ) ) {
	return false;
}
$results = $wpdb->get_results(
	"SELECT * FROM {$wpdb->prefix}{$table}"
);

// ✅ Use $wpdb properties for core tables
$wpdb->posts
$wpdb->postmeta
$wpdb->users
$wpdb->usermeta
$wpdb->options
$wpdb->comments
$wpdb->terms
$wpdb->term_taxonomy
$wpdb->term_relationships
```

### Insert and Update

```php
// ✅ Use $wpdb->insert() - auto-prepares
$wpdb->insert(
	$wpdb->prefix . 'my_table',
	array(
		'name'    => $name,
		'email'   => $email,
		'status'  => $status,
	),
	array(
		'%s',  // name format
		'%s',  // email format
		'%d',  // status format
	)
);

// ✅ Use $wpdb->update() - auto-prepares
$wpdb->update(
	$wpdb->prefix . 'my_table',
	array( 'status' => 'active' ),     // Data
	array( 'id' => $id ),               // Where
	array( '%s' ),                      // Data format
	array( '%d' )                       // Where format
);

// ✅ Use $wpdb->delete() - auto-prepares
$wpdb->delete(
	$wpdb->prefix . 'my_table',
	array( 'id' => $id ),
	array( '%d' )
);
```

---

## File Security

### File Uploads

```php
// ✅ Validate file type
$allowed_types = array( 'image/jpeg', 'image/png', 'image/gif' );
$file_type = wp_check_filetype( $filename );

if ( ! in_array( $file_type['type'], $allowed_types, true ) ) {
	wp_die( __( 'Invalid file type.', 'text-domain' ) );
}

// ✅ Use WordPress upload handling
$upload = wp_handle_upload( $_FILES['my_file'], array(
	'test_form' => false,
	'mimes'     => array(
		'jpg|jpeg' => 'image/jpeg',
		'png'      => 'image/png',
		'gif'      => 'image/gif',
	),
) );

if ( isset( $upload['error'] ) ) {
	wp_die( $upload['error'] );
}
```

### File Paths

```php
// ✅ Prevent directory traversal
$filename = sanitize_file_name( $_POST['filename'] );
$filepath = wp_upload_dir()['basedir'] . '/' . $filename;

// ✅ Verify path is within allowed directory
$upload_dir = wp_upload_dir()['basedir'];
$real_path = realpath( $filepath );

if ( 0 !== strpos( $real_path, $upload_dir ) ) {
	wp_die( __( 'Invalid file path.', 'text-domain' ) );
}
```

### Including Files

```php
// ❌ Never include user input directly
include $_GET['template'];  // Remote code execution!

// ✅ Whitelist allowed templates
$allowed = array( 'header', 'footer', 'sidebar' );
$template = sanitize_file_name( $_GET['template'] );

if ( in_array( $template, $allowed, true ) ) {
	include get_template_directory() . '/templates/' . $template . '.php';
}
```

---

## Common Vulnerabilities

### Cross-Site Scripting (XSS)

```php
// ❌ Vulnerable
echo '<p>' . $_GET['message'] . '</p>';

// ✅ Safe
echo '<p>' . esc_html( $_GET['message'] ) . '</p>';
```

### SQL Injection

```php
// ❌ Vulnerable
$wpdb->query( "DELETE FROM {$wpdb->posts} WHERE ID = {$_GET['id']}" );

// ✅ Safe
$wpdb->query(
	$wpdb->prepare(
		"DELETE FROM {$wpdb->posts} WHERE ID = %d",
		absint( $_GET['id'] )
	)
);
```

### Cross-Site Request Forgery (CSRF)

```php
// ❌ Vulnerable - no nonce check
if ( isset( $_POST['delete'] ) ) {
	delete_item( $_POST['id'] );
}

// ✅ Safe - nonce verified
if ( isset( $_POST['delete'] ) ) {
	check_admin_referer( 'delete_item', '_wpnonce' );
	delete_item( absint( $_POST['id'] ) );
}
```

### Insecure Direct Object Reference

```php
// ❌ Vulnerable - no ownership check
function delete_user_post( $post_id ) {
	wp_delete_post( $post_id );
}

// ✅ Safe - verify ownership
function delete_user_post( $post_id ) {
	$post = get_post( $post_id );
	
	if ( ! $post || (int) $post->post_author !== get_current_user_id() ) {
		wp_die( __( 'You cannot delete this post.', 'text-domain' ) );
	}
	
	wp_delete_post( $post_id );
}
```

---

## Security Checklist

### Before Processing Input

- [ ] Verified nonce (CSRF protection)
- [ ] Checked user capability
- [ ] Sanitized all input data
- [ ] Validated data format and constraints

### Before Database Queries

- [ ] Used $wpdb->prepare() for all queries with variables
- [ ] Whitelisted table/column names if dynamic
- [ ] Used appropriate placeholder types (%s, %d, %f)

### Before Output

- [ ] Escaped all dynamic content
- [ ] Used context-appropriate escaping function
- [ ] Translated user-facing strings

### File Operations

- [ ] Validated file types
- [ ] Sanitized file names
- [ ] Verified paths don't escape allowed directories
- [ ] Used WordPress file handling functions
