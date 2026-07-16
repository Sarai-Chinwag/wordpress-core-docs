---
type: document
title: REST API reference
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/rest-api-reference/"
tags:
timestamp: "2026-06-16T19:29:20+00:00"
wordpress:
  id: 2443
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:20"
  date_gmt: "2026-06-16 19:29:20"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: rest-api-reference
  parent: 2499
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/rest-api-reference/"
  comment_count: 0
---

Welcome to the WordPress.com REST API reference docs page. This doc page lists a selection of available endpoints, with each linking to a full page detailing the input, output, and example code in curl and PHP.

Alternatively, the [Development Console](https://developer.wordpress.com/docs/api/console/) provides a complete view of all available endpoints grouped by [namespace and version](https://developer.wordpress.com/docs/api/namespaces-versions-versions/). While it doesn’t provide in-depth details for each endpoint, it does allow you to construct and test real API requests to each endpoint interactively.

When making API requests, you’ll need to use the [standardized WordPress.com REST API URL format](https://developer.wordpress.com/docs/api/getting-started/#1-base-url-structure): `https://public-api.wordpress.com/{namespace}/{version}/sites/{site_id}/{endpoint}`.

For detailed information about URL structures, obtaining your site ID, and best practices for making API requests, see the [Getting Started guide](https://developer.wordpress.com/docs/api/getting-started/).

For more information about a particular endpoint, click on its name under the Resource header. You’ll be taken to the endpoint’s documentation page, which includes what query parameters the endpoint will accept, what the JSON object’s parameters will be in the response, and an example query/response.

## Users

View user information data such as username, name, email, blog, and Gravatar.

| **Resource** | **Description** |
|---|---|
| [GET/sites/$site/users](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/users/) | List the users of a site. |
| [POST/sites/$site/users/$user\_id](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/users/%24user_id/) | Update details of a user of a site. |
| [POST/sites/$site/invites/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/invites/new/) | Invite one or more users to your site. |
| [GET/sites/$site/users/login:$user\_id](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/users/login:%24user_id/) | Get details of a user of a site by login. |
| [POST/sites/$site/users/$user\_ID/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/users/%24user_ID/delete/) | Deletes or removes a user of a site. |
| [GET/users/suggest](https://developer.wordpress.com/docs/api/1.1/get/users/suggest/) | Get a list of possible users to suggest for @mentions. |
| [GET/me](https://developer.wordpress.com/docs/api/1.1/get/me/) | Get metadata about the current user. |
| [GET/me/billing-history](https://developer.wordpress.com/docs/api/1.1/get/me/billing-history/) | Get list of current user’s billing history and upcoming charges. |
| [GET/me/settings/](https://developer.wordpress.com/docs/api/1.1/get/me/settings/) | Get the current user’s settings. |
| [POST/me/settings/](https://developer.wordpress.com/docs/api/1.1/post/me/settings/) | Update the current user’s settings. |
| [GET/me/preferences/](https://developer.wordpress.com/docs/api/1.1/get/me/preferences/) | Get the current user’s settings. |
| [POST/me/preferences/](https://developer.wordpress.com/docs/api/1.1/post/me/preferences/) | Update the current user’s preferences. |
| [POST/me/settings/password/validate](https://developer.wordpress.com/docs/api/1.1/post/me/settings/password/validate/) | Verify strength of a user’s new password. |
| [GET/me/settings/profile-links/](https://developer.wordpress.com/docs/api/1.1/get/me/settings/profile-links/) | Get current user’s profile links. |
| [POST/me/settings/profile-links/new](https://developer.wordpress.com/docs/api/1.1/post/me/settings/profile-links/new/) | Add a link to current user’s profile. |
| [POST/me/settings/profile-links/$slug/delete](https://developer.wordpress.com/docs/api/1.1/post/me/settings/profile-links/%24slug/delete/) | Delete a link from current user’s profile. |
| [GET/me/connected-applications/](https://developer.wordpress.com/docs/api/1.1/get/me/connected-applications/) | Get current user’s connected applications. |
| [GET/me/connected-applications/$ID](https://developer.wordpress.com/docs/api/1.1/get/me/connected-applications/%24ID/) | Get one of current user’s connected applications. |
| [POST/me/connected-applications/$ID/delete](https://developer.wordpress.com/docs/api/1.1/post/me/connected-applications/%24ID/delete/) | Delete one of current user’s connected application access tokens. |
| [GET/me/two-step](https://developer.wordpress.com/docs/api/1.1/get/me/two-step/) | Get information about current user’s two factor configuration. |
| [POST/me/two-step/sms/new](https://developer.wordpress.com/docs/api/1.1/post/me/two-step/sms/new/) | Sends a two-step code via SMS to the current user. |
| [GET/me/likes/](https://developer.wordpress.com/docs/api/1.1/get/me/likes/) | Get a list of the current user’s likes. |

## Sites

View general site information and options.

| **Resource** | **Description** |
|---|---|
| [GET/sites/$site/shortcodes/render](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/shortcodes/render/) | Get a rendered shortcode for a site. Note: The current user must have publishing access. |
| [GET/sites/$site/shortcodes](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/shortcodes/) | Get a list of shortcodes available on a site. Note: The current user must have publishing access. |
| [GET/sites/$site/embeds/render](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/embeds/render/) | Get a rendered embed for a site. Note: The current user must have publishing access. |
| [GET/sites/$site/embeds](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/embeds/) | Get a list of embeds available on a site. Note: The current user must have publishing access. |
| [GET/sites/$site](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/) | Get information about a site. |
| [GET/sites/$site/page-templates](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/page-templates/) | Get a list of page templates supported by a site. |
| [GET/sites/$site/post-types](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/post-types/) | Get a list of post types available for a site. |
| [GET/sites/$site/post-counts/$post\_type](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/post-counts/%24post_type/) | Get number of posts in the post type groups by post status |
| [GET/sites/$site/widgets](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/widgets/) | Retrieve the active and inactive widgets for a site. |
| [POST/sites/$site/widgets/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/widgets/new/) | Activate a widget on a site. |
| [GET/sites/$site/wordads/settings](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/wordads/settings/) | Get detailed WordAds settings information about a site. |
| [POST/sites/$site/wordads/settings](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/wordads/settings/) | Update WordAds settings for a site. |
| [GET/sites/$site/wordads/earnings](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/wordads/earnings/) | Get detailed WordAds earnings information about a site. |
| [GET/sites/$site/wordads/tos](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/wordads/tos/) | Get WordAds TOS information about a site. |
| [POST/sites/$site/wordads/tos](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/wordads/tos/) | Update WordAds TOS setting for a site. |
| [POST/sites/$site/wordads/approve](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/wordads/approve/) | Request streamlined approval to join the WordAds program. |
| [GET/sites/$site/wordads/stats](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/wordads/stats/) | Get WordAds stats for a site |
| [GET/me/sites](https://developer.wordpress.com/docs/api/1.1/get/me/sites/) | Get a list of the current user’s sites. |
| [GET/me/sites/features](https://developer.wordpress.com/docs/api/1.1/get/me/sites/features/) | Get a list of the current user’s sites features |
| [GET/me/sites/plugins](https://developer.wordpress.com/docs/api/1.1/get/me/sites/plugins/) | Get a list of the current user’s sites plugins |
| [POST/sites/$site/search](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/search/) | Search within a site using an Elasticsearch Query API. |
| [GET/sites/$site/widgets/widget:$id](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/widgets/widget:%24id/) | Retrieve a widget on a site by its ID. |
| [POST/sites/$site/widgets/widget:$id](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/widgets/widget:%24id/) | Update a widget on a site by its ID. |
| [POST/sites/$site/widgets/widget:$id/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/widgets/widget:%24id/delete/) | Deactivate a widget on a site by its ID. Will delete if already deactivated. |
| [GET/sites/$site/headers/$theme\_slug](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/headers/%24theme_slug/) | Get the custom header options for a site with a particular theme. |
| [GET/sites/$site/headers/mine](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/headers/mine/) | Get the custom header options for a site. |
| [POST/sites/$site/headers/mine](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/headers/mine/) | Set the custom header options for a site. |

## Posts

View and manage posts including reblogs and likes.

| **Resource** | **Description** |
|---|---|
| [GET/sites/$site/dropdown-pages/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/dropdown-pages/) | Get a list of pages to be displayed as options in a select-a-page-dropdown. |
| [GET/sites/$site/posts/$post\_ID](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/posts/%24post_ID/) | Get a single post (by ID). |
| [POST/sites/$site/posts/$post\_ID](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post_ID/) | Edit a post. |
| [GET/sites/$site/posts/slug:$post\_slug](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/posts/slug:%24post_slug/) | Get a single post (by slug). |
| [GET/sites/$site/posts/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/posts/) | Get a list of matching posts. |
| [POST/sites/$site/posts/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/new/) | Create a post. |
| [POST/sites/$site/posts/$post\_ID/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post_ID/delete/) | Delete a post. Note: If the trash is enabled, this request will send the post to the trash. A second request will permanently delete the post. |
| [POST/sites/$site/posts/$post\_ID/restore](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post_ID/restore/) | Restore a post or page from the trash to its previous status. |
| [POST/sites/$site/posts/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/delete/) | Delete multiple posts. Note: If the trash is enabled, this request will send non-trashed posts to the trash. Trashed posts will be permanently deleted. |
| [POST/sites/$site/posts/restore](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/restore/) | Restore multiple posts. |
| [GET/me/posts](https://developer.wordpress.com/docs/api/1.1/get/me/posts/) | Get a list of posts across all the user’s sites. |
| [GET/sites/$site/posts/$post\_ID/likes/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/posts/%24post_ID/likes/) | Get a list of the likes for a post. |
| [POST/sites/$site/posts/$post\_ID/likes/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post_ID/likes/new/) | Like a post. |
| [POST/sites/$site/posts/$post\_ID/likes/mine/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post_ID/likes/mine/delete/) | Unlike a post. |
| [GET/sites/$site/posts/$post\_ID/likes/mine/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/posts/%24post_ID/likes/mine/) | Get the current user’s like status for a post. |
| [GET/sites/$site/posts/$post/subscribers/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/posts/%24post/subscribers/) | Get a list of the specified post’s subscribers. |
| [GET/sites/$site/posts/$post/subscribers/mine](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/posts/%24post/subscribers/mine/) | Get subscription status of the specified post for the current user. |
| [POST/sites/$site/posts/$post/subscribers/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post/subscribers/new/) | Subscribe current user to be notified of the specified post’s comments. |
| [POST/sites/$site/posts/$post/subscribers/mine/update](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post/subscribers/mine/update/) | Subscribe current user to be notified of the specified post’s comments. |
| [POST/sites/$site/posts/$post/subscribers/mine/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post/subscribers/mine/delete/) | Unsubscribe the current user from the specified post. |
| [POST/sites/$site/posts/$post\_ID/reblogs/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post_ID/reblogs/new/) | Reblog a post. |
| [GET/sites/$site/posts/$post\_ID/reblogs/mine](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/posts/%24post_ID/reblogs/mine/) | Get reblog status for a post. |
| [POST/sites/$site/posts/$post/related](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post/related/) | Search within a site for related posts. |

## Comments

View and manage a post’s comments.

| **Resource** | **Description** |
|---|---|
| [GET/sites/$site/comments/$comment\_ID](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/comments/%24comment_ID/) | Get a single comment. |
| [POST/sites/$site/comments/$comment\_ID](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/comments/%24comment_ID/) | Edit a comment. |
| [GET/sites/$site/comments/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/comments/) | Get a list of recent comments. |
| [GET/sites/$site/posts/$post\_ID/replies/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/posts/%24post_ID/replies/) | Get a list of recent comments on a post. |
| [POST/sites/$site/posts/$post\_ID/replies/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/posts/%24post_ID/replies/new/) | Create a comment on a post. |
| [POST/sites/$site/comments/$comment\_ID/replies/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/comments/%24comment_ID/replies/new/) | Create a comment as a reply to another comment. |
| [POST/sites/$site/comments/$comment\_ID/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/comments/%24comment_ID/delete/) | Delete a comment. |
| [GET/sites/$site/comment-counts](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/comment-counts/) | Get comment counts for each available status |
| [GET/sites/$site/comment-history/$comment\_ID](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/comment-history/%24comment_ID/) | Get the audit history for given comment |
| [GET/sites/$site/comments/$comment\_ID/likes/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/comments/%24comment_ID/likes/) | Get the likes for a comment. |
| [POST/sites/$site/comments/$comment\_ID/likes/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/comments/%24comment_ID/likes/new/) | Like a comment. |
| [POST/sites/$site/comments/$comment\_ID/likes/mine/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/comments/%24comment_ID/likes/mine/delete/) | Remove your like from a comment. |
| [GET/sites/$site/comments/$comment\_ID/likes/mine/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/comments/%24comment_ID/likes/mine/) | Get your like status for a comment. |
| [GET/kill-switch/comment-likes](https://developer.wordpress.com/docs/api/1.1/get/kill-switch/comment-likes/) | Kill comment likes |

## Taxonomy

View and manage a site’s tags and categories.

| **Resource** | **Description** |
|---|---|
| [GET/sites/$site/categories](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/categories/) | Get a list of a site’s categories. |
| [GET/sites/$site/tags](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/tags/) | Get a list of a site’s tags. |
| [GET/sites/$site/categories/slug:$category](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/categories/slug:%24category/) | Get information about a single category. |
| [POST/sites/$site/categories/slug:$category](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/categories/slug:%24category/) | Edit a category. |
| [GET/sites/$site/tags/slug:$tag](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/tags/slug:%24tag/) | Get information about a single tag. |
| [POST/sites/$site/tags/slug:$tag](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/tags/slug:%24tag/) | Edit a tag. |
| [GET/sites/$site/taxonomies/$taxonomy/terms/slug:$slug](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/taxonomies/%24taxonomy/terms/slug:%24slug/) | Get information about a single term. |
| [POST/sites/$site/taxonomies/$taxonomy/terms/slug:$slug](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/taxonomies/%24taxonomy/terms/slug:%24slug/) | Edit a term. |
| [GET/sites/$site/post-types/$post\_type/taxonomies](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/post-types/%24post_type/taxonomies/) | Get a list of taxonomies associated with a post type. |
| [GET/sites/$site/taxonomies/$taxonomy/terms](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/taxonomies/%24taxonomy/terms/) | Get a list of a site’s terms by taxonomy. |
| [POST/sites/$site/categories/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/categories/new/) | Create a new category. |
| [POST/sites/$site/tags/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/tags/new/) | Create a new tag. |
| [POST/sites/$site/categories/slug:$category/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/categories/slug:%24category/delete/) | Delete a category. |
| [POST/sites/$site/tags/slug:$tag/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/tags/slug:%24tag/delete/) | Delete a tag. |
| [POST/sites/$site/taxonomies/$taxonomy/terms/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/taxonomies/%24taxonomy/terms/new/) | Create a new term. |
| [POST/sites/$site/taxonomies/$taxonomy/terms/slug:$slug/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/taxonomies/%24taxonomy/terms/slug:%24slug/delete/) | Delete a term. |

## Follow

Follow and unfollow blogs.

| **Resource** | **Description** |
|---|---|
| [GET/sites/$site/follows/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/follows/) | List a site’s followers in reverse chronological order. |
| [POST/sites/$site/follows/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/follows/new/) | Follow a blog. |
| [POST/sites/$site/follows/mine/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/follows/mine/delete/) | Unfollow a blog. |
| [GET/sites/$site/follows/mine](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/follows/mine/) | Get blog following status for the current user. |

## Sharing

Connect social media services to automatically share new posts and manage sharing buttons on a site.

| **Resource** | **Description** |
|---|---|
| [GET/sites/$site/sharing-buttons/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/sharing-buttons/) | Get a list of a site’s sharing buttons. |
| [POST/sites/$site/sharing-buttons](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/sharing-buttons/) | Edit all sharing buttons for a site. |
| [GET/meta/external-services/](https://developer.wordpress.com/docs/api/1.1/get/meta/external-services/) | Get a list of third-party services that WordPress.com or Jetpack sites can integrate with via keyring. |
| [GET/meta/external-services/$service](https://developer.wordpress.com/docs/api/1.1/get/meta/external-services/%24service/) | Get information about a single external service that WordPress.com or Jetpack sites can integrate with via keyring. |
| [GET/me/publicize-connections/](https://developer.wordpress.com/docs/api/1.1/get/me/publicize-connections/) | Get a list of publicize connections that the current user has set up. |
| [GET/me/publicize-connections/$publicize\_connection\_ID](https://developer.wordpress.com/docs/api/1.1/get/me/publicize-connections/%24publicize_connection_ID/) | Get a single publicize connection that the current user has set up. |
| [POST/me/publicize-connections/$publicize\_connection\_ID](https://developer.wordpress.com/docs/api/1.1/post/me/publicize-connections/%24publicize_connection_ID/) | Update a single publicize connection belonging to the current user. |
| [POST/me/publicize-connections/$publicize\_connection\_ID/delete](https://developer.wordpress.com/docs/api/1.1/post/me/publicize-connections/%24publicize_connection_ID/delete/) | Delete the specified publicize connection. |
| [GET/me/keyring-connections/](https://developer.wordpress.com/docs/api/1.1/get/me/keyring-connections/) | Get a list of all the keyring connections associated with the current user. |
| [GET/me/keyring-connections/$keyring\_connection\_ID](https://developer.wordpress.com/docs/api/1.1/get/me/keyring-connections/%24keyring_connection_ID/) | Get a single Keyring connection that the current user has setup. |
| [POST/me/keyring-connections/$keyring\_connection\_ID/delete](https://developer.wordpress.com/docs/api/1.1/post/me/keyring-connections/%24keyring_connection_ID/delete/) | Delete the Keyring connection (and associated token) with the provided ID. Also deletes all associated publicize connections. |
| [GET/sites/$site/publicize-connections/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/publicize-connections/) | Get a list of publicize connections that are associated with the specified site. |
| [GET/sites/$site/publicize-connections/$publicize\_connection\_ID](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/publicize-connections/%24publicize_connection_ID/) | Get a single publicize connection that is associated with the specified site. |
| [POST/sites/$site/publicize-connections/$publicize\_connection\_ID](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/publicize-connections/%24publicize_connection_ID/) | Update a single publicize connection belonging to the specified site. |
| [POST/sites/$site/publicize-connections/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/publicize-connections/new/) | Create a new publicize connection that is associated with the specified site. |
| [POST/sites/$site/publicize-connections/$publicize\_connection\_ID/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/publicize-connections/%24publicize_connection_ID/delete/) | Delete the specified publicize connection. |
| [GET/meta/sharing-buttons](https://developer.wordpress.com/docs/api/1.1/get/meta/sharing-buttons/) | Get a list of external services for which sharing buttons are supported. |

## Freshly Pressed

View Freshly Pressed posts from the WordPress.com homepage.

| **Resource** | **Description** |
|---|---|
| [GET/freshly-pressed/](https://developer.wordpress.com/docs/api/1.1/get/freshly-pressed/) | Get a list of Freshly Pressed posts. (Note: Freshly Pressed has been retired. Please visit [https://discover.wordpress.com](https://discover.wordpress.com/) to get the best content published across our network.) |

## Notifications

View and manage a user’s notifications.

| **Resource** | **Description** |
|---|---|
| [POST/notifications/seen](https://developer.wordpress.com/docs/api/1.1/post/notifications/seen/) | Set the timestamp of the most recently seen notification. |
| [POST/notifications/read](https://developer.wordpress.com/docs/api/1.1/post/notifications/read/) | Mark a set of notifications as read. |

## Insights

View analytics for your application.

| **Resource** | **Description** |
|---|---|
| [GET/insights](https://developer.wordpress.com/docs/api/1.1/get/insights/) | Get a list of stats/metrics/insights that the current user has access to. |
| [GET/insights/$slug](https://developer.wordpress.com/docs/api/1.1/get/insights/%24slug/) | Get raw data for a particular graph. |

## Reader

Manage and view a user’s subscriptions to the WordPress.com Reader.

| **Resource** | **Description** |
|---|---|
| [GET/read/menu/](https://developer.wordpress.com/docs/api/1.1/get/read/menu/) | Get default reader menu. |
| [GET/read/feed/$feed\_url\_or\_id](https://developer.wordpress.com/docs/api/1.1/get/read/feed/%24feed_url_or_id/) | Get details about a feed. |
| [GET/read/sites/$site/posts/$post\_ID](https://developer.wordpress.com/docs/api/1.1/get/read/sites/%24site/posts/%24post_ID/) | Get a single post (by ID). |
| [GET/read/following/](https://developer.wordpress.com/docs/api/1.1/get/read/following/) | Get a list of posts from the blogs a user follows. |
| [GET/read/liked/](https://developer.wordpress.com/docs/api/1.1/get/read/liked/) | Get a list of posts from the blogs a user likes. |
| [GET/read/tags/$tag/posts](https://developer.wordpress.com/docs/api/1.1/get/read/tags/%24tag/posts/) | Get a list of posts from a tag. |
| [GET/read/tags](https://developer.wordpress.com/docs/api/1.1/get/read/tags/) | Get a list of tags subscribed to by the user. |
| [GET/read/tags/alphabetic](https://developer.wordpress.com/docs/api/1.1/get/read/tags/alphabetic/) | Get a filtered list of top tags, grouped by letter. |
| [GET/read/trending/tags](https://developer.wordpress.com/docs/api/1.1/get/read/trending/tags/) | Get a list of trending tags. |
| [GET/read/tags/$tag](https://developer.wordpress.com/docs/api/1.1/get/read/tags/%24tag/) | Get details about a specified tag. |
| [GET/read/tags/$tag/mine](https://developer.wordpress.com/docs/api/1.1/get/read/tags/%24tag/mine/) | Get the subscribed status of the user to a given tag. |
| [POST/read/tags/$tag/mine/new](https://developer.wordpress.com/docs/api/1.1/post/read/tags/%24tag/mine/new/) | Subscribe to a new tag. |
| [POST/read/tags/$tag/mine/delete](https://developer.wordpress.com/docs/api/1.1/post/read/tags/%24tag/mine/delete/) | Unsubscribe from a tag. |
| [GET/read/following/mine](https://developer.wordpress.com/docs/api/1.1/get/read/following/mine/) | Get a list of the feeds the user is following. |
| [POST/read/following/mine/new](https://developer.wordpress.com/docs/api/1.1/post/read/following/mine/new/) | Follow the specified blog. |
| [POST/read/following/mine/delete](https://developer.wordpress.com/docs/api/1.1/post/read/following/mine/delete/) | Unfollow the specified blog. |
| [GET/read/feed/](https://developer.wordpress.com/docs/api/1.1/get/read/feed/) | Get the ID and subscribe URL of one or more matching feeds by domain or URL. |
| [GET/read/email-settings/](https://developer.wordpress.com/docs/api/1.1/get/read/email-settings/) | Returns the email settings |
| [POST/read/email-settings/](https://developer.wordpress.com/docs/api/1.1/post/read/email-settings/) | Returns the email settings |
| [GET/read/subscriptions-count/](https://developer.wordpress.com/docs/api/1.1/get/read/subscriptions-count/) | Returns the number of blog, comment and pending subscriptions. |
| [GET/read/recommendations/mine/](https://developer.wordpress.com/docs/api/1.1/get/read/recommendations/mine/) | Get a list of blog recommendations for the current user. |

## Stats

View stats for a site.

| **Resource** | **Description** |
|---|---|
| [GET/sites/$site/stats/highlights](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/highlights/) | View highlight metrics from the last seven days. |
| [GET/sites/$site/stats](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/) | Get a site’s stats |
| [GET/sites/$site/stats/summary](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/summary/) | View a site’s summarized views, visitors, likes and comments |
| [GET/sites/$site/stats/top-posts](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/top-posts/) | View a site’s top posts and pages by views |
| [GET/sites/$site/stats/video/$post\_id](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/video/%24post_id/) | View the details of a single video |
| [GET/sites/$site/stats/referrers](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/referrers/) | View a site’s referrers |
| [GET/sites/$site/stats/clicks](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/clicks/) | View a site’s outbound clicks |
| [GET/sites/$site/stats/tags](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/tags/) | View a site’s views by tags and categories |
| [GET/sites/$site/stats/top-authors](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/top-authors/) | View a site’s top authors |
| [GET/sites/$site/stats/comments](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/comments/) | View a site’s top comment authors and most-commented posts |
| [GET/sites/$site/stats/video-plays](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/video-plays/) | View a site’s video plays |
| [GET/sites/$site/stats/file-downloads](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/file-downloads/) | View a site’s file downloads |
| [GET/sites/$site/stats/post/$post\_id](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/post/%24post_id/) | View a post’s views |
| [GET/sites/$site/stats/country-views](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/country-views/) | View a site’s views by country |
| [GET/sites/$site/stats/followers](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/followers/) | View a site’s followers |
| [GET/sites/$site/stats/comment-followers](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/comment-followers/) | View a site’s comment followers |
| [POST/sites/$site/stats/referrers/spam/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/stats/referrers/spam/new/) | Report a referrer as spam |
| [POST/sites/$site/stats/referrers/spam/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/stats/referrers/spam/delete/) | Unreport a referrer as spam |
| [GET/sites/$site/stats/publicize](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/publicize/) | View a site’s publicize follower counts |
| [GET/sites/$site/stats/search-terms](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/search-terms/) | View search terms used to find the site |
| [GET/sites/$site/stats/views/posts](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/views/posts/) | View the total number of views for each post. |
| [GET/sites/$site/stats/emails/summary](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/emails/summary/) | View the total number of email opens and clicks for each post. |
| [GET/sites/$site/stats/opens/emails/summary](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/opens/emails/summary/) | View the total number of email opens for each post. |
| [GET/sites/$site/stats/opens/emails/$post\_id](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/opens/emails/%24post_id/) | View multiple stats related to email opens by post. |
| [GET/sites/$site/stats/opens/emails/$post\_id/client](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/opens/emails/%24post_id/client/) | View email opens stats by client. |
| [GET/sites/$site/stats/opens/emails/$post\_id/country](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/opens/emails/%24post_id/country/) | View email opens stats by country. |
| [GET/sites/$site/stats/opens/emails/$post\_id/device](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/opens/emails/%24post_id/device/) | View email opens stats by device. |
| [GET/sites/$site/stats/opens/emails/$post\_id/rate](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/opens/emails/%24post_id/rate/) | View email opens rate by post. |
| [GET/sites/$site/stats/clicks/emails/$post\_id](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/clicks/emails/%24post_id/) | View chart stats related to email clicks by period. |
| [GET/sites/$site/stats/clicks/emails/$post\_id/rate](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/clicks/emails/%24post_id/rate/) | View email clicks rate by post. Returns mock data. |
| [GET/sites/$site/stats/clicks/emails/$post\_id/country](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/clicks/emails/%24post_id/country/) | View email clicks by country. |
| [GET/sites/$site/stats/clicks/emails/$post\_id/device](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/clicks/emails/%24post_id/device/) | View email clicks by device. |
| [GET/sites/$site/stats/clicks/emails/$post\_id/client](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/clicks/emails/%24post_id/client/) | View email clicks by client. |
| [GET/sites/$site/stats/clicks/emails/$post\_id/link](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/clicks/emails/%24post_id/link/) | View email clicks by link. |
| [GET/sites/$site/stats/clicks/emails/$post\_id/user-content-link](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/clicks/emails/%24post_id/user-content-link/) | View email clicks by user content link. |
| [GET/sites/$site/stats/clicks/emails/summary](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/clicks/emails/summary/) | View the total number of email clicks for each post. |
| [GET/sites/$site/stats/utm/$utm\_param\_name](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/utm/%24utm_param_name/) | Fetch site’s UTM param statistics. |
| [GET/sites/$site/stats/utm/$utm\_param\_name/top\_posts](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/utm/%24utm_param_name/top_posts/) | Fetch top posts for a given UTM parameter value. |
| [GET/sites/$site/stats/streak](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/stats/streak/) | Get stats for Calendar Heatmap. Returns data with each post timestamp. |

## Media

Manage a site’s media library.

| **Resource** | **Description** |
|---|---|
| [POST/sites/$site/media/$media\_ID/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/media/%24media_ID/delete/) | Delete a piece of media. Note: Media is deleted and not trashed. |
| [GET/sites/$site/media/$media\_ID](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/media/%24media_ID/) | Get a single media item (by ID). |
| [POST/sites/$site/media/$media\_ID](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/media/%24media_ID/) | Edit basic information about a media item. |
| [GET/sites/$site/media/](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/media/) | Get a list of items in the media library. |
| [POST/sites/$site/media/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/media/new/) | Upload a new piece of media. |
| [POST/sites/$site/media/$media\_ID/edit](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/media/%24media_ID/edit/) | Edit a media item. |

## Menus

View and manage a site’s menus.

| **Resource** | **Description** |
|---|---|
| [POST/sites/$site/menus/new](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/menus/new/) | Create a new navigation menu. |
| [POST/sites/$site/menus/$menu\_id](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/menus/%24menu_id/) | Update a navigation menu. |
| [GET/sites/$site/menus/$menu\_id](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/menus/%24menu_id/) | Get a single navigation menu. |
| [GET/sites/$site/menus](https://developer.wordpress.com/docs/api/1.1/get/sites/%24site/menus/) | Get a list of all navigation menus. |
| [POST/sites/$site/menus/$menu\_id/delete](https://developer.wordpress.com/docs/api/1.1/post/sites/%24site/menus/%24menu_id/delete/) | Delete a navigation menu |

## Batch

Batch several API GET requests into one.

| **Resource** | **Description** |
|---|---|
| [GET/batch/](https://developer.wordpress.com/docs/api/1.1/get/batch/) | Run several GET endpoints and return them as an array. |

## Videos

View video information.

| **Resource** | **Description** |
|---|---|
| [GET/videos/$guid](https://developer.wordpress.com/docs/api/1.1/get/videos/%24guid/) | Get the metadata for a specified VideoPress video. |
| [GET/videos/$guid/poster](https://developer.wordpress.com/docs/api/1.1/get/videos/%24guid/poster/) | Get the poster for a specified VideoPress video. |
| [POST/videos/$guid/poster](https://developer.wordpress.com/docs/api/1.1/post/videos/%24guid/poster/) | Upload and set a poster for a specified VideoPress video. |
| [GET/videos/$guid/chapters](https://developer.wordpress.com/docs/api/1.1/get/videos/%24guid/chapters/) | Get the chapters for a specified VideoPress video. |
| [GET/videos/$guid/playlist/$format](https://developer.wordpress.com/docs/api/1.1/get/videos/%24guid/playlist/%24format/) | Get the poster for a specified VideoPress video. |
| [POST/videos/$guid/tracks](https://developer.wordpress.com/docs/api/1.1/post/videos/%24guid/tracks/) | Upload a subtitle/caption track for a specified VideoPress video. |
| [POST/videos/$guid/tracks/delete](https://developer.wordpress.com/docs/api/1.1/post/videos/%24guid/tracks/delete/) | Delete an existing subtitle/caption track for a specified VideoPress video. |

## Agencies

Manage agency sites and tools.

| **Resource** | **Description** |
|---|---|
| [GET /wpcom/v2/agency/$agency\_id/sites](https://developer.wordpress.com/docs/api/2/get/agency/$agency_id/sites/) | Get a list of sites managed by the agency. |
| [GET/wpcom/v2/agency/$agency\_id/sites/pending](https://developer.wordpress.com/docs/api/2/get/agency/$agency_id/sites/pending/) | Get a list of sites that are available for provision. |
| [POST/wpcom/v2/agency/$agency\_id/sites/$site\_id/provision](https://developer.wordpress.com/docs/api/2/post/agency/$agency_id/sites/$site_id/provision/) | Provision of a new site for the agency. |
| [GET/wpcom/v2/sites/$wpcom\_site/staging-site](https://developer.wordpress.com/docs/api/2/get/sites/$wpcom_site/staging-site/) | Retrieves the staging site associated with a specified production site. |
| [POST/wpcom/v2/sites/$wpcom\_site/staging-site](https://developer.wordpress.com/docs/api/2/post/sites/$wpcom_site/staging-site/) | Creates a [staging site](https://wordpress.com/support/how-to-create-a-staging-site/) for an existing site. |
| [DELETE/wpcom/v2/sites/$wpcom\_site/staging-site/$staging\_site\_id](https://developer.wordpress.com/docs/api/2/delete/sites/$wpcom_site/staging-site/$staging_site_id/) | Deletes the staging site associated with the specified production site. |
| [GET/sites/$site/automated-transfers/status](https://developer.wordpress.com/docs/api/1.1/get/sites/$site/automated-transfers/status/) | Returns the current status of Automated Transfer for a site. |

## GitHub Deployments

Deploy code on WordPress.com infrastructure.

| **Resource** | **Description** |
|---|---|
| [GET/hosting/github/installations](https://developer.wordpress.com/docs/api/2/get/hosting/github/installations/) | Return a list of installations that a GitHub user has access to through app installations. |
| [GET/hosting/github/repositories](https://developer.wordpress.com/docs/api/2/get/hosting/github/repositories/) | Get a list of repositories and their external\_repository\_ids. |
| [GET/sites/$wpcom\_site/hosting/code-deployments](https://developer.wordpress.com/docs/api/2/get/sites/$wpcom_site/hosting/code-deployments/) | Get a list of site code deployments configured for this site. |
| [POST/sites/$wpcom\_site/hosting/code-deployments](https://developer.wordpress.com/docs/api/2/post/sites/$wpcom_site/hosting/code-deployments/) | Create or update a deployment configuration for this site. |
| [DELETE/wpcom/v2/sites/$wpcom\_site/hosting/code-deployments/$deployment\_id](https://developer.wordpress.com/docs/api/2/delete/sites/$wpcom_site/hosting/code-deployments/$deployment_id/) | Delete a deployment configuration for a site. |
| [GET/wpcom/v2/sites/$wpcom\_site/hosting/code-deployments/$deployment\_id/runs](https://developer.wordpress.com/docs/api/2/get/sites/$wpcom_site/hosting/code-deployments/$deployment_id/runs/) | Get code deployment runs. |
| [POST/sites/$wpcom\_site/hosting/code-deployments/$deployment\_id/runs](https://developer.wordpress.com/docs/api/2/post/sites/$wpcom_site/hosting/code-deployments/$deployment_id/runs/) | Initiate a manual deployment run of a code using its deployment\_id. |
| [GET/sites/$wpcom\_site/hosting/code-deployments/$deployment\_id/](https://developer.wordpress.com/docs/api/2/get/sites/$wpcom_site/hosting/code-deployments/$deployment_id/runs/$deployment_run_id/logs/) [runs/$deployment\_run\_id/logs](https://developer.wordpress.com/docs/api/2/get/sites/$wpcom_site/hosting/code-deployments/$deployment_id/runs/$deployment_run_id/logs/) | Get the logs for a deployment run of a code using its deployment\_id and deployment\_run\_id. |

## SSH Management

Create and manage SSH access to WordPress.com servers.

| **Resource** | **Description** |
|---|---|
| [GET/wpcom/v2/sites/$wpcom\_site/hosting/ssh-users](https://developer.wordpress.com/docs/api/2/get/sites/$wpcom_site/hosting/ssh-users/) | Get SSH users for a site. |
| [POST/wpcom/v2/sites/$wpcom\_site/hosting/ssh-user](https://developer.wordpress.com/docs/api/2/post/sites/$wpcom_site/hosting/ssh-user/) | Create an SSH user for a site. |
| [POST/wpcom/v2/sites/$wpcom\_site/hosting/ssh-user/$ssh\_user/reset-password](https://developer.wordpress.com/docs/api/2/post/sites/$wpcom_site/hosting/ssh-user/$ssh_user/reset-password/) | Rotate the SSH user password and return it. |
| [GET/wpcom/v2/sites/$wpcom\_site/hosting/ssh-access](https://developer.wordpress.com/docs/api/2/get/sites/$wpcom_site/hosting/ssh-access/) | Gets the SSH access setting type for a site. |
| [POST/wpcom/v2/sites/$wpcom\_site/hosting/ssh-access](https://developer.wordpress.com/docs/api/2/post/sites/$wpcom_site/hosting/ssh-access/) | Sets the SSH access setting for a site. |
| [GET/wpcom/v2/sites/$wpcom\_site/hosting/ssh-keys](https://developer.wordpress.com/docs/api/2/get/sites/$wpcom_site/hosting/ssh-keys/) | Get SSH keys for a site. |
| [POST/wpcom/v2/sites/$wpcom\_site/hosting/ssh-keys](https://developer.wordpress.com/docs/api/2/post/sites/$wpcom_site/hosting/ssh-keys/) | Attach a new SSH key to a site. |
| [DELETE/wpcom/v2/sites/$wpcom\_site/hosting/ssh-keys/$user\_name/$name](https://developer.wordpress.com/docs/api/2/delete/sites/$wpcom_site/hosting/ssh-keys/$user_name/$name/) | Detach an SSH key from a site. |
