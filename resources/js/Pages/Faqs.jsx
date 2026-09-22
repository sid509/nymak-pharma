import Accordion from '../Components/Accordion';
import { ButtonLink, Container, PageHero } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

export default function Faqs({ seo, groups }) {
    return (
        <SiteLayout>
            <PageHero eyebrow="FAQs" breadcrumbs={[['Home', '/'], ['FAQs']]}
                title="Frequently asked questions"
                lead="Direct answers about who we are, what we manufacture, where we export and how to work with us." />

            <section className="py-14 sm:py-20">
                <Container className="max-w-4xl">
                    <div className="space-y-12">
                        {groups.map((g) => (
                            <section key={g.category} aria-labelledby={`faq-${g.category.toLowerCase().replace(/\W+/g, '-')}`}>
                                <h2 id={`faq-${g.category.toLowerCase().replace(/\W+/g, '-')}`}
                                    className="mb-5 text-xl font-extrabold text-ink-900">
                                    {g.category}
                                </h2>
                                <Accordion items={g.faqs} />
                            </section>
                        ))}
                    </div>

                    <div className="mt-14 rounded-2xl bg-brand-700 p-8 text-white">
                        <h2 className="text-xl font-extrabold">Still have a question?</h2>
                        <p className="mt-2 max-w-xl text-sm leading-relaxed text-brand-100">
                            Our exports and regulatory teams respond to every enquiry — products, pricing,
                            registration, packaging and logistics.
                        </p>
                        <ButtonLink href="/contact" variant="light" className="mt-5">Ask us directly</ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
