# Email System

WordPress email architecture built on PHPMailer with extensive hook-based customization.

**Source:** `wp-includes/pluggable.php`, `wp-includes/PHPMailer/`, `wp-includes/class-wp-phpmailer.php`

## Components

| Component | Description |
|-----------|-------------|
| [class-wp-phpmailer.md](./class-wp-phpmailer.md) | WordPress PHPMailer extension with i18n |
| [hooks.md](./hooks.md) | All email-related actions and filters |

## Architecture

WordPress uses a bundled copy of PHPMailer (v7.x) in the `PHPMailer\PHPMailer` namespace. The library is extended by `WP_PHPMailer` to provide WordPress-specific internationalization.

### File Structure

```
wp-includes/
├── class-phpmailer.php        # Deprecated shim → PHPMailer/PHPMailer.php
├── class-smtp.php             # Deprecated shim → PHPMailer/SMTP.php  
├── class-pop3.php             # Standalone POP3 class (RFC 1939)
├── class-wp-phpmailer.php     # WordPress PHPMailer extension
└── PHPMailer/
    ├── PHPMailer.php          # Main PHPMailer class
    ├── SMTP.php               # SMTP transport class
    └── Exception.php          # PHPMailer exceptions
```

### Deprecation Notes

Since WordPress 5.5.0:
- `class-phpmailer.php` → Use `PHPMailer\PHPMailer\PHPMailer` directly
- `class-smtp.php` → Use `PHPMailer\PHPMailer\SMTP` directly

Both legacy files create class aliases for backward compatibility.

## wp_mail() Flow

The primary email function with extensive filtering at every stage.

```
wp_mail($to, $subject, $message, $headers, $attachments, $embeds)
    │
    ├── apply_filters('wp_mail')              # Filter all arguments
    │
    ├── apply_filters('pre_wp_mail')          # Short-circuit opportunity
    │   └── Return non-null to skip sending
    │
    ├── Instantiate WP_PHPMailer (if needed)
    │   └── Stored in global $phpmailer
    │
    ├── Parse headers (From, CC, BCC, Reply-To, Content-Type)
    │
    ├── Set From address
    │   ├── apply_filters('wp_mail_from')
    │   └── apply_filters('wp_mail_from_name')
    │
    ├── Add recipients (To, CC, BCC, Reply-To)
    │
    ├── Configure content
    │   ├── apply_filters('wp_mail_content_type')
    │   └── apply_filters('wp_mail_charset')
    │
    ├── Add attachments and embeds
    │   └── apply_filters('wp_mail_embed_args')
    │
    ├── do_action_ref_array('phpmailer_init', [&$phpmailer])
    │   └── Last chance to modify PHPMailer instance
    │
    └── $phpmailer->send()
        ├── Success: do_action('wp_mail_succeeded')
        └── Failure: do_action('wp_mail_failed')
```

## Transport Methods

PHPMailer supports three transport methods, configured via `$phpmailer->Mailer`:

| Method | Property | Description |
|--------|----------|-------------|
| `mail` | `isMail()` | PHP's `mail()` function (default) |
| `sendmail` | `isSendmail()` | Direct sendmail binary |
| `smtp` | `isSMTP()` | SMTP server connection |

WordPress defaults to `mail`. Switch to SMTP via `phpmailer_init`:

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

## Global Instance

WordPress maintains a single PHPMailer instance in `global $phpmailer`. This instance persists across multiple `wp_mail()` calls within a request.

The instance is cleared and reset at the start of each `wp_mail()` call:
- `clearAllRecipients()`
- `clearAttachments()`
- `clearCustomHeaders()`
- `clearReplyTos()`
- Reset `Body`, `AltBody`, `Encoding`

## Default From Address

When no `From:` header is provided:
- **Name:** `WordPress`
- **Email:** `wordpress@{site_domain}` (strips `www.` prefix)

Override via `wp_mail_from` and `wp_mail_from_name` filters.

## Content Types

| Type | When Used |
|------|-----------|
| `text/plain` | Default, no Content-Type header |
| `text/html` | Content-Type header contains `text/html` |
| `multipart/*` | When boundary is specified in headers |

The `text/html` content type triggers `$phpmailer->isHTML(true)`.

## Embeds (Since 6.9.0)

The `$embeds` parameter allows inline image embedding:

```php
wp_mail(
    'user@example.com',
    'Subject',
    '<img src="cid:logo">',
    ['Content-Type: text/html'],
    [],
    ['logo' => '/path/to/logo.png']
);
```

## Error Handling

PHPMailer throws `PHPMailer\PHPMailer\Exception` on failures. WordPress catches these and fires `wp_mail_failed` with a `WP_Error` containing:
- Exception message
- Exception code
- Original mail data (to, subject, message, headers, attachments, embeds)

## Multisite Considerations

On multisite, `fix_phpmailer_messageid()` is hooked to `phpmailer_init` to set the hostname for Message-ID generation to the network domain.
