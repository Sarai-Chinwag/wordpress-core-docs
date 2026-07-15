import { existsSync } from 'node:fs';
import { spawnSync } from 'node:child_process';

const args = process.argv.slice(2);
const dryRun = args.includes('--dry-run');
const output = 'dist';

if (!existsSync(output)) {
  console.error('No prebuilt dist/ directory exists. Run a build before requesting Spacefast publication.');
  process.exit(1);
}
if (!dryRun && process.env.WP_DOCS_ALLOW_PUBLISH !== '1') {
  console.error('Publication is approval-gated. Re-run with WP_DOCS_ALLOW_PUBLISH=1 only after explicit approval, or use --dry-run.');
  process.exit(1);
}
const help = spawnSync('spacefast', ['--help'], { encoding: 'utf8' });
if (help.error && help.error.code === 'ENOENT') {
  console.log('Spacefast CLI is not installed; no publication was attempted.');
  process.exit(0);
}
if (help.status !== 0 || !/deploy/i.test(`${help.stdout}${help.stderr}`)) {
  console.error('Installed Spacefast CLI does not advertise a deploy command; no publication was attempted.');
  process.exit(1);
}
if (dryRun && !/dry.run/i.test(`${help.stdout}${help.stderr}`)) {
  console.log('Installed Spacefast CLI does not advertise a dry-run flag; no publication was attempted.');
  process.exit(0);
}
const result = spawnSync('spacefast', ['deploy', output, ...(dryRun ? ['--dry-run'] : [])], { stdio: 'inherit' });
process.exit(result.status ?? 1);
