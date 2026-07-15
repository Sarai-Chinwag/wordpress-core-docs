---
type: document
title: Tools Erase Personal Data screen
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/tools-erase-personal-data-screen/"
tags:
timestamp: "2026-06-16T19:29:01+00:00"
wordpress:
  id: 2348
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:01"
  date_gmt: "2026-06-16 19:29:01"
  modified: "2026-06-16 19:29:01"
  modified_gmt: "2026-06-16 19:29:01"
  slug: tools-erase-personal-data-screen
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/tools-erase-personal-data-screen/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

WordPress 4.9.6 included a feature to delete a user’s personal data upon verified request. Deleted data is permanently removed from the database. Erasure requests cannot be reversed after they have been confirmed.

Note: Erase Personal Data tool does not remove the data from backups or archive files: When using the tool alongside automated backups or archives, we advise you to exercise caution when restoring user data from backups. When restoring an archived copy of your site, your requests for erasure should be respected.

Note: As this tool ONLY gathers data from WordPress and participating plugins, you may need to go beyond to comply with delete requests.

## Using Erase Personal Data tool

### Basic Usage

Erase Personal Data tool uses email validation to send a user’s request to an administrator.

1\. Select **Tools** -&gt; **Erase Personal Data** from Administration Screens.

[![](https://i2.wp.com/wordpress.org/documentation/files/2019/02/ErasePersonalData_4.9.6.jpg?fit=1121%2C707&ssl=1)](https://wordpress.org/support/?attachment_id=11181157)Erase Personal Data Screen2\. Specify Username or email address and click **Send Request**.
 If Confirmation request initiated successfully, the request will be shown in below table and **Status** will be *Pending*.

[![](https://i1.wp.com/wordpress.org/documentation/files/2019/02/ErasePersonalData_4.9.6_pending.jpg?fit=937%2C259&ssl=1)](https://wordpress.org/support/?attachment_id=11181173)Waiting ConfirmationUser will receive the following mail titled ‘\[&lt;site\_name&gt;\] Confirm Action: Erase Personal Data’.

```
Howdy,

A request has been made to perform the following action on your account:

     Erase Personal Data

To confirm this, please click on the following link:
https://<site_address>/wp-login.php?action=confirmaction&request_id=120&confirm_key=4Ouy5xJDptm4aLwcJIAA

You can safely ignore and delete this email if you do not want to
take this action.

This email has been sent to atachibana@unofficialtokyo.com.

Regards,
All at <site_name>
http://<site_address>/
```

3\. If user click link in the mail, below dialog box is shown.

[![](https://i2.wp.com/wordpress.org/documentation/files/2019/02/ErasePersonalData_4.9.6_confirmation.jpg?fit=400%2C408&ssl=1)](https://wordpress.org/support/?attachment_id=11181182)At the same time, the Status of Request will be changed to *Confirmed*, and **Next Steps** shows **Erase Personal Data** button.

[![](https://i1.wp.com/wordpress.org/documentation/files/2019/02/ErasePersonalData_4.9.6_confirmed.jpg?fit=939%2C247&ssl=1)](https://wordpress.org/support/?attachment_id=11181190)Confirmed – Erase Personal DataIf user didn’t confirm the request, the Status will be “failed”. You may resend the request.

4\. Click **Erase Personal Data**.
 **Status** will be changed to *Completed*, and **Next Steps** displays **Remove request** button.

Notice: There are no confirmation prompt. Clicking the button means erasing the data.

[![](https://i1.wp.com/wordpress.org/documentation/files/2019/02/ExportPersonalData_4.9.6_completed.jpg?fit=881%2C252&ssl=1)](https://wordpress.org/support/?attachment_id=11181199)Remove Request6\. Click **Remove request**. The request will be removed.

Notice: There are no ‘Trash’ status such as Posts’.

### Forcing of Erasing Personal Data

You can force to erase Personal Data from popup menu **Force Erase Personal Data**.

1. Move mouse cursor on the Requester’s mail address in the Requester Table.
2. Click **Force Erase Personal Data**.

[![](https://i2.wp.com/wordpress.org/documentation/files/2019/02/ErasePersonalData_4.9.6_forceerase.jpg?fit=938%2C257&ssl=1)](https://wordpress.org/support/?attachment_id=11181207)Force Erase Personal DataStatus of Request will be changed to *Completed*, and **Next Steps** shows **Remove request** button.

Notice: Even in the *Pending* status, you can force to erase Personal Data.

### Filtering Request

You can filter requests by Status or Requester’s mail address.

To Filter by Status

- Click **All**, **Pending**, **Confirmed**, **Failed** and **Completed** above Requester Table.

To Filter by Requester’s email address

- Insert full or part of email address in the box above Requester Table, and Click **Search Results**

### Removing Request

You can get rid of request from Requester Table. It does not remove Personal Data.

1. Select checkbox of the Request that you want to remove.
2. Select **Remove** from **Bulk Actions** dropdown box and click **Apply**.

### Resending the mail

1. Select checkbox of the Request that you want to resend the mail.
2. Select **Resend email** from **Bulk Actions** dropdown box and click **Apply**.

## Erased Personal Data

To confirm what data will be erased by this tool, Go to **Tools** &gt; **Export Personal Data** from Administration Screens, and export Personal data.
