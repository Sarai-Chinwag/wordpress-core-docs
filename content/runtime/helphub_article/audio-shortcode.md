---
type: document
title: Audio Shortcode
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/audio-shortcode/"
tags:
timestamp: "2026-06-16T19:29:10+00:00"
wordpress:
  id: 2403
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:10"
  date_gmt: "2026-06-16 19:29:10"
  modified: "2026-06-16 19:29:10"
  modified_gmt: "2026-06-16 19:29:10"
  slug: audio-shortcode
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/audio-shortcode/"
  comment_count: 0
  terms:
    category:
      - media
      - support-guides
---

The Audio feature allows you to embed audio files and play them back using a simple Shortcode. This was added as of WordPress 3.6 and is used like this:

```
[ audio]
```

Note: Do not put space between “\[” and “audio”.

You can also use build-in embeds and simply put the media file on its own line:

```
My cool contenthttp://my.mp3s.com/cool/songs/coolest.mp3More cool content
```

## Usage

I have an old post that has an audio file in the Media Library attached to it, and I want to use the new shortcode:

```
[ audio]
```

Note: Do Not put Space between “\[” and “audio”.

I have the URL for an MP3, from the Media Library or external, that I want to play:

\[audio src="audio-source.mp3"\]

I have a source URL and fallbacks for other HTML5-supported filetypes:

\[audio mp3="source.mp3" ogg="source.ogg" wav="source.wav"\]

## Options

The following basic options are supported:

`src`
([string](https://wordpress.org/documentation/article/glossary/#string)) (optional) The source of your audio file. If not included it will auto-populate with the first audio file attached to the post. You can use the following options to define specific filetypes, allowing for graceful fallbacks:

- ‘mp3’, ‘m4a’, ‘ogg’, ‘wav’, ‘wma’

Default: First audio file attached to the post

`loop`
([string](https://wordpress.org/documentation/article/glossary/#string)) (optional) Allows for the looping of media.

- “off” – Do not loop the media.
- “on” – Media will loop to the beginning when finished and automatically continue playing.

Default: “off”

`autoplay`
([string](https://wordpress.org/documentation/article/glossary/#string)) (optional) Causes the media to automatically play as soon as the media file is ready.

- “off” – Do not automatically play the media.
- “on” – Media will play as soon as it is ready.

Default: “off”

`preload`
([string](https://wordpress.org/documentation/article/glossary/#string)) (optional) Specifies if and how the audio should be loaded when the page loads. Defaults to “none”

- “none” – The audio should not be loaded when the page loads.
- “auto” – The audio should be loaded entirely when the page loads.
- “metadata” – Only metadata should be loaded when the page loads.

Default: “none”

## Related

WordPress Shortcodes: [video](https://wordpress.org/documentation/article/video-shortcode/), [caption](https://codex.wordpress.org/Caption_Shortcode), [embed](https://codex.wordpress.org/Embed_Shortcode), [gallery](https://codex.wordpress.org/Gallery_Shortcode), [playlist](https://codex.wordpress.org/Playlist_Shortcode)

#### **Changelog** 

- Updated 2021-10-18
    - Added changelog
    - Corrected the links to the codex pages for the caption, embed, gallery and playlist shortcodes
