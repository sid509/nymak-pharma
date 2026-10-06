import { Link, usePage } from '@inertiajs/react';

/**
 * Inertia <Link> that prefixes internal hrefs with the current locale
 * (/fr/about, /es/products). External URLs and English pass through unchanged.
 * Use it anywhere on the public site in place of <Link>.
 */
export default function LocaleLink({ href, ...props }) {
    const { locale = 'en' } = usePage().props;
    const url = locale !== 'en' && typeof href === 'string' && href.startsWith('/')
        ? `/${locale}${href}`
        : href;

    return <Link href={url} {...props} />;
}
