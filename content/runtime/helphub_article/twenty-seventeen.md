---
type: document
title: Twenty Seventeen
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-seventeen/"
tags:
timestamp: "2026-06-16T19:29:14+00:00"
wordpress:
  id: 2425
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:14"
  date_gmt: "2026-06-16 19:29:14"
  modified: "2026-06-16 19:29:14"
  modified_gmt: "2026-06-16 19:29:14"
  slug: twenty-seventeen
  parent: 0
  menu_order: 17
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twenty-seventeen/"
  comment_count: 0
  terms:
    category:
      - customization
      - default-themes
---

[Twenty Seventeen](https://wordpress.org/themes/twentyseventeen/) is the new default theme for WordPress in 2017. Its business-oriented design highlights new video headers, and it has a front-page layout that can be created by combining page sections. The theme can be customized further using custom color options and by adding a site logo, social menu, and widgets.

![Two screenshots of Twenty Seventeen, one for desktop and one for mobile.](https://wordpress.org/documentation/files/2018/10/twenty-seventeen-1058.jpg)## Quick Specs

- The main column width is up to 525px for the two-column layout and 740px for the one-column layout.
- The sidebar column width is up to 326px.
- The recommended size for featured images is 2000px wide by 1200px high.
- The recommended size for header videos and header images is 2000px wide by 1200px high.

## Header Media

Twenty Seventeen supports both header images and header videos. To modify either type on your site, navigate to Customizer &gt; Header Media.

![The Customizer is opened and shows the preview of the site. The settings panel shows the options for the Header Media, including an option for selecting a header video.](https://wordpress.org/documentation/files/2018/10/video-headers.png)For header videos, you can upload your own `mp4` video or link to a video hosted on YouTube. Smaller file sizes will help make sure your site is loaded quickly.

A header image can be used on its own to display a large photograph at the top of your site. It can also be used as a video fallback: If both a video and image are added, the image will be used as a placeholder while the video loads, and it also acts as a fallback on smaller screens where videos may be harder to serve over mobile networks.

## Front Page

Twenty Seventeen allows you to build a striking front page composed of content from different pages on your site. Each page’s featured image is highlighted, displayed at full-screen size with a fixed position. Twenty Seventeen has four different sections you can assign pages to.

To set this up, first navigate to Customizer &gt; Static Front Page, and set your site to use a static front page if you haven’t already.

![The Customizer is open and shows a preview of the site, as well as the Static Front Page settings.](https://wordpress.org/documentation/files/2018/10/front-page.jpg)Navigate to Customizer &gt; Theme Options. Under each `Front Page Section # Content` header, select a page you’d like to display for that section.

![The Customizer is open and shows a preview of the site. The settings panel shows the Page Layout options which are custom options for Twenty Seventeen.](https://wordpress.org/documentation/files/2018/10/theme-options.jpg)If you haven’t created any pages yet, you can do that from the Customizer by clicking `+ Add New Page` beneath any of the sections. This will allow you to create a new page from the Customizer that you can later add content to.

For the best appearance, make sure each page includes a featured image and some content.

You can also select your Blog Posts page, and the panel will display your three latest blog posts.

![An example of the Page Layout options for the front page, with the page section in view.](https://wordpress.org/documentation/files/2018/10/blog.jpg)Once you’ve finished adding pages to the sections, click `Save & Publish`.

If you’d like to change the number of sections you can add pages to, add this snippet to your theme’s `functions.php`:

```php
add_filter( 'twentyseventeen_front_page_sections', 'prefix_custom_front_page_sections' );function prefix_custom_front_page_sections( $num_sections ) {    return 6;}
```

This snippet changes the default four sections to six.

## Custom Colors

Twenty Seventeen includes three color options: the default light color scheme, a dark color scheme, and a Custom Colors scheme that can be adjusted to various hues using a slider.

![Six screenshots that show the color schemes in the Customizer: Light, dark and custom color hues.](https://wordpress.org/documentation/files/2018/10/colours-screenshot.png)To explore all the color options available, navigate to Customizer &gt; Colors.

## Language Support

Twenty Seventeen includes optimal font styles for many languages, thanks to feedback from the WordPress community. The theme uses [Libre Franklin](https://fonts.google.com/specimen/Libre+Franklin) by default and makes adjustments to the typography for the following alphabets:

- Arabic
- Chinese
- Cyrillic
- Devanagari
- Greek
- Gujarati
- Hebrew
- Japanese
- Korean
- Thai

To improve legibility, Twenty Seventeen also removes its letter-spacing styles for all non-Latin alphabets.

## One- and Two-Column Layouts

For [pages](/support/article/pages/), Twenty Seventeen allows you to choose between a one- and two-column layout. This can be changed via Customizer &gt; Theme Options. The theme defaults to the two-column layout, which displays the page title in one column and the page content in the other.

Note: This feature only becomes available after setting a static front page.

![The Customizer Theme Options panel for single pages.](https://wordpress.org/documentation/files/2018/10/two-column-option.jpg)When the one-column layout is selected, both the page title and content display in a wider single column, centered on the page.

![The theme's two column layout, with the post title on the left and the content on the right.](https://wordpress.org/documentation/files/2018/10/two-column.jpg)![The theme's one column layout, with the post title above the content.](https://wordpress.org/documentation/files/2018/10/one-column.jpg)## Widgets

Twenty Seventeen includes a footer [widget](/support/article/wordpress-widgets/) [](https://codex.wordpress.org/WordPress_Widgets)area allowing widgets to be added below the site’s content.

The blog index, archive, and search pages and single blog posts also include a sidebar widget area. For each of these pages, the content is displayed in one center column if there is no sidebar. With the sidebar, the content is displayed in one column and the widgets are displayed in the other.

## Pullquotes

Pullquotes can be used to direct your readers’ attention to a particular passage or add visual interest to your posts and pages. In Twenty Seventeen, you can pair a pullquote with an `alignleft` or `alignright` class on the `blockquote` element to further highlight it. Instructions on how to do this can be found in [the support article for the Classic Editor](https://wordpress.org/documentation/article/write-posts-classic-editor/#visual-versus-text-editor). See the following example:

```
<blockquote class="alignleft">This is my fabulous left-aligned pullquote.</blockquote>
```

When a two-column layout is used (whether via the Customizer for pages, or by adding a sidebar widget for posts), the pullquote aligned to the same side will display fully outside of the content area and below the second column. Note: This will only work when the pullquote appears in the content below where the second column ends.

![A pullquote that is positioned to the left of the main content.](https://wordpress.org/documentation/files/2018/10/pullquotes.jpg)## Post Formats

Twenty Seventeen supports the following post formats:

- Aside
- Audio
- Gallery
- Image
- Link
- Quote
- Video

## Social Icons

Twenty Seventeen includes a Social Icons Menu, allowing you to add links to your social media profiles that will be displayed as logos in the footer. If you’re not familiar with this functionality, please refer to the [documentation from Twenty Fifteen](/support/article/twenty-fifteen/#add-social-icons).

The following services are supported by Twenty Seventeen’s Social Icons Menu:

- Behance
- Codepen
- DeviantArt
- Digg
- Dribbble
- Dropbox
- Facebook
- Flickr
- Foursquare
- GitHub
- Google+
- Instagram
- LinkedIn
- Meanpath
- Medium
- Pinterest
- Pocket
- Reddit
- Skype
- SlideShare
- Snapchat
- SoundCloud
- Spotify
- StumbleUpon
- Tumblr
- Twitch
- Twitter
- Vimeo
- Vine
- VK
- WordPress
- Yelp
- YouTube

## Support and Resources

Get community help with Twenty Seventeen on its [forum](https://wordpress.org/support/theme/twentyseventeen).

Get tips for theming with Twenty Seventeen from [this post on make.wordpress.org](https://make.wordpress.org/core/2016/11/29/theming-with-twenty-seventeen/) by one of Twenty Seventeen’s developers. You can also read [the theme’s changelog](https://wordpress.org/documentation/article/twenty-seventeen-changelog/).
