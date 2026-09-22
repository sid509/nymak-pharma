<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Company facts (identity, NAP, socials, stats, offices) — stored overrides
 * merged over config/nymak.php defaults via SiteSetting::merged().
 */
class SiteSettingsController extends Controller
{
    public function edit(): Response
    {
        $merged = SiteSetting::merged();

        return Inertia::render('Admin/Settings/Form', [
            // input names are underscored (address_street) — JSON posts don't
            // parse bracket syntax; mapped back to dotted keys on save.
            'fields' => collect(SiteSetting::FIELDS)->map(fn ($f, $key) => [
                'name' => str_replace('.', '_', $key),
                'label' => $f[0], 'type' => $f[1] === 'json' ? 'textarea' : $f[1],
                'help' => $f[2] ?? null, 'rows' => $f[1] === 'json' ? 10 : null,
                'value' => $f[1] === 'json'
                    ? json_encode(Arr::get($merged, $key), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
                    : Arr::get($merged, $key),
            ])->values(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];
        foreach (SiteSetting::FIELDS as $key => [$label, $type]) {
            $rules[str_replace('.', '_', $key)] = match ($type) {
                'email' => ['nullable', 'email', 'max:200'],
                'json' => ['nullable', 'json', 'max:20000'],
                'textarea' => ['nullable', 'string', 'max:2000'],
                default => ['nullable', 'string', 'max:300'],
            };
        }
        $data = $request->validate($rules);

        foreach (SiteSetting::FIELDS as $key => $f) {
            $value = $data[str_replace('.', '_', $key)] ?? null;
            if ($value === null || $value === '') {
                SiteSetting::where('key', $key)->delete();
            } else {
                SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return back()->with('success', 'Site settings saved.');
    }
}
