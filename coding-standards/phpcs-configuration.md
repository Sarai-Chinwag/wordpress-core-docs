# WordPress PHPCS Configuration

PHP_CodeSniffer (PHPCS) with WordPress Coding Standards (WPCS) enforces coding standards automatically.

## Installation

### Via Composer (Recommended)

```bash
# In your plugin/theme directory
composer require --dev \
	squizlabs/php_codesniffer \
	wp-coding-standards/wpcs \
	phpcompatibility/phpcompatibility-wp \
	dealerdirect/phpcodesniffer-composer-installer
```

The `phpcodesniffer-composer-installer` automatically registers the standards with PHPCS.

### Global Installation

```bash
# Install PHPCS globally
composer global require squizlabs/php_codesniffer

# Install WPCS
composer global require wp-coding-standards/wpcs

# Register WPCS with PHPCS
phpcs --config-set installed_paths ~/.composer/vendor/wp-coding-standards/wpcs
```

---

## Configuration Files

### Basic phpcs.xml

```xml
<?xml version="1.0"?>
<ruleset name="My Plugin Coding Standards">
	<description>Coding standards for My Plugin.</description>

	<!-- Scan these files -->
	<file>.</file>

	<!-- Exclude directories -->
	<exclude-pattern>/vendor/*</exclude-pattern>
	<exclude-pattern>/node_modules/*</exclude-pattern>
	<exclude-pattern>/tests/*</exclude-pattern>
	<exclude-pattern>/build/*</exclude-pattern>
	<exclude-pattern>/assets/*</exclude-pattern>

	<!-- Show progress and colors -->
	<arg value="ps"/>
	<arg name="colors"/>

	<!-- Only check PHP files -->
	<arg name="extensions" value="php"/>

	<!-- Use WordPress standards -->
	<rule ref="WordPress"/>

	<!-- Set minimum PHP version -->
	<config name="minimum_wp_version" value="6.0"/>

	<!-- Set text domain -->
	<config name="text_domain" value="my-plugin"/>

	<!-- Set prefixes -->
	<rule ref="WordPress.NamingConventions.PrefixAllGlobals">
		<properties>
			<property name="prefixes" type="array">
				<element value="my_plugin"/>
				<element value="My_Plugin"/>
			</property>
		</properties>
	</rule>
</ruleset>
```

### Comprehensive phpcs.xml

```xml
<?xml version="1.0"?>
<ruleset name="My Plugin Standards">
	<description>Custom ruleset for My Plugin</description>

	<!-- =================================================================== -->
	<!-- File Scanning Configuration -->
	<!-- =================================================================== -->
	
	<file>.</file>
	
	<exclude-pattern>/vendor/*</exclude-pattern>
	<exclude-pattern>/node_modules/*</exclude-pattern>
	<exclude-pattern>/build/*</exclude-pattern>
	<exclude-pattern>/dist/*</exclude-pattern>
	<exclude-pattern>/tests/*</exclude-pattern>
	<exclude-pattern>*.min.js</exclude-pattern>
	<exclude-pattern>*.asset.php</exclude-pattern>
	
	<arg value="ps"/>
	<arg name="colors"/>
	<arg name="extensions" value="php"/>
	<arg name="parallel" value="8"/>

	<!-- =================================================================== -->
	<!-- WordPress Standards -->
	<!-- =================================================================== -->
	
	<!-- Use WordPress-Extra (includes WordPress-Core) -->
	<rule ref="WordPress-Extra">
		<!-- Allow short array syntax -->
		<exclude name="Universal.Arrays.DisallowShortArraySyntax"/>
	</rule>

	<!-- WordPress documentation standards -->
	<rule ref="WordPress-Docs"/>

	<!-- =================================================================== -->
	<!-- PHP Compatibility -->
	<!-- =================================================================== -->
	
	<rule ref="PHPCompatibilityWP"/>
	<config name="testVersion" value="7.4-"/>

	<!-- =================================================================== -->
	<!-- WordPress Version -->
	<!-- =================================================================== -->
	
	<config name="minimum_wp_version" value="6.0"/>

	<!-- =================================================================== -->
	<!-- Text Domain -->
	<!-- =================================================================== -->
	
	<rule ref="WordPress.WP.I18n">
		<properties>
			<property name="text_domain" type="array">
				<element value="my-plugin"/>
			</property>
		</properties>
	</rule>

	<!-- =================================================================== -->
	<!-- Prefixes for Global Items -->
	<!-- =================================================================== -->
	
	<rule ref="WordPress.NamingConventions.PrefixAllGlobals">
		<properties>
			<property name="prefixes" type="array">
				<element value="my_plugin"/>
				<element value="My_Plugin"/>
				<element value="MY_PLUGIN"/>
			</property>
		</properties>
	</rule>

	<!-- =================================================================== -->
	<!-- Customizations -->
	<!-- =================================================================== -->
	
	<!-- Allow // comments for inline documentation -->
	<rule ref="Squiz.Commenting.InlineComment.InvalidEndChar">
		<severity>0</severity>
	</rule>

	<!-- Allow short ternary -->
	<rule ref="WordPress.PHP.DisallowShortTernary.Found">
		<severity>0</severity>
	</rule>

	<!-- More specific error messages for security issues -->
	<rule ref="WordPress.Security.EscapeOutput">
		<properties>
			<property name="customEscapingFunctions" type="array">
				<element value="my_plugin_escape_custom"/>
			</property>
		</properties>
	</rule>

	<!-- Additional sanitization functions -->
	<rule ref="WordPress.Security.ValidatedSanitizedInput">
		<properties>
			<property name="customSanitizingFunctions" type="array">
				<element value="my_plugin_sanitize_custom"/>
			</property>
		</properties>
	</rule>

	<!-- Allowed database direct queries tables -->
	<rule ref="WordPress.DB.DirectDatabaseQuery">
		<properties>
			<property name="customCacheGetFunctions" type="array">
				<element value="my_plugin_cache_get"/>
			</property>
			<property name="customCacheSetFunctions" type="array">
				<element value="my_plugin_cache_set"/>
			</property>
		</properties>
	</rule>

</ruleset>
```

