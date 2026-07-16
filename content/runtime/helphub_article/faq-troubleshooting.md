---
type: document
title: FAQ Troubleshooting
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/faq-troubleshooting/"
tags:
timestamp: "2026-06-16T19:29:09+00:00"
wordpress:
  id: 2395
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:09"
  date_gmt: "2026-06-16 19:29:09"
  modified: "2026-06-16 19:29:09"
  modified_gmt: "2026-06-16 19:29:09"
  slug: faq-troubleshooting
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/faq-troubleshooting/"
  comment_count: 0
  terms:
    category:
      - faqs
      - wordpress-overview
---

**Important:** Please note that this is not a support page. If you seek help with your specific problem, please refer to the [Support forums](https://wordpress.org/support/welcome/).

Also refer [Common WordPress Errors](/support/article/common-wordpress-errors/) for the most common WordPress errors experienced by WordPress users such as

- The White Screen
- Internal Server Error
- Error Establishing Database Connection
- Failed Auto-Upgrade
- Connection Timed Out
- Maintenance Mode Following Upgrade
- PHP errors or MySQL DB errors

## How to deactivate all plugins when not able to access the administrative menus?

Sometimes it may be necessary to deactivate all plugins, but you can’t access the Administration Screens to do so. One of two methods are available to deactivate all plugins.

Use [phpMyAdmin](/support/article/phpmyadmin/) to deactivate all plugins.

1. In the table wp\_options, under the *option\_name* column (field) find the *active\_plugins* row
2. Change the *option\_value* field to: **a:0:{}**

Or reset your plugins folder via [FTP](/support/article/ftp-clients/) or the file manager provided in your host’s control panel. This method preserves plugin options but requires plugins be manually reactivated.

1. Via FTP or your host’s file manager, navigate to the wp-contents folder (directory)
2. Via FTP or your host’s file manager, rename the folder “plugins” to “plugins.hold”
3. Login to your WordPress administration plugins page (/wp-admin/plugins.php) – this will disable any plugin that is “missing”.
4. Via FTP or your host’s file manager, rename “plugins.hold” back to “plugins”

## How to clear the “Briefly unavailable for scheduled maintenance” message after doing automatic upgrade?

As part of the automatic upgrade WordPress places a file named `.maintenance` in the blog **base** folder (folder that contains the wp-admin folder). If that file exists, then vistors will see the message **Briefly unavailable for scheduled maintenance. Check back in a minute.**

To stop that message from being displayed to vistors, just delete the `.maintenance` file. The automatic upgrade should be executed again, just in case it failed.

## An update was just released, so why does my blog not recognize the update is available?

When an update is released, notification of that release is displayed at the top administration screens saying **WordPress x.x.x is available! Please update now.** Not every blog will see that message at the same time. Your blog is programmed to check for updates every 12 hours, but the timing of that check is purely random. So if your blog just checked for updates minutes before an update was released, you won’t see the update message until your blog checks for updates 12 hours later.

If you want your blog to check right now for updates, you can delete the **update\_core** option name record in your *wp\_options* table. Note that plugins and themes each have their own check and update cycle, controlled by the records **update\_plugins** and **update\_themes**, in *wp\_options*.

Relevant discussion thread:

- <https://wordpress.org/support/topic/242485>

## Why did I lose custom changes to the WordPress Default Theme during the last automatic upgrade?

A core upgrade copies all the new files from the distribution over the old ones, so if you changed existing files in the WordPress default theme (e.g. *wp-content/themes/twentysixteen/style.css*), those changes got overwritten with the new version of that file.

Please note, a core upgrade goes through a list of “old files”, as defined in *wp-admin/includes/update-core.php*, and deletes those files. Any files not on the list, and not in the distribution, are preserved.

**Remember, that before upgrades, whether automatic or manual, both the WordPress Files and database should be backed-up as explained in [WordPress Backups](/support/article/wordpress-backups/).**

A better way to modify the default theme is by using a [child theme](<https://codex.wordpress.org/Child Themes>). It’s a little more work to set up, but worth the effort because your customizations will be safe when the main theme is updated.

## How do you repair a MySQL database table?

Every once in a while, it may be necessary to repair one or more MySQL database tables. According to the [How to Repair MyISAM Tables at dev.mysql.com](https://dev.mysql.com/doc/refman/8.0/en/myisam-repair.html) there are a number of reasons to repair a table including errors such as “tbl\_name.frm is locked against change”, “Can’t find file tbl\_name.MYI (Errcode: nnn)”, “Unexpected end of file”, “Record file is crashed”, or “Got error nnn from table handler”.

Here are the steps to repair a table in a MySQL database using [phpMyAdmin](/support/article/phpmyadmin/):

1. Login to hosting account.
2. Login to [phpMyAdmin](/support/article/phpmyadmin/).
3. Choose the affected database. If you only have one database, it should choose it by default so you don’t need to do anything.
4. In the main panel, you should see a list of your database tables. Check the boxes by the tables that need repair.
5. At the bottom of the window just below the list of tables, there is a drop down menu. Choose “Repair Table”

Remember, that it is advisable to have a current backup of your database at all times. See also [WordPress Backups](/support/article/wordpress-backups/)

## How do I empty a database table?

Refer [Emptying a Database Table](<https://codex.wordpress.org/Emptying a Database Table>)

## Emailed passwords are not being received

**Description:** When users try to register with your blog or change their passwords by entering their username and/or email, WordPress indicates that their password has been emailed to them, but it is never received.

**Reason and Solutions:** WordPress uses the standard PHP mail() function, which uses sendmail. No account information is needed. This is not generally a problem if you are using a hosting service, but if you are using your own box and do not have an SMTP server, the mail will never send. If you are using a \*NIX box, you should have either postfix or sendmail on your machine; you will just need to set them up (search the Internet for how-to’s). If you do not want to go through setting up a complete mail server on your \*NIX box you may find msmtp useful — it provides *“A secure, effective and simple way of getting mail off a system to your mail hub”*. On a Windows machine, try a sendmail emulator like [Glob SendMail](http://glob.com.au/sendmail/).

More help can be found on this thread of the WordPress Support Forums: <https://wordpress.org/support/topic.php?id=24981>.

**Windows Host Server Specific:** Check your “Relay” settings on the SMTP Virtual Server. Grant access to `127.0.0.1` . Then in your *php.ini*file, set the `SMTP` setting to the same IP address. Also set `smtp_port` to `25`.

**Ensure Proper Return Address is Used:** By default, the WordPress mailer fills in the From: field with *wordpress@yourdomain.com* and the From: name as *WordPress*.

This is fine if this is a valid e-mail address. For example, if your real e-mail is *wordpress@yourdomain.com*, your host should pass the email on for delivery. It will probably send your mail as long as *yourdomain.com* is setup to send and receive mail, even if *wordpress* is not a valid mail box. But if you set you real email as the From: address and it’s something like *wpgod@gmail.com*, the mail may not send because *gmail.com* is not a domain handled by the mail server.

**Treated as Spam:** Your email message may have been routed to a spam folder or even worse, simply discarded as malicious. There are a couple measures you can use to convince recipient’s mail servers that your message is legitimate and should be delivered as addressed.

**SPF:** (Sender Policy Framework) This is the most common anti-spam measure used. If you are on a hosted system, there is a good chance your host has set this up for the mail server you are using. Have WordPress email you and check the message headers for evidence that the message passed the SPF check. You can get a message sent by following the Forgot Password link on the login page. To keep your old password, do not follow the link in the message.
If your system email failed the SPF check, you can set up the credentials if you have access to your DNS records and your mail server’s domain belongs to you. Check the return path of the email your system sent. If the mail server listed there has your domain name, you can set up SPF credentials. There are several how-tos on the Internet.

**DKIM:** (Domain Key Identified Mail) This system is also used. You can use both SPF and DKIM in the same message. Again, just as with SPF, you can check if your receiving mailserver verified your host’s domain key by examining the mail header. There is a fair chance no signature key was provided, indicating your host chose to not use this protocol. Also as with SPF, if you can edit your DNS records and the mail server belongs to your domain, you can set up DKIM credentials yourself. Some how-tos exist if you search the Internet.

## Why can’t I see my posts? All I see is *Sorry, no posts match your criteria*?

Clearing your browser cache and cookies may resolve this problem. See also [I Make Changes and Nothing Happens](<https://codex.wordpress.org/I Make Changes and Nothing Happens>)

## How do I solve the *Headers already sent* warning problem?

**Description:** You got a warning message on your browser that says:

```
Warning: Cannot modify header information - headers already sent by
(output started at
```

**Reason and Solution:**

It is usually because there are spaces, new lines, or other stuff before an opening `<?php` tag or after a closing `?>` tag, typically in **wp-config.php**. This can also happen in other edited PHP files that are not theme templates, so please check the error message, as it will list the specific file name where the error occurred (see “Interpreting the Error Message” below). Replacing the faulty file with one from your most recent backup or one from a fresh WordPress download is your best bet, but if neither of those are an option, please follow the steps below.

Just because you cannot see anything does not mean that PHP sees the same.

1. Download the file mentioned in the error message via [FTP](/support/article/ftp-clients/) or the file manager provided in your host’s control panel.
2. Open that file in a [plain text editor](/support/article/glossary#text-editor) (**NOT** Microsoft Word or similar. Notepad or BBEdit are fine).
3. Check that the *very* first characters are with no blank lines or spaces after it.
4. Before saving, or use the Save as dialog, ensure the file encoding is not **`UTF-8 BOM`** but plain **`UTF-8`** or any without the **`BOM`** suffix.

To be sure about the end of the file, do this:

1. Place the cursor between the ? and &gt;
2. Now press the DELETE key on your computer **Note to MAC users**: The “DELETE” key on a PC deletes characters to the *right* of the cursor. That is the key noted here.
3. Keep that key pressed
4. For at least 15 seconds
5. Now type &gt; and
6. **save** without pressing any other key at all.
7. If you press another key, you will bring the problem back.
8. DO **NOT** PUT CODE IN UNNECESSARY CODE BLOCKS, PUT THEM IN A SINGLE PHP BLOCK.

Wrong:

```
<?php some code; ?> <?php some other codes; ?>
```

Correct:

```
<?php code; some other code; ?>
```

Upload the file back to your server after editing and saving the file.

**Note**: Also check the encoding of the file. If the file is encoded as UTF-8 with BOM, the BOM is seen as a character which starts the output.

**Interpreting the Error Message:**

If the error message states: `Warning: Cannot modify header information - headers already sent by (output started at /path/blog/wp-config.php:34) in /path/blog/wp-login.php on line 42`, then the problem is at line #34 of `wp-config.php`, not line #42 of `wp-login.php`. In this scenario, line #42 of `wp-login.php` is the victim. It is being affected by the excess whitespace at line #34 of `wp-config.php`.

If the error message states: `Warning: Cannot modify header information - headers already sent by (output started at /path/wp-admin/admin-header.php:8) in /path/wp-admin/post.php on line 569`, then the problem is at line #8 of `admin-header.php`, not line #569 of `post.php`. In this scenario, line #569 of `post.php` is the victim. It is being affected by the excess whitespace at line #8 of `admin-header.php`.

## Why doesn’t my “Publish” or “Save Draft” button work?

To resolve this and similar issues, disable your plugins one at a time until you find the source of the issue. Generally, this will be due to two or more plugins trying to use the same resources (for example, JQuery or other Java-based tools).

In addition, it could be that there is a problem with your browser. A common resolution is to empty the browser’s cache. Please consult the documentation for your preferred browser to learn how to do this.

## How to fix 404 error when using Pretty Permalinks?

If an error 404 occurs when using the [Pretty Permalink](/support/article/introduction-to-blogging/#pretty-permalinks) choices such as **Day and Name** in [Administration](/support/article/administration-screens/) &gt; [Settings](/support/article/administration-screens/#permalinks) &gt; [Settings\_Permalinks\_Screen](/support/article/settings-permalinks-screen/) it could be a result of the **mod\_rewrite** module not being activated/installed. The solution is to activate **mod\_rewrite** for the Apache web-server. Check the apacheconfhttpd.conf file for the line *\# LoadModule rewrite\_module modules/mod\_rewrite.so*
and delete the # in front of the line. Then stop Apache and start it again. **Note:** you may have to ask your host to activate mod\_rewrite.

See also [Using Permalinks](/support/article/using-permalinks/). Relevant discussion thread is <https://wordpress.org/support/topic/234726>

## Why isn’t the admin user listed as an author when editing posts?

Not sure why this problem happens, but here’s a couple of things to try one of these two solutions.

This usually fixes the problem:

1. Create new admin user (e.g. newadmin) with Administrator Role
2. Login as ‘newadmin’
3. Degrade the old ‘admin’ user to Role of Subscriber and Save
4. Promote the old ‘admin’ back to Administrator Role and Save
5. Login as the old ‘admin’

If that doesn’t work, try:

1. Create a new admin user (e.g. newadmin) with Administrator Role
2. Login as ‘newadmin’
3. Delete the old ‘admin’ user and assign any posts to ‘newadmin’
4. Create ‘admin’ user with Administrator Role
5. Login as ‘admin’
6. Delete ‘newadmin’ user and assign posts to ‘admin’

## Why is the wrong author name displayed for a post on a blog?

This problem is usually solved by the same solution as is presented in the question right before this one:
[Why isn’t the admin user listed as an author when editing posts?](/support/article/faq-troubleshooting/#why-isnt-the-admin-user-listed-as-an-author-when-editing-posts)

## How do I find more help?

There are various resources that will help you find more help with WordPress, in addition to these [FAQ](https://codex.wordpress.org/FAQ).

- [Troubleshooting](https://codex.wordpress.org/Troubleshooting)
- [Finding WordPress Help](https://wordpress.org/documentation/article/where-to-find-wordpress-help/)
- [Using the Support Forums](https://wordpress.org/support/welcome/)
- [Resources and Technical Articles about WordPress](<https://codex.wordpress.org/Technical Articles>)
- [Installation Problems](https://codex.wordpress.org/Troubleshooting#Installation_Problems)

**Important:** Please note that this is not a support page. If you seek help with your specific problem, please refer to the [Support forums](https://wordpress.org/support/welcome/).
