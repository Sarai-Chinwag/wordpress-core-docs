# WP-CLI: wp user

Manages users, along with their roles, capabilities, and meta.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp user add-cap` | Adds a capability to a user |
| `wp user add-role` | Adds a role for a user |
| `wp user application-password` | Manages application passwords |
| `wp user check-password` | Checks if a user's password is valid |
| `wp user create` | Creates a new user |
| `wp user delete` | Deletes one or more users from the current site |
| `wp user exists` | Verifies whether a user exists |
| `wp user generate` | Generates some users |
| `wp user get` | Gets details about a user |
| `wp user import-csv` | Imports users from a CSV file |
| `wp user list` | Lists users |
| `wp user list-caps` | Lists all capabilities for a user |
| `wp user meta` | Manages user custom fields |
| `wp user remove-cap` | Removes a user's capability |
| `wp user remove-role` | Removes a user's role |
| `wp user reset-password` | Resets the password for one or more users |
| `wp user session` | Destroys and lists a user's sessions |
| `wp user set-role` | Sets the user role |
| `wp user signup` | Manages signups on multisite |
| `wp user spam` | Marks users as spam on multisite |
| `wp user term` | Manages user terms |
| `wp user unspam` | Removes users from spam on multisite |
| `wp user update` | Updates an existing user |

---

## wp user create

Creates a new user.

### Syntax

```bash
wp user create <user-login> <user-email> [--role=<role>] [--user_pass=<password>] [--user_registered=<yyyy-mm-dd-hh-ii-ss>] [--display_name=<name>] [--user_nicename=<nice_name>] [--user_url=<url>] [--nickname=<nickname>] [--first_name=<first_name>] [--last_name=<last_name>] [--description=<description>] [--rich_editing=<rich_editing>] [--send-email] [--porcelain]
```

### Options

| Option | Description |
|--------|-------------|
| `<user-login>` | The login of the user to create |
| `<user-email>` | The email address of the user to create |
| `--role=<role>` | The role: administrator, editor, author, contributor, subscriber. Default: default role |
| `--user_pass=<password>` | The user password. Default: randomly generated |
| `--user_registered=<yyyy-mm-dd-hh-ii-ss>` | The date the user registered. Default: current date |
| `--display_name=<name>` | The display name |
| `--user_nicename=<nice_name>` | URL-friendly name for the user |
| `--user_url=<url>` | The user's website URL |
| `--nickname=<nickname>` | The user's nickname |
| `--first_name=<first_name>` | The user's first name |
| `--last_name=<last_name>` | The user's last name |
| `--description=<description>` | Content about the user |
| `--rich_editing=<rich_editing>` | Whether to enable the rich editor |
| `--send-email` | Send an email with new account details |
| `--porcelain` | Output just the new user id |

### Examples

```bash
# Create basic user
wp user create bob bob@example.com

# Create user with role
wp user create bob bob@example.com --role=author

# Create user with password
wp user create bob bob@example.com --user_pass=mypassword123

# Create admin user
wp user create admin admin@example.com --role=administrator --user_pass=adminpass

# Create user with full details
wp user create john john@example.com --role=editor --first_name=John --last_name=Doe --display_name="John Doe"

# Create user and send welcome email
wp user create bob bob@example.com --send-email

# Get just the user ID
wp user create bob bob@example.com --porcelain
```

---

## wp user delete

Deletes one or more users from the current site.

### Syntax

```bash
wp user delete <user>... [--network] [--reassign=<user-id>] [--yes]
```

### Options

| Option | Description |
|--------|-------------|
| `<user>...` | User ID, login, or email of user(s) to delete |
| `--network` | On multisite, delete the user from the entire network |
| `--reassign=<user-id>` | Reassign posts to this user ID |
| `--yes` | Answer yes to confirmation message |

### Examples

```bash
# Delete user and reassign posts
wp user delete 123 --reassign=567

# Delete user without confirmation
wp user delete 123 --yes

# Delete user by login
wp user delete bob --reassign=1

# Delete from entire network (multisite)
wp user delete 123 --network --yes

