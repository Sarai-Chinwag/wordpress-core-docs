#!/usr/bin/env bash
set -euo pipefail

if [ "$#" -ne 1 ]; then
  echo "Usage: $0 <wordpress-path>" >&2
  exit 2
fi

wp_path=$1
test -f "$wp_path/wp-load.php"

php -r '
require $argv[1] . "/wp-load.php";
require_once ABSPATH . "wp-admin/includes/plugin.php";
foreach (["push-md/push-md.php", "wp-docs/wp-docs.php"] as $plugin) {
    if (! is_plugin_active($plugin)) { throw new RuntimeException("Required plugin is inactive: " . $plugin); }
}
$post_type = get_post_type_object("wpdocs_document");
if (! $post_type || ! $post_type->show_ui || ! $post_type->show_in_rest || $post_type->public || $post_type->publicly_queryable) { throw new RuntimeException("WP Docs CPT visibility is wrong"); }
foreach (["wpdocs_collection", "wpdocs_topic"] as $taxonomy) { $object = get_taxonomy($taxonomy); if (! $object || ! $object->show_in_rest) { throw new RuntimeException("WP Docs taxonomy registration is wrong"); } }
if (! in_array("wpdocs_document", Push_MD_Plugin::get_supported_post_types(), true)) { throw new RuntimeException("Push MD did not register the WP Docs adapter"); }
$routes = rest_get_server()->get_routes();
$has_git_route = false;
foreach (array_keys($routes) as $route) { if (0 === strpos($route, "/git/v1/md")) { $has_git_route = true; break; } }
if (! $has_git_route) { throw new RuntimeException("Push MD Git route is missing"); }
echo "WP Docs Push MD runtime verification passed.\n";
' "$wp_path"
