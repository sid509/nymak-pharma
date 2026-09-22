import { ClipboardCheck, FileCheck2, FlaskConical, Microscope, Package, Warehouse } from 'lucide-react';
import { ButtonLink, Container, PageHero, SectionHeading } from '../Components/Ui';
import SiteLayout from '../Layouts/SiteLayout';

const capabilities = [
    {
        icon: FlaskConical,
        title: 'In-house QC laboratory',
        text: 'A dedicated quality control laboratory analyses batch lots before release — partners reviewing the facility consistently note well-controlled processes and modern storage.',
    },
    {
        icon: ClipboardCheck,
        title: 'Quality assurance oversight',
        text: 'A separate QA function reviews and approves every batch before it leaves the facility, ensuring each consignment matches specification and documentation.',
    },
    {
        icon: FileCheck2,
        title: 'Regulatory & dossier support',
        text: 'An in-house regulatory team prepares and manages product dossiers, supporting registration requirements in destination markets across Africa, Central America and the Pacific.',
    },
    {
        icon: Package,
        title: 'Design & packaging',
        text: 'An in-house design team produces compliant, market-ready packaging and labelling — including the branded ranges supplied to West African markets.',
    },
    {
        icon: Warehouse,
        title: 'Warehousing & logistics',
        text: 'Committed warehouse infrastructure with controlled storage, managed by a dedicated logistics head — over 200 containers shipped in FY 2023–24.',
    },
    {
        icon: Microscope,
        title: 'Continuous up-gradation',
        text: 'The facility operates with a documented focus on innovation and up-gradation of existing facilities, verified through client inspections and audits.',
    },
];

const dosageForms = [
    ['IV fluids & infusions', 'Large-volume parenterals — saline, dextrose, Ringer lactate, multi-electrolyte, therapeutic infusions (100 ml–1000 ml).'],
    ['Tablets & capsules', 'Including dispersible, sublingual, sustained-release and combination presentations.'],
    ['Oral liquids', 'Syrups, suspensions and drops — paediatric and adult formulations.'],
    ['Injections', 'Ampoules and vials — liquid and dry powder for reconstitution.'],
    ['Medical devices', 'IV access, infusion sets, syringes, needles and patient-care consumables.'],
    ['Diagnostics & antisera', 'Rapid test kits, snake venom antiserum and tetanus antitoxin.'],
];

export default function Manufacturing({ seo }) {
    return (
        <SiteLayout>
            <PageHero eyebrow="Manufacturing" breadcrumbs={[['Home', '/'], ['Manufacturing']]}
                title="A WHO-GMP facility built for export"
                lead="Nymak Pharma manufactures at Plot No. 22, Phase 3, Port Biz Industrial Park, Kandla-Mundra Highway, Mundra (Kutch), Gujarat — minutes from two of India's busiest export ports." />

            {/* Facility overview */}
            <section className="py-16 sm:py-20">
                <Container className="grid items-start gap-10 lg:grid-cols-2">
                    <div className="prose-nymak">
                        <h2>Manufacturing at Mundra</h2>
                        <p>
                            Our head office and works sit within the Port Biz Industrial Park on the
                            Kandla–Mundra highway in Gujarat — a location chosen deliberately for its direct
                            access to the ports of Mundra and Kandla, the gateways through which over 200
                            containers of Nymak products shipped in FY 2023–24.
                        </p>
                        <p>
                            The facility operates under WHO-GMP certification with ISO 13485:2016 quality
                            management systems. Production is supported by a structure that keeps the critical
                            functions in-house: a quality control laboratory, a quality assurance team, a
                            regulatory affairs team handling dossiers and registrations, a design team for
                            market-compliant packaging, and a logistics function managing warehousing and dispatch.
                        </p>
                        <p>
                            Client inspections tell the story better than we can — partners visiting the plant
                            describe modern machinery and storage, processes well controlled to GMP requirement,
                            and a quality-conscious, supportive management.
                        </p>
                    </div>
                    <div className="lg:sticky lg:top-28">
                        <img src="/images/hero/facility-aerial.webp" alt="Nymak Pharma manufacturing facility, Port Biz Industrial Park, Mundra"
                             width="960" height="640" loading="lazy"
                             className="w-full rounded-3xl object-cover shadow-card" />
                        <div className="mt-4 grid grid-cols-2 gap-3">
                            <div className="rounded-xl bg-brand-50 p-4">
                                <p className="text-2xl font-extrabold text-brand-800">WHO-GMP</p>
                                <p className="text-xs font-semibold text-ink-600">Certified facility</p>
                            </div>
                            <div className="rounded-xl bg-brand-50 p-4">
                                <p className="text-2xl font-extrabold text-brand-800">ISO 13485</p>
                                <p className="text-xs font-semibold text-ink-600">Quality management</p>
                            </div>
                        </div>
                    </div>
                </Container>
            </section>

            {/* Capabilities grid */}
            <section className="bg-ink-50 py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow="Capability" title="What runs inside the facility" align="center"
                        lead="Quality, regulatory, design and logistics under one roof — so partners deal with one accountable team." />
                    <div className="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        {capabilities.map((c) => (
                            <div key={c.title} className="rounded-2xl border border-ink-100 bg-white p-6 shadow-card">
                                <span className="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                                    <c.icon size={20} aria-hidden />
                                </span>
                                <h3 className="mt-4 text-base font-bold text-ink-900">{c.title}</h3>
                                <p className="mt-2 text-sm leading-relaxed text-ink-600">{c.text}</p>
                            </div>
                        ))}
                    </div>
                </Container>
            </section>

            {/* Dosage forms */}
            <section className="py-16 sm:py-20">
                <Container>
                    <SectionHeading eyebrow="What we make" title="Dosage forms & product lines" />
                    <div className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {dosageForms.map(([title, text]) => (
                            <div key={title} className="rounded-xl border-l-4 border-brand-500 bg-ink-50/60 p-5">
                                <h3 className="text-sm font-bold text-ink-900">{title}</h3>
                                <p className="mt-1.5 text-sm leading-relaxed text-ink-600">{text}</p>
                            </div>
                        ))}
                    </div>
                    <div className="mt-12 flex flex-wrap gap-3">
                        <ButtonLink href="/products">Browse the product catalogue</ButtonLink>
                        <ButtonLink href="/quality-certifications" variant="outline">Quality & certifications</ButtonLink>
                    </div>
                </Container>
            </section>
        </SiteLayout>
    );
}
