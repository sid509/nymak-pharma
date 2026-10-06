import { usePage } from '@inertiajs/react';
import { CheckCircle2, FileDown } from 'lucide-react';
import { useEffect, useState } from 'react';
import { WhatsAppIcon } from '../Components/Ui';
import Footer from '../Components/Footer';
import Header from '../Components/Header';

function FlashToast() {
    const { flash } = usePage().props;
    const [visible, setVisible] = useState(false);

    useEffect(() => {
        if (flash?.success || flash?.error) {
            setVisible(true);
            const t = setTimeout(() => setVisible(false), 6000);
            return () => clearTimeout(t);
        }
    }, [flash]);

    if (!visible || !(flash?.success || flash?.error)) return null;

    return (
        <div role="status" aria-live="polite"
             className="fixed bottom-6 left-1/2 z-50 flex w-[calc(100%-2rem)] max-w-md -translate-x-1/2 items-start gap-3 rounded-xl border border-brand-200 bg-white p-4 shadow-card">
            <CheckCircle2 size={20} className="mt-0.5 shrink-0 text-brand-600" aria-hidden />
            <p className="text-sm font-medium text-ink-800">{flash.success || flash.error}</p>
        </div>
    );
}

export default function SiteLayout({ children }) {
    const site = usePage().props.site || {};
    const url = usePage().url;

    // Tawk.to live chat — official embed, loaded on every page when the
    // property/widget ID is set in Admin → Settings. Tawk renders its own
    // default bubble bottom-right ("we're here" greeting, online status
    // etc. are configured in the Tawk dashboard, not here).
    useEffect(() => {
        if (!site?.tawk_property || document.getElementById('tawk-embed')) return;
        window.Tawk_API = window.Tawk_API || {};
        window.Tawk_LoadStart = new Date();
        const s1 = document.createElement('script');
        const s0 = document.getElementsByTagName('script')[0];
        s1.id = 'tawk-embed';
        s1.async = true;
        s1.src = `https://embed.tawk.to/${site.tawk_property}`;
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    }, [site?.tawk_property]);

    return (
        <div className="flex min-h-screen flex-col">
            <a href="#main-content"
               className="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-brand-700 focus:px-4 focus:py-2 focus:text-sm focus:font-bold focus:text-white">
                Skip to main content
            </a>
            <Header />
            {/* key remounts per Inertia page → page-enter replays on each navigation */}
            <main id="main-content" key={url} className="page-enter flex-1">{children}</main>
            <Footer />

            {/* Brochure FAB — expands to reveal its label on hover; PDF badge cues the file type */}
            {site.brochure && (
                <a href={`/${site.brochure}`} target="_blank" rel="noopener noreferrer"
                   aria-label="Download Nymak Pharma product brochure (PDF)"
                   onClick={() => window.nymakTrack && window.nymakTrack('brochure_download', { placement: 'fab' })}
                   className="fab-brochure group fixed bottom-[77px] left-5 z-40 flex h-12 items-center rounded-full bg-brand-600 text-white shadow-card transition-[transform,box-shadow] duration-200 hover:-translate-y-0.5 hover:bg-brand-700 hover:shadow-card-hover">
                    <span className="relative grid h-12 w-12 shrink-0 place-items-center">
                        <FileDown size={20} aria-hidden className="fab-file" />
                        <span className="absolute -right-1 -top-1 rounded-full bg-red-600 px-1 py-px text-[7px] font-extrabold uppercase leading-none tracking-wide text-white ring-2 ring-white/90 transition-transform duration-200 group-hover:scale-110" aria-hidden>PDF</span>
                    </span>
                    <span className="max-w-0 overflow-hidden whitespace-nowrap text-sm font-semibold opacity-0 transition-[max-width,opacity,padding] duration-300 ease-out group-hover:max-w-32 group-hover:pr-4 group-hover:opacity-100">
                        Brochure <span className="text-white/70">· PDF</span>
                    </span>
                </a>
            )}

            {/* WhatsApp — B2B quick contact (tracked, requirement #2) */}
            <a href={`https://wa.me/${site.whatsapp}`} target="_blank" rel="noopener noreferrer"
               aria-label="Chat with Nymak Pharma on WhatsApp"
               onClick={() => window.nymakTrack && window.nymakTrack('contact_click', { method: 'whatsapp' })}
               className="fixed bottom-5 left-5 z-40 flex h-12 w-12 items-center justify-center rounded-full bg-[#25D366] text-white shadow-card transition-transform hover:scale-105">
                <WhatsAppIcon size={24} />
            </a>

            <FlashToast />
        </div>
    );
}
