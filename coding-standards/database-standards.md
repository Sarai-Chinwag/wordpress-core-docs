# WordPress Database Standards

All database operations must prevent SQL injection and follow WordPress patterns.

## The wpdb Class

### Global Access

```php
// ✅ Access the global wpdb object
global $wpdb;

// Or in class methods
public function query() {
	global $wpdb;
	// Use $wpdb
}
```

### Table Name Properties

```php
// ✅ Use $wpdb properties for core tables
$wpdb->posts           // wp_posts
$wpdb->postmeta        // wp_postmeta
$wpdb->users           // wp_users
$wpdb->usermeta        // wp_usermeta
$wpdb->options         // wp_options
$wpdb->comments        // wp_comments
$wpdb->commentmeta     // wp_commentmeta
$wpdb->terms           // wp_terms
$wpdb->term_taxonomy   // wp_term_taxonomy
$wpdb->term_relationships // wp_term_relationships
$wpdb->termmeta        // wp_termmeta
$wpdb->links           // wp_links

// ✅ Custom tables use prefix
$table = $wpdb->prefix . 'my_custom_table';  // wp_my_custom_table
```

---

## Prepared Statements

### The prepare() Method

**CRITICAL: Always use prepare() for queries with user data.**

```php
// ✅ String placeholder
$result = $wpdb->get_row(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->users} WHERE user_email = %s",
		$email
	)
);

// ✅ Integer placeholder
$result = $wpdb->get_row(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} WHERE ID = %d",
		$post_id
	)
);

// ✅ Float placeholder
$result = $wpdb->get_row(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->postmeta} WHERE meta_value = %f",
		$price
	)
);

// ✅ Multiple placeholders
$result = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} 
		 WHERE post_type = %s 
		 AND post_status = %s 
		 AND post_author = %d",
		$post_type,
		$post_status,
		$author_id
	)
);
```

### Placeholder Types

```php
%s  // String - quoted and escaped automatically
%d  // Integer - cast to integer
%f  // Float - cast to float
%i  // Identifier (table/column name) - WordPress 6.2+

// ❌ Never use %s for integers
$wpdb->prepare( "WHERE ID = %s", $id );  // Wrong

// ✅ Use correct type
$wpdb->prepare( "WHERE ID = %d", $id );  // Correct
```

### IN Clauses

```php
// ✅ Multiple values in IN clause
$ids = array( 1, 2, 3, 4, 5 );

// Create placeholders dynamically
$placeholders = implode( ', ', array_fill( 0, count( $ids ), '%d' ) );

$results = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} WHERE ID IN ($placeholders)",
		...$ids  // Spread operator (PHP 5.6+)
	)
);

// Alternative for older PHP
$results = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} WHERE ID IN ($placeholders)",
		$ids
	)
);
```

### LIKE Clauses

```php
// ✅ LIKE with proper escaping
$search_term = 'test';

$results = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} WHERE post_title LIKE %s",
		'%' . $wpdb->esc_like( $search_term ) . '%'
	)
);

// $wpdb->esc_like() escapes %, _, and \ in the search term
// Wildcards are added OUTSIDE the prepare placeholder

// ✅ Starts with
$wpdb->prepare(
	"WHERE post_title LIKE %s",
	$wpdb->esc_like( $prefix ) . '%'
);

// ✅ Ends with
$wpdb->prepare(
	"WHERE post_title LIKE %s",
	'%' . $wpdb->esc_like( $suffix )
);
```

### Table and Column Names

```php
// ❌ Can't use prepare() for identifiers (pre-WP 6.2)
$wpdb->prepare( "SELECT * FROM %s", $table );  // Won't work!

// ✅ WordPress 6.2+: Use %i placeholder for identifiers
$wpdb->prepare(
	"SELECT * FROM %i WHERE %i = %s",
	$table_name,
	$column_name,
	$value
);

// ✅ Pre-6.2: Whitelist allowed values
$allowed_columns = array( 'post_title', 'post_content', 'post_date' );
$column = sanitize_key( $_GET['orderby'] );

if ( in_array( $column, $allowed_columns, true ) ) {
	$results = $wpdb->get_results(
		"SELECT * FROM {$wpdb->posts} ORDER BY {$column}"
	);
}

// ✅ Validate table names
$allowed_tables = array( 'posts', 'users', 'options' );
if ( in_array( $table, $allowed_tables, true ) ) {
	$full_table = $wpdb->prefix . $table;
}
```

---

## Query Methods

### Select Queries

