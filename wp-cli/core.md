# WP-CLI: wp core

Downloads, installs, updates, and manages a WordPress installation.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp core check-update` | Checks for WordPress updates via Version Check API |
| `wp core download` | Downloads core WordPress files |
| `wp core install` | Runs the standard WordPress installation process |
| `wp core is-installed` | Checks if WordPress is installed |
| `wp core multisite-convert` | Transforms single-site into multisite installation |
| `wp core multisite-install` | Installs WordPress multisite from scratch |
| `wp core update` | Updates WordPress to a newer version |
| `wp core update-db` | Runs the WordPress database update procedure |
| `wp core verify-checksums` | Verifies WordPress files against WordPress.org checksums |
| `wp core version` | Displays the WordPress version |

---

## wp core download

Downloads core WordPress files.

### Syntax

```bash
wp core download [<download-url>] [--path=<path>] [--locale=<locale>] [--version=<version>] [--skip-content] [--force] [--insecure] [--extract]
```

### Options

| Option | Description |
|--------|-------------|
| `[<download-url>]` | Download directly from a provided URL instead of fetching from wordpress.org |
| `--path=<path>` | Specify the path to install WordPress. Defaults to current directory |
| `--locale=<locale>` | Select which language to download |
| `--version=<version>` | Select which version to download. Accepts version number, 'latest', or 'nightly' |
| `--skip-content` | Download WP without default themes and plugins |
| `--force` | Overwrites existing files if present |
| `--insecure` | Retry download without certificate validation if TLS handshake fails |
| `--extract` | Whether to extract the downloaded file. Defaults to true |

### Examples

```bash
# Download latest WordPress
wp core download

# Download WordPress in Dutch
wp core download --locale=nl_NL

# Download specific version
wp core download --version=6.4.2

# Download to specific path
wp core download --path=/var/www/mysite

# Download without default themes and plugins
wp core download --skip-content

# Force overwrite existing files
wp core download --force

# Download nightly build
wp core download --version=nightly
```

---

## wp core install

Runs the standard WordPress installation process (the famous 5-minute install).

### Syntax

```bash
wp core install --url=<url> --title=<site-title> --admin_user=<username> [--admin_password=<password>] --admin_email=<email> [--locale=<locale>] [--skip-email]
```

### Options

| Option | Required | Description |
|--------|----------|-------------|
| `--url=<url>` | Yes | The address of the new site |
| `--title=<site-title>` | Yes | The title of the new site |
| `--admin_user=<username>` | Yes | The name of the admin user |
| `--admin_password=<password>` | No | The password for admin user. Defaults to randomly generated |
| `--admin_email=<email>` | Yes | The email address for the admin user |
| `--locale=<locale>` | No | The locale/language for installation (e.g., `de_DE`). Default: `en_US` |
| `--skip-email` | No | Don't send email notification to the new admin user |

### Examples

```bash
# Basic installation
wp core install --url=example.com --title=Example --admin_user=admin --admin_password=strongpassword --admin_email=admin@example.com

# Install with specific locale
wp core install --url=example.com --title="Mon Site" --admin_user=admin --admin_email=admin@example.com --locale=fr_FR

# Install without sending email
wp core install --url=example.com --title=Example --admin_user=admin --admin_email=admin@example.com --skip-email

# Install with password from file (avoid bash history)
wp core install --url=example.com --title=Example --admin_user=admin --admin_email=admin@example.com --prompt=admin_password < password.txt
```

### Notes

- If WordPress is installed in a subdirectory, run `wp option update siteurl` after installation
- When using custom user tables (`CUSTOM_USER_TABLE`), admin email and password are ignored if user_login already exists

---

## wp core update

Updates WordPress to a newer version.

### Syntax

```bash
wp core update [<zip>] [--minor] [--version=<version>] [--force] [--locale=<locale>] [--insecure]
```

### Alias

`wp core upgrade`

### Options

| Option | Description |
|--------|-------------|
| `[<zip>]` | Path to zip file to use instead of downloading from wordpress.org |
| `--minor` | Only perform updates for minor releases (e.g., 4.3 to 4.3.3 instead of 4.4.2) |
| `--version=<version>` | Update to a specific version. Alternatively accepts 'nightly' |
| `--force` | Update even when installed WP version is greater than requested version |
| `--locale=<locale>` | Select which language to download |
| `--insecure` | Retry download without certificate validation if TLS handshake fails |

### Examples

```bash
# Update to latest version
wp core update

# Update only minor version
wp core update --minor

# Update to specific version
wp core update --version=6.4.2

