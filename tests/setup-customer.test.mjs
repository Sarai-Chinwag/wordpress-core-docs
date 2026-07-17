import assert from 'node:assert/strict';
import { spawnSync } from 'node:child_process';
import { mkdtemp, mkdir, rm } from 'node:fs/promises';
import test from 'node:test';
import { tmpdir } from 'node:os';
import { join } from 'node:path';
import { approved, contentKind, normalizeDocsUrl, normalizeHostname, normalizeOrigin, planSetup, redact, sourceRootFor } from '../scripts/setup-customer.mjs';

test('plans a normalized, provider-neutral setup without credential arguments', () => {
  const plan = planSetup({ origin: 'https://Example.test/wp/', contentRoot: 'content/runtime', space: 'customer-docs', customHostname: 'docs.example.test', docsUrl: 'https://docs.example.test' });
  assert.equal(plan.origin, 'https://example.test/wp');
  assert.deepEqual(plan.steps.at(0), ['GET', 'https://example.test/wp/wp-json/wp/v2/settings?context=edit']);
  assert.deepEqual(plan.steps.at(-1), ['PUT', 'https://example.test/wp/wp-json/wp/v2/settings', 'wpdocs_base_url after hostname health check']);
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
