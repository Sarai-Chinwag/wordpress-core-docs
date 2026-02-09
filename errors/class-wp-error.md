# WP_Error

Container class for checking WordPress errors and error messages.

**Source:** `wp-includes/class-wp-error.php`  
**Since:** 2.1.0

## Description

WP_Error is returned by many core functions when an error occurs. Always use `is_wp_error()` to check if a function returned an error before using the result.

Supports multiple error codes, multiple messages per code, and arbitrary data attached to each code.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$errors` | array | public | Error codes and messages (`['code' => ['message1', 'message2']]`) |
| `$error_data` | array | public | Most recent data for each error code |
| `$additional_data` | array[] | protected | Previously added data (since 5.6.0) |

## Class Attributes

```php
#[AllowDynamicProperties]
class WP_Error
```

---

## Methods

### __construct()

Initializes the error. If `$code` is empty, other parameters are ignored.

```php
public function __construct( string|int $code = '', string $message = '', mixed $data = '' )
```

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$code` | string\|int | No | `''` | Error code |
| `$message` | string | No | `''` | Error message |
| `$data` | mixed | No | `''` | Error data |

**Example:**

```php
// Empty error container
$error = new WP_Error();

// With initial error
$error = new WP_Error( 'invalid_email', 'The email address is invalid.' );

// With data
$error = new WP_Error( 
    'rest_forbidden', 
    'Permission denied.', 
    array( 'status' => 403 ) 
);
```

---

### add()

Adds an error or appends an additional message to an existing error code.

```php
public function add( string|int $code, string $message, mixed $data = '' ): void
```

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$code` | string\|int | Yes | — | Error code |
| `$message` | string | Yes | — | Error message |
| `$data` | mixed | No | `''` | Error data |

**Fires:** `wp_error_added` action

**Example:**

```php
$error = new WP_Error();
$error->add( 'invalid_title', 'Title cannot be empty.' );
$error->add( 'invalid_content', 'Content is required.' );

// Multiple messages for same code
$error->add( 'validation', 'Field A is invalid.' );
$error->add( 'validation', 'Field B is invalid.' );
```

---

### add_data()

Adds data to an error code. If data already exists for the code, previous data is moved to `$additional_data`.

```php
public function add_data( mixed $data, string|int $code = '' ): void
```

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$data` | mixed | Yes | — | Error data |
| `$code` | string\|int | No | `''` | Error code (defaults to first code) |

**Example:**

```php
$error = new WP_Error( 'api_error', 'API call failed.' );
$error->add_data( array( 'status' => 500 ) );
$error->add_data( array( 'retry_after' => 60 ) ); // Previous data moved to additional_data
```

---

### get_error_code()

Retrieves the first error code.

```php
public function get_error_code(): string|int
```

**Returns:** First error code, or empty string if no errors.

**Example:**

```php
$error = new WP_Error( 'first_error', 'First message.' );
$error->add( 'second_error', 'Second message.' );

$code = $error->get_error_code(); // 'first_error'
```

---

### get_error_codes()

Retrieves all error codes.

```php
public function get_error_codes(): array
```

**Returns:** Array of error codes, or empty array if no errors.

**Example:**

```php
$error = new WP_Error();
$error->add( 'code_a', 'Message A.' );
$error->add( 'code_b', 'Message B.' );

$codes = $error->get_error_codes(); // ['code_a', 'code_b']
```

---

### get_error_message()

Gets a single error message. Returns the first message for the given code, or the first message overall if no code specified.

```php
public function get_error_message( string|int $code = '' ): string
```

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$code` | string\|int | No | `''` | Error code to retrieve message for |

**Returns:** Error message string, or empty string if none.

**Example:**

```php
$error = new WP_Error( 'not_found', 'Resource not found.' );

$message = $error->get_error_message();              // 'Resource not found.'
$message = $error->get_error_message( 'not_found' ); // 'Resource not found.'
$message = $error->get_error_message( 'other' );     // ''
```

---

### get_error_messages()

Retrieves all error messages, or all messages for a specific code.

```php
public function get_error_messages( string|int $code = '' ): string[]
```

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$code` | string\|int | No | `''` | Error code (empty for all messages) |

**Returns:** Array of error message strings.

**Example:**

```php
$error = new WP_Error();
$error->add( 'validation', 'Email invalid.' );
$error->add( 'validation', 'Name required.' );
$error->add( 'auth', 'Not authorized.' );

// All messages
$all = $error->get_error_messages(); 
// ['Email invalid.', 'Name required.', 'Not authorized.']

// Messages for specific code
$validation = $error->get_error_messages( 'validation' ); 
// ['Email invalid.', 'Name required.']
```