# Update from local zip file
wp core update ../wordpress-6.4.2.zip

# Force downgrade to older version
wp core update --version=6.0 --force

# Update to nightly build
wp core update --version=nightly
```

### Troubleshooting

If you see "Error: Another update is currently in progress.", run:
```bash
wp option delete core_updater.lock
```

---

## wp core version

Displays the WordPress version.

### Syntax

```bash
wp core version [--extra]
```

### Options

| Option | Description |
|--------|-------------|
| `--extra` | Show extended version information |

### Examples

```bash
# Show version number
wp core version
# Output: 6.4.2

# Show extended information
wp core version --extra
# Output includes PHP version, MySQL version, etc.
```

---

## wp core check-update

Checks for WordPress updates via Version Check API.

### Syntax

```bash
wp core check-update [--minor] [--major] [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `--minor` | Compare only the first two parts of the version number |
| `--major` | Compare only the first part of the version number |
| `--field=<field>` | Print the value of a single field for each update |
| `--fields=<fields>` | Limit output to specific fields. Options: version, update_type, package_url |
| `--format=<format>` | Output format: table, csv, count, json, yaml. Default: table |

### Examples

```bash
# Check for any updates
wp core check-update

# Check for minor updates only
wp core check-update --minor

# Output as JSON
wp core check-update --format=json
```

---

## wp core is-installed

Checks if WordPress is installed.

### Syntax

```bash
wp core is-installed [--network]
```

### Options

| Option | Description |
|--------|-------------|
| `--network` | Check if this is a multisite installation |

### Examples

```bash
# Check if installed (exit code 0 = installed, 1 = not installed)
wp core is-installed
echo $?

# Check if multisite is installed
wp core is-installed --network
```

---

## wp core update-db

Runs the WordPress database update procedure.

### Syntax

```bash
wp core update-db [--network] [--dry-run]
```

### Options

| Option | Description |
|--------|-------------|
| `--network` | Update databases for all sites on a network |
| `--dry-run` | Compare database versions without performing the update |

### Examples

```bash
# Update database after WordPress update
wp core update-db

# Update all network sites
wp core update-db --network

# Check what would be updated
wp core update-db --dry-run
```

---

## wp core verify-checksums

Verifies WordPress files against WordPress.org's checksums.

### Syntax

```bash
wp core verify-checksums [--version=<version>] [--locale=<locale>] [--insecure]
```

### Options

| Option | Description |
|--------|-------------|
| `--version=<version>` | Verify checksums against a specific version of WordPress |
| `--locale=<locale>` | Verify checksums against a specific locale of WordPress |
| `--insecure` | Retry download without certificate validation |

### Examples

```bash
# Verify current installation
wp core verify-checksums

# Verify against specific version
wp core verify-checksums --version=6.4.2
```

---

## wp core multisite-install

Installs WordPress multisite from scratch.

### Syntax

```bash
wp core multisite-install --title=<site-title> --admin_user=<username> --admin_email=<email> [--admin_password=<password>] [--base=<url-path>] [--subdomains] [--skip-email] [--skip-config]
```

### Options

| Option | Description |
|--------|-------------|
| `--title=<site-title>` | The title of the network |
| `--admin_user=<username>` | The name of the admin user |
| `--admin_email=<email>` | The email address for the admin user |
| `--admin_password=<password>` | The password for admin. Defaults to randomly generated |
| `--base=<url-path>` | Base path after the domain name. Default: / |
| `--subdomains` | Use subdomains instead of subdirectories |
| `--skip-email` | Don't send email notification |
| `--skip-config` | Don't add multisite constants to wp-config.php |

### Examples

```bash
# Install subdirectory multisite
wp core multisite-install --title="My Network" --admin_user=admin --admin_email=admin@example.com

# Install subdomain multisite
wp core multisite-install --title="My Network" --admin_user=admin --admin_email=admin@example.com --subdomains
```

---

## wp core multisite-convert

Transforms an existing single-site installation into a multisite installation.

### Syntax

```bash
wp core multisite-convert [--title=<network-title>] [--base=<url-path>] [--subdomains]
```

### Options

| Option | Description |
|--------|-------------|
| `--title=<network-title>` | The title of the new network |
| `--base=<url-path>` | Base path after the domain name. Default: / |
| `--subdomains` | Use subdomains instead of subdirectories |

### Examples

```bash
# Convert to subdirectory multisite
wp core multisite-convert --title="My Network"

# Convert to subdomain multisite
wp core multisite-convert --title="My Network" --subdomains
```
