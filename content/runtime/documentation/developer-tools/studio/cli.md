---
type: document
title: Studio CLI
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/cli/"
tags:
timestamp: "2026-06-16T19:29:22+00:00"
wordpress:
  id: 2457
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:22"
  date_gmt: "2026-06-16 19:29:22"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: cli
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/cli/"
  comment_count: 0
---

Studio CLI comes bundled with Studio, and it’s also available as a standalone npm module, [wp-studio](https://www.npmjs.com/package/wp-studio).

If you already have Studio installed, the easiest way to try the CLI is to follow the instructions below.

Studio CLI is a globally available command-line utility that lets you interact with [WordPress Studio](https://developer.wordpress.com/docs/developer-tools/studio/) features from your terminal, regardless of whether Studio is open or not.

It’s especially useful for:

- Managing local Studio sites.
- Creating and updating preview sites on WordPress.com.
- Running WP-CLI commands.
- Integrate with AI coding agents. Every site comes with an AGENTS.md file.
- Integrating Studio into scripts and build steps.

## Installation

1. Open the **“WordPress Studio**” application.
2. From the main menu, open the **Settings** modal. You can also click the gear icon in the top-right corner of the app.
3. Enable the **“Studio CLI**” option and click **Save**.
4. On macOS, you’ll be prompted for your account password to allow installation.

[![Screenshot of WordPress Studio settings menu showing options for language, code editor, terminal application, and Studio CLI.](https://developer.wordpress.com/wp-content/uploads/2025/05/studio-enable-cli-1.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/05/studio-enable-cli-1.jpg)## Usage

The Studio CLI is invoked with the studio command. All commands follow the pattern:

```
studio <area> <command> [options]
```

You can see a high-level overview at any time with:

```
studio --help
```

[![Screenshot of a command line interface displaying the WordPress Studio CLI help menu with various commands and options.](https://developer.wordpress.com/wp-content/uploads/2025/05/studio-ai-studio-help-3.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/05/studio-ai-studio-help-3.jpg)Most commands are designed to be run from the root directory of a Studio-managed site. To target a different site directory than your current working directory, use the `--path` option:

```
studio <area> <command> --path /path/to/site
```

## Authentication commands

Use the `auth` commands to manage your WordPress.com authentication for Studio features that require a logged-in user (for example, preview sites).

```
studio auth login      # Log in to WordPress.com
studio auth logout     # Log out and clear WordPress.com authentication
studio auth status     # Check authentication status
```

- `studio auth login` opens a browser-based flow to connect the CLI to your WordPress.com account. You will receive an authentication token to paste into the terminal to complete the login process.
- `studio auth status` reports whether you are currently authenticated and shows which account is in use.
- `studio auth logout` disconnects the CLI from your WordPress.com account and clears stored credentials.

If you run a command that requires authentication (such as `studio preview create`) while logged out, the CLI will return an error and guide you to log in.

Use the `--help` flag for detailed options on any auth command:

```
studio auth --help
studio auth login --help
```

## Preview site commands

[Preview sites](https://developer.wordpress.com/docs/developer-tools/studio/preview-sites/) are temporary, shareable environments hosted on WordPress.com that mirror your local Studio site. Use them to share work with teammates or stakeholders without requiring a local environment.

```
studio preview create          # Create a preview site
studio preview list            # List preview sites
studio preview update <host>   # Update an existing preview site
studio preview delete <host>   # Delete a preview site
```

### Creating a preview site

From the root of your local Studio site:

```
cd /path/to/your/studio-site
studio preview create
```

This will:

- Build and upload your local site to a preview environment.
- Return a preview URL you can share with others.
- Require you to be logged in with `studio auth login`.

You can also specify a site directory explicitly:

```
studio preview create --path /path/to/your/studio-site
```

### Listing preview sites

To view all preview sites associated with your account:

```
studio preview list
```

This shows each preview’s host (for example, `example-preview.wpcomstaging.com`), which you’ll use with the `update` and `delete` commands.

### Updating and deleting preview sites

Each preview site is identified by its host name:

```
# Rebuild and redeploy changes from your local site to the preview site:
studio preview update <host>
Permanently remove a preview site:
studio preview delete <host>
```

Use `studio preview list` to discover the appropriate `<host>` value if you don’t have it handy.

For the full set of options:

Use the `site` commands to manage local Studio sites on your machine: creating, starting, stopping, listing, and configuring them.

```
studio preview --help
studio preview create --help
studio preview update --help
studio preview delete --help
```

## Local site management commands

You can run the `create` command from an empty directory, or a directory that already contains the files of a WordPress site, but one that’s not already listed in Studio.

```
studio site status    # Get status of local site
studio site create    # Create a new local site
studio site list      # List local sites
studio site start     # Start local site
studio site stop      # Stop local site(s)
studio site delete    # Delete local site
studio site set       # Configure site settings
```

### Creating a local site

To create a new local site managed by Studio:

studio site create --https --domain hello.wp.local

```
# Create a new site in the current working directory, using all the default options
studio site create
Create a new site with a custom domain and HTTPS
studio site create --https --domain hello.wp.local
Create a new site in a different directory
studio site create --path /path/to/site
```

There are several supported flags that you can use when creating a new site. For the full set of options:

Studio offers access to the [Blueprints Gallery](https://developer.wordpress.com/docs/developer-tools/studio/blueprints/) where you can choose and activate blueprints to create a site. The Blueprints Gallery is also available through CLI. The commands for working with blueprints are:

studio blueprint use &lt;blueprint-slug&gt; --name "&lt;site-name&gt;"

```
studio site create --help
```

### Creating a local site using Blueprints Gallery

studio site status

```
# Show all available blueprints for creating a local Studio site
studio blueprint list
Create a local site with selected blueprint
studio blueprint use <blueprint-slug> --name "<site-name>"
```

Status output includes information such as:

### Listing and inspecting sites

```
# Show all local sites known to Studio:
studio site list
Show details and current status for the site in the current directory:
studio site status
Or explicitly for a given path:
studio site status --path /path/to/site
```

studio site delete --files

This removes the site from Studio and, optionally, the site files from disk.

- Whether the site is running.
- Local URL (for example, `http://localhost:PORT`).
- Key configuration details (PHP version, database status, etc.).

### Starting and stopping sites

```
# From inside a site directory:
studio site start
studio site stop
Or by path:
studio site start --path /path/to/site
studio site stop --path /path/to/site
```

Examples of what this command can be used for include:

To see the full list of configurable options, run:

### Deleting a local site

```
# Delete a site from Studio
studio site delete
Delete the site and move the site directory to the system trash
studio site delete --files
```

Examples (run from your site’s root directory):

studio wp plugin list

### Configuring site settings

studio wp core update-db

```
studio site set [options]
```

Key points:

- Changing the PHP version or WordPress version.
- Adjusting the local domain or port.
- Toggling features that affect how the local environment runs.

For a complete list of supported WP-CLI subcommands and arguments, refer to the [WP-CLI documentation](https://developer.wordpress.org/cli/commands/) or run:

```
studio site set --help
```

## Using WP-CLI through Studio

The Studio CLI works well with AI-assisted development tools and agents such as **Claude Code**, **Cursor**, and other IDE extensions that can run shell commands on your behalf.

```
studio wp [<wp-cli-command>] [<wp-cli-arguments>...]
```

Because these tools can see your project files and execute terminal commands, they can:

```
# Check WordPress version:
studio wp core version
List installed plugins:
studio wp plugin list
Run database upgrades:
studio wp core update-db
```

*“Set up a new local WordPress site using PHP version 8.2 using Studio in this folder, start it, and tell me the local URL.”*

Behind the scenes, the agent might run:

- You don’t need a separate WP-CLI installation; Studio provides and configures it for you.
- Environment variables, paths, and credentials are automatically set based on the selected site, so commands operate on the correct database and files.
- You can use `--path` if you’re not in the site directory:

```
studio wp plugin list --path /path/to/site
```

This is useful when:

```
studio wp help
studio wp help <command>
```

## Using Studio CLI with AI coding agents

When the agent suggests a fix or change, it can also run checks using `studio wp`:

studio wp plugin list

- Detect that you are working in a Studio-managed WordPress project.
- Call `studio` commands automatically to manage local sites, previews, and WP-CLI tasks.
- Use command output to guide further code changes or debugging steps.

### Typical workflows with AI agents

You might ask:

#### 1. Spinning up and managing a local site

*“Run whatever WP-CLI checks you need through Studio to diagnose why the site is throwing a 500 error, then propose fixes.”*

The agent can iteratively:

Agents can help you set up and maintain preview environments tied to your branch or feature:

```
studio site create --php 8.2
studio site start
studio site status
```

*“Create a preview site for this project and give me the shareable URL. Then, after each code change, update the same preview.”*

- Quickly prototyping a new plugin or theme.
- Onboarding to an existing project where you want the agent to set up the environment for you.

#### 2. Automated debugging and WP-CLI operations

Which translates to:

```
# Run database upgrades:
studio wp core update-db
Check for current plugins:
studio wp plugin list
```

By combining Studio CLI with AI coding agents, you can offload much of the repetitive environment setup, testing, and deployment orchestration, and focus more on writing and reviewing your WordPress code.

Every command and subcommand supports `--help` for inline documentation, usage, and available options. For example:

This is the best way to explore the capabilities of the specific version of Studio CLI you have installed.

1. Run `studio wp` commands to gather diagnostics.
2. Update code or configuration.
3. Re-run commands to verify the fix.

#### 3. Creating and updating preview sites for review

```
studio auth login              # if needed
studio preview create          # initial deployment
studio preview update <host>   # after subsequent changes
```

[![A terminal window displaying a Bash command execution showing the creation of a preview site, including validation and archive creation messages, along with a link to the live site and total time taken.](https://developer.wordpress.com/wp-content/uploads/2025/05/studio-ai-create-preview-2.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/05/studio-ai-create-preview-2.jpg)- Sharing progress with non-technical stakeholders.
- Collaborating with teammates who need to see live behavior without setting up a local environment.

### Best practices when using AI agents with Studio CLI

- **Stay in a Studio site root**: Many commands assume the current directory is a Studio-managed site. Remind your agent to `cd` into the correct folder or to use `--path`.
- **Be explicit in instructions**: When prompting an agent, mention “use the `studio` CLI” and any constraints, for example:
    - “Don’t delete existing sites.”
    - “Ask for confirmation before running database migrations.”
    - “Only run read-only `studio wp` commands.”
- **Review destructive operations**: Commands like `studio site delete` and `studio preview delete` can remove environments. Ask the agent to show the commands it plans to run before executing them.
- **Use authentication deliberately**: For commands that require WordPress.com access (`studio auth login`, `studio preview ...`), ensure you’re comfortable with the agent initiating login flows, and confirm which account is being used.

## Getting help

```
studio --help
studio auth --help
studio preview create --help
studio site start --help
studio site set --help
studio wp help
```
