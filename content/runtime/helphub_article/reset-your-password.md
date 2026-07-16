---
type: document
title: Reset your password
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/reset-your-password/"
tags:
timestamp: "2026-06-16T19:29:08+00:00"
wordpress:
  id: 2387
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:08"
  date_gmt: "2026-06-16 19:29:08"
  modified: "2026-06-16 19:29:08"
  modified_gmt: "2026-06-16 19:29:08"
  slug: reset-your-password
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/reset-your-password/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

In WordPress, there is more than one way to reset your password. (Normally, the easiest way to reset it is through the “Lost your password?” link on the main login page for your blog or website.)
However, there are certain times (especially if your email isn’t working correctly) that you may have to take different steps to reset your password.

Here’s a list of different ways to reset a password. The method that you use depends on the type of access that you still have to your website.

## To Change Your Password

To change your password in current versions:

1. In the Administration Screen, menu, go to Users &gt; All Users.
2. Click on your username in the list to edit it.
3. In the Edit User screen, scroll down to the New Password section and click the Generate Password button.
4. If you want to change the automatically generated password, you can overwrite it by typing a new password in the box provided. The strength box will show you how good (strong) your password is.
5. Click the Update User button.

Your new password becomes active immediately.

## Through the automatic emailer

If you know your username or the email account in your profile, you can use the “lost password” feature of WordPress.

