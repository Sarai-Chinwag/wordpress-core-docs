---
type: document
title: Manage WordPress widgets
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/manage-wordpress-widgets/"
tags:
timestamp: "2026-06-16T19:29:12+00:00"
wordpress:
  id: 2414
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:12"
  date_gmt: "2026-06-16 19:29:12"
  modified: "2026-06-16 19:29:12"
  modified_gmt: "2026-06-16 19:29:12"
  slug: manage-wordpress-widgets
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/manage-wordpress-widgets/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

This article covers “Classic Widgets”. If you are using the newer block-based widgets, please check [this article](https://wordpress.org/documentation/article/block-based-widgets-editor/).

WordPress widgets add content and functionality to the widget area. The widget area is a pre-defined area by the theme, typically located in the sidebar or footer, but varies from theme to theme. Examples are the default widgets that come with WordPress; for Categories, Tag cloud, Search, etc. Plugins will often add their own widgets.

Widgets were originally designed to provide a simple and easy-to-use way of giving design and structure control of the WordPress Theme to the user, which is now available on properly “widgetized” WordPress Themes to include the header, footer, and elsewhere in the WordPress design and structure.

Widgets require no code experience or expertise. They can be added, removed, and rearranged on the **Theme Customizer** or **Appearance &gt; Widgets** in the WordPress Administration Screens.

Some WordPress Widgets offer customization and options such as forms to fill out, includes or excludes of data and information, optional images, and other customization features.

The [Block-based Widgets Editor](https://wordpress.org/documentation/article/block-based-widgets-editor/) explains how to use the updated Widgets experience with blocks.

The [Appearance Widgets Screen](https://wordpress.org/documentation/article/appearance-widgets-screen/) explains how to use the various Widgets that come with WordPress in the Classic experience.

Plugins that come bundled with widgets can be found in the [WordPress Plugin Directory](https://wordpress.org/extend/plugins/).

## Installing Widgets

WordPress comes pre-packaged with a variety of [Widgets](/support/article/glossary/#widget). If those are insufficient for your needs you can install new ones by searching the [WordPress Plugin Directory](https://wordpress.org/extend/plugins/) which is accessible from the WordPress Administration **Plugins &gt; Add New** Screen.

## Displaying Widgets

### Existing Widgets in Existing Widget Areas

Before you can add a Widget you must verify that the Theme you’re using supports Widgets (more specifically: [Widget Area](/support/article/glossary/#widget-area)). You can do so by simply navigating to the Appearance menu and looking for a sub menu titled “Widgets”.

If your Theme supports Theme Customizer then you can use the following Steps. In Theme Customizer, the live preview of changes is available.

![](https://wordpress.org/documentation/files/2018/10/appearance-customize-widgets.png)1. Go to **Appearance &gt; Customize** in the WordPress Administration Screens.
2. Click the **Widget** menu in the Theme Customizer to access to the Widget Customize Screen.
3. Click the **down arrow** of Widget Area to list the already registered Widgets.
4. Click Add a Widget button at the bottom of sidebar. It shows the list of available widgets.
5. Click a widget you want to add. The widgets should be added in the sidebar.
6. Preview your site and you should see the content from your new Widget.
7. To arrange the Widgets within the Sidebar, drag and drop the widgets in the order you want or click Reorder link and click up arrow and down allow of each widget and click Done after the arrange operation.
8. To customize the Widget features, click the **down arrow** in the right to expand the Widget’s interface.
9. To remove the widget, click **Remove** from Widget’s interface in above step.

If your Theme does not support Theme Customizer then you can use the following conventional steps:

![](https://wordpress.org/documentation/files/2018/10/designwidget-2.png)1. Go to **Appearance &gt; Widgets** in the WordPress Administration Screens.
2. Choose a Widget and either drag it to the sidebar where you wish it to appear, or click the widget, (select a destination sidebar if your theme has more than one) and click the Add Widget button. There might be more than one sidebar option, so begin with the first one. Once in place, WordPress automatically updates the Theme.
3. Preview the site. You should find that the “default” sidebar elements are now gone and only the new addition is visible.
4. Return to the Widgets Screen to continue adding Widgets.
5. To arrange the Widgets within the sidebar or Widget area, click and drag it into place.
6. To customize the Widget features, click the down arrow in the upper right corner to expand the Widget’s interface.
7. To save the Widget’s customization, click Save.
8. To remove the Widget, click Delete.

If you want to remove the widget but save its setting for possible future use, just drag it into the Inactive Widgets area. You can add them back anytime from there. This is especially helpful when you switch to a theme with fewer or different widget areas.

When changing themes, there is often some variation in the number and setup of widget areas/sidebars and sometimes these conflicts make the transition a bit less smooth. If you changed themes and seem to be missing widgets, scroll down on the screen to the Inactive Widgets area, where all of your widgets and their settings will have been saved.

Enabling Accessibility Mode, via Screen Options, allows you to use Add and Edit buttons instead of using drag and drop.

### Widget Areas

While widget areas typically occur in webpage sidebars, a theme can place widget areas anywhere on a page. For example, besides the usual sidebar locations, the [Twenty Seventeen](/support/article/twenty-seventeen/) theme has a widget area in the footer of every page.

## Using Text Widgets

The Text Widget is one of the most commonly used WordPress Widgets that comes with every WordPress installation. It allows users to add text, video, images, custom lists, and more to their WordPress sites.

To use the WordPress Text Widget:

1. Go to **Appearance &gt; Customize** in the WordPress Administration Screens and click the **Widget** menu in the Theme Customizer. Or Go to **Appearance &gt; Widgets** in the WordPress Administration Screens.
2. Open the sidebar to which you wish to add the Text Widget.
3. Find the Text Widget in the list of Widgets.
4. Click and drag the Widget to the spot you wish it to appear.

To open and edit the Text Widget:

1. Click the down arrow to the right of the Text Widget title.
2. Set the Text Widget Title (optional).
3. Add the text or HTML code to the box or edit what is currently there.
4. Choose the option to **Automatically add paragraphs** to wrap each block of text in an HTML paragraph tag (recommended for text).
5. Click Save to save the Text Widget.
6. Click Close to close the Text Widget.
7. Switch tabs in your browser and preview the results and make changes if necessary.

The Text Widget can hold a variety of HTML, XHTML, and multimedia links and players such as video and object embeds.

### Adding Code to the Text Widget

Basic HTML, embeds, and JavaScript are added easily to the WordPress Text Widget. Most embed codes from social sharing sites for multimedia will work in a WordPress Text Widget. However, active code and programming languages such as PHP will not work as the Widget will strip out code it cannot display.

To add active code to the Text Widget, use one of the many WordPress Plugins from the [WordPress Plugin Directory](https://wordpress.org/plugins/) that override WordPress restrictions on using PHP in posts. Check that they will work on Widgets as some will not.

## Using RSS Widgets

The RSS Widget allows you to integrate an external feed source for content into a Widget area of your site, such as your Twitter account, Facebook posts, Google+ posts, or other blogs.

The RSS Widget displays the most recently published content from any source with an active feed. This is an ideal way of integrating outside content into your site.

By default, WordPress RSS Widget displays the post title or the first 100 or so characters of a Tweet or long untitled post. These are either in the form of a link or features a link to the original source depending upon the feed’s design and structure.

1. Enter the RSS feed URL in the first box, copied from the source page for the content you wish to include in your sidebar or other widgetized space.
2. Give the feed a title: This is optional and gives you the chance to showcase the source of the content.
3. How many items would you like to display?: By default, 10 are show, but you can choose from 1-20 posts.
4. Display item content?: This allows you to show an excerpt of the content not just the title.
5. Display item author if available?: If you wish to give credit to the original author of the content, check this to display the author.
6. Display item date?: If available, the date of the original content will be shown.

You may add multiple RSS Widgets for incoming feeds to your WordPress sidebar and other widgetized areas of your site.

## Resources

- [WordPress Widgets Announcement (historical reference)](https://wordpress.org/development/2006/03/widgets-plugin/)
