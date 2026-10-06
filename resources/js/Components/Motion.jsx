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

/** Scroll-reveal wrapper: children rise/settle into place on first view.
    variant="media" swaps the rise for a clip wipe — for big imagery. */
export function Reveal({ children, className = '', delay = 0, as: Tag = 'div', variant }) {
    const [ref, inView] = useInView();
    const kind = variant === 'media' ? 'reveal-media' : 'reveal';
    return (
        <Tag ref={ref}
             className={`${kind} ${inView ? 'is-visible' : ''} ${className}`}
             style={delay ? { transitionDelay: `${delay}ms` } : undefined}>
            {children}
        </Tag>
    );
}

/**
 * Scroll-progress through an element — 0 at top-of-viewport entry,
 * 1 when the element's bottom reaches the viewport bottom. Used for
 * scroll-driven motion where the scroll relationship carries meaning.
 */
export function useScrollProgress() {
    const ref = useRef(null);
    const [progress, setProgress] = useState(0);

    useEffect(() => {
        const el = ref.current;
        if (! el) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            setProgress(1);
            return;
        }
        let raf = null;
        const update = () => {
            raf = null;
            const rect = el.getBoundingClientRect();
            const vh = window.innerHeight;
            const total = rect.height + vh * 0.4;
            const done = Math.min(Math.max(vh * 0.9 - rect.top, 0), total);
            setProgress(done / total);
        };
        const onScroll = () => { if (! raf) raf = requestAnimationFrame(update); };
        update();
        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll);
        return () => {
            window.removeEventListener('scroll', onScroll);
            window.removeEventListener('resize', onScroll);
            if (raf) cancelAnimationFrame(raf);
        };
    }, []);

    return [ref, progress];
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
