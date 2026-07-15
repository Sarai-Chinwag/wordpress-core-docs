---
type: document
title: Blueprints in WordPress Studio
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/blueprints/"
tags:
timestamp: "2026-06-16T19:29:19+00:00"
wordpress:
  id: 2440
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:19"
  date_gmt: "2026-06-16 19:29:19"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: blueprints
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/blueprints/"
  comment_count: 0
---

A Blueprint is a JSON file that describes how to build a site in WordPress Studio. This “recipe” tells Studio which WordPress and PHP versions to use, which plugins and themes to install, what content or settings to apply, and more.

Unlike full-site Blueprints in other local development environments, Studio Blueprints are lightweight, declarative, and easy to share. Choose from one of our free starter Blueprints or upload a [Blueprint of your own](https://developer.wordpress.com/docs/guides/how-to-create-custom-blueprints/).

## How Blueprints work in Studio

When you launch a site with a Blueprint, Studio reads the JSON file and builds the site according to the instructions inside. Instead of copying a pre-existing site, Studio installs and configures everything fresh each time. This ensures that anyone using the same Blueprint ends up with the same environment.

A Blueprint can configure:

- **Core versions**: Specify which WordPress and PHP versions the site should use.
- **Plugins and themes**: Define which should be installed and activated automatically.
- **Site options**: Set values such as the site title, permalink structure, and other WordPress settings.
- **Content**: Import demo posts, pages, or other starter content.
- **Custom steps**: Run PHP or SQL commands during site creation to further customize the setup.

Blueprints in Studio follow the same format as [WordPress Playground](https://wordpress.org/playground/) Blueprints. That means a Blueprint you create for Studio can also be opened in Playground (and vice versa), making them portable across different development contexts.

Studio does not support *every* Playground feature. Unsupported steps are skipped without affecting the rest of the Blueprint. For a comprehensive list of these steps, refer to the [Blueprints guide](https://developer.wordpress.com/docs/guides/how-to-create-custom-blueprints/#1-blueprint-limitations-in-studio).

## Creating a Studio site from a Blueprint

Creating local sites from Blueprints is incorporated into the site creation flow within Studio.

1. Click the “**Add site**” button in the lower left corner of the Studio app. The following screen will appear.

[![The new "Add a site" screen in WordPress Studio.](https://developer.wordpress.com/wp-content/uploads/2025/10/new-studio-site.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/10/new-studio-site.png)1. Select “**Build a new site,**” and you will see a gallery of featured Blueprints and an option to choose your own custom Blueprint file.

[![The new "Build a new site" screen in WordPress Studio showcases the Featured Blueprints as well as the option to upload your own.](https://developer.wordpress.com/wp-content/uploads/2025/10/build-new-site.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/10/build-new-site.png)1. Select a featured Blueprint that fits your needs or “**Choose blueprint file**” and select the JSON file from your computer.
2. Click **Continue**.
3. On the setup screen, give your site a name. You can open “**Advanced settings**” for more options.
4. Click “**Add site.**“

![Set the site name and configure advanced settings.](https://developer.wordpress.com/wp-content/uploads/2025/10/studio-add-site-name-settings-16-1.jpg)Behind the scenes, Studio builds the site from whichever Blueprint you selected or added.

## Featured Blueprints

Studio currently has three free featured Blueprints that you can use when setting up a new local site.

1. **Quick Start**: A WordPress.com-like environment that mirrors the Business plan. It includes the same core plugins and themes you’d find pre-installed on a WordPress.com Business plan, so you can spin up a production-like site right away.
2. **Development**: Designed for building themes and plugins, this Blueprint enables debug settings and includes tools like Query Monitor, Plugin Check, Theme Check, and Create Block Theme.
3. **Commerce**: Tailored for launching an online store, this Blueprint comes with WooCommerce and companion plugins pre-installed, along with optional extensions such as payment, advertising, and product listing tools. It provides a store-ready framework that you can extend for client projects.

Additionally, Studio offers access to the Blueprints Gallery, where you can browse and activate a growing library of pre-configured environments tailored for things like blogging, ecommerce, development, design exploration, or plugin testing.

[![The image shows Blueprints Gallery: a selection of blueprints that can be activated.](https://developer.wordpress.com/wp-content/uploads/2025/10/blueprints-gallery.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/10/blueprints-gallery.png)## Building your own Blueprints

Beyond the featured Blueprints, you can also create a custom JSON file to define your specific site requirements. For details on supported steps, JSON structure, and examples, refer to [How to create custom Blueprints](https://developer.wordpress.com/docs/guides/how-to-create-custom-blueprints/).

## Opening Blueprints in Studio

You can use a custom Blueprint when creating a new site in Studio, but you can also generate shareable links that open your Blueprint directly in the app (as long as the user has Studio installed). This makes it easy to share demos and examples that others can explore locally. Use the button below to learn how to create your own links.

<a class="wp-block-button__link wp-element-button">Open in WordPress Studio button</a>