---

### get_error_data()

Retrieves the most recently added error data for a code.

```php
public function get_error_data( string|int $code = '' ): mixed
```

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$code` | string\|int | No | `''` | Error code (defaults to first code) |

**Returns:** Error data, or undefined if no data exists.

**Example:**

```php
$error = new WP_Error( 'api_error', 'Failed.', array( 'status' => 500 ) );

$data = $error->get_error_data(); // ['status' => 500]
```

---

### get_all_error_data()

Retrieves all error data for a code in the order it was added.

```php
public function get_all_error_data( string|int $code = '' ): mixed[]
```

**Since:** 5.6.0

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$code` | string\|int | No | `''` | Error code (defaults to first code) |

**Returns:** Array of all data items for the code.

**Example:**

```php
$error = new WP_Error( 'error', 'Message.' );
$error->add_data( array( 'attempt' => 1 ) );
$error->add_data( array( 'attempt' => 2 ) );
$error->add_data( array( 'attempt' => 3 ) );

$all_data = $error->get_all_error_data();
// [['attempt' => 1], ['attempt' => 2], ['attempt' => 3]]
```

---

### has_errors()

Verifies if the instance contains any errors.

```php
public function has_errors(): bool
```

**Since:** 5.1.0

**Returns:** `true` if errors exist, `false` otherwise.

**Example:**

```php
$error = new WP_Error();
$error->has_errors(); // false

$error->add( 'code', 'message' );
$error->has_errors(); // true
```

---

### remove()

Removes all messages and data for a specific error code.

```php
public function remove( string|int $code ): void
```

**Since:** 4.1.0

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$code` | string\|int | Yes | Error code to remove |

**Example:**

```php
$error = new WP_Error();
$error->add( 'keep', 'Keep this.' );
$error->add( 'remove', 'Remove this.' );

$error->remove( 'remove' );
$error->get_error_codes(); // ['keep']
```

---

### merge_from()

Merges errors from another WP_Error into this one.

```php
public function merge_from( WP_Error $error ): void
```

**Since:** 5.6.0

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$error` | WP_Error | Yes | Error object to merge from |

**Example:**

```php
$error1 = new WP_Error( 'a', 'Error A.' );
$error2 = new WP_Error( 'b', 'Error B.' );

$error1->merge_from( $error2 );
$error1->get_error_codes(); // ['a', 'b']
```

---

### export_to()

Exports errors from this instance to another WP_Error.

```php
public function export_to( WP_Error $error ): void
```

**Since:** 5.6.0

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$error` | WP_Error | Yes | Error object to export to |

**Example:**

```php
$source = new WP_Error( 'code', 'Message.' );
$target = new WP_Error();

$source->export_to( $target );
$target->get_error_message(); // 'Message.'
```

---

### copy_errors() (protected static)

Copies errors from one WP_Error to another.

```php
protected static function copy_errors( WP_Error $from, WP_Error $to ): void
```

**Since:** 5.6.0

Used internally by `merge_from()` and `export_to()`.

---

## Usage Patterns

### Collecting Multiple Validation Errors

```php
function validate_form( $data ) {
    $errors = new WP_Error();
    
    if ( empty( $data['email'] ) ) {
        $errors->add( 'email_required', 'Email is required.' );
    } elseif ( ! is_email( $data['email'] ) ) {
        $errors->add( 'email_invalid', 'Email is invalid.' );
    }
    
    if ( empty( $data['name'] ) ) {
        $errors->add( 'name_required', 'Name is required.' );
    }
    
    if ( $errors->has_errors() ) {
        return $errors;
    }
    
    return true;
}
```

### REST API Error Response

```php
function my_rest_callback( $request ) {
    $result = do_something();
    
    if ( is_wp_error( $result ) ) {
        return $result; // WP REST API handles WP_Error automatically
    }
    
    return new WP_REST_Response( $result, 200 );
}

// Creating REST-compatible error
return new WP_Error(
    'rest_invalid_param',
    'Invalid parameter value.',
    array( 'status' => 400 )
);
```

### Error Aggregation

```php
$all_errors = new WP_Error();

$result1 = process_item_1();
if ( is_wp_error( $result1 ) ) {
    $all_errors->merge_from( $result1 );
}

$result2 = process_item_2();
if ( is_wp_error( $result2 ) ) {
    $all_errors->merge_from( $result2 );
}

if ( $all_errors->has_errors() ) {
    return $all_errors;
}
```
