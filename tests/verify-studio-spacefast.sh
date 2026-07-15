#!/usr/bin/env bash
set -euo pipefail

npm ci
npm run build:fixture

test -f dist/index.html
test -f dist/developer/index.html
test -f dist/developer/script-modules/index.html
test -f dist/developer/dependencies/index.html
test -f dist/media/"$(node -e "const c=require('node:crypto'); console.log(c.createHash('sha256').update('http://studio.test/wp-content/uploads/script-modules.svg').digest('hex').slice(0,16))").svg"

for page in dist/developer/index.html dist/developer/script-modules/index.html dist/developer/dependencies/index.html; do
  test -s "$page"
  grep -qi '<!doctype html>' "$page"
  grep -q '<main' "$page"
done

grep -q 'Script Modules' dist/developer/script-modules/index.html
grep -q 'Dependencies and imports' dist/developer/dependencies/index.html
grep -q 'aria-label="Breadcrumb"' dist/developer/script-modules/index.html
grep -q 'language-php' dist/developer/script-modules/index.html
if grep -R -E -i -n '(localhost|127\.0\.0\.1|studio\.test)' dist; then
  echo 'Generated output contains a local backend URL.' >&2
  exit 1
fi

sf_bin=$(mktemp -d)
sf_args=$(mktemp)
sf_expected=$(mktemp)
cleanup() {
  rm -rf "$sf_bin"
  rm -f "$sf_args" "$sf_expected"
}
trap cleanup EXIT

cat > "$sf_bin/sf" <<'EOF'
#!/usr/bin/env bash
set -euo pipefail
printf '%s\n' "$@" > "$SF_ARGS_FILE"
EOF
chmod +x "$sf_bin/sf"

PATH="$sf_bin:$PATH" SF_ARGS_FILE="$sf_args" npm run publish:spacefast -- --dry-run
printf 'deploy\ndist\n--prebuilt\n--dry-run\n' > "$sf_expected"
cmp -s "$sf_expected" "$sf_args"
