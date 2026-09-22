import { Link } from '@inertiajs/react';
import { ButtonLink, Container } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

const copy = {
    404: {
        title: 'Page not found',
        text: "The page you're looking for doesn't exist or has moved. Try the product catalogue or contact us directly.",
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
    const { title, text } = copy[status] || copy[500];

    return (
        <SiteLayout seo={seo || { title, robots: 'noindex' }}>
            <section className="flex min-h-[60vh] items-center">
                <Container className="py-20 text-center">
                    <p className="text-6xl font-extrabold tracking-tight text-brand-200">{status}</p>
                    <h1 className="mt-4 text-3xl font-extrabold tracking-tight text-ink-900">{title}</h1>
                    <p className="mx-auto mt-3 max-w-md text-ink-600">{text}</p>
                    <div className="mt-8 flex flex-wrap justify-center gap-3">
                        <ButtonLink href="/">Back to home</ButtonLink>
                        <ButtonLink href="/products" variant="outline">Product catalogue</ButtonLink>
                        <ButtonLink href="/contact" variant="ghost">Contact us</ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
