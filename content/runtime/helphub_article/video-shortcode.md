---
type: document
title: Video shortcode
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/video-shortcode/"
tags:
timestamp: "2026-06-16T19:29:10+00:00"
wordpress:
  id: 2402
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:10"
  date_gmt: "2026-06-16 19:29:10"
  modified: "2026-06-16 19:29:10"
  modified_gmt: "2026-06-16 19:29:10"
  slug: video-shortcode
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/video-shortcode/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

The **Video** feature allows you to embed video files and play them back using a simple shortcode. This was added as of WordPress [Version 3.6](https://wordpress.org/documentation/wordpress-version/version-3-6/) and is used like this:

```
[video]
```

You can also use built in embeds and simply put the media file on its own line:

```
My cool contenthttp://my.movies.com/cool/movie/coolest.mp4More cool content
```

## Usage

I have an old post that has an audio file in the Media Library attached to it, and I want to use the new shortcode:

```
[video]
```

Note: Do Not put Space between “\[” and “video”.

I have the URL for an MP3, from the Media Library or external, that I want to play:

```
[video src="video-source.mp4"]
```

I have a source URL and fallbacks for other HTML5-supported filetypes:

```
[video mp4="source.mp4" ogv="source.ogv" webm="source.webm"]
```

## Options

The following basic options are supported:

`src`
(string) (optional) The source of your video file. If not included it will auto-populate with the first video file attached to the post. You can use the following options to define specific filetypes, allowing for graceful fallbacks:

- mp4, m4v, webm, ogv, wmv, flv

Default: First video file attached to the post

`poster`
Defines image to show as placeholder before the media plays.
Default: none

`loop`
(string) Allows for the looping of media. Defaults to “off.”

- “off” – (“default”) does not loop the media
- “on” – media will loop to beginning when finished and automatically continue playing

Default: “off”

`autoplay`
(string) Causes the media to automatically play as soon as the media file is ready. Defaults to “off.”

- “off” – (“default”) does not automatically play the media
- “on” – Media will play as soon as the media is ready

Default: “off”

`preload`
(string) (optional) Specifies if and how the video should be loaded when the page loads. Defaults to “metadata.”

- “metadata” – (“default”) only metadata should be loaded when the page loads
- “none” – the video should not be loaded when the page loads
- “auto” – the video should be loaded entirely when the page loads

Default: “metadata”

`height`
(integer) (required) Defines height of the media. Value is automatically detected on file upload.
Default: \[Media file height\]

`width`
(integer) (required) Defines width of the media. Value is automatically detected on file upload.
Default: \[Media file width\]

## Related

WordPress Shortcodes: [audio](https://wordpress.org/documentation/article/audio-shortcode/), [caption](https://codex.wordpress.org/Caption_Shortcode), [embed](https://codex.wordpress.org/Embed_Shortcode), [gallery](https://codex.wordpress.org/Gallery_Shortcode), [playlist](https://codex.wordpress.org/Playlist_Shortcode)

#### **Changelog** 

- Updated 2021-10-18
    - Added changelog
    - Corrected the links to the codex pages for the caption, embed, gallery and playlist shortcodes
