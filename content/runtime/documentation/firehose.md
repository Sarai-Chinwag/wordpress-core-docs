---
type: document
title: WordPress.com Firehose
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/firehose/"
tags:
timestamp: "2026-06-16T19:29:26+00:00"
wordpress:
  id: 2488
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:26"
  date_gmt: "2026-06-16 19:29:26"
  modified: "2026-06-16 19:29:26"
  modified_gmt: "2026-06-16 19:29:26"
  slug: firehose
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/firehose/"
  comment_count: 0
---

WordPress publishers and visitors produce [thousands of new posts and comments every hour](https://wordpress.com/stats/posting/). These content streams are available in three real-time formats from redundant servers. These streams are intended for partners like search engines, artificial intelligence (AI) products and market intelligence providers who would like to ingest a real-time stream of new content from a wide spectrum of publishers.

## Feeds

- **Posts Firehose:** the Posts Firehose is a stream of posts—averaging 1 million/day—from the tens of millions of websites published on WordPress.com. Posts are also available for Jetpack-powered WordPress(.org) sites, through a separate feed.
- **Comments Firehose:** the Comments Firehose streams hundreds of thousands of comments every day from WordPress.com. Comments are also available for Jetpack-powered WordPress(.org) sites, through a separate feed.
- **Likes Firehose:** the Likes Firehose streams engagement data from WordPress.com’s [“like” feature](https://wordpress.com/support/likes/).

## Feed Formats

- **PubSub:** An extension of the popular Jabber/[XMPP](https://xmpp.org/) instant messaging protocol. WordPress.com operates a Jabber service at [im.wordpress.com](https://im.wordpress.com/) that allows all WordPress.com users to subscribe to the blogs of their choice and receive instant notification of new items. However, the full streams are access-controlled.
- **JSON Stream:** A stream of JSON formatted data delivered over HTTP. You can view a very limited sample stream by using `curl` in a terminal:
    - Posts: `curl xmpp.wordpress.com:8008/posts.json`
    - Comments: `curl xmpp.wordpress.com:8008/comments.json`
- **XML Stream:** Delivers the same pubsub-style XML streams by the much simpler mechanism of an HTTP GET request. This makes implementing the streams as simple as can be. You can view a very limited sample stream by using `curl` in a terminal:
    - Posts: `curl xmpp.wordpress.com:8008/firehose.xml`
    - Comments: `curl xmpp.wordpress.com:8008/gusher.xml`

## Firehose Terms of Service

By using Firehose or accessing Firehose data, you agree to these terms and all other operating rules, policies, and procedures that may be published from time to time by Automattic (collectively, the “Agreement”). This Agreement contains, among other things, warranty disclaimers, and liability limitations.

**Permitted Uses.** You may use Firehose to search, display, analyze, retrieve, and view the data provided to you through the Firehose. You may also use the WordPress.com name or logos and other brand elements that Automattic makes available in order to identify the source of the information, provided the use doesn’t suggest any endorsement by Automattic. You agree to comply with all applicable privacy laws and regulations, and will post and adhere to a privacy policy that does not modify, supersede, or be inconsistent with the [Automattic Privacy Policy](https://automattic.com/privacy/).

**Prohibited Uses.** If you use Firehose, you agree not to:

- Engage in, encourage, or facilitate activity that is malicious or illegal under applicable law.
- Interfere with, disrupt, or attack any service or network, including Automattic’s.
- Republish the content, provide any third parties with access to Firehose or Firehose data, or enable any third parties to distribute Firehose data.
- Substantially replicate products or services offered by Automattic, or create a competing service, such as by creating a separate publishing platform.
- Display, distribute, or otherwise make available content or data to governmental entities for intelligence gathering or surveillance purposes.
- Use the information in a biased, misleading, or dishonest manner, for example, to promote or publicize a biased political point of view.
- Modify, decompile, reverse engineer, or otherwise alter or seek to derive the trade secrets and other inherent intellectual property of the Automattic APIs.
- Use the Firehose or Firehose Data to (i) to create or enable any app, website, tool, or other mechanism that is, or enables, or operates in conjunction with, any malware, spyware, adware, other malicious programs or code, or (ii) in any manner that would violate any applicable law or governmental regulation.
- Cache or store personal data or user passwords.
- Use Firehose content or data to profile, or create profiles of, individuals, or directly target individuals with advertisements or other messages.

**Suspension.** If Automattic believes, in its sole discretion, that you have violated or attempted to violate this Agreement, your ability to use and access Firehose may be temporarily or permanently revoked, with or without notice.

**Account.** You will be solely responsible and liable for any activity that occurs under your account. You are responsible for keeping your login and password secure.

**No Warranties.** Automattic makes no, and expressly disclaims any, representations or warranties, whether express or implied, regarding Firehose or the content provided via Firehose. This disclaimer includes disclaimer of warranties of fitness for a particular purpose, non infringement, and that its products will be uninterrupted or error-free.

**Intellectual Property.** This Agreement does not transfer from Automattic to you any Automattic or third party intellectual property, and all right, title, and interest in and to such property will remain (as between the parties) solely with Automattic. During the term of this Agreement, and subject to the terms and conditions herein, Automattic grants you a limited, non-exclusive, non-transferable license to access and use Firehose data.

**Liability.** In no event will Automattic be liable with respect to any subject matter of this Agreement under any contract, negligence, strict liability, or other legal or equitable theory for: (i) the cost of procurement for substitute products or services; (ii) interruption of use or loss or corruption of data; or (iii) for any amounts that exceed the fees paid by you to Automattic under this Agreement during the twelve (12) month period prior to the cause of action. Neither party shall be liable under this Agreement for any incidental or consequential damages.

**Changes.** We may make modifications to the Firehose service that do not materially degrade your level of service. We may also make changes to the pricing or other terms under which we offer the service. If we make changes that are material, we will let you know by sending you an email or other communication before the changes take effect, which shall be no earlier than the next Renewal Period. Your continued use of the Service will be subject to the new terms.

**Jurisdiction and Applicable Law.** This Agreement and any access to or use of the Service will be governed by the laws of the state of California, excluding its conflict of law provisions. The venue for any disputes arising out of or relating to this Agreement or the Service will be the state and federal courts located in San Francisco County, California.
