import { Container, PageHero } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

const content = {
    privacy: [
        ['Information we collect', 'When you submit an enquiry through this website, we collect the details you provide — name, company, email address, phone number, country and your message — along with your IP address for abuse prevention.'],
        ['How we use it', 'We use this information solely to respond to your enquiry, discuss potential business, and comply with legal obligations. We do not sell, rent or share your personal data with third parties for marketing.'],
        ['Email & contact data', 'Contact details published on this site are for genuine business enquiries. We may limit, filter or protect published addresses to reduce spam, while keeping them accessible to real partners.'],
        ['Data retention', 'Enquiry records are retained as long as needed to serve the enquiry and maintain business records. You may request deletion of your enquiry data by emailing us.'],
        ['Cookies & analytics', 'Where analytics are enabled, we use them to understand aggregate site usage and improve the site — not to identify individuals.'],
        ['Contact', 'For privacy questions, write to info@nymakpharma.com or use our contact page.'],
    ],
    terms: [
        ['About this website', 'This website is operated by Nymak Pharma Private Limited, Mundra (Kutch), Gujarat, India. It provides information about our company, products and export services for business visitors.'],
        ['Product information', 'Product listings describe our manufacturing and export portfolio for business-to-business evaluation. They are not medical advice, prescribing information or an offer to sell to consumers. Product availability and registration vary by market.'],
        ['Intellectual property', 'All content, brand names, logos and imagery on this site are the property of Nymak Pharma or its partners and may not be reproduced without written permission.'],
        ['Accuracy', 'We work to keep information accurate and current, but make no warranty that content is error-free. Specifications and packaging may vary by market registration.'],
        ['Liability', 'Nymak Pharma is not liable for decisions made in reliance on website content. Business terms are governed by individual contracts, not this website.'],
        ['Governing law', 'These terms are governed by the laws of India. Disputes are subject to the jurisdiction of courts in Gujarat, India.'],
    ],
};

export default function Legal({ seo, heading, kind }) {
    return (
        <SiteLayout>
            <PageHero title={heading} breadcrumbs={[['Home', '/'], [heading]]} />
            <section className="py-14">
                <Container className="max-w-3xl">
                    <div className="prose-nymak space-y-8">
                        {content[kind].map(([title, text]) => (
                            <section key={title}>
                                <h2 className="!mt-0">{title}</h2>
                                <p>{text}</p>
                            </section>
                        ))}
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
