# class-wp-filesystem-base.php

## Overview

Admin include file from WordPress core. This doc summarizes the public-facing classes and functions developers typically interact with.

## Classes

- `WP_Filesystem_Base` — Base WordPress Filesystem

### Developer Usage

The WP_Filesystem API abstracts file operations across direct, FTP, and SSH transports. Initialize with `WP_Filesystem()` and then use the global `$wp_filesystem` methods.
