---
type: document
title: WordPress.com store SaaS billing flow
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/wordpress-com-store-saas-billing-flow/"
tags:
timestamp: "2026-06-16T19:29:21+00:00"
wordpress:
  id: 2449
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:21"
  date_gmt: "2026-06-16 19:29:21"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: wordpress-com-store-saas-billing-flow
  parent: 2456
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/wordpress-com-store-saas-billing-flow/"
  comment_count: 0
---

WordPress.com Store’s Billing Flow enables vendors to sell subscriptions for their SaaS products on WordPress.com Store, via our in-house billing and subscription system. WordPress.com Store’s Billing API supports recurring payments.

## The purchase flow

The customer must go through the vendor application to select a specific plan. The following is the SaaS product subscription creation event life cycle:

![](https://lh3.googleusercontent.com/SMc-9X40IrmM6iR1OKzedr1wKWGvIIadY_ca6ysD5_4l4ADJbqUmSRlqekZyHF-BitXvBiflbqCRl9SqkrsA-99ye37lNms48hdo9fuF-o-XkVlfFkxP2lHr5uESHcdQ2ezkx8D1_dhGAIEqxdpJPwG052rak2Qb_471R0vEDfkNM83xA8vAFSmEEw)

### 1. The customer follows a link from a WordPress.com Store plugin page and lands on the vendor application

The flow starts when a customer visits the WordPress.com Store plugin page. At this stage, customers are already authenticated in WordPress.com. The customer is redirected to the Vendor Application by clicking on the buy now button on the listing page. The Vendor Application landing page will receive additional GET parameters to facilitate the purchase flow like customer and site identifiers.

The GET parameter is called `uuid`. It comprises two sections: the user id and blog id, separated by a + symbol. The user id is always the first part, and the site id is the second part.

If there are several plans available in the vendor application, the vendor can have the customers choose one before initiating the purchase. The vendor application may also decide to not show the customer anything and initiate the purchase immediately, as described in the next step.

### 2. Create billing intent

The vendor application needs to make an API call to WordPress.com’s API with the subscription plan information. It will receive a checkout URL in the response. Please review the API documentation for more details.

The subscription plan information includes the plan name, price, billing period, billing interval, and a return URL. The return URL is a URL in the vendor application where WordPress.com will redirect the customer after they complete the purchase on WordPress.com.

The vendor application needs to redirect customers to the checkout URL for them to confirm and pay for the subscription. The checkout URL is the shopping cart page on WordPress.com and it will have the subscription plan pre-filled when a customer visits it.

The response of the billing intent from WordPress.com API contains a unique billing intent id, which the vendor can use to associate the subscription with the vendor application’s internal customer ID. Please review the API documentation for more details.

If the vendor initiates the purchase immediately when the customer lands on the application and then redirects to WordPress.com checkout URL during the same request, the operation will take less than a few seconds to complete. The experience for the customer is seamless as if they never left WordPress.com.

### 3. Customer confirms the purchase

After the vendor application redirects the customer to the checkout URL on WordPress.com, the customer will have to confirm and pay for the subscription. The customer goes through a familiar checkout experience, with all the necessary payment information pre-filled if they’ve purchased from WordPress.com before.

### 4. Customer is redirected to the vendor application

After the customer completes the purchase, they are redirected to the return URL provided by the vendor while creating the billing intent in the previous steps. If the vendor application hasn’t already signed up the customer, it can do it in this phase. The return URL passes the billing intent id in a GET parameter, so the vendor application can associate it with the internal customer ID.

At this point, WordPress.com also makes a webhook call to the webhook URL provided by the vendor. Please review the API documentation for more details.

In most cases, the webhook will be sent before the customer is redirected to the vendor application. But in some cases, the customers will be redirected to the page before the webhook event is received by the vendor application due to the asynchronous operations.

## API Documentation

API reference: [https://developer.wordpress.com/wordpress-com-marketplace/vendor-apis/](https://developer.wordpress.com/wordpress-com-marketplace/vendor-apis/#http-api)
