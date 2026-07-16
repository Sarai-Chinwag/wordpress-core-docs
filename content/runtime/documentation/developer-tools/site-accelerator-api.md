---
type: document
title: Site Accelerator API
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/site-accelerator-api/"
tags:
timestamp: "2026-06-16T19:29:19+00:00"
wordpress:
  id: 2438
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:19"
  date_gmt: "2026-06-16 19:29:19"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: site-accelerator-api
  parent: 2514
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/site-accelerator-api/"
  comment_count: 0
---

[Site Accelerator from Jetpack](https://wordpress.com/support/site-accelerator-cdn/) is a Content Delivery Network (CDN) on WordPress.com, optimized to speed up your site by delivering faster images and static files. This guide explains how to use its API and available arguments.

Site Accelerator CDN is automatically enabled on sites with the [WordPress.com Business and Commerce plans](https://wordpress.com/hosting/?ref=developer-docs#pricing-grid).

## Query arguments

You can crop, resize, and filter images served by the Site Accelerator CDN using the following GET query parameters.

---

`<span class="api-method-get">GET</span>?w=`

Set the **w**idth of an image in pixels:

`?w=300`

![Image of the Fox Oakland Theater sign with a green traffic light in the foreground and a crowd of people walking down the street.](https://i0.wp.com/s.ma.tt/files/2012/06/DSC01205.jpg?w=300)

---

`<span class="api-method-get">GET</span>?h=`

Set the **h**eight of an image in pixels:

`?h=200`

![Close-up of purple lavender flowers with a bee collecting nectar.](https://i0.wp.com/s.ma.tt/files/2012/06/MCM_0629-1600x1064.jpg?h=200)

---

`<span class="api-method-post">GET</span>?crop=x,y,w,h`

Crop an image by percentages **x**-offset, **y**-offset, **w**idth, **h**eight (x,y,w,h). Percentages are used so that you don’t need to recalculate the cropping when transforming the image in other ways such as resizing it.

For example, the following image takes a 60% by 60% rectangle from the [source image](http://s.ma.tt/files/2012/06/4-MCM_0830-1600x1064.jpg) starting at 12% offset from the left and 25% offset from the top.

`?crop=12,25,60,60`

![Close-up of glass containers with various colorful sauces or jams, displayed on a white tablecloth, with small spoons beside them.](https://i0.wp.com/s.ma.tt/files/2012/06/4-MCM_0830-1600x1064.jpg?crop=12,25,60,60)The next image takes a 788 by 788 square starting at 160 by 160.

The next image takes a 788 by 788 square starting at 160 by 160.

The next image takes a 788 by 788 square starting at 160 by 160.

`?crop=160px,160px,788px,788px`

You can also mix the parameters types, for example a 1400 pixels by 60% rectangle from the image starting at 160 pixels by 25%.

You can also mix the parameters types, for example a 1400 pixels by 60% rectangle from the image starting at 160 pixels by 25%.

You can also mix the parameters types, for example a 1400 pixels by 60% rectangle from the image starting at 160 pixels by 25%.

`?crop=160px,25,1400px,60`

![Close-up of three glass containers with domed lids, each holding different colored sauces or jams, placed on a white tablecloth.](https://i0.wp.com/s.ma.tt/files/2012/06/4-MCM_0830-1600x1064.jpg?crop=160px,160px,788px,788px)![A row of small glass jars containing colorful sauces or condiments, each topped with a glass lid, placed on a white tablecloth with silver spoons beside them.](https://i0.wp.com/s.ma.tt/files/2012/06/4-MCM_0830-1600x1064.jpg?crop=160px,25,1400px,60)

---

`<span class="api-method-get">GET</span>?resize=`

Resize and crop an image to the exact **w**idth,**h**eight pixel dimensions. Set the first number as close to the target size as possible and then crop the rest. Which direction it’s resized and cropped depends on the aspect ratios of the original image and the target size.

`?resize=400,220`

![Scenic view of a coastal landscape with hills, a winding road, and a clear blue sky.](https://i0.wp.com/s.ma.tt/files/2012/06/9-DSC01406-1600x1066.jpg?resize=400,220)`?resize=200,400`

![A tabby cat resting its front paws on a balcony railing, with a blurred background of greenery.](https://i0.wp.com/s.ma.tt/files/2010/11/MCM_4443.jpg?resize=200,400)This is useful for taking an image of any size and making it fit into a certain location while losing as little of the image as possible.

This is useful for taking an image of any size and making it fit into a certain location while losing as little of the image as possible.

This is useful for taking an image of any size and making it fit into a certain location while losing as little of the image as possible.

---

`<span class="api-method-post">GET</span>?fit=`

Fit an image to a containing box of **w**idth, **h**eight dimensions. Image aspect ratio is maintained.

``?fit=300,300``

![A reflective metallic sphere sculpture on a wet surface, capturing the surrounding cityscape and trees.](https://i0.wp.com/s.ma.tt/files/2010/10/MCM_4049.jpg?fit=300,300)

``?fit=300,300``

![A bottle of Jameson Distillery Reserve 12 whiskey displayed next to a glass of red wine on a dining table.](https://i0.wp.com/s.ma.tt/files/2010/10/MCM_4214.jpg?fit=300,300)

For example, `fit=100,100` on a landscape image with dimensions 400×300 will result in an image that is 100×75, while `fit=100,100` on a portrait image with dimensions 300×400 will result in an image that is 75×100.

For example, `fit=100,100` on a landscape image with dimensions 400×300 will result in an image that is 100×75, while `fit=100,100` on a portrait image with dimensions 300×400 will result in an image that is 75×100.

For example, `fit=100,100` on a landscape image with dimensions 400×300 will result in an image that is 100×75, while `fit=100,100` on a portrait image with dimensions 300×400 will result in an image that is 75×100.

---

`<span class="api-method-post">GET</span>?lb=`

Add black letterboxing effect to images, by scaling them to **w**idth, **h**eight while maintaining the aspect ratio and filling the rest with black.

**Original Image**

![A scenic view of a calm sea with rocky shores under a cloudy sky, showcasing a distant coastline with mountains.](https://i0.wp.com/developer.files.wordpress.com/2013/03/letterboxing-example.jpg)

`?lb=310,250`

![Scenic view of a rocky coastline with waves crashing against the rocks, under a cloudy sky, with distant mountains and a coastal town in the background.](https://i0.wp.com/developer.files.wordpress.com/2013/03/letterboxing-example.jpg?lb=310,250)

---

`<span class="api-method-post">GET</span>?ulb=`

Remove black letterboxing effect from images with **ulb**. This function takes only one argument, `true`.

**Original Image**

![Black and white image of two men in a crowd, one wearing a cap with 'RIP G' and the other looking on.](https://i0.wp.com/developer.files.wordpress.com/2012/11/black-letterboxing-example.jpg)

`?ulb=true`

![Black and white image of two individuals in a lively atmosphere, one wearing a cap with 'RIP' printed on it and smiling, while the other appears contemplative.](https://i0.wp.com/developer.files.wordpress.com/2012/11/black-letterboxing-example.jpg?ulb=true)

---

`<span class="api-method-get">GET</span>?filter=`

The **filter** parameter is used to apply one of multiple filters. Valid values are: `negate`, `grayscale`, `sepia`, `edgedetect`, `emboss`, `blurgaussian`, `blurselective`, `meanremoval`.

**Original Image**

![A cup of tea with a teabag on a saucer, accompanied by a piece of pastry and a teapot in the background.](https://i0.wp.com/s.ma.tt/files/2010/12/MCM_5875-1600x1064.jpg?w=200)

`?filter=negate`

![An inverted image of a cup with a tea bag on a saucer, accompanied by a blue pastry and a teapot.](https://i0.wp.com/s.ma.tt/files/2010/12/MCM_5875-1600x1064.jpg?w=200&filter=negate)

`?filter=grayscale`

![A black and white image of a coffee cup with a tea bag tag, a piece of bread, and a teapot in the background, placed on a wooden surface.](https://i0.wp.com/s.ma.tt/files/2010/12/MCM_5875-1600x1064.jpg?w=200&filter=grayscale)

`?filter=sepia`

![A cup of coffee with a tea bag on the saucer, accompanied by a biscuit and a teapot in the background.](https://i0.wp.com/s.ma.tt/files/2010/12/MCM_5875-1600x1064.jpg?w=200&filter=sepia)

`?filter=edgedetect`

![A cup of coffee on a saucer with a biscuit, accompanied by a teapot, featuring a label on the cup.](https://i0.wp.com/s.ma.tt/files/2010/12/MCM_5875-1600x1064.jpg?w=200&filter=edgedetect)

`?filter=emboss`

![Cup of coffee with a pastry on a plate, a sugar packet in the cup, and a teapot in the background, artistically filtered.](https://i0.wp.com/s.ma.tt/files/2010/12/MCM_5875-1600x1064.jpg?w=200&filter=emboss)

`?filter=blurgaussian`

![A cup of tea with a teabag tag, accompanied by a teapot and a piece of bread on a saucer, placed on a wooden table.](https://i0.wp.com/s.ma.tt/files/2010/12/MCM_5875-1600x1064.jpg?w=200&filter=blurgaussian)

`?filter=blurselective`

![A cup of coffee with a logo sticker on it, accompanied by a small plate with a pastry, a teapot, and a sugar packet, all placed on a wooden table.](https://i0.wp.com/s.ma.tt/files/2010/12/MCM_5875-1600x1064.jpg?w=200&filter=blurselective)

`?filter=meanremoval`

![A cup of tea with a teabag resting on the rim, accompanied by a pastry on a plate, set on a wooden table.](https://i0.wp.com/s.ma.tt/files/2010/12/MCM_5875-1600x1064.jpg?w=200&filter=meanremoval)

---

`GET?brightness=`

Adjust the **brightness** of an image. Valid values are -255 through 255 where -255 is black and 255 is white. Higher is brighter. The default is zero.

`?brightness=-40`

![A bird in flight against a gray sky.](https://i0.wp.com/s.ma.tt/files/2011/06/MCM_9517-1600x1065.jpg?brightness=-40)

`?brightness=0`

![A bird flying against a cloudy gray sky.](https://i0.wp.com/s.ma.tt/files/2011/06/MCM_9517-1600x1065.jpg?brightness=0)

`?brightness=80`

![A white bird in flight against a bright white background.](https://i0.wp.com/s.ma.tt/files/2011/06/MCM_9517-1600x1065.jpg?brightness=80)

---

`<span class="api-method-post">GET</span>?contrast=`

Adjust the **contrast** contrast of an image. Valid values are -100 through 100. The default is zero.

`?contrast=-50`

![A bird flying against a cloudy sky.](https://i0.wp.com/s.ma.tt/files/2011/06/MCM_9517-1600x1065.jpg?contrast=-50)

`?contrast=0`

![A bird in flight against a gray sky.](https://i0.wp.com/s.ma.tt/files/2011/06/MCM_9517-1600x1065.jpg?contrast=0)

`?contrast=50`

![A bird in flight against a white background.](https://i0.wp.com/s.ma.tt/files/2011/06/MCM_9517-1600x1065.jpg?contrast=50)

---

`<span class="api-method-post">GET</span>?colorize=`

Add color hues to an image with **colorize** by passing a comma separated list of red, green, and blue (RGB). For example, values such as 255,0,0 (red), 0,255,0 (green), 0,0,255 (blue).

`?colorize=100,0,0`

![](https://i0.wp.com/s.ma.tt/files/2024/02/IMG_3775.jpeg?colorize=100,0,0)

`?colorize=0,100,0`

![](https://i0.wp.com/s.ma.tt/files/2024/02/IMG_3775.jpeg?colorize=0,100,0)

`?colorize=0,0,100`

![A lighthouse standing on a rocky cliff with greenery surrounding it and a blue sky in the background.](https://i0.wp.com/s.ma.tt/files/2024/02/IMG_3775.jpeg?colorize=0,0,100)

---

`<span class="api-method-get">GET</span>?smooth=`

The **smooth** parameter can be used to smooth out the image.

**Original image**

![Close-up view of a vintage aircraft engine and propeller with orange and white color scheme, showcasing the engine components and a glimpse of the landscape in the reflection.](https://i0.wp.com/s.ma.tt/files/2011/06/MCM_9230-1600x1064.jpg)

`?smooth=1`

![Close-up view of an orange and white vintage airplane with a propeller, set against a clear blue sky.](https://i0.wp.com/s.ma.tt/files/2011/06/MCM_9230-1600x1064.jpg?w=310&smooth=1)

According to the PHP manual, the function applies a 9-cell convolution matrix where the center pixel is weighted by the value of the first argument, and all surrounding pixels have a weight of 1. The result is normalized by dividing by the total weight. In simpler terms, a value of 0 results in maximum smoothing, while higher values reduce the smoothing effect. Values around 2048 or more have little to no visible impact.

---

`<span class="api-method-get">GET</span>?zoom=`

Use **zoom** to size images for high pixel ratio devices and browsers when zoomed. Not available to use with crop. Zoom is intended for use by scripts such as devicepx.js which automatically set the zoom level. Valid zoom levels are 1, 1.5, 2-10.

**Original image**

![A child holding a stick with smoke rising, in front of a crowd during a celebration outdoors, with mountains in the background.](https://i0.wp.com/s.ma.tt/files/2012/02/MCM_4246-1600x1064.jpg?w=310)

`?zoom=2`

![A young girl dressed in a blue dress holds a tall bundle of burning sticks while an Ethiopian flag flutters in the background. The scene is set in a rural area with a group of spectators in the background.](https://i0.wp.com/s.ma.tt/files/2012/02/MCM_4246-1600x1064.jpg?zoom=2)

---

`GET?quality=`

Use this parameter to manage the quality output of the images. Valid settings are between the values 10 and 100. The degree of compression depends on the image, its lossy or lossless nature, and the requesting web browser’s capabilities.

For lossless images, providing the quality input less than 100 will result in a lossy image provided the requested browser supports this image type. Below is an example that shows conversion of a non-transparent PNG (lossless) image to a JPEG (or lossy WebP if browser supports it) when quality is specified.

If the quality is not specified, photon will try to preserve the original quality.

**Original image**

![Close-up image of two black ants interacting on a piece of wood with a blurred green background.](https://i0.wp.com/ma.tt/files/2014/09/8084136238_169f1ca1f0_o.jpg?w=310)

`?quality=50`

![Close-up of two ants engaged in a confrontation on a wooden surface, with a blurred natural background.](https://i0.wp.com/ma.tt/files/2014/09/8084136238_169f1ca1f0_o.jpg?w=310&quality=50)

**Original png image**

![Original png (lossless) image](https://i0.wp.com/ma.tt/files/2025/06/image-1.png)

?`quality=60`

![Original image is now converted to jpeg (lossy) because `?quality=60` attribute is specified](https://i0.wp.com/ma.tt/files/2025/06/image-1.png?quality=60)

`GET?allow_lossy=`

Use this parameter to control whether the Image CDN may serve a lossy-compressed version of an image. When `allow_lossy=1` is specified, the CDN will attempt to deliver a lossy format (for example, JPEG or WebP) if the requesting browser supports it.

Below is an example that demonstrates how a non-transparent PNG (lossless) image can be converted to a JPEG (or lossy WebP if browser supports it) when `allow_lossy=1` is included in the request.

**Original png image**

![Original png (lossless) image](https://i0.wp.com/ma.tt/files/2025/06/image-1.png)

?`allow_lossy=1`

![Original image is now converted to jpeg (lossy) because `?allow_lossy=1` attribute is specified](https://i0.wp.com/ma.tt/files/2025/06/image-1.png?allow_lossy=1)

---

`GET?strip=`

Use the **strip** functionality to control how metadata is preserved. Color profiles are always applied and removed, but other metadata may be kept. All data is stripped by default, with any existing orientation data being first applied to the image. There are 2 valid settings for this parameter:

- **all**: strips all extraneous data (this is the default).
- **none**: preserves Exif, IPTC and XMP.

**Original image**

![Close-up of yellow flowers with a green background.](https://i0.wp.com/ma.tt/files/2012/06/13-MCM_0885.jpg?w=310)

`?strip=none`

![Close-up of vibrant yellow flowers amidst green foliage, taken from above.](https://i0.wp.com/ma.tt/files/2012/06/13-MCM_0885.jpg?w=310&strip=all)