```php
// ✅ get_results() - Multiple rows
$posts = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} WHERE post_author = %d",
		$author_id
	)
);
// Returns array of objects

// ✅ get_results() with output type
$posts = $wpdb->get_results( $query, OBJECT );        // Default - objects
$posts = $wpdb->get_results( $query, OBJECT_K );      // Objects keyed by first column
$posts = $wpdb->get_results( $query, ARRAY_A );       // Associative arrays
$posts = $wpdb->get_results( $query, ARRAY_N );       // Numeric arrays

// ✅ get_row() - Single row
$post = $wpdb->get_row(
	$wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} WHERE ID = %d",
		$post_id
	)
);
// Returns object or null

// ✅ get_var() - Single value
$count = $wpdb->get_var(
	$wpdb->prepare(
		"SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_author = %d",
		$author_id
	)
);
// Returns string or null

// ✅ get_col() - Single column
$ids = $wpdb->get_col(
	$wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts} WHERE post_type = %s",
		'post'
	)
);
// Returns array of values
```

### Insert

```php
// ✅ $wpdb->insert() - Safe insert
$result = $wpdb->insert(
	$wpdb->prefix . 'my_table',
	array(
		'column1' => 'value1',
		'column2' => 123,
		'column3' => 45.67,
	),
	array(
		'%s',  // column1 format
		'%d',  // column2 format
		'%f',  // column3 format
	)
);

// Returns false on error, number of rows affected on success

// ✅ Get the inserted ID
$new_id = $wpdb->insert_id;

// ✅ Check for errors
if ( false === $result ) {
	error_log( 'Insert failed: ' . $wpdb->last_error );
}
```

### Update

```php
// ✅ $wpdb->update() - Safe update
$result = $wpdb->update(
	$wpdb->prefix . 'my_table',
	// Data to update
	array(
		'column1' => 'new_value',
		'column2' => 456,
	),
	// WHERE conditions
	array(
		'id' => $id,
	),
	// Data formats
	array(
		'%s',  // column1
		'%d',  // column2
	),
	// WHERE formats
	array(
		'%d',  // id
	)
);

// Returns false on error, number of rows affected on success (can be 0)
```

### Delete

```php
// ✅ $wpdb->delete() - Safe delete
$result = $wpdb->delete(
	$wpdb->prefix . 'my_table',
	array( 'id' => $id ),
	array( '%d' )
);

// Returns false on error, number of rows affected on success
```

### Replace

```php
// ✅ $wpdb->replace() - Insert or update if exists
$result = $wpdb->replace(
	$wpdb->prefix . 'my_table',
	array(
		'id'     => $id,       // Primary/unique key
		'column' => 'value',
	),
	array( '%d', '%s' )
);
```

### Raw Queries

```php
// ✅ $wpdb->query() - For queries that don't return data
$wpdb->query(
	$wpdb->prepare(
		"UPDATE {$wpdb->posts} SET post_status = %s WHERE ID = %d",
		'publish',
		$post_id
	)
);

// Returns number of rows affected, or false on error
```

---

## Error Handling

### Check for Errors

```php
// ✅ Check last_error after query
$result = $wpdb->get_results( $query );

if ( $wpdb->last_error ) {
	error_log( 'Database error: ' . $wpdb->last_error );
	return new WP_Error( 'db_error', $wpdb->last_error );
}

// ✅ Check return values
$inserted = $wpdb->insert( $table, $data, $format );

if ( false === $inserted ) {
	// Insert failed
	return false;
}

// ✅ Suppress errors for expected failures
$wpdb->suppress_errors( true );
$result = $wpdb->query( $query );
$wpdb->suppress_errors( false );
```

### Debug Queries

```php
// Enable query logging (in wp-config.php)
define( 'SAVEQUERIES', true );

// Access logged queries
global $wpdb;
print_r( $wpdb->queries );
// Each entry: array( query, execution_time, caller )

// Show last query
echo $wpdb->last_query;

// Show last error
echo $wpdb->last_error;
```

---

## Creating Tables

### Table Creation

```php
function my_plugin_create_tables() {
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'my_custom_table';
	$charset_collate = $wpdb->get_charset_collate();
	
	$sql = "CREATE TABLE $table_name (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		user_id bigint(20) unsigned NOT NULL,
		title varchar(255) NOT NULL,
		content longtext NOT NULL,
		status varchar(20) NOT NULL DEFAULT 'draft',
		created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		KEY user_id (user_id),
		KEY status (status)
	) $charset_collate;";
	
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
}
register_activation_hook( __FILE__, 'my_plugin_create_tables' );
```

### dbDelta Requirements

```php
// dbDelta is picky about formatting:

// ✅ Correct format
$sql = "CREATE TABLE {$table_name} (
	id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	name varchar(255) NOT NULL,
	PRIMARY KEY  (id)
)";

// Requirements:
// - Must use CREATE TABLE (not CREATE TABLE IF NOT EXISTS)
// - Column definitions on separate lines
// - TWO spaces between PRIMARY KEY and (id)
// - KEY keyword for indexes, not INDEX
// - No trailing comma after last column
```

### Version Control for Schema

