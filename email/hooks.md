# Email Hooks

Actions and filters for customizing WordPress email functionality.

**Source:** `wp-includes/pluggable.php`, `wp-includes/ms-functions.php`

## Filters

### wp_mail

Filter all `wp_mail()` arguments before processing.

```php
apply_filters( 'wp_mail', array $args )
```

**Since:** 2.2.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Associative array of wp_mail arguments |

**$args keys:**
- `to` (string|array) - Email addresses
- `subject` (string) - Email subject
- `message` (string) - Message body
- `headers` (string|array) - Additional headers
- `attachments` (string|array) - File paths to attach
- `embeds` (string|array) - File paths to embed inline (6.9.0+)

```php
add_filter( 'wp_mail', function( $args ) {
    // Add BCC to all emails
    $args['headers'][] = 'Bcc: archive@example.com';
    return $args;
});
```

---

### pre_wp_mail

Short-circuit `wp_mail()` before any processing.

```php
apply_filters( 'pre_wp_mail', null|bool $return, array $atts )
```

**Since:** 5.7.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$return` | null\|bool | Return non-null to skip sending |
| `$atts` | array | The wp_mail arguments |

```php
add_filter( 'pre_wp_mail', function( $return, $atts ) {
    // Block emails to specific domain
    if ( str_contains( $atts['to'], '@blocked.com' ) ) {
        return false;
    }
    return $return;
}, 10, 2 );
```

---

### wp_mail_from

Filter the "From" email address.

```php
apply_filters( 'wp_mail_from', string $from_email )
```

**Since:** 2.2.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$from_email` | string | The from email address |

**Default:** `wordpress@{site_domain}`

```php
add_filter( 'wp_mail_from', function( $from ) {
    return 'noreply@example.com';
});
```

---

### wp_mail_from_name

Filter the "From" name.

```php
apply_filters( 'wp_mail_from_name', string $from_name )
```

**Since:** 2.3.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$from_name` | string | The from name |

**Default:** `WordPress`

```php
add_filter( 'wp_mail_from_name', function( $name ) {
    return get_bloginfo( 'name' );
});
```

---

### wp_mail_content_type

Filter the email content type.

```php
apply_filters( 'wp_mail_content_type', string $content_type )
```

**Since:** 2.3.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$content_type` | string | The content type |

**Default:** `text/plain` (or from Content-Type header)

```php
add_filter( 'wp_mail_content_type', function( $type ) {
    return 'text/html';
});
```

**Warning:** Setting globally to `text/html` affects all emails. Consider using per-email headers instead.

---

### wp_mail_charset

Filter the email character set.

```php
apply_filters( 'wp_mail_charset', string $charset )
```

**Since:** 2.3.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$charset` | string | The character set |

**Default:** Value from `get_bloginfo('charset')` or Content-Type header

```php
add_filter( 'wp_mail_charset', function( $charset ) {
    return 'UTF-8';
});
```

---

### wp_mail_embed_args

Filter arguments for embedded images.

```php
apply_filters( 'wp_mail_embed_args', array $args )
```

**Since:** 6.9.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Arguments for PHPMailer's `addEmbeddedImage()` |

**$args keys:**
- `path` (string) - Path to the file
- `cid` (string) - Content-ID for the image
- `name` (string) - Filename (defaults to basename)
- `encoding` (string) - Encoding type (default: `base64`)
- `type` (string) - MIME type (empty = auto-detect)
- `disposition` (string) - Disposition (default: `inline`)

---

## Actions

### phpmailer_init

Fires after PHPMailer is initialized, before sending. Primary hook for SMTP configuration.

```php
do_action_ref_array( 'phpmailer_init', array( PHPMailer &$phpmailer ) )
```

**Since:** 2.2.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$phpmailer` | PHPMailer | PHPMailer instance (passed by reference) |

**SMTP Configuration Example:**

```php
add_action( 'phpmailer_init', function( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.example.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 587;
    $phpmailer->Username   = 'user@example.com';
    $phpmailer->Password   = 'secret';
    $phpmailer->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
});
```

**Debug SMTP:**

