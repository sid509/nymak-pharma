import { useEffect, useRef, useState } from 'react';

/**
 * Motion primitives — IntersectionObserver-driven reveals and counters.
 * All states render fully visible without JS and respect
 * prefers-reduced-motion (handled in app.css).
 */

export function useInView({ threshold = 0.15, once = true } = {}) {
    const ref = useRef(null);
    const [inView, setInView] = useState(false);

    useEffect(() => {
        const el = ref.current;
        if (! el || typeof IntersectionObserver === 'undefined') {
            setInView(true);
            return;
        }
        const io = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting) {
                setInView(true);
                if (once) io.disconnect();
            } else if (! once) {
                setInView(false);
            }
        }, { threshold });
        io.observe(el);
        return () => io.disconnect();
    }, [threshold, once]);

    return [ref, inView];
}

/** Scroll-reveal wrapper: children rise/settle into place on first view. */
export function Reveal({ children, className = '', delay = 0, as: Tag = 'div' }) {
    const [ref, inView] = useInView();
    return (
        <Tag ref={ref}
             className={`reveal ${inView ? 'is-visible' : ''} ${className}`}
             style={delay ? { transitionDelay: `${delay}ms` } : undefined}>
            {children}
        </Tag>
    );
}

/** Counts an integer up when scrolled into view. "24+" renders 0→24 then keeps the suffix. */
export function CountUp({ value, className = '' }) {
    const [ref, inView] = useInView({ threshold: 0.6 });
    const [display, setDisplay] = useState(() => value);

    useEffect(() => {
        const match = String(value).match(/^(\d+)(.*)$/);
        if (! inView || ! match) { setDisplay(value); return; }
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            setDisplay(value);
            return;
        }
        const target = parseInt(match[1], 10);
        const suffix = match[2];
        const start = performance.now();
        const duration = 900;
        let raf;
        const tick = (now) => {
            const t = Math.min(1, (now - start) / duration);
            const eased = 1 - Math.pow(1 - t, 3);
            setDisplay(`${Math.round(target * eased)}${suffix}`);
            if (t < 1) raf = requestAnimationFrame(tick);
        };
        raf = requestAnimationFrame(tick);
        return () => cancelAnimationFrame(raf);
    }, [inView, value]);

    return <span ref={ref} className={className}>{display}</span>;
}
