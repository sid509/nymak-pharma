import Markdown from '../../Components/Markdown';
import { PostCard } from '../../Components/Cards';
import { Breadcrumbs, ButtonLink, Container } from '../../Components/Ui';
import SiteLayout from '../../Layouts/SiteLayout';

export default function BlogShow({ seo, post, related }) {
    const date = new Date(post.published_at).toLocaleDateString('en-GB', {
        day: 'numeric', month: 'long', year: 'numeric',
    });

    return (
        <SiteLayout>
            <article className="py-14 sm:py-20">
                <Container>
                    <div className="mx-auto max-w-3xl">
                        <Breadcrumbs items={[['Home', '/'], ['Blog', '/blog'], [post.title]]} />
                        <p className="text-xs font-semibold uppercase tracking-[0.04em] text-brand-700">{post.category}</p>
                        <h1 className="mt-3 t-page text-ink-950">
                            {post.title}
                        </h1>
                        <p className="mt-3 text-sm font-semibold text-ink-500">
                            <time dateTime={post.published_at}>{date}</time> · Nymak Pharma
                        </p>

                        {post.excerpt && (
                            <p className="mt-6 border-l-4 border-brand-500 pl-5 text-lg leading-relaxed text-ink-700">
                                {post.excerpt}
                            </p>
                        )}

                        <div className="mt-10">
                            <Markdown body={post.body} />
                        </div>

                        <div className="mt-12 rounded-2xl bg-gradient-to-br from-brand-700 to-brand-900 p-7 text-white">
                            <h2 className="t-h4">Work with a WHO-GMP certified manufacturer</h2>
                            <p className="mt-2 text-sm text-brand-100">
                                Product enquiries, distribution and partnership — talk to our exports team.
                            </p>
                            <ButtonLink href="/contact" variant="light" className="mt-4">Contact us</ButtonLink>
                        </div>
                    </div>
                </Container>
            </article>

            {related?.length > 0 && (
                <section className="border-t border-ink-100 bg-ink-50/50 py-14">
                    <Container>
                        <h2 className="t-h3 text-ink-900">More from the journal</h2>
                        <div className="mt-6 grid gap-5 md:grid-cols-3">
                            {related.map((p) => <PostCard key={p.slug} post={p} />)}
                        </div>
                    </Container>
                </section>
            )}
        </SiteLayout>
    );
}
