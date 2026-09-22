import { render, screen } from '@testing-library/react';
import { describe, expect, it } from 'vitest';
import SpecTable from '../../resources/js/Components/SpecTable';

describe('SpecTable', () => {
    const products = [
        { name: 'Ciprofloxacin IV', strength: '200 mg/100 ml', pack_size: '100 ml', url: null },
        { name: 'Alumak Tablets', strength: '20+120 mg', pack_size: '6 Tabs', url: '/products/finished-formulations/alumak' },
    ];

    it('renders strength/pack columns by default', () => {
        render(<SpecTable products={products} />);
        expect(screen.getByText('Product Name')).toBeInTheDocument();
        expect(screen.getByText('Strength')).toBeInTheDocument();
        expect(screen.getByText('Pack Size')).toBeInTheDocument();
        expect(screen.getByText('Ciprofloxacin IV')).toBeInTheDocument();
        expect(screen.getByText('200 mg/100 ml')).toBeInTheDocument();
    });

    it('renders specimen mode for diagnostic kits', () => {
        render(<SpecTable mode="specimen" products={[{ name: 'HIV 1 & 2 Test', specimen: 'Serum' }]} />);
        expect(screen.getByText('Specimen')).toBeInTheDocument();
        expect(screen.getByText('Serum')).toBeInTheDocument();
    });

    it('links only rows that have a detail page', () => {
        render(<SpecTable products={products} />);
        const linked = screen.getByRole('link', { name: 'Alumak Tablets' });
        expect(linked).toHaveAttribute('href', '/products/finished-formulations/alumak');
        // Unlinked product renders as plain text, not an anchor.
        expect(screen.getByText('Ciprofloxacin IV').closest('a')).toBeNull();
    });

    it('renders an empty table body for empty data', () => {
        render(<SpecTable products={[]} />);
        expect(screen.getByRole('table')).toBeInTheDocument();
        expect(screen.getAllByRole('row')).toHaveLength(1); // header only
    });
});
