---
type: document
title: REST API example apps
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/rest-api-example-apps/"
tags:
timestamp: "2026-06-16T19:29:27+00:00"
wordpress:
  id: 2496
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:27"
  date_gmt: "2026-06-16 19:29:27"
  modified: "2026-06-16 19:29:27"
  modified_gmt: "2026-06-16 19:29:27"
  slug: rest-api-example-apps
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/rest-api-example-apps/"
  comment_count: 0
---

We’ve created some open source apps that demonstrate how to build applications on top of the REST API.

## Grasshopper

A single-page JavaScript application that uses the [D3.js](https://d3js.org) graphing library to graph a site’s recent visitors and views using the [/stats](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/) endpoint. It uses [Implicit OAuth](https://developer.wordpress.com/docs/api/rest-api-javascript/) to authenticate a user and retrieve the data for a specific site, without storing any tokens.

![example-apps_grasshopper](https://wpdeveloperstaging.files.wordpress.com/2024/02/4201a-example-apps_grasshopper.png)The code can be found [on GitHub](https://github.com/automattic/grasshopper), and there’s a live demo at[ https://automattic.github.io/grasshopper/](https://automattic.github.io/grasshopper/).

## Sulfur

A media manager written in [Backbone](http://backbonejs.org/). The code is [on GitHub](https://github.com/Automattic/sulfur/).

![example-apps_sulfur](https://wpdeveloperstaging.files.wordpress.com/2024/02/9adba-example-apps_sulfur.png)Like Grasshopper, it shows how you can use Implicit OAuth to do authentication without a server component. It also provides examples for using the API with third-party libraries like [plupload](http://www.plupload.com/) for uploading media.

Sulfur allows you to upload images, view your entire media library contents, view meta data, and delete images. You can learn more about Sulfur in this [previous post](https://wordpress.com/blog/2014/05/20/meet-sulfur/).

## REST API Console

For an example of a more complex application (and one that we use in real life!) check out the API Console, an interactive way of building and testing API queries.

![example-apps_console](https://wpdeveloperstaging.files.wordpress.com/2024/02/9eb7c-example-apps_console.png)There’s now a Version 2 of the console. Its code is [on GitHub](https://github.com/Automattic/rest-api-console2), and it runs at <https://developer.wordpress.com/docs/api/console/>. Read our initial post about v1 of the API console [here](https://wordpress.com/blog/2014/06/11/rest-development-console-now-open-source/).
