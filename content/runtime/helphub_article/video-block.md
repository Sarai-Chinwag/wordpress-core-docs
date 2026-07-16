---
type: document
title: Video block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/video-block/"
tags:
timestamp: "2026-06-16T19:28:56+00:00"
wordpress:
  id: 2326
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:56"
  date_gmt: "2026-06-16 19:28:56"
  modified: "2026-06-16 19:28:56"
  modified_gmt: "2026-06-16 19:28:56"
  slug: video-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/video-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - media-blocks
---

[Go to the list of Blocks](https://wordpress.org/documentation/article/blocks/)

Use the Video block to upload and embed video into your post or page.

## Add a Video block

To add the Video block to a page, click the (+) icon to open the block inserter pop-up window and choose the Video block.

You can also use the keyboard shortcut `/video` to quickly insert a Video block.

[Detailed instructions on adding blocks can be found here.](https://wordpress.org/documentation/article/adding-a-new-block/)

When you add a Video block, you will be prompted with three options to add your content, Upload, Media Library, and Insert from URL.

The Upload will allow you to upload a new video file from your computer. Media Library lets you select a file that’s already uploaded to your site’s media library.

If you insert a URL from a supported block type, such as YouTube, the Video block will automatically transform into a YouTube embed block.

![add video and upload video](https://wordpress.org/documentation/files/2019/03/video-block-1024x330.png)## Block toolbar

To view the block toolbar, click on the block, and the toolbar will be displayed.

Every block comes with unique toolbar icons and blocks specific user controls that allow you to manipulate the block right in the editor. The Video block contains the following specific tools within the block toolbar:

- Add/Remove caption
- Text tracks
- Replace

### Add/Remove caption

Use Add/Remove caption option to toggle the caption of the video.
You can apply bold or italic formatting to captions, or create a link.

![Caption enabled Video block](https://wordpress.org/documentation/files/2019/03/video-remove-caption-6.8-1-1024x710.jpg)### Text tracks

The Text tracks option will allow you to display timed text tracks (such as subtitles or captions) when the media is playing.

The tracks are formatted in WebVTT format (.vtt files or Web Video Text Tracks).

This is the example of .vtt file

```
WEBVTT

NOTE State of the Word is the annual keynote
address celebrating the progress of the open
source WordPress project and offering a glimpse
into its future.

0:02:14.000 --> 0:02:15.000
Konbanwa

0:02:16.000 --> 0:02:17.000
And howdy.

0:02:18.000 --> 0:02:20.000
And thanks for being here, everyone.
```

Once you upload the track, you will find the edit track option.

![Text tracks option in the Video block toolbar](https://wordpress.org/documentation/files/2019/03/video-texttracks-6.8-1024x674.jpg)**Label.** A user-readable title of the text track which is used by the browser when listing available text tracks.

**Source language.** Language of the track text data. It must be a valid BCP 47 language tag. If the Kind attribute is set to Subtitles, then the Source language must be defined.

**Kind.** How the text track is meant to be used. If omitted, the default kind is Subtitles. If the attribute contains an invalid value, it will use Metadata.

- **Subtitles**: Translations of the dialogue in the video for when audio is available but not understood. Subtitles are shown over the video.
- **Captions:** Transcription of the dialogue, sound effects, musical cues, and other audio information for when the viewer is deaf/hard of hearing or the video is muted. Captions are also shown in the video.
- **Descriptions:** Text descriptions of what’s happening in the video for when the video portion isn’t available because the viewer is using assistive technology. Descriptions are read by a screen reader or turned into a separate audio track.
- **Chapters**: Chapter titles that are used to create navigation within the video. Typically they’re in the form of a list of chapters that the viewer can click on to go to a specific chapter.
- **Metadata**: Tracks with data meant for javascript to parse and do something with. These aren’t shown to the user.

![Video with English subtitle](https://wordpress.org/documentation/files/2019/03/video-subtitles-6.8-1024x592.jpg)### Replace

![Replace option in the Video block toolbar](https://wordpress.org/documentation/files/2019/03/video-replace-6.8.jpg)The Replace option will allow you to select a new video file for your block. Use this if you need to replace the video file in your Video block. You’ll have the option to select Open Media Library, Upload, or Current media URL.

### More options

The Options menu represented by three vertical dots on the far right of the toolbar gives you more features such as the ability to duplicate or remove the block.

[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block settings

The block settings panel contains customization options specific to the block. To open it, select the block and click the Settings icon next to the Publish button.

![Block settings sidepanel](https://wordpress.org/documentation/files/2019/03/video-block-settings-6.8.jpg)### Settings

- **Autoplay, Loop, Muted**. These options let you set your video file to autoplay when someone visits the page or post. Looping lets you choose if the video file repeats after it is finished. You can also choose to mute the video if your circumstance requires it.
- **Play inline**. This option lets you set your video to be played *inline*, that is within the element’s playback area. Keep in mind that turning this option off does not imply that the video will always be played in fullscreen.

#### Playback controls

Toggle this option to show or hide the playback control overlay on the video.

![playback control option](https://wordpress.org/documentation/files/2019/03/playback-controls-1024x570.png)A video with playback controls:![no play back for video option](https://wordpress.org/documentation/files/2019/03/no-playback-1024x571.png)A video without playback controls:### Preload

![preload option](https://wordpress.org/documentation/files/2019/03/preload.png)This option allows you to select how much of the video file is downloaded when the page or post is loaded. While it may be tempting to go ahead and have the whole file download automatically, keep in mind that this can slow your page’s load speed down.

There are three settings:

- **Auto** – The entire video file is downloaded, regardless of whether the visitor clicks the Play button or not. This makes the biggest impact on your page or post’s load speed, especially with larger video files.
- **Metadata** – Only basic info about the file will be downloaded automatically. Like the None option, the download of the video file only begins when someone clicks Play. This setting is also very fast, as the only thing downloaded is text. On a fundamental level, there’s not a big difference between None and Metadata.
- **None** – Nothing about the video file is downloaded automatically. The download of the video file only begins when your visitor clicks the Play button. This is the fastest setting.

### Poster image

![Set poster image button from the Video block settings sidebar](https://wordpress.org/documentation/files/2019/03/Screenshot-2026-03-02-at-7.19.51-PM-1.png)You can choose a poster image that will be displayed before a video is set to play. This can be useful if the first frame of the video isn’t necessarily appealing or indicative of the video content. An eye-catching poster image can really draw attention to your video.

#### Advanced

The Video block provides the following Advanced settings options: HTML Anchor, Additional CSS Class(es), and Styles.

[Learn more about advanced settings](https://wordpress.org/documentation/article/advanced-settings-overview/)

### Styles

### Dimensions

The Video block provides dimension settings options to change padding and margin size.

For details, refer to this support article: [Dimensions Settings Overview](https://wordpress.org/documentation/article/dimension-controls-overview/)

## Changelog

- Updated 2026-05-25 (props to @kjoyner @awetz583)
    - Updated “Advanced” section to refer to new overview page
- Updated 2026-03-02 (props to @awetz583)
    - Updated formatting and headings
    - Added Advanced and More options sections
- Updated 2025-10-18
    - Added Add/Remove caption
    - Updated screenshots for 6.8
- Updated 2023-02-17
    - Revised formatting for the whole article
    - Updated all the screenshots for 6.1
- Updated 2022-11-25
    - Change screenshot alignment for mobile view
    - Remove redundant text
    - Added caption to images
- Updated 2022-02-04
    - Changed screenshots
- Updated 2020-12-07
    - Added Text tracks in Block Toolbar
    - Changed screenshots in Block Toolbar
- Updated 2020-08-25
    - Screenshots as per WordPress 5.5
    - Added feature changes in Block Toolbar
    - Added feature changes in Block Settings
- Updated 2020-06-18
    - Added “Go back to the list of Blocks” to the top of the page
    - Added the Changelog
- Created 2019-03-07
