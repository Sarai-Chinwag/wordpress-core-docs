---
type: document
title: Twitter embed
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twitter-embed/"
tags:
timestamp: "2026-06-16T19:28:47+00:00"
wordpress:
  id: 2287
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:47"
  date_gmt: "2026-06-16 19:28:47"
  modified: "2026-06-16 19:28:47"
  modified_gmt: "2026-06-16 19:28:47"
  slug: twitter-embed
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/twitter-embed/"
  comment_count: 0
  terms:
    category:
      - customization
      - embed-blocks
---

[Go back to the list of **Blocks**](https://wordpress.org/documentation/article/blocks/)

With the Twitter Embed block, you can embed Tweets (posts on Twitter) into your posts and pages. You don’t need a Twitter account to be able to use it. You can only embed public tweets, though.

**An example:**

> In the April edition of our "People of WordPress" series, you'll find out how Mario Peshev went from self-taught developer to teaching basic digital literacy. <https://t.co/OFO82H7zHS> [pic.twitter.com/rzqC9F7LEW](https://t.co/rzqC9F7LEW)
> 
> — WordPress (@WordPress) [April 8, 2020](https://twitter.com/WordPress/status/1247690005516034048?ref_src=twsrc%5Etfw)

Apart from a single tweet you can also use the block to add:

- Profile links – shows the latest tweets from a user.
- Twitter List – shows the latest tweets from a Twitter List.

**Steps to embed a Tweet**

1. **You need to find the URL of the Tweet**
    Like other social networks, the post date of a single Tweet is linking to the single tweet view. To grab the URL, point your mouse to the date, using the right mouse click menu select Copy Link Address.

![Steps to get the URL for the tweet you want to embed](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-22-at-9.30.14-AM.png)Depending on the version of Twitter Interface (Mobile or Desktop) you can also use the left option ![](https://wordpress.org/documentation/files/2020/04/Twitter-CopyLInk-menu-icon.jpg)on the bottom of the tweet

![Steps to get the URL for the tweet you want to embed](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-22-at-9.34.35-AM.png)1. **Go to your post or page**
2. **Add the Twitter block**

![How to add the twitter embed block](https://wordpress.org/documentation/files/2022/02/twitter-block-insert-wp-5-9.png)Insert a Twitter block[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

1. **Paste the link into the text box and click the “Embed” button**

![Twitter block embed view](https://wordpress.org/documentation/files/2022/02/twitter-block-embed-link-1024x419.png)Twitter block embed viewIf it’s a link that can be successfully embedded you will see a preview in your editor.

![Display of the tweet embed in editor ](https://wordpress.org/documentation/files/2022/02/twitter-block-embed-success-5-9.png)If you use an URL that can’t be embedded, the block shows the message *“Sorry, this content could not be embedded.”*

You will have two choices: Try again with a different URL or convert it to a link.

![URL to embed the twitter pot ](https://wordpress.org/documentation/files/2022/02/twitter-block-embed-fail-1024x556.png)1. **Click on “Preview” to see how it will look on the front-end**

![](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-22-at-9.52.52-AM.png)## Block Toolbar

Besides the “Mover” and “Drag &amp; Drop Handle”, the Block Toolbar for the Twitter Embed block shows four buttons:

- Transform to – also the icon for the block.
- The drag handle
- The move up and down options
- Change alignment
- Edit URL, and
- More Options.

![Block toolbar for the twitter block](https://wordpress.org/documentation/files/2022/02/twitter-block-toolbar-5-9.png)**Transform to**:

![How to transform the block to a different one](https://wordpress.org/documentation/files/2022/02/twitter-block-embed-transform-to-5-9-1024x568.png)You can transform a Twitter embed to a Paragraph. This will convert the tweet embed to a link.

You can transform a Twitter embed to Columns.

You can transform a Twitter embed to a Group. This would give you the ability to change the background color around the Twitter embed.

![Editor view of an Twitter Embed as a group with Color Settings controls](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-22-at-10.13.25-AM.png)Left: Editor view of an Twitter Embed as a group with Color Settings controls
Right: Twitter embed with a blue background.![Twitter embed with a blue background.](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-22-at-10.13.40-AM.png)**Change Alignment**

![Block alignment ](https://wordpress.org/documentation/files/2022/02/twitter-block-toolbar-alignment-5-9.png)- ****None** – Default alignment option.**
- ****Wide width** – Increase the width of the post beyond the content size.**
- ****Full width** – Extend the block to cover the full width of the screen.**
- ****Align left** – Make the block left-aligned.**
- ****Align center** – Make the block alignment centered.**
- ****Align right** – Make the block right aligned.**

“Wide width” and “Full width” alignment need to be enabled by the Theme of your site.

**Edit URL**

Via the edit URL, you can change the Twitter Embed URL in the embed block. Overwrite the existing URL and click on the “Embed” Button on the right.

![How to edit the URL of the tweet ](https://wordpress.org/documentation/files/2022/02/twitter-block-embed-fail-1024x556.png)**More Options**

[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block Settings

Besides the Advanced section, the Twitter embed has only one setting in the “Block Settings” sidebar: Media Settings.

**Media Settings**

![Media settings to control the behaviour of your post embed](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-20-at-9.29.46-AM.png)![Media settings to control the behaviour of your post embed](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-20-at-9.29.55-AM.png)Via the *Media Settings* you can control the behavior of your post embed when viewed from a smaller device, like on a phone screen.

The Toggle switch turns on or off the resize functionality for smaller devices. The default setting is “on” or blue.

**“Off:”** This embed may not preserve its aspect ratio when the browser is resized. In the off position the toggle switch is gray.

**“On:”** This embed will preserve its aspect ratio when the browser is resized. The toggle switch turns blue in the “On” position.

**Advanced**

The advanced tab lets you add a CSS class to your block, allowing you to write custom CSS and style the block as you see fit.

[![The advanced section lets you add a CSS class to your block.](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-22-at-10.33.35-AM.png)](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-22-at-10.33.35-AM.png)The advanced section lets you add a CSS class to your block.## Changelog

- Updates 2022-11-27
    - Removed redundant content
    - Added alt text to images
- Updated 2022-02-04
    - Replace images with new screenshots for WordPress 5.9
    - Updated text information for more settings for capitalisation
- Updated 2020-08-18
    - Replaced “More Options” – new screenshot
    - Added “Move To” and “Copy” section under More Options
- Updated: 2020-06-20
    - Fixed typos
- Updated: 2020-06-04
    - Fixed typos
- Updated: 2020-04-24
    - Added it to the Embed Blocks category
- Created 2020-04-22
