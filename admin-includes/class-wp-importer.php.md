# class-wp-importer.php

## Overview

Admin include file from WordPress core. This doc summarizes the public-facing classes and functions developers typically interact with.

## Classes

- `WP_Importer` — WP_Importer base class

## Functions

- `get_cli_args()` — WP_Importer base class

### Developer Usage

Importer classes extend `WP_Importer`. Register importers using `register_importer()` (see `import.php`).
