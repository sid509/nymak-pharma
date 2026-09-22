import { ChevronDown } from 'lucide-react';
import { useState } from 'react';

/** Accessible FAQ accordion — single-open, keyboard friendly, semantic buttons. */
export default function Accordion({ items }) {
    const [open, setOpen] = useState(0);

    return (
        <div className="divide-y divide-ink-100 rounded-2xl border border-ink-100 bg-white">
            {items.map((item, i) => {
                const isOpen = open === i;
                return (
                    <div key={i}>
                        <h3>
                            <button type="button" onClick={() => setOpen(isOpen ? -1 : i)}
                                    aria-expanded={isOpen} aria-controls={`faq-panel-${i}`} id={`faq-button-${i}`}
                                    className="flex w-full items-center justify-between gap-4 px-5 py-4 text-left text-sm font-bold text-ink-900 transition-colors hover:bg-ink-50 sm:text-base">
                                {item.question}
                                <ChevronDown size={18} aria-hidden
                                             className={`shrink-0 text-brand-600 transition-transform ${isOpen ? 'rotate-180' : ''}`} />
                            </button>
                        </h3>
                        <div id={`faq-panel-${i}`} role="region" aria-labelledby={`faq-button-${i}`}
                             aria-hidden={! isOpen}
                             className={`grid transition-[grid-template-rows] duration-300 ease-out ${isOpen ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'}`}>
                            <div className="overflow-hidden">
                                <div className="px-5 pb-5 text-sm leading-relaxed text-ink-600 sm:text-[15px]">
                                    {item.answer}
                                </div>
                            </div>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
