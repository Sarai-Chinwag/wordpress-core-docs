---
type: document
title: Settings General screen
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/settings-general-screen/"
tags:
timestamp: "2026-06-16T19:29:08+00:00"
wordpress:
  id: 2390
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:08"
  date_gmt: "2026-06-16 19:29:08"
  modified: "2026-06-16 19:29:08"
  modified_gmt: "2026-06-16 19:29:08"
  slug: settings-general-screen
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/settings-general-screen/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

This Settings General Screen is the default Screen in the [Settings Administration Screen](/support/article/administration-screens/#settings-configuration-settings) and controls some of the most basic configuration settings for your site: your site’s title and location, who may register an account at your site, and how dates and times are calculated and displayed.

[![](https://wordpress.org/documentation/files/2018/11/760px-options-general.png)](https://wordpress.org/documentation/files/2018/11/760px-options-general.png)## General Settings

### Site title

Enter the name of your site (or blog) here. Most themes will display this title, at the top of every page, and in the reader’s browser titlebar. WordPress also uses this title as the identifying name for your [Syndication](/support/article/introduction-to-blogging/#syndication) feeds.

### Tagline

In a few words, explain what your site is about. Your sites’ slogan, or tagline, might be entered here. A tagline is short phrase, or sentence, used to convey the essence of the site and is often funny or eye-catching. The default tagline is an empty string.

### WordPress Address (URL)

Enter the full URL of the directory containing your WordPress core application files (e.g., wp-config.php, wp-admin, wp-content, and wp-includes). For example, if you installed WordPress into a directory called “blog”, then the WordPress address would be `http://example.net/blog` (where example.net is your domain). If you installed WordPress into your web root, this address will be the root URL `http://example.net`. WordPress will trim a slash (`/`) from the end. If you defined the **WP\_SITEURL** constant in your [`wp-config.php`](https://codex.wordpress.org/Editing_wp-config.php#WordPress_address_.28URL.29) file, that value will appear in this field and you will not be able to make changes to it from the WordPress administration screen.

### Site Address (URL)

Enter the address you want people to type in their browser to reach your WordPress site. This is the directory where WordPress’s main `index.php` file is installed. The *Site address (URL)* is identical to the *WordPress address (URL)* (above) unless you are [giving WordPress its own directory](/support/article/giving-wordpress-its-own-directory/). WordPress will trim a slash (`/`) from the end. If you defined the **WP\_HOME** constant in your [`wp-config.php`](https://codex.wordpress.org/Editing_wp-config.php#Blog_address_.28URL.29) file, that value will appear in this field and you will not be able to make changes to it from the WordPress administration screen.

### E-mail Address

Enter the e-mail address to which you want WordPress to send messages regarding the administration and maintenance of your WordPress site. For example, if you allow new users to register as a member of your site (see Membership below), then a notification will be sent through e-mail to this address. In addition, if the option, **An administrator must always approve the comment**, is set in [Administration](/support/article/administration-screens/) &gt; [Settings](/support/article/administration-screens/#discussion) &gt; [Discussion](/support/article/settings-discussion-screen/), this e-mail address will receive notification that the comment is being held for moderation. Please note this is different than the address you supplied for the **admin** user account; the **admin** account e-mail address is sent an e-mail only when someone submits a comment to a post by **admin**. The address you enter here will never be displayed on the site. You can send messages to multiple admins by using an email address which forwards email to multiple recipients.

### Membership

**Anyone can register** – Check this checkbox if you want anyone to be able to register an account on your site.

### New User Default Role

This drop-down box allows you to select the default [Role](/support/article/roles-and-capabilities/) that is assigned to new users. This Default [Role](/support/article/roles-and-capabilities/) will be assigned to newly registered members or users added via the [Administration](/support/article/administration-screens/) &gt; [Users ](/support/article/administration-screens/#users-your-blogging-family) &gt; [Users Screen](https://codex.wordpress.org/Users_Screen). Valid choices are [Administrator](/support/article/roles-and-capabilities/#administrator), [Editor](/support/article/roles-and-capabilities/#editor), [Author](/support/article/roles-and-capabilities/#author), [Contributor](/support/article/roles-and-capabilities/#contributor), or [Subscriber](/support/article/roles-and-capabilities/#subscriber).

### Site Language

The WordPress dashboard language.

### Timezone

From the drop-down box, choose a city in the same timezone as you. For example, under America, select New York if you reside in the Eastern Timezone of the United States that honors daylight savings times. If you can’t identify a city in your timezone, select one of the **Etc GMT** settings that represents the number of hours by which your time differs from [Greenwich Mean Time](https://en.wikipedia.org/wiki/Greenwich_Mean_Time). Click the **Save Changes** button and the [UTC time](https://en.wikipedia.org/wiki/Coordinated_Universal_Time) and “Local time” will display to confirm the correct Timezone was selected.

### Date Format

The format in which to display dates on your site. The Date Format setting is intended to be used by theme designers in displaying dates on your site, but does not control how the date is displayed in the Administrative Screens (e.g. Manage Posts). Click the **Save Changes** button and the “Output” example below will show the current date in the format entered. See [Formatting Date and Time](/support/article/formatting-date-and-time/) for some of the formats available.

### Time Format

The format in which to display times on your site. The Time Format setting is intended to be used by theme designers in displaying time on your site, but does not control how the time is displayed in the Administrative Screens (e.g. Write Post edit of timestamp). Click the **Save Changes** button and the “Output” example below will show the current time in the format entered. See [Formatting Date and Time](/support/article/formatting-date-and-time/) for some of the formats available.

### Week Starts On

Select your preferred start date for WordPress calendars from the drop-down box. Monday is the default setting for this drop-down, meaning a monthly calendar will show Monday in the first column. If you want your calendar to show Sunday as the first column, then select Sunday from the drop-down.

### Save Changes

Click the **Save Changes** button to ensure any changes you have made to your Settings are saved to your database. Once you click the button, a confirmation text box will appear at the top of the page telling you your settings have been saved.

## Changelog

- Updated 2024-08-24
    - Spacing/typos
    - Tagline default of empty string added
