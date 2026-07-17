import { existsSync } from 'node:fs';
import { spawnSync } from 'node:child_process';

const args = process.argv.slice(2);
const dryRun = args.includes('--dry-run');
const output = 'dist';
const space = process.env.WP_DOCS_SPACEFAST_TARGET || 'wp-docs';

if (!existsSync(output)) {
  console.error('No prebuilt dist/ directory exists. Run a build before requesting Spacefast publication.');
  process.exit(1);
}
if (!dryRun && process.env.WP_DOCS_ALLOW_PUBLISH !== '1') {
  console.error('Publication is approval-gated. Re-run with WP_DOCS_ALLOW_PUBLISH=1 only after explicit approval, or use --dry-run.');
  process.exit(1);
}
const result = spawnSync('sf', [
  'publish',
  output,
  '--prebuilt',
  '--space',
  space,
  '--yes',
  '--wait',
  ...(dryRun ? ['--dry-run'] : [])
], { stdio: 'inherit' });
process.exit(result.status ?? 1);
