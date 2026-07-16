---
type: document
title: "Step 3: Set up GitHub"
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/github/"
tags:
timestamp: "2026-06-16T19:29:24+00:00"
wordpress:
  id: 2470
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:24"
  date_gmt: "2026-06-16 19:29:24"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: github
  parent: 2510
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/github/"
  comment_count: 0
---

We recommend creating a GitHub repository for each project you’re working on—a theme, a plugin, or a full site. You can [create a free GitHub account](https://github.com/signup?source=header-home) and then set up as many public or private repositories as you like. GitHub will give you the flexibility of version control and can [effortlessly sync with your WordPress.com production or staging site](https://developer.wordpress.com/docs/get-started/deploy/).

This development workflow is recommended for most use cases, but an alternative option is [Studio Sync](https://developer.wordpress.com/docs/developer-tools/studio/sync/). This feature allows you to synchronize a complete WordPress.com site with a local WordPress Studio site in either direction without requiring GitHub. Studio Sync can also [complement GitHub-based development workflows](https://wordpress.com/blog/2025/03/19/local-wordpress-development-workflows/) for added flexibility.

There are many ways to add your code to a GitHub repository, like using the command line. However, we recommend using [GitHub Desktop](https://desktop.github.com/download/), a free app that serves as a GUI for your commits and pull requests. It allows you to seamlessly interact with your local site files and GitHub repositories through an intuitive visual interface.

The tutorials below will cover this workflow.

[Download GitHub Desktop](https://desktop.github.com/download/)

## If you’re working on a new theme

First, you’ll need to create a local repository inside of your theme folder:

1. In GitHub Desktop, click the “**Create a New Repository on your Local Drive…**” button or navigate to *File &gt; New Repository*.
2. In the “**Repository Name**” field, type the name of the theme you’re developing. It should match the name of the theme in your `wp-content/themes/` folder.
3. In the “**Local Path**” field, select the `wp-content/themes/` folder in your Studio site (the path will look something like this: `/Users/user_name/Studio/site_name/wp-content/themes`).
4. Click **“Create Repository**“.

Once you click the “**Create Repository”** button, you will have created a local repository. Two hidden files will be added to your individual theme folder (`.git` and `.gitattributes`).

If you attempt to enter the details of a folder that is already configured as a Git repository, then GitHub desktop will prompt you to add this repository instead.

You can now create your theme inside this local repository.

To publish your local repository to GitHub:

1. Go to GitHub Desktop and click the “**Publish repository”** button.
2. If you aren’t already, you will be asked to sign into your GitHub account.
3. Name your public repository; you can give it any name, but it’s a good idea to keep it the same name as the theme folder. You can also select whether you want your code to be public or private using the checkbox provided.
4. Click **“Publish Repository**“.

Once published, you should be able to see your repository with your theme code on GitHub.

## If you’re working on a new plugin

First, you’ll need to create a local repository inside of your plugin folder:

1. In GitHub Desktop, click the “**Create a New Repository on your Local Drive…**” button or navigate to *File &gt; New Repository*.
2. In the “**Repository Name**” field, type the name of the plugin you’re developing. It should match the name of the plugin in your `wp-content/plugins/` folder.
3. In the “**Local Path**” field, select the `wp-content/plugins/` folder in your Studio site (the path will look something like this: `/Users/user_name/Studio/site_name/wp-content/plugins`).
4. Click “**Create Repository**“.

Once you click the “**Create Repository**” button, you will have created a local repository. Two hidden files will be added to your individual theme folder (`.git` and `.gitattributes`).

If you attempt to enter the details of a folder that is already configured as a Git repository, then GitHub desktop will prompt you to add this repository instead.

To publish your local repository to GitHub:

1. Go to GitHub Desktop and click the “**Publish Repository**” button.
2. Name your public repository; you can give it any name, but it’s a good idea to keep it the same name as the theme folder. You can also select whether you want your code to be public or private using the checkbox provided.
3. Click “**Publish Repository**“.

Once published, you should be able to see your repository with your plugin code on GitHub.

## If you want to sync all `wp-content` files

If you’re not working on a specific plugin or theme and want to place a full site under version control, we recommend only tracking what’s inside the `wp-content` folder. This is where all your customizations are stored that make your site unique. The majority of WordPress core files usually remain unchanged and can be re-downloaded if necessary. The `wp-config.php` file is an exception, as it contains essential configuration details, primarily for your database connection.

If you want to sync the full website, including the database, consider using [Studio Sync](https://developer.wordpress.com/docs/developer-tools/studio/sync/). While version control is not provided by Studio Sync itself, you can use this feature alongside GitHub-based development workflows.

First, you’ll need to create a local repository in your site `wp-content` folder:

1. In WordPress Studio, select your site and click on the **Overview** tab.
2. Under the “**Open in…**“ section, open the site folder in your [chosen code editor](https://developer.wordpress.com/docs/developer-tools/studio/sites/#6--open-in-section).
3. Create a file named `.gitignore` inside the `wp-content` folder.
4. Add the following folder and file names to this new `.gitignore` file to avoid tracking them in your repository. This will exclude the plugins required by Studio, your SQLite database, and your uploads folder. **For this reason your posts, pages and images from your local site won’t be committed to your production site.**

```
mu-plugins
database
db.php
uploads
```

mu-plugins database db.php uploadsCopyCopied

1. In GitHub Desktop, click the “**Create a New Repository on your Local Drive…**” button or navigate to *File &gt; New Repository*.
2. In the “**Repository Name**” field, type `wp-content`, to match the name of your `wp-content` folder.
3. In the “**Local Path**” field, select the folder of your Studio site (the path will look something like this: `/Users/user_name/Studio/site_name`).
4. Click “**Create Repository**“.

Once you click the “**Create Repository**” button, you will have created a local repository. Two hidden files will be added to your individual theme folder (`.git` and `.gitattributes`).

To publish your local repository to GitHub:

1. Go to GitHub Desktop and click the “**Publish Repository**” button.
2. Name your public repository; you can give it any name. You can also select whether you want your code to be public or private using the checkbox provided.
3. Click “**Publish Repository**“.
