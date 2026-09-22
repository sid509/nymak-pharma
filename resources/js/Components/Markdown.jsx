/**
 * Minimal markdown renderer for post bodies — handles ##/### headings,
 * paragraphs, - lists and **bold** inline. Content is authored by us in
 * seeders, so HTML is escaped first and only our transforms apply.
 */
function escapeHtml(s) {
    return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function inline(text) {
    return escapeHtml(text)
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.+?)\*/g, '<em>$1</em>');
}

export function mdToHtml(md = '') {
    return md
        .split(/\n{2,}/)
        .map((block) => {
            const b = block.trim();
            if (!b) return '';
            if (b.startsWith('### ')) return `<h3>${inline(b.slice(4))}</h3>`;
            if (b.startsWith('## ')) return `<h2>${inline(b.slice(3))}</h2>`;
            if (b.startsWith('# ')) return `<h2>${inline(b.slice(2))}</h2>`;
            if (/^[-*] /m.test(b)) {
                const items = b.split('\n').filter((l) => /^[-*] /.test(l.trim()));
                return `<ul>${items.map((l) => `<li>${inline(l.trim().slice(2))}</li>`).join('')}</ul>`;
            }
            return `<p>${inline(b).replace(/\n/g, ' ')}</p>`;
        })
        .join('\n');
}

export default function Markdown({ body }) {
    return <div className="prose-nymak" dangerouslySetInnerHTML={{ __html: mdToHtml(body) }} />;
}
