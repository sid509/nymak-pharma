<?php

namespace App\Support;

/**
 * UI-chrome translations use Laravel's JSON translation files (lang/fr.json,
 * lang/es.json) where English source text is the key — the same files power
 * __() server-side and the shared `i18n` prop client-side, so SSR and the
 * browser always agree.
 */
class I18n
{
    /** [key => translated] map for a locale; empty for English. */
    public static function dict(string $locale): array
    {
        if ($locale === 'en') {
            return [];
        }

        $path = lang_path("{$locale}.json");

        return file_exists($path) ? (array) json_decode(file_get_contents($path), true) : [];
    }
}