---

## Standard Rulesets

### Available Rulesets

```xml
<!-- WordPress Core - Basic coding style -->
<rule ref="WordPress-Core"/>

<!-- WordPress Extra - Core + Best Practices -->
<rule ref="WordPress-Extra"/>

<!-- WordPress Docs - Documentation requirements -->
<rule ref="WordPress-Docs"/>

<!-- WordPress VIP - Stricter rules for VIP hosting -->
<rule ref="WordPress-VIP-Go"/>

<!-- WordPress - All of the above (Core, Extra, Docs) -->
<rule ref="WordPress"/>
```

### Recommended Setup

```xml
<!-- For most plugins/themes -->
<rule ref="WordPress-Extra"/>
<rule ref="WordPress-Docs"/>
<rule ref="PHPCompatibilityWP"/>
```

---

## Running PHPCS

### Command Line

```bash
# Check current directory
phpcs

# Check specific file or directory
phpcs includes/
phpcs my-plugin.php

# Use specific standard
phpcs --standard=WordPress .

# Show sniff codes (useful for excluding rules)
phpcs -s

# Fix automatically fixable issues
phpcbf

# Generate report
phpcs --report=summary
phpcs --report=full
phpcs --report=json > report.json
```

### Composer Scripts

```json
{
	"scripts": {
		"lint": "phpcs",
		"lint:fix": "phpcbf",
		"lint:report": "phpcs --report=summary"
	}
}
```

```bash
composer lint
composer lint:fix
```

---

## Important Sniffs

### Security Sniffs

```xml
<!-- CRITICAL: Never disable these -->

<!-- SQL Injection Prevention -->
<rule ref="WordPress.DB.PreparedSQL"/>
<rule ref="WordPress.DB.PreparedSQLPlaceholders"/>

<!-- XSS Prevention -->
<rule ref="WordPress.Security.EscapeOutput"/>

<!-- Input Validation -->
<rule ref="WordPress.Security.ValidatedSanitizedInput"/>
<rule ref="WordPress.Security.NonceVerification"/>

<!-- Safe Redirects -->
<rule ref="WordPress.Security.SafeRedirect"/>

<!-- Filesystem Security -->
<rule ref="WordPress.WP.AlternativeFunctions"/>
```

### Security Sniff Examples

```php
// WordPress.DB.PreparedSQL - Triggers on:
$wpdb->query( "SELECT * FROM $table WHERE id = $id" );  // Error!

// WordPress.Security.EscapeOutput - Triggers on:
echo $user_input;  // Error!

// WordPress.Security.ValidatedSanitizedInput - Triggers on:
$value = $_POST['key'];  // Error! (not sanitized)

// WordPress.Security.NonceVerification - Triggers on:
if ( isset( $_POST['action'] ) ) {  // Error! (no nonce check)
```

### Code Quality Sniffs

```xml
<!-- Naming conventions -->
<rule ref="WordPress.NamingConventions.ValidFunctionName"/>
<rule ref="WordPress.NamingConventions.ValidVariableName"/>
<rule ref="WordPress.NamingConventions.ValidHookName"/>

<!-- Prevent deprecated functions -->
<rule ref="WordPress.WP.DeprecatedFunctions"/>
<rule ref="WordPress.WP.DeprecatedClasses"/>
<rule ref="WordPress.WP.DeprecatedParameters"/>

<!-- Internationalization -->
<rule ref="WordPress.WP.I18n"/>

<!-- Performance -->
<rule ref="WordPress.DB.SlowDBQuery"/>
<rule ref="WordPress.CodeAnalysis.AssignmentInCondition"/>
```

---

## Excluding Rules

### In Configuration

