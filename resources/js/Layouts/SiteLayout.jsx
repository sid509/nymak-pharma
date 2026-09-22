import { usePage } from '@inertiajs/react';
import { CheckCircle2, MessageCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
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
    const { site } = usePage().props;

    return (
        <div className="flex min-h-screen flex-col">
            <a href="#main-content"
               className="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-brand-700 focus:px-4 focus:py-2 focus:text-sm focus:font-bold focus:text-white">
                Skip to main content
            </a>
            <Header />
            <main id="main-content" className="flex-1">{children}</main>
            <Footer />

            {/* WhatsApp — B2B quick contact (tracked, requirement #2) */}
            <a href={`https://wa.me/${site.whatsapp}`} target="_blank" rel="noopener noreferrer"
               aria-label="Chat with Nymak Pharma on WhatsApp"
               onClick={() => window.nymakTrack && window.nymakTrack('contact_click', { method: 'whatsapp' })}
               className="fixed bottom-5 right-5 z-40 flex h-12 w-12 items-center justify-center rounded-full bg-[#25D366] text-white shadow-card transition-transform hover:scale-105">
                <MessageCircle size={24} aria-hidden />
            </a>
            <FlashToast />
        </div>
    );
}
