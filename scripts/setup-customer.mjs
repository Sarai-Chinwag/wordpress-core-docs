import { existsSync } from 'node:fs';
import { mkdtemp, rm, writeFile } from 'node:fs/promises';
import { spawnSync } from 'node:child_process';
import { tmpdir } from 'node:os';
import { basename, join, resolve } from 'node:path';
import { createInterface } from 'node:readline/promises';

const DEFAULT_SPACE = 'wp-docs';

export function normalizeOrigin(value) {
  let url;
  try {
    url = new URL(value);
  } catch {
    throw new Error('WP_DOCS_ORIGIN must be an absolute HTTPS WordPress URL.');
  }
  if (url.protocol !== 'https:' || url.username || url.password || url.search || url.hash) {
    throw new Error('WP_DOCS_ORIGIN must be an absolute HTTPS WordPress URL without credentials, query, or fragment.');
  }
  url.pathname = url.pathname.replace(/\/+$/, '') || '/';
  return url.toString().replace(/\/$/, '');
}

export function normalizeHostname(value) {
  const hostname = String(value || '').toLowerCase().replace(/\.$/, '');
  if (hostname.length > 253 || !hostname.includes('.') || hostname.split('.').some((label) => !/^[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?$/.test(label))) {
    throw new Error('WP_DOCS_CUSTOM_HOSTNAME must be a valid hostname without a scheme or path.');
  }
  return hostname;
}

export function normalizeDocsUrl(value) {
  let url;
  try {
    url = new URL(value);
  } catch {
    throw new Error('WP_DOCS_DOCS_URL must be an absolute HTTPS URL.');
  }
  if (url.protocol !== 'https:' || url.username || url.password || url.search || url.hash) {
    throw new Error('WP_DOCS_DOCS_URL must be an absolute HTTPS URL without credentials, query, or fragment.');
  }
  return url.toString().replace(/\/$/, '');
}

export function sourceRootFor(contentRoot) {
  const root = resolve(contentRoot);
  return existsSync(join(root, 'wpdocs_document')) ? join(root, 'wpdocs_document') : root;
}

export function contentKind(contentRoot) {
  const root = sourceRootFor(contentRoot);
  if (!existsSync(root)) throw new Error(`Content root is missing: ${root}`);
  if (basename(root) === 'wpdocs_document') return 'push-md';
  if (existsSync(join(root, 'documentation')) && existsSync(join(root, 'helphub_article'))) return 'bundled';
  throw new Error('Content root must be content/runtime or a Push MD clone containing wpdocs_document/.');
}

export function publicationEndpoint(origin, ability) {
  return `${normalizeOrigin(origin)}/wp-json/wp-abilities/v1/abilities/wpdocs/${ability}/run`;
}

export function clonePlan(endpoint) {
  return ['git', 'clone', '--depth', '1', endpoint, '<ephemeral-content-root>'];
}

export function selectQueuedPublication(requests) {
  if (!Array.isArray(requests)) throw new Error('WordPress returned an invalid publication queue.');
  return requests.findLast((request) => request?.state === 'queued') ?? null;
}

export function redact(value, secrets = []) {
  return secrets.reduce((result, secret) => secret ? result.split(secret).join('[REDACTED]') : result, String(value));
}

export function planSetup({ origin, contentRoot, space = DEFAULT_SPACE, customHostname, docsUrl }) {
  const normalizedOrigin = normalizeOrigin(origin);
  const gitEndpoint = `${normalizedOrigin}/wp-json/git/v1/md.git`;
  const steps = [
    ['GET', `${normalizedOrigin}/wp-json/wp/v2/settings?context=edit`],
    ['git', 'ls-remote', gitEndpoint],
    ['npm', 'run', 'build'],
    ['sf', 'status', '--json'],
    ['sf', 'publish', 'dist', '--space', space, '--yes', '--wait', '--json']
  ];
  if (customHostname) steps.push(['sf', 'domains', 'add', customHostname, '--space', space, '--yes', '--wait'], ['sf', 'domains', 'check', customHostname, '--space', space, '--wait'], ['sf', 'domains', 'diagnostics', customHostname, '--space', space]);
  if (docsUrl) steps.push(['POST', publicationEndpoint(normalizedOrigin, 'report-publication'), 'verified succeeded report updates wpdocs_base_url']);
  return { origin: normalizedOrigin, gitEndpoint, contentRoot: sourceRootFor(contentRoot), steps };
}

export function approved(environment = process.env) {
  return environment.WP_DOCS_ALLOW_SETUP === '1';
}

export function run(command, args, environment = process.env) {
  const result = spawnSync(command, args, { env: environment, encoding: 'utf8', stdio: 'pipe' });
  if (result.error || result.status !== 0) throw new Error(`${command} check failed.`);
  return result.stdout;
}

function attachedHostnames(space, environment) {
  let result;
  try {
    result = JSON.parse(run('sf', ['domains', 'ls', '--space', space, '--json'], environment));
  } catch {
    throw new Error('Spacefast domain inspection failed.');
  }
  return Array.isArray(result.data) ? result.data.map((domain) => domain.name) : [];
}

export function withoutWordPressCredentials(environment) {
  const sanitized = { ...environment };
  delete sanitized.WP_DOCS_APP_PASSWORD;
  delete sanitized.WP_DOCS_GIT_PASSWORD;
  return sanitized;
}

async function credential(environment) {
  if (!environment.WP_DOCS_USERNAME) throw new Error('WP_DOCS_USERNAME is required. Use a WordPress administrator account name.');
  if (environment.WP_DOCS_APP_PASSWORD) return { username: environment.WP_DOCS_USERNAME, password: environment.WP_DOCS_APP_PASSWORD };
  if (environment.WP_DOCS_APP_PASSWORD_STDIN === '1') {
    const chunks = [];
    for await (const chunk of process.stdin) chunks.push(chunk);
    const password = Buffer.concat(chunks).toString('utf8').trim();
    if (password) return { username: environment.WP_DOCS_USERNAME, password };
  }
  if (process.stdin.isTTY) {
    const prompt = createInterface({ input: process.stdin, output: process.stderr, terminal: true });
    const password = await prompt.question('WordPress application password: ', { hideEchoBack: true });
    prompt.close();
    if (password) return { username: environment.WP_DOCS_USERNAME, password };
  }
  throw new Error('WordPress application password is missing. Set WP_DOCS_APP_PASSWORD, pipe it with WP_DOCS_APP_PASSWORD_STDIN=1, or use an interactive terminal.');
}

async function wpRequest(url, credentials, options = {}) {
  const response = await fetch(url, {
    ...options,
    headers: { ...options.headers, authorization: `Basic ${Buffer.from(`${credentials.username}:${credentials.password}`).toString('base64')}` }
  });
  if (!response.ok) throw new Error(`WordPress REST request failed (${response.status}). Check that WP Docs is active and the application password belongs to an administrator.`);
  return response;
}

export async function callAbility(origin, ability, credentials, input = {}) {
  const readonly = ability === 'preview-publication' || ability === 'get-publication-status';
  const options = readonly ? { method: 'GET' } : {
    method: 'POST', headers: { 'content-type': 'application/json' }, body: JSON.stringify(input)
  };
  const response = await wpRequest(publicationEndpoint(origin, ability), credentials, options);
  const body = await response.json();
  return body.data ?? body;
}

async function gitEnvironment(credentials) {
  const directory = await mkdtemp(join(tmpdir(), 'wpdocs-askpass-'));
  const helper = join(directory, 'askpass');
  await writeFile(helper, '#!/bin/sh\ncase "$1" in *Username*) printf %s "$WP_DOCS_GIT_USERNAME" ;; *) printf %s "$WP_DOCS_GIT_PASSWORD" ;; esac\n', { mode: 0o700 });
  return { directory, environment: { ...withoutWordPressCredentials(process.env), GIT_ASKPASS: helper, GIT_TERMINAL_PROMPT: '0', WP_DOCS_GIT_USERNAME: credentials.username, WP_DOCS_GIT_PASSWORD: credentials.password } };
}

export async function clonePushMd(endpoint, credentials) {
  const directory = await mkdtemp(join(tmpdir(), 'wpdocs-content-'));
  const askpass = await gitEnvironment(credentials);
  try {
    run('git', ['clone', '--depth', '1', endpoint, directory], askpass.environment);
    if (contentKind(directory) !== 'push-md') throw new Error('Push MD endpoint did not contain wpdocs_document/.');
    return { directory, version: run('git', ['-C', directory, 'rev-parse', 'HEAD'], askpass.environment).trim() };
  } catch (error) {
    await rm(directory, { recursive: true, force: true });
    throw error;
  } finally {
    await rm(askpass.directory, { recursive: true, force: true });
  }
}

async function main() {
  const environment = process.env;
  let password = environment.WP_DOCS_APP_PASSWORD || '';
  let credentials;
  let plan;
  let request;
  let claimed = false;
  let temporaryContent = '';
  try {
    const dryRun = process.argv.includes('--dry-run');
    const seedMode = environment.WP_DOCS_SEED_CONTENT === '1';
    const contentRoot = environment.WP_DOCS_CONTENT_ROOT || (seedMode ? 'content/runtime' : '');
    const space = environment.WP_DOCS_SPACEFAST_TARGET || DEFAULT_SPACE;
    const customHostname = environment.WP_DOCS_CUSTOM_HOSTNAME ? normalizeHostname(environment.WP_DOCS_CUSTOM_HOSTNAME) : '';
    const configuredDocsUrl = environment.WP_DOCS_DOCS_URL || (customHostname ? `https://${customHostname}` : '');
    if (!dryRun && !configuredDocsUrl) throw new Error('WP_DOCS_DOCS_URL is required before an approved run can mutate Spacefast.');
    const docsUrl = configuredDocsUrl ? normalizeDocsUrl(configuredDocsUrl) : '';
    plan = planSetup({ origin: environment.WP_DOCS_ORIGIN || '', contentRoot: contentRoot || 'content/runtime', space, customHostname, docsUrl });
    credentials = await credential(environment);
    password = credentials.password;
    const childEnvironment = withoutWordPressCredentials(environment);

    for (const command of ['node', 'npm', 'git', 'sf']) run(command, ['--version'], childEnvironment);
    await wpRequest(`${plan.origin}/wp-json/wp/v2/settings?context=edit`, credentials);
    const askpass = await gitEnvironment(credentials);
    try { run('git', ['ls-remote', plan.gitEndpoint], askpass.environment); } finally { await rm(askpass.directory, { recursive: true, force: true }); }
    run('sf', ['status', '--json'], childEnvironment);
    const attached = attachedHostnames(space, childEnvironment).includes(customHostname);
    let preflightRoot = contentRoot;
    let preflightClone;
    if (!preflightRoot) {
      preflightClone = await clonePushMd(plan.gitEndpoint, credentials);
      preflightRoot = preflightClone.directory;
    }
    try { process.stdout.write(`Preflight passed. Content: ${contentKind(preflightRoot)}. Planned publication: sf publish dist --space ${space} --wait --json.\n`); } finally { if (preflightClone) await rm(preflightClone.directory, { recursive: true, force: true }); }
    if (dryRun) return;
    if (!approved(environment)) throw new Error('Setup is approval-gated. Re-run with WP_DOCS_ALLOW_SETUP=1 after explicit approval, or use --dry-run.');
    request = selectQueuedPublication(await callAbility(plan.origin, 'get-publication-status', credentials));
    if (!request) {
      process.stdout.write('No queued WordPress publication request exists. Nothing was published.\n');
      return;
    }
    await callAbility(plan.origin, 'report-publication', credentials, { request_id: request.request_id, state: 'running' });
    claimed = true;
    let buildRoot = contentRoot;
    let version = 'seed';
    if (!buildRoot) {
      const clone = await clonePushMd(plan.gitEndpoint, credentials);
      temporaryContent = clone.directory;
      buildRoot = clone.directory;
      version = clone.version;
    }
    run('npm', ['run', 'build'], { ...childEnvironment, WP_DOCS_CONTENT_ROOT: buildRoot });
    const publication = JSON.parse(run('node', ['scripts/publish-spacefast.mjs'], { ...childEnvironment, WP_DOCS_ALLOW_PUBLISH: '1' }));
    if (customHostname) {
      if (!attached) run('sf', ['domains', 'add', customHostname, '--space', space, '--yes', '--wait'], childEnvironment);
      run('sf', ['domains', 'check', customHostname, '--space', space, '--wait'], childEnvironment);
      run('sf', ['domains', 'diagnostics', customHostname, '--space', space], childEnvironment);
    }
    const served = await fetch(docsUrl, { redirect: 'follow' });
    if (!served.ok) throw new Error(`Documentation hostname is not serving yet (${served.status}); wpdocs_base_url was not changed.`);
    await callAbility(plan.origin, 'report-publication', credentials, {
      request_id: request.request_id, state: 'succeeded', verified: true,
      artifact: {
        serving_url: docsUrl,
        version: publication.versionId,
        identifier: publication.spaceId,
        immutable_url: publication.immutableUrl,
        source_revision: version
      }
    });
    process.stdout.write('Setup completed. WordPress now links document previews to the serving documentation hostname.\n');
  } catch (error) {
    if (credentials && plan && request && claimed) {
      try { await callAbility(plan.origin, 'report-publication', credentials, { request_id: request.request_id, state: 'failed', failure: redact(error.message, [password]) }); } catch { /* Preserve the original failure. */ }
    }
    process.stderr.write(`${redact(error.message, [password])}\n`);
    process.exitCode = 1;
  } finally {
    if (temporaryContent) await rm(temporaryContent, { recursive: true, force: true });
  }
}

if (import.meta.url === `file://${process.argv[1]}`) await main();
