# wp-links-opml.php

## Purpose
Exports the Links/Bookmarks catalog as OPML XML.

## Flow
- Loads WordPress.
- Determines link category filter from query string.
- Outputs OPML header and iterates link categories.
- Outputs bookmark outlines for each category.

## Key functions called
- `get_categories()`
- `get_bookmarks()`
- `get_bloginfo()`

## Hooks fired
- Actions:
  - `opml_head`
- Filters:
  - `link_category`
  - `link_title`
