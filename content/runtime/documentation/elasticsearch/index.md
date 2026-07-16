---
type: document
title: Elasticsearch-powered APIs
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/elasticsearch/"
tags:
timestamp: "2026-06-16T19:29:28+00:00"
wordpress:
  id: 2512
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:28"
  date_gmt: "2026-06-16 19:29:28"
  modified: "2026-06-16 19:29:28"
  modified_gmt: "2026-06-16 19:29:28"
  slug: elasticsearch
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/elasticsearch/"
  comment_count: 0
---

We maintain [Elasticsearch](https://www.elastic.co/products/elasticsearch) indices for all posts on WordPress.com and all posts synced through the [Jetpack plugin](https://jetpack.com/).

These documents describe the index structures and APIs that are available for querying. These APIs power features that are available on [WordPress VIP](https://vip.wordpress.com/documentation/vip-go/elasticsearch-on-vip-go/)and in the [Jetpack Professional Plan](https://cloud.jetpack.com/pricing). The [Jetpack Related Posts API](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post/related/)also accepts Elasticsearch filters.

## API Availability

There are three tiers of availability:

- **WordPress VIP**: We can build a single index for your content (setup fee required). The code for building the index is [open source](https://github.com/Automattic/wpes-lib/blob/master/src/indices/vip2-all-posts-index.php). Often experimental features/fields or things we cannot scale to all sites will get implemented here first.
- [**Jetpack Professional Plan**](https://cloud.jetpack.com/pricing): All Jetpack Pro sites (including all VIP sites) are indexed into our global Elasticsearch cluster and can be queried with Elasticsearch Query API calls. We do not support the entire ES Query DSL, but do support most of it.
- **Jetpack Free Plan**: All sites are indexed to power the [Related Posts API](https://jetpack.com/support/related-posts/). The API accepts custom [Elasticsearch filters](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post/related/).

## Elasticsearch Versions and Backwards Compatibility

The Elasticsearch project is focused on continually improving its APIs and so regularly breaks backwards compatibility. Our APIs strive to maintain backwards compatibility and so there are a number of features that we choose not to support for various security or performance reasons. For example, all scripting is disabled in our API. We also do not try and use the very latest version of Elasticsearch because we are committed to backwards compatibility.

Our [query API](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/search/) looks mostly like the Elasticsearch Search API from [version 2.4 of Elasticsearch](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/search-request-body.html). We do however accept some deprecated features and perform some query rewriting to maintain compatibility. A good example is when we moved from ES 1.x to 2.x all content had to be migrated from being stored in the “content” field with multiple analyzers to being stored in a separate field for each language analyzer: “content.en”, “content.fr”, “content.default”, etc. We rewrite queries that still use the “content” field.

## Existing Libraries

There likely will be times where we have to **break backwards compatibility** (in hopefully minor ways). The best way to ensure your application will not run into these issues is to use one of the existing libraries or filters rather than writing a completely custom search query:

- Jetpack Related Posts [filter hooks](https://developer.jetpack.com/?search_for=wpapi-hook&s=jetpack_related) and [examples](https://jetpack.com/support/customize-related-posts/).
- Jetpack Search [filter hooks](https://developer.jetpack.com/?search_for=wpapi-hook&s=jetpack_search)
- [Jetpack Search Search Query Builder](https://github.com/Automattic/jetpack/blob/master/_inc/lib/jetpack-wpes-query-builder/jetpack-wpes-query-parser.php) (abstraction layer)
- [Jetpack Search Query Builder](https://github.com/Automattic/jetpack/blob/master/_inc/lib/jetpack-wpes-query-builder/jetpack-wpes-query-builder.php) (abstraction layer)
- [es-wp-query](https://github.com/alleyinteractive/es-wp-query) (converts WP\_Query MySQL queries to Elasticsearch queries). Fully supported on VIP Indices, may partially work on Jetpack Pro but it is untested.
- [es-admin](https://github.com/alleyinteractive/es-admin) (power the wp-admin post search with ES). Fully supported on VIP indices, unknown on Jetpack Pro.

Because code makes the best documentation, how the mappings and documents are built for our indices is mostly available in [WPES-Lib](https://github.com/Automattic/wpes-lib/). [Data.blog](https://data.blog/) has the best description of [how our real time indexing](http://data.blog/2017/07/11/real-time-elasticsearch-indexing-on-wordpress-com/) works.

## Documents

We index all WordPress posts, pages, and custom post types as long as the post status is one of `publish`, `trash`, `pending`, `draft`, `future`, or `private`. Posts which are publicly available can be queried from our API unauthenticated. Authenticated requests will return all posts. In the case of Jetpack, any posts which are blocked from syncing will not be available in our index.

See the [post document schema](https://developer.wordpress.com/elasticsearch-post-doc-schema-v2/) for details on all fields in the index.

## Search API

There are slightly different limitations on the APIs depending on which tier of service you have (WordPress VIP, Jetpack Pro, or Jetpack Related Posts). Depending on the level of service different features of the Elasticsearch Query DSL are available.

See [the query API](https://developer.wordpress.com/docs/elasticsearch/elasticsearch-queries/) for details and limitations of available queries, filters, and aggregations.

*\* Elasticsearch is a trademark of Elasticsearch BV, registered in the U.S. and in other countries.*
