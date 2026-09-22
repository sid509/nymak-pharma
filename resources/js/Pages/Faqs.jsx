import Accordion from '../Components/Accordion';
import { ButtonLink, Container, PageHero } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

export default function Faqs({ seo, groups, content }) {
    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['FAQs']]}
                title={content.hero_title}
                lead={content.hero_lead} />

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
                        <h2 className="text-xl font-extrabold">{content.cta_title}</h2>
                        <p className="mt-2 max-w-xl text-sm leading-relaxed text-brand-100">
                            {content.cta_body}
                        </p>
                        <ButtonLink href="/contact" variant="light" className="mt-5">Ask us directly</ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
