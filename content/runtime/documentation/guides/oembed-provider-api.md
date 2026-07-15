---
type: document
title: WordPress.com oEmbed provider
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/oembed-provider-api/"
tags:
timestamp: "2026-06-16T19:29:28+00:00"
wordpress:
  id: 2507
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:28"
  date_gmt: "2026-06-16 19:29:28"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: oembed-provider-api
  parent: 2479
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/oembed-provider-api/"
  comment_count: 0
---

Every post, page, attachment, and VideoPress video hosted on [WordPress.com](https://wordpress.com/) supports the [oEmbed format](https://oembed.com/) through our public oEmbed API.

## What is the oEmbed format?

The oEmbed format allows for embedding a representation of a URL on third party sites. The WordPress.com oEmbed API allows any website to display embedded content (such as photos or videos) from WordPress.com when a user posts a link to that resource, without having to parse the resource directly.

## oEmbed Endpoint

The WordPress.com oEmbed API endpoint is available at: <https://public-api.wordpress.com/oembed/>

## Query string parameters

The WordPress.com oEmbed API supports the following query string parameters:

- **for** (required): the requesting domain or domain or company name
- **url** (required): the URL of the requested resource. Can be any any URL hosted on WordPress.com, including `wordpress.com`, `wp.me`, `videopress.com` domains and subdomains, or any top level domains hosted with WordPress.com, for example [TechCrunch](https://techcrunch.com/), [CNN Press Room](https://cnnpressroom.blogs.cnn.com/) etc.
- **format**: `json` or `xml`, defaults to `json`.
- **callback**: when used with `json`, a JavaScript callback function you want wrapped around the output.
- **maxwidth**: max width for images/thumbnails, defaults to 440px
- **maxheight**: max height for images/thumbnails, defaults to 330px.
- **img\_size**: alternative to setting **maxwidth** and/or **maxheight**, pass as *\[width\]x\[height\]*, defaults to 440x330px.
- **as\_article**: `true` or `false`, triggers the non-standard article extension for post/pages.

The *as\_article* parameter triggers a non-standard oEmbed output of `type: article`. When content is served `as_article`, the article content can be found in a *body* property, instead of the standard *html* property. Other non-standard properties, such as `related_topics`, are also available.

## Features

- in `as_article` mode, content is stripped of tags and limited to a ~256 characters excerpt .
- in standard mode (i.e. `as_article=false`), content is served as markup in full, or in excerpt if provided and as set by author.
- supports posts and pages as link/html or article/body (see as\_article argument).
- supports attachments (pictures/media/documents) as type link or type photo for images (gif, jpg, jpeg, png).
- the thumbnail for post and pages is used as the `thumbnail_url` if present, if not it will return the 1st image in the content.
- local and remote images are resized and/or re-cropped to desired dimensions, for consistency, then cached (including CDN) for speed.
- supports geolocation data, when made available by the author, through custom properties (`geo_latitude`, `geo_longitude`)
- supports `related_topics` in `as_article` mode (`as_article=true`).

## Response examples

Basic request, only required parameters passed:

```
https://public-api.wordpress.com/oembed/?for=develop.wordpress.com&url=https://wordpress.com/blog/2025/06/13/wordcamp-europe-2025-recap-connecting-and-learning-in-basel-switzerland/
```

Response:

```
{
  "version": "1.0",
  "provider_name": "WordPress.com News",
  "provider_url": "http://en.blog.wordpress.com",
  "author_name": "Nick Schäferhoff",
  "author_url": "https://en.blog.wordpress.com/author/nschaeferhoff/",
  "title": "WordCamp Europe 2025 Recap: Connecting and Learning in Basel, Switzerland",
  "html": "<blockquote class="wp-embedded-content" data-secret="g3Lu0xsMqa"><a href="https://en.blog.wordpress.com/2025/06/13/wordcamp-europe-2025-recap-connecting-and-learning-in-basel-switzerland/">WordCamp Europe 2025 Recap: Connecting and Learning in Basel, Switzerland</a></blockquote>https://en.blog.wordpress.com/2025/06/13/wordcamp-europe-2025-recap-connecting-and-learning-in-basel-switzerland/embed/#?secret=g3Lu0xsMqa<script type="text/javascript">n/* <![CDATA[ */n/*! This file is auto-generated */n!function(d,l){"use strict";l.querySelector&&d.addEventListener&&"undefined"!=typeof URL&&(d.wp=d.wp||{},d.wp.receiveEmbedMessage||(d.wp.receiveEmbedMessage=function(e){var t=e.data;if((t||t.secret||t.message||t.value)&&!/[^a-zA-Z0-9]/.test(t.secret)){for(var s,r,n,a=l.querySelectorAll('iframe[data-secret="'+t.secret+'"]'),o=l.querySelectorAll('blockquote[data-secret="'+t.secret+'"]'),c=new RegExp("^https?:$","i"),i=0;i<o.length;i++)o[i].style.display="none";for(i=0;i<a.length;i++)s=a[i],e.source===s.contentWindow&&(s.removeAttribute("style"),"height"===t.message?(1e3<(r=parseInt(t.value,10))?r=1e3:~~r<200&&(r=200),s.height=r):"link"===t.message&&(r=new URL(s.getAttribute("src")),n=new URL(t.value),c.test(n.protocol))&&n.host===r.host&&l.activeElement===s&&(d.top.location.href=t.value))}},d.addEventListener("message",d.wp.receiveEmbedMessage,!1),l.addEventListener("DOMContentLoaded",function(){for(var e,t,s=l.querySelectorAll("iframe.wp-embedded-content"),r=0;r<s.length;r++)(t=(e=s[r]).getAttribute("data-secret"))||(t=Math.random().toString(36).substring(2,12),e.src+="#?secret="+t,e.setAttribute("data-secret",t)),e.contentWindow.postMessage({message:"ready",secret:t},"*")},!1)))}(window,document);n/* ]]> */n</script>n",
  "type": "rich",
  "thumbnail_url": "https://en-blog.files.wordpress.com/2025/06/wceu-2025-recap-header.jpg?fit=440%2C330",
  "thumbnail_width": null,
  "thumbnail_height": null
}
```

{ "version": "1.0", "provider\_name": "WordPress.com News", "provider\_url": "http://en.blog.wordpress.com", "author\_name": "Nick Schäferhoff", "author\_url": "https://en.blog.wordpress.com/author/nschaeferhoff/", "title": "WordCamp Europe 2025 Recap: Connecting and Learning in Basel, Switzerland", "html": "&lt;blockquote class="wp-embedded-content" data-secret="g3Lu0xsMqa"&gt;&lt;a href="https://en.blog.wordpress.com/2025/06/13/wordcamp-europe-2025-recap-connecting-and-learning-in-basel-switzerland/"&gt;WordCamp Europe 2025 Recap: Connecting and Learning in Basel, Switzerland&lt;/a&gt;&lt;/blockquote&gt;https://en.blog.wordpress.com/2025/06/13/wordcamp-europe-2025-recap-connecting-and-learning-in-basel-switzerland/embed/#?secret=g3Lu0xsMqa&lt;script type="text/javascript"&gt;n/\* &lt;!\[CDATA\[ \*/n/\*! This file is auto-generated \*/n!function(d,l){"use strict";l.querySelector&amp;&amp;d.addEventListener&amp;&amp;"undefined"!=typeof URL&amp;&amp;(d.wp=d.wp||{},d.wp.receiveEmbedMessage||(d.wp.receiveEmbedMessage=function(e){var t=e.data;if((t||t.secret||t.message||t.value)&amp;&amp;!/\[^a-zA-Z0-9\]/.test(t.secret)){for(var s,r,n,a=l.querySelectorAll('iframe\[data-secret="'+t.secret+'"\]'),o=l.querySelectorAll('blockquote\[data-secret="'+t.secret+'"\]'),c=new RegExp("^https?:$","i"),i=0;i&lt;o.length;i++)o\[i\].style.display="none";for(i=0;i&lt;a.length;i++)s=a\[i\],e.source===s.contentWindow&amp;&amp;(s.removeAttribute("style"),"height"===t.message?(1e3&lt;(r=parseInt(t.value,10))?r=1e3:~~r&lt;200&amp;&amp;(r=200),s.height=r):"link"===t.message&amp;&amp;(r=new URL(s.getAttribute("src")),n=new URL(t.value),c.test(n.protocol))&amp;&amp;n.host===r.host&amp;&amp;l.activeElement===s&amp;&amp;(d.top.location.href=t.value))}},d.addEventListener("message",d.wp.receiveEmbedMessage,!1),l.addEventListener("DOMContentLoaded",function(){for(var e,t,s=l.querySelectorAll("iframe.wp-embedded-content"),r=0;r&lt;s.length;r++)(t=(e=s\[r\]).getAttribute("data-secret"))||(t=Math.random().toString(36).substring(2,12),e.src+="#?secret="+t,e.setAttribute("data-secret",t)),e.contentWindow.postMessage({message:"ready",secret:t},"\*")},!1)))}(window,document);n/\* \]\]&gt; \*/n&lt;/script&gt;n", "type": "rich", "thumbnail\_url": "https://en-blog.files.wordpress.com/2025/06/wceu-2025-recap-header.jpg?fit=440%2C330", "thumbnail\_width": null, "thumbnail\_height": null }CopyCopied

`as_article` mode (`as_article=true)`:

```
https://public-api.wordpress.com/oembed/?for=develop.wordpress.com&url=https://wordpress.com/blog/2025/06/13/wordcamp-europe-2025-recap-connecting-and-learning-in-basel-switzerland/&as_article=true
```

Response:

```
{
  "version": "1.0",
  "provider_name": "WordPress.com News",
  "provider_url": "http://en.blog.wordpress.com",
  "author_name": "Nick Schäferhoff",
  "author_url": "https://en.blog.wordpress.com/author/nschaeferhoff/",
  "title": "WordCamp Europe 2025 Recap: Connecting and Learning in Basel, Switzerland",
  "type": "article",
  "body": "Couldn't make it to WordCamp Europe 2025? Don’t worry. While nothing beats the experience of actually being there, this post will give you a detailed summary of some of the most important and meaningful presentations held at the conference.",
  "related_topics": "News",
  "thumbnail_url": "https://en-blog.files.wordpress.com/2025/06/wceu-2025-recap-header.jpg?fit=440%2C330",
  "thumbnail_width": null,
  "thumbnail_height": null
}
```

{ "version": "1.0", "provider\_name": "WordPress.com News", "provider\_url": "http://en.blog.wordpress.com", "author\_name": "Nick Schäferhoff", "author\_url": "https://en.blog.wordpress.com/author/nschaeferhoff/", "title": "WordCamp Europe 2025 Recap: Connecting and Learning in Basel, Switzerland", "type": "article", "body": "Couldn't make it to WordCamp Europe 2025? Don’t worry. While nothing beats the experience of actually being there, this post will give you a detailed summary of some of the most important and meaningful presentations held at the conference.", "related\_topics": "News", "thumbnail\_url": "https://en-blog.files.wordpress.com/2025/06/wceu-2025-recap-header.jpg?fit=440%2C330", "thumbnail\_width": null, "thumbnail\_height": null }CopyCopied

Requesting a specific image size, and xml format

```
https://public-api.wordpress.com/oembed/?for=develop.wordpress.com&url=https://wordpress.com/blog/2025/06/13/wordcamp-europe-2025-recap-connecting-and-learning-in-basel-switzerland/&as_article=true&img_size=880x660&format=xml
```

Response:

```
<oembed>
    <version>
        <![CDATA[ 1.0 ]]>
    </version>
    <provider_name>
        <![CDATA[ WordPress.com News ]]>
    </provider_name>
    <provider_url>
        <![CDATA[ https://en.blog.wordpress.com ]]>
    </provider_url>
    <author_name>
        <![CDATA[ Nick Schäferhoff ]]>
    </author_name>
    <author_url>
        <![CDATA[ https://en.blog.wordpress.com/author/nschaeferhoff/ ]]>
    </author_url>
    <title>
        <![CDATA[ WordCamp Europe 2025 Recap: Connecting and Learning in Basel, Switzerland ]]>
    </title>
    <type>
        <![CDATA[ article ]]>
    </type>
    <body>
        <![CDATA[ Couldn't make it to WordCamp Europe 2025? Don’t worry. While nothing beats the experience of actually being there, this post will give you a detailed summary of some of the most important and meaningful presentations held at the conference. ]]>
    </body>
    <related_topics>
        <![CDATA[ News ]]>
    </related_topics>
    <thumbnail_url>
        <![CDATA[ https://en-blog.files.wordpress.com/2025/06/wceu-2025-recap-header.jpg?fit=880%2C660 ]]>
    </thumbnail_url>
    <thumbnail_width>
        <![CDATA[ ]]>
    </thumbnail_width>
    <thumbnail_height>
        <![CDATA[ ]]>
    </thumbnail_height>
</oembed>
```

&lt;oembed&gt; &lt;version&gt; &lt;!\[CDATA\[ 1.0 \]\]&gt; &lt;/version&gt; &lt;provider\_name&gt; &lt;!\[CDATA\[ WordPress.com News \]\]&gt; &lt;/provider\_name&gt; &lt;provider\_url&gt; &lt;!\[CDATA\[ https://en.blog.wordpress.com \]\]&gt; &lt;/provider\_url&gt; &lt;author\_name&gt; &lt;!\[CDATA\[ Nick Schäferhoff \]\]&gt; &lt;/author\_name&gt; &lt;author\_url&gt; &lt;!\[CDATA\[ https://en.blog.wordpress.com/author/nschaeferhoff/ \]\]&gt; &lt;/author\_url&gt; &lt;title&gt; &lt;!\[CDATA\[ WordCamp Europe 2025 Recap: Connecting and Learning in Basel, Switzerland \]\]&gt; &lt;/title&gt; &lt;type&gt; &lt;!\[CDATA\[ article \]\]&gt; &lt;/type&gt; &lt;body&gt; &lt;!\[CDATA\[ Couldn't make it to WordCamp Europe 2025? Don’t worry. While nothing beats the experience of actually being there, this post will give you a detailed summary of some of the most important and meaningful presentations held at the conference. \]\]&gt; &lt;/body&gt; &lt;related\_topics&gt; &lt;!\[CDATA\[ News \]\]&gt; &lt;/related\_topics&gt; &lt;thumbnail\_url&gt; &lt;!\[CDATA\[ https://en-blog.files.wordpress.com/2025/06/wceu-2025-recap-header.jpg?fit=880%2C660 \]\]&gt; &lt;/thumbnail\_url&gt; &lt;thumbnail\_width&gt; &lt;!\[CDATA\[ \]\]&gt; &lt;/thumbnail\_width&gt; &lt;thumbnail\_height&gt; &lt;!\[CDATA\[ \]\]&gt; &lt;/thumbnail\_height&gt; &lt;/oembed&gt;CopyCopied

## Header tags

WordPress.com also adds the [related link tags](https://oembed.com/#section4) to site headers, for posts, pages and attachments (for public sites only) so that 3rd-party sites can automatically discover the oEmbed representation equivalent of your content:

```
<link href="http://public-api.wordpress.com/oembed/?format=json&url=http:%2F%2Ftekartist.org%2F2011%2F07%2F13%2Fyourself-truly-by-emma%2F&for=wpcom-auto-discovery" rel="alternate" type="application/json+oembed" />
<link href="http://public-api.wordpress.com/oembed/?format=xml&url=http:%2F%2Ftekartist.org%2F2011%2F07%2F13%2Fyourself-truly-by-emma%2F&for=wpcom-auto-discovery" rel="alternate" type="application/xml+oembed" />
```

&lt;link href="http://public-api.wordpress.com/oembed/?format=json&amp;url=http:%2F%2Ftekartist.org%2F2011%2F07%2F13%2Fyourself-truly-by-emma%2F&amp;for=wpcom-auto-discovery" rel="alternate" type="application/json+oembed" /&gt; &lt;link href="http://public-api.wordpress.com/oembed/?format=xml&amp;url=http:%2F%2Ftekartist.org%2F2011%2F07%2F13%2Fyourself-truly-by-emma%2F&amp;for=wpcom-auto-discovery" rel="alternate" type="application/xml+oembed" /&gt;CopyCopied
