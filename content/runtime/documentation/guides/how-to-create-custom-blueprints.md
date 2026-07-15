---
type: document
title: How to create custom WordPress Blueprints
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/how-to-create-custom-blueprints/"
tags:
timestamp: "2026-06-16T19:29:19+00:00"
wordpress:
  id: 2439
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:19"
  date_gmt: "2026-06-16 19:29:19"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: how-to-create-custom-blueprints
  parent: 2479
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/how-to-create-custom-blueprints/"
  comment_count: 0
---

WordPress Studio is powered by [WordPress Playground](https://wordpress.org/playground/), which supports Blueprints. [Blueprints in Studio](https://developer.wordpress.com/docs/developer-tools/studio/blueprints/) help you:

- **Streamline repeatable setups:** Create Blueprints for common site types (like blog, portfolio, or store) to start new Studio projects more efficiently.
- **Keep teams aligned:** Add a blueprint.json file to your project’s GitHub repository, whether you’re building a plugin, theme, or full site. It scaffolds the same environment every time, so teammates can start building a plugin, theme, or full site in minutes, while version control keeps changes reviewable and consistent.
- **Simplify demos and testing:** Launch Studio with the exact theme, plugins, and sample content you need. Reproduce bugs or confirm fixes with a reliable, repeatable setup.

This guide will teach you the basics of creating a custom Blueprint and provide additional resources where you can learn more.

## What are Blueprints?

A Blueprint is a JSON file that defines a WordPress site’s setup. Within a Blueprint, you can configure settings such as your preferred WordPress and PHP versions. You can also specify a list of steps to run when the site is created, like installing and activating plugins and themes, setting site options, importing demo content, and running PHP or SQL queries.

Blueprints are written using a public JSON schema, standardizing their use across Playground, WordPress Studio, and beyond.

This minimal example configures the preferred WordPress and PHP versions, installs and activates the WooCommerce plugin and the Pendant theme, and sets the admin color scheme to “Modern.”

```
{
  "$schema": "https://playground.wordpress.net/blueprint-schema.json",
  "landingPage": "/wp-admin/",
  "login": true,
  "preferredVersions": {
    "php": "8.3",
    "wp": "latest"
  },
  "steps": [
    {
      "step": "installPlugin",
      "pluginData": {
        "resource": "wordpress.org/plugins",
        "slug": "woocommerce"
      },
      "options": {
        "activate": true
      }
    },
    {
      "step": "installTheme",
      "themeData": {
        "resource": "wordpress.org/themes",
        "slug": "pendant"
      },
      "options": {
        "activate": true
      }
    },
    {
      "step": "updateUserMeta",
      "meta": {
        "admin_color": "modern"
      },
      "userId": 1
    }
  ]
}
```

{ "$schema": "https://playground.wordpress.net/blueprint-schema.json", "landingPage": "/wp-admin/", "login": true, "preferredVersions": { "php": "8.3", "wp": "latest" }, "steps": \[ { "step": "installPlugin", "pluginData": { "resource": "wordpress.org/plugins", "slug": "woocommerce" }, "options": { "activate": true } }, { "step": "installTheme", "themeData": { "resource": "wordpress.org/themes", "slug": "pendant" }, "options": { "activate": true } }, { "step": "updateUserMeta", "meta": { "admin\_color": "modern" }, "userId": 1 } \] }CopyCopied

Key things to know:

- `preferredVersions` lets you predefine the PHP and WordPress versions.
- `steps` is where the magic happens. You can log in, install or activate plugins and themes, import WXR content, set options, run PHP, and more. For instance, the example demonstrates installing WooCommerce, setting the site’s language to Spanish, and adjusting the admin color scheme. Check out the [Step Library](https://wordpress.github.io/wordpress-playground/blueprints/steps/) for each available action with examples.

WordPress Playground offers an [interactive Blueprint builder](https://playground.wordpress.net/builder/builder.html#%7B%22$schema%22:%22https://playground.wordpress.net/blueprint-schema.json%22,%22landingPage%22:%22/wp-admin/%22,%22login%22:true,%22preferredVersions%22:%7B%22php%22:%228.3%22,%22wp%22:%22latest%22%7D,%22steps%22:[%7B%22step%22:%22installPlugin%22,%22pluginData%22:%7B%22resource%22:%22wordpress.org/plugins%22,%22slug%22:%22woocommerce%22%7D,%22options%22:%7B%22activate%22:true%7D%7D,%7B%22step%22:%22updateUserMeta%22,%22meta%22:%7B%22admin_color%22:%22modern%22%7D,%22userId%22:1%7D,%7B%22step%22:%22setSiteLanguage%22,%22language%22:%22es_ES%22%7D]%7D), allowing you to test various Blueprint setups. It’s a great way to validate your custom Blueprints before running them in Studio.

[![The Blueprint builder in WordPress Playground.](https://developer.wordpress.com/wp-content/uploads/2025/10/blueprint-builder-2.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/10/blueprint-builder-2.jpg)[Preview Blueprint](https://playground.wordpress.net/builder/builder.html#{%22$schema%22:%22https://playground.wordpress.net/Blueprint-schema.json%22,%22landingPage%22:%22/wp-admin/%22,%22login%22:true,%22preferredVersions%22:{%22php%22:%228.3%22,%22wp%22:%22latest%22},%22steps%22:[{%22step%22:%22installPlugin%22,%22pluginData%22:{%22resource%22:%22wordpress.org/plugins%22,%22slug%22:%22woocommerce%22},%22options%22:{%22activate%22:true}},{%22step%22:%22installTheme%22,%22themeData%22:{%22resource%22:%22wordpress.org/themes%22,%22slug%22:%22pendant%22},%22options%22:{%22activate%22:true}},{%22step%22:%22updateUserMeta%22,%22meta%22:{%22admin_color%22:%22modern%22},%22userId%22:1}]})

Preview and download this Blueprint using the button above. Once downloaded, you can use it to create a new site in Studio. For detailed instructions, refer to the [site creation flow in Studio](https://developer.wordpress.com/docs/developer-tools/studio/blueprints/).

## Blueprint limitations in Studio

The following table highlights how Blueprints function differently in Studio compared to [playground.wordpress.net](http://playground.wordpress.net), as of version 1.6.0:

| **Property** | **Why it’s ignored by Studio** |
|---|---|
| [`landingPage`](https://wordpress.github.io/wordpress-playground/blueprints/data-format#landing-page) | Users can navigate to the WP Admin and frontend of the local site from links within the Studio user interface. |
| [`login`](https://wordpress.github.io/wordpress-playground/blueprints/steps/shorthands#login) | You’re automatically logged in when navigating to local sites from the Studio user interface. |
| [`extraLibraries`](https://wordpress.github.io/wordpress-playground/blueprints/data-format#extra-libraries) | Studio maintains all extra libraries directly. |
| `features → <a href="https://wordpress.github.io/wordpress-playground/blueprints/data-format#features">networking</a>` | Users should always be able to install plugin and themes in Studio. |
| `steps → step → <a href="https://wordpress.github.io/wordpress-playground/blueprints/steps#DefineSiteUrlStep">defineSiteUrl</a>` | The site URL defaults to localhost and can be customized in the Studio user interface during site creation. |
| `steps → step → <a href="https://wordpress.github.io/wordpress-playground/blueprints/steps#EnableMultisiteStep">enableMultisite</a>` | Multisite is not currently supported in Studio. |
| `steps → step → <a href="https://wordpress.github.io/wordpress-playground/blueprints/steps#SetSiteOptionsStep">setSiteOptions</a> → blogName` *or* `<a href="https://wordpress.github.io/wordpress-playground/blueprints/steps/shorthands#siteoptions">siteOptions</a> → blogName` | The site name is set in the Studio user interface during site creation. |
| `steps → step → <a href="https://wordpress.github.io/wordpress-playground/blueprints/steps#SetSiteOptionsStep">setSiteOptions</a> → login → username/password` *or* `<a href="https://wordpress.github.io/wordpress-playground/blueprints/steps/shorthands#siteoptions">siteOptions</a> → login → username/password` | The username and password for a local site is set by Studio during site creation. |

## Additional resources

Blueprints can be simple like the example above or as sophisticated as your workflow requires. The [Playground documentation](https://wordpress.github.io/wordpress-playground/) provides a clear overview of Blueprint JSON format, a quick start tutorial, and detailed references. If you want to create your own Blueprints or explore examples from the WordPress community, see the resources below:

- [Blueprints overview and quick start tutorial](https://wordpress.github.io/wordpress-playground/blueprints/tutorial)
- [Data format and schema](https://wordpress.github.io/wordpress-playground/blueprints/data-format)
- [Steps reference and visual Step Library](https://wordpress.github.io/wordpress-playground/blueprints/steps/)
- [Example Blueprints and the community gallery](https://github.com/WordPress/blueprints/blob/trunk/GALLERY.md)

Leveraging AI tools like the [Studio Assistant](https://developer.wordpress.com/docs/developer-tools/studio/assistant/) is a great way to get help building custom Blueprints. Simply ask it to write a Blueprint for you:

[![Asking the Studio Assistant to build Blueprints.](https://developer.wordpress.com/wp-content/uploads/2025/10/studio-assistant-blueprint-1.jpg)](https://developer.wordpress.com/wp-content/uploads/2025/10/studio-assistant-blueprint-1.jpg)There are also several community projects that provide a user interface for creating Blueprints, which are worth checking out:

- [WordPress Playground Step Library](https://akirk.github.io/playground-step-library/)
- [Pootle Playground](https://pootleplayground.com/)
- [Block Based Visual Blueprint Builder](https://github.com/lubusIN/visual-blueprint-builder)

For those following the WordPress Playground project closely, you may be aware that a new version of Blueprints [is under development](https://github.com/WordPress/wordpress-playground/pull/2394). As soon as Blueprints v2 is stable in Playground, support will be added to Studio in a subsequent release. All v1 Blueprints will remain supported.