```xml
<!-- Exclude entire sniff -->
<rule ref="WordPress">
	<exclude name="WordPress.Files.FileName.InvalidClassFileName"/>
</rule>

<!-- Exclude only for specific files -->
<rule ref="WordPress.WP.AlternativeFunctions">
	<exclude-pattern>*/bin/*</exclude-pattern>
</rule>

<!-- Change severity -->
<rule ref="WordPress.PHP.YodaConditions.NotYoda">
	<severity>5</severity>  <!-- 0-10, 5 is warning, 10 is error -->
</rule>

<!-- Change to warning instead of error -->
<rule ref="WordPress.DB.DirectDatabaseQuery.DirectQuery">
	<type>warning</type>
</rule>
```

### Inline Suppression

```php
// Disable for next line
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $trusted_html;

// Disable for specific sniff
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery -- Caching handled separately
$results = $wpdb->get_results( $query );

// Disable for block
// phpcs:disable WordPress.Security.EscapeOutput
echo $html_1;
echo $html_2;
// phpcs:enable WordPress.Security.EscapeOutput

// Disable entire file
// phpcs:ignoreFile
```

### When to Suppress (and When Not To)

```php
// ✅ OK to suppress - trusted source, documented
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Output from wp_kses_post()
echo wp_kses_post( $content );

// ✅ OK to suppress - intentional direct query with caching
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Custom caching implemented
$results = my_plugin_cached_query( $query );

// ❌ NEVER suppress these without extremely good reason
// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared  // SQL INJECTION RISK!
// phpcs:ignore WordPress.Security.ValidatedSanitizedInput  // XSS/INJECTION RISK!
// phpcs:ignore WordPress.Security.NonceVerification  // CSRF RISK!
```

---

## IDE Integration

### VS Code

Install `phpcs` extension, then in `settings.json`:

```json
{
	"phpcs.enable": true,
	"phpcs.standard": "WordPress",
	"phpcs.executablePath": "./vendor/bin/phpcs",
	"phpcs.autoConfigSearch": true,
	"[php]": {
		"editor.formatOnSave": false
	}
}
```

### PHPStorm

1. Settings → PHP → Quality Tools → PHP_CodeSniffer
2. Set path to `vendor/bin/phpcs`
3. Settings → Editor → Inspections → PHP → Quality Tools
4. Enable "PHP_CodeSniffer validation"
5. Set coding standard to "WordPress" or "Custom" (point to phpcs.xml)

---

## CI/CD Integration

### GitHub Actions

```yaml
name: PHP Coding Standards

on: [push, pull_request]

jobs:
  phpcs:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          tools: composer, cs2pr
      
      - name: Install dependencies
        run: composer install
      
      - name: Run PHPCS
        run: vendor/bin/phpcs --report=checkstyle | cs2pr
```

### GitLab CI

```yaml
phpcs:
  stage: lint
  image: php:8.2
  before_script:
    - composer install --no-interaction
  script:
    - vendor/bin/phpcs --report=summary
  allow_failure: false
```

---

## Common Errors and Fixes

### Missing Text Domain

```php
// Error: Text domain missing
__( 'Hello' );

// Fix:
__( 'Hello', 'my-plugin' );
```

### Unprepared SQL

```php
// Error: Use placeholders and $wpdb->prepare()
$wpdb->query( "DELETE FROM $table WHERE id = $id" );

// Fix:
$wpdb->query(
	$wpdb->prepare( "DELETE FROM {$table} WHERE id = %d", $id )
);
```

### Unescaped Output

```php
// Error: Output should be escaped
echo $title;

// Fix:
echo esc_html( $title );
```

### Unsanitized Input

```php
// Error: Detected usage of a non-sanitized input variable
$name = $_POST['name'];

// Fix:
$name = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
```

### Missing Nonce

```php
// Error: Processing form data without nonce verification
if ( isset( $_POST['save'] ) ) {
	update_option( 'my_option', $_POST['value'] );
}

// Fix:
if ( isset( $_POST['save'] ) ) {
	check_admin_referer( 'my_action', 'my_nonce' );
	update_option( 'my_option', sanitize_text_field( wp_unslash( $_POST['value'] ) ) );
}
```

### Yoda Conditions

```php
// Error: Use Yoda Condition checks
if ( $value === true ) {}

// Fix:
if ( true === $value ) {}
```

### Direct Database Query

```php
// Warning: Usage of a direct database call is discouraged
$results = $wpdb->get_results( $query );

// Fix - either cache:
$cache_key = 'my_query_' . md5( $query );
$results = wp_cache_get( $cache_key );
if ( false === $results ) {
	$results = $wpdb->get_results( $query );
	wp_cache_set( $cache_key, $results );
}

// Or suppress with reason:
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery -- Custom table not cached
$results = $wpdb->get_results( $query );
```

---

## Quick Reference

```bash
# Install
composer require --dev wp-coding-standards/wpcs dealerdirect/phpcodesniffer-composer-installer

# Run
vendor/bin/phpcs           # Check
vendor/bin/phpcbf          # Fix automatically

# Show sniff codes (for excluding)
vendor/bin/phpcs -s

# Check specific files
vendor/bin/phpcs includes/class-main.php

# Generate reports
vendor/bin/phpcs --report=summary
vendor/bin/phpcs --report=json > report.json
```
