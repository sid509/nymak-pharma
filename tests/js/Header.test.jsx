import { fireEvent, render, screen } from '@testing-library/react';
import { describe, expect, it } from 'vitest';
import Header from '../../resources/js/Components/Header';

describe('Header', () => {
    it('renders primary navigation with the contact CTA', () => {
        render(<Header />);
        expect(screen.getByRole('navigation', { name: 'Primary' })).toBeInTheDocument();
        expect(screen.getByRole('link', { name: 'Contact Us' })).toHaveAttribute('href', '/contact');
    });

    it('exposes the products dropdown with aria state', () => {
        render(<Header />);
        const btn = screen.getByRole('button', { name: /product categories/i });
        expect(btn).toHaveAttribute('aria-expanded', 'false');
        fireEvent.click(btn);
        expect(btn).toHaveAttribute('aria-expanded', 'true');
    });

    it('Products nav item links to /products (not just a toggle)', () => {
        render(<Header />);
        expect(screen.getAllByRole('link', { name: 'Products' })[0])
            .toHaveAttribute('href', '/products');
    });

    it('toggles the mobile menu', () => {
        render(<Header />);
        const toggle = screen.getByRole('button', { name: /open menu/i });
        fireEvent.click(toggle);
        expect(screen.getByRole('navigation', { name: 'Mobile' })).toBeInTheDocument();
        fireEvent.click(screen.getByRole('button', { name: /close menu/i }));
        expect(screen.queryByRole('navigation', { name: 'Mobile' })).toBeNull();
    });

    it('has a reachable brand link', () => {
        render(<Header />);
        expect(screen.getByRole('link', { name: /nymak pharma — home/i })).toHaveAttribute('href', '/');
    });
});
