---
type: document
title: "What are smilies?"
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/what-are-smilies/"
tags:
timestamp: "2026-06-16T19:29:10+00:00"
wordpress:
  id: 2406
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:10"
  date_gmt: "2026-06-16 19:29:10"
  modified: "2026-06-16 19:29:10"
  modified_gmt: "2026-06-16 19:29:10"
  slug: what-are-smilies
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/what-are-smilies/"
  comment_count: 0
  terms:
    category:
      - publishing
      - support-guides
---

## What Are Smileys?

Smileys, also known as “emoticons”, are *glyphs* used to convey emotions in your writing. They are a great way to brighten up posts. 🙂

Text smileys are created by typing two or more punctuation marks. Some examples are:

`;-)` is equivalent to 😉

`:-)` is equivalent to 🙂

`:-(` is equivalent to 🙁

`:-?` is equivalent to 😕

To learn more about emoticons and their history, see the [Wikipedia entry on Emoticons](http://en.wikipedia.org/wiki/Emoticons).

### Smileys are not Emoji

Although smileys and emoji can both display smiley faces and such, emoji are a newer development and have a much wider range of images that can be displayed. (They are also created differently.) For more information on emoji and how to use them, see the [Emoji](https://codex.wordpress.org/Emoji) page.

## How Does WordPress Handle Smileys?

By default, WordPress automatically converts text smileys to graphic images. When you type `;-)` in your post you see 😉 when you preview or publish your post.

## To Turn off Graphic Smileys

As of WordPress 4.3, the option to disable graphic smileys was removed from new installs. There is [a plugin](https://wordpress.org/plugins/keep-emoticons-as-text/) if you want to retain the option.

## What Text Do I Type to Make Smileys?

Smiley images and the text used to produce them\*:

![:mrgreen:](https://wordpress.org/documentation/wp-includes/images/smilies/mrgreen.png)*\* In some instances, multiple text options are available to display the same smiley.*

Category:Getting Started

## Troubleshooting Smileys

### Why Doesn’t it Work?

Smileys may have been disabled by your WordPress admin. Another possibility is the smiley image files have been deleted from `/wp-includes/images/smilies`.

### Why Doesn’t it Work for Me?

*If smileys work for others at your site but not for you:*

Type a space before and after your smiley text. That prevents the smiley being accidentally included in the text around it. 😳

Make sure not to use quotes or other punctuation marks before and after the smiley text. 🙄

### Where Are My Smiley Images Kept?

The smiley or emoticon image graphics are found in the `/wp-includes/images/smilies` directory.

Note that smileys is spelled ‘eys’ in this documentation and the directory name for the smiley images is *‘smilies*, spelled ‘ies’. 😯

### How Can I Have Different Smiley Images Appear?

The easiest way is to filter the smilies.

Upload the images you want with the same name to your server (say in wp-content/images/smilies) and put this in your theme’s function.php:

```
add_filter( 'smilies_src', 'my_custom_smilies_src', 10, 3 );
function my_custom_smilies_src( $img_src, $img, $siteurl )
{
        return $siteurl.'/wp-content/images/smilies/'.$img;
}
```

That will replace http://example.com/wp-includes/images/smilies/icon\_question.gif with http://example.com/wp-content/images/smilies/icon\_question.gif

### Why are my Smiley Images Blank?

If you recently uploaded the images, it could be that the images have been uploaded in ***ASCII*** format by your FTP program. Re-upload the smileys ensuring that they are transferred in ***BINARY*** format.

Some FTP programs have an **auto-detect** setting which will upload files in the correct format without user intervention. If you have such a setting, turn it on.

## Smiley CSS

The smiley images in WordPress are automatically given a [CSS](https://codex.wordpress.org/Glossary#CSS) class of **wp-smiley** when they are displayed in a post. You can use this class to style your smileys differently from other post images.

For example, it’s not uncommon to set up images in a post to appear on the left-hand side of the content with text flowing around the image. The CSS for that might look like this:

```
.post img {
        float: left;
}
```

This would typically affect all images in a post, **including** your smiley images. To *override* this so that smileys stay inline, you could add this to your CSS:

```
img.wp-smiley {
        float: none;
}
```

For more on CSS in WordPress, you might want to [start here](https://codex.wordpress.org/CSS).

## More Information on Smileys

- [Wikipedia – Emoticon](http://en.wikipedia.org/wiki/Emoticon)
