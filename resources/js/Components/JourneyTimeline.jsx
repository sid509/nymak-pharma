import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faAward, faBox, faBuilding, faCircleCheck, faDroplet, faFileCircleCheck, faFlask, faGlobe, faMicroscope, faSeedling, faShieldHalved, faShip, faSyringe, faTag } from '@fortawesome/free-solid-svg-icons';
import { Reveal } from './Motion';
import { useT } from '../i18n/useT';

const ICONS = { faAward, faBox, faBuilding, faCircleCheck, faDroplet, faFileCircleCheck, faFlask, faGlobe, faMicroscope, faSeedling, faShieldHalved, faShip, faSyringe, faTag };

/**
 * The pinboard journey timeline: a chevron arrow bar with one segment per
 * year, and image cards hanging off it on stems. Entries sharing a year sit
 * side by side under a single marker. The track scrolls horizontally.
 */
export default function JourneyTimeline({ items }) {
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

    return (
        <div className="journey-scroll" role="region" tabIndex={0} aria-label={t('Company journey timeline')}>
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
                                            ) : photos.map((src) => (
                                                <img key={src} src={`/${src}`} alt="" loading="lazy" decoding="async"
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
    );
}
