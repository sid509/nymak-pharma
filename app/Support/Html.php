<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

/**
 * Sanitises admin-authored WYSIWYG HTML before it is stored. Allows only the
 * formatting the editor can produce so the public site can render it with
 * dangerouslySetInnerHTML safely.
 */
class Html
{
    private static ?HtmlSanitizer $sanitizer = null;

    public static function sanitize(?string $html): ?string
    {
        if ($html === null) {
            return null;
        }

        $clean = trim(static::sanitizer()->sanitize($html));

        // Editors leave trailing empty paragraphs behind; an empty editor is
        // nothing but them — drop the tail, and store null if nothing remains.
        $clean = preg_replace('/(\s*<p>(\s|&nbsp;|<br\s*\/?>)*<\/p>)+$/', '', $clean);

        return $clean === '' ? null : $clean;
    }

    private static function sanitizer(): HtmlSanitizer
    {
        if (static::$sanitizer) {
            return static::$sanitizer;
        }

        $config = (new HtmlSanitizerConfig)
            ->allowElement('p')
            ->allowElement('br')
            ->allowElement('strong')
            ->allowElement('b')
            ->allowElement('em')
            ->allowElement('i')
            ->allowElement('u')
            ->allowElement('s')
            ->allowElement('h2')
            ->allowElement('h3')
            ->allowElement('h4')
            ->allowElement('ul')
            ->allowElement('ol')
            ->allowElement('li')
            ->allowElement('blockquote')
            ->allowElement('a', ['href', 'target', 'rel', 'title'])
            ->allowLinkSchemes(['https', 'http', 'mailto', 'tel'])
            ->allowRelativeLinks()
            ->forceAttribute('a', 'rel', 'noopener noreferrer')
            ->withMaxInputLength(200_000);

        return static::$sanitizer = new HtmlSanitizer($config);
    }
}
