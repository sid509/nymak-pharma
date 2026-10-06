import { ArrowLeft } from 'lucide-react';
import { ButtonLink, Container } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';
import { useT } from '../i18n/useT';

const copy = {
    401: {
        title: 'Sign in required',
        text: 'You need to be signed in to view this page.',
        actions: [{ href: '/admin/login', label: 'Sign in' }],
    },
    402: {
        title: 'Payment required',
        text: 'This page cannot be accessed until payment is completed.',
    },
    403: {
        title: 'Access restricted',
        text: "You don't have permission to view this page. If you believe this is a mistake, contact us and we'll help.",
    },
    404: {
        title: 'Page not found',
        text: "The page you're looking for doesn't exist or has moved. Try the product catalogue or contact us directly.",
        catalogue: true,
    },
    405: {
        title: 'Method not allowed',
        text: 'This page does not support that request. Head back and try another way.',
    },
    408: {
        title: 'Request timed out',
        text: 'The request took too long to complete. Please try again in a moment.',
    },
    419: {
        title: 'Session expired',
        text: 'The page was open too long and your session expired. Go back, refresh, and try again.',
    },
    422: {
        title: 'Unable to process',
        text: 'We could not process that request. Please check what you submitted and try again.',
    },
    429: {
        title: 'Too many requests',
        text: "You've made too many requests in a short time. Please wait a moment and try again.",
    },
    500: {
        title: 'Something went wrong',
        text: 'An unexpected error occurred. Please try again in a moment — or reach us directly by phone or email.',
    },
    503: {
        title: 'Under maintenance',
        text: 'We are performing scheduled maintenance. Please check back shortly.',
    },
};

export default function Error({ status, seo }) {
    const { t } = useT();
    const { title, text, catalogue, actions } = copy[status] || copy[500];

    return (
        <SiteLayout seo={seo || { title, robots: 'noindex' }}>
            <section className="flex min-h-[60vh] items-center">
                <Container className="py-20 text-center">
                    <p className="text-xs font-bold uppercase tracking-widest text-ink-400">{t('Error')} {status}</p>
                    <p className="mt-3 text-7xl font-extrabold tracking-tight text-gradient sm:text-8xl">{status}</p>
                    <h1 className="mt-4 t-page text-ink-900">{t(title)}</h1>
                    <p className="mx-auto mt-3 max-w-md text-ink-600">{t(text)}</p>
                    <div className="mt-8 flex flex-wrap justify-center gap-3">
                        {actions ? (
                            actions.map((a) => <ButtonLink key={a.href} href={a.href}>{t(a.label)}</ButtonLink>)
                        ) : (
                            <ButtonLink href="/">{t('Back to home')}</ButtonLink>
                        )}
                        {catalogue && <ButtonLink href="/products" variant="outline">{t('Product catalogue')}</ButtonLink>}
                        <ButtonLink href="/contact" variant={actions || catalogue ? 'ghost' : 'outline'}>{t('Contact us')}</ButtonLink>
                    </div>
                    <button type="button" onClick={() => window.history.back()}
                            className="mx-auto mt-6 inline-flex items-center gap-1.5 text-xs font-semibold text-ink-400 transition-colors hover:text-ink-700">
                        <ArrowLeft size={13} aria-hidden /> {t('Go back to the previous page')}
                    </button>
                </Container>
            </section>
        </SiteLayout>
    );
}
