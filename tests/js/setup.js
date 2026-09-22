import '@testing-library/jest-dom/vitest';
import React from 'react';
import { vi } from 'vitest';

// jsdom lacks these — stub for components that use them.
window.scrollTo = window.scrollTo || (() => {});

// Inertia's Link/usePage need an app context; provide lightweight mocks so
// components render standalone in tests.
vi.mock('@inertiajs/react', async (importOriginal) => {
    const actual = await importOriginal();
    return {
        ...actual,
        Link: ({ href, children, ...props }) => React.createElement('a', { href, ...props }, children),
        usePage: () => ({
            props: {
                site: {
                    name: 'Nymak Pharma',
                    legal_name: 'Nymak Pharma Private Limited',
                    tagline: 'Efficacy-Driven Lifecare',
                    phone: '+91 98252 25567',
                    phone_href: '+919825225567',
                    whatsapp: '919825225567',
                    email: 'info@nymakpharma.com',
                    address: { street: 'Plot No. 22, Phase 3, Port Biz Industrial Park', city: 'Mundra (Kutch)', region: 'Gujarat', postal_code: '370421', country: 'India' },
                    offices: [],
                    socials: {},
                },
                nav: { categories: [] },
                flash: {},
                auth: {},
            },
            url: '/',
        }),
        router: { post: vi.fn(), get: vi.fn(), patch: vi.fn(), delete: vi.fn(), on: vi.fn() },
        Head: ({ children }) => React.createElement(React.Fragment, null, children),
        useForm: () => ({
            data: {}, errors: {}, processing: false,
            setData: vi.fn(), post: vi.fn(), reset: vi.fn(),
        }),
    };
});
