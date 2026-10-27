import { fireEvent, render, screen } from '@testing-library/react';
import { describe, expect, it, vi } from 'vitest';
import WorldMap, { placeMarkets } from '../../resources/js/Components/WorldMap';
import { countryName, numericId } from '../../resources/js/data/countries';

const markets = [
    { name: 'Sierra Leone', slug: 'sierra-leone', iso_code: 'SL', region: 'West Africa', description: 'Freetown office.', featured: true, pin_type: 'presence', latitude: null, longitude: null, products: [] },
    { name: 'Nigeria', slug: 'nigeria', iso_code: 'NG', region: 'West Africa', description: null, featured: true, pin_type: 'partner', latitude: null, longitude: null, products: [] },
    { name: 'Kenya', slug: 'kenya', iso_code: 'ke', region: 'East Africa', description: null, featured: false, pin_type: 'ethical', latitude: null, longitude: null, products: [] },
    { name: 'South Pacific Islands', slug: 'south-pacific', iso_code: null, region: 'Oceania', description: 'First export region.', featured: false, pin_type: 'partner', latitude: -17.7, longitude: 178.0, products: [] },
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

describe('WorldMap pinboard', () => {
    it('renders a pin button for every market, wherever it sits on the board', () => {
        render(<WorldMap markets={markets} selected="nigeria" onSelect={() => {}} />);
        // Flat board - no hemisphere hiding: every pinned market is a button,
        // including coordinate-only regions like the South Pacific.
        expect(screen.getByRole('button', { name: /Nigeria/ })).toHaveAttribute('aria-pressed', 'true');
        expect(screen.getByRole('button', { name: /Sierra Leone/ })).toHaveAttribute('aria-pressed', 'false');
        expect(screen.getByRole('button', { name: /Kenya/ })).toBeInTheDocument();
        expect(screen.getByRole('button', { name: /South Pacific Islands/ })).toBeInTheDocument();
    });

    it('colours each pin by its pin_type and marks the selected one', () => {
        const { container } = render(<WorldMap markets={markets} selected="kenya" onSelect={() => {}} />);
        expect(container.querySelector('.ppin-presence')).not.toBeNull(); // Sierra Leone + HQ
        expect(container.querySelector('.ppin-partner')).not.toBeNull();
        expect(container.querySelector('.ppin-ethical')).not.toBeNull();
        const kenya = screen.getByRole('button', { name: /Kenya/ });
        expect(kenya.classList.contains('ppin-ethical')).toBe(true);
        expect(kenya).toHaveAttribute('data-selected', 'true');
    });

    it('falls back to a partner pin when pin_type is missing or unknown', () => {
        const { container } = render(<WorldMap markets={[{ ...markets[1], pin_type: undefined }, { ...markets[2], pin_type: 'bogus' }]} selected={null} onSelect={() => {}} />);
        expect(container.querySelectorAll('.map-pins .ppin-partner').length).toBe(2);
    });

    it('draws the Mundra HQ pin as a non-interactive presence marker', () => {
        const { container } = render(<WorldMap markets={markets} selected={null} onSelect={() => {}} />);
        const hq = container.querySelector('.ppin-presence[aria-hidden="true"]');
        expect(hq).not.toBeNull();
        expect(hq.querySelector('title').textContent).toContain('Mundra');
    });

    it('selects on pin click and deselects when the active pin is clicked again', () => {
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
