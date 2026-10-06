import { usePage } from '@inertiajs/react';

/**
 * Public-site i18n. `i18n` is the shared prop: {englishKey: translated} for
 * the current locale (empty for en). Keys are the English source strings, so
 * calls read naturally — t('Contact us'), t('{n} products', { n }).
 */
export function useT() {
    const { i18n = {}, locale = 'en' } = usePage().props;

    const t = (key, vars) => {
        let out = i18n[key] ?? key;
        if (vars) {
            for (const [k, v] of Object.entries(vars)) {
                out = out.replaceAll(`{${k}}`, v);
            }
        }
        return out;
    };

    // Prefix an app-relative path with the locale when not English.
    const localize = (path) => {
        if (locale === 'en' || !path || !path.startsWith('/')) return path;
        return `/${locale}${path}`;
    };

    return { t, locale, localize };
}
