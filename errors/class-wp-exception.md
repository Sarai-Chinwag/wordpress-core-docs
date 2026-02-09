# WP_Exception

Core base Exception class for WordPress.

**Source:** `wp-includes/class-wp-exception.php`  
**Since:** 6.7.0

## Description

`WP_Exception` is the base exception class for WordPress. All future WordPress-specific exceptions should extend this class.

This provides a WordPress-specific exception type that can be caught separately from generic PHP exceptions, allowing more granular error handling.

## Class Definition

```php
class WP_Exception extends Exception {}
```

## Inheritance

```
Exception (PHP built-in)
    └── WP_Exception
        └── (future WordPress-specific exceptions)
```

## Inherited Methods

All methods are inherited from PHP's `Exception` class:

| Method | Returns | Description |
|--------|---------|-------------|
| `getMessage()` | string | Exception message |
| `getCode()` | int | Exception code |
| `getFile()` | string | Filename where exception was created |
| `getLine()` | int | Line number where exception was created |
| `getTrace()` | array | Stack trace as array |
| `getTraceAsString()` | string | Stack trace as string |
| `getPrevious()` | Throwable\|null | Previous exception |
| `__toString()` | string | String representation |

## Constructor

```php
public function __construct( 
    string $message = '', 
    int $code = 0, 
    ?Throwable $previous = null 
)
```

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$message` | string | No | `''` | Exception message |
| `$code` | int | No | `0` | Exception code |
| `$previous` | Throwable\|null | No | `null` | Previous exception for chaining |

## Usage

### Basic Exception

```php
function critical_operation() {
    if ( $failure_condition ) {
        throw new WP_Exception( 'Critical operation failed.' );
    }
}

try {
    critical_operation();
} catch ( WP_Exception $e ) {
    error_log( 'WP Exception: ' . $e->getMessage() );
}
```

### With Exception Code

```php
throw new WP_Exception( 'Database connection failed.', 500 );
```

### Exception Chaining

```php
try {
    // Some operation
} catch ( PDOException $e ) {
    throw new WP_Exception( 
        'Database error occurred.', 
        0, 
        $e  // Chain the original exception
    );
}
```

### Catching Specific vs Generic

```php
try {
    risky_operation();
} catch ( WP_Exception $e ) {
    // Handle WordPress-specific exceptions
    wp_die( $e->getMessage() );
} catch ( Exception $e ) {
    // Handle all other exceptions
    error_log( $e->getMessage() );
}
```

## Creating Custom Exceptions

Future WordPress-specific exceptions should extend `WP_Exception`:

```php
class WP_Database_Exception extends WP_Exception {
    protected $query;
    
    public function __construct( $message, $query = '', $code = 0, $previous = null ) {
        $this->query = $query;
        parent::__construct( $message, $code, $previous );
    }
    
    public function getQuery() {
        return $this->query;
    }
}
```

## WP_Exception vs WP_Error

| Aspect | WP_Exception | WP_Error |
|--------|--------------|----------|
| **Paradigm** | Exception throwing | Return value |
| **Flow control** | Automatic propagation | Explicit checking |
| **Multiple errors** | No (one message) | Yes (multiple codes/messages) |
| **Error data** | No (extend class to add) | Yes (via `add_data()`) |
| **Stack trace** | Yes | No |
| **Minimum version** | 6.7.0 | 2.1.0 |
| **Use case** | Critical/internal errors | API return values |

### When to Use WP_Exception

- Internal errors that should halt execution
- Errors that benefit from stack traces
- Modern codebases targeting 6.7.0+
- When exception propagation is desired

### When to Use WP_Error

- Public API functions (backward compatibility)
- Collecting multiple validation errors
- Attaching arbitrary data to errors
- Plugin/theme development (broader support)
