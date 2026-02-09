# bookmark.php

## Overview

Admin helpers for Link/Bookmark management (legacy Links Manager).

## Functions

- `add_link()` — WordPress Bookmark Administration API
- `edit_link()` — Updates or inserts a link using values provided in $_POST.
- `get_default_link_to_edit()` — Retrieves the default link for editing.
- `wp_delete_link()` — Deletes a specified link from the database.
- `wp_get_link_cats()` — Fires before a link is deleted.
- `get_link_to_edit()` — Retrieves link data based on its ID.
- `wp_insert_link()` — Inserts a link into the database, or updates an existing link.
- `wp_set_link_cats()` — Fires after a link was updated in the database.
- `wp_update_link()` — Updates a link in the database.
- `wp_link_manager_disabled_message()` — Outputs the 'disabled' message for the WordPress Link Manager.
