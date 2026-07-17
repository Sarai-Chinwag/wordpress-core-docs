import assert from 'node:assert/strict';
import { spawnSync } from 'node:child_process';
import { mkdtemp, mkdir, rm } from 'node:fs/promises';
import test from 'node:test';
import { tmpdir } from 'node:os';
import { join } from 'node:path';
import { approved, callAbility, clonePlan, contentKind, normalizeDocsUrl, normalizeHostname, normalizeOrigin, planSetup, publicationEndpoint, redact, selectQueuedPublication, sourceRootFor, withoutWordPressCredentials } from '../scripts/setup-customer.mjs';
import { parsePublishResult } from '../scripts/publish-spacefast.mjs';

test('plans a normalized, provider-neutral setup without credential arguments', () => {
  const plan = planSetup({ origin: 'https://Example.test/wp/', contentRoot: 'content/runtime', space: 'customer-docs', customHostname: 'docs.example.test', docsUrl: 'https://docs.example.test' });
  assert.equal(plan.origin, 'https://example.test/wp');
  assert.deepEqual(plan.steps.at(0), ['GET', 'https://example.test/wp/wp-json/wp/v2/settings?context=edit']);
  assert.deepEqual(plan.steps.at(-1), ['POST', 'https://example.test/wp/wp-json/wp-abilities/v1/abilities/wpdocs/report-publication/run', 'verified succeeded report updates wpdocs_base_url']);
  assert.equal(plan.steps.some((step) => step[0] === 'sf' && step[1] === 'status'), true);
  assert.equal(plan.steps.some((step) => step[0] === 'sf' && step[1] === 'domains' && step[2] === 'add'), true);
  assert.equal(plan.steps.some((step) => step[0] === 'sf' && step[1] === 'domains' && step[2] === 'diagnostics'), true);
  assert.equal(JSON.stringify(plan.steps).includes('password'), false);
});

test('requires explicit setup approval and redacts credentials', () => {
  assert.equal(approved({}), false);
  assert.equal(approved({ WP_DOCS_ALLOW_SETUP: '1' }), true);
  assert.equal(redact('failed: secret-value', ['secret-value']), 'failed: [REDACTED]');
});

test('rejects non-HTTPS WordPress origins', () => {
  assert.throws(() => normalizeOrigin('http://example.test'), /absolute HTTPS/);
});

test('validates publication destinations before an approved run', () => {
  assert.equal(normalizeHostname('Docs.Example.test.'), 'docs.example.test');
  assert.equal(normalizeDocsUrl('https://docs.example.test/'), 'https://docs.example.test');
  assert.throws(() => normalizeHostname('https://docs.example.test'), /valid hostname/);
  assert.throws(() => normalizeDocsUrl('https://user:secret@docs.example.test'), /without credentials/);

  const result = spawnSync(process.execPath, ['scripts/setup-customer.mjs'], {
    cwd: process.cwd(),
    encoding: 'utf8',
    env: {
      ...process.env,
      WP_DOCS_ALLOW_SETUP: '1',
      WP_DOCS_ORIGIN: 'https://example.test',
      WP_DOCS_USERNAME: 'administrator',
      WP_DOCS_APP_PASSWORD: 'secret-value',
      WP_DOCS_DOCS_URL: ''
    }
  });
  assert.notEqual(result.status, 0);
  assert.match(result.stderr, /required before an approved run can mutate Spacefast/);
  assert.equal(result.stderr.includes('secret-value'), false);
});

test('recognizes a Push MD clone root without changing bundled content behavior', async () => {
  const root = await mkdtemp(join(tmpdir(), 'wpdocs-content-test-'));
  await mkdir(join(root, 'wpdocs_document', 'guide'), { recursive: true });
  try {
    assert.equal(contentKind(root), 'push-md');
    assert.equal(sourceRootFor(root), join(root, 'wpdocs_document'));
    assert.equal(contentKind('content/runtime'), 'bundled');
  } finally {
    await rm(root, { recursive: true, force: true });
  }
});

test('uses the core Ability REST runner surface, an ephemeral authenticated clone plan, and credential-isolated child environments', () => {
  assert.equal(publicationEndpoint('https://example.test/wp', 'report-publication'), 'https://example.test/wp/wp-json/wp-abilities/v1/abilities/wpdocs/report-publication/run');
  assert.deepEqual(clonePlan('https://example.test/wp-json/git/v1/md.git'), ['git', 'clone', '--depth', '1', 'https://example.test/wp-json/git/v1/md.git', '<ephemeral-content-root>']);
  const child = withoutWordPressCredentials({ WP_DOCS_APP_PASSWORD: 'app-password', WP_DOCS_GIT_PASSWORD: 'git-password', SAFE: '1' });
  assert.deepEqual(child, { SAFE: '1' });
});

test('consumes the oldest queued request and accepts exact ready Spacefast publication evidence', () => {
  const request = selectQueuedPublication([
    { request_id: 'newer', state: 'queued' },
    { request_id: 'running', state: 'running' },
    { request_id: 'older', state: 'queued' }
  ]);
  assert.equal(request.request_id, 'older');

  const publication = parsePublishResult(JSON.stringify({ data: {
    spaceId: 'spc_123', versionId: 'ver_456', versionRef: 'v42', versionStatus: 'ready',
    liveVersionId: 'ver_456', immutableUrl: 'https://v42--docs.view.fast', siteUrl: 'https://docs.view.fast'
  } }));
  assert.deepEqual(publication, {
    spaceId: 'spc_123', versionId: 'ver_456', versionRef: 'v42',
    immutableUrl: 'https://v42--docs.view.fast', siteUrl: 'https://docs.view.fast'
  });
  assert.throws(() => parsePublishResult(JSON.stringify({ data: {
    spaceId: 'spc_123', versionId: 'ver_456', versionStatus: 'ready', liveVersionId: 'ver_old',
    immutableUrl: 'https://v42--docs.view.fast'
  } })), /ready and live/);
});

test('uses the HTTP methods required by WordPress core Ability annotations', async () => {
  const calls = [];
  const originalFetch = globalThis.fetch;
  globalThis.fetch = async (url, options) => {
    calls.push({ url, options });
    return { ok: true, json: async () => ({ data: [] }) };
  };
  try {
    const credentials = { username: 'administrator', password: 'application-password' };
    await callAbility('https://example.test', 'get-publication-status', credentials);
    await callAbility('https://example.test', 'report-publication', credentials, { request_id: 'request', state: 'running' });
  } finally {
    globalThis.fetch = originalFetch;
  }
  assert.equal(calls[0].options.method, 'GET');
  assert.equal(calls[0].options.body, undefined);
  assert.equal(calls[1].options.method, 'POST');
  assert.equal(JSON.parse(calls[1].options.body).state, 'running');
});
