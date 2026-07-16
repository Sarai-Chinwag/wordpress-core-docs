---
type: document
title: Studio Assistant
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/assistant/"
tags:
timestamp: "2026-06-16T19:29:24+00:00"
wordpress:
  id: 2477
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:24"
  date_gmt: "2026-06-16 19:29:24"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: assistant
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/assistant/"
  comment_count: 0
---

[Studio Code](https://developer.wordpress.com/docs/developer-tools/studio/studio-code/) is recommended for taking full advantage of AI when building WordPress sites with Studio.

The Studio Assistant is a smart chatbot integrated within [WordPress Studio](https://developer.wordpress.com/studio/), our free and open source local development app. With the Studio Assistant, you can quickly configure new sites, manage existing sites, and run complex WP-CLI commands—all through a simple and intuitive chat interface.

## How to use the Studio Assistant

To access the Studio Assistant, open your WordPress Studio app and click on the Assistant tab.

[![A screenshot of the Studio app with an orange arrows pointing to Studio Assistant tab.](https://developer.wordpress.com/wp-content/uploads/2024/10/studio-assistant-2.jpg)](https://developer.wordpress.com/wp-content/uploads/2024/10/studio-assistant-2.jpg)Each Studio site will have its own unique chat conversation, allowing the assistant to understand and respond based on the specific context of your site.

To access the Assistant, you must be [logged into your WordPress.com account](https://developer.wordpress.com/docs/developer-tools/studio/#connect-wordpress-com), as we use WordPress.com infrastructure to generate responses and manage access. Each user is allowed 200 prompts per month across all of their Studio sites.

## Notable features

You can use the Assistant to streamline workflows for your local sites like:

### Performing actions based on your site specs

The Studio Assistant has context about your site (like the themes and plugins that are installed), so it can tailor its responses based on your specific site features.

For example, you can ask the Assistant to disable or update the plugins that are already installed on your local site or to upgrade your site’s WordPress version, even for beta or RC versions.

### WP-CLI suggestions and execution

You don’t need to install WP-CLI on your computer to run WP-CLI commands with the Studio Assistant. When the Assistant recommends running a WP-CLI command, you will be able to run the command inline within the Assistant interface by clicking the **Run** button.

![A screenshot of the Studio Assistant with an orange arrows pointing to the Run button.](https://developer.wordpress.com/wp-content/uploads/2024/10/studio-assistant-run-1.jpg)[If you’ve already installed WP-CLI](https://make.wordpress.org/cli/handbook/guides/installing/), you can click the **Open in terminal** button to copy the command and then run it in your terminal. This is especially useful when you need to modify some parameters.

A few WP-CLI commands, such as `db`, `server`, and `shell`, are not currently compatible with the execution inline, and the buttons to run these commands won’t be visible in the Studio Assistant.

If you want to use WP-CLI outside of the Studio Assistant, you must have WP-CLI on your machine. We recommend [following these instructions](https://make.wordpress.org/cli/handbook/guides/installing/) if you don’t already have it installed.

### Generate code and content

When you ask the Assistant to write posts, it will provide you with Gutenberg blocks that you can simply copy and paste into your wp-admin editor.

For creating PHP, JavaScript, or CSS code, the Assistant will also generate code blocks that you can copy, paste, and adapt to your specific needs.

All code blocks include a convenient copy button to easily copy their content.

![A screenshot of the Studio Assistant with an orange arrows pointing to the copy button.](https://developer.wordpress.com/wp-content/uploads/2024/10/studio-assistant-copy-1.jpg)### Open files

If you have a file in mind but don’t want to look for it in your Finder, File Explorer, or text editor, simply ask the Assistant to open it for you. In the Assistant’s response, you can click on the file name to open files with your IDE or folders in your file explorer.

![A screenshot of the Studio Assistant with orange arrows pointing to the links that open files.](https://developer.wordpress.com/wp-content/uploads/2024/10/studio-assistant-open-files.jpg)### Clear the conversation

Any time you want to start a new conversation for a given site, you can clear the current conversation by clicking on the three dots menu and clicking the **Clear conversation** button.

![A screenshot of the Studio Assistant with an orange arrows pointing to the button that clears the conversation.](https://developer.wordpress.com/wp-content/uploads/2024/10/studio-assistant-clear.jpg)
