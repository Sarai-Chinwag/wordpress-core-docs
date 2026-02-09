# WP-CLI: wp cron

Tests, runs, and deletes WP-Cron events; manages WP-Cron schedules.

## Subcommands

| Command | Description |
|---------|-------------|
| `wp cron event` | Schedules, runs, and deletes WP-Cron events |
| `wp cron schedule` | Gets WP-Cron schedules |
| `wp cron test` | Tests the WP Cron spawning system |

---

## wp cron event

Schedules, runs, and deletes WP-Cron events.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp cron event delete` | Deletes all scheduled cron events for the given hook |
| `wp cron event list` | Lists scheduled cron events |
| `wp cron event run` | Runs the next scheduled cron event for the given hook |
| `wp cron event schedule` | Schedules a new cron event |
| `wp cron event unschedule` | Unschedules all cron events for a given hook |

---

### wp cron event list

Lists scheduled cron events.

#### Syntax

```bash
wp cron event list [--fields=<fields>] [--<field>=<value>] [--field=<field>] [--format=<format>]
```

#### Options

| Option | Description |
|--------|-------------|
| `--fields=<fields>` | Limit output to specific fields |
| `--<field>=<value>` | Filter by a field value |
| `--field=<field>` | Print value of a single field |
| `--format=<format>` | Output format: table, csv, ids, json, count, yaml |

#### Available Fields

- hook
- next_run_gmt
- next_run_relative
- recurrence
- args

#### Examples

```bash
# List all cron events
wp cron event list

# List as JSON
wp cron event list --format=json

# List specific fields
wp cron event list --fields=hook,next_run,recurrence

# Count events
wp cron event list --format=count

# Get just hooks
wp cron event list --field=hook

# Filter by hook
wp cron event list --hook=wp_version_check
```

---

### wp cron event run

Runs the next scheduled cron event for the given hook.

#### Syntax

```bash
wp cron event run [<hook>...] [--due-now] [--all]
```

#### Options

| Option | Description |
|--------|-------------|
| `[<hook>...]` | One or more hooks to run |
| `--due-now` | Run all events due right now |
| `--all` | Run all events regardless of schedule |

#### Examples

```bash
# Run specific hook
wp cron event run wp_version_check

# Run multiple hooks
wp cron event run wp_version_check wp_update_plugins

# Run all events that are due now
wp cron event run --due-now

# Run all events regardless of schedule
wp cron event run --all

# Run and show output
wp cron event run wp_scheduled_delete
```

---

### wp cron event schedule

Schedules a new cron event.

#### Syntax

```bash
wp cron event schedule <hook> [<next-run>] [<recurrence>] [--<field>=<value>]
```

#### Options

| Option | Description |
|--------|-------------|
| `<hook>` | The hook name |
| `[<next-run>]` | Unix timestamp or strtotime-compatible string. Default: now |
| `[<recurrence>]` | How often the event recurs. See `wp cron schedule list` |
| `--<field>=<value>` | Arguments to pass to the hook's callback function |

#### Recurrence Options

| Name | Interval |
|------|----------|
| `hourly` | Once hourly |
| `twicedaily` | Twice daily |
| `daily` | Once daily |
| `weekly` | Once weekly |

#### Examples

```bash
# Schedule one-time event now
wp cron event schedule my_hook

# Schedule one-time event for specific time
wp cron event schedule my_hook "2025-01-15 10:00:00"

# Schedule recurring event
wp cron event schedule my_hook now hourly

# Schedule daily event
wp cron event schedule my_daily_task now daily

# Schedule with relative time
wp cron event schedule my_hook "+1 hour"

# Schedule with arguments
wp cron event schedule my_hook now daily --post_id=123
```

---

### wp cron event delete

Deletes all scheduled cron events for the given hook.

#### Syntax

```bash
wp cron event delete <hook>
```

#### Options

| Option | Description |
|--------|-------------|
| `<hook>` | The hook name |

#### Examples

```bash
# Delete events for a hook
wp cron event delete my_hook

# Delete plugin's scheduled events
wp cron event delete my_plugin_cron_hook
```

---

### wp cron event unschedule

Unschedules all cron events for a given hook.

#### Syntax

```bash
wp cron event unschedule <hook>
```

#### Examples

```bash
# Unschedule all events for hook
wp cron event unschedule my_hook
```

---

## wp cron schedule

Gets WP-Cron schedules.

### Subcommands

| Command | Description |
|---------|-------------|
| `wp cron schedule list` | Lists available cron schedules |

---

### wp cron schedule list

Lists available cron schedules.

#### Syntax

```bash
wp cron schedule list [--fields=<fields>] [--field=<field>] [--format=<format>]
```

#### Options

| Option | Description |
|--------|-------------|
| `--fields=<fields>` | Limit output to specific fields |
| `--field=<field>` | Print value of a single field |
| `--format=<format>` | Output format: table, csv, ids, json, count, yaml |

#### Available Fields

- name
- display
- interval

#### Examples

```bash
# List all schedules
wp cron schedule list

