<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageMeta;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Per-page SEO overrides for static/list pages (page_metas keyed by page id).
 * Schema markup stays auto-derived — admins edit titles, descriptions and OG
 * images, which the schema builder consumes; JSON-LD is never hand-edited.
 */
class SeoPageController extends Controller
{
    public function index(): Response
    {
        // Ensure a row exists for every known page key.
        foreach (PageMeta::PAGES as $key => $label) {
            PageMeta::firstOrCreate(['key' => $key]);
        }

        return Inertia::render('Admin/Seo/Index', [
            'pages' => PageMeta::whereIn('key', array_keys(PageMeta::PAGES))
                ->orderBy('key')->get()
                ->map(fn ($m) => [
                    'id' => $m->id,
                    'key' => $m->key,
                    'label' => PageMeta::PAGES[$m->key] ?? $m->key,
                    'meta_title' => $m->meta_title,
                    'meta_description' => $m->meta_description,
                    'og_image' => $m->og_image,
                    'customized' => (bool) ($m->meta_title || $m->meta_description || $m->og_image),
                ]),
        ]);
    }

    public function edit(PageMeta $seoPage): Response
    {
        return Inertia::render('Admin/Seo/Form', [
            'page' => [
                'id' => $seoPage->id,
                'key' => $seoPage->key,
                'label' => PageMeta::PAGES[$seoPage->key] ?? $seoPage->key,
                'meta_title' => $seoPage->meta_title,
                'meta_description' => $seoPage->meta_description,
                'og_image' => $seoPage->og_image,
            ],
        ]);
    }

    public function update(Request $request, PageMeta $seoPage): RedirectResponse
    {
        $data = $request->validate([
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($file = $request->file('og_image')) {
            ImageUpload::delete($seoPage->og_image);
            $data['og_image'] = ImageUpload::store($file, 'og', $seoPage->key);
        } else {
            unset($data['og_image']);
        }

        $seoPage->update($data);

        return redirect()->route('admin.seo-pages.index')->with('success', 'SEO settings saved.');
    }
}