```php
add_action( 'phpmailer_init', function( $phpmailer ) {
    $phpmailer->SMTPDebug = 2; // 0=off, 1=client, 2=client+server
    $phpmailer->Debugoutput = function( $str, $level ) {
        error_log( "PHPMailer [$level]: $str" );
    };
});
```

**Add DKIM Signing:**

```php
add_action( 'phpmailer_init', function( $phpmailer ) {
    $phpmailer->DKIM_domain   = 'example.com';
    $phpmailer->DKIM_private  = '/path/to/private.key';
    $phpmailer->DKIM_selector = 'mail';
    $phpmailer->DKIM_identity = $phpmailer->From;
});
```

---

### wp_mail_succeeded

Fires after PHPMailer successfully sends an email.

```php
do_action( 'wp_mail_succeeded', array $mail_data )
```

**Since:** 5.9.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$mail_data` | array | The email data |

**$mail_data keys:**
- `to` (array) - Recipient email addresses
- `subject` (string) - Email subject
- `message` (string) - Message body
- `headers` (array) - Email headers
- `attachments` (array) - Attachment paths
- `embeds` (array) - Embedded file paths

**Note:** Success means PHPMailer processed the request without errors. It does not guarantee delivery.

```php
add_action( 'wp_mail_succeeded', function( $data ) {
    error_log( 'Email sent to: ' . implode( ', ', $data['to'] ) );
});
```

---

### wp_mail_failed

Fires when `wp_mail()` encounters an error.

```php
do_action( 'wp_mail_failed', WP_Error $error )
```

**Since:** 4.4.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$error` | WP_Error | Error with message and mail data |

**Error data keys:**
- `to`, `subject`, `message`, `headers`, `attachments`, `embeds`
- `phpmailer_exception_code` - PHPMailer exception code

```php
add_action( 'wp_mail_failed', function( $error ) {
    error_log( 'Email failed: ' . $error->get_error_message() );
    error_log( 'To: ' . print_r( $error->get_error_data()['to'], true ) );
});
```

---

## Multisite-Specific

### fix_phpmailer_messageid

Hooked to `phpmailer_init` on multisite to set the Message-ID hostname.

```php
// In ms-default-filters.php
add_action( 'phpmailer_init', 'fix_phpmailer_messageid' );

// In ms-functions.php
function fix_phpmailer_messageid( $phpmailer ) {
    $phpmailer->Hostname = get_network()->domain;
}
```

**Since:** MU (3.0.0)

This ensures emails from multisite use the network domain in Message-ID headers rather than the server hostname.

---

## Common Patterns

### Force HTML Emails

```php
add_filter( 'wp_mail_content_type', fn() => 'text/html' );
```

### Custom From Address Site-Wide

```php
add_filter( 'wp_mail_from', fn() => 'noreply@example.com' );
add_filter( 'wp_mail_from_name', fn() => get_bloginfo( 'name' ) );
```

### Log All Emails

```php
add_action( 'wp_mail_succeeded', function( $data ) {
    global $wpdb;
    $wpdb->insert( 'email_log', [
        'to'      => implode( ', ', $data['to'] ),
        'subject' => $data['subject'],
        'sent_at' => current_time( 'mysql' ),
    ]);
});

add_action( 'wp_mail_failed', function( $error ) {
    global $wpdb;
    $data = $error->get_error_data();
    $wpdb->insert( 'email_log', [
        'to'      => implode( ', ', $data['to'] ),
        'subject' => $data['subject'],
        'error'   => $error->get_error_message(),
        'sent_at' => current_time( 'mysql' ),
    ]);
});
```

### Prevent Emails in Development

```php
add_filter( 'pre_wp_mail', function( $return, $atts ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'Email blocked: ' . $atts['subject'] );
        return true; // Pretend success
    }
    return $return;
}, 10, 2 );
```

### Redirect All Emails (Testing)

```php
add_filter( 'wp_mail', function( $args ) {
    $args['to'] = 'dev@example.com';
    $args['subject'] = '[TEST] ' . $args['subject'];
    return $args;
});
```
