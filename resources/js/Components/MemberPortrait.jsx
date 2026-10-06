/**
 * Team portrait tile — brand duotone + the site's concentric-ring motif.
 * Shows the member's photo as a centred circle (the format their assets ship
 * in), falling back to initials when no photo is uploaded. Tone alternates
 * per member (stable by slug) so grids carry rhythm.
 */
const TONES = {
    green: 'from-brand-900 via-brand-700 to-brand-500',
    blue: 'from-gold-900 via-gold-700 to-gold-500',
};

export function portraitTone(member) {
    const s = member.slug || member.name || '';
    return [...s].reduce((a, c) => a + c.charCodeAt(0), 0) % 2 ? 'blue' : 'green';
}

export default function MemberPortrait({ member, tone, className = '', initialClass = 'text-4xl', photoClass = 'h-28 w-28 sm:h-36 sm:w-36' }) {
    return (
        <div className={`relative grid h-full w-full place-items-center overflow-hidden bg-gradient-to-br ${TONES[tone ?? portraitTone(member)]} ${className}`}>
            {/* concentric rings — the site's route-map motif, bottom-right */}
            <svg className="absolute -bottom-12 -right-12 h-48 w-48 text-white/[0.12]" viewBox="0 0 200 200" fill="none" aria-hidden>
                {[97, 74, 51, 28].map((r) => <circle key={r} cx="100" cy="100" r={r} stroke="currentColor" strokeWidth="1.25" />)}
            </svg>
            <svg className="absolute -left-9 -top-9 h-28 w-28 text-white/[0.08]" viewBox="0 0 200 200" fill="none" aria-hidden>
                <circle cx="100" cy="100" r="95" stroke="currentColor" strokeWidth="1.5" />
            </svg>
            {/* top sheen so the tile sits in the same light as the photos it frames */}
            <div className="absolute inset-0 bg-gradient-to-b from-white/[0.16] via-transparent to-black/[0.14]" aria-hidden />
            {member.photo ? (
                <img src={`/${member.photo}`} alt={member.name} loading="lazy"
                     className={`relative rounded-full object-cover object-top shadow-xl ring-4 ring-white/85 transition-opacity duration-300 group-hover:opacity-30 ${photoClass}`} />
            ) : (
                <span className={`relative font-semibold tracking-[0.05em] text-white/95 transition-opacity duration-300 group-hover:opacity-30 ${initialClass}`} aria-hidden>{member.initials}</span>
            )}
        </div>
    );
}
