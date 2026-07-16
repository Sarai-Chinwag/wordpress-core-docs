---
type: document
title: Work with themes
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/work-with-themes/"
tags:
timestamp: "2026-06-16T19:28:37+00:00"
wordpress:
  id: 2238
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:37"
  date_gmt: "2026-06-16 19:28:37"
  modified: "2026-06-16 19:28:37"
  modified_gmt: "2026-06-16 19:28:37"
  slug: work-with-themes
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/work-with-themes/"
  comment_count: 0
  terms:
    category:
      - appearance
      - customization
---

## What is a Theme?

Fundamentally, the WordPress Theme system is a way to “skin” your WordPress site. Yet, it is more than just a “skin”. Skinning your site implies that only the design is changed. WordPress Themes can provide much more control over the visual presentation of your content and other data on your WordPress site, as well as behavior of certain site’s elements while interacting with visitors.

A WordPress Theme is a collection of files that work together to produce a graphical interface with an underlying unifying design for a website. These files are called [template files](https://developer.wordpress.org/themes/basics/template-files/). A Theme modifies the way the site is displayed, without modifying the underlying software. Themes may include customized template files, image files (\*.jpg, \*.png, \*.gif), style sheets (\*.css), custom [Pages](/support/article/pages/), as well as any necessary code files (\*.php). For an introduction to template files, see [Template Files](https://developer.wordpress.org/themes/basics/template-files/).

Let’s say you write a lot about cheese and gadgets. Through the use of the [WordPress Loop](https://developer.wordpress.org/themes/basics/the-loop/) and [template files](https://developer.wordpress.org/themes/basics/template-files/), you can customize your Cheese category posts to look different from your Gadgets category posts. With this powerful control over what different pages and categories look like on your site, you are limited only by your imagination. For information on how to create custom look for various templates in your theme, take a look at [Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/).

[![](https://wordpress.org/documentation/files/2018/10/template-hierarchy.png)](https://wphierarchy.com/)Template Hierarchy – the structure of WordPress theme filesTo better understand this diagram, you can [interact with it](https://wphierarchy.com/).

## Default Themes

WordPress currently comes with twelve themes: the default [Twenty Twenty Two theme](https://wordpress.org/themes/twentytwentytwo/) ([demo](https://2022.wordpress.net/)), and the previous defaults [Twenty Twenty One theme](https://wordpress.org/themes/twentytwentyone/) ([demo](https://2021.wordpress.net/)) [Twenty Twenty](https://wordpress.org/documentation/article/twenty-twenty/) ([demo](http://2020.wordpress.net/)) [Twenty Nineteen](https://wordpress.org/documentation/article/twenty-nineteen/) ([demo](http://2019.wordpress.net/)) [Twenty Seventeen](https://wordpress.org/documentation/article/twenty-seventeen/) ([demo](http://2017.wordpress.net/)) [Twenty Sixteen](https://wordpress.org/documentation/article/twenty-sixteen/) ([demo](https://twentysixteendemo.wordpress.com/)) [Twenty Fifteen](https://wordpress.org/documentation/article/twenty-fifteen/) ([demo](https://twentyfifteendemo.wordpress.com/)) [Twenty Fourteen](https://wordpress.org/themes/twentyfourteen/) ([demo](https://twentyfourteendemo.wordpress.com/)) [Twenty Thirteen](https://wordpress.org/themes/twentythirteen/) ([demo](https://twentythirteendemo.wordpress.com/)) [Twenty Twelve](https://wordpress.org/themes/twentytwelve/) ([demo](https://twentytwelvedemo.wordpress.com/)) [Twenty Eleven](https://wordpress.org/themes/twentyeleven/) ([demo](https://twentyelevendemo.wordpress.com/)) [Twenty Ten](https://wordpress.org/themes/twentyten/) ([demo](https://twentytendemo.wordpress.com/)).

The Twenty Twenty Two theme is the first ever default [block theme](https://wordpress.org/documentation/article/block-themes/). It currently only works if you are using WordPress 5.9 and above or if you install the Gutenberg plugin alongside prior WordPress versions.

***NOTE***: All default themes now come bundled with [block patterns](https://wordpress.org/documentation/article/block-pattern/), which allow you to easily create beautiful layouts. Find out which patterns are added to themes on the [Make WordPress Blog](https://make.wordpress.org/core/2021/06/21/bundled-themes-changes-in-wordpress-5-8/).

You can switch between Themes from the Appearance menu in the Administration Screen. Themes you add to the theme directory will appear in the [Administration Screen](/support/article/administration-screens/) &gt; [Appearance](/support/article/administration-screens/#appearance-change-the-look-of-your-blog) &gt; [Themes](/support/article/administration-screens/#themes) as additional selections.

[![Themes Administration Screen - Installed Themes](https://wordpress.org/documentation/files/2021/06/themes-administration-screen-1024x503.png)](https://wordpress.org/documentation/files/2021/06/themes-administration-screen.png)Themes Administration Screen – Installed Themes## Get New Themes

The [WordPress Theme Directory](https://wordpress.org/themes/) is the official site for WordPress Themes. Every theme in this directory is reviewed by a dedicated team and tested against wide range of rules, all of which are ensuring secure and pleasant experience for theme user.

With over 9,000 themes in the directory, you can easily find the right one for your site with advanced search feature using filters for layout, subject and specific theme’s features. This includes finding [Block themes](https://wordpress.org/documentation/article/block-themes/) which support full site editing features.

[![Themes Directory - Feature Filter](https://wordpress.org/documentation/files/2021/06/themes-feature-filter.png)](https://wordpress.org/documentation/article/using-themes/themes-feature-filter-2/)Themes Directory – Feature FilterIf you need more than a screenshot and features list to decide whether the theme fits your needs, you can see the demo for the theme with **Preview** feature on [theme’s info page](https://wordpress.org/themes/twentytwentyone/).

![Twenty Twenty-One Theme Info Page](https://wordpress.org/documentation/files/2021/06/theme-info-page.png)Theme Info Page## Adding New Themes

Most of themes in [WordPress Theme Directory](https://wordpress.org/themes/) come with installation instructions, especially the ones that may require more steps than the usual theme installation. Be sure to read through and follow those instructions for the successful installation of the Theme. If your Theme does not work after following any provided instructions, please **contact the Theme author for help**.

### Adding Block themes

A [block theme](https://wordpress.org/documentation/article/block-themes/) is a theme that uses blocks for all parts of a site, including navigation menus, header, content, and site footer. These themes are built for the newest features coming to WordPress that allow you to edit and customize all parts of your site.

Currently, you can add block themes in the same way you would any other theme. However, the Live Preview option is removed which means you will need to [set up a test site](https://wordpress.org/documentation/article/test-driving-wordpress/) first to explore the theme before activating if you wish to preview it. You also will not have the option to use the Customizer since block themes rely on the [Site Editor](https://wordpress.org/documentation/article/site-editor/) to edit all parts of your site. In order to customize a block theme, you’ll need to activate it first.

You can [read more about this current experience here](https://make.wordpress.org/core/2022/01/07/state-of-the-customizer-with-block-themes-in-wordpress-5-9/).

### Adding New Themes using the Administration Screens

You can download any theme from [WordPress Theme Directory](https://wordpress.org/themes/) directly to your site by using the **Add New** option in the Appearance sub-menu.

1. Log in to the WordPress [Administration Screens](/support/article/administration-screens/).
2. Select the [Appearance](/support/article/administration-screens/#appearance-change-the-look-of-your-blog) screen, then [Themes](/support/article/administration-screens/#themes).
3. Select **Add New**.
4. Either use the **Search** or **Filter options** to locate a Theme you would like to use.
5. Click on the **Preview** link to preview the Theme or the **Install** link to upload the Theme to your site. Note that
6. Or use the **Upload Theme** button at the top of page to upload a zipped copy of a Theme that you have previously downloaded to your machine.

When the Theme is already downloaded but not activated **Live Preview** option will give you a preview of your site with your own, existing content.

### Adding New Themes by using cPanel

If your host offers the [cPanel](/support/article/glossary/#cpanel) control panel, you can use its **Upload** option to upload the Theme files to your site. For this you will need Theme files in an compressed archive (**.zip** or **.gz**).

1. Download the Theme **.zip** file to your machine.
2. In **cPanel File Manager**, navigate to your **Themes folder**. Depending on your hosting, path to Themes folder can differ a bit but essentially you are looking for **public\_html** inside which you’ll find **/wp-content/themes/**.
3. Once you’re inside the **Themes folder** in cPanel File Manager, click on **Upload** and upload that **.zip** file you saved in Step 1.
4. Once the **.zip** file is uploaded, **right click** on the name of that file in cPanel and select **Extract** from the context menu.
5. When Theme files are successfully extracted, follow the [instructions below](#activating-the-theme) for activating the new Theme.

 [![](https://wordpress.org/documentation/files/2018/10/cpanel-file-manager-300x61.jpg)](https://wordpress.org/documentation/cpanel-file-manager/) 

  cPanel – File Manager  [![](https://wordpress.org/documentation/files/2018/10/cpanel-wpcontent-themes-300x103.jpg)](https://wordpress.org/documentation/cpanel-wpcontent-themes/) 

  cPanel – Themes Directory  

![](https://wordpress.org/documentation/files/2018/10/cpanel-file-manager-300x61.jpg)cPanel – File Manager![](https://wordpress.org/documentation/files/2018/10/cpanel-wpcontent-themes-300x103.jpg)cPanel – Themes DirectoryTo add a new Theme to your WordPress installation via FTP protocol, you’ll need [FTP client](/support/article/ftp-clients/) and extracted Theme files.

![](https://wordpress.org/documentation/files/2018/10/cpanel-file-manager-300x61.jpg)cPanel – File Manager![](https://wordpress.org/documentation/files/2018/10/cpanel-wpcontent-themes-300x103.jpg)cPanel – Themes DirectoryNow that new Theme is in **/wp-content/themes/** directory (whether you used [Administration Screens](#adding-new-themes-using-the-administration-screens), [cPanel](#adding-new-themes-by-using-cpanel) or [FTP](#adding-new-themes-manually-ftp) method), this new Theme is ready to be activated. All themes in **/wp-content/themes/** directory are available for **Activation** and **Update** (when update is provided by theme author), but only one theme from this directory can be **Active**.

### Adding New Themes Manually (FTP)

When theme is **Activated** it means that this theme’s style and functionality (look and behavior) will be applied on your site. You will be informed by Administration notification about successful activation of the Theme.

1. Download the Theme archive (**.zip**) and extract the files it contains. You should have a folder named as theme itself, containing theme files.
2. Using an [FTP cli](/getting-started/ftp-clients/)[e](/support/article/ftp-clients/)[nt](/getting-started/ftp-clients/) to access your host web server and navigate to **/wp-content/themes/** directory.
3. Upload the Theme folder to this directory on your host server.
4. Follow the [instructions below](#activating-the-theme) for activating the new Theme.

## Activating the Theme

To activate a Theme for your site:

Your selection will immediately become active.

![](https://wordpress.org/documentation/files/2018/10/theme-activated-notice.jpg)Activated Theme Notice**Note:** If the Theme preview is blank, do **NOT** activate the new Theme without investigating further. Your site may not be displayed correctly, otherwise. If you do not see Theme’s thumbnail at all, your new Theme might be corrupted or broken. Take a look below installed theme’s thumbnails if there is any info about broken themes. In this case **contact the Theme author for help**.

1. Log in to the WordPress [Administration Screens](/support/article/administration-screens/).
2. Select the [Appearance](/support/article/administration-screens/#appearance-change-the-look-of-your-blog) screen, then [Themes](/support/article/administration-screens/#themes).
3. You should see here all themes from your **/wp-content/themes/** directory and from here you can see details for each of them by clicking on **Theme Details** (rollover the Theme thumbnail).
4. **Live Preview** option will give you preview of your site with your site’s content.
5. To activate the Theme click the **Activate** button.

If you are interested in creating your own Theme for distribution, or learning more about the architecture of Themes, please review the documentation regarding [Theme Development](https://developer.wordpress.org/themes/).

If you simply want to customize your current Theme for your own use, consider creating a [Child Theme](https://developer.wordpress.org/themes/advanced-topics/child-themes/).

[![](https://wordpress.org/documentation/files/2018/10/broken-theme.jpg)](https://wordpress.org/documentation/article/using-themes/broken-theme-50/)Broken Theme## Creating Themes

Whichever the case, you are welcome to join the [Themes Team](https://make.wordpress.org/themes/) and their dedicated [\#themereview](https://wordpress.slack.com/messages/themereview) Slack channel. In that channel, you can ask for help on developing themes for [WordPress Theme Directory](https://wordpress.org/themes/) or even [start reviewing themes](https://make.wordpress.org/themes/handbook/get-involved/become-a-reviewer/) yourself.
