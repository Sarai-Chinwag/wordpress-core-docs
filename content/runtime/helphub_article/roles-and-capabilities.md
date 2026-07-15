---
type: document
title: Roles and Capabilities
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/roles-and-capabilities/"
tags:
timestamp: "2026-06-16T19:29:03+00:00"
wordpress:
  id: 2366
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:03"
  date_gmt: "2026-06-16 19:29:03"
  modified: "2026-06-16 19:29:03"
  modified_gmt: "2026-06-16 19:29:03"
  slug: roles-and-capabilities
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/roles-and-capabilities/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

WordPress uses a concept of [Roles](#roles), designed to give the [site](/support/article/glossary/#site) owner the ability to control what users can and cannot do within the site. A site owner can manage the user access to such tasks as [writing and editing posts](/support/article/writing-posts/), [creating Pages](/support/article/pages/), [creating categories](https://codex.wordpress.org/Posts_Categories_SubPanel), [moderating comments](https://codex.wordpress.org/Comment_Moderation), [managing plugins](/support/article/managing-plugins/), [managing themes](/support/article/using-themes/), and [managing other users](https://codex.wordpress.org/Users_Screen), by assigning a specific role to each of the users.

WordPress has six pre-defined roles: [Super Admin](/support/article/roles-and-capabilities/#super-admin), [Administrator](#administrator), [Editor](#editor), [Author](#author), [Contributor](#contributor) and [Subscriber](#subscriber). Each role is allowed to perform a set of tasks called [Capabilities](/support/article/glossary/#capabilities). There are many capabilities including “[publish\_posts](#publish_posts)“, “[moderate\_comments](#moderate_comments)“, and “[edit\_users](#edit_users)“. [A default set](#capability-vs-role-table) of capabilities is pre-assigned to each role, but other capabilities can be assigned or removed using the [add\_cap()](https://codex.wordpress.org/Function_Reference/add_cap) and [remove\_cap()](https://codex.wordpress.org/Function_Reference/remove_cap) functions. New roles can be introduced or removed using the [add\_role()](https://codex.wordpress.org/Function_Reference/add_role) and [remove\_role()](https://codex.wordpress.org/Function_Reference/remove_role) functions.

The [Super Admin](#super-admin) role allows a user to perform all possible capabilities. Each of the other roles has a decreasing number of allowed capabilities. For instance, the [Subscriber](#subscriber) role has just the “[read](#read)” capability. One particular role should not be considered to be senior to another role. Rather, consider that roles define the user’s responsibilities within the site.

## Summary of Roles

- [Super Admin](#super-admin) – somebody with access to the site network administration features and all other features. See the [Create a Network](/support/article/create-a-network/) article.
- [Administrator](#administrator) (*slug: ‘administrator’*) – somebody who has access to all the administration features within a single site.
- [Editor](#editor) (*slug: ‘editor’*) – somebody who can publish and manage posts including the posts of other users.
- [Author](#author) (*slug: ‘author’*) – somebody who can publish and manage their own posts.
- [Contributor](#contributor) (*slug: ‘contributor’*) – somebody who can write and manage their own posts but cannot publish them.
- [Subscriber](#subscriber) (*slug: ‘subscriber’*) – somebody who can only manage their profile.

Upon installing WordPress, an Administrator account is automatically created.

The default role for new users can be set in [Administration Screens](/support/article/administration-screens/) &gt; [Settings](/support/article/administration-screens/#settings-configuration-settings) &gt; [General](/support/article/settings-general-screen/).

## Roles

A Role defines a set of tasks a user assigned the role is allowed to perform. For instance, the [Super Admin](#super-admin) role encompasses every possible task that can be performed within a [Network](/support/article/glossary/#network) of virtual WordPress [sites](/support/article/glossary/#site). The [Administrator](#administrator) role limits the allowed tasks only to those which affect a single site. On the other hand, the [Author](#author) role allows the execution of just a small subset of tasks.

The following sections list the default Roles and their capabilities:

### Super Admin

Multisite Super Admins have, by default, all capabilities. The following Multisite-only capabilities are therefore only available to Super Admins:

- [create\_sites](#create_sites)
- [delete\_sites](#delete_sites)
- [manage\_network](#manage_network)
- [manage\_sites](#manage_sites)
- [manage\_network\_users](#manage_network_users)
- [manage\_network\_plugins](#manage_network_plugins)
- [manage\_network\_themes](#manage_network_themes)
- [manage\_network\_options](#manage_network_options)
- [upgrade\_network](#upgrade_network)
- [setup\_network](#setup_network)

In the case of single site WordPress installation, Administrators are, in effect, Super Admins. As such, they are the only ones to have access to [additional admin capabilities](/support/article/roles-and-capabilities/#additional-admin-capabilities).

### Administrator

The capabilities of Administrators differs between single site and [Multisite](/support/article/glossary/#multisite) WordPress installations. All administrators have the following capabilities:

- [activate\_plugins](#activate_plugins)
- [delete\_others\_pages](#delete_others_pages)
- [delete\_others\_posts](#delete_others_posts)
- [delete\_pages](#delete_pages)
- [delete\_posts](#delete_posts)
- [delete\_private\_pages](#delete_private_pages)
- [delete\_private\_posts](#delete_private_posts)
- [delete\_published\_pages](#delete_published_pages)
- [delete\_published\_posts](#delete_published_posts)
- [edit\_dashboard](#edit_dashboard)
- [edit\_others\_pages](#edit_others_pages)
- [edit\_others\_posts](#edit_others_posts)
- [edit\_pages](#edit_pages)
- [edit\_posts](#edit_posts)
- [edit\_private\_pages](#edit_private_pages)
- [edit\_private\_posts](#edit_private_posts)
- [edit\_published\_pages](#edit_published_pages)
- [edit\_published\_posts](#edit_published_posts)
- [edit\_theme\_options](#edit_theme_options)
- [export](#export)
- [import](#import)
- [list\_users](#list_users)
- [manage\_categories](#manage_categories)
- [manage\_links](#manage_links)
- [manage\_options](#manage_options)
- [moderate\_comments](#moderate_comments)
- [promote\_users](#promote_users)
- [publish\_pages](#publish_pages)
- [publish\_posts](#publish_posts)
- [read\_private\_pages](#read_private_pages)
- [read\_private\_posts](#read_private_posts)
- [read](#read)
- [remove\_users](#remove_users)
- [switch\_themes](#switch_themes)
- [upload\_files](#upload_files)
- [customize](#customize)
- [delete\_site](#delete_site)

#### Additional Admin Capabilities

Only Administrators of single site installations have the following capabilities. In [Multisite](/support/article/glossary/#multisite), only the Super Admin has these abilities:

- [update\_core](#update_core)
- [update\_plugins](#update_plugins)
- [update\_themes](#update_themes)
- [install\_plugins](#install_plugins)
- [install\_themes](#install_themes)
- [delete\_themes](#delete_themes)
- [delete\_plugins](#delete_plugins)
- [edit\_plugins](#edit_plugins)
- [edit\_themes](#edit_themes)
- [edit\_files](#edit_files)
- [edit\_users](#edit_users)
- [add\_users](#add_users)
- [create\_users](#create_users)
- [delete\_users](#delete_users)
- [unfiltered\_html](#unfiltered_html)

### Editor

- [delete\_others\_pages](#delete_others_pages)
- [delete\_others\_posts](#delete_others_posts)
- [delete\_pages](#delete_pages)
- [delete\_posts](#delete_posts)
- [delete\_private\_pages](#delete_private_pages)
- [delete\_private\_posts](#delete_private_posts)
- [delete\_published\_pages](#delete_published_pages)
- [delete\_published\_posts](#delete_published_posts)
- [edit\_others\_pages](#edit_others_pages)
- [edit\_others\_posts](#edit_others_posts)
- [edit\_pages](#edit_pages)
- [edit\_posts](#edit_posts)
- [edit\_private\_pages](#edit_private_pages)
- [edit\_private\_posts](#edit_private_posts)
- [edit\_published\_pages](#edit_published_pages)
- [edit\_published\_posts](#edit_published_posts)
- [manage\_categories](#manage_categories)
- [manage\_links](#manage_links)
- [moderate\_comments](#moderate_comments)
- [publish\_pages](#publish_pages)
- [publish\_posts](#publish_posts)
- [read](#read)
- [read\_private\_pages](#read_private_pages)
- [read\_private\_posts](#read_private_posts)
- [unfiltered\_html](#unfiltered_html) (not with Multisite)
- [upload\_files](#upload_files)

### Author

- [delete\_posts](#delete_posts)
- [delete\_published\_posts](#delete_published_posts)
- [edit\_posts](#edit_posts)
- [edit\_published\_posts](#edit_published_posts)
- [publish\_posts](#publish_posts)
- [read](#read)
- [upload\_files](#upload_files)

### Contributor

- [delete\_posts](#delete_posts)
- [edit\_posts](#edit_posts)
- [read](#read)

### Subscriber

- [read](#read)

### Special Cases

The following capabilities are special cases:

- [unfiltered\_upload](#unfiltered_upload) – This capability is not available to any role by default (including Super Admins). The capability needs to be enabled by defining the following constant:

```
define( 'ALLOW_UNFILTERED_UPLOADS', true );
```

With this constant defined, all roles on a single site install can be given the unfiltered\_upload capability, but only Super Admins can be given the capability on a Multisite install.

### Capability vs. Role Table

Note that the capabilities of Administrators **differs** between single site and [Multisite](/support/article/glossary/#multisite) WordPress installations, [as described above](#additional-admin-capabilities) .

| Capability | Super Admin | Administrator | Editor | Author | Contributor | Subscriber |
|---|---|---|---|---|---|---|
| create\_sites | yes | x | x | x | x | x |
| delete\_sites | yes | x | x | x | x | x |
| manage\_network | yes | x | x | x | x | x |
| manage\_sites | yes | x | x | x | x | x |
| manage\_network\_users | yes | x | x | x | x | x |
| manage\_network\_plugins | yes | x | x | x | x | x |
| manage\_network\_themes | yes | x | x | x | x | x |
| manage\_network\_options | yes | x | x | x | x | x |
| upload\_plugins | yes | x | x | x | x | x |
| upload\_themes | yes | x | x | x | x | x |
| upload\_network | yes | x | x | x | x | x |
| upgrade\_network | yes | x | x | x | x | x |
| setup\_network | yes | x | x | x | x | x |
| activate\_plugins | yes | yes (single site or  enabled by  network setting) | x | x | x | x |
| create\_users | yes | yes (single site) | x | x | x | x |
| delete\_plugins | yes | yes (single site) | x | x | x | x |
| delete\_themes | yes | yes (single site) | x | x | x | x |
| delete\_users | yes | yes (single site) | x | x | x | x |
| edit\_files | yes | yes (single site) | x | x | x | x |
| edit\_plugins | yes | yes (single site) | x | x | x | x |
| edit\_theme\_options | yes | yes | x | x | x | x |
| edit\_themes | yes | yes (single site) | x | x | x | x |
| edit\_users | yes | yes (single site) | x | x | x | x |
| export | yes | yes | x | x | x | x |
| import | yes | yes | x | x | x | x |
| install\_plugins | yes | yes (single site) | x | x | x | x |
| install\_themes | yes | yes (single site) | x | x | x | x |
| list\_users | yes | yes | x | x | x | x |
| manage\_options | yes | yes | x | x | x | x |
| promote\_users | yes | yes | x | x | x | x |
| remove\_users | yes | yes | x | x | x | x |
| switch\_themes | yes | yes | x | x | x | x |
| update\_core | yes | yes (single site) | x | x | x | x |
| update\_plugins | yes | yes (single site) | x | x | x | x |
| update\_themes | yes | yes (single site) | x | x | x | x |
| edit\_dashboard | yes | yes | x | x | x | x |
| customize | yes | yes | x | x | x | x |
| delete\_site | yes | yes | x | x | x | x |
| moderate\_comments | yes | yes | yes | x | x | x |
| manage\_categories | yes | yes | yes | x | x | x |
| manage\_links | yes | yes | yes | x | x | x |
| edit\_others\_posts | yes | yes | yes | x | x | x |
| edit\_pages | yes | yes | yes | x | x | x |
| edit\_others\_pages | yes | yes | yes | x | x | x |
| edit\_published\_pages | yes | yes | yes | x | x | x |
| publish\_pages | yes | yes | yes | x | x | x |
| delete\_pages | yes | yes | yes | x | x | x |
| delete\_others\_pages | yes | yes | yes | x | x | x |
| delete\_published\_pages | yes | yes | yes | x | x | x |
| delete\_others\_pos | yes | yes | yes | x | x | x |
| delete\_private\_posts | yes | yes | yes | x | x | x |
| edit\_private\_posts | yes | yes | yes | x | x | x |
| read\_private\_posts | yes | yes | yes | x | x | x |
| delete\_private\_pages | yes | yes | yes | x | x | x |
| edit\_private\_pages | yes | yes | yes | x | x | x |
| read\_private\_pages | yes | yes | yes | x | x | x |
| unfiltered\_html | yes | yes (single site) | yes (single site) | x | x | x |
| unfiltered\_html | yes | yes | yes | x | x | x |
| edit\_published\_posts | yes | yes | yes | yes | x | x |
| upload\_files | yes | yes | yes | yes | x | x |
| publish\_posts | yes | yes | yes | yes | x | x |
| delete\_published\_posts | yes | yes | yes | yes | x | x |
| edit\_posts | yes | yes | yes | yes | yes | x |
| delete\_posts | yes | yes | yes | yes | yes | x |
| read | yes | yes | yes | yes | yes | yes |

## Capabilities

### switch\_themes

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - Appearance
    - Appearance &gt; Themes

### edit\_themes

- Since 2.0
- Allows access to Appearance &gt; [Theme Editor](https://codex.wordpress.org/Appearance_Editor_SubPanel) to edit theme files.

### edit\_theme\_options

- Since 3.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - Appearance &gt; [Widgets](https://codex.wordpress.org/Appearance_Widgets_SubPanel)
    - Appearance &gt; [Menus](/support/article/appearance-menus-screen/)
    - Appearance &gt; [Customize](/support/article/appearance-customize-screen/) if they are supported by the current theme
    - Appearance &gt; [Header](https://codex.wordpress.org/Appearance_Header_SubPanel)

### install\_themes

- Since 2.8
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - Appearance &gt; Add New Themes

### activate\_plugins

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - [Plugins](/support/article/administration-screens/#plugins-add-functionality-to-your-blog)

### edit\_plugins

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - [Plugins](/support/article/administration-screens/#plugins-add-functionality-to-your-blog) &gt; [Plugin Editor](/support/article/administration-screens/#plugin-editor)

### install\_plugins

- Since 2.7
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - [Plugins](/support/article/administration-screens/#plugins-add-functionality-to-your-blog) &gt; Add New

### edit\_users

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - [Users](/support/article/administration-screens/#users-your-blogging-family)

### edit\_files

- Since 2.0
- **Note:** No longer used.

### manage\_options

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - Settings &gt; General
    - Settings &gt; Writing
    - Settings &gt; Reading
    - Settings &gt; Discussion
    - Settings &gt; Permalinks
    - Settings &gt; Miscellaneous

### moderate\_comments

- Since 2.0
- Allows users to moderate comments from the Comments Screen (although a user needs the [edit\_posts](#edit_posts) Capability in order to access this)

### manage\_categories

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - Posts &gt; Categories
    - Links &gt; Categories

### manage\_links

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - Links
    - Links &gt; Add New

### upload\_files

- Since 2.0
- Allows access to [Administration Screens ](/support/article/administration-screens/)options:
    - Media
    - Media &gt; Add New

### import

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - Tools &gt; Import
    - Tools &gt; Export

### unfiltered\_html

- Since 2.0
- Allows user to post HTML markup or even JavaScript code in pages, posts, comments and widgets.
- **Note:** Enabling this option for untrusted users may result in their posting malicious or poorly formatted code.
- **Note:** In WordPress Multisite, only Super Admins have the `unfiltered_html` capability.

### edit\_posts

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - Posts
    - Posts &gt; Add New
    - Comments
    - Comments &gt; Awaiting Moderation

### edit\_others\_posts

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - Manage &gt; Comments (*Lets user delete and edit every comment, see edit\_posts above*)
- user can edit other users’ posts through function get\_others\_drafts()
- user can see other users’ images in inline-uploading \[no? see [inline-uploading.php](https://trac.wordpress.org/file/trunk/wp-admin/inline-uploading.php)\]
- See [Exceptions](#exceptions)

### edit\_published\_posts

- Since 2.0
- User can edit their published posts. *This capability is off by default.*
- The core checks the capability **edit\_posts**, but on demand this check is changed to **edit\_published\_posts**.
- If you don’t want a user to be able to edit their published posts, remove this capability.

### publish\_posts

- Since 2.0
- See and use the “publish” button when editing their post *(otherwise they can only save drafts)*
- Can use XML-RPC to publish *(otherwise they get a “Sorry, you can not post on this weblog or category.”)*

### edit\_pages

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - Pages
    - Pages &gt; Add New

### read

- Since 2.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - [Dashboard](/support/article/dashboard-screen/)
    - Users &gt; Your Profile
- *Used nowhere in the core code except the menu.php*

### publish\_pages

- Since 2.1

### edit\_others\_pages

- Since 2.1

### edit\_published\_pages

- Since 2.1

### delete\_pages

- Since 2.1

### delete\_others\_pages

- Since 2.1

### delete\_published\_pages

- Since 2.1

### delete\_posts

- Since 2.1

### delete\_others\_posts

- Since 2.1

### delete\_published\_posts

- Since 2.1

### delete\_private\_posts

- Since 2.1

### edit\_private\_posts

- Since 2.1

### read\_private\_posts

- Since 2.1

### delete\_private\_pages

- Since 2.1

### edit\_private\_pages

- Since 2.1

### read\_private\_pages

- Since 2.1

### delete\_users

- Since 2.1

### create\_users

- Since 2.1
- Allows creating new users.
    - Without other capabilities, created users will have your blog’s [New User Default Role](/support/article/settings-general-screen/).

### unfiltered\_upload

- Since 2.3

### edit\_dashboard

- Since 2.5

### customize

- Since 4.0
- Allows access to the Customizer.

### delete\_site

- Since 4.0
- Allows the user to delete the current site (Multisite only).

### update\_plugins

- Since 2.6

### delete\_plugins

- Since 2.6

### update\_themes

- Since 2.7

### update\_core

- Since 3.0

### list\_users

- Since 3.0
- Allows access to [Administration Screens](/support/article/administration-screens/) options:
    - [Users](/support/article/administration-screens/#users-your-blogging-family)

### remove\_users

- Since 3.0

### add\_users

- Since 3.0
- Replaced in 4.4 with [promote\_users](#promote_users)

### promote\_users

- Since 3.0
- Enables the “Change role to…” dropdown in the admin user list.
    - This does not depend on ‘[edit\_users](#edit_users)‘ capability.
- Enables the ‘Add Existing User’ to function for multi-site installs.

### delete\_themes

- Since 3.0

### export

- Since 3.0

### edit\_comment

- Since 3.1

### create\_sites

- Since 3.1
- Multi-site only
- Allows user to create sites on the network

### delete\_sites

- Since 3.1
- Multi-site only
- Allows user to delete sites on the network

### manage\_network

- Since 3.0
- Multi-site only
- Allows access to [Super Admin](/support/article/multisite-network-administration/) menu
- Allows user to upgrade network

### manage\_sites

- Since 3.0
- Multi-site only
- Allows access to [Network Sites](https://codex.wordpress.org/Network_Admin#Sites) menu
- Allows user to add, edit, delete, archive, unarchive, activate, deactivate, spam and unspam new site/blog in the network

### manage\_network\_users

- Since 3.0
- Multi-site only
- Allows access to [Network Users](https://codex.wordpress.org/Network_Admin#Users) menu

### manage\_network\_themes

- Since 3.0
- Multi-site only
- Allows access to [Network Themes](https://codex.wordpress.org/Network_Admin#Themes) menu

### manage\_network\_options

- Since 3.0
- Multi-site only
- Allows access to [Network Options](https://codex.wordpress.org/Network_Admin#Settings) menu

### manage\_network\_plugins

- Multi-site only
- Allows access to [Network Plugins](https://codex.wordpress.org/Network_Admin#Plugins) menu

### upload\_plugins

- Since 4.0
- Multi-site only
- Allows user to upload plugin ZIP files from the [Network Plugins](https://codex.wordpress.org/Network_Admin#Plugins) -&gt; Add New menu

### upload\_themes

- Since 4.0
- Multi-site only
- Allows user to upload theme ZIP files from the [Network Themes](https://codex.wordpress.org/Network_Admin#Themes) -&gt; Add New menu

### upgrade\_network

- Since 4.8
- Multi-site only
- is used to determine whether a user can access the Network Upgrade page in the network admin. Related to this, the capability is also checked to determine whether to show the notice that a network upgrade is required. The capability is not mapped, so it is only granted to network administrators. See [\#39205](https://core.trac.wordpress.org/ticket/39205) for background discussion.

### setup\_network

- Since 4.8
- Multi-site only
- is used to determine whether a user can setup multisite, i.e. access the Network Setup page. Before setting up a multisite, the capability is mapped to the `manage\_options` capability, so that it is granted to administrators. Once multisite is setup, it is mapped to `manage\_network\_options`, so that it is granted to network administrators. See [\#39206](https://core.trac.wordpress.org/ticket/39206) for background discussion.

## Resources

### Plugins

- [Members Plugin](https://wordpress.org/plugins/members/)
- [User Access Manager](https://wordpress.org/plugins/user-access-manager/)
- [Advanced Access Manager](https://wordpress.org/plugins/advanced-access-manager/)
- [User Role Editor](https://wordpress.org/plugins/user-role-editor/)
- [WordPress User Role Editor](https://wordpress.org/plugins/wpfront-user-role-editor/)
- [Simple Membership Plugin](https://wordpress.org/plugins/simple-membership/)
- [View Admin As](https://wordpress.org/plugins/view-admin-as/) (manage &amp; test roles)
