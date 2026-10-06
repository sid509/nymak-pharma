import '@fontsource/inter/400.css';
import '@fontsource/inter/500.css';
import '@fontsource/inter/600.css';
import '@fontsource/inter/700.css';
import '../css/app.css';
import { createInertiaApp, router } from '@inertiajs/react';
import { createRoot, hydrateRoot } from 'react-dom/client';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const appName = 'Nymak Pharma';

// Meta is emitted by Blade from the `seo` page prop (always in HTML, even if
// SSR is down). Inertia removes non-managed <title> tags on navigation, so
// after each visit we re-assert the document title from the new page's props.
// A page_view event keeps GA4 accurate across SPA navigations.
router.on('success', (event) => {
    const page = event.detail.page;
    const title = page?.props?.seo?.title;
    document.title = title ? `${title} | ${appName}` : appName;
    if (window.nymakTrack) {
        window.nymakTrack('page_view', { page_path: page?.url || window.location.pathname });
    }
});

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        // hydrateRoot only when SSR actually rendered markup; on client-only
        // pages (dev with SSR off, SSR fallback) mount fresh to avoid a
        // hydration-mismatch error on an empty #app.
        if (el.hasAttribute('data-server-rendered')) {
            hydrateRoot(el, <App {...props} />);
        } else {
            createRoot(el).render(<App {...props} />);
        }
    },
    progress: {
        color: '#0e7a72',
        showSpinner: false,
    },
});
