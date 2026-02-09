# export.php

## Overview

Exports content via the Tools → Export screen, including filters and file generation.

## Functions

- `export_wp()` — WordPress Export Administration API
- `wxr_cdata()` — Fires at the beginning of an export, before any headers are sent.
- `wxr_site_url()` — Returns the URL of the site.
- `wxr_cat_name()` — Outputs a cat_name XML tag from a given category object.
- `wxr_category_description()` — Outputs a category_description XML tag from a given category object.
- `wxr_tag_name()` — Outputs a tag_name XML tag from a given tag object.
- `wxr_tag_description()` — Outputs a tag_description XML tag from a given tag object.
- `wxr_term_name()` — Outputs a term_name XML tag from a given term object.
- `wxr_term_description()` — Outputs a term_description XML tag from a given term object.
- `wxr_term_meta()` — Outputs term meta XML tags for a given term object.
- `wxr_authors_list()` — Filters whether to selectively skip term meta used for WXR exports.
- `wxr_nav_menu_terms()` — Outputs all navigation menu terms.
- `wxr_post_taxonomy()` — Outputs list of taxonomy terms, in XML tag format, associated with a post.
- `wxr_filter_postmeta()` — Determines whether to selectively skip post meta used for WXR exports.
