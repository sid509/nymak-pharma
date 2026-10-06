import { fireEvent, render, screen } from '@testing-library/react';
import { describe, expect, it, vi } from 'vitest';
import WorldMap, { placeMarkets } from '../../resources/js/Components/WorldMap';
import { countryName, numericId } from '../../resources/js/data/countries';

const markets = [
    { name: 'Sierra Leone', slug: 'sierra-leone', iso_code: 'SL', region: 'West Africa', description: 'Freetown office.', featured: true, latitude: null, longitude: null, products: [] },
    { name: 'Nigeria', slug: 'nigeria', iso_code: 'NG', region: 'West Africa', description: null, featured: true, latitude: null, longitude: null, products: [] },
    { name: 'Kenya', slug: 'kenya', iso_code: 'ke', region: 'East Africa', description: null, featured: false, latitude: null, longitude: null, products: [] },
    { name: 'South Pacific Islands', slug: 'south-pacific', iso_code: null, region: 'Oceania', description: 'First export region.', featured: false, latitude: -17.7, longitude: 178.0, products: [] },
];

describe('countries lookup', () => {
    it('maps alpha-2 codes to atlas ids case-insensitively', () => {
        expect(numericId('NG')).toBe('566');
        expect(numericId('ng')).toBe('566');
        expect(numericId('SL')).toBe('694');
        expect(numericId(null)).toBeNull();
        expect(numericId('XX')).toBeNull();
        expect(countryName('LR')).toBe('Liberia');
    });
});

describe('placeMarkets', () => {
    it('resolves ISO markets to a country + geo centroid, and coordinate markets to their point', () => {
        const placed = placeMarkets(markets);
        const sl = placed.find((m) => m.slug === 'sierra-leone');
        const sp = placed.find((m) => m.slug === 'south-pacific');

        expect(sl.countryId).toBe('694');
        expect(sl.point).toHaveLength(2); // Sierra Leone centroid, ≈ [-11.8, 8.5]
        expect(sl.point[0]).toBeGreaterThan(-14);
        expect(sl.point[0]).toBeLessThan(-8);
        expect(sp.countryId).toBeNull();
        expect(sp.point).toEqual([178, -17.7]);
    });

    it('explicit coordinates override the country centroid', () => {
        const [a] = placeMarkets([{ ...markets[1] }]);
        const [b] = placeMarkets([{ ...markets[1], latitude: 0, longitude: 0 }]);
        expect(a.point).not.toEqual(b.point);
        expect(b.point).toEqual([0, 0]);
        expect(b.countryId).toBe('566');
    });
});

describe('WorldMap globe', () => {
    it('renders visible market countries as buttons, with the selected one pressed', () => {
        render(<WorldMap markets={markets} selected="nigeria" onSelect={() => {}} />);
        // The opening view centres on the Indian Ocean — African markets are
        // in frame; South Pacific is on the far side and reaches the user via
        // the list (selecting it spins the globe round).
        expect(screen.getByRole('button', { name: /Nigeria/ })).toHaveAttribute('aria-pressed', 'true');
        expect(screen.getByRole('button', { name: /Sierra Leone/ })).toHaveAttribute('aria-pressed', 'false');
        expect(screen.getByRole('button', { name: /Kenya/ })).toBeInTheDocument();
    });

    it('draws a supply-route arc from Mundra to every market', () => {
        const { container } = render(<WorldMap markets={markets} selected={null} onSelect={() => {}} />);
        const arcs = container.querySelectorAll('.globe-arc');
        expect(arcs.length).toBe(4); // one per market, visible or not
        const runner = container.querySelectorAll('.globe-arc-run');
        expect(runner.length).toBe(4);
        expect(container.querySelector('.globe-hq')).not.toBeNull(); // Mundra HQ marker
    });

    // Found in browser UAT: the arcs are painted over country shapes — without
    // pointer-events:none they swallowed clicks aimed at markets beneath them.
    it('keeps decorative route arcs out of the hit target', () => {
        const { container } = render(<WorldMap markets={markets} selected={null} onSelect={() => {}} />);
        const routes = container.querySelector('.globe-routes');
        expect(routes.style.pointerEvents).toBe('none');
        expect(routes.getAttribute('aria-hidden')).not.toBeNull();
    });

    it('selects on click and deselects when the active country is clicked again', () => {
        const onSelect = vi.fn();
        const { rerender } = render(<WorldMap markets={markets} selected={null} onSelect={onSelect} />);
        fireEvent.click(screen.getByRole('button', { name: /Kenya/ }));
        expect(onSelect).toHaveBeenLastCalledWith('kenya');

        rerender(<WorldMap markets={markets} selected="kenya" onSelect={onSelect} />);
        fireEvent.click(screen.getByRole('button', { name: /Kenya/ }));
        expect(onSelect).toHaveBeenLastCalledWith(null);
    });

    it('is keyboard operable', () => {
        const onSelect = vi.fn();
        render(<WorldMap markets={markets} selected={null} onSelect={onSelect} />);
        const sl = screen.getByRole('button', { name: /Sierra Leone/ });
        expect(sl).toHaveAttribute('tabindex', '0');
        fireEvent.keyDown(sl, { key: 'Enter' });
        expect(onSelect).toHaveBeenCalledWith('sierra-leone');
    });

    it('shows a hover card with the market summary on focus', () => {
        render(<WorldMap markets={markets} selected={null} onSelect={() => {}} />);
        expect(screen.queryByRole('tooltip')).toBeNull();
        fireEvent.focus(screen.getByRole('button', { name: /Sierra Leone/ }));
        const tip = screen.getByRole('tooltip');
        expect(tip).toHaveTextContent('Sierra Leone');
        expect(tip).toHaveTextContent('Freetown office.');
        fireEvent.blur(screen.getByRole('button', { name: /Sierra Leone/ }));
        expect(screen.queryByRole('tooltip')).toBeNull();
    });
});