# List as JSON
wp cron schedule list --format=json

# Get schedule names only
wp cron schedule list --field=name
```

#### Default Schedules

| Name | Display | Interval |
|------|---------|----------|
| hourly | Once Hourly | 3600 |
| twicedaily | Twice Daily | 43200 |
| daily | Once Daily | 86400 |
| weekly | Once Weekly | 604800 |

Plugins can add custom schedules using the `cron_schedules` filter.

---

## wp cron test

Tests the WP Cron spawning system and reports back its status.

### Syntax

```bash
wp cron test
```

### Examples

```bash
# Test cron system
wp cron test
```

### Output

```
Success: WP-Cron spawning is working as expected.
```

Or if there's a problem:
```
Error: The cron spawn request returned HTTP status code 500.
```

---

## Common WP-Cron Hooks

### WordPress Core

| Hook | Description |
|------|-------------|
| `wp_version_check` | Checks for WordPress updates |
| `wp_update_plugins` | Checks for plugin updates |
| `wp_update_themes` | Checks for theme updates |
| `wp_scheduled_delete` | Empties trash |
| `wp_scheduled_auto_draft_delete` | Deletes auto-drafts |
| `delete_expired_transients` | Cleans expired transients |
| `wp_privacy_delete_old_export_files` | Cleans old export files |

### Common Plugin Hooks

| Hook | Plugin |
|------|--------|
| `woocommerce_scheduled_sales` | WooCommerce |
| `wp_mail_smtp_admin_notifications_update` | WP Mail SMTP |
| `jetpack_sync_cron` | Jetpack |

---

## Practical Examples

### Debugging Cron Issues

```bash
# Test if cron is working
wp cron test

# List all scheduled events
wp cron event list

# Check for overdue events
wp cron event list --format=json | jq '.[] | select(.next_run_relative | contains("ago"))'

# Run overdue events
wp cron event run --due-now
```

### Maintenance

```bash
# Run all scheduled events manually
wp cron event run --all

# Force update checks
wp cron event run wp_version_check wp_update_plugins wp_update_themes

# Clear orphaned cron events (after plugin removal)
wp cron event delete old_plugin_cron_hook
```

### Manual Cron Setup

If `DISABLE_WP_CRON` is true in wp-config.php, set up system cron:

```bash
# Add to crontab
*/5 * * * * cd /var/www/mysite && wp cron event run --due-now --quiet
```

Or with wget:
```bash
*/5 * * * * wget -q -O /dev/null https://example.com/wp-cron.php
```

### Scheduling Custom Events

```bash
# Schedule a one-time event
wp cron event schedule my_custom_hook "+1 hour"

# Schedule recurring cleanup
wp cron event schedule cleanup_old_logs now daily

# Schedule with arguments
wp cron event schedule send_report now weekly --report_type=monthly
```

### Monitoring

```bash
# Count scheduled events
wp cron event list --format=count

# Export cron schedule
wp cron event list --format=json > cron-events.json

# Find events for specific plugin
wp cron event list | grep my_plugin
```

---

## Troubleshooting

### Cron Not Running

1. **Test the cron system**:
   ```bash
   wp cron test
   ```

2. **Check for loopback issues**:
   - Ensure the server can reach itself
   - Check firewall rules

3. **Verify cron isn't disabled**:
   ```bash
   wp config get DISABLE_WP_CRON
   ```

4. **Check for stuck cron**:
   ```bash
   wp option get doing_cron
   # If stuck, delete it
   wp option delete doing_cron
   ```

### Events Not Firing

1. **List overdue events**:
   ```bash
   wp cron event list
   ```

2. **Manually run overdue**:
   ```bash
   wp cron event run --due-now
   ```

3. **Check hook registration**:
   Ensure the action hook is registered in your plugin/theme.

### Performance Issues

1. **Too many events**:
   ```bash
   wp cron event list --format=count
   ```

2. **Long-running events blocking**:
   Consider using `DISABLE_WP_CRON` with system cron for better control.

---

## Best Practices

1. **Use System Cron**: For production sites, disable WP-Cron and use system cron for reliability

2. **Don't Overload**: Limit the number of scheduled events; consolidate where possible

3. **Unique Hooks**: Use unique hook names to avoid conflicts with other plugins

4. **Cleanup**: Remove cron events when deactivating plugins

5. **Monitor**: Regularly check that cron events are running as expected

6. **Logging**: Log cron event execution for debugging
