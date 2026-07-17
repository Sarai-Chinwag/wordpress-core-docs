#!/usr/bin/env bash
set -euo pipefail

while IFS= read -r -d '' file; do
  php -l "$file" >/dev/null
done < <(find plugins/wp-docs -type f -name '*.php' -print0)

php tests/wpdocs/test-plugin.php
