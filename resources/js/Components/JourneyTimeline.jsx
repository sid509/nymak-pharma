import { useEffect, useRef, useState } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faAward, faBox, faBuilding, faChevronLeft, faChevronRight, faCircleCheck, faDroplet, faFileCircleCheck, faFlask, faGlobe, faLocationDot, faMicroscope, faSeedling, faShieldHalved, faShip, faSyringe, faTag, faWarehouse } from '@fortawesome/free-solid-svg-icons';
import { Reveal } from './Motion';
import { useT } from '../i18n/useT';

const ICONS = { faAward, faBox, faBuilding, faCircleCheck, faDroplet, faFileCircleCheck, faFlask, faGlobe, faLocationDot, faMicroscope, faSeedling, faShieldHalved, faShip, faSyringe, faTag, faWarehouse };

/**
 * The pinboard journey timeline: a chevron arrow bar with one segment per
 * year, and image cards hanging off it on stems. Entries sharing a year sit
 * side by side under a single marker. The track scrolls horizontally.
 */
export default function JourneyTimeline({ items, partners = [] }) {
    const { t } = useT();
    if (!items?.length) {
        return null;
    }

    // Group consecutive entries by year: each gets one chevron segment that
    // spans however many cards belong to it.
    const years = [];
    items.forEach((item) => {
        const last = years[years.length - 1];
        if (last && last.year === item.year) {
            last.count += 1;
        } else {
            years.push({ year: item.year, count: 1 });
        }
    });

    const cols = `repeat(${items.length}, minmax(11rem, 13.5rem))`;
    const railRef = useRef(null);
    const [edge, setEdge] = useState('start');
    const onScroll = () => {
        const el = railRef.current;
        if (!el) return;
        const max = el.scrollWidth - el.clientWidth - 8;
        setEdge(el.scrollLeft <= 8 ? 'start' : el.scrollLeft >= max ? 'end' : 'mid');
    };
    useEffect(() => {
        onScroll();
        // Scroll-snap can shift scrollLeft while lazy images reflow the
        // track - recompute the edge state on every resize so the arrows
        // never stick at a stale end position.
        const ro = new ResizeObserver(onScroll);
        if (railRef.current) {
            ro.observe(railRef.current);
            ro.observe(railRef.current.firstElementChild);
        }
        window.addEventListener('resize', onScroll);
        return () => { ro.disconnect(); window.removeEventListener('resize', onScroll); };
    }, []);
    const nudge = (dir) => railRef.current?.scrollBy({ left: dir * railRef.current.clientWidth * 0.7, behavior: 'smooth' });

    return (
        <div>
            {partners.length > 0 && (
                <ul className="journey-partners" aria-label={t('Group companies')}>
                    {partners.map((p) => (
                        <li key={p.name}>
                            {p.image
                                ? <img src={`/${p.image}`} alt={`${p.name} logo`} loading="lazy" decoding="async" />
                                : <span className="journey-partner-mark" aria-hidden>{p.name.charAt(0)}</span>}
                            <span>{p.name}</span>
                        </li>
                    ))}
                </ul>
            )}
            <div className="journey-rail">
            <button type="button" className="journey-nav journey-nav--prev" onClick={() => nudge(-1)}
                disabled={edge === 'start'} aria-label={t('Earlier milestones')}>
                <FontAwesomeIcon icon={faChevronLeft} aria-hidden />
            </button>
            <div className="journey-scroll" role="region" tabIndex={0} aria-label={t('Company journey timeline')}
                ref={railRef} onScroll={onScroll}>
            <div className="journey-track">
                <div className="journey-bar" style={{ gridTemplateColumns: cols }} aria-hidden="true">
                    {years.map((y, i) => (
                        <div key={`${y.year}-${i}`} className="journey-year" style={{ gridColumn: `span ${y.count}` }}>
                            <span className="journey-year-label">{y.year}</span>
                            <span className={`journey-seg ${i % 2 ? 'journey-seg--gold' : 'journey-seg--ink'}`} />
                        </div>
                    ))}
                </div>
                <ol className="journey-items" style={{ gridTemplateColumns: cols }}>
                    {items.map((item, i) => {
                        const FaIcon = ICONS[item.icon] || faAward;
                        const photos = [item.image, item.image_2].filter(Boolean);
                        return (
                            <li key={`${item.year}-${item.title}-${i}`} className="journey-node">
                                <Reveal delay={Math.min(i, 8) * 50}>
                                    <figure>
                                        <div className={`journey-imgs ${photos.length > 1 ? 'journey-imgs--duo' : ''}`}>
                                            {photos.length === 0 ? (
                                                <span className="journey-icon-tile"><FontAwesomeIcon icon={FaIcon} aria-hidden /></span>
                                            ) : photos.map((src, pi) => (
                                                <img key={src} src={`/${src}`} alt={pi === 0 ? `${item.title}, ${item.year}` : ''} loading="lazy" decoding="async"
                                                    className={item.fit === 'contain' ? 'journey-img-contain' : ''} />
                                            ))}
                                        </div>
                                        <figcaption>
                                            <span className="sr-only">{item.year}: </span>
                                            <h3>{item.title}</h3>
                                            {item.body && <p>{item.body}</p>}
                                        </figcaption>
                                    </figure>
                                </Reveal>
                            </li>
                        );
                    })}
                </ol>
            </div>
            </div>
            <button type="button" className="journey-nav journey-nav--next" onClick={() => nudge(1)}
                disabled={edge === 'end'} aria-label={t('Later milestones')}>
                <FontAwesomeIcon icon={faChevronRight} aria-hidden />
            </button>
            </div>
        </div>
    );
}