# Delete multiple users
wp user delete 123 456 789 --reassign=1 --yes
```

---

## wp user list

Lists users.

### Syntax

```bash
wp user list [--role=<role>] [--<field>=<value>] [--network] [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `--role=<role>` | Limit to users of a specific role |
| `--<field>=<value>` | Filter by a field value |
| `--network` | List all users in the network (multisite) |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, ids, json, count, yaml |

### Available Fields

- ID
- user_login
- display_name
- user_email
- user_registered
- roles

### Examples

```bash
# List all users
wp user list

# List user IDs only
wp user list --field=ID

# List administrators
wp user list --role=administrator

# List as JSON
wp user list --format=json

# List specific fields
wp user list --fields=ID,user_login,user_email

# Count users
wp user list --format=count

# List users by role
wp user list --role=subscriber
```

---

## wp user update

Updates an existing user.

### Syntax

```bash
wp user update <user>... [--user_pass=<password>] [--user_nicename=<nice_name>] [--user_url=<url>] [--user_email=<email>] [--display_name=<name>] [--nickname=<nickname>] [--first_name=<first_name>] [--last_name=<last_name>] [--description=<description>] [--rich_editing=<rich_editing>] [--user_registered=<yyyy-mm-dd-hh-ii-ss>] [--role=<role>] [--skip-email]
```

### Options

| Option | Description |
|--------|-------------|
| `<user>...` | User ID, login, or email to update |
| `--user_pass=<password>` | New password |
| `--user_nicename=<nice_name>` | URL-friendly name |
| `--user_url=<url>` | User's website |
| `--user_email=<email>` | New email address |
| `--display_name=<name>` | Display name |
| `--nickname=<nickname>` | Nickname |
| `--first_name=<first_name>` | First name |
| `--last_name=<last_name>` | Last name |
| `--description=<description>` | Bio description |
| `--rich_editing=<rich_editing>` | Enable/disable rich editor |
| `--user_registered=<yyyy-mm-dd-hh-ii-ss>` | Registration date |
| `--role=<role>` | New role |
| `--skip-email` | Don't send email notification for password change |

### Examples

```bash
# Update display name
wp user update 123 --display_name=Mary

# Update password
wp user update 123 --user_pass=newpassword123

# Update multiple fields
wp user update 123 --display_name="John Smith" --first_name=John --last_name=Smith

# Update email
wp user update 123 --user_email=newemail@example.com

# Update user by login
wp user update bob --display_name="Bob Smith"

# Change role
wp user update 123 --role=editor
```

---

## wp user meta

Adds, updates, deletes, and lists user custom fields.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp user meta add` | Adds a meta field |
| `wp user meta delete` | Deletes a meta field |
| `wp user meta get` | Gets meta field value |
| `wp user meta list` | Lists all metadata for a user |
| `wp user meta patch` | Update a nested value |
| `wp user meta pluck` | Get a nested value |
| `wp user meta update` | Updates a meta field |

### wp user meta add

```bash
wp user meta add <user> <key> <value> [--format=<format>]
```

### wp user meta delete

```bash
wp user meta delete <user> <key> [<value>] [--all]
```

### wp user meta get

```bash
wp user meta get <user> <key> [--format=<format>]
```

### wp user meta list

```bash
wp user meta list <user> [--keys=<keys>] [--fields=<fields>] [--format=<format>] [--orderby=<fields>] [--order=<order>]
```

### wp user meta update

```bash
wp user meta update <user> <key> <value> [--format=<format>]
```

### Examples

```bash
# Add user meta
wp user meta add 123 bio "Mary is a WordPress developer."

# List user meta
wp user meta list 123

# List specific keys
wp user meta list 123 --keys=nickname,description,wp_capabilities

# Get specific meta
wp user meta get 123 nickname

# Update user meta
wp user meta update 123 bio "Mary is an awesome WordPress developer."

# Delete user meta
wp user meta delete 123 bio

# Get meta as JSON
wp user meta get 123 wp_capabilities --format=json
```

---

## wp user get

Gets details about a user.

### Syntax

```bash
wp user get <user> [--field=<field>] [--fields=<fields>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `<user>` | User ID, login, or email |
| `--field=<field>` | Print value of a single field |
| `--fields=<fields>` | Limit output to specific fields |
| `--format=<format>` | Output format: table, csv, json, yaml |

### Examples

```bash
# Get user details
wp user get 123

# Get specific fields
wp user get 123 --fields=ID,user_login,user_email

# Get as JSON
wp user get 123 --format=json

# Get by login
wp user get bob
```

---

## wp user exists

Verifies whether a user exists.

### Syntax

```bash
wp user exists <user>
```

### Examples

```bash
# Check if user exists
wp user exists 123 && echo "Exists" || echo "Does not exist"

# Check by login
wp user exists bob
```

---

## wp user generate

Generates some users.

### Syntax

```bash
wp user generate [--count=<number>] [--role=<role>] [--format=<format>]
```

### Options

| Option | Description |
|--------|-------------|
| `--count=<number>` | How many users to generate. Default: 100 |
| `--role=<role>` | The role. Default: default role |
| `--format=<format>` | Output format: progress, ids |

### Examples

```bash
# Generate 10 users
wp user generate --count=10

# Generate subscribers
wp user generate --count=50 --role=subscriber

# Generate with ID output
wp user generate --count=5 --format=ids
```

---

## wp user set-role

Sets the user role.

### Syntax

```bash
wp user set-role <user> [<role>]
```

### Options

| Option | Description |
|--------|-------------|
| `<user>` | User ID, login, or email |
| `[<role>]` | New role. Omit to remove all roles |

### Examples

```bash
# Set role to editor
wp user set-role 123 editor

# Remove all roles
wp user set-role 123
```

---

## wp user add-role

Adds a role for a user.

### Syntax

```bash
wp user add-role <user> <role>
```

### Examples

```bash
# Add additional role
wp user add-role 123 contributor
```

---

## wp user remove-role

Removes a user's role.

### Syntax

```bash
wp user remove-role <user> [<role>]
```

### Examples

```bash
# Remove specific role
wp user remove-role 123 contributor

# Remove all roles
wp user remove-role 123
```

---

## wp user add-cap

Adds a capability to a user.

### Syntax

```bash
wp user add-cap <user> <cap>
```

### Examples

```bash
# Add capability
wp user add-cap 123 publish_posts
```

---

## wp user remove-cap

Removes a user's capability.

### Syntax

```bash
wp user remove-cap <user> <cap>
```

### Examples

```bash
# Remove capability
wp user remove-cap 123 publish_posts
```

---

## wp user list-caps

Lists all capabilities for a user.

### Syntax

```bash
wp user list-caps <user> [--format=<format>]
```

### Examples

```bash
# List capabilities
wp user list-caps 123

# List as JSON
wp user list-caps 123 --format=json
```

---

## wp user reset-password

Resets the password for one or more users.

### Syntax

```bash
wp user reset-password <user>... [--skip-email] [--show-password] [--porcelain]
```

### Options

| Option | Description |
|--------|-------------|
| `<user>...` | Users to reset |
| `--skip-email` | Don't send password reset email |
| `--show-password` | Show the new password |
| `--porcelain` | Output just the new password |

### Examples

```bash
# Reset password and send email
wp user reset-password 123

# Reset and show new password
wp user reset-password 123 --show-password

# Reset without email
wp user reset-password 123 --skip-email --show-password
```

---

## wp user session

Destroys and lists a user's sessions.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp user session list` | Lists sessions |
| `wp user session destroy` | Destroys sessions |

### Examples

```bash
# List sessions
wp user session list 123

# Destroy all sessions
wp user session destroy 123 --all

# Destroy specific session
wp user session destroy 123 <token>
```

---

## wp user import-csv

Imports users from a CSV file.

### Syntax

```bash
wp user import-csv <file> [--send-email] [--skip-update]
```

### Options

| Option | Description |
|--------|-------------|
| `<file>` | Path to CSV file |
| `--send-email` | Send welcome emails |
| `--skip-update` | Skip updating existing users |

### CSV Format

The CSV must have a header row with column names matching user fields: user_login, user_email, display_name, role, etc.

### Examples

```bash
# Import users
wp user import-csv users.csv

# Import and send emails
wp user import-csv users.csv --send-email
```

---

## wp user application-password

Creates, updates, deletes, lists and retrieves application passwords.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp user application-password create` | Creates an application password |
| `wp user application-password list` | Lists application passwords |
| `wp user application-password delete` | Deletes an application password |
| `wp user application-password exists` | Checks if app password exists |
| `wp user application-password get` | Gets a specific app password |
| `wp user application-password update` | Updates an application password |

### Examples

```bash
# Create application password
wp user application-password create 123 "My App" --porcelain

# List application passwords
wp user application-password list 123

# Delete application password
wp user application-password delete 123 <uuid>
```

---

## wp user check-password

Checks if a user's password is valid.

### Syntax

```bash
wp user check-password <user> <user_pass>
```

### Examples

```bash
# Check password
wp user check-password bob mypassword && echo "Valid" || echo "Invalid"
```
