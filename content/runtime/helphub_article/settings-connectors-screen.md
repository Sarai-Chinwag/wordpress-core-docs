---
type: document
title: Settings Connectors screen
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/settings-connectors-screen/"
tags:
timestamp: "2026-06-16T19:28:09+00:00"
wordpress:
  id: 2112
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:09"
  date_gmt: "2026-06-16 19:28:09"
  modified: "2026-06-16 19:28:09"
  modified_gmt: "2026-06-16 19:28:09"
  slug: settings-connectors-screen
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/settings-connectors-screen/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

The Settings Connectors screen lets you connect your WordPress site to external services. It comes with the three following featured connectors:

- Anthropic
- Google
- OpenAI

To access this screen, select **Settings &gt; Connectors** from the WordPress dashboard.

![Connects screen containing a notice to install the AI plugin, and options to install Anthropic, Google, and OpenAI connections.](https://wordpress.org/documentation/files/2026/05/dashboard-settings-connectors-screen.png)Connects screen with options to install the AI plugin, Anthropic, Google, or OpenIA connectors.## Install the AI plugin

The Connectors screen displays a notice to install the [AI plugin](https://wordpress.org/plugins/ai/). The AI plugin can use your configured AI connectors to generate featured images, alt text, titles, excerpts, and other content.

Select **Install the AI plugin** to add and enable the plugin on your site.

After installing, WordPress adds an **AI** screen under **Settings**. This screen is used to configure AI features and experiments for your site.

![](https://wordpress.org/documentation/files/2026/05/dashboard-settings-ai-screen.png)AI settings screenThe plugin requires a valid AI connector before it can be used. If no valid connector is configured, you will see a message asking you to verify that one or more AI connectors are configured.

## Install a connector

Select Install to install the plugin associated with a connector. After the plugin is installed and active, you must add an API key from the provider.

Each connector includes a link to the provider’s site where you can create or copy the required credentials:

![API key fields for Anthropic and Google in the Settings Connectors Screen. ](https://wordpress.org/documentation/files/2026/05/dashboard-settings-connector-api-keys.png)### API keys

AI provider connectors use API keys to connect WordPress to external services. An API key gives WordPress permission to use the provider’s service.

An API key can be provided in more than one way. For connectors that use API keys, WordPress checks for credentials in this order:

1\. Environment variable
2\. PHP constant
3\. Database setting

If you enter an API key through the Connectors screen, WordPress stores it as a database setting. API keys stored in the database are masked in the user interface but are not encrypted.

Site owners or developers who do not want API keys stored in the database can define them as environment variables or PHP constants instead.

## Enable AI options

After installing the AI plugin and setting up a connector, go to Settings &gt; AI and turn on Enable AI in the top right of the screen.

![](https://wordpress.org/documentation/files/2026/05/connects-screen-enable-ai-toggle-e1780887747926.png)Turn on Enable AI under Settings &gt; AI**Note**: You can turn on **Enable AI** without an AI connector, but WordPress recommends configuring a [valid AI connector](#install-a-connector) so these options work properly.

You can then enable the AI options you want to use, such as image generation, excerpt generation, or alt text generation.

![Preview of AI options in the AI plugin settings page.](https://wordpress.org/documentation/files/2026/05/connectors-settings-ai-options.png)Turn on the AI options you want to use in Settings &gt; AIOnce enabled, these options appear in the WordPress editor when available. For example, image generation and excerpt generation add options to generate a featured image and excerpt.

![WordPress editor showing AI plugin options for generating a featured image and excerpt text.](https://wordpress.org/documentation/files/2026/05/ai-plugin-generate-image-and-excerpt.jpeg)AI options for generating a featured image and excerpt in the WordPress editorFor more information about the Connectors API, refer to the [Introducing the Connectors API in WordPress 7.0](https://make.wordpress.org/core/2026/03/18/introducing-the-connectors-api-in-wordpress-7-0/) post.

## Changelog

- Updated 2026-06-07 (props @kjoyner @lanamiro1)
    - Added “Enable AI options” section
- Created 2026-05-24