- Go to your WordPress Login page (something like [http://yoursite.com/wordpress/wp-login.php](https://codex.wordpress.org/Resetting_your_password))
- Click on the “Lost your password?” link
- You will be taken to a page to enter some details. Enter your username or the email address on file for that account.
- Wait happily as your new password is emailed to you.
- Once you get your new password, login to your profile page and change this password to something you can *remember*.

## Through MySQL Command Line

1. Get an MD5 hash of your password. 
    - [Visit md5 Hash Generator](http://www.miraclesalad.com/webtools/md5.php), or…
    - Create a key with Python, or…
    - On Unix/Linux:
    
    
    1. Create a file called `wp.txt`, containing nothing but the new password.
    2. `tr -d 'rn' < wp.txt | md5sum | tr -d ' -'` (to output the pure MD5 hash string of the content of `wp.txt`, ignoring line breaks)
    3. `rm wp.txt` (to remove `wp.txt`)
2. “`mysql -u root -p`” (to log in to MySQL)
3. enter your mysql password
4. “`use (name-of-database)`” (to select WordPress database)
5. `"show tables;"` (you’re looking for a table name with `"users"` at the end)
6. `"SELECT ID, user_login, user_pass FROM (name-of-table-you-found);"` (this gives you an idea of what’s going on inside)
7. `"UPDATE (name-of-table-you-found) SET user_pass="(MD5-string-you-made)" WHERE ID = (id#-of-account-you-are-reseting-password-for);"` (actually changes the password)
8. `"SELECT ID, user_login, user_pass FROM (name-of-table-you-found);"` (confirm that it was changed)
9. (type Control-D to exit mysql client)

Note: if you have a recent version of MySQL (version 5.x?) you can have MySQL compute the MD5 hash for you.

1. Skip step# 1 above.
2. Do the following for step# 7 instead.
    - `"UPDATE (name-of-table-you-found) SET user_pass = MD5('(new-password)') WHERE ID = (id#-of-account-you-are-reseting-password-for);"` (actually changes the password)

Note that even if the passwords are salted, meaning they look like $P$BLDJMdyBwegaCLE0GeDiGtC/mqXLzB0, you can still replace the password with an MD5 hash, and WordPress will let you log in.

## Through phpMyAdmin

This article is for those who have [phpMyAdmin](/support/article/phpmyadmin/) access to their database. **Note: use phpMyAdmin at your own risk. If you doubt your ability to use it, seek further advice. WordPress is not responsible for loss of data.**

1. Begin by logging into phpMyAdmin and clicking **databases**.
2. A list of databases will appear. Click on your WordPress database.

[![PHPMyAdmin database selection](https://i0.wp.com/wordpress.org/documentation/files/2018/11/changepw2.jpg?fit=355%2C316&ssl=1)](https://i0.wp.com/wordpress.org/documentation/files/2018/11/changepw2.jpg?fit=355%2C316&ssl=1)phpMyAdmin database select1. All the tables in your database will appear. If not, click **Structure**.
2. Look for **`wp_users`** in the Table column.
3. Click on the icon for **browse**.
4. Locate your username under `user_login`
5. Click **edit** (may look like a pencil icon in some versions of phpMyAdmin).

[![PHPMyAdmin select users database table](https://i1.wp.com/wordpress.org/documentation/files/2018/11/changepw3.jpg?fit=343%2C226&ssl=1)](https://i1.wp.com/wordpress.org/documentation/files/2018/11/changepw3.jpg?fit=343%2C226&ssl=1)phpMyAdmin select users table1. Your `user_id` will be shown. Click on Edit.
2. Next to the `user_pass` is a long list of numbers and letters.
3. Select and delete these and type in your new password.
4. Type in the password you want to use. You can type it in normally–but remember, it is case-sensitive.
5. In this example, the new password will be ‘rabbitseatcarrots.’
6. Once you have done that, click the dropdown menu indicated, and select MD5 from the menu.

[![phpMyAdmin select MD5 function on user_pass row](https://i2.wp.com/wordpress.org/documentation/files/2018/11/changepw6.jpg?fit=415%2C139&ssl=1)](https://i2.wp.com/wordpress.org/documentation/files/2018/11/changepw6.jpg?fit=415%2C139&ssl=1)phpMyAdmin select MD5 function on user\_pass row1. Check that your password is actually correct, and that MD5 is in the box.

[![phpMyAdmin user_pass row with MD5 function and "rabbitseatcarrots" as the password](https://i2.wp.com/wordpress.org/documentation/files/2018/11/changepw7.jpg?fit=415%2C76&ssl=1)](https://i2.wp.com/wordpress.org/documentation/files/2018/11/changepw7.jpg?fit=415%2C76&ssl=1)phpMyAdmin user\_pass row with MD5 function and “rabbitseatcarrots” as the password1. Click the ‘Go’ button to the bottom right.
2. Test the new password on the login screen. If it doesn’t work, check that you’ve followed these instructions exactly.

## Through FTP

There is also an easy way to reset your password via FTP, if you’re using the admin user.

1. Login to your site via FTP and download your active theme’s functions.php file.
2. Edit the file and add this code to it, right at the beginning, after the first `<?php`
    
    `wp_set_password( 'my_new_password', 1 );`
    
    In the above code, replace the text `my_new_password` with your own new password for the main admin user. The number `1` above refers to the user ID number in the `wp_users` database table. Since we wanted the user ID of the main admin user, we just keep the number as `1`, which is typically the user ID of the main admin user.
3. Upload the modified file back to your site.
4. Once you are able to login, make sure to go back and remove that code. It will reset your password on every page load until you do so.

## Through WP CLI

WP CLI is a command line tool for managing your WordPress installation.

1. Move into the /wordpress directory and type
    
    `$ wp user list<br></br>`
    to see all users. Find the ID of the user you’d like to update.

1. Then, update the user
    
    `$ wp user update 1 --user_pass=$UP3RstrongP4$w0rd<br></br>`
    replacing “1” with the id of the user you want to update.

[More on wp cli](http://wp-cli.org/)

## Using the Emergency Password Reset Script

If the other solutions listed above won’t work, then try the Emergency Password Reset Script. Please note that it’s not a plugin, it’s a PHP script.

### A Word of Caution:

1. The Emergency Password Reset Script requires that you know the administrator’s username.
2. It updates the administrator password and sends an email to the administrator’s email address.
3. Even if you don’t receive the email, the password will still be changed.
4. You do not need to be logged in to use it. (After all, if you could login, you wouldn’t need the script.)
5. Place the script in the root of your WordPress installation. Do not upload it to your WordPress Plugins directory.
6. For security reasons, remember to delete the script when you are done.

### Directions for Use:

1. Copy the emergency script from [Emergency Password Script](https://codex.wordpress.org/User:MichaelH/Orphaned_Plugins_needing_Adoption/Emergency) and put into a file called emergency.php in the root of your WordPress installation (the same directory that contains wp-config.php).
2. In your browser, open http://example.com/emergency.php.
3. As instructed, enter the administrator username (usually admin) and the new password, then click **Update Options**. A message is displayed noting the changed password. An email is sent to the blog administrator with the changed password information.
4. **Delete emergency.php from your server when you are done.** Do not leave it on your server, as someone else could use it to change your password.

## Additional Reference

- Here is another [password reset script](http://kuttler.eu/code/wordpress-password-reset/) that can be used without knowing the username or email.
