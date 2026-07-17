import { existsSync } from 'node:fs';
import { spawnSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';

export function parsePublishResult(output) {
  let envelope;
  try {
    envelope = JSON.parse(output);
  } catch {
    throw new Error('Spacefast did not return valid JSON publication evidence.');
  }
  const result = envelope.data ?? envelope;
  if (!result.spaceId || !result.versionId || result.versionStatus !== 'ready' || result.liveVersionId !== result.versionId) {
    throw new Error('Spacefast did not confirm that the published version is ready and live.');
  }
  if (!result.immutableUrl || new URL(result.immutableUrl).protocol !== 'https:') {
    throw new Error('Spacefast did not return an immutable HTTPS version URL.');
  }
  return {
    spaceId: result.spaceId,
    versionId: result.versionId,
    versionRef: result.versionRef ?? result.versionId,
    immutableUrl: result.immutableUrl,
    siteUrl: result.siteUrl ?? ''
  };
}

export function publishSpacefast({ environment = process.env, dryRun = false } = {}) {
  const output = 'dist';
  const space = environment.WP_DOCS_SPACEFAST_TARGET || 'wp-docs';
  if (!existsSync(output)) throw new Error('No built dist/ directory exists. Run a build before requesting Spacefast publication.');
  if (!dryRun && environment.WP_DOCS_ALLOW_PUBLISH !== '1') {
    throw new Error('Publication is approval-gated. Re-run with WP_DOCS_ALLOW_PUBLISH=1 only after explicit approval, or use --dry-run.');
  }
  const result = spawnSync('sf', [
    'publish', output, '--space', space, '--yes', '--wait', '--json',
    ...(dryRun ? ['--dry-run'] : [])
  ], { env: environment, encoding: 'utf8', stdio: 'pipe' });
  if (result.error || result.status !== 0) throw new Error('Spacefast publication failed.');
  return dryRun ? JSON.parse(result.stdout) : parsePublishResult(result.stdout);
}

if (process.argv[1] && fileURLToPath(import.meta.url) === process.argv[1]) {
  try {
    process.stdout.write(`${JSON.stringify(publishSpacefast({ dryRun: process.argv.includes('--dry-run') }))}\n`);
  } catch (error) {
    process.stderr.write(`${error.message}\n`);
    process.exitCode = 1;
  }
}