```php
function my_plugin_maybe_update_db() {
	$current_version = get_option( 'my_plugin_db_version', '0' );
	
	if ( version_compare( $current_version, '1.0.0', '<' ) ) {
		my_plugin_create_tables();
		update_option( 'my_plugin_db_version', '1.0.0' );
	}
	
	if ( version_compare( $current_version, '1.1.0', '<' ) ) {
		// Add new column
		global $wpdb;
		$table = $wpdb->prefix . 'my_custom_table';
		
		$wpdb->query( "ALTER TABLE {$table} ADD COLUMN new_field varchar(100) AFTER title" );
		
		update_option( 'my_plugin_db_version', '1.1.0' );
	}
}
add_action( 'plugins_loaded', 'my_plugin_maybe_update_db' );
```

---

## Performance

### Use WordPress APIs First

```php
// ✅ Use WordPress APIs when they exist
// Posts
$posts = get_posts( $args );
$post = get_post( $id );

// Meta
$value = get_post_meta( $post_id, $key, true );
update_post_meta( $post_id, $key, $value );

// Options
$value = get_option( 'option_name' );
update_option( 'option_name', $value );

// Users
$user = get_userdata( $user_id );
$meta = get_user_meta( $user_id, $key, true );

// Terms
$terms = get_terms( $args );
$term = get_term( $term_id );

// ❌ Don't write raw SQL for operations WP APIs handle
$wpdb->get_row( "SELECT * FROM {$wpdb->posts} WHERE ID = $id" );
```

### Efficient Queries

```php
// ✅ Only select needed columns
$ids = $wpdb->get_col(
	"SELECT ID FROM {$wpdb->posts} WHERE post_status = 'publish'"
);

// ❌ Don't SELECT * when you only need one column
$posts = $wpdb->get_results(
	"SELECT * FROM {$wpdb->posts} WHERE post_status = 'publish'"
);
$ids = wp_list_pluck( $posts, 'ID' );

// ✅ Use LIMIT for pagination
$wpdb->prepare(
	"SELECT * FROM {$wpdb->posts} LIMIT %d OFFSET %d",
	$per_page,
	( $page - 1 ) * $per_page
);

// ✅ Use COUNT for totals, not fetching all rows
$total = $wpdb->get_var(
	"SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status = 'publish'"
);
```

### Batch Operations

```php
// ❌ Don't query in loops
foreach ( $post_ids as $id ) {
	$meta = get_post_meta( $id, 'my_key', true );  // N queries!
}

// ✅ Batch with single query
$meta_values = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT post_id, meta_value FROM {$wpdb->postmeta} 
		 WHERE meta_key = %s AND post_id IN ($placeholders)",
		'my_key',
		...$post_ids
	),
	OBJECT_K
);

// ✅ Or use WP_Query with 'update_post_meta_cache'
$query = new WP_Query( array(
	'post__in'                 => $post_ids,
	'update_post_meta_cache'   => true,
	'update_post_term_cache'   => false,
	'no_found_rows'            => true,
) );
```

### Caching

```php
// ✅ Use WordPress object cache
$cache_key = 'my_plugin_expensive_query_' . md5( serialize( $args ) );
$results = wp_cache_get( $cache_key, 'my_plugin' );

if ( false === $results ) {
	$results = $wpdb->get_results( $query );
	wp_cache_set( $cache_key, $results, 'my_plugin', HOUR_IN_SECONDS );
}

// ✅ Use transients for persistent cache
$results = get_transient( 'my_plugin_results' );

if ( false === $results ) {
	$results = $wpdb->get_results( $query );
	set_transient( 'my_plugin_results', $results, DAY_IN_SECONDS );
}

// ✅ Invalidate cache when data changes
function my_plugin_invalidate_cache() {
	wp_cache_delete( 'my_plugin_expensive_query', 'my_plugin' );
	delete_transient( 'my_plugin_results' );
}
add_action( 'save_post', 'my_plugin_invalidate_cache' );
```

---

## Transactions

```php
// ✅ Use transactions for multiple related operations
global $wpdb;

$wpdb->query( 'START TRANSACTION' );

try {
	$result1 = $wpdb->insert( $table1, $data1, $format1 );
	if ( false === $result1 ) {
		throw new Exception( $wpdb->last_error );
	}
	
	$result2 = $wpdb->insert( $table2, $data2, $format2 );
	if ( false === $result2 ) {
		throw new Exception( $wpdb->last_error );
	}
	
	$wpdb->query( 'COMMIT' );
	
} catch ( Exception $e ) {
	$wpdb->query( 'ROLLBACK' );
	error_log( 'Transaction failed: ' . $e->getMessage() );
	return new WP_Error( 'transaction_failed', $e->getMessage() );
}
```

---

## Security Checklist

- [ ] **Every query with variables uses prepare()**
- [ ] **Correct placeholder types** (%s, %d, %f) for data types
- [ ] **Table/column names whitelisted** if dynamic
- [ ] **esc_like() used** before adding LIKE wildcards
- [ ] **Check return values** for errors
- [ ] **Use WordPress APIs** when available (get_post, get_option, etc.)
- [ ] **Validate and sanitize** all input before database operations
