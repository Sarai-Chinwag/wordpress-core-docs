# WP_PHPMailer

WordPress extension of PHPMailer providing internationalized error messages.

**Since:** 6.8.0  
**Source:** `wp-includes/class-wp-phpmailer.php`  
**Extends:** `PHPMailer\PHPMailer\PHPMailer`

## Purpose

`WP_PHPMailer` overrides PHPMailer's language handling to use WordPress's internationalization system (`__()`). This ensures error messages are translated according to the site's locale rather than PHPMailer's built-in language files.

## Constructor

```php
public function __construct( $exceptions = false )
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$exceptions` | bool | `false` | Whether to throw exceptions for errors |

Calls parent constructor and immediately sets language strings.

## Methods

### setLanguage()

```php
public static function setLanguage( $langcode = 'en', $lang_path = '' )
```

Overrides PHPMailer's `setLanguage()` to populate `static::$language` with WordPress-translated strings.

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$langcode` | string | `'en'` | **Unused.** Ignored by WordPress implementation |
| `$lang_path` | string | `''` | **Unused.** Ignored by WordPress implementation |

**Returns:** `true` (always)

### Translated Error Messages

| Key | English Message |
|-----|-----------------|
| `authenticate` | SMTP Error: Could not authenticate. |
| `buggy_php` | Your version of PHP is affected by a bug... |
| `connect_host` | SMTP Error: Could not connect to SMTP host. |
| `data_not_accepted` | SMTP Error: Data not accepted. |
| `empty_message` | Message body empty |
| `encoding` | Unknown encoding: |
| `execute` | Could not execute: |
| `extension_missing` | Extension missing: |
| `file_access` | Could not access file: |
| `file_open` | File Error: Could not open file: |
| `from_failed` | The following From address failed: |
| `instantiate` | Could not instantiate mail function. |
| `invalid_address` | Invalid address: |
| `invalid_header` | Invalid header name or value |
| `invalid_hostentry` | Invalid host entry: |
| `invalid_host` | Invalid host: |
| `mailer_not_supported` | mailer is not supported. |
| `provide_address` | You must provide at least one recipient email address. |
| `recipients_failed` | SMTP Error: The following recipients failed: |
| `signing` | Signing Error: |
| `smtp_code` | SMTP code: |
| `smtp_code_ex` | Additional SMTP info: |
| `smtp_connect_failed` | SMTP connect() failed. |
| `smtp_detail` | Detail: |
| `smtp_error` | SMTP server error: |
| `variable_set` | Cannot set or reset variable: |
| `no_smtputf8` | Server does not support SMTPUTF8 needed to send to Unicode addresses |
| `imap_recommended` | Using simplified address parser is not recommended... |
| `deprecated_argument` | Argument $useimap is deprecated |

## Usage

WordPress automatically uses `WP_PHPMailer` when `wp_mail()` is called:

```php
// In wp_mail() - wp-includes/pluggable.php
if ( ! ( $phpmailer instanceof PHPMailer\PHPMailer\PHPMailer ) ) {
    require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
    require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
    require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
    require_once ABSPATH . WPINC . '/class-wp-phpmailer.php';
    $phpmailer = new WP_PHPMailer( true );

    $phpmailer::$validator = static function ( $email ) {
        return (bool) is_email( $email );
    };
}
```

Note: WordPress sets `$exceptions = true` and replaces PHPMailer's email validator with WordPress's `is_email()` function.

## Inherited Properties

Key properties from `PHPMailer\PHPMailer\PHPMailer`:

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$Mailer` | string | `'mail'` | Send method: mail, sendmail, smtp |
| `$Host` | string | `'localhost'` | SMTP host(s) |
| `$Port` | int | `25` | SMTP port |
| `$SMTPAuth` | bool | `false` | Enable SMTP authentication |
| `$Username` | string | `''` | SMTP username |
| `$Password` | string | `''` | SMTP password |
| `$SMTPSecure` | string | `''` | Encryption: '', 'tls', 'ssl' |
| `$SMTPAutoTLS` | bool | `true` | Auto-enable TLS if supported |
| `$From` | string | `''` | From email address |
| `$FromName` | string | `''` | From name |
| `$Subject` | string | `''` | Email subject |
| `$Body` | string | `''` | Email body (HTML or plain) |
| `$AltBody` | string | `''` | Plain-text alternative body |
| `$CharSet` | string | `'iso-8859-1'` | Character set |
| `$ContentType` | string | `'text/plain'` | MIME content type |
| `$Encoding` | string | `'8bit'` | Message encoding |
| `$Timeout` | int | `300` | SMTP timeout in seconds |
| `$SMTPDebug` | int | `0` | Debug output level (0-4) |

## Inherited Methods

| Method | Description |
|--------|-------------|
| `send()` | Send the email |
| `isMail()` | Set mailer to use PHP mail() |
| `isSMTP()` | Set mailer to use SMTP |
| `isSendmail()` | Set mailer to use sendmail |
| `setFrom($address, $name)` | Set From address |
| `addAddress($address, $name)` | Add To recipient |
| `addCC($address, $name)` | Add CC recipient |
| `addBCC($address, $name)` | Add BCC recipient |
| `addReplyTo($address, $name)` | Add Reply-To address |
| `addAttachment($path, $name)` | Add file attachment |
| `addEmbeddedImage(...)` | Add inline embedded image |
| `addCustomHeader($header)` | Add custom header |
| `isHTML($isHtml)` | Set HTML mode |
| `clearAllRecipients()` | Clear all recipients |
| `clearAttachments()` | Clear attachments |
| `clearCustomHeaders()` | Clear custom headers |
| `clearReplyTos()` | Clear Reply-To addresses |

## Constants

From `PHPMailer\PHPMailer\PHPMailer`:

```php
// Character sets
const CHARSET_ASCII = 'us-ascii';
const CHARSET_ISO88591 = 'iso-8859-1';
const CHARSET_UTF8 = 'utf-8';

// Content types
const CONTENT_TYPE_PLAINTEXT = 'text/plain';
const CONTENT_TYPE_TEXT_HTML = 'text/html';
const CONTENT_TYPE_MULTIPART_ALTERNATIVE = 'multipart/alternative';
const CONTENT_TYPE_MULTIPART_MIXED = 'multipart/mixed';
const CONTENT_TYPE_MULTIPART_RELATED = 'multipart/related';

// Encodings
const ENCODING_7BIT = '7bit';
const ENCODING_8BIT = '8bit';
const ENCODING_BASE64 = 'base64';
const ENCODING_QUOTED_PRINTABLE = 'quoted-printable';

// Encryption
const ENCRYPTION_STARTTLS = 'tls';
const ENCRYPTION_SMTPS = 'ssl';
```
