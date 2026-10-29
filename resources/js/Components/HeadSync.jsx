import { usePage } from '@inertiajs/react';
import { useEffect, useRef } from 'react';

const appName = 'Nymak Pharma';
const OG_LOCALES = { en: 'en_US', fr: 'fr_FR', es: 'es_ES' };

// Meta is emitted by Blade from the `seo` page prop (always in HTML, even if
// SSR is down). Blade-rendered head tags are not Inertia-managed, so without
// this sync a client-side visit keeps the previous page's description, OG
// tags, hreflang links and JSON-LD - every page then looks identical to
// crawlers/extensions. Syncing from committed usePage() props (not router
// events) guarantees the tags match the rendered page. A page_view event
// keeps GA4 accurate across SPA navs.
const upsertMeta = (attr, name, content) => {
    let el = document.head.querySelector(`meta[${attr}="${name}"]`);
    if (!content) {
        el?.remove();
        return;
    }
    if (!el) {
        el = document.createElement('meta');
        el.setAttribute(attr, name);
        document.head.appendChild(el);
    }
    el.setAttribute('content', content);
};

const upsertLink = (rel, extra, content) => {
    const sel = `link[rel="${rel}"]${extra ? `[${extra.name}="${extra.value}"]` : ''}`;
    let el = document.head.querySelector(sel);
    if (!content) {
        el?.remove();
        return;
    }
    if (!el) {
        el = document.createElement('link');
        el.setAttribute('rel', rel);
        if (extra) el.setAttribute(extra.name, extra.value);
        document.head.appendChild(el);
    }
    el.setAttribute('href', content);
};

const syncHead = (page) => {
    const seo = page?.props?.seo || {};
    const locales = page?.props?.locales || {};
    const locale = page?.props?.locale || 'en';
    const fullTitle = seo.title ? `${seo.title} | ${appName}` : appName;

    document.title = fullTitle;
    upsertMeta('name', 'description', seo.description);
    upsertMeta('name', 'robots', seo.robots || 'index, follow, max-image-preview:large');
    upsertLink('canonical', null, seo.canonical);

    document.head.querySelectorAll('link[rel="alternate"][hreflang]').forEach((el) => el.remove());
    Object.entries(locales).forEach(([code, href]) => {
        upsertLink('alternate', { name: 'hreflang', value: code }, href);
    });
    if (locales.en) {
        upsertLink('alternate', { name: 'hreflang', value: 'x-default' }, locales.en);
    }

    upsertMeta('property', 'og:type', seo.type || 'website');
    upsertMeta('property', 'og:title', fullTitle);
    upsertMeta('property', 'og:description', seo.description);
    upsertMeta('property', 'og:url', seo.url || seo.canonical);
    upsertMeta('property', 'og:site_name', seo.site_name || appName);
    upsertMeta('property', 'og:locale', OG_LOCALES[locale] || 'en_US');
    document.head.querySelectorAll('meta[property="og:locale:alternate"]').forEach((el) => el.remove());
    Object.entries(OG_LOCALES).forEach(([code, ogLoc]) => {
        if (code === locale) return;
        const el = document.createElement('meta');
        el.setAttribute('property', 'og:locale:alternate');
        el.setAttribute('content', ogLoc);
        document.head.appendChild(el);
    });
    upsertMeta('property', 'og:image', seo.image);
    upsertMeta('name', 'twitter:card', 'summary_large_image');
    upsertMeta('name', 'twitter:title', fullTitle);
    upsertMeta('name', 'twitter:description', seo.description);
    upsertMeta('name', 'twitter:image', seo.image);

    document.head.querySelectorAll('script[data-page-schema]').forEach((el) => el.remove());
    (seo.schema || []).forEach((node) => {
        const el = document.createElement('script');
        el.type = 'application/ld+json';
        el.setAttribute('data-page-schema', '');
        el.textContent = JSON.stringify({ '@context': 'https://schema.org', ...node });
        document.head.appendChild(el);
    });
};

export default function HeadSync() {
    const page = usePage();
    const mounted = useRef(false);

    useEffect(() => {
        syncHead(page);
        // GA4 sends the initial page_view itself; only track SPA visits.
        if (mounted.current && window.nymakTrack) {
            window.nymakTrack('page_view', { page_path: window.location.pathname });
        }
        mounted.current = true;
    }, [page]);

    return null;
}
