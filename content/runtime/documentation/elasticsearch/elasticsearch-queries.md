---
type: document
title: Elasticsearch queries
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/elasticsearch-queries/"
tags:
timestamp: "2026-06-16T19:29:28+00:00"
wordpress:
  id: 2511
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:28"
  date_gmt: "2026-06-16 19:29:28"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: elasticsearch-queries
  parent: 2512
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/elasticsearch-queries/"
  comment_count: 0
---

There are slightly different limitations on the query APIs depending on which tier of service you have (WordPress VIP, Jetpack Pro, or Jetpack Related Posts). Depending on the level of service different features of the Elasticsearch Query DSL are available. There are currently two APIs available:

- [Post Search API](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/search/) (VIP and Jetpack Pro).
    - Mostly a wrapper around the [Elasticsearch /\_search API](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/search-request-body.html).
    - The response looks slightly different due to filtering out some fields and some historical reasons.
    - Supports a subset of the top query parameters. See [API docs](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/search/).
- [Related Posts API](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post/related/) (Free)
    - Accepts Elasticsearch Filters for modifying the results. Many common examples [here](https://jetpack.com/support/related-posts/customize-related-posts/).
    - Returns the post\_id and blog\_id of any results.

## Allowed Queries (&amp; Filters)

To avoid performance problems and ensure backwards compatibility we only allow a subset of the[ Elasticsearch Query DSL](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/query-dsl.html).

Elasticsearch has moved away from [explicitly separating queries and filters](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/query-filter-context.html), so we don’t either.

### Common Queries:

- [bool](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-bool-query.html)
- [match](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-match-query.html)
- [multi match](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-multi-match-query.html)
- [function score](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-function-score-query.html)
    - random\_score is not supported
- [match all](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-match-all-query.html)
- [range](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/query-dsl-range-query.html)
- [term](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/query-dsl-term-query.html)
- [terms](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/query-dsl-terms-query.html)

### Exotic Queries:

- [constant score](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-constant-score-query.html)
- [boosting](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-boosting-query.html)
- [dis max](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-dis-max-query.html)
- [more like this / mlt](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-mlt-query.html)
- [more like this field / mlt field](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-mlt-field-query.html)
- [geo bounding box](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/query-dsl-geo-bounding-box-query.html)
- [geo distance](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-geo-distance-query.html)
- [geo distance range](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-geo-distance-range-query.html)
- [geohash cell](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-geohash-cell-query.html)
- [exists](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/query-dsl-exists-query.html)

### Deprecated Queries (Will be removed in the future):

- [and filter](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-and-filter.html) (deprecated, use bool)
- [not filter](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-not-filter.html) (deprecated, use bool)
- [or filter](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-or-filter.html) (deprecated, use bool)
- [filtered query](http://www.elasticsearch.org/guide/en/elasticsearch/reference/2.4/query-dsl-filtered-query.html) (deprecated, use bool)

## Allowed Aggregations

To avoid performance problems and ensure backwards compatibility we only allow a subset of the[ Elasticsearch Aggregations DSL](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/search-aggregations.html). We do not currently allow any pipeline aggregations.

Aggregations are not allowed on any analyzed content fields (eg “content”, “title”, “tag.name.en”).

### Metric Aggregations

- [Extended Stats](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/search-aggregations-metrics-extendedstats-aggregation.html)
- [Stats](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/search-aggregations-metrics-stats-aggregation.html)

### Bucket Aggregations

- [Date Histogram](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/search-aggregations-metrics-sum-aggregation.html)
- [Filters](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/search-aggregations-bucket-filters-aggregation.html)
- [Histogram](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/search-aggregations-bucket-histogram-aggregation.html)
- [Terms](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/search-aggregations-bucket-terms-aggregation.html)

## Size Field

The allowed maximum **size** depends on your level of service:

- Jetpack Professional Plan: 0-100
- WordPress VIP (with a dedicated index): 0-1000
- Jetpack Free Plan (Related Posts API): 1-15

## From Field

The allowed maximum **from** depends on your level of service:

- Jetpack Professional Plan: 0-1000
- WordPress VIP (with a dedicated index): 0-9000
- Jetpack Free Plan (Related Posts API): 0-50

## Fields

Although it is possible to return fields from the index, this is highly discouraged for production queries. The index has been optimized to efficiently and quickly return **post\_id** and **blog\_id**. Returning other fields is possible, but will slow down search results.

The other reason for relying on **post\_id** and then getting the final data from the DB is that the Elasticsearch index is only a mirror of your data. It is cached, can be delayed, or can be slightly out of sync with your database. Any of these could result in serving stale content if you rely on it.

## Sorting

Basic [sorting](https://www.elastic.co/guide/en/elasticsearch/reference/2.4/search-request-sort.html) on any field is allowed. We don’t allow any scripting.

## Allowed Suggestions (Experimental)

Suggestions are currently experimental as we don’t yet have any libraries using it in production. There is an [open issue](https://github.com/Automattic/jetpack/issues/7924) for how to integrate it. Only term and phrase suggestions are supported. Exact support may change.

## Allowed Rescoring (Experimental)

We currently support rescoring of queries for some experimental features. You probably shouldn’t use it.

## Facets (Deprecated)

Facets are deprecated and will be removed. Do not use them. Use aggregations instead. We still have some VIP clients using them which is why the API accepts them, but they probably won’t work for you.

*\* Elasticsearch is a trademark of Elasticsearch BV, registered in the U.S. and in other countries.*
