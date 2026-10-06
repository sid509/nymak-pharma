<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use App\Support\Html;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Editable content slots for public pages. Each page declares its slots in
 * PageContent::SCHEMA (text/textarea/richtext/image/json/toggle); stored rows override the
 * defaults. PageContent::for() is what public controllers consume.
 */
class PageContentController extends Controller
{
    public function index(): Response
    {
        $counts = PageContent::selectRaw('page, count(*) as n')->groupBy('page')->pluck('n', 'page');

        return Inertia::render('Admin/Pages/Index', [
            'pages' => collect(PageContent::PAGE_LABELS)->map(fn ($label, $key) => [
                'key' => $key,
                'label' => $label,
                'fields' => count(PageContent::SCHEMA[$key]),
                'customized' => $counts->get($key, 0),
            ])->values(),
        ]);
    }

    public function edit(string $page): Response
    {
        abort_unless(isset(PageContent::SCHEMA[$page]), 404);

        return Inertia::render('Admin/Pages/Form', [
            'page' => ['key' => $page, 'label' => PageContent::PAGE_LABELS[$page]],
            'fields' => PageContent::fieldsFor($page),
            'values' => PageContent::for($page), // resolved: overrides + defaults
            'stored' => PageContent::where('page', $page)->pluck('value', 'key'),
        ]);
    }

    public function update(Request $request, string $page): RedirectResponse
    {
        abort_unless(isset(PageContent::SCHEMA[$page]), 404);

        $rules = [];
        foreach (PageContent::SCHEMA[$page] as [$key, , $type]) {
            $rules[$key] = match ($type) {
                'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
                'json' => ['nullable', 'json', 'max:20000'],
                'textarea' => ['nullable', 'string', 'max:5000'],
                'richtext' => ['nullable', 'string', 'max:100000'],
                'toggle' => ['nullable', 'in:0,1,true,false'],
                default => ['nullable', 'string', 'max:500'],
            };
        }
        $data = $request->validate($rules);

        foreach (PageContent::SCHEMA[$page] as [$key, , $type]) {
            if ($type === 'image') {
                if ($file = $request->file($key)) {
                    $old = PageContent::where('page', $page)->where('key', $key)->value('value');
                    ImageUpload::delete($old);
                    PageContent::updateOrCreate(['page' => $page, 'key' => $key],
                        ['value' => ImageUpload::store($file, 'pages', "{$page}-{$key}")]);
                }
                continue; // no upload → existing image/default stays
            }

            $value = $data[$key] ?? null;
            if ($type === 'toggle') {
                // Always persisted — '0' is a real choice, not "use default".
                $value = in_array($value, ['1', 'true', true, 1], true) ? '1' : '0';
            } elseif ($type === 'richtext') {
                $value = Html::sanitize($value);
            }
            if ($value === null || $value === '') {
                PageContent::where('page', $page)->where('key', $key)->delete();
            } else {
                PageContent::updateOrCreate(['page' => $page, 'key' => $key], ['value' => $value]);
            }
        }

        return redirect()->route('admin.pages.edit', $page)->with('success', 'Page content saved.');
    }
}
