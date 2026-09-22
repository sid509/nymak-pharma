import { fireEvent, render, screen } from '@testing-library/react';
import { describe, expect, it } from 'vitest';
import Accordion from '../../resources/js/Components/Accordion';

const items = [
    { question: 'Is Nymak Pharma a pharmaceutical exporter?', answer: 'Yes, a Star Export House.' },
    { question: 'Where is it located?', answer: 'Mundra, Gujarat, India.' },
];

describe('Accordion', () => {
    it('renders all questions with accessible buttons', () => {
        render(<Accordion items={items} />);
        for (const item of items) {
            const btn = screen.getByRole('button', { name: item.question });
            expect(btn).toBeInTheDocument();
            expect(btn).toHaveAttribute('aria-expanded');
        }
    });

    it('reveals the answer on click and exposes expanded state', () => {
        render(<Accordion items={items} />);
        const btn = screen.getByRole('button', { name: items[1].question });
        expect(btn).toHaveAttribute('aria-expanded', 'false');
        fireEvent.click(btn);
        expect(btn).toHaveAttribute('aria-expanded', 'true');
        expect(screen.getByText(items[1].answer)).toBeInTheDocument();
    });

    it('closes the open item when clicked again', () => {
        render(<Accordion items={items} />);
        const btn = screen.getByRole('button', { name: items[1].question });
        fireEvent.click(btn);
        fireEvent.click(btn);
        // Content stays mounted for the height transition — assert collapsed state.
        const region = screen.getByText(items[1].answer).closest('[role="region"]');
        expect(btn).toHaveAttribute('aria-expanded', 'false');
        expect(region).toHaveAttribute('aria-hidden', 'true');
        expect(region.className).toContain('grid-rows-[0fr]');
    });

    it('renders nothing harmful for empty items', () => {
        const { container } = render(<Accordion items={[]} />);
        expect(container.querySelector('button')).toBeNull();
    });
});
