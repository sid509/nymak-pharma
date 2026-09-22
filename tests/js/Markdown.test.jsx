import { describe, expect, it } from 'vitest';
import { mdToHtml } from '../../resources/js/Components/Markdown';

describe('mdToHtml', () => {
    it('renders headings and paragraphs', () => {
        const html = mdToHtml('Intro para.\n\n## A heading\n\nAnother para.');
        expect(html).toContain('<p>Intro para.</p>');
        expect(html).toContain('<h2>A heading</h2>');
        expect(html).toContain('<p>Another para.</p>');
    });

    it('renders lists', () => {
        const html = mdToHtml('- one\n- two');
        expect(html).toContain('<ul><li>one</li><li>two</li></ul>');
    });

    it('renders bold inline', () => {
        expect(mdToHtml('text **bold** end')).toContain('<strong>bold</strong>');
    });

    it('escapes raw HTML — content is author-controlled but never trusted', () => {
        const html = mdToHtml('Safe <script>alert(1)</script>');
        expect(html).not.toContain('<script>');
        expect(html).toContain('&lt;script&gt;');
    });

    it('handles empty input', () => {
        expect(mdToHtml('')).toBe('');
        expect(mdToHtml(undefined)).toBe('');
    });
});
