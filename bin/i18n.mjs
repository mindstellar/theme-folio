/*
 * Folio — a Shopclass public theme.
 * Copyright (c) 2026 Navjot Tomer (Mindstellar) and contributors
 * SPDX-License-Identifier: GPL-3.0-or-later
 *
 * Scans the theme's PHP for translatable strings and rewrites
 * languages/folio.pot.
 *
 *   node bin/i18n.mjs
 *
 * Node's standard library only — no npm, no package.json, no install step. The
 * theme ships no build output, and this must not be the thing that gives it one:
 * it is a maintenance tool a person runs after changing UI strings, and it is
 * excluded from the release archive.
 */

import fs from 'node:fs';
import path from 'node:path';
import url from 'node:url';

const ROOT = path.resolve(path.dirname(url.fileURLToPath(import.meta.url)), '..');
const LANG_DIR = path.join(ROOT, 'languages');
const POT = path.join(LANG_DIR, 'folio.pot');
const DOMAIN = 'folio';

/** Single-quoted PHP string, honouring \' and \\ */
const STR = String.raw`'((?:[^'\\]|\\.)*)'`;
// __('text', 'folio') and _e('text', 'folio')
const SINGULAR = new RegExp(String.raw`\b(?:__|_e)\(\s*${STR}\s*,\s*'${DOMAIN}'\s*\)`, 'g');
// _n('one', 'many', $n, 'folio')
const PLURAL = new RegExp(String.raw`\b_n\(\s*${STR}\s*,\s*${STR}\s*,`, 'g');

function themeVersion() {
    const index = fs.readFileSync(path.join(ROOT, 'index.php'), 'utf8');
    const m = index.match(/^Version:\s*(.+)$/m);
    return m ? m[1].trim() : '0';
}

function phpFiles(dir, out = []) {
    for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
        if (entry.name === '.git' || entry.name === 'bin' || entry.name === 'languages') {
            continue;
        }
        const full = path.join(dir, entry.name);
        if (entry.isDirectory()) {
            phpFiles(full, out);
        } else if (entry.name.endsWith('.php')) {
            out.push(full);
        }
    }
    return out;
}

/** PHP single-quoted source -> the actual string. */
const decode = (s) => s.replace(/\\(['\\])/g, '$1');

/** The actual string -> a .po double-quoted literal. */
const encode = (s) =>
    '"' + s.replace(/\\/g, '\\\\').replace(/"/g, '\\"').replace(/\n/g, '\\n') + '"';

const lineAt = (text, index) => text.slice(0, index).split('\n').length;

// msgid -> { plural, refs[] }. Insertion order is the file walk, then sorted below.
const entries = new Map();

function record(msgid, plural, ref) {
    if (msgid === '') {
        return;
    }
    if (!entries.has(msgid)) {
        entries.set(msgid, { plural: null, refs: [] });
    }
    const entry = entries.get(msgid);
    if (plural && !entry.plural) {
        entry.plural = plural;
    }
    if (!entry.refs.includes(ref)) {
        entry.refs.push(ref);
    }
}

for (const file of phpFiles(ROOT).sort()) {
    const source = fs.readFileSync(file, 'utf8');
    // POSIX separators: a Windows checkout must not rewrite every reference.
    const rel = path.relative(ROOT, file).split(path.sep).join('/');

    for (const m of source.matchAll(SINGULAR)) {
        record(decode(m[1]), null, `${rel}:${lineAt(source, m.index)}`);
    }
    for (const m of source.matchAll(PLURAL)) {
        record(decode(m[1]), decode(m[2]), `${rel}:${lineAt(source, m.index)}`);
    }
}

const header = [
    'msgid ""',
    'msgstr ""',
    `"Project-Id-Version: Folio ${themeVersion()}\\n"`,
    '"Report-Msgid-Bugs-To: https://github.com/mindstellar/theme-folio/issues\\n"',
    '"MIME-Version: 1.0\\n"',
    '"Content-Type: text/plain; charset=UTF-8\\n"',
    '"Content-Transfer-Encoding: 8bit\\n"',
    '"Plural-Forms: nplurals=2; plural=(n != 1);\\n"',
    '"Language: \\n"',
].join('\n');

const blocks = [...entries.entries()]
    .sort(([a], [b]) => (a < b ? -1 : a > b ? 1 : 0))
    .map(([msgid, { plural, refs }]) => {
        const lines = refs.map((r) => `#: ${r}`);
        lines.push(`msgid ${encode(msgid)}`);
        if (plural) {
            lines.push(`msgid_plural ${encode(plural)}`);
            lines.push('msgstr[0] ""');
            lines.push('msgstr[1] ""');
        } else {
            lines.push('msgstr ""');
        }
        return lines.join('\n');
    });

fs.mkdirSync(LANG_DIR, { recursive: true });
fs.writeFileSync(POT, `${header}\n\n${blocks.join('\n\n')}\n`, 'utf8');

const silence = path.join(LANG_DIR, 'index.php');
if (!fs.existsSync(silence)) {
    fs.writeFileSync(silence, '<?php // Silence.\n', 'utf8');
}

console.log(`folio.pot: ${entries.size} strings from ${phpFiles(ROOT).length} files`);
