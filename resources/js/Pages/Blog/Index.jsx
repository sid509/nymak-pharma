import { Link } from '@inertiajs/react';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { PostCard } from '../../Components/Cards';
import { Container, PageHero } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

export default function BlogIndex({ seo, posts, content }) {
    return (
        <SiteLayout>
            <PageHero eyebrow={content.hero_eyebrow} breadcrumbs={[['Home', '/'], ['Blog']]}
                title={content.hero_title}
                lead={content.hero_lead} />

            <section className="py-14 sm:py-20">
                <Container>
                    {posts.data.length === 0 ? (
                        <div className="rounded-2xl border border-dashed border-ink-200 bg-ink-50/50 p-12 text-center">
                            <p className="font-semibold text-ink-700">Articles are on their way.</p>
                            <p className="mt-1 text-sm text-ink-500">Check back soon for company news and product insights.</p>
                        </div>
                    ) : (
                        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            {posts.data.map((p) => <PostCard key={p.slug} post={p} />)}
                        </div>
                    )}

                    {/* Pagination — crawlable links (requirement: SEO-friendly pagination) */}
                    {posts.last_page > 1 && (
                        <nav aria-label="Pagination" className="mt-12 flex items-center justify-center gap-2">
                            {posts.links.map((l, i) => {
                                const label = l.label.includes('Previous') ? <ChevronLeft size={16} /> :
                                    l.label.includes('Next') ? <ChevronRight size={16} /> : l.label;
                                return l.url ? (
                                    <Link key={i} href={l.url} aria-current={l.active ? 'page' : undefined}
                                          className={`flex h-10 min-w-10 items-center justify-center rounded-lg px-3 text-sm font-bold ${
                                              l.active ? 'bg-brand-700 text-white' : 'border border-ink-200 text-ink-700 hover:border-brand-400'
                                          }`}>
                                        {label}
                                    </Link>
                                ) : (
                                    <span key={i} className="flex h-10 min-w-10 items-center justify-center px-3 text-sm text-ink-300">{label}</span>
                                );
                            })}
                        </nav>
                    )}
                </Container>
            </section>
        </SiteLayout>
    );
}
