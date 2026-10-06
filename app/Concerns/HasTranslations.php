<?php

namespace App\Concerns;

/**
 * Per-record field translations stored in an `i18n` JSON column:
 *
 *   { "fr": { "name": "…" }, "es": { "name": "…" } }
 *
 * Models declare `protected array $translatable = ['name', ...]` — the list of
 * attributes visitors may translate. On non-English requests (locale set by the
 * SetLocale middleware on public routes) attribute reads and toArray()
 * serialization resolve through the translation with an English fallback, so
 * controllers, SEO tags and JSON-LD get localized content without changes.
 * Admin routes never set a non-EN locale, so editing always sees base values.
 */
trait HasTranslations
{
    /** Translatable fields that hold rich HTML (sanitised on write). */
    private const HTML_FIELDS = ['content', 'body', 'description', 'answer', 'bio', 'value'];

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if ($key !== 'i18n' && in_array($key, $this->translatableFields(), true)) {
            $translated = $this->translationFor($key);
            if ($translated !== null) {
                return $translated;
            }
        }

        return $value;
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        if (app()->getLocale() !== 'en') {
            foreach ($this->translatableFields() as $field) {
                $translated = $this->translationFor($field);
                if ($translated !== null) {
                    $attributes[$field] = $translated;
                }
            }
        }

        return $attributes;
    }

    /**
     * Explicit translation lookup — falls back to the base (English) value.
     */
    public function trans(string $field, ?string $locale = null): mixed
    {
        $locale ??= app()->getLocale();
        $base = $this->getRawOriginal($field) ?? parent::getAttribute($field);

        if ($locale === 'en') {
            return $base;
        }

        $translated = data_get($this->i18nArray(), "{$locale}.{$field}");

        return ($translated === null || $translated === '') ? $base : $translated;
    }

    /**
     * All translations for one locale: [field => value].
     */
    public function translationsFor(string $locale): array
    {
        return (array) data_get($this->i18nArray(), $locale, []);
    }

    /**
     * Merge translations for a locale (used by admin form saves).
     */
    public function setTranslations(string $locale, array $fields): void
    {
        $allowed = array_flip($this->translatableFields());
        $i18n = $this->i18nArray();
        $existing = (array) ($i18n[$locale] ?? []);

        foreach (array_intersect_key($fields, $allowed) as $field => $value) {
            // Rich-text fields are sanitised just like their base attribute.
            $existing[$field] = $value !== null && in_array($field, self::HTML_FIELDS, true)
                ? \App\Support\Html::sanitize($value)
                : $value;
        }

        $i18n[$locale] = array_filter($existing, fn ($v) => $v !== null && $v !== '');
        if ($i18n[$locale] === []) {
            unset($i18n[$locale]);
        }

        $this->i18n = $i18n === [] ? null : $i18n;
    }

    /**
     * Current-request translation for a field, null when not applicable.
     */
    private function translationFor(string $field): mixed
    {
        if (($locale = app()->getLocale()) === 'en') {
            return null;
        }

        $translated = data_get($this->i18nArray(), "{$locale}.{$field}");

        return ($translated === null || $translated === '') ? null : $translated;
    }

    /**
     * The i18n column as an array — reads the raw attribute and decodes, so it
     * works on partially-hydrated models regardless of the cast.
     */
    private function i18nArray(): array
    {
        $raw = $this->getAttributeFromArray('i18n');
        if (is_string($raw)) {
            $raw = json_decode($raw, true);
        }

        return is_array($raw) ? $raw : [];
    }

    protected function translatableFields(): array
    {
        return property_exists($this, 'translatable') ? $this->translatable : [];
    }
}
