# class-wp-upgrader.php

## Overview

Admin include file from WordPress core. This doc summarizes the public-facing classes and functions developers typically interact with.

## Classes

- `WP_Upgrader` — Upgrade API: WP_Upgrader class

### Developer Usage

`WP_Upgrader` powers core/plugin/theme upgrade workflows. Use the specialized subclasses (`Plugin_Upgrader`, `Theme_Upgrader`, `Core_Upgrader`, `Language_Pack_Upgrader`) rather than instantiating this base class directly.
